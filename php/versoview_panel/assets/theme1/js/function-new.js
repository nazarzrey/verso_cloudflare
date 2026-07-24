
function autoload_cmnt($len) {
  $num = 10;
  $rms = ($len / $num) / $num * $num;
  if (Number.isInteger($rms)) {
    getcomment("load", "0");
  }
  // setTimeout(function(){            
  //   
  // },5000);
}

function load_cmnt($tipe) {
  $frmcmnt = $(".ov-comment");
  if ($tipe == "load-auto") {
    $frmcmnt.show();
  } else {
    $frmcmnt.toggle();
  }
  if ($frmcmnt.is(":visible")) {
    storage.set("comment-frm", true);
    //getcomment("default","0");              
  } else {
    storage.rem("comment-frm");
  }
  fokus("cmnt-input");
}

// function timeout(time){
//     setInterval(function(){
//     },time);
// }
function fokus($class) {
  setTimeout(function () {
    $("." + $class).focus();
  }, 700);
}
function getuname($tipe) {
  $uname = storage.get("uname");
  if ($uname === undefined) {
    alert("please input your name first...");
    if ($tipe == "") {
      $(".cmnt-frm").hide();
      $(".cmnt-frm-name").removeClass("hide").fadeIn()
      setTimeout(function () {
        $(".cmnt-input-name").focus().val("");
      }, 1000);
    } else {
      $(".cntn-frm").hide();
      $(".cntn-frm-name").removeClass("hide").fadeIn()
      setTimeout(function () {
        $(".cntn-input-name").focus().val("");
      }, 1000);
    }
  }
}

function jxhr(url) {
  var jqXHR = $.ajax({
    url: base_url(url),
    dataType: 'json',
    async: false
  });
  return JSON.parse(jqXHR.responseText);
}
function v_stop() {
  $vv = $('#video_player').trigger("pause");
}

function openPath() {
  pathPage = window.location.hash.substr(1);
  $goto = pathPage.replace("p", "ov-");
  return $goto;
}
function openHdr($goto) {
  parent.location.hash = "";
  hide_menu("disabled");
  $("#OpenView-Dtl").hide();
  $(".cnt-dtl").hide();
  $(".cnt-show").hide();
  $(".ov-comment").hide();
  $(".cmnt-frm-name,.cntn-frm-name").hide();
  $(".cnt-hdr").show();
  getdata("hdr", $edisi, nasabah);
  data_likebook("");
  if ($goto != "") {
    if ($("#" + $goto).hasAttr("list-content-first")) {
      godtl("top-one", "0");
    } else {
      gohdr($goto, "60");
    }
  }
  change_text_menu("", "hdr");
  $("#result-comment").html("");
  $(".ov-logo-hdr").removeClass("none");
  $(".ov-logo").addClass("none");
  $(".flip-url").attr("data-page", "");
}
function openDtl($dtl, $goto, $push) {
  // popup($push,0)
  parent.location.hash = $push;
  $("#OpenView-Dtl").show();
  $(".cnt-dtl").hide();
  $(".cnt-hdr").hide();
  $(".ov-logo-hdr").addClass("none");
  $(".ov-logo").removeClass("none");
  $("#" + $dtl).show().attr("section-hdr", $push.replace("p",""));
  load_likebook($dtl, $push);
  data_likebook($dtl);
  load_readcontent();
  
  // alert($target1+"p"+realPage+"p"+realPage)
  // alert($dtl+);
  change_text_menu($dtl, "dtl");
  hide_menu("enable");
  $("#result-comment").html("");
  getcomment("default", "0");
  comment_frm();
  $(".flip-url").attr("data-page", $push);
  if ($goto == "OpenView-Dtl") {
    godtl($push, "70");
  }else{
    godtl($push, "60");
  }
}
function comment_frm() {
  if (storage.get("comment-frm")) {
    // alert($komen)
    if($komen!="x"){
      $(".ov-comment").show();
    }
  }
}
function change_text_menu($dtl, $tipe) {
  if ($tipe == "dtl") {
    $title = $("#" + $dtl).attr("data-title");
    $(".text-menu1").hide();
    $(".text-menu0,.text-menu3").show();
    $(".text-menu0,.text-menu3").attr("judul", $(".text-menu0,.text-menu3").find("a").text())
    $(".text-menu0,.text-menu3").find("a").text($title)
  } else {
    $(".text-menu1").show();
    $txt = $(".text-menu0,.text-menu3").attr("judul");
    $(".text-menu0,.text-menu3").find("a").text($txt);
  }
}
function getdata($key, $edisi, $nasabah) {
  $.getJSON(base_url($key + '/' + $edisi + '/' + $nasabah), function (data, status) {
    if (status == "success") {
      if (data["like"].length) {
        var objk = data["like"];
        for (var k in objk) {
          var konten = objk[k].content;
          var t_like = objk[k].tlike;
          $('.get-api-ovi').each(function (i) {
            var prev = $(this).attr("data-ovi");
            var obj1 = $(this).find(".hdr-ov-like").find("span");
            if (prev == konten) {
              $(obj1).text(t_like);
            }
          });
        }
      }
      if (data["cmnt"].length) {
        var objk = data["cmnt"];
        for (var k in objk) {
          var konten = objk[k].content;
          var t_cmnt = objk[k].tcmnt;
          $('.get-api-ovi').each(function (i) {
            var prev = $(this).attr("data-ovi");
            var obj2 = $(this).find(".hdr-ov-cmnt").find("span");
            if (prev == konten) {
              $(obj2).text(t_cmnt);
            }
          });
        }
      }
    }
  })
}
// function childcomment(obj,$id){
// }
function lg($obj) {
  console.log($obj);
}

// like_book("like",$id,"0");
function like_book($tipe, $section, $id, $value) {
  // alert($edisi);
  $.ajax({
    type: 'POST',
    url: base_url("likebook"),
    dataType: "json",
    data: {
      'tipe': $tipe,
      'uid': $id,
      'value': $value,
      'edisi': $edisi,
      'section': $section,
      'section_dtl': ''
    },
    success: function (data) {

    }
  });
}
function hide_menu($btn) {
  if ($btn == "disabled") {
    $(".ov-footer-popup").show();
    $(".ov-like").find("img").attr("src", assets("extfile/like.png"));
    $(".ov-bookmark").find("img").attr("src", assets("extfile/bookmark.png"));
  } else {
    $(".ov-footer-popup").hide();
  }
}
$.fn.isInViewport = function () {
  var elementTop = $(this).offset().top;
  var elementBottom = elementTop + $(this).outerHeight();

  var viewportTop = $(window).scrollTop();
  var viewportBottom = viewportTop + $(window).height();

  return elementBottom > viewportTop && elementTop < viewportBottom;
};

function godtl($id, $add) {
  $xid = $("#" + $id);
  if ($xid.offset()) {
    $('html, body').animate({
      scrollTop: $xid.offset().top - $add
    }, 100);
  } else {
    $('html, body').animate({
      scrollTop: $('html, body').offset().top - $add
    }, 100);
  }
}
function gohdr($id, $add) {
  $xid = $("." + $id);
  if ($xid.offset()) {
    $('html, body').animate({
      scrollTop: $xid.offset().top - $add
    }, 100);
  } else {
    $('html, body').animate({
      scrollTop: $('html, body').offset().top - $add
    }, 100);
  }
}
function gogo($add) {
  $xid = $(".cnt-dtl");
  $('html, body').animate({
    scrollTop: $xid.offset().top - $add
  }, 100);
}
function gotop($id, $tipe) {

  $xid = $($id);
  $padd = 0;
  if ($tipe == "body") {
    elem = 'html, body';
    $time = 100;
  } else if ($tipe == "share") {
    elem = 'html, body';
    $time = 800;
    $padd = 100;
  } else if ($tipe == "komen") {
    elem = "#ov-comment";
    $time = 1000;
  } else {
    elem = $id;
    $time = 1000;
    $xid = $($id + " " + $tipe);
  }
  $(elem).animate({
    scrollTop: $xid.offset().top - $padd
  }, $time);

  $(elem).animate({ scrollTop: 500 }, $time);
}
function popup(data,top){
  $("html").append('<div style="position:fixed;top:'+top+'px;z-index:999999;background:#fff;padding:10px;border:solid 1px red;min-width:300px" data-attr="">'+data+'</div>');
}
function gocnt($id,$mid) {
    
  $cid = $("#"+$id).attr("class").split(" ");
  $xid = $("#"+$cid[0]);
  if($xid.css("display")=="none"){
    $(".cnt-dtl").hide();
    $xid.css("display","block");    
    change_text_menu($cid[0], "dtl");
  }
  $(".cnt-dtl").find(".spanhover").removeClass("spanhover");
  $("#" + $id).addClass("spanhover");
  $xid = $("#"+$id);
  $padd = 60;
  elem = 'html, body';
  $time = 100;
  // popup($xid.attr("class"),100)
  $(elem).animate({
    scrollTop: $xid.offset().top - $padd
  }, $time);

  // $(elem).animate({ scrollTop: 1000 }, $time);
}
function skrool($class, $cont) {
  var $container = $("html, body");
  if ($cont != "") {
    $container = $($cont);
  }
  var $scrollTo = $($class);
  $container.animate({ scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop(), scrollLeft: 0 }, 300);
}

function load_readcontent() {
  $key = "ov-font";
  $read = $(".content-page,.fisrt-content-page, div p,.content-page label,.content-page section,.cmnt-txt");
  if (storage.get($key)) {
    $read.addClass("font-18");
  }
}
function load_likebook($dtl, $push) {
  $push = $push.replace("p", "");
  $page = $dtl;
  $title = $("#" + $page).find("h2").text();
  $(".ov-footer").attr("openview-page", $page).attr("openview-page-title", $title);
  $key1 = $edisi + "|" + nasabah + "|ov-like|" + $page;
  $key2 = $edisi + "|" + nasabah + "|ov-bookmark|" + $page;
  if (storage.get($key1)) {
    $("#ov-like").find("img").attr("src", assets("extfile/like-ok.png"));
  } else {
    $("#ov-like").find("img").attr("src", assets("extfile/like.png"));
  };
  if (storage.get($key2)) {
    $("#ov-bookmark").find("img").attr("src", assets("extfile/bookmark-ok.png"));
  } else {
    $("#ov-bookmark").find("img").attr("src", assets("extfile/bookmark.png"));
  };
}
function data_likebook($dtl) {
  //likebook
  $(".dlike ul").html("");
  $(".dbook ul").html("");
  $(".cnt-dtl").each(function () {
    $page = $(this).attr("id");
    $key1 = $edisi + "|" + nasabah + "|ov-like|" + $page;
    $val1 = storage.get($key1);
    $key2 = $edisi + "|" + nasabah + "|ov-bookmark|" + $page;
    $val2 = storage.get($key2);
    $judul = $page.replace("-", " ").toUpperCase();
    if ($val1) {
      $url1 = $val1["page"].replace("ov-", "p");
      $(".dlike ul").append("<li><a href='#" + $url1 + "' class='bookmark-link'>" + $judul + " : " + $val1["title"] + "</a></li>");
    }
    if ($val2) {
      $url2 = $val2["page"].replace("ov-", "p");
      $(".dbook ul").append("<li><a href='#" + $url2 + "'  class='bookmark-link'>" + $judul + " : " + $val2["title"] + "</a></li>");
    }
  })
}
function hide_repl() {
  //             $("#comment").find(".cmnt-posts").hide();
  $("#ov-comment").find(".cmnt-frm-reply").remove();
}
function isInView(elem) {
  return $(elem).offset().top - $(window).scrollTop() < $(elem).height();
}
function unic() {
  $.get(base_url("unic"), function (data, status) {
    unic_device = data;
  });
}
function base_url($url) {
  if ($(location).attr("hostname") == "localhost") {
    //return "http://localhost/agencyfish/weblist/versoview/openvi/"+$url;
    return "http://localhost/versoview/openvi/" + $url;
  } else {
    return "https://panel.versoview.com/openvi/" + $url;
  }
}
function assets($assets) {
  $base = $("#ptop").attr("base-url");
  return $base+$assets;
}
function ucfirst(str) {
  return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
    return $1.toUpperCase();
  });
}

$.fn.hasAttr = function (name) {
  return this.attr(name) !== undefined;
};