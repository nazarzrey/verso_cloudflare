<?php
if($data){
    foreach ($data as $key => $value) {
        $bigname = strtoupper($value->magz_name);
        $lowname = strtolower($value->magz_name);
        $url     = strtolower($value->magz_url);
        $img     = strtolower($value->gambar);
        $issue   = strtolower($value->ttl_issu);

                            echo '
                                <div class="col-md-6 col-lg-3">
                                    <a class="statistic__item" href="'.admin_url("magz/".$url).'">
                                        <img src="'.magz_img($img).'">
                                        <h2 class="number nmp">'.$bigname.'</h2>
                                        <span class="desc">'.$issue.' issue</span><br/>
                                        <span class="desc">'.rand(0,1000).' view</span>
                                    </a>
                                </div>';
    }
}else{
    "<h1>No Magazine yet</h1>";
}
?>