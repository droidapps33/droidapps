<?php

class Database_model extends CI_Model{

  //var $table_category = 'table_category';

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_apps(){
    $this->db->order_by('app_id', 'DESC');
    $query = $this->db->get('table_app');
    return $query->result_array();
  }

  public function get_flavours(){
    $this->db->order_by('ranking', 'ASC');
    $this->db->where('visibility =', '1');
    $query = $this->db->get('table_flavour');
    return $query->result_array();
  }

   public function get_item_types($whereClause = array()){
       $this->db->order_by('id', 'DESC');
       $query = $this->db->get_where("table_item_type", $whereClause);
       return $query->result_array();
   }

   public function insert_category($isUpdate = false, $whereClause = array(), $data = array()){
     $query = $this->db->get_where('table_category', $whereClause);
     if($query->num_rows() <= 0 ){
       return $this->db->insert("table_category", $data);
     }else {
       if($isUpdate){
         return $this->db->update("table_category", $data, $whereClause);
       }else {
         return false;
       }
     }
   }

   public function update_category($whereClause = array(), $data = array()){
     $query = $this->db->get_where('table_category', $whereClause);
     if($query->num_rows() > 0 ){
       return $this->db->update("table_category", $data, $whereClause);
     }else {
       return false;
     }
   }

   public function delete_category($whereClause = array()){
     return $this->db->delete("table_category", $whereClause);
   }

    public function get_category($whereClause = array(), $searchQuery=[]){
        if($searchQuery != null && count($searchQuery) > 0){
            $this->db->like($searchQuery);
        }
        $this->db->order_by('cat_id', 'DESC');
        $query = $this->db->get_where("table_category", $whereClause);
        return $query->result_array();
    }

   public function insert_content($isUpdate = false, $whereClause = array(), $data = array()){
     $query = $this->db->get_where('table_content', $whereClause);
     if($query->num_rows() <= 0 ){
       return $this->db->insert("table_content", $data);
     }else {
       if($isUpdate){
         return $this->db->update("table_content", $data, $whereClause);
       }else {
         return false;
       }
     }
   }

   public function update_content($whereClause = array(), $data = array()){
     $query = $this->db->get_where('table_content', $whereClause);
     if($query->num_rows() > 0 ){
       return $this->db->update("table_content", $data, $whereClause);
     }else {
       return false;
     }
   }

   public function delete_content($whereClause = array()){
       return $this->db->delete("table_content", $whereClause);
   }

    public function get_content($whereClause = array(), $searchQuery=[]){
        if($searchQuery != null && count($searchQuery) > 0){
           $this->db->like($searchQuery);
        }
        $this->db->where('title !=', '');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get_where("table_content", $whereClause);
         return $query->result_array();
    }

    public function insert_json($isUpdate = false, $whereClause = array(), $data = array()){
      $query = $this->db->get_where('table_json', $whereClause);
      if($query->num_rows() <= 0 ){
        return $this->db->insert("table_json", $data);
      }else {
        if($isUpdate){
          return $this->db->update("table_json", $data, $whereClause);
        }else {
          return false;
        }
      }
    }

    public function update_json($whereClause = array(), $data = array()){
      $query = $this->db->get_where('table_json', $whereClause);
      if($query->num_rows() > 0 ){
        return $this->db->update("table_json", $data, $whereClause);
      }else {
        return false;
      }
    }

    public function delete_json($whereClause = array()){
        return $this->db->delete("table_json", $whereClause);
    }

     public function get_json($whereClause = array(), $searchQuery=[]){
         if($searchQuery != null && count($searchQuery) > 0){
            $this->db->like($searchQuery);
         }
         $this->db->order_by('id', 'DESC');
         $query = $this->db->get_where("table_json", $whereClause);
          return $query->result_array();
     }

     public function get_content_data($whereClause = array(), $searchQuery=[]){
        if($searchQuery != null && count($searchQuery) > 0){
            $this->db->like($searchQuery);
        }
        $this->db->select('pkg_id, id, cat_id, json_data, updated_at');
        $this->db->where('title =', '');
        $this->db->where('json_data !=', '');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get_where("table_content", $whereClause);
        return $query->result_array();
    }

    public function insert_item_type($isUpdate = false, $whereClause = array(), $data = array()){
      $query = $this->db->get_where('table_item_type', $whereClause);
      if($query->num_rows() <= 0 ){
        return $this->db->insert("table_item_type", $data);
      }else {
        if($isUpdate){
          return $this->db->update("table_item_type", $data, $whereClause);
        }else {
          return false;
        }
      }
    }

    public function update_item_type($whereClause = array(), $data = array()){
      $query = $this->db->get_where('table_item_type', $whereClause);
      if($query->num_rows() > 0 ){
        return $this->db->update("table_item_type", $data, $whereClause);
      }else {
        return false;
      }
    }

    public function delete_item_type($whereClause = array()){
        $pkgId = $whereClause['pkg_id'];
        if($pkgId != null && $pkgId == 'common'){
            $user_pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
            if($user_pkg_id != 'com.appsfeature'){
                return false;
            }
        }
        return $this->db->delete("table_item_type", $whereClause);
    }

     public function get_item_type($whereClause = array(), $searchQuery=[]){
         if($searchQuery != null && count($searchQuery) > 0){
             $this->db->like($searchQuery);
         }
         $names = array('common', $whereClause['pkg_id']);
         $this->db->where_in('pkg_id', $names);
         $this->db->order_by('ranking', 'ASC');
         $query = $this->db->get("table_item_type");
         return $query->result_array();
     }
}
?>
