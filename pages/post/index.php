<?php
require_once '../../service/connect.php';

if(isset($_GET['travel_search'])) {
    $search = $_GET['travel_search'];
  } else {
    $search = '';
  }

if(isset($_GET['pages'])) {
    $ID = $_GET['pages'];
} else {
    $ID = '';
}

$stmt = $connect->prepare("SELECT * FROM tb_travel WHERE ID = :ID AND STATUS_CHG = 0");
$stmt->bindParam(':ID', $ID);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_OBJ);

if($result) {
    $TOPIC = $result->TOPIC;
    $ABOUT = $result->ABOUT;
    $DETAIL = $result->DETAIL;
    $IMG = $result->IMG;
    $EMAIL = $result->CREATE_BY;
}

$stmt_user = $connect->prepare("SELECT NAME, IMG, DATE_FORMAT(CREATE_DATE, '%W %D %M, %Y') AS CREATE_DATE,ABOUT_ME FROM tb_user WHERE EMAIL = :EMAIL AND STATUS_CHG = 0");
$stmt_user->bindParam(':EMAIL', $EMAIL);
$stmt_user->execute();
$result_user = $stmt_user->fetch(PDO::FETCH_OBJ);

if($result_user) {
    $NAME = $result_user->NAME;
    $IMG_USER = $result_user->IMG;
    $CREATE_DATE = $result_user->CREATE_DATE;
    $ABOUT_ME = $result_user->ABOUT_ME;
}

$stmt_comment = $connect->prepare("SELECT NAME, IMG, MESSAGE, DATE_FORMAT(COMMENT_DATE, '%d %M %Y') COMMENT_DATE FROM tb_comment WHERE STATUS_CHG = 0");
$stmt_comment->execute();
$result_comment = $stmt_comment->fetchAll(PDO::FETCH_ASSOC);

$stmt_lastest = $connect->prepare("SELECT ID,TOPIC,IMG, ABOUT,DATE_FORMAT(CREATE_DATE, '%d %M %Y') CREATE_DATE FROM `tb_travel` WHERE STATUS_CHG = 0 AND ID <> :ID ORDER BY CREATE_DATE ASC LIMIT 3");
$stmt_lastest->bindParam(':ID', $ID);
$stmt_lastest->execute();
$result_lastest = $stmt_lastest->fetchAll(PDO::FETCH_ASSOC);

$stmt_img = $connect->prepare("SELECT IMG FROM `tb_travel` WHERE STATUS_CHG = 0 ORDER BY CREATE_DATE ASC LIMIT 8");
$stmt_img->execute();
$result_img = $stmt_img->fetchAll(PDO::FETCH_ASSOC);




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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300,400&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abril+Fatface&amp;display=swap">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.css">
    <link rel="stylesheet" href="../../plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">

    <link rel="stylesheet" href="../../assets/css/style.default.css" id="theme-stylesheet">

    <!-- Swiper slider-->
    <link rel="stylesheet" href="../../assets/vendor/swiper/swiper-bundle.min.css">
    <!-- Owl Carousel -->
    <!-- <link rel="stylesheet" href="../../vendor/owl.carousel2/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../../vendor/owl.carousel2/assets/owl.theme.default.min.css"> -->

</head>
<body class="hold-transition layout-top-nav layout-navbar-fixed">
    <div class="wrapper">
        <?php  
            if(isset($_SESSION['email'])) {
                include_once('../includes/sidebar_login.php');
            } else {
                include_once('../includes/sidebar.php');
            }
        ?>
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
                                <li class="breadcrumb-item active">หน้าหลัก</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
              <nav class="navbar navbar-expand-lg navbar-light bg-white py-4">
                <div class="container text-center"><a class="navbar-brand mx-auto" href="./"><img class="mb-2" src="../../assets/images/logo.svg" alt="Logo Images" width="140">
                    <p class="text-sm text-uppercase text-gray mb-0">เเนะนำสถานที่ท่องเที่ยว</p></a></div>
              </nav>

                <!-- Destinations -->
                <section class="py-5">
                    <div class="container text-center">
                        <p class="h6 mb-0 text-uppercase text-primary">Lifestyle</p>
                        <h1><?php echo $TOPIC; ?></h1>
                        <p class="mb-3"><?php echo $ABOUT; ?></p>
                        <ul class="list-inline small text-uppercase mb-0">
                        <li class="list-inline-item align-middle"><img class="rounded-circle shadow-sm" src="../../assets/upload/<?php echo $IMG_USER; ?>" alt="Profile Images" width="40"/></li>
                        <li class="list-inline-item me-0 text-muted align-middle">By </li>
                        <li class="list-inline-item align-middle me-0"><a class="fw-bold reset-anchor" href="#"><?php echo $NAME; ?></a></li>
                        <li class="list-inline-item text-muted align-middle me-0">|</li>
                        <li class="list-inline-item text-muted align-middle me-0"><?php echo $CREATE_DATE; ?></li>
                        <!-- <li class="list-inline-item text-muted align-middle me-0">|</li> -->
                        <!-- <li class="list-inline-item text-muted align-middle">20 Comments</li> -->
                        </ul>
                    </div><img class="py-5 text-center" style="width: 100%; height: 750px;" src="../../assets/upload/<?php echo $IMG; ?>" alt="Banner Image">
                    <div class="container">
                        <div class="row gy-5">
                        <div class="col-lg-8">
                            <p class="lead first-letter-styled lh-4"><?php echo $DETAIL; ?></p>
                            <div class="px-lg-5 mb-5">
                                <blockquote class="blockquote-custom">ถ้าชอบอย่าลืมกด Like เเละ Comment ไว้กันด้วยยน่าา..</blockquote>
                            </div>
                            
                            <h3 class="h4 mb-4">Leave a comment</h3>
                            <form class="mb-5" id="formComment" enctype="multipart/form-data">
                                <div class="row gy-3">
                                    <?php if(isset($_SESSION['email'])) { ?>
                                    <div class="col-lg-6">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="กรุณาใส่ชื่อ เช่น อาทิตย์ ส่องสวน" value="<?php if($_SESSION['name']) {echo $_SESSION['name']; } ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <input class="form-control" type="email" name="email" id="email" placeholder="กรุณาใส่อีเมลล์ เช่น Arthit@email.com" value="<?php if($_SESSION['email']) {echo $_SESSION['email']; } ?>">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea class="form-control" name="message" rows="5" id="message" placeholder="สามารถทิ้งความไว้ได้น่า.."></textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <button class="btn btn-dark" type="submit">Submit your comment</button>
                                    </div>
                                    <?php } else { ?>
                                    <div class="col-lg-6">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="กรุณาใส่ชื่อ เช่น อาทิตย์ ส่องสวน">
                                    </div>
                                    <div class="col-lg-6">
                                        <input class="form-control" type="email" name="email" id="email" placeholder="กรุณาใส่อีเมลล์ เช่น Arthit@email.com">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea class="form-control" name="message" rows="5" id="message" placeholder="สามารถทิ้งความไว้ได้น่า.."></textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <button class="btn btn-dark" type="submit" name="btn_message" id="btn_message">Submit your comment</button>
                                    </div>
                                    <?php } ?>
                                    <input type="hidden" name="email_hidden" id="email_hidden" value="<?php echo $EMAIL; ?>">
                                </div>
                            </form>
                            <h3 class="h4 mb-4 d-flex align-items-center"><span>Comments</span></h3>
                            <ul class="list-unstyled comments">
                                <!-- <li>
                                        <div class="d-flex mb-4">
                                        <div class="pe-2 flex-grow-1" style="width: 75px; min-width: 75px;"><img class="rounded-circle shadow-sm img-fluid img-thumbnail" src="../../assets/images/person-1.jpg" alt=""/></div>
                                            <div class="ps-2">
                                                <p class="small mb-0 text-primary">15 Aug 2019</p>
                                                <h5>Jimmy Roy</h5>
                                                <p class="text-muted text-sm mb-2">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At.</p><a class="reset-anchor text-sm" href="#"><i class="fas fa-share me-2 text-primary"></i><strong>Reply</strong></a>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li> 
                                                <div class="d-flex mb-4">
                                                    <div class="pe-2 flex-grow-1" style="width: 75px; min-width: 75px;"><img class="rounded-circle shadow-sm img-fluid img-thumbnail" src="../../assets/images/person-2.jpg" alt=""/></div>
                                                        <div class="ps-2">
                                                            <p class="small mb-0 text-primary">19 Sep 2019</p>
                                                            <h5>Melissa Johanson</h5>
                                                            <p class="text-muted text-sm mb-2">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At.</p><a class="reset-anchor text-sm" href="#"><i class="fas fa-share me-2 text-primary"></i><strong>Reply</strong></a>
                                                        </div>
                                                    </div>
                                            </li>
                                        </ul>
                                </li> -->
                                <?php foreach($result_comment as $key_commet => $row_comment) { ?>
                                <li>
                                    <div class="d-flex mb-4">
                                    <div class="pe-2" style="width: 75px; min-width: 75px;"><img class="rounded-circle shadow-sm img-fluid img-thumbnail" src="../../assets/upload/<?php echo $row_comment['IMG']; ?>" alt="Image Profile"/></div>
                                        <div class="ps-2">
                                            <p class="small mb-0 text-primary"><?php echo $row_comment['COMMENT_DATE']; ?></p>
                                            <h5><?php echo $row_comment['NAME']; ?></h5>
                                            <p class="text-muted text-sm mb-2"><?php echo $row_comment['MESSAGE']; ?></p><a class="reset-anchor text-sm" href="#"><i class="fas fa-share me-2 text-primary"></i><strong>Reply</strong></a>
                                        </div>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <!-- About me widget -->
                            <div class="mb-5 text-center"><img class="mb-3 rounded-circle img-thumbnail shadow-sm" src="../../assets/upload/<?php echo $IMG_USER; ?>" alt="Profile Images" width="110">
                            <h3 class="h4">About me</h3>
                            <p class="text-sm text-muted px-sm-4"><?php echo $ABOUT_ME;?></p>
                            <ul class="list-inline text-sm mb-0">
                                <li class="list-inline-item"><a class="reset-anchor" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <!-- <li class="list-inline-item"><a class="reset-anchor" href="#"><i class="fab fa-twitter"></i></a></li> -->
                                <li class="list-inline-item"><a class="reset-anchor" href="#"><i class="fab fa-instagram"></i></a></li>
                                <li class="list-inline-item"><a class="reset-anchor" href="#"><i class="fab fa-youtube"></i></a></li>
                                <!-- <li class="list-inline-item"><a class="reset-anchor" href="#"><i class="fab fa-vimeo-v"></i></a></li> -->
                            </ul>
                            </div>
                            <!-- Latest posts widget -->
                            <div class="mb-5">
                            <h3 class="h5">Latest posts</h3>
                            <p class="text-sm text-muted mb-4">สามารถดูเเต่ละโพสใหม่ล่าสุดได้ที่นี่เลย..</p>
                            <ul class="list-unstyled">
                                <?php foreach($result_lastest as $key_lastest => $row_lastest) { ?>
                                    <li class="d-flex mb-1"><a href="../post/index.php?pages=<?php echo $row_lastest['ID'];?>"><img src="../../assets/upload/<?php echo $row_lastest['IMG'];?>" alt="Travel Images" width="80"></a>
                                        <div class="media-body ms-3">
                                            <p class="small text-primary text-uppercase mb-0"><?php echo $row_lastest['CREATE_DATE'];?></p>
                                            <h6 class="mb-1"><a class="reset-anchor" href="../post/index.php?pages=<?php echo $row_lastest['ID'];?>"><?php echo $row_lastest['TOPIC'];?></a></h6>
                                            <p class="small text-muted"><?php echo $row_lastest['ABOUT'];?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                            </div>
                            <!-- Instagram widget -->
                            <!-- <div class="mb-5">
                                <h3 class="h5">Follow on Instagram</h3>
                                <p class="text-sm text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</p>
                                <div class="row gx-0">
                                    <?php foreach($result_img as $key_img => $row_img) { ?>
                                        <div class="col-3"><a class="instagram-item overlay-hover-dark-sm d-block w-100" href="#">
                                            <div class="overlay-content"><img class="img-fluid" src="../../assets/upload/<?php echo $row_img['IMG'];?>" alt="Travel Images"></div></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div> -->
                        </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>
    
    <!-- scripts -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
    <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../../assets/js/front.js"></script>

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

      $('#formComment').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData();
        var name = $('#name').val();
        var email = $('#email').val();
        var message = $('#message').val();
        var email_hidden = $('#email_hidden').val();
        var btn_message = $('#btn_message').val();

        formData.append('name', name); 
        formData.append('email', email); 
        formData.append('message', message);   
        formData.append('email_hidden', email_hidden);   
        formData.append('btn_message', btn_message); 

        $.ajax({
            type: "POST",
            url: "../../service/api/comment.php",
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
                location.reload();
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

      

      function injectSvgSprite(path) {
      
        var ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function(e) {
        var div = document.createElement("div");
        div.className = 'd-none';
        div.innerHTML = ajax.responseText;
        document.body.insertBefore(div, document.body.childNodes[0]);
        }
      }

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

      injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg'); 
    </script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>
</html>