<?php 
 if($setngs->payment_type == 'sandbox'){
 	echo $this->Form->create('frmPayPal1', array('url' => 'https://www.sandbox.paypal.com/cgi-bin/webscr','type' => 'post','id'=>'paypal'));
 }elseif($setngs->payment_type == 'paypal'){
 	echo $this->Form->create('frmPayPal1', array('url' => 'https://www.paypal.com/cgi-bin/webscr','type' => 'post','id'=>'paypal')); 
 } 	
?>

		<input type="hidden" name="business" value="<?php echo $setngs->payment_type; ?>"/>
		<input type="hidden" name="cmd" value="_cart" /> 
		<input type="hidden" name="upload" value="1">
		<input type="hidden" name="no_note" value="1" />
		<input type="hidden" name="lc" value="UK" />
		<input type="hidden" name="currency_code" value="<?php echo $_SESSION['default_currency_code']; ?>" />
		<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
		<input type="hidden" name="first_name" value="<?php echo $reciptent_name; ?>"  />
		<!-- input type="hidden" name="last_name" value="<?php echo $reciptent_name; ?>"  /-->
		<input type="hidden" name="custom" value="<?php echo $giftcardId; ?>"  />
		<?php 
		//echo $this->Form->input('rm', array('type' => 'hidden','name'=>'rm', 'value'=>'2','id'=>'toc1_'.$itm['Item']['id']));
		echo $this->Form->input('item_name', array('type' => 'hidden','name'=>'item_name_1', 'value'=>'Gift Card','id'=>'item_name'.$giftcardId));
		echo $this->Form->input('quantity', array('type' => 'hidden','name'=>'quantity_1','value'=>'1','id'=>'quantity_'.$giftcardId));
		echo $this->Form->input('item_number', array('type' => 'hidden','name'=>'item_number_1', 'value'=>$giftcardId,'id'=>'item_number_'.$giftcardId));
		//echo $this->Form->input('shipping', array('type' => 'hidden','name'=>'shipping_1', 'value'=>'0','id'=>'shipping_'.$giftcardId));
		echo '<input type="hidden" name="no_shipping" value="1">';
		echo "<input type='hidden' class='price' name='amount_1' value='".$amount."' id='price_".$amount."'>";
		//echo $this->Form->input('discount_amount', array('type' => 'hidden','name'=>'discount_amount', 'value'=>'2'));
		//echo '<input type="hidden" name="discount_amount_cart"  value="'.$discount.'">';
		//echo '<input type="hidden" name="discount_rate_cart"  value="'.$discount.'">';	
		echo $this->Form->input('cancel_return', array('type' => 'hidden','name'=>'cancel_return', 'value'=>''.SITE_URL.'payment-cancelled','id'=>'toc'));
		echo $this->Form->input('return', array('type' => 'hidden','name'=>'return', 'value'=>''.SITE_URL.'payment-successful','id'=>'toc'));
	?>
	<input type="hidden" name="notify_url" value="<?php echo SITE_URL.'paypal/giftcardipnIpn/'; ?>" />
	<!--input type="submit" class="btn btn-success ckout" value="Checkout with Paypal"/> http://dev.hitasoft.com/new/
	success.php-->
	<?php echo $this->Form->end(); ?>