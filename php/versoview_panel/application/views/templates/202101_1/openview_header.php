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
        $.getMultiScripts = function(arr, path) {
            var _arr = $.map(arr, function(scr) {
                return $.getScript( (path||"") + scr );
            });
                
            _arr.push($.Deferred(function( deferred ){
                $( deferred.resolve );
            }));
                
            return $.when.apply($, _arr);
        }
        var script_arr = [
            // 'assets/css/custom.css', 
            '<?= $msturi ?>assets/js/function.js',
            '<?= $msturi ?>assets/js/custom.js',
            '<?= $msturi ?>assets/js/ovjs.js'
        ];
        $.getMultiScripts(script_arr);
        
        var rd =  Math.random().toString(36).substr(2, 9);
        $.ajax({
            url: "ovi-data.html?"+rd, 
            context: document.body,
            success: function(response) {
                $("#ovi-content").html(response);
            }
        });
      </script>
      <!-- 

      <script src="<?= $msturi ?>assets/js/function.js"></script>
      <script src="<?= $msturi ?>assets/js/custom.js"></script>
      <script src="<?= $msturi ?>assets/js/ovjs.js"></script> -->
   </head>
   <body>

    <div id="OpenView-Hdr">

      <div id="ptop" data-openview="bca-87" base-url="<?= $msturi ?>"></div>
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
                                 <li class="nav-item">  <a class="nav-link waves-effect waves-light text-dark text-right mybook">My Bookmarks</a></li>
                                 <li class="nav-item">  <a class="nav-link waves-effect waves-light text-dark text-right" href="<?=$msturi?>index.html">Flipbook</a></li>
                              </ul>  
                         </li>
                      </ul>
                   </div>
                </nav>
             </div>
          </div>
       </div>