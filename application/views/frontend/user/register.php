
<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap nopadding">

        <div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: url('<?php echo DEFAULT_IMG_DIR;?>parallax/home/1.jpg') center center no-repeat; background-size: cover;"></div>

        <div class="section nobg full-screen nopadding nomargin">
            <div class="container-fluid vertical-middle divcenter clearfix">
                <div class="card divcenter noradius noborder" style="max-width: 800px; background-color: rgba(255,255,255,0.93);">
                    <div class="card-body" style="padding: 40px;">
                        
                        <form id="register-form" name="register-form" class="nobottommargin" method="post"  novalidate="novalidate">
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
                            <div class="form-row">
								<div class="form-group col-md-6">
									<label for="userid">ID<span class="required"> * </span></label>
									<input type="text" class="form-control" id="user_id" name="user_id" placeholder="please type your id">
								</div>
								<div class="form-group col-md-6">
                                <label for="email">Email Address<span class="required"> * </span></label>
									<input type="email" class="form-control" id="user_email" name="user_email" placeholder="Please type your email address">
								</div>
							</div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
									<label for="password">Choose Password<span class="required"> * </span></label>
									<input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password here">
								</div>
								<div class="form-group col-md-6">
									<label for="repassword">Re-enter Password</label>
									<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="re-enter the password">
								</div>
                            </div>

                            <div class="col_full nobottommargin">
                                <button class="button button-3d button-black nomargin" id="register-form-submit" name="register-form-submit" value="register" type="button">Register Now</button>
                            </div> 

                        </form>

                        <div class="line line-sm"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section><!-- #content end -->
