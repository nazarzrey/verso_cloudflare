<div class="container" style="margin-top:100px">
  <div id="cover-show" class="row text-center">
    <div class="container " style="padding: 0">
    <?php
    if($listcategory){
      foreach ($listcategory as $result) {
        $id  = $result->magz_id;
        $img = get_img($result->gambar);
        $txt = $result->magz_name;
        $hrg = $result->magz_price;
        $url = $result->magz_url;
        if($hrg==0){
          $brd = "";
        }else{
          $brd = "";
        }
        $cat = trim($result->magz_cat);
        echo '
            <a class="col-20 '.$brd.'" id="cat_'.$cat.'" href="'.base_url("magz/".$url).'">
              <div class="cover-tengah">
                <img src="'.$img.'">
                <p>'.$txt.'</p>
              </div>
            </a>';
      }
    }else{
      echo "<h1 style='margin:10% 0'>category not have data..</h1>";
    }
    ?>    
    </div>
  </div>
</div>