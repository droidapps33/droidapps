<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AppsFeature</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/toast/build/toastr.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Welcome, <strong>Admin</strong>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url().'admin/login/logout' ?>" class="dropdown-item">
             Logout
          </a>

        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="<?php echo base_url()?>public/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><strong><?php echo getAppName(); ?></strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="info">
          <a href="#" class="d-block"><?php echo getPersonName(); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item">
           <a href="<?php echo base_url().'admin/home';?>" class="nav-link">
             <i class="far fa-circle nav-icon"></i>
             <p>
               Dashboard
             </p>
           </a>
         </li>
         <?php if(isVisibleSideMenu('Categories') == true) {?>
         <!-- Category section start -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <?php echo getMenuTitle('Categories');?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url().getMenuLink('admin/category');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?php echo getMenuTitle('Categories');?></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().getMenuLink('admin/category/create');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?php echo getMenuTitle('Add Category');?></p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Category section end -->
          <?php } ?>

          <?php if(isVisibleSideMenu('Contents') == true) {?>
          <!-- Content section start -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <?php echo getMenuTitle('Contents');?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url().getMenuLink('admin/content');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?php echo getMenuTitle('Contents');?></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().getMenuLink('admin/content/create');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?php echo getMenuTitle('Add Content');?></p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>
          <!-- Content section end -->

          <!-- Data section start -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <?php echo getMenuTitle('Simple Item');?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url().getMenuLink('admin/item');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?php echo getMenuTitle('Items');?></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().getMenuLink('admin/item/create');?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?php echo getMenuTitle('Add Item');?></p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Data section end -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
