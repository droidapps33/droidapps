<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Category extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $admin = $this->session->userdata('admin');
    if(empty($admin)){
      $this->session->set_flashdata('msg','Your session has been expired!');
        redirect(base_url().'admin/login/index');
    }
    $this->load->model(array("api/v1/database_model"));
    $this->load->library(array("form_validation"));
  }

    //http://localhost/droidappsmaster/admin/category
    //This will show category list page
    public function index(){
      $this->load->view('admin/category/list');
    }

    //This will show create page
    public function create(){

      $this->form_validation->set_error_delimiters('<p class="invalid-feedback">','</p>');
      $this->form_validation->set_rules("cat_name", "Category Name", "trim|required");

      if($this->form_validation->run() === FALSE){
        $this->load->view('admin/category/create');
      }else{
        $category = array(
          "pkg_id" => $pkg_id,
          "sub_cat_id" => $sub_cat_id == null ? 0 : $sub_cat_id,
          "cat_name" => $cat_name,
          "cat_type" => $cat_type == null ? 0 : $cat_type,
          "image" => $image,
          "order_id" => $order_id == null ? 0 : $order_id,
          "visibility" => $visibility == null ? 1 : $visibility,
          "json_data" => $json_data,
          "other_property" => $other_property
        );
        if($this->database_model->insert_category(false, $whereClause, $category)){
          $this->responseStatus(STATUS_SUCCESS, "Category has been " . ($isInsertUpdate ? "updated" : "created"));
        }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to " . ($isInsertUpdate ? "update" : "create") . " Category");
        }
      }
    }

    //This will show edit page
    public function edit(){

    }

    //This will show delete page
    public function delete(){

    }
}

?>
