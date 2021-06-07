<?php echo $this->element('emailHeader'); ?>
				<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="font-family: Georgia, serif; background: #fff;" bgcolor="#ffffff">
			      <tr>
			        <td width="14" style="font-size: 0px;" bgcolor="#ffffff">&nbsp;</td>
					<td width="100%" valign="top" align="left" bgcolor="#ffffff" style="font-family: Georgia, serif; background: #fff;">
						<table cellpadding="0" cellspacing="0" border="0"  style="color: #333333; font: normal 13px Arial; margin: 0; padding: 0;" width="100%" class="content">
						<!-- <tr>
							<td style="padding: 25px 0 5px; border-bottom: 2px solid #d2b49b;font-family: Georgia, serif; "  valign="top" align="center">
								<h3 style="color:#767676; font-weight: normal; margin: 0; padding: 0; font-style: italic; line-height: 13px; font-size: 13px;">~ <currentmonthname> <currentday>, <currentyear> ~</h3>
							</td>
						</tr> -->
						<tr>
							<td style="padding: 18px 0 0;" align="left">
								<h2 style=" font-weight: normal; margin: 0; padding: 0 0 12px; font-style: inherit; line-height: 30px; font-size: 25px; font-family: Trebuchet MS; border-bottom: 1px solid #333333; "> <?php echo __d('user','Your order confirmation - The order ID(s)');?> <?php echo $orderId; ?>.</h2>
							</td>
						</tr>

							<tr>
								<td style="padding: 15px 0;"  valign="top">
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Hello');?> <?php echo $custom; ?>,
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Thank you for shopping on');?> <?php echo $setngs['site_name']; ?>! <?php echo __d('user','Kindly note down the order ID(s)');?>
										<?php echo $orderId; ?> <?php echo __d('user','as a reference number for this purchase');?>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Your order is confirmed. The same has been notified to the seller too. Once the order is shipped by the seller, we will send you an email with the shipment details from the seller. In case if you have ordered multiple items from multiple sellers, all your orders may be delivered separately. All your orders can be seen and tracked through your');?> <?php echo $setngs['site_name']; ?> <?php echo __d('user','account also');?>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Your order details');?>:
									</p>
									<p style='margin-bottom: 10px'>
										<?php
										echo 'Seller Name(s) :';
										for($i=0;$i<count($seller_name);$i++)
										{
											echo '<a href="'.SITE_URL.'people/'.$seller_name_url[$i].'">'.$seller_name[$i].'</a>,';
										}
										?>
										<br />
										<?php echo __d('user','Order ID(s)');?>: <?php echo $orderId; ?>
										<br>
										Order Date: <?php echo date('j-M-Y'); ?>
									</p>
									<p style='margin-bottom: 10px'>
										<table width="100%" class='order-details-table' style='border-spacing: 0;border-collapse: collapse;border: none;'>
										  <tr>
										    <th style='padding: 6px 10px;border: 1px solid rgba(0, 0, 0, 0.12);'><?php echo __d('user','Item');?></th>
										    <th style='padding: 6px 10px;border: 1px solid rgba(0, 0, 0, 0.12);'><?php echo __d('user','Quantity');?></th>
										    <th style='padding: 6px 10px;border: 1px solid rgba(0, 0, 0, 0.12);'><?php echo __d('user','Size');?></th>
										  </tr>
										  <?php foreach($itemname as $key=>$item){ ?>
										  <tr>

											<td style='padding: 6px 10px;border: 1px solid rgba(0, 0, 0, 0.12);'><?php echo $item; ?></td>
											<td style='padding: 6px 10px;border: 1px solid rgba(0, 0, 0, 0.12);text-align: center;'><?php echo $tot_quantity[$key]; ?></td>
											<?php if ($sizeopt[$key] == '0') { ?>
												<td style='padding: 6px 10px;border: 1px solid rgba(0, 0, 0, 0.12);text-align: center;'> -- </td>
											<?php }else { ?>
												<td style='padding: 6px 10px;border: 1px solid rgba(0, 0, 0, 0.12);text-align: center;'><?php echo $sizeopt[$key]; ?></td>
											<?php } ?>

										  </tr>
										  <?php } ?>
										</table>
									</p>
									<p style='margin-bottom: 10px'>
										<b><?php echo __d('user','Ship to');?>:</b>
										<br clear="all" /><br />
										<?php echo $usershipping_addr['name']; ?><br />
										<?php echo $usershipping_addr['address1']; ?><br />
										<?php if ($usershipping_addr['address2'] != ""){echo $usershipping_addr['address2']."<br />";} ?>
										<?php echo $usershipping_addr['city']." - ".$usershipping_addr['zipcode']; ?><br />
										<?php echo $usershipping_addr['state']; ?><br />
										<?php echo $usershipping_addr['country']; ?><br />
										<?php echo "Ph.: ".$usershipping_addr['phone']; ?><br />
									</p>
									<p style='margin-bottom: 10px;font-size:16px;'>
										<?php echo __d('user','Total');?>: <b><?php echo $totalcost." ".$currencyCode; ?></b> <br/>

									<?php if($totalcost_discount != 0)?>
										<?php echo __d('user','Discount');?>: <b><?php echo $totalcost_discount." ".$currencyCode; ?></b> <br/>
										<?php echo __d('user','Grand Total');?>: <b><?php echo $totalcost_grandtotal." ".$currencyCode; ?></b> <br/>


									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Your order is safe and been monitored closely with the seller when you shop on');?> <?php echo $setngs['site_name']; ?>. <?php echo __d('user','In case if you don\'t receive your order from the seller(s) or it is delivered in an unsatisfactory condition, you can reach us');?> <a href='<?php echo SITE_URL; ?>help/contact'>here</a>. <?php echo __d('user','When you write to us about any orders, please mention the order ID to get quick response from the support team');?>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Item\'s also recommended to update the system once you received the order from the seller as expected and you are satisfied. In case of any order\'s receipt is not notified in the system will be automatically confirmed as "Delivered" and will processed in the favor of sellers. Within this duration you are recommended to reach us in case of any problem in the orders');?>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','To update receipt of the order, please login and go to profile and settings, then click "My orders" and select the "Actions" and choose "Mark as received"');?>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','We look forward to see you again');?>.
									</p>
								</td>
							</tr>

							<tr>
								<td style="padding: 15px 0"  valign="top">
									<p style="color: #333333; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 14px;font-family: Arial; ">
										<?php echo __d('user','Regards');?>,
										<br />
										<b><?php echo $setngs['site_name'].' Team'; ?>.</b>
									</p>
									<br>
								</td>
							</tr>
						</table>
					</td>
					<td width="16" bgcolor="#ffffff" style="font-size: 0px;font-family: Georgia, serif; background: #fff;">&nbsp;</td>
			      </tr>
				</table><!-- body -->
				  <?php echo $this->element('emailFooter'); ?>
		  	</td>
		</tr>
    </table>
  </body>
</html>
<?php //die; ?>

