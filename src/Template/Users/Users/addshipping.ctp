		<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
		<!-- breadcrumb start -->
<div class="container-fluid margin-top10 no_hor_padding_mobile">
  <div class="container">
<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
     <div class="breadcrumb">
      <a href="<?php echo $baseurl;?>"><?php echo __d('user','Home');?></a>
      <span class="breadcrumb-divider1">/</span>
      <a href="#"><?php echo __d('user','Add Address');?></a>
     
     </div>
    </div>
     
  </div>
    </div>
    <!-- breadcrumb end -->
       
	<div class="container margin_top165_mobile">
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
							<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<?php echo __d('user','Add Shipping Address');?> </h2>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">
			<?php
			echo $this->Form->create('Password', [
    'url' => ['controller' => 'Users', 'action' => 'addshipping'],'onsubmit'=>'return validaddship();'
]);
?>

								<div class="border_bottom_grey padding-top10 clearfix">
								<div class="padding-bottom15 clearfix">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<label class="font-weight-normal primary-color-txt margin-bottom20"><?php echo __d('user','New Address');?></label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
										<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding adres-alighn">
											<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">
												<?php echo __d('user','Full Name');?></div>
											<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="fullname" name="fullname" type="text" maxlength='30' value="<?php if(isset($usr_datas)) { echo $usr_datas['name']; } ?>" placeholder="<?php echo __d('user','Enter your real name');?>">
											<div id='alert_em' class="trn" style='color:red;'></div>
										</div>

										<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding adres-alighn">
											<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">
												<?php echo __d('user','Nick Name');?></div>
											<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="nick" type="text" name="nickname" maxlength='30' value="<?php if(isset($usr_datas)) { echo $usr_datas['nickname']; } ?>" placeholder="<?php echo __d('user','e.g. Home, Work');?>">
											<div id='alert_nick' class="trn" style='color:red;'></div>
										</div>

										<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">
												<?php echo __d('user','Address');?></div>
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
													<div class="divtwo clearfix">
													  <input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="add1" name="address1" type="text" value="<?php if(isset($usr_datas)) { echo $usr_datas['address1']; } ?>" placeholder="<?php echo __d('user','Line')." 1";?>">
													</div>
												</div>

												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
													<div class="divtwo clearfix">
													  <input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="text" name="address2" value="<?php if(isset($usr_datas)) { echo $usr_datas['address2']; } ?>" placeholder="<?php echo __d('user','Line')." 2";?>">
													</div>
												</div>
													<div id='alert_add1' class="trn" style='color:red;'></div>
										</div>

										<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
													<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">
														<?php echo __d('user','Country');?></div>
													<div class="selectdiv divtwo">
													  <label>
														  <select id="countrys" name="country">
					<option value=""><?php echo __d('user','Select Country');?></option>
					<?php $selected = '';
							foreach ($countrylist as $country) {
								if (isset($usr_datas)  && $country['country'] == $usr_datas['country'])
									$selected = 'selected';
					?>
							<option value="<?php echo $country['id'];?>" <?php echo $selected;?>><?php echo $country['country']; ?></option>
						<?php $selected = '';} ?>
														  </select>
													  </label>

													</div>
													  <div id='alert_country' class="trn" style='color:red;'></div>
												</div>
												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
												<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">
													<?php echo __d('user','State');?></div>
													<div class="divtwo">
													  <input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="state" type="text" name="state" value="<?php if(isset($usr_datas)) { echo $usr_datas['state']; } ?>" placeholder="<?php echo __d('user','Enter State');?>">
													</div>
													<div id='alert_state' class="trn" style='color:red;'></div>
												</div>

										</div>
										<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<div class="popup-label-text col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
											<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">
												<?php echo __d('user','City');?></div>
													<div class="divtwo">
													  <input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="city" type="text" name="city" value="<?php if(isset($usr_datas)) { echo $usr_datas['city']; } ?>" placeholder="<?php echo __d('user','Enter City');?>">
													  <div id='alert_city' class="trn" style='color:red;'></div>
													</div>

												</div>

												<div class="popup-label-text col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
												<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">
													<?php echo __d('user','Zipcode');?></div>
													<div class="divtwo">
													  <input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="zip" type="text" name="zipcode" value="<?php if(isset($usr_datas)) { echo $usr_datas['zipcode']; } ?>" placeholder="<?php echo __d('user','Enter your zipcode');?>">
													  <div id='alert_zip' class="trn" style='color:red;'></div>
													</div>

												</div>

										</div>

										<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding adres-alighn">
											<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">
												<?php echo __d('user','Phone No');?></div>
											<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="phne" type="text" name="phone" maxlength='20' value="<?php if(isset($usr_datas)) { echo $usr_datas['phone']; } ?>" placeholder="<?php echo __d('user','Enter your phone number');?>">
											<div id='alert_ph' class="trn" style='color:red;'></div>
										</div>

      <input name="shippingId" type="hidden" type="text" value="<?php if(isset($usr_datas)) { echo $usr_datas['shippingid']; }else{echo '0';} ?>"/>
										<?php if($sta == 1){ ?><div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding option-radio">
												<input type="radio" id="setdefault" name="setdefault" />
												<label class="adres-cnfrm" for="setdefault"><span></span>
													<?php echo __d('user','Make this as default address');?></label>
											</div>
										</div>
										<?php } ?>

									</div>
								</div>
							</div>

							<div class=" padding-top20 clearfix">
								<div class="">
									<div class="footer-acnt-save">
										
										<div class="btn primary-color-bg primary-color-bg bold-font margin-both5 txt-uppercase pull-right">
												<input class="btn-primary-inpt" value="<?php echo __d('user','Save');?>" type="submit">
										</div>
									</div>
								</div>
							</div>

						</form>
				</div>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>
	<style type="text/css">
		select option {
			padding: 0px !important;
		}
	</style>