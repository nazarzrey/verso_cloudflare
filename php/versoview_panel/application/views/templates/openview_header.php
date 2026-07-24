<?php 

  $jdl  = "Home";
  $uri  = base_url("login")."/";
  $path = $uri;
  if(isset($dtl_openview)){    
    $jdl  = ucwords(str_replace("magazine","",strtolower($dtl_openview[0]->magz_name)));    
    $uri  = base_url("ovj/".$hdr_id)."/";
    $path = flip_url($dtl_openview[0]->issue_path);
  }
  if(isset($hdr_openview)){
    $jdl  = $jdl;   
    $uri  = flip_url($hdr_openview[0]->issue_path)."/";    
    $path = flip_url($hdr_openview[0]->issue_path);
  }
  #echo $uri;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Backend Menu</title>
    <!-- Jquery JS-->
    <script src="<?= assets('js/jquery-1.9.1.min.js') ?>"></script>
    <script src="<?= assets('js/ovjs.js') ?>"></script>
    <link href="<?= assets('css/bootstrap.min.4.css') ?>" rel="stylesheet" >
    <link href="<?= assets('css/custom.css?').date("Hi"); ?>" rel="stylesheet" />

    
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Josefin Slab' rel='stylesheet'>
    <!-- <div class='ov-option-view'><a href='#'' class='ov-thumb'>thumbnail</a> . <a href='#'' class='ov-extend'>extended</a></div> -->
    <script type="text/javascript">
        $(document).ready(function(){
            $(".ov-extend").attr("style","font-weight:bold;font-style:underline");
            $(".img").click(function(){
              PageUrl   = window.location.hash.substr(1);
              PageId    = $(".view-page").html();
              if (typeof PageId !== 'undefined'){
                //alert(PageId);
                if(PageId.length==0){
                  Page    = PageUrl;
                }else{
                  Page    = PageId;
                }
                pathPage  = Page.substr(0,1) + "=" + Page.substr(1,(Page.length))
                NewPage   = "<?= $path ?>#"+pathPage;
                "" != "index.html" && self.location['replace'](NewPage);
                //alert(NewPage);
              }
            })
            $(".ov-thumb").click(function(){
              $(".content-page").find("h1, h2, h3").hide();
              $(".ganjil").attr("style","background:#fff  !important");
              $(this).attr("style","font-weight:bold;font-style:underline");
              $(".ov-extend").attr("style","font-weight:normal;font-style:none");
            })
            $(".ov-extend").click(function(){
              $(".content-page").find("h1, h2, h3").show();
              $(".ganjil").attr("style","background:#f5f5f5 !important");
              $(this).attr("style","font-weight:bold;font-style:underline");
              $(".ov-thumb").attr("style","font-weight:normal;font-style:none");
            })
            $(".ov-font").click(function(){
              $(".content-page,.fisrt-content-page, div p,.content-page label,.content-page section").toggleClass("font-18");;
            })
            $(".ov-share,.ov-bookmark,.ov-like").click(function(){
              alert("success");
            })
        })
        $.fn.isInViewport = function() {
          var elementTop = $(this).offset().top;
          var elementBottom = elementTop + $(this).outerHeight();

          var viewportTop = $(window).scrollTop();
          var viewportBottom = viewportTop + $(window).height();
          return elementBottom > viewportTop && elementTop < viewportBottom;
        };

        $(window).on('resize scroll', function() {
          $s = "";
          $('.content-page img').each(function() {
            var activeColor = $(this).attr('id');
            if ($(this).isInViewport()) {
                if(activeColor){

              //alert(activeColor);  
                  if($s!=activeColor) {
                    //alert(activeColor);
                    $(".view-page").html(activeColor);
                    return false;
                  }else{
                    $s = activeColor;
                  }
                };
              //$('#fixed-' + activeColor).addClass(activeColor + '-active');
            //} else {
              //$('#fixed-' + activeColor).removeClass(activeColor + '-active');
            }
          });
        });

        /*$(window).scroll(function() {
            var winTop = $(this).scrollTop();
            var $divs = $('p');
            var top = $.grep($divs, function(item) {
                $ag = $(item).position().top <= winTop;
            });
            alert( $divs.attr("id"));
        });*/

        //alert(list);
    </script>
</head>
<body>

  <div id="OpenView">