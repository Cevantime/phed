<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'modules/filebrowser/third_party/FILEBROWSER_Controller.php';

class Index extends FILEBROWSER_Controller
{

    protected $filters;
    protected $model, $modelName;

    public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('filebrowser/layout/filebrowser');
        $this->filters = $this->input->get('filters') ? explode(',', $this->input->get('filters')) : ['all'];

        $this->model = $this->input->get('model') ?: 'filebrowser/file';
        $this->modelName = pathinfo($this->model)['filename'];
        $this->load->model($this->model);
//		$this->output->enable_profiler(true);
    }

    public function home()
    {
        $this->load->helper('memberspace/connection');
        $folder = $this->input->get_post('folder');
        if (user_can('see', 'file', '*')) {
            $this->layout->view('filebrowser/index', array('folder' => $folder));
        } else {
            die(translate('vous ne pouvez pas accéder à cette ressource.'));
        }
    }

    public function index()
    {
        $this->home();
    }

    public function see($idFile = null)
    {
        if (user_can('see', 'file', $idFile)) {
            $file = null;
            if ($idFile) {
                if ($idFile !== null && !is_int($idFile) && !ctype_digit($idFile)) {
                    $userId = user_id();
                    $file = $this->{$this->modelName}->getRow(['fullpath' => $idFile, 'user_id' => $userId]);

                } else {
                    $file = $this->{$this->modelName}->getId($idFile);
                }
            }

            if (!$file || $file->is_folder) {
                $this->seeFolder($file);
            } else {
                $this->seeFile($file);
            }
        } else {
            die(translate('Vous ne pouvez pas accéder à cette ressource'));
        }
    }

    public function delete($fileId)
    {
        if (user_can('delete', 'file', $fileId)) {
            $file = $this->{$this->modelName}->getId($fileId);
            if (!$file) {
                if ($this->input->is_ajax_request()) {
                    die(json_encode(
                            array(
                                'status' => 'error',
                                'message' => translate('le fichier à supprimer n\'existe pas')
                            )
                        )
                    );
                } else {
                    redirect('filebrowser/index/index');
                }
            }
            $parent_id = $file->parent_id;
            $this->{$this->modelName}->deleteFile($file);
            if ($this->input->is_ajax_request()) {
                die(json_encode(
                        array(
                            'status' => 'success',
                            'message' => translate('le fichier a bien été supprimé')
                        )
                    )
                );
            } else {
                redirect('filebrowser/index/index/' . $parent_id);
            }
        } else {
            die(translate('Vous ne pouvez pas effectuer cette action'));
        }
    }

    private function seeFolder($folder = null)
    {
        $children = $this->{$this->modelName}->getGrouped(array('user_id' => user_id(), 'parent_id' => $folder ? $folder->id : null), $this->filters);
        $this->load->view('filebrowser/see-folder', array('files' => $children, 'folder' => $folder ));
    }

    public function seeFolderContent($folderId = null)
    {
        if( ! $folderId) {
            $folderId = null;
        }
        if (!user_can('see', 'file', $folderId)) {
            die(translate('Vous ne pouvez pas accéder à cette ressource'));
        }
        $children = $this->{$this->modelName}->getGrouped(array('user_id' => user_id(), 'parent_id' => $folderId), $this->filters);
        $this->load->view('filebrowser/includes/_folder', array('files' => $children));
    }

    private function seeFile($file)
    {
        $this->load->view('filebrowser/see-file', array('user_id' => user_id(), 'file' => $file));
    }

    public function add($redirect = null)
    {
        $pop = $this->save($redirect);
        $this->load->view('filebrowser/save', array('datas' => $pop));
    }

    public function update($idFile, $redirect = null)
    {
        $this->save($idFile, $redirect);
        $this->load->view('filebrowser/save', array('datas' => $pop));
    }

    public function save($id = null, $redirect = null)
    {

        $post = $this->input->post();

        if (!$id && !$post)
            return array();

        if ($id) {
            if (!user_can('update', 'file', $id)) {
                return array();
            }
            $file = $this->{$this->modelName}->get($id, 'array');
        } else {
            if (!user_can('add', 'file')) {
                return array();
            }
        }

        if (!$post)
            return $file;


        $success = $this->{$this->modelName}->fromPost();

        $this->load->helper('flashmessages/flashmessages');

        if (!$success) {
            $errors = $this->{$this->modelName}->getLastErrors();
            if ($this->input->is_ajax_request()) {
                $rep = array(
                    'status' => 'error',
                    'errors' => $errors
                );
                die(json_encode($rep));
            }
            foreach ($errors as $error) {
                add_error($error);
            }
            return $post;
        }

        $modelInst = $this->{$this->modelName};
        $datas = $modelInst->getLastSavedDatas();

        if ($redirect) {
            $lastRow = $datas->getLastSavedDatas();
            $regex = '/\{row:(.+?)\}/';
            if (preg_match_all($regex, $redirect, $matches)) {
                for ($j = 0; $j < count($matches[0]); $j++) {
                    $redirect = str_replace($matches[0][$j], $lastRow[$matches[1][$j]], $redirect);
                }
            }
        }

        if ($this->input->is_ajax_request()) {

            $parentId = isset($datas['parent_id']) && $datas['parent_id'] ? $datas['parent_id'] : null;
            $files = $this->{$this->modelName}->getGrouped(array('parent_id' => $parentId), $this->filters);
            $file = $modelInst->getId($datas['id']);
            $html = $this->load->view('filebrowser/includes/_file_row', array('file' => $file), true);
            $rep = array(
                'status' => 'success',
                'files' => $files,
                'datas' => $datas,
                'html' => $html
            );
            die(json_encode($rep));
        }

        return $datas;
    }

}
