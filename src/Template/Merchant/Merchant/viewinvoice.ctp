<?= $this->Html->script('jQuery.print.js') ?>
		<?php
	$shippingAddress = $shippingModel['name'].",</br>";
	$shippingAddress .= $shippingModel['address1'].",</br>";
	if ($shippingModel['address2'] != '')
	$shippingAddress .= $shippingModel['address2'].",</br>";
	$shippingAddress .= $shippingModel['city']." - ".$shippingModel['zipcode'].",</br>";
	$shippingAddress .= $shippingModel['state'].",</br>";
	$shippingAddress .= $shippingModel['country'].",</br>";
	$shippingAddress .= "Phone no. :".$shippingModel['phone'];
	echo "<div class='invoicetitletab'>
			<div class='invoiccetitlehead'>"?><?php echo __d('merchant','Invoice');echo "</div>
			<div class='invoicetitleaction'>";
	echo '<!-- p class="inv-print fa fa-print m-0" style="font-size: 20px;"></p -->';
	echo '<p class="inv-close fa fa-times m-0" style="font-size: 20px;"></p>';
	
	echo "</div></div>";
	echo "<div id='userdata' class='userdata_invoice' style='margin-left:10px;'>";
	//echo '<button class="btn btn-danger inv-close" style="width: 90px; margin: 14px 6px 0px; font-size: 11px;float:right;">Back</button>';
	echo "<h2 class='inv-head' style='background: #EFEFEF; font-size: 18px; padding: 6px 10px;'>"?>
			<?php echo __d('merchant','Order');echo " #".$invoiceModel['invoiceno']." "?><?php echo __d('merchant','on');echo " ".date('m/d/Y',$invoiceModel['invoicedate'])."</h2>";
	echo "<div class='clearfix'><div style='width:40%;float:left;'><p class='pay-status' style='color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;'>"?><?php echo __d('merchant','Payment Method');echo " : ".$invoiceModel['paymentmethod']."</p>";
	if($orderDetails['deliverytype']=='pickup')
	{
		echo "<p class='pay-status' style='color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;'>"
		.__d('merchant','Delivery Type').': '.__d('merchant','Pickup').'</p>';
	} else {
		echo "<p class='pay-status' style='color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;'>"
		.__d('merchant','Delivery Type').': '.__d('merchant','Door Delivery').'</p>';
	} ?>

	<?php 
		if(strtolower($invoiceModel['invoicestatus']) == "refunded") {
			$inv_pay_status = "Cancelled";
		} else {
			$inv_pay_status = $invoiceModel['invoicestatus'];
		}
	echo "<p class='pay-status' style='color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;'>"?><?php echo __d('merchant','Payment Status');echo " : ". __d('merchant',$inv_pay_status)."</p></div></div>";
	//echo "<div><img src='".SITE_URL."barcode/INV_".$orderItemModel[0]['Order_items']['orderid'].".png' alt='".__d('merchant','Barcode')."' style='margin-top:12px;'></div>";
	echo '<div class="inv-clear"></div>';
	/* 
	echo '<span class="pay-status"  style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;">'?><?php echo __('Payment to');echo '</span></br>';
	echo '<span class="pay-to" style="font-size: 14px; font-weight: bold;">'.$sellerModel['Users']['first_name'].'</span></br>';
	echo '<span class="pay-status"  style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;">'?><?php echo __('Email');echo ' : '.$sellerModel['Users']['email']."</span>";
	echo '<div class="inv-clear" style="border-bottom: 1px solid #DEDEDE; margin-bottom: 14px; padding-top: 14px;"></div>';
	 */
	echo '<div class="buyerdiv">';
	echo '<div class="buyerper" style="display: inline-block; float: left; width: 50%;">';
	echo '<span class="pay-status"  style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;">'?><?php echo __d('merchant','Buyer Details');echo '</span></br>';
	echo '<span class="pay-to" style="font-size: 14px; font-weight: bold;">'.$userModel['first_name'].'</span></br>';
	echo '<span class="pay-status"  style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;">'?><?php echo __d('merchant','Email');echo ' : '.$userModel['email']."</span>";
	echo '</div>';
	echo '<div class="inv-shipping" style="display: inline-block; width: 50%;">';
	if($orderDetails['deliverytype']!='pickup')
	{
		echo '<span class="pay-status"  style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;">'?><?php echo __d('merchant','Shipping Address');echo '</span></br>';
	echo $shippingAddress;
	}
	echo '</div>';
	echo '</div>';
	echo '<div class="inv-clear" style="border-bottom: 1px solid #DEDEDE; margin-bottom: 14px; padding-top: 14px;"></div>';
	
	
	
	$totalprice = 0;
	$shipping = 0;
	$tax = 0;
	$disCouunts = 0;
	echo "<table class='Item-details' style='border:1px solid;'> <thead style='background-color: #D3D3D3; color: #4D4D4D;'>
			<!-- th style='font-size: 14px;'>"?><?php echo __d('merchant','Product Id');echo ".</th -->
			<th style='font-size: 12px; text-align:center; font-weight:500; padding:5px 0px; width:300px;'>"?><?php echo __d('merchant','Product Name');echo "</th>
			<!-- th style='font-size: 12px; text-align:center; font-weight:500; padding:5px 0px;'>"?><?php echo __d('merchant','Barcode number');echo "</th -->
			<th style='font-size: 12px; text-align:center; font-weight:500; padding:5px 0px;'>"?><?php echo __d('merchant','Quantity');echo "</th>
			<th style='font-size: 12px; text-align:center; font-weight:500; padding:5px 0px;'>"?><?php echo __d('merchant','Size');echo "</th>
			<th style='font-size: 12px; text-align:center; font-weight:500; padding:5px 0px;'>"?><?php echo __d('merchant','Unit Price');echo "</th>
			<th style='font-size: 12px; text-align:center; font-weight:500; padding:5px 0px;'>"?><?php echo __d('merchant','Shipping Fee');echo "</th>
			<th style='font-size: 12px; text-align:center; font-weight:500; padding:5px 0px;'>"?><?php echo __d('merchant','Total Price');echo "</th></thead>";
	foreach($orderItemModel as $key => $orderItem) {
		$count = $key + 1;
				$totalprice = $totalprice + ($orderItem['itemunitprice']*$orderItem['itemquantity']);
				$itemprice = ($orderItem['itemunitprice']*$orderItem['itemquantity']) + $orderItem['shippingprice'];
		$shipping = $shipping + $orderItem['shippingprice'];
		$disCouunts = $disCouunts + $orderItem['discountAmount'];
		$discountType = $orderItem['discountType'];
		$tax+= $orderItem['tax'];
		$tott = $totalprice + $shipping;
		echo "<tr><!-- td style='font-size: 14px; padding: 6px ; width: 145px;text-align:center;'>".$orderItem['itemid']."</td -->";
		echo "<td style='font-size: 14px; padding: 6px; width: 145px;text-align:center; word-break:break-all;'>".$orderItem['itemname']."</td>";
		echo "<!-- td style='font-size: 14px; padding: 6px; width: 145px;text-align:center;'>".$orderItem['item_skucode']."</td -->";
		echo "<td style='font-size: 14px; padding: 6px; width: 145px;text-align:center;'>".$orderItem['itemquantity']."</td>";
		if(!empty($orderItem['item_size'])){		
		echo "<td style='font-size: 14px; padding: 6px; width: 145px;text-align:center;'>".$orderItem['item_size']."</td>";
		}
		else
		{
		echo "<td style='font-size: 14px; padding: 6px; width: 145px;text-align:center;'>N/A</td>";
		}	
		echo "<td style='font-size: 14px; padding: 6px; width: 145px;text-align:center;'>".$currencySymbol.$orderItem['itemunitprice']."</td>";
		echo "<td style='font-size: 14px; padding: 6px; width: 145px;text-align:center;'>".$currencySymbol.$orderItem['shippingprice']."</td>";
		echo "<td style='font-size: 14px; padding: 6px; width: 145px;text-align:center;'>".$currencySymbol.$itemprice."</td></tr>";

	}
	echo  "</table>";
	$total_price = $totalprice;
	 		/*if(!empty($getcouponvalue)){
			 	if($getcouponvalue['Coupon']['coupontype'] == 'percent'){
			 		$discount = $getcouponvalue['Coupon']['discount_amount'];
			 		$discount = $totalprice * ($discount / 100);
			 		$totalprice -= $discount;
			 		
			 	}
			 	if($getcouponvalue['Coupon']['coupontype'] == 'fixed'){
			 		$discount = $getcouponvalue['Coupon']['discount_amount'];
			 		$totalprice = $totalprice - $discount;
			 		
			 	}
			 
			 }*/
	


	$gtotal = $totalprice + $shipping + $tax;
	$getcouponvalue = 60;
	//$discount_amount = 500;

	if($discountType=='Giftcard Discount')
	{
		       echo '<div style="float:left;">'.__d('merchant','Gift Card Used').' : '.$currencySymbol.$discount_amount.' for this transaction.</div>';
	}       
       echo '<div style="margin-top:12px;margin-left:450px;width:300px;">';
	echo '<table>
	<tr><td align="left" style="width:200px;"><p class="gtotal">'.__d('merchant','Product Total').$discount_amount.'</p></td><td style="width:50px;"></td>
	<td align="right" style="width:200px;"><p class="gtotal"><b>'.$total_price.' '.$currencyCode.'</b></p></td></tr>';
	if(!empty($disCouunts) && $discountType!='Giftcard Discount'){
		echo "<tr><td align='left'><p class='gtotal'> ".$discountType."</p></td><td style='width:50px;'></d><td align='right'><p class='gtotal'><b>(-) ".$disCouunts." ".$currencyCode."</b></p></td></tr>";
		$gtotal -=$disCouunts; 
	}

	echo '<tr><td align="left"><p class="gtotal">'.__d('merchant','Shipping Fee').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$shipping.' '.$currencyCode.'</b></p></td></tr>';
	if($tax>0)
	echo '<tr><td align="left"><p class="gtotal">'.__d('merchant','Tax').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$tax.' '.$currencyCode.'</b></p></td></tr>';
	
	echo '<tr><td colspan="2"><div id="horizonal" style="border-top: 1px solid black;width:300px;position: absolute;"></div></td></tr>
	<tr><td align="left"><p class="gtotal">'.__d('merchant','Grand Total').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$gtotal.' '.$currencyCode.'</b></p></td></tr>
	<tr><td colspan="2"><div id="horizonal" style="border-top: 1px solid black;width:300px;position: absolute;"></div></td></tr>
	</table>';  
	echo '</div>';
	
	/*echo '<div class="inv-tot" style="text-align:right;">';
	echo "<p class='gtotal'>"?><?php echo __('Item Total');echo " : ".$totalprice." ".$currencyCode."</p>";

	echo "<p class='gtotal'>"?><?php echo __('Shipping Fee');echo ": ".$shipping." ".$currencyCode."</p>";
	echo "<p class='gtotal'>"?><?php echo __('Tax');echo ": ".$tax." ".$currencyCode."</p>";
	echo "<p class='gtotal'>"?><?php echo __('Grand Total');echo ": ".$gtotal." ".$currencyCode."</p>";
	echo "</div>";*/
	echo "</div>";
	?>

	<script>
		$('.inv-close').click(function(){
		$('#invoice-popup-overlay').hide();
		$('#invoice-popup-overlay').css("opacity", "0");
		$('body').css("overflow-y", "visible");
	});
	$('.inv-print').click(function(){
		$(".userdata_invoice").print();
		return (false);
	});

	</script>
	
