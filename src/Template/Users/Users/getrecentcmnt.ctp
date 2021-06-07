<?php
$message = "";
if (count($ordercommentsModel)>0){
        					$cmntcontnr = 'style="text-align: right;"';
        					$usrimg = 'style="float: right;"';
        					$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';

        					foreach ($ordercommentsModel as $key => $ordercomment) {
        						if ($key < 5) {
        							if ($ordercomment['commentedby'] != 'seller') {
					$prof_img = $buyerModel['profile_image'];
					if(empty($prof_img)){
						$prof_img = "usrimg.jpg";
					}
							$message .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border_bottom_grey padding-top20 padding-bottom20 no-hor-padding negotian-by-info clearfix">
									<div class="negotaio-image">
										<div class="messag-img">
										<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'">
											<div class="clint-img admin-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$prof_img.');background-repeat:no-repeat; border-radius:3px;"></div>
											</a>
										</div>

									</div>
									<div class="negotation-details margin-both15">
									<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'">
										<div class="bold-font margin-top0 margin-bottom10 ">'.$buyerModel['first_name'].'</div>
										</a>
										<p class="font-color">'.date('d M Y',$ordercomment['createddate']).'</p>
										<p class="font-color foldtxt">'.$ordercomment['comment'].'</p>
									</div>
							</div>';
							}
							else
							{

					$prof_img = $merchantModel['profile_image'];
					if(empty($prof_img)){
						$prof_img = "usrimg.jpg";
					}
							$message .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 negotiatin-chat-cover no-hor-padding clearfix">
								<div class="chatflow padding-top20 padding-bottom30 no-hor-padding clearfix ">
									<div class="nogatim-chat">
										<div class="messag-img">
										<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'">
											<div class="clint-img stranger-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$prof_img.');background-repeat:no-repeat; border-radius:3px;"></div>
											</a>
										</div>
									</div>
									<div class="messanger-details">
									<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'">
										<div class="bold-font margin-top0 margin-bottom10 ">'.$merchantModel['first_name'].'</div>
									</a>
										<div class="font-color margin-bottom10">'.date('d M Y',$ordercomment['createddate']).'</div>
										<div class="font-color margin-bottom10 foldtxt">'.$ordercomment['comment'].'</div>

									</div>
							</div>';
							}
							}
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