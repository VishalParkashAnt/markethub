<?php
$message = "";
	if(!empty($messagedisp)){
	foreach($messagedisp as $key=>$msg){
	//	if ($key < 10) {
$msrc = $msg['commented_by'];
$msrd=date('d,M Y',$msg['date']);
$msrm = $msg['message'];
$msro = $msg['order_id'];
$imagedisputes = $msg['imagedisputes'];
if ($msrc == 'Buyer') {
$profile_image = $buyerModel['profile_image'];
if($profile_image == "")
$profile_image = "usrimg.jpg";
		$message .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border_bottom_grey padding-top10 padding-bottom20 hor-padding negotian-by-info clearfix">
				<div class="negotaio-image">
					<div class="messag-img">
					<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'">
						<div class="clint-img admin-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$profile_image.');background-repeat:no-repeat;"></div>
					</a>
					</div>
				</div>
				<div class="negotation-details margin-both15">
				<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'">
					<div class="bold-font margin-top0 margin-bottom10 primary-color-txt">'.$buyerModel['first_name'].'</div>
				</a>
					<p class="font-color margin-bottom5">'.$msrd.'</p>
					<p class="font-color margin-bottom5">'.$msrm.'</p>';
		if($imagedisputes!='')
		{
			$message .= '<div class="messanger-details">
				<div class="attached-file col-lg-12 col-md-12 col-sm-12 col-xs-12 grey-color-bg hor-padding">
						<div class="pointer right-pointer"></div>
						<p class="text_grey_dark margin-both5 margin-top5 bold-font margin-bottom5">'.__d('user','Download File').'</p>
						<div class="custm-file">
							<div class="file-name">
							<a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" class="url" target="_blank">'.$imagedisputes.'</a>
							</div>
						</div>
					</div>
			</div>';
		}

				$message .= '</div>



		</div>';
}elseif ($msrc == 'Seller') {
$profile_image = $merchantModel['profile_image'];
if($profile_image == "")
$profile_image = "usrimg.jpg";
		$message.= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border_bottom_grey padding-top10 padding-bottom20 hor-padding negotian-by-info clearfix">
				<div class="negotaio-image">
					<div class="messag-img">
					<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'">
						<div class="clint-img admin-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$profile_image.');background-repeat:no-repeat;"></div>
					</a>
					</div>
				</div>
				<div class="negotation-details margin-both15">
				<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'">
					<div class="bold-font margin-top0 margin-bottom10 primary-color-txt">'.$merchantModel['first_name'].'</div>
				</a>
					<p class="font-color margin-bottom5">'.$msrd.'</p>
					<p class="font-color margin-bottom5">'.$msrm.'</p>';
		if($imagedisputes!='')
		{
			$message.= '<div class="messanger-details">
				<div class="attached-file col-lg-12 col-md-12 col-sm-12 col-xs-12 grey-color-bg hor-padding">
						<div class="pointer right-pointer"></div>
						<p class="text_grey_dark margin-both5 margin-top5 bold-font margin-bottom5">'.__d('user','Download File').'</p>
						<div class="custm-file">
							<div class="file-name">
							<a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" class="url" target="_blank">'.$imagedisputes.'</a>
							</div>
						</div>
					</div>
			</div>';
		}

				$message.= '</div>



		</div>';
}
else
{
$profile_image = "usrimg.jpg";
		$message.= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border_bottom_grey padding-top10 padding-bottom20 hor-padding negotian-by-info clearfix">
				<div class="negotaio-image">
					<div class="messag-img">
						<div class="clint-img admin-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$profile_image.');background-repeat:no-repeat;"></div>
					</div>
				</div>
				<div class="negotation-details margin-both15">

					<p class="font-color margin-bottom5">'.$msrd.'</p>
					<p class="font-color margin-bottom5">'.$msrm.'</p>';
		if($imagedisputes!='')
		{
			$message.= '<div class="messanger-details">
				<div class="attached-file col-lg-12 col-md-12 col-sm-12 col-xs-12 grey-color-bg hor-padding">
						<div class="pointer right-pointer"></div>
						<p class="text_grey_dark margin-both5 margin-top5 bold-font margin-bottom5">
						'.__d('user','Download File').'</p>
						<div class="custm-file">
							<div class="file-name">
							<a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" class="url" target="_blank">'.$imagedisputes.'</a>
							</div>
						</div>
					</div>
			</div>';
		}

				$message.= '</div>



		</div>';
}
//}
}
	$result[] = $latestcount;
	$result[] = $message;
	$output = json_encode($result);
	echo $output;
}
else
{
	echo 'false';
}
?>