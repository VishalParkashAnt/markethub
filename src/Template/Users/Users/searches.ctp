<?php
use Cake\Routing\Router;
use Cake\I18n\Time;
$baseurl = Router::url('/');
?>
<section class="container">
	<div class="container default-home-header row margin_top165_mobile">
		<ul class="nav nav-pills home-page-tab col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<li class="active"><a class="bold-font" data-toggle="pill" href="#things" onclick="setindex();"><?php echo __d('user', 'Things'); ?></a></li>
			<li class=""><a class="bold-font" data-toggle="pill" href="#people" onclick="setindex();"><?php echo __d('user', 'People'); ?></a></li>
		</ul>
	</div>
	<div class="tab-content container section_container row">
		<div id="people" class="tab-pane fade">
			<!--Staggered Grid-->
			<div class="slider section_container">
				<div class="col-xs-12 col-sm-12 no-hor-padding default-page-timer-cnt" >
					<h2 class="section_heading bold-font centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom5 padding-top10 padding-top20"><?php echo __d('user', 'People'); ?></h2>
					<!--div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom20"><div class="timer-cnt"><img src="images/icons/timer.png"><span class="time bold-font ">12:08:06 Left</span></div></div-->
				</div>
				<div class="row box1 people_stream">
					<?php
if (count($userDetails) > 0)
{
    foreach ($userDetails as $people)
    {
        $people_id = $people->id;
        $username_url = $people->username_url;
        //User Image
        $imgname = $_SESSION['media_url'] . "media/avatars/thumb70/" . $people->profile_image;
        $imgsze = getimagesize($imgname);
        if (!empty($people->profile_image) && !empty($imgsze))
        {
            $imageUrl = $_SESSION['media_url'] . "media/avatars/thumb70/" . $people->profile_image;
        }
        else
        {
            $imageUrl = $_SESSION['media_url'] . "media/avatars/thumb70/usrimg.jpg";
        }
?>
							<div class="product_cnt col-lg-3 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
								<div class="find_people_image1">
									<?php echo '<a href="' . SITE_URL . "people/" . $username_url . '">'; ?><div class="find_people_image" style="background:url('<?php echo $imageUrl; ?>');"></div></a>
								</div>
								<div class="find_people_followers">
									<div class="gradient_bg">
										<h4 class="margin-bottom0 extra_text_hide"><?php echo '<a href="' . SITE_URL . "people/" . $username_url . '">'; ?><?php echo $people->first_name . $people->last_name; ?></a></h4>
									</div><p class="profile_text margin-bottom20 extra_text_hide hor-padding">@ <?php echo $people->username; ?></p>
									<?php
        if ($userid != $people['id'])
        {
            foreach ($followcnt as $flcnt)
            {
                if ($flcnt['follow_user_id'] == $userid)
                {
                    $flwrcntid[] = $flcnt['user_id'];
                }
            }
            if ($userid != $people['id'])
            {
                if (!in_array($people['id'], $flwrcntid))
                {
                    $flw = true;
                }
                else
                {
                    $flw = false;
                }
                if ($flw)
                {
                    echo '<span id="foll' . $people['id'] . '"><div class="btn user_followers_butn" id="follow_' . $people['id'] . '">
												<a href="javascript:void(0);" class="" onclick="getpeoplefollows(' . $people['id'] . ')">' . __d('user', 'Follow') . '</a></div></span>';
                }
                else
                {
                    echo '<span id="unfoll' . $people['id'] . '"><div class="btn user_followers_butn" id="follow_' . $people['id'] . '">
												<a href="javascript:void(0);" class="" onclick="deletepeoplefollows(' . $people['id'] . ')">' . __d('user', 'Unfollow') . '</a></div></span>';
                }
                echo '<span id="changebtn' . $people['id'] . '" style="float:right;"></span>';
            }
        }
?>
								</div>
							</div>
						<?php
    }
}
else
{
    echo '<div class="text-center padding-top30 padding-bottom30">
							<div class="outer_no_div">
							<div class="empty-icon no_follow_icon"></div>
							</div>
							<h5>' . __d('user', 'No Peoples') . '</h5>
							</div>';
}
?>
					</div>
					<input type="hidden" value="20" id="people_sindex">
					<input type="hidden" value="20" id="people_offset">
					<input type="hidden" value="true" id="people_event">
					<input type="hidden" value="true" id="people_data">
					<input type="hidden" value="0" id="people_scroll">
				</div>
				<!--Staggered Grid-->
			</div>
			<div id="things" class="tab-pane fade in active">
				<!--Staggered Grid-->
				<div class="slider section_container">
					<div class="col-xs-12 col-sm-12 no-hor-padding default-page-timer-cnt">
						<h2 class="section_heading bold-font centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom5 padding-top10 padding-top20"><?php echo __d('user', 'Things'); ?></h2>
						<!--div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom20"><div class="timer-cnt"><img src="images/icons/timer.png"><span class="time bold-font ">12:08:06 Left</span></div></div-->
					</div>
					<div class="">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<?php
if (count($itemDetails) > 0)
{
?>
								<!-- Bottom to top-->
								<div class="row product_align_cnt">
									<div id="fh5co-main">
										<div id="fh5co-board" class="things_stream" data-columns>
											<?php
    foreach ($itemDetails as $deals)
    {
        $itemid = base64_encode($deals->id . "_" . rand(1, 9999));
        $item_title = $deals['item_title'];
        $item_title_url = $deals['item_title_url'];
        $item_price = $deals['price'];
        $favorte_count = $deals['fav_count'];
        $username = $deals['user']['username'];
        $currencysymbol = $deals['forexrate']['currency_symbol'];
        $items_image = $deals['photos'][0]['image_name'];
        $itemprice = $deals['price'];
        $user_currency_price = $currencycomponent->conversion($deals['forexrate']['price'], $_SESSION['currency_value'], $itemprice);
        echo '<span id="figcaption_titles' . $deals['id'] . '" figcaption_title ="' . $item_title . '" ></span>';
        echo '<span class="figcaption" id="figcaption_title_url' . $deals['id'] . '" figcaption_url ="' . $item_title_url . '" style="position: relative; top: 10px; left: 7px;display:none;" >' . $item_title_url . '</span>';
        echo '<span id="price_vals' . $deals['id'] . '" price_val="' . $currencysymbol . $item_price . '" ></span>';
        echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $deals['id'] . '" usernameval ="' . $username . '"></a>';
        echo '<span id="img_' . $deals['id'] . '" class="nodisply">' . SITE_URL . 'media/items/original/' . $items_image . '</span>';
        echo '<span class="fav_count" id="fav_count' . $deals['id'] . '" fav_counts ="' . $favorte_count . '" ></span>';
        $item_image = $deals['photos'][0]['image_name'];
        if ($item_image == "")
        {
            $itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
        }
        else
        {
            $itemimage = WWW_ROOT . 'media/items/original/' . $item_image;
            /*$header_response = get_headers($itemimage, 1);*/
            if (file_exists($itemimage))
            {
                $itemimage = SITE_URL . 'media/items/original/' . $item_image;
            }
            else
            {
                $itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
            }
        }
?>
												<div class="item">
													<div class="grid cs-style-3 no-hor-padding">
														<div class="image-grid col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
															<div>
																<!-- <figure class="animate-box"> -->
																<a href="<?php echo $baseurl . 'listing/' . $itemid; ?>" class="fh5co-board-img">
																	<img class="img-responsive" src="<?php echo $itemimage; ?>" alt="img">
																</a>
															<!-- </figure> -->
														</div>
															<div class="rate_section bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
																<div class="product_name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
																		<a href=""><?php echo $deals->item_title; ?></a></div>
																		<?php $date = date('d');
        $month = date('m');
        $year = date('y');
        //$tdy = strtotime($month . '/' . $date . '/' . $year);
        $tdy = strtotime($year . '-' . $month  . '-' . $date  );
        $dealdate = strtotime($deals['dealdate']);
        //$newdate = new Time($deals['dealdate']);
        //$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
        //echo $deals['discount_type'];
        
        if (($deals['discount_type'] == 'daily' && $dealdate == $tdy) || $deals['discount_type'] == 'regular')
        {

            echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
            //
            $dealprice = $itemprice * (1 - $deals['discount'] / 100);
            $user_currency_dealprice = $currencycomponent->conversion($deals['forexrate']['price'], $_SESSION['currency_value'], $dealprice);
            if (isset($_SESSION['currency_code']))
            { ?>&#x200E;<?php
                //echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
                echo $_SESSION['currency_symbol'] . ' ' . $user_currency_dealprice;
            }
            else
            { ?>&#x200E;<?php
                //echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
                echo $deals['forexrate']['currency_symbol'] . ' ' . $dealprice;
            }
            echo ' ';
            if (isset($_SESSION['currency_code']))
            { ?>&#x200E;<?php
                echo '<strike class="bold-font">' . $_SESSION['currency_symbol'] . ' ' . $user_currency_price . '</strike>';
            }
            else
            { ?>&#x200E;<?php
                echo '<strike class="bold-font">' . $deals['forexrate']['currency_symbol'] . ' ' . $itemprice . '</strike>';
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
                echo $deals['forexrate']['currency_symbol'] . ' ' . $itemprice;
            }
            echo '</div>';
        }
?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php
    }
?>
													</div>
												</div>
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
										<!-- end Bottom to top-->
									</div>
								</div>
							</div>
							<input type="hidden" value="20" id="things_sindex">
							<input type="hidden" value="20" id="things_offset">
							<input type="hidden" value="true" id="things_event">
							<input type="hidden" value="true" id="things_data">
							<input type="hidden" value="0" id="things_scroll">
							<!--Staggered Grid-->
						</div>
					</div>
				</section>
				<?php
if (isset($loguser['id'])) echo '<input type="hidden" id="loguserid" value="' . $loguser['id'] . '">';
else echo '<input type="hidden" id="loguserid" value="0">';
?>
				<script type="text/javascript">
					var searchString = '<?php echo $searchWord; ?>';
					var baseurl = getBaseURL();
					var scrollevent;
					var sIndex;var offSet;var isPreviousEventComplete;var isDataAvailable;
					$(window).scroll(function () {
						loadmoretab = $(".tab-pane.fade.in.active").attr('id');
						scrollevent = $("#"+loadmoretab+"_scroll").val();
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
								if(loadmoretab=="things"){
									$.ajax({
										type: "GET",
										url: baseurl+'searchviewmore?startIndex=' + sIndex + '&offset=' + offSet + '&searchString='+searchString,
										beforeSend: function () {
											$('#infscr-loading').show();
										},
										dataType: 'html',
										success: function (result) {
											$('#infscr-loading').hide();
											var response = $.trim(result.toString());
											var splitresponse=response.split("~|~");
											if ($.trim(response) != 'false') {
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
								else{

									$.ajax({
										type: "GET",
										url: baseurl+'searchpeople?startIndex=' + sIndex + '&offset=' + offSet + '&searchString='+searchString,
										beforeSend: function () {
											$('#infscr-loading').show();
										},
										dataType: 'html',
										success: function (result) {
											$('#infscr-loading').hide();
											var response = $.trim(result.toString());
											if ($.trim(response) != 'false') {
												$("."+loadmoretab+"_stream").append(response);
											}else {
												isDataAvailable = false;
											}
											sIndex = parseInt(sIndex) + parseInt(offSet);
											isPreviousEventComplete = true;
										}
									});
								}


							}
						}
					});
					function setindex()
					{
						var sIndex = 20, offSet = 20, isPreviousEventComplete = true, isDataAvailable = true;
					}
				</script>
