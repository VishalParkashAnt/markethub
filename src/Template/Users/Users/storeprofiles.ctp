<?php
namespace Cake\I18n;
use Cake\Routing\Router;
use Cake\I18n\Time;
$baseurl = Router::url('/');
?>
<?php echo $this->element('numberconversion'); ?>

<div class="container-fluid margin-top10 no_hor_padding_mobile">
	<div class="container">
		<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
     <!--div class="breadcrumb">
      <a href="homepage.html">Home</a>
      <span class="breadcrumb-divider1">/</span>
      <a href="#">All stores</a>
      <a href="#">Opumo</a>
  </div-->
</div>
<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	<?php
if ($shopsdet['shop_banner'] != '') echo '<div class="store_banner" style="background-image:url(' . SITE_URL . 'media/avatars/original/' . $shopsdet['shop_banner'] . ');background-repeat:no-repeat;">';
else echo '<div class="store_banner">';
?>
	<div class="text-right padding-top15 right-padding left_padding_rtl">
		<?php
$shop_id = $shopsdet['id'];
foreach ($followcnt as $flcnt)
{
    $flwrcntid[] = $flcnt['store_id'];
}

if ($shop_id != $loguser['id'])
{
    if (in_array($shop_id, $flwrcntid) && isset($loguser['id']))
    {
        $flw = false;
    }
    else
    {
        $flw = true;
    }
    if ($flw)
    {
        echo '<span id="folls' . $shop_id . '"><div class="user_followers_butn btn">
				<a href="javascript:void(0);" onclick="getshopfollows(' . $shop_id . ')">' . __d('user', 'Follow Store') . '</a></div></span>';
    }
    else
    {
        echo '<span id="unfolls' . $shop_id . '"><div class="btn user_unfollowers">
				<a href="javascript:void(0);" onclick="deleteshopfollows(' . $shop_id . ')">' . __d('user', 'Unfollow Store') . '</a></div></span>';
    }
    echo '<span id="changebtnn' . $shop_id . '" ></span>';
}
?>
	</div>
</div>
<div class="profile_bg">
	<div class="dis_table">
		<div class="dis_cell">
			<div class="seller_image1 margin_top_50minus seller_image_mobile">
				<?php
$shopimage = $shopsdet['shop_image'];
if ($shopimage == "") $shopimage = "usrimg.jpg";
else $shopimage = $shopsdet['shop_image'];
echo '<div class="seller_image" style="background-image:url(' . SITE_URL . 'media/avatars/thumb150/' . $shopimage . ');background-repeat:no-repeat;"></div>';
?>
			</div>
		</div>
		<div class="dis_cell left-padding padding-bottom15">
			<div class="dis_table full_width_store">
				<div class="rating_display_cell">
					<h2 class="bold-font margin_top20_seller margin-right20 margin_right0_rtl text_center_seller">
						<?php
echo $shopsdet['shop_name'];
?>
					</h2>
					<p class="profile_text margin-bottom10 text_center_seller"><?php echo __d('user', 'By'); ?> <?php echo $shopsdet['merchant_name']; ?></p>
				</div>
	 <!--div class="rating_display_cell border_left_grey_shop">
		 <span class="badge margin-left20 margin_left0_rtl margin_right20_rtl pull-left">4.2</span> <span class="font_size13 pull-left margin_left5_rtl">&nbsp;Rating</span>
		</div-->
	</div>
	<p class="profile_text text_center_seller margin_top10_seller" style="word-break: break-all;">
		<?php
echo $shopsdet['shop_address'];
?>
	</p>
	<div class="profile_text text-content text_center_seller margin-top5">
		<div class="dolessmore">
			<p>
				<?php
echo $shopsdet['shop_description'];
?>
			</p>
		</div>
	</div>
</div>
</div>
</div>
</section>
</div>
</div>

<section class="container-fluid side-collapse-container no_hor_padding_mobile">
	<div class="container">


		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">


			<div id="parentVerticalTab" class="resp-vtabs">

				<ul class="resp-tabs-list">
					<?php
if (count($_GET) == 0) echo '<li class="resp-tab-active productli">';
else echo '<li class="productli">';
?>
					<a href="<?php echo $baseurl . 'stores/' . $_SESSION['username_urls']; ?>"><span><?php echo __d('user', 'All Products'); ?></span><span class="rtl_tab_list"></span></a></li>
					<?php
if (isset($_GET['news'])) echo '<li class="resp-tab-active">';
else echo '<li class="productli">';
?>
					<a href="<?php echo $baseurl . 'stores/' . $_SESSION['username_urls'] . '?news'; ?>"><span><?php echo __d('user', 'News'); ?></span><span class="rtl_tab_list"></span></a></li>
					<?php
if (isset($_GET['reviews'])) echo '<li class="resp-tab-active">';
else echo '<li class="productli">';
?>
					<a href="<?php echo $baseurl . 'stores/' . $_SESSION['username_urls'] . '?reviews'; ?>"><span><?php echo __d('user', 'Reviews'); ?></span><span class="rtl_tab_list"></span></a></li>
					<?php
if (isset($_GET['followers'])) echo '<li class="resp-tab-active">';
else echo '<li class="productli">';
?>
					<a href="<?php echo $baseurl . 'stores/' . $_SESSION['username_urls'] . '?followers'; ?>"><span><?php echo __d('user', 'Followers'); ?></span><span class="rtl_tab_list"></span></a></li>

				</ul>


				<div class="resp-tabs-container">
					<?php
if (count($_GET) == 0)
{
    $selectedTab = 'added';
?>
						<div class="row hor-padding padding-top0">
							<div>
								<h2 class="user_profile_inner_heading padd_lft10_mobile"><?php echo __d('user', 'All Products'); ?></h2>
								<p class="margin-bottom40 padd_lft10_mobile txt_center_mobile margin-top2 time_text"> </p>
								<?php
    if (count($item_details) > 0)
    {
        foreach ($item_details as $item)
        {
            $itemid = base64_encode($item->id . "_" . rand(1, 9999));

            $itm_id = $item['id'];
            $item_title_url = $item['item_title_url'];
            $item_title = $item['item_title'];
            $image_name = $item['photos'][0]['image_name'];
            $price = $item['price'];
            $user_id = $item['user_id'];
            $item_price = $item['price'];
            $item_default_price = round($item['price'] * $item['forexrate']['price'], 2);
            $itemid = base64_encode($itm_id . "_" . rand(1, 9999));
            $item_price = $item['price'];
            $favorte_count = $item['fav_count'];
            $username = $item['user']['username'];
            $currencysymbol = $item['forexrate']['currency_symbol'];
            $items_image = $item['photos'][0]['image_name'];
            //$item_title = UrlfriendlyComponent::limit_char($item_title,12);
            if (isset($item['photos'][0]))
            {
                $image_name = $item['photos'][0]['image_name'];
            }
            else
            {
                $image_name = "usrimg.jpg";
            }
            $shopname_url = $item['shop']['shop_image'];
            $username_url = $item['user']['profile_image'];
            if ($shopname_url == '')
            {
                $shopname_url = 'usrimg.jpg';
            }
            if ($username_url == '')
            {
                $username_url = 'usrimg.jpg';
            }
            $user_level = $item['user']['user_level'];
            $username = $item['user']['username'];
            $sellername = $item['shop']['shop_name'];
            $sellername_id = $item['shop']['user_id'];
            $sellername_url_ori = $item['shop']['shop_name_url'];

            $username_url_ori = $item['user']['username_url'];
            $favorte_count = $item['fav_count'];

            $item_price = $item['price'];
            $item_default_price = round($item_price * $item['forexrate']['price'], 2);
            $size_options = $item['size_options'];
            $sizeoptions = json_decode($size_options, true);
            if (!empty($sizeoptions['size']))
            {
                $item_price = reset($sizeoptions['price']);
                $item_default_price = round(reset($sizeoptions['price']) * $item['Forexrates']['price'], 2);
            }

            $itemprice = $item['price'];

            $user_currency_price = $currencycomponent->conversion($item['forexrate']['price'], $_SESSION['currency_value'], $itemprice);

            echo '<span id="figcaption_titles' . $item['id'] . '" figcaption_title ="' . $item_title . '" ></span>';
            echo '<span class="figcaption" id="figcaption_title_url' . $item['id'] . '" figcaption_url ="' . $item_title_url . '" style="position: relative; top: 10px; left: 7px;display:none;" >' . $item_title_url . '</span>';
            echo '<span id="price_vals' . $item['id'] . '" price_val="&#x200E;' . $_SESSION['currency_symbol'] . ' ' . $user_currency_price . '" ></span>';
            echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $item['id'] . '" usernameval ="' . $username . '"></a>';
            echo '<span id="img_' . $item['id'] . '" class="nodisply">' . SITE_URL . 'media/items/original/' . $items_image . '</span>';
            echo '<span class="fav_count" id="fav_count' . $item['id'] . '" fav_counts ="' . $favorte_count . '" ></span>';
            if ($loguser == "")
            {
                $temp = "";
                $temp1 = "";
            }
            else
            {
                $temp = "modal";
                $temp1 = "#share-modal";
            }

            echo '<div class="item1 box_shadow_img"><div class="product_cnt box_shadow_img col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
										<a class="img-hover" href="' . $baseurl . 'listing/' . $itemid . '">
											<img src="' . $baseurl . 'media/items/original/' . $item['photos'][0]['image_name'] . '" class="img-responsive" />
										</a>
										<div class="hover-visible">
											<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou(' . $item['id'] . ')">';
            if (count($likeditemid) != 0 && in_array($item['id'], $likeditemid))
            {
                /*echo  '<i class="fa fa-heart like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
                echo '<img src="' . SITE_URL . 'img/Heart filled@2x.png" id="like-icon' . $item['id'] . '" class="like-icon' . $item['id'] . '">
													<span class="like-txt' . $item['id'] . ' nodisply" id="like-txt' . $item['id'] . '" >Fantacies</span>';
            }
            else
            {
                /*  echo    '<i class="fa fa-heart-o like-icon'.$deals['id'].'" id="like-icon'.$deals['id'].'"></i>*/
                echo '<img src="' . SITE_URL . 'img/Like.png" id="like-icon' . $item['id'] . '" class="like-icon' . $item['id'] . '">
														<span class="like-txt' . $item['id'] . ' nodisply" id="like-txt' . $item['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
            }
            echo '</span>
													<span class="hover-icon-cnt share_hover" href="javascript:void(0)" onclick="share_posts(' . $item['id'] . ')" data-toggle="' . $temp . '" data-target="' . $temp1 . '" ><img src="' . SITE_URL . 'images/icons/share_icon.png"></span>
												</div>
											</a>



											<div class="rate_section padding-left0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<div class="product_name bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="">' . $item['item_title_url'] . '</a><br/>';
            $date = date('d');
            $month = date('m');
            $year = date('y');
            $tdy = strtotime($month . '/' . $date . '/' . $year);
            $newdate = new Time($item['dealdate']);
            $dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);

            if (($item['discount_type'] == 'daily' && $dealdate >= $tdy) || $item['discount_type'] == 'regular')
            {
                echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

                //
                $dealprice = $itemprice * (1 - $item['discount'] / 100);

                $user_currency_dealprice = $currencycomponent->conversion($item['forexrate']['price'], $_SESSION['currency_value'], $dealprice);

                if (isset($_SESSION['currency_code']))
                { ?>&#x200E;<?php
                    //echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
                    echo $_SESSION['currency_symbol'] . ' ' . $user_currency_dealprice;
                }
                else
                { ?>&#x200E;<?php
                    //echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
                    echo $item['forexrate']['currency_symbol'] . ' ' . $dealprice;
                }
                echo ' ';
                if (isset($_SESSION['currency_code']))
                { ?>&#x200E;<?php
                    echo '<strike class="bold-font">' . $_SESSION['currency_symbol'] . ' ' . $user_currency_price . '</strike>';
                }
                else
                { ?>&#x200E;<?php
                    echo '<strike class="bold-font">' . $item['forexrate']['currency_symbol'] . ' ' . $itemprice . '</strike>';
                }

                echo '</div>';
            }
            else
            {
                echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

                if (isset($_SESSION['currency_code']))
                { ?>&#x200E;<?php
                    echo $_SESSION['currency_symbol'] . ' ' . $user_currency_price;
                }
                else
                { ?>&#x200E;<?php
                    echo $item['forexrate']['currency_symbol'] . ' ' . $itemprice;
                }

                echo '</div>';
            }
            echo '</div>
														</div>
													</div>';
        }
?>


											</div>
											<?php
    }
    else
    {
        echo '<div class="text-center padding-top30 padding-bottom30">
											<div class="outer_no_div">
												<div class="empty-icon no_products_icon"></div>
											</div>
											<h5>' . __d('user', 'No Products') . '</h5>
										</div>';
    }
?>

								</div><!---tab1 content ends---->
								<?php
} ?>
								<?php
if (isset($_GET['news']))
{
    $selectedTab = 'news';
?>
									<div class="row hor-padding padding-top0">
										<div>
											<div class="form-group padd_lft10_mobile">
												<h2 class="margin-bottom20 user_profile_inner_heading"><?php echo __d('user', 'News'); ?>:

													<a href="javascript:void(0)" data-toggle="tooltip"  data-placement="bottom" data-trigger="hover" title="<?php echo __d('user', 'Followers will get push notifications and the message will be update in their notification alert'); ?>" id="changeBtn"><img src="<?php echo SITE_URL; ?>images/information-icon.png"></a>

												</h2>

											</div>
											<?php
    if (count($postmessage) > 0)
    {
        foreach ($postmessage as $news)
        {
            $ldate = $news['cdate'];
            $from = $ldate;
            $now = 0;
            $txt = '';
            if ($now == 0) $now = time();
            $diff = $now - $from;
            $days = intval($diff / 86400);
            $diff = $diff % 86400;
            $hours = intval($diff / 3600);
            $diff = $diff % 3600;
            $minutes = intval($diff / 60);

            if ($days > 1) $txt .= " $days " . __d('user', 'days');
            else if ($days == 1) $txt .= " $days " . __d('user', 'day');

            if ($days < 2)
            {
                if ($hours > 1) $txt .= " $hours " . __d('user', 'hours');
                else if ($hours == 1) $txt .= " $hours " . __d('user', 'hour');

                if ($hours < 3)
                {
                    if ($minutes > 1) $txt .= " $minutes " . __d('user', 'minutes');
                    //else if ($minutes<1) $txt  .= " less than half minute";
                    else if ($minutes == 1) $txt .= " $minutes " . __d('user', 'minute');
                }
            }

            if ($txt == '') $txt = ' ' . "5 " . __d('user', 'seconds');

            //echo "dsfds";
            //echo $this->Urlfriendly->txt_time_diff($ldate);
            echo '<div class="comment-row col-xs-12 col-sm-12 border_bottom_grey">

													<div class="comment-section">
														<div class="margin-top10 comment-txt">
															' . $news['message'] . '
														</div>
														<div class="comment-edit-cnt col-lg-12 no-hor-padding">
															<p class="time_text">' . $txt . ' ' . __d('user', 'ago') . '</p>
														</div>
													</div>
												</div>';
        }
?>



										</div>
										<?php
    }
    else
    {

        echo '<div class="text-center padding-top30 padding-bottom30">
											<div class="outer_no_div">
												<div class="empty-icon no_news_icon"></div>
											</div>
											<h5>' . __d('user', 'No News') . '</h5>
										</div>';
    }
?>
								</div><!---tab2 content ends---->
								<?php
} ?>
								<?php
if (isset($_GET['reviews']))
{
    $selectedTab = 'reviews';
    foreach ($order_datas as $orders)
    {
        $orderdate = date('Y-m-d H:i:s', $orders['Orders']['orderdate']);
        $today = date('Y-m-d H:i:s');
        $date = date_create($orderdate);
        date_add($date, date_interval_create_from_date_string('30 days'));
        $review_date = date_format($date, 'Y-m-d H:i:s');
        $tot = 0; //print_r($rateval_data);
        if ($today < $review_date) $orders['Orders']['orderid'] . "<br />";
    }
    foreach ($rateval_data as $rateval)
    {
        $tot += $rateval['ratings'];
    }
    $percentage = ($tot * 100) / ($review_count * 5);
    $percentage = floor($percentage * 2) / 2;
    $count = count($rateval_data);
    $count = format_number($count);
?>
	<div class="row hor-padding padding-top0">
		<div>
			<h2 class="user_profile_inner_heading margin-bottom40 padd_lft10_mobile margin_botm10_mobile"><?php echo __d('user', 'All Reviews'); ?>
				<div class="pull-right font_size13 full_width_rating_moble white_space_nowrap">
					<?php
    if ($count > 0)
    {
?>
						<div id="storeratings">
							<?php
        $avg_ratings = floor($tot / $count);
        for ($i = 1;$i <= 5;$i++)
        {
            if ($i <= $avg_ratings)
            {
                echo '<label class="starsactive"></label>';
            }
            else
            {
                echo '<label class="stars"></label>';
            }
        } ?>
						</div>
						<?php
    } ?>
						<?php
    if ($count > 0)
    {
        echo '<div class="float_left_review_rtl margin-top5">' . $percentage . '% ' . __d('user', 'Positive') . '<span class="profile_text"> (' . __d('user', 'Based on') . ' ' . $count . ' ' . __d('user', 'ratings') . ')</span></div>';
    }
?>
					</div>
				</h2>
				<?php
    if (count($reviews_added) > 0)
    {
        foreach ($reviews_added as $reviews)
        {
            $prof_img = $reviews['user']['profile_image'];
            if (empty($prof_img))
            {
                $prof_img = "usrimg.jpg";
            }
            $usrname = $reviews["user"]["first_name"];
            $usrname_url = $reviews["user"]["username_url"];
            $rating = $reviews['ratings'];

            $item_title = $reviews["item"]['item_title'];
            $item_url = SITE_URL.'listing/'.base64_encode($reviews["item"]['id'] . "_" . rand(1, 9999));

            echo '<div class="comment-row col-xs-12 col-sm-12 border_bottom_grey">
						<div class="sold-by-prof-pic-cnt padding_right0_rtl col-xs-2 col-lg-1 padding-right0 padding-left0">
							<a href=' . SITE_URL . 'people/' . $usrname_url . '><div class="review_prof_pic" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $prof_img . ')"></div></a>
						</div>

						<div class="comment-section col-xs-10 col-lg-11 padding-right0">
							<div class="bold-font txt-uppercase comment-name">' . $usrname . '</div>
                            <div class="bold-font txt-uppercase comment-name"><a href="'.$item_url.'">' . $item_title . '</a></div>
							<p class="text_center_seller time_text">' . date('d M Y', strtotime($reviews['date'])) . '</p>
							<div class="margin-top10 comment-txt">
								' . $reviews['reviews'] . '
							</div>
							<div class="comment-edit-cnt col-lg-12 no-hor-padding margin-top10">
								<div id="storeratings">';
            for ($i = 1;$i <= 5;$i++)
            {
                if ($i <= $reviews['ratings'])
                {
                    echo '<label class="starsactive"></label>';
                }
                else
                {
                    echo '<label class="stars"></label>';
                }
            }
            echo '</div>
								</div>
							</div>
						</div>';
        }

        echo '
				</div>';
    }
    else
    {

        echo '<div class="text-center padding-top30 padding-bottom30">
				<div class="outer_no_div">
					<div class="empty-icon no_review_icon"></div>
				</div>
				<h5>' . __d('user', 'No Reviews') . '</h5>
			</div>';
    }
?>
	</div><!---tab3 content ends---->
	<?php
} ?>
	<?php
if (isset($_GET['followers']))
{
    $selectedTab = 'followers';
?>

		<div class="row hor-padding padding-top0">
			<div>
				<h2 class="user_profile_inner_heading margin-bottom40 padd_lft10_mobile"><?php echo __d('user', 'Followers'); ?></h2>
				<?php
    if (!empty($people_details))
    {
        foreach ($people_details as $ppls)
        {
            $fullname = $ppls['first_name'];
            $user_nam = $ppls['username'];
            $user_nam_url = $ppls['username_url'];
            $user_first = $ppls['first_name'];
            $user_imges = $ppls['profile_image'];
            if (empty($user_imges))
            {
                $user_imges = "usrimg.jpg";
            }
            echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
						<div class="user_follower_image1">
							<a href=' . SITE_URL . 'people/' . $user_nam_url . '><div class="user_follower_image" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $user_imges . ')"></div></a>
						</div>
						<div class="user_followers">
							<h4 class="margin-bottom0 extra_text_hide">' . $fullname . '</h4>
							<p class="profile_text margin-bottom20 extra_text_hide">@' . $user_nam . '</p>';
            foreach ($follow_user_count as $flcnt)
            {
                $flwrcntid[] = $flcnt['user_id'];
            }

            if ($userid != $ppls['id'])
            {
                if (in_array($ppls['id'], $flwrcntid) && isset($loguser['id']))
                {
                    $flw = false;
                }
                else
                {
                    $flw = true;
                }
                if ($flw)
                {
                    echo '<span id="foll' . $ppls['id'] . '"><div class="user_followers_butn btn">
									<a href="javascript:void(0);" onclick="getfollows(' . $ppls['id'] . ')">' . __d('user', 'Follow') . '</a></div></span>';
                }
                else
                {
                    echo '<span id="unfoll' . $ppls['id'] . '"><div class="btn user_unfollowers">
									<a href="javascript:void(0);" onclick="deletefollows(' . $ppls['id'] . ')">' . __d('user', 'Unfollow') . '</a></div></span>';
                }
                echo '<span id="changebtn' . $ppls['id'] . '" ></span>';
            }
            echo '</div>
						</div>';
        }

        echo '
				</div>';
    }
    else
    {

        echo '<div class="text-center padding-top30 padding-bottom30">
				<div class="outer_no_div">
					<div class="empty-icon no_follow_icon"></div>
				</div>
				<h5>' . __d('user', 'No Followers') . '</h5>
			</div>';
    }
?>
	</div><!---tab4 content ends---->
	<?php
} ?>


</div>
</div>


</section>
</div>
</section>
<?php
if (empty($userid))
{
    echo "<input type='hidden' id='gstid' value='0' />";
    echo "<input type='hidden' id='loguserid' value='0' />";
}
else
{
    echo "<input type='hidden' id='gstid' value='" . $userid . "' />";
    echo "<input type='hidden' id='loguserid' value='" . $loguser['id'] . "' />";
}
echo "<input type='hidden' id='selectedtab' value='" . $selectedTab . "' />";
echo '<input type="hidden" id="likebtncnt" value="' . $setngs['like_btn_cmnt'] . '" />';
echo '<input type="hidden" id="likedbtncnt" value="' . $setngs['liked_btn_cmnt'] . '" />';

?>
<script type="text/javascript">
	var sIndex = <?php echo $startIndex; ?>, offSet = 15, isPreviousEventComplete = true, isDataAvailable = true;
	var baseurl = getBaseURL();var selectedtab = $('#selectedtab').val();
	$(window).scroll(function () {
//$("[name='my-checkbox']").bootstrapSwitch();
	 //if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
	 	if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.5) {
	 		if (isPreviousEventComplete && isDataAvailable) {

	 			isPreviousEventComplete = false;
	 			var baseurl = getBaseURL()+"getmorestoreprofiles";
	 			$(".LoaderImage").css("display", "block");
	 			storeid = $("#storeid").val();
	 			$.ajax({
	 				type: "POST",
	 				url: baseurl+'?startIndex=' + sIndex + '&offset=' + offSet + '&tab=' + selectedtab,
	 				data: {'shopid':storeid},
	 				beforeSend: function () {
	 					$('#infscr-loading').show();
	 				},
	 				dataType: 'html',
	 				success: function (responce) {
	 					$('#infscr-loading').hide();
	 					if($.trim(responce)=='' || $.trim(responce)=='false')
	 						$(window).unbind('scroll');
	 					else if ($.trim(responce) != 'false') {
	 						if (selectedtab == 'added') {
	 							$('.profile-content').append(responce);
	 						}else if (selectedtab == 'news') {
	 							$('.profile-content').append(responce);
	 						}else if (selectedtab == 'reviews') {
	 							$('.profile-content').append(responce);
	 						}else if (selectedtab == 'followers') {
	 							$('.profile-content').append(responce);
	 						}
	 					}else {
	 						isDataAvailable = false;
	 					}
	 					sIndex = sIndex + offSet;
	 					isPreviousEventComplete = true;
	 				}
	 			});

	 		}
	 	}
	 });


	</script>

	<!-- Share Modal -->
	<div id="share-modal" class="modal fade" role="dialog">
		<div class="modal-dialog downloadapp-modal">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="share-container margin-bottom20">
						<div class="share-cnt-row">
							<h2 class="bold-font text-center"><?php echo __d('user', 'SHARE THIS THING'); ?></h2>
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
	$(document).ready(function(){
		var qval = '<?php echo count($_GET); ?>';
		if(qval == 1)
			$(".productli").removeClass('resp-tab-active');
	});
</script>

<style>
	#storeratings > label {
		margin: 0 auto;
		height: 30px;
		width: 30px;
	}

	#storeratings .stars {
		background: url("<?php echo SITE_URL; ?>images/stars.png") repeat-x 0 0;
	}

	#storeratings .starsactive{
		background: url("<?php echo SITE_URL; ?>images/stars.png") repeat-x 0 100%;
	}
</style>
