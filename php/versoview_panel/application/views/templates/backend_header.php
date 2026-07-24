<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags-->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" media="screen">
  <meta name="description" content="au theme template">
  <meta name="author" content="Hau Nguyen">
  <meta name="keywords" content="au theme template">

  <!-- Title Page-->
  <title>Versoview Backend</title>

  <!-- Fontfaces CSS-->
  <link href="<?= assets('css/font-face.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/font-awesome-4.7/css/font-awesome.min.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/font-awesome-5/css/fontawesome-all.min.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/mdi-font/css/material-design-iconic-font.min.css') ?>" rel="stylesheet" media="all">

  <!-- Bootstrap CSS-->
  <link href="<?= assets('vendor/bootstrap-4.2.1/bootstrap.min.css') ?>" rel="stylesheet" media="all">

  <!-- Vendor CSS-->
  <link href="<?= assets('vendor/animsition/animsition.min.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/wow/animate.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/css-hamburgers/hamburgers.min.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/slick/slick.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/select2/select2.min.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/perfect-scrollbar/perfect-scrollbar.css') ?>" rel="stylesheet" media="all">
  <link href="<?= assets('vendor/vector-map/jqvmap.min.css') ?>" rel="stylesheet" media="all">
  <!-- Main CSS-->
  <link href="<?= assets('css/styles.css?' . date('His')) ?>" rel="stylesheet" media="all">
  <link href="<?= assets('css/theme.css?' . date('His')) ?>" rel="stylesheet" media="all">
  <link href="<?= assets('css/backend-style.css?' . date('His')) ?>" rel="stylesheet" media="all">
  <link href="<?= assets('css/loading-use.css?' . date('His')) ?>" rel="stylesheet" media="all">
  <!-- <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script> -->
  <!-- <script src="<?php # assets('pdfjs/build/pdf.worker.js') 
                    ?>"></script>
    <script src="<?php # assets('pdfjs/build/pdf.js') 
                  ?>"></script> -->
  <!-- <script src="<?php # assets('js/pdfjs.worker.js') 
                    ?>"></script> -->
  <script src="<?= assets('js/pdfjs.js') ?>"></script>

  <!-- ckeditor -->
  <!-- 
    <script src="<?php # assets('ckeditor/ckeditor.js') 
                  ?>"></script>
    <script src="<?php # assets('ckeditor/sample.js') 
                  ?>"></script>
    <link  href="<?php # assets('ckeditor/samples/css/samples.css?'.date('His')) 
                  ?>">
    <link  href="<?php # assets('ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css?'.date('His')) 
                  ?>">
    -->
  <!-- niceEditor -->

  <!-- Global site tag (gtag.js) - Google Analytics -->

  <script src="<?= assets('js/sweetalert2.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?= assets('css/sweetalert2.min.css'); ?>">

  <!--     <script async src="https://www.googletagmanager.com/gtag/js?id=UA-143438659-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-143438659-1');
    </script>     -->
</head>
<?php
if ($this->config->item('lokal') == "yes") {
  dbg($this->config->item('lokal'));
  popup("0", $this->router->fetch_class() . " -> " . $this->router->fetch_method());
}
?>

<body class="animsition">
  <div id="base-url" data-id="<?= base_url("") ?>"></div>
  <div class="page-wrapper">