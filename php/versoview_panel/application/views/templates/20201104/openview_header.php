<!DOCTYPE html>
<html lang="en">
   <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="BCA Prioritas">
      <meta name="author" content="BCA Prioritas">
      <meta name="keywords" content="BCA Prioritas">
      <title>OpenView - BCA Prioritas</title>
      <script src="<?= $msturi ?>javascript/jquery.js"></script>
      <script src="<?= $msturi ?>assets/js/ovjs.js"></script>
      <link href="<?= $msturi ?>assets/css/bootstrap.css" rel="stylesheet" >
      <link href="<?= $msturi ?>assets/css/custom.css" rel="stylesheet" />
      <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
      <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
      <link href='https://fonts.googleapis.com/css?family=Josefin Slab' rel='stylesheet'>
      <link rel="icon" href="<?= $msturi ?>assets/images/ov.png" type="image/png" sizes="16x16">
      <script type="text/javascript">
      var storage = {
        set: function(key, value) {
          if (!key || !value) {return;}

          if (typeof value === "object") {
            value = JSON.stringify(value);
          }
          localStorage.setItem(key, value);
        },
        get: function(key) {
          var value = localStorage.getItem(key);

          if (!value) {return;}
          // assume it is an object that has been stringified
          if (value[0] === "{") {
            value = JSON.parse(value);
          }
          return value;
        },
        rem: function(key) {
          var value = localStorage.removeItem(key);
        }
      }
      var ID = {
        set : function () {
          uid =  Math.random().toString(36).substr(2, 9);          
          localStorage.setItem("uid", uid);
        },
        get: function(key) {
          var value = localStorage.getItem("uid");

          if (!value) {return;}
          // assume it is an object that has been stringified
          if (value[0] === "{") {
            value = JSON.parse(value);
          }
          return value;
        },
        rem: function(key) {
          var value = localStorage.removeItem("uid");
        }
    };
    function nasabah(){
      if( ID.get() === undefined || ID.get() === "undefined"){
        ID.set();
      }
      return ID.get();
    }
      $(document).ready(function() {
          v_stop();
          $edisi = $("#ptop").attr("data-openview");
          nasabah  = nasabah(); 
          pathPage = window.location.hash.substr(1);
          realPage = (parseInt(pathPage.replace("p","")))
          openHdr("")
          if($("#p"+realPage).length){
            $id = $("#p"+realPage);
            $parent1 = $id.parents(':eq(3)');
            $target1 = $parent1.attr("id");
            if (typeof $target1 === "undefined") {
              $parent2 = $id.parents(':eq(1)');
              $target2 = $parent2.attr("data-href");
              if (typeof $target2 === "undefined") {
                openHdr("");
              }else{
                openDtl($target2,"p"+realPage,"p"+realPage);
              }
            }else{              
             openDtl($target1,"p"+realPage,"p"+realPage); 
            }
          }
          $(document).on("click", ".img", function() {
              $dtl = $(this).attr("data-href");
              $id  = $(this).attr("id").replace("ov-","");
              openDtl($dtl,"OpenView-Dtl","p"+$id);
          })
          $(document).on("click", ".ov-logo", function() {
              $goto = openPath();
              v_stop();
              openHdr($goto);
          })
          $(document).on("click", ".img-dtl", function() {
              $dtl = $(this).find("img").attr("id");
              pathPage = $dtl.substr(0, 1) + "=" + $dtl.substr(1, ($dtl.length))
              NewPage = "index.html#" + pathPage;
              "" != "index.html" && self.location['replace'](NewPage);
          })
          $(".ov-extend").attr("style", "font-weight:bold;font-style:underline");
          $(document).on("click", ".ov-thumb", function() {
              $(".content-page").find("h1, h2, h3").hide();
              $(".ganjil").attr("style", "background:#fff  !important");
              $(this).attr("style", "font-weight:bold;font-style:underline");
              $(".ov-extend").attr("style", "font-weight:normal;font-style:none");
          })
          $(document).on("click", ".ov-extend", function() {
              $(".content-page").find("h1, h2, h3").show();
              $(".ganjil").attr("style", "background:#f5f5f5 !important");
              $(this).attr("style", "font-weight:bold;font-style:underline");
              $(".ov-thumb").attr("style", "font-weight:normal;font-style:none");
          })
          $(document).on("click", ".ov-font", function() {
            $key  = "ov-font";
            $read = $(".content-page,.fisrt-content-page, div p,.content-page label,.content-page section");
            if($read.hasClass("font-18")){
              if(storage.get($key)){
                storage.rem($key);
              }else{
                storage.set($key,true);
              }
              $read.toggleClass("font-18");
            }else{              
              if(storage.get($key)){
                storage.rem($key);
              }else{
                storage.set($key,true);
              }
              $read.toggleClass("font-18");
            }
          })
          $(document).on("click", ".ov-menu", function() {
              $lb = $('#likebook');
              if($lb.is(":hidden")){
                $lb.show();
              }else{
                $lb.hide();
              }
          })
          
          $(document).on("click", ".menu-next", function() {
            $(".next-menu").toggle();          
          })

          $(document).on("click",".bookmark-link",function(){
            $link = $(this).attr("href");
            window.location.href = $link;
            window.location.reload();
            //window.location.replace($link);
          })
          $(document).on("click",".mybook",function(){
            $(".likebook").toggle()
          })

          $(".ov-share,.ov-bookmark,.ov-like").click(function() {
              $id    = $(this).attr("id");
              $page  = $(".ov-footer").attr("openview-page");
              $judul = $(".ov-footer").attr("openview-page-title");
              $title = {page:openPath(),title:$judul}          
              $key   = $edisi+"|"+nasabah+"|"+$id+"|"+$page;
              if(storage.get($key)){
                if($id=="ov-like"){
                  $(this).find("img").attr("src","<?=$msturi?>files/extfile/like.png");
                }else if($id=="ov-bookmark"){
                  $(this).find("img").attr("src","<?=$msturi?>files/extfile/bookmark.png");
                }
                storage.rem($key);
              }else{
                storage.set($key,$title);
                if($id=="ov-like"){
                  if(storage.get($key)){
                    $(this).find("img").attr("src","<?=$msturi?>files/extfile/like-ok.png");
                  }else{
                    $(this).find("img").attr("src","<?=$msturi?>files/extfile/like.png");
                  }
                }else if($id=="ov-bookmark"){
                  if(storage.get($key)){
                    $(".likebook").show();
                    $(this).find("img").attr("src","<?=$msturi?>files/extfile/bookmark-ok.png");
                  }else{
                    $(this).find("img").attr("src","<?=$msturi?>files/extfile/bookmark.png");
                  }
                }
              };              
              data_likebook($id);
          })
          $(document).on("click",".close-bookmark",function(){
            $(".likebook").hide();
          })
          $(window).on('wheel', function(event){
           // if (isInView($('.menu-next'))){
           //    $(".next-menu").show();
           // }else{
              $(".next-menu,.xlikebook").hide();
           //}
          });

      })

      function jxhr(url){
        var jqXHR = $.ajax({
          url   : base_url(url),
          dataType: 'json',
          async : false
        });
        return JSON.parse(jqXHR.responseText);  
      }
      function v_stop(){
        $vv = $('#video_player').trigger("pause");
      }

      function openPath(){        
        pathPage = window.location.hash.substr(1);
        $goto = pathPage.replace("p","ov-");
        return $goto;
      }
      function openHdr($goto){
        parent.location.hash = "";
        hide_menu("disabled");
        $("#OpenView-Dtl").hide();
        $(".cnt-dtl").hide();
        $(".cnt-show").hide();              
        $(".cnt-hdr").show();
        getdata("hdr",$edisi,nasabah);
        if($goto!=""){
          gotop($goto);      
        }
        data_likebook("");
        change_text_menu("","hdr");
      }
      function openDtl($dtl,$goto,$push){          
        parent.location.hash = $push;
        $("#OpenView-Dtl").show();
        $(".cnt-dtl").hide();
        $(".cnt-hdr").hide();
        $("#"+$dtl).show();
        load_likebook($dtl,$push);
        data_likebook($dtl);
        load_readcontent();
        change_text_menu($dtl,"dtl");
        hide_menu("enable");
        if($goto=="OpenView-Dtl"){
          $goto = $push;
        }
        //gotop($goto);
      }
      function change_text_menu($dtl,$tipe){
        if($tipe=="dtl"){
          $title = $("#"+$dtl).attr("data-title");
          $(".text-menu1").hide();
          $(".text-menu0").show();
          $(".text-menu0").find("a").text("BCA PRIORITAS - "+$title)
        }else{
          $(".text-menu1").show();
          $(".text-menu0").hide();          
        }
      }
      function getdata($key,$edisi,$nasabah){
        $.getJSON(base_url($key+'/'+$edisi+'/'+$nasabah),function(data,status){
          if(status=="success"){
          }
         })
      }
      function hide_menu($btn){        
        if($btn=="disabled"){
          $(".popup").show();
          $(".ov-like").find("img").attr("src","<?=$msturi?>files/extfile/like.png");
          $(".ov-bookmark").find("img").attr("src","<?=$msturi?>files/extfile/bookmark.png");
        }else{
          $(".popup").hide();
        }
      }
      $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).outerHeight();

        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
      };
      function gotop($id){
          $xid = $("#"+$id);
          $('html, body').animate({
              scrollTop: $xid.offset().top
          }, 100);
      }

      function load_readcontent(){        
        $key  = "ov-font";
        $read = $(".content-page,.fisrt-content-page, div p,.content-page label,.content-page section");
        if(storage.get($key)){
          $read.addClass("font-18");
        }
      }
      function load_likebook($dtl,$push){
        $push  = $push.replace("p","");
        $page  = $dtl;
        $title = $("#"+$page).find("h2").text();
        $(".ov-footer").attr("openview-page",$page).attr("openview-page-title",$title);        
        $key1   = $edisi+"|"+nasabah+"|ov-like|"+$page;
        $key2   = $edisi+"|"+nasabah+"|ov-bookmark|"+$page;
        if(storage.get($key1)){
          $("#ov-like").find("img").attr("src","<?=$msturi?>files/extfile/like-ok.png");
        }else{
          $("#ov-like").find("img").attr("src","<?=$msturi?>files/extfile/like.png");
        };
        if(storage.get($key2)){
          $("#ov-bookmark").find("img").attr("src","<?=$msturi?>files/extfile/bookmark-ok.png");
        }else{
          $("#ov-bookmark").find("img").attr("src","<?=$msturi?>files/extfile/bookmark.png");
        };
      }
      function data_likebook($dtl){
        //likebook
        $(".dlike ul").html("");
        $(".dbook ul").html("");
        $(".cnt-dtl").each(function() {
          $page  = $(this).attr("id");
          $key1  = $edisi+"|"+nasabah+"|ov-like|"+$page;
          $val1  = storage.get($key1);
          $key2  = $edisi+"|"+nasabah+"|ov-bookmark|"+$page;
          $val2  = storage.get($key2);
          $judul = $page.replace("-"," ").toUpperCase();
          if($val1){       
            $url1  = $val1["page"].replace("ov-","p");  
            $(".dlike ul").append("<li><a href='ovi.html#"+$url1+"' class='bookmark-link'>"+$judul+" : "+$val1["title"]+"</a></li>");
          }
          if($val2){            
            $url2  = $val2["page"].replace("ov-","p");   
            $(".dbook ul").append("<li><a href='ovi.html#"+$url2+"'  class='bookmark-link'>"+$judul+" : "+$val2["title"]+"</a></li>");
          }
        })
      }
      function base_url($url){
          return "http://localhost/agencyfish/weblist/versoview/openvi/"+$url;
      }
      function isInView(elem){
         return $(elem).offset().top - $(window).scrollTop() < $(elem).height() ;
      }
    </script>
   </head>
   <body>
    <div id="OpenView-Hdr">

      <div id="ptop" data-openview="bca-87"></div>
       <!-- position: fixed;width: 100%;z-index: 100; -->
       <div class='content-page fisrt-content-page content-nav'>
          <div class="container" style="position: relative; ">
             <div style="float: none" >
                <nav class="navbar navbar-expand-lg  navbar-light menu-content" style="">
                   <div id="navbarSupportedContent" class="navbar-collapse justify-content-center ">
                      <ul class="navbar-nav">
                         <li class="nav-item text-menu0">  <a class="nav-link waves-effect waves-light text-dark ov-thumb" >Menu</a></li>
                         <li class="nav-item text-menu1">  <a class="nav-link waves-effect waves-light text-dark ov-thumb" >Thumbnail</a></li>
                         <li class="nav-item text-menu1">  <a class="nav-link waves-effect waves-light text-dark ov-extend" >Extended</a></li>
                         <li class="nav-item menu-next">  
                            <!-- <a class="nav-link waves-effect waves-light text-dark" href="index.html">
                            <img src="assets/images/ovi.png" style="height: 20px" />
                            </a> -->
                            <a class="nav-link waves-effect waves-light text-dark">
                            <img src="<?=$msturi?>files/extfile/menu.png" style="height: 15px" />
                            </a>
                              <ul class="next-menu">
                                 <!-- <li class="nav-item">  <a class="nav-link waves-effect waves-light text-dark text-right mybook">My Bookmarks</a></li> -->
                                 <li class="nav-item">  <a class="nav-link waves-effect waves-light text-dark text-right" href="<?=$msturi?>index.html">Flipbook</a></li>
                              </ul>  
                         </li>
                      </ul>
                   </div>
                </nav>
             </div>
          </div>
       </div>