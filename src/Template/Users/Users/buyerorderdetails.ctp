<?php
use Cake\Routing\Router;

$baseurl = Router::url('/');

//echo '<pre>'; print_r($orderModel); die;
?>

 <!-- breadcrumb start -->
<div class="container-fluid margin-top10 no_hor_padding_mobile">
  <div class="container">
<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
     <div class="breadcrumb">
      <a href="<?php echo $baseurl; ?>"><?php echo __d('user', 'Home'); ?></a>
      <span class="breadcrumb-divider1">/</span>
      <a href="#"><?php echo __d('user', 'My Orderss'); ?></a>
     
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
							<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<?php echo __d('user', 'My Orders'); ?> </h2>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin-top10 fint-height margin-bottom10 text-right responsive-text-center">
							<?php
						echo '<a href="' . SITE_URL . 'purchases" class="primary-color-txt"><i class="fa fa-angle-left margin-both5"></i> ' . __d('user', 'Back to My Orders') . ' </a>';
						?>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">

							<h3 class="section_heading font13 bold-font margin0 extra_text_hide no-hor-padding padding-bottom15"><?php echo __d('user', 'Order Details'); ?></h3>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top10 padding-bottom10 hor-padding border">
								<div class="inline-block"><?php echo __d('user', 'Status'); ?>: </div>
								<?php
							if ($orderModel['status'] != '' && $orderModel['status'] != 'Paid') {
								echo '<div class="inline-block green-txt">' . __d('user', $orderModel['status']) . '</div>';
								$orderStatusSelfi = $orderModel['status'];
							} elseif ($orderModel['status'] != 'Paid') {
								echo '<div class="inline-block green-txt">' . __d('user', 'Pending') . '</div>';
								$orderStatusSelfi = 'Pending';
							} else {
								echo '<div class="inline-block green-txt">' . __d('user', 'Delivered') . '</div>';
								$orderStatusSelfi = 'Delivered';
							}
							?>
							</div>
							
	<?php
if (count($trackingModel) == 0) {
	echo '<div class="trck-detail col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top10 padding-bottom10 hor-padding border"><div class="inline-block">' . __d('user', 'Tracking Details Not yet updated') . '</div></div>';
} else {
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 padding-top10 padding-bottom10 hor-padding border grey-color-bg">
								<div class="ship-detail padding-bottom10 clearfix ">';
	echo '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 padding-top5 padding-bottom5 no-hor-padding">
			<div class="inline-block">' . __d('user', 'Shipment Date') . ': </div>
			<div class="inline-block">' . date('d,M Y', $trackingModel['shippingdate']) . '</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 padding-top5 padding-bottom5 no-hor-padding">
			<div class="inline-block">' . __d('user', 'Shipping Method') . ': </div>
			<div class="inline-block">' . $trackingModel['couriername'] . ' </div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 padding-top5 padding-bottom5 no-hor-padding">
			<div class="inline-block">' . __d('user', 'Tracking Id') . ': </div>
			<div class="inline-block bold-font red-txt">' . $trackingModel['trackingid'] . '</div>
		</div>';
	echo '</div>';
	echo '<div class="addition-note padding-right10 padding-left10 padding-top10 padding-bottom10">
					<div class="margin-bottom10 bold-font extra_text_hide no-hor-padding">' . __d('user', 'Additional Notes') . ':</div>
					<p class="margin-bottom5">' . $trackingModel['notes'] . '</p>
				</div>';
	echo '</div>';
}
?>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top10 padding-bottom10 no-hor-padding">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 border_right_grey responsive-no-border">
							<?php
						echo '<div class="order-number order-number col-lg-10 col-md-10 col-sm-10 col-xs-12 no-hor-padding">
										<div class="listorder padding-top10 padding-bottom10 clearfix">
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . __d('user', 'Order Number') . ': </span>
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding"><b>' . $orderModel['orderid'] . '</b></span>
										</div>
										<div class="listorder padding-top10 padding-bottom10 clearfix">
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . __d('user', 'Seller') . ':  </span>
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding"><a class="primary-color-txt" href="javascript:void(0);">' . $merchantModel['first_name'] . '</a></span>
										</div>
										<div class="listorder padding-top10 padding-bottom10 clearfix">
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . __d('user', 'Order Date') . ': </span>
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . date('d, M Y', $orderModel['orderdate']) . '</span>
										</div>';
						if ($orderModel['status'] != "Delivered") {
						} else {
							echo '<div class="listorder padding-top10 padding-bottom10 clearfix">
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . __d('user', 'Deliver Date') . ': </span>
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . date('d, M Y', $orderModel['deliver_date']) . '</span>
										</div>';
						}
						if ($orderModel['status'] != "Delivered") {
							$businessday = $itemModle[0]['businessday'];
							$business = str_split($businessday);
							$saledate = date('Y-m-d', $orderModel['orderdate']);
							$deliverydate = date("Y-m-d", strtotime($saledate . ' + 2 day'));
							if ($business[1] == 'd') {
								$expected_delivery = date("d, M Y", strtotime($deliverydate . ' + ' . $business[0] . ' day'));
								$expected_from = date("Y-m-d", strtotime($deliverydate . ' + ' . $business[0] . ' day'));
							} else {
								$original_business = $business[0] * 6;
								$expected_delivery = date("d, M Y", strtotime($deliverydate . ' + ' . $original_business . ' day'));
								$expected_from = date("Y-m-d", strtotime($deliverydate . ' + ' . $original_business . ' day'));
							}
							$expected_to = date("d, M Y", strtotime($expected_from . ' + 3 day'));
							$expected_at = date("d, M Y", strtotime($expected_at));
							echo '<div class="listorder padding-top10 padding-bottom10 clearfix">
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . __d('user', 'Expected Delivery Date') . ': </span>
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">'.$expected_at.'</span>
										</div>';
						}
						echo '<div class="listorder padding-top10 padding-bottom10 clearfix">
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . __d('user', 'Amount Paid') . ': </span>
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding"><span id="grandtot1"></span></span>
										</div>';
						echo '
										<div id="discount">
										<div class="listorder padding-top10 padding-bottom10 clearfix">
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . __d('user', 'Discount Type') . ': </span>
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding"><span id="disctype1"></span></span>
										</div>
										<div class="listorder padding-top10 padding-bottom10 clearfix">';

						echo '<div id="discountid">
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . __d('user', 'Discount Id') . ': </span>
											
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding"><span  id="discid1"></span></span></div>';

						echo '</div></div>';
						echo '
										<div class="listorder padding-top10 padding-bottom30 clearfix">
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . __d('user', 'Payment Method') . ':</span>
											<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-hor-padding">' . strtoupper($paymentmethod) . '</span>
										</div>
									</div>';
						?>

								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="order-customerdetail col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 no-hor-padding">
									<?php
								echo '<div class="custme-ordername">
											<h3 class="bold-font margin-top10">' . $userModel['first_name'] . '</h3>
											<p class="margin-bottom5">' . $shippingModel['address1'] . ',</p>';
								if (!empty($shippingModel['address2'])) {
									echo '<p class="margin-bottom5">' . $shippingModel['address2'] . ',';
								}
								echo '<p class="margin-bottom5">' . $shippingModel['city'] . ' - ' . $shippingModel['zipcode'] . ',</p>
											<p class="margin-bottom5">' . $shippingModel['state'] . ',</p>
											<p class="margin-bottom5">' . $shippingModel['country'] . ',</p>
											<br>
											<p class="margin-bottom5">Ph : ' . $shippingModel['phone'] . '.</p>
										</div>';
								?>
									</div>
								</div>

							</div>

							<div class="grey-color-bg col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top10 padding-bottom10 no-hor-padding margin-top2">
								<div class="purchaseitme clearfix">
		<?php
	$totalShipping = 0;
	$totalitemprice = 0;
	$grandtotal = 0;
	$coupgrandtot = 0;
	foreach ($itemModle as $item) {

		//echo '<pre>'; print_r($item); die;

		$totalprice = $item['itemunitprice'] + $item['shippingprice'];
		$totalShipping += $item['shippingprice'];
		$totalitemprice += $item['itemunitprice']*$item['itemquantity'];
		$disCouunts = $disCouunts + $item['discountAmount'];
		$tax += $item['tax'];
		$giftamou += $item['giftamount'];

		$itempri = $totalitemprice+$totalShipping+round($tax, 2);
		$total = $itempri - $giftamou;


		if ($item['discountType'] != "")
			$discountType = $item['discountType'];
		$discId = $item['discountId'];
		$taxtotal += ($item['itemunitprice']*$item['itemquantity'] * $tax) / 100;
		$grandtotal += $totalitemprice;
		$coupgrandtot += ($item['itemunitprice']*$item['itemquantity']) + $item['shippingprice'];

		if ($item['itemimage'] == "")
			$itemimage = "usrimg.jpg";
		else
			$itemimage = $item['itemimage'];
		echo '<!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top2 no-hor-padding">-->
				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 no-hor-padding"><div class="order-name-size">
				<div class="order-name-size">
					<div class="myorder-images border">
						<div class="purchas-image-item" style="background-image:url(' . $baseurl . 'media/items/thumb350/' . $itemimage . ');background-repeat:no-repeat;"></div>
					</div></div>
					</div></div>
					<div class="col-lg-6 col-md-5 col-sm-5 col-xs-12 no-hor-padding">
					<div class="image-detailsitem text-left responsive-text-center">
						<div class="fnt16 bold-font extra_text_hide">' . $item['itemname'] . ' </div>
						<!--<div class="purh-price"><span class="fnt16 bold-font">$150.00 </span> <span class="ofrc-txt text_grey_dark">
												<strike>$200.00</strike> 50% OFF</span>
											</div>-->';

						//echo $orderModel['status'];

						if($item['review'] == '' && ($orderModel['status'] == 'Delivered' || $orderModel['status'] == 'Paid'))
						{
							echo '<a class="txt-uppercase oder-option bold-font" id="'.$item["itemid"].'" href="javascript:void(0)" onclick="writereviews(this);">' . __d('user', 'Write review') . '</a>';	
						}elseif($item['review'] != '' && $orderModel['status'] == 'Delivered' || $orderModel['status'] == 'Paid'){
							echo '<a class="txt-uppercase oder-option bold-font" id="'.$item["itemid"].'" href="javascript:void(0)" onclick="editreviews(this);">' . __d('user', 'Edit review') . '</a>';
							echo '<input type="hidden" name="review_data" value="'.$item['review_data']['rating'].'~'.base64_encode($item['review_data']['reviews']).'" id="review_data" />';
							echo '<input type="hidden" name="review_id" value="'.$item['review'].'" id="review_id" />';
						}

						echo '<h6 class="">' . __d('user', 'Qty') . ': ' . $item['itemquantity'] . ' &nbsp; &nbsp; ';
		if (isset($item['itemsize']) && $item['itemsize'] != "")
			echo __d('user', 'Size') . ': ' . $item['itemsize'];
		echo ' </h6><input type="hidden" name="avg_rating" id="avg_rating" value="'.$item['avg_rating'].'" />
					</div></div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-hor-padding">
					<div class="middle-postion">
						<div class="add-self-name-btn">';
		if ($orderStatusSelfi == 'Delivered') {
			echo '<a class="btn primary-color-border-btn txt-uppercase oder-option bold-font" href="javascript:void(0)" onclick="showselfie(' . $item['itemid'] . ')" data-toggle="modal" data-target="#add-selfies">' . __d('user', 'Add selfies') . '</a>';

			
		}
		echo '</div>
					</div>
					</div>
				</div>';
	}
	$grandtotal += $tax;
	$coupgrandtot += $tax;
	?>

								</div>
							<!--</div>-->

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top10 padding-bottom10 no-hor-padding">
								<div class="order-btns padding-left5 padding-right5">
									<ul>

											<?php $orderid = $orderModel['orderid'];
										$orderModel['commentcount'] = $orderModelcommentcount; ?>
									<?php if ($orderModel['status'] == 'Delivered' && $orderModel['commentcount'] > 0 || $orderModel['status'] == 'Paid' && $orderModel['commentcount'] > 0) { ?>
									<li class="text-center margin-top5 margin-both5 margin-bottom5">
											<a data-target="#review-seller" data-toggle="modal" href="javascript:void(0)" class="btn primary-color-bg txt-uppercase oder-option bold-font" onclick="contactseller(<?php echo $orderid; ?>)">View Conversation</a>
										</li>
										<?php 
								} else if ($orderModel['status'] == 'Delivered' && $orderModel['commentcount'] == 0 || $orderModel['status'] == 'Paid' && $orderModel['commentcount'] == 0) {

								} else { ?>

											<li class="text-center margin-top5 margin-both5 margin-bottom5">
											<a data-target="#review-seller" data-toggle="modal" href="javascript:void(0)" class="btn primary-color-bg txt-uppercase oder-option bold-font" onclick="contactseller(<?php echo $orderid; ?>)">Contact seller</a>
										</li>
											<?php 
									} ?>
									
										<?php if ($orderModel['status'] == 'Shipped' && $orderModel['deliverytype'] != 'pickup') { ?>
										<li class="text-center margin-top5 margin-both5 margin-bottom5">
											<a data-target="#review-seller" data-toggle="modal" href="javascript:void(0)" class="btn btn btn-success txt-uppercase oder-option bold-font" onclick="markprocess_details(<?php echo $orderid; ?>,'Delivered')">Mark Received</a>
										</li>
										<?php 
								} ?>
								
<?php
if (count($disp_data) > 0) {
	echo '<li class="text-center margin-top5 margin-both5 margin-bottom5">
					<a class="btn red-btn txt-uppercase oder-option bold-font" href="javascript:void(0)" onclick="disputemsg(' . $orderModel['orderid'] . ');">' . __d('user', 'View Disputes') . '</a>
		</li>';
} else {
	if ($orderModel['status'] == "Delivered") {
		echo '<li class="text-center margin-top5 margin-both5 margin-bottom5">
					<a class="btn red-btn txt-uppercase oder-option bold-font" href="javascript:void(0)" onclick="dispute(' . $orderModel['orderid'] . ');">' . __d('user', 'Create Disputes') . '</a>
		</li>';
	}
}

			//if($orderModel['paymentmethod']=='COD')
			//{
if ($orderModel['status'] == "" || $orderModel['status'] == "Pending" || $orderModel['status'] == "Processing") {
	echo '<li class="text-center margin-top5 margin-both5 margin-bottom5">
							<a class="white-txt btn dark-grey-bg txt-uppercase oder-option bold-font" onclick="cancel_cod_order(' . $orderModel['orderid'] . ');" href="javascript:void(0)" data-toggle="modal" data-target="#cancel-order">' . __d('user', 'Cancel Order') . '</a>
						</li>';
}
			//}
?>

				<?php if ($orderModel['status'] == 'Shipped'){ ?>
										<li class="text-center margin-top5 margin-both5 margin-bottom5">
											<a data-target="#review-seller" data-toggle="modal" href="javascript:void(0)" class="btn btn-warning txt-uppercase oder-option bold-font" onclick="markclaim(<?php echo $orderid; ?>)">Claim</a>
										</li>
										<?php 
								} ?>

									</ul>
								</div>
							</div>
<?php 
echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20 padding-bottom0 no-hor-padding">
								<div class="text-right padding-top5 padding-bottom5 total-order-price">
									<span class="text-left margin-both10">' . __d('user', 'Item Total') . ': </span>
									<span class="order-rate margin-both5"> ' . $totalitemprice . ' ' . $currencyCode . '</span>
								</div>
								<div class="text-right padding-top5 padding-bottom5 total-order-price">
									<span class="text-left margin-both10">' . __d('user', 'Shipping Fee') . ': </span>
									<span class="order-rate margin-both5"> ' . $totalShipping . ' ' . $currencyCode . '</span>
								</div>';
if (!empty($disCouunts) && ($discountType == 'Giftcard Discount' || $discountType == 'Coupon Discount')) {
	$coupgrandtot -= $disCouunts;
	if($discountType != 'Giftcard Discount')
	{
		$total = $coupgrandtot;
		$giftamou = $disCouunts;
	}
	//$giftamou = $totalitemprice+$totalShipping+round($tax, 2);
	echo '<div class="text-right padding-top5 padding-bottom5 total-order-price" >
									<span class="text-left margin-both10" id="disctype">' . __d('user', $discountType) . ' </span>
									<span class="order-rate margin-both5" id="discamount"> (-) ' . $giftamou . " " . $currencyCode . '</span>
									<input type="hidden" value="0" id="discid">
								</div>';
	
}
if ($tax > 0) {
	echo '<div class="text-right padding-top5 padding-bottom5 total-order-price">
									<span class="text-left margin-both10">' . __d('user', 'Tax') . ': </span>
									<span class="order-rate margin-both5"> ' . round($tax, 2) . ' ' . $currencyCode . '</span>
								</div>';
}

	

echo '<div class="text-right padding-top10 padding-bottom10 margin-top5 margin-bottom5 grey-color-bg total-order-price">
									<span class="text-left margin-both10">' . __d('user', 'Order Total') . ':</span>
									<span class="order-rate margin-both5"><b id="grandtot">' . round($total, 2) . ' ' . $currencyCode . '</b></span>
								</div>';

echo '</div>';
?>
						</div>
		</div>
        	<input type="hidden" id="hiddenorderid" value="<?php echo $orderModel['orderid']; ?>" />
        	<input type="hidden" id="hiddenbuyeremail" value="<?php echo $userModel['email']; ?>" />
        	<input type="hidden" id="hiddenbuyername" value="<?php echo $userModel['first_name']; ?>" />
		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script type="text/javascript">
    $(document).ready(function(){
    	
	var grandtotal = $("#grandtot").html();
	$("#grandtot1").html(grandtotal);
	var disctype = $("#disctype").html();
	console.log("disctype="+disctype);
	if (typeof disctype == 'undefined') {
    $("#discount").hide();
	}
	else{
	$("#disctype1").html(disctype);
	var discamount = $("#discamount").html();
	$("#discamount1").html(discamount);

	var discid = $("#discid").html();
if(discid == 0)
{
	$("#discountid").hide();
}
else
{	$("#discountid").show();
	$("#discid1").html(discid);
}
	
	}
	
    });
</script>

	  <div class="modal fade" id="add-selfies" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-md sucessfull-dispute">

		  <!-- Modal content-->
		  <div class="modal-content text-center">
			<div class="modal-body clearfix">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<h2 class="bold-font text-center txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top10 padding-bottom15 no-hor-padding">
						<?php echo __d('user', 'Add your Selfies'); ?></h2>
						<div class="popup-heading-border"></div>
					<div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20 padding-bottom20 no-hor-padding">
						<img id="fashionimg" class="img-responsive border center-block" src="<?php echo SITE_URL . 'media/avatars/original/usrimg.jpg'; ?>" width="300">
					</div>
					<div class="share-cnt-row padding-top10 padding-bottom20 text-center">

						<a class="margin-bottom10 edit_popup_button btn txt-uppercase primary-color-bg bold-font transparent_border" href="javascript:void(0);">
		<input type="file" value="Browse..." class="file-input-area1 uploadimgbtn" id="uploadfashionfile" name="image" style="" onchange="uploadfashionfile()" accept="image/*"/>
						<?php echo __d('user', 'Upload'); ?></a>
						<a class="margin-bottom10 edit_popup_button btn txt-uppercase primary-color-border-btn bold-font margin-left10" href="javascript:void(0);" onclick="savefashionfile();"><?php echo __d('user', 'Save'); ?></a>
					</div>
					<div id="loadingimgg" class="nodisply"><img src="<?php echo SITE_URL . 'images/loading.gif'; ?>"></div>
						<div id="imageerror" class="statuspostimg-error trn" style="color: red;"></div>
								<input id="image_computer" class="celeb_name" type="hidden" value="" name="image">
								<input type="hidden" id="itemid" value="">
				</div>
			</div>
		</div>
	  </div>
	</div>

	<div class="modal fade" id="creat-dispute" role="dialog" tabindex="-1">
		<div class="modal-dialog">

		  <!-- Modal content-->
		  <div class="pop-up modal-content">
			<div class="pop-up-cnt modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<h2 class="login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user', 'Create a Dispute'); ?></h2>
						<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user', 'Order Id'); ?>:<span id="orderid"></span>
						</div>
							<form class="" method="post" action="<?php echo SITE_URL . 'userdispute'; ?>" onsubmit="return disputesendform();">
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="selectdiv select-div">
										<label>
											<?php
										if (count($subject_data) > 0) {
											$subjects = json_decode($subject_data['queries'], true);
										} else {
											$subjects = "";
										}
										?>
											<select name="data[Dispute][plm]" id="problem">
												<option value=""><?php echo __d('user', 'Choose One'); ?></option>
												<?php
											foreach ($subjects as $key => $subject) {
												echo '<option value="' . substr($subject, 0, 40) . '">' . substr($subject, 0, 70) . '</option>';
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
											<?php echo __d('user', 'Orders'); ?>
											</label>
											<input id="id_radio2" value="Item" name="data[Dispute][types]" type="radio">
											<label class="" for="id_radio2">
												<span></span>
												<?php echo __d('user', 'Items'); ?>
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
										<button type="submit" data-toggle="modal" data-target="#sucess-dispute" class="margin-bottom10 edit_popup_button btn txt-uppercase primary-color-bg bold-font transparent_border"><?php echo __d('user', 'Create Dispute'); ?></button>
										<button type="button" data-dismiss="modal" class="margin-bottom10 edit_popup_button btn white-color-bg txt-uppercase primary-color-border-btn bold-font margin-left10"><?php echo __d('user', 'Cancel'); ?></button>
									</div>

								</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	  </div>


	  <div id="writereview" class="modal fade" role="dialog">
							<div class="modal-dialog downloadapp-modal">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-body">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<div class="write-comment-container">
											<h2 class="bold-font margin-bottom10">
												<?php echo __d('user','Write a Review'); ?> <label class="primary-color-txt"><?php //echo $item_datas['item_title']; ?></label>
											</h2>

											<div id="ratingerrorspan">
													
												</div>
											<div class="rev_star_sec">
												
												<br/>
												<form id="ratingsForm0">
															<div class="stars margin_top5min">
																<input type="radio" name="star" class="star-1" id="star-1" />
																<label class="star-1" for="star-1" onclick="ratingClick('1');">1</label>
																<input type="radio" name="star" class="star-2" id="star-2" />
																<label class="star-2" for="star-2" onclick="ratingClick('2');">2</label>
																<input type="radio" name="star" class="star-3" id="star-3" />
																<label class="star-3" for="star-3" onclick="ratingClick('3');">3</label>
																<input type="radio" name="star" class="star-4" id="star-4" />
																<label class="star-4" for="star-4" onclick="ratingClick('4');">4</label>
																<input type="radio" name="star" class="star-5" id="star-5" />
																<label class="star-5" for="star-5" onclick="ratingClick('5');">5</label>
																<span></span>
															</div>
														</form>

												<div class="reviews	">
													<div class="current-rate">  </div>
												</div>
	
					<input type="hidden" id="rateval">
<!-- 					<input type="hidden" id="user_id" value="<?php echo $userModel['id']; ?>" />
 -->					<input type="hidden" id="item_id" value="">
					<input type="hidden" id="order_id" value="<?php echo $orderModel['orderid']; ?>">
													
											</div>


											<div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
												<textarea class="form-control" rows="5" id="review" maxlength="180"
													onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"
													autocomplete="off" placeholder="<?php echo __d('user','Write a Review'); ?>"></textarea>
												<div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
													<ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0"
														role="menu" style="border:none;"></ul>
												</div>
												<div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
													<button class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10"
														data-dismiss="modal" style="height:30px;">
														<?php echo __d('user','CANCEL'); ?></button>
													<button href="javascript:void(0);" id="commentssave" onclick="return submitreview();" style="height:30px;"
														class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10">
														<?php echo __d('user','SUBMIT'); ?></button>
												</div>
												<div id="cmnterr"
													style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px">
													Please enter comment</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

<div id="editreview" class="modal fade" role="dialog">
							<div class="modal-dialog downloadapp-modal">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-body">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<div class="write-comment-container">
											<h2 class="bold-font margin-bottom10">
												<?php echo __d('user','Edit review'); ?> <label class="primary-color-txt"><?php echo $item_datas['item_title']; ?></label>
											</h2>

											<div id="ratingerrorspan">
													
												</div>
											<div class="rev_star_sec">
												
												<br/>
												<!--<form id="ratingsForm0">
															<div class="stars margin_top5min">
																<input type="radio" name="star" class="star-1" id="star-1" />
																<label class="star-1" for="star-1" onclick="ratingClick('1');">1</label>
																<input type="radio" name="star" class="star-2" id="star-2" />
																<label class="star-2" for="star-2" onclick="ratingClick('2');">2</label>
																<input type="radio" name="star" class="star-3" id="star-3" />
																<label class="star-3" for="star-3" onclick="ratingClick('3');">3</label>
																<input type="radio" name="star" class="star-4" id="star-4" />
																<label class="star-4" for="star-4" onclick="ratingClick('4');">4</label>
																<input type="radio" name="star" class="star-5" id="star-5" />
																<label class="star-5" for="star-5" onclick="ratingClick('5');">5</label>
																<span></span>
															</div>
														</form>-->

														<fieldset class="rating">
									<input type="radio" id="star5" onclick="ratingClick('5');" name="rating" value="5">
									<label class="full" for="star5" title="Awesome - 5 stars">

									</label>
									<input type="radio" id="star4half" onclick="ratingClick('4.5');" name="rating" value="4 and a half">
									<label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>

									<input type="radio" id="star4" onclick="ratingClick('4');" name="rating" value="4">
									<label class="full" for="star4" title="Pretty good - 4 stars"></label>

									<input type="radio" id="star3half" onclick="ratingClick('3.5');" name="rating" value="3 and a half">
									<label class="half" for="star3half" title="Meh - 3.5 stars"></label>

									<input type="radio" id="star3" onclick="ratingClick('3');" name="rating" value="3">
									<label class="full" for="star3" title="Meh - 3 stars"></label>

									<input type="radio" id="star2half" onclick="ratingClick('2.5');" name="rating" value="2 and a half">
									<label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>

									<input type="radio" id="star2" name="rating" value="2">
									<label class="full" for="star2" title="Kinda bad - 2 stars"></label>

									<input type="radio" id="star1half" onclick="ratingClick('2');" name="rating" value="1 and a half">
									<label class="half" for="star1half" title="Meh - 1.5 stars"></label>

									<input type="radio" id="star1" onclick="ratingClick('1');" name="rating" value="1" checked="checked">
									<label class="full" for="star1" title="Sucks big time - 1 star"></label>

									<input type="radio" id="starhalf" onclick="ratingClick('0.5');" name="rating" value="half">
									<label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
								</fieldset>

												<div class="reviews	">
													<div class="current-rate">  </div>
												</div>
	
					<input type="hidden" id="rateval">
					<input type="hidden" id="user_id" value="<?php echo $userModel['id']; ?>" />

					<input type="hidden" id="item_id" value="">
					<input type="hidden" id="order_id" value="<?php echo $orderModel['orderid']; ?>">
													
											</div>


											<div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
												<textarea class="form-control" rows="5" name="review" id="edit_review_data" maxlength="180"
													onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"
													autocomplete="off" placeholder="<?php echo __d('user','Write a Review'); ?>"></textarea>
												<div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
													<ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0"
														role="menu" style="border:none;"></ul>
												</div>
												<div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
													<button class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10"
														data-dismiss="modal" style="height:30px;">
														<?php echo __d('user','CANCEL'); ?></button>
													<button href="javascript:void(0);"  onclick="return updatereview(this);" id="" 
														class="btn filled-btn follow-btn primary-color-bg review_id pull-right margin-top10" style="height:30px;">
														<?php echo __d('user','SUBMIT'); ?></button>
												</div>
												<div id="cmnterr"
													style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px">
													<?php echo __d('user','Please enter comment'); ?></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>