<?php
  // echo "<i class='hilang'>#####</i>";
      echo '<div style="padding-bottom:60px" id="top-one"></div>';
      echo '<div class="content-deliver cnt-hdr">';
      foreach ($hdr_openview as $key => $value) {
        $imgpage = ganjil_genap($value->magz_page);
        $path    = $value->issue_path;
        #var_dump($path);
        // $url1    = $value->content."-".$value->magz_page;
        $url1    = $value->content;
        #echo "<a href='".$url1."' class='brd' style='overflow:auto'>";
        $gg = gg($key);
        echo "<div class='content-page fisrt-content-page $gg' data-url='".$url1."#'>
                <div class='container'>
                  <div class='img row img-deliver' id='ov-".$imgpage[0]."' data-href='".str_replace(" ","-",$url1)."'>
                    <div class='img-data'>";
                    foreach ($imgpage as $key => $page) {
                      #$url = base_url("ovj/".$hdr_id."/".min_space($value->content,"-")."#p".$page);
                      $url = base_url("ovj/".$hdr_id."/".min_space($value->content,"-")."#ptop");
                      $img = $msturi.api_ov_img($page,$path,"med");
                      echo "
                      <img src='".$img."' id='h".$page."' class='ov-image'/>";
                    }
              echo "</div>
                  </div>                
                  <div style='padding:0'>
                    <h2 style='padding:0 !important;margin:10px 0 10px 0 !important'>".$value->title."</h2>
                    <h3 style='padding: 0 0 20px 0 !important;'>".$value->lead."</h3>
                  </div>          
                  ";
                  if($halaman && is_numeric($halaman)){
                     echo "<div class='get-api-ovi' data-ovi='".str_replace(" ","-",strtolower($url1))."'>
                       <a class='hdr-ov-like'>
                        <img src='".$msturi."files/extfile/like.png' class='no'>
                        <span>0</span>
                       </a>
                       <a class='hdr-ov-cmnt'>
                       <img src='".$msturi."files/extfile/comment.png'>                      
                        <span>0</span>
                       </a>
                     </div>
                    ";
                  }
        echo "  </div>
          </div>";
      }
    echo "</div>";
      ##########################detl################
      echo '<div id="xOpenView-Dtl">';
            $cek = "";
            $ttl = count($dtl_openview)-1;
            foreach ($dtl_openview as $key => $value) {
              if($key==0){
                echo "<div class='cnt-dtl' id='".str_replace(" ","-",$value->content)."' data-title='".ucwords($value->content)."'>";
              }else{
                if($value->content!=$cek){
                  echo "</div>";
                  echo "<div class='cnt-dtl' id='".str_replace(" ","-",$value->content)."' data-title='".ucwords($value->content)."'>";
                }  
              }
              $cek = $value->content;
                $p = "<section>".$value->body_text."</section>";
                $l = "<section style='white-space: normal;'>".$value->caption."</section>";
                $ant = $value->pengantar;
                if(strlen($ant)>0){
                  $antr = "<section class='pg'>".$ant."</section>";
                }else{
                  $antr = "";
                }
                $imgpage = ganjil_genap($value->magz_page);
                $path    = $value->issue_path;
                $url1    = $value->magz_page;
                echo "<div class='content-page fisrt-content-page' data-url='".$url1."'>";
                if($value->magz_page % 2 == 0){ 
                echo "<div class='img-dtl'>
                        <div class='img-data'>";          
                        foreach ($imgpage as $key => $page) {
                          $url = base_url("ovj/".$hdr_id."/".$page);
                          $img = $msturi.api_ov_img($page,$path,"med");
                          echo "
                          <img src='".$img."' id='p".$page."' class='ov-image'/>";
                        } 
                  echo "</div>
                      </div>";
                }
                if(!empty(trim($value->title))){
                  echo "<h2 style='padding:40px 0;margin:0'>".$value->title."</h2>";
                  echo "<h3>".$value->lead."</h3>";
                }
                echo $antr;
                echo $p." ".$l;
                echo "</div>";
            $cek = $value->content;
        }
    echo "</div>";
    echo "</div>";
    echo "</div>";
  // echo "<i class='hilang'>#####</i>";
?>