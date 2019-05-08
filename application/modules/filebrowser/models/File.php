<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class File extends DATA_Model
{

    const TABLE_NAME = 'files';

    public $infos = array();
    protected $_owned = array();

    public function getInfos($filename)
    {
        return $this->infos[$filename];
    }

    public function getTableName()
    {
        return self::TABLE_NAME;
    }

    public function validationRulesForInsert($datas)
    {
        $m = $this;
        $rules = array(
            'is_folder' => array(
                'field' => 'is_folder',
                'label' => translate('Est un répertoire'),
                'rules' => 'required|in_list[0,1]'
            ),
            'parend_id' => array(
                'field' => 'parent_id',
                'label' => translate('Dossier parent'),
                'rules' => array(
                    array('is_natural_or_empty', function($v) {
                            $this->load->library('form_validation');
                            return $this->form_validation->is_natural($v) || $v === '';
                        })
                )
            )
        );
        if (isset($datas['is_folder']) && $datas['is_folder']) {

            $rules['name'] = array(
                'field' => 'name',
                'label' => translate('Nom de fichier'),
                'rules' => array(
                    'required',
                    'regex_match[/^([a-zA-ZÀ-ÿ\-_ 0-9\.]+)$/]',
                    array('is_parent_uniq', function($name) use ($datas) {
                            $userId = isset($datas['user_id']) ? $datas['user_id'] : user_id();
                            if (!isset($datas['parent_id']))
                                return true;
                            $parentId = $datas['parent_id'];
                            if (!$parentId) {
                                $parentId = null;
                            }
                            return $this->isParentUniq($name, $parentId, $userId);
                        }
                    ))
            );
        } else {
            $rules['file'] = array(
                'field' => 'file',
                'label' => translate('Fichier'),
                'rules' => 'file_required|file_allowed_type[image,image_icon,application,document,compress,mp4]'
            );
        }
        return $rules;
    }

    public function validationRulesForUpdate($datas)
    {
        $model = $this;
        $rules['id'] = array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => array(
                'required',
                'is_natural',
                array('exists', array($model, 'exists'))
            )
        );
        $rules['name'] = array(
            'field' => 'name',
            'label' => translate('Nom de fichier'),
            'rules' => array(
                'regex_match[/^([a-zA-ZÀ-ÿ\-_ 0-9\.]+)$/]',
                array('is_parent_uniq', function($name) use ($datas) {
                        $userId = isset($datas['user_id']) ? $datas['user_id'] : user_id();
                        $parentId = isset($datas['parent_id']) ? $datas['parent_id'] : null;
                        if (!isset($datas['parent_id']))
                            return $parentId = null;

                        else {
                            $parentId = $datas['parent_id'];
                        }

                        if (!$parentId) {
                            $parentId = null;
                        }
                        return $this->isParentUniq($name, $parentId, $userId);
                    }
                ))
        );

        $rules['parent_id'] = array(
            'field' => 'parent_id',
            'label' => translate('Dossier parent'),
            'rules' => array(
                array('is_natural_or_empty', function($v) {
                        $this->load->library('form_validation');
                        return $this->form_validation->is_natural($v) || $v === '';
                    }),
                array('is_not_self_containing', function($v) use($datas) {
                        if ($v === $datas['id']) {
                            return false;
                        }
                        $parent = $this->getId($v);
                        if (!$parent)
                            return true;
                        $hierarchy = explode('/', $parent->hierarchy);
                        if (in_array($datas['id'], $hierarchy)) {
                            return false;
                        }

                        return true;
                    })
            )
        );
        return $rules;
    }

    public function isParentUniq($name, $parentId, $userId = null)
    {
        if (!$userId) {
            $userId = user_id();
        }
        if (!$parentId)
            $parentId = null;
        return $this->get(array('user_id' => $userId, 'name' => $name, 'parent_id' => $parentId)) == FALSE;
    }

    public function fromDatas($datas = null)
    {
        $this->infos = array();
        return parent::fromDatas($datas);
    }

    protected function doUpload(&$datas, $uploadPath, $key)
    {
        if (isset($datas['id']) && $datas['id']) {
            return true;
        }
        if (isset($_FILES[$key])) {
            if (!file_exists('./' . $uploadPath)) {
                mkdir('./' . $uploadPath);
            }
            $this->upload->initialize(array('upload_path' => './' . $uploadPath, 'allowed_types' => '*', 'file_name' => uniqid()));
            if ($this->upload->do_upload($key)) {
                $this->infos[$key] = $this->upload->data();
                $this->infos[$key]['original_name'] = $_FILES[$key]['name'];
                if ($datas) {
                    $datas[$key] = $uploadPath . '/' . $this->upload->file_name;
                } else {
                    $_POST[$key] = $uploadPath . '/' . $this->upload->file_name;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    protected function beforeInsert(&$to_insert = null)
    {
        if (array_key_exists('parent_id', $to_insert) && !$to_insert['parent_id'])
            $to_insert['parent_id'] = null;

        if (array_key_exists('parent_id', $to_insert)) {
            $parent = $this->getId($to_insert['parent_id']);
        } else {
            $parent = null;
        }
        $to_insert['hierarchy'] = $parent ? $parent->hierarchy . '/' . $parent->id : '';
        if (!isset($to_insert['is_folder']) || !$to_insert['is_folder']) {
            $to_insert['infos'] = $this->infos['file'];
            $to_insert['name'] = $this->infos['file']['original_name'];
            $to_insert['type'] = $this->infos['file']['file_type'];
        } else {
            $to_insert['file'] = null;
            $to_insert['infos'] = null;
        }

        $to_insert['fullpath'] = $parent ? $parent->fullpath . '/' . $to_insert['name'] : '/' . $to_insert['name'];

        parent::beforeInsert($to_insert);
    }

    protected function beforeUpdate(&$data = null, $where = null)
    {
        if (array_key_exists('parent_id', $data) && !$data['parent_id']) {
            $data['parent_id'] = null;
        }

        if (array_key_exists('parent_id', $data)) {
            $parent = $this->getId($data['parent_id']);
        } else {
            $parent = null;
        }
        unset($data['is_folder']);
        unset($data['infos']);
        unset($data['file']);
        if (array_key_exists('parent_id', $data)) {
            $parent = $this->getId($data['parent_id']);
            $data['hierarchy'] = $parent ? $parent->hierarchy . '/' . $parent->id : '';
            if(! isset($data['name']) ) {
                $row = $this->getRow(['id' => $data['id']]);
                $data['name'] = $row->name;
            }
            $data['fullpath'] = $parent ? $parent->fullpath . '/' . $data['name'] : '/' . $data['name'];
        }
        parent::beforeUpdate($data, $where);
    }

    public function getGrouped($where = null, $filters = null, $type = 'object', $columns = null)
    {
        $this->db->order_by('is_folder DESC, name ASC');
        if ($filters && !in_array('all', $filters)) {
            $this->db->group_start()
                ->where_in('type', $filters)
                ->or_where('type', null)
                ->group_end();
        }
        if ($where) {
            $this->db->where($where);
        }
        return parent::get(NULL, $type, $columns);
    }

    public function getOwnedBy($userId, $refresh = false)
    {
        if (!isset($this->_owned[$userId]) || $refresh) {
            $this->_owned[$userId] = $this->get(array('user_id' => $userId));
        }
        return $this->_owned[$userId];
    }

    public function isOwnedBy($file, $user)
    {
        if (is_object($file)) {
            return $file->user_id == $user->id;
        }
        if (is_array($file)) {
            return $file['user_id'] == $user->id;
        }
        $owned = $this->getOwnedBy($user->id);
        if (!$owned)
            return false;
        foreach ($owned as $own) {
            if ($own->id == $file) {
                return true;
            }
        }

        return false;
    }

    public function uploadPaths()
    {
        return array('file' => 'uploads/filebrowser');
    }

    public function deleteFile($file)
    {
        $children = $this->get(array('parent_id' => $file->id));
        if ($children) {
            foreach ($children as $child) {
                $this->deleteFile($child);
            }
        }
        if ($this->deleteId($file->id) && $file->file) {
            unlink($file->file);
        }
    }

    public function createFolderFromFullpath($fullpath, $userId = null)
    {
        if (!$userId) {
            $userId = user_id();
        }
        $fullpath = ltrim($fullpath, '/');
        $segments = explode('/', $fullpath);
        
        $path = '';
        
        $parent = (object)array(
            'id' => '',
            'name' => '',
            'hierarchy' => '',
            'fullpath' => $path,
            'parent_id' => null
        );
        
        foreach ($segments as $segment) {
            $path .= '/' . $segment;
            $folder = $this->getByFullpath($path);
            if (!$folder) {
                $folderData = [
                    'name' => $segment,
                    'is_folder' => 1,
                    'hierarchy' => $parent->hierarchy . '/' . $parent->id,
                    'fullpath' => $path,
                    'parent_id' => $parent->id,
                    'user_id' => $userId
                ];
                $folder = (object)$folderData;
                $folder->id = $this->insert($folderData);
            }
            $parent = $folder;
        }
        
        return $parent;
    }

    public function getByFullpath($path)
    {
        return $this->getRow(['fullpath' => $path]);
    }

}
