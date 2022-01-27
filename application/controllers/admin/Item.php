<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Item extends CI_Controller{

    public $module_title = 'Items';
    public $module_url = 'admin/item';
    public $module_url_list = 'admin/item';
    public $module_url_create = 'admin/item/create';
    public $module_url_edit = 'admin/item/edit';
    public $module_url_delete = 'admin/item/delete';

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

    //http://localhost/droidapps/admin/item
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
        $this->load->view($this->module_url.'/list', $data);
    }

    //This will show create page
    public function create(){
        $this->load->view($this->module_url.'/create');
    }

    //This will show edit page
    public function edit($jsonData = null){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';

        $whereClause = getDataWhereClause($pkg_id, null, $jsonData);
        $item = $this->database_model->get_content_data($whereClause);
        if($item != null && count($item) == 1){
            $data['item'] = $item[0];
            // print_r($item);die;
            $this->load->view($this->module_url.'/edit', $data);
        }else {
            $this->session->set_flashdata('error', 'Item not found');
            redirect(base_url().$this->module_url);
        }
    }

    //This will show delete page
    public function delete($jsonData = null){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $whereClause = getDataWhereClause($pkg_id, null, $jsonData);

        $itemArray = $this->database_model->get_content_data($whereClause);
        if($itemArray != null && count($itemArray) == 1){
            $item = $itemArray[0];
            if($this->database_model->delete_content($whereClause)){
                $this->session->set_flashdata('success', 'Item has been deleted');
            }else{
                $this->session->set_flashdata('error', 'Failed to delete Item');
            }
        }else {
            $this->session->set_flashdata('error', 'Item not found');
        }
        redirect(base_url().$this->module_url);
    }
}

?>
