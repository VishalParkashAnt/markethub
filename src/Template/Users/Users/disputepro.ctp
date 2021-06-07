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
      <a href="#"><?php echo __d('user','Disputes');?></a>
     
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
								<?php echo __d('user','Dispute Management');?> </h2>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">

							<div class="display_none">
								<div class="text-center padding-top30 padding-bottom30">
									<div class="outer_no_div">
										<div class="empty-icon no-disputeicon"></div>
									</div>
									<h5><?php echo __d('user','No Dispute');?></h5>
								</div>
							</div>

							<div class="disput-table div-cover-box">
								<ul class="nav nav-pills home-page-tab col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	<?php
	if(isset($_REQUEST['buyer'])){
		echo '<li class="active"><a class="" href="'.SITE_URL.'dispute/'.$_SESSION['first_name'].'?buyer">'.__d('user','Active Dispute').' ('.$msgelcou.')</a></li>
			<li class=""><a class="" href="'.SITE_URL.'dispute/'.$_SESSION['first_name'].'?seller">'.__d('user','Closed Dispute').' ('.$tocousel.')</a></li>';
	}
	else if(isset($_REQUEST['seller'])){
		echo '<li class=""><a class="" href="'.SITE_URL.'dispute/'.$_SESSION['first_name'].'?buyer">'.__d('user','Active Dispute').' ('.$msgelcou.')</a></li>
			<li class="active"><a class="" href="'.SITE_URL.'dispute/'.$_SESSION['first_name'].'?seller">'.__d('user','Closed Dispute').' ('.$tocousel.')</a></li>';
	}
	?>
								</ul>

								<div class="tab-content section_container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	<?php
	if(isset($_REQUEST['buyer'])){
		echo '<div id="activedispute" class="tab-pane fade in active">
			<div class="section_container">
				<div class="table-responsive">';
		if(count($messagesel)>0)
		{
			echo '<table class="table table-hover animate-box fadeInDown animated table-customize">
				<thead>
					<th>'.__d('user','Dispute ID').'</th>
					<th>'.__d('user','Dispute On').'</th>
					<th>'.__d('user','Other Party').'</th>
					<th>'.__d('user','Dispute Amount').'</th>
					<th>'.__d('user','Status').'</th>
					<th>'.__d('user','View').'</th>
				</thead>
				<tbody>';
			foreach($messagesel as $key=>$msg){
				$msro = $msg['uorderid'];
				$usid = $loguser['id'];
				$disputeid = $msg['disid'];
				$useid = $msg['userid'];
				$itemdetail = $msg['itemdetail'];
				$sellername = $msg['sname'];
				$usename = $msg['uname'];
				$amount = $msg['totprice'];
				$money = $msg['money'];
				$newstatus = $msg['newstatus'];
				$newstatusup = $msg['newstatusup'];
			 	$usernames = $msg['username_url'];
				$item_title_url = $msg['item_title_url'];
				$currencyCode = $msg['currencyCode'];
				if($useid == $usid){
					echo '<tr>
						<td>'.$disputeid.'</td>';
					if($itemdetail == 'null' || $itemdetail==""){
						echo '<td>'.$msro.'</td>';
					}
					else
					{
						$subjects = json_decode($itemdetail, true);

						foreach($subjects as $key=>$sub){
							echo '<td>'.$sub.'</td>';
						}
					}
					if($useid == $usid){
						echo '<td>'.$sellername.'</td>';
					}
					else
					{
						echo '<td>'.$usename.'</td>';
					}
						echo '<td>'.$amount .' ' . $currencyCode.'</td>';
						echo '<td>';
					if($useid == $usid){
				       if($newstatusup == 'Reply'){
				       	echo '<span style="color: #66B5D2;">';
				       	echo __d('user','Responded');
				       	echo '</span>';
				       }elseif($newstatusup == 'Responded'){
				       	echo '<span style="color: #66B5D2;">';
				       	echo __d('user','Reply');
				       	echo '</span>';
				       }elseif($newstatusup == 'Admin'){
				       	echo '<span style="color: #66B5D2;">';
				       	echo __d('user','Reply');
				       	echo '</span>';
				       } else{
					       	echo '<span style="color: #66B5D2;">';
					       	if(strtolower($newstatusup) == "accepeted")
						       echo __d('user',"Accepted");
						    else
						    	echo __d('user',$newstatusup);
					       	echo '</span>';
				   		}
					}
					else
					{
				       if($newstatusup == 'Reply'){
				       	echo '<span style="color: #575757;">';
				       	echo __d('user','Reply');
				       	echo '</span>';
				       }elseif($newstatusup == 'Responded'){
				       	echo '<span style="color: #575757;">';
				       	echo __d('user','Responded');
				       	echo '</span>';
				       }elseif($newstatusup == 'Admin'){
				       	echo '<span style="color: #575757;">';
				       	echo __d('user','Reply');
				       	echo '</span>';
				       } else{
					       	echo '<span style="color: #575757;">';
					       	if(strtolower($newstatusup) == "accepeted")
						       echo __d('user',"Accepted");
						    else
						    	echo __d('user',$newstatusup); 
						    echo '</span>';
				   		}
					}
						echo '</td>';
					if($useid == $usid){
						echo '<td><a href="'.SITE_URL.'disputemessage/'.$msro.'"><button type="button" name="view" class="btn primary-color-border-btn"> '.__d('user','View').' </button></a></td>';
					}
					else
					{
						echo '<td><a href="'.SITE_URL.'disputeBuyer/'.$msro.'"><button type="button" name="view" class="btn primary-color-border-btn"> '.__d('user','View').' </button></a></td>';
					}

					echo '</tr>';
				}
				}
				echo '</tbody>
			</table>';
		}
		else
		{
			echo '<div class="text-center padding-top30 padding-bottom30">
					<div class="outer_no_div">
						<div class="empty-icon no-disputeicon"></div>
					</div>
					<h5>'.__d('user','No active disputes').'</h5>
				</div>';
		}
				echo '</div>
			</div>
		</div>';
	}
	else if(isset($_REQUEST['seller'])){
		echo '<div id="closeddispute" class="tab-pane fade in active">
			<div class="section_container">
				<div class="table-responsive">';
		if(count($messagebuyer)>0)
		{
			echo '<table class="table table-hover animate-box fadeInDown animated table-customize">
				<thead>
					<th>'.__d('user','Dispute ID').'</th>
					<th>'.__d('user','Dispute On').'</th>
					<th>'.__d('user','Other Party').'</th>
					<th>'.__d('user','Dispute Amount').'</th>
					<th>'.__d('user','Status').'</th>
					<th>'.__d('user','View').'</th>
				</thead>
				<tbody>';
			foreach($messagebuyer as $ky=>$msgbuy){
					$msro = $msgbuy['uorderid'];
					$usid = $loguser['id'];
					$disputeid = $msgbuy['disid'];
					$useid = $msgbuy['userid'];
					$selid = $msgbuy['selid'];
					$itemdetail = $msgbuy['itemdetail'];
					$sellername = $msgbuy['sname'];
					$usename = $msgbuy['uname'];
					$amount = $msgbuy['totprice'];
					$money = $msgbuy['money'];
					$newstatus = $msgbuy['newstatus'];
					$newstatusup = $msgbuy['newstatusup'];
					$usernames = $msgbuy['username_url'];
					$item_title_url = $msgbuy['item_title_url'];
					$currencyCode = $msgbuy['currencyCode'];
					if($usid != $selid){
					echo '<tr>
						<td>'.$disputeid.'</td>';
					if($itemdetail == 'null' || $itemdetail==""){
						echo '<td>'.$msro.'</td>';
					}
					else
					{
						$subjects = json_decode($itemdetail, true);
						foreach($subjects as $key=>$sub){
							echo '<td>'.$sub.'</td>';
						}
					}
					if($usid != $selid){
						echo '<td>'.$sellername.'</td>';
					}
					else
					{
						echo '<td>'.$usename.'</td>';
					}
						echo '<td>'.$amount .' ' . $currencyCode.'</td>';
						echo '<td>';
					if($usid != $selid){
				       if($newstatusup == 'Reply'){
				       	echo '<span style="color: #66B5D2;">';
				       	echo __d('user','Responded');
				       	echo '</span>';
				       }elseif($newstatusup == 'Responded'){
				       	echo '<span style="color: #66B5D2;">';
				       	echo __d('user','Reply');
				       	echo '</span>';
				       }elseif($newstatusup == 'Admin'){
				       	echo '<span style="color: #66B5D2;">';
				       	echo __d('user','Reply');
				       	echo '</span>';
				       } else{
				       		echo '<span style="color: #66B5D2;">';
				       		if(strtolower($newstatusup) == "accepeted")
						       echo __d('user',"Accepted");
						   elseif(strtolower($newstatusup) == "cancel")
						    	echo __d('user',"Resolved");
						    else
						    	echo __d('user',$newstatusup); 
						    echo '</span>';
				   		}
					}
					else
					{
				       if($newstatusup == 'Reply'){
				       	echo '<span style="color: #575757;">';
				       	echo __d('user','Reply');
				       	echo '</span>';
				       }elseif($newstatusup == 'Responded'){
				       	echo '<span style="color: #575757;">';
				       	echo __d('user','Responded');
				       	echo '</span>';
				       }elseif($newstatusup == 'Admin'){
				       	echo '<span style="color: #575757;">';
				       	echo __d('user','Reply');
				       	echo '</span>';
				       } else{
				       		echo '<span style="color: #575757;">';
				       		if(strtolower($newstatusup) == "accepeted")
						       echo __d('user',"Accepted");
						    elseif(strtolower($newstatusup) == "cancel")
						    	echo __d('user',"Resolved");
						    else
						    	echo __d('user',$newstatusup); 
						    echo '</span>';
				   		}
					}
						echo '</td>';
					if($usid != $selid){
						echo '<td><a href="'.SITE_URL.'disputemessage/'.$msro.'"><button type="button" name="view" class="btn primary-color-border-btn"> '.__d('user','View').' </button></a></td>';
					}
					else
					{
						echo '<td><a href="'.SITE_URL.'disputeBuyer/'.$msro.'"><button type="button" name="view" class="btn primary-color-border-btn"> '.__d('user','View').' </button></a></td>';
					}

					echo '</tr>';
				}
		}
				echo '</tbody>
			</table>';
		}
		else
		{
			echo '<div class="text-center padding-top30 padding-bottom30">
					<div class="outer_no_div">
						<div class="empty-icon no-disputeicon"></div>
					</div>
					<h5>'.__d('user','No closed disputes').'</h5>
				</div>';
		}
				echo '</div>

			</div>
		</div>';
	}
	?>

								</div>

							</div>
						</div>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>