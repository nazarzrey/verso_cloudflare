<?php
// echo $host = gethostname();
// echo FCPATH;
// dbg($magz);
// dbg($result);
// if ($_SERVER["SERVER_NAME"] == "versoview.com" || $_SERVER["SERVER_NAME"] == "panel.versoview.com") {
//     $server = "https://versoview.com/";
//     $page1  = "openview/";
//     $page2  = "finance/";
//     $fldr   = "";
// } else {
//     $server = base_url();
//     $page1  = "pageturner/";
//     $page2  = "";
//     $fldr   = "bca/";
// }
if ($result) {
    // $ch = curl_init(); 
    $x = 0;
    echo '
    <div class="content-page fisrt-content-page genap ov-10">
        <div class="container">
            <div class="img row img-deliver" id="ov-10">';
    foreach ($result as $num => $hasil) {
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
        // $img1   = $page1 . $page2 . $hasil->ov_path . "files/medium/1.jpg";
        // $img2   = $page1 . $page2 . $hasil->ov_path . "files/thumb/1.jpg";
        // if (file_exists(str_replace('panel', 'html', FCPATH) . $img1)) {
        //     $img = $server . $img1;
        // } else {
        //     $img = $server . $img2;
        // }
        // #        dbg(FCPATH . $img1.$server);
        $img   = ov_img_dtl($hasil->ov_path, "") . "files/medium/1.jpg";
        $edisi = $hasil->magz_dtl_fk_id;
        echo "
        <div class='img-data'>
            <a href='" . $magz . "/" . $edisi . "'>
            <img src='" . $img . "' class='ov-image'>
            <div class='img-ov-content'>
                <div style='padding: 0 10px !important; text-align:left !important'>
                    <div class='get-like-cmnt'>
                    ";
        if ($hasil->like > 0 || $hasil->cmnt > 0 || $hasil->book > 0) {
            echo comment($hasil->like, $hasil->cmnt, $hasil->book);
        } else {
            echo "<br/>";
        }
        echo "
                    <h6>$hasil->content_title</h6>
                    <span>$hasil->content_desc</span>
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
function comment($like, $cmnt, $book)
{
    global $server, $page1;
    echo "
    <div class='xicon' style='margin-top:12px;'>
        <a>
            <img src='" . assets("") . "theme1/extfile/like.png' class='like'>
            <span>$like</span>
        </a>
        <a>
            <img src='" . assets("") . "theme1/extfile/comment.png'>
            <span>$cmnt</span>
        </a>
        <a>
            <img src='" . assets("") . "theme1/extfile/bookmark.png' class='book'>
            <span>$book</span>
        </a>
    </div>
    <hr>";
}
?>
<div style="padding-bottom:30px"></div>