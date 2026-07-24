<div id="boximageall" class="v_photopopular">
<?php
    $cari = 1;
    foreach ($issuemagazine as $result) {
        $mid = $result->issue_id;
        $img = magz_img($result->gambar);
        $txt = $result->issue_title;
        #$base = $result->base_url;
        $url = $result->issue_id;  
        $pge = $result->pdf_page;  
        $cnv = $result->pdf_conv;      
        $pub = $result->pdf_pub;
        $cat = $result->cat;
        $stat= istatus($cnv,$pub);
        $desk= $result->desk;
        $path = $result->issue_path;
        $dir  = "./pageturner/".$path."/files/page/";
        $pros = $result->date_pros;


        if($cnv=="1"){
        #echo $this->Mod_magick->ttl_pros_conv()->ttl_process."xxxx";
          if(is_dir($dir)){
            $tg2   = date("Y-m-d H:i:s");
            $total = $this->Mod_magick->count_img($path,"cek",$dir);
            if($total!=$pge){
              $zrey  = "";
              for ($zre=1; $zre<=$pge; $zre++) { 
                $nazar = $dir.$zre.".jpg";
                if(!file_exists($nazar)){
                  $zrey = $zre;
                  break;
                }
              }
              $page   = ($zrey - 1 ).",".$pge;
              #limitasi 2 perproses per user nya supaya server ga lag
              if($cari<=2){
                if((strtotime($tg2) - strtotime($pros))>1200){ #get process is runing more than 2 hours
                  $DtlMgz = $this->Mod_magazine->DtlMagz($url,"issue_id");
                  //convert pdf to jpg
                  $this->Mod_magick->convert_iss($DtlMgz,$url,"reconvert",$page);
                  $this->Mod_magazine->ProConv($result->issue_path,array("issue_date_process"=>$tg2));
                }
              }
              $cari++;
            }else{
              $this->Mod_magazine->ProConv($result->issue_path,array("issue_convert"=>"2"));
              $cnv = 2;
            }
          }else{
              $this->Mod_magazine->ProConv($url,array("issue_convert"=>"0"));
              $cnv = 0;
          }
        }

        if($cnv==0 && $pub==0){
          $cpub = "cnone";
          $ipro = "ipro_pub";
          $pcn  = "";
        }elseif($cnv!=0 && $pub==0){
          $cpub = "cready";
          $ipro = "ipro_con";
          $pcn  = "style='width:100%'";
        }elseif($cnv==2 && $pub==1){
          $cpub = "cpok";
          $ipro = "ipro_def";
          $pcn  = "style='width:100%'";
        }else{
          $cpub = "";
          $ipro = "ipro_flip";
          $pcn  = "style='width:100%'";
        }
        /*
.ipro_def{display: block;background: #f5f5f5 !important}
.ipro_con{display: block;background: #ff533d !important}
.ipro_pub{display: block;background: #ab987a !important}
.ipro_flip{display: block;background: #0f1627 !important}*/
        ?>
          <a target="_blank" class="<?= $grid ?> i_gallery  p_hide  photo_dtl cover-tengah <?= $cpub ?> brdgr" data-toggle="modal" data-target="#edit-magz" data-magz="<?= $url ?>" data-page="<?= $pge ?>">
            <div class="">
              <div class="<?= $col ?> nmp column" style="float: left">
                <u class=""><?= $cat ?></u>
                <u class="p_like"><?= $pge ?> <b class="fas fa-file"></b></u>
                <p style="background: url(<?= $img ?>);" class="grow" data-img="<?= $img ?>">
                </p>
                <h5 class=""><?= $txt ?></h5>
              </div>
              <div class="col-5 nmp label" style="float:right;padding:10px !important">
                <label><b><?= $txt ?></b></label>
                <label><?= $cat ?></label><br/>
                <label><?= $pge ?> Pages</label>
                <label><?= $stat ?></label>
                <label style="border: none !important"><?= paragrap($desk,10) ?></label>
              </div>
              <div id="is_<?= $mid ?>" class="issue_progress" style="height: 3px !important;position: absolute;bottom:0">        
                <div class="<?= $ipro ?>" <?= $pcn ?>>&nbsp;</div>
              </div>
            </div>
          </a> 
        <?php
    }
?>
</div>
