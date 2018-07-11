<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once APPPATH.'modules/memberspace/models/User.php';

class Pheduser extends User
{

    const TABLE_NAME = 'users_phed';

    public function getTableName()
    {
        return self::TABLE_NAME;
    }
    
    protected function afterInsert($insert_id, &$to_insert = null)
    {
        parent::afterInsert($insert_id, $to_insert);
        $this->load->model('phedtoken');
        
        $token = $this->phedtoken->generate($to_insert['id']);
        
        $this->load->model('memberspace/right');
        $this->right->allowUserTo($insert_id, 'add', 'file');
        $this->right->allowUserTo($insert_id, '*', 'model[file]::isOwnedBy({object},{user})');
    }

    public function get($where = null, $type = 'object', $columns = null)
    {
        $this->load->model('phedtoken');
        $tokenTable = $this->phedtoken->getTableName();
        $this->join($tokenTable, $this->getTableName().'.id = '.$tokenTable.'.user_id', 'left');
        $this->select($tokenTable.'.token');
        return parent::get($where, $type, $columns);
    }
}
