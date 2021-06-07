<?php 
 
$roundProfile = "";
$roundProfileFlag = 0;
if ($roundProf == "round")  {
	$roundProfile = "border-radius:40px;";
	$roundProfileFlag = 1;
} else {
	$roundProfile = "border-radius:8px;";
}

if (!empty($csmessageModel)){
	$cmntcontnr = 'style="text-align: right;"';
	$usrimg = 'style="float: right;"';
	$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';
	foreach ($csmessageModel as $key => $csmessage) {
		if ($csmessage['sentby'] == $currentUser) {
			echo '<div class="cmntcontnr">
					<div class="usrimg">
		        			<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';
						if(!empty($merchantModel['profile_image'])){
							echo '<img src="'.SITE_URL.'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
						}else{
							echo '<img src="'.SITE_URL.'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
						}
							
						echo '</a>
					</div>
					<div class="cmntdetails">
						<p class="usrname">';
							echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">'; 
								echo $merchantModel['first_name']; 
							echo '</a>
						</p>
						<p class="cmntdate">'.date('d,M Y',$csmessage['createdat']).'</p>
    	    			<p class="comment">'.$csmessage['message'].'</p>
			  		</div>
				</div>';
		}else{
        		echo '<div class="cmntcontnr" style="text-align: right;">
        				<div class="usrimg" style="float: right;">
        					<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';
							if(!empty($buyerModel['profile_image'])){
							echo '<img src="'.SITE_URL.'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
							}else{
							echo '<img src="'.SITE_URL.'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
							}
							
							echo '</a>
        			</div>
        			<div class="cmntdetails">
        				<p class="usrname" style="float: right; margin-right: 0px; margin-left: 20px;">
        					<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">'; 
        						echo $buyerModel['first_name']; 
        					echo '</a>
        				</p>
        				<p class="cmntdate">'.date('d,M Y',$csmessage['createdat']).'</p>
        				<p class="comment">'.$csmessage['message'].'</p>
		        			</div>
        				</div>';
		}
	} 
}else{
	echo "false";
}
