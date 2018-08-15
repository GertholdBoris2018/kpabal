		<section id="slider" class="slider-element slider-parallax swiper_wrapper full-screen clearfix">
			<div class="slider-parallax-inner">

				<div class="swiper-container swiper-parent">
					<div class="swiper-wrapper">
						<?php foreach($sliders as $slider){?>
						<div class="swiper-slide dark" style="background-image: url('<?=ROOTPATH?><?=PROJECT_MEDIA_DIR?>/site_contents_<?=$slider->id?>.jpg'); background-position: center top;">
							<div class="container clearfix">
								<div class="slider-caption slider-caption-<?=$slider->additional_css?>">
									<h2 data-caption-animate="fadeInUp"><?=$slider->title?></h2>
									<p class="d-none d-sm-block" data-caption-animate="fadeInUp" data-caption-delay="200">
										<?=$slider->content?></p><br><br><br>
								</div>
							</div>
						</div>
						<?php }?>
					</div>
					<div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
					<div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
				</div>

				<a href="#" data-scrollto="#content" data-offset="100" class="dark one-page-arrow"><i class="icon-angle-down infinite animated fadeInDown"></i></a>

			</div>
		</section>

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">
					<div class="row clearfix">

						<div class="col-xl-5">
							<div class="heading-block topmargin">
								<h1>Welcome to KPABAL.<br>MultiPurpose Platform.</h1>
							</div>
							<p class="lead">Can search anything that you are gonna be proud of. Be it Business, Person, Job, Product, Articles &amp; much more.</p>
						</div>

						<div class="col-xl-7">

							<div style="position: relative; margin-bottom: -60px;" class="ohidden" data-height-xl="426" data-height-lg="567" data-height-md="470" data-height-md="287" data-height-xs="183">
								<img src="<?php echo DEFAULT_IMG_DIR;?>services/main-fbrowser.png" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="100" alt="Chrome">
								<img src="<?php echo DEFAULT_IMG_DIR;?>services/main-fmobile.png" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="400" alt="iPad">
							</div>

						</div>

					</div>
				</div>

				<div class="section nobottommargin">
					<div class="container clear-bottommargin clearfix">
						<div class="heading-block center"> 
							<h2>Business listing, Quick and Easy Use.</h2>
						</div>

						<div class="row topmargin-sm clearfix">
							<div class="col-md-6 bottommargin">
								<div class="input-group divcenter">
									<input type="text" class="form-control" id="search_keywords" placeholder="Search by business or keyword" required="" style="text-indent: 20px; background: transparent;">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="1 -3 18 18" width="18" height="18" style="position:  absolute; top: 10px; left:  10px;"><path id="magnifying-glass" d="M13.5 8h-0.8l-0.3-0.3c1-1.1 1.6-2.6 1.6-4.2C14-0.1 11.1-3 7.5-3S1-0.1 1 3.5 3.9 10 7.5 10c1.6 0 3.1-0.6 4.2-1.6L12 8.7v0.8l5 5 1.5-1.5L13.5 8 13.5 8zM7.5 8C5 8 3 6 3 3.5S5-1 7.5-1 12 1 12 3.5 10 8 7.5 8L7.5 8z"></path></svg>
								</div>
							</div>
							<div class="col-md-6 bottommargin">
								<div class="input-group divcenter">
									<input type="text" class="form-control" id="autocomplete" placeholder="Enter location for search" required="">
									<div class="input-group-append">
										<button class="btn btn-success" type="submit"><i class="icon-search"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="container clearfix">
					<div class="heading-block center topmargin-lg">
						<h2>Jobs you may be interested in</h2>
						<span class="divcenter">From KPABAL, you can browse or search thousands of jobs or person</span>
					</div>
					<?php for($i=0; $i<count($jobs); $i++){?>
					<div class="col_one_third<?php if($i % 3 == 2) echo ' col_last';?>">
						<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="<?=($i + 1) * 2?>00">
							<div class="fbox-icon">
								<a href="#"><i class="icon-line-circle-check"></i></a>
							</div>
							<h3><?=$jobs[$i]->title?></h3>
							<p><?=$jobs[$i]->description?></p>
						</div>
					</div>					
					<?php 
						if($i % 3 == 2) echo '<div class="clear"></div>';
						} ?>
				</div>

				<div class="section topmargin nobottommargin nobottomborder">
					<div class="container clearfix">
						<div class="heading-block center nomargin">
							<h3>Our Recommended Products</h3>
						</div>
					</div>
				</div>

				<div id="portfolio" class="portfolio portfolio-nomargin grid-container portfolio-notitle portfolio-full grid-container clearfix">
					<?php foreach($products as $product){ ?>
					<article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image">
							<a href="portfolio-single.html">
								<img src="<?=ROOTPATH?>api/image/product/<?=$product->id?>/400/300" alt="<?=$product->title?>">
							</a>
							<div class="portfolio-overlay">
								<a href="<?=ROOTPATH?>api/image/product/<?=$product->id?>/1200/900" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
								<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
							</div>
						</div>
						<div class="portfolio-desc">
							<h3><a href="portfolio-single.html"><?=$product->title?></a></h3>
							<span><a href="#"><?=$product->categoryName?></a></span>
						</div>
					</article>
					<?php } ?>
				</div>
				<div class="clear"></div>
				<a href="portfolio.html" class="button button-full button-dark center tright">
					<div class="container clearfix">
						More than 100+ products in our Market Place. <strong>See More</strong> <i class="icon-caret-right" style="top:4px;"></i>
					</div>
				</a>
				<div class="section notopmargin notopborder">
					<div class="container clearfix">
						<div class="heading-block center nomargin">
							<h3>Latest from the Blog</h3>
						</div>
					</div>
				</div>
				<div class="container clear-bottommargin clearfix">
					<div class="row">

						<?php foreach($articles as $article) {?>
						<div class="col-lg-3 col-md-6 bottommargin">
							<div class="ipost clearfix">
								<div class="entry-image">
									<a href="#"><img class="image_fade" src="<?=ROOTPATH?>api/image/board/<?=$article->id?>/400/300" alt="Image"></a>
								</div>
								<div class="entry-title">
									<h3><a href="blog-single.html"><?=$article->article_title?></a></h3>
								</div>
								<ul class="entry-meta clearfix">
									<li><i class="icon-calendar3"></i> <?=date("jS F Y", strtotime($article->article_date))?></li>
									<?php if($article->reply_count):?>
									<li><a href="blog-single.html#comments"><i class="icon-comments"></i> <?=$article->reply_count?></a></li>
									<?php endif ?>
								</ul>
							</div>
						</div>
						<?php }?>

					</div>
				</div>

			</div>

		</section><!-- #content end -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1_cca3KUssaymD-nx0yRKQyHcFFAfxp0&libraries=places&callback=initAutocomplete"
	        async defer></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
  .ui-autocomplete-loading {
    background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
</style>
<script type="text/javascript">	
	window.onload = function(){
	    jQuery( "#search_keywords" ).autocomplete({
	      source: function( request, response ) {
	        $.ajax( {
	          url: "<?=ROOTPATH?>api/search_keywords",
	          dataType: "jsonp",
	          data: {
	            term: request.term
	          },
	          success: function( data ) {
	            response( data );
	          }
	        } );
	      },
	      minLength: 2,
	      select: function( event, ui ) {
	        console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
	      }
	    });
	}

	function initAutocomplete() {
	  // Create the autocomplete object, restricting the search to geographical
	  // location types.
	  autocomplete = new google.maps.places.Autocomplete(
	      /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
	      {types: ['geocode']});

	}

</script>