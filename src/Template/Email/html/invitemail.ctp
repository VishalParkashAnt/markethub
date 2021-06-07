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
								<h2 style=" font-weight: normal; margin: 0; padding: 0 0 12px; font-style: inherit; line-height: 30px; font-size: 25px; font-family: Trebuchet MS; border-bottom: 1px solid #333333; "> Hi there, your friend <?php echo $loguser['first_name']; ?> inviting you.</h2>
							</td>
						</tr>
						
							<tr>
								<td style="padding: 15px 0;"  valign="top">
									<p style='margin-bottom: 10px'>
										Hello There,
									</p>
									<p style='margin-bottom: 10px'>
										Greetings from <?php echo $sitename;?>!
									</p>
									<p style='margin-bottom: 10px'>
										You have received an invitation from 
										<?php echo $loguser['first_name']; ?> to join 
										<?php echo $sitename; ?>. Please click the link below to accept 
										the invitation and to create your new account with 
										<?php echo $sitename; ?>.
									</p>
									<p style='margin-bottom: 10px'>
										Invitation link: <?php echo "<a href='".SITE_URL."signup?referrer=".$loguser['username']."'>Join with me</a>"; ?>
									</p>
									<p style='margin-bottom: 10px'>
										To view <?php echo $loguser['first_name']; ?>'s  profile, please click the link below.
									</p>
									<p style='margin-bottom: 10px'>
										Link:  <?php echo "<a href='".SITE_URL."people/".$loguser['username']."'>"; ?><?php echo ucwords(strtolower($loguser['username'])); ?></a>
									</p>
									<?php if ($msg != ""){ ?>
										<p style='margin-bottom: 10px'>
											Message from your friend:
										</p>
										<p style="background-color: #f1f1f1; font-style: italic; margin-bottom: 10px; padding: 10px;">
											<?php echo $msg; ?>.
										</p>
									<?php } ?>
									<p style='margin-bottom: 10px'>
										Joining to <?php echo $sitename; ?> & referring your friends is not only sharing the fun, but you will get some additional benefits too. Go to our help section to read more about the referral program. 
									</p>
									
								</td>
							</tr>			
							
							<tr>
								<td style="padding: 15px 0"  valign="top">
									<p style="color: #333333; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 14px;font-family: Arial; ">
										Regards,
										<br />
										<b><?php echo $sitename.' Team'; ?>.</b>
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
