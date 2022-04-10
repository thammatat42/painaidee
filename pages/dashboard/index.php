<?php
require_once '../../service/connect.php'; 
unset($_SESSION['fullname']);
unset($_SESSION['email']);

if(isset($_GET['travel_search'])) {
  $search = $_GET['travel_search'];
} else {
  $search = '';
}


$stmt = $connect->prepare("SELECT a.*,b.name_th as amphures ,c.name_th as provinces FROM `tb_travel` as a
INNER JOIN amphures as b on a.AMPHURES_ID = b.id
INNER JOIN provinces as c on a.PROVINCE_ID = c.id 
WHERE b.name_th LIKE '%$search%' OR c.name_th LIKE '%$search%' OR TOPIC LIKE '%$search%' AND a.STATUS_CHG = 0");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <?php  include_once('../includes/sidebar.php') ?>
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
                <div class="container text-center"><a class="navbar-brand mx-auto" href="./"><img class="mb-2" src="../../assets/images/logo.svg" alt="" width="140">
                    <p class="text-sm text-uppercase text-gray mb-0">เเนะนำสถานที่ท่องเที่ยว</p></a></div>
              </nav>

              <!-- Destinations -->
              <section class="pt-5">
                <div class="container">
                  <h1>จุดหมายปลายทางสถานที่ท่องเที่ยว</h1>
                  <p class="mb-0">รวมสถานที่ท่องเที่ยวต่างๆที่มีผู้คนเดินทางไปเยี่ยมชมมากที่สุดในเเต่ละจังหวัด</p>
                </div>
                <div class="swiper destinations-slider swiper-padding">
                  <div class="swiper-wrapper">
                      <?php foreach($result as $key => $row) { ?>
                          <div class="swiper-slide h-auto"><a class="destination d-flex align-items-end bg-center bg-cover" href="../post/?pages=<?php echo $row['ID'];?>" style="background: url(../../assets/upload/<?php echo $row['IMG'];?>)">
                              <div class="destination-inner w-100 text-center text-white index-forward has-transition">
                                  <p class="small text-uppercase mb-0"><?php echo $row['TOPIC'];?></p>
                                  <h2 class="h3 mb-4"><?php echo $row['provinces'];?></h2>
                                  <div class="btn btn-primary w-100 destination-btn text-white">เยี่ยมชม</div>
                              </div></a>
                          </div>
                      <?php } ?>
                  </div>
                  <div class="swiper-button-prev swiper-custom-nav text-uppercase letter-spacing-0">
                      <svg class="svg-icon svg-icon me-1">
                      <use xlink:href="#arrow-left-1"> </use>
                      </svg><span class="text-sm">Prev</span>
                  </div>
                  <div class="swiper-button-next swiper-custom-nav text-uppercase letter-spacing-0"><span class="text-sm">Next</span>
                      <svg class="svg-icon svg-icon ms-1">
                      <use xlink:href="#arrow-right-1"> </use>
                      </svg>
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
    </script>
</body>
</html>