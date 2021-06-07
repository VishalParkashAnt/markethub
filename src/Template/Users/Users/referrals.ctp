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
      <a href="#"><?php echo __d('user','Referrals');?></a>
     
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
					<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo $setngs['site_name'].' '.__d('user','Referrals');?> </h2>

				</div>
<?php
if (count($invited_friend) > 0) {
?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">


								<div class="no-hor-padding">
									<h3 class="font13 margin0 bold-font extra_text_hide no-hor-padding padding-bottom20"><?php echo __d('user','Referrals Status');?></h3>

									<div class="display_none">
										<div class="text-center padding-top30 padding-bottom30">
											<div class="outer_no_div">
												<div class="empty-icon no-refferal"></div>
											</div>
											<h5><?php echo __d('user','No Referral');?></h5>
										</div>
									</div>

									<div class="credit-table div-cover-box">
										<div class="table-responsive">
												<table class="table table-hover animate-box fadeInDown animated table-customize margin-bottom0">
													<thead>
														<tr>
															<th class="class-left"><?php echo __d('user','Username');?></th>
															<th><?php echo __d('user','Date');?></th>
															<th><?php echo __d('user','Status');?></th>
														</tr>
													</thead>
													<tbody>
<?php
foreach($invited_friend as $invite){
			echo '<tr class="">';
			if($invite['invited_email']=="")
			{
				echo '<td class="class-left">'.__d('user','Removed User').' </td>';
			}
			else
			{
				echo '<td class="class-left">'.$invite['invited_email'].'</td>';
			}
				echo '<td>'.date('m/d/Y',$invite['invited_date']).'</td>';
			if($invite['status']=='Joined'){
				echo '<td class="primary-color-txt">'.__d('user',$invite['status']).'</td>';
			}
			else{
				if($invite['status']=='Invited'){
						echo '<td class="green-txt">'.__d('user',$invite['status']).'</td>';
				}
				else
				{
						echo '<td class="red-txt">'.__d('user',$invite['status']).'</td>';
				}
				
				
			}
			echo '</tr>';
}
?>

													</tbody>
												</table>
										</div>
									</div>
								</div>

								<div class="join-invite padding-top20 animate-box fadeInUp animated">
									<div class="box-arw text-center padding-top20 padding-bottom20">
										<div class="b-arw arew-left">
											<div class="pointer right-pointer"></div>
											<div class="middle-align">
												<p><?php echo __d('user','Invited');?></p>
												<p class="inv-jnd-cunt green-txt"><?php echo $invitCount;?></p>
											</div>
										</div>
										<div class="b-arw arew-right">
											<div class="pointer left-pointer"></div>
											<div class="middle-align">
												<p><?php echo __d('user','Joined');?></p>
												<p class="inv-jnd-cunt primary-color-txt"><?php echo $joinedCount;?></p>
											</div>
										</div>
									</div>
									<div class="text-center invit-frnds">
										<div class="btn primary-color-bg primary-color-bg bold-font">
											<a class="btn-primary-inpt txt-uppercase" href="<?php echo $baseurl.'invite_friends'; ?>"><?php echo __d('user','Invite More Friends');?></a>
										</div>
									</div>

								</div>

						</div>
		<?php }
		else
		{
		echo '<div class="col-sm-12 col-md-12 col-lg-12" style="text-align:center;color:#ff0000;font-size:14px; margin:10px 0px;">'.__d('user','You haven\'t invited anyone yet').'</div>';

		echo '<div class="col-sm-12 col-md-12 col-lg-12 text-center"><a href="'.$baseurl.'invite_friends" style="font-size:14px;">'.__d('user','Invite Friends').'</a></div>';
		}
		?>
		</div>


		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>