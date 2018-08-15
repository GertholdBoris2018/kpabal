<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Product Information</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products" class="m-nav__link m-nav__link--icon">
							<i class="m-nav__link-icon la la-home"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- END: Subheader -->
	<div class="m-content">
		<!--begin::Portlet-->
		<div class="m-portlet">
			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right" id="product_form" novalidate="novalidate">
				<input type="hidden" name="id" value="<?=$id?>">
				<div class="m-portlet__body">
					<div class="m-form__content">
						<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_1_msg">
							<div class="m-alert__icon">
								<i class="la la-warning"></i>
							</div>
							<div class="m-alert__text">
								Oh snap! Change a few things up and try submitting again.
							</div>
							<div class="m-alert__close">
								<button type="button" class="close" data-close="alert" aria-label="Close">
								</button>
							</div>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Product Name *</label>
							<input type="text" class="form-control m-input" name="product_name" placeholder="Enter product name" value="<?php if($product) echo $product->product_name;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Product Title *</label>
							<input type="text" class="form-control m-input" name="title" placeholder="Enter product title" value="<?php if($product) echo $product->title;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Price *</label>
							<input type="text" class="form-control m-input" name="price" id="price" placeholder="Enter price" value="<?php if($product) echo $product->price;?>">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Category *</label>
							<select class="form-control m-input" name="category">
								<option value="">Select</option>
								<?php foreach($categories as $category) { ?>
		                      <option value="<?=$category->categoryIdx?>"<?php if(($product) && ($product->category == $category->categoryIdx)) echo " selected";?>><?=$category->categoryName?></option>
		                      <?php foreach($category->children as $sub_category) { ?>
		                      <option value="<?=$sub_category->categoryIdx?>"<?php if(($product) && ($product->category == $sub_category->categoryIdx)) echo " selected";?>>&nbsp;&nbsp;&nbsp;<?=$sub_category->categoryName?></option>
		                      <?php } } ?>
							</select>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Product Description</label>
							<textarea class="form-control m-input" rows="5" name="descriptions" placeholder="Enter product description"><?php if($product) echo $product->descriptions;?></textarea>
						</div>
					</div>
					<?php if($product):?>
					<div class="form-group m-form__group row">
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Avatar</label>
							<a href="#" id="select_avatar" class="btn btn-primary">Select Picture</a>
						</div>
						<?php if(file_exists(PROJECT_PRODUCT_DIR."/product_".$id."_1.jpg")) unlink(PROJECT_PRODUCT_DIR."/product_".$id."_1.jpg");?>
						<div class="col-md-3 m-form__group-sub">
							<img id="avatar" src="<?php if(file_exists(PROJECT_PRODUCT_DIR."/product_".$id.".jpg")) echo ROOTPATH.PROJECT_PRODUCT_DIR."/product_".$id.".jpg"; else echo ROOTPATH.PROJECT_PRODUCT_DIR."/default.jpg";?>" style="display: inline-block; min-width: 80px; height: 80px; border: solid 2px #3235985c; border-radius: 5px;" alt=" Avatar">
						</div>
					</div>
					<?php endif?>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="<?=ROOTPATH?><?=ADMIN_PUBLIC_DIR?>/products" class="btn btn-secondary">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
			<input type="file" id="upload_avatar" accept=".gif,.jpg,.jpeg,.png" style="display: none;">
		</div>
		<!--end::Portlet-->
	</div>
</div>