<!-- Page Title
		============================================= -->
		

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<!-- Sidebar
					============================================= -->
					<div class="sidebar nobottommargin clearfix">
						<div class="sidebar-widgets-wrap">

							<div class="side-panel-wrap">

                                <div class="widget clearfix">

                                    <h4>Category</h4>
                                    <nav class="nav-tree nobottommargin">
                                        
                                        <?php 
                                        //var_dump($categories);
                                            if(count($categories) > 0){
                                                ?>
                                                <ul>
                                                    <?php foreach($categories as $category) { ?>
                                                        <li><a href="javascript:;"></i><?=$category->categoryName?></a>
                                                        <?php if(count($category->children) > 0) { ?>
                                                            <ul>
                                                                <?php foreach($category->children as $sub_category) { ?>
                                                                    <li><a href="javascript:;" onclick="select('<?=$sub_category->categoryIdx?>')"><?php echo $sub_category->categoryName?></a></li>
                                                                <?php } ?>
                                                            </ul>
                                                        <?php } ?>
                                                        
                                                    <?php } ?>
                                                </ul>
                                        <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <span>Catetory no exist!</span>
                                                <?php
                                            }
                                        ?>
                                        
                                    </nav>

                                </div>

                            </div>

						</div>

					</div><!-- .sidebar end -->

					<!-- Post Content
					============================================= -->
					<div class="postcontent bothsidebar nobottommargin">
                        <form id="filterForm" action="<?=ROOTPATH?>markets" class="m-form m-form--fit m-form--label-align-right" method="post">
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="inputEmail4">Category</label>
									<select id="category" name="category" class="form-control category">
                                        <option value="">모든 카테고리</option>
                                            <?php foreach($categories as $category) { ?>
                                        <option value="<?=$category->categoryIdx?>"<?php if(($selected_cat) && ($selected_cat == $category->categoryIdx)) echo " selected";?>><?=$category->categoryName?></option>
                                        <?php foreach($category->children as $sub_category) { ?>
                                        <option value="<?=$sub_category->categoryIdx?>"<?php if(($selected_cat) && ($selected_cat == $sub_category->categoryIdx)) echo " selected";?>>&nbsp;&nbsp;&nbsp;<?=$sub_category->categoryName?></option>
                                        <?php } } ?>
									</select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Keyword</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo isset($selected_key)?$selected_key:'';?>" placeholder="what are you looking for?">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputAddress"></label>
                                    <button type="submit" class="btn btn-primary">search</button>
                                </div>
							</div>
						</form>
						<!-- Shop
						============================================= -->
						<div id="shop" class="shop product-1 clearfix">
                            <?php foreach($products as $product) { ?>
                                <div class="product clearfix">
                                    <div class="product-image">
                                        <a href="#"><img src="<?php if(file_exists(PROJECT_PRODUCT_DIR."/product_".$product->id.".jpg")) echo ROOTPATH.PROJECT_PRODUCT_DIR."/product_".$product->id.".jpg"; else echo ROOTPATH.PROJECT_PRODUCT_DIR."/default.jpg";?>" alt="Checked Short Dress"></a>
                                        
                                    </div>
                                    <div class="product-desc">
                                        <div class="product-title"><h3><a href="#"><?php echo $product->product_name;?></a></h3></div>
                                        <div class="product-price"><ins>$<?php echo $product->price;?></ins></div>
                                        <div class="product-desc">
                                            <?php echo $product->descriptions;?>
                                        </div>
                                        <div class="product-posted text-right">
                                            <?php echo $product->posted_date;?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

						</div><!-- #shop end -->

					</div><!-- .postcontent end -->

					<!-- Sidebar
					============================================= -->
					<div class="sidebar nobottommargin col_last">
						<div class="sidebar-widgets-wrap">

							
						</div>
					</div><!-- .sidebar end -->

				</div>

			</div>

		</section><!-- #content end -->