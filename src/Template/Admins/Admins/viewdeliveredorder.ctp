<script src="https://checkout.stripe.com/checkout.js"></script>
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
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	deliveredorders"><?php echo __d('admin', 'Delivered Orders'); ?></a></li>
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
	$shippingAddress .= __d("admin", "Phone no. :").$shippingModel['phone'];

	$couponAmount = 0;
	foreach($orderItemModel as $orderItems) {
		if($orderItems['discountType']=='Coupon Discount')
			$couponAmount += $orderItems['discountAmount'];
	}
	$shareamount = $shareproducts['share_amount'];

	$order_totalcost_ognl = $orderDetails['totalcost'] + $orderDetails['tax'] + $orderDetails['totalCostshipp'] - $shareamount - $couponAmount;
	$order_totalcost = $orderDetails['totalcost'] + $orderDetails['tax'] + $orderDetails['totalCostshipp']- $orderDetails['admin_commission'] - $shareamount - $couponAmount;

	if($order_totalcost ==''){
		$amount = $order_totalcost_ognl;
	}else{
		$amount = $order_totalcost;
	}
	echo '<input type="hidden" value="'.$orderDetails['currency'].'" id="currency" />';
		?>
	
	<div style="text-align:right">
	<a href="javascript:history.back()"><input type="button" class="btn btn-info" value="<?php echo __d('user','Back');?>"></a>
	</div>
	<?php

		echo '<span class="pay-status" style="float:right;margin-top:15px;">'.__d('admin',
		'Seller payment mode is').' <b>'.__d('admin', 'Braintree').'</b></span>';


	echo '<span class="pay-status">'.__d('admin', 'Payment to').'</span></br>';
	echo '<span class="pay-to"><b>'.$sellerModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">'.__d('admin', 'Email :').$sellerModel['email']."</span></br>";
	echo '<span class="pay-status">'.__d('admin', 'Seller amount : ').'<b>'.$amount.' '.$orderDetails['currency']."</b></span>";


	?>
	<button id="customButton"  class="btn btn-success" style="margin-top:-14px; float:right; " onclick="approvebraintree();"><?php echo __d('admin','Approve');?></button>

<?php
	echo '<div class="inv-clear"></div>';


	echo '<hr>';
	echo '<div class="buyerdiv" style="height:auto;overflow:hidden;">';
	echo '<div class="buyerper" style="width:40%;float:left;">';
	echo '<span class="pay-status">'.__d('admin', 'Buyer Details').'</span></br>';
	echo '<span class="pay-to"><b>'.$userModel['first_name'].'</b></span></br>';
	echo '<span class="pay-status">'.__d('admin', 'Email :').' '.$userModel['email']."</span>";
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
	echo "<table class='tablesorter table table-striped table-bordered table-condensed'> <thead>
			<th>".__d("admin", "product id")."</th>
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
		echo "<td>".$currencySymbol.(($orderItem['itemunitprice']*$orderItem['itemquantity']) + $orderItem['Order_items']['shippingprice'])."</td></tr>";
		$totalprice = $totalprice + ($orderItem['itemunitprice']*$orderItem['itemquantity']);
		$shipping = $shipping + $orderItem['shippingprice'];
		$disCouunts = $disCouunts + $orderItem['discountAmount'];
		$discountType = $orderItem['discountType'];
		$tax+=$orderItem['tax'];
		$tott = $totalprice;

		$giftamou += $orderItem['giftamount'];

		$itempri = $totalprice+$shipping+round($tax, 2);
		$total = $itempri - $admin_commission - $shareamount;

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


	$gtotal = $tott + $shipping + $tax - $admin_commission - $shareamount;

	//$orderCurrency = $orderDetails['Orders']['currency'];

	if($discountType=='Giftcard Discount')
	{
		       echo '<div style="float:left;">'.__d('admin', 'Gift Card Used :').$discount_amount.__d('admin', ' for this transaction.').'</div>';
	}


	if($discountType=='User Credits')
	{
		       echo '<div style="float:left;">'.__d('admin', 'Credits Used :').$currencySymbol.$discount_amount.' '.__d('admin', 'for this transaction.').' </div>';
	}
	echo '<div style="margin-top:12px;margin-left:600px;width:300px;">';
	echo '<table>
	<tr><td align="left" style="width:200px;"><p class="gtotal">'.__d('admin', 'Item Total').'</p></td><td style="width:50px;"></td><td align="right" style="width:100px;"><p class="gtotal"><b>'.$tott.' '.$orderCurrency.'</b></p></td></tr>';

	echo '<tr><td align="left"><p class="gtotal">'.__d('admin', 'Shipping Fee').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$shipping.' '.$orderCurrency.'</b></p></td></tr>';
	if($tax>0){
		echo '<tr><td align="left"><p class="gtotal">'.__d('admin', 'Tax').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$tax.' '.$orderCurrency.'</b></p></td></tr>';
	}
	//if (!empty($disCouunts) && ($discountType == 'Giftcard Discount' || $discountType == 'User Credits' || $discountType == 'Coupon Discount')) {
		
	//if($discountType != 'Giftcard Discount')
		if(!empty($disCouunts) && $discountType!='Giftcard Discount' && $discountType!='User Credits')
	{
		$gtotal -=$disCouunts;
		$total = $gtotal;
		$giftamou = $disCouunts;
		echo "<tr><td align='left'><p class='gtotal'> ".$discountType." (-)</p></td><td style='width:50px;'></d><td align='right'><p class='gtotal'><b> ".$giftamou." ".$orderCurrency."</b></p></td></tr>";

	}
				
	//}
	if($shareamount > 0){
		echo '<tr><td align="left"><p class="gtotal">'.__d('admin', 'Affiliate Commission (-)').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$shareamount.' '.$orderCurrency.'</b></p></td></tr>';
	}
	if($admin_commission>0)
	{
		echo '<tr><td align="left"><p class="gtotal">'.__d('admin', 'Commission (-)').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$admin_commission.' '.$orderCurrency.'</b></p></td></tr>';
	}
	echo '<tr><td colspan="2"><div id="horizonal" style="border-top: 1px solid black;width:300px;position: absolute;margin-top: -6px;"></div></td></tr>
	<tr><td align="left"><p class="gtotal">'.__d('admin', 'Grand Total').'</p></td><td style="width:50px;"></td><td align="right"><p class="gtotal"><b>'.$total.' '.$orderCurrency.'</b></p></td></tr>
	<tr><td colspan="2"><div id="horizonal" style="border-top: 1px solid black;width:300px;position: absolute;"></div></td></tr>
	</table>';
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo '</div></div>';
	echo "</div>";
	echo '</div></div>';
	echo '</div></div>';
	echo "</div>";
//echo '<div id="paypalfom"></div>';
?>

<div id="invoice-popup-overlay1">
	<div class="invoice-popup">
		<div id="userdata" class="invoice-datas" style="height:auto;overflow:hidden;">
	  <div>
	    <span onclick="closebraintree();" class="close">×</span>
	  <h2><?php echo __d('admin', 'Brain Tree Payment details'); ?></h2>
	</div>

	<form method="post" action="<?php echo SITE_URL.'braintree/admin_checkout_braintree/'?>" id="paymentForm">
	<?php $total_price = $amount; ?>
	<input type="hidden" value="<?php echo $total_price; ?>" id="totalprice" name="totalPrice">
	 <input type="hidden" name="username" value="<?php echo $sellerModel['username_url']; ?>"/>
	 <input type="hidden" name="orderid" value="<?php echo $orderDetails['orderid']; ?>"/>
	 <input type="hidden" value="<?php echo $orderDetails['currency']; ?>" id="currency" name="currency"/>

<div>
	<label><?php echo __d('admin', 'Card Number'); ?></label>
	<input type="text" name="card_number" id="card_number"  maxlength="19" placeholder="1234 5678 9012 3456"/>
</div>

<div>
	<label><?php echo __d('admin', 'Name on Card'); ?></label>
	<input type="text" name="card_name" id="card_name" placeholder="<?php echo __d('admin', 'Your Card Name'); ?>"/>
</div>

<div>
	<label><?php echo __d('admin', 'Expires'); ?></label>
	<input type="text" name="expiry_month" id="expiry_month" maxlength="2" placeholder="<?php echo __d('admin', 'MM'); ?>" />
	<input type="text" name="expiry_year" id="expiry_year" maxlength="2" placeholder="<?php echo __d('admin', 'YY'); ?>" />
</div>

<div>
	<label><?php echo __d('admin', 'CVV'); ?></label>
	<input type="text" name="cvv" id="cvv" maxlength="3" placeholder="123" />
</div>

	<center>
	<input type="submit" style="cursor: pointer;padding:8px;margin-top: 8px;" class="btn button btn btn-red" id="paymentButton" value="<?php echo __d('admin', 'Checkout'); ?>" disabled="true" class="disable">
	</center>

	</form>
</div></div></div>


<script>
$(document).ready(function()
{

document.getElementById('card_number').addEventListener('input', function (e) {
  e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
});
/* Form Validation */
$("#paymentForm input[type=text]").on("keyup",function()
{
var cardValid=$("#card_number").val();
var C=$("#card_name").val();
var M=$("#expiry_month").val();
var Y=$("#expiry_year").val();
var CVV=$("#cvv").val();
var expName =/^[a-z ,.'-]+$/i;
var expMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
var expYear = /^16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31$/;
var expCVV= /^[0-9]{3,3}$/;

//alert(C);
if(expName.test(C) && expMonth.test(M) && expYear.test(Y) && expCVV.test(CVV))
{
$('#paymentButton').prop('disabled', false);
$('#paymentButton').removeClass('disable');
}
else
{
$('#paymentButton').prop('disabled', true);
$('#paymentButton').addClass('disable');
}
});

});
function approvebraintree()
{

           $('#invoice-popup-overlay1').show();
		   $('#invoice-popup-overlay1').css("opacity", "1");
	//$('#myModal').show();
}


	/*$('#customButton').click(function(){
		var stripekey = $('#stripekey').val();
		var totalprice = $('#totalprice').val();
		var currency = $('#currency').val();

		var token = function(res){
		 var $input = $('<input type=hidden name=stripeToken />').val(res.id);
		 $('#card').append($input).submit();
		 };

		 StripeCheckout.open({
			 key:         stripekey,
			 address:     false,
			 image:		  '<?php echo SITE_URL; ?>images/logo/logo_icon.png',
			 amount:      totalprice,
			 currency:    currency,
			 name:        '<?php echo SITE_NAME; ?>',
			 panelLabel:  'Checkout',
			 token:       token
		 });

		 return false;
		});*/


</script>
