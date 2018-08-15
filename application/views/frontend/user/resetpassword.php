<section id="content">

<div class="content-wrap nopadding">

    <div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: url('<?php echo DEFAULT_IMG_DIR;?>parallax/home/1.jpg') center center no-repeat; background-size: cover;"></div>

    <div class="section nobg full-screen nopadding nomargin">
        <div class="container-fluid vertical-middle divcenter clearfix">
            <div class="card divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
                <div class="card-body" style="padding: 40px;">
                    <form id="reset-form" name="reset-form" class="nobottommargin validate-form" method="post">
                        <h3>Get Your Password</h3>
                        <div class="alert alert-danger alert-dismissible fade display-none" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>
                            <span class="msgContent"></span>
                        </div>
                        <div class="alert alert-success alert-dismissible fade display-none" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>
                            <span class="msgContent"></span>
                        </div>
                        <div class="col_full">
                        <input type="hidden" id="forgot_password_code" name="forgot_password_code" value="<?php echo isset($code)?$code:'';?>"/>
                            <label for="user_password">New Password</label>
                            <input type="password" id="user_password" name="user_password" value="" class="form-control not-dark user_id" />
                        </div>
                        <div class="col_full nobottommargin">
                            <button class="button button-3d button-black nomargin reset-form-submit" name="reset-form-submit" id="reset-form-submit" value="login" type="button">Submit</button>
                        </div>
                    </form>

                    <div class="line line-sm"></div>
                </div>
            </div>
        </div>
    </div>

</div>

</section><!-- #content end -->