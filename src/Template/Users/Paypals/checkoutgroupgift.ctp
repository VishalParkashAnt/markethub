<?php 
 if($setngs->payment_type == 'sandbox'){
 	echo $this->Form->create('frmPayPal1', array('url' => 'https://www.sandbox.paypal.com/cgi-bin/webscr','type' => 'post','id'=>'ggpaypal'));
 }elseif($setngs->payment_type == 'paypal'){
 	echo $this->Form->create('frmPayPal1', array('url' => 'https://www.paypal.com/cgi-bin/webscr','type' => 'post','id'=>'ggpaypal')); 
 } 	
?>
<input type="hidden" name="business" value="<?php echo $setngs->paypal_id; ?>"/>
<input type="hidden" name="cmd" value="_cart" /> 
<input type="hidden" name="upload" value="1">
<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="lc" value="UK" />
<input type="hidden" name="currency_code" value="<?php echo $item_datas->currency; ?>" />
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
<input type="hidden" name="first_name" value="<?php echo 'fname'; ?>"  />
<input type="hidden" name="last_name" value="<?php echo 'lname'; ?>"  />
<?php 
echo $this->Form->input('item_name', array('type' => 'hidden','name'=>'item_name_1', 'value'=>$item_datas['Item']['item_title'],'id'=>'item_name'.$Ggdatas['Groupgiftuserdetail']['id']));
echo $this->Form->input('quantity', array('type' => 'hidden','name'=>'quantity_1','value'=>'1','id'=>'quantity_1'));
echo $this->Form->input('item_number', array('type' => 'hidden','name'=>'item_number_1', 'value'=>$Ggdatas['Groupgiftuserdetail']['id'],'id'=>'item_number_'.$Ggdatas['Groupgiftuserdetail']['id']));
echo "<input type='hidden' class='price' name='amount_1' value='".$UserEntrAmt."'>";

echo "<input type='hidden' name='custom' value='".$UserId."'  />";

$ggids = $Ggdatas['Groupgiftuserdetail']['id'];

echo $this->Form->input('cancel_return', array('type' => 'hidden','name'=>'cancel_return', 'value'=>''.SITE_URL.'payment-cancelled','id'=>'toc'));
echo $this->Form->input('return', array('type' => 'hidden','name'=>'return', 'value'=>''.SITE_URL.'gifts/'.$ggids,'id'=>'toc'));?>

<input type="hidden" name="notify_url" value="<?php echo SITE_URL.'paypal/ggipn/'; ?>"/>
<!--input type="submit" class="btn btn-success ckout" value="Checkout with Paypal"/>   http://dev.hitasoft.com/new/success.php-->
</form> 
