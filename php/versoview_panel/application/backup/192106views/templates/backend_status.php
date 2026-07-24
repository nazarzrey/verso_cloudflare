<!-- BREADCRUMB-->
            <section class="au-breadcrumb m-t-75 bg-db">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="au-breadcrumb-content">
                                    <div class="au-breadcrumb-left">
                                        <!-- <span class="au-breadcrumb-span">You are here:</span> -->
                                        <ul class="list-unstyled list-inline au-breadcrumb__list">
                                            <li class="list-inline-item"><?= ucwords(str_replace('_',' ',$status["status"])); ?></li>
                                        </ul>
                                    </div>
                                    <?php 
                                    if(isset($status["btn-class"])){
                                        if($status["btn-class"]!="x"){
                                        ?>
                                        <button class="au-btn au-btn-icon au-btn--green <?= $status["btn-class"] ?> brdw" data-toggle='modal' data-target='#frm-mdl'>
                                            <i class="zmdi zmdi-plus"></i><?= $status["btn-txt"]; ?></button>
                                        <?php
                                        } 
                                    }else{
                                        if($status["btn-href"]!="x"){;
                                        ?>
                                        <a href="<?= $status["btn-href"] ?>">
                                            <button class="au-btn au-btn-icon au-btn--green  brdw">
                                                <?= $status["btn-txt"]; ?>
                                            </button>
                                        </a>
                                        <?php 
                                        }
                                    }
                                     ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<!-- END BREADCRUMB-->