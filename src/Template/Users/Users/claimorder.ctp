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
								<?php echo __d('user','Claim Order');?> </h2>
						</div>
        	<?php
	        	$shipmentDate = '';
	        	$trackid = '';
	        	$couriername = '';
	        	$courierservice = '';
	        	$notes = '';
        		if (!empty($trackingModel)){
        			echo '<input type="hidden" id="trackid" value="'.$trackingModel['id'].'" />';
        			$shipmentDate = $trackingModel['shippingdate'];
        			$trackid = $trackingModel['trackingid'];
        			$couriername = $trackingModel['couriername'];
        			$courierservice = $trackingModel['courierservice'];
        			$notes = $trackingModel['notes'];

        		}else{
        			echo '<input type="hidden" id="trackid" value="0" />';
        		}
        	?>
        	<input type="hidden" id="hiddenorderid" value="<?php echo $orderModel['orderid']; ?>" />
        	<input type="hidden" id="hiddenbuyeremail" value="<?php echo $userModel['email']; ?>" />
        	<input type="hidden" id="hiddenbuyername" value="<?php echo $userModel['first_name']; ?>" />
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">


								<div class="padding-top10 clearfix">

								<div class="padding-bottom15 clearfix">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="font-weight-normal primary-color-txt margin-bottom20"><?php echo __d('user','Order Id');?> : <?php echo $orderModel['orderid'];?></label><br />
										<label class="font-weight-normal primary-color-txt margin-bottom20">
											<?php echo __d('user','Status');?> :
			<?php
        	if (!empty($orderModel['status'])){
        		echo __d('user',$orderModel['status']);
        		echo '<input type="hidden" id="hiddenorderstatus" value="'.$orderModel['status'].'" />';
        	}else{
        		echo __d('user',"Pending");
        		echo '<input type="hidden" id="hiddenorderstatus" value="Pending" />';
        	}
        	?>
										</label>
									</div>
<form>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding adres-alighn">
				<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Shipment Date');?></div>
				<input type="text" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" readonly="true" name="shipmentdate" id="shipmentdate" value="<?php echo date('m/d/Y',$shipmentDate); ?>">
			</div>
			<div class="shipmentdateerror error"></div>
			<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Shipping Method');?></div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
						<div class="divtwo clearfix">
						  <input type="text" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" readonly="true" name="couriername" id="couriername" value="<?php echo $couriername; ?>"  placeholder="<?php echo __d('user','Enter the Courier');?>">
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
						<div class="divtwo clearfix">
						  <input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="text" readonly="true" name="courierservice" id="courierservice" value="<?php echo $courierservice; ?>"  placeholder="<?php echo __d('user','Shipping Service');?>">
						</div>
					</div>
			</div>
			<div class="couriernameerror error"></div>
			<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding adres-alighn">
				<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Tracking Id');?></div>
				<input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" type="text" name="trackingid" readonly="true" id="trackingid" value="<?php echo $trackid; ?>">
			</div>
			<div class="trackingiderror error"></div>
			<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding adres-alighn">
				<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Additional Notes');?></div>
<textarea rows="10" cols="15" id="notes" readonly="true" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" ><?php echo $notes; ?></textarea>
			</div>


	</div>
	</form>
							</div>

		<div class=" padding-top20 clearfix">
			<div class="">
				<div class="footer-acnt-save">
					<a href="<?php echo SITE_URL.'purchases';?>">
						<div class="btn primary-color-bg primary-color-bg bold-font margin-both5 txt-uppercase pull-right">
								<button class="btn-primary-inpt" type="button"><?php echo __d('user','Cancel');?></button>
						</div>
					</a>
					<div class="btn primary-color-bg primary-color-bg bold-font margin-both5 txt-uppercase pull-right">
							<input class="btn-primary-inpt" onclick="return claimorder(<?php echo $orderModel['orderid']; ?>);" value="<?php echo __d('user','Confirm Claim');?>" type="submit">
					</div>
				</div>
			</div>
		</div>


				</div>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>