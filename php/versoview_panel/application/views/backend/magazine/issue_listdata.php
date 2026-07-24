<?php
$auto   = $hdrmagz[0]->cover_auto;
$title  = $hdrmagz[0]->magz_name;
$desc   = $hdrmagz[0]->magz_desc;
$url    = "<a href='" . base_url('index.php') . "''>Home</a> / <b>" . $title;
$uri    = $hdrmagz[0]->magz_url;
$mgid   = $hdrmagz[0]->magz_id;
$cat    = $hdrmagz[0]->cat_name;
$href   = base_url("pageturner/" . $uri . "/index.html");
$sm     = $md = $lg = $grid = $col =  $txtdel = "";
$adadtl = "hilang";
if ($issue_view->val != "") {
  if ($issue_view->val == "1") {
    $sm   = "active";
    $grid = "boximage";
    $col  = "col-12";
  } else {
    $md   = "active";
    $grid = "boximage2";
    $col  = "col-7";
  }
}
if ($auto == "2") {
  $cover   = magz_img($hdrmagz[0]->cover);
  $txtauto = "Manual Change";
} else {
  if (empty($hdrmagz[0]->cover_issue)) {
    $cover   = magz_img($hdrmagz[0]->cover);
  } else {
    $img     = $this->Mod_magazine->magazine_gallery("magazine", $hdrmagz[0]->cover_issue);
    // debug($img . $hdrmagz[0]->cover_issue, "1");
    $cover   = magz_img($img);
  }
  $txtauto = "Auto Change";
}
if ($hdrmagz[0]->ttl_issue > 0) {
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
        <div id="detail-show col-lg-12 brd">
          <div class="col-lg-12 row nmp" style="margin:0 0 10px 0">
            <div class="col-lg-3">
              <img src="<?= $cover ?>">
            </div>
            <div class="col-md-6 text-left">
              <p style="padding:10px;height:175px;overflow: hidden;">
                <?= $desc ?>
              </p>
            </div>
            <div class="col-lg-3 text-left" style="float:right;position: relative;font-size: 15px;line-height: 1.6">
              <table width="100%">
                <tr>
                  <td>Category</td>
                  <td><?= $cat ?></td>
                </tr>
                <!-- <tr><td>Type</td><td>Magazine</td></tr>
                            <tr><td>Language</td><td>English</td></tr>
                             -->
                <!-- <tr><td>Frequency</td><td>Monthly</td></tr> -->
                <tr>
                  <td>Type</td>
                  <td>Magazine</td>
                </tr>
                <tr>
                  <td>Language</td>
                  <td>English</td>
                </tr>
                <!-- <tr><td>Account</td><td>Free</td></tr> -->
                <tr>
                  <td>Cover</td>
                  <td><?= $txtauto ?></td>
                </tr>
              </table>
              <div class="btn-magz btn-magz-bottom">
                <button>Settings</button>
                <button>Share</button>
                <button>Statistics</button>
                <button data-toggle='modal' data-target='#form-mdl' class="btn ver-bg4 ver-clr1">Delete</button>
                <button data-toggle='modal' data-target='#cvr-issue' style="width: 190px" class="ver-bg2 <?= $adadtl ?>" id="cvr-from-issue" magz-id="<?= $uri ?>">Cover from Issue</button>
              </div>
            </div>
          </div>
          <?php
          if ($issuemagazine) {
          ?>
            <div class="col-lg-12" style="background: #fff;margin-top: 20px !important;overflow: auto">
              <div class="nmp" style="min-height: 50vh">
                <div class="text-left" style="padding-top:10px;position: relative;">
                  OTHER ISSUES OF <b><?= Mname($hdrmagz[0]->magz_name); ?></b>
                  <div class="issue-magz">
                    <ul>
                      <!-- <li class="fa fa-th-list <?= $lg ?> issue-magz-show" id="i-list"></li> -->
                      <li class="fa fa-th-large <?= $md ?> issue-magz-show" id="i-large"></li>
                      <li class="fa fa-th <?= $sm ?> issue-magz-show" id="i-small"></li>
                    </ul>
                  </div>
                </div>
                <br />
                <?php
                require_once(APPPATH . 'views/include/list_magazine.php');
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
          if ($data) {
            $use = "";
            foreach ($data as $key => $result) {
              $img = magz_img($result->cover);
              $txt = $result->issue;
              $id  = $result->id;
              $akt = "";
              if ($result->use_cover == "yes") {
                $akt = "i-aktif";
                $use .= $txt;
              }
              echo "
              <div class='issue-cover $akt' data-id='$id'>
                  <img src='" . $img . "'/>
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
              <img src="<?= assets("images/pdf_box.png") ?>">
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
                      <div class="nbg ver-bg4 ver-clr1 pdf_proses txc" style="display:none;height: 42px;padding-top: 11px" /><label class="blink">PROCESS UPLOAD...</label>
          </div><br />
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

<div class="modal fade" id="edit-magz" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <div class="col-md-6 ver-clr1 nmp">
              <div class="col-md-12 ver-clr1 nmp">
                <div class="row nmp">
                  <div class="col-md-5 emagz-img ver-clr1 nmp">
                    <div class="row">
                      <img src="<?= assets('/images/nomagze.png') ?>" class="" />
                    </div>
                  </div>
                  <div class="col-md-7 emagz-tittle-button ver-clr2">
                    <h3 class="" style="overflow: hidden;height: 35px;margin-bottom: 5px">Judul</h3>
                    <a class="btn nmp st-1" id="magz-draft">Back to Draft</a>
                    <a class="btn nmp st-6" href="#"></a>
                    <a class="btn nmp st-7" href="#"></a>
                    <button class="btn ver-bg4 no-rds btn-sm st-7 hilang" id="magz-app">App Status</button>
                    <button class="btn ver-bg4 no-rds btn-sm st-2" id="issue-conv">Convert to Page Turner and Android iOS apps</button>
                    <button class="btn ver-bg4 no-rds btn-sm st-3"><span class="kedip">Issue conversion in process...</span></button>
                    <button class="btn ver-bg4 no-rds btn-sm st-4" id="magz-prc">Now Publish Your Magazine</button>
                    <a target="_blank" href="#" class="btn ver-bg4 no-rds btn-sm st-5">View the Page Turner</a>

                    <div class="issue-content-data fl w100">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 nmp emagz-img-desc ver-clr2">
                <p>
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                </p>
              </div>
            </div>
            <div class="col-md-1 ver-clr2 text-center">
              <!-- <div id="progressCounter"></div>
              <br>
              <div id="loading">Loading</div>
              <br>
              <div id="data"></div> -->
              <ul class="edit-magz-button">
                <li>
                  <span class="fa fa-link"></span>
                </li>
                <li>
                  <span class="fa fa-edit (alias)"></span>
                </li>
                <li>
                  <span class="fa fa-refresh (alias)"></span>
                </li>
                <li>
                  <span class="fa fa-credit-card"></span>
                </li>
                <li>
                  <span class="fa fa-code"></span>
                </li>
                <li>
                  <span class="fa fa-bar-chart-o"></span>
                </li>
                <li>
                  <span class="fa fa-rss"></span>
                </li>
                <li>
                  <span class="fa fa-sitemap"></span>
                </li>
                <li>
                  <span class="fa fa-tasks"></span>
                </li>
                <li>
                  <span class="fa fa-users"></span>
                </li>
                <li>
                  <span class="fa fa-upload"></span>
                </li>
                <li>
                  <span class="fa fa-tags"></span>
                </li>
                <li>
                  <span class="fa fa-trash"></span>
                </li>
              </ul>
            </div>
            <div class="col-md-5 ver-clr2 nmp edit-magz-slide">
              <div class="edit-magz-slide-content">
                <button type="button" class="close1" style="position:absolute;top:10px;right:10px">
                  <span aria-hidden="true">×</span>
                </button>
                <div class="" role="document" style="background:#fff;height:109%;margin:10px;margin-top:-50px;">
                  <div class="modal-header txc" style="display:block">
                    <h5 class="modal-title txc" id="exampleModalLabel">Form Delete</h5>
                  </div>
                  <div class="modal-body text-center">
                    <p>
                      Are you sure you would like to delete this issue
                    </p>
                  </div>
                  <div class="modal-footer txc" style="display:block">
                    <button type="button" class="btn btn-md btn-secondary btn-cancel wx100" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger  btn-process wx100" id="confirm-delete-dtl">Deleted</button>
                  </div>
                </div>
              </div>
              <div class="edit-magz-slide-nav">
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#basic">Sample 1</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#bisnis">Sample 2</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#custom">Sample 3</a>
                  </li>
                </ul>
                <div class="tab-content emagz-tab-content">
                  <div class="tab-pane active" id="basic">
                    <h5>Sample 1</h5>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                  </div>
                  <div class="tab-pane" id="bisnis">
                    <h5>Sample 2</h5>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                  </div>
                  <div class="tab-pane" id="custom">
                    <h5>Sample 3</h5>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>