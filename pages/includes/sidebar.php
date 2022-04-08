<?php 
    function isActive ($data) {
        $array = explode('/', $_SERVER['REQUEST_URI']);
        $key = array_search("pages", $array);
        $name = $array[$key + 1];
        return $name === $data ? 'active' : '' ;
    }
    // echo '<pre>';
    // print_r($_SESSION);
    // die();
?>

<style>
  .led {
      animation-name: backgroundColorPalette;
      animation-duration: 5s;
      animation-iteration-count: infinite;
      animation-direction: alternate;
      animation-timing-function: linear;
  }

  @keyframes backgroundColorPalette {
      0% {
          color: #ee6055;
      }
      25% {
          color: #60d394;
      }
      50% {
          color: #aaf683;
      }
      75% {
          color: #ffd97d;
      }
      100% {
          color: #ff9b85;
      }
  }

  #overlay{	
      position: fixed;
      top: 0;
      z-index: 2500;
      width: 100%;
      height:100%;
      display: none;
      background: rgba(0,0,0,0.6);
  }
  .cv-spinner {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;  
  }
  .spinner {
      width: 40px;
      height: 40px;
      border: 4px #ddd solid;
      border-top: 4px #2e93e6 solid;
      border-radius: 50%;
      animation: sp-anime 0.8s infinite linear;
  }
  @keyframes sp-anime {
      100% { 
      transform: rotate(360deg); 
      }
  }
  .is-hide{
      display:none;
  }


    /* .container {
    width: 100%;
    height: 100%;
    display: flex;
    position: fixed;
    top: 0;
    left: 0;
    justify-content: center;
    align-items: center;
    background-color: #000;
    overflow: auto;
  } */
  span2 {
    /* font-size: 1.5vw; */
    line-height: 1.05em;
    text-transform: uppercase;
    color: transparent;
    letter-spacing: 0.5vw;
    margin: 0;
    background: linear-gradient(124deg, #c53d3d 19%, #000 19%, #000 20%, #56b337 20%, #56b337 39%, #000 39%, #000 40%, #3a47d3 40%, #3a47d3 59%, #000 59%, #000 60%, #7831F5 60%, #7831F5 79%, #000 79%, #000 80%, #c318be 80%, #c318be 100%);
    -webkit-background-clip: text;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 100% 100%;
    transition: all 0.5s;
  }

  img {
    margin-top: -0.8rem !important;
  }


  .btn {
    border-radius: 2rem;
  }

  input[type="search"] {
    border: none;
    background: transparent;
    margin: 0;
    padding: 7px 8px;
    font-size: 14px;
    color: inherit;
    border: 1px solid transparent;
    border-radius: inherit;
  }

  input[type="search"]::placeholder {
    color: #bbb;
  }

  /* button[type="submit"] {
    text-indent: -999px;
    overflow: hidden;
    width: 40px;
    padding: 0;
    margin: 0;
    border: 1px solid transparent;
    border-radius: inherit;
    background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat center;
    cursor: pointer;
    opacity: 0.7;
  } */

  button[type="submit"]:hover {
    opacity: 1;
  }

  button[type="submit"]:focus,
  input[type="search"]:focus {
    box-shadow: 0 0 3px 0 #1183d6;
    border-color: #1183d6;
    outline: none;
  }

  form.nosubmit {
  border: none;
  padding: 0;
  }

  input.nosubmit {
    width: 100%;
    padding: 9px 4px 9px 40px;
    background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 13px center;
  }
 
</style>

<!-- Modal Login -->
<form id="form_login">
  <div class="modal fade" id="modal-login">
      <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="text-glow" class="modal-title"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_modal_1">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="card-body">
                  <div class="form-group col-sm-12">
                    <div class="alert alert-danger" role="alert" id="alert" hidden>
                      *ไม่สามารถเข้าสู่ระบบได้: รหัสผ่านหมดอายุ
                    </div>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text px-3"><i class="fas fa-user"></i></div>
                      </div>
                      <input type="text" class="form-control" name="username" placeholder="อีเมลล์">
                    </div>
                  </div>
                  <div class="form-group col-sm-12">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text px-3"><i class="fas fa-lock"></i></div>
                      </div>
                      <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน">
                    </div>
                  </div>
                  <!-- <div class="form-group"> -->
                    <!-- <div class="row"> -->
                      <!-- <div class="col-md-8 col-mb-4"> -->
                      <div class="d-flex justify-content-between">
                        <div class="icheck-primary">
                          <input type="checkbox" name="remember" id="remember" value="<?php if(isset($_COOKIE["remember"])) { echo $_COOKIE["remember"]; } ?>">
                          <label for="remember">
                            ให้ฉันอยู่ในระบบเสมอ
                          </label>
                          
                        </div>
                        <p>
                          <a style="color: #909090;" href="../recover/" >ลืมรหัสผ่านไหม?</a>
                          /
                          <a style="color: #909090;" href="../register/" >สมัครสมาชิก</a>
                        </p>
                      </div>
                      <!-- <div class="col-md-4 col-mb-2">
                        <a href="recover.php" style="color: red">Change Password</a>
                      </div> -->
                    <!-- </div> -->
                  <!-- </div> -->
              </div>
              
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" id="close_modal_2">ยกเลิก</button>
                  <button type="submit" class="btn btn-success" name="btn_login" id="btn_login">เข้าสู่ระบบ</button>
              </div>
          </div>
      </div>
  </div>
</form>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="../dashboard/" class="navbar-brand">
        <img src="../../assets/images/painaidee2.png" alt="Location Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span2 class="brand-text font-weight-light">ไปไหนดี</span2>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- SEARCH FORM -->
        <!-- <form class="form-inline ml-0 ml-md-3">
          <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="ค้นหาข้อมูลที่นี่..">
          </div>
        </form> -->
        <form class="nosubmit">
          <input class="nosubmit" type="search" name="travel_search" id="travel_search" placeholder="ค้นหาข้อมูลที่นี่..">

          <?php if(isset($_GET['pages'])) {?>
            <input type="hidden" name="pages" value="<?php if(isset($_GET['pages'])) { echo $_GET['pages']; }?>">
          <?php } ?>
        </form>

        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <!-- <a href="./" class="nav-link">จัดการ</a> -->
          </li>
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="#" class="dropdown-item">Some action </a></li>
              <li><a href="#" class="dropdown-item">Some other action</a></li>

              <li class="dropdown-divider"></li>

              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                  </li>

                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                    </ul>
                  </li>

                  <li><a href="#" class="dropdown-item">level 2</a></li>
                  <li><a href="#" class="dropdown-item">level 2</a></li>
                </ul>
              </li>
            </ul>
          </li> -->
        </ul>
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

          
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" data-toggle="modal" data-target="#modal-login">
              <i class="far fa-user"></i>
              เข้าสู่ระบบ
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../register/" role="button">
              <i class="fas fa-user-plus"></i>
              สมัครสมาชิก
            </a>
          </li>
          
        </ul>
      </div>

      <!-- Right navbar links -->
      <!-- <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto"> -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" data-toggle="modal" data-target="#modal-login">
            <i class="far fa-user"></i>
            เข้าสู่ระบบ
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-user-plus"></i>
            สมัครสมาชิก
          </a>
        </li> -->
      <!-- </ul> -->
    </div>
</nav>
  <!-- /.navbar -->

<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>

