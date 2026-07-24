<?php 
    #echo "issue_listdata.php";
    $auto   = $hdrmagz[0]->cover_auto;
    $title  = $hdrmagz[0]->magz_name;
    $desc   = $hdrmagz[0]->magz_desc;
    $url    = "<a href='".base_url('index.php')."''>Home</a> / <b>".$title;
    $uri    = $hdrmagz[0]->magz_url;
    $mgid   = $hdrmagz[0]->magz_id;
    $cat    = $hdrmagz[0]->cat_name;
    $href   = base_url("pageturner/".$uri."/index.html");
    $sm     = $md = $lg = $grid = $col =  $txtdel = "";
    $adadtl = "hilang";
    if($issue_view->val!=""){
      if($issue_view->val=="1"){
        $sm   = "active";
        $grid = "boximage";
        $col  = "col-12";
      }else{
        $md   = "active";
        $grid = "boximage2";
        $col  = "col-7";
      }
    }
    if($auto=="2"){
      $cover   = magz_img($hdrmagz[0]->cover);
      $txtauto = "Manual Change";
    }else{
      if(empty($hdrmagz[0]->cover_issue)){
        $cover   = magz_img($hdrmagz[0]->cover);
      }else{
        $img     = $this->Mod_magazine->magazine_gallery("magazine",$hdrmagz[0]->cover_issue);
        $cover   = magz_img($img);
      }
      $txtauto = "Auto Change";
    }
    if($hdrmagz[0]->ttl_issue>0){
      $txtdel  = "this magazine have issue...!!!<br/>";
      $adadtl  = "muncul";
    }
    #echo var_dump($issue_view->val)." s ".$sm." m ".$md." l ".$lg;
?>
    <div class="main-content" style="padding:10px">
        <div class="section__content">
            <div class="container-fluid">
                <div class="block">
<!-- content -->
                  <div id="detail-show col-lg-12">
                    <?php 
                      if($issuemagazine){ 
                    ?>
                    <div class="col-lg-12" style="background: #fff;margin-top: 20px !important;overflow: auto" >
                      <div class="nmp" style="min-height: 50vh" >
                        <div class="text-left" style="padding-top:10px;position: relative;">
                          <div  class="issue-magz">
                            <ul>
                              <!-- <li class="fa fa-th-list <?= $lg ?> issue-magz-show" id="i-list"></li> -->
                              <li class="fa fa-th-large <?= $md ?> issue-magz-show" id="i-large"></li>
                              <li class="fa fa-th <?= $sm ?> issue-magz-show" id="i-small"></li>
                            </ul>
                          </div>
                        </div>
                        <br/>
                        <?php
                          require_once(APPPATH.'views/include/list_openview.php');
                        ?>    
                      </div>
                    </div>
                    <?php } ?>
                  </div>
            </div>
        </div>
    </div>
  <div class="modal fade" id="cvr-issue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Change Cover from Issue</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body text-center data-cvr-issue">
        <?php
          $data = $this->Mod_magazine->issue_cover($uri);
          if($data){
            $use = "";
            foreach ($data as $key => $result) {
              $img = magz_img($result->cover);
              $txt = $result->issue;
              $id  = $result->id;
              $akt = "";
              if($result->use_cover=="yes"){
                $akt = "i-aktif";
                $use .= $txt;
              }
              echo "
              <div class='issue-cover $akt' data-id='$id'>
                  <img src='".$img."'/>
                  <div style='padding:5px' class='i-txt'>$txt</div>
              </div>";
            }
          }
        ?>
      </div>
      <div class="modal-footer">
        <div class="col-12">
          <div class="form-group fl col-9 nmp">
            <input type="text" class="form-control issue-use" readonly="" value="cover use from issue : <?= $use ?>">
          </div>
          <div class="text-right">
            <button type="button" class="btn btn-md btn-secondary btn-cancel" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-info btn-process wx75" id='change-cover' magz-id="<?= $uri ?>" data-id='<?= $mgid ?>'>Save</button>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  <!--  -->
	<div class="modal fade" id="form-mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body text-center">
			<p>
        <?= $txtdel ?>
				Are you sure you would like to delete this magazine
			</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-md btn-secondary btn-cancel" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-danger  btn-process" id="confirm-delete" magz-id="<?= $mgid ?>">Deleted</button>
		  </div>
		</div>
	  </div>
  </div>
  <!--  -->
  <div class="modal fade" id="new-magz" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content no-rds">
      <div class="modal-body text-center">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
        <div class="preview_pdf">
          <div id="image-holder">
            <img src="<?=assets("images/pdf_box.png") ?>" >
          <canvas id="pdfViewer" style="display: none"></canvas>
          </div>
          <div class="file-info">Max File upload 150Mb</div>
        </div>
        <div>
          <form enctype="multipart/form-data" class="data_pdf" method="post" id="upload_pdf">  
          <input type="file" id="my_file" name="new_pdf" class="hilang new-image" accept="application/pdf"> 
          <input class="hilang img_default" data-href="458"> 
          <table style="padding:10px;width: 100%">
            <tbody>
            <tr class="hilang">
              <td>
                <b>User ID</b><br> 
                <input type="text" name="uid" id="uid" required="" value="<?= $session["uid"]; ?>">
                <input type="text" name="magz_id" id="magz_id" required="" value="<?= $mgid ?>">
              </td>
            </tr>
            <tr>
              <td>
                <b>Magazine</b>
                <input type="text" value="<?= ucwords(strtolower($title)) ?>" readonly="" class='ro'>
              </td>
            </tr>
            <tr>
              <td>
              <b>Category</b><br>
              <select name="pdf_category" id="pdf_category" required="">  
                  <!-- <option value="">Choose your category</option> -->
                  <?php
                  foreach ($dtlcat as $key => $value) {
                    echo "<option value='$value->cat_id'>$value->cat_name</option>";
                  }
                  ?>
              </select>
              </td>
            </tr>
            <tr>
              <td>
                <b>Issue Title</b><br>  
                <input type="text" name="pdf_title" id="pdf_title" placeholder="Your Issue Title" required="" autocomplete="off">
              </td>
            </tr>
              <td>
                <b>Description</b><br>
                <textarea name="pdf_desc" id="pdf_desc" placeholder="Brief explanation of your pdf in minimum 140 characters" required=""></textarea>
              </td>
            </tr>
        
            <tr>
              <td>
                <input type="button" name="pdf_submit" id="pdf_submit" class="button2 nbg ver-bg4 ver-clr1" value="UPLOAD" style="border: none">
                <input type="button" id="pdf_submit-info" class="button2 nbg ver-bg2 ver-clr1" value="file pdf to large" style="display:none">
                <div class="nbg ver-bg4 ver-clr1 pdf_proses txc" style="display:none;height: 42px;padding-top: 11px"/><label class="blink">PROCESS UPLOAD...</label></div><br/>
              </td>
            </tr>
          </tbody>
          </table>
           <div class="alert alert-info alert-danger txc nmp message-info">info</div>
            <div class="loadinge">        
                <div class="progress">
                  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                  </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    </div>
  </div>

  <div class="modal fade" id="edit-ov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content no-rds nmp">
      <div class="progress2">        
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:1%">
        </div>
      </div>
      <div class="modal-body" style="margin-top:5px">
      <button type="button" class="close keluar" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-2 ver-clr1 nmp text-center">
            <div class="col-md-12 ver-clr1 nmp ">
              <div class="row nmp">
                <div class="col-md-12 emagz-img ver-clr1 nmp">
                  <div class="row">
                    <img src="<?= assets('/images/nomagze.png') ?>" class="" /> 
                  </div>
                  <div class="emagz-tittle-button ver-clr2">
                    <!-- <h3 class="" style="height: 35px;margin:5px 0 5px 5px;font-size: 20px">Judul</h3> -->
                  </div>
                </div>
              </div>
                xx
            </div>
          </div>
          <div class="col-md-10 ver-clr1 nmp text-center" id="result_ov">
          </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>  
  <script type="text/javascript">
    /*
    CKEDITOR.editorConfig = function( config ) {
      config.toolbarGroups = [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'forms', groups: [ 'forms' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'about', groups: [ 'about' ] }
      ];

      config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Strike,Subscript,Superscript';
    };
    */
  </script>