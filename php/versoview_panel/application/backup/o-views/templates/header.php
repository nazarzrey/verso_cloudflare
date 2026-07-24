
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com --> 
  <title>Versoview</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
  <!-- add script css -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?'.date('Hm')) ?>">
  <script src="<?= base_url('assets/js/script.js'); ?>"></script>
  <style>
  </style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
  <nav class="navbar navbar-default navbar-fixed-top" style="box-shadow:0px -1px 5px #555">
    <div class="container">
      <div class="navbar-collapse" id="myNavbar" style="position: relative;">
        <div style="padding:18px 0;float: left">
          <img src="<?= base_url('assets/images/menu.png'); ?>" alt="" class="mouse xopen">
          <a class="mouse" href="<?= base_url('index.php') ?>"><img src="<?= base_url('assets/images/logo.png'); ?>" alt="" height="35px"></a>
        </div>
        <div class="navbar-menu">
          <ul class="nav navbar-nav navbar-right" style="margin-right: 0">
            <li class="category-menu">
              <a class="dropdown-toggle mouse " data-toggle="dropdown" style="color:#ab9889 !important">ALL CATEGORIES 
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
            <?php
              foreach ($listcategory as $row) {
                  echo '<li><a href="'.base_url("cat/".$row->cat_url).'">'.$row->cat_name.'</a></li>';
              }
            ?>
              </ul>
            </li>
            <li>            
              <div>
                <form action="/action_page.php"  class="search-container">
                  <input type="text" placeholder="Type to search and hit enter.." name="search" style="padding: 24px 10px;" autocomplete="off" maxlength="100" 
                  >
                  <button type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </form>
              </div>
            </li>
            <!-- <li><a href="#pricing">LOGIN</a></li> -->
            <li><a href="<?= base_url('login'); ?>">LOGIN</a></li>
            <li><a href="<?= base_url('register'); ?>" class="aktif">SIGN UP</a></li>
          </ul>
      </div>
      </div>
    </div>
    <div class="cover-page">
      <div class="left-menu">
        <div class="header-left-menu">
          <ul>
              <li class="logo-left-menu"><img src="<?= base_url('assets/images/close.png'); ?>" class="xclose" ><img src="<?= base_url('assets/images/logo.png'); ?>" height='30px'></li>
              <li><label class="MI MI_ho"></label><a href="index.php">HOME</a></li>
              <li><label class="MI MI_mg"></label><a href="?page=magazine">FEATURED MAGAZINES</a></li>
              <li><label class="MI MI_li"></label><a href="#">MY LIBRARY</a></li>
              <li><label class="MI MI_qr"></label><a href="#">QR CODE</a></li>
              <li><label class="MI MI_go"></label><a href="#">GOOGLE REWARD</a></li>
              <li><label class="MI MI_bat"></label><a href="#">BAT REWARD</a></li>
              <li><label style="margin-left:22px;"></label>
                  <a href="<?= base_url('login'); ?>" style="font-size:16px;text-decoration: underline;">Login</a> 
                  / 
                  <a href="<?= base_url('register'); ?>" style="font-size:16px;text-decoration: underline;">Sign Up</a> 
              </li>
          </ul>
        </div>
        <div class="footer-left-menu">
        </div>
      </div>
  </div>
</nav>