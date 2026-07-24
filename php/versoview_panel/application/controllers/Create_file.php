<?php

function analytics($ga_id){
	if($ga_id!="0"){
		$gatags = "
	  <script async src='https://www.googletagmanager.com/gtag/js?id=$ga_id'></script>
	  <script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', '$ga_id');
	  </script>";
	}else{
		$gatags = "";
	}
	return $gatags;

}

function create_index($path,$magz_id,$ga){
	#echo $ga;
	$fileindex  = $path."/index.html";
	if (file_exists($fileindex)) unlink($fileindex);
	$myfile = fopen($fileindex, "w") or die("Unable to open file!");
	$record = '
	<script>
		$(document).ready(function(){
		 	var medheight = window.innerHeight;
		 	var medwidth = window.innerWidth;
			$uri   = window.location.href;
			$media = medheight+"x"+medwidth;
			$url = "'.base_url("").'";
	        $.ajax({
	        	url  : $url+"/ajax/record/log/'.$magz_id.'",
	        	type : "post",        	
				dataType : "json",
	        	data : "media="+$media+"&url="+$uri,
				success: function(data, status, xhr){
				},
				error: function(xhr, status, error){
				}
	        });   
		})
	</script>
	';
	$str    = '
	<!DOCTYPE HTML>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="monitor-signature" content="monitor:player:html5">

	<meta property="og:image" content="files/thumb/1.jpg"/>
	<meta property="og:title" content=""/> 
	<meta property="og:description" content="" />
	<meta name="og:image" content="files/thumb/1.jpg"/>
	<link rel="image_src" href="files/thumb/1.jpg"/>

	<meta name="Description" content="">

	<link rel="stylesheet" href="style/scrollbar.css" />
	<link rel="stylesheet" href="style/style.css" />
	<link rel="stylesheet" href="style/player.css" />
	<link rel="stylesheet" href="style/phoneTemplate.css" />
	<script src="javascript/jquery-1.9.1.min.js"></script>
	'.$record.'
	'.analytics($ga).'
	</head>	
	<body>
	<script src="javascript/config.js"></script>
	<script src="javascript/LoadingJS.js"></script>
		
	<script src="javascript/main.js"></script>
	<script src="javascript/editor.js"></script>
	<script src="files/search/book_config.js"></script>
	<link rel="stylesheet" href="style/template.css" />

	<script src="javascript/MovingBackgrounds.min.js"></script>
	<link rel="stylesheet" href="style/MovingBackgrounds.min.css" />
	<script src="javascript/FlipBookPlugins.min.js"></script>
	<link rel="stylesheet" href="style/FlipBookPlugins.min.css" />
	<script src="javascript/flipHtml5.hiSlider2.min.js"></script>
	<link rel="stylesheet" href="style/hiSlider2.min.css" />
	<script src="slide_javascript/slideJS.js"></script>

	</body>
	</html>';		
	fwrite($myfile, $str);
	fclose($myfile);
}

function create_config($path,$num_pages){	
	global $title;
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
	$str = $str."function orgt(s){ return binl2hex(core_hx(str2binl(s), s.length * chrsz));}var bookConfig={DownloadButtonVisible: DownloadButtonVisible,    BookmarkButtonVisible : \"Show\",searchColor : \"#00ffff\", searchAlpha : 0.3, leastSearchChar : 0, CreatedBy:\"Flip HTML5 for windows 6.3.7.0\",BookTemplateName:\"Handy\",loadingBackground:\"#323232\",searchPositionJS:\"files/search/text_position[%d].js\",loadingCaption:\"Loading\",loadingCaptionColor:\"#DDDDDD\",loadingBackground:\"#1F2232\",loadingPicture:\"files/extfile/loading.png\",bgBeginColor:\"#323232\",bgEndColor:\"#323232\",bgMRotation:90,backGroundImgURL:backGroundImgURL,backgroundPosition:\"Stretch\",backgroundOpacity:100,backgroundScene:\"None\",LeftShadowWidth:100,LeftShadowAlpha:1,RightShadowWidth:40,RightShadowAlpha:1,ShowTopLeftShadow:\"Yes\",FlipStyle:flipstyle,FlipDirection:\"0\",autoDoublePage:\"Yes\",showMirrorSide:\"Show\",retainBookCenter:\"Yes\",isTheBookOpen:\"No\",RightToLeft:\"No\",pageBackgroundColor:\"#FFFFFF\",OriginPageIndex:1,flipshortcutbutton:\"Show\",QRCode:\"Hide\",thicknessWidthType:\"thick\",thicknessColor:\"#FFFFFF\",BindingType:\"side\",HardPageEnable:\"No\",hardCoverBorderWidth:8,cornerRound:8,borderColor:\"#572F0D\",outerCoverBorder:\"Yes\",coverTexture:\"none\",HardInnerPageEnable:\"No\",totalPagesCaption:\"\",pageNumberCaption:\"\",leftMargin:10,topMargin:10,rightMargin:10,bottomMargin:10,leftMarginOnMobile:0,topMarginOnMobile:0,rightMarginOnMobile:0,bottomMarginOnMobile:0,bleedAreaLeft:\"0%\",bleedAreaTop:\"0%\",bleedAreaRight:\"0%\",bleedAreaBottom:\"0%\",maxWidthToSmallMode:\"400\",maxHeightToSmallMode:\"300\",appLogoIcon:\"\",appLogoLinkURL:\"\",appLogoOpenWindow:\"Blank\",bookTitle:bookTitle,bookDescription:bookDescription,toolbarColor:\"#22305F\",iconColor:\"#EEEEEE\",iconFontColor:\"#EEEEEE\",pageNumColor:\"#111111\",formBackgroundColor:\"#111111\",formFontColor:\"#EEEEEE\",logoHeight:\"25\",logoPadding:\"10\",logoTop:\"8\",FirstButtonIcon:\"\",PreviousButtonIcon:\"\",NextButtonIcon:\"\",LastButtonIcon:\"\",enablePageBack:\"Hide\",BackwardButtonIcon:\"\",ForwardButtonIcon:\"\",HomeButtonVisible:HomeButtonVisible,HomeURL:HomeURL,HomeButtonIcon:\"\",AnnotationButtonVisible:\"Hide\",AnnotationButtonIcon:\"\",ShareButtonVisible:\"Hide\",ShareButtonIcon:\"\",ThumbnailsButtonVisible:\"Show\",thumbnailAlpha:100,ThumbnailButtonIcon:\"\",ZoomButtonVisible:\"Show\",ZoomInButtonIcon:\"\",ZoomOutButtonIcon:\"\",FullscreenButtonVisible:\"Hide\",FullscreenButtonIcon:\"\",ExitFullscreenButtonIcon:\"\",BookMarkButtonVisible:\"Hide\",BookmarkButtonIcon:\"\",TableOfContentButtonVisible:\"Hide\",TableOfContentButtonIcon:\"\",SearchButtonVisible:\"Hide\",leastSearchChar:3,searchKeywordFontColor:\"#FFB000\",SearchButtonIcon:\"\",SelectTextButtonVisible:\"Hide\",SelectTextButtonIcon:\"\",PrintButtonVisible:PrintButtonVisible,PrintButtonIcon:\"\",printWatermarkFile:\"\",BackgroundSoundButtonVisible:\"Hide\",BackgroundSoundURL:\"\",BackgroundSoundLoop:-1,BackgroundSoundButtonOnIcon:\"\",BackgroundSoundButtonOffIcon:\"\",HelpButtonVisible:\"Hide\",helpContentFileURL:\"\",helpWidth:400,helpHeight:450,showHelpContentAtFirst:\"No\",HelpButtonIcon:\"\",InstructionsButtonVisible:\"Show\",aboutButtonVisible:\"Hide\",CompanyLogoFile:\"\",AboutButtonIcon:\"\",AutoPlayButtonVisible:\"Show\",autoPlayAutoStart:\"No\",autoPlayDuration:3,autoPlayLoopCount:1,AutoPlayStartButtonIcon:\"\",AutoPlayStopButtonIcon:\"\",minZoomWidth:403,minZoomHeight:518,DownloadButtonVisible:DownloadButtonVisible,DownloadButtonIcon:\"\",DownloadURL:DownloadURL,VideoButtonVisible:\"Hide\",VideoButtonIcon:\"\",SlideshowButtonVisible:\"Hide\",SlideshowButtonIcon:\"\",PhoneButtonVisible:\"Hide\",PhoneButtonIcon:\"\",FlipSound:FlipSound,flippingTime:flippingTime,mouseWheelFlip:\"Yes\",CurlingPageCorner:\"Yes\",updateURLForPage:\"Yes\",OpenWindow:\"Blank\",showLinkHint:\"No\",haveAdSense:\"No\",adSenseWidth:200,adSenseHeight:200,adSenseLeft:50,adSenseTop:50,adSenseClientId:\"\",googleAnalyticsID:\"\",language: \"English\",AboutAddress: \"Guang Dong Guang Zhou China\",AboutEmail: \"support@fliphtml5.com\",AboutMobile: \"\",AboutWebsite: \"http://www.fliphtml5.com\",AboutDescription: \"FlipHTML5 Software Co., Ltd., established in 2010, is headquartered in China, with branch offices in HongKong China. We have focused on Digital Flip Book publishing tools for years, and been the leading flipbook software provider in the world. We supply to customers all over the world. We are committed to offering cost-effective software and service for commercial or personal use.\", AboutAuthor: \"fliphtml5.com\",SlideshowAutoPlay: false,SlideshowPlayInterval: 5,totalPageCount:$num_pages,largePageWidth:1240,largePageHeight:1654,normalPath:\"files/page/\",largePath:\"files/page/\",thumbPath:\"files/thumb/\"}\n";
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
}
?>