
 <?php echo $this->element('emailHeader'); ?>  
				<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="font-family: Georgia, serif; background: #fff;" bgcolor="#ffffff">
			      <tr>
			        <td width="14" style="font-size: 0px;" bgcolor="#ffffff">&nbsp;</td>
					<td width="100%" valign="top" align="left" bgcolor="#ffffff" style="font-family: Georgia, serif; background: #fff;">
						<table cellpadding="0" cellspacing="0" border="0"  style="color: #333333; font: normal 13px Arial; margin: 0; padding: 0;" width="100%" class="content">
						
						<h1> <?php echo __d('merchant','Hi'); ?>, <?php echo $custom; ?></h1>
						
						<p style='margin-bottom: 10px;'> <?php echo __d("merchant","I saw that you were about to pick up some goods in the shop and that you didn't get a chance to finish your order.")." "; ?>  <?php echo __d('merchant','I just wanted to see if there were any problems, or anything at all I could help with. If so, please let me know by responding to this email.'); ?>
						</p>
						
						<p style='margin-bottom: 15px;'><?php echo __d("merchant","In case you were looking to pick up where you left off, here's a reminder of what you were thinking about getting"); ?> :
						  </p>
							<?php  
								foreach($itemdatas as $items){ 
									$itemid = $items['id'];
									$itemtitle = $items['item_title'];
									echo $cartquantity[$userid][$itemid].' x '.$itemtitle."<br>";
								}
							 ?>
					
							<p style='margin-top: 20px; margin-bottom: 10px;'><?php echo __d("merchant","Here is a link to your shopping cart"); ?> : </p>
							
							<p style='margin-bottom: 10px;'><a href="<?php echo $access_url; ?>"> <?php echo $access_url; ?> </a></p>
							
							<p style='margin-bottom: 10px;'><?php echo __d("merchant","Thanks again for visiting us, and please let me know if you have thoughts on how we can improve your experience at")." ".$setngs['site_name']; ?>.</p>
							
							<p style='margin-bottom: 10px;'><?php echo __d("merchant","Best wishes from")." ".$setngs['site_name']."!"; ?>
							</p>
							
							
							<tr>
								<td style="padding: 15px 0;"  valign="top">
									<p style="color: #333333; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 14px;font-family: Arial; ">
										<?php echo __d("merchant","Regards"); ?>,
										<br />
										<b><?php echo $setngs['site_name'].' '.__d("merchant","Team"); ?>.</b>
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




