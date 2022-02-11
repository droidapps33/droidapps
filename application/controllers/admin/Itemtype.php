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
        $catIdSelected = getPref('catIdSelected');
        $querySearch = '';
        if(!empty($queryString)){
            if(array_key_exists("cat_id", $queryString)){
                $catIdSelected = $queryString['cat_id'];
                savePref('catIdSelected', $catIdSelected);
            }
            if(array_key_exists("title", $queryString)){
                $querySearch = $queryString['title'];
            }
        }else{
            $queryString['cat_id'] = $catIdSelected;
        }
        $whereClause = getContentWhereClause($pkg_id, null, null, null, null);
        $categories = $this->database_model->get_category($whereClause);

        $itemtypes = $this->database_model->get_itemtype($whereClause, $queryString);
        $data['itemtypes'] = $itemtypes;
        $data['categories'] = $categories;
        $data['catIdSelected'] = $catIdSelected;
        $data['querySearch'] = $querySearch;
        $data['mainModule'] = 'itemtype';
        $data['subModule'] = 'viewContent';
        $this->load->view($this->module_url.'/list', $data);
    }

    //Reset and open list
    public function list(){
        savePref('catIdSelected', '');
        $this->index();
    }

    //This will show create page
    public function create(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
        $whereClause = getCategoryWhereClause($pkg_id, null, null);
        $categories = $this->database_model->get_category($whereClause);
        $itemTypes = $this->database_model->get_item_types($whereClause);
        $catIdSelected = getPref('catIdSelected');
        $data['categories'] = $categories;
        $data['itemTypes'] = $itemTypes;
        $data['catIdSelected'] = $catIdSelected;
        $data['mainModule'] = 'itemtype';
        $data['subModule'] = 'createContent';
        $this->load->view($this->module_url.'/create', $data);
    }

    //This will show edit page
    public function edit($itemtypeId = null){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';

        $whereClause = getContentWhereClause($pkg_id, null, null, $itemtypeId, null);
        $itemtype = $this->database_model->get_itemtype($whereClause);

        $whereClause = getCategoryWhereClause($pkg_id, null, null);
        $allCategories = $this->database_model->get_category($whereClause);
        $itemTypes = $this->database_model->get_item_types($whereClause);

        if($itemtype != null && count($itemtype) == 1){
            $data['itemtype'] = $itemtype[0];
            $data['categories'] = $allCategories;
            $data['itemTypes'] = $itemTypes;
            $data['mainModule'] = 'itemtype';
            $data['subModule'] = '';
            $this->load->view($this->module_url.'/edit', $data);
        }else {
            $this->session->set_flashdata('error', 'Itemtype not found');
            redirect(base_url().$this->module_url);
        }
    }

    //This will show delete page
    public function delete($itemtypeId){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $whereClause = getContentWhereClause($pkg_id, null, null, $itemtypeId, null);

        $itemtypeArray = $this->database_model->get_itemtype($whereClause);
        if($itemtypeArray != null && count($itemtypeArray) == 1){
            if($this->database_model->delete_itemtype($whereClause)){
                $this->session->set_flashdata('success', 'Itemtype has been deleted');
            }else{
                $this->session->set_flashdata('error', 'Failed to delete Itemtype');
            }
        }else {
            $this->session->set_flashdata('error', 'Itemtype not found');
        }
        redirect(base_url().$this->module_url);
    }
}

?>
