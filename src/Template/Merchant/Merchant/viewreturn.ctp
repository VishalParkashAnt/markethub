<style type="text/css">
 .pay-status
 {
		   font-size:13px;
 }
 .pay-to > b
 {
 	font-weight: 600;
 }
</style>
	
<div class="row">
  	<div class="col-12">
    	<div class="card">
      	<div class="card-block">
	         <h4 class="text-themecolor m-b-0 m-t-0">View Returned</h4>
         	<hr/>
        
         	<div class="table-responsive m-t-20">
					<div class="box-content">   
						<div class="containerdiv">
							<?php
							if (!empty($shippingModel['name']))
								$shippingAddress = '<b>'.$shippingModel['name']."</b>,</br>";
							if (!empty($shippingModel['address1']))
	                     $shippingAddress .= $shippingModel['address1'].",<br />";
	                  if (!empty($shippingModel['address2']))
	                    $shippingAddress .= $shippingModel['address2'].",<br />";
	                  if (!empty($shippingModel['city']))
	                     $shippingAddress .= $shippingModel['city'];
	                  if (!empty($shippingModel['zipcode']))
	                     $shippingAddress .= " - ".$shippingModel['zipcode'].",<br />";
	                  if (!empty($shippingModel['state']))
	                     $shippingAddress .= $shippingModel['state'].",<br />";
	                  if (!empty($shippingModel['country']))
	                  	$shippingAddress .= $shippingModel['country'].",<br />";
	                  if (!empty($shippingModel['phone']))
	                     $shippingAddress .= "Ph. : ".$shippingModel['phone'].".<br />";
	                  
	
	
	echo '<span class="pay-status">Payment to</span></br>';
	echo '<span class="pay-to"><b>'.$sellerModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">Email : '.$sellerModel['email']."</span>";
	echo '<div class="inv-clear"></div>';
	
    echo "<span class='pay-to'><b>Logistic Details: </b></span><br />";
	echo '<span class="pay-status">Shipment Date: '.date('d,M Y',$trackingModel['shippingdate']).'</span><br />';
	echo '<span class="pay-status">Tracking Id: '.$trackingModel['trackingid'].'</span><br />';
	echo '<span class="pay-status">Logistic Name: '.$trackingModel['couriername'].'</span><br />';
	echo '<span class="pay-status">Shipment Service: '.$trackingModel['courierservice'].'</span><br />';
    echo '<span class="pay-status">Additional Notes: '.$trackingModel['notes'].'</span><br />';
	echo '<span class="pay-status">Reason For Return: '.$trackingModel['reason'].'</span><br />';
	
	echo '<div class="inv-clear"></div>';
	echo '<div class="buyerdiv" style="height:auto;overflow:hidden;">';
	echo '<div class="buyerper" style="width:40%;float:left;">';
	echo '<span class="pay-status">Buyer Details</span></br>';
	echo '<span class="pay-to"><b>'.$userModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">Email : '.$userModel['email']."</span>";
	echo '</div>';
	echo '<div class="inv-shipping" style="width:40%;float:left;">';
	echo '<span class="pay-status">Shipping Address</span></br>';
	echo '<span class="pay-status">'.$shippingAddress.'</span>';
	echo '</div>';
	echo '</div>';
	
	echo '<div class="inv-clear"></div>';
	
	
	$totalprice = 0;
	$shipping = 0;
	$disCouunts = 0;
	$tax = 0;
	echo "<table class='tablesorter table table-striped table-bordered table-condensed'> <thead>
			<th class='pay-to'>Sellnu product id</th>
			<th class='pay-to'>Item Name</th>
			<th class='pay-to'>Item Quantity</th>
			<th class='pay-to'>Item Unitprice</th>
			<th class='pay-to'>Shipping fee</th>
			<th class='pay-to'>Total Price</th></thead>";
	foreach($orderItemModel as $key => $orderItem) {
		$count = $key + 1;
		echo "<tr class='pay-status'><td>".$orderItem['itemid']."</td>";
		echo "<td>".$orderItem['itemname']."</td>";
		echo "<td>".$orderItem['itemquantity']."</td>";
		echo "<td>".$currencySymbol.$orderItem['itemunitprice']."</td>";
		echo "<td>".$currencySymbol.$orderItem['shippingprice']."</td>";
		echo "<td>".$currencySymbol.($orderItem['itemprice'] + $orderItem['Order_items']['shippingprice'])."</td></tr>";
		$totalprice = $totalprice + $orderItem['itemprice'];
		$shipping = $shipping + $orderItem['shippingprice'];
		$disCouunts = $disCouunts + $orderItem['discountAmount'];
		$discountType = $orderItem['discountType'];
		$tax+=$orderItem['tax'];
		$tott = $totalprice;
		
	}
	echo  "</table>";
	
	 	
	$gtotal = $tott + $shipping + $tax;
	
	if($discountType=='Giftcard Discount')
	{
		       echo '<div style="float:left;">Gift Card Used : '.$discount_amount.' for this transaction.</div>';
	}	
	echo '<div style="margin-top:15px; float:right;">';
	echo '<table>
				<tr>
					<td align="left" style="width:200px;">
						<p class="gtotal pay-status">Item Total</p>
					</td>
					<td style="width:50px;"></td>
					<td class="pay-status" align="right" style="width:100px;">
						<p class="gtotal"><b>'.$tott.' '.$orderCurrency.'</b></p>
					</td>
				</tr>';
	if(!empty($disCouunts) && $discountType!='Giftcard Discount'){
		echo "<tr>
					<td align='left'>
						<p class='gtotal pay-status'> ".$discountType."</p>
					</td>
					<td style='width:50px;'></td>
					<td class='pay-status' align='right'>
						<p class='gtotal'><b>(-) ".$disCouunts." ".$orderCurrency."</b></p>
					</td>
				</tr>";
		$gtotal -=$disCouunts; 
	}	
	echo '<tr>
				<td align="left">
					<p class="gtotal pay-status">Shipping Fee</p>
				</td>
				<td style="width:50px;"></td>
				<td align="right" class="pay-status">
					<p class="gtotal"><b>'.$shipping.' '.$orderCurrency.'</b>
					</p>
				</td>
			</tr>';

	if($tax>0) {
		echo '<tr>
					<td align="left">
						<p class="gtotal pay-status">Tax</p>
					</td>
					<td style="width:50px;"></td>
					<td align="right" class="pay-status">
						<p class="gtotal">
							<b>'.$tax.' '.$orderCurrency.'</b>
						</p>
					</td>
				</tr>';
	}

	echo '<tr>
				<td colspan="3">
					<div id="horizonal" style="border-top: 1px solid black;"></div>
				</td>
			</tr>
			<tr>
				<td align="left">
					<p class="gtotal pay-to">Grand Total</p>
				</td>
				<td style="width:50px;"></td>
				<td align="right" class="pay-to">
					<p class="gtotal">
						<b>'.$gtotal.' '.$orderCurrency.'</b>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div id="horizonal" style="border-top: 1px solid black;"></div>
				</td>
			</tr>
	</table>';

	echo "</div>";
?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

