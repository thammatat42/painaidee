<?php
require_once('../authen.php');

?>
<!DOCTYPE html>
<html lang="en" class="notranslate" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google" content="notranslate" />
    <title>ไปไหนดี</title>

    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/painaidee.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">

</head>
<body class="hold-transition layout-top-nav layout-navbar-fixed">
    <div class="wrapper">
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <!-- <h1 class="m-0"> Space Available Monitoring <small>Version 1.0</small></h1> -->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
                                <li class="breadcrumb-item active">สมัครสมาชิก</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content" style="display: flex; justify-content: center;">
                <div class="register-box" style="width: 500px">
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                        <a href="../../index2.html" class="h1"><b>ไปไหน</b>ดี</a>
                        </div>
                        <div class="card-body">
                            <p class="login-box-msg">&nbsp;คุณลืมรหัสผ่าน? สามารถเปลี่ยนแปลงรหัสผ่านได้ที่นี่!</p>

                            <form action="../../index.html" method="post">
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" placeholder="อีเมลล์">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="input-group mb-3 justify-content-center">
                                    <button type="submit" class="btn btn-warning btn-block" style="width: 100px">ส่ง</button>
                                </div>
                            </form>

                            <!-- Login Online -->
                            <!-- <div class="social-auth-links text-center">
                                <a href="#" class="btn btn-block btn-primary">
                                <i class="fab fa-facebook mr-2"></i>
                                Sign up using Facebook
                                </a>
                                <a href="#" class="btn btn-block btn-danger">
                                <i class="fab fa-google-plus mr-2"></i>
                                Sign up using Google+
                                </a>
                            </div> -->
                        </div>
                        <!-- /.form-box -->
                    </div><!-- /.card -->
                </div>
                
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>
    
    <!-- scripts -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="../../plugins/toastr/toastr.min.js"></script>

    <script>
      $("#overlay").fadeIn(300);

      $("#modal-login").modal({
        show: false,
        backdrop: 'static'
      });

      $(document).on('click', '#close_modal_1', function(){
        location.reload()
          
      });

      $(document).on('click', '#close_modal_2', function(){
        location.reload()
      });

      $(document).on('click', '#btn_login', function(){
        $('#form_login').validate({
          rules: {
            username: {
              required: true,
            },
            password: {
              required: true,
              minlength: 3
            },
          },
          messages: {
            username: {
              required: "กรุณาใส่อีเมลล์",
            },
            password: {
              required: "กรุณาใส่รหัสผ่าน",
              minlength: "รหัสผ่านของคุณไม่ผ่านเงื่อนไขตัวอักษร 3 ตัวขึ้นไป"
            },
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
      });

      $("#overlay").fadeOut(300);
    </script>
</body>
</html>