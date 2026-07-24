  <div class="col-sm-12 categories">
    <h3 class="text-left category_all" style="padding-left: 20px;">Categories</h3>
    <?php
    foreach ($datacategory as $result) {
      $img = get_img($result->assets_path.$result->assets_image1);
      $txt = $result->cat_name;
      $id  = $result->cat_id;
       echo '
              <div class="col-lg-1 category" id="cat_'.$id.'">
                <div>
                  <img src="'.$img.'">
                </div>
                <span>'.$txt.'</span>
              </div>';
    }
    ?>
  </div>