
        <!-- PAGE CONTAINER-->
            <!-- HEADER DESKTOP-->
            <section class="statistic">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row magazine-list">
                            <?php
                                $this->load->view('backend/openview/my_magz',$data);
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END STATISTIC-->

            <section>
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                          <?php
                            # $this->load->view('backend/magazine/chart')
                          ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END PAGE CONTAINER-->
            <!-- modal -->
            <div class="modal fade" id="new-magz" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Magazine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="modal-body modal-form form-group" id="fmagz-create">
                    <input type="text" name="nmagz" id="nmagz" required="" class="form-control" placeholder="Magazine Name" value="" autocomplete="off">
                    <div class="col-12 nmp row">
                      <div class="col-9 nmp">
                        <select name="cmagz" id="cmagz"  class="form-control">
                          <!-- <option value='1'>Art</option> -->
                          <option value="">Choose your category</option>
                          <?php
                          foreach ($dtlcat as $key => $value) {
                            echo "<option value='$value->cat_id'>$value->cat_name</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-3 nmp">
                        <select name="aumagz" id="aumagz"  class="form-control">
                          <option value="1">Auto Change Cover</option>
                          <option value="2">Manual Change Cover</option>
                        </select>
                      </div>
                    </div>
                    <textarea name="dmagz" id="dmagz" placeholder="Description" class="form-control"></textarea>
                    <br/>
                    <button type="button" class="btn wx150 ver-bg2"  id="magz-create"  style="margin-top:-15px">Create Magazine</button>
                  </form>
                </div>
              </div>
            </div>