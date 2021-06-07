<?php
namespace Cake\I18n;
use Cake\I18n\Time;
//$this->element($slider);
//echo '<pre>'; print_r($mostpopularModel); die;

?>
<!-- Slider 6  -->
	<?php
if (!empty($suggestedModel))
{

?>
	<!-- Slider 6  -->
	<section class="container new-arrivals tpdown">
			<div class="product_align_cnt col-sm-12 no-hor-padding">
				<div class="item-slider grid col-xs-12 col-sm-12 no-hor-padding">
					<div class="section_header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<h2 class="section_heading bold-font">
							<?php echo __d('user', 'Suggested Items'); ?> </h2>
						<div class="view-all-btn btn primary-color-bg primary-color-bg pull-right">
							<a href="<?php echo SITE_URL . 'viewmore/suggesteditem'; ?>"><?php echo __d('user','View All'); ?></a>
						</div>
					</div>
				</div>
			</div>

		</section>
<?php
} ?>



		<section class="container">

		<div>
			<div class="row">
				<?php
			      if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
			      {
			    ?>
				 <div dir="rtl">  
				<?php } ?>
				<div class="Popular_sliders">
					<?php
$i = 0;
foreach ($suggestedModel as $skey => $eachItem)
{
	if($i=='0')
	{
		$class_id = '';
	}else{
		$class_id = $i;
	}

    if ($i > 2) continue;
?>

					<div class="col-md-4">
						<div class=" slider  slider-for<?php echo $class_id; ?>">
						<?php
							$s=1;	
							//echo "<pre>";print_r($eachItem);die;
							foreach ($eachItem['related_items'] as $rkey => $eachItems)
						    {

						    	 $itemprice = $eachItems['price'];
                  $discountprice = $itemprice * ( 1 - $eachItems['discount'] / 100 );

                $user_currency_price =  $currencycomponent->conversion($eachItems['forexrate_price'],$_SESSION['currency_value'],$itemprice);

          $user_currency_dealprice = $currencycomponent->conversion($eachItems['forexrate_price'],$_SESSION['currency_value'],$discountprice);
						?>
							<div class="slick-demo d<?php echo $s; ?>">
								<div class="item1 box_shadow_img">
									<div class="product_cnt clearfix">
										<div class="whit-bagd">
											<a class="products-hovers" href="<?php echo $eachItems['product_url']; ?>">
												<div class="recent_imgs">
													<img src="<?php echo $eachItems['image']; ?>"
														class="Recent_img-responsive img-fluid">
												</div>
											</a>
											<div class="hover-visible">
												<?php

    if (count($likeditemid) != 0 && in_array($eachItem['id'], $likeditemid))
    {

?>
												<span class="hover-icon-cnt like_hover marked" href="#" onclick="itemcou1(<?php echo $eachItem['id']; ?>);">
													<img src="<?php echo SITE_URL; ?>images/icons/liked-w.png"
														id="like-icon<?php echo $eachItem['id']; ?>" class="like-icon<?php echo $eachItem['id']; ?>">
													<span class="like-txt<?php echo $eachItem['id']; ?> nodisply"
														id="like-txt<?php echo $eachItem['id']; ?>">Fantacy</span></span>
													<?php
    }
    else
    {
?>
														<span class="hover-icon-cnt like_hover unmarked" href="#" onclick="itemcou(<?php echo $eachItem['id']; ?>)">
													<img src="<?php echo SITE_URL; ?>/images/icons/heart_icon.png"
														id="like-icon<?php echo $eachItem['id']; ?>" class="like-icon<?php echo $eachItem['id']; ?>">
													<span class="like-txt<?php echo $eachItem['id']; ?> nodisply"
														id="like-txt<?php echo $eachItem['id']; ?>">Fantacies</span></span>

														<?php
    } ?>
    <span class="hover-icon-cnt share_hover" href="javascript:void(0)"
													onclick="share_posts(<?php echo $eachItem['id']; ?>);" data-toggle="modal" data-target="#share-modal"><img
														src="<?php echo SITE_URL; ?>images/icons/share_icon.png"></span>
											</div>
										</div>
				
										<div
											class="recent_section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<div
												class="product_det_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				
												<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"
													href="#"> <span><?php echo $eachItems['item_title']; ?>  </span> </a>
												
												<?php
      $price = $eachItems['price'];

      $date = date('d');
      $month = date('m');
      $year = date('Y');
      $tdy = strtotime($month . '/' . $date . '/' . $year);

      //echo $eachItems['dealdate']; die;

      if( $eachItems['discount_type'] == 'daily' && 
      	isset($eachItems['dealdate']) && 
      	$eachItems['dealdate'] != '' )
      {
          //$dealdate = $eachItems['dealdate']; 
      		//echo 'Deal date format'
      		//echo $dealdate = $eachItems['dealdate']->format('Y-m-d'); die;
      	  if(isset($eachItems['dealdatetwo']) && isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
      	  {
      	  	//$newdate = new Time($eachItems['dealdate']);
      	  	$sfdfsddf = $eachItems['dealdatetwo'];
          	$dealdate = strtotime($sfdfsddf);

      	  }else{
      	  	$newdate = new Time($eachItems['dealdate']);
          	$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
      	  }
      	  
          $dealstrtime = strtotime(date('Y-m-d',$dealdate));
          $todaystrtime = strtotime(date('Y-m-d',$tdy));
          
       }else{
          $dealstrtime = '';
          $todaystrtime = strtotime(date('Y-m-d',$tdy));
       }

      if($eachItems['discount_type'] == 'daily' && 
         $dealstrtime == $todaystrtime)
      {
      	
         $dailydealdiscount = $eachItems['discount'];
         $unitPriceConvert = number_format((float)$price, 2, '.', '');
         $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);

         echo '<span id="price_vals'.$eachItems['id'].'" price_val="'.$_SESSION['currency_symbol'].$daily_price.'" style="display:none;width:0px !important;"></span>';
         ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">&lrm;<?php echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice; ?> &lrm;<strike class="bold-font"><?php echo $_SESSION['currency_symbol'].' '.$user_currency_price; ?></strike></div>

<?php
   }elseif($eachItems['discount_type'] == 'regular')
   {
   	
   		$dailydealdiscount = $eachItems['discount'];
   		$unitPriceConvert = number_format((float)$price, 2, '.', '');
        $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
         
         

         echo '<span id="price_vals'.$eachItems['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_dealprice.'" style="display:none;width:0px !important;"></span>';
      ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">&lrm;<?php echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice; ?> &lrm;<strike class="bold-font"><?php echo $_SESSION['currency_symbol'].' '.$user_currency_price; ?></strike></div>


<?php
   }else{
   	
      ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
   <?php echo $_SESSION['currency_symbol']; ?><?php echo $user_currency_price; ?> 
</div>
<?php
echo '<span id="price_vals'.$eachItems['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_price.'" style="display:none;width:0px !important;"></span>';
   }
   ?>

												


											</div>
										</div>
				
				
									</div>
				
								</div>
				
							</div>
							<?php 
							$s++;
							}
							 ?>
				
				
				
				
						</div>
						<div class="slider slider-nav<?php echo $class_id; ?>">
							<?php
								$d=1;
							    foreach ($eachItem['related_items'] as $rkey => $eachItems)
							    {
							?>
							<div class="slick-demo slider-div d<?php echo $d; ?>">
								<div class="Recent_added_1">
									<div class="Thumbnail_img1 clearfix">
				
										<img src="<?php echo $eachItems['image']; ?>" />
				
									</div>
				
								</div>
							</div>
							<?php $d++; } ?>
						</div>
						
					</div>
					<?php $i++; } ?>




					
				
				</div>
<?php
      if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
      {
        ?>
				 </div> 
<?php } ?>
			</div>
			</div>

			<!-- control arrows -->



        </section>