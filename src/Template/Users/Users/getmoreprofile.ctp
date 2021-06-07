<?php
namespace Cake\I18n;
use Cake\I18n\Time;
if($tab == 'fantacy')
{
	if(count($itematas)>0)
	{
		foreach($itematas as $itemdata)
		{
		$image_name = $itemdata[photos][0]['image_name'];
		$itemid = base64_encode($itemdata->id."_".rand(1,9999));
				$item_title = $itemdata['item_title'];
				$item_title_url = $itemdata['item_title_url'];
				$item_price = $itemdata['price'];
				$favorte_count = $itemdata['fav_count'];
				$username = $itemdata['user']['username'];
				$currencysymbol = $itemdata['forexrate']['currency_symbol'];
				$items_image = $itemdata['photos'][0]['image_name'];
				$dealprice = $item_price * ( 1 - $itemdata['discount'] / 100 );


					$itemprice = $itemdata['price'];

$user_currency_price =  $currencycomponent->conversion($itemdata['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

				echo '<span id="figcaption_titles'.$itemdata['id'].'" figcaption_title ="'.$item_title.'" ></span>';
				echo  '<span class="figcaption" id="figcaption_title_url'.$itemdata['id'].'" figcaption_url ="'.$item_title_url.'" style="position: relative; top: 10px; left: 7px;display:none;" >'.$item_title_url.'</span>';
				echo '<span id="price_vals'.$itemdata['id'].'" price_val="'.$currencysymbol.$item_price.'" ></span>';
				echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$itemdata['id'].'" usernameval ="'.$username.'"></a>';
				echo '<span id="img_'.$itemdata['id'].'" class="nodisply">'.SITE_URL.'media/items/original/'.$items_image.'</span>';
				echo '<span class="fav_count" id="fav_count'.$itemdata['id'].'" fav_counts ="'.$favorte_count.'" ></span>';

						$item_image = $itemdata['photos'][0]['image_name'];
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

		echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
		<figure class="animate-boxs">
				<a class="img-hover1 fh5co-board-img" href="'.$baseurl.'listing/'.$itemid.'">
				<div class="bg_product">
					<img src="'.$itemimage.'" class="img-responsive" />
					</div>
				</a>

			<div class="hover-visible">
				<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou('.$itemdata['id'].')">';

		foreach($itemdata['itemfavs'] as $useritemfav){
			if($useritemfav['user_id'] == $userid ){
				$usecoun[] = $useritemfav['item_id'];
			}
		}
		if(isset($usecoun) &&  in_array($itemdata['id'],$usecoun)){
			/*echo '<i class="fa fa-heart like-icon'.$itemdata['id'].'"></i>*/
			echo '<img src="'.SITE_URL.'images/icons/liked-w.png" id="like-icon'.$itemdata['id'].'" class="like-icon'.$itemdata['id'].'">
				<span class="like-txt'.$itemdata['id'].' nodisply">'.$setngs['liked_btn_cmnt'].'</span>';
		}
		else
		{
			/*echo '<i class="fa fa-heart-o like-icon'.$itemdata['id'].'"></i>*/
			echo '<img src="'.SITE_URL.'images/icons/heart_icon.png" id="like-icon'.$itemdata['id'].'" class="like-icon'.$itemdata['id'].'">
				<span class="like-txt'.$itemdata['id'].' nodisply">'.$setngs['like_btn_cmnt'].'</span>';
		}



				echo '</span>
				<span class="hover-icon-cnt share_hover" href="javascript:void(0)" onclick="share_posts('.$itemdata['id'].')" data-toggle="modal" data-target="#share-modal"><img src="'.SITE_URL.'images/icons/share_icon.png"></span>
			</div>
	</figure>
				<div class="rate_section padding-left0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="product_name bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="">'.$itemdata->item_title.'</a><br/>';


						$date = date('d');
					$month = date('m');
					$year = date('y');
					$tdy = strtotime($month . '/' . $date . '/' . $year);
					$newdate = new Time($itemdata['dealdate']);
					$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
					
					
						
			if($itemdata['dailydeal'] =='yes' && $dealdate == $tdy){
			echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

			
//

$dealprice = $itemprice * ( 1 - $itemdata['discount'] / 100 );

$user_currency_dealprice = $currencycomponent->conversion($itemdata['forexrate']['price'],$_SESSION['currency_value'],$dealprice);

 if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
					}
					else{?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
						echo $itemdata['forexrate']['currency_symbol'].' '.$dealprice;
				}
					echo ' ';
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$itemdata['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}
			
echo '</div>';}
else
{
	echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

	if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo $_SESSION['currency_symbol'].' '.$user_currency_price;
				}
					else{?>&#x200E;<?php
					echo $itemdata['forexrate']['currency_symbol'].' '.$itemprice;}
				
				echo '</div>';
}
						
					echo '</div>
				</div>
		</div>';
		}
	}
	else
	{
		echo 'false';
	}
}
else if($tab == 'lists')
{
	if(count($itemListsAll)>0)
	{
	foreach($itemListsAll as $list)
	{
		$lists_name = $list['lists'];
		$listimage = $userdetail['profile_image'];
		if($listimage == "")
			$listimage = "usrimg.jpg";
        echo '<div class="product_cnt col-lg-4 col-md-4 col-sm-6 col-xs-6 margin-bottom20">
				<a href="javascript:void(0);" onclick="show_lists('.$list->id.');" data-toggle="modal" data-target="#user_lists">
					<div class="img_list_tab" style="background-image:url('.SITE_URL.'media/avatars/original/'.$listimage.');background-repeat:no-repeat;">

					<div class="trans">
						<p class="text-center trans_text white-txt">'.$lists_name.'</p>
					</div>
					</div>
				</a>
					</div>';
	}
}
else{
	echo 'false';
}
}
else if($tab == 'followers')
{
	if(count($people_details)>0)
	{
foreach($people_details as $ppl){
			$profile_img = $ppl['profile_image'];
			if($profile_img == "")
				$profile_img = "usrimg.jpg";
                    echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
											<div class="user_follower_image1">
														<div class="user_follower_image" style="background-image:url('.SITE_URL.'media/avatars/original/'.$profile_img.');background-repeat:no-repeat;"></div>
													</div>
<div class="user_followers">
				<h4 class="margin-bottom0 extra_text_hide">'.$ppl['first_name'].'</h4>
				<p class="profile_text margin-bottom20 extra_text_hide">@'.$ppl['username'].'</p>';

						foreach($followerscnt as $flcnt){
							$followerscntid[] = $flcnt['user_id'];

						}

			if($userid != $ppl['id']){
			//print_r($ppls['User']['id']);echo "<=>".$loguser[0]['User']['id']."/";print_r($flwrcntid);
							/*if(in_array($ppls['User']['id'],$flwrcntid)  && isset($loguser[0]['User']['id']) ){
								$flw = false;
							}else {
							    $flw = true;
						        }*/
							if(in_array($ppl['id'],$followerscntid)  && isset($loguser['id']) ){
								$flw = false;
							}else {
							    $flw = true;
						        }
			if($flw)
			{
			echo '<span id="foll'.$ppl['id'].'"><div class="user_followers_butn btn">
				<a href="javascript:void(0);" onclick="getfollows('.$ppl['id'].')">'.__d('user','Follow').'</a></div></span>';
			}
			else
			{
			echo '<span id="unfoll'.$ppl['id'].'"><div class="btn user_unfollowers">
			<a href="javascript:void(0);" onclick="deletefollows('.$ppl['id'].')">'.__d('user','Unfollow').'</a></div></span>';
			}

			echo '<span id="changebtn'.$ppl['id'].'" ></span>';
			}
										echo '</div></div>';


					}
	}
	else
	{
		echo 'false';
	}
}
else if($tab == 'followings')
{
	if(count($people_details_for_following)>0)
	{
			foreach($people_details_for_following as $ppl){
			$profile_img = $ppl['profile_image'];
			if($profile_img == "")
				$profile_img = "usrimg.jpg";
                    echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20 following'.$ppl['id'].'">
											<div class="user_follower_image1">
														<div class="user_follower_image" style="background-image:url('.SITE_URL.'media/avatars/original/'.$profile_img.');background-repeat:no-repeat;"></div>
													</div>
											<div class="user_followers">
												<h4 class="margin-bottom0 extra_text_hide">'.$ppl['first_name'].'</h4>
												<p class="profile_text margin-bottom20 extra_text_hide">@'.$ppl['username'].'</p>';
						foreach($followerscnt as $flcnt){
							$followerscntid[] = $flcnt['user_id'];

						}

			if($userid != $ppl['id']){
			//print_r($ppls['User']['id']);echo "<=>".$loguser[0]['User']['id']."/";print_r($flwrcntid);
							/*if(in_array($ppls['User']['id'],$flwrcntid)  && isset($loguser[0]['User']['id']) ){
								$flw = false;
							}else {
							    $flw = true;
						        }*/
							if(in_array($ppl['id'],$followerscntid)  && isset($loguser['id']) ){
								$flw = false;
							}else {
							    $flw = true;
						        }
			if($flw)
			{
			echo '<span id="foll'.$ppl['id'].'"><div class="user_followers_butn btn">
				<a href="javascript:void(0);" onclick="getfollows('.$ppl['id'].')">'.__d('user','Follow').'</a></div></span>';
			}
			else
			{
			echo '<span id="unfoll'.$ppl['id'].'"><div class="btn user_unfollowers">
			<a href="javascript:void(0);" onclick="deletefollows('.$ppl['id'].')">'.__d('user','Unfollow').'</a></div></span>';
			}

			echo '<span id="changebtn'.$ppl['id'].'" ></span>';
			}
										echo '</div></div>';


					}
	}
	else
	{
		echo 'false';
	}
}
else if($tab == 'stores')
{
if(count($shopsdet)>0)
{

					foreach ($shopsdet as $shopdatas){  //print_r($shopdatas);
							$shop_name = $shopdatas['shop_name'];
							$shop_name_url = $shopdatas['shop_name_url'];
							$shop_img = $shopdatas['shop_image'];
							$merchant_name = $shopdatas['merchant_name'];
							$item_count = $shopdatas['item_count'];
							$shop_id = $shopdatas['id'];
							$shop_user_id = $shopdatas['user_id'];
							$follow_count = $shopdatas['follow_count'];
							$follow_shop = $shopdatas['follow_shop'];
										echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
											<div class="favourite_store">

											</div>
												<div class="user_favourite_image1 margin_top_40min">
														<div class="user_favourite_image"></div>
													</div>
											<div class="user_favourite">
												<h4 class="margin-bottom0 extra_text_hide">'.$shop_name.'</h4>
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
}
?>



