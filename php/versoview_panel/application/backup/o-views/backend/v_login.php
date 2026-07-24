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
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" autocomplete="off" name="password" placeholder="Password" id="log-pass">
                                </div>
                                <div class="login-checkbox">
                                    <!-- <label>
                                        <input type="checkbox" name="remember">Remember Me
                                    </label> -->
                                    <label>
                                        <a href="<?= base_url("lostpass") ?>">Forgotten Password?</a>
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block ver-bg4 m-b-20" type="button">
                                    <!-- <a href="admin" style="color:#fff">sign in</a> -->
                                    sign in
                                </button>
                                <div class="alert alert-info alert-danger txc nmp message-info">info</div>
                            </form>
                            <div class="register-link">
                                <p>
                                    <a></a>
                                    Don't you have account?
                                    <a href="register">Sign Up Here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    