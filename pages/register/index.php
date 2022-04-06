<?php
require_once('../../service/connect.php');


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
                        <a href="#" class="h1"><b>ไปไหน</b>ดี</a>
                        </div>
                        <div class="card-body">
                            <p class="login-box-msg"><i class="fas fa-user-plus"></i>&nbsp;สร้างบัญชีของคุณได้เลย ฟรีนะ!</p>

                            <form id="form_Register" enctype="multipart/form-data">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="ชื่อ" value="<?php if(isset($_SESSION['fullname'])) { echo $_SESSION['fullname']; unset($_SESSION['fullname']); }?>" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user"></span>
                                            </div>
                                        </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="อีเมลล์" value="<?php if(isset($_SESSION['email'])) { echo $_SESSION['email']; unset($_SESSION['email']); }?>" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="รหัสผ่าน" minlength="8" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="ยืนยันรหัสผ่าน" minlength="8" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3" style="margin-top: -15px;">
                                    <small style="color: gray;">&nbsp;&nbsp;อย่างน้อย 8 ตัว</small>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="agreeTerms" name="agreeTerms" value="1" required>
                                            <label for="agreeTerms">
                                                ฉันได้ยอมรับข้อกำหนดเเละ <a href="#">เงื่อนไขทั้งหมด</a>
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="input-group mb-3 justify-content-center">
                                    <button type="submit" class="btn btn-success btn-block" name="btn_register" id="btn_register" style="width: 100px">สมัครสมาชิก</button>
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
              minlength: 8
            },
          },
          messages: {
            username: {
              required: "กรุณาใส่อีเมลล์",
            },
            password: {
              required: "กรุณาใส่รหัสผ่าน",
              minlength: "รหัสผ่านของคุณไม่ผ่านเงื่อนไขตัวอักษร 8 ตัวขึ้นไป"
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

    $("#form_Register").submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../../service/api/register.php",
            data: $(this).serialize(),
        }).done(function(resp) {
            Swal.fire({
                text: resp.message,
                icon: 'success',
                confirmButtonText: 'ตกลง',
            }).then((result) => {
                location.href = '../dashboard/'
            })
        }).fail(function(resp) {
            const check_log = jQuery.parseJSON( resp.responseText );
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด..',
                text: check_log.message,
                footer: 'กรุณาตรวจสอบใหม่อีกครั้ง!!'
            }).then((result) => {
                location.reload()
            })
        })
    });

    $("#form_login").submit(function(e){
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "../../service/auth/login.php",
            data: $(this).serialize(),
        }).done(function(resp) {
            Swal.fire({
                text: resp.message,
                icon: 'success',
                confirmButtonText: 'ตกลง',
            }).then((result) => {
                location.href = '../../pages/index.php'
            })
        }).fail(function(resp) {
            const check_log = jQuery.parseJSON( resp.responseText );
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด..',
                text: check_log.message,
                footer: 'กรุณาตรวจสอบใหม่อีกครั้ง!!'
            }).then((result) => {
                location.reload()
            })
        })
    });

    $("#overlay").fadeOut(300);
    </script>
</body>
</html>