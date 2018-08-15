		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">
			<div class="container">
				<!-- Footer Widgets
				============================================= -->
				<div class="footer-widgets-wrap clearfix">
					<div class="col_two_third">
						<div class="col_one_third">
							<div class="widget clearfix">
								<img src="<?php echo DEFAULT_IMG_DIR;?>footer-widget-logo.png" alt="" class="footer-logo">
								<p><?=SITE_SENTENCE?></p>
								<div style="background: url('<?php echo DEFAULT_IMG_DIR;?>world-map.png') no-repeat center center; background-size: 100%;">
									<address>
										<strong>Headquarters:</strong><br>
										<?=SITE_ADDRESS?><br>
									</address>
									<abbr title="Phone Number"><strong>Phone:</strong></abbr> <?=SITE_PHONE?><br>
									<abbr title="Fax"><strong>Fax:</strong></abbr> <?=SITE_FAX?><br>
									<abbr title="Email Address"><strong>Email:</strong></abbr> <?=SITE_EMAIL?>
								</div>
							</div>
						</div>
						<div class="col_one_third">
							<div class="widget widget_links clearfix">
								<h4>Blogroll</h4>
								<ul><?php foreach($blog_categories as $category){?>
									<li><a href="<?=ROOTPATH?>blogs/category/<?=$category->categoryIdx?>"><?=$category->categoryName?></a></li><?php }?>
								</ul>
							</div>
						</div>
						<div class="col_one_third col_last">
							<div class="widget clearfix">
								<h4>Recent Business</h4>
								<div id="post-list-footer">
									<?php foreach($recent_business as $business){?>
									<div class="spost clearfix">
										<div class="entry-c">
											<div class="entry-title">
												<h4><a href="business/<?=$business->id?>"><?=$business->business_name_en?></a></h4>
											</div>
											<ul class="entry-meta">
												<li><?=date("jS F Y", strtotime($business->register_date))?></li>
											</ul>
										</div>
									</div>
									<?php }?>
								</div>
							</div>
						</div>
					</div>
					<div class="col_one_third col_last">
						<div class="widget clearfix" style="margin-bottom: -20px;">
							<div class="row">
								<div class="col-lg-6 bottommargin-sm">
									<div class="counter counter-small"><span data-from="<?=round($total_business / 100)?>" data-to="<?=$total_business?>" data-refresh-interval="80" data-speed="3000" data-comma="true"></span></div>
									<h5 class="nobottommargin">Total Business</h5>
								</div>
								<div class="col-lg-6 bottommargin-sm">
									<div class="counter counter-small"><span data-from="<?=round($total_client / 50)?>" data-to="<?=$total_client?>" data-refresh-interval="50" data-speed="2000" data-comma="true"></span></div>
									<h5 class="nobottommargin">Clients</h5>
								</div>
							</div>
						</div>
						<div class="widget subscribe-widget clearfix">
							<h5><strong>Subscribe</strong> to Our Newsletter to get Important News, Amazing Offers &amp; Inside Scoops:</h5>
							<div class="widget-subscribe-form-result"></div>
							<form id="widget-subscribe-form" action="include/subscribe.php" role="form" method="post" class="nobottommargin">
								<div class="input-group divcenter">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="icon-email2"></i></div>
									</div>
									<input type="email" id="widget-subscribe-form-email" name="widget-subscribe-form-email" class="form-control required email" placeholder="Enter your Email">
									<div class="input-group-append">
										<button class="btn btn-success" type="submit">Subscribe</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div><!-- .footer-widgets-wrap end -->
			</div>
			<!-- Copyrights
			============================================= -->
			<div id="copyrights">
				<div class="container clearfix">
					<div class="col_half">
						Copyrights &copy; <?=date("Y")?> All Rights Reserved by <?=SITE_COMPANY?> Inc.<br>
						<div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>
					</div>
					<div class="col_half col_last tright">
						<div class="fright clearfix">
							<?php if(defined('SOCIAL_FACEBOOK')){?>
							<a href="<?=SOCIAL_FACEBOOK?>" class="social-icon si-small si-borderless si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>
							<?php }?>
							<?php if(defined('SOCIAL_TWITTER')){?>
							<a href="<?=SOCIAL_TWITTER?>" class="social-icon si-small si-borderless si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>
							<?php }?>
							<?php if(defined('SOCIAL_GPLUS')){?>
							<a href="<?=SOCIAL_GPLUS?>" class="social-icon si-small si-borderless si-gplus">
								<i class="icon-gplus"></i>
								<i class="icon-gplus"></i>
							</a>
							<?php }?>
							<?php if(defined('SOCIAL_PINTEREST')){?>
							<a href="<?=SOCIAL_PINTEREST?>" class="social-icon si-small si-borderless si-pinterest">
								<i class="icon-pinterest"></i>
								<i class="icon-pinterest"></i>
							</a>
							<?php }?>
							<?php if(defined('SOCIAL_VIMEO')){?>
							<a href="<?=SOCIAL_VIMEO?>" class="social-icon si-small si-borderless si-vimeo">
								<i class="icon-vimeo"></i>
								<i class="icon-vimeo"></i>
							</a>
							<?php }?>
							<?php if(defined('SOCIAL_GITHUB')){?>
							<a href="<?=SOCIAL_GITHUB?>" class="social-icon si-small si-borderless si-github">
								<i class="icon-github"></i>
								<i class="icon-github"></i>
							</a>
							<?php }?>
							<?php if(defined('SOCIAL_YAHOO')){?>
							<a href="<?=SOCIAL_YAHOO?>" class="social-icon si-small si-borderless si-yahoo">
								<i class="icon-yahoo"></i>
								<i class="icon-yahoo"></i>
							</a>
							<?php }?>
							<?php if(defined('SOCIAL_LINKEDIN')){?>
							<a href="<?=SOCIAL_LINKEDIN?>" class="social-icon si-small si-borderless si-linkedin">
								<i class="icon-linkedin"></i>
								<i class="icon-linkedin"></i>
							</a>
							<?php }?>
						</div>
						<div class="clear"></div>
						<i class="icon-envelope2"></i> <?=SITE_EMAIL?> <span class="middot">&middot;</span> <i class="icon-headphones"></i> <?=SITE_PHONE?> <span class="middot">&middot;</span> <i class="icon-skype2"></i> <?=SITE_SKYPE?>
					</div>
				</div>
			</div><!-- #copyrights end -->
		</footer><!-- #footer end -->
	</div><!-- #wrapper end -->
	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>
	<!-- External JavaScripts
	============================================= -->
	<script src="<?php echo DEFAULT_JS_DIR;?>jquery.js"></script>
	<script src="<?php echo DEFAULT_JS_DIR;?>plugins.js"></script>
	<!-- Footer Scripts
	============================================= -->
	<script src="<?php echo DEFAULT_JS_DIR;?>functions.js"></script>
	<?php 
      if(isset($additional_js)):
        foreach($additional_js as $js) {
    ?>
    <script src="<?=$js?>" type="text/javascript"></script>
    <?php } endif ?>
</body>
</html>