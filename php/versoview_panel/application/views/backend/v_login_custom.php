<?php
  #require_once  "config.fb.php";
  #$helper = $fb->getRedirectLoginHelper();                          
  #$permissions = ['email']; // Optional permissions
  #$loginUrl = $helper->getLoginUrl("http://localhost/agencyfish/weblist/versoview/".'fb-callback.php', $permissions);
if($clients){
    $logo = assets('clients/'.$clients.'.png');
    $top  = "style='padding-top:15vh'";
}else{
    $logo = assets('images/logo.png');    
    $top  = "";
}
?>
<div class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap" <?= $top ?>>
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="<?= base_url("") ?>">
                                <img src="<?= $logo ?>" style="width: 250px" alt="<?= $clients ?>">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="<?= base_url('login/validate') ?>" method="post" id="frm-login">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="text" name="useremail" placeholder="Email" autocomplete="off" value="" id="log-name">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" autocomplete="off" name="password" placeholder="Password" id="log-pass">
                                </div>
                                <div class="form-group hilang">
                                    <input class="session_id" type="text" name="session_id" id="log-pass" value="<?= Ses(""); ?>">
                                </div>
                                <div class="login-checkbox">
                                    <!-- <label>
                                        <input type="checkbox" name="remember">Remember Me
                                    </label> -->
                                    <label>
                                        <a href="<?= base_url("reset") ?>">Forgotten Password?</a>
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block ver-bg4 m-b-20" type="button">
                                    <!-- <a href="admin" style="color:#fff">sign in</a> -->
                                    sign in
                                </button>
                            </form>                           
                            <?php         
                            if($clients){
                            }else{
                            require_once(APPPATH."views/backend/v_sosmed_login.php");
                            ?>
                            <div class="alert alert-info alert-danger txc nmp message-info" style="margin-bottom: 20px !important">info</div>
                            <div class="register-link">
                                <p>
                                    <a></a>
                                    Don't you have account?
                                    <a href="register">Sign Up Here</a>
                                </p>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    