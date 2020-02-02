<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo base_url(); ?>assets/index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"></p>

    <?php echo $form_open; ?>
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <div id="msg_username"></div>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <div id="msg_password"></div>
        <div id="msg_error"></div>
        <div id="hilang">
                  <?php
                  $message = $this->session->flashdata('msg');
                  echo $message == '' ? '' : '<p id="message">' . $message . '</p>';
                  ?>
        </div>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close(); ?>
  </div>
  <!-- /.login-box-body -->
   <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="title_modal">SELECT GROUP LOGIN</h4>
          </div>
          <div class="modal-body">
            <div id="detail"></div>
          </div>
         
        </div>
      </div>
    </div>
</div>
<!-- /.login-box -->
<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });

    $('#form').submit(function(event){
        event.preventDefault();
        var me = $(this);
        var formData = new FormData($(this)[0]);
        $.ajax({
          url: me.attr('action'),
          type:'POST',
          data: formData,
          dataType: 'JSON',
           async: false,
          cache: false,
          contentType: false,
          processData: false,
          success:function(result){
            if (result['st'] == 0) {
                $('#msg_username').html(result.username);
                $('#msg_password').html(result.password); 
                 $('#msg_error').html('');
                 $('#hilang').remove();
            } 
            else if (result['st'] == 1) {
             window.location.replace("<?php echo site_url('main')?>");
            }   
            else if (result['st'] == 2) {
                $('#msg_error').html(result.error);
                $('#msg_username').html(''); 
                $('#msg_password').html(''); 
                $('#hilang').remove();
            }
            else if (result['st'] == 3) {
               id = result.id;
               urls = "<?php echo site_url($this->router->fetch_class()); ?>/check_role/";
                
                 $.ajax({
                    url: urls,
                    type: 'POST',
                    data : {
                      id : id
                    },
                    success: function(res) {
                        $("#myModal").modal({backdrop: 'static', keyboard: false});
                        $("#detail").html(res);
                    }
                });

            } else  {
                alert(result);  
            }
          }
      });
    });
  });
</script>
</body>
</html>