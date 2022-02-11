<?php
require APPPATH.'libraries/REST_Controller.php';

class Database extends REST_Controller{

  public function __construct(){
      parent::__construct();
      //load database
      $this->load->database();
      $this->load->model(array(version_prefix."database_model"));
      $this->load->library(array("form_validation"));
      $this->load->helper("security");
      $this->load->helper("common_helper");
  }


  //http://localhost/droidapps/api/v1/database/get-apps
  public function get_apps_get(){
      $apps = $this->database_model->get_apps();
      if(count($apps) > 0){
          $this->responseResult(STATUS_SUCCESS,"Apps found", $apps);
      }else{
          $this->responseResult(STATUS_FAILURE," No Apps found");
      }
  }

  //http://localhost/droidapps/api/v1/database/get-flavours
  public function get_flavours_get(){
      $flavours = $this->database_model->get_flavours();
      if(count($flavours) > 0){
          $this->responseResult(STATUS_SUCCESS, "Flavours found", $flavours);
      }else{
          $this->responseResult(STATUS_FAILURE," No Flavours found");
      }
  }

  //http://localhost/droidapps/index.php/api/v1/database/insert-category
  //where: pkg_id, title, sub_cat_id
  public function insert_category_post(){
        // print_r($whereClause);die;
      $this->insertUpdateCategory(false);
  }
  //http://localhost/droidapps/index.php/api/v1/database/insert-update-category
  //where: pkg_id, title, sub_cat_id
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
      $title = $this->input->post("title");
      if($isUpdateOnly){
          $whereClause = getCategoryWhereClause($pkg_id, $cat_id, null);
      }else {
          $whereClause = getCategoryWhereClause($pkg_id, $title, null);
      }

      $item_type = $this->input->post("item_type");
      $imageOld = $this->input->post("image_old");

      $ranking = $this->input->post("ranking");
      $visibility = $this->input->post("visibility");
      $json_data = $this->input->post("json_data");
      $other_property = $this->input->post("other_property");
      $updated_at = $this->input->post("updated_at");


      $this->form_validation->set_rules("pkg_id", "Package Id", "required");
      $this->form_validation->set_rules("title", "Category Name", "required");

      // checking form submittion have any error or not
      if($this->form_validation->run() === FALSE){
          // we have some errors
          $this->responseResult(0, strip_tags(validation_errors()));
      }else{
          $category = array(
            "pkg_id" => $pkg_id,
            "sub_cat_id" => $sub_cat_id == null ? 0 : $sub_cat_id,
            "title" => $title,
            "item_type" => $item_type == null ? 0 : $item_type,
            "ranking" => $ranking == null ? 0 : $ranking,
            "visibility" => $visibility == null ? 1 : $visibility,
            "json_data" => $json_data,
            "other_property" => $other_property,
            "updated_at" => $updated_at
          );
          // "created_at" => date('Y-m-d H:i:s');

          $config['upload_path']          = './'.path_image;
          $config['allowed_types']        = 'gif|jpg|jpeg|png';
          $config['encrypt_name']         =  true;
          // $config['max_size']             = 100;
          // $config['max_width']            = 1024;
          // $config['max_height']           = 768;

          $this->load->library('upload', $config);
          // print_r($_FILES['image']);
          // exit;
          $image=null;
          if(!empty($_FILES['image']['name'])){
              if ($this->upload->do_upload('image')){
                  $imageData = $this->upload->data();
                  resizeImage($config['upload_path'].$imageData['file_name'], $config['upload_path'].'thumb/'.$imageData['file_name']
                            , 100, 100);
                  $image = $imageData['file_name'];

                  if(!empty($imageOld)){
                      if(file_exists('./'.path_image.$imageOld)){
                        unlink('./'.path_image.$imageOld);
                      }
                      if(file_exists('./'.path_image_thumb.$imageOld)){
                        unlink('./'.path_image_thumb.$imageOld);
                      }
                  }
                  $category['image'] = $image;
              } else {
                  $this->responseStatus(STATUS_FAILURE, $this->upload->display_errors());
                  return;
              }
          }

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

  //http://localhost/droidapps/api/v1/database/delete-category
  public function delete_category_post(){
      // delete data method
      $pkg_id = $this->input->post("pkg_id");
      $cat_id = $this->input->post("cat_id");
      $sub_cat_id = $this->input->post("sub_cat_id");
      $whereClause = getCategoryWhereClause($pkg_id, $cat_id, $sub_cat_id);

      if($this->database_model->delete_category($whereClause)){
          $this->responseStatus(STATUS_SUCCESS, "Category has been deleted");
      }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to delete category");
      }
  }

  //http://localhost/droidapps/index.php/api/v1/database/get-category
  public function get_category_get(){
      $pkg_id = $this->input->get("pkg_id");
      $cat_id = $this->input->get("cat_id");
      $sub_cat_id = $this->input->get("sub_cat_id");
      $whereClause = getCategoryWhereClause($pkg_id, $cat_id, $sub_cat_id);

      $category = $this->database_model->get_category($whereClause);
      // print_r($students);
      // die();
      if(count($category) > 0){
          $this->responseResult(STATUS_SUCCESS,"Category found", $category);
      }else{
          $this->responseResult(STATUS_FAILURE," No Category found");
      }
  }

  //http://localhost/droidapps/api/v1/database/insert-content
  //where: pkg_id, title, sub_cat_id
  public function insert_content_post(){
      // print_r($whereClause);die;
      $this->insertUpdateContent(false);
  }
  //http://localhost/droidapps/api/v1/database/insert-update-content
  //where: pkg_id, title, sub_cat_id
  public function insert_update_content_post(){
      $this->insertUpdateContent(true);
  }
  //http://localhost/droidapps/api/v1/database/update-content
  //where: pkg_id, cat_id, sub_cat_id
  public function update_content_post(){
      $this->insertUpdateContent(true, true);
  }

    private function insertUpdateContent($isInsertUpdate = false, $isUpdateOnly = false){
        $pkg_id = $this->input->post("pkg_id");
        $id = $this->input->post("id");
        $cat_id = $this->input->post("cat_id");
        $sub_cat_id = $this->input->post("sub_cat_id");
        $title = $this->input->post("title");
        $imageOld = $this->input->post("image_old");

        if($isInsertUpdate == false){
            //case for insert record
            $whereClause = getContentWhereClause($pkg_id, null, null, $id, $title);
        }else {
            //case for update record
            $whereClause = getContentWhereClause($pkg_id, null, null, $id, null);
        }

        $description = $this->input->post("description");
        $item_type = $this->input->post("item_type");
        $link = $this->input->post("link");
        $visibility = $this->input->post("visibility");
        $json_data = $this->input->post("json_data");
        $other_property = $this->input->post("other_property");
        $updated_at = $this->input->post("updated_at");


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
                "item_type" => $item_type,
                "link" => $link,
                "visibility" => $visibility == null ? 1 : $visibility,
                "json_data" => $json_data,
                "other_property" => $other_property,
                "updated_at" => $updated_at
            );

            $config['upload_path']          = './'.path_image;
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['encrypt_name']         =  true;
            // $config['max_size']             = 100;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);
            // print_r($_FILES['image']);
            // exit;
            $image=null;
            if(!empty($_FILES['image']['name'])){
                if ($this->upload->do_upload('image')){
                    $imageData = $this->upload->data();
                    resizeImage($config['upload_path'].$imageData['file_name'], $config['upload_path'].'thumb/'.$imageData['file_name']
                              , 100, 100);
                    $image = $imageData['file_name'];

                    if(!empty($imageOld)){
                        if(file_exists('./'.path_image.$imageOld)){
                            unlink('./'.path_image.$imageOld);
                        }
                        if(file_exists('./'.path_image_thumb.$imageOld)){
                            unlink('./'.path_image_thumb.$imageOld);
                        }
                    }
                    $content['image'] = $image;
                } else {
                    $this->responseStatus(STATUS_FAILURE, $this->upload->display_errors());
                    return;
                }
            }
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

  //http://localhost/droidapps/api/v1/database/delete-content
  public function delete_content_post(){
      // delete data method
      $pkg_id = $this->input->post("pkg_id");
      $id = $this->input->post("id");
      $cat_id = $this->input->post("cat_id");
      $sub_cat_id = $this->input->post("sub_cat_id");
      $whereClause = getContentWhereClause($pkg_id, $cat_id, $sub_cat_id, $id, null);

      if($this->database_model->delete_content($whereClause)){
          $this->responseStatus(STATUS_SUCCESS, "Content has been deleted");
      }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to delete content");
      }
  }

  //http://localhost/droidapps/api/v1/database/get-content
  public function get_content_get(){
      $pkg_id = $this->input->get("pkg_id");
      $id = $this->input->get("id");
      $cat_id = $this->input->get("cat_id");
      $sub_cat_id = $this->input->get("sub_cat_id");
      $whereClause = getContentWhereClause($pkg_id, $cat_id, $sub_cat_id, $id, null);

      $content = $this->database_model->get_content($whereClause);
      if(count($content) > 0){
          $this->responseResult(STATUS_SUCCESS,"Content found", $content);
      }else{
          $this->responseResult(STATUS_FAILURE," No Content found");
      }
  }

  //http://localhost/droidapps/api/v1/database/get-content-by-category
  public function get_content_by_category_get(){
      $pkg_id = $this->input->get("pkg_id");
      $cat_id = $this->input->get("cat_id");
      $level = $this->input->get("level");

      $whereClause = getCategoryWhereClause($pkg_id, $cat_id, null);
      $category = $this->database_model->get_category($whereClause);
      if(count($category) > 0){
          foreach ($category as $key => $item) {
              if($level >= 2){
                  $whereClause = getCategoryWhereClause($pkg_id, null, $item['cat_id']);
                  $category2 = $this->database_model->get_category($whereClause);
                  if(count($category2) > 0){
                      foreach ($category2 as $key2 => $item2) {
                          if($level >= 3){
                              $whereClause = getCategoryWhereClause($pkg_id, null, $item2['cat_id']);
                              $category3 = $this->database_model->get_category($whereClause);
                              if(count($category3) > 0){
                                  foreach ($category3 as $key3 => $item3) {
                                      $whereClause = getContentWhereClause($pkg_id, $item3['cat_id'], null, null, null);
                                      $category3[$key3]['data'] = $this->database_model->get_content($whereClause);
                                  }
                              }
                              $category2[$key2]['data'] = $category3;
                          }else {
                              $whereClause = getContentWhereClause($pkg_id, $item2['cat_id'], null, null, null);
                              $category2[$key2]['data'] = $this->database_model->get_content($whereClause);
                          }
                      }
                  }
                  $category[$key]['data'] = $category2;
              }else {
                  $whereClause = getContentWhereClause($pkg_id, $item['cat_id'], null, null, null);
                  $category[$key]['data'] = $this->database_model->get_content($whereClause);
              }
          }
          $this->responseResult(STATUS_SUCCESS,"Category found", $category);
      }else{
          $this->responseResult(STATUS_FAILURE," No Category found");
      }
  }

  //http://localhost/droidapps/api/v1/database/get-content-by-sub-category
  public function get_content_by_sub_category_get(){
      $pkg_id = $this->input->get("pkg_id");
      $cat_id = $this->input->get("cat_id");
      $whereClause = getCategoryWhereClause($pkg_id, null, $cat_id);

      $category = $this->database_model->get_category($whereClause);
      if(count($category) > 0){
          foreach ($category as $key => $item) {
              $whereClause = getContentWhereClause($pkg_id, $item['cat_id'], null, null, null);
              $category[$key]['data'] = $this->database_model->get_content($whereClause);
          }
          $this->responseResult(STATUS_SUCCESS,"Category found", $category);
      }else{
          $this->responseResult(STATUS_FAILURE," No Category found");
      }
  }

  //http://localhost/droidapps/api/v1/database/insert-data
  //where: pkg_id, title, sub_cat_id
  public function insert_data_post(){
        // print_r($whereClause);die;
        $this->insertUpdateData(false);
  }
  //http://localhost/droidapps/api/v1/database/insert-update-data
  //where: pkg_id, title, sub_cat_id
  public function insert_update_data_post(){
      $this->insertUpdateData(false);
  }
  //http://localhost/droidapps/api/v1/database/update-data
  //where: pkg_id, cat_id, sub_cat_id
  public function update_data_post(){
      $this->insertUpdateData(true);
  }

  private function insertUpdateData($isUpdateOnly = false){
      $pkg_id = $this->input->post("pkg_id");
      $cat_id = $this->input->post("cat_id");
      $id = $this->input->post("id");
      $json_data = $this->input->post("json_data");

      $whereClause = getDataWhereClause($pkg_id, null, $id);

      $this->form_validation->set_rules("pkg_id", "Package Id", "required");
      $this->form_validation->set_rules("json_data", "Json Data", "required");
      // checking form submittion have any error or not
      if($this->form_validation->run() === FALSE){
          // we have some errors
          $this->responseResult(0, strip_tags(validation_errors()));
      }else{
          $content = array(
              "pkg_id" => $pkg_id,
              "cat_id" => $cat_id == null ? 0 : $cat_id,
              "json_data" => $json_data
          );
          if($isUpdateOnly){
              if($this->database_model->update_json($whereClause, $content)){
                  $this->responseStatus(STATUS_SUCCESS, "Json has been updated");
              }else{
                  $this->responseStatus(STATUS_FAILURE,"Failed to update Json");
              }
          }else {
              if($this->database_model->insert_json(false, $whereClause, $content)){
                  $this->responseStatus(STATUS_SUCCESS, "Json has been created");
              }else{
                  $this->responseStatus(STATUS_FAILURE,"Failed to create Json");
              }
          }
      }
  }

  //http://localhost/droidapps/api/v1/database/delete-data
  public function delete_data_post(){
      // delete data method
      $pkg_id = $this->input->post("pkg_id");
      $cat_id = $this->input->post("cat_id");
      $whereClause = getDataWhereClause($pkg_id, $cat_id, null);

      if($this->database_model->delete_json($whereClause)){
          $this->responseStatus(STATUS_SUCCESS, "Json has been deleted");
      }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to delete Json");
      }
  }

  //http://localhost/droidapps/api/v1/database/get-data
  public function get_data_get(){
      $pkg_id = $this->input->get("pkg_id");
      $cat_id = $this->input->get("cat_id");
      $whereClause = getDataWhereClause($pkg_id, $cat_id, null);

      $content = $this->database_model->get_json($whereClause);
      if(count($content) > 0){
          $this->responseResult(STATUS_SUCCESS,"Json found", $content);
      }else{
          $this->responseResult(STATUS_FAILURE," No Json found");
      }
  }

  //http://localhost/droidapps/api/v1/database/insert-item-type
  //where: $pkg_id, $id, $title
  public function insert_item_type_post(){
        $this->insertItemtype(false);
  }
  //http://localhost/droidapps/api/v1/database/update-item-type
  //where: $pkg_id, $id, $title
  public function update_item_type_post(){
      $this->insertItemtype(true);
  }

  private function insertItemtype($isUpdateOnly = false){
      $pkg_id = $this->input->post("pkg_id");
      $id = $this->input->post("id");
      $flavour = $this->input->post("flavour");
      $itemType = $this->input->post("item_type");
      $title = $this->input->post("title");
      $ranking = $this->input->post("ranking");
      $visibility = $this->input->post("visibility");

      $whereClause = getItemTypeWhereClause($pkg_id, $id, $title);

      $this->form_validation->set_rules("pkg_id", "Package Id", "required");
      $this->form_validation->set_rules("item_type", "Item Type", "required");
      $this->form_validation->set_rules("title", "Title", "required");
      // checking form submittion have any error or not
      if($this->form_validation->run() === FALSE){
          // we have some errors
          $this->responseResult(0, strip_tags(validation_errors()));
      }else{
          $content = array(
              "pkg_id" => $pkg_id,
              "flavour" => $flavour == null ? 0 : $flavour,
              "item_type" => $itemType == null ? 0 : $itemType,
              "title" => $title,
              "ranking" => $ranking == null ? 0 : $ranking,
              "visibility" => $visibility == null ? 1 : $visibility
          );
          if($isUpdateOnly){
              if($this->database_model->update_item_type($whereClause, $content)){
                  $this->responseStatus(STATUS_SUCCESS, "ItemType has been updated");
              }else{
                  $this->responseStatus(STATUS_FAILURE,"Failed to update ItemType");
              }
          }else {
              if($this->database_model->insert_item_type(false, $whereClause, $content)){
                  $this->responseStatus(STATUS_SUCCESS, "ItemType has been created");
              }else{
                  $this->responseStatus(STATUS_FAILURE,"Failed to create ItemType");
              }
          }
      }
  }

  //http://localhost/droidapps/api/v1/database/delete-item-type
  public function delete_item_type_post(){
      // delete data method
      $pkg_id = $this->input->post("pkg_id");
      $id = $this->input->post("id");
      $whereClause = getItemTypeWhereClause($pkg_id, $id, null);

      if($this->database_model->delete_item_type($whereClause)){
          $this->responseStatus(STATUS_SUCCESS, "ItemType has been deleted");
      }else{
          $this->responseStatus(STATUS_FAILURE,"Failed to delete ItemType");
      }
  }

  //http://localhost/droidapps/index.php/api/v1/database/get-item-type
  public function get_item_type_get(){
      $pkg_id = $this->input->get("pkg_id");
      $id = $this->input->get("id");
      $whereClause = getItemTypeWhereClause($pkg_id, $id, null);

      $category = $this->database_model->get_item_type($whereClause);
      // print_r($students);
      // die();
      if(count($category) > 0){
          $this->responseResult(STATUS_SUCCESS,"ItemType found", $category);
      }else{
          $this->responseResult(STATUS_FAILURE," No ItemType found");
      }
  }

}

 ?>
