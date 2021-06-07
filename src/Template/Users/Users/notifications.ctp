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
				<a href="#"><?php echo __d('user','Notifications');?></a>
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
			<?php echo __d('user','Notifications');?> </h2>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">
			<?php
			echo $this->Form->create('Notifications', [
				'url' => ['controller' => 'Users', 'action' => 'notifications']
			]);
			?>
			<div class="border_bottom_grey padding-top20 clearfix">
				<div class="padding-bottom15 clearfix">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<label class="font-weight-normal primary-color-txt margin-bottom20"><?php echo __d('user','Email');?></label>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
						<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font border_bottom_grey padding-bottom15"><?php echo __d('user','Email Settings');?></div>
							<div class=" padding-bottom5 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="checkbox checkbox-primary margin-top15 margin-bottom0">
									<?php if($usr_datas['someone_follow']=='1'){ ?>
										<input name="somone_flw" id="following" checked = "checked" type="checkbox" value=NULL>
										<label for="following"><?php echo __d('user','When someone follows you');?></label>
									<?php }else{ ?>
										<input name="somone_flw" id="following" type="checkbox" value=NULL>
										<label for="following"><?php echo __d('user','When someone follows you');?></label>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="border_bottom_grey padding-top20 clearfix">
				<div class="padding-bottom15 clearfix">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<label class="font-weight-normal primary-color-txt margin-bottom20"><?php echo __d('user','Notifications');?></label>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
						<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font border_bottom_grey padding-bottom15"><?php echo __d('user','Web and push settings');?> <small class="normal-font"> (<?php echo __d('user','Activity that involves you');?>) </small></div>
							<div class=" padding-bottom5 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="checkbox checkbox-primary margin-top15 margin-bottom0">
									<?php
									$decoded_value = json_decode($usr_datas['push_notifications']);
									if($decoded_value->somone_flw_push=='1'){ ?>
										<input name="somone_flw_push" id="somone_flw_push"  checked = "checked" value=NULL type="checkbox">
										<label for="somone_flw_push"><?php echo __d('user','When someone follows you');?></label>
									<?php }else{ ?>
										<input name="somone_flw_push" id="somone_flw_push" value=NULL type="checkbox">
										<label for="somone_flw_push"><?php echo __d('user','When someone follows you');?></label>
									<?php } ?>
								</div>
							</div>
							<div class=" padding-bottom5 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="checkbox checkbox-primary margin-top15 margin-bottom0">
									<?php if($decoded_value->somone_mentions_push=='1'){ ?>
										<input name="somone_mentions_push" id="somone_mentions_push" checked = "checked" value=NULL type="checkbox">
										<label for="somone_mentions_push"><?php echo __d('user','When someone mentions you');?></label>
									<?php } else { ?>
										<input name="somone_mentions_push" id="somone_mentions_push" value=NULL type="checkbox">
										<label for="somone_mentions_push"><?php echo __d('user','When someone mentions you');?></label>
									<?php } ?>
								</div>
							</div>
							<div class=" padding-bottom5 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="checkbox checkbox-primary margin-top15 margin-bottom0">
									<?php if($decoded_value->somone_cmnts_push=='1'){ ?>
										<input name="somone_cmnts_push" id="somone_cmnts_push" checked = "checked" value=NULL type="checkbox">
									<?php } else{ ?>
										<input name="somone_cmnts_push" id="somone_cmnts_push" value=NULL type="checkbox">
									<?php } ?>
									<label for="somone_cmnts_push"><?php echo __d('user','When someone comments on a thing you').' '.$setngs['like_btn_cmnt'];?></label>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font border_bottom_grey padding-bottom15 padding-top20"><?php echo __d('user','Store & Friends activity');?> </div>
							<div class=" padding-bottom5 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="checkbox checkbox-primary margin-top15 margin-bottom0">
									<?php
									$decoded_value = json_decode($usr_datas['push_notifications']);
									if($decoded_value->frends_flw_push=='1'){ ?>
										<input name="frends_flw_push" id="frends_flw_push"  checked = "checked" value=NULL type="checkbox">
									<?php } else { ?>
										<input name="frends_flw_push" id="frends_flw_push" value=NULL type="checkbox">
									<?php } ?>
									<label for="frends_flw_push"><?php echo __d('user','When product Added by followed Store or profile');?></label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="border_bottom_grey padding-top20 clearfix">
				<div class="padding-bottom15 clearfix">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<label class="font-weight-normal primary-color-txt margin-bottom20"><?php echo __d('user','Updates');?></label>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
						<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font border_bottom_grey padding-bottom15"><?php echo __d('user','Updates from').' '.$setngs['site_name'];?></div>
							<div class=" padding-bottom5 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="checkbox checkbox-primary margin-top15 margin-bottom0">
									<input type="hidden" value="off" name="news_abt" />
									<?php if($usr_datas['subs']=='1'){ ?>
										<input name="news_abt" id="news_abt" value=NULL checked = "checked" type="checkbox">
										<label for="news_abt"><?php echo __d('user','Send news about').' '.$setngs['site_name'];?></label>
									<?php } else { ?>
										<input name="news_abt" id="news_abt" value=NULL type="checkbox">
										<label for="news_abt"><?php echo __d('user','Send news about').' '.$setngs['site_name'];?></label>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class=" padding-top15 clearfix">
				<div class="">
					<div class="footer-acnt-save">
						<div class="btn primary-color-bg primary-color-bg bold-font txt-uppercase pull-right">
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