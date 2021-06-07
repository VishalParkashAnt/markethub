
	<section class="container-fluid side-collapse-container no_hor_padding_mobile ">
		<div class="container" style="margin-top: 20px; margin-bottom: 20px;">


			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding vertical_margin20">
				<div class="create_gift">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

							<div class="birthday_profile margin_bottom20_991" style="background: url(<?php echo SITE_URL.'media/items/original/'.$item_datas['photos'][0]['image_name'];?>) no-repeat scroll 50% center /cover;height:450px;padding:20px;"></div>

					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div style="text-align:right">
	<a href="javascript:history.back()"><input type="button" class="btn btn-info" value="<?php echo __d('user','Back');?>"></a>
	</div>
						<div class="">
						<?php
						$itemid = base64_encode($item_datas['id']."_".rand(1,9999));
						echo '<a href="'.SITE_URL.'listing/'.$itemid.'"><h4 class="bold-font txt-uppercase">'.$item_datas['item_title'].'</h4></a>';
						echo '<h6 class="font_size13">'.$setngs['liked_btn_cmnt'].' '.__d('user','By').' '.$item_datas['fav_count'].' '.__d('user','People').'</h6>';
						echo '<h6 class="font_size13">'.__d('user','Qty').': <span>'.$items_list_data['itemquantity'].'</span></h6>';
						?>

						<?php
if($paidamt == ''){
	$paidamt = '0.00';
}else{
	$paidamt = $paidamt;
}

	$ggid = $items_list_data['id'];
	$timeleft = time() - $items_list_data['c_date'];
	$daysleft = round((($timeleft/24)/60)/60);
	//604800
	$datelast = $items_list_data['c_date'] + 3600;
	$statuss = $items_list_data['status'];

	if($statuss !='Active' && $statuss !='Completed'){
		$disabled = 'disabled';
		$items_list_data['status'] = 'Refunded';
	}elseif($statuss == 'Completed'){
		$disabled = 'disabled';
		$items_list_data['status'] = 'Completed';
	}elseif($datelast < time()){
		$disabled = 'disabled';
		$items_list_data['status'] = 'Expired';
	}

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
								<h5 class="bold-font font_size13" ><?php echo __d('user','Delivery Address');?></h5>
								<span style="word-wrap:break-word;">
								<?php
								echo $items_list_data['address1'].','.
								$items_list_data['address2'].','.
								$items_list_data['city'].','.
								$items_list_data['state'].','.
								$countrys_list_data['country'];
								?>
								</span>
							</div>

							

						</div>
					</div>
				</div>
				<div class="birthday_description">
					<h3 class="bold-font txt-uppercase margin-bottom5 margin-top10"><?php echo $items_list_data['title'];?></h3>
					<span style="word-wrap:break-word; width:30%"><?php echo $items_list_data['description'];?></span>
				</div>
				</div>
			</section>

			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">
				<div class="white_bg">
					<h5 class="bold-font border_bottom_grey padding15 margin-bottom0"><?php echo __d('user','Contributions');?>
					<?php
					if($items_list_data['status'] =='Expired' && $items_list_data['balance_amt'] != '0') {

					 if(count($refundbutton) != 0){ ?>
		<button id="giftamountrefund" style="float:right;" class="btn btn-primary claimedord">Refund</button>
<?php } 
} ?>
		
					</h5>

				</div>

<?php
$totContri = 0;
if(count($ggAmtDatas)>0){
foreach($ggAmtDatas as $key => $ggdata){
$totContri += $ggdata['amount'];
}
}
				$cost = $items_list_data['total_amt'];
				$remainContri = $cost - $totContri;
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
					echo '<span>'.$item_datas['forexrate']['currency_symbol'].$paidamt.'</span> / <span class="primary-color-txt padding-right10 padding_right0_rtl margin_left5_rtl">'.$item_datas['forexrate']['currency_symbol'].$items_list_data['total_amt'].'</span>';
					?>
					</h2>
					<hr class="hr_width">
					<div class="margin-bottom15">
					<span><?php echo __d('user','Pending Amount');?>: <span class="primary-color-txt padding-right10">
					<?php
					echo $item_datas['forexrate']['currency_symbol'].$remainContri;
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
					


				</div>
<?php
$totContri = 0;
if(count($ggAmtDatas)>0){
				echo '<div class="product_align_cnt col-sm-12 no-hor-padding margin-bottom10">
						<div class="item-slider grid col-xs-12 col-sm-12 mobile_nohor_padding">

		<div class="  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding product-sec-slide heroSlider-fixed">

         <!-- Slider -->
        <div class="slider responsive slick-initialized slick-slider" id="featured">';


foreach($ggAmtDatas as $key => $ggdata){


	$contributorimage = $ggdata['user']['profile_image'];
	if (empty($contributorimage)){
		$contributorimage = "usrimg.jpg";
	}
	$contributorname = $ggdata['user']['first_name'];
	$lday = date( "F j, Y " ,$ggdata['cdate']);

	if($ggdata['status'] == "" && $items_list_data['status'] == 'Expired')
	{
		$ggdata['status'] = 'Not Refunded';
	}

		echo '<div class="item1 box_shadow_img col-xs-3 col-lg-3 ">';

		echo '<div class="product_cnt">
			<div class="comment-row border_contribute">
				<div class="row hor-padding">
				<div class="sold-by-prof-pic-cnt img_contribute col-xs-2 col-lg-4">
				<a href="'.SITE_URL.'/people/'.$ggdata['username_url'].'">
					<div class="sold-by-prof-pic" style="background:url('.SITE_URL.'media/avatars/thumb70/'.$contributorimage.') no-repeat scroll 50% center/contain;height:70px;width: 70px;border-radius:50%;"></div>
				</a>
				</div>
				<div class="comment-section text_center768_1199 col-xs-10 col-lg-8 padding-right0 padding-left10">
					<div class="margin-top10 comment-txt">
					<a href="'.SITE_URL.'/people/'.$ggdata['user']['username_url'].'">
						<h5 class="font_size13 extra_text_hide padding-left10">'.$contributorname.'</h5>
					</a>
						<h5 class="font_size13">'.$lday.'</h5>
					</div>

				</div>
				</div>
				<div class="border_top_grey padding-top10 text-center">Contributed Amount: <span class="bold-font"> '.$item_datas['forexrate']['currency_symbol'].$ggdata['amount'].'</span><br><span class="bold-font red-txt" id="status'.$ggdata['id'].'">'.$ggdata['status'].'</span></div>
			</div>
		</div></div>';
		$totContri += $ggdata['amount'];
}

								echo '


            </div>

        <ul class="slick-dots" style="display: block;"><li class="slick-active" aria-hidden="false"><button type="button" data-role="none">1</button></li><li aria-hidden="true"><button type="button" data-role="none">2</button></li></ul>

				<!-- control arrows
				<div class="prev slick-disabled" style="display: block;">
					<span class="fa fa-angle-left" aria-hidden="true"></span>
				</div>
				<div class="next" style="display: block;">
					<span class="fa  fa-angle-right" aria-hidden="true"></span>
				</div> -->
				</div>
						  <!-- end Bottom to top-->
						</div>
				</div><!--end of carusol-->';
}

?>

				
			</section>
		</div>

	</section>

	<!--GROUP GIFT PAYMENT-->
	<form method="post" action="<?php echo SITE_URL.'braintree/checkouttokengroupgift/'?>" id="paymentForm" name="paymentbraintreegiftform">
	 <input type="hidden" name="giftamount" value="" id="giftamountb" >
	 <input type="hidden" name="itemid" value="<?php echo $item_datas['id']; ?>"/>
	 <input type="hidden" name="ggid" id="ggid" value="<?php echo $ggid; ?>"/>
	 <input type="hidden" name="currency" id="currency" value="<?php echo $item_datas['forexrate']['currency_code']; ?>"/>
	</form>
	<!--GROUP GIFT PAYMENT-->

	<script type="text/javascript">
	$('#customGroupgiftb').click(function(){
	var UserEntrAmt = parseFloat($('#ggamt').val());
	var totalcost = parseInt($('#costforitem').val());
	var giftamount = UserEntrAmt * 100;
	var remainContri = parseInt($('#remainingContribution').val());
	var totalContri = parseInt($('#totalContribution').val());
	var aftercontri = totalcost - (UserEntrAmt + totalContri);
	$('#giftamountb').val(UserEntrAmt);

	if(UserEntrAmt > totalcost){
	       $("#gifterr").show();
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
	       $("#gifterr").html("Contribution amount is high");
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
	setTimeout(function() {
		  $('#gifterr').fadeOut('slow');
		}, 5000);
	return false;
	}else if (aftercontri != 0 && 5 > aftercontri){
	       $("#gifterr").show();
	       $("#gifterr").html("Remaining Contribution should be greater than 4");
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
	setTimeout(function() {
		  $('#gifterr').fadeOut('slow');
		}, 5000);
	return false;
	}else if(totalcost>5)
	{
	if (5 > UserEntrAmt){
	       $("#gifterr").show();
	       $("#gifterr").html("Minimum Contribution should be 5");
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


		$('#giftamountrefund').click(function(){
			var tmp = confirm("Are you sure to refund amount to users ?");
			if(tmp == true)
			{
			var giftid=$('#ggid').val();
			var currency=$('#currency').val();
			var baseUrl=getBaseURL();
			$.ajax({
				url: baseUrl+"giftrefundamount",
				type: "post",
				data : { 'gid': giftid,'currency': currency },
				dataType: "text",
				success: function(responce){

					location.reload();
				
					//var res = responce.split('//');
					//for (i = 0; i < res.length; i++) { 
  					//	var result = res[i].split(,);
  					//	alert(result[0]);
					//}

				}
	  		});
			}
		});

	</script>