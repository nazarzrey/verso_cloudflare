<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxrequest extends CI_Controller {
	function __construct() {
		parent::__construct();
    	// $this->load->library('session');
    	$this->load->model(array('Mod_request'));
	}
	#index
	public function index($value=""){
	}
	public function api_magz(){
		$sintak = "select lower(title) as title,path,description,href,image from api_magazine";
		#$hasil  = "";
		/*
		foreach($data as $result){
			echo $hasil .= $result->path;
		}
		*/
		if(count($this->Mod_request->api_each_query($sintak))<=1){			
			$data[] = $this->Mod_request->api_each_query($sintak);
		}else{
			$data = $this->Mod_request->api_each_query($sintak);
		}
		echo json_encode($data);
	}
	public function api_popular(){
		$sintak = "select lower(title) as title,path,description,href,image from api_magazine LIMIT 3";	
		if(count($this->Mod_request->api_each_query($sintak))<=1){			
			$data["data"][] = $this->Mod_request->api_each_query($sintak);
		}else{
			$data["data"] = $this->Mod_request->api_each_query($sintak);
		}			
		echo json_encode($data);
	}
	public function api_last_magazine(){
		$sintak = "select UPPER(title) as title,description,href from api_magazine LIMIT 1";
		$data = $this->Mod_request->api_each_query($sintak);
		echo json_encode($data);
	}
	public function api_ads(){
		$sintak = "select * from api_ads";
		$data   = $this->Mod_request->api_each_query($sintak);
		echo json_encode($data);
	}
	public function user($value='')
	{
		if($value=="register"){
			if($this->input->post("username")){
			    $this->form_validation->set_rules('username', 'username', 'required|trim');
			    $this->form_validation->set_rules('email', 'email', 'required|trim');
			    $this->form_validation->set_rules('password', 'password', 'required|trim');
				$name = $this->input->post("username");
				$mail = $this->input->post("email");
				$pass = $this->input->post("password");
				#$this->Mod_request->update($id,$value,$modul);
				$data["status"] = $this->Mod_request->register($name,$mail,$pass);
				echo json_encode($data);
			}else{
				echo "{}";
			}
		}elseif($value=="login"){
			if($this->input->post("useremail")){
			    $this->form_validation->set_rules('useremail', 'useremail', 'required|trim');
			    $this->form_validation->set_rules('password', 'password', 'required|trim');
				$mail = $this->input->post("useremail");
				$pass = $this->input->post("password");
				#$this->Mod_request->update($id,$value,$modul);
				$data["status"] = $this->Mod_request->login($mail,$pass);
				echo json_encode($data);
			}else{
				echo "{}";
			}
		}else{
			die();
		}
	}
	public function upload($value=''){
		$config['upload_path']          = './pdf_temp/';
		$config['allowed_types']        = 'gif|jpg|png|pdf';
		$config['max_size']             = 1024000;
 		$str = array(" ","&","'",'"',"/","\\","*","@","!","#","$","%","^","(",")");
		$uid = $this->input->post("uid");
		$cat = $this->input->post("pdf_category");
		$jdl = $this->input->post("pdf_title");
		$des = $this->input->post("pdf_desc");
		$magz = strtolower(str_replace($str,"",$jdl));
		$url  = $magz.tgl("sort");
		$uri  = "admin/magz/".$magz;
		$cek  = $this->Mod_request->magz_title_cek($jdl);
		// status 1=alerady title,0=ok insert,2=error process
		if($cek==1){
			$array = array("exits");
			echo json_encode($array);
		}else{
			$this->load->library('upload', $config); 
			if ( ! $this->upload->do_upload('new-pdf')){
				$error = array('error' => $this->upload->display_errors());
				echo json_encode(array($error));
				//$this->load->view('v_upload', $error);
			}else{
				$data   = array('upload_data' => $this->upload->data(),$url);
				$status = $this->Mod_request->magz_created($cat,$magz,$url,$jdl,$des,$uid,$data["upload_data"]["file_name"]);
				echo json_encode(array($status,$uri));
			}
		}
	}
	public function convert($value)
	{		
		ini_set('display_errors', true);
		ini_set('max_execution_time', 0);
		ini_set('upload_max_filesize', '100M');
		ini_set('post_max_size', '100M');
		ini_set('client_max_body_size', '100M');
		error_reporting(E_ALL);
		/**/
		    $file 	  	= 'book.zip';    
		    $imagename  = $this->Mod_request->magz_name($value);
		    $pdfname  	= $this->Mod_request->magz_pdf($value);
			$directory 	= "/var/www/html/";
		    $foldername = "pageturner/".str_replace(" ","",$imagename);
		    #    if (!is_dir($foldername)) { mkdir($foldername); }
			
		    $path       = $directory.$foldername."/";
		    $path2      = $directory."magazine/cover/";
		    $saveAsPath = $directory.$foldername."/files/";
		    $filepdf 	= $directory."/pdf_temp/".$pdfname;
			$title      = ucwords(strtolower($imagename))." Magazine";
			$iconfile  	= "ico_".strtolower(str_replace(" ","-",$imagename)).tgl("sort").".jpg";
			
		    $zip = new ZipArchive;			
		    $res = $zip->open($file);
		    if ($res === TRUE) {
		        $zip->extractTo($path);
		        $zip->close();		        
		        // echo "WOOT! $file extracted to $path";
		    }
			$im = new imagick();
			$im->setResolution(200, 200);  
			$im->readImage($filepdf);
			#die(tgl("full"));
			$im->setImageFormat('jpeg');			
			$im->setImageAlphaChannel(imagick::ALPHACHANNEL_REMOVE);
			$im->mergeImageLayers(imagick::LAYERMETHOD_FLATTEN);
			$im->setImageBackgroundColor('white');
			$num_pages = $im->getNumberImages();
			//for ($i = 0; $i < $num_pages; $i++) {
			for ($i = 0; $i < $num_pages; $i++) {
				$a = $i + 1;
				$temp  = $saveAsPath . "temp/" . $a.'.jpg';
				$move  = $saveAsPath . "page/" . $a.'.jpg';
				$thumb = $saveAsPath . "thumb/" . $a.'.jpg';
				$im->setIteratorIndex($i);					
				
				// $im->resizeImage( 1240, 1654, Imagick::FILTER_SINC, 0.1, false );  				
				$im->setImageCompression(imagick::COMPRESSION_JPEG); 
				$im->setImageCompressionQuality(300);					
		        $im->writeImage($temp);	
				#echo $temp;				
				if(file_exists($temp)){
					if(filesize($temp)<=1024000){
						copy($temp,$move);
						ak_img_resize($temp,$thumb, 270, 360, "jpg");
					}else{						
						ak_img_resize($temp,$move, 1240, 1654, "jpg");
						ak_img_resize($temp,$thumb, 270, 360, "jpg");
					}
					unlink($temp);
				}
			}
		    $im->clear(); 
		    $im->destroy();
			
			
			$thumb = $path."/files/thumb/1.jpg";
			$icon  = $path2.$iconfile;
		    if(file_exists($thumb)){
		    	copy($thumb,$icon);
		    }
			$linklogo 	 = "";
			$downloadurl = "";
			$fileconfig  = $path."/javascript/config.js";
			if (file_exists($fileconfig)) unlink($fileconfig);
			$myfile = fopen($fileconfig, "w") or die("Unable to open file!");
			$str = "";

			$str = $str."var flipstyle;\n";
			$str = $str."var flippingTime;\n";
			$str = $str."var HomeButtonVisible;\n";
			$str = $str."var HomeURL;\n";
			$str = $str."var ShareButtonVisible;\n";
			$str = $str."var FlipSound;\n";
			$str = $str."var backGroundImgURL;\n";
			$str = $str."var DownloadButtonVisible;\n";
			$str = $str."var PrintButtonVisible;\n";
			$str = $str."var appLogoIcon = \"files/extfile/logo.png\";\n";
			$str = $str."var appLogoLinkURL = \"$linklogo/\";\n";
			$str = $str."var bookTitle = \"$title\";\n";
			$str = $str."var bookDescription = \"$title\";\n";
			$str = $str."var DownloadURL = \"$downloadurl\";\n";
			$str = $str."\n";
			$str = $str."if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {\n";
			$str = $str."    flipstyle = \"Slide\";\n";
			$str = $str."    flippingTime = 0;\n";
			$str = $str."    HomeButtonVisible = \"Show\";\n";
			$str = $str."    HomeURL = \"/\";\n";
			$str = $str."    DownloadButtonVisible = \"Hide\";\n";
			$str = $str."    ShareButtonVisible = \"Show\";\n";
			$str = $str."    FlipSound = \"No\";\n";
			$str = $str."    backGroundImgURL = \"files/extfile/bg.jpg\";\n";
			$str = $str."    $(\".button[title='Print']\").hide();\n";
			$str = $str."    PrintButtonVisible = \"Hide\";\n";
			$str = $str."}else{\n";
			$str = $str."    flipstyle = \"Flip\";\n";
			$str = $str."    flippingTime = 0.6;\n";
			$str = $str."    HomeButtonVisible = \"Hide\";\n";
			$str = $str."    HomeURL = \"\";\n";
			$str = $str."    DownloadButtonVisible = \"Show\";\n";
			$str = $str."    ShareButtonVisible = \"Hide\";\n";
			$str = $str."    FlipSound = \"Yes\";\n";
			$str = $str."    backGroundImgURL = \"files/extfile/bg.jpg\";\n";
			$str = $str."    $(\".button[title='Print']\").show();\n";
			$str = $str."    PrintButtonVisible = \"Show\";\n";
			$str = $str."}\n";

			$str = $str."if( /iPhone|iPad|iPod/i.test(navigator.userAgent) ) {\n";
			$str = $str."    $('head').append( '<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no\">' );\n";
			$str = $str."}\n";
			$str = $str."function orgt(s){ return binl2hex(core_hx(str2binl(s), s.length * chrsz));}var bookConfig={DownloadButtonVisible: DownloadButtonVisible,    BookmarkButtonVisible : \"Show\",searchColor : \"#00ffff\", searchAlpha : 0.3, leastSearchChar : 0, CreatedBy:\"Flip HTML5 for windows 6.3.7.0\",BookTemplateName:\"Handy\",loadingBackground:\"#323232\",searchPositionJS:\"files/search/text_position[%d].js\",loadingCaption:\"Loading\",loadingCaptionColor:\"#DDDDDD\",loadingBackground:\"#1F2232\",loadingPicture:\"files/extfile/loading.png\",bgBeginColor:\"#323232\",bgEndColor:\"#323232\",bgMRotation:90,backGroundImgURL:backGroundImgURL,backgroundPosition:\"Stretch\",backgroundOpacity:100,backgroundScene:\"None\",LeftShadowWidth:100,LeftShadowAlpha:1,RightShadowWidth:40,RightShadowAlpha:1,ShowTopLeftShadow:\"Yes\",FlipStyle:flipstyle,FlipDirection:\"0\",autoDoublePage:\"Yes\",showMirrorSide:\"Show\",retainBookCenter:\"Yes\",isTheBookOpen:\"No\",RightToLeft:\"No\",pageBackgroundColor:\"#FFFFFF\",OriginPageIndex:1,flipshortcutbutton:\"Show\",QRCode:\"Hide\",thicknessWidthType:\"thick\",thicknessColor:\"#FFFFFF\",BindingType:\"side\",HardPageEnable:\"No\",hardCoverBorderWidth:8,cornerRound:8,borderColor:\"#572F0D\",outerCoverBorder:\"Yes\",coverTexture:\"none\",HardInnerPageEnable:\"No\",totalPagesCaption:\"\",pageNumberCaption:\"\",leftMargin:10,topMargin:10,rightMargin:10,bottomMargin:10,leftMarginOnMobile:0,topMarginOnMobile:0,rightMarginOnMobile:0,bottomMarginOnMobile:0,bleedAreaLeft:\"0%\",bleedAreaTop:\"0%\",bleedAreaRight:\"0%\",bleedAreaBottom:\"0%\",maxWidthToSmallMode:\"400\",maxHeightToSmallMode:\"300\",appLogoIcon:\"\",appLogoLinkURL:\"\",appLogoOpenWindow:\"Blank\",bookTitle:bookTitle,bookDescription:bookDescription,toolbarColor:\"#264D60\",iconColor:\"#EEEEEE\",iconFontColor:\"#EEEEEE\",pageNumColor:\"#111111\",formBackgroundColor:\"#111111\",formFontColor:\"#EEEEEE\",logoHeight:\"25\",logoPadding:\"10\",logoTop:\"8\",FirstButtonIcon:\"\",PreviousButtonIcon:\"\",NextButtonIcon:\"\",LastButtonIcon:\"\",enablePageBack:\"Hide\",BackwardButtonIcon:\"\",ForwardButtonIcon:\"\",HomeButtonVisible:HomeButtonVisible,HomeURL:HomeURL,HomeButtonIcon:\"\",AnnotationButtonVisible:\"Hide\",AnnotationButtonIcon:\"\",ShareButtonVisible:\"Hide\",ShareButtonIcon:\"\",ThumbnailsButtonVisible:\"Show\",thumbnailAlpha:100,ThumbnailButtonIcon:\"\",ZoomButtonVisible:\"Show\",ZoomInButtonIcon:\"\",ZoomOutButtonIcon:\"\",FullscreenButtonVisible:\"Hide\",FullscreenButtonIcon:\"\",ExitFullscreenButtonIcon:\"\",BookMarkButtonVisible:\"Hide\",BookmarkButtonIcon:\"\",TableOfContentButtonVisible:\"Show\",TableOfContentButtonIcon:\"\",SearchButtonVisible:\"Hide\",leastSearchChar:3,searchKeywordFontColor:\"#FFB000\",SearchButtonIcon:\"\",SelectTextButtonVisible:\"Hide\",SelectTextButtonIcon:\"\",PrintButtonVisible:PrintButtonVisible,PrintButtonIcon:\"\",printWatermarkFile:\"\",BackgroundSoundButtonVisible:\"Hide\",BackgroundSoundURL:\"\",BackgroundSoundLoop:-1,BackgroundSoundButtonOnIcon:\"\",BackgroundSoundButtonOffIcon:\"\",HelpButtonVisible:\"Hide\",helpContentFileURL:\"\",helpWidth:400,helpHeight:450,showHelpContentAtFirst:\"No\",HelpButtonIcon:\"\",InstructionsButtonVisible:\"Show\",aboutButtonVisible:\"Hide\",CompanyLogoFile:\"\",AboutButtonIcon:\"\",AutoPlayButtonVisible:\"Show\",autoPlayAutoStart:\"No\",autoPlayDuration:3,autoPlayLoopCount:1,AutoPlayStartButtonIcon:\"\",AutoPlayStopButtonIcon:\"\",minZoomWidth:403,minZoomHeight:518,DownloadButtonVisible:DownloadButtonVisible,DownloadButtonIcon:\"\",DownloadURL:DownloadURL,VideoButtonVisible:\"Hide\",VideoButtonIcon:\"\",SlideshowButtonVisible:\"Hide\",SlideshowButtonIcon:\"\",PhoneButtonVisible:\"Hide\",PhoneButtonIcon:\"\",FlipSound:FlipSound,flippingTime:flippingTime,mouseWheelFlip:\"Yes\",CurlingPageCorner:\"Yes\",updateURLForPage:\"Yes\",OpenWindow:\"Blank\",showLinkHint:\"No\",haveAdSense:\"No\",adSenseWidth:200,adSenseHeight:200,adSenseLeft:50,adSenseTop:50,adSenseClientId:\"\",googleAnalyticsID:\"\",language: \"English\",AboutAddress: \"Guang Dong Guang Zhou China\",AboutEmail: \"support@fliphtml5.com\",AboutMobile: \"\",AboutWebsite: \"http://www.fliphtml5.com\",AboutDescription: \"FlipHTML5 Software Co., Ltd., established in 2010, is headquartered in China, with branch offices in HongKong China. We have focused on Digital Flip Book publishing tools for years, and been the leading flipbook software provider in the world. We supply to customers all over the world. We are committed to offering cost-effective software and service for commercial or personal use.\", AboutAuthor: \"fliphtml5.com\",SlideshowAutoPlay: false,SlideshowPlayInterval: 5,totalPageCount:$num_pages,largePageWidth:1240,largePageHeight:1654,normalPath:\"files/page/\",largePath:\"files/page/\",thumbPath:\"files/thumb/\"}\n";
			$str = $str." var fliphtml5_pages=[";
			for ($x = 1; $x <= $num_pages; $x++) {
				$str = $str."{\"l\":\"files/page/$x.jpg\", \"n\":\"files/page/$x.jpg\", \"t\":\"files/thumb/$x.jpg\"}";
				if ($x < $num_pages) $str = $str.",";
			}
			$lst = $x;
			$str = $str."];\n";
			$str = $str."var language = [{language : \"english\",btnFirstPage : \"First\",btnNextPage : \"Next\",btnLastPage : \"Last\",btnPrePage : \"Previous\",btnGoToHome : \"Home\",btnDownload : \"Download\",btnSoundOn : \"Sound On\",btnSoundOff : \"Sound Off\",btnPrint : \"Print\",btnThumb : \"Thumbnails\",btnBookMark : \"Bookmark\",frmBookMark : \"Bookmark\",btnZoomIn : \"Zoom In\",btnZoomOut : \"Zoom Out\",btnAutoFlip : \"Auto Flip\",btnStopAutoFlip : \"Stop Auto Flip\",btnSocialShare : \"Share\",btnHelp : \"Help\",btnAbout : \"About\",btnSearch : \"Search\",btnFullscreen : \"Fullscreen\",btnExitFullscreen : \"Exit Fullscreen\",btnMore : \"More\",frmPrintCaption : \"Print\",frmPrintall : \"Print All Pages\",frmPrintcurrent : \"Print Current Page\",frmPrintRange : \"Print Range\",frmPrintexample : \"Example: 2,3,5-10\",frmPrintbtn : \"Print\",frmShareCaption : \"Share\",frmShareLabel : \"Share\",frmShareInfo : \"You can easily share this publication to social networks.Just click the appropriate button below\",frminsertLabel : \"Insert to Site\",frminsertInfo : \"Use the code below to embed this publication to your website.\",frmaboutcaption : \"Contact\",frmaboutcontactinformation : \"Contact Information\",frmaboutADDRESS : \"Address\",frmaboutEMAIL : \"Email\",frmaboutWEBSITE : \"Website\",frmaboutMOBILE : \"Mobile\",frmaboutAUTHOR : \"Author\",frmaboutDESCRIPTION : \"Description\",frmSearch : \"Search\",frmToc : \"Table Of Contents\",btnTableOfContent : \"Table Of Contents\",btnNote : \"Annotation\",lblLast : \"This is the last page.\",lblFirst : \"This is the first page.\",lblFullscreen : \"Click to view in fullscreen\",lblName : \"Name\",lblPassword : \"Password\",lblLogin : \"Login\",lblCancel : \"Cancel\",lblNoName : \"User name can not be empty.\",lblNoPassword : \"Password can not be empty.\",lblNoCorrectLogin : \"Please enter the correct user name and password.\",btnVideo : \"Video Gallery\",btnSlideShow : \"Slideshow\",pnlSearchInputInvalid : \"The search text is too short.\",btnDragToMove : \"Move by mouse drag\",btnPositionToMove : \"Move by mouse position\",lblHelp1 : \"Drag the page corner to view\",lblHelp2 : \"Double click to zoom in, out\",lblCopy : \"Copy\",lblAddToPage : \"Add To Page\",lblPage : \"Page\",lblTitle : \"Title\",lblEdit : \"Edit\",lblDelete : \"Delete\",lblRemoveAll : \"Remove All\",tltCursor : \"Cursor\",tltAddHighlight : \"Add highlight\",tltAddTexts : \"Add texts\",tltAddShapes : \"Add shapes\",tltAddNotes : \"Add notes\",tltAddImageFile : \"Add image file\",tltAddSignature : \"Add signature\",tltAddLine : \"Add line\",tltAddArrow : \"Add arrow\",tltAddRect : \"Add rect\",tltAddEllipse : \"Add ellipse\",lblDoubleClickToZoomIn : \"Double click to zoom in.\",lblPages : \"Pages\",infCopyToClipboard : \"Your browser dose not support clipboard, please do it yourself.\",lblDescription : \"Title\",frmLinkLabel : \"Link\",infNotSupportHtml5 : \"Your browser does not support HTML5.\",frmHowToUse : \"How To Use\",lblHelpPage1 : \"Move your finger to flip the book page.\",lblHelpPage2 : \"Zoom in by using gesture or double click on the page.\",lblHelpPage3 : \"Click on the logo to reach the official website of the company.\",lblHelpPage4 : \"Add bookmarks, use search function and auto flip the book.\",lblHelpPage5 : \"Switch horizontal and vertical view on mobile devices.\",frmQrcodeCaption : \"Scan the bottom two-dimensional code to view with mobile phone.\",btnPageBack : \"Backward\",btnPageForward : \"Forward\",btnLanguage : \"Change Language\",msgConfigMissing : \"Configuration file is missing, unable to open the book.\",frmTelephone : \"Tel\",btnDialing : \"Call\",lblSelectMessage : \"Please copy the the text content in the text box.\",btnSelectText : \"Select Text\"}];\n";
			$str = $str."var ols=[{\"caption\":\"First Page\",\"page\":1,\"level\":1,\"children\":[]},{\"caption\":\"Last Page\",\"page\":$lst,\"level\":1,\"children\":[]}];\n";
			$str = $str." var bmtConfig = [];\n";
			$str = $str."var staticAd ={\"haveAd\":false, \"interval\":3000, \"data\":[]};\n";
			$str = $str."var videoList=[];\n";
			$str = $str."var slideshow =[];\n";
			$str = $str."var flipByAudio = {\"audioType\":0,\"audioFile\":\"\",\"showPlayer\":false,\"items\":[]};\n";
			$str = $str."var phoneNumber = [];\n";
			$str = $str."var bookPlugin = null;\n";

			fwrite($myfile, $str);
			fclose($myfile);

			
		    $pdfname  	= $this->Mod_request->magz_update($value,$iconfile);
			echo "ok";
		/**/
	}	
}