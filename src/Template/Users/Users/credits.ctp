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
      <a href="#"><?php echo __d('user','Credits');?></a>
     
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
							<?php echo $setngs['site_name'].' '.__d('user','Credits');?> </h2>

					</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">
						<?php
						if ($available_bal > 0) {
							if($available_bal > 0){
								$available_bal = $available_bal;
							}else{
								$available_bal = 0;
							}
							echo '<div class="fant-credits">
								<div class="padding-top10 padding-bottom20 no-hor-padding">
									<div class="whole-box text-center">
										<div class="first-bg"></div>
										<div class="scnd-bg"></div>
										<div class="box-content padding-top50 padding-bottom30">
											<p>'.__d('user','Available Credits').'</p>
											<h2>$'.$available_bal.'</h2>
										</div>
									</div>
									<div class="text-center padding-top30 padding-bottom0"><p>'.$setngs['site_name'].' '.__d('user','Credits can be applied on your purchases during checkout').'.</p></div>
									<div style="display:none;" class="text-center padding-top30 padding-bottom0"><p>'.__d('user','Earn more credits by').' <a class="color-pink" href="'.SITE_URL.'invite_friends">'.__d('user','Invite Friends').'</a></p></div>
								</div>
								<div class="padding-top10 padding-bottom10 no-hor-padding border_bottom_grey border_top_grey">
									<!--<div class="cls-total text-center"><span>'.__d('user','Total Amount').':</span><span> <b>$ '.$invite_credits.'</b></span></div>-->
								</div>
								<div class="padding-top30 no-hor-padding">

									<div class="display_none">
										<div class="text-center padding-top30 padding-bottom30">
											<div class="outer_no_div">
												<div class="empty-icon no-credit"></div>
											</div>
											<h5>'.__d('user','No History').'</h5>
										</div>
									</div>';
									if(count($creditamt_user)>0){

									echo '<div class="div-cover-box">
									<div class="section_heading bold-font extra_text_hide no-hor-padding padding-bottom15">'.__d('user','Invite Credit History').'</div>

									<div class="credit-table">
										<div class="table-responsive">
												<table class="table table-hover animate-box fadeInDown animated table-customize margin-bottom0">
													<thead>
														<tr>
															<th class="class-left">'.__d('user','Username').'</th>
															<th>'.__d('user','Date').'</th>
															<th>'.__d('user','Amount').'</th>
														</tr>
													</thead>
													<tbody>';
				foreach($creditamt_user as $usrr)
				{
						echo '<tr class="">';
						if($usrr['user_id']=='0'){
							echo '<td class="class-left">'.__d('user','From Group Gift').' </td>';
						}
						else
						{
							if($usrr['user']['username'] == "")
								echo '<td class="class-left">'.__d('user','Removed User').' </td>';
							else
								echo '<td class="class-left">'.$usrr['user']['username'].' </td>';
						}
							echo '<td>'.date('m/d/Y',$usrr['cdate']).'</td>
							<td>$'.$usrr['credit_amount'].'</td>
						</tr>';
				}

													echo '</tbody>
												</table>
											</div>
									</div>
								</div>
								</div>
							</div><br>';
							}
						}
						else
						{
							echo '<div style="text-align:center;color:#ff0000;font-size:20px;" class="fant-credits">'.__d('user','Your Credit amount is empty').'.</div>
							<div style="text-align:center;font-size:14px;">
							'.__d('user','Earn more credits by').' <a href="'.SITE_URL.'invite_friends">'.__d('user','Invite Friends').'</a>
							</div>
							';
						}
						//$refund=$available_bal-$invite_credits;
						if(count($refundorders)>0 || count($giftrefund)>0){
						echo '<div class="div-cover-box">
									<div class="section_heading bold-font extra_text_hide no-hor-padding padding-bottom15">Refunded Credit History</div>

									<div class="credit-table">
										<div class="table-responsive">
												<table class="table table-hover animate-box fadeInDown animated table-customize margin-bottom0 bounceIn">
													<thead>
														<tr>
															
															<th>Order/Gift Id</th>
															<th>Amount</th>
														</tr>
													</thead>
													<tbody>';
													foreach($refundorders as $refund){
													if($refund['refunded_amount']>0){

													echo '
													<tr class=""><td>'.$refund['orderid'].'</td>
													<td>$'.$refund['refunded_amount'].'</td></tr>';
													}}

													foreach($giftrefund as $refund){
														if($refund['amount']>0){

														echo '<tr class="">
														<td>'.$refund['ggid'].'</td>
														<td>$'.$refund['amount'].'</td></tr>';
													}}
												echo '</tbody>';
												echo '</table>
											</div>
									</div>
								</div>';
								}
								//echo count($shareitem_purchases);die;
								if(count($shareitem_purchases)>0) {
									echo '<div class="div-cover-box">
									<div class="section_heading bold-font extra_text_hide no-hor-padding padding-bottom15">Shared Product Credit History</div>

									<div class="credit-table">
										<div class="table-responsive">
												<table class="table table-hover animate-box fadeInDown animated table-customize margin-bottom0 bounceIn">
													<thead>
														<tr>
															
															<th>Item Name</th>
															<th>Amount</th>
														</tr>
													</thead>
													<tbody>';

													foreach($shareitem_purchases as $shareitem){
													if($shareitem['share_amount']>0){
														//print_r($shareitem);die;
													echo '
													<tr class=""><td>'.$shareitem['item']['item_title'].'</td>
													<td>$'.$shareitem['share_amount'].'</td></tr>';
													}}
												echo '</tbody>';
												echo '</table>
											</div>
									</div>
								</div>';
								}
						?>

						</div>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>