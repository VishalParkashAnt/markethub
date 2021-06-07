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
								<h2 style=" font-weight: normal; margin: 0; padding: 0 0 12px; font-style: inherit; line-height: 30px; font-size: 25px; font-family: Trebuchet MS; border-bottom: 1px solid #333333; ">
									<?php echo __d('user','Hi there, your friend');?> <?php echo $sentuser; ?> <?php echo __d('user','has sent a gift card');?>
									<?php echo __d('user','from');?> <?php echo $sitename; ?>.
								</h2>
							</td>
						</tr>

							<tr>
								<td style="padding: 15px 0;"  valign="top">
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Hello');?>,
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Your friend');?> <?php echo $sentuser; ?> <?php echo __d('user','has bought a gift card for you from');?> <?php echo $sitename; ?> <?php echo __d('user','and you can use the this gift for buying any product from');?> <?php echo $sitename; ?>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','If you have an existing activated account with');?> <?php echo $sitename; ?> <?php echo __d('user','using this same email address, this gift details will be available under your profile page. If you have not registered yet, please click the following link and register your new account. Please make sure you will use this same email address for creating the new account and to avail this gift card');?>.
									</p>
									<p style="margin-bottom: 10px; font-weight:bold;">
										<?php echo __d('user','Your Gift Card code');?>: <?php echo $uniquecode; ?>
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Not yet registered? Claim your gift now by click this link');?>: <a href="<?php echo $access_url; ?>"> <?php echo __d('user','click');?> </a>
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Message from your friend');?>:
									</p>
									<p style="background-color: #f1f1f1; font-style: italic; margin-bottom: 10px; padding: 10px;">
										<?php echo __d('user','Hello');?> <?php echo $recvuser; ?>, <?php echo $gcmessage; ?>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','How to use');?>:
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','This special gift card shared by your friend is just a code and it will work only for your account which is using this email address. You can use this code at the time of payment mode and this can be found In the cart page as an entry of "Gift Card Codes" with the input text box and apply button. You can enter this code and click the apply button to see the change in the actual product price. If you are happy you can hit the "Checkout" button and that\'s it. You will also be able see the collection of gift card you received and it\'s used under your profile page');?>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Terms & Conditions');?>:
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','This gift card code is an auto generated one and should not be shared with anyone else. Any accidental damage caused by the usage of this gift card code will be reversible in the system by the administrators of');?> <?php echo $sitename; ?>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','If you have any problem in using the gift card code, you are recommended to write to the support team email address');?> <a href='<?php echo SITE_URL; ?>help/contact'><?php echo __d('user','here');?></a>.
									</p>
									<p style='margin-bottom: 10px'>
										<?php echo __d('user','Enjoy gifting');?> !!!
									</p>

								</td>
							</tr>

							<tr>
								<td style="padding: 15px 0"  valign="top">
									<p style="color: #333333; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 14px;font-family: Arial; ">
										<?php echo __d('user','Regards');?>,
										<br />
										<b><?php echo $sitename.' '.__d('user','Team'); ?>.</b>
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
