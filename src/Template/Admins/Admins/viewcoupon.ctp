
<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Coupon Logs'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>admin/couponlog"><?php echo __d('admin', 'Coupon Logs'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'View Coupon'); ?></a></li>
                 </ol>
         </div>
    </div>
</div>
  
				<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'View Coupon'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    

	
						<div class="row-fluid">		
				<div class="box span12">

					<div class="box-content">


<body class=""> 

<?php
	
	
	$shippingAddress = '<b>'.$shippingModel['name']."</b>,</br>";
	$shippingAddress .= $shippingModel['address1'].",</br>";
	if ($shippingModel['address2'] != '')
	$shippingAddress .= $shippingModel['address2'].",</br>";
	$shippingAddress .= $shippingModel['city']." - ".$shippingModel['zipcode'].",</br>";
	$shippingAddress .= $shippingModel['state'].",</br>";
	$shippingAddress .= $shippingModel['country'].",</br>";
	$shippingAddress .= __d("admin", "Phone no. :").$shippingModel['phone'];
	
	
	echo '<span class="pay-status">'.__d('admin', 'Payment to').'</span></br>';
	echo '<span class="pay-to"><b>'.$sellerModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">'.__d('admin', 'Email :').$sellerModel['email']."</span>";
	echo '<div class="inv-clear"></div>';
	echo '<hr>';
	echo '<div class="buyerdiv" style="height:auto;overflow:hidden;">';
	echo '<div class="buyerper" style="width:40%;float:left;">';
	echo '<span class="pay-status">'.__d('admin', 'Buyer Details').'</span></br>';
	echo '<span class="pay-to"><b>'.$userModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">'.__d('admin', 'Email :').$userModel['email']."</span>";
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
	echo "<table class='tablesorter table table-striped table-bordered table-condensed'> <thead>
			<th>".__d("admin", "Sl no.")."</th>
			<th>".__d("admin", "Item Name")."</th>
			<th>".__d("admin", "Item Quantity")."</th>
			<th>".__d("admin", "Item Unitprice")."</th>
			<th>".__d("admin", "Total Price")."</th>
			<th>".__d("admin", "Shipping fee")."</th></thead>";
	foreach($orderItemModel as $key => $orderItem) {
		$count = $key + 1;
		echo "<tr><td>".$count."</td>";
		echo "<td>".$orderItem['itemname']."</td>";
		echo "<td>".$orderItem['itemquantity']."</td>";
		echo "<td>".$orderItem['itemunitprice']."</td>";
		echo "<td>".$orderItem['itemprice']."</td>";
		echo "<td>".$orderItem['shippingprice']."</td></tr>";
		$totalprice = $totalprice + $orderItem['itemprice'];
		$shipping = $shipping + $orderItem['shippingprice'];
		$disCouunts = $disCouunts + $orderItem['discountAmount'];
		$discountType = $orderItem['discountType'];
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
	
	
	$gtotal = $tott + $shipping;
	
	//$orderCurrency = $orderDetails['Orders']['currency'];
	
	echo '<div class="inv-tot" style="margin-top:12px;margin-left:700px;">';
	echo "<p class='gtotal'>".__d("admin", "Item Total:")." ".$tott." ".$orderCurrency."</p>";
	/* if(!empty($getcouponvalue)){
		echo "<p class='gtotal'>Coupon Discount: $".$discount."</p>";
	} */
	if(!empty($disCouunts)){
		echo "<p class='gtotal'> ".$discountType.": ".$disCouunts." ".$orderCurrency."</p>";
		$gtotal -=$disCouunts; 
	}
	echo "<p class='gtotal'>".__d("admin", "Shipping Fee:")." ".$shipping." ".$orderCurrency."</p>";
	echo "<p class='gtotal'>".__d("admin", "Grand Total:")." ".$gtotal." ".$orderCurrency."</p>";
	echo "</div></div>";
	echo "</div></div></div></div>";
echo '</div></div>';