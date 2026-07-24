         <div class="likebook">
            <!-- <h4 class="text-center">Like & Bookmark</h4> -->
            <div class='container'>
              <div class="row">
                <div style="width: 50%;float: left;padding: 10px;margin-bottom: 20px;display: none" >
                  <h4 style="background-color: #f1f1f1f9;">Like</h4>
                  <div class="dlike">
                    <ul>
                    </ul>
                  </div>
                </div>
                <div style="width: 100%;float: left;margin-bottom: 20px">
                  <div style=" ">
                    <h4 class="text-bookmark">Bookmark</h4>
                    <span class="close-bookmark">X</span>
                  </div>
                  <div class="dbook">
                    <ul>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
         </div>
      <div class="ov-footer" style="background: #fff;position: fixed;bottom: 0;left:0;z-index: 999;width:100%;box-shadow:1px 1px 5px #ccc;">
         <div class="ov-comment hilang" style="border-bottom: solid 1px #f1f1f1;margin-bottom: 15px">
            <h4 class="nmp text-center">Comment</h4>
            <div class='content-page fisrt-content-page'>
               <section style="padding: 10px;background: #f1f1f180;border: solid 1px #f1f1f1">
                  <ul>
                     <li>
                        <ul>
                           <li></li>
                        </ul>
                     </li>
                     <li></li>
                  </ul>
               </section>
            </div>
         </div>
         <div class="popup" style="width: 75%;background-color: #fffbfbb5;height: 25px;position: absolute;right:0">
         </div>
         <a id="" class="ov-logo pull-left">
         <img style="height: 22px;width:25px;margin-top:0px" src="<?=$msturi?>assets/images/ovi.png">
         </a>
         <?php 
         // debug($msturi,"l");
         if($halaman && is_numeric($halaman)){
            echo '
           <a id="" class="ov-share hilang">
           <img src="'.$msturi.'files/extfile/share.png">
           </a>
           <a id="ov-like" class="ov-like">
           <img src="'.$msturi.'files/extfile/like.png">
           </a>
           <a id="ov-comment" class="ov-cmnt">
           <img src="'.$msturi.'files/extfile/comment.png">
           </a>
           <a id="ov-bookmark" class="ov-bookmark">
           <img src="'.$msturi.'files/extfile/bookmark.png">
           </a>';
          }
          ?>
         <a id="" class="ov-font pull-left">
         <img src="<?=$msturi?>files/extfile/font.png">
         </a>    
         <!-- <a id="" class="ov-menu right-mobile">
         <img src="<?=$msturi?>files/extfile/menu.png">
         </a> -->
      </div> 
   </body>
</html>