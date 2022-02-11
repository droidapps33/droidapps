<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Json extends CI_Controller{

    public $module_title = 'Items';
    public $module_url = 'admin/json';
    public $module_url_list = 'admin/json';
    public $module_url_create = 'admin/json/create';
    public $module_url_edit = 'admin/json/edit';
    public $module_url_delete = 'admin/json/delete';

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

    //http://localhost/droidapps/admin/json
    //This will show item list page
    public function index(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $queryString = $this->input->get();
        $querySearch = '';
        if($queryString != null){
            $querySearch = $queryString['json_data'];
        }
        $whereClause = getDataWhereClause($pkg_id, null, null);

        $items = $this->database_model->get_json($whereClause, $queryString);
        $data['items'] = $items;
        $data['querySearch'] = $querySearch;
        $data['mainModule'] = 'item';
        $data['subModule'] = 'viewItem';
        $this->load->view($this->module_url.'/list', $data);
    }

    //This will show create page
    public function create(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
        $whereClause = getCategoryWhereClause($pkg_id, null, null);
        $categories = $this->database_model->get_category($whereClause);
        $data['categories'] = $categories;
        $data['mainModule'] = 'item';
        $data['subModule'] = 'createItem';
        $this->load->view($this->module_url.'/create', $data);
    }

    //This will show edit page
    public function edit($id = null){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';

        $whereClause = getDataWhereClause($pkg_id, null, $id);
        $item = $this->database_model->get_json($whereClause);

        $whereClause = getCategoryWhereClause($pkg_id, null, null);
        $categories = $this->database_model->get_category($whereClause);

        if($item != null && count($item) == 1){
            $data['item'] = $item[0];
            $data['categories'] = $categories;
            $data['mainModule'] = 'item';
            $data['subModule'] = '';
            // print_r($item);die;
            $this->load->view($this->module_url.'/edit', $data);
        }else {
            $this->session->set_flashdata('error', 'Json not found');
            redirect(base_url().$this->module_url);
        }
    }

    //This will show delete page
    public function delete($id = null){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $whereClause = getDataWhereClause($pkg_id, null, $id);

        $itemArray = $this->database_model->get_json($whereClause);
        if($itemArray != null && count($itemArray) == 1){
            $item = $itemArray[0];
            if($this->database_model->delete_json($whereClause)){
                $this->session->set_flashdata('success', 'Json has been deleted');
            }else{
                $this->session->set_flashdata('error', 'Failed to delete Json');
            }
        }else {
            $this->session->set_flashdata('error', 'Json not found');
        }
        redirect(base_url().$this->module_url);
    }
}

?>
