<?php
if($data){
	if(count($data)==1){
		$bigname = strtoupper($data->magz_name);
		$lowname = strtolower($data->magz_name);
		$url     = strtolower($data->magz_url);
		$imgdata = explode(",",$data->gallery);
	  //  die(var_dump($imgdata));
		$img     = $this->Mod_backend_magazine->magazine_gallery($imgdata[0],$imgdata[1]);
		//die(var_dump($img));
		//$img     = strtolower($data->gambar);
		$issue   = $data->ttl_issue;		
		echo '
			<div class="col-md-6 col-lg-3">
				<a class="statistic__item" href="'.admin_url("magz/".$url).'">
					<img src="'.magz_img($img->gambar).'">
					<h2 class="number nmp">'.$bigname.'</h2>
					<span class="desc">'.$issue.' issue</span><br/>
					<span class="desc">'.rand(0,1000).' view</span>
				</a>
			</div>';
	}else{
		foreach ($data as $key => $value) {
			$bigname = strtoupper($value->magz_name);
			$lowname = strtolower($value->magz_name);
			$url     = strtolower($value->magz_url);
			$imgdata = explode(",",$value->gallery);
		  //  die(var_dump($imgdata));
			$img     = $this->Mod_backend_magazine->magazine_gallery($imgdata[0],$imgdata[1]);
			//die(var_dump($img));
			//$img     = strtolower($value->gambar);
			$issue   = $value->ttl_issue;


			  //  $data["data"] = $this->Mod_backend_magazine->magazine_gallery($this->session->userdata('uid'));
				//magazine_gallery
								echo '
									<div class="col-md-6 col-lg-3">
										<a class="statistic__item" href="'.admin_url("magz/".$url).'">
											<img src="'.magz_img($img->gambar).'">
											<h2 class="number nmp">'.$bigname.'</h2>
											<span class="desc">'.$issue.' issue</span><br/>
											<span class="desc">'.rand(0,1000).' view</span>
										</a>
									</div>';
		}
	}
}else{
    "<h1>No Magazine yet</h1>";
}
?>