<?php 
    if($submagazine){
        $cover = magz_img($submagazine->gambar);
        $title = $submagazine->base_url;
        $edisi = $submagazine->issue_title;
        $desc  = $submagazine->issue_desc;
        $flip  = $submagazine->flipbook;
        $url   = "<a href='".base_url('index.php')."''>Home</a> / <a href='".strtolower($datamagazine->magz_name)."''>".ucwords(strtolower($datamagazine->magz_name))."</a> / <b>".$edisi."</b>"; 
    }else{
        if($datamagazine->magz_fk_issue==0){
            $cover = magz_img($datamagazine->gambar);
            $title = $datamagazine->magz_name;
            $edisi = $datamagazine->issue_title;
            $desc  = $datamagazine->magz_desc;
            $flip  = $datamagazine->flipbook;
            $url   = "<a href='".base_url('index.php')."''>Home</a> / <b>".$title; 
        }else{
            $cover = magz_img($issuemagazine->gambar);
            $title = $issuemagazine->base_url;
            $edisi = $issuemagazine->issue_title;
            $desc  = $issuemagazine->issue_desc;
            $flip  = $issuemagazine->flipbook;
            $url   = "<a href='".base_url('index.php')."''>Home</a> / <b>".$title;          
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
                                  <label><?= $edisi ?></label>
                                </div>
                                <br/>
                                <div style="position: absolute;right:0;top:0;min-height: 70px;width: 100px" class="btn-magz">
                                  <button class="w100" magz-id="">Process Convert</button>
                                  <button class="w100">Publish Status</button>
                                  <button class="w100">App Status</button>
                                </div>
                                  <p  style="padding:10px;background:#fefefe; border-radius:5px;">
                                      <?= $desc ?>
                                  </p>
                              <div class="btn-magz" style="float:right">
                                <button>Settings</button>
                                <button>Content</button>
                                <button>Share</button>
                                <button>Statistics</button>
                                <button>Delete</button>
                              </div>
                              <div class="btn-magz" style="float:left">
                                <button>Count View</button>
                              </div>
                          </div>
                        </div>
                        </div>
                    </div>
                <div>
            </div>
        </div>
    </div>
  </div>
</div>