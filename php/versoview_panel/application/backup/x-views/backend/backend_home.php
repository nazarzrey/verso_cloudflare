
        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <section class="statistic">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <a class="statistic__item" href="<?= admin_url("magz/colours") ?>">
                                    <img src="<?= magz('colours/ico_colours1904.jpg') ?>">
                                    <h2 class="number">COLOURS</h2>
                                    <span class="desc">10,368 view</span>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <a class="statistic__item" href="<?= admin_url("magz/mutiarabiru") ?>">
                                    <img src="<?= magz('cover/6.png') ?>">
                                    <h2 class="number">MUTIARABIRU</h2>
                                    <span class="desc">10,368 view</span>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <a class="statistic__item" href="<?= admin_url("magz/prioritas") ?>">
                                    <img src="<?= magz('cover/10.png') ?>">
                                    <h2 class="number">PRIORITAS</h2>
                                    <span class="desc">10,368 view</span>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <a class="statistic__item" href="<?= admin_url("magz/colours-me") ?>">
                                    <img src="<?= magz('colours-me/ico_colours-me1904.jpg') ?>">
                                    <h2 class="number">COLOURS-ME</h2>
                                    <span class="desc">10,368 view</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END STATISTIC-->

            <section>
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-12">
                                <!-- RECENT REPORT 2-->
                                <div class="recent-report2">
                                    <h3 class="title-3">recent View</h3>
                                    <div class="chart-info">
                                        <div class="chart-info__left">
                                            <div class="chart-note">
                                                <span class="dot dot--blue"></span>
                                                <span>Colours</span>
                                            </div>
                                            <div class="chart-note">
                                                <span class="dot dot--black"></span>
                                                <span>Mutiarabiru</span>
                                            </div>
                                            <div class="chart-note">
                                                <span class="dot dot--green"></span>
                                                <span>Prioritas</span>
                                            </div>
                                            <div class="chart-note">
                                                <span class="dot dot--purple"></span>
                                                <span>Colours ME</span>
                                            </div>
                                        </div>
                                        <!-- <div class="chart-info-right">
                                            <div class="rs-select2--dark rs-select2--md m-r-10">
                                                <select class="js-select2" name="property">
                                                    <option selected="selected">All Properties</option>
                                                    <option value="">Products</option>
                                                    <option value="">Services</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                            <div class="rs-select2--dark rs-select2--sm">
                                                <select class="js-select2 au-select-dark" name="time">
                                                    <option selected="selected">All Time</option>
                                                    <option value="">By Month</option>
                                                    <option value="">By Day</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="recent-report__chart">
                                        <canvas id="recent-rep2-chart"></canvas>
                                    </div>
                                </div>
                                <!-- END RECENT REPORT 2             -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END PAGE CONTAINER-->
        </div>
        <!-- modal -->
        <div class="modal fade" id="frm-mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Magazine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body modal-form">
                <input type="text" class="form-control" placeholder="Magazine Name">
                <input type="file" class="form-control" placeholder="File ">
                <textarea placeholder="Description"></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Process</button>
              </div>
            </div>
          </div>
        </div>