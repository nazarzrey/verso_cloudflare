<?php
// echo "<i class='hilang'>#####</i>";
echo '<div style="padding-bottom:60px" id="top-one"></div>';
echo '<div class="content-deliver cnt-hdr">';
if ($hdr_openview == "x") {
  die("error check data curl[2]");
};
foreach ($hdr_openview as $key => $value) {
  $imgpage = ganjil_genap($value->magz_page);
  $path    = $value->issue_path;
  #var_dump($path);
  // $url1    = $value->content."-".$value->magz_page;
  $url1    = $value->content;
  #echo "<a href='".$url1."' class='brd' style='overflow:auto'>";
  $gg = gg($key);
  echo "<div class='content-page fisrt-content-page $gg ov-" . $imgpage[0] . "' data-url='" . $url1 . "#'>
                <div class='container'>
                  <div class='img row img-deliver' id='ov-" . $imgpage[0] . "' data-href='" . str_replace(" ", "-", $url1) . "'>
                    <div class='img-data'>";
  foreach ($imgpage as $key => $page) {
    #$url = base_url("ovj/".$hdr_id."/".min_space($value->content,"-")."#p".$page);
    $url = base_url("ovj/" . $hdr_id . "/" . min_space($value->content, "-") . "#ptop");
    $img = $msturi . api_ov_img($page, $path, "med");
    echo "
                      <img src='" . $img . "' id='h" . $page . "' class='ov-image'/>";
  }
  echo "</div>
                  </div>                
                  <div style='padding:0'>
                    <h2 style='padding:0 !important;margin:10px 0 10px 0 !important'>" . $value->title . "</h2>
                    <h3 style='padding: 0 0 20px 0 !important;'>" . $value->lead . "</h3>
                  </div>          
                  ";
  echo "  </div>
          </div>";
}

echo "<div style='padding-bottom:30px'></div>";
echo "</div>";
##########################detl################
echo '<div id="OpenView-Dtl">';
$cek = "";
$ttl = count($dtl_openview) - 1;
foreach ($dtl_openview as $key => $value) {
  if ($key == 0) {
    echo "<div class='cnt-dtl' id='" . str_replace(" ", "-", $value->content) . "' data-title='" . ucwords($value->content) . "'>";
  } else {
    if ($value->content != $cek) {
      echo "</div>";
      echo "<div class='cnt-dtl' id='" . str_replace(" ", "-", $value->content) . "' data-title='" . ucwords($value->content) . "'>";
    }
  }
  $cek = $value->content;
  if (strlen($value->body_text)) {
    $p = "<section>" . $value->body_text . "</section>";
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
          $m10 = "mt10";
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
  // if ($value->magz_page % 2 == 0) {
  echo "<div class='img-dtl'>
                        <div class='img-data'>";
  foreach ($imgpage as $key => $page) {
    $url = base_url("ovj/" . $hdr_id . "/" . $page);
    $img = $msturi . api_ov_img($page, $path, "med");
    echo "
                          <img src='" . $img . "' id='p" . $page . "' class='ov-image'/>";
  }
  echo "</div>
                      </div>";
  // }
  if (!empty(trim($value->title))) {
    echo "<h2 style='padding:40px 0;margin:0'>" . $value->title . "</h2>";
    echo "<h3>" . $value->lead . "</h3>";
  } else {
    if (strlen($value->lead)) {
      echo "<h3 style='font-weight:bold;color:#555;line-height:25px'>" . $value->lead . "</h3>";
    }
  }
  echo $antr;
  if (!empty(trim($value->title)) && $value->content == "prioritas table") {
    echo '<section class="video">
                    <video width="100%" height="100%" autoplay="" controls="" id="video_player" __idm_id__="68287489">
                      <source src="files\SlidePage\video.webm" type="video/webm">
                    Your browser does not support the video tag.
                    </video>
                  </section>';
  }
  #style='white-space: normal;padding-top:20px;text-transform:italic'
  echo $p . " " . $l;
  echo "</div>";
  $cek = $value->content;
}
echo "</div>";
echo "</div>";
echo "</div>";
  // echo "<i class='hilang'>#####</i>";
