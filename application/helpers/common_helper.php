<?php

function resizeImage($sourcePath, $newPath, $width, $height){

    $CI =& get_instance();
    $config['image_library']    = 'gd2';
    $config['source_image']     = $sourcePath;
    $config['new_image']        = $newPath;
    $config['create_thumb']     = TRUE;
    $config['maintain_ratio']   = TRUE;
    $config['width']            = $width;
    $config['height']           = $height;
    $config['thumb_marker']     = '';

    $CI->load->library('image_lib', $config);

    $CI->image_lib->resize();
    $CI->image_lib->clear();
}

function getCategoryWhereClause($pkg_id, $cat_id_or_name, $sub_cat_id){
    $key_cat_id_or_name = is_numeric($cat_id_or_name) ? 'cat_id' : 'cat_name';

    if($cat_id_or_name != null && $sub_cat_id != null){
      return array('pkg_id' => $pkg_id, $key_cat_id_or_name => $cat_id_or_name, 'sub_cat_id' => $sub_cat_id);
    }else if($cat_id_or_name != null){
      return array('pkg_id' => $pkg_id, $key_cat_id_or_name => $cat_id_or_name);
    }else if($sub_cat_id != null){
      return array('pkg_id' => $pkg_id, 'sub_cat_id' => $sub_cat_id);
    }else if($pkg_id != null){
      return array('pkg_id' => $pkg_id);
    }else{
      return null;
    }
}

function getContentWhereClause($pkg_id, $cat_id, $sub_cat_id, $id){
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
    }else if($pkg_id != null){
      return array('pkg_id' => $pkg_id);
    }else{
      return null;
    }
}

function getDataWhereClause($pkg_id, $cat_id, $json_data){
    if($cat_id != null){
      return array('pkg_id' => $pkg_id, 'cat_id' => $cat_id, 'json_data' => $json_data);
    }else{
      return array('pkg_id' => $pkg_id, 'json_data' => $json_data);
    }
}
?>
