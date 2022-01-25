<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Admin_model extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function getByUsername($username){
    $this->db->where('user_id', $username);
    $query = $this->db->get('table_account');
    return $query->row_array();
  }

  public function getAppDetail($whereClause = array()){
      $query = $this->db->get_where("table_app", $whereClause);
      // return $query->result_array();
      return $query->row_array();
  }
}

?>
