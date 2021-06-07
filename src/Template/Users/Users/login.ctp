<?= $this->Flash->render('auth') ?>
<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<?php
$merchantlogin=0;
if(isset($_SESSION['ismerchant']) && $_SESSION['ismerchant']=='1'){
$merchantlogin=1;
unset($_SESSION['ismerchant']);
}
?>
<?php echo $this->Form->create('login',array('url'=>array('controller'=>'/users','action'=>'/login'),'id'=>'loginform' ,'onsubmit'=>'return validsigninfrm()')); ?>
<!--Login Page-->
<div class="container section_container margin-top40">
	<div class="login-page-cnt col-lg-8">
		<div class="login-page">
			<div class="pop-up-cnt login-body">
				<div class="login-left-cnt col-xs-12 col-sm-7 col-md-7 col-lg-7 no-hor-padding">
					<h2 class="login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php echo __d('user','Login to').' '.$setngs['site_name']; echo $merchantvisit;?></h2>
						<?php if(isset($_SESSION['loginError']) && $_SESSION['loginError']!=""){?>
								<p class="trn red-txt invaliduser" style='text-align:center;'><?php echo __d('user','Invalid username or password, try again');
								unset($_SESSION['loginError']);
								?></p>
								<?php } ?>
						<form>
							<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding profile"><?php echo __d('user','Email');?>:</div>
								<div id='alert_em' class="trn red-txt" style='float:right;height:0px;'></div>
								<!-- <input type="text" id="email" value="<?php if(!empty($getemailval))  { echo $getemailval; } ?>" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="email" placeholder="<?php echo __d('user','Enter your email address');?>">-->
								<input type="text" id="email" value="" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="email" placeholder="<?php echo __d('user','Enter your email address');?>">
							</div>
							<div class="pwd padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding profile"><?php echo __d('user','Password');?>:</div>
								<div id='alert_pass' class="trn red-txt" style='float:right;height:0px;'></div>
								<!--<input type="password" id="password" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="password" placeholder="<?php echo __d('user','Enter your password');?>">-->
								<input type="password" id="password" value="" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="password" placeholder="<?php echo __d('user','Enter your password');?>" >
							</div>

							<div class="remember-pwd padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="checkbox checkbox-primary">
									<input type="checkbox" id="checkbox3" value="1" name="remember">
									<label for="checkbox3"><?php echo __d('user','Remember me');?></label>
								</div>
							</div>

						<div class="login-forget-pwd col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<input type="submit" class="btn primary-color-bg col-xs-4 col-sm-4 col-md-4 col-lg-4 no-hor-padding login-text bold-font txt-uppercase" value="<?php echo __d('user','Login');?>">
								<?php
								echo '<a href="'.SITE_URL.'forgotpassword" class="forgot-pwd-txt">'.__d('user','Forgot Password').'?</a>';
								?>
							</div>
						</form>
						<div class="or bold-font"><?php echo __d('user','OR');?></div>
					</div>
					<div class="login-right-cnt col-xs-12 col-sm-5 col-md-5 col-lg-5 no-hor-padding">
						<div class="social-buttons col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<a href="<?php echo $baseurl.'sociallogin/facebook'; ?>" class="social-button fb-button bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12">facebook</a>
							<a href="" class="social-button google-button bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12">google</a>
							<div class="new-to-website col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','New to');?> <?php echo $setngs['site_name'];?>? <a href="<?php echo SITE_URL.'signup';?>"  class="sign-up-now-txt bold-font txt-uppercase"><?php echo __d('user','Sign up now');?></a></div>
						</div>
					</div>
				</div>
				<div class="login-footer modal-footer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<?php echo __d('user','Interested in selling'); ?>?<a class="bold-font txt-uppercase" href="<?php echo SITE_URL.'merchant';?>"><?php echo __d('user','Get started');?></a>
				</div>
			</div>
		</div>
	</div>
</form>
<!--Merchant Login Modal-->
<div id="merchant_login_info" class="modal fade" role="dialog">
	  <div class="modal-dialog downloadapp-modal">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-body">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<div class="signup-welcome-container margin-bottom50 margin-top50">
				<div class="signup-welcome-row text-center"><i class="primary-color-txt fa fa-smile-o"></i></div>
				<div class="signup-welcome-row text-center margin-top30 margin-bottom30 bold-font"><h5><?php 
				echo __d('user','Please Visit Merchant Site  Login If You have Merchant ID');?></h5></div>
			</div>
		  </div>
		  <div class="wizard-btn-cnt">
				<a href="" class="wiz-btn text-center dark-grey-bg bold-font txt-uppercase" data-dismiss="modal"><?php echo __d('user','CANCEL');?></a>
				<a href="<?php echo $baseurl.'merchant/'; ?>"  id="wiz-1-btn" class="embed-modal wiz-btn text-center primary-color-bg bold-font txt-uppercase">
				<?php echo __d('user','Merchant Login');?></a>
			</div>
		</div>

	  </div>
	</div>
<!--Merchant Login Modal-->
<script type="text/javascript">
	$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
		$("#success-alert").slideUp(500);
	});

	$( document ).ready(function() {
	var ismerchant="<?php echo $merchantlogin ?>";
	if(ismerchant=='1'){
		$("#merchant_login_info").modal('show');	
	}});

</script>
	<style>
		.fullPage{
			margin-top: 0px!important;
		}
	</style>