<?php
namespace Cake\I18n;
use Cake\I18n\Time;
$widgets = explode('(,)',$homepageModel['widgets']);
$sliders = json_decode($homepageModel['slider'], true);
$webslidercount = 0;
$appslidercount = 0;
foreach ($sliders as $key => $webslider) {
	if($webslider['mode'] == 'web')
		$webslidercount++;
	if($webslider['mode'] == 'app')
		$appslidercount++;
}
//echo"here thou reside";die;
//$slidercount = count($sliders);
$sliderProperty = json_decode($homepageModel['properties'], true);
$sliderstyle = "style='box-shadow:none;height:".$sliderProperty['sliderheight'].";background-color:".$sliderProperty['sliderbg'].";'";

$widgetSettings = json_decode($homepageModel['widget_settings']);
?>

 <div class="row">
      <section class="col-md-9 col-sm-12 no-hor-padding ">
      <section class="side-collapse-container mainPage">

         <section class="slider">
            <div class="banner"> 
            <?php
			  $sliderkey = 0;
			  //echo '<pre>';print_r($sliders);
			  //foreach($sliders as $skey => $slider){
			  	if($sliders[0]['mode'] == 'web'){ 
            	echo '<a href="'.$sliders[0]['link'].'" target="_blank" style="display:block;">
						  		<img src="'.SITE_URL.'images/slider/'.$sliders[0]['image'].'" alt="'.$sliders[0]['image'].'">
						  	</a>';
				 }?>
            </div>
         </section>
         <!--Daily Deals-->
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
				  console.log(output);
				  return output;
				}

				// Start the countdown
				setInterval(function() {
				    _date.setSeconds(_date.getSeconds() - 1);
				    document.getElementById('timer').innerHTML = parseDate(_date);
				}, 1000);
				 </script>
         <?php
		if(count($todaydeal) > 0)
		{
		?>
         <section class="new-arrivals paddigs todaysDeal clearfix">
            <div class="product_align_cnt  no-hor-padding">
               <div class="item-slider grid no-hor-padding">
                  <div class="section_header tdyDeal col-xs-12 col-sm-3 col-md-3 col-lg-3">
                     <div class="todayDeal">
                        <div>
                     <div class="deals"><h2 class="section_heading bold-font">
                        Todays Deal</h2></div>
                        <div class="timerToday deals">
                           <div class="timer"><img src="./img/Timer@2x.png" alt="timer"></div>
                           <div class="timerClock" id="timer"></div>
                        </div>
                     <div class="view-all-btn btn primary-color-bg primary-color-bg deals">
                        <a href="<?php echo SITE_URL.'viewmore/dailydeals';?>"><?php echo __d('user','View All');?></a>

                     </div>
                  </div>
                  </div>
                  </div>

                  <div
                     class=" col-xs-12 col-sm-7 col-md-8 col-lg-8  product-sec-slide heroSlider-fixed">
                    
                     <div class=" new_arrivals ar_center homeSlider">
                     	<?php
						//echo '<pre>'; print_r($data); die;
							foreach($todaydeal as $dealkey => $deal)
							{
								$itemid = base64_encode($deal->id."_".rand(1,9999));

								$item_title = $deal['item_title'];
								$item_title_url = $deal['item_title_url'];
								$item_price = $deal['price'];
								$favorte_count = $deal['fav_count'];
								$username = $deal['user']['username'];
								$currencysymbol = $deal['forexrate']['currency_symbol'];
								$items_image = $deal['photos'][0]['image_name'];



										$item_image = $deal['photos'][0]['image_name'];
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


									$itemprice = $deal['price'];
					$discountprice = $itemprice * ( 1 - $deal['discount'] / 100 );

					$item_url = base64_encode($deal['id']."_".rand(1,9999));

					$user_currency_price =  $currencycomponent->conversion($deal['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

					$user_currency_dealprice = $currencycomponent->conversion($deal['forexrate']['price'],$_SESSION['currency_value'],$discountprice);
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
						?>
                        <div class="item1 box_shadow_img">
                           <div class="product_cnt clearfix">
                              <div class="imgDescription">
                              <a class="img-hover1" href="<?php echo SITE_URL.'listing/'.$item_url; ?>">
                                 <div class="bg_product">
                                    <img src="<?php echo $itemimage; ?>" class="img-responsive">
                                 </div>
                              </a>
                              <div class="prodDescrip new_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                                 <div class="imgDes">
                                 <div class="deal_like">
                                 <a class=""
                                    href="<?php echo SITE_URL.'listing/'.$item_url; ?>">
                                     <div class="desCri"><?php echo $deal['item_title'];?></div> </a>
                                  <?php 
                                 echo '<div class="desIcon">
                            <div class="likeIcon" onclick="itemcou(' . $deal['id'] . ')">
                            ';
				            if (count($likeditemid) != 0 && in_array($deal['id'], $likeditemid)) {
								echo '<img src="' . SITE_URL . 'images/icons/Heart_after_like@2x.png" id="like-icon' . $deal['id'] . '" class="like-icon" alt="liked">
								<span style="display:none" class="like-txt' . $deal['id'] . ' nodisply" id="like-txt' . $deal['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
							} else {
								
								echo '<img src="' . SITE_URL . 'img/like.png" id="like-icon' . $deal['id'] . '" class="like-icon" alt="unliked">
								<span style="display:none" class="like-txt' . $deal['id'] . ' nodisply" id="like-txt' . $deal['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
							}
                            echo '</div>
                            <div class="shareIcon" onclick="share_posts(' . $deal['id'] . ')" data-toggle="' . $temp . '" data-target="' . $temp1 . '"><img src="' . SITE_URL . '/img/share.png" alt="share"></div>
                        </div></div>';?>   
                                 <div class="price ">
                                 <?php
                                   if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
											//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
											echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
											}
											else{?>&#x200E;<?php
											//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
												echo $deal['forexrate']['currency_symbol'].' '.$discountprice;
										}
											echo ' ';
										if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
											echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
										}
											else{?>&#x200E;<?php
										echo '<strike class="bold-font">'.$deal['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
									}
                                 ?>
                                 </div>
                                 <span id="price_vals6" price_val="$300"
                                    style="display:none;width:0px !important;"></span>
                                 </div>
                                 


                              </div>
                              </div>
                              
                           </div>

                        </div>
                        <?php }	?>
                        <!-- <div class="item1 box_shadow_img">
                           <div class="product_cnt clearfix">
                              <div class="imgDescription">
                              <a class="img-hover1" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                 <div class="bg_product">
                                    <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                 </div>
                              </a>

                              


                              <div class="prodDescrip new_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                                 <div class="imgDes">
                                 <a class=""
                                    href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                     <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>

                                 <div class="price ">
                                    $600
                                 </div>
                                 <span id="price_vals6" price_val="$300"
                                    style="display:none;width:0px !important;"></span>
                                 </div>
                                 
                              </div>
                              </div>
                              
                           </div>

                        </div> -->

                        
                     </div>

                  </div>
               </div>
            </div>
         </section>
         <?php }  
         
         ?>
         <section class="clearfix">
            <div class="allImg">
            	<?php
	if (isset($loguser['id']))
		echo '<input type="hidden" id="loguserid" value="' . $loguser['id'] . '">';
	else
		echo '<input type="hidden" id="loguserid" value="0">';

	echo '<input type="hidden" id="likebtncnt" value="' . $setngs['like_btn_cmnt'] . '" />';
	echo '<input type="hidden" id="likedbtncnt" value="' . $setngs['liked_btn_cmnt'] . '" />';
	?>

	<?php
	//echo count($item->toArray()); die;
	if (count($item->toArray()) != 0) {

		foreach ($item as $itms) {
			$itm_id = $itms['id'];
			$item_title_url = $itms['item_title_url'];
			$item_title = $itms['item_title'];
			$image_name = $itms['photos'][0]['image_name'];
			$price = $itms['price'];
			$user_id = $itms['user_id'];
			$item_price = $itms['price'];
			$item_default_price = round($itms['price'] * $itms['forexrate']['price'], 2);
			$itemid = base64_encode($itm_id . "_" . rand(1, 9999));
			$item_price = $itms['price'];
			$favorte_count = $itms['fav_count'];
			$username = $itms['user']['username'];
			$currencysymbol = $itms['forexrate']['currency_symbol'];
			$items_image = $itms['photos'][0]['image_name'];
					//$item_title = UrlfriendlyComponent::limit_char($item_title,12);

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


			$itemprice = $itms['price'];

			$user_currency_price = $currencycomponent->conversion($itms['forexrate']['price'], $_SESSION['currency_value'], $itemprice);

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

            echo '<div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="bg_product" id="item_cnt'.$itms['id'].'">
                    <img src="' . SITE_URL . 'media/items/original/' . $image_name . '" class="img-responsive">
                </div>
                <div class="prodDescrip new_prod_nam bold-font ">
                    <div class="prdDescrip">
                        <div class="imgDes">
                            <a class="" href="' . SITE_URL . 'listing/' . $itemid . '">
                                <div class="desCri">' . $item_title . '</div>
                            </a>
                            <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                        </div>
                        <div class="desIcon">
                            <div class="likeIcon" onclick="itemcou(' . $itms['id'] . ')">
                            ';
				            if (count($likeditemid) != 0 && in_array($itms['id'], $likeditemid)) {
								echo '<img src="' . SITE_URL . 'images/icons/Heart_after_like@2x.png" id="like-icon' . $itms['id'] . '" class="like-icon" alt="liked">
								<span style="display:none" class="like-txt' . $itms['id'] . ' nodisply" id="like-txt' . $itms['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
							} else {
								
								echo '<img src="' . SITE_URL . 'img/like.png" id="like-icon' . $itms['id'] . '" class="like-icon" alt="unliked">
								<span style="display:none" class="like-txt' . $itms['id'] . ' nodisply" id="like-txt' . $itms['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
							}
                            echo '</div>
                            <div class="shareIcon" onclick="share_posts(' . $itms['id'] . ')" data-toggle="' . $temp . '" data-target="' . $temp1 . '"><img src="' . SITE_URL . '/img/share.png" alt="share"></div>
                        </div>
                    </div>
                    ';
              
            $date = date('d');
			$month = date('m');
			$year = date('y');
			$tdy = strtotime($month . '/' . $date . '/' . $year);
			$newdate = strtotime($itms['dealdate']);
			//$newdate = new Time($itms['dealdate']);
			//$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);


			if (($itms['discount_type'] == 'daily' && $newdate == $tdy) || $itms['discount_type'] == 'regular') {
				echo '<div class="price ">';

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
 			
               echo '</div>
            </div>';
             }
             
	} else {
		echo '<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5>' . __d('user', 'No Products') . '</h5></div>';
	} ?>

	<input type="hidden" value="<?php echo $categoryId; ?>" id="hiddencatvalue">
	<input type="hidden" value="<?php echo $currentUrl; ?>" id="currentCatPath">
	<input type="hidden" value="0" id="offsetval">
	<input type="hidden" value="18" id="limitval">
	  
            </div>
            <?php 
           if (count($item->toArray()) != 0) { 
       			echo '<div class="view-all-btn loadMore btn primary-color-bg primary-color-bg deals"><a href="javascript:void(0);" onclick="loadmore();">Load more</a></div>';
       		}
         ?>
         </section>
      </section>
   </section>
      <section class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
         <div class="cateGory">
         <div class="category">
            <div id="sidebar">
               <div class="sidebar__inner border_right_grey" style="position: relative; ">
                  
         		<div id="accordion1" class="panel-group margin-bottom0">
				<div id="" class="panel panel-default box_shadow0">
					<div class="panel-heading padding0">
						<a data-toggle="collapse" data-parent="#accordion1" href="#collapsezero" class="" aria-expanded="true">
							<h4 class="panel-title bold-font filter_accordion accordion_shop primary-color-bg white-txt">
								<div class="inlined-display shop_filter_menu_padding">
									<?php echo __d('user', 'Filter'); ?></div><i class="more-less glyphicon glyphicon-minus bold-font white-txt"></i>
								</h4>
							</a>
						</div>
						<div id="collapsezero" class="colla-hei panel-collapse collapse in" aria-expanded="true">
							<div class="no-hor-padding padding-top0">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading padding0" role="tab" id="headingOne">
											<a role="button" class="accordion_one" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												<h4 class="panel-title accordion_shop bold-font">
													<div class="inlined-display shop_filter_menu_padding">
														<?php echo __d('user', 'Categories'); ?></div><!-- <i class="more-less glyphicon glyphicon-minus"></i> -->

													</h4>
												</a>
											</div>

											<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
												<div class="panel-body list_menu" style="max-height: 440px">
													<div class="panel-group" id="nested">
														<?php
														foreach ($parent_categories as $parent_cat) {
															$parentcatid = $parent_cat['id'];
															echo '<div class="panel panel-default box_shadow0">
															<div class="panel-heading">
															<div class="checkbox checkbox-primary">';
															if (count($sub_categories[$parentcatid]) <= 0) {
																echo '<a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-0-_-0" value="' . $parentcatid . '">

																' . __d('user',$parent_cat['category_name']) . '
																</a>
																';
															} else {
																$cls = 'shop_menu';
																//if (count($sub_categories[$parentcatid]) > 0)
																//$cls = 'shop_menu1';

																echo '
																<a class="'.$cls.'" data-parent="#nested" href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'">
																<h4 class="panel-title sub_menu_panel">
																' . __d('user',$parent_cat['category_name']);
																//if (count($sub_categories[$parentcatid]) > 0)
																	//echo '<i class="more-less glyphicon glyphicon-plus"></i>';
																echo '</h4>
																</a>
																';
															}
															echo '</div>
															</div><!--/.panel-heading -->';
															if (count($sub_categories[$parentcatid]) > 0) {
																echo '<div id="nested-collapseOne' . $parentcatid . '" class="panel-collapse collapse">
																<div class="pad_left25">
																';
																if (count($sub_categories[$parentcatid]) > 0) {
																	echo '<div class="checkbox checkbox-primary padding-bottom15">
																	<a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-0-_-0">
																	<h4 class="panel-title sub_menu_panel">
																	' . __d('user', 'View All') . '
																	</h4></a></div>
																	';
																}

																foreach ($sub_categories[$parentcatid] as $sub_cat) {

																	$subcatid = $sub_cat['categoryid'];
																	$subcatname = $sub_cat['category_name'];
																	echo '
																	<div class="checkbox checkbox-primary padding-bottom15">';
																	if (count($super_categories[$parentcatid][$subcatid]) <= 0) {
																		echo '<a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-' . $subcatid . '-_-0">' . __d('user',$subcatname) . '</a>';
																	} else {
																		echo '<a data-toggle="collapse" data-parent="#nested-collapseOne' . $parentcatid . '" href="#nested-collapseTwo' . $subcatid . '" class="shop_menu active">
																		' .__d('user', $subcatname ). '
																		<i class="more-less glyphicon glyphicon-plus"></i>
																		</a>';
																	}
										/*echo '<input id="'.$parentcatid.'-_-'.$subcatid.'-_-0" value="'.$parentcatid.'-'.$subcatid.'" type="checkbox" name="category">
										<label for="'.$parentcatid.'-_-'.$subcatid.'-_-0">
										<a data-toggle="collapse" data-parent="#nested-collapseOne'.$parentcatid.'" href="#nested-collapseTwo'.$subcatid.'" class="shop_menu active">
										'.$subcatname.'
										</a>
										</label>';*/
										echo '</div>
										';
										if (count($super_categories[$parentcatid][$subcatid]) > 0) {
											echo '<div id="nested-collapseTwo' . $subcatid . '" class="panel-collapse collapse">
											<div class="pad_left25">
											';

											if (count($super_categories[$parentcatid][$subcatid]) > 0) {
												echo '<div class="checkbox checkbox-primary padding-bottom15"><a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-' . $subcatid . '-_-0">' . __d('user', 'View All') . '</a></div>';
											}

											foreach ($super_categories[$parentcatid][$subcatid] as $super_cat) {
												$supercatid = $super_cat['categoryid'];
												$supercatname = $super_cat['category_name'];
												echo '
												<div class="checkbox checkbox-primary padding-bottom15">
												<a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-' . $subcatid . '-_-' . $supercatid . '">' . __d('user',$supercatname) . '</a>
												</div>
												';
											}
											echo '
											</div>
											</div>';
										}
									}
									echo '
									</div><!--/.panel-body -->
									</div><!--/.panel-collapse -->';
								}
								echo '</div><!-- /.panel -->';
							}
							?>

						</div>
					</div>
				</div>
			</div>


			</div>
                
         
         
                  </div>
         
               </div>
            </div>
         </div>
         </div>
         <object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>
         </div>
         </div>
         </div>
      </div>
      </section>
   </div>



<?php
//print_r($loguser); die;
if(isset($loguser['id'])){
	echo '<input type="hidden" id="loguserid" value="'.$loguser['id'].'">';
}
else{
	echo '<input type="hidden" id="loguserid" value="0">';
}
echo '<input type="hidden" id="likebtncnt" value="'.$setngs['like_btn_cmnt'].'" />';
echo '<input type="hidden" id="likedbtncnt" value="'.$setngs['liked_btn_cmnt'].'" />';

?>

<script type="text/javascript">
	


</script>