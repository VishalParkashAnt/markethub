<?php
namespace Cake\I18n;
use Cake\I18n\Time;
?>
<!-- Top Stores-->

		<section class="container new-arrivals paddigs">
			<div class="product_align_cnt col-sm-12 no-hor-padding">
				<div class="item-slider grid col-xs-12 col-sm-12 no-hor-padding">
					<div class="section_header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<h2 class="section_heading bold-font">
							<?php echo __d('user', 'Top Stores'); ?> </h2>
						<div class="view-all-btn btn primary-color-bg primary-color-bg pull-right">
							<a href="<?php echo SITE_URL; ?>/viewmorestores/fdsfds"><?php echo __d('user','VIEW ALL'); ?></a>
						</div>
					</div>



					<div
						class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding product-sec-slide heroSlider-fixed">
						
						<!-- Slider -->
						<!-- <div dir="rtl"> -->
						<div class=" top_stores arr_str_center">

						<?php
							$store = 1;
							foreach($topstoreModel as $storeKey=>$storeModel)
							{
								//echo '<pre>'; print_r($storeModel); die;
								$shop_url = SITE_URL . 'stores/' . $storeModel['shop_name_url'];
								//echo '<pre>'; print_r($storeModel); die;
						?>
							<div class="item<?php echo $store; ?> box_shadow_img">
								<div class="product_cnt clearfix">
									<a class="products-hovers" id="shop_url<?php echo $storeModel['store_id']; ?>" href="<?php echo $shop_url; ?>">
										<div class="store_imgs">
											<img id="store_img_<?php echo $storeModel['store_id']; ?>" src="<?php echo $storeModel['image']; ?>" class=" img-responsive" />
										</div>
									</a>
									<div class="hover-visible">
										
										<span class="hover-icon-cnt share_hover" href="javascript:void(0)"
											onclick="share_store(<?php echo $storeModel['store_id']; ?>);"><img
												src="<?php echo SITE_URL; ?>images/icons/share_icon.png"></span>
									</div>

									<div
											class="just_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="#">
												<span id="store_names_<?php echo $storeModel['store_id']; ?>"><?php echo $storeModel['store_name']; ?> </span> </a>
											<div id="merchant_name_<?php echo $storeModel['store_id']; ?>" class="top_usrnam col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<?php echo $storeModel['merchant_name']; ?> </div>
		
										</div>
								</div>

							</div>
							<?php 
							$store++;
							} 
							?>


						<!-- </div> -->

					</div>

				


					</div>
				</div>
			</div>
		</section>