<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Home extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $admin = $this->session->userdata('admin');
        $this->load->helper("common_helper");
        if(empty($admin)){
          $this->session->set_flashdata('msg','Your session has been expired!');
            redirect(base_url().'admin/login/index');
        }
    }

    //http://localhost/droidappsmaster/admin/home
    public function index() {
        $this->load->view('admin/dashboard');
    }

}

?>
