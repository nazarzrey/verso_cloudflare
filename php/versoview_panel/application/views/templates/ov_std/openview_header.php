<!DOCTYPE html>
<html lang="en">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <?php
   if ($_SERVER['HTTP_HOST'] != "localhost" && $_SERVER['HTTP_HOST'] != "192.168.2.108") {
      //   echo '
      //     ###jangan lupa hapus
      //     <META http-equiv="refresh" content="30;">
      //     ';
   }
   ?>
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="<?= $hdr_openview[1]->magz_name ?>">
   <meta name="author" content="<?= $hdr_openview[1]->magz_name ?>">
   <meta name="keywords" content="<?= $hdr_openview[1]->magz_name ?>">
   <title>OpenView - <?= $hdr_openview[1]->magz_name ?></title>
   <script>
      localStorage.setItem("firstLoading", true);
   </script>
   <script src="<?= $msturi ?>javascript/jquery.js"></script>
   <script src="<?= $msturi ?>assets/js/ovjs.js"></script>
   <link href="<?= $msturi ?>assets/css/bootstrap.css" rel="stylesheet">
   <link href="<?= $msturi ?>assets/css/custom.css" rel="stylesheet" />
   <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
   <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
   <link href='https://fonts.googleapis.com/css?family=Josefin Slab' rel='stylesheet'>
   <link rel="icon" href="<?= $msturi ?>assets/images/ov.png" type="image/png" sizes="16x16">

   <script src="<?= $msturi ?>assets/js/function.js"></script>
   <script src="<?= $msturi ?>assets/js/custom.js"></script>
   <script src="<?= $msturi ?>assets/js/ovjs.js"></script>
   <script type="text/javascript">
      $(window).on("load", function() {
         gogo("70");
         topbotbar();
      })
   </script>
   <script async src="https://www.googletagmanager.com/gtag/js?id=G-YL9NRXCWL0"></script>
   <script>
      /*
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-YL9NRXCWL0');
        */
   </script>
</head>

<body>

   <div id="OpenView-Hdr">

      <div id="ptop" data-openview="<?= $hdr_openview[1]->magz_short . "-" . $hdr_openview[1]->magz_dtl_id ?>" base-url="<?= $msturi ?>"></div>
      <!-- position: fixed;width: 100%;z-index: 100; -->
      <div class='content-page fisrt-content-page content-nav'>
         <div class="container" style="position: relative; ">
            <div style="float: none">
               <nav class="navbar navbar-expand-lg  navbar-light menu-content" style="">
                  <div id="navbarSupportedContent" class="navbar-collapse justify-content-center ">
                     <ul class="navbar-nav">
                        <li class="nav-item text-menu0"> <a class="nav-link waves-effect waves-light text-dark ov-thumb">Menu</a></li>
                        <li class="nav-item text-menu1"> <a class="nav-link waves-effect waves-light text-dark ov-thumb">Thumbnail</a></li>
                        <li class="nav-item text-menu1"> <a class="nav-link waves-effect waves-light text-dark ov-extend">Extended</a></li>
                        <li class="nav-item menu-next">
                           <a class="nav-link waves-effect waves-light text-dark">
                              <img src="<?= $msturi ?>files/extfile/menu.png" style="height: 15px" />
                           </a>
                           <ul class="next-menu">
                              <!-- <li class="nav-item">  <a class="nav-link waves-effect waves-light text-dark text-right mybook">My Bookmarks</a></li> -->
                              <li class="nav-item"> <a class="nav-link waves-effect waves-light text-dark text-right" id="goto-flip">Flipbook</a></li>
                           </ul>
                        </li>
                     </ul>
                  </div>
               </nav>
            </div>
         </div>
      </div>

      <?php
      /*
        dbg($hdr_openview[1]);
        dbg($hdr_openview[1]->magz_short);
        dbg($hdr_openview[1]->magz_dtl_id);
        */
      ?>