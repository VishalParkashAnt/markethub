		 <?= $this->Flash->render('auth') ?>
  <?php echo $this->Form->create('login',array('url'=>array('controller'=>'/users','action'=>'/setpassword'),'onsubmit'=>'return validpassword()')); ?>
		<!--Login Page-->
		<div class="container section_container margin-top40">
			<div class="login-page-cnt col-lg-8">
				<div class="login-page">
					<div class="pop-up-cnt login-body">
						<div class="login-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','New Password');?></h2>
							<form>
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','New Password');?></div>
									<input type="password" id="newpassword" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="newpassword"  placeholder="">
								</div>

								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','Confirm Password');?></div>
									<input type="password" id="confirm" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="confirm"  placeholder="">
								</div>

		   	<div class='addshiperror trn red-txt' style="padding-top:4px;"></div>
			<input type="hidden" value="<?php echo $email; ?>" name="email" />
			<input type="hidden" value="<?php echo $veri_pass; ?>" name="verify_pass" />

								<div class="login-forget-pwd col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<input type="submit" class="btn primary-color-bg col-xs-4 col-sm-4 col-md-4 col-lg-4 no-hor-padding login-text bold-font txt-uppercase" value="<?php echo __d('user','Continue');?>">
								</div>
							</form>
						</div>

					</div>
					<!--div class="login-footer modal-footer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						Interested in selling?<a class="bold-font txt-uppercase" href="">Get started</a>
					</div-->
				</div>
		  </div>
		</div>
		</form>
	<!--E O Login page-->
