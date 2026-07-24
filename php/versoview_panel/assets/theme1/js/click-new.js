// JAVASCRIPT (jQuery)

// Trigger action when the contexmenu is about to be shown

$(document).ready(function () {
    var $Ourl = window.location.href;
    var $Durl = $(".cntn-input")
    $(".open-wa").click(function () {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            window.location.href = "whatsapp://send?text=" + $Ourl + "&text=" + $Durl.val();
        } else {
            if ($(location).attr("hostname") == "localhost") {
                window.location.href = "whatsapp://send?text=" + $Ourl + "&text=" + $Durl.val();
            } else {
                window.location.href = "https://web.whatsapp.com/send?text=" + $Ourl + "&text=" + $Durl.val();
            }
        }
    })
    $(".open-tl").click(function () {
        window.location.href = "https://telegram.me/share/url?url=" + $Ourl + "&text=" + $Durl.val();
    })
    $(".open-tw").click(function () {
        window.location.href = "https://twitter.com/intent/tweet?url=" + $Ourl + "&text=" + $Durl.val();
    })
    $(".open-fb").click(function () {
        // alert("gs");
        // javascript:ShareToFaceBook({url:$Ourl, title:"test", screenshot:"teset", description:"test"})
        // window.open("http://www.facebook.com/sharer.php?u=" + share_url.toString() + "&picture=" + b.screenshot)
        window.open("http://www.facebook.com/sharer.php?u=" + $Ourl.toString());
    })
    // alert($Ourl);
    /*
    javascript:ShareToFaceBook({url:share_url, title:share_title, screenshot:share_screenshot, description:share_description})"
    tw 
    
    whatsapp://send?text=http://localhost/versoview/pageturner/ov-comment/88/ovi.html#p12&text=test
    */
})
$(document).on("contextmenu", function (event) {
    // Avoid the real one
    event.preventDefault();
    if (event.target.id) {
        if($komen!="x"){
            popup_box(event, "page");
        }
    } else {
        if (event.view.window.$open_section) {
            $cls = event.view.window.$open_section;
            $("." + $cls).removeClass("spanhover");
        }
    }
});

$(document).on("clickup mouseup", function (e) {
    e.preventDefault();
    var sel = this.getSelection()
    if (sel.rangeCount === 0 || sel.isCollapsed) return;

    if (e.target.id) {
        if (sel.toString().length >= 10) {
            popup_box(e, sel.toString());
        }
    }
})

function popup_box(event, tipe) {
    $class = (event.target.className);
    $id = (event.target.id);
    $("#get-content").attr("class", $id)
    $(".cntn-input").attr("data-share", $id);
    var $csclick = $(".custom-menu");
    // Show contextmenu
    //add 21-06-21        
    if (tipe == "page") {
        $("." + $class).removeClass("spanhover");
        $("#" + $id).addClass("spanhover");
        $txt = $("#" + $id).text().substring(0, 250).trim();
    } else {
        $txt = tipe;
    }
    if ($txt.length < 15) {
        return;
    }
    $csclick.find(".modal-body p").html($txt);
    $csclick.find(".cntn-input").val("");
    //end
    if (event.clientY < 100) {
        Ypage = event.pageY - (event.clientY) + 30;
    } else if (event.clientY >= 200 && event.clientY < 200) {
        Ypage = event.pageY - (event.clientY) + 70;
    } else {
        Ypage = event.pageY - 100;
    };
    
    // console.log(event.clientX+" "+window.innerWidth+);
    $rms = (event.clientX / window.innerWidth) * 100
    if($rms>35){
        Xpage = window.innerWidth - event.clientX;
    }else{
        Xpage = event.clientX;
    }
    // console.log($rms+" "+event.clientX +" "+window.innerWidth+ " "+Xpage);
    $csclick.finish().toggle(100).
        // In the right position (the mouse)
        css({
            top: (Ypage) + "px",
            left: (Xpage) + "px"
        });
    setTimeout(function () {
        $(".cntn-input").focus();
    }, 200)
    // content_section();
}

// If the document is clicked somewhere
$(document).bind("mousedown", function (event) {

    // If the clicked element is not the menu
    if (!$(event.target).parents(".custom-menu").length > 0) {

        // Hide it
        if (event.view.window.$open_section) {
            $cls = event.view.window.$open_section;
            $("." + $cls).removeClass("spanhover");
        }
        $(".custom-menu").hide(100);
    }
});

// If the menu element is clicked
$(document).on("click", ".custom-menu li", function (event) {
    //     $id = $(this).attr("class");
    //     $txt = $("#"+$id).text().substring(0,200);
    //     $(".ov-comment").show();
    //     $(".cmnt-post").prop("disabled",false).removeClass("disabled");    
    //     $(".cmnt-input").val($txt).select().attr("data-share",$id);
    //     // Hide it AFTER the action was triggered
    //     $(".custom-menu").hide(100);
    //     if(event.view.window.$open_section){s
    //         $cls = event.view.window.$open_section;
    //         $("."+$cls).removeClass("spanhover");
    //     }
});

$(document).on("click", ".share-content", function (event) {
    $id  = $(this).attr("data-share");
    $mid =  $(this).attr("section-id");
    // alert($id);
    gocnt($id,$mid);
    // gotop("#" + $id,"share");    
})