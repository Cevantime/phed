<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'modules/filebrowser/controllers/Index.php';

class FileBrowser extends Index
{

    public function __construct()
    {
        $this->load->library('session');
        $this->load->model('phedtoken');
        if (!($this->session->userdata('user_id'))) {
            $this->destroySession = true;
            $phedtoken = $this->phedtoken->checkToken($this->input->get_post('access_token'));
            if ($phedtoken) {
                $this->session->set_userdata('user_id', $phedtoken->user_id);
            }
        }

        if (!is_connected()) {
            redirect("/");
        }

        parent::__construct();

//        if (isset($_SERVER['HTTP_ORIGIN'])) {
//            $origin = $_SERVER['HTTP_ORIGIN'];
//            $userDomain = $this->user->domain;
//            if(str_replace(array('http://', 'https://'), '', $userDomain) === str_replace(array('http://', 'https://'), '', $origin)){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
//            }
//        }
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
        $this->layout->title('PHED');
        $this->output->enable_profiler(false);
    }

    public function save($id = null, $redirect = null)
    {
        $post = $this->input->post();
        if (!isset($post['parent_id']) && isset($post['parent_folder'])) {
            $folder = $this->{$this->modelName}->createFolderFromFullpath($post['parent_folder']);
            $_POST['parent_id'] = $folder->id;
        }
        if (!isset($post['user_id'])) {
            $_POST['user_id'] = user_id();
        }
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
            var_dump($errors);
            die();
            return $post;
        }

        $modelInst = $this->{$this->modelName};
        $datas = $modelInst->getLastSavedDatas();

        if ($redirect) {
            $lastRow = $datas;
            $regex = '/\{row:(.+?)\}/';
            if (preg_match_all($regex, $redirect, $matches)) {
                for ($j = 0; $j < count($matches[0]); $j++) {
                    $redirect = str_replace($matches[0][$j], $lastRow[$matches[1][$j]], $redirect);
                }
            }
        }


        $parentId = isset($datas['parent_id']) && $datas['parent_id'] ? $datas['parent_id'] : null;
        $files = $this->{$this->modelName}->getGrouped(array('parent_id' => $parentId), $this->filters);
        $file = $modelInst->getId($datas['id']);
        $html = $this->load->view('filebrowser/includes/_file_row', array('file' => $file), true);

        $rep = array(
            'status' => 'success',
            'data' => $datas
        );
        if ($this->input->is_ajax_request()) {
            $rep['files'] = $files;
            $rep['html'] = $html;
            $rep['infos']['infos'] = json_decode($rep['data']['infos']);
        } else if (!$datas['is_folder']) {
            unset($rep['data']['infos']);
            $rep['data']['url'] = base_url($datas['file']);
        }
        die(json_encode($rep));
    }

    public function delete($fileId)
    {
        if (user_can('delete', 'file', $fileId)) {
            $file = $this->{$this->modelName}->getId($fileId);
            if (!$file) {
                die(json_encode(
                        array(
                            'status' => 'error',
                            'message' => translate('le fichier à supprimer n\'existe pas')
                        )
                    )
                );
            }
            $parent_id = $file->parent_id;
            $this->{$this->modelName}->deleteFile($file);

            die(json_encode(
                    array(
                        'status' => 'success',
                        'message' => translate('le fichier a bien été supprimé')
                    )
                )
            );
        } else {
            die(translate('Vous ne pouvez pas effectuer cette action'));
        }
    }

    public function disconnect()
    {
        $this->load->library('memberspace/loginManager');
        $this->loginmanager->disconnect();
    }

}
