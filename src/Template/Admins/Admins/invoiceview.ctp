	<?php

	
	$shippingAddress = '<b>'.$shippingModel['name']."</b>,</br>";
	$shippingAddress .= $shippingModel['address1'].",</br>";
	if ($shippingModel['address2'] != '')
	$shippingAddress .= $shippingModel['address2'].",</br>";
	$shippingAddress .= $shippingModel['city']." - ".$shippingModel['zipcode'].",</br>";
	$shippingAddress .= $shippingModel['state'].",</br>";
	$shippingAddress .= $shippingModel['country'].",</br>";
	$shippingAddress .= __d("admin", "Phone no:").$shippingModel['phone'];
	echo "<div id='userdata' style='margin-left:10px;' class='invoice_datas'>";
	echo '<span class="inv-print glyphicons print" style="padding: 0px; font-size: 11px;cursor:pointer;left:610px;top:13px;"></span>';
	echo '<button id="btn_close" class="btn btn-danger inv-close" style="width: 90px; margin: 14px 6px 0px; font-size: 11px;float:right;" onclick="hideinvoice()">'.__d('admin', 'Back').'</button>';
	//echo '<p class="inv-close glyphicons remove_2"></p>';
	echo "<h2 class='inv-head'>Order #".$invoiceModel['invoiceno']." on ".date('m/d/Y',$invoiceModel['invoicedate'])."</h2>";
	echo '<hr>';
	echo "<p class='pay-status'>".__d("admin", "Payment Method")." : ".$invoiceModel['paymentmethod']."</p>";
	if($orderDetails['deliverytype']=='pickup')
	{
		echo "<p class='pay-status'>"
		.__("Delivery Type").":".__d("admin", "Pickup")."</p>";
	}	
	echo "<p class='pay-status'>".__d("admin", "Payment Status")." : ".$invoiceModel['invoicestatus']."</p>";
	echo '<div class="inv-clear"></div>';
	echo '<hr>';
	echo '<span class="pay-status">'.__d('admin', 'Payment to').'</span></br>';
	echo '<span class="pay-to"><b>'.$sellerModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">'.__d('admin', 'Email').' : '.$sellerModel['email']."</span>";
	echo '<div class="inv-clear"></div>';
	echo '<hr>';
	echo '<div class="buyerdiv" style="height:auto;overflow:hidden;">';
	echo '<div class="buyerper" style="width:40%;float:left;">';
	echo '<span class="pay-status">'.__d('admin', 'Buyer Details').'</span></br>';
	echo '<span class="pay-to"><b>'.$userModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">'.__d('admin', 'Email').' : '.$userModel['email']."</span>";
	echo '</div>';
	echo '<div class="inv-shipping" style="width:40%;float:left;">';
	echo '<span class="pay-status">'.__d('admin', 'Shipping Address').'</span></br>';
	echo $shippingAddress;
	echo '</div>';
	echo '</div><hr>';
	
	echo '<div class="inv-clear"></div>';
	
	
	
	$totalprice = 0;
	$shipping = 0;
	$disCouunts = 0;
	$tax = 0;
	echo "<table class='table-responsive tablesorter table table-striped table-bordered table-condensed'> <thead>
			<th>".__d("admin", "Sellnu product id")."</th>
			<th>".__d("admin", "Item Name")."</th>
			<th>".__d("admin", "Item Quantity")."</th>
			<th>".__d("admin", "Item Unitprice")."</th>
			<th>".__d("admin", "Shipping fee")."</th>
			<th>".__d("admin", "Total Price")."</th></thead>";
	
		echo "<tr><td>".$orderItemModel['itemid']."</td>";
		echo "<td>".$orderItemModel['itemname']."</td>";
		echo "<td>".$orderItemModel['itemquantity']."</td>";
		echo "<td>".$currencySymbol.$orderItemModel['itemunitprice']."</td>";
		echo "<td>".$currencySymbol.$orderItemModel['shippingprice']."</td>";
		echo "<td>".$currencySymbol.($orderItemModel['itemprice'] + $orderItemModel['shippingprice'])."</td></tr>";
		$totalprice = $totalprice + $orderItemModel['itemprice'];
		$shipping = $shipping + $orderItemModel['shippingprice'];
		$disCouunts = $disCouunts + $orderItemModel['discountAmount'];
		$discountType = $orderItemModel['discountType'];
		$tax+=$orderItemModel['tax'];
		$tott = $totalprice;
		
		echo  "</table>";
	
	 		/* if(!empty($getcouponvalue)){
			 	if($getcouponvalue['Coupon']['coupontype'] == 'percent'){
			 		$discount = $getcouponvalue['Coupon']['discount_amount'];
			 		$discount = $totalprice * ($discount / 100);
			 		$totalprice -= $discount;
			 		
			 	}
			 	if($getcouponvalue['Coupon']['coupontype'] == 'fixed'){
			 		$discount = $getcouponvalue['Coupon']['discount_amount'];
			 		$totalprice = $totalprice - $discount;
			 		
			 	}
			 
			 } */
	

	$gtotal = $tott + $shipping + $tax;
	
	//$orderCurrency = $orderDetails['Orders']['currency'];
	if($discountType=='Giftcard Discount')
	{
		       echo '<div style="float:left;">'.__d('admin', 'Gift Card Used').' : '.$currencySymbol.$discount_amount.__d('admin', ' for this transaction.').'</div>';
	}	
	echo '<div style="margin-top:12px;margin-left:430px;width:300px;">';
	echo '<table>
	<tr><td align="left" style="width:200px;"><p class="gtotal">'.__d('admin', 'Item Total').'</p></td><td style="width:50px;"></td><td align="right" style="width:100px;"><p class="gtotal"><b>'.$tott.' '.$orderCurrency.'</b></p></td></tr>';
	if(!empty($disCouunts) && $discountType!='Giftcard Discount'){
		echo "<tr><td align='left'><p class='gtotal'> ".$discountType."</p></td><td style='width:50px;'></d><td align='right'><p class='gtotal'><b>(-) ".$disCouunts." ".$orderCurrency."</b></p></td></tr>";
		$gtotal -=$disCouunts; 
	}	
	echo '<tr><td align="left"><p class="gtotal">'.__d('admin', 'Shipping Fee').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$shipping.' '.$orderCurrency.'</b></p></td></tr>';
	if($tax>0)
	echo '<tr><td align="left"><p class="gtotal">'.__d('admin', 'Tax').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$tax.' '.$orderCurrency.'</b></p></td></tr>';
	echo '<tr><td colspan="2"><div id="horizonal" style="border-top: 1px solid black;width:300px;position: absolute;margin-top: -6px;"></div></td></tr>
	<tr><td align="left"><p class="gtotal">'.__d('admin', 'Grand Total').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$gtotal.' '.$orderCurrency.'</b></p></td></tr>
	<tr><td colspan="2"><div id="horizonal" style="border-top: 1px solid black;width:300px;position: absolute;"></div></td></tr>
	</table>';
