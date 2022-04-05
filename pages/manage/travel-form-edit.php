<?php
require_once('../authen.php'); 

$ID = $_GET['pages'];



$stmt = $connect->prepare("SELECT a.*,b.name_th as amphures ,c.name_th as provinces FROM `tb_travel` as a
INNER JOIN amphures as b on a.AMPHURES_ID = b.id
INNER JOIN provinces as c on a.PROVINCE_ID = c.id 
WHERE a.ID = :ID AND a.STATUS_CHG = 0");
$stmt->bindParam(':ID', $ID);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_OBJ);

if($result) {
    $province_id = $result->PROVINCE_ID;
    $amphures_id = $result->AMPHURES_ID;
    $province = $result->provinces;
    $amphures = $result->amphures;
    $topic = $result->TOPIC;
    $about = $result->ABOUT;
    $detail = $result->DETAIL;
    $IMG = $result->IMG;

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
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.css">
    <link rel="stylesheet" href="../../plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">

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
                                <li class="breadcrumb-item active">จัดการ</a></li>
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
                                            src="../../assets/js/zzcjjxew.json"
                                            trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:50px;height:50px">
                                        </lord-icon>
                                        หน้าจัดการสถานที่ท่องเที่ยว
                                    </h4>

                                </div>
                                <div class="card-body">
                                    <div class="card-header background-color">
                                        <p class="card-title" style="font-size: 1.6rem;"><i class="fas fa-tag"></i>&nbsp;<u>จัดการ</u>ข้อมูลหลังบ้าน</p>
                                    </div></br>

                                    <form id="formDataTravel_Edit" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 px-1 px-md-5">
                                                    <div class="form-group">
                                                        <label for="province_th">จังหวัด</label>
                                                        <select class="form-control select2bs4" name="province" id="province" style="width: 100%;" required>
                                                            <option value="<?php echo $province_id; ?>" selected><?php echo $province; ?></option>
                                                        </select>
                                                        
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="city_th">อำเภอ</label>
                                                        <select class="form-control select2bs4" name="city" id="city" style="width: 100%;" required>
                                                            <option value="<?php echo $amphures_id; ?>" selected><?php echo $amphures; ?></option>
                                                        </select>
                                                        
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="topic_th">หัวข้อเรื่อง</label>
                                                        <input type="text" class="form-control" id="topic" name="topic" placeholder="หัวข้อเรื่อง" value="<?php echo $topic; ?>" required>
                                                        
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="about_th">เกี่ยวกับ</label>
                                                        <input type="text" class="form-control" id="about" name="about" placeholder="ใส่คำอธิบายเกี่ยวกับหัวข้อ" value="<?php echo $about; ?>" required>
                                                        
                                                    </div>

                                                </div>
                                                <div class="col-md-6 px-1 px-md-5">
                                                    <div class="form-group">
                                                        <label for="detail_th">รายละเอียด</label>
                                                        <textarea class="form-control" name="detail" id="detail" rows="5" required><?php echo $detail; ?></textarea>
                                                        
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="customfile">รูป</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="customfile" id="customfile" accept="image/*">
                                                            <input type="hidden" id="namefiles" name="namefiles">
                                                            <label class="custom-file-label" for="customfile" id="file-name">เลือกรูปภาพ</label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="img-fluid" style="width: 25%; height: 25%; overflow: hidden; background: #cccccc; margin: 0 auto" id="edit_img_hidden">
                                                            <img src="../../assets/upload/<?php echo $IMG?>" alt="Image Travel" class="img-fluid p-0" >
                                                        </div>

                                                        <div id="preview" class="img-fluid" style="width: 20%; height: 20%; overflow: hidden; background: #cccccc; margin: 0 auto;" hidden></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit" id="submit">บันทึกข้อมูล</button>
                                        </div>
                                    </form>
                                </div>
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
    <script src="../../plugins/select2/js/select2.full.min.js"></script>

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

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#formDataTravel_Edit').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData();
            var province = $('#province').val();
            var city = $('#city').val();
            var topic = $('#topic').val();
            var about = $('#about').val();
            var detail = $('#detail').val();
            var submit = $('#submit').val();

            /* Attach file */
            formData.append('customfile', $('input[type=file]')[0].files[0]); 
            formData.append('province', province); 
            formData.append('city', city); 
            formData.append('topic', topic);  
            formData.append('about', about); 
            formData.append('detail', detail); 
            formData.append('submit', submit); 

            $.ajax({
                type: "POST",
                url: "../../service/manage/travel-edit-update.php",
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

         /* เเสดงรูปภาพ */
         $('#customfile').on("change", previewImages);

        function previewImages() {
            var $preview = $('#preview').empty();
            if (this.files) $.each(this.files, readAndPreview);


            function readAndPreview(i, file) {
                if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                    return file.name;
                } // else...



                var reader = new FileReader();

                $(reader).on("load", function() {
                    $preview.append($("<img/>", {src:this.result, height:100,width:200}).addClass("img-thumbnail"));
                });
                reader.readAsDataURL(file);
            }

            $("#preview").attr("hidden", false);
            $("#edit_img_hidden").attr("hidden", true);

        }

        $('body').on('change', '#customfile', function (event) {
            // console.log("test");
            $("#file-name").text(this.files[0].name);
            $("#namefiles").val(this.files[0].name);
        });

        $("#overlay").fadeOut(300);
    </script>
</body>
</html>