<?php 
$roundProfile = "";
$roundProfileFlag = 0;
if ($roundProf == "round")  {
	$roundProfile = "border-radius:40px;";
	$roundProfileFlag = 1;
}
?>
<?php 
$message = '';
if (!empty($ordercommentsModel)){
	$cmntcontnr = 'style="text-align: right;"';
	$usrimg = 'style="float: right;"';
	$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';
	foreach ($ordercommentsModel as $ordercomment) {

		if ($ordercomment['commentedby'] == $contacter) {
			$message .= '<div class="cmntcontnr" style="margin: 0 0 10px;">
        					<div class="usrimg" style="float:left;">';
			$message .=  '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';
			if(!empty($merchantModel['profile_image'])){
				$message .=  '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
			}else{
				$message .=  '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
			}
									
			$message .=  '</a></div><div class="cmntdetails"><p class="usrname">';
		    $message .=  '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">'; 
		    $message .=  $merchantModel['first_name']; 
		    $message .=  '</a></p><p class="cmntdate">'.date('d,M Y',$ordercomment['createddate']).'</p>
		        	<p class="comment">'.$ordercomment['comment'].'</p></div></div>';
        }else{
        	$message .=  '<div class="cmntcontnr" style="text-align: right;margin: 0 0 10px;">
        			<div class="usrimg" style="float: right;">';
        			
        	$message .=  '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';
			if(!empty($buyerModel['profile_image'])){
				$message .=  '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
			}else{
				$message .=  '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
			}
							
			$message .=  '</a></div><div class="cmntdetails">
				<p class="usrname" style="float: right; margin-right: 0px; margin-left: 20px;">';
        	$message .=  '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">'; 
        	$message .=  $buyerModel['first_name']; 
        	$message .=  '</a></p>
		        	<p class="cmntdate">'.date('d,M Y',$ordercomment['createddate']).'</p>
		        	<p class="comment">'.$ordercomment['comment'].'</p>
		    	</div>
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

