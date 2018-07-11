<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller
{

    public function index()
    {
        if (is_connected()) {
            redirect('filebrowser/index');
        }
        $this->load->view('home');
    }

}
