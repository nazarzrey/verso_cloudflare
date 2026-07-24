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
  <link href="<?= assets('css/custom.css?').date("Hi"); ?>" rel="stylesheet" />
  <script type="text/javascript">
        $(document).ready(function(){
            $(".ov-font").click(function(){
              //alert("x");
              $(".content-page p").toggleClass("font-18");
            })
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
                alert(NewPage);
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
<?php
  if(empty($hdr_page)){
    if(isset($hdr_openview)){
      #var_dump($hdr_openview);
      #title
      // echo "<h3>".$hdr_openview[0]->magz_name."</h3>";
      // echo "<h4>".$hdr_openview[0]->issue_title."</h4>";
      #title
      echo "<div class='ov-option-view'><a href='#'' class='ov-thumb'>thumbnail</a> . <a href='#'' class='ov-extend'>extended</a></div>";
      foreach ($hdr_openview as $key => $value) {
        $imgpage = ganjil_genap($value->magz_page);
        $path    = $value->issue_path;
        #var_dump($path);
        $url1    = base_url("ovj/".$hdr_id."/".$value->content."#");
        #echo "<a href='".$url1."' class='brd' style='overflow:auto'>";
        $gg = gg($key);
        echo "<div class='content-page fisrt-content-page ' data-url='".$url1."'>";
         echo "<div class='img row $gg'>";
          echo "<div class='img-data'>";
          foreach ($imgpage as $key => $page) {
            $url = base_url("ovj/".$hdr_id."/".min_space($value->content,"-")."#p".$page);
            $img = base_url(ov_img($page,$path));
            echo "<a href='".$url."'><img src='".$img."' id='p".$page."' class='ov-image'/></a>";
          }
          echo "</div>";
          echo "</div>";
          echo "
            <h1 style='padding:40px 0;margin:0'>".$value->content."</h1>
            <h2 style='padding:40px 0;margin:0'>".$value->title."</h2>
            <h3>".$value->lead."</h3>
            ";
        echo "</div>";
        #echo "</a>";
      }
    };
  }else{
    if(isset($dtl_openview)){
      echo "<div class='view-page'></div>";
      #var_dump($dtl_openview);
    #echo "x";
      #var_dump($hdr_openview);
      echo "<h3>".$dtl_openview[0]->magz_name."</h3>";
      echo "<h4>".$dtl_openview[0]->issue_title." / ".ucwords(min_space($hdr_page,""))."</h4>";
      foreach ($dtl_openview as $key => $value) {
        $imgpage = ganjil_genap($value->magz_page);
        $path    = $value->issue_path;
        $url1    = base_url("ovj/".$hdr_id."/".$value->magz_page);
        echo "<div class='content-page fisrt-content-page' data-url='".$url1."'>";
          if($value->magz_page % 2 == 0){ 
          echo "<div class='img row'>";
          echo "<div class='img-data'>";          
            foreach ($imgpage as $key => $page) {
              $url = base_url("ovj/".$hdr_id."/".$page);
              $img = base_url(ov_img($page,$path));
              echo "<img src='".$img."' id='p".$page."' class='ov-image'/>";
            } 
            echo "</div>";
            echo "</div>";
          }
          if(!empty($value->title)){
            #echo $value->title."xxx";
            echo "
              <h1 style='padding:40px 0;margin:0'>".$value->content."</h1>
              <h2 style='padding:40px 0;margin:0'>".$value->title."</h2>
              <h3>".$value->lead."</h3>
              ";              
              if(!empty($value->body_text) && !empty($value->caption)){
                echo "<p style='padding:10px 5px ;margin:0'>".$value->body_text."</p>";
                echo "<label>".$value->caption."</label>";
              }elseif(!empty($value->body_text) && empty($value->caption)){                
                echo "<p style='padding:10px 5px ;margin:0'>".$value->body_text."</p>";
              }elseif(empty($value->body_text) && !empty($value->caption)){
                echo "<label>".$value->caption."</label>";
              }
            }else{
              if(!empty($value->body_text) && !empty($value->caption)){
                echo "<p style='padding:10px 5px ;margin:0'>".$value->body_text."</p>";
                echo "<label>".$value->caption."</label>";
              }elseif(!empty($value->body_text) && empty($value->caption)){                
                echo "<p style='padding:10px 5px ;margin:0'>".$value->body_text."</p>";
              }elseif(empty($value->body_text) && !empty($value->caption)){
                echo "<label>".$value->caption."</label>";
              }
            }
        echo "</div>";
        #echo "</a>";
      }
    }else{
      redirect('ovj/'.$hdr_id, 'location', 301);
    }
  }
?>