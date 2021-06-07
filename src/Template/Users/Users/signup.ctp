<?= $this->Flash->render('auth') ?>
  <?php echo $this->Form->create('login',array('url'=>array('controller'=>'/users','action'=>'/signup'),'id'=>'loginform','onsubmit'=> 'return signform();')); ?>
				<!--Login Page-->
		<div class="container section_container margin-top40">
			<div class="login-page-cnt col-lg-6">
				<div class="login-page">
					<div class="pop-up-cnt login-body">
						<div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','Join');?> <?php echo $setngs['site_name'];?> <?php echo __d('user','Today');?></h2>
							<form>
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding profile" maxlength="26"><?php echo __d('user','Full Name');?>:</div>
									<div id='alertName' class="trn red-txt" style='float:right;height:auto;'></div>
									<input type="text" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" maxlength="30" id="fullname" name="data[signup][firstname]" placeholder="<?php echo __d('user','Enter Your Full Name');?>" onkeypress="return isAlpha(event);">
								</div>

								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding profile"><?php echo __d('user','User Name');?>:</div>
									<div id='alertUname' class="trn red-txt" style='float:right;height:auto;'></div>
									<input type="text" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="user_name" maxlength="26" name="data[signup][username]" placeholder="<?php echo __d('user','Enter your User Name');?>">
								</div>
   					<?php if(!empty($refferrer_user_id)){ ?>
   					<input type='hidden' name='refferid' value='<?php echo $refferrer_user_id; ?>'>
   					<?php } ?>
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding profile" style="width:30%;"><?php echo __d('user','Email Address');?>:</div>
									<div id='alertEmail' class="trn red-txt" style='float:right;height:auto;'></div>
									<input type="text" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="email" name="data[signup][email]" placeholder="<?php echo __d('user','Enter your email address');?>">
								</div>

								<div class="pwd padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding profile"><?php echo __d('user','Password');?>:</div>
									<div id='alertPass' class="trn red-txt" style='float:right;height:auto;'></div>
									<input type="password" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="password" name="data[signup][password]" placeholder="<?php echo __d('user','Enter your password');?>">
								</div>
								<div class="pwd padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','Captcha');?>:</div>
									<?php echo $this->Captcha->create('securitycode');?>
								</div>
								<div class="login-forget-pwd col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding padding-bottom15">
									<input type="submit" class="padding-bottom15 padding-top15 btn login-text primary-color-bg col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font txt-uppercase" value="<?php echo __d('user','Join');?> <?php echo $setngs['site_name'];?>">
								</div>
								<div class="signup-tc col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding padding-bottom15">
									<?php echo __d('user','By clicking the');?>"<?php echo __d('user','Join');?> <?php echo $setngs['site_name'];?>" <?php echo __d('user','you are agree that you have read and agree the');?> <?php echo $setngs['site_name'];?>" <?php echo __d('user','Terms and Conditions');?>"
								</div>
								<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									----<?php echo __d('user','or use your mail');?>----
								</div>
							</form>
						</div>
						<div class="signup-right-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin-top30">
							<div class="social-buttons col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<a href="" class="social-button fb-button bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12">facebook</a>
								<a href="" class="social-button google-button bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12">google +</a>
								<div class="new-to-website col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','Already a member');?>? <a href="<?php echo SITE_URL.'login';?>" class="sign-up-now-txt bold-font txt-uppercase"><?php echo __d('user','Login');?></a></div>
							</div>
						</div>
					</div>
					<div class="login-footer modal-footer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php echo __d('user','Interested in selling?');?>
						<?php
						echo '<a class="bold-font txt-uppercase" href="'.SITE_URL.'merchant">'.__d('user','Get started').'</a>';
						?>
					</div>
				</div>
		  </div>
		</div>
	<!--E O Login page-->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>


$("#securitycode").val("");
jQuery('.creload').on('click', function() {
    var mySrc = $(this).prev().attr('src');
    var glue = '?';
    if(mySrc.indexOf('?')!=-1)  {
        glue = '&';
    }
    $(this).prev().attr('src', mySrc + glue + new Date().getTime());
    return false;
});
</script>