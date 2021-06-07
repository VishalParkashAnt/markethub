<?php
if(count($commentModel)>0)
{
				foreach($commentModel as $comment){
					$itemId = $comment['item']['id'];
					$itemname = $comment['item']['item_title'];
					$itemurl = $comment['item']['item_title_url'];
					$userComment = $comment['comments'];
					$username = $comment['user']['first_name'];
					$atusername = $comment['user']['username'];
					$usernameUrl = $comment['user']['username_url'];
					$profileImage = $comment['user']['profile_image'];
					if ($profileImage == "")
						$profileImage = "usrimg.jpg";
?>
					<div class="activity_heading">
						<div class="row">
							<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 span_1">
								<div class="live_feeds_logo1 image_center_mobile">
								<img alt="<?php echo $username; ?>" src="<?php echo $_SESSION['media_url'].
									'media/avatars/thumb70/'.$profileImage; ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8 margin_left20 margin-right20_mobile margin_left_0_tab span_8 text_center_seller">
								<div class="margin-left20 margin-right20 word_break">
									<a href="<?php echo SITE_URL."people/".$usernameUrl; ?>"
										title="<?php echo $username; ?>">
										<?php echo $username; ?>
										<span class='anchoratuser'><?php echo "@".$usernameUrl; ?></span>
									</a>
								</div>
								<p class="time_text margin-left20 margin-right20 extra_text_hide">
									<?php echo $userComment; ?>
								</p>
								<p class="time_text margin-left20 margin-right20 extra_text_hide">
								<?php echo __d('user','Commented On');?>:
									<?php if (!empty($itemname)){ ?>
									<a href="<?php echo SITE_URL."listing/".$itemId."/".$itemurl; ?>"
										title="<?php echo $itemname; ?>">
										<?php echo $itemname; ?>
									</a>
									<?php }else{
										echo __d('user',"Status");
									}?>
								</p>

							</div>


						</div>


					</div>
<?php } ?>



	<?php }
	else
	{

	}
	?>