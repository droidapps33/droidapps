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

function savePref($key, $value){
    $CI =& get_instance();
    $preferencesArray[$key] = $value;
    $preferencesKey = $key.'pref';
    $CI->session->set_userdata($preferencesKey, $preferencesArray);
}

function getPref($key){
    $preferencesKey = $key.'pref';
    return isset($_SESSION[$preferencesKey][$key])?$_SESSION[$preferencesKey][$key]:'';
}

function getCategoryWhereClause($pkg_id, $cat_id_or_name, $sub_cat_id){
    $key_cat_id_or_name = is_numeric($cat_id_or_name) ? 'cat_id' : 'title';

    $whereClause = null;
    if($pkg_id != null){
        $whereClause['pkg_id'] = $pkg_id;
    }
    if($cat_id_or_name != null){
        $whereClause[$key_cat_id_or_name] = $cat_id_or_name;
    }
    if($sub_cat_id != null){
        $whereClause['sub_cat_id'] = $sub_cat_id;
    }
    return $whereClause;
}

function getContentWhereClause($pkg_id, $cat_id, $sub_cat_id, $id, $title){
    $whereClause = null;
    if($pkg_id != null){
        $whereClause['pkg_id'] = $pkg_id;
    }
    if($cat_id != null){
        $whereClause['cat_id'] = $cat_id;
    }
    if($sub_cat_id != null){
        $whereClause['sub_cat_id'] = $sub_cat_id;
    }
    if($id != null){
        $whereClause['id'] = $id;
    }
    if($title != null){
        $whereClause['title'] = $title;
    }
    return $whereClause;
}

function getDataWhereClause($pkg_id, $cat_id, $id){
    $whereClause = null;
    if($pkg_id != null){
        $whereClause['pkg_id'] = $pkg_id;
    }
    if($cat_id != null){
        $whereClause['cat_id'] = $cat_id;
    }
    if($id != null){
        $whereClause['id'] = $id;
    }
    return $whereClause;
}

function getItemTypeWhereClause($pkg_id, $id, $title){
    $whereClause = null;
    if($pkg_id != null){
        $whereClause['pkg_id'] = $pkg_id;
    }
    if($id != null){
        $whereClause['id'] = $id;
    }
    if($title != null){
        $whereClause['title'] = $title;
    }
    return $whereClause;
}

function savePreferences(){
    $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
    if($pkg_id == 'com.appsfeature.bizwiz'){
        savePref('catSpinnerSelected', '114');
    }
}

function isVisibleSideMenu($menuName){
  $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
  if($pkg_id == 'com.appsfeature.bizwiz'){
      if($menuName == 'Categories' || $menuName == 'Contents' || $menuName == 'ItemType'){
          return false;
      }
  }
  return true;
}

function isVisibleDashboardMenu($menuName){
  $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
  if($pkg_id == 'com.appsfeature.bizwiz'){
      // if($menuName == 'Categories'){
      //     return false;
      // }
  }
  return true;
}

function getMenuTitle($menuName){
  $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
  if($pkg_id == 'com.appsfeature.bizwiz'){
      switch ($menuName) {
          case 'Contents':
              return 'Home Items';
          case 'Json data':
              return 'Home Items';
          default:
              return $menuName;
      }
  }
  return $menuName;
}

function getMenuLink($menuLink){
  $pkg_id = isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:'';
  if($pkg_id == 'com.appsfeature.bizwiz'){
      switch ($menuLink) {
          case 'admin/content':
          case 'admin/content/list':
          case 'admin/json':
              return 'admin/bizwiz';
          case 'admin/json/create':
              return 'admin/bizwiz/create';
          default:
              return $menuLink;
      }
  }
  return $menuLink;
}

//Dashboard customization methods
function getAppName(){
  return isset($_SESSION['admin']['app_name'])?$_SESSION['admin']['app_name']:'Appsfeature';
}
function getPersonName(){
  return isset($_SESSION['admin']['name'])?$_SESSION['admin']['name']:'User';
}
?>
