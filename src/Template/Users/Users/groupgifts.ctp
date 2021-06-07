
    <!-- breadcrumb start -->
<div class="container-fluid margin-top10 no_hor_padding_mobile">
  <div class="container">
<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
     <div class="breadcrumb">
      <a href="<?php echo $baseurl;?>"><?php echo __d('user','Home');?></a>
      <span class="breadcrumb-divider1">/</span>
      <a href="#"><?php echo __d('user','Create New Gift');?></a>
     
     </div>
    </div>
     
  </div>
    </div>
    <!-- breadcrumb end -->
	<section class="container-fluid side-collapse-container no_hor_padding_mobile margin_top165_mobile">
		<div class="container">
			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="create_gift">
						<h2 class="find_new_heading extra_text_hide">
							<?php echo __d('user','Start a Group Gift Today');?></h2>
						<p class="extra_text_hide margin-bottom0 margin-top5">
							<?php echo __d('user','Gather your friends and give amazing gifts to the people you love');?></p>

						<ul class="margin-top20">
						<li class="active bold-font"><a href="javascript:void(0);"><?php echo __d('user','Create New Gift');?></a></li>
						<li><a href="<?php echo SITE_URL.group_gift_lists;?>"><?php echo __d('user','Group Gift List');?></a></li>
						</ul>
				</div>
			</section>

			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">
				<div class="create_gift">
					<div class="group_gift">
					<h2 class="text-center bold-font"><?php echo __d('user','How it Works');?></h2>
					<div class="gift_heading_border"></div>
					</div>

					<div class="text-center regular-font">
					<h5 class="line_height25"><?php echo __d('user','Create a easy and fun way to give gifts to your friends');?></h5>
					<h5 class="line_height25"><?php echo __d('user','Contribute pick any item, Contribute any amount. You are only charged if group gift was successful');?></h5>
					<h5 class="line_height25"><?php echo __d('user','Invite your friends to contribute. Once you meet your target,').$setngs['site_name'].' '.__d('user','will take care of rest');?>!</h5>
					</div>

					<div class="view-all-btn center_div btn primary-color-bg">
						<a href="<?php echo SITE_URL;?>"><?php echo __d('user','Start Shopping');?></a>
					</div>

					<div class="row margin-top30">
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 border_right_grey padding15">
							<div class="select_gift gift_steps_bg center-block"></div>
							<h5 class="text-center">1. <?php echo __d('user','Select Gift');?></h5>
							<div class="popup-heading-border"></div>
						</div>

						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 border_right_grey padding15">
							<div class="create_gift_group gift_steps_bg center-block"></div>
							<h5 class="text-center">2. <?php echo __d('user','Create Group Gift');?></h5>
							<div class="popup-heading-border"></div>
						</div>

						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 border_right_grey padding15">
							<div class="invite_friends_gift gift_steps_bg center-block"></div>
							<h5 class="text-center">3. <?php echo __d('user','Invite Your Friends');?></h5>
							<div class="popup-heading-border"></div>
						</div>

						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 padding15">
							<div class="reach_target gift_steps_bg center-block"></div>
							<h5 class="text-center">4. <?php echo __d('user','Reach Target');?></h5>
							<div class="popup-heading-border"></div>
						</div>

					</div>
				</div>
					<div class="create_gift border_top_grey">
					<div class="text-center">
						<span class="gift_group_border padding-right10"><?php echo __d('user','Minimum Contribute Amount');?> <span class="red-txt">5%</span></span>
						<span class="padding-left10"><?php echo __d('user','Target should be reached within'); ?> <span class="red-txt">7 <?php echo __d('user','days'); ?></span> <?php echo __d('user','or else it will expire');?></span>
					</div>
					</div>
					</section>
		</div>



	</section>
