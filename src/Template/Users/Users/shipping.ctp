	
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
      <a href="#"><?php echo __d('user','Address Notes');?></a>
     
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
							<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12"> <?php echo __d('user','Address Notes');?> </h2>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin-top10 fint-height margin-bottom10 text-right responsive-text-center">
								<a href="<?php echo SITE_URL.'addaddress';?>" class="primary-color-txt"> <?php echo __d('user','Add Address');?> </a>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding addition-note margin_top0_tab margin0_mobile clearfix">

							<div class="display_none">
								<div class="text-center padding-top30 padding-bottom30">
									<div class="outer_no_div">
										<div class="empty-icon no-addres-note"></div>
									</div>
									<h5><?php echo __d('user','No Address');?></h5>
								</div>
							</div>

							<div class="div-cover-box">
							<h3 class="bold-font font13 extra_text_hide margin0 hor-padding padding-top15 padding-bottom15 responsive-text-center"><?php echo __d('user','Your Saved Shipping Addresses');?></h3>
							<div class="shipping-address hor-padding padding-bottom15 clearfix">
		<?php
		if(count($shippingModel)>0)
		{
			foreach($shippingModel as $shipping)
			{
				$shippingstyle = '';
				$shippingid = $shipping['shippingid'];
				$nick = $shipping['nickname'];
				$fullname = $shipping['name'];
				$address1 = $shipping['address1'];
				$address2 = $shipping['address2'];
				$city = $shipping['city'];
				$state = $shipping['state'];
				$country = $shipping['country'];
				$zip = $shipping['zipcode'];
				$phone = $shipping['phone'];
				if ($usershipping == $shippingid) {
						$ship_count = 1;
						$shippingstyle = 'style="display:none;"';
				}
				echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ship-adrss padding-top15 padding-bottom15 clearfix shipping'.$shippingid.'">
					<div class="default-adres event-color-bg padding-top15 padding-bottom15 hor-padding" >

<div class="dropdown pull-right float_right_mobile_rtl">
  <a data-toggle="dropdown" href="#" class="prod-share-icon-cnt" aria-expanded="false">
		<div class="menu_like_status"></div>
	</a>
  <ul class="dropdown-menu dropdown-menu1 regular-font padding-bottom0 padding-top0" role="menu" aria-labelledby="Label">';

	echo '<li class="">
	<a class="edit_'.$shippingid.'" href="javascript:void(0);" onclick="shippingEdit('.$shippingid.')" >'.__d('user','Edit').'</a>
	</li>
	<li>';
	if($usershipping != $shippingid)
	{
		if($ship_count == 1 && count($shippingModel)>=2 || $ship_count==0 && count($shippingModel)>1)
		{
		echo '<span class="defaultremove slash_'.$shippingid.'"></span>
		<a class="defaultremove remove_'.$shippingid.'" href="javascript:void(0);" onclick="shippingRemove('.$shippingid.')" >'.__d('user','Remove').'</a>';
		}
	}
	echo '</li>';

  echo '</ul>
</div>';
					if ($usershipping != $shippingid) {
					echo '<div class="btn btn-graybg-white-txt bold-font"><a class="remove_ dall default'.$shippingid.'" '.$shippingstyle.' href="javascript:void(0);" onclick="shippingdefault('.$shippingid.')" style="text-transform:uppercase;">'.__d('user','Make Default').'</a>';
					}
					else
					{
						echo '<div class="btn primary-color-bg bold-font"><div class="remove_ dall default" style="text-transform:uppercase;">'.__d('user','Default').'</div>';
					}
					/*if ($usershipping == $shippingid) {
						echo '<button id="defaultbtn'.$shippingid.'" class="btn-primary-inpt txt-uppercase defaultbtn" type="submit">Default</button>';
					}
					else if ($usershipping != $shippingid) {
					echo '<button id="mdefaultbtn'.$shippingid.'" class="white-txt btn-primary-inpt txt-uppercase mdefaultbtn" type="submit" onclick="shippingdefault('.$shippingid.')">Make Default</button>';
					}*/

		/*echo '';
		if($usershipping != $shippingid)
		{
			if($ship_count == 1 && count($shippingModel)>=2 || $ship_count==0 && count($shippingModel)>1)
			{
			echo '<span class="defaultremove slash_'.$shippingid.'"> / </span>
			<a class="defaultremove remove_'.$shippingid.'" href="javascript:void(0);" onclick="shippingRemove('.$shippingid.')" >Remove</a>';
			}
		}*/
					echo '</div>
					<div class="full-adres margin-top20 margin-bottom0">
						<p class="bold-font txt-capitalize">'.$nick.'</p>
						<p class="margin-top10 margin-bottom10">'.$fullname.'</p>
						<p class="margin-top10 margin-bottom10">'.$address1.'</p>
						<p class="margin-top10 margin-bottom10">'.$city.' '.$state.' '.$zip.'</p>
						<p class="margin-top10 margin-bottom10">'.$country.' </p>
					</div>
					</div>
				   </div>';
				   }
		}
		else
		{
			echo '<div>
								<div class="text-center padding-top30 padding-bottom30">
									<div class="outer_no_div">
										<div class="empty-icon no-addres-note"></div>
									</div>
									<h5>'.__d('user','No Address').'</h5>
								</div>
							</div>			';
		}
		?>




							</div>
						</div>
					</div>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>

	<div class="modal fade" id="cancel-order" role="dialog" tabindex="-1">
		<div class=" modal-dialog">
			<div class="modal-content">
				<div class=" login-body modal-body clearfix">
					<button class="close" type="button" data-dismiss="modal">×</button>
					<div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
						<h2 class="popupheder login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding reporttxt">Are you sure want to delete this Address</h2>
					</div>
					<div class=" share-cnt-row col-md-12 padding-bottom10">
						<a class="margin-bottom10  btn txt-uppercase primary-color-bg bold-font yes" href="javascript:void(0);">Yes</a>
						<a class="cancelpop margin-bottom10 btn txt-uppercase primary-color-border-btn bold-font margin-left10 no" data-dismiss="modal" href="javascript:void(0);">No</a>
					</div>

				</div>
			</div>
		</div>
	</div>