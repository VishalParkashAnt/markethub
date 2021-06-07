<?php
$message = "";
if(count($orderDetails)>0)
{
foreach($orderDetails as $ky => $orderDetail)
{
if($ky<10)
{
					$orderid = $orderDetail['orderid'];
					$usid = $loguser[0]['User']['id'];
							$message .= '<div class="my-orders padding-bottom10 clearfix" id="order_'.$orderid.'">
								<div class="first-row seller-view-row padding-top10 padding-bottom10 padding-right10 padding-left10 add-color-bg border_top_grey border_left_grey_shop border_right_grey clearfix">
									<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 no-hor-padding">
										<div class="negotian-by-info">
';
							foreach ($orderDetail['orderitems'] as $orderkey => $orderItem){
								if($orderkey == 0)
								{
								$message .= '<div class="negotaio-image">
												<div class="messag-img">
													<div class="clint-img admin-img" style="background-image:url('.$orderItem['itemimage'].');background-repeat:no-repeat;"></div>
												</div>
											</div>';
										$message .= '<div class="negotation-details margin-both15">
											<div class="bold-font margin-top0 margin-bottom5">'.$orderItem['itemname'].'</div>
												<p class="margin-bottom5"><span>'.__d('user','Size').': '.$orderItem['itemssize'].' </span> <span> '.__d('user','Qty').': '.$orderItem['quantity'].'</span></p>
												<p class="margin-bottom5">'.__d('user','Ordered On').' '.date('d/m/Y',$orderDetail['saledate']).'</p>
											</div>
										';
									}
							}
										$message .= '</div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top5 no-hor-padding">
											<div class="inline-block">'.__d('user','Seller').':</div>
											<span class="inline-block primary-color-txt">'.$orderDetail['sellername'].'</span>
										</div>
									</div>';
							foreach ($orderDetail['orderitems'] as $orderkeys => $orderItem){
								if($orderkeys == 0)
								{
									$message .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 no-hor-padding ">
										<div class="center-area">
											<div class="centered resp-pading">
												<p class="margin-bottom0  text-center"><b>'.$orderItem['cSymbol'].$orderItem['price'].'</b></p>

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
									$message .= '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-hor-padding ">
										<div class="center-area responsive-text-center order-status">
											<div class="centered resp-pading">
												<div>'.__d('user','Your order has been placed').'!</div>
												<div>
													<strong class="inline-block">Status :</strong>
													<span class="inline-block red-txt"> '.__d('user',$orderStatusCurrent).'</span>
												</div>
											</div>
										</div>

									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-hor-padding border listord animate-box fadeInDown animated">
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-5 text-center no-hor-padding">
										<a class="btn oder-option font-color" href="javascript:void(0);" onclick="loadpurchasedetails('.$orderid.')">'.__d('user','View Details').'</a>
									</div>';
			//if($orderDetail['paymentmethod']=='COD')
			//{
				if($orderDetail['status']=="" || $orderDetail['status']=="Pending" || $orderDetail['status']=="Processing")
				{
					$message .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none">
						<a class="btn border_left_grey_shop font-color oder-option" onclick="cancel_cod_order('.$orderid.');" href="javascript:void(0);" data-toggle="modal" data-target="#cancel-order">'.__d('user','Cancel Order').'</a>
					</div>';
				}
			//}
	$deliverdate = $orderDetail['deliver_update'];
	$timestamp = strtotime('+15 days', $deliverdate);
	$today = time();
	if ($orderDetail['status'] == 'Delivered' && $today<=$timestamp && $orderDetail['deliverytype'] != 'pickup'){
		//$message .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none returnmarker'.$orderid.'">
			//<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="markreturn('.$orderid.')">'.__d('user','Return').'</a>
		//</div>';
	}

	if ($orderDetail['status'] == 'Shipped' && $orderDetail['deliverytype'] != 'pickup'){
		$message .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none buyerstatusmarker'.$orderid.'">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="markprocess('.$orderid.',\'Delivered\')">'.__d('user','Mark Received').'</a>
		</div>';
	}
	if ($orderDetail['status'] == 'Shipped' && $orderDetail['trackingdetails'] > 0 && $orderDetail['deliverytype'] != 'pickup'){
		$message .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none claimmarker'.$orderid.'">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="markclaim('.$orderid.')">'.__d('user','Claim').'</a>
		</div>';
	}

	//$message .= '<div class="nodisply col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none returnmarker'.$orderid.'">
		//<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="markreturn('.$orderid.')">'.__d('user','Return').'</a>
	//</div>';

	if ($orderDetail['status'] == 'Delivered' && $orderDetail['commentcount']>0 || $orderDetail['status'] == 'Paid' && $orderDetail['commentcount']>0)
	{
		$message .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="contactseller('.$orderid.')">'.__d('user','View Conversation').'</a>
		</div>';
	}
	else if ($orderDetail['status'] == 'Delivered' && $orderDetail['commentcount']==0 || $orderDetail['status']=='Paid' && $orderDetail['commentcount']==0)
	{
	}
	else
	{
		$message .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="contactseller('.$orderid.')">'.__d('user','Contact Seller').'</a>
		</div>';
	}
	foreach($disp_data as $key=>$temp){
		 $uoid[] = $temp['uorderid'];
		 $keyor = array_search($orderid, $uoid);
	}
	if (in_array($orderid, $uoid))
	{
		$message .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="disputemsg('.$orderid.');">'.__d('user','View Disputes').'</a>
		</div>';
	}
	else
	{
		if($orderDetail['status']=="Delivered" || $orderDetail['status']=="Shipped")
				{
		$message .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none">
			<a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="dispute('.$orderid.');">'.__d('user','Create Disputes').'</a>
		</div>';
		}

	}


									$message .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7 border_left_grey_shop oder-option text-right padding-top10 padding-bottom10 no-hor-padding right-float">
										<div class="margin-both5">
											<div class="inline-block">'.__d('user','Order Total').': </div>
											<div class="inline-block bold-font margin-both5">'.$orderItem['cSymbol'].$orderDetail['price'].'</div>
										</div>
									</div>
								</div>
							</div>';


}}
	$result[] = $latestcount;
	$result[] = $message;
	$output = json_encode($result);
	echo $output;

}
else
{
	//echo 'false';
}
?>