	<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<!-- breadcrumb start -->
<div class="container-fluid margin-top10 no_hor_padding_mobile">
  <div class="container">
<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12  margin-bottom10">
     <div class="breadcrumb">
      <a href="<?php echo $baseurl;?>"><?php echo __d('user','Home');?></a>
      <span class="breadcrumb-divider1">/</span>
      <a href="#"><?php echo __d('user','Change Password');?></a>
     
     </div>
    </div>
     
  </div>
    </div>
    <!-- breadcrumb end -->

        

	<div class="container">
		<div id="sidebar" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 no-hor-padding sidebar is-affixed" style="">
			<div class="sidebar__inner border_right_grey" style="position: relative; ">
				<div class="mini-submenu profile-menu">
			        <!--<span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>-->
			    </div>
			    <!--SETTINGS SIDEBAR PAGE-->
				<?php echo $this->element('settingssidebar'); ?>

    			<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

			</div>
		</div>

		<div id="content" class="col-lg-9 col-md-9 col-sm-12 col-xs-12 no-hor-padding clearfix min-height-profile">
			<div class="cnt-top-header border_bottom_grey col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo __d('user','Change Password');?> </h2>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">
			<?php
			echo $this->Form->create('Password', [
    'url' => ['controller' => 'Users', 'action' => 'password'],'onsubmit'=>'return passwordconfirm();'
]);
?>

					<div class="padding-top20 clearfix">
						<div class="padding-bottom15 clearfix">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								<label class="font-weight-normal primary-color-txt margin-bottom20"><?php echo __d('user','Password');?></label>
							</div>
							<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<?php
							if($soci_autoverify == 0 && $usr_datas['password'] != "")
							{
							?>
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Existing Password');?></div>
									<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="password" name = "epassword" id="exispass" maxlength = "32">
								</div>
							<?php } else {
								echo '<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="hidden" name = "epassword" id="exispass" maxlength = "32" value="xxx_xxx">';
							}
							 ?>
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','New Password');?></div>
									<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="password" name = "password" id="passw" maxlength = "32">
									<p class="text-right font-size12 col-sm-12 margin-top5 margin0 padding0 pull-right"><?php echo __d('user','New password at least 6 characters');?>.</p>
								</div>
								<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Confirm Password');?></div>
									<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="password" name = "cpassword"  id="confirmpass" maxlength = "32">
								</div>

								<div class="email-addr padding-bottom15 padding-top20 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="btn primary-color-bg primary-color-bg bold-font txt-uppercase">
										<button class="btn-primary-inpt" disabled="disabled" id="save_password"  type="submit"><?php echo __d('user','Change Password');?></button>
									</div>
									
								</div>
								<div id="alert" class="trn" style='color:red;'></div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>
