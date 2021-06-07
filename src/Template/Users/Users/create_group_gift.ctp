<?php
//unset($_SESSION['currency_code']);
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<section class="container-fluid side-collapse-container no_hor_padding_mobile margin_top165_mobile">
	<div class="container">
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="create_gift">
				<h2 class="find_new_heading extra_text_hide">
					<?php echo __d('user','Start a Group Gift Today');?></h2>
					<p class="extra_text_hide margin-bottom0 margin-top5">
						<?php echo __d('user','Gather your friends and give amazing gifts to the people you love');?></p>

						<ul class="margin-top20">
							<li class="active bold-font"><a href="<?php echo $baseurl.'create_group_gift/';?>"><?php echo __d('user','Create New Gift');?></a></li>
							<li><a href="<?php echo $baseurl.'group_gift_lists/';?>">
								<?php echo __d('user','Group Gift List');?></a></li>
							</ul>
						</div>
					</section>
					<?php
/*$itemid = "13";
$size = "Single";
$quantity = "3";*/
$itemid = "16";
$size = "";
$quantity = "3";
$ggurl = base64_encode($itemid.'-_-'.$size.'-_-'.$quantity);
$item_image = $itemdata['photos'][0]['image_name'];
if($item_image == "")
	$item_image = "usrimg.jpg";
//echo $ggurl;
//MTMtXy1TaW5nbGUtXy0z
//MTYtXy0tXy0z
if(!empty($loguser)){
	echo "<input type='hidden' id='loguserid' value='".$loguser['id']."' />";
	echo "<input type='hidden' id='featureditemid' value='".$detarr[0]."' />";
}else{
	echo "<input type='hidden' id='loguserid' value='0' />";
}

echo '<input type="hidden" id="listingid" value="'.$detarr[0].'" />';
echo '<input type="hidden" id="size_opt" value="'.$detarr[1].'" />';
echo '<input type="hidden" id="qty_opt" value="'.$detarr[2].'" />';
echo '<input type="hidden" id="lastestidgg" value="" />';
echo '<input type="hidden" id="totitemshipcost" value="" />';
echo '<input type="hidden" id="recepietName" value="" />';
echo '<input type="hidden" id="recepietcity" value="" />';
echo '<input type="hidden" id="sizeset" value="'.$sizeset.'" />';


?>
<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top20 no-hor-padding">
	<div class="text-center bold-font">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 border_right_grey gift_menu_active border_bottom_grey" id="ggtitle1">
			<h5 class="txt-uppercase">1. <?php echo __d('user','Choose recipient');?></h5>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 border_right_grey create_gift border_bottom_grey hide_mobile" id="ggtitle2">
			<h5 class="txt-uppercase">2. <?php echo __d('user','Personalize');?></h5>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 create_gift border_bottom_grey hide_mobile" id="ggtitle3">
			<h5 class="txt-uppercase">3. <?php echo __d('user','Ask for contributions');?></h5>
		</div>

	</div>


</section>
<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	<form onsubmit="return validggusersave();" id="ggform1">
		<div class="create_gift paading_btm0_gift">
			<div class="row">

				<input type="hidden" name="uid" value=""/>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
					<div id="show_url" class="choose_recipent_img img_center_mobile margin_btm5_giftMobile gg-userimg">
					</div>
					<input type="hidden" id="image_computer">
					<!--span class="edit_center"><a href="" class="red-txt img_center_mobile">Edit</a></span-->
					<div class="padding-bottom20 margin-top10">
						<label class="popup-label-text padding-bottom0">
							<?php echo __d('user','Recipient');?></label>
							<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Enter User Name or Email Address');?>" id="comment_msgemail" onkeypress="ajaxuserautocgroupemail(event,this.value, 'comment_msgemail','comment-autocompletegroupemailN');"  autocomplete="off"  i_id="0">
						</div>
						<div class="comment-autocompletegroupemail comment-autocompletegroupemailN" style="display: none;">
							<ul class="usersearchgroupemail dropdown-menu minwidth_33 padding-bottom0 padding-top0" role="menu" style="top:18%;margin-left: 15px;width: 92%;">

							</ul>
						</div>
						<span id='recipient_name_err' class='text' style='font-weight:bold;display:none;color:#FF0000;margin: -38px -195px 0 0;border:0;font-size:12px;'>
							<?php echo __d('user','Recipient name must be atleast 3 characters');?> </span>
							<span id='recipient_check_recipient_err' class='text' style='font-weight:bold;display:none;color:#FF0000;margin: -38px -195px 0 0;border:0;font-size:12px;'>
							<?php echo __d('user','Recipient name should not be same as creator.');?> </span>
							<span id='recipient_check_name_err' class='text' style='font-weight:bold;display:none;color:#FF0000;margin: -38px -195px 0 0;border:0;font-size:12px;'>
								<?php echo __d('user','Please choose the recipient from dropdown shown');?> </span>
							<ul class="user-list"></ul>

							<div class="padding-bottom20">
								<label class="popup-label-text padding-bottom0"><?php echo __d('user','Full Name');?></label>
								<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Enter Your Full Name');?>" name="name" id="name">
								<span id='name_err' class='text' style='font-weight:bold;display:none;color:#FF0000;font-size:12px;'> <?php echo __d('user','Full name must be atleast 3 characters');?> </span>
							</div>

							<div class="padding-bottom20">
								<label class="popup-label-text padding-bottom0"><?php echo __d('user','Address');?></label>
								<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Enter Your Street Name');?>" name="address1" id="address1">
								<span id='address1_err' class='text' style='font-weight:bold;display:none;color:#FF0000;font-size:12px;'> <?php echo __d('user','Address1 must be atleast 3 characters');?> </span>
							</div>

							<div class="padding-bottom20">
								<label class="popup-label-text padding-bottom0"><?php echo __d('user','Address Line');?></label>
								<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Address Line');?>" name="address2" id="address2">
							</div>
							<span id='address2_err' class='text' style='font-weight:bold;display:none;color:#FF0000;font-size:12px;'> <?php echo __d('user','Address2 must be atleast 3 characters');?> </span>

							<div class="padding-bottom20">

								<label class="popup-label-text padding-bottom0"><?php echo __d('user','Country');?></label>
								<div class="selectdiv full_width margin-bottom5">

									<select  name="countrygg" id="countrygg">
										<option value=""><?php echo __d('user','Select Country');?></option>
										<?php
										if (in_array(0, $possibleCountry)){
											foreach ($contry_datas as $country) {	?>
												<option value="<?php echo $country['id'];?>"><?php echo $country['country']; ?></option>
											<?php }
										}else{
											foreach ($contry_datas as $country) {
												if (in_array($country['id'], $possibleCountry)) { ?>
													<option value="<?php echo $country['id'];?>"><?php echo $country['country']; ?></option>
												<?php } }
											} ?>
										</select>

									</div>
									<br />
									<span class='text' style='color:green;font-size:12px;'><?php echo __d('user','Product can be shipped only to the listed countries');?>.</span>
									<br /><span id='country_err' class='text' style='font-weight:bold;display:none;color:#FF0000;font-size:12px;'> <?php echo __d('user','Select The Country');?> </span>
								</div>

								<div class="padding-bottom20">
									<label class="popup-label-text padding-bottom0"><?php echo __d('user','State');?></label>
									<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Enter Your State');?>" name="stategg" id="stategg">
								</div>
								<span id='state_err' class='text' style='font-weight:bold;display:none;color:#FF0000;font-size:12px;'> <?php echo __d('user','State must be atleast 2 characters');?> </span>

								<div class="padding-bottom20">
									<label class="popup-label-text padding-bottom0"><?php echo __d('user','City');?></label>
									<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Enter Your City');?>" name="citygg" id="citygg">
								</div>
								<span id='city_err' class='text' style='font-weight:bold;display:none;color:#FF0000;font-size:12px;'> <?php echo __d('user','City must be atleast 2 characters');?> </span>

								<div class="padding-bottom20">
									<label class="popup-label-text padding-bottom0"><?php echo __d('user','Zip Code');?></label>
									<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Enter Your zip code');?>" name="zipcodegg" id="zipcodegg">
								</div>
								<span id='zipcode_err' class='text' style='font-weight:bold;display:none;color:#FF0000;font-size:12px;'> <?php echo __d('user','Enter the Zipcode');?> </span>

								<div class="padding-bottom20">
									<label class="popup-label-text padding-bottom0">
										<?php echo __d('user','Mobile Number');?></label>
										<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Enter Your mobile number');?>" name="telephonegg" id="telephonegg" maxlength="11">
									</div>
									<span id='telephone_err' class='text' style='font-weight:bold;display:none;color:#FF0000;font-size:12px;'> <?php echo __d('user','Enter the Telephone number');?> </span>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
									<div class="gift_left_bottom_border">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 product_cnt margin_top15_mobile">
												<?php
												echo '<div class="gift_image" style="background-image:url('.SITE_URL.'media/items/original/'.$item_image.');background-repeat:no-repeat;">
												</div>';

												echo '<input type="hidden" id="fullimgtag" value="'.SITE_URL.'media/items/original/'.$item_image.'" />';
												?>
											</div>


										</div>
									</div>
								</div>


							</div>


						</div>
						<div class="create_gift border_top_grey">
							<button type="submit" class="edit_popup_button btn primary-color-bg transparent_border bold-font"><?php echo __d('user','Continue');?></button>
							<a href="javascript:history.back()" class="edit_popup_button margin-left10 btn primary-color-border-btn bold-font"><?php echo __d('user','Cancel');?></a>
						</div>
					</form>

					<form id="ggform2" class="nodisply">
						<div class="create_gift paading_btm0_gift">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
									<div class="padding-bottom15">
										<label class="popup-label-text padding-bottom0"><?php echo __d('user','Gift Title');?>:</label>
										<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Ex: Jenny\'s Birthday Gift');?>" id="ggift-title">
										<span id='title_err' class='text' style='display:none;color:#FF0000;font-size:13px;font-weight:bold;'> <?php echo __d('user','Title must be atleast 3 characters');?> </span>
									</div>


									<div class="padding-bottom15">

										<label class="popup-label-text padding-bottom0"><?php echo __d('user','Description');?>:</label>
										<textarea class="form-control popup-input font_size13" rows="5" placeholder="<?php echo __d('user','Ex: Lets celebrate Jenny\'s bdy and give her amazing gift!');?>" id="ggift-description"></textarea>
										<p class="margin-top5 margin-bottom0"><?php echo __d('user','Use your group gift description to share more about who you are raising contributions about and why');?></p>
										<span id='description_err' class='text' style='display:none;color:#FF0000;font-size:13px;font-weight:bold;'> <?php echo __d('user','Description must be atleast 10 characters');?> </span>
									</div>




									<div class="padding-bottom15">
										<label class="popup-label-text padding-bottom0"><?php echo __d('user','Note');?>:</label>
										<input class="form-control popup-input font_size13" placeholder="<?php echo __d('user','Enter note');?>" id="ggift-note">
										<p class="text-right margin-top5"><?php echo __d('user','You can leave a personlized not for merchant here');?></p>
									</div>

									<div id="final2err" style="font-size:13px;color:red;font-weight:bold;"></div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
									<div class="gift_left_bottom_border">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 product_cnt margin_top15_mobile">
												<?php
												echo '<div class="gift_image" style="background-image:url('.SITE_URL.'media/items/original/'.$item_image.');background-repeat:no-repeat;">
												</div>';

												echo '<input type="hidden" id="fullimgtag" value="'.SITE_URL.'media/items/original/'.$item_image.'" />';
												?>
											</div>

											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 product_cnt margin_top15_mobile">
												<h2 class="gift_heading text_center_gift extra_text_hide">
													<?php echo $itemdata['item_title'];
													?>
												</h2>
												<h5 class="bold-font text_center_gift">&#x200E;
													<!--CONVERT CURRENCY STARTS-->
													<?php
													if(isset($_SESSION['currency_code'])){
														echo $_SESSION['currency_symbol'];
														$currency_rate=$_SESSION['currency_value'];
													}
													else{?>&#x200E;<?php
														echo $_SESSION['default_currency_symbol'];
														$currency_rate=$_SESSION['default_currency_value'];
													}
													?>
													<!--CONVERT CURRENCY ENDS-->
													<?php 
													$itemprice=$currencycomponent->conversion($itemrate,$currency_rate,$itemdata['price']);
								//echo $itemprice;
													echo '<span class="subtotal_price" id="itemprice" style="float:none"></span>';
													?>
												</h5>
												<?php if($sizeset == 1) {  ?>
													<h6 class="regular-font font_size13 word_break"><?php echo __d('user','Size').": ";?> <span id="gg_update_size"> </span></h6>
												<?php } ?>
												<h6 class="regular-font font_size13 word_break"><?php echo __d('user','Quantity').": ";?> <span id="gg_update_qty"> </span></h6>
								<!--div class="size_qty_gift">
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt">
											<div class="selectdiv">
											<select>
												<option selected="">Size</option>
												<option>Medium</option>
												<option>XL</option>
												<option>XXL</option>
											</select>
											</div>
										</div>

										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt">
											<div class="selectdiv">
											<select>
												<option selected="">Quantity</option>
												<option>1</option>
												<option>2</option>
												<option>3</option>
											</select>
											</div>
										</div>
									</div>
								</div-->

								<div class="total_menu_gift">
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt">
											<h6 class="regular-font font_size13 word_break"><?php echo __d('user','Item Total');?></h6>
											<h6 class="regular-font font_size13 word_break"><?php echo __d('user','Shipping');?></h6>
											<h6 class="regular-font font_size13 word_break"><?php echo __d('user','Tax');?></h6>
										</div>

										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt text-right">
											<h6 class="regular-font font_size13">
												<?php
								//echo $itemdata['forexrate']['currency_symbol'];?>
								<!--CONVERT CURRENCY STARTS-->
								&#x200E;
								<?php
								if(isset($_SESSION['currency_code'])){
									echo $_SESSION['currency_symbol'];
								}
								else{?>&#x200E;<?php
									echo $_SESSION['default_currency_symbol'];
								}
								?>
								<!--CONVERT CURRENCY ENDS-->
								<span class="subtotal_price" id="totalscosts2" style="float:none"></span>
							</h6>
							<h6 class="regular-font font_size13">
								<?php
								//echo $itemdata['forexrate']['currency_symbol'];
								?>
								<!--CONVERT CURRENCY STARTS-->
								&#x200E;
								<?php
								if(isset($_SESSION['currency_code'])){
									echo $_SESSION['currency_symbol'];
								}
								else{?>&#x200E;<?php
									echo $_SESSION['default_currency_symbol'];
								}

								?>
								<!--CONVERT CURRENCY ENDS-->
								<span class="shipping_cost" id="shipscosts" style="float:none"></span>
							</h6>
							<h6 class="regular-font font_size13">
								<?php
								//echo $itemdata['forexrate']['currency_symbol'];
								?>
								<!--CONVERT CURRENCY STARTS-->
								&#x200E;
								<?php
								if(isset($_SESSION['currency_code'])){
									echo $_SESSION['currency_symbol'];
								}
								else{?>&#x200E;<?php
									echo $_SESSION['default_currency_symbol'];
								}
								?>
								<!--CONVERT CURRENCY ENDS-->
								<span class="sales_tax" style="float:none" id="sales_tax_val1"></span>
							</h6>
						</div>
					</div>
				</div>

				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt">
					<h6 class="regular-font font_size13"><?php echo __d('user','Goal Total');?></h6>
				</div>

				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt">
					<h6 class="regular-font font_size13 text-right">
						<?php
									//echo $itemdata['forexrate']['currency_symbol'];
						?>
						<!--CONVERT CURRENCY STARTS-->
						&#x200E;
						<?php
						if(isset($_SESSION['currency_code'])){
							echo $_SESSION['currency_symbol'];
						}
						else{?>&#x200E;<?php
							echo $_SESSION['default_currency_symbol'];
						}
						?>
						<!--CONVERT CURRENCY ENDS-->
						<span class="total_price" style="float:none" id="totalscosts" ></span>
					</h6>
				</div>
			</div>
		</div>
	</div>
</div>


</div>


</div>
<div class="create_gift border_top_grey">
	<a href="javascript:void(0);" onclick="show_gg_form1();" class="edit_popup_button btn primary-color-border-btn bold-font"><?php echo __d('user','Go Back');?></a>
	<a href="javascript:void(0);" onclick="createggift()" class="edit_popup_button margin-left10 btn primary-color-bg transparent_border bold-font"><?php echo __d('user','Create');?></a>
</div>
</form>

<form id="ggform3" class="nodisply">
	<div class="create_gift paading_btm0_gift">
		<div class="row border_bottom_grey padding-bottom15">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 border_left_grey_gift border_noMobile_gift text-center">
				<h5 class="regular-font"><?php echo __d('user','Ask Your friends to Contribute');?></h5>
				<div class="share-details-cnt margin-top15 margin-bottom15">
					<div class="share-details margin-top10 margin-bottom10">
						<a href="" class="share-icons fa fa-facebook-official facebook" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a>
						<a href="" class="share-icons fa fa-twitter-square twitter" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a>
						<a href="" class="share-icons fa  fa-google-plus-square google" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a>
						<a href="" class="share-icons fa fa-linkedin-square linkedin" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a>
						<a href="" class="share-icons fa fa-tumblr-square tumblr" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a>
					</div>
				</div>
				<span><?php echo __d('user','Easy to Contribute');?> </span>
			</div>
		</div>
		<div class="row  padding-top15">
			<h2 class="group_gift_summary hor-padding"><?php echo __d('user','Group Gift Summary');?></h2>
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 padding-top15 padding-bottom15">

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 padding-left0 padding-right0 padding_btm15_giftMobile">
					<?php
					echo '<div class="gift_image full_width autowidth" style="background-image:url('.SITE_URL.'media/items/original/'.$item_image.');background-repeat:no-repeat;">
					</div>';
					echo '<input type="hidden" id="fullimgtag" value="'.SITE_URL.'media/items/original/'.$item_image.'" />';
					?>

				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 padding_left0_gift">
					<h5 class="regular-font margin-top0" id="Usergifttitle"></h5>
					<div class="padding-top15">
						<h5><?php echo __d('user','Gift to');?></h5>
						<h5 id="UsergiftNamee"></h5>
						<h5 class="padding_btm15_giftMobile" id="Usergiftcity"></h5>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 border_left_grey_gift border_noMobile_gift ">
				<h2 class="group_gift_summary padding-left0 padding_right0"><?php echo __d('user','Group Gift Total');?></h2>
				<div class="total_menu_gift">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt">
							<h6 class="regular-font font_size13 word_break"><?php echo __d('user','Item Total');?></h6>
							<h6 class="regular-font font_size13 word_break"><?php echo __d('user','Shipping');?></h6>
							<h6 class="regular-font font_size13 word_break"><?php echo __d('user','Tax');?></h6>
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt text-right">
							<h6 class="regular-font font_size13">
								&#x200E;
								<!--CONVERT CURRENCY STARTS-->
								<?php
								if(isset($_SESSION['currency_code'])){
									echo $_SESSION['currency_symbol'];
								}
								else{?>&#x200E;<?php
									echo $_SESSION['default_currency_symbol'];
								}
								?>
								<!--CONVERT CURRENCY ENDS-->
								<?php
								//echo $itemdata['forexrate']['currency_symbol'];
								?>
								<span class="subtotal_price" id="totalscosts3" style="float:none"> </span>
							</h6>
							<h6 class="regular-font font_size13">
								<?php
								//echo $itemdata['forexrate']['currency_symbol'];
								?>
								<!--CONVERT CURRENCY STARTS-->
								&#x200E;
								<?php
								if(isset($_SESSION['currency_code'])){
									echo $_SESSION['currency_symbol'];
								}
								else{?>&#x200E;<?php
									echo $_SESSION['default_currency_symbol'];
								}
								?>
								<!--CONVERT CURRENCY ENDS-->
								<span class="shipping_cost" id="shipscosts1" style="float:none"></span>
							</h6>
							<h6 class="regular-font font_size13">
								<?php
								//echo $itemdata['forexrate']['currency_symbol'];
								?>
								<!--CONVERT CURRENCY STARTS-->
								&#x200E;
								<?php
								if(isset($_SESSION['currency_code'])){
									echo $_SESSION['currency_symbol'];
								}
								else{?>&#x200E;<?php
									echo $_SESSION['default_currency_symbol'];
								}
								?>
								<!--CONVERT CURRENCY ENDS-->
								<span class="sales_tax" style="float:none" id="sales_tax_val"></span>
							</h6>
						</div>
					</div>
				</div>
				<div class="total_menu_gift no_border">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt">
							<h6 class="regular-font font_size13"><?php echo __d('user','Goal Total');?></h6>
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 product_cnt">
							<h6 class="regular-font font_size13 text-right">
								<?php
										//echo $itemdata['forexrate']['currency_symbol'];
								?>
								<!--CONVERT CURRENCY STARTS-->



								&#x200E;
								<?php
								if(isset($_SESSION['currency_code'])){
									echo $_SESSION['currency_symbol'];
								}
								else{?>&#x200E;<?php
									echo  $_SESSION['default_currency_symbol'];
								}
								?>
								<!--CONVERT CURRENCY ENDS-->
								<span class="total_price" id="totalscosts1" style="float:none"></span>
							</h6>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="create_gift border_top_grey">
		<a href="javascript:void(0);" onclick="show_gg_form2();" class="edit_popup_button btn primary-color-border-btn bold-font"><?php echo __d('user','Go Back');?></a>
		<a href="javascript:void(0);" class="edit_popup_button btn_center_gift margin-left10 btn primary-color-bg transparent_border bold-font" id="gglistdone"><?php echo __d('user','Done');?></a>

		<p class="pull-right margin-bottom0 valid_text_gift margin-top10"><?php echo __d('user','This group gift is valid for');?> <span class="red-txt">7 <?php echo __d('user','days');?></span></p>
	</div>


</div>
</form>
</section>
</section>