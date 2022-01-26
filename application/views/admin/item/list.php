<?php $this->load->view('admin/header'); ?>
<?php $CI =& get_instance(); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $CI->module_title;?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home';?>">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $CI->module_title;?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">
                  <form id="searchForm" name="searchForm" method="get" action="">
                    <div class="input-group input-group-sm">
                      <input type="text" value="<?php  echo $querySearch;?>" class="form-control" placeholder="Search" name="json_data">
                      <div class="input-group-append">
                        <button class="input-group-text" id="basic-addon1">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="card-tools">
                  <a href="<?php echo base_url().$CI->module_url_create; ?>" class="btn btn-primary"><i class="fas fa-plus"></i>  Create</a>
                </div>
              </div>

              <div class="card-body">
                  <table class="table">
                    <tr>
                      <th width="50" class="text-center">Id</th>
                      <th width="100" class="text-center">CatId</th>
                      <th>JsonData</th>
                      <th width="160" class="text-center">Action</th>
                    </tr>

                    <?php if(!empty($items)) {?>
                        <?php foreach ($items as $itemRow) {?>
                            <tr>
                              <td class="text-center"><?php echo $itemRow['id'];?></td>
                              <td class="text-center"><?php echo $itemRow['cat_id'];?></td>
                              <td><?php echo $itemRow['json_data'];?></td>

                              <td class="text-center">
                                  <a href="<?php echo base_url().$CI->module_url_edit.'/'.$itemRow['json_data']; ?>" class="btn btn-primary btn-sm">
                                    <i class="far fa-edit"></i> Edit
                                  </a>
                                  <a href="javascript:void(0);" onclick="deleteRow('<?php echo $itemRow['json_data'] ?>')" class="btn btn-danger btn-sm">
                                    <i class="far fa-trash-alt"></i> Delete
                                  </a>
                              </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                      <tr>
                        <td colspan="4">Record not found</td>
                      </tr>
                    <?php } ?>
                  </table>
              </div>

            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">
    if('<?php echo $this->session->flashdata('success'); ?>' != ""){
        showToast(true, "<?php echo $this->session->flashdata('success'); ?>");
    }
    if('<?php echo $this->session->flashdata('error'); ?>' != ""){
        showToast(false, "<?php echo $this->session->flashdata('error'); ?>");
    }
</script>

<script type="text/javascript">
    function deleteRow(JsonData) {
        if(confirm("Are you sure you want to delete item?")){
            window.location.href='<?php echo base_url().$CI->module_url_delete.'/'; ?>' + JsonData;
        }
    }
</script>
