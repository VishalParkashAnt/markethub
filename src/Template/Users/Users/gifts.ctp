
	<section class="container-fluid side-collapse-container no_hor_padding_mobile margin_top165_mobile">
		<div class="container">


			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="create_gift">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

							<div class="birthday_profile margin_bottom20_991" style="background: url(<?php echo SITE_URL.'media/items/original/'.$item_datas['photos'][0]['image_name'];?>) no-repeat scroll 50% center /contain;height:450px;padding:20px;"></div>

					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="">
						<?php
						$itemid = base64_encode($item_datas['id']."_".rand(1,9999));
						echo '<a href="'.SITE_URL.'listing/'.$itemid.'"><h4 class="bold-font txt-uppercase">'.$item_datas['item_title'].'</h4></a>';
						echo '<h6 class="font_size13">'.$setngs['liked_btn_cmnt'].' '.__d('user','By').' '.$item_datas['fav_count'].' '.__d('user','People').'</h6>';
						echo '<h6 class="font_size13">'.__d('user','Qty').': <span>'.$items_list_data['itemquantity'].'</span></h6>';
						?>
	<?php
		$ggimages = $items_list_data['image'];
		if(empty($ggimages)){
			$ggimages = "usrimg.jpg";
		}
		$recipientname = $items_list_data['name'];

		$createrimage = $createuserDetails['profile_image'];
		if(empty($createrimage)){
			$createrimage = "usrimg.jpg";
		}
		$creatorname = $createuserDetails['first_name'];
		$lday=date("F j, Y ",$items_list_data['c_date']);
	?>

							<div class="comment-row col-xs-12 col-sm-6">
							<div class="bold-font margin-bottom10"><?php echo __d('user','Recipient');?></div>
								<div class="sold-by-prof-pic-cnt col-xs-2 col-lg-3 padding-right0 padding-left0">
									<div class="sold-by-prof-pic" style="background:url(<?php echo $_SESSION['media_url'].'media/avatars/thumb70/'.$ggimages; ?>) no-repeat scroll 50% center/contain;height:70px;width: 70px;border-radius:50%;"></div>
								</div>
								<div class="comment-section col-xs-10 col-lg-9 padding-right0 padding-left10">
									<div class="margin-top10 comment-txt">
										<h5 class="font_size13 margin-right10"><?php echo $recipientname; ?></h5>
										<h5 class="font_size13 margin-right10"><?php echo $lday; ?></h5>
									</div>

								</div>
								</div>

								<div class="comment-row col-xs-12 col-sm-6">
										<div class="bold-font margin-bottom10"><?php echo __d('user','Creator');?></div>
											<div class="sold-by-prof-pic-cnt col-xs-2 col-lg-3 padding-right0 padding-left0">
												<div class="sold-by-prof-pic" style="background:url(<?php echo $_SESSION['media_url'].'media/avatars/thumb70/'.$createrimage;?>) no-repeat scroll 50% center/contain;height:70px;width: 70px;border-radius:50%;"></div>
											</div>
											<div class="comment-section col-xs-10 col-lg-9 padding-right0 padding-left10">
												<div class="margin-top10 comment-txt">
													<h5 class="font_size13 margin-right10"><?php echo $creatorname; ?></h5>
													<h5 class="font_size13 margin-right10"><?php echo $lday; ?></h5>
												</div>

											</div>
								</div>

							<div class="margin-bottom10">
								<h5 class="bold-font font_size13"><?php echo __d('user','Delivery Address');?></h5>
								<span>
								<?php
								echo $items_list_data['address1'].','.
								$items_list_data['address2'].','.
								$items_list_data['city'].','.
								$items_list_data['state'].','.
								$countrys_list_data['country'];
								?>
								</span>
							</div>

							<div class="share-details-cnt margin-top15 margin-bottom15">
							<h5 class="bold-font"><?php echo __d('user','Share to Your Friends');?></h5>
									<div class="share-details inlined-display margin-top10 margin-bottom10">
										<?php /*<a href="https://www.facebook.com/sharer.php?s=100&p[title]=Contribution Request from your friend&p[url]=<?php echo SITE_URL."gifts/".$items_list_data['id']; ?>&p[images][0]=<?php echo $_SESSION['media_url'].'media/items/thumb150/'.$item_datas['photos'][0]['image_name'];?>" onclick="javascript:MyPopUpWinsocialggfb(this);return false;" class="share-icons fa fa-facebook-official facebook"></a> */ ?>

										<?php /*<a href="javascript:void(0);" onclick="javascript:window.open('https://www.facebook.com/sharer.php?u=<?php echo $_SESSION['media_url'].'media/items/original/'.$item_datas['photos'][0]['image_name'];?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-facebook-official facebook" target="_blank"></a>*/ ?>

 
										<!--<a href="javascript:void(0);" onclick="javascript:window.open('https://www.facebook.com/dialog/share?app_id=<?php //echo $fbapp_id; ?>&display=popup&href=<?php //echo SITE_URL."gifts/".$items_list_data['id']; ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-facebook-official facebook" target="_blank"></a> -->
										
										<a href="javascript:void(0);" onclick="javascript:window.open('http://www.facebook.com/sharer.php?&display=popup&u=<?php echo SITE_URL."gifts/".$items_list_data['id']; ?>&t=<?php echo $_SESSION['media_url'].'media/items/original/'.$item_datas['photos'][0]['image_name'];?>&t=<?php echo $items_list_data['title'];?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600')" class="share-icons fa fa-facebook-official facebook">

										<!-- <a href="https://twitter.com/?status=" alt="Share this on twitter"     onclick="javascript:MyPopUpWinsocial(this);return false;" class="share-icons fa fa-twitter-square twitter"></a>
										
										<a href="https://www.linkedin.com/cws/share?url" alt="Share this on linkedin"         onclick="javascript:MyPopUpWinsocial(this);return false;" class="share-icons fa fa-linkedin-square linkedin"></a>
										<a href="https://www.tumblr.com/share/link?url="  onclick="javascript:MyPopUpWinsocial(this);return false;" class="share-icons fa fa-tumblr-square tumblr"></a> -->

										<a href="http://twitter.com/share?text=<?php echo $items_list_data['title'];?>&url=<?php echo SITE_URL."gifts/".$items_list_data['id']; ?>" alt="Share this on twitter"     class="share-icons fa fa-twitter-square twitter"></a>

										<a href="http://www.linkedin.com/cws/share?url=<?php echo SITE_URL."gifts/".$items_list_data['id']; ?>&title=<?php echo $items_list_data['title'];?>" alt="Share this on linkedin" class="share-icons fa fa-linkedin-square linkedin"></a>

										<a href="http://www.tumblr.com/share/link?url=<?php echo SITE_URL."gifts/".$items_list_data['id']; ?>&name=<?php echo $items_list_data['title'];?>" class="share-icons fa fa-tumblr-square tumblr"></a> 
										

										<input type="hidden" id="gift_shareurl" value="<?php echo SITE_URL."gifts/".$items_list_data['id']."_".$currentUser; ?>">
										<input type="hidden" id="gift_shareimg" value="<?php echo $_SESSION['media_url'].'media/items/original/'.$item_datas['photos'][0]['image_name'];?>">

									</div>
							</div>

						</div>
					</div>
				</div>
				<div class="birthday_description">
					<h3 class="bold-font txt-uppercase margin-bottom5 margin-top10"><?php echo $items_list_data['title'];?></h3>
					<span><?php echo $items_list_data['description'];?></span>
				</div>
				</div>
			</section>

			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">
				<div class="white_bg">
					<h5 class="bold-font border_bottom_grey padding15 margin-bottom0"><?php echo __d('user','Contributions');?></h5>
				</div>
	<?php
	if($paidamt == ''){
		$paidamt = '0.00';
	}else{
		$paidamt = $paidamt;
	}
	$currency_rate=$_SESSION['currency_value'];
	$paidamt = round($currencycomponent->conversion($gift_currency_rate,$currency_rate,$paidamt),2);
	$totalamt=round($items_list_data['total_amt'],2);
	$totalamt = round($currencycomponent->conversion($gift_currency_rate,$currency_rate,$totalamt),2);
	$ggid = $items_list_data['id'];
	$timeleft = time() - $items_list_data['c_date'];
	$daysleft = round((($timeleft/24)/60)/60,2);
	$datelast = $items_list_data['c_date'] + 3600;
	$statuss = $items_list_data['status'];
	$viewStatus='';
	if($statuss !='Active' && $statuss !='Completed'){
		$disabled = 'disabled';
		$viewStatus='none';
		$items_list_data['status'] = 'Refunded';
	}elseif($statuss == 'Completed'){
		$disabled = 'disabled';
		$viewStatus='none';
		$items_list_data['status'] = 'Completed';
	}elseif($datelast < time()){
		$disabled = 'disabled';
		$viewStatus='none';
		$items_list_data['status'] = 'Expired';
	}

?>
<?php
$totContri = 0;
if(count($ggAmtDatas)>0){
foreach($ggAmtDatas as $key => $ggdata){
$totContri += $ggdata['amount'];
}
}
				$cost = round($items_list_data['total_amt'],2);
				$remainContri = $cost - $totContri;
				$remainContri = round($currencycomponent->conversion($gift_currency_rate,$currency_rate,$remainContri),2);
				$cost = round($currencycomponent->conversion($gift_currency_rate,$currency_rate,$cost),2);
				$totContri = round($currencycomponent->conversion($gift_currency_rate,$currency_rate,$totContri),2);
				echo '<input type="hidden" id="lastestidggs" value="'.$items_list_data['id'].'" />';
				echo '<input type="hidden" id="costforitem" value="'.$cost.'" />';
				echo '<input type="hidden" id="itemidval" value="'.$item_datas['id'].'" />';
				echo '<input type="hidden" id="totalContribution" value="'.$totContri.'" />';
				echo '<input type="hidden" id="remainingContribution" value="'.$remainContri.'" />';
				$contributed = 0;
				if ($cost == $totContri){
					$contributed = 1;
				}
?>



				<div class="create_gift text-center">
					<h2 class="bold-font font_size15_mobile margin-top10">
					<?php
					echo '<span>&#x200E;'.$_SESSION['currency_symbol'].' '.$paidamt.'</span> / <span class="primary-color-txt padding-right10 padding_right0_rtl margin_left5_rtl">&#x200E;'.$_SESSION['currency_symbol'].' '.$totalamt.'</span>';
					?>
					</h2>
					<hr class="hr_width">
					<div class="margin-bottom15">
					<span><?php echo __d('user','Pending Amount');?>: <span class="primary-color-txt padding-right10">&#x200E;
					<?php
					echo $_SESSION['currency_symbol'].' '.round($remainContri,2);
					?>
					</span> </span>
				<?php
					switch($items_list_data['status']){
						case 'Expired':
							$color = 'color: #952525';
							$disabled = 'disabled';
							break;
						case 'Completed':
							$color = 'color: #252595';
							$disabled = 'disabled';
							break;
						case 'Active':
							$color = 'color: #259525';
							break;
					}

					if(empty($loguser)){
						$disabled = 'disabled';
					}
				?>
					<span><?php echo __d('user','Status');?>: <span class="red-txt padding-right10" style="<?php echo $color;?>">
					<?php echo __d('user',$items_list_data['status']); ?>
					</span></span>
					<span><?php echo __d('user','Total Contributors');?>: <span><?php echo count($paidUserId);?> People</span></span>
					</div>
					<div class="text-center create_gift" style="display:<?php echo $viewStatus;?>">
					<div class="gift-amt">
						<div class="no_find_people"></div>
						<h5 class="regular-font"><?php echo __d('user','Minimum contribution');?>:&#x200E;
						<?php 
						echo $_SESSION['currency_symbol'].' '.round(($totalamt * 5)/100,2);
						?>
						</h5>
			<input type="text" id="ggamt" class="popup-input col-xs-12 col-sm-12 col-md-4 col-lg-4 no-hor-padding" onkeyup="chknum(this,event);" placeholder="<?php echo __d('user','Enter Amount');?>" style="padding: 7px; margin: 4px 0px;color: inherit !important;float:none;" maxlength="6" >
							  <div id="gifterr" class="contribute-err col-lg-12 no-padding trn" style="font-size:13px;color:red;"></div>
								</div>

							</div>
								<div class="view-all-btn center_div btn primary-color-bg" style="display:<?php echo $viewStatus;?>">
									<a id="customGroupgiftb"><?php echo __d('user','Contribute Now');?></a>
								</div>


							</div>
<?php
$totContri = 0;
if(count($ggAmtDatas)>0){
				echo '<div class="product_align_cnt col-sm-12 no-hor-padding margin-bottom10">
						<div class="item-slider grid col-xs-12 col-sm-12 mobile_nohor_padding">

		<div class="  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding product-sec-slide heroSlider-fixed">

         <!-- Slider -->
        <div class="slider responsive" id="featured">';


foreach($ggAmtDatas as $key => $ggdata){
	$contributorimage = $ggdata['user']['profile_image'];
	if (empty($contributorimage)){
		$contributorimage = "usrimg.jpg";
	}
	$usernameurl = $ggdata['user']['username_url'];
	$contributorname = $ggdata['user']['first_name'];
	$lday = date( "F j, Y " ,$ggdata['cdate']);
	$ggdata['amount']=round($currencycomponent->conversion($gift_currency_rate,$currency_rate,$ggdata['amount']),2);

		echo '<div class="item1 box_shadow_img">';

		echo '<div class="product_cnt">
			<div class="comment-row border_contribute">
				<div class="row hor-padding">
				<div class="sold-by-prof-pic-cnt img_contribute col-xs-2 col-lg-4">
				<a href="'.SITE_URL.'people/'.$usernameurl.'">
					<div class="sold-by-prof-pic" style="background:url('.SITE_URL.'media/avatars/thumb70/'.$contributorimage.') no-repeat scroll 50% center/contain;height:70px;width: 70px;border-radius:50%;"></div>
				</a>
				</div>
				<div class="comment-section text_center768_1199 col-xs-10 col-lg-8 padding-right0 padding-left10">
					<div class="margin-top10 comment-txt">
					<a href="'.SITE_URL.'people/'.$usernameurl.'">
						<h5 class="font_size13 extra_text_hide padding-left10">'.$contributorname.'</h5>
					</a>
						<h5 class="font_size13 extra_text_hide padding-left10 ">'.$lday.'</h5>
					</div>

				</div>
				</div>
				<div class="border_top_grey padding-top10 text-center">Contributed Amount: <span class="bold-font"> '.$_SESSION['currency_symbol'].$ggdata['amount'].'</span></div>
			</div>
		</div></div>';
		$totContri += $ggdata['amount'];
}

								echo '


            </div>

        <ul class="slick-dots" style="display: block;"><li class="slick-active" aria-hidden="false"><button type="button" data-role="none">1</button></li><li aria-hidden="true"><button type="button" data-role="none">2</button></li></ul>

				<!-- control arrows -->
				<div class="prev preb slick-disabled" style="display: block;">
					<span class="fa fa-angle-left" aria-hidden="true"></span>
				</div>
				<div class="next nexb" style="display: block;">
					<span class="fa  fa-angle-right" aria-hidden="true"></span>
				</div>
				</div>
						  <!-- end Bottom to top-->
						</div>
				</div><!--end of carusol-->';
}

?>

				<div class="create_gift text-center">
				<span class="margin-top10"><?php echo __d('user','This Group Must recieve all contributions by');?> <span><?php $finaldate = $items_list_data['c_date'] + 604800;echo $lday=date("F j, Y ",$finaldate); ?></span> <?php echo __d('user','to be successful');?>. <span class="red-txt"><?php echo __d('user','Unsuccessful gift will be refunded');?>.</span></span>
				</div>
			</section>
		</div>

	</section>

	<!--GROUP GIFT PAYMENT-->
	<form method="post" action="<?php echo SITE_URL.'braintree/checkouttokengroupgift/'?>" id="paymentForm" name="paymentbraintreegiftform">
	 <input type="hidden" name="giftamount" value="" id="giftamountb" >
	 <input type="hidden" name="itemid" value="<?php echo $item_datas['id']; ?>"/>
	 <input type="hidden" name="ggid" value="<?php echo $ggid; ?>"/>
	 <input type="hidden" name="currency" value="<?php echo $_SESSION['currency_code']; ?>"/>
	</form>
	<!--GROUP GIFT PAYMENT-->

	<script type="text/javascript">
	$('#customGroupgiftb').click(function(){
	var UserEntrAmt = Math.round($('#ggamt').val()*100)/100;
	var totalcost = Math.round($('#costforitem').val()*100)/100;
	var minimumcontribute=(totalcost * 5)/100;
	var minimumcontribute=Math.round(minimumcontribute*100)/100;
	var giftamount = UserEntrAmt * 100;
	var remainContri = $('#remainingContribution').val();
	var totalContri = Math.round($('#totalContribution').val()*100)/100;
	//alert(totalcost+"***"+UserEntrAmt+"***"+totalContri);
	var aftercontri = totalcost - (UserEntrAmt + totalContri);
	aftercontri = Math.round(aftercontri*100)/100;
	$('#giftamountb').val(UserEntrAmt);
	//alert(totalcost);
	//alert(UserEntrAmt);
	//alert(totalContri);
	//alert(minimumcontribute);
	//alert(aftercontri);

	if(UserEntrAmt > totalcost){
	       $("#gifterr").show();
	       $("#gifterr").removeAttr('data-trn-key');
	       $("#gifterr").html("Entered amount is high");
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
	setTimeout(function() {
		  $('#gifterr').fadeOut('slow');
		}, 5000);
	return false;
	}else  if(UserEntrAmt > remainContri){
	       $("#gifterr").show();
	       $("#gifterr").removeAttr('data-trn-key');
	       $("#gifterr").html("Contribution amount is high");
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
	setTimeout(function() {
		  $('#gifterr').fadeOut('slow');
		}, 5000);
	return false;
	}else if (aftercontri != 0 && minimumcontribute > aftercontri){
	       $("#gifterr").show();
	       $("#gifterr").removeAttr('data-trn-key');
	       $("#gifterr").html("Remaining Contribution should be greater than"+" "+minimumcontribute);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
	setTimeout(function() {
		  $('#gifterr').fadeOut('slow');
		}, 5000);
	return false;
	}else if(totalcost>minimumcontribute)
	{
	if (minimumcontribute > UserEntrAmt){
	       $("#gifterr").show();
	       $("#gifterr").removeAttr('data-trn-key');
	       $("#gifterr").html("Minimum Contribution should be"+" "+minimumcontribute);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
	setTimeout(function() {
		  $('#gifterr').fadeOut('slow');
		}, 5000);
	return false;
	}
	}

	if(UserEntrAmt > 0){
	setTimeout("document.paymentbraintreegiftform.submit()", 2);

	} else {
	$("#gifterr").show();
	$("#gifterr").removeAttr('data-trn-key');
	       $("#gifterr").html("Please enter amount");
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
	setTimeout(function() {
		  $('#gifterr').fadeOut('slow');
		}, 5000);
	return false;

	}

	 return false;
	});

	</script>