

      function content_section(){
        $("#content-section,#content-section2").html("")
        $open_section = $(".ov-footer").attr("openview-page");
        // alert($open_section)
        option("#content-section,#content-section2",$open_section,ucfirst($open_section.replace("-"," ").replace("-"," ")))
        $sec = "";
        // $(".cnt-hdr").find(".content-page").each(function(){
        $(".cnt-hdr").find(".img-data").each(function(){
          $id = $(this).attr("data-href");
          if($id!=$open_section){            
            if($id!=$sec && $id!=undefined){
              // lg($id.replace("-"," ")+" "+$open_section);
              if($id!="cover"){
                option("#content-section,#content-section2",$id,ucfirst($id.replace("-"," ").replace("-"," ")))
                $sec = $id;
              }
            }
          }
        })
      }

      function option($clid,$val,$txt){  
          $($clid).append($('<option>', { 
              value: $val,
              text : $txt 
          }));
      }
      
      function push_comment(cid,crp,cnm,con,cdt,ttl,$load,$cek,$share,$hdr,$dtl,magz_hdr){
        $nload  = "";
        if($load=="new" || $load=="post"){
          $nload = "data-load='baru'";
        }
        if(crp=="0"){
          cnt = "<b>"+cnm+"</b><br/>"+con;
          if($share!="" && $share !== undefined){
            if($dtl!== null){
              if(con!=""){
                con = "<div class='mt-1 mb-1 p-1 cmnt-cnt'>"+con+"</div>";
              }
              
              if( $share.indexOf(magz_hdr) != -1 ){
                cnt = "<b>"+cnm+"</b><br/><a class='share-content mb-1' data-share='"+$share+"' section-id='"+magz_hdr+"'>"+$dtl+"</a>"+con;
              }else{
                idnya = $("#"+$share).attr("class").split(" ");
                $xidnya = idnya[0].replace("-"," ").toUpperCase();
                cnt = "<b>"+cnm+"</b><br/><a class='share-content mb-1' data-share='"+$share+"' section-id='"+magz_hdr+"'>"+$xidnya+" - "+$dtl+"</a>"+con;
              }
            }else{
              cnt = cnt+"&nbps;";
            }
          }
           var komen = "<ul>"+
              "<li class='prnt' id='com-"+cid+"' "+$nload+" data-child='"+ttl+"'>"+
                "<div class='rpdtl'>"+
                  "<div class='cmnt-txt'>"+
                  cnt+
                  "</div>"+
                "</div>"+
                "<div class='cmnt-reply'>"+cdt+
                  "<a class='reply-cmnt' comment-id='"+cid+"' comment-name='"+cnm+"'>Reply</a>"+
                "</div>"+
                "<ul></ul>"+
              "</li>"+
            "</ul>";
            $("#result-comment").append(komen);
        }else{
          // alert($cek)
          if($cek=="df"){
            if($load=="load"){
              $ortu = "#cmn-"+crp;
            }else{
              $ortu = "#com-"+crp;
            }
          }else{
            if($cek.substr(0,1)=="c"){
              $ortu = "#"+$cek;
            }else{
              $ortu = "#cmn-"+$cek;                
            }
          }
          // lg($ortu);
          $parent = $($ortu);
           var komen2 = "<li class='pr-"+crp+" anak' id='com-"+cid+"' "+$nload+">"+
                "<div class='rpdtl2'>"+
                  "<div class='cmnt-txt'>"+
                  "<b>"+cnm+"</b><br/>"+con+
                  "</div>"+
                "</div>"+
                "<div class='cmnt-reply'>"+cdt+
                  "<a class='reply-cmnt' comment-id='"+cid+"' comment-name='"+cnm+"'>Reply</a>"+
                "</div>"+
              "</li>";
            $parent.find("ul").append(komen2);
           if(ttl>1){
              if($parent.find(".load-child").length){
                $parent.find(".load-child").attr({"span":(ttl - 2),"data-child":(ttl - 2)})
              }else{
                $parent.append("<div class='cmnt-reply2 load-child' id='pr-"+cid+"' data-child='"+(ttl - 1)+"' reply='parent'>lihat balasan lainnya <span>("+(ttl - 1)+")</span></div>");
              }
           }
        }
      }
      function getcomment($tipe,$id){
        content_section();
        $("ov-loading").fadeIn();
        // alert($num);
        $section = $(".ov-footer").attr("openview-page");
        $.ajax({
          type: 'GET',
          url: base_url("comment_get/"+$section+"/"+$tipe+"/"+$id_edisi),
          dataType:"json",
          success: function(data){
            if(data["chdr"].length){
              var objk = data["chdr"];
              for(var k in objk) {
                 var cid  = objk[k].id;
                 var crp  = objk[k].rpl;
                 var cnm  = objk[k].nme;
                 var con  = objk[k].txt;
                 var cdt  = objk[k].tgl;
                 var ctl  = objk[k].ttl;
                 var chd  = objk[k].chld;
                 var shr  = objk[k].share;
                 var hdr  = objk[k].cnt_hdr;
                 var dtl  = objk[k].cnt_dtl;
                 var mst  = objk[k].magz_hdr;
                 push_comment(cid,crp,cnm,con,cdt,ctl,"load","df",shr,hdr,dtl,mst);
                 if(chd !== null){
                    push_comment(chd.id,chd.rpl,chd.nme,chd.txt,chd.tgl,ctl,"load-rpl","df",shr,hdr,dtl,mst);
                 }
              }
            }
          }
        })
      }
      function getmorecomment($tipe,$id,$rpl){
        $("ov-loading").fadeIn();
        $(".ov-comment .back").fadeIn();
        $section = $(".ov-footer").attr("openview-page");
        $chd = "";
        if($rpl==0){
          $("#"+$id).find(".anak").each(function(){
            $chd += $(this).attr("id").replace("com-","")+",";
          })
        }
        $id = $id.replace("com-","").replace("cmn-","");
        $.ajax({
          type: 'POST',
          url: base_url("comment_get_more/"+$section+"/"+$tipe+"/"+$id_edisi),
          dataType:"json",
          data: {
              'cmnt_prnt' : $id,
              'cmnt_chld' : $chd
          },
          success: function(data){
            if(data["chdr"].length){
              var objk = data["chdr"];
              for(var k in objk) {
                 var cid  = objk[k].id;
                 var crp  = objk[k].rpl;
                 var cnm  = objk[k].nme;
                 var con  = objk[k].txt;
                 var cdt  = objk[k].tgl;
                 var ctl  = objk[k].ttl;
                 var chd  = objk[k].chld;
                 var shr  = objk[k].share;
                 push_comment(cid,crp,cnm,con,cdt,ctl,"load",$id,shr,"","");
                 if(chd !== null){
                    push_comment(chd.id,chd.rpl,chd.nme,chd.txt,chd.tgl,ctl,"load-rpl",$id,shr,"","");
                 }
              }
            }

            $hdr = $("#cmn-"+$id);
            $ttl = $hdr.attr("data-child");
            $shw = $hdr.find(".anak").length;
            $sisa = ($ttl-$shw);
            if($sisa>0){
              $hdr.find(".load-child span").html("("+$sisa+")");
            }else{
              $hdr.find(".load-child").attr("reply","hide").text("sembunyikan balasan");
            }
          }
         })
      }