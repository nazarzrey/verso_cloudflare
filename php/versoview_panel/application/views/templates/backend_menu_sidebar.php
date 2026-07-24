
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="<?= admin_url("") ?>">
                    <!-- <img src="images/icon/logo-white.png" alt="Cool Admin" /> -->                 
                    <img src="<?= assets('images/logo_white.png') ?>" style="width: 180px" alt="CoolAdmin">
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <?php 
                    require(APPPATH.'views/templates/backend_menu.php');
                ?>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->
