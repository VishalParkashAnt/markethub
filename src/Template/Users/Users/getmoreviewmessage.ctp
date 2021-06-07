<?php
if (count($csmessageModel)>0){
        					$cmntcontnr = 'style="text-align: right;"';
        					$usrimg = 'style="float: right;"';
        					$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';
					$prof_img = $merchantModel['profile_image'];
					if(empty($prof_img)){
						$prof_img = "usrimg.jpg";
					}
        					foreach ($csmessageModel as $key => $csmessage) {
        						if ($key < 5) {
        							if ($csmessage['sentby'] == $currentUser) {

							echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border_bottom_grey padding-top20 padding-bottom20 hor-padding negotian-by-info clearfix">
									<div class="negotaio-image">
										<div class="messag-img">';
										echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'">';
											echo '<div class="clint-img admin-img" style="background:url('.SITE_URL.'media/avatars/thumb70/'.$prof_img.')"></div>';
											echo '</a>';
										echo '</div>
									</div>
									<div class="negotation-details margin-both15">
									<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'">
										<div class="bold-font margin-top0 margin-bottom10 ">'.$merchantModel['first_name'].'</div>
										</a>
										<p class="font-color">'.date('d,M Y',$csmessage['createdat']).'</p>
										<p class="font-color foldtxt">'.$csmessage['message'].'</p>
									</div>
							</div>';
							}
							else
							{


							echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 negotiatin-chat-cover no-hor-padding clearfix">
								<div class="chatflow padding-top20 padding-bottom30 no-hor-padding clearfix ">
									<div class="nogatim-chat">
										<div class="messag-img">
											<div class="clint-img stranger-img" style="background:url('.SITE_URL.'media/avatars/thumb70/'.$prof_img.')"></div>
										</div>
									</div>
									<div class="messanger-details">
										<div class="bold-font margin-top0 margin-bottom10 ">'.$merchantModel['first_name'].'</div>
										<div class="font-color margin-bottom10">'.date('d,M Y',$csmessage['createdat']).'</div>
										<div class="font-color margin-bottom10 foldtxt">'.$csmessage['message'].'</div>

									</div>
							</div>';
							}
							}
							}
							if (count($csmessageModel) > 5)
							{
								echo '<div class="loadmorecomment centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20" onclick="loadmorecomment('.$contactsellerModel['id'].')" style="cursor: pointer;"><a href="javascript:void(0);">+ '.__d('user','Load More').'</a>
								<div class="morecommentloader" style="display: none;">
        							<img src="'.$baseurl.'images/loading.gif" alt="Loading" />
        						</div>
        					</div>';
							}

	}
	else
	{
		echo 'false';
	}
?>