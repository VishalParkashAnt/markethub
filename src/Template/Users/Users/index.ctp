<?php
namespace Cake\I18n;
use Cake\Routing\Router;
use Cake\I18n\Time;
$baseurl = Router::url('/');
?>
<section class="container">
	<div class="container default-home-header row margin_top165_mobile">
		<ul class="nav nav-pills home-page-tab col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<li class="active"><a class="bold-font" data-toggle="pill" onclick="setindex();" href="#dailydealspdt"><?php echo __d('user','Daily Deals');?></a></li>
			<li class=""><a class="bold-font" data-toggle="pill" onclick="setindex();" href="#popularpdt"><?php echo __d('user','Popular Products');?></a></li>
			<li class=""><a class="bold-font" data-toggle="pill" onclick="setindex();" href="#arrivalpdt"><?php echo __d('user','New Arrivals');?></a></li>
			<li class=""><a class="bold-font" data-toggle="pill" onclick="setindex();" href="#featured"><?php echo __d('user','Featured');?></a></li>
		</ul>
	</div>
			<?php	date_default_timezone_set("Asia/KolKata");
				$date = date('d');
				$month = date('m');
				$year = date('Y');
				$today = $month.'/'.$date.'/'.$year;
				$date1 = date('Y-m-d H:i:s');
				$date2 = date("Y-m-d", strtotime($today)).' 24:00:00';
				$diff = abs(strtotime($date2) - strtotime($date1));

				$hours = floor(($diff % 86400) / 3600);
				$mins = floor(($diff % 86400 % 3600) / 60);
				$sec = ($diff % 60);

				?>
				<script type="text/javascript">
				// Initialize the Date object.
				//  The set methods should be filled in by PHP

				var _date = new Date();
				_date.setHours(<?php echo $hours; ?>);
				_date.setMinutes(<?php echo $mins; ?>);
				_date.setSeconds(<?php echo $sec; ?>);

				// Generates a HH:MM:SS string
				function parseDate(dateObj) {
				  var output = "";
				  if(dateObj.getHours() < 10) {
				      output += "";
				  }
				  output += dateObj.getHours() + ":";

				  if(dateObj.getMinutes() < 10) {
				   output += "0";
				  }
				  output += dateObj.getMinutes() + ":";

				  if(dateObj.getSeconds() < 10) {
				   output += "0";
				  }
				  output += dateObj.getSeconds();
				 // console.log(output);
				  return output;
				}

				// Start the countdown
				setInterval(function() {
				    _date.setSeconds(_date.getSeconds() - 1);
				    document.getElementById('timer').innerHTML = parseDate(_date);
				}, 1000);
				 </script>
<div class="tab-content container section_container row">
		<div id="dailydealspdt" class="tab-pane fade in active">
			<!--Staggered Grid-->
			<div class="slider section_container">
				<div class="col-xs-12 col-sm-12 no-hor-padding default-page-timer-cnt">
					<h2 class="section_heading bold-font centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom5 padding-top10 padding-top20"><?php echo __d('user','Daily Deals');?></h2>
					<?php if(count($dailydeals)>0) { ?>
					<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom10"><span class="primary-color-txt font-size12" href=""><?php echo count($dailydeals);?> <?php echo __d('user','products');?></span></div>

					<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom20"><div class="timer-cnt"><img src="<?php echo SITE_URL.'images/icons/timer.png';?>"><span class="time bold-font " id="timer"></span></div></div>
					<?php } else { ?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding stream">
								<div class="text-center padding-top30 padding-bottom30">
	 								<div class="outer_no_div">
	  									<div class="empty-icon no_products_icon"></div>
	 								</div>
	 									<h5>No Products</h5>
	 									<span id="timer" style="display:none;"></span>
									</div>
							</div>
						<?php } ?>
				</div>
<input type="hidden" value="20" id="dailydealspdt_sindex">
<input type="hidden" value="20" id="dailydealspdt_offset">
<input type="hidden" value="true" id="dailydealspdt_event">
<input type="hidden" value="true" id="dailydealspdt_data">
<input type="hidden" value="0" id="dailydealspdt_scroll">


				<div class="">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						  <!-- Bottom to top-->
						  <div class="row product_align_cnt">
							<div id="fh5co-main">
								<div id="fh5co-board" class="dailydealspdt_stream" data-columns>
								<?php
									if(isset($loguser['id']))
									echo '<input type="hidden" id="loguserid" value="'.$loguser['id'].'">';
								else
									echo '<input type="hidden" id="loguserid" value="0">';

												echo '<input type="hidden" id="likebtncnt" value="'.$setngs['like_btn_cmnt'].'" />';
												echo '<input type="hidden" id="likedbtncnt" value="'.$setngs['liked_btn_cmnt'].'" />';
								foreach($dailydeals as $deals)
								{
								$itemid = base64_encode($deals->id."_".rand(1,9999));
				$item_title = $deals['item_title'];
				$item_title_url = $deals['item_title_url'];
				$item_price = $deals['price'];
				$favorte_count = $deals['fav_count'];
				$username = $deals['user']['username'];
				$currencysymbol = $deals['forexrate']['currency_symbol'];
				$items_image = $deals['photos'][0]['image_name'];



					$itemprice = $deals['price'];
				$dealprice = $itemprice * ( 1 - $deals['discount'] / 100 );

$user_currency_price =  $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$itemprice);
$user_currency_dealprice = $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$dealprice);

				echo '<span id="figcaption_titles'.$deals['id'].'" figcaption_title ="'.$item_title.'" ></span>';
				echo  '<span class="figcaption" id="figcaption_title_url'.$deals['id'].'" figcaption_url ="'.$item_title_url.'" style="position: relative; top: 10px; left: 7px;display:none;" >'.$item_title_url.'</span>';
				
				echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$deals['id'].'" usernameval ="'.$username.'"></a>';
				echo '<span id="img_'.$deals['id'].'" class="nodisply">'.SITE_URL.'media/items/original/'.$items_image.'</span>';
				echo '<span class="fav_count" id="fav_count'.$deals['id'].'" fav_counts ="'.$favorte_count.'" ></span>';
									?>

									<div class="item">
										<div class="grid cs-style-3 no-hor-padding">
											<div class="image-grid col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<div><figure class="animate-box">
			<?php
				echo '<a href="'.$baseurl.'listing/'.$itemid.'" class="fh5co-board-img">';
						$item_image = $deals['photos'][0]['image_name'];
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
				?>
														<img class="img-responsive" src="<?php echo $itemimage;?>" alt="img">

													</a>
	<div class="hover-visible">
		<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou(<?php echo $deals['id'];?>)">
					<?php	
					if(count($likeditemid)!=0 &&  in_array($deals['id'],$likeditemid)){
							/*echo 	'<i class="fa fa-heart like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
				echo '<img src="'.SITE_URL.'images/icons/liked-w.png" id="like-icon'.$deals['id'].'" class="like-icon'.$deals['id'].'">
								<span class="like-txt'.$deals['id'].' nodisply" id="like-txt'.$deals['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';}
								else
								{
				/*echo 	'<i class="fa fa-heart-o like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
			echo '<img src="'.SITE_URL.'images/icons/heart_icon.png" id="like-icon'.$deals['id'].'" class="like-icon'.$deals['id'].'">
												<span class="like-txt'.$deals['id'].' nodisply" id="like-txt'.$deals['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';
								}
								?>
		</span>
		<span class="hover-icon-cnt share_hover cur" onclick="share_posts(<?php echo $deals['id'];?>);" href="javascript:void(0)" data-toggle="modal" data-target="#share-modal"><img src="<?php echo $baseurl;?>images/icons/share_icon.png"></span>
	</div>
												</figure></div>
												<div class="rate_section bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<div class="product_name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<a href=""><?php echo $deals->item_title;?></a></div>
														<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">






		<?php if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
					}
					else{?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
						echo $deal['forexrate']['currency_symbol'].' '.$dealprice;
				}
					echo ' ';
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$deal['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}?>
			









															
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>



								</div>
							</div>
						  </div>
						  <!-- end Bottom to top-->
					</div>
				</div>
			</div>
		<!--Staggered Grid-->
		</div>

		<div id="arrivalpdt" class="tab-pane fade">
			<!--Staggered Grid-->
			<div class="slider section_container">
				<div class="col-xs-12 col-sm-12 no-hor-padding default-page-timer-cnt">
					<h2 class="section_heading bold-font centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom5 padding-top10 padding-top20"><?php echo __d('user','New Arrivals');?></h2>
					<!--div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom20"><div class="timer-cnt"><img src="images/icons/timer.png"><span class="time bold-font ">12:08:06 Left</span></div></div-->
				</div>
<input type="hidden" value="20" id="arrivalpdt_sindex">
<input type="hidden" value="20" id="arrivalpdt_offset">
<input type="hidden" value="true" id="arrivalpdt_event">
<input type="hidden" value="true" id="arrivalpdt_data">
<input type="hidden" value="0" id="arrivalpdt_scroll">
				<div class="">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						  <!-- Bottom to top-->
						  <div class="row product_align_cnt">
							<div id="fh5co-main">
								<div id="fh5co-board" class="arrivalpdt_stream" data-columns>
					<?php
					foreach($new_products as $deals)
					{
						$itemid = base64_encode($deals->id."_".rand(1,9999));

				$item_title = $deals['item_title'];
				$item_title_url = $deals['item_title_url'];
				$item_price = $deals['price'];
				$favorte_count = $deals['fav_count'];
				$username = $deals['user']['username'];
				$currencysymbol = $deals['forexrate']['currency_symbol'];
				$items_image = $deals['photos'][0]['image_name'];

				$dealprice = $deals['price'] * ( 1 - $deals['discount'] / 100 );


					$itemprice = $deals['price'];

$user_currency_price =  $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

				echo '<span id="figcaption_titles'.$deals['id'].'" figcaption_title ="'.$item_title.'" ></span>';
				echo  '<span class="figcaption" id="figcaption_title_url'.$deals['id'].'" figcaption_url ="'.$item_title_url.'" style="position: relative; top: 10px; left: 7px;display:none;" >'.$item_title_url.'</span>';
				echo '<span id="price_vals'.$deals['id'].'" price_val="'.$_SESSION['currency_symbol'].$dealprice.'" ></span>';
				echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$deals['id'].'" usernameval ="'.$username.'"></a>';
				echo '<span id="img_'.$deals['id'].'" class="nodisply">'.SITE_URL.'media/items/original/'.$items_image.'</span>';
				echo '<span class="fav_count" id="fav_count'.$deals['id'].'" fav_counts ="'.$favorte_count.'" ></span>';

						$item_image = $deals['photos'][0]['image_name'];
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

						?>

									<div class="item">
										<div class="grid cs-style-3 no-hor-padding">
											<div class="image-grid col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<div><figure class="animate-box">
													<a href="<?php echo $baseurl.'listing/'.$itemid;?>" class="fh5co-board-img">
														<img class="img-responsive" src="<?php echo $itemimage;?>" alt="img">

													</a>
	<div class="hover-visible">
		<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou(<?php echo $deals['id'];?>)">
			<?php	
					if(count($likeditemid)!=0 &&  in_array($deals['id'],$likeditemid)){
							/*echo 	'<i class="fa fa-heart like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
							echo '<img src="'.SITE_URL.'images/icons/liked-w.png" id="like-icon'.$deals['id'].'" class="like-icon'.$deals['id'].'">
								<span class="like-txt'.$deals['id'].' nodisply" id="like-txt'.$deals['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';}
								else
								{
			/*	echo 	'<i class="fa fa-heart-o like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
			echo '<img src="'.SITE_URL.'images/icons/heart_icon.png" id="like-icon'.$deals['id'].'" class="like-icon'.$deals['id'].'">
												<span class="like-txt'.$deals['id'].' nodisply" id="like-txt'.$deals['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';
								}
								?>
		</span>
		<span class="hover-icon-cnt share_hover cur" onclick="share_posts(<?php echo $deals['id'];?>)" href="javascript:void(0)" data-toggle="modal" data-target="#share-modal"><img src="<?php echo $baseurl;?>images/icons/share_icon.png"></span>
	</div>
												</figure></div>
												<div class="rate_section bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<div class="product_name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<a href=""><?php echo $deals->item_title;?></a></div>
													<?php


													$date = date('d');
					$month = date('m');
					$year = date('y');
					$tdy = strtotime($month . '/' . $date . '/' . $year);
					$newdate = new Time($deals['dealdate']);
					$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
					
						
			if($deals['dailydeal'] =='yes' && $dealdate >= $tdy){
			echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

			
//

$dealprice = $itemprice * ( 1 - $deals['discount'] / 100 );

$user_currency_dealprice = $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$dealprice);

 if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
					}
					else{?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
						echo $deals['forexrate']['currency_symbol'].' '.$dealprice;
				}
					echo ' ';
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$deals['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}
			
echo '</div>';}
else
{
	echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

	if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo $_SESSION['currency_symbol'].' '.$user_currency_price;
				}
					else{?>&#x200E;<?php
					echo $deals['forexrate']['currency_symbol'].' '.$itemprice;}
				
				echo '</div>';
}
		
?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>



								</div>
							</div>
						  </div>
						  <!-- end Bottom to top-->
					</div>
				</div>
			</div>
		<!--Staggered Grid-->
		</div>

		<div id="popularpdt" class="tab-pane fade">
			<!--Staggered Grid-->
			<div class="slider section_container">
				<div class="col-xs-12 col-sm-12 no-hor-padding default-page-timer-cnt">
					<h2 class="section_heading bold-font centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom5 padding-top10 padding-top20"><?php echo __d('user',
					'Popular Products');?></h2>
					<!--div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom20"><div class="timer-cnt"><img src="images/icons/timer.png"><span class="time bold-font ">12:08:06 Left</span></div></div-->
				</div>
<input type="hidden" value="20" id="popularpdt_sindex">
<input type="hidden" value="20" id="popularpdt_offset">
<input type="hidden" value="true" id="popularpdt_event">
<input type="hidden" value="true" id="popularpdt_data">
<input type="hidden" value="0" id="popularpdt_scroll">
				<div class="">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						  <!-- Bottom to top-->
						  <div class="row product_align_cnt">
							<div id="fh5co-main">
								<div id="fh5co-board" class="popularpdt_stream" data-columns>
								<?php
								foreach($popular_products as $deals)
								{
									$itemid = base64_encode($deals->id."_".rand(1,9999));

				$item_title = $deals['item_title'];
				$item_title_url = $deals['item_title_url'];
				$item_price = $deals['price'];
				$favorte_count = $deals['fav_count'];
				$username = $deals['user']['username'];
				$currencysymbol = $deals['forexrate']['currency_symbol'];
				$items_image = $deals['photos'][0]['image_name'];


					$itemprice = $deals['price'];

		$user_currency_price =  $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

				echo '<span id="figcaption_titles'.$deals['id'].'" figcaption_title ="'.$item_title.'" ></span>';
				echo  '<span class="figcaption" id="figcaption_title_url'.$deals['id'].'" figcaption_url ="'.$item_title_url.'" style="position: relative; top: 10px; left: 7px;display:none;" >'.$item_title_url.'</span>';
				echo '<span id="price_vals'.$deals['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_price.'" ></span>';
				echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$deals['id'].'" usernameval ="'.$username.'"></a>';
				echo '<span id="img_'.$deals['id'].'" class="nodisply">'.SITE_URL.'media/items/original/'.$items_image.'</span>';
				echo '<span class="fav_count" id="fav_count'.$deals['id'].'" fav_counts ="'.$favorte_count.'" ></span>';

						$item_image = $deals['photos'][0]['image_name'];
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

						?>

									<div class="item">
										<div class="grid cs-style-3 no-hor-padding">
											<div class="image-grid col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<div><figure class="animate-box">
													<a href="<?php echo $baseurl.'listing/'.$itemid;?>" class="fh5co-board-img">
														<img class="img-responsive" src="<?php echo $itemimage;?>" alt="img">

													</a>
	<div class="hover-visible">
		<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou(<?php echo $deals['id'];?>)">
			<?php	
					if(count($likeditemid)!=0 &&  in_array($deals['id'],$likeditemid)){
							/*echo 	'<i class="fa fa-heart like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
							echo '<img src="'.SITE_URL.'images/icons/liked-w.png" id="like-icon'.$deals['id'].'" class="like-icon'.$deals['id'].'">
								<span class="like-txt'.$deals['id'].' nodisply" id="like-txt'.$deals['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';}
								else
								{
				/*echo 	'<i class="fa fa-heart-o like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
				echo '<img src="'.SITE_URL.'images/icons/heart_icon.png" id="like-icon'.$deals['id'].'" class="like-icon'.$deals['id'].'">
												<span class="like-txt'.$deals['id'].' nodisply" id="like-txt'.$deals['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';
								}
								?>
		</span>
		<span class="hover-icon-cnt share_hover cur" onclick="share_posts(<?php echo $deals['id'];?>)" href="javascript:void(0)" data-toggle="modal" data-target="#share-modal"><img src="<?php echo $baseurl;?>images/icons/share_icon.png"></span>
	</div>
												</figure></div>
												<div class="rate_section bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<div class="product_name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<a href=""><?php echo $deals->item_title;?></a></div>
														<?php


												$date = date('d');
					$month = date('m');
					$year = date('y');
					$tdy = strtotime($month . '/' . $date . '/' . $year);
					$newdatee = new Time($deals['dealdate']);
					$dealdatee = $newdatee->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
						
			if($deals['dailydeal'] =='yes' && $dealdatee >= $tdy){
			echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

			
//

$dealprice = $itemprice * ( 1 - $deals['discount'] / 100 );

$user_currency_dealprice = $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$dealprice);

 if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
					}
					else{?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
						echo $deals['forexrate']['currency_symbol'].' '.$dealprice;
				}
					echo ' ';
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$deals['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}
			
echo '</div>';}
else
{
	echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

	if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo $_SESSION['currency_symbol'].' '.$user_currency_price;
				}
					else{?>&#x200E;<?php
					echo $deals['forexrate']['currency_symbol'].' '.$itemprice;}
				
				echo '</div>';
}
		
?>
							
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>



								</div>
							</div>
						  </div>
						  <!-- end Bottom to top-->
					</div>
				</div>
			</div>
		<!--Staggered Grid-->
		</div>
		<div id="featured" class="tab-pane fade">
			<!--Staggered Grid-->
			<div class="slider section_container">
				<div class="col-xs-12 col-sm-12 no-hor-padding default-page-timer-cnt">
					<h2 class="section_heading bold-font centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom5 padding-top10 padding-top20"><?php echo __d('user','Featured Products');?></h2>
					<!--div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom20"><div class="timer-cnt"><img src="images/icons/timer.png"><span class="time bold-font ">12:08:06 Left</span></div></div-->
				</div>
<input type="hidden" value="20" id="featured_sindex">
<input type="hidden" value="20" id="featured_offset">
<input type="hidden" value="true" id="featured_event">
<input type="hidden" value="true" id="featured_data">
<input type="hidden" value="0" id="featured_scroll">
				<div class="">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						  <!-- Bottom to top-->
						  <div class="row product_align_cnt">
							<div id="fh5co-main">
								<div id="fh5co-board" class="featured_stream" data-columns>
								<?php
								foreach($featured as $deals)
								{
									$itemid = base64_encode($deals->id."_".rand(1,9999));

				$item_title = $deals['item_title'];
				$item_title_url = $deals['item_title_url'];
				$item_price = $deals['price'];
				$favorte_count = $deals['fav_count'];
				$username = $deals['user']['username'];
				$currencysymbol = $deals['forexrate']['currency_symbol'];
				$items_image = $deals['photos'][0]['image_name'];


					$itemprice = $deals['price'];

$user_currency_price =  $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

				echo '<span id="figcaption_titles'.$deals['id'].'" figcaption_title ="'.$item_title.'" ></span>';
				echo  '<span class="figcaption" id="figcaption_title_url'.$deals['id'].'" figcaption_url ="'.$item_title_url.'" style="position: relative; top: 10px; left: 7px;display:none;" >'.$item_title_url.'</span>';
				echo '<span id="price_vals'.$deals['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_price.'" ></span>';
				echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$deals['id'].'" usernameval ="'.$username.'"></a>';
				echo '<span id="img_'.$deals['id'].'" class="nodisply">'.SITE_URL.'media/items/original/'.$items_image.'</span>';
				echo '<span class="fav_count" id="fav_count'.$deals['id'].'" fav_counts ="'.$favorte_count.'" ></span>';

						$item_image = $deals['photos'][0]['image_name'];
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
									?>

									<div class="item">
										<div class="grid cs-style-3 no-hor-padding">
											<div class="image-grid col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<div><figure class="animate-box">
													<a href="<?php echo $baseurl.'listing/'.$itemid;?>" class="fh5co-board-img">
														<img class="img-responsive" src="<?php echo $itemimage;?>" alt="img">

													</a>
	<div class="hover-visible">
		<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou(<?php echo $deals['id'];?>)">
			<?php	
					if(count($likeditemid)!=0 &&  in_array($deals['id'],$likeditemid)){
							/*echo 	'<i class="fa fa-heart like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
							echo '<img src="'.SITE_URL.'images/icons/liked-w.png" id="like-icon'.$deals['id'].'" class="like-icon'.$deals['id'].'">
								<span class="like-txt'.$deals['id'].' nodisply" id="like-txt'.$deals['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';}
								else
								{
				/*echo 	'<i class="fa fa-heart-o like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
				echo '<img src="'.SITE_URL.'images/icons/heart_icon.png" id="like-icon'.$deals['id'].'" class="like-icon'.$deals['id'].'">
												<span class="like-txt'.$deals['id'].' nodisply" id="like-txt'.$deals['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';
								}
								?>
		</span>
		<span class="hover-icon-cnt share_hover cur" onclick="share_posts(<?php echo $deals['id'];?>)" href="javascript:void(0)" data-toggle="modal" data-target="#share-modal"><img src="<?php echo $baseurl;?>images/icons/share_icon.png"></span>
	</div>
												</figure></div>
												<div class="rate_section bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<div class="product_name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<a href=""><?php echo $deals->item_title;?></a></div>
														<?php


													$date = date('d');
					$month = date('m');
					$year = date('y');
					$tdy = strtotime($month . '/' . $date . '/' . $year);
					$newdate1 = new Time($deals['dealdate']);
					$dealdate1 = $newdate1->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
					
						
			if($deals['dailydeal'] =='yes' && $dealdate1 >= $tdy){
			echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

			
//

$dealprice = $itemprice * ( 1 - $deals['discount'] / 100 );

$user_currency_dealprice = $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$dealprice);

 if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
					}
					else{?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
						echo $deals['forexrate']['currency_symbol'].' '.$dealprice;
				}
					echo ' ';
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$deals['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}
			
echo '</div>';}
else
{
	echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

	if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo $_SESSION['currency_symbol'].' '.$user_currency_price;
				}
					else{?>&#x200E;<?php
					echo $deals['forexrate']['currency_symbol'].' '.$itemprice;}
				
				echo '</div>';
}
		
?>
							
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>



								</div>
							</div>
						  </div>
						  <!-- end Bottom to top-->
					</div>
				</div>
			</div>
		<!--Staggered Grid-->
		</div>

</div>
</section>

<?php
if(isset($loguser['id']))
	echo '<input type="hidden" id="loguserid" value="'.$loguser['id'].'">';
else
	echo '<input type="hidden" id="loguserid" value="0">';

				echo '<input type="hidden" id="likebtncnt" value="'.$setngs['like_btn_cmnt'].'" />';
				echo '<input type="hidden" id="likedbtncnt" value="'.$setngs['liked_btn_cmnt'].'" />';
?>

	<!-- Share Modal -->
	<div id="share-modal" class="modal fade" role="dialog">
	  <div class="modal-dialog downloadapp-modal">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-body">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<div class="share-container margin-bottom20">
				<div class="share-cnt-row">
					<h2 class="bold-font text-center"><?php echo __d('user','SHARE THIS THING');?> Test</h2>
					<div class="popup-heading-border"></div>
				</div>
				<div class="share-cnt-row">
					<div class="share-details-cnt margin-top30">

					<?php
						echo '<div class="share-details">
							<div class="share-img margin-right20"><img id="share_img" class="img-responsive" src=""></div>
							<div class="share-details-txt">
								<div class="bold-font" id="share_title"></div>
								<div class="">'.__d('user','By').' <span id="share_username"></span></div>
								<div class="bold-font margin-top20" id="share_price"></div>
							</div>
						</div>';
					?>

					</div>
				</div>
				<div class="share-cnt-row">
					<div class="share-details-cnt margin-top30 share-icons-cnt padding-top20 padding-bottom20">
						<div class="share-details margin-top10 margin-bottom10">
							<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-facebook-official facebook" target="_blank"></a>
							<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-twitter-square twitter" target="_blank"></a>
							<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa  fa-google-plus-square google" target="_blank"></a>
							<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-linkedin-square linkedin" target="_blank"></a>
							<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');" class="share-icons fa fa-stumbleupon stumbleupon" target="_blank"></a>
							<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-tumblr-square tumblr" target="_blank"></a>
						</div>
					</div>
				</div>
				<!--div class="share-cnt-row">
					<div class="share-details-cnt margin-top30">
						<a href="" class="share-popup-btn btn primary-color-bg bold-font">CANCEL</a>
					</div>
				</div-->
			</div>
		  </div>
		</div>

	  </div>
	</div>
	<!-- Share modal -->

<script type="text/javascript">
var followid = 0;
var baseurl = getBaseURL();
var scrollevent;
var sIndex;var offSet;var isPreviousEventComplete;var isDataAvailable;
$(window).scroll(function () {
	loadmoretab = $(".tab-pane.fade.in.active").attr('id');
scrollevent = $("#"+loadmoretab+"_scroll").val();
	//console.log(loadmoretab);
 //if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
	if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.5) {
		if(scrollevent == "0")
		{
				sIndex = $("#"+loadmoretab+"_sindex").val();
				offSet = $("#"+loadmoretab+"_offset").val();
				isPreviousEventComplete = $("#"+loadmoretab+"_event").val();
				isDataAvailable = $("#"+loadmoretab+"_data").val();
		}
		else
		{
			$("#"+loadmoretab+"_scroll").val("1");
		}
		$("#"+loadmoretab+"_scroll").val("1");
  if (isPreviousEventComplete && isDataAvailable) {

    isPreviousEventComplete = false;
    $(".LoaderImage").css("display", "block");

    $.ajax({
      type: "GET",
      url: baseurl+'getMorePosts?startIndex=' + sIndex + '&offset=' + offSet + '&followid='+followid+'&loadmoretab='+loadmoretab,
      beforeSend: function () {
			$('#infscr-loading').show();
		},
	  dataType: 'html',
      success: function (result) {
      	$('#infscr-loading').hide();
      	var response = $.trim(result.toString());
      	var splitresponse=response.split("~|~");
		if ($.trim(response) != 'false') {
			//When data is not available
	        //$("."+loadmoretab+"_stream").append(result);
			var grid = document.querySelector("."+loadmoretab+"_stream");
			for(var i = 0; i < splitresponse.length; i++){
				var item = document.createElement('div');
				salvattore.appendElements(grid, [item]);
				item.outerHTML = splitresponse[i];
			}

        }else {
            isDataAvailable = false;
		}
        sIndex = parseInt(sIndex) + parseInt(offSet);
        isPreviousEventComplete = true;
      }
    });

  }
 }
 });

function setindex()
{
	var sIndex = 20, offSet = 10, isPreviousEventComplete = true, isDataAvailable = true;
}
	</script>
