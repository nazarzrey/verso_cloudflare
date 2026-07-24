// $(document).ready(function(){
//     //nang lu edit disini aja
//   var unic_device;
 
//   // load_unic();
//   $("#ov-like").click(function() {
//     var content = $(".ov-footer").attr("openview-page-title");
//     var src = $(this).find("img").attr("src");
//     if (src == "files/extfile/like.png"){
//         $(this).find("img").attr("src", "files/extfile/like-ok.png")
//         $.get(base_url("/like/") + ID.get() + "/" + content + "/" + unic_device);
//     }else{
//         $(this).find("img").attr("src", "files/extfile/like.png")
//          $.get(base_url("/like/") + ID.get() + "/" + content + "/" + unic_device + "/1");
//     }
//   });

//   $("#ov-bookmark").click(function() {
//     var content = $(".ov-footer").attr("openview-page-title");
//     var src = $(this).find("img").attr("src");
//     if (src == "files/extfile/bookmark.png"){
//         $(this).find("img").attr("src", "files/extfile/bookmark-ok.png")
//          $.get(base_url("bookmark/") + ID.get() + "/" + content + "/" + unic_device);
//     }else{
//         $(this).find("img").attr("src", "files/extfile/bookmark.png")
//          $.get(base_url("/bookmark/") + ID.get() + "/" + content + "/" + unic_device + "/1");
//     }
//   });
//   // storage.rem($key);
// })
    



// $(document).ready(function(){
//     $(".content-page p").text($(".content-page p").html());
// })

// var currentParent = null;
// var currentSubMenu = null;

// // Hide all sublists
// $('.submenu>ul').hide();
// $('.menu>ul>li').on('click', selectParent);

// function selectParent(event) {
//     var elem = $(this);

//     // If there is a previous parent, hide its child list
//     if (currentParent && !elem.is(currentParent)) {
//         currentSubMenu.hide();
//     }

//     var childID = elem.children('a').attr('href');
//     var childMenu = $(childID);

//     // Show the clicked element's child list
//     childMenu.show();

//     currentParent = elem;
//     currentSubMenu = childMenu;
// }

// /*// window.location
// window.location.replace('http://www.example.com')
// window.location.assign('http://www.example.com')
// window.location.href = 'http://www.example.com'
// document.location.href = '/path'

// // window.history
// window.history.back()
// window.history.go(-1)

// // window.navigate; ONLY for old versions of Internet Explorer
// window.navigate('top.jsp')


// // Probably no bueno
// self.location = 'http://www.example.com';
// top.location = 'http://www.example.com';

// // jQuery
// $(location).attr('href','http://www.example.com')
// $(window).attr('location','http://www.example.com')
// $(location).prop('href', 'http://www.example.com')
// */

