<?php
require_once('../authen.php'); 

$EMAIL = $_SESSION['email'];

$stmt = $connect->prepare("SELECT * FROM `tb_user` WHERE EMAIL = :EMAIL AND STATUS_CHG = 0");
$stmt->bindParam(':EMAIL', $EMAIL);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_OBJ);

if($result) {
    $IMG = $result->IMG;
    $NAME = $result->NAME;
    $EMAIL = $result->EMAIL;
    $ABOUT_ME = $result->ABOUT_ME;
} else {
    $IMG = 'no_img.jpg';
    $NAME = '';
    $EMAIL = '';
}


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
    <link rel="stylesheet" href="../../assets/css/auto-color.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.css">
    <link rel="stylesheet" href="../../plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">

    <style>
      .profile-pic-wrapper {
        /* height: 100vh; */
        width: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .pic-holder {
        text-align: center;
        position: relative;
        border-radius: 50%;
        width: 150px;
        height: 150px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .pic-holder .pic {
        height: 100%;
        width: 100%;
        -o-object-fit: cover;
        object-fit: cover;
        -o-object-position: center;
        object-position: center;
    }

        .pic-holder .upload-file-block,
        .pic-holder .upload-loader {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(90, 92, 105, 0.7);
        color: #f8f9fc;
        font-size: 12px;
        font-weight: 600;
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        }

        .pic-holder .upload-file-block {
        cursor: pointer;
        }

        .pic-holder:hover .upload-file-block,
        .uploadProfileInput:focus ~ .upload-file-block {
        opacity: 1;
        }

        .pic-holder.uploadInProgress .upload-file-block {
        display: none;
        }

        .pic-holder.uploadInProgress .upload-loader {
        opacity: 1;
        }
        

/* Snackbar css */
.snackbar {
  visibility: hidden;
  min-width: 250px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 14px;
  transform: translateX(-50%);
}

.snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {
    bottom: 0;
    opacity: 0;
  }
  to {
    bottom: 30px;
    opacity: 1;
  }
}

@keyframes fadein {
  from {
    bottom: 0;
    opacity: 0;
  }
  to {
    bottom: 30px;
    opacity: 1;
  }
}

@-webkit-keyframes fadeout {
  from {
    bottom: 30px;
    opacity: 1;
  }
  to {
    bottom: 0;
    opacity: 0;
  }
}

@keyframes fadeout {
  from {
    bottom: 30px;
    opacity: 1;
  }
  to {
    bottom: 0;
    opacity: 0;
  }
}
    </style>

</head>
<body class="hold-transition layout-top-nav layout-navbar-fixed">
    <div class="wrapper">
        <?php  include_once('../includes/sidebar_login.php') ?>
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
                                <li class="breadcrumb-item active">โปรไฟล์</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <lord-icon
                                            src="../../assets/js/dxjqoygy.json"
                                            trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:50px;height:50px">
                                        </lord-icon>
                                        หน้าจัดการโปรไฟล์
                                    </h4>

                                </div>
                                <div class="card-body">
                                    <div class="card-header background-color">
                                        <p class="card-title" style="font-size: 1.6rem;"><i class="fas fa-tag"></i>&nbsp;<u>จัดการ</u>โปรไฟล์</p>
                                    </div></br>

                                    <div class="profile-pic-wrapper">
                                        <div class="pic-holder">
                                            <img id="profilePic" class="mb-3 rounded-circle img-thumbnail shadow-sm pic" src="../../assets/upload/<?php echo $IMG;?>">

                                            <Input class="uploadProfileInput" type="file" name="profile_pic" id="newProfilePhoto" accept="image/*" />
                                            <label for="newProfilePhoto" class="upload-file-block">
                                                <div class="text-center">
                                                    <div class="mb-2">
                                                        <i class="fa fa-camera fa-2x"></i>
                                                    </div>
                                                    <div class="text-uppercase">
                                                        Update <br /> Profile Photo
                                                    </div>
                                                </div>
                                            </label>
                                            
                                        </div>
                                        <h3 class="h4">Profile</h3>
                                        <form id="formProfile" enctype="multipart/form-data">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group text-center">
                                                                <label for="name">ชื่อ</label>
                                                                <input type="text" class="form-control" id="name" value="<?php echo $NAME;?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group text-center">
                                                                <label for="email">อีเมลล์</label>
                                                                <input type="text" class="form-control" id="email" value="<?php echo $EMAIL;?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <div class="form-group text-center">
                                                        <label for="about_me">เเนะนำตัวเอง</label>
                                                        <textarea class="form-control" name="about_me" id="about_me" rows="3" placeholder="เเนะนำตัวเองที่นี่.."><?php echo $ABOUT_ME;?></textarea>
                                                    </div>

                                                    <div class="input-group mb-3 justify-content-center">
                                                        <button type="submit" class="btn btn-success btn-block" name="btn_profile" id="btn_profile" style="width: 100px">Submit</button>

                                                    </div>
                                                </div>
                                                
                                                <p class="text-sm text-muted px-sm-4 text-center">หลังอัพเดทรูปภาพโปรไฟล์เเล้วอย่าลืมกดปุ่ม submit ด้วย..</p>

                                            </div>
                                        </form>
                                        
                                    </div>
                                </div><hr>
                            </div>
                        </div>
                    </div>
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

    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-fixedheader/js/dataTables.fixedHeader.js"></script>
    <script src="../../plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../../plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.js"></script>
    <script src="../../plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js"></script>
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="../../plugins/toastr/toastr.min.js"></script>

    <script>
        $("#overlay").fadeIn(300);

        $(document).on("change", ".uploadProfileInput", function () {
            var triggerInput = this;
            var currentImg = $(this).closest(".pic-holder").find(".pic").attr("src");
            var holder = $(this).closest(".pic-holder");
            var wrapper = $(this).closest(".profile-pic-wrapper");
            $(wrapper).find('[role="alert"]').remove();
            triggerInput.blur();
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) {
                return;
            }
            if (/^image/.test(files[0].type)) {
                // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () {
                    $(holder).addClass("uploadInProgress");
                    $(holder).find(".pic").attr("src", this.result);
                    $(holder).append(
                        '<div class="upload-loader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                    );

                // Dummy timeout; call API or AJAX below
                    setTimeout(() => {
                        $(holder).removeClass("uploadInProgress");
                        $(holder).find(".upload-loader").remove();
                        // If upload successful
                        if (Math.random() < 0.9) {
                            $(wrapper).append(
                                '<div class="snackbar show" role="alert"><i class="fa fa-check-circle text-success"></i> อัพเดทรูปภาพเรียบร้อยเเล้ว..</div>'
                            );

                            // Clear input after upload
                            // $(triggerInput).val("");

                            setTimeout(() => {
                                $(wrapper).find('[role="alert"]').remove();
                            }, 3000);
                        } else {
                            $(holder).find(".pic").attr("src", currentImg);
                            $(wrapper).append(
                                '<div class="snackbar show" role="alert"><i class="fa fa-times-circle text-danger"></i> เกิดบางอย่างผิดปกติ..ไม่สามารถอัพเดทรูปภาพได้!</div>'
                            );

                            // Clear input after upload
                            $(triggerInput).val("");
                            setTimeout(() => {
                                $(wrapper).find('[role="alert"]').remove();
                            }, 3000);
                        }
                    }, 1500);
                };
            } else {
                $(wrapper).append(
                    '<div class="alert alert-danger d-inline-block p-2 small" role="alert">Please choose the valid image.</div>'
                );
                setTimeout(() => {
                    $(wrapper).find('role="alert"').remove();
                }, 3000);
            }
        });

        $('#formProfile').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData();
            var name = $('#name').val();
            var email = $('#email').val();
            var about_me = $('#about_me').val();
            var btn_profile = $('#btn_profile').val();

            /* Attach file */
            formData.append('newProfilePhoto', $('input[type=file]')[0].files[0]); 
            formData.append('name', name); 
            formData.append('email', email); 
            formData.append('about_me', about_me);  
            formData.append('btn_profile', btn_profile); 

            $.ajax({
                type: "POST",
                url: "../../service/manage/profile-update.php",
                data: formData,
                contentType: false,
                processData: false
            }).done(function(resp) {
                Swal.fire({
                    text: resp.message,
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                    backdrop: `
                        rgba(0,0,123,0.4)
                        url("../../assets/images/nyan-cat.gif")
                        left top
                        no-repeat
                    `
                }).then((result) => {
                    location.reload()
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