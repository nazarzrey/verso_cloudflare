<?php

// if ($_SERVER['REMOTE_ADDR'] == "localhost" || $_SERVER['REMOTE_ADDR'] == "::1") {
//     $host   = "http://localhost/versoview/";
//     $server = $host . "pageturner/";
// } else {
//     if ($_SERVER["SERVER_NAME"] == "versoview.com" || $_SERVER["SERVER_NAME"] == "panel.versoview.com") {
//         $host   = "https://panel.versoview.com/";
//         $server = "https://versoview.com/openview/";
//     } else {
//         $host   = "http://192.168.0.201/versoview/";
//         $server = $host . "pageturner/";
//     }
// }
if (isset($edisi)) {
    $ed = $edisi;
} else {
    $ed = "94";
}
// dbg($header);
if ($header) {
    $mag_name = $header->magz_name;
    $judul    = $header->issue_title;
    $keter    = $header->issue_desc;
    $mag_ovi  = $header->magz_openview;
    $mag_cmnt = $header->magz_comment;
} else {
    $judul = $keter = $mag_name = $mag_ovi = $mag_cmnt = "";
}
if ($mag_cmnt != "x") {
    $cmnt_icon = 20;
    $cmnt_text = 175;
} else {
    $cmnt_icon = 25;
    $cmnt_text = 130;
}
$cmnt_len  = 100 - $cmnt_icon;
function cache()
{
    echo date("ymdhis");
}
$murl = base_url("") . "/ovi/theme_view/";
$url = $murl . $magz;
$ss = $murl . $ed;
$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);
#header('wscr:' . "<script>window.innerWidth</script>",);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- <META http-equiv="refresh" content="30;"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $mag_name ?>">
    <meta name="author" content="<?= $mag_name ?>">
    <meta name="keywords" content="<?= $mag_name ?>">
    <title>OpenView - <?= $mag_name ?></title>
    <script>
        localStorage.setItem("firstLoading", true);
    </script>
    <script src="<?= assets("") ?>theme1/js/jquery.js"></script>
    <script src="<?= assets("") ?>theme1/js/boostratp.min.js"></script>
    <!-- <script src="assets/js/jquery.scrollTo.min.js"></script> -->
    <!-- <script src="assets/js/ovjs.js"></script> -->
    <link href="<?= assets("") ?>theme1/css/bootstrap.css" rel="stylesheet">
    <link href="<?= assets("") ?>theme1/css/custom-new.css?v2" rel="stylesheet" />
    <link href="<?= assets("") ?>theme1/css/click.css?v2" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Josefin Slab' rel='stylesheet'>
    <link rel="icon" href="assets/images/ov.png" type="image/png" sizes="16x16">
    <script type="text/javascript">
        var $h = window.innerHeight;
        var $w = window.innerWidth;
        $(document).ready(function() {
            $edisi = $("#ptop").attr("data-openview");
            $komen = "<?= $mag_cmnt ?>";

            // screen($w, $h);
            $(window).resize(function() {
                var $h = window.innerHeight;
                var $w = window.innerWidth;

                // screen($w, $h);
                if ($w == 420 || $w == 580 || $w == 920 || $w == 1024 || $w == 1140 || $w == 1364) {
                    // window.location.href = "";
                }
            })
            pathPage = window.location.hash.substr(1);
            Api($w, pathPage);
            // alert(document.location.href + " " + pathPage.length);
            if (pathPage.length == 0) {
                $newUri = document.location.href + "#width=" + $w;
                // alert("X" + $newUri);
                document.location.href = $newUri;
                // var $el = $('a[href*="/HelloWorld/default.aspx"]');
                // $ss = $el.attr("href", $el.attr("href") + "?template=PW");
                // alert($ss);
            }
        })


        function screen($w, $h) {
            $(".text").html($w + "px x " + $h + "px");
        }

        function pegi(pathPage) {
            if (pathPage.length) {
                // alert(pathPage.length);
                // $(".xloading").show();
                $(".cnt-hdr").hide()
                $xid = pathPage.replace("p", "ov-");
                setTimeout(function() {
                    $dtl = $("#" + $xid).attr("data-href");
                    if ($dtl) {
                        $("#" + $xid).click()
                    }
                    // $(".xloading").hide();
                }, 1000)
            };
        }

        function Api(layar) {
            $.ajax({
                url: "<?= base_url("") ?>ov_std/<?= $ed ?>/edisi",
                type: "GET",
                dataType: "json",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('wscr', $w);
                },
                success: function(data) {
                    if ($(".cnt-hdr").css("display") == "block") {
                        $(".text-menu0").find("a").text(data[0]["judul"]);
                    }
                    $("#ptop").attr("data-openview", "bca-" + data[0]["edisi"]).html("bca-" + data[0]["edisi"]);
                    $(".flip-url").attr("data-href", data[0]["url"] + "index.html");
                }
            });
            // $(".xloading").hide();
        }
        // $.getMultiScripts(script_arr);
    </script>


    <style type="text/css" media="screen">
        .ov-footer a,
        .ov-footer2 a {
            width: <?= $cmnt_icon ?>% !important;
        }

        .content-page .img-ov-content {
            max-height: <?= $cmnt_text ?>px;
        }

        .ov-footer-popup {
            width: <?= $cmnt_len ?> !important%;
        }

        .blok {
            display: block !important;
            position: relative !important
        }

        .modal-footer label {
            padding-top: 5px !important;
            margin: 0 !important;
        }

        .modal-footer ul li {
            list-style: none;
            float: left;
            margin: 0;
            /* padding: 0 3px; */
            cursor: pointer;
        }

        .modal-footer ul {
            overflow: hidden;
            margin: 0;
            padding: 0;
            list-style-type: none
        }

        .xloading {
            background: #0f1624;
            height: 140vh;
            position: fixed;
            z-index: 9999;
            width: 100%;
            display: none;
        }

        .xloading img {
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -50px;
            margin-left: -100px;
            /* width: 100px; */
        }

        .dblok {
            display: block !important;
        }
    </style>
</head>

<body>

    <div id="img-versi" versi="v2" class="none"></div>
    <div class="xloading">
        <img src="<?= assets("") ?>theme1/extfile/vv.gif">
    </div>
    <div id="myModal" class="new-modal  " style="">
        <span class="close">&times;</span>
        <div class="new-modal-content">
        </div>
        <div id="caption"></div>
    </div>

    <div class='custom-menu'>
        <section data-action="first" id="get-content">
            <form id="comment-content">
                <div class="modal " tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                Select section
                                <select name="" id="content-section2">
                                </select>
                                <button type="button" class="close hide" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>data content here</p>
                            </div>
                            <div class="modal-footer" style="display:block">
                                <div style="width: 100%;" class="mt-2">
                                    <div class="input-group cntn-frm">
                                        <textarea rows="4" class="form-control cntn-input" placeholder="type your comment"></textarea>
                                    </div>
                                    <div class="input-group cntn-frm-name">
                                        <textarea rows="4" class="form-control cntn-input-name" placeholder="input your name"></textarea>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>
                                                share
                                            </label>
                                        </div>
                                        <div class="col-md-10">
                                            <ul>

                                                <li><a class="open-wa" alt="share openview to whatsapp">&nbsp;</a></li>
                                                <li><a class="open-tl" alt="share openview to telegram">&nbsp;</a></li>
                                                <li><a class="open-tw" alt="share openview to twitter">&nbsp;</a></li>
                                                <li><a class="open-fb" alt="share openview to facebook">&nbsp;</a></li>
                                                <li><a class="open-mark" alt="save openview to your bookmark">&nbsp;</a></li>

                                                <div class="text-right cntn-frm">
                                                    <button class="btn btn-secondary btn-sm post-content bg-dark" type="button">Post</button>
                                                </div>

                                                <div class="text-right cntn-frm-name">
                                                    <button class="btn btn-secondary btn-sm cntn-post-name bg-dark" type="button">Save</button>
                                                </div>
                                            </ul>
                                        </div>
                                        <!--  -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </section>
    </div>

    <div class="text" style="display:none;position:fixed;z-index:9999;height:50%;width:100%;bottom:0"></div>

    <div id="ptop" data-openview="<?= $edisi; ?>" data-title="<?= $judul ?>" base-url="<?= assets("") . "theme1/"; ?>" class="none"></div>
    <!-- position: fixed;width: 100%;z-index: 100; -->
    <div class='content-page fisrt-content-page content-nav'>
        <div class="container" style="position: relative; ">
            <div style="float: none">
                <nav class="navbar navbar-expand-lg  navbar-light menu-content" style="">

                    <?php
                    $logo  = $url . "/logo";
                    $hasil = file_get_contents($logo, false, stream_context_create($arrContextOptions));
                    if ($hasil) {
                        $data  = explode(",", $hasil);
                        if (count($data)) {
                            $img   = $data[0];
                            $ht    = $data[1];
                        } else {
                            $img   = "";
                            $ht    = "";
                        }
                        echo '<img src="' . base_url("") . "/magazine/logo/" . $img . '" style="position:absolute;height:' . $ht . 'px" class="desktop" />';
                    } else {
                        echo '<h5 style="margin-top: 5px;">Logo</h5>';
                    }
                    ?>
                    <div id="navbarSupportedContent" class="navbar-collapse justify-content-center ">
                        <ul class="navbar-nav">
                            <li class="nav-item text-menu0" judul=""> <a class="nav-link waves-effect waves-light text-dark desktop">Menu</a></li>
                            <!-- <li class="nav-item"> <a class="nav-link waves-effect waves-light text-dark ov-edisi">info</a></li> -->
                            <li class="nav-item text-menu1 none "> <a class="nav-link waves-effect waves-light text-dark ov-thumb">Thumbnail</a></li>
                            <li class="nav-item text-menu1  none "> <a class="nav-link waves-effect waves-light text-dark ov-extend">Extended</a></li>

                        </ul>
                    </div>
                    <div style="position: absolute;right:0" class="nav-item menu-next ">
                        <a class="nav-link waves-effect waves-light text-dark">
                            <img data-src="<?= assets("") ?>theme1/extfile/menu.png" style="height: 15px" />
                        </a>
                        <ul class="next-menu">
                            <li class="nav-item"> <a class="nav-link waves-effect waves-light text-dark text-right mybook">My Bookmarks</a></li>
                            <li class="nav-item"> <a class="nav-link waves-effect waves-light text-dark text-right flip-url" href="#">Flipbook</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!-- <div style='padding-bottom:60px' id="top-one"></div> -->
    <div class="content-deliver cnt-hdr">
        <?php
        echo file_get_contents($ss, false, stream_context_create($arrContextOptions));
        ?>
    </div>
    <div id="OpenView-Dtl">
        <?php
        echo file_get_contents(base_url("") . "/ov_std/" . $ed . "/view", false, stream_context_create($arrContextOptions));
        ?>
        <!-- <h1 style="padding-top: 100px;text-align:center;margin:auto">Content not laoded</h3> -->
    </div>
    <div class="likebook">
        <!-- <h4 class="text-center">Like & Bookmark</h4> -->
        <div class='container'>
            <div class="row">
                <div style="width: 50%;float: left;padding: 10px;margin-bottom: 20px;display: none">
                    <h4 style="background-color: #f1f1f1f9;">Like</h4>
                    <div class="dlike">
                        <ul>
                            <li></li>
                        </ul>
                    </div>
                </div>
                <div style="width: 100%;float: left;margin-bottom: 10px">
                    <div style=" ">
                        <!-- <h6 class="text-bookmark">Bookmark & Like</h6> -->
                        <!-- <h6 class="text-bookmark">&nbsp;</h6> -->
                        <h1 style="padding-top: 5px;"></h1>
                        <span class="close-bookmark">X</span>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Bookmark</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Like</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                        </li> -->
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="dbook">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"></div>
                        <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...3</div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ov-footer" style="background: #fff;position: fixed;bottom: 0;right:0;z-index: 999;width:100%;box-shadow:1px 1px 5px #ccc;">
        <div class="ov-comment">
            <h5 class="text-center comment-header"></h5>
            <select name="" id="content-section"></select>
            <span class="back"></span>
            <section style="position: relative;" id="ov-comment">
                <div class="ov-loading">
                    <img data-src="style/icon/loading.gif">
                </div>
                <div id="result-comment"></div>
                <div id="result-comment-reply"></div>
                <span class="cmnt-bottom"></span>
            </section>
            <form id="comment">
                <div class="cmnt-posts">
                    <ul>
                        <li>
                            <div>
                                <div class="cmnt-frm-name hide">
                                    <input placeholder="input your name" style="width: 79%" class="cmnt-input-name" maxlength="25"><input type="button" value="Save" class="cmnt-post-name disabled" style="width: 20%">
                                </div>
                                <div class="cmnt-frm">
                                    <input placeholder="add a comment..." style="width: 79%" class="cmnt-input" data-reply="" data-share=""><input type="button" value="Post" class="cmnt-post disabled" style="width: 20%">
                                </div>
                            </div>
                            <ul>
                                <li></li>
                            </ul>
                        </li>
                        <li></li>
                    </ul>
                </div>
            </form>
        </div>
        <div class="ov-footer-popup">
        </div>
        <a href="<?= base_url("") . "theme1/" . $magz ?>" id="" class="ov-logo-hdr none">
            <img data-src="<?= assets(""); ?>theme1/img/ovi.png">
        </a>
        <a id="" class="ov-logo">
            <img data-src="<?= assets(""); ?>theme1/img/ovi.png">
        </a>
        <a src="" id="ov-like" class="ov-like">
            <img data-src="<?= assets(""); ?>theme1/img/extfile/like.png" class="no">
        </a>
        <?php if ($mag_cmnt != "x") { ?>
            <a src="" id="ov-comment2" class="ov-cmnt">
                <img data-src="<?= assets(""); ?>theme1/img/extfile/comment.png">
            </a>
        <?php } ?>
        <a src="" id="ov-bookmark" class="ov-bookmark ">
            <img data-src="<?= assets(""); ?>theme1/img/extfile/bookmark.png" class="no">
            <!-- <img data-src="files/extfile/bookmark-ok.png" class="ok"> -->
        </a>
        <a src="" id="" class="ov-share hilang">
            <img data-src="<?= assets(""); ?>theme1/img/extfile/share.png">
        </a>
        <a src="" id="" class="ov-font pull-left">
            <img data-src="<?= assets(""); ?>theme1/img/extfile/font.png">
        </a>
        <!-- <a src="" id="" class="ov-menu right-mobile">
         <img data-src="files/extfile/menu.png">
         </a> -->
    </div>

    <script src="<?= assets("") ?>theme1/js/lazyload.js"></script>
    <script>
        new LazyLoad();

        $(document).ready(function() {
            // Get the image and insert it inside the modal - use its "alt" text as a caption
            $(document).on("click", ".myImg", function() {
                $(".new-modal-content").html("");
                $("#myModal").css("display", "block");
                $("#caption").html($(this).attr("alt"));
                $(this).closest(".img-data-dtl").find("img").each(function() {
                    $img = $(this).attr("data-img");
                    // $("#img01").attr("src", $(this).attr("data-src"));
                    $(".new-modal-content").append("<img src='" + $img + "' />")
                })
                // lg($hdr.attr("data-src"))
            });

            // lg($(this).attr("data-src"));

            // When the user clicks on <span> (x), close the modal
            $(document).on("click", ".close", function() {
                $("#myModal").css("display", "none");
            })
        })
    </script>

    <script src="<?= assets("") ?>theme1/js/function-new.js?v2"></script>
    <script src="<?= assets("") ?>theme1/js/custom-new.js?v2"></script>
    <!-- <script src="<?= assets("") ?>theme1/js/bookmark-new.js"></script> -->
    <script src="<?= assets("") ?>theme1/js/ovjs-new.js?v2"></script>

    <script src="<?= assets("") ?>theme1/js/click-new.js?v2"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>