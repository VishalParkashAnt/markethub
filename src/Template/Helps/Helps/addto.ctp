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
								<?php echo __d('user','Add to');?> <?php echo $setngs['site_name']; ?>
								</h4>
								<p><?php echo __d('user','Be a part of the');?> <?php echo $setngs['site_name'];?> <?php echo __d('user','community and add your favorite things.');?>
							</div>
							<div class="in_general">
								<h4 class="bold-font margin-top30">
								<?php echo $setngs['liked_btn_cmnt'];?> <?php echo __d('user','Button');?>
								</h4>

		<div id="bookmarkhome" style="background: none repeat scroll 0 0 #F0F3F6;border-top: 1px solid #E2E8ED;color: #373D48;display: inline-block;font-size: 15px;">
			<a style="box-shadow:none;" class="btn filled-btn follow-btn primary-color-bg"	href="javascript:(function(){_my_script=document.createElement('SCRIPT');_my_script.type='text/javascript';_my_script.src='<?php echo SITE_URL; ?>script.js?';document.getElementsByTagName('head')[0].appendChild(_my_script);})();"><?php echo $setngs['liked_btn_cmnt']; ?></a> <?php echo __d('user','Drag this');?>
			<b><?php echo __d('user','button');?></b>
			<?php echo __d('user','into your Bookmarks Bar');?>
		</div>

				<p>
				<strong><?php echo __d('user','The bookmarklet lets you save things and products from any site to your own ').$setngs['site_name'].__d('user',' catalog.');?></strong>
				</p>
				<p class="chrome" style="display: none;"><?php echo __d('user','To install the ');
				echo '"'.$setngs['liked_btn_cmnt'].'"';echo __d('user',' bookmarklet in Chrome, follow these steps:')?></p>
				<p class="firefox"><?php __('To install the ');
				echo '"'.$setngs['liked_btn_cmnt'].'"';echo __d('user',' bookmarklet in Firefox, follow these steps:');?></p>

			<p>
				<span class="no"><?php echo __('1');?></span>
				<strong><?php echo __d('user','Drag bookmarklet');?></strong>
				<?php echo __d('user','Drag the blue');?>
				<b><?php echo $setngs[0]['Sitesetting']['liked_btn_cmnt'];?></b>
				<?php echo __d('user','button above to your Bookmarks bar.');?>
			</p>
			<p>
				<span class="no"><?php echo __('2');?></span>
				<strong><?php echo __d('user','You’re finished');?></strong>
				<?php echo __d('user','When you are browsing a webpage, click');?>
				<b><?php echo $setngs[0]['Sitesetting']['liked_btn_cmnt'];?></b>
				<?php echo __d('user','to add things to your personal catalog.');?>
			</p>

							</div>
						</div>

					</div>
				</section>
			</div>
		</div>
	</section>
	<style>
		@media (min-width: 640px) {
		    #bookmarkhome {
		        min-width: 602px;
		        line-height: 67px;
		        margin-bottom: 28px;
		        padding: 0 14px;
		    }
		}
		@media (max-width: 639px) {
		    a.filled-btn {
		        width: 100%;
		    }
		    #bookmarkhome {
		        line-height: 40px;
		        margin-bottom: 25px;
		        padding: 14px 14px;
		    }
		} 
	</style>