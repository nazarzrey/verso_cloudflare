<?php
// if ($_SERVER["SERVER_NAME"] == "versoview.com" || $_SERVER["SERVER_NAME"] == "panel.versoview.com") {
//     $server = "https://versoview.com/";
//     $page1  = "openview/";
//     $page2  = "finance/";
//     $fldr   = "";
// } else {
//     $server = base_url();
//     $page1  = "pageturner/";
//     $page2  = "/";
//     $fldr   = "bca/";
// }
function ganjen($number)
{
    if (is_numeric($number)) {
        if ($number % 2 == 0) {
            return "genap";
        } else {
            return "ganjil";
        }
    } else {
        return "1";
    }
}
if ($result) {
    // $ch = curl_init(); 
    $x = 0;
    $y = 1;
    $layar = 4;
    $w = "25%";
    if ($screen < 421) {
        $layar = 1;
        $w = "100%";
    } elseif ($screen >= 421 && $screen < 580) {
        $layar = 1;
        $w = "80%";
    } elseif ($screen >= 580 && $screen < 920) {
        $layar = 2;
        $w = "50%";
    } elseif ($screen >= 920  && $screen < 1024) {
        $layar = 3;
        $w = "33.3%";
    } elseif ($screen >= 1024  && $screen < 1200) {
        $layar = 3;
        $w = "33.3%";
    }

    echo '
        <div class="content-page fisrt-content-page genap">
            <div class="container">
                <div class="row img-deliver">';

    $layar = 4; #accept only this one for limitation
    $rms   = fmod(count($result) / $layar, 1);
    $sisa  = $layar - ($layar * $rms);
    // debug(die($rms . "XXX" . $sisa));
    foreach ($result as $num => $hasil) {
        if ($x == $layar) {
            echo '
                        </div>
                    </div>
                </div>';
            echo '
                <div class="content-page fisrt-content-page ' . ganjen($y) . '">
                    <div class="container">
                        <div class="row img-deliver">';
            $x = 1;
            $y = $y + 1;
        } else {
            $x = $x + 1;
        }
        $img1   =  $page1 . $page2 . $hasil->ov_path . "files/medium/" . $hasil->magz_page . ".jpg";
        $img2   =  $page1 . $page2 . $hasil->ov_path . "files/thumb/" . $hasil->magz_page . ".jpg";
        if (file_exists(str_replace('panel', 'html', FCPATH) . $img1)) {
            $img = $server . $img1;
        } else {
            $img = $server . $img2;
        }
        $style = "";
        echo "
            <div class='img img-data' $style id='ov-" . $hasil->magz_page . "' data-href='" . str_replace(' ', '-', strtolower($hasil->content)) . "'>
                <img data-src='$img' class='ov-image'>
                <div class='img-ov-content'>
                    <div style='padding: 0 10px !important; text-align:left !important'>
                        <div class='get-like-cmnt'>
                            <div class='xicon' style='margin-top:10px;'>
                                <a class=''>
                                    <img src='" . $server . $page1 . "sample/files/extfile/like.png' class='like'>
                                    <span>" . rand(0, 99) . "</span>
                                </a>
                                <a class=''>
                                    <img src='" . $server . $page1 . "sample/files/extfile/comment.png'>
                                    <span>" . rand(0, 20) . "</span>
                                </a>
                                <a class=''>
                                    <img src='" .  $server . $page1 . "sample/files/extfile/bookmark.png' class='book'>
                                    <span>" . rand(0, 10) . "</span>
                                </a>
                            </div>
                        <hr>
                        <h6>$hasil->title</h6>
                        <span>$hasil->lead</span>
                        </div>
                    </div>
                </div>
            </div>";
    }
    // dbg($sisa);
    if ($sisa != $layar) {
        for ($x = 1; $x <= $sisa; $x++) {
            // if ($x == $layar) {
            //     echo '
            //             </div>
            //         </div>
            //     </div>';
            //     echo '
            //     <div class="content-page fisrt-content-page ' . ganjen($y) . '">
            //         <div class="container">
            //             <div class="row img-deliver">';
            //     $x = 1;
            //     $y = $y + 1;
            // } else {
            //     $x = $x + 1;
            // }
            // $img1   =  $page1 . $page2 . $hasil->ov_path . "files/medium/" . $hasil->magz_page . ".jpg";
            // $img2   =  $page1 . $page2 . $hasil->ov_path . "files/thumb/" . $hasil->magz_page . ".jpg";
            // if (file_exists(FCPATH . $img1)) {
            //     $img = $server . $img1;
            // } else {
            //     $img = $server . $img2;
            // }
            $style = "";
            echo "
            <div class='img img-data' $style >
                <div class='img-ov-content' style='background:none;border:none !important'>
                    <div style='padding: 0 10px !important; text-align:left !important'>
                        <div class='get-like-cmnt'>
                            <div class='xicon' style='margin-top:10px;'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
        }
    }
    echo '
                </div>
            </div>
    </div>';
} else {
    echo '
        <div class="content-page fisrt-content-page genap" style="border:none">
            <div class="container">
                <div style="font-size:38px;color:#999;">This section has no OpenView content</div>
            </div>
        </div>';
}
?>
<div style="padding-bottom:40px"></div>
<!-- 
<script src="assets/js/lazyload.min.js"></script>
<script>
    new LazyLoad();
</script> -->