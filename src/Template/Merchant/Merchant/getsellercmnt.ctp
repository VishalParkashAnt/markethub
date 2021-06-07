<?php 
$roundProfile = "";
$roundProfileFlag = 0;
if ($roundProf == "round")  {
	$roundProfile = "border-radius:40px;";
	$roundProfileFlag = 1;
} else {
	$roundProfile = "border-radius:8px;";
}
?>

<?php 
$message = '';

if (!empty($messagedisp)){
	$cmntcontnr = 'style="text-align: right;"';
	$usrimg = 'style="float: right;"';
	$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';
	foreach($messagedisp as $key=>$msg){
		if ($msg['commented_by'] == 'Buyer') {
			$message .= '<div class="cmntcontnr" style="text-align: right;">
        					<div class="usrimg" style="float: right;">'; 
				if($merchantModel['user_level'] == 'shop') {
					if(!empty($merchantModel['profile_image'])){
				$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
			}else{
				$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
			}

				} else { 
			$message .=  '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';
			if(!empty($merchantModel['profile_image'])){
				$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
			}else{
				$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
			}
									
			$message .=  '</a>'; 
			} 
			$message .= '</div><div class="cmntdetails">
		        				<p class="usrname" style="float: right; margin-right: 0px; margin-left: 20px;">';
			if($merchantModel['user_level'] == 'shop') { 

			$message .=  $merchantModel['first_name']; 
			} else { 
		    $message .=  '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">'; 
		    $message .=  $merchantModel['first_name']; 
		    $message .=  '</a>';
			}
		    $message .= '</p><p class="cmntdate">'.date('d,M Y',$msg['date']).'</p>
		        	<p class="comment" style="word-break:break-all;margin-left: -25px;">'.$msg['message'].'</p>';
		if($msg['imagedisputes'] == '') { } else {
			$message .= '<p class="linimg" style=""><a href="'.SITE_URL.'disputeimage/'.$msg['imagedisputes'].'" class="url" target="_blank">'.'Image'.'</a></p>';
				}
			$message .= '</div></div>';
        }elseif ($msg['commented_by'] == 'Seller') {
        	$message .=  ' <div class="cmntcontnr">
        					<div class="usrimg">';
        	if($buyerModel['user_level'] == 'shop') { 
			if(!empty($buyerModel['profile_image'])){
				$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
			}else{
				$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
			}

		} else { 
        	$message .=  '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';
			if(!empty($buyerModel['profile_image'])){
				$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
			}else{
				$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
			}
							
			$message .=  '</a>'; 
                } 
              $message .= '</div><div class="cmntdetails">
					<p class="usrname">';
			if($buyerModel['user_level'] == 'shop') { 
			$message .=  $buyerModel['first_name']; 
			} else { 
        	$message .=  '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">'; 
        	$message .=  $buyerModel['first_name']; 
        	$message .=  '</a>'; 
			} 
			$message .= '</p>
		        	<p class="cmntdate">'.date('d,M Y',$msg['date']).'</p>
		        	<p class="comment" style="word-break:break-all;">'.$msg['message'].'</p>';
		if($msg['imagedisputes'] == '') { } else {
			$message .= '<p class="linimg" style=""><a href="'.SITE_URL.'disputeimage/'.$msg['imagedisputes'].'" class="url" target="_blank">'.'Image'.'</a></p>';
				}
		  $message .='</div>
        	</div>'; 
		}else{
        	$message .=  '<div class="cmntcontnr" style="text-align: right;">
        					<div class="usrimg" style="float: right;">';
        			
        	//$message .=  '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';
			//if(!empty($buyerModel['profile_image'])){
				//$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
			//}else{
				$message .=  '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
			//}
							
			$message .=  '</a></div><div class="cmntdetails">
		        				<p class="usrname" style="float: right; margin-right: 0px; margin-left: 20px;">';
        	$message .=  '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">'; 
        	$message .=  $msg['commented_by']; 
        	$message .=  '</a></p>
		        	<p class="cmntdate">'.date('d,M Y',$msg['date']).'</p>
		        	<p class="comment" style="word-break:break-all;margin-left: -25px;">'.$msg['message'].'</p>';
		if($msg['imagedisputes'] == '') { } else {
			$message .= '<p class="linimg" style=""><a href="'.SITE_URL.'disputeimage/'.$msg['imagedisputes'].'" class="url" target="_blank">'.'Image'.'</a></p>';
				}
			$message .= '</div>
        	</div>'; 
			

		}
	}
	$result[] = $latestcount;
	$result[] = $message;
	$output = json_encode($result);
	echo $output;	
}else{
	echo "false";
}

