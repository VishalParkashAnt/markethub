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


			<a href="'.SITE_URL.'help/contact" class="list-group-item">'.__d('user','Contact').'</a>


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
							<h4 class="bold-font margin-top0">
								<?php echo $setngs['site_name']; ?> <?php echo __d('user','for iPhone & iPad');?>
							</h4>
							<p>
							</p>
							<?php
			echo '<div style="text-align: left; padding-top: 100%;  width: 200px; height: 300px; background: transparent url('.SITE_URL.'images/logo/'.$mobile_datas['iosimage'].') no-repeat scroll center center / contain ;" id="selectimgs" class="item-image1">
							</div>';
							?>
							<p>
							<?php echo $mobile_datas['ioscontent']; ?>
							</p>
							<p>
							<?php

							echo '<a href="'.$mobile_datas['ioslink'].'" target="_blank"><img class="download-app-icon primary-color-bg" src="'.SITE_URL.'images/icons/apple-white-icon.png"></a>';
							?>
							</p>
							</div>


							<div class="in_general">
							<h4 class="bold-font margin-top30">
								<?php echo $setngs['site_name']; ?> <?php echo __d('user','for Android');?>
							</h4>
							<p>
							</p>
							<?php
			echo '<div style="text-align: left; padding-top: 100%;  width: 200px; height: 300px; background: transparent url('.SITE_URL.'images/logo/'.$mobile_datas['androidimage'].') no-repeat scroll center center / contain ;" id="selectimgs" class="item-image1">
							</div>';
							?>
							<p>
							<?php echo $mobile_datas['androidcontent']; ?>
							</p>
							<p>
							<?php

							echo '<a href="'.$mobile_datas['androidlink'].'" target="_blank"><img class="download-app-icon primary-color-bg" src="'.SITE_URL.'images/icons/android-white-icon.png"></a>';
							?>
							</p>
							</div>

						</div>

					</div>
				</section>
			</div>
		</div>
	</section>
