	<section class="side-collapse-container margin-top20">
		<div class="container">
			<div class="">

				<section class="">


		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 no-hor-padding sidebar sidebar border_right_grey margin_top_150_tab">
    <div class="mini-submenu profile-menu">
        <!--<span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>-->
    </div>
    <div class="list-group margin0">
        <span class="list-group-item sidebar-top-title list-group-item sidebar-top-title active">
            <h4 class="panel-title accordion_shop bold-font txt-uppercase"><?php echo __d('user','Help');?></h4>
            <span class="pull-right" id="slide-submenu">
                <img src="<?php echo SITE_URL;?>images/icons/close-gray.png" width="16" height="20">
            </span>
        </span>
		<div class="acnt-submenu border_bottom_grey">
		<?php
			echo '<a href="'.SITE_URL.'help/faq" class="list-group-item">'.__d('user','FAQ').'</a>


			<a href="'.SITE_URL.'help/contact" class="list-group-item active">'.__d('user','Contact').'</a>


			<a href="'.SITE_URL.'help/copyright" class="list-group-item">'.__d('user','Copyright policy').'</a>


			<a href="'.SITE_URL.'help/terms_sales" class="list-group-item">'.__d('user','Terms of sales').' </a>


			<a href="'.SITE_URL.'help/terms_service" class="list-group-item"> '.__d('user','Terms of service').'</a>
			<a href="'.SITE_URL.'help/terms_condition" class="list-group-item"> '.__d('user','Terms & condition').'</a>
			<a href="'.SITE_URL.'help/privacy" class="list-group-item"> '.__d('user','Privacy').'</a>';
		?>
		</div>

		<span class="list-group-item sidebar-top-title list-group-item sidebar-top-title">
            <h4 class="panel-title accordion_shop bold-font txt-uppercase "><?php echo __d('user','Account Info');?></h4>
        </span>
		<div class="acnt-submenu border_bottom_grey">
		<?php
			echo '<a href="'.SITE_URL.'help/about" class="list-group-item">
				'.__d('user','About').'
			</a>
			<a href="'.SITE_URL.'help/documentation" class="list-group-item">
				'.__d('user','Documentation').'
			</a>
			<a href="'.SITE_URL.'help/press" class="list-group-item">
				'.__d('user','Press').'
			</a>
			<a href="'.SITE_URL.'help/pricing" class="list-group-item">
				'.__d('user','Pricing').'
			</a>
			<a href="'.SITE_URL.'help/talk" class="list-group-item">
			'.$setngs['site_name'].' '.__d('user','Talk').'
			</a>';
		?>
		</div>



    </div>
	</div>
					<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 no-hor-padding clearfix min-height-profile">

						<div class="cnt-top-header border_bottom_grey col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height"><?php echo __d('user','Help');?> </h2>

						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">
							<div class="in_general">
<?php
$contacts = json_decode($contact,true); ?>

<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin-top20">
	<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Email').' : '; ?></div>
	<?php echo $contacts['emailid']; ?>
</div>

<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin-top20">
	<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Mobile No').' : '; ?></div>
	<?php echo $contacts['mobileno']; ?>
</div>

<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin-top20">
	<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Contact Address').' : '; ?></div>
	<?php echo $contacts['contactaddress']; ?>
</div>

<?php 
echo $this->Form->create('notifi',array('url'=>array('controller'=>'helps','action'=>'contact'),'onsubmit'=>'return helpcontact()')); ?>

					<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin-top20">
						<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Your Name');?></div>
						<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="text" value="" id="contact_name" name="contact_name"><br />
						<span style="font-size:13px;color:red;font-weight:normal;" class="trn" id="nameerr"></span>
					</div>
					<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Your Email Address');?></div>
						<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="text" value="" id="contact_email" name="contact_email"><br />
						<span style="font-size:13px;color:red;font-weight:normal;" class="trn" id="emailerr"></span>
					</div>
					<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="selectdrpdwn popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Select a topic');?></div>
						<div class="selectdiv margin-bottom20">
						<select class="topic" name="topic">
							<option value="User account"><?php echo __d('user','User account');?></option>
							<option value="Forgot my password"><?php echo __d('user','Forgot my password');?></option>
							<option value="Order Inquiry"><?php echo __d('user','Order Inquiry');?></option>
							<option value="Payment Issues"><?php echo __d('user','Payment Issues');?></option>
							<option value="Returns and Refunds"><?php echo __d('user','Returns and Refunds');?></option>
							<option value="Fantacy Site Features"><?php echo $setngs['site_name'].' '.__d('user','Site Features');?></option>
							<option value="Fantacy Mobile Features"><?php echo $setngs['site_name'].' '.__d('user','Mobile Features');?></option>
							<option value="Partnership Opportunities"><?php echo __d('user','Partnership Opportunities');?></option>
							<option value="Copyright Issue"><?php echo __d('user','Copyright Issue');?></option>
						</select>
						</div>
					</div>
					<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Order Number');?></div>
						<input class="order popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="text" placeholder="If applicable" name="contact_order"><br />
						<span style="font-size:13px;color:red;font-weight:normal;" class="trn" id="ordererr"></span>
					</div>
					<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Username');?></div>
						<input class="user popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="text" value="" name="contact_user"><br />
						<span style="font-size:13px;color:red;font-weight:normal;" class="trn" id="usererr"></span>
					</div>
					<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Message');?></div>

						<textarea  data-gramm="false" class="description popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="contact_message" maxlength="250"></textarea><br />
						<span style="font-size:13px;color:red;font-weight:normal;" class="trn" id="descriptionerr"></span>
						<p class="text-right font-size12 col-sm-12 margin-top5 margin0 padding0 pull-right">(<?php echo __d('user','Maximum 250 characters only');?>)</p><br />

					</div>
					<button class="btn filled-btn follow-btn primary-color-bg margin-top10" type="submit"><?php echo __d('user','Submit');?></button>
					<div class="contact-error trn" style="font-size:13px;color:red;font-weight:normal;"></div>
			</form>
							</div>
						</div>

					</div>
				</section>
			</div>
		</div>
	</section>
