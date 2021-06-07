<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>

 <!-- breadcrumb start -->
<div class="container-fluid margin-top10 no_hor_padding_mobile">
  <div class="container">
<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
     <div class="breadcrumb">
      <a href="<?php echo $baseurl;?>"><?php echo __d('user','Home');?></a>
      <span class="breadcrumb-divider1">/</span>
      <a href="#"><?php echo __d('user','My Orders');?></a>
     
     </div>
    </div>
     
  </div>
    </div>
    <!-- breadcrumb end -->

   
	<div class="container margin_top165_mobile">
		<div id="sidebar" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 no-hor-padding sidebar is-affixed" style="">
			<div class="sidebar__inner border_right_grey" style="position: relative; ">
				<div class="mini-submenu profile-menu">
			        <!--<span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>-->
			    </div>
			    <!--SETTINGS SIDEBAR PAGE-->
				<?php echo $this->element('settingssidebar'); ?>

    			<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

			</div>
		</div>

		<div id="content" class="col-lg-9 col-md-9 col-sm-12 col-xs-12 no-hor-padding clearfix min-height-profile">
			<div class="cnt-top-header border_bottom_grey col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo __d('user','My Orders');?>  </h2>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">

							<div class="display_none">
								<div class="text-center padding-top30 padding-bottom30">
									<div class="outer_no_div">
										<div class="empty-icon no-orders"></div>
									</div>
									<h5><?php echo __('user','No Order');?></h5>
								</div>
							</div>

						<div class="div-cover-box">
							<h3 class="section_heading font13 bold-font margin0 extra_text_hide no-hor-padding padding-bottom15"><?php echo __d('user','Recent Orders');?> </h3>
							<div class="myorderlisttbody">
<?php
if(count($orderDetails)>0)
{
foreach($orderDetails as $ky => $orderDetail)
{
	//print_r($orderDetail); die;
if($ky<10)
{
					$orderid = $orderDetail['orderid'];
					$usid = $loguser[0]['User']['id'];
							echo '<div class="my-orders padding-bottom10 clearfix" id="order_'.$orderid.'">
								<div class="first-row seller-view-row padding-top10 padding-bottom10 padding-right10 padding-left10 add-color-bg border_top_grey border_left_grey_shop border_right_grey clearfix">
									<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 no-hor-padding">
										<div class="negotian-by-info">
';
							foreach ($orderDetail['orderitems'] as $orderkey => $orderItem){
								if($orderkey == 0)
								{
								echo '<div class="negotaio-image">
												<div class="messag-img">
													<div class="clint-img admin-img" style="background-image:url('.$orderItem['itemimage'].');background-repeat:no-repeat;"></div>
												</div>
											</div>';
										echo '<div class="negotation-details margin-both15">
											<div class="bold-font margin-top0 margin-bottom5" style="word-break:break-all;">'.$orderItem['itemname'].'</div>
												<p class="margin-bottom5"><span>'.__d('user','Size').' '.': '.$orderItem['size'].' </span>  &nbsp; <span> '.__d('user','Qty').' : '.$orderItem['quantity'].'</span></p>
												<p class="margin-bottom5">'.__d('user','Ordered On').' '.date('d/m/Y',$orderDetail['saledate']).'</p>
											</div>
										';
									}
							}
										echo '</div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top5 no-hor-padding">
											<div class="inline-block">'.__d('user','Seller').' '.':</div>
											<span class="inline-block primary-color-txt" style = "text-transform: capitalize;">'.strtolower($orderDetail['sellername']).'</span>
										</div>
									</div>';
							foreach ($orderDetail['orderitems'] as $orderkeys => $orderItem){
							if($orderkeys == 0)
								{
									echo '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 no-hor-padding ">
										<div class="center-area">
											<div class="centered resp-pading">
												<p class="margin-bottom0  text-center"><b>&#x200E;'.$orderItem['cSymbol'].' '.$orderItem['price'].'</b></p>

											</div>
										</div>
									</div>';
								}
							}
							if ($orderDetail['status'] != '' && $orderDetail['status'] != 'Paid' && $orderDetail['status'] != 'Delivered'){
								$orderStatusCurrent = $orderDetail['status'];
								$statusColor = "#25A525";
							}elseif ($orderDetail['status'] != 'Paid' && $orderDetail['status'] != 'Delivered'){
								$orderStatusCurrent = "Pending";
								$statusColor = "#A52525";
							}else {
								$orderStatusCurrent = "Delivered";
								$statusColor = "#2525A5";
							}
									echo '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-hor-padding ">
										<div class="center-area responsive-text-center order-status">
											<div class="centered resp-pading">
												<div>'.__d('user','Your order has been placed').'!</div>
												<div>
													<strong class="inline-block">'; echo __d('user','Status');echo ' :</strong>
													<span class="inline-block red-txt" id="status'.$orderid.'"> '.__d('user',$orderStatusCurrent).'</span>
												</div>
											</div>
										</div>

									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-hor-padding border listord animate-box fadeInDown animated" id="statusbutton'.$orderid.'">
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-5 text-center no-hor-padding">
										<a class="btn oder-option font-color" href="javascript:void(0);" onclick="loadpurchasedetails('.$orderid.')">'.__d('user','View Details').'</a>
									</div>';


			//if($orderDetail['paymentmethod']=='COD')
			//{
				if($orderDetail['status']=="" || $orderDetail['status']=="Pending" || $orderDetail['status']=="Processing")
				{
					echo '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none">
						<a class="btn border_left_grey_shop font-color oder-option" onclick="cancel_cod_order('.$orderid.');" href="javascript:void(0);" data-toggle="modal" data-target="#cancel-order">'.__d('user','Cancel Order').'</a>
					</div>';
				}
			//}
	$deliverdate = $orderDetail['deliver_update'];
	$timestamp = strtotime('+15 days', $deliverdate);
	$today = time();
	if ($orderDetail['status'] == 'Delivered' && $today<=$timestamp && $orderDetail['deliverytype'] != 'pickup'){
		//echo '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none returnmarker'.$orderid.'">
			//<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="markreturn('.$orderid.')">'.__d('user','Return').'</a>
		//</div>';
	}

	if ($orderDetail['status'] == 'Shipped' && $orderDetail['deliverytype'] != 'pickup'){
		echo '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none buyerstatusmarker'.$orderid.'">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="markprocess('.$orderid.',\'Delivered\')">'.__d('user','Mark Received').'</a>
		</div>';
	}
	// if ($orderDetail['status'] == 'Shipped' || $orderDetail['trackingdetails'] > 0 && $orderDetail['deliverytype'] != 'pickup'){
	if ($orderDetail['status'] == 'Shipped'){
		echo '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none claimmarker'.$orderid.'">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="markclaim('.$orderid.')">'.__d('user','Claim').'</a>
		</div>';
	}

	//echo '<div class="nodisply col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none returnmarker'.$orderid.'">
		//<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="markreturn('.$orderid.')">'.__d('user','Return').'</a>
	//</div>';

	if ($orderDetail['status'] == 'Delivered' && $orderDetail['commentcount']>0 || $orderDetail['status'] == 'Paid' && $orderDetail['commentcount']>0)
	{
		echo '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none" id="contactseller'.$orderid.'">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="contactseller('.$orderid.')">'.__d('user','View Conversation').'</a>
		</div>';
	}
	else if ($orderDetail['status'] == 'Delivered' && $orderDetail['commentcount']==0 || $orderDetail['status']=='Paid' && $orderDetail['commentcount']==0)
	{
	}
	else
	{
		echo '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none" id="contactseller'.$orderid.'">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="contactseller('.$orderid.')">'.__d('user','Contact Seller').'</a>
		</div>';
	}
	foreach($disp_data as $key=>$temp){
		 $uoid[] = $temp['uorderid'];
		 $keyor = array_search($orderid, $uoid);
	}
	if (in_array($orderid, $uoid))
	{
		echo '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none" >
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="disputemsg('.$orderid.');">'.__d('user','View Disputes').'</a>
		</div>';
	}
	else
	{
		if($orderDetail['status']=="Delivered")
				{
		echo '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="dispute('.$orderid.');">'.__d('user','Create Disputes').'</a>
		</div>';
		

		}
	}


									echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7 border_left_grey_shop oder-option text-right padding-top10 padding-bottom10 no-hor-padding right-float">
										<div class="margin-both5">
											<div class="inline-block">'.__d('user','Order Total').' '.': </div>
											<div class="inline-block bold-font margin-both5">&#x200E;'.$orderItem['cSymbol'].' '.$orderDetail['price'].'</div>
										</div>
									</div>
								</div>
							</div>';


}}



}
else
{
	echo '<div class="">
								<div class="text-center padding-top30 padding-bottom30">
									<div class="outer_no_div">
										<div class="empty-icon no-orders"></div>
									</div>
									<h5>'.__d('user','No Order').'</h5>
								</div>
							</div>';
}
?>
						</div>
<?php
if(count($orderDetails)>9)
{

							echo '<div class="loadmorecomment centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20 trn" onclick="loadmorecomment('.$usid.')">
								<a href="javascript:void(0);">+ '.__d('user','Load More').'</a>
							</div>';
}
?>
					</div>
						</div>
					</div>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>

<script type="text/javascript">
var crntcommentcnt = '<?php echo count($orderDetails); ?>';
var order_id = '<?php echo $usid; ?>';
//alert (order_id);
var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 10;
var baseurl = getBaseURL();


	function loadmorecomment(upid){
		//alert(uid);
		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'getmorecommentviewpurchase',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt,'contact':'buyer','userid':upid},
				beforeSend: function(){
					$('.morecommentloader img').show();
				},
				success: function(responce){
					$('.morecommentloader img').hide();
					if (responce){
						var output = eval(responce);
				        $('.myorderlisttbody').append(output[1]);
				        loadmoreajax = 1;
						loadmorecmntcnt += 10;
					}else{
						loadmore = 0;
				        loadmoreajax = 1;
				        $('.loadmorecomment').html('No More Orders');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
				         $('.loadmorecomment').css('cursor','default');
					}
				}
			});
		}
	}



</script>

	<div class="modal fade" id="creat-dispute" role="dialog" tabindex="-1">
		<div class="modal-dialog">

		  <!-- Modal content-->
		  <div class="pop-up modal-content">
			<div class="pop-up-cnt modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<h2 class="login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','Create a Dispute');?></h2>
						<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','Order Id');?>:<span id="orderid"></span>
						</div>
							<form class="" method="post" action="<?php echo SITE_URL.'userdispute';?>" onsubmit="return disputesendform();">
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="selectdiv select-div">
										<label>
											<?php
											if(count($subject_data)>0)
											{
											$subjects = json_decode($subject_data['queries'], true);
											}
											else
											{
												$subjects = "";
											}
											?>
											<select name="data[Dispute][plm]" id="problem">
												<option value=""><?php echo __d('user','Choose One');?></option>
												<?php
												foreach($subjects as $key=>$subject){
													echo '<option value="'.substr($subject, 0, 40).'">'.substr($subject, 0, 70).'</option>';
												}
												?>
											</select>
										</label>
									</div>
								</div>
								<div id='alertName' class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding trn" style="color:red;"></div>
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<textarea class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="data[Dispute][msg]" id="message" maxlength="500"></textarea>
								</div>
								<div id='alertNamemsg' class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding trn"  style="color:red;"></div>
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding option-radio">
										<input id="id_radio1" value="Order" name="data[Dispute][types]" type="radio" checked="checked">
											<label class="" for="id_radio1">
												<span></span>
											<?php echo __d('user','Orders');?>
											</label>
											<input id="id_radio2" value="Item" name="data[Dispute][types]" type="radio">
											<label class="" for="id_radio2">
												<span></span>
												<?php echo __d('user','Items');?>
											</label>
									</div>
								</div>
								<div class="padding-bottom15 col-lg-12 col-md-12 col-sm-12 col-xs-12 no-hor-padding">
									<div id="itemlist" class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									</div>
								</div>
								<input type="hidden" id="disputeorderid" name="data[Dispute][orderid]">
								<div class="padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding text-right">
									<div class="share-cnt-row create-dispute-btn ">
										<button type="submit" data-toggle="modal" data-target="#sucess-dispute" class="margin-bottom10 edit_popup_button btn txt-uppercase primary-color-bg bold-font transparent_border"><?php echo __d('user','Create Dispute');?></button>
										<button type="button" data-dismiss="modal" class="margin-bottom10 edit_popup_button btn white-color-bg txt-uppercase primary-color-border-btn bold-font margin-left10"><?php echo __d('user','Cancel');?></button>
									</div>

								</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	  </div>