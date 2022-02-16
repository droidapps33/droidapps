<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Itemtype extends CI_Controller{

    public $module_title = 'Itemtypes';
    public $module_url = 'admin/itemtype';
    public $module_url_list = 'admin/itemtype';
    public $module_url_create = 'admin/itemtype/create';
    public $module_url_edit = 'admin/itemtype/edit';
    public $module_url_delete = 'admin/itemtype/delete';

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

    //http://localhost/droidapps/admin/itemtype
    //This will show itemtype list page
    public function index(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
        $queryString = $this->input->get();
        $querySearch = '';
        $flavourSelected = '';
        if(!empty($queryString)){
            if(array_key_exists("title", $queryString)){
                $querySearch = $queryString['title'];
            }
            if(array_key_exists("flavour", $queryString)){
                $flavourSelected = $queryString['flavour'];
            }
        }
        $whereClause = getItemTypeWhereClause($pkg_id, null, null);
        $flavours = $this->database_model->get_flavours();

        $itemtypes = $this->database_model->get_item_type($whereClause, $queryString);
        $data['itemtypes'] = $itemtypes;
        $data['flavours'] = $flavours;
        $data['flavourSelected'] = $flavourSelected;
        $data['querySearch'] = $querySearch;
        $data['mainModule'] = 'itemtype';
        $data['subModule'] = 'viewItemtype';
        $this->load->view($this->module_url.'/list', $data);
    }

    //Reset and open list
    public function list(){
        $this->index();
    }

    //This will show create page
    public function create(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
        $whereClause = getCategoryWhereClause($pkg_id, null, null);
        $flavours = $this->database_model->get_flavours();
        $data['flavours'] = $flavours;
        $data['mainModule'] = 'itemtype';
        $data['subModule'] = 'createItemtype';
        $this->load->view($this->module_url.'/create', $data);
    }

    //This will show edit page
    public function edit($itemtypeId = null){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';

        $whereClause = getItemTypeWhereClause(null, $itemtypeId, null);
        $itemtype = $this->database_model->get_item_type_where($whereClause);

        $flavours = $this->database_model->get_flavours();
        if($itemtype != null && count($itemtype) == 1){
            if($itemtype[0]['pkg_id'] == 'common' && $pkg_id != 'com.appsfeature'){
                $this->session->set_flashdata('error', 'Not authorise to edit.');
                redirect(base_url().$this->module_url);
            }else {
                $data['itemtype'] = $itemtype[0];
                $data['flavours'] = $flavours;
                $data['mainModule'] = 'itemtype';
                $data['subModule'] = '';
                $this->load->view($this->module_url.'/edit', $data);
            }
        }else {
            $this->session->set_flashdata('error', 'Itemtype not found');
            redirect(base_url().$this->module_url);
        }
    }

    //This will show delete page
    public function delete($itemtypeId){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $whereClause = getItemTypeWhereClause(null, $itemtypeId, null);
        $itemtypeArray = $this->database_model->get_item_type_where($whereClause);
        if($itemtypeArray != null && count($itemtypeArray) == 1){
            if($itemtypeArray[0]['pkg_id'] == 'common' && $pkg_id != 'com.appsfeature'){
                $this->session->set_flashdata('error', 'Not authorise to delete.');
            }else {
                if($this->database_model->delete_item_type($whereClause)){
                    $this->session->set_flashdata('success', 'Itemtype has been deleted');
                }else{
                    $this->session->set_flashdata('error', 'Failed to delete Itemtype');
                }
            }
        }else {
            $this->session->set_flashdata('error', 'Itemtype not found');
        }
        redirect(base_url().$this->module_url);
    }
}

?>
