<?php 
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $data['title']; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= BASEURL.('/public/'); ?>plugins/fontawesome-free/css/all.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= BASEURL.('/public/'); ?>css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= BASEURL.('/public/'); ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?= BASEURL.('/public/'); ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= BASEURL.('/public/'); ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="<?= BASEURL.('/public/'); ?>plugins/jquery/jquery.min.js"></script>
  <script src="<?= BASEURL.('/public/'); ?>js/dev.js"></script>
  <script src="<?= BASEURL.('/public/'); ?>js/utils.js"></script>
  <script src="<?= BASEURL.('/public/'); ?>js/aes.js" type="text/javascript"></script>
  
  <link rel="stylesheet" href="<?= BASEURL.('/public/'); ?>plugins/daterangepicker/daterangepicker.css">
  <link  rel="stylesheet" href="<?= BASEURL.('/public/'); ?>plugins/toastr/toastr.css">
  <script src="<?= BASEURL.('/public/'); ?>plugins/toastr/toastr.min.js"></script>
  <link rel="apple-touch-icon" sizes="180x180" href="<?= BASEURL.('/public/img/');?>/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= BASEURL.('/public/img/');?>favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= BASEURL.('/public/img/');?>favicon-16x16.png">
  <link rel="manifest" href="<?= BASEURL.('/public/img/');?>site.webmanifest">
  <link href="<?= BASEURL.('/public/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="<?= BASEURL.('/public/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= BASEURL.('/public/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Select2 -->
  <script src="<?= BASEURL.('/public/'); ?>plugins/select2/js/select2.full.min.js"></script>
  
  
  <!-- summernote -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= BASEURL.('/public/'); ?>img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= BASEURL.('/panel'); ?>" class="brand-link">
      
      <span class="brand-text font-weight-light">E-Point Siswa</span>
    </a>
    <?php
    // var_dump($_SESSION);
         require_once 'app/views/'.$data['menu'].'.php';
    ?>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      	<?php
         require_once 'app/views/'.$data['content'].'.php';
         
    	   ?>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y'); ?></strong>
    All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script type="text/javascript">
  var menu = '<?= $data['menu-active'];?>';
  var open = '<?= $data['menu-open']; ?>';
  if (open === '1') {
    var parent = '<?= $data['parent']; ?>';
    $(menu).addClass('active');
    $(parent).addClass('menu-open');  
  }else if (open === '2') {
    $(menu).addClass('active');
  }
  
</script>
<script src="<?= BASEURL.('/public/'); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= BASEURL.('/public/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASEURL.('/public/'); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?= BASEURL.('/public/'); ?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?= BASEURL.('/public/'); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= BASEURL.('/public/'); ?>js/adminlte.js"></script>
<script src="<?= BASEURL.('/public/'); ?>js/demo.js"></script>
<!-- <script src="<?= BASEURL.('/public/'); ?>plugins/datatables/jquery.dataTables.min.js"></script> -->
</body>
</html>
