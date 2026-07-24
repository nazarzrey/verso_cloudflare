<?php
  #require_once  "config.fb.php";
  #$helper = $fb->getRedirectLoginHelper();                          
  #$permissions = ['email']; // Optional permissions
  #$loginUrl = $helper->getLoginUrl("http://localhost/agencyfish/weblist/versoview/".'fb-callback.php', $permissions);
?>
<div class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="<?= base_url() ?>">
                                <img src="<?= assets('images/logo.png') ?>" style="width: 250px" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="<?= base_url('login/validate') ?>" method="post" id="frm-login">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="text" name="useremail" placeholder="Email" autocomplete="off" value="" id="log-name">
                                </div>
                                <button class="au-btn au-btn--block ver-bg2 m-b-20" type="button">
                                    <!-- <a href="admin" style="color:#fff">sign in</a> -->
                                    Reset Password
                                </button>
                            </form>
                            <?php                                
                            require_once(APPPATH."views/backend/v_sosmed_login.php");
                            ?>
                            <div class="alert alert-info alert-danger txc nmp message-info" style="margin-bottom: 20px !important">info</div>
                            <div class="register-link">
                                <p>
                                    Already have account?
                                    <a href="login">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    