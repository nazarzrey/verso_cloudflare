<?php
if(count($argv)){
	$path = explode("=",$argv[1]);
	$pdf  = explode("=",$argv[2]);
	$page = explode("=",$argv[3]);
	if(count($path)>1 && count($pdf)>1 && count($page)>1){
		#echo $pdf[1]." ".$path[1]." ".$page[1];
		$xpage = explode(",", $page[1]);
		if(count($xpage)>1){
			$dir   = __DIR__ . DIRECTORY_SEPARATOR;
			$start = $xpage[0];
			$end   = $xpage[1];
			#$filepdf    = $dir."pdf_temp/".$pdf[1];
			#$saveAsPath = $dir."pageturner/".$path[1];
			$filepdf    = $pdf[1];
			$saveAsPath = $path[1];
			if(strpos($saveAsPath, 'files/') !== false){
				$xpath = $saveAsPath;
			}else{
				$xpath = $saveAsPath."files/";
			}
			if(file_exists($filepdf)){
				for ($x = $start; $x <= $end - 1; $x++) {
					$xx = $x +1;
					#$move  = $saveAsPath . "/files/page/" . $xx.'.jpg';
					#$thumb = $saveAsPath . "/files/thumb/" . $xx.'.jpg';
					$move   = $xpath . "page/" . $xx.'.jpg';
					$thumb  = $xpath . "thumb/" . $xx.'.jpg';
					$med    = $xpath . "medium/" . $xx.'.jpg';
					$big    = sys('conv').' -colorspace sRGB -density 220 '.$filepdf.'['.$x.'] -set units PixelsPerInch -alpha remove  -quality 50 '.$move;
					$small  = sys('conv').' -colorspace sRGB -density  50 '.$filepdf.'['.$x.'] -set units PixelsPerInch -alpha remove  -quality 50 '.$thumb;
					$medium = sys('conv').' -colorspace sRGB -density  100 '.$filepdf.'['.$x.'] -set units PixelsPerInch -alpha remove  -quality 50 '.$med;
					if(!file_exists($move)){
						shell_exec($big);
					}
					if(!file_exists($thumb)){
						shell_exec($small);
					}
					if(!file_exists($med)){
						shell_exec($medium);
					}
				}
			}else{
				echo $filepdf." not exists";
			}
		}
	}
}


function sys($tipe) {
	if (DIRECTORY_SEPARATOR == '\\') {
		$conv  = "magick ";
	}else{		
		$conv  = "convert ";
	}
	return $conv;
}