<?php 
    if($submagazine){
        $cover = magz_img($submagazine->gambar);
        $title = $submagazine->base_url;
        $edisi = $submagazine->issue_title;
        $desc  = $submagazine->issue_desc;
        $flip  = $submagazine->flipbook;
        $url   = "<a href='".base_url('index.php')."''>Home</a> / <a href='".strtolower($datamagazine->magz_name)."''>".ucwords(strtolower($datamagazine->magz_name))."</a> / <b>".$edisi."</b>"; 
        $conv  = "";
        $mid   = $submagazine->magz_id;
		$href  = "";
    }else{
        if($datamagazine->magz_fk_issue==0){
            $cover = magz_img($datamagazine->gambar);
            $title = $datamagazine->magz_name;
            $edisi = $datamagazine->issue_title;
            $desc  = $datamagazine->magz_desc;
            $flip  = $datamagazine->flipbook;
            $url   = "<a href='".base_url('index.php')."''>Home</a> / <b>".$title;
            $conv  = $datamagazine->magz_process_c2flip; 
            $mid   = $datamagazine->magz_id;
			$href  = base_url("magazine/".strtolower($title)."/index.html");

      #magz_pdf_file,magz_process_c2flip
        }else{
            $cover = magz_img($issuemagazine->gambar);
            $title = $issuemagazine->base_url;
            $edisi = $issuemagazine->issue_title;
            $desc  = $issuemagazine->issue_desc;
            $flip  = $issuemagazine->flipbook;
            $url   = "<a href='".base_url('index.php')."''>Home</a> / <b>".$title;  
            $conv  = "";      
            $mid   = $issuemagazine->magz_id; 
			$href  = ""; 
        }
        #echo h3($datamagazine->magz_fk_issue);
    }
    if($datamagazine->magz_price<=0){
        $subscribe = "FREE SUBSCRIBE";
    }else{
        $subscribe = "PURCHASE TO SUBSCRIBE";
    }
    if(strlen($flip)>0){
        $flipbook = "
                    <div class='col-md-6'>
                        <a href='".$flip."' target='_blank'><div class='btn-prev color1'>READ ISSUE</div></a>
                    </div>
                    <div class='col-md-6'>
                        <!-- <div class=' btn-next color2'>DOWNLOAD</div> -->
                        <div class=' btn-next color2'>$subscribe</div>
                    </div>";

    }else{
        $flipbook = "
                    <div class='col-md-6'>
                        <!-- <div class=' btn-next color2'>DOWNLOAD</div> -->
                        <div class=' btn-next color1'>$subscribe</div>
                    </div>";
    }
    #echo h3($flip);
?>
    <div class="main-content" style="padding:10px">
        <div class="section__content">
            <div class="container-fluid">
                <div class="row">
<!-- content -->

                <div class="row"  style="padding-top:0px;">
                  <div id="detail-show">
                    <div class="container">
                        <div class="col-lg-12 row">
                            <div class="col-lg-4">
                                <img src="<?= $cover ?>" width="90%">
                            </div>
                            <div class="col-md-8 text-left">
                                <div style="margin-bottom: 20px">
                                  <h3><?= $title ?></h3>
                                  <label><?= $edisi."" ?>&nbsp;</label>
                                </div>
                                <br/>
                                <div style="position: absolute;right:0;top:0;min-height: 70px;width: 100px" class="btn-magz">
                                  <?php  if($conv==0){
                                    echo '<button class="w100 ver-bg4 ver-clr1" id="convert-magazine" magz-id="'.$mid.'">Convert PDF</button>';
                                  }else{
                                    echo '<button class="w100">Already Convert</button>';
                                  }
                                  ?>
                                  <button class="w100">Status publish</button>
                                  <button class="w100">Status App</button>
                                </div>
                                  <p  style="padding:10px;background:#fefefe; border-radius:5px;">
                                      <?= $desc ?>
                                  </p>
                              <div class="btn-magz" style="float:right">
                                <button>Setting</button>
                                <button>Content</button>
                                <button>Share</button>
                                <button>Statistic</button>
                                <button>Delete</button>
                              </div>
                              <div class="btn-magz" style="float:left">
                                  <?php 
                                  if($conv==2){
                                    echo '<a href="'.$href.'" target="_blank" ><button class="ver-bg3">View Pageturner</button></a>';
                                  }
                                  ?>
                                
                              </div>
                          </div>
                        </div>
                    </div>
                <div>
                    <?php
                    if($datamagazine->magz_price<=0){
                        /*
                    ?>
                    <div style="background-image: url(<?= base_url('assets/images/bg.png')?>);height: 260px;margin-bottom: 30px">
                        <div class="container subscribe-form">
                            <h1>SUBSCRIBE</h1>
                            <p>and join us for update on new issue!</p>
                            <input type="text" placeholder="subscibe" class="input">
                            <button>SEND</button>
                        </div>
                    </div>
                    <?php
                    */
                    }else{
                    ?>
                <div>
                    <div class="container section-purchase">
                      <div class="text-left"><b>PURCHASE PRICE</b></div>
                        <div style="margin:20px 0 !important;overflow: auto">
                            <div class="col-md-3">
                              <div class="purchase pactive">
                                <h4 class="pactive">SINGLE EDITION</h4>
                                <h1>$ 2.99</h1>
                                <!-- <div class="content">
                                  <p>10gb Cloud Storage</p>
                                  <p>Unlimited Access</p>
                                  <p>Free Support</p>
                                </div> -->
                                <div class="button">GET STARTED</div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="purchase">
                                <h4>3 MONTH</h4>
                                <h1>$ 7.99</h1>
                                <!-- <div class="content">
                                  <p>10gb Cloud Storage</p>
                                  <p>Unlimited Access</p>
                                  <p>Free Support</p>
                                </div> -->
                                <div class="button2">GET STARTED</div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="purchase">
                                <h4>6 MONTH</h4>
                                <h1>$ 15.99</h1>
                                <!-- <div class="content">
                                  <p>10gb Cloud Storage</p>
                                  <p>Unlimited Access</p>
                                  <p>Free Support</p>
                                </div> -->
                                <div class="button2">GET STARTED</div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="purchase">
                                <h4>1 YEAR</h4>
                                <h1>$ 30.99</h1>
                                <!-- <div class="content">
                                  <p>10gb Cloud Storage</p>
                                  <p>Unlimited Access</p>
                                  <p>Free Support</p>
                                </div> -->
                                <div class="button2">GET STARTED</div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php } ?>
                    <!-- </div> -->

                    <?PHP 
                    if($lastmagazine){ ?>
                <div style="background: #fff;overflow: auto">
                    <div class="container section-magazine-list" >
                      <div class="text-left" style="padding-top:10px">OTHER ISSUES OF <b><?= $datamagazine->magz_name; ?> MAGAZINE</b></div><br/>
                      <?php
                     # var_dump($lastmagazine);
                          foreach ($lastmagazine as $result) {
                              $img = magz_img($result->gambar);
                              $txt = $result->issue_title;
                              $base = $result->base_url;
                              $url = $result->issue_url;
                                echo '
                              <a class="col-20" href='.base_url("admin/magz/".$base."/".$url).'>
                                <div class="cover-tengah">
                                  <img src="'.$img.'">
                                  <p>'.$txt.'</p>
                                </div>
                              </a>';
                          }
                      ?>    
                    </div>
                    <!-- <div class="container other-edition">
                        <div class="col-md-12">
                            <div class="container-fluid btn-next color1">LOAD MORE MAGAZINES</div>
                        </div>
                    </div> -->
                <?php } ?>
                  </div>
                </div>
                </div>
<!--  -->

                </div>
            </div>
        </div>
    </div>