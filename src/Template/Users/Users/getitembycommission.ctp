<?php
use Cake\I18n\Time;
//echo $item_count;die;
if ($item_count > 0) {
	if (isset($loguser['id']))
		echo '<input type="hidden" id="loguserid" value="' . $loguser['id'] . '">';
	else
		echo '<input type="hidden" id="loguserid" value="0">';

	echo '<input type="hidden" id="likebtncnt" value="' . $setngs['like_btn_cmnt'] . '" />';
	echo '<input type="hidden" id="likedbtncnt" value="' . $setngs['liked_btn_cmnt'] . '" />';
	//	print_r($itemdata);die;
	
		foreach ($itemdata as $itms) {
			$itm_id = $itms['id'];
			$item_title_url = $itms['item_title_url'];
			$item_title = $itms['item_title'];
			$image_name = $itms['photos'][0]['image_name'];
			$price = $itms['price'];
			$user_id = $itms['user_id'];
			$item_price = $itms['price'];
			$item_default_price = round($itms['price'] * $itms['forexrate']['price'], 2);
			$itemid = base64_encode($itm_id . "_" . rand(1, 9999));
						//$item_title = UrlfriendlyComponent::limit_char($item_title,12);

			$item_price = $itms['price'];
			$favorte_count = $itms['fav_count'];
			$username = $itms['user']['username'];
			$currencysymbol = $itms['forexrate']['currency_symbol'];
			$items_image = $itms['photos'][0]['image_name'];
			$item_image = $itms['photos'][0]['image_name'];
			if ($item_image == "") {
				$itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
			} else {
				$itemimage = WWW_ROOT . 'media/items/original/' . $item_image;
				/*$header_response = get_headers($itemimage, 1);*/
				if (file_exists($itemimage)) {
					$itemimage = SITE_URL . 'media/items/original/' . $item_image;
				} else {
					$itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
				}
			}


			$itemprice = $itms['price'];
			$user_currency_price = $currencycomponent->conversion($itms['forexrate']['price'], $_SESSION['currency_value'], $itemprice);

			if (isset($itms['photos'][0])) {
				$image_name = $itms['photos'][0]['image_name'];
			} else {
				$image_name = "usrimg.jpg";
			}
			$shopname_url = $itms['shop']['shop_image'];
			$username_url = $itms['user']['profile_image'];
			if ($shopname_url == '') {
				$shopname_url = 'usrimg.jpg';
			}
			if ($username_url == '') {
				$username_url = 'usrimg.jpg';
			}
			$user_level = $itms['user']['user_level'];
			$username = $itms['user']['username'];
			$sellername = $itms['shop']['shop_name'];
			$sellername_id = $itms['shop']['user_id'];
			$sellername_url_ori = $itms['shop']['shop_name_url'];

			$username_url_ori = $itms['user']['username_url'];
			$favorte_count = $itms['fav_count'];

			$item_price = $itms['price'];
			$item_default_price = round($item_price * $itms['forexrate']['price'], 2);
			$size_options = $itms['size_options'];
			$sizeoptions = json_decode($size_options, true);
			if (!empty($sizeoptions['size'])) {
				$item_price = reset($sizeoptions['price']);
				$item_default_price = round(reset($sizeoptions['price']) * $itms['Forexrates']['price'], 2);
			}


			echo '<span id="figcaption_titles' . $itms['id'] . '" figcaption_title ="' . $item_title . '" ></span>';
			echo '<span class="figcaption" id="figcaption_title_url' . $itms['id'] . '" figcaption_url ="' . $item_title_url . '" style="position: relative; top: 10px; left: 7px;display:none;" >' . $item_title_url . '</span>';
			echo '<span id="price_vals' . $itms['id'] . '" price_val="' . $_SESSION['currency_symbol'] . $user_currency_price . '" ></span>';
			echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $itms['id'] . '" usernameval ="' . $username . '"></a>';
			echo '<span id="img_' . $itms['id'] . '" class="nodisply">' . SITE_URL . 'media/items/original/' . $items_image . '</span>';
			echo '<span class="fav_count" id="fav_count' . $itms['id'] . '" fav_counts ="' . $favorte_count . '" ></span>';
			if ($loguser == "") {
				$temp = "";
				$temp1 = "";
			} else {
				$temp = "modal";
				$temp1 = "#share-modal";
			}


			echo '<div class="item1 box_shadow_img"><div class="product_cnt box_shadow_img col-lg-3 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
			<a class="img-hover" href="' . SITE_URL . 'listing/' . $itemid . '">
			<img src="' . $itemimage . '" class="img-responsive" /></a>

			<div class="hover-visible">
			<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou(' . $itms['id'] . ')">';

			if (count($likeditemid) != 0 && in_array($itms['id'], $likeditemid)) {
				/*echo 	'<i class="fa fa-heart like-icon'.$itms['id'].'" id="like-icon'.$itms['id'].'"></i>*/
				echo '<img src="' . SITE_URL . 'img/Heart filled@2x.png" id="like-icon' . $itms['id'] . '" class="like-icon' . $itms['id'] . '">
				<span class="like-txt' . $itms['id'] . ' nodisply" id="like-txt' . $itms['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
			} else {
				/*echo 	'<i class="fa fa-heart-o like-icon'.$itms['id'].'" id="like-icon'.$itms['id'].'"></i>*/
				echo '<img src="' . SITE_URL . 'img/like.png" id="like-icon' . $itms['id'] . '" class="like-icon' . $itms['id'] . '">
				<span class="like-txt' . $itms['id'] . ' nodisply" id="like-txt' . $itms['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
			}
			echo '</span>
			<span class="hover-icon-cnt share_hover" href="javascript:void(0)" data-toggle="' . $temp . '" data-target="' . $temp1 . '" onclick="share_posts(' . $itms['id'] . ')"><img src="' . SITE_URL . 'images/icons/share_icon.png"></span>
			</div>



			<div class="rate_section padding-left0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="product_name bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="' . SITE_URL . 'listing/' . $itemid . '">
			' . $item_title . '
			</a><br/><div class="d-flex justify-content-between align-items-center w-100">';

			$date = date('d');
			$month = date('m');
			$year = date('y');
			$tdy = strtotime($month . '/' . $date . '/' . $year);
			//$newdate = new Time($itms['dealdate']);
			//$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
			$dealdate = strtotime($itms['dealdate']);

			if (($itms['discount_type'] == 'daily' && $dealdate == $tdy) || $itms['discount_type'] == 'regular') {
				echo '<div class="price">';


//

				$dealprice = $itemprice * (1 - $itms['discount'] / 100);

				$user_currency_dealprice = $currencycomponent->conversion($itms['forexrate']['price'], $_SESSION['currency_value'], $dealprice);

				if (isset($_SESSION['currency_code'])) { ?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'] . ' ' . $user_currency_dealprice;
				} else { ?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
					echo $itms['forexrate']['currency_symbol'] . ' ' . $dealprice;
				}
				echo ' ';
				if (isset($_SESSION['currency_code'])) { ?>&#x200E;<?php
					echo '<strike class="bold-font">' . $_SESSION['currency_symbol'] . ' ' . $user_currency_price . '</strike>';
				} else { ?>&#x200E;<?php
					echo '<strike class="bold-font">' . $itms['forexrate']['currency_symbol'] . ' ' . $itemprice . '</strike>';
				}

				echo '</div>';
			} else {
				echo '<div class="price">';

				if (isset($_SESSION['currency_code'])) { ?>&#x200E;<?php
					echo $_SESSION['currency_symbol'] . ' ' . $user_currency_price;
				} else { ?>&#x200E;<?php
					echo $itms['forexrate']['currency_symbol'] . ' ' . $itemprice;
				}

				echo '</div>';
			}
			echo '<div class="percentage_tag">'.$itms['affiliate_commission'].' % </div></div>';
			echo '</div>
			</div>
			</div>';
		}
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
							<h2 class="bold-font text-center">
								<?php echo __d('user', 'SHARE THIS THING'); ?></h2>
								<div class="popup-heading-border"></div>
							</div>
							<div class="share-cnt-row">
								<div class="share-details-cnt margin-top30">

									<?php
									echo '<div class="share-details">
									<div class="share-img margin-right20"><img id="share_img" class="img-responsive" src=""></div>
									<div class="share-details-txt">
									<div class="bold-font" id="share_title"></div>
									<div class="">' . __d('user', 'By') . ' <span id="share_username"></span></div>
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

						</div>
					</div>
				</div>

			</div>
		</div>
		<?php
	} else {
		echo "false";
	}
	?>

