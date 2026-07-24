<?php

$jdl  = "Home";
$uri  = base_url("login") . "/";
if (isset($dtl_openview)) {
  $jdl  = ucwords(str_replace("magazine", "", strtolower($dtl_openview[0]->magz_name)));
  $uri  = base_url("ovj/" . $hdr_id) . "/";
  $path = flip_url($dtl_openview[0]->issue_path);
}
if (isset($hdr_openview)) {
  $jdl  = $jdl;
  $uri  = flip_url($hdr_openview[0]->issue_path) . "/";
  $path = flip_url($hdr_openview[0]->issue_path);
}
?>

<?php
if (empty($hdr_page)) {
  if (isset($hdr_openview)) {
    debug($hdr_openview);
    foreach ($hdr_openview as $key => $value) {
      $imgpage = ganjil_genap($value->magz_page);
      $path    = $value->issue_path;
      #var_dump($path);
      $url1    = $value->content . "-" . $value->magz_page;
      #echo "<a href='".$url1."' class='brd' style='overflow:auto'>";
      $gg = gg($key);
      echo "
        <div class='content-page fisrt-content-page $gg' data-url='" . $url1 . "#'>";
      echo "
        <div class='container'>";
      echo "
        <div class='img row img-deliver' id='ov-" . $imgpage[0] . "' data-href='" . str_replace(" ", "-", $url1) . "'>";
      echo "
        <div class='img-data'>";
      foreach ($imgpage as $key => $page) {
        #$url = base_url("ovj/".$hdr_id."/".min_space($value->content,"-")."#p".$page);
        $url = base_url("ovj/" . $hdr_id . "/" . min_space($value->content, "-") . "#ptop");
        $img = api_ov_img($page, $path, "med");
        echo "
            <img src='" . $img . "' id='p" . $page . "' class='ov-image'/>";
      }
      echo "</div>";
      echo "</div>";
      /*<h1 style='padding:40px 0;margin:0'>".$value->content."</h1>*/
      echo "
          <div style='padding:0'>
          <h2 style='padding:0 !important;margin:10px 0 10px 0 !important'>" . $value->title . "</h2>
          <h3 style='padding: 0 0 20px 0 !important;'>" . $value->lead . "</h3>
          </div>
          ";
      echo "</div>
        </div>";
    }
  };
} else {
  if (isset($dtl_openview)) {
    echo "<div class='cnt-dtl' id='" . str_replace(" ", "-", $dtl_openview[0]->content) . "'>
      <div class='view-page'></div>";
    foreach ($dtl_openview as $key => $value) {
      $p = "<section>" . $value->body_text . "</section>";
      $l = "<section style='white-space: normal;'>" . $value->caption . "</section>";
      $ant = $value->pengantar;
      if (strlen($ant) > 0) {
        $antr = "<section class='pg'>" . $ant . "</section>";
      } else {
        $antr = "";
      }
      $imgpage = ganjil_genap($value->magz_page);
      $path    = $value->issue_path;
      $url1    = $value->magz_page;
      echo "<div class='content-page fisrt-content-page' data-url='" . $url1 . "'>";
      if ($value->magz_page % 2 == 0) {
        echo "<div class='img-dtl'>";
        echo "<div class='img-data'>";
        foreach ($imgpage as $key => $page) {
          $url = base_url("ovj/" . $hdr_id . "/" . $page);
          $img = api_ov_img($page, $path, "med");
          echo "<img src='" . $img . "' id='p" . $page . "' class='ov-image'/>";
        }
        echo "</div>";
        echo "</div>";
      }
      if (!empty(trim($value->title))) {
        echo "<h2 style='padding:40px 0;margin:0'>" . $value->title . "</h2>
                <h3>" . $value->lead . "</h3>";
      }
      echo $antr;
      echo $p . " " . $l;
      echo "</div>";
      #echo "</a>";
    }
    /*echo '
      <div class="ov-footer" style="background: #fff;position: fixed;bottom: 0;left:0;z-index: 999;width:100%;box-shadow:1px 1px 5px #ccc">
        <a src="" id="" class="ov-like hilang">
          <img src="'.base_url("pageturner/200122/yzjs0gucd25/files/extfile/like.png").'">
        </a>
        <a src="" id="" class="ov-share hilang">
          <img src="'.base_url("pageturner/200122/yzjs0gucd25/files/extfile/share.png").'">
        </a>
        <a src="" id="" class="ov-bookmark hilang">
          <img src="'.base_url("pageturner/200122/yzjs0gucd25/files/extfile/bookmark.png").'">
        </a>
        <a src="" id="" class="ov-font pull-right">
          <img src="'.base_url("pageturner/200122/yzjs0gucd25/files/extfile/font.png").'">
        </a>
      </div>
    ';*/
    echo "</div>";
  } else {
    redirect('ovj/' . $hdr_id, 'location', 301);
  }
}
?>