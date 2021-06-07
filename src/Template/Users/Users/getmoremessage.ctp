<?php
if (count($messageModel)>0) {
foreach($messageModel as $message)
{
					$csId = $message['csid'];
					$item = $message['item'];
					$itemid = $message['itemid'];
					$itemurl = $message['itemurl'];
					$itemurl = base64_encode($itemid."_".rand(1,9999));
					$prof_img = $message['profile_image'];
					if(empty($prof_img)){
						$prof_img = "usrimg.jpg";
					}
					$bold = '';
					$tid++;
							echo '<div class="seller-view-row padding-top10 padding-bottom10 padding-right10 padding-left10 event-color-bg clearfix">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding negotian-by-info">


									<div class="negotaio-image">
										<div class="messag-img">
											<div class="clint-img order-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$prof_img.')"></div>
										</div>
									</div>
									<div class="negotation-details margin-both15">
										<div class="bold-font margin-top0 margin-bottom10">'.$message['from'].'</div>
										<p class="margin-bottom5"><b>'.__d('user','Sub').':</b> '.$message['subject'].'</p>
										<!--p class="margin-bottom5"><small>18 Mar 2016</small></p-->
									</div>


								</div>
								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-hor-padding ">
									<div class="center-area">
										<div class="centered">
											<p class="margin-bottom0"><b>'.__d('user','Item').': </b></p>
											<a href="'.SITE_URL.'listing/'.$itemurl.'" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding extra_text_hide width-custom">'.$item.'</a>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center no-hor-padding ">
									<div class="block2">
										<div class="inner">
											<a href="'.SITE_URL.'viewmessage/'.$csId.'">
											<button class="btn primary-color-border-btn " type="button" name="view"> '.__d('user','View').' </button>
											</a>
										</div>
									</div>
								</div>
							</div>';
		}


	}
	else
{
	echo 'false';
}
?>