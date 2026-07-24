  <div id="cover-show" class="row text-center">
    <div class="container " style="padding: 0">
    <?php
    if($datacover){
      if(count($datacover)>0){
        foreach ($datacover as $key => $value) {
          $bigname = strtoupper($value->magz_name);
          $lowname = strtolower($value->magz_name);
          $url     = $value->magz_url;
          $imgdata = explode(",",$value->gallery);

          $id  = $value->magz_id;
          $txt = $value->magz_name;
          $hrg = $value->magz_price;
          $cat = trim($value->magz_cat);

          if($hrg==0){
            $brd = "";
          }else{
            $brd = "";
          }
          #echo $imgdata[1];
          if($imgdata[1]!=0){
            $img     = $this->Mod_magazine->magazine_gallery($imgdata[0],$imgdata[1]);
            echo '
            <a class="col-20 '.$brd.' data_cover" id="cat_'.$cat.'" href="'.base_url("magz/".$url).'">
              <div class="cover-tengah slideanim">
                <img src="'.$img.'">
                <p>'.$txt.'</p>
              </div>
            </a>';
          }
        }
      }
    }
    ?>
    
    </div>
  </div>