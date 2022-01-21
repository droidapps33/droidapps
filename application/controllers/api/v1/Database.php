<?php

require APPPATH.'libraries/REST_Controller.php';

class Database extends REST_Controller{

  public function __construct(){

    parent::__construct();
    //load database
    $this->load->database();
    $this->load->model(array("api/v1/database_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }


  //http://localhost/droidapps/index.php/api/v1/Database/get_apps
  public function get_apps_get(){
    $apps = $this->database_model->get_apps();
    // print_r($students);
    // die();
    if(count($apps) > 0){
      $this->responseResult(STATUS_SUCCESS,"Apps found", $apps);
    }else{
      $this->responseResult(STATUS_FAILURE," No Apps found");
    }
  }

  private function getCategoryWhereClause($pkg_id, $cat_id_or_name, $sub_cat_id){
    $key_cat_id_or_name = is_numeric($cat_id_or_name) ? 'cat_id' : 'cat_name';

    if($cat_id_or_name != null && $sub_cat_id != null){
      return array('pkg_id' => $pkg_id, $key_cat_id_or_name => $cat_id_or_name, 'sub_cat_id' => $sub_cat_id);
    }else if($cat_id_or_name != null){
      return array('pkg_id' => $pkg_id, $key_cat_id_or_name => $cat_id_or_name);
    }else if($sub_cat_id != null){
      return array('pkg_id' => $pkg_id, 'sub_cat_id' => $sub_cat_id);
    }else{
      return array('pkg_id' => $pkg_id);
    }
  }

  //http://localhost/droidapps/index.php/api/v1/database/insert-category
  //where: pkg_id, cat_name, sub_cat_id
  public function insert_category_post(){
        // print_r($whereClause);die;
     $this->insertUpdateCategory(false);
  }
  //http://localhost/droidapps/index.php/api/v1/database/insert-update-category
  //where: pkg_id, cat_name, sub_cat_id
  public function insert_update_category_post(){
     $this->insertUpdateCategory(true);
  }
  //http://localhost/droidapps/index.php/api/v1/database/update-category
  //where: pkg_id, cat_id, sub_cat_id
  public function update_category_post(){
     $this->insertUpdateCategory(true, true);
  }

  private function insertUpdateCategory($isInsertUpdate = false, $isUpdateOnly = false){
    $pkg_id = $this->input->post("pkg_id");
    $cat_id = $this->input->post("cat_id");
    $sub_cat_id = $this->input->post("sub_cat_id");
    $cat_name = $this->input->post("cat_name");
    if($isUpdateOnly){
      $whereClause = $this->getCategoryWhereClause($pkg_id, $cat_id, $sub_cat_id);
    }else {
      $whereClause = $this->getCategoryWhereClause($pkg_id, $cat_name, $sub_cat_id);
    }

    $cat_type = $this->input->post("cat_type");
    $image = $this->input->post("image");
    $order_id = $this->input->post("order_id");
    $visibility = $this->input->post("visibility");
    $json_data = $this->input->post("json_data");
    $other_property = $this->input->post("other_property");


    $this->form_validation->set_rules("pkg_id", "Package Id", "required");
    $this->form_validation->set_rules("cat_name", "Category Name", "required");

    // checking form submittion have any error or not
    if($this->form_validation->run() === FALSE){
      // we have some errors
      $this->responseResult(0, strip_tags(validation_errors()));
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

      if($isUpdateOnly){
        if($this->database_model->update_category($whereClause, $category)){
          $this->responseStatus(STATUS_SUCCESS, "Category has been updated");
        }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to update Category");
        }
      }else {
        if($this->database_model->insert_category($isInsertUpdate, $whereClause, $category)){
          $this->responseStatus(STATUS_SUCCESS, "Category has been " . ($isInsertUpdate ? "updated" : "created"));
        }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to " . ($isInsertUpdate ? "update" : "create") . " Category");
        }
      }
    }
  }

  //http://localhost/droidapps/index.php/api/v1/database/delete-category
  public function delete_category_post(){
    // delete data method
    $pkg_id = $this->input->post("pkg_id");
    $cat_id = $this->input->post("cat_id");
    $sub_cat_id = $this->input->post("sub_cat_id");
    $whereClause = $this->getCategoryWhereClause($pkg_id, $cat_id, $sub_cat_id);

    if($this->database_model->delete_category($whereClause)){
      $this->responseStatus(STATUS_SUCCESS, "Category has been deleted");
    }else{
      $this->responseStatus(STATUS_FAILURE,"Failed to delete category");
    }
  }

  //http://localhost/droidapps/index.php/api/v1/Database/get-category
  public function get_category_get(){
    $pkg_id = $this->input->get("pkg_id");
    $cat_id = $this->input->get("cat_id");
    $sub_cat_id = $this->input->get("sub_cat_id");
    $whereClause = $this->getCategoryWhereClause($pkg_id, $cat_id, $sub_cat_id);

    $category = $this->database_model->get_category($whereClause);
    // print_r($students);
    // die();
    if(count($category) > 0){
      $this->responseResult(STATUS_SUCCESS,"Category found", $category);
    }else{
      $this->responseResult(STATUS_FAILURE," No Category found");
    }
  }

  private function getContentWhereClause($pkg_id, $cat_id, $sub_cat_id, $id){
    if($cat_id != null && $sub_cat_id != null && $id != null){
      return array('pkg_id' => $pkg_id, 'id' => $id, 'cat_id' => $cat_id, 'sub_cat_id' => $sub_cat_id);
    }else if($cat_id != null && $sub_cat_id != null){
      return array('pkg_id' => $pkg_id, 'cat_id' => $cat_id, 'sub_cat_id' => $sub_cat_id);
    }else if($cat_id != null && $id != null){
      return array('pkg_id' => $pkg_id, 'id' => $id, 'cat_id' => $cat_id);
    }else if($sub_cat_id != null && $id != null){
      return array('pkg_id' => $pkg_id, 'id' => $id, 'sub_cat_id' => $sub_cat_id);
    }else if($id != null){
      return array('pkg_id' => $pkg_id, 'id' => $id);
    }else if($cat_id != null){
      return array('pkg_id' => $pkg_id, 'cat_id' => $cat_id);
    }else if($sub_cat_id != null){
      return array('pkg_id' => $pkg_id, 'sub_cat_id' => $sub_cat_id);
    }else{
      return array('pkg_id' => $pkg_id);
    }
  }

  //http://localhost/droidapps/index.php/api/v1/database/insert-content
  //where: pkg_id, cat_name, sub_cat_id
  public function insert_content_post(){
        // print_r($whereClause);die;
     $this->insertUpdateContent(false);
  }
  //http://localhost/droidapps/index.php/api/v1/database/insert-update-content
  //where: pkg_id, cat_name, sub_cat_id
  public function insert_update_content_post(){
     $this->insertUpdateContent(true);
  }
  //http://localhost/droidapps/index.php/api/v1/database/update-content
  //where: pkg_id, cat_id, sub_cat_id
  public function update_content_post(){
     $this->insertUpdateContent(true, true);
  }

  private function insertUpdateContent($isInsertUpdate = false, $isUpdateOnly = false){
    $pkg_id = $this->input->post("pkg_id");
    $id = $this->input->post("id");
    $cat_id = $this->input->post("cat_id");
    $sub_cat_id = $this->input->post("sub_cat_id");

    $whereClause = $this->getContentWhereClause($pkg_id, $cat_id, $sub_cat_id, $id);

    $title = $this->input->post("title");
    $description = $this->input->post("description");
    $image = $this->input->post("image");
    $link = $this->input->post("link");
    $visibility = $this->input->post("visibility");
    $json_data = $this->input->post("json_data");
    $other_property = $this->input->post("other_property");


    $this->form_validation->set_rules("pkg_id", "Package Id", "required");
    $this->form_validation->set_rules("title", "Title", "required");

    // checking form submittion have any error or not
    if($this->form_validation->run() === FALSE){
      // we have some errors
      $this->responseResult(0, strip_tags(validation_errors()));
    }else{

      $content = array(
        "pkg_id" => $pkg_id,
        "cat_id" => $cat_id == null ? 0 : $cat_id,
        "sub_cat_id" => $sub_cat_id == null ? 0 : $sub_cat_id,
        "title" => $title,
        "description" => $description,
        "image" => $image,
        "link" => $link,
        "visibility" => $visibility == null ? 1 : $visibility,
        "json_data" => $json_data,
        "other_property" => $other_property
      );

      if($isUpdateOnly){
        if($this->database_model->update_content($whereClause, $content)){
          $this->responseStatus(STATUS_SUCCESS, "Content has been updated");
        }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to update Content");
        }
      }else {
        if($this->database_model->insert_content($isInsertUpdate, $whereClause, $content)){
          $this->responseStatus(STATUS_SUCCESS, "Content has been " . ($isInsertUpdate ? "updated" : "created"));
        }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to " . ($isInsertUpdate ? "update" : "create") . " Content");
        }
      }
    }
  }

  //http://localhost/droidapps/index.php/api/v1/database/delete-content
  public function delete_content_post(){
    // delete data method
    $pkg_id = $this->input->post("pkg_id");
    $id = $this->input->post("id");
    $cat_id = $this->input->post("cat_id");
    $sub_cat_id = $this->input->post("sub_cat_id");
    $whereClause = $this->getContentWhereClause($pkg_id, $cat_id, $sub_cat_id, $id);

    if($this->database_model->delete_content($whereClause)){
      $this->responseStatus(STATUS_SUCCESS, "Content has been deleted");
    }else{
      $this->responseStatus(STATUS_FAILURE,"Failed to delete content");
    }
  }

  //http://localhost/droidapps/index.php/api/v1/Database/get-content
  public function get_content_get(){
    $pkg_id = $this->input->get("pkg_id");
    $id = $this->input->get("id");
    $cat_id = $this->input->get("cat_id");
    $sub_cat_id = $this->input->get("sub_cat_id");
    $whereClause = $this->getContentWhereClause($pkg_id, $cat_id, $sub_cat_id, $id);

    $content = $this->database_model->get_content($whereClause);
    if(count($content) > 0){
      $this->responseResult(STATUS_SUCCESS,"Content found", $content);
    }else{
      $this->responseResult(STATUS_FAILURE," No Content found");
    }
  }

  //http://localhost/droidapps/index.php/api/v1/Database/get-content-by-category
  public function get_content_by_category_get(){
    $pkg_id = $this->input->get("pkg_id");
    $id = $this->input->get("id");
    $cat_id = $this->input->get("cat_id");
    $sub_cat_id = $this->input->get("sub_cat_id");
    $whereClause = $this->getContentWhereClause($pkg_id, $cat_id, $sub_cat_id, $id);

    $category = $this->database_model->get_category($whereClause);
    if(count($category) > 0){
      foreach ($category as $key => $item) {
         $category[$key]->content = $this->database_model->get_content($whereClause);
      }
      $this->responseResult(STATUS_SUCCESS,"Category found", $category);
    }else{
      $this->responseResult(STATUS_FAILURE," No Category found");
    }
  }

  private function getDataWhereClause($pkg_id, $cat_id, $json_data){
    if($cat_id != null){
      return array('pkg_id' => $pkg_id, 'cat_id' => $cat_id, 'json_data' => $json_data);
    }else{
      return array('pkg_id' => $pkg_id, 'json_data' => $json_data);
    }
  }

  //http://localhost/droidapps/index.php/api/v1/database/insert-data
  //where: pkg_id, cat_name, sub_cat_id
  public function insert_data_post(){
        // print_r($whereClause);die;
     $this->insertUpdateData(false);
  }
  //http://localhost/droidapps/index.php/api/v1/database/insert-update-data
  //where: pkg_id, cat_name, sub_cat_id
  public function insert_update_data_post(){
     $this->insertUpdateData(false);
  }
  //http://localhost/droidapps/index.php/api/v1/database/update-data
  //where: pkg_id, cat_id, sub_cat_id
  public function update_data_post(){
     $this->insertUpdateData(true);
  }

  private function insertUpdateData($isUpdateOnly = false){
    $pkg_id = $this->input->post("pkg_id");
    $cat_id = $this->input->post("cat_id");
    $json_data = $this->input->post("json_data");
    $title = "";
    $whereClause = $this->getDataWhereClause($pkg_id, $cat_id, $json_data);

    $this->form_validation->set_rules("pkg_id", "Package Id", "required");

    // checking form submittion have any error or not
    if($this->form_validation->run() === FALSE){
      // we have some errors
      $this->responseResult(0, strip_tags(validation_errors()));
    }else{

      $content = array(
        "pkg_id" => $pkg_id,
        "cat_id" => $cat_id == null ? 0 : $cat_id,
        "sub_cat_id" => 0,
        "title" => $title,
        "description" => null,
        "image" => null,
        "link" => null,
        "visibility" => 1,
        "json_data" => $json_data,
        "other_property" => null
      );

      if($isUpdateOnly){
        if($this->database_model->update_content($whereClause, $category)){
          $this->responseStatus(STATUS_SUCCESS, "Data has been updated");
        }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to update Data");
        }
      }else {
        if($this->database_model->insert_content($isInsertUpdate, $whereClause, $category)){
          $this->responseStatus(STATUS_SUCCESS, "Data has been " . ($isInsertUpdate ? "updated" : "created"));
        }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to " . ($isInsertUpdate ? "update" : "create") . " Data");
        }
      }
    }
  }

  //http://localhost/droidapps/index.php/api/v1/database/delete-data
  public function delete_data_post(){
    // delete data method
    $pkg_id = $this->input->post("pkg_id");
    $cat_id = $this->input->post("cat_id");
    $whereClause = $this->getDataWhereClause($pkg_id, $cat_id, null);

    if($this->database_model->delete_content($whereClause)){
      $this->responseStatus(STATUS_SUCCESS, "Data has been deleted");
    }else{
      $this->responseStatus(STATUS_FAILURE,"Failed to delete Data");
    }
  }

  //http://localhost/droidapps/index.php/api/v1/Database/get-data
  public function get_data_get(){
    $pkg_id = $this->input->get("pkg_id");
    $cat_id = $this->input->get("cat_id");
    $whereClause = $this->getDataWhereClause($pkg_id, $cat_id, null);

    $content = $this->database_model->get_content_data($whereClause);
    if(count($content) > 0){
      $this->responseResult(STATUS_SUCCESS,"Data found", $content);
    }else{
      $this->responseResult(STATUS_FAILURE," No Data found");
    }
  }

}

 ?>
