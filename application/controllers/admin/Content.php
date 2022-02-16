<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Content extends CI_Controller{

    public $flavour = 1;
    public $module_title = 'Contents';
    public $module_url = 'admin/content';
    public $module_url_list = 'admin/content';
    public $module_url_create = 'admin/content/create';
    public $module_url_edit = 'admin/content/edit';
    public $module_url_delete = 'admin/content/delete';

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

    //http://localhost/droidapps/admin/content
    //This will show content list page
    public function index(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
        $queryString = $this->input->get();
        $catIdSelected = getPref('catIdSelected');
        $itemTypeContentSelected = getPref('itemTypeContentSelected');
        $querySearch = '';
        if(!empty($queryString)){
            if(array_key_exists("sub_cat_id", $queryString)){
                $catIdSelected = $queryString['sub_cat_id'];
                savePref('catIdSelected', $catIdSelected);
            }
            if(array_key_exists("item_type", $queryString)){
                $itemTypeContentSelected = $queryString['item_type'];
                savePref('itemTypeContentSelected', $itemTypeContentSelected);
            }
            if(array_key_exists("title", $queryString)){
                $querySearch = $queryString['title'];
            }
        }else{
            $queryString['sub_cat_id'] = $catIdSelected;
        }
        $whereClause = getContentWhereClause($pkg_id, null, null, null, null);
        $categories = $this->database_model->get_category($whereClause);

        $contents = $this->database_model->get_content($whereClause, $queryString);

        $whereClause['flavour'] = $this->flavour;
        $itemTypes = $this->database_model->get_item_type_flavour($whereClause);
        $itemTypeMap = null;
        foreach ($itemTypes as $value) {
            $itemTypeMap[$value['item_type']] = $value['title'];
        }
        $categoryMap = null;
        foreach ($categories as $value1) {
            $categoryMap[$value1['cat_id']] = $value1['title'];
        }

        $data['contents'] = $contents;
        $data['categories'] = $categories;
        $data['categoryMap'] = $categoryMap;
        $data['catIdSelected'] = $catIdSelected;
        $data['itemTypeContentSelected'] = $itemTypeContentSelected;
        $data['querySearch'] = $querySearch;
        $data['itemTypes'] = $itemTypes;
        $data['itemTypeMap'] = $itemTypeMap;
        $data['mainModule'] = 'content';
        $data['subModule'] = 'viewContent';
        $this->load->view($this->module_url.'/list', $data);
    }

    //Reset and open list
    public function list(){
        savePref('catIdSelected', '');
        savePref('itemTypeContentSelected', '');
        $this->index();
    }

    //This will show create page
    public function create(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
        $whereClause = getCategoryWhereClause($pkg_id, null, null);
        $categories = $this->database_model->get_category($whereClause);
        $whereClause['flavour'] = $this->flavour;
        $itemTypes = $this->database_model->get_item_type_flavour($whereClause);
        $catIdSelected = getPref('catIdSelected');
        $itemTypeContentSelected = getPref('itemTypeContentSelected');
        $data['categories'] = $categories;
        $data['itemTypes'] = $itemTypes;
        $data['catIdSelected'] = $catIdSelected;
        $data['itemTypeContentSelected'] = $itemTypeContentSelected;
        $data['mainModule'] = 'content';
        $data['subModule'] = 'createContent';
        $this->load->view($this->module_url.'/create', $data);
    }

    //This will show edit page
    public function edit($contentId = null){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';

        $whereClause = getContentWhereClause($pkg_id, null, null, $contentId, null);
        $content = $this->database_model->get_content($whereClause);

        $whereClause = getCategoryWhereClause($pkg_id, null, null);
        $allCategories = $this->database_model->get_category($whereClause);
        $whereClause['flavour'] = $this->flavour;
        $itemTypes = $this->database_model->get_item_type_flavour($whereClause);

        if($content != null && count($content) == 1){
            $data['content'] = $content[0];
            $data['categories'] = $allCategories;
            $data['itemTypes'] = $itemTypes;
            $data['mainModule'] = 'content';
            $data['subModule'] = '';
            $this->load->view($this->module_url.'/edit', $data);
        }else {
            $this->session->set_flashdata('error', 'Content not found');
            redirect(base_url().$this->module_url);
        }
    }

    //This will show delete page
    public function delete($contentId){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $whereClause = getContentWhereClause($pkg_id, null, null, $contentId, null);

        $contentArray = $this->database_model->get_content($whereClause);
        if($contentArray != null && count($contentArray) == 1){
            $content = $contentArray[0];
            if(!empty($content['image'])){
                if(file_exists('./'.path_image.$content['image'])){
                    unlink('./'.path_image.$content['image']);
                }
                if(file_exists('./'.path_image_thumb.$content['image'])){
                    unlink('./'.path_image_thumb.$content['image']);
                }
            }
            if($this->database_model->delete_content($whereClause)){
                $this->session->set_flashdata('success', 'Content has been deleted');
            }else{
                $this->session->set_flashdata('error', 'Failed to delete Content');
            }
        }else {
            $this->session->set_flashdata('error', 'Content not found');
        }
        redirect(base_url().$this->module_url);
    }
}

?>
