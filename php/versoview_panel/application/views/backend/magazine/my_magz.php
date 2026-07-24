<?php
if($data){
	if(count((array)$data)>0){
		foreach ($data as $key => $value) {
			$bigname = strtoupper($value->magz_name);
			$lowname = strtolower($value->magz_name);
			$url     = $value->magz_url;
			$imgdata = explode(",",$value->gallery);
#			h3($imgdata[0].$imgdata[1].$value->gallery);
			$img     = $this->Mod_magazine->magazine_gallery($imgdata[0],$imgdata[1]);
			#die($img);
			$d_issue = $value->ttl_issue;
			$v_issue = $value->v_issue;
			$clr  	 = $value->basecolor;
			$s_issue = '';
			if($v_issue!=0){
				$s_issue = '<span class="desc view_issue '.$clr.'">'.$v_issue.' 
                                <i class="fas fa-eye"></i>
                            </span>';
			}
				echo '
					<div class="col-md-6 col-lg-3 p-relative">
						<a href="'.base_url("backend/panel/".$url).'">
						  <div class="statistic__item">
						    <div class="statistic__item_img">
							  <img src="'.magz_img($img).'">
						    </div>
							<h2 class="number nmp">'.$bigname.'</h2>
							<span class="desc">'.$d_issue.' issue</span><br/>
							'.$s_issue.'
						  </div>
						</a>
					</div>';
		}
	}
}else{
    "<h1>No Magazine yet</h1>";
}
?>