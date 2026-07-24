<?php
// if ($_SERVER['REMOTE_ADDR'] == "localhost" || $_SERVER['REMOTE_ADDR'] == "::1") {
//     $host   = "http://localhost/versoview/";
//     $server = $host . "pageturner/sample/";
// } else {
//     if ($_SERVER["SERVER_NAME"] == "versoview.com") {
//         $host   = "https://panel.versoview.com/";
//         $server = "https://versoview.com/openview/sample/";
//     } else {
//         $host   = "http://192.168.0.201/versoview/";
//         $server = $host . "pageturner/sample/";
//     }
// }

#die($_SERVER['REMOTE_ADDR'] . $_SERVER['SERVER_NAME'] . $host);

$cmnt_text = 130;
$mag_name  = "Archive"

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $mag_name ?>">
    <meta name="author" content="<?= $mag_name ?>">
    <meta name="keywords" content="<?= $mag_name ?>">
    <title>OpenView - <?= $mag_name ?></title>
    <script>
        localStorage.setItem("firstLoading", true);
    </script>
    <script src="<?= assets("") ?>theme1/js/jquery.js"></script>
    <script src="<?= assets("") ?>theme1/js/ovjs.js"></script>
    <link href="<?= assets("") ?>theme1/css/bootstrap.css" rel="stylesheet">
    <link href="<?= assets("") ?>theme1/css/custom.css" rel="stylesheet" />

    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Josefin Slab' rel='stylesheet'>
    <link rel="icon" href="<?= base_url("") ?>assets/images/ov.png" type="image/png" sizes="16x16">
    <script type="text/javascript">
        $(window).on("load", function() {
            // gogo("70");
            // topbotbar();
        })
        $(document).ready(function() {
            function screen() {
                $h = window.innerHeight;
                $w = window.innerWidth;
                $("#text").val($w + "px x " + $h + "px");
            }
            screen()
            $(window).resize(function() {
                screen()
            })
            $(document).on("click", ".ov-thumb-hdr", function() {
                $(".content-page").find("h1, h2, h3").hide();
                $(".ganjil").attr("style", "background:#fff  !important");
                $(this).attr("style", "font-weight:bold;font-style:underline");
                $(".ov-extend-hdr").attr("style", "font-weight:normal;font-style:none");
                $(".img-ov-content").addClass("none");
            })
            $(document).on("click", ".ov-extend-hdr", function() {
                $(".content-page").find("h1, h2, h3").show();
                $(".ganjil").attr("style", "background:#f5f5f5 !important");
                $(this).attr("style", "font-weight:bold;font-style:underline");
                $(".ov-thumb-hdr").attr("style", "font-weight:normal;font-style:none");
                $(".img-ov-content").removeClass("none");
            })
            $(document).on("click", ".open-img-data", function() {
                window.location.href = $(this).attr("data-href")
            })
        })
    </script>
    <style type="text/css" media="screen">
        .ov-footer a,
        .ov-footer2 a {
            width: <?= $cmnt_icon ?>% !important;
            /* width: 33.333%; */
        }

        .content-page .img-ov-content {
            max-height: <?= $cmnt_text ?>px;
        }
    </style>
</head>

<body>
    <?php

    if (isset($magz)) {
        $url = base_url("") . "ovi/theme_view/" . $magz;
    } else {
        $url = base_url("") . "ovi/theme_view";
    }
    $arrContextOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );
    ?>
    <div id="OpenView-Hdr">

        <div id="ptop" data-openview="" base-url=""></div>
        <!-- position: fixed;width: 100%;z-index: 100; -->
        <div class='content-page fisrt-content-page content-nav'>
            <div class="container" style="position: relative; ">
                <div style="float: none">
                    <nav class="navbar navbar-expand-lg  navbar-light menu-content" style="">
                        <?php
                        echo '<img src="' . base_url("") . "/magazine/logo/logo-ovi.png" . '" style="position:absolute;height:25px" class="desktop" />';
                        ?>
                        <div id=" navbarSupportedContent" class="navbar-collapse justify-content-center ">
                            <ul class="navbar-nav">
                                <li class="nav-item text-menu1"> <a class="nav-link waves-effect waves-light text-dark ov-thumb-hdr">Thumbnail</a></li>
                                <li class="nav-item text-menu1"> <a class="nav-link waves-effect waves-light text-dark ov-extend-hdr">Extended</a></li>
                                <li class="nav-item menu-next hide">
                                    <a class="nav-link waves-effect waves-light text-dark">
                                        <img src="<?= assets("") ?>img/extfile/menu.png" style="height: 15px" />
                                    </a>
                                    <ul class="next-menu">
                                        <li class="nav-item"> <a class="nav-link waves-effect waves-light text-dark text-right" id="goto-flip">Flipbook</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div style="padding-bottom:60px" id="top-one"></div>
        <div class="content-deliver cnt-hdr">
            <?php
            // dbg($header);
            if ($header) {
                // $ch = curl_init(); 
                $x = 0;
                echo '
                <div class="content-page fisrt-content-page genap ov-10">
                    <div class="container">
                        <div class="img row img-deliver" id="ov-10">';
                foreach ($header as $num => $hasil) {
                    if ($x == 4) {
                        // echo $x . "z ";
                        echo '
                                </div>
                            </div>
                        </div>';
                        echo '
                        <div class="content-page fisrt-content-page genap ov-10">
                            <div class="container">
                                <div class="img row img-deliver" id="ov-10">';

                        $x = 0;
                    }
                    $x = $x + 1;
                    $img   = ov_img_dtl($hasil->issue_path, "") . "files/medium/1.jpg";
                    $edisi = $hasil->magz_dtl_id;
                    echo "
                    <div class='img-data'>
                        <a href='" . base_url("") . "theme1/" . $hasil->magz_url . "'>
                        <img src='" . $img . "' class='ov-image'>
                        <div class='img-ov-content'>
                            <div style='padding: 0 10px !important; text-align:left !important'>
                                <div class='get-like-cmnt'>
                                ";

                    echo "
                                <h6>$hasil->magz_name</h6>
                                <span>" . ucfirst(strtolower(paragrap($hasil->magz_desc, 16))) . "</span>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>";
                }
                echo '
                        </div>
                    </div>
                </div>';
            }

            ?>
            <div style='padding-bottom:30px'></div>
        </div>
    </div>
</body>

</html>