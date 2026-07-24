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
    function setup(){   
      $.ajaxSetup({
        headers : {
          'X-Auth' : 'a8f14e4d5f-ceeae167-a5al36-deddi-4bea25a43',
          'X-Keys' : 'a64a4b0dd1-9d5cefe2-c01lc9-0d25i-c1d582aaf'
        }
      });
    }
      // setTimeout(function(){ 
      //   getcomment("load","0");
      // },10000);
      $(document).ready(function() {
          v_stop();
          $edisi = $("#ptop").attr("data-title");
          $id_edisi = $("#ptop").attr("data-openview");
          nasabah  = nasabah(); 
          pathPage = window.location.hash.substr(1);
          realPage = (parseInt(pathPage.replace("p","")))
      	  $(".comment-header").text($edisi);
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
          $(document).on("keyup",".cmnt-input",function(e){
            $typo = $(this).val().length;
            $cek = $(this).attr("input-reply");
            
            if($cek){
                  $hdr = $(this).closest("li").attr("id");                  
                  if($typo>0){
                    $("#"+$hdr).find(".cmnt-post").prop("disabled",false).removeClass("disabled");
                    if(e.keyCode==13){
                      $("#"+$hdr).find(".cmnt-post").click();
                    }
                  }else{
                    $("#"+$hdr).find(".cmnt-post").prop("disabled",true).addClass("disabled");
                    $(this).attr("data-reply","");
                  }
            }else{
                  if($typo>0){
                    $(".cmnt-post").prop("disabled",false).removeClass("disabled")
                    // if($typo>5){
                    //   autoload_cmnt($typo);
                    // }
                    if(e.keyCode==13){
                      $(".cmnt-post").click();
                    }
                  }else{
                    $(".cmnt-post").prop("disabled",true).addClass("disabled");
                    $(this).attr("data-reply","");
                  }                  
            }
          })
          $(document).on("keyup",".cmnt-input-name",function(){
          	if($(this).val().length>0){
          		$(".cmnt-post-name").prop("disabled",false).removeClass("disabled")
          	}else{
          		$(".cmnt-post-name").prop("disabled",true).addClass("disabled");
          	}
          })
          $(document).on("click", ".img", function() {
              $dtl = $(this).attr("data-href");
              $id  = $(this).attr("id").replace("ov-","");
              if($dtl!="cover"){
                openDtl($dtl,"OpenView-Dtl","p"+$id);
              }
          })
          $(document).on("click", ".hdr-ov-like,.hdr-ov-cmnt", function(e) {
              $par = $(this).closest(".container");
              $cls = $(this).attr("class");
              $par.find(".img").click();
              if($cls=="hdr-ov-cmnt"){       
                 setTimeout(function(){ 
                  load_cmnt("load-auto");
                 }, 300);

                //     if($("#OpenView-Dtl").is(":visible")){         
                //           setTimeout(function(){ 
                //               alert($cls);     
                //               $(".ov-cmnt").click();
                //           }, 1000);
                //     }
              }
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
          $(".ov-cmnt").click(function() {
            load_cmnt("load-def");
          })
          $(".ov-share,.ov-bookmark,.ov-like").click(function() {
              $id    = $(this).attr("id");
              $page  = $(".ov-footer").attr("openview-page");
              $judul = $(".ov-footer").attr("openview-page-title");
              $title = {page:openPath(),title:$judul}          
              $key   = $id_edisi+"|"+nasabah+"|"+$id+"|"+$page;
              $asset = $("#ptop").attr("base-url");
              // alert($asset);
              if(storage.get($key)){
                if($id=="ov-like"){
                  like_book("like",$page,nasabah,"0");
                  $(this).find("img").attr("src",assets("extfile/like.png"));
                }else if($id=="ov-bookmark"){
                  like_book("book",$page,nasabah,"0");
                  $(this).find("img").attr("src",assets("extfile/bookmark.png"));
                }
                storage.rem($key);
              }else{
                storage.set($key,$title);
                if($id=="ov-like"){
                  if(storage.get($key)){
                    $(this).find("img").attr("src",assets("extfile/like-ok.png"));
                    like_book("like",$page,nasabah,"1");
                  }else{
                    $(this).find("img").attr("src",assets("extfile/like.png"));
                    like_book("like",$page,nasabah,"0");
                  }
                }else if($id=="ov-bookmark"){
                  if(storage.get($key)){
                    $(".likebook").show();
                    $(this).find("img").attr("src",assets("extfile/bookmark-ok.png"));
                    like_book("book",$page,nasabah,$judul);
                  }else{
                    $(this).find("img").attr("src",assets("extfile/bookmark.png"));
                    like_book("book",$page,nasabah,"0");
                  }
                }
              };              
              data_likebook($id);
          })
          $(document).on("click",".close-bookmark",function(){
            $(".likebook").hide();
          })
          $(document).on("click",".reply-cmnt",function(){
            $par = $(this).closest(".prnt").attr("id");
            $com = $(this).closest("li").attr("id");
            $cid = $(this).attr("comment-id");
            $cnm = $(this).attr("comment-name");            
            $uname = storage.get("uname");
              if($uname === undefined){
                getuname("");
              }else{                    
                hide_repl();             
                if($("#"+$com).find(".cmnt-frm-reply").length){                      
                  $("#"+$com).find(".cmnt-frm-reply").remove();
                }else{
                      if($("#"+$com).attr("class")=="prnt"){
                        $("#"+$com+" ul").prepend("<div class='cmnt-frm-reply'>"+$(".cmnt-frm").html()+"<div>");
                      }else{                      
                        $("#"+$par+" #"+$com).append("<div class='cmnt-frm-reply'>"+$(".cmnt-frm").html()+"<div>");
                      }
                      $("#"+$com).find(".cmnt-frm-reply input").attr({"placeholder":" reply comment","input-reply":"reply"})
//                       $("#"+$com).find(".cmnt-input").focus();
                }
//                 $("#"+$com).find(".cmnt-input").val("@"+$cnm+" ").attr("data-reply",$cid).attr("parent",$par).focus();
                
                    // $("."+$class).focus();
                    // $("#"+$com).find(".cmnt-input").attr({"data-reply":$cid+"zre","parent":$par}).focus();        
                    $(this).closest("li").find(".cmnt-input").attr({"data-reply":$cid,"parent":$par}).focus();        
//                 fokus("cmnt-input");
              }
          })
          $(document).on("click",".cmnt-post",function(){
            $disable = $(this).hasClass("disabled");
            if ($disable === false) {              
              $uname = storage.get("uname");
              if($uname === undefined){
                getuname("");
              }else{
                $page  = $(".ov-footer").attr("openview-page");
                $uid   = storage.get("uid");
                $xcid  = $(".cmnt-input").attr("data-reply")
                $share = $(".cmnt-input").attr("data-share");
                $pare  = $(".cmnt-input").attr("parent");
                $cmnt  = $(".cmnt-input").val();
                 $.ajax({
                    type: 'POST',

                    // make sure you respect the same origin policy with this url:
                    // http://en.wikipedia.org/wiki/Same_origin_policy
                    url: base_url("comment_post"),
                    dataType:"json",
                    data: { 
                        'cid' : $xcid, 
                        'cuid': $uid, 
                        'cnam': $uname, 
                        'cedisi': $id_edisi, 
                        'cshare': $share, // <-- the $ sign in the parameter name seems unusual, I would avoid it
                        'csection': $page, // <-- the $ sign in the parameter name seems unusual, I would avoid it
                        'comment': $cmnt // <-- the $ sign in the parameter name seems unusual, I would avoid it
                    },
                    success: function(data){
                      hide_repl();
                      $(".cmnt-input").val("").attr({"data-reply":"","data-share":""}).focus();
                      $(".cmnt-post").prop("disabled",true).addClass("disabled");
                      //getcomment("load","0");
                      $result   = $("#result-comment");
                      $load_btn = $result.find(".load-parent");
                      // alert($load_btn.length);
                      if($load_btn.length){
                       if($xcid!=""){
                         $find_reply = $result.find("#com-"+$xcid);
                         if($find_reply.length){                            
                           $find_reply.append(data);
                         }else{
                           $load_btn.remove();
                           $result.append(data);
                           $result.append('<div class="load-parent glyphicon glyphicon-plus-sign"></div>');                            
                         }
                       }else{
                         $load_btn.remove();
                         $result.append(data);
                         $result.append('<div class="load-parent glyphicon glyphicon-plus-sign"></div>');
                       }
                      }else{
                         hsl = data["chld"][0];
                         if($xcid!=""){ 
                           $find_reply = $result.find("#com-"+$xcid);
                           if($find_reply.length){      
                             $find_reply.append(data);
                              push_comment(hsl.cmnt_id,hsl.cmnt_reply,hsl.cmnt_name,hsl.cmnt_text,hsl.tgl,hsl.rpl,"new-reply",$pare,hsl.dibagi,"","",hsl.magz_hdr);
                           }else{                
                             // $load_btn.remove();
                              push_comment(hsl.cmnt_id,hsl.cmnt_reply,hsl.cmnt_name,hsl.cmnt_text,hsl.tgl,hsl.rpl,"new-reply",$pare,hsl.dibagi,"","",hsl.magz_hdr);
                             // $result.append(data);
                             // $result.append('<div class="load-parent glyphicon glyphicon-plus-sign"></div>');                            
                           }
                         }else{
                          push_comment(hsl.cmnt_id,hsl.cmnt_reply,hsl.cmnt_name,hsl.cmnt_text,hsl.tgl,hsl.rpl,"post","",hsl.dibagi,"","",hsl.magz_hdr);
                          gotop("#com-"+hsl.cmnt_id,"komen");
                           //$load_btn.remove();
                           // $result.append(data);
                           // $result.append('<div class="load-parent glyphicon glyphicon-plus-sign"></div>');
                         }

                      }
                    }
                });
              }
            }
          })
          $(document).on("click",".post-content",function(){  
              $uname = storage.get("uname");
              if($uname === undefined){
                getuname("content");
              }else{
                $page   = $("#content-section2").val();
                $page2  = $(".ov-footer").attr("openview-page");
                if($page==$page2){
                  $(".ov-comment").show();
                  $page_add = "";
                }else{
                  $page_add = "#p"+$("#"+$page).find(".fisrt-content-page").first().attr("data-url")
                }
                $uid   = storage.get("uid");
                $xcid  = $(".cntn-input").attr("data-reply")
                $share = $(".cntn-input").attr("data-share");
                $pare  = $(".cntn-input").attr("parent");
                $cmnt  = $(".cntn-input").val();
                $hdr2   = $("#"+$share).closest(".cnt-dtl").find(".content-page h2").text();
                $hdr   = $hdr2;
                $dtl   = $("#get-content").find(".modal-body p").text();
                 $.ajax({
                    type: 'POST',
                    url: base_url("content_post"),
                    dataType:"json",
                    data: { 
                        'cid' : $xcid, 
                        'cuid': $uid, 
                        'cnam': $uname, 
                        'cedisi': $id_edisi, 
                        'cshare': $share, // +$page_add, // <-- the $ sign in the parameter name seems unusual, I would avoid it
                        'csection': $page, // <-- the $ sign in the parameter name seems unusual, I would avoid it
                        'comment': $cmnt, // <-- the $ sign in the parameter name seems unusual, I would avoid it
                        'cnt-hdr': $hdr,
                        'cnt-dtl': $dtl
                    },
                    success: function(data){
                      hide_repl();
                      $(".custom-menu").hide();
                      $(document).find(".spanhover").removeClass("spanhover");
                      // $(".cntn-input").val("").attr({"data-reply":"","data-share":""}).focus();
                      $(".cntn-post").prop("disabled",true).addClass("disabled");
                      //getcomment("load","0");
                      $result   = $("#result-comment");
                      $load_btn = $result.find(".load-parent");
                      // alert($load_btn.length);
                      if($load_btn.length){
                       if($xcid!=""){
                         $find_reply = $result.find("#com-"+$xcid);
                         if($find_reply.length){                            
                           $find_reply.append(data);
                         }else{
                           $load_btn.remove();
                           $result.append(data);
                           $result.append('<div class="load-parent glyphicon glyphicon-plus-sign"></div>');                            
                         }
                       }else{
                         $load_btn.remove();
                         $result.append(data);
                         $result.append('<div class="load-parent glyphicon glyphicon-plus-sign"></div>');
                       }
                      }else{
                          hsl = data["chld"][0];
                          if($page!=$page2){
                            $(".ov-comment").show();                        
                            $lg = $("#"+$page).find(".fisrt-content-page").first().attr("data-url");
                            $(".back").click();
                            openDtl($page,"OpenView-Dtl","p"+$lg);
                          }
                          push_comment(hsl.cmnt_id,hsl.cmnt_reply,hsl.cmnt_name,hsl.cmnt_text,hsl.tgl,hsl.rpl,"post","",hsl.dibagi,hsl.cnt_hdr,hsl.cnt_dtl,hsl.magz_hdr);
                          gotop("#com-"+hsl.cmnt_id,"komen");
                      }
                    }                
                });
              }
          })
          $(document).on("click",".flip-url",function(){
            $url  = $(this);
            $page = $url.attr("data-page");
            if($page.length==0){
              $uri  = $url.attr("data-href");
            }else{
              $uri  = $url.attr("data-href")+"#"+$page[0]+"="+$page.replace("p","");
            }           
            window.location.href = $uri;
          })
          $(document).on("click","#content-section",function(){            
            $val = $(this).val();
            $xid = $("#"+$val).css("display");
            if($xid=="none"){              
              $lg = $("#"+$val).find(".fisrt-content-page").first().attr("data-url");
              $(".back").click();
              openDtl($val,"OpenView-Dtl","p"+$lg);
            }
          })
          $(document).on("change","#content-section",function(){
            $val = $(this).val();
            $lg = $("#"+$val).find(".fisrt-content-page").first().attr("data-url");
            $(".back").click();
            openDtl($val,"OpenView-Dtl","p"+$lg);
          })
          $(document).on("click",".load-parent",function(){
            $cmnt_parent = $("#result-comment").find(".prnt").length;
            getcomment("more-parent",$cmnt_parent);
            $(this).remove();
          })
          $(document).on("click",".back",function(){
            $(this).hide();
            $("#result-comment-reply").html("");
            $("#result-comment").fadeIn();            
            $(".cmnt-input-name").focus().val("");
            $("#comment").find(".cmnt-posts").show();
          })
          $(document).on("click",".child-hide",function(){
            $cmnt_parent = $(this).attr("id").replace("rep","ch");
            $id_parent   = $(this).closest("li").attr("id");
            $("#"+$id_parent).find("."+$cmnt_parent).hide();
            $(this).html("show reply").addClass("child-show").removeClass("child-hide");
          })
          $(document).on("click",".child-show",function(){
            $cmnt_parent = $(this).attr("id").replace("rep","ch");
            $id_parent   = $(this).closest("li").attr("id");
            $("#"+$id_parent).find("."+$cmnt_parent).show();
            $(this).html("hide reply").addClass("child-hide").removeClass("child-show");
          })
          $(document).on("click",".load-child",function(){
            $cek_rpl  = $(this).attr("reply");
            $cmnt_id  = $(this).closest("li").attr("id");
            $ttl_rep  = $(this).closest("li").attr("data-child");
            $prnt_id  = $cmnt_id.replace("com","cmn");
            // $ttl_chld = $('#'+$cmnt_id).find("li").not('.load-cmnt').length;
            // alert("s")
            if($cek_rpl=="parent"){
              $("#comment").find(".cmnt-posts").hide();
              $("#result-comment").hide();
              $("#result-comment-reply").html("").append("<ul><li class='prnt' id='"+$prnt_id+"' data-child='"+$ttl_rep+"'>"+$("#"+$cmnt_id).html()+"</li></ul>").fadeIn();
              $("#result-comment-reply #"+$prnt_id).find(".anak").remove()
              $("#result-comment-reply").find(".load-child").attr("reply","child");
              getmorecomment("reply",$cmnt_id,"1");
            }else if($cek_rpl=="child"){
              getmorecomment("reply",$cmnt_id,"0");
            }else if($cek_rpl=="hide"){
              $("#"+$cmnt_id).find(".anak").hide();
              $(this).attr("reply","show").text("tampilkan balasan");
              $(this).css("margin-left","-33px !important;")
            }else if($cek_rpl=="show"){
              $("#"+$cmnt_id).find(".anak").show();
              $(this).attr("reply","hide").text("sembunyikan balasan");
            }
//             gobot("#result-comment-reply");
          })
          $(document).on("click",".cmnt-post-name,.cntn-post-name",function(){

            if($(this).hasClass("cntn-post-name")){
              $cls = ".cntn";
            }else{
              $cls = ".cmnt";
            }
            $disable = $(this).hasClass("disabled");
            $name    = $($cls+"-input-name").val();
            if ($disable === false) {
              storage.set("uname",$name);
              alert("success..");
            }
              $($cls+"-frm-name").fadeOut();
              setTimeout(function(){ 
                $($cls+"-frm").fadeIn();
                $($cls+"-input").focus();
              }, 500);
          })
          $(window).on('wheel', function(event){
           // if (isInView($('.menu-next'))){
           //    $(".next-menu").show();
           // }else{
              $(".next-menu,.xlikebook").hide();
           //}
          });

      })
