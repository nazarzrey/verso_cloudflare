                            <div class="social-login-content">
                                <label>or sign in with</label>
                                <div class="social-button">
                                    <a href="<?php if(Host()!="localhost"){ echo $fb_login; } ?>" >
                                        <button class="au-btn ver-brd5">
                                            <img src="<?= assets("images/fb.svg") ?>" class="fb">                                        
                                        </button>
                                    </a>

                                    <a href="<?php if(Host()!="localhost"){ echo $tw_login; } ?>" >
                                        <button class="au-btn ver-brd5">
                                            <img src="<?= assets("images/tw.png") ?>" class="tw">
                                        </button>
                                    </a>

                                    <a href="<?php if(Host()!="localhost"){ echo $go_login; } ?>" >
                                        <button class="au-btn ver-brd5">
                                            <img src="<?= assets("images/google.svg") ?>" class="go">
                                        </button>
                                    </a>
                                </div>
                            </div>