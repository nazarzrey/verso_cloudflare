  <div id="cover-show" class="row text-center">
    <div class="container " style="padding: 0">
    <?php
    foreach ($datacover as $result) {
      $id  = $result->magz_id;
      $img = get_img($result->cover);
      $txt = $result->magz_name;
      $hrg = $result->magz_price;
      $url = $result->magz_url;
      if($result->magz_fk_issue>0){        
        if(get_cover($result->gambar)=="x"){
          $img = $img;
        }else{          
          $img = get_cover($result->gambar);
        }
      }
      #echo h3($img);
      #die;
      $iss = $result->magz_fk_issue;
      if($hrg==0){
        $brd = "";
      }else{
        $brd = "";
      }
      $cat = trim($result->magz_cat);
      echo '
          <a class="col-20 '.$brd.' data_cover" id="cat_'.$cat.'" href="'.base_url("magz/".$url).'">
            <div class="cover-tengah slideanim">
              <img src="'.$img.'">
              <p>'.$txt.'</p>
            </div>
          </a>';
    }
    ?>
    
    </div>
  </div>