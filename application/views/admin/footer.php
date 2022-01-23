

<!-- Main Footer -->
<footer class="main-footer">

  <!-- Default to the left -->
  <strong>Copyright &copy; 2014-2022 <a href="https://appsfeature.com">Appsfeature</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url()?>public/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>public/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>public/admin/plugins/toast/build/toastr.min.js"></script>

<script type="text/javascript">

  function showToast(isSuccess, message)  {
    // toastr.options = {
    //   "closeButton": true,
    //   "newestOnTop": false,
    //   "positionClass": "toast-top-right",
    //   "preventDuplicates": false,
    //   "onclick": null,
    //   "showDuration": "300",
    //   "hideDuration": "1000",
    //   "timeOut": "1000",
    //   "extendedTimeOut": "1000",
    //   "showEasing": "swing",
    //   "hideEasing": "linear",
    //   "showMethod": "fadeIn",
    //   "hideMethod": "fadeOut"
    // }
    if(isSuccess) {
        toastr["success"](message, "Success");
    } else {
        toastr["error"](message, "Error");
    }
  }
</script>
</body>
</html>
