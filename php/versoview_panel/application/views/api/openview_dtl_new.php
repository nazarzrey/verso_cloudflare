<?php
// echo "<i class='hilang'>#####</i>";
echo '<div style="padding-bottom:60px" id="top-one"></div>';
echo '<div class="content-deliver cnt-hdr">';
if ($hdr_openview == "x") {
    die("error check data curl[2] new dtl");
};
echo "<div style='padding-bottom:30px'></div>";
echo "</div>";
##########################detl################
echo '<div id="OpenView-Dtl">';
$cek = "";
$ttl = count($dtl_openview) - 1;
foreach ($dtl_openview as $key => $value) {
    $id = str_replace(" ", "-", $value->content);
    if ($key == 0) {
        echo "<div class='cnt-dtl' id='" . $id . "' data-title='" . ucwords($value->content) . "'>";
    } else {
        if ($value->content != $cek) {
            echo "</div>";
            echo "<div class='cnt-dtl' id='" . $id . "' data-title='" . ucwords($value->content) . "'>";
        }
    }
    $cek = $value->content;
    if (strlen($value->body_text)) {
        $body = "<span>" . preg_replace("/\r/", "</span><span>", $value->body_text) . "</span>";
        $xx   = explode("<span>", $body);
        $z    = "";
        $p    = $value->magz_page;
        foreach ($xx as $key => $zz) {
            $z .= "<span class='" . $id . "' id='" . $id . "-"  . $p . "-" . $key . "'>" . $zz . "</span>";
        }

        // $p = "<section id='" . $id . "-" . $value->magz_page . "'>" . $z . "</section>";
        $p = "<section style='margin-top:20px !important'>" . $z . "</section>";
    } else {
        $p = "";
    }
    if (strlen($value->caption)) {
        $l = "<section class='caption'>" . $value->caption . "</section>";
    } else {
        $l = "";
    }
    $ant = $value->pengantar;
    if (strlen($ant) > 0) {
        $m10 = "";
        if (strlen($value->body_text)) {
            if (strlen($value->lead)) {
                $m10 = $m10;
            } else {
                if ($value->magz_page % 2 == 0) {
                    $m10 = $m10;
                } else {
                    $m10 = "";
                }
            }
        }
        $antr = "<section class='pg $m10'>" . $ant . "</section>";
    } else {
        $antr = "";
    }
    $imgpage = ganjil_genap($value->magz_page);
    $path    = $value->issue_path;
    $url1    = $value->magz_page;
    echo "<div class='content-page fisrt-content-page' data-url='" . $url1 . "'>";
    if ($value->magz_page % 2 == 0) {
        echo "<div class='img-dtl-new'>
                        <div class='img-data-dtl' style='border:solid 1px #ececec'>";
        foreach ($imgpage as $key => $page) {
            $url  = base_url("ovj/" . $hdr_id . "/" . $page);
            // echo api_ov_img($page, $path, "med");
            $img  = ov_img_dtl($path . api_ov_img($page, $path, "med"), "");
            $img1 = ov_img_dtl($path . api_ov_img($page, $path, "large"), "");
            // echo " <img img-src='" . assets("images/vv4.png") . "' data-src='" . $img . "' data-img='" . $img1 . "' id='p" . $page . "' class='ov-image myImg'/>";
            echo " <img src='" . assets("images/vv6.png") . "' data-src='" . $img . "' data-img='" . $img1 . "'  id='p" . $page . "' class='ov-image myImg' />";
        }
        echo "</div>
                      </div>";
    }
    if (!empty(trim($value->title))) {
        echo "<h2>" . $value->title . "</h2>";
        echo "<h3>" . $value->lead . "</h3>";
    } else {
        if (strlen($value->lead)) {
            echo "<h3 style='font-weight:bold;color:#555;line-height:25px;margin-top:10px !important'>" . $value->lead . "</h3>";
        }
    }
    echo $antr;
    // if (!empty(trim($value->title)) && $value->content == "prioritas table") {
    //     echo '<section class="video">
    //                 <video width="100%" height="100%" autoplay="" controls="" id="video_player" __idm_id__="68287489">
    //                   <source src="files\SlidePage\video.webm" type="video/webm">
    //                 Your browser does not support the video tag.
    //                 </video>
    //               </section>';
    // }
    #style='white-space: normal;padding-top:20px;text-transform:italic'
    echo $p . " " . $l;
    echo "</div>";
    $cek = $value->content;
}
echo "</div>";
echo "</div>";
echo "</div>";
// echo "<i class='hilang'>#####</i>";

?>
<!-- 
<script src="assets/js/lazyload.min.js"></script>
<script>
    new LazyLoad();
</script> -->