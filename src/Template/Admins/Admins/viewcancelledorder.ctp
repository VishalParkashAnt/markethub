<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'View Order'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	shippedorders"><?php echo __d('admin', 'Shipped Orders'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'View Order'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'View Order'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">  
<?php
	echo "<div class='containerdiv'>";
	
	$shippingAddress = '<b>'.$shippingModel['name']."</b>,</br>";
	$shippingAddress .= $shippingModel['address1'].",</br>";
	if ($shippingModel['address2'] != '')
	$shippingAddress .= $shippingModel['address2'].",</br>";
	$shippingAddress .= $shippingModel['city']." - ".$shippingModel['zipcode'].",</br>";
	$shippingAddress .= $shippingModel['state'].",</br>";
	$shippingAddress .= $shippingModel['country'].",</br>";
	$shippingAddress .= __d("admin", "Phone no. ").":".$shippingModel['phone'];
		?>
	
	<div style="text-align:right">
	<a href="javascript:history.back()"><input type="button" class="btn btn-info" value="<?php echo __d('user','Back');?>"></a>
	</div>
	<?php
	
	echo '<span class="pay-status">'.__d('admin', 'Payment Method :').' <b>'.$paymentmethod.'</b></span><br />';
	if($orderDetails['deliverytype']=='pickup')
	{
		echo "<p class='pay-status'>"
		.__("Delivery Type").": ".__d("admin", "Pickup")."</p>";
	}	
	echo '<span class="pay-status">'.__d('admin', 'Payment to').'</span></br>';
	echo '<span class="pay-to"><b>'.$sellerModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">'.__d('admin', 'Email :').$sellerModel['email']."</span>";
	echo '<div class="inv-clear"></div>';
	echo '<hr>';
	echo '<div class="buyerdiv row" style="height:auto;overflow:hidden;">';
	echo '<div class="buyerper col-12 col-md-6" >';
	echo '<span class="pay-status">'.__d('admin', 'Buyer Details').'</span></br>';
	echo '<span class="pay-to"><b>'.$userModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">'.__d('admin', 'Email :').$userModel['email']."</span>";
	echo '</div>';
	echo '<div class="inv-shipping col-12 col-md-6" >';
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
			<th>".__d("admin", "Product id")."</th>
			<th>".__d("admin", "Item Name")."</th>
			<th>".__d("admin", "Item Quantity")."</th>
			<th>".__d("admin", "Item Unitprice")."</th>
			<th>".__d("admin", "Shipping fee")."</th>
			<th>".__d("admin", "Total Price")."</th></thead>";
	foreach($orderItemModel as $key => $orderItem) {
		$count = $key + 1;
		echo "<tr><td>".$orderItem['itemid']."</td>";
		echo "<td>".$orderItem['itemname']."</td>";
		echo "<td>".$orderItem['itemquantity']."</td>";
		echo "<td>".$currencySymbol.$orderItem['itemunitprice']."</td>";
		echo "<td>".$currencySymbol.$orderItem['shippingprice']."</td>";
		echo "<td>".$currencySymbol.(($orderItem['itemunitprice']*$orderItem['itemquantity']) + $orderItem['shippingprice'])."</td></tr>";
		$totalprice = $totalprice + ($orderItem['itemunitprice']*$orderItem['itemquantity']);
		$shipping = $shipping + $orderItem['shippingprice'];
		$disCouunts = $disCouunts + $orderItem['discountAmount'];
		$discountType = $orderItem['discountType'];
		$tax+=$orderItem['tax'];
		$tott = $totalprice;
		
	}
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
	$gtotal_admin_dis = $tott + $shipping + $tax;

	
	//$orderCurrency = $orderDetails['Orders']['currency'];
	if($discountType=='Giftcard Discount')
	{
		       echo '<div style="float:left;">'.__d('admin', 'Gift Card Used :').$currencySymbol.$discount_amount.__d('admin', 'for this transaction.').' </div>';
	}	
echo '<div style="margin-top:12px;" class="float-right">';
	echo '<table>
	<tr><td align="left" style="width:200px;"><p class="gtotal">'.__d('admin', 'Item Total').'</p></td><td style="width:50px;"></td><td align="right" style="width:100px;"><p class="gtotal"><b>'.$tott.' '.$orderCurrency.'</b></p></td></tr>';
	if(!empty($disCouunts) && $discountType!='Giftcard Discount'){
	//if(!empty($disCouunts) ){
		echo "<tr><td align='left'><p class='gtotal'> ".$discountType."</p></td><td style='width:50px;'></d><td align='right'><p class='gtotal'><b>(-) ".$disCouunts." ".$orderCurrency."</b></p></td></tr>";
		$gtotal -=$disCouunts; 
	}

	echo '<tr><td align="left"><p class="gtotal">'.__d('admin', 'Shipping Fee').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$shipping.' '.$orderCurrency.'</b></p></td></tr>';
	if($tax>0)
	echo '<tr><td align="left"><p class="gtotal">'.__d('admin', 'Tax').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$tax.' '.$orderCurrency.'</b></p></td></tr>';
	echo '
	<tr class="ver_border padding_top10"><td align="left"><p class="gtotal">'.__d('admin', 'Grand Total').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$gtotal_admin_dis.' '.$orderCurrency.'</b></p></td></tr>

	</table>';
	echo "</div>";
	echo "</div>";
	echo "</div>";
echo '</div></div>';
echo "</div>";
echo '</div></div>';
echo "</div>";
echo '</div></div>';