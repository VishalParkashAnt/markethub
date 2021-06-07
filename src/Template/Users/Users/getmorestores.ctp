<?php
if(count($shopsdet)>0)
{
	foreach ($shopsdet as $shopdatas){
			$shop_name = $shopdatas['shop_name'];
			$shop_name_url = $shopdatas['shop_name_url'];
			$shop_img = $shopdatas['shop_image'];
			$shop_bannerimg = SITE_URL.'media/avatars/original/'.$shopdatas['shop_banner'];
			$merchant_name = $shopdatas['merchant_name'];
			$item_count = $shopdatas['item_count'];
			$shop_id = $shopdatas['id'];
			$shop_user_id = $shopdatas['user_id'];
			$follow_count = $shopdatas['follow_count'];
			$follow_shop = $shopdatas['follow_shop'];
							if($shop_name == "")
								$shop_name = $merchant_name;
							if($shop_img == "")
								$shop_img = "usrimg.jpg";
							if($shopdatas['shop_banner'] == "")
								$shop_bannerimg = SITE_URL.'images/banner_1.png';
						//echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">';
						echo '<div>
							<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
											<div class="favourite_store" style="background-image:url('.$shop_bannerimg.');background-repeat:no-repeat;">

							</div>
								<div class="user_favourite_image1 margin_top_40min">
														<div class="user_favourite_image" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$shop_img.');background-repeat:no-repeat;"></div>
													</div>
							<div class="user_favourite">
								<h4 class="margin-bottom0 extra_text_hide">
												<a href="'.SITE_URL.'stores/'.$shop_name_url.'">'.$shop_name.'</a></h4>
								<p class="profile_text margin-bottom20 extra_text_hide">'.__d('user','By').' '.$merchant_name.'</p>';
foreach($followcnt as $flcnt){
$flwrcntid[] = $flcnt['store_id'];
}

if($shop_id != $loguser['id']){
if(in_array($shop_id,$flwrcntid)  && isset($loguser['id']) ){
	$flw = false;
}else{
	$flw = true;
}
if($flw)
{
echo '<span id="folls'.$shop_id.'"><div class="user_followers_butn btn">
<a href="javascript:void(0);" onclick="getshopfollows('.$shop_id.')">'.__d('user','Follow Store').'</a></div></span>';
}
else
{
echo '<span id="unfolls'.$shop_id.'"><div class="btn user_unfollowers">
<a href="javascript:void(0);" onclick="deleteshopfollows('.$shop_id.')">'.__d('user','Unfollow Store').'</a></div></span>';
}
echo '<span id="changebtnn'.$shop_id.'" ></span>';
}
							echo '</div>
						</div>';
						}
}
else
{
echo 'false';
}
						?>