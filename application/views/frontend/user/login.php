
<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap nopadding">

        <div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: url('<?php echo DEFAULT_IMG_DIR;?>parallax/home/1.jpg') center center no-repeat; background-size: cover;"></div>

        <div class="section nobg full-screen nopadding nomargin">
            <div class="container-fluid vertical-middle divcenter clearfix">
                <div class="card divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
                    <div class="card-body" style="padding: 40px;">
                        <form id="login-form" name="login-form" class="nobottommargin validate-form" method="post">
                            <h3>Login to your Account</h3>
                                <div class="alert alert-danger alert-dismissible fade display-none" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    </button>
                                    <span class="msgContent"></span>
                                </div>
                            <div class="col_full">
                                <label for="user_id">Username:</label>
                                <input type="text" name="user_id" value="" class="form-control not-dark user_id" />
                            </div>

                            <div class="col_full">
                                <label for="user_password">Password:</label>
                                <input type="password" name="user_password" value="" class="form-control not-dark user_password" />
                            </div>

                            <div class="col_full nobottommargin">
                                <button class="button button-3d button-black nomargin login-form-submit" name="login-form-submit" value="login" type="button">Login</button>
                                <a href="<?php echo FRONTEND_USER_FORGOT_PASS_DIR;?>" class="fright">Forgot Password?</a>
                            </div>
                        </form>

                        <div class="line line-sm"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section><!-- #content end -->
