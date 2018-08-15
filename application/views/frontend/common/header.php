<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>dark.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>font-icons.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>animate.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>magnific-popup.css" type="text/css" />

	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>components/bs-datatable.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>responsive.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Document Title
	============================================= -->
	<title>kpabal | Markets</title>

</head>
<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Top Bar
		============================================= -->
		<div id="top-bar" style="<?php echo isset($selected) && $selected =='login'?'display: none;':'' ?>">

			<div class="container clearfix">

				<div class="col_half nobottommargin d-none d-md-block">

					<p class="nobottommargin"><strong>Call:</strong> 1800-547-2145 | <strong>Email:</strong> info@canvas.com</p>

				</div>

				<div class="col_half col_last fright nobottommargin">

					<!-- Top Links
					============================================= -->
					<div class="top-links">
						<ul>
							<li><a href="#">USD</a>
								<ul>
									<li><a href="#">EUR</a></li>
									<li><a href="#">AUD</a></li>
									<li><a href="#">GBP</a></li>
								</ul>
							</li>
							<li><a href="#">EN</a>
								<ul>
									<li><a href="#"><img src="<?php echo DEFAULT_IMG_DIR;?>/icons/flags/french.png" alt="French"> FR</a></li>
									<li><a href="#"><img src="<?php echo DEFAULT_IMG_DIR;?>/icons/flags/italian.png" alt="Italian"> IT</a></li>
									<li><a href="#"><img src="<?php echo DEFAULT_IMG_DIR;?>/icons/flags/german.png" alt="German"> DE</a></li>
								</ul>
							</li>
							<?php 
								$userid = $loggedinuser['memberIdx'];
								$username = $loggedinuser['username'];
								if($userid === NULL){
									?>
									<li><a href="<?php echo ROOTPATH;?>login">Login</a>
										<div class="top-link-section">
											<form id="top-login" role="form" method="post" action="<?php echo  ROOTPATH.API_DIR;?>/user_login">
												<div class="alert alert-danger alert-dismissible fade display-none" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													</button>
													<span class="msgContent"></span>
												</div>
												<div class="input-group" id="top-login-username">
													<div class="input-group-prepend">
														<div class="input-group-text"><i class="icon-user"></i></div>
													</div>
													<input type="text" class="form-control user_id"  name="user_id" placeholder="username" required="">
												</div>
												<div class="input-group" id="top-login-password">
													<div class="input-group-prepend">
														<div class="input-group-text"><i class="icon-key"></i></div>
													</div>
													<input type="password" name="user_password" class="user_password form-control" placeholder="Password" required="">
												</div>
												<label class="checkbox">
												<input type="checkbox" value="remember-me"> Remember me
												</label>
												<button class="btn btn-danger btn-block login-form-submit" type="button">Sign in</button>
												<a href="<?php echo ROOTPATH.FRONTEND_REGISTER_PUBLIC_DIR;?>" class="btn btn-primary btn-block" type="button">Sign up</a>
											</form>
										</div>
									</li>
									<?php
								}
							?>
						</ul>
						
					</div><!-- .top-links end -->
					<?php 
						if($userid !== NULL){
							?>
								<div id="top-account" class="dropdown" style="margin : 0;">
									<a href="#" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-user"></i></a>
									<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
										<a class="dropdown-item tleft" href="<?php echo FRONTEND_USER_PROFILE_DIR;?>">Profile</a>
										<a class="dropdown-item tleft" href="#">Messages <span class="badge badge-pill badge-secondary fright" style="margin-top: 3px;">5</span></a>
										<a class="dropdown-item tleft" href="#">Settings</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item tleft" href="<?php echo  ROOTPATH.API_DIR;?>/user_logout">Logout <i class="icon-signout"></i></a>
									</ul>
								</div>
							<?php
						}
					?>
					
					
				</div>

			</div>

		</div><!-- #top-bar end -->

		<!-- Header
		============================================= -->
		<header id="header" class="sticky-style-2"  style="<?php echo isset($selected) && ($selected =='login' || $selected =='register')?'display: none;':'' ?>">

			<div class="container clearfix">

				<!-- Logo
				============================================= -->
				<div id="logo">
					<a href="index.html" class="standard-logo" data-dark-logo="<?php echo DEFAULT_IMG_DIR;?>/logo-dark.png"><img src="<?php echo DEFAULT_IMG_DIR;?>/logo.png" alt="Canvas Logo"></a>
					<a href="index.html" class="retina-logo" data-dark-logo="<?php echo DEFAULT_IMG_DIR;?>/logo-dark@2x.png"><img src="<?php echo DEFAULT_IMG_DIR;?>/logo@2x.png" alt="Canvas Logo"></a>
				</div><!-- #logo end -->

				<ul class="header-extras">
					<li>
						<i class="i-medium i-circled i-bordered icon-thumbs-up2 nomargin"></i>
						<div class="he-text">
							Original Brands
							<span>100% Guaranteed</span>
						</div>
					</li>
					<li>
						<i class="i-medium i-circled i-bordered icon-truck2 nomargin"></i>
						<div class="he-text">
							Free Shipping
							<span>for $20 or more</span>
						</div>
					</li>
					<li>
						<i class="i-medium i-circled i-bordered icon-undo nomargin"></i>
						<div class="he-text">
							30-Day Returns
							<span>Completely Free</span>
						</div>
					</li>
				</ul>

			</div>

			<div id="header-wrap">

				<!-- Primary Navigation
				============================================= -->
				<nav id="primary-menu" class="style-2">

					<div class="container clearfix">

						<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

							<ul>
								<li class="<?php echo isset($selected) && $selected == 'home'?'current':'';?>">
									<a href="<?php echo ROOTPATH;?>"><div>Home</div><span>Lets Start</span></a>
								</li>
								<li class="<?php echo isset($selected) && $selected == 'market'?'current':'';?>">
									<a href="<?php echo ROOTPATH;?>markets"><div>Markets</div><span>Awesome Works</span></a>
								</li>
							</ul>

						<!-- Top Cart
						============================================= -->
						<div id="top-cart">
							<div class="top-cart-content">
								<div class="top-cart-title">
									<h4>Shopping Cart</h4>
								</div>
								<div class="top-cart-items">
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="#"><img src="<?php echo DEFAULT_IMG_DIR;?>/shop/small/1.jpg" alt="Blue Round-Neck Tshirt" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="#">Blue Round-Neck Tshirt</a>
											<span class="top-cart-item-price">$19.99</span>
											<span class="top-cart-item-quantity">x 2</span>
										</div>
									</div>
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="#"><img src="<?php echo DEFAULT_IMG_DIR;?>/shop/small/6.jpg" alt="Light Blue Denim Dress" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="#">Light Blue Denim Dress</a>
											<span class="top-cart-item-price">$24.99</span>
											<span class="top-cart-item-quantity">x 3</span>
										</div>
									</div>
								</div>
								<div class="top-cart-action clearfix">
									<span class="fleft top-checkout-price">$114.95</span>
									<button class="button button-3d button-small nomargin fright">View Cart</button>
								</div>
							</div>
						</div><!-- #top-cart end -->

						<!-- Top Search
						============================================= -->
						<div id="top-search">
							<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
							<form action="search.html" method="get">
								<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
							</form>
						</div><!-- #top-search end -->

					</div>

				</nav><!-- #primary-menu end -->

			</div>

		</header><!-- #header end -->