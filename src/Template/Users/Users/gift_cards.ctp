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
			<div class="cnt-top-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="user_profile_inner_heading pro-title-head margin-bottom0 section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo $setngs['site_name'].' '.__d('user','Gift Card');?> </h2>
							<p class="pro-title-head margin-top0 col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php echo __d('user','Gather your friends and give amazing gifts from Fantacy to people you love.');?></p>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">

							<div class="gift-card">
								<ul class="nav nav-pills border_bottom_grey home-page-tab col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<li class="active"><a class="" data-toggle="pill" href="#create-new"><?php echo __d('user','Create New');?></a></li>
									<li class=""><a class="" data-toggle="pill" href="#gift-card-list"><?php echo __d('user','Gift Card List');?></a></li>
								</ul>

								<div class="tab-content section_container col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top30 no-hor-padding">
									<div id="create-new" class="tab-pane fade">
										<div class="section_container clearfix">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top10 padding-bottom30 no-hor-padding">
												<div id="giftcard-bg" class="giftcard-img">
													<div class="bubble white-txt">
														<div class="gift-txt txt-uppercase bold-font"><?php echo $setngs['site_name'].' '.__d('user','Gift Card');?></div>
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<h5 class="bold-font text-center txt-uppercase col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php echo $setngs['site_name'].' '.__d('user','Gift Card');?> </h5>
												<p class="text-center col-xs-12 col-sm-10 col-md-10 col-lg-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1"><?php echo $setngs['site_name'].' '.__d('user','Gift card is the Feature which is used for the User, User can buy send receive the gift card to the friends, And the User can receive the Gift card code and use for the purchase');?></p>
											</div>
											<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 padding-top40 no-hor-padding">
												<form class="add-gif-card" method="post">
													<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
																<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">Value</div>
																<div class="selectdiv divtwo">
																  <label>
																	  <select>
																		  <option selected>Select value</option>
																		  <option>value12</option>
																		  <option>value12</option>
																		  <option>value12</option>
																	  </select>
																  </label>
																</div>
															</div>
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
															<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">Recipient</div>
																<div class="divtwo">
																  <input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="recipient" placeholder="Recipient name" type="text">
																</div>
															</div>
													</div>
													<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding adres-alighn">
														<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">Personal Message</div>
														<textarea class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" rows="4" name="msg" placeholder="Type your message"></textarea>
													</div>

													<div class="padding-top15 margin-both5 clearfix">
														<div class="">
															<div class="footer-acnt-save">
																<div class="btn primary-color-bg bold-font pull-right">
																	<input class="txt-uppercase btn-primary-inpt" value="Add to Cart" type="submit">
																</div>
															</div>
														</div>
													</div>
												</form>
											</div>

										</div>
									</div>
<?php

if(isset($_REQUEST['sent']) || isset($_REQUEST['received'])){
	echo '<div id="gift-card-list" class="tab-pane fade active in">';
	}
else
{
	echo '<div id="gift-card-list" class="tab-pane fade">';
}
?>
										<div class="section_container clearfix">

										<div class="display_none">
											<div class="text-center padding-top30 padding-bottom30">
												<div class="outer_no_div">
													<div class="empty-icon no-gift"></div>
												</div>
												<h5>No Gift card list</h5>
											</div>
										</div>

										<div class="disput-table div-cover-box">
											<ul class="nav nav-pills home-page-tab col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<li class="active"><a class="" data-toggle="pill" href="#sent-card">Sent</a></li>
												<li class=""><a class="" data-toggle="pill" href="#recieved-card">Recieved</a></li>
											</ul>
											<div class="tab-content section_container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
<?php
if(isset($_REQUEST['sent']))
	echo '<div id="sent-card" class="tab-pane fade in active">';
else
	echo '<div id="sent-card" class="tab-pane fade in">';
?>

													<div class="section_container">
														<div class="table-responsive">
<?php
if (count($giftcarddets)>0) {

		echo '<table class="table table-hover animate-box fadeInDown animated table-customize">
			<thead>
				<th>Reciever</th>
				<th>Date</th>
				<th>Total Amount</th>
				<th>Available Amount</th>
				<th>Key</th>
				<th>Status</th>
			</thead>
			<tbody>';
foreach($giftcarddets as $gif){
				echo '<tr>';
				if($gif['reciptent_name']=="")
					echo '<td>Removed User</td>';
				else
					echo '<td>'.$gif['reciptent_name'].'</td>';
				echo '<td>'.date('m/d/Y',$gif['cdate']).'</td>
					<td>$'.$gif['amount'].'</td>
					<td>$'.$gif['avail_amount'].'</td>
					<td class="primary-color-txt">'.$gif['giftcard_key'].'</td>
					<td>Sent</td>
				</tr>';
	}

			echo '</tbody>
		</table>';
}
else
{
	echo 'No gift cards sent';
}

?>
														</div>
														<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20">
															<a href="">+ Load More</a>
														</div>
													</div>
												</div>
<?php
if(isset($_REQUEST['received']))
	echo '<div id="recieved-card" class="tab-pane fade in active">';
else
	echo '<div id="recieved-card" class="tab-pane fade in">';
?>
													<div class="section_container">
														<div class="table-responsive">
<?php
if (count($giftcarddets_recv)>0) {
		echo '<table class="table table-hover animate-box fadeInDown animated table-customize">
			<thead>
				<th>Reciever</th>
				<th>Date</th>
				<th>Total Amount</th>
				<th>Available Amount</th>
				<th>Key</th>
				<th>Status</th>
			</thead>
			<tbody>';
foreach($giftcarddets_recv as $gif)
{
		echo '<tr>';
		if($gif['user']['username']=="")
			echo '<td>Removed User</td>';
		else
			echo '<td>'.$gif['user']['username'].'</td>';
				echo '<td>'.date('m/d/Y',$gif['cdate']).'</td>
				<td>$'.$gif['amount'].' </td>
				<td>$'.$gif['avail_amount'].'</td>
				<td class="primary-color-txt">'.$gif['giftcard_key'].'</td>
				<td>recieved</td>
			</tr>';
}

			echo '</tbody>
		</table>';
}
else
{
	echo 'No gift cards received';
}
?>
														</div>
														<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20">
															<a href="">+ Load More</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										</div>
									</div>

								</div>
							</div>
					</div>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>
	