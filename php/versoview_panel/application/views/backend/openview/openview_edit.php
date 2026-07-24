  <?php
  #var_dump($ov_header);
  #$detail["detail"] = $this->Mod_magazine->DtlOV($value,"issue_id");
  #echo $ov_id;
  if($ov_header){
  ?>
<div class="edit-magz-slide-nav" style="padding-left: 15px;">
              <ul class="nav nav-tabs">
                <?php
                  $x=1;
                  foreach ($ov_header as $key => $value) {
                   # echo "XX".$key."sss";
                    if($key==0){
                      $act = "active";
                    }else{
                      $act = "";
                    }                  
                    echo '
                    <li class="nav-item">
                        <a class="nav-link '.$act.'" data-toggle="tab" href="#'.str_replace(" ","-",$value->content).'">'.$value->content.'</a>
                    </li>';
                    $x++;
                  }
                ?>
              </ul>
              <div class="tab-content emagz-tab-content"  style="border: solid 1px #f1f1f1">
                <?php

                  $x=1;
                  foreach ($ov_header as $key => $value) {
                   # echo "XX".$key."sss";
                    if($key==0){
                      $act = "active";
                    }else{
                      $act = "";
                    }
                    $min = $value->min_page;
                    $max = $value->max_page;
                    $cnt = str_replace(" ","-",$value->content);
                    echo '<div class="tab-pane '.$act.'" id="'.$cnt.'">';
                    $ov_detail = $this->Mod_magazine->DtlOV($ov_id,$value->content);
                    #var_dump($ov_detail);
                    echo '
                          <div class="edit-magz-slide-nav">
                            <ul class="nav nav-tabs">';
                            foreach ($ov_detail as $keys => $data) {
                              $num = $data->magz_page;
                              if($keys==0){
                                $act = "active";
                              }else{
                                $act = "";
                              }                  
                              echo '
                              <li class="nav-item">
                                  <a class="nav-link '.$act.'" data-toggle="tab" href="#'.$cnt.'_'.$num.'">Page '.$num.'</a>
                              </li>';
                            }
                    echo '  </ul>
                          </div>
                          <div class="tab-content emagz-tab-content"  style="border: solid 1px #f1f1f1">';                          
                            foreach ($ov_detail as $keys => $data) {
                              $num = $data->magz_page;
                              if($keys==0){
                                $act = "active";
                              }else{
                                $act = "";
                              }                  
                              echo '
                              <div class="tab-pane '.$act.'" id="'.$cnt.'_'.$num.'">
                                  <h5>Title</h5>
                                  <input type="text" value="'.$data->title.'" />
                                  <h5>Lead</h5>
                                  <input type="text" value="'.$data->lead.'" />
                                  <h5>Caption</h5>
                                  <textarea id="area'.$num.'">'.$data->caption.'</textarea>
                                  <h5>Paragraph</h5>
                                  <textarea id="area'.$num.'">'.$data->body_text.'</textarea>
                              </div>';
                            }
                    echo '</div>';
                    echo '</div>';
                    #var_dump($value);
                    $x++;
                  }
                ?>

              </div>
              <br/>
              <button class="save_openview btn ver-bg4">Save Content</button>
            </div>
<?php
  }
?>
    <!-- niceEditor -->  
    <script src="http://localhost/agencyfish/weblist/versoview/assets/nicedit/nicEdit.js" type="text/javascript"></script>
    <script type="text/javascript">       
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
    </script>
