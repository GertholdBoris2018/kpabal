<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />
	<!-- Stylesheets
	============================================= -->
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>swiper.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>dark.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>font-icons.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>animate.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>responsive.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>components/bs-datatable.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo DEFAULT_CSS_DIR;?>custom.css" type="text/css" />

	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- Document Title 
	============================================= -->
	<title><?=SITE_TITLE?><?php if($caption) echo ' - '.$caption;?></title>
</head>
<body class="stretched">
	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">
		<!-- Header
		============================================= -->
		<header id="header" class="transparent-header full-header" data-sticky-class="not-dark">
			<div id="header-wrap">
				<div class="container clearfix">
					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
					<!-- Logo
					============================================= -->
					<div id="logo">
						<a href="<?=ROOTPATH?>" class="standard-logo" data-dark-logo="<?php echo DEFAULT_IMG_DIR;?>logo-dark.png"><img src="<?php echo DEFAULT_IMG_DIR;?>logo.png" alt="Canvas Logo"></a>
						<a href="<?=ROOTPATH?>" class="retina-logo" data-dark-logo="<?php echo DEFAULT_IMG_DIR;?>logo-dark@2x.png"><img src="<?php echo DEFAULT_IMG_DIR;?>logo@2x.png" alt="Canvas Logo"></a>
					</div><!-- #logo end -->
					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu" class="dark">
						<ul>
							<?php foreach($categories as $key => $main_category) { ?>
							<li><a href="<?php if($main_category->menuURL) echo ROOTPATH.substr($main_category->menuURL, 1); else echo '#';?>"><div><?=$main_category->menuName?></div></a>
								<?php if(strtolower($main_category->menuName) == "boards"):?>								
									<?php if(count($blog_categories)):?>
									<ul>
										<?php foreach($blog_categories as $category){?>
										<li><a href="<?=ROOTPATH?>blogs/category/<?=$category->categoryIdx?>"><div><?=$category->categoryName?></div></a>
											<?php if(count($category->children)):?>
											<ul>
												<?php foreach($category->children as $child_category){?>
												<li><a href="<?=ROOTPATH?>blogs/category/<?=$child_category->categoryIdx?>"><div><?=$category->categoryName?> - <?=$child_category->categoryName?></div></a></li>
												<?php }?>
											</ul>
											<?php endif?>
										</li>
										<?php }?>
									</ul>
									<?php endif?>
								<?php else:?>
									<?php if(count($main_category->children)):?>
									<ul>
										<?php foreach($main_category->children as $category){?>
										<li><a href="<?php if($category->menuURL) echo ROOTPATH.substr($category->menuURL, 1); else echo '#';?>"><div><?=$main_category->menuName?> - <?=$category->menuName?></div></a>
											<?php if(count($category->children)):?>
											<ul>
												<?php foreach($category->children as $child_category){?>
												<li><a href="<?php if($child_category->menuURL) echo ROOTPATH.substr($child_category->menuURL, 1); else echo '#';?>"><div><?=$category->menuName?> - <?=$child_category->menuName?></div></a></li>
												<?php }?>
											</ul>
											<?php endif?>
										</li>
										<?php }?>
									</ul>
									<?php endif?>
								<?php endif?>
							</li>
							<?php }?>
						</ul>
						<!-- Top Cart
						============================================= -->
						<div id="top-cart">
							<a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><?php if($cart->total_amount):?><span><?=$cart->total_amount?></span><?php endif?></a>
							<div class="top-cart-content">
								<div class="top-cart-title">
									<h4>Shopping Cart</h4>
								</div>
								<?php if($cart->items):?>
								<div class="top-cart-items">
									<?php foreach ($cart->items as $item) {?>
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="#"><img src="<?=$item->image?>" alt="<?=$item->title?>" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="#"><?=$item->title?></a>
											<span class="top-cart-item-price">$<?=$item->price?></span>
											<span class="top-cart-item-quantity">x <?=$item->amount?></span>
										</div>
									</div>
									<?php }?>
								</div>
								<?php endif ?>
								<div class="top-cart-action clearfix"<?php if($cart->items):?><?php else:?> style="text-align: center;"<?php endif?>>
									<?php if($cart->items):?>
									<span class="fleft top-checkout-price">$<?php if($cart->total_price) echo $cart->total_price;?></span>
									<button class="button button-3d button-small nomargin fright">View Cart</button>
									<?php else:?>
									<span class="fleft top-checkout-price" style="font-size:14px; float: none !important;">Cart is empty</span>
									<?php endif ?>
								</div>
							</div>
						</div><!-- #top-cart end -->
					</nav><!-- #primary-menu end -->
				</div>
			</div>
		</header><!-- #header end -->