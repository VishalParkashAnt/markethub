		 <?= $this->Flash->render('auth') ?>
  <?php echo $this->Form->create('login',array('url'=>array('controller'=>'/users','action'=>'/forgotpassword'),'onsubmit'=>'return validforgot()')); ?>
		<!--Login Page-->
		<div class="container section_container margin-top40">
			<div class="login-page-cnt col-sm-9 col-md-7 col-lg-6" style="margin-top:0px!important;">
				<div class="login-page" style="display: block;">
					<div class="pop-up-cnt login-body clearfix" style="display: block;">
						<div class="login-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="padding-right: 0px; border-right: none;">
							<h2 class="login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<?php echo __d('user','Forgot Password');?></h2>
							<p>
							<?php echo __d('user','Forgot your password? Enter your email address to change it');?>.</p>
							<form>
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','Email Address');?>:</div>
									<input type="text" id="email" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="email" placeholder="<?php echo __d('user','Enter your email address');?>">
								</div>
								<div id='alert_em' class="trn red-txt" style='float:right;height:0px;font-size:13px;'></div>
								<div class="login-forget-pwd col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<input type="submit" class="btn primary-color-bg col-xs-4 col-sm-4 col-md-4 col-lg-4 no-hor-padding login-text bold-font txt-uppercase" style="font-size:12px;" value="<?php echo __d('user','Continue');?>">
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
