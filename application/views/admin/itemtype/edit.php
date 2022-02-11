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
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home' ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url().$CI->module_url_list ?>"><?php echo $CI->module_title;?></a></li>
              <li class="breadcrumb-item active">Edit Item</li>
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
            <div class="card card-primary">
              <div class="card-header">
                <div class="card-title">
                    Edit Item
                </div>

              </div>

              <div class="card-body">
                  <form name="itemForm" id="itemForm" action=""  method="post" enctype="multipart/form-data">

                    <input type="hidden" name="pkg_id" access="false" id="pkg_id" value="<?php echo isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:''; ?>">

                    <input type="hidden" name="id" access="false" id="id" value="<?php echo $itemtype['id']; ?>">

                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label for="flavour" class="Flavour">Flavour</label>
                            <select class="form-control" name="flavour" id="flavour">
                                <option value="0">Select Flavour</option>
                                <?php
                                    if(!empty($flavours)){
                                        foreach ($flavours as $value) {
                                            $selected = ($itemtype['flavour'] == $value['id']) ? true : false;
                                             ?>
                                             <option <?php echo set_select('flavour', $value['id'], $selected); ?> value="<?php echo $value['id'];?>"><?php echo $value['title'];?></option>
                                             <?php
                                        }
                                    }
                                 ?>
                            </select>
                        </div>
                    </div>

                     <div class="row">
                         <div class="col-sm-4 mb-3">
                             <label for="description" class="formbuilder-number-label">ItemType</label>
                             <input type="number" placeholder="Enter Item Type"  value="<?php echo $itemtype['item_type'];?>" class="form-control" name="item_type" access="false" id="item_type">
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-4 mb-3">
                             <label for="title" class="formbuilder-text-label">Title <span style="color:red">*</span></label>
                             <input type="text" placeholder="Enter Title" value="<?php echo $itemtype['title'];?>" class="form-control <?php echo (form_error('title') != "") ? 'is-invalid' : ''; ?>" name="title" access="false" id="title">
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-4 mb-3">
                             <label for="ranking" class="formbuilder-number-label">Ranking</label>
                             <input type="number" placeholder="Enter Ranking" class="form-control" value="<?php echo $itemtype['ranking'];?>" name="ranking" access="false" value="0" id="ranking">
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-4 mb-3">
                             <label for="radio-group-1642854908703" class="formbuilder-radio-group-label">Visibility</label>
                             <div class="radio-group row">
                                 <div class="ml-3">
                                     <input name="visibility"  id="radio_active" value="1" type="radio" <?php echo ($itemtype['visibility'] == 1) ? 'checked' : ''; ?>>
                                     <label for="radio_active">Active</label>
                                 </div>
                                 <div class="ml-3">
                                     <input name="visibility"  id="radio-deactive" value="0" type="radio" <?php echo ($itemtype['visibility'] == 0) ? 'checked' : ''; ?>>
                                     <label for="radio-deactive">Deactive</label>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <div class="formbuilder-button form-group field-submit">
                        <button type="submit" class="btn-success btn" name="submit" access="false" style="success" id="submitBtn">Submit</button>
                    </div>
                  </form>
              </div>

            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.itemtype -->
  </div>
  <!-- /.itemtype-wrapper -->

<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $("#itemForm").submit(function(e) {
        e.preventDefault();
        $("#submitBtn").prop("disabled", true);

        var formData= new FormData($("#itemForm")[0]);
        console.log('my message' + formData);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().version_prefix.'database/update_item_type' ?>",
            data: formData,
            processData: false,
            contentType: false,
            encode: true,
        }).done(function(data) {
            var successURL = "<?php echo base_url().$CI->module_url_list; ?>";
            if(data.status=='failure'){
              showToast(false, data.message);
              $("button[type='submit']").prop("disabled", false);
            } else {
              if(successURL!==null) {
                window.location.href=successURL;
              }
            }
        });
    });
});
</script>
