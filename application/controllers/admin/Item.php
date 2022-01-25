<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Item extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $admin = $this->session->userdata('admin');
        if(empty($admin)){
          $this->session->set_flashdata('msg','Your session has been expired!');
            redirect(base_url().'admin/login/index');
        }
        $this->load->model(array(version_prefix."database_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("common_helper");
    }

    //http://localhost/droidappsmaster/admin/item
    //This will show item list page
    public function index(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $queryString = $this->input->get();
        $querySearch = '';
        if($queryString != null){
            $querySearch = $queryString['json_data'];
        }
        $whereClause = getDataWhereClause($pkg_id, null, null);

        $items = $this->database_model->get_content_data($whereClause, $queryString);
        $data['items'] = $items;
        $data['querySearch'] = $querySearch;
        $this->load->view('admin/item/list', $data);
    }

    //This will show create page
    public function create(){
        $this->load->view('admin/item/create');
    }

    //This will show edit page
    public function edit($jsonData){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';

        $whereClause = getDataWhereClause($pkg_id, null, $jsonData);
        $item = $this->database_model->get_content_data($whereClause);
        // print_r($item);die;
        if($item != null && count($item) == 1){
            $data['item'] = $item[0];
            $this->load->view('admin/item/edit', $data);
        }else {
            $this->session->set_flashdata('error', 'Item not found');
            redirect(base_url().'admin/item');
        }
    }

    //This will show delete page
    public function delete($jsonData){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $whereClause = getDataWhereClause($pkg_id, null, $jsonData);

        $itemArray = $this->database_model->get_content_data($whereClause);
        if($itemArray != null && count($itemArray) == 1){
            $item = $itemArray[0];
            if($this->database_model->delete_data($whereClause)){
                $this->session->set_flashdata('success', 'Item has been deleted');
            }else{
                $this->session->set_flashdata('error', 'Failed to delete Item');
            }
        }else {
            $this->session->set_flashdata('error', 'Item not found');
        }
        redirect(base_url().'admin/item');
    }
}

?>
