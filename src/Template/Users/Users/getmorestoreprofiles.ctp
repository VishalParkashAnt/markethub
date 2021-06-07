<?php
namespace Cake\I18n;
use Cake\I18n\Time;
if($tab == 'added')
{
	if(count($item_details)>0)
	{
	foreach($item_details as $item)
	{
		$itemid = base64_encode($item->id."_".rand(1,9999));


					$itemprice = $item['price'];

$user_currency_price =  $currencycomponent->conversion($item['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

		echo '<div class="product_cnt box_shadow_img col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
				<a class="img-hover" href="'.$baseurl.'listing/'.$itemid.'">
					<img src="'.$baseurl.'media/items/original/'.$item['photos'][0]['image_name'].'" class="img-responsive" />
			<div class="hover-visible">
				<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou('.$item['id'].')">
				<!--<i class="fa fa-heart-o like-icon'.$item['id'].'"></i>-->
				<img src="'.SITE_URL.'images/icons/heart_icon.png" id="like-icon'.$item['id'].'" class="like-icon'.$item['id'].'">
				<span class="like-txt'.$item['id'].' nodisply">'.$setngs['like_btn_cmnt'].'</span>
				</span>
				<span class="hover-icon-cnt share_hover" href="javascript:void(0)" onclick="share_posts('.$item['id'].')" data-toggle="modal" data-target="#share-modal"><img src="'.SITE_URL.'images/icons/share_icon.png"></span>
			</div>
				</a>


				<div class="rate_section padding-left0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="product_name bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="">'.$item['item_title_url'].'</a><br/>';
						$date = date('d');
					$month = date('m');
					$year = date('y');
					$tdy = strtotime($month . '/' . $date . '/' . $year);
					$newdate = new Time($item['dealdate']);
					$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);

					
					
						
			if($item['dailydeal'] =='yes' && $dealdate >= $tdy){
			echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

			
//

$dealprice = $itemprice * ( 1 - $item['discount'] / 100 );

$user_currency_dealprice = $currencycomponent->conversion($item['forexrate']['price'],$_SESSION['currency_value'],$dealprice);

 if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
					}
					else{?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
						echo $item['forexrate']['currency_symbol'].' '.$dealprice;
				}
					echo ' ';
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$item['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}
			
echo '</div>';}
else
{
	echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

	if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo $_SESSION['currency_symbol'].' '.$user_currency_price;
				}
					else{?>&#x200E;<?php
					echo $item['forexrate']['currency_symbol'].' '.$itemprice;}
				
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
else if($tab == 'news')
{
	if(count($postmessage)>0)
	{
		foreach($postmessage as $news)
		{
			$ldate = $news['cdate'];
			$from = $ldate;
			$now = 0;
		$txt = '';
		if($now==0) $now = time();
		$diff=$now-$from;
		$days=intval($diff/86400);
		$diff=$diff%86400;
		$hours=intval($diff/3600);
		$diff=$diff%3600;
		$minutes=intval($diff/60);

		if($days>1) $txt  .= " $days ".__d('user','days');
		else if ($days==1) $txt  .= " $days ".__d('user','day');

		if($days < 2){
			if($hours>1) $txt .= " $hours ".__d('user','hours');
			else if ($hours==1) $txt  .= " $hours ".__d('user','hour');

			if($hours < 3){
				if($minutes>1) $txt .= " $minutes ".__d('user','minutes');
				//else if ($minutes<1) $txt  .= " less than half minute";
				else if ($minutes==1) $txt  .= " $minutes ".__d('user','minute');
			}
		}

		if($txt=='') $txt = ' '. "5 ".__d('user','seconds');

											//echo "dsfds";
											//echo $this->Urlfriendly->txt_time_diff($ldate);
					echo '<div class="comment-row col-xs-12 col-sm-12 border_bottom_grey">

						<div class="comment-section">
								<div class="margin-top10 comment-txt">
								'.$news['message'].'
							</div>
							<div class="comment-edit-cnt col-lg-12 no-hor-padding">
								<p class="time_text">'.$txt.' '.__d('user','ago').'</p>
							</div>
						</div>
					</div>';
					}
	}
	else
	{
		echo 'false';
	}
}
else if($tab == 'followers')
{
	if(count($people_details)>0)
	{
				foreach($people_details as $ppls){
							$fullname = $ppls['first_name'];
							$user_nam = $ppls['username'];
							$user_nam_url = $ppls['username_url'];
							$user_first = $ppls['first_name'];
							$user_imges = $ppls['profile_image'];
						if(empty($user_imges)){
							$user_imges = "usrimg.jpg";
						}
									echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
											<div class="user_follower_image1">
														<div class="user_follower_image"></div>
													</div>
											<div class="user_followers">
												<h4 class="margin-bottom0 extra_text_hide">'.$fullname.'</h4>
												<p class="profile_text margin-bottom20 extra_text_hide">@'.$user_nam.'</p>';
            foreach($follow_user_count as $flcnt){
            	$flwrcntid[] = $flcnt['user_id'];
            }

			if($userid != $ppls['id']){
            	if(in_array($ppls['id'],$flwrcntid)  && isset($loguser['id']) ){
            		$flw = false;
            	}else{
            		$flw = true;
            	}
            	if($flw)
            	{
				echo '<span id="foll'.$ppls['id'].'"><div class="user_followers_butn btn">
				<a href="javascript:void(0);" onclick="getfollows('.$ppls['id'].')">'.__d('user','Follow').'</a></div></span>';
            	}
            	else
            	{
			echo '<span id="unfoll'.$ppls['id'].'"><div class="btn user_unfollowers">
			<a href="javascript:void(0);" onclick="deletefollows('.$ppls['id'].')">'.__d('user','Unfollow').'</a></div></span>';
			}
	echo '<span id="changebtn'.$ppls['id'].'" ></span>';
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
else if($tab == 'reviews')
{
if(count($reviews_added)>0)
{
		foreach($reviews_added as $reviews)
		{
					$prof_img = $reviews['user']['profile_image'];
					if(empty($prof_img)){
						$prof_img = "usrimg.jpg";
					}
					$usrname = $reviews["user"]["first_name"];
					$usrname_url = $reviews["user"]["username_url"];
					$rating = $reviews['ratings'];
					echo '<div class="comment-row col-xs-12 col-sm-12 border_bottom_grey">
						<div class="sold-by-prof-pic-cnt padding_right0_rtl col-xs-2 col-lg-1 padding-right0 padding-left0">
							<div class="review_prof_pic" style="background:url('.SITE_URL.'media/avatars/thumb70/'.$prof_img.')"></div>
						</div>
						<div class="comment-section col-xs-10 col-lg-11 padding-right0">
							<div class="bold-font txt-uppercase comment-name">'.$usrname.'</div>
							<p class="text_center_seller time_text">'.date('d M Y',strtotime($reviews['date'])).'</p>
							<div class="margin-top10 comment-txt">
								'.$reviews['reviews'].'
							</div>
							<div class="comment-edit-cnt col-lg-12 no-hor-padding margin-top10">
								<form id="ratingsForm">
										<div class="stars pull-left">
											<input type="radio" name="star" class="star-1" id="star-1" />
											<label class="star-1" for="star-1">1</label>
											<input type="radio" name="star" class="star-2" id="star-2" />
											<label class="star-2" for="star-2">2</label>
											<input type="radio" name="star" class="star-3" id="star-3" />
											<label class="star-3" for="star-3">3</label>
											<input type="radio" name="star" class="star-4" id="star-4" />
											<label class="star-4" for="star-4">4</label>
											<input type="radio" name="star" class="star-5" id="star-5" />
											<label class="star-5" for="star-5">5</label>
											<span></span>
										</div>
									</form>
							</div>
						</div>
					</div>';
		}

	}
	else
	{
		echo 'false';
	}
}
?>