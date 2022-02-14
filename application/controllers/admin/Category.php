<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Category extends CI_Controller{

    public $flavour = 0;
    public $module_title = 'Categories';
    public $module_url = 'admin/category';
    public $module_url_list = 'admin/category';
    public $module_url_create = 'admin/category/create';
    public $module_url_edit = 'admin/category/edit';
    public $module_url_delete = 'admin/category/delete';

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

    //http://localhost/droidapps/admin/category
    //This will show category list page
    public function index(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $queryString = $this->input->get();
        $subCatIdSelected = getPref('subCatIdSelected');
        $querySearch = '';
        if(!empty($queryString)){
            if(array_key_exists("sub_cat_id", $queryString)){
                $subCatIdSelected = $queryString['sub_cat_id'];
                savePref('subCatIdSelected', $subCatIdSelected);
            }
            if(array_key_exists("title", $queryString)){
                $querySearch = $queryString['title'];
            }
        }else{
            $queryString['sub_cat_id'] = $subCatIdSelected;
        }
        // print_r($queryString);die;
        $whereClause = getCategoryWhereClause($pkg_id, null, null);

        $subCategories = $this->database_model->get_category($whereClause);

        $category = $this->database_model->get_category($whereClause, $queryString);

        $whereClause['flavour'] = $this->flavour;
        $itemTypes = $this->database_model->get_item_type_flavour($whereClause);
        $itemTypeMap = null;
        foreach ($itemTypes as $value) {
            $itemTypeMap[$value['item_type']] = $value['title'];
        }

        $data['categories'] = $category;
        $data['subCategories'] = $subCategories;
        $data['subCatIdSelected'] = $subCatIdSelected;
        $data['querySearch'] = $querySearch;
        $data['itemTypeMap'] = $itemTypeMap;
        $data['mainModule'] = 'category';
        $data['subModule'] = 'viewCategory';
        $this->load->view($this->module_url.'/list', $data);
    }

    //Reset and open list
    public function list(){
        savePref('subCatIdSelected', '');
        $this->index();
    }

    //This will show create page
    public function create(){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $whereClause = getCategoryWhereClause($pkg_id, null, null);
        $categories = $this->database_model->get_category($whereClause);
        $whereClause['flavour'] = $this->flavour;
        $itemTypes = $this->database_model->get_item_type_flavour($whereClause);
        $subCatIdSelected = getPref('subCatIdSelected');
        $data['categories'] = $categories;
        $data['itemTypes'] = $itemTypes;
        $data['subCatIdSelected'] = $subCatIdSelected;
        $data['mainModule'] = 'category';
        $data['subModule'] = 'createCategory';
        $this->load->view($this->module_url.'/create', $data);
    }

    //This will show edit page
    public function edit($catId = null){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $whereClause = getCategoryWhereClause($pkg_id, $catId, null);
        $category = $this->database_model->get_category($whereClause);

        $whereClause = getCategoryWhereClause($pkg_id, null, null);
        $allCategories = $this->database_model->get_category($whereClause);

        $whereClause['flavour'] = $this->flavour;
        $itemTypes = $this->database_model->get_item_type_flavour($whereClause);
        if($category != null && count($category) == 1){
            $data['category'] = $category[0];
            $data['categories'] = $allCategories;
            $data['itemTypes'] = $itemTypes;
            $data['mainModule'] = 'category';
            $data['subModule'] = '';
            $this->load->view($this->module_url.'/edit', $data);
        }else {
            $this->session->set_flashdata('error', 'Category not found');
            redirect(base_url().$this->module_url);
        }
    }

    //This will show delete page
    public function delete($catId){
        $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';;
        $whereClause = getCategoryWhereClause($pkg_id, $catId, null);

        $categoryArray = $this->database_model->get_category($whereClause);
        if($categoryArray != null && count($categoryArray) == 1){
            $category = $categoryArray[0];
            if(!empty($category['image'])){
                if(file_exists('./'.path_image.$category['image'])){
                    unlink('./'.path_image.$category['image']);
                }
                if(file_exists('./'.path_image_thumb.$category['image'])){
                    unlink('./'.path_image_thumb.$category['image']);
                }
            }
            if($this->database_model->delete_category($whereClause)){
                $this->session->set_flashdata('success', 'Category has been deleted');
            }else{
                $this->session->set_flashdata('error', 'Failed to delete category');
            }
        }else {
            $this->session->set_flashdata('error', 'Category not found');
        }
        redirect(base_url().$this->module_url);
    }
}

?>
