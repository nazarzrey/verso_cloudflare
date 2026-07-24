<div id="ptop"></div>
<?php

  $jdl  = "Home";
  $uri  = base_url("login")."/";
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
  ?>

<script type="text/javascript">
    $(document).ready(function(){
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
        $(".ov-footer").click(function(){
          //alert("s");
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

<?php
  #debug($hdr_page);
  if(empty($hdr_page)){    
      $content    = '
                     <li class="nav-item">  <a class="nav-link waves-effect waves-light text-dark ov-thumb" href="#">Thumbnail</a></li>
                     <li class="nav-item">  <a class="nav-link waves-effect waves-light text-dark ov-extend" href="#">Extended</a></li>';
      $openview   = '
                     <li class="nav-item">  <a class="nav-link waves-effect waves-light text-dark" href="'.$uri.'"><img src="'.assets("images/ovi.png").'" style="height: 20px" /></a></li>';
      $pageturner = '';
      $mobile     = '';
  }else{
      $content    = "";
      $openview   = '<li class="nav-item" style="height: 38px"></li>';
      $pageturner = '
      <a style="position: absolute;top:15px;right:10px;z-index:1001" class="desktop" href="'.$uri.'">
        <img src="'.assets("images/ovi.png").'" style="height: 22px" />
      </a>';
      $mobile     = 'desktop';
  }
?>
  <div class="container hide">
    <div class="row">
      <div class="col-xs-12 menu-content ">
        <ul class="list-inline text-center hide">
          <li><a><img src="<?= base_url("pageturner/200122/yzjs0gucd25/files/extfile/logo.png") ?>"/></a></li>
          <?= $content ?>
          <li class=""><a href='<?= $uri; ?>'><?= $jdl; ?>bbb</a></li>
          <li class=""><a href='<?= $uri; ?>'><?= $jdl; ?>aaa</a></li>
        </ul>
      </div>
    </div>
  </div>
<!-- position: fixed;width: 100%;z-index: 100; -->
<div class='content-page fisrt-content-page content-nav desktop'>
  <div class="container" style="background: #f5f5f5;position: relative;">
    <div style="position: absolute;top:15px">
      <img src="<?= base_url("pageturner/200122/yzjs0gucd25/files/extfile/logo.png") ?>" style="height: 32px" />
    </div>
    <?= $pageturner; ?>
    <div style="float: none">
        <nav class="navbar navbar-expand-lg  navbar-light menu-content" style="">
          <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-center ">
            <ul class="navbar-nav">
              <?= $content ?>
              <?= $openview ?>
            </ul>
          </div>
      </nav>
    </div>
  </div>
</div>

<div class='content-page fisrt-content-page content-nav mobile'>
  <div class="container" style="background: #f5f5f5;position: relative;overflow: auto;padding-top: 20px">
    <div>
      <img src="<?= base_url("pageturner/200122/yzjs0gucd25/files/extfile/logo.png") ?>" style="height: 32px" />
    </div>
    <div class="<?= $mobile ?>" style="margin-top:10px">
      <ul class="navbar-nav">
              <?= $content ?>
              <?= $openview ?>
            </ul>
    </div>
    <?= $pageturner; ?>
    <div style="float: none">
        <nav class="navbar navbar-expand-lg  navbar-light menu-content" style="">
          <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-center ">
          </div>
      </nav>
    </div>
  </div>
</div>


<div class='content-page fisrt-content-page content-nav mobile hilang'>
  <div class="container" style="background: #f5f5f5;position: relative;overflow: auto;padding-top: 20px">
    <div>
      <img src="<?= base_url("pageturner/200122/yzjs0gucd25/files/extfile/logo.png") ?>" style="height: 32px;position: absolute;left: 10px;top: 15px;" />
    </div>
    <div class="" style="height:40px"></div>
    <?= $pageturner; ?>
  </div>
</div>
<?php
  if(empty($hdr_page)){
    if(isset($hdr_openview)){
      #var_dump($hdr_openview);
      #title
      // echo "<h3>".$hdr_openview[0]->magz_name."</h3>";
      // echo "<h4>".$hdr_openview[0]->issue_title."</h4>";
      #title
      #echo "<div class='ov-option-view'><a href='#'' class='ov-thumb'>thumbnail</a> . <a href='#'' class='ov-extend active'>extended</a></div>";
      foreach ($hdr_openview as $key => $value) {
        $imgpage = ganjil_genap($value->magz_page);
        $path    = $value->issue_path;
        #var_dump($path);
        $url1    = base_url("ovj/".$hdr_id."/".$value->content."#");
        #echo "<a href='".$url1."' class='brd' style='overflow:auto'>";
        $gg = gg($key);
        echo "<div class='content-page fisrt-content-page $gg' data-url='".$url1."'>";
        echo "<div class='container'>";
        echo "<div class='img row '>";
        echo "<div class='img-data'>";
          foreach ($imgpage as $key => $page) {
            #$url = base_url("ovj/".$hdr_id."/".min_space($value->content,"-")."#p".$page);
            $url = base_url("ovj/".$hdr_id."/".min_space($value->content,"-")."#ptop");
            $img = base_url(ov_img($page,$path,"big"));
            echo "<a href='".$url."'><img src='".$img."' id='p".$page."' class='ov-image'/></a>";
          }
        echo "</div>";
        echo "</div>";
        /*<h1 style='padding:40px 0;margin:0'>".$value->content."</h1>*/
        echo "
          <div style='padding:0'>
          <h2 style='padding:0 !important;margin:10px 0 10px 0 !important'>".$value->title."</h2>
          <h3 style='padding: 0 0 20px 0 !important;'>".$value->lead."</h3>
          </div>
          ";
        echo "</div>
        </div>";
        #echo "</a>";
      }
    };
  }else{
    if(isset($dtl_openview)){
      echo "<div style='margin-bottom:70px'><div class='view-page'></div>";
      #var_dump($dtl_openview);
    #echo "x";
      #var_dump($hdr_openview);
      // echo "<h3>".$dtl_openview[0]->magz_name."</h3>";
      // echo "<h4>".$dtl_openview[0]->issue_title." / ".
      // echo ucwords(min_space($hdr_page,""))."</h4>";
      $body = "";
      $capt = "";
      foreach ($dtl_openview as $key => $value) {
        $body = $value->body_text;
        $p = "<section>".$value->body_text."</section>";
        $l = "<section style='white-space: normal;'>".$value->caption."</section>";
        $imgpage = ganjil_genap($value->magz_page);
        $path    = $value->issue_path;
        $url1    = base_url("ovj/".$hdr_id."/".$value->magz_page);
        echo "<div class='content-page fisrt-content-page' data-url='".$url1."'>";
            if($value->magz_page % 2 == 0){ 
            echo "<div class='img'>";
            echo "<div class='img-data'>";          
              foreach ($imgpage as $key => $page) {
                $url = base_url("ovj/".$hdr_id."/".$page);
                $img = base_url(ov_img($page,$path,"big"));
                echo "<img src='".$img."' id='p".$page."' class='ov-image'/>";
              } 
              echo "</div>";
              echo "</div>";
            }
            if(!empty(trim($value->title))){
              echo "
                <h2 style='padding:40px 0;margin:0'>".$value->title."</h2>
                <h3>".$value->lead."</h3>
                ";                      
            }
            echo $p." ".$l;
        echo "</div>";
        #echo "</a>";
      }
      echo '
      <div class="ov-footer" style="background: #fff;position: fixed;bottom: 0;left:0;z-index: 999;width:100%;box-shadow:1px 1px 5px #ccc">
        <a src="" id="" class="ov-like hilang">
          <img src="'.base_url("pageturner/200122/yzjs0gucd25/files/extfile/like.png").'">
        </a>
        <a src="" id="" class="ov-share hilang">
          <img src="'.base_url("pageturner/200122/yzjs0gucd25/files/extfile/share.png").'">
        </a>
        <a src="" id="" class="ov-bookmark hilang">
          <img src="'.base_url("pageturner/200122/yzjs0gucd25/files/extfile/bookmark.png").'">
        </a>
        <a src="" id="" class="ov-font pull-right">
          <img src="'.base_url("pageturner/200122/yzjs0gucd25/files/extfile/font.png").'">
        </a>
      </div>
    </div>';
    }else{
      redirect('ovj/'.$hdr_id, 'location', 301);
    }
  }
?>