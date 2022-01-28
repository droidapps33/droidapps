# DroidApps Backend

This is a developed community where you will find several interesting blog articles with short and cool codes. It contains Laravel 8, CodeIgniter 4, MySQL, WordPress, Node Js etc. Please visit once and see the power of learning from this blog.




API Base Url: `http://yourdomain.com/droidapps/api/v1/database/`

- GET: get-apps

        return all apps list.

## Category API's methods

- POST: insert-category, insert-update-category

        Params : pkg_id, sub_cat_id, cat_name, cat_type, image, order_id, visibility
                 , json_data, other_property

        Where  : pkg_id, cat_name, sub_cat_id

- POST: update-category

        Params : pkg_id, cat_id, sub_cat_id, cat_name, cat_type, image, order_id, visibility
                 ,json_data, other_property

        Where  : pkg_id, cat_id, sub_cat_id

- POST: delete-category

        Params & Where : pkg_id, cat_id, sub_cat_id

- GET: get-category

        Params & Where : pkg_id, cat_id, sub_cat_id



## Content API's methods

- POST: insert-content, insert-update-content

        Params : pkg_id, cat_id, sub_cat_id, title, description, image, link, visibility
                 , json_data, other_property

        Where  : pkg_id, cat_id, sub_cat_id

- POST: update-content

        Params : pkg_id, id, cat_id, sub_cat_id, title, description, image, link, visibility
                 , json_data, other_property

        Where  : pkg_id, id, cat_id, sub_cat_id

- POST: delete-content

        Params & Where : pkg_id, id, cat_id, sub_cat_id

- GET: get-content

        Params & Where : pkg_id, id, cat_id, sub_cat_id

- GET: get-content-by-category

        Params & Where : pkg_id, id, cat_id, sub_cat_id



## Data API's methods

- POST: insert-data, insert-update-data

        Params & Where : pkg_id, cat_id, json_data

- POST: update-data

        Params & Where : pkg_id, cat_id, json_data

- POST: delete-data

        Params & Where : pkg_id, cat_id

- GET: get-data

        Params & Where : pkg_id, cat_id



## ScreenShots

## Table Category

<p align="center">
  <img src="https://raw.githubusercontent.com/appsfeature/droidapps/master/screenshots/tableCategory.png" alt="Preview 1" width="600" />
</p>

## Table Content

<p align="center">
  <img src="https://raw.githubusercontent.com/appsfeature/droidapps/master/screenshots/tableContent.png" alt="Preview 1" width="600" />
</p>

## Views configuration

### Step 1:Set base url in views file for css, script and image path.
application\views\admin\login.php
```php

<?php echo base_url()?>public/admin/
-Or-
<?php echo base_url().'admin/login/authenticate' ?>
For Example:
<script src="<?php echo base_url()?>public/admin/plugins/jquery/jquery.min.js"></script>

```

### Step 2:Call Php method from view
application\views\admin\login.php
```html
<div class="card">
      <form action="<?php echo base_url().'admin/login/authenticate' ?>" name="loginForm" id="loginForm" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" id="username" class="form-control" placeholder="Username">
          ...
        </div>
        <?php echo form_error('username'); ?>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          ...
        </div>
        <?php echo form_error('password'); ?>
        <div class="row">
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
        </div>
      </form>
  </div>

```

### Step 3:PHP receiving data using post method
application\controllers\admin\Login.php
```php
public function authenticate(){
  $this->form_validation->set_rules("username", "Username", "trim|required");
  $this->form_validation->set_rules("password", "Password", "trim|required");

  if($this->form_validation->run() === TRUE){
     $username = $this->input->post('username');
     $password = $this->input->post('password');
     $account = $this->Admin_model->getByUsername($username);
     if(!empty($account)){
         // if(password_verify($password, $account['password']) == true){
         if($password == $account['password']){
           $adminArray['admin_id'] = $account['id'];
           $adminArray['username'] = $account['user_id'];
           $this->session->set_userdata('admin', $adminArray);
           redirect(base_url().'admin/home/index');
         }else{
           $this->session->set_flashdata('msg','Either username or password is incorrect');
           redirect(base_url().'admin/login/index');
         }
     }else {
       $this->session->set_flashdata('msg','Either username or password is incorrect');
       redirect(base_url().'admin/login/index');
     }
  }else{
    $this->load->view('admin/login');
  }
}
```

### Step 3:PHP receiving data using post method
application\controllers\admin\Login.php

```html

<input type="hidden" name="pkg_id" access="false" id="pkg_id" value="<?php echo isset($_SESSION['admin']['pkg_id'])?$_SESSION['admin']['pkg_id']:''; ?>">

```
```ajax

<script type="text/javascript">
$(document).ready(function() {
    $("#categoryForm").submit(function(e) {
        e.preventDefault();
        $("#submitBtn").prop("disabled", true);
        var formData = $('#categoryForm').serialize();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'api/v1/database/insert_category' ?>",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function(data) {
            var successURL = "<?php echo base_url().'admin/category' ?>";
            notify(data, successURL);
        });
    });
});
</script>

```

```html
// call javascript method
<a href="javascript:void(0);" onclick="deleteCategory()" class="btn btn-danger btn-sm">
  <i class="far fa-trash-alt"></i> Delete
</a>

//define javascript method
<script type="text/javascript">
    function deleteCategory(id) {
        if(confirm("Are you sure you want to delete category?")){
            window.locotion.href='<?php echo base_url().'admin/category/delete/'; ?>' + id;
        }
    }
</script>
```
### Call controller method from View
```html
<!DOCTYPE html>
//define at the top of screen
<?php $CI =& get_instance(); ?>

//call controller method in anywhere in html page
<?php if($CI->callHelperFunctionByName('Categories') == true) {?>
     <div class="treeview">

     </div>
 <?php } ?>
```

### Call helper method from View
```php
//load helper in constructor.
class Home extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->helper("your_helper_class");
  }
}
```
```html
<!DOCTYPE html>
//call controller method in anywhere in html page
<?php if(callHelperFunctionByName('Categories') == true) {?>
     <div class="treeview">

     </div>
 <?php } ?>
```


## CodeIgniter Documentation

- [https://www.codeigniter.com/userguide3/database/query_builder.html](https://www.codeigniter.com/userguide3/database/query_builder.html)
