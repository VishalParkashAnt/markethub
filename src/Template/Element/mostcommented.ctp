<?php
namespace Cake\I18n;
use Cake\I18n\Time;

?>
	<!--Most Commented-->
	<section class="container new-arrivals">
		<div class="product_align_cnt col-sm-12 no-hor-padding">
			<div class="item-slider grid col-xs-12 col-sm-12 no-hor-padding">
				<div class="section_header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<h2 class="section_heading bold-font">
						<?php echo __d('user','Most Commented');?>
					</h2>
					<div class="view-all-btn btn primary-color-bg primary-color-bg pull-right">
						<a href="<?php echo SITE_URL.'viewmore/mostcommented';?>">
							<?php echo __d('user','View All');?></a>
					</div>
				</div>
		<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding product-sec-slide heroSlider-fixed" >
		<?php
		if(isset($loguser['id']))
	echo '<input type="hidden" id="loguserid" value="'.$loguser['id'].'">';
else
	echo '<input type="hidden" id="loguserid" value="0">';

				echo '<input type="hidden" id="likebtncnt" value="'.$setngs['like_btn_cmnt'].'" />';
				echo '<input type="hidden" id="likedbtncnt" value="'.$setngs['liked_btn_cmnt'].'" />'; ?>
				
         <!-- Slider -->
        <div class="slider responsive2" id="mostcommented">
	<?php

	foreach ($mostcommentedModel as $mostcommentedkey => $recentlyadded)
	{

		
	$item_url = base64_encode($recentlyadded['id']."_".rand(1,9999));

				$itemid = base64_encode($recentlyadded->id."_".rand(1,9999));

				$item_title = $recentlyadded['item_title'];
				$item_title_url = $recentlyadded['item_title_url'];
				$item_price = $recentlyadded['price'];
				$favorte_count = $recentlyadded['fav_count'];
				$username = $recentlyadded['user']['username'];
				$currencysymbol = $recentlyadded['forexrate']['currency_symbol'];
				$items_image = $recentlyadded['photos'][0]['image_name'];


		if($recentlyadded['photos'][0]['image_name']=="")
			$itemimage = "usrimg.jpg";
		else
			$itemimage = $recentlyadded['photos'][0]['image_name'];


		$item_image = $recentlyadded['photos'][0]['image_name'];
						if($item_image == "")
						{
							$itemimage = SITE_URL.'media/items/original/usrimg.jpg';
						}
						else
						{
							$itemimage = WWW_ROOT.'media/items/original/'.$item_image;
							/*$header_response = get_headers($itemimage, 1);*/
							if (file_exists($itemimage))
							{
								$itemimage = SITE_URL.'media/items/original/'.$item_image;
							}
							else
							{
								$itemimage = SITE_URL.'media/items/original/usrimg.jpg';
							}
						}
					$itemprice = $recentlyadded['price'];

$user_currency_price =  $currencycomponent->conversion($recentlyadded['forexrate']['price'],$_SESSION['currency_value'],$itemprice);
if($loguser=="")
{
	$temp = ""; 
	$temp1= "";
}
else
{
	$temp = "modal";
	$temp1=  "#share-modal";
}
			echo '<div class="item1 box_shadow_img">
				<div class="product_cnt clearfix">
				<a class="img-hover1" href="'.SITE_URL.'listing/'.$item_url.'">
				<div class="bg_product">
					<img src="'.$itemimage.'" class="img-responsive" />
					</div></a>
				<div class="hover-visible">
				<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou('.$recentlyadded['id'].')">';
								
					if(count($likeditemid)!=0 &&  in_array($recentlyadded['id'],$likeditemid)){
							/*echo 	'<i class="fa fa-heart like-icon'.$recentlyadded['id'].'" id="like-icon'.$recentlyadded['id'].'"></i>*/
							echo '<img src="images/icons/liked-w.png" id="like-icon'.$recentlyadded['id'].'" class="like-icon'.$recentlyadded['id'].'">
								<span class="like-txt'.$recentlyadded['id'].' nodisply" id="like-txt'.$recentlyadded['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';}
								else
								{
				/*echo 	'<i class="fa fa-heart-o like-icon'.$recentlyadded['id'].'" id="like-icon'.$recentlyadded['id'].'"></i>*/
				echo '<img src="images/icons/heart_icon.png" id="like-icon'.$recentlyadded['id'].'" class="like-icon'.$recentlyadded['id'].'">
												<span class="like-txt'.$recentlyadded['id'].' nodisply" id="like-txt'.$recentlyadded['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';
								}
				echo '</span>
				<span class="hover-icon-cnt share_hover" href="javascript:void(0)" onclick="share_posts('.$recentlyadded['id'].');" data-toggle="'.$temp.'" data-target="'.$temp1.'" ><img src="'.SITE_URL.'images/icons/share_icon.png"></span>
					</div>

				';

				echo '<span id="figcaption_titles'.$recentlyadded['id'].'" figcaption_title ="'.$item_title.'" style="display:none;width:0px !important;"></span>';
				echo  '<span class="figcaption" id="figcaption_title_url'.$recentlyadded['id'].'" figcaption_url ="'.$item_title_url.'" style="display:none;width:0px !important;" >'.$item_title_url.'</span>';
				echo '<span id="price_vals'.$recentlyadded['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_price.'" style="display:none;width:0px !important;"></span>';
				echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$recentlyadded['id'].'" usernameval ="'.$username.'" style="display:none;width:0px !important;"></a>';
				echo '<span id="img_'.$recentlyadded['id'].'" class="nodisply" style="display:none;width:0px !important;">'.SITE_URL.'media/items/original/'.$items_image.'</span>';
				echo '<span class="fav_count" id="fav_count'.$recentlyadded['id'].'" fav_counts ="'.$favorte_count.'" style="display:none;width:0px !important;"></span>';

				echo '<div class="rate_section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="product_name bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="'.SITE_URL.'listing/'.$item_url.'">'.$recentlyadded['item_title'].'</a><br/>';
							$date = date('d');
					$month = date('m');
					$year = date('y');
					$tdy = strtotime($month . '/' . $date . '/' . $year);

						$newdate = new Time($recentlyadded['dealdate']);
							$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
					
						
			if($recentlyadded['dailydeal'] =='yes' && $dealdate >= $tdy){
			echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

			
//

$dealprice = $itemprice * ( 1 - $recentlyadded['discount'] / 100 );

$user_currency_dealprice = $currencycomponent->conversion($recentlyadded['forexrate']['price'],$_SESSION['currency_value'],$dealprice);

 if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
					}
					else{?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
						echo $recentlyadded['forexrate']['currency_symbol'].' '.$dealprice;
				}
					echo ' ';
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$recentlyadded['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}
			
echo '</div>';}
else
{
	echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

	if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo $_SESSION['currency_symbol'].' '.$user_currency_price;
				}
					else{?>&#x200E;<?php
					echo $recentlyadded['forexrate']['currency_symbol'].' '.$itemprice;}
				
				echo '</div>';
}
			echo '</div>
				</div>
				</div>

	</div>';
}
?>

            </div>

        <ul class="slick-dots" style="display: block;"><li class="slick-active" aria-hidden="false"><button type="button" data-role="none">1</button></li><li aria-hidden="true"><button type="button" data-role="none">2</button></li></ul>


				<!-- control arrows -->
				<div class="prev1 preb slick-disabled" style="display: block;">
					<span class="fa fa-angle-left" aria-hidden="true"></span>
				</div>
				<div class="next1 nexb" style="display: block;">
					<span class="fa  fa-angle-right" aria-hidden="true"></span>
				</div>
				</div>
		</div>
	</div>
	</section>