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
    return $query->result();
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

   public function get_category($whereClause = array()){
     $query = $this->db->get_where("table_category", $whereClause);
     return $query->result();
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

   public function get_content($whereClause = array()){
     $query = $this->db->get_where("table_content", $whereClause);
     return $query->result();
   }

   public function get_content_data($whereClause = array()){
     $this->db->select('pkg_id, id, cat_id, json_data, updated_at');
     $query = $this->db->get_where("table_content", $whereClause);
     return $query->result();
   }
}
?>
