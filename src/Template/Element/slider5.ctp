<?php
namespace Cake\I18n;
use Cake\I18n\Time;
switch ($model){
		case 'recentlyadded':
			$data = $recentlyaddedModel;
			$viewmore = 'recent';
			$title = "NEW ARRIVALS";
			break;
		case 'mostpopular':
			$data = $mostpopularModel;
			$viewmore = 'popular';
			$title = "POPULAR PRODUCTS";
			break;
		case 'categories':
			$data = $categoryModel;
			$viewmore = 'categories';
			$title = "Categories";
			break;
		case 'top_rated':
			$data = $topratedModel;
			$viewmore = 'toprated';
			$title = "Top Rated Products";
			break;
		case 'discount_items':
			$data = $discount_items;
			$viewmore = 'discountproducts';
			$title = "Discount Items";
			break;
		case 'featured':
			$data = $featuredModel;
			$viewmore = 'featured';
			$title = "Featured Items";
			break;
	}

   if(count($data) > 0)
   {
?>
<section class="container new-arrivals topselpadings">
			<div class="product_align_cnt col-sm-12 no-hor-padding">
				<div class="item-slider grid col-xs-12 col-sm-12 no-hor-padding">
					<div class="section_header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<h2 class="section_heading bold-font">
							<?php echo __d('user', $title); ?></h2>
						<div class="view-all-btn btn primary-color-bg primary-color-bg pull-right">
							<a href="<?php echo SITE_URL.'viewmore/'.$viewmore; ?>"><?php echo __d('user', 'View all'); ?></a>
						</div>
					</div>

					<div
						class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding product-sec-slide heroSlider-fixed">
						
						<?php
					      if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
					      {
					    ?>
						<div dir="rtl">
						<?php } ?>
						<div class="top_selslider ">



							<!-- <div class="top_products_row">  </div> -->

							<?php
								$topRated = 0;
								foreach($data as $dkey=>$eachData)
								{

									$itemprice = $eachData['price'];
                  $discountprice = $itemprice * ( 1 - $eachData['discount'] / 100 );

                $user_currency_price =  $currencycomponent->conversion($eachData['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

          $user_currency_dealprice = $currencycomponent->conversion($eachData['forexrate']['price'],$_SESSION['currency_value'],$discountprice);

									if($topRated > 9)
										continue;
									
									if ($topRated % 2 == 0)
									  {
									    ?>
									    <div class="item1 box_shadow_img">
								<div class="product_cnt clearfix">
									    <div>
											<a class="Top_products <?php echo $dkey; ?>" href="<?php echo $eachData['product_url']; ?>">
												<img class=" img-responsive top_product" src="<?php echo $eachData['image']; ?>">
												</a>

												<div class="hover-visible_2">
										
										<?php

							        if (count($likeditemid) != 0 && in_array($eachData['id'], $likeditemid))
							        {

							?>
										<span class="hover-icon-cnt like_hover" href="#" onclick="itemcou1(<?php echo $eachData['id']; ?>)"><img
												src="<?php echo SITE_URL; ?>images/icons/liked-w.png"
												id="like-icon<?php echo $eachData['id']; ?>" class="like-icon<?php echo $eachData['id']; ?>">
											<span class="like-txt<?php echo $eachData['id']; ?> nodisply" id="like-txt<?php echo $eachData['id']; ?>">Fantacies</span></span>
											 <?php
        }
        else
        {

?>
<span class="hover-icon-cnt like_hover" href="#" onclick="itemcou1(<?php echo $eachData['id']; ?>)"><img
												src="<?php echo SITE_URL; ?>images/icons/heart_icon.png"
												id="like-icon<?php echo $eachData['id']; ?>" class="like-icon<?php echo $eachData['id']; ?>">
											<span class="like-txt<?php echo $eachData['id']; ?> nodisply" id="like-txt<?php echo $eachData['id']; ?>">Fantacy</span></span>

<?php
        }

?>


										<span class="hover-icon-cnt share_hover" href="javascript:void(0)"
											onclick="share_posts(<?php echo $eachData['id']; ?>);" data-toggle="modal" data-target="#share-modal"><img
												src="<?php echo SITE_URL; ?>images/icons/share_icon.png"></span>
									</div>
									<?php
        echo '<span id="figcaption_titles' . $eachData['id'] . '" figcaption_title ="' . $eachData['item_title'] . '" style="display:none;width:0px !important;"></span>';
        echo '<span class="figcaption" id="figcaption_title_url' . $deal['id'] . '" figcaption_url ="' . $eachData['item_title'] . '" style="display:none;width:0px !important;" >' . $eachData['item_title'] . '</span>';
        echo '<span id="price_vals' . $eachData['id'] . '" price_val="' . $_SESSION['currency_symbol'] . $user_currency_price . '" style="display:none;width:0px !important;"></span>';
        echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $deal['id'] . '" usernameval ="' . $username . '" style="display:none;width:0px !important;"></a>';
        echo '<span id="img_' . $eachData['id'] . '" class="nodisply" style="display:none;width:0px !important;">' . $eachData['image'] . '</span>';
        echo '<span class="fav_count" id="fav_count' . $eachData['id'] . '" fav_counts ="' . $favorte_count . '" style="display:none;width:0px !important;"></span>';

?>
											

											<div
												class="just_prod_nam marg_res bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="<?php echo $eachData['product_url']; ?>">
													<span><?php echo $eachData['item_title']; ?> </span> </a>
												<!--<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													‎<?php echo $eachData['currency']; ?> <?php echo $eachData['price']; ?></div>-->

											<?php
      $price = $eachData['price'];
      $date = date('d');
          $month = date('m');
          $year = date('Y');
          $tdy = strtotime($month . '/' . $date . '/' . $year);
          $newdate = new Time($eachData['dealdatetwo']);
          $dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
      
      $dealstrtime = strtotime(date('Y-m-d',$dealdate));
      $todaystrtime = strtotime(date('Y-m-d',$tdy));
      if($eachData['discount_type'] == 'daily' && 
         $dealstrtime == $todaystrtime)
      {
         $dailydealdiscount = $eachData['discount'];
         $unitPriceConvert = number_format((float)$price, 2, '.', '');
         $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
         echo '<span id="price_vals'.$eachData['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_dealprice.'" style="display:none;width:0px !important;"></span>';
         ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">&lrm;<?php echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice; ?> &lrm;<strike class="bold-font"><?php echo $_SESSION['currency_symbol'].' '.$user_currency_price; ?></strike></div>
<?php
   }elseif($eachData['discount_type'] == 'regular')
   {
         
         $unitPriceConvert = number_format((float)$price, 2, '.', '');
         $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);

         echo '<span id="price_vals'.$eachData['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_dealprice.'" style="display:none;width:0px !important;"></span>';
      ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">&lrm;<?php echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice; ?> &lrm;<strike class="bold-font"><?php echo $_SESSION['currency_symbol'].' '.$user_currency_price; ?></strike></div>
<?php
   }else{
   	echo '<span id="price_vals'.$eachData['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_price.'" style="display:none;width:0px !important;"></span>';
      ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
   <?php echo $_SESSION['currency_symbol']; ?><?php echo $user_currency_price; ?> 
</div>
<?php
   }
   ?>

											</div>

										</div>
									    	
										</div></div>
									    <?php
									  }
									  else
									  {
									    ?>
									    							<div class="item2 box_shadow_img">
								<div class="product_cnt clearfix"> 	
									    <div>
											<div class="Top_products_2 <?php echo $dkey; ?>">
											<a class="Top_products <?php echo $dkey; ?>" href="<?php echo $eachData['product_url']; ?>">
												<img class="img-responsive img-fluid " src="<?php echo $eachData['image']; ?>"
													class="img-responsive"></a>

												<div class="hover-visible">
													<?php

							        if (count($likeditemid) != 0 && in_array($eachData['id'], $likeditemid))
							        {

							?>
										<span class="hover-icon-cnt like_hover" href="#" onclick="itemcou1(<?php echo $eachData['id']; ?>)"><img
												src="<?php echo SITE_URL; ?>images/icons/liked-w.png"
												id="like-icon<?php echo $eachData['id']; ?>" class="like-icon<?php echo $eachData['id']; ?>">
											<span class="like-txt<?php echo $eachData['id']; ?> nodisply" id="like-txt<?php echo $eachData['id']; ?>">Fantacies</span></span>
											 <?php
        }
        else
        {

?>
<span class="hover-icon-cnt like_hover" href="#" onclick="itemcou1(<?php echo $eachData['id']; ?>)"><img
												src="<?php echo SITE_URL; ?>images/icons/heart_icon.png"
												id="like-icon<?php echo $eachData['id']; ?>" class="like-icon<?php echo $eachData['id']; ?>">
											<span class="like-txt<?php echo $eachData['id']; ?> nodisply" id="like-txt<?php echo $eachData['id']; ?>">Fantacy</span></span>

<?php
        }

?>



														
													<span class="hover-icon-cnt share_hover" href="javascript:void(0)"
														onclick="share_posts(<?php echo $eachData['id']; ?>);" data-toggle="modal" data-target="#share-modal"><img
															src="<?php echo SITE_URL; ?>images/icons/share_icon.png"></span>
												</div>
												<?php
        echo '<span id="figcaption_titles' . $eachData['id'] . '" figcaption_title ="' . $eachData['item_title'] . '" style="display:none;width:0px !important;"></span>';
        echo '<span class="figcaption" id="figcaption_title_url' . $deal['id'] . '" figcaption_url ="' . $eachData['item_title'] . '" style="display:none;width:0px !important;" >' . $eachData['item_title'] . '</span>';
        echo '<span id="price_vals' . $eachData['id'] . '" price_val="' . $_SESSION['currency_symbol'] . $user_currency_price . '" style="display:none;width:0px !important;"></span>';
        echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $deal['id'] . '" usernameval ="' . $username . '" style="display:none;width:0px !important;"></a>';
        echo '<span id="img_' . $eachData['id'] . '" class="nodisply" style="display:none;width:0px !important;">' . $eachData['image'] . '</span>';
        echo '<span class="fav_count" id="fav_count' . $eachData['id'] . '" fav_counts ="' . $favorte_count . '" style="display:none;width:0px !important;"></span>';

?>


												<div
													class="just_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="<?php echo $eachData['product_url']; ?>">
														<span><?php echo $eachData['item_title']; ?> </span> </a>
													
													<!--<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														‎<?php echo $eachData['currency']; ?> <?php echo $eachData['price']; ?></div>-->
										<?php
      $price = $eachData['price'];
      $date = date('d');
          $month = date('m');
          $year = date('Y');
          $tdy = strtotime($month . '/' . $date . '/' . $year);
          $newdate = new Time($eachData['dealdatetwo']);
          $dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
      
      $dealstrtime = strtotime(date('Y-m-d',$dealdate));
      $todaystrtime = strtotime(date('Y-m-d',$tdy));
      if($eachData['discount_type'] == 'daily' && 
         $dealstrtime = $todaystrtime)
      {
         $dailydealdiscount = $eachData['discount'];
         $unitPriceConvert = number_format((float)$price, 2, '.', '');
         $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
         ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">&lrm;<?php echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice; ?> &lrm;<strike class="bold-font"><?php echo $_SESSION['currency_symbol'].' '.$user_currency_price; ?></strike></div>
<?php
   }elseif($eachData['discount_type'] == 'regular')
   {
         
         $unitPriceConvert = number_format((float)$price, 2, '.', '');
         $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
      ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">&lrm;<?php echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice; ?> &lrm;<strike class="bold-font"><?php echo $_SESSION['currency_symbol'].' '.$user_currency_price; ?></strike></div>
<?php
   }else{
      ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
   <?php echo $_SESSION['currency_symbol']; ?><?php echo $user_currency_price; ?> 
</div>
<?php
   }
   ?>

												</div>
											</div>
										</div>
									    	</div></div>
											
									    <?php
									  }
							$topRated++;
								}
							?>
					</div>
					<?php
					      if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
					      {
					    ?>
					    </div>

					    <?php } ?>

				</div>
			</div>
			</div>
		</section>
		<?php } ?>