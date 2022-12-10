<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Sistem</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= BASEURL.('/public/'); ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= BASEURL.('/public/'); ?>css/adminlte.min.css">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= BASEURL.('/public/img/');?>/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= BASEURL.('/public/img/');?>favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= BASEURL.('/public/img/');?>favicon-16x16.png">
  <link rel="manifest" href="<?= BASEURL.('/public/img/');?>site.webmanifest">
  <script src="<?= BASEURL.('/public/'); ?>plugins/jquery/jquery.min.js"></script>
  <script src="<?= BASEURL.('/public/'); ?>js/dev.js"></script>
  <script src="<?= BASEURL.('/public/'); ?>js/utils.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-green">
    <div class="card-header text-center">
      <center>Point Pelanggaran</center>
    </div>
    <div class="card-body">
      <form id="loginform">
        <div class="input-group mb-3">
          <input id="username" type="text" class="form-control" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
          </div>
          <!-- /.col -->
          <div class="col-6">
            <button type="submit" id="btnlogin" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<script type="text/javascript">
  $(document).ready(function(){
    toastr.options = {
      positionClass: 'toast-top-center'
    };
    var url = '<?= BASEURL.('/api/');?>';
  
    $("#loginform").submit(function(e){
      e.preventDefault();
      var username = $('#username').val();
      var password = $('#password').val();
      var data = { 
        username:username,
        password:password,
        action:'auth'
      };
      var atr = {
        atr:'#btnlogin',
        fh:'Login',
        html:'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
      }
      var urls = url+'auth';
      // data,url,fetch,atr
      loginAjax(data,urls,atr);
    });

  });
</script>
<!-- /.login-box -->

<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="<?= BASEURL.('/public/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= BASEURL.('/public/'); ?>js/adminlte.min.js"></script>
</body>
</html>
