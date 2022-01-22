<?php $this->load->view('admin/header'); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Categories</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home' ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/category' ?>">Categories</a></li>
              <li class="breadcrumb-item active">Create New Category</li>
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
                    Create New Category
                </div>

              </div>

              <div class="card-body">
                  <form name="categoryForm" id="categoryForm" action="<?php echo base_url().'admin/category/create' ?>" method="post">

                    <div class="formbuilder-number form-group field-sub_cat_id">
                         <label for="sub_cat_id" class="formbuilder-number-label">SubCatId</label>
                         <input type="number" placeholder="Enter SubCatId" class="form-control" name="sub_cat_id" access="false" value="0" id="sub_cat_id">
                     </div>
                     <div class="formbuilder-text form-group field-cat_name">
                         <label for="cat_name" class="formbuilder-text-label">Category Name</label>
                         <input type="text" placeholder="Enter Category Name" class="form-control <?php echo (form_error('cat_name') != "") ? 'is-invalid' : ''; ?>" name="cat_name" access="false" id="cat_name">
                         <?php echo form_error('cat_name');?>
                     </div>
                     <div class="formbuilder-number form-group field-cat_type">
                         <label for="cat_type" class="formbuilder-number-label">Category Type</label>
                         <input type="number" placeholder="Enter Category Type" class="form-control" name="cat_type" access="false" value="0" id="cat_type">
                     </div>
                     <div class="formbuilder-file form-group field-image">
                         <label for="image" class="formbuilder-file-label">Image</label>
                         <input type="file" class="form-control" name="image" access="false" multiple="false" id="image">
                     </div>
                     <div class="formbuilder-number form-group field-order_id">
                         <label for="order_id" class="formbuilder-number-label">Order Id</label>
                         <input type="number" placeholder="Enter Order Id" class="form-control" name="order_id" access="false" value="0" id="order_id">
                     </div>
                     <div class="formbuilder-radio-group form-group field-radio-group-1642854908703">
                         <label for="radio-group-1642854908703" class="formbuilder-radio-group-label">Visibility</label>
                         <div class="radio-group">
                             <div class="formbuilder-radio">
                                 <input name="visibility"  id="radio_active" value="1" type="radio" checked="checked">
                                 <label for="radio_active">Active</label>
                             </div>
                             <div class="formbuilder-radio">
                                 <input name="visibility"  id="radio-deactive" value="2" type="radio" >
                                 <label for="radio-deactive">Deactive</label>
                             </div>
                         </div>
                     </div>
                     <div class="formbuilder-text form-group field-json_data">
                         <label for="json_data" class="formbuilder-text-label">Json Data</label>
                         <input type="text" placeholder="Enter Json Data" class="form-control" name="json_data" access="false" id="json_data">
                     </div>
                     <div class="formbuilder-text form-group field-other_property">
                         <label for="other_property" class="formbuilder-text-label">Other Property</label>
                         <input type="text" placeholder="Enter Other Property" class="form-control" name="other_property" access="false" id="other_property">
                     </div>

                     <div class="formbuilder-button form-group field-submit">
                        <button type="submit" class="btn-success btn" name="submit" access="false" style="success" id="submit">Submit</button>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php $this->load->view('admin/footer'); ?>
