<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Home extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $admin = $this->session->userdata('admin');
        $this->load->model(array(version_prefix."database_model"));
        $this->load->helper("common_helper");
        if(empty($admin)){
          $this->session->set_flashdata('msg','Your session has been expired!');
            redirect(base_url().'admin/login/index');
        }
    }

    //http://localhost/droidapps/admin/home
    public function index() {
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;

        $whereClause = getDataWhereClause($pkg_id, null, null);

        $categories = $this->database_model->get_category($whereClause);
        $contents = $this->database_model->get_content($whereClause);
        $data['categories'] = $categories;
        $data['contents'] = $contents;
        $data['mainModule'] = 'dashboard';

        $this->load->view('admin/dashboard', $data);
    }

}

?>
