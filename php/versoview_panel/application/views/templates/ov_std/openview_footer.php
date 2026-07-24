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
      <div class="ov-footer">
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
         <?php
         if($halaman && is_numeric($halaman)){
           echo '
               <a class="ov-logo pull-left">
                <img src="'.$msturi.'assets/images/icon-ovi.png">
               </a>
               <a class="ov-font pull-left">
                <img src="'.$msturi.'assets/images/icon-font.png">
               </a>    
               <a class="ov-mini pull-left">
               <img src="'.$msturi.'assets/images/icon-full1.png">
               </a>
               <a class="ov-back pull-left none">
               <img src="'.$msturi.'assets/images/icon-back.png">
               </a>';
          }
          ?>
      </div> 
      <div class="ov-footer2">
        <?php
         if($halaman && is_numeric($halaman)){
           echo '
               <a class="ov-maxi" style="float: right;margin-bottom: 2px;">
               <img src="'.$msturi.'assets/images/icon-maxi.png">
               </a>';
          }
         ?>
      </div> 
   </body>
</html>