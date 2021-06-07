<?php echo $this->element('numberconversion'); ?>
<section class="container-fluid side-collapse-container margin-top10 no_hor_padding_mobile margin_top165_mobile">
	<div class="container">
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding activity_container">
			<h2 class="activity_heading txt-uppercase"><?php echo __d('user','Activity Feeds');?></h2>
		</section>
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin-top10">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<h2 class="activity_heading word_break border_bottom_grey"><?php echo __d('user','Post a Status');?>:</h2>
					<div class="">
						<div class="form-group margin-bottom10">
							<textarea maxlength="250" class="form-control no_border" rows="5" id="status-textarea" placeholder="<?php echo __d('user','upload a image or write something');?>.." onkeyup="ajaxuserautoc(event,this.value, 'status-textarea','comment-autocompleteN','0');"  autocomplete="off"></textarea>
							<div class="comment-autocomplete comment-autocompleteN">
								<ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0"></ul>
							</div>
							<button class="view-all-btn btn primary-color-bg pull-right post_butn_mobile"  onclick ="return poststatus();" id="statussave"><?php echo __d('user','Post');?></button>
							<div class="activity_heading border_top_grey">
								<a href="javascript:void(0);">
									<div class="upload_camera">
										<input type="file" value="Browse..." class="file-input-area1" id="uploadajaxfile" name="image" style="opacity: 0;filter: alpha(opacity = 0);width:16px;height:16px;cursor:pointer;" onchange="uploadajaxfile();" accept="image/*"/>
									</div>
									<div class="statuspost-error trn red-txt" id="statuspost-error" ></div>
								</a>
							</div>
							<div class="statusimage-container nodisply activity_heading" id='statusimg-cont' style="width:100%;">
								<?php
								echo "<img id='show_url'  style='display:none;margin-left: 10px; height: 80px;' src='".SITE_URL."media/avatars/thumb70/usrimg.jpg'>";
								echo "<a href='javascript:void(0);' id='removeimg' class='status-remove' onclick='removestatusimg(\" 1 \")'> ";
								echo "x"; echo "</a>";
								?>
							</div>
							<span class="uploadicon glyphicons camera"></span>
							<div id="imageerr" class="statuspostimg-error trn red-txt" ></div>
							<input id="image_computer" class="celeb_name" type="hidden" value="" name="image">
						</div>
					</div>
					<div class="feeds-ol">
						<?php
						if (count($loguserdetails)>0){
							foreach ($loguserdetails as $log){
								$logId = $log['id'];
								$type = $log['type'];
								$feedImages = json_decode($log['image'],true);
								$notifymsg = $log['notifymessage'];
								$feedMessage = $log['message'];
								$ldate = $log['cdate'];
								$likecount = $log['likecount'];
								$pastTime = txt_time_diff($ldate);
								$logUserid = $log['userid'];
								$shareduserid = $log['shareduserid'];
								$shared = $log['shared'];
								$sharedagain = $log['shareagain'];
								if (empty($feedImages['user']['link']))
									$feedImages['user']['link'] = 'javascript:void(0);';
								$userimages = $feedImages['user']['image'];
								if($userimages=="")
									$userimages = "usrimg.jpg";
								$itemimages = $feedImages['item']['image'];
								if($itemimages=="")
									$itemimages = "usrimg.jpg";
								$statusimages = $feedImages['status']['image'];
								if($statusimages=="")
									$statusimages = "usrimg.jpg";
								$statusmessage = $feedImages['status']['message'];
								echo '<div class="activity_heading margin-top10 feed'.$logId.'">
								<div class="row">';
								if($shared!='0' && $shareduserid!='0' && $type=='status')
								{
									echo '<div class="sharecontainer activity_heading">';
									echo $log['username'];
									$username1_url = $username1[$logId][$log['userid']]['username_url'];
									$username2_url = $username2[$logId][$log['shareduserid']]['username_url'];
									if($sharedagain=="1")
										echo '<a href="'.SITE_URL.'people/'.$username1_url.'">'.$username1[$logId][$log['userid']]['username'].'</a> again shared '.'<a href="'.SITE_URL.'people/'.$username2_url.'">'.$username2[$logId][$log['shareduserid']]['username'].'</a> \'s status';
									else
										echo '<a href="'.SITE_URL.'people/'.$username1_url.'">'.$username1[$logId][$log['userid']]['username'].'</a> shared '.'<a href="'.SITE_URL.'people/'.$username2_url.'">'.$username2[$logId][$log['shareduserid']]['username'].'</a> \'s status';
									echo '</div>';
								}
								if ($type == 'status' && $userid == $logUserid){
									echo '<div class="dropdown pull-right margin-right20 float_right_mobile_rtl">
									<a data-toggle="dropdown" href="#" class="prod-share-icon-cnt">
									<div class="menu_like_status"></div>
									</a>
									<ul class="dropdown-menu dropdown-menu1 regular-font" role="menu" aria-labelledby="Label">
									<li><a href="javascript:void(0);" onclick="deletepost('.$logId.')">';echo __d('user','Delete');echo '</a></li>
									</ul>
									</div>';
								}
								echo '<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 span_1">
								<div class="live_feeds_logo1 image_center_mobile">
								<div class="live_feeds_logo" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$userimages.');background-repeat:no-repeat;"></div>
								</div>
								<p class="time_text margin-top10 margin-bottom10 text-content more word_break"></p>
								</div>
								<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8 margin_left20 margin-right20_mobile margin_left_0_tab span_8 text_center_seller">
								<div class="margin-left20 custom_left_space margin-right20 word_break">';
								$notifymsg = explode('-___-', $notifymsg);
								foreach($notifymsg as $nmsg){
									echo __d('user',$nmsg);
								}
								echo '</div>
								<p class="time_text margin-left20 custom_left_space margin-right20 extra_text_hide">'.$pastTime.'</p>';
								if($type == "mentioned"){
		//echo '<img src="'.SITE_URL.'media/status/original/'.$statusimages.'" class="livefeedimg">';
								}
								echo '</div>
								</div>';
								echo '<p style="display:none;" class="time_text margin-top10 margin-bottom10 text-content dolessmore">content</p>';
								if (isset($feedImages['item']) || isset($feedImages['status'])){
									if(isset($feedImages['status'])){
		//if($statusmessage)
	//{
										$pattern = '/<a[^<>]*?[^<>]*?>(.*?)<\/a>/';
										$atuserPattern = '/<span[^<>]*?[^<>]*?>(.@?)<\/span>/';
										$hashPattern = '/<span[^<>]*?[^<>]*?>(.*#)<\/span>/';
										$withoutAnchortag = preg_replace($pattern, '$1', $statusmessage);
										$withoutAtuserspan = preg_replace($atuserPattern, '$1', $withoutAnchortag);
										$withoutHashspan = preg_replace($hashPattern, '$1', $withoutAtuserspan);
										echo "<div class='status'>".$withoutHashspan."</div>";
		//echo '<div class="status">'.$statusmessage.'
	//}
										if($statusimages!="" && $statusimages != "usrimg.jpg" ){
											$livefeedsimage=SITE_URL.'media/status/original/'.$statusimages;	
											?>
											<div class="status_img1">
												<div class="like_status_img" data-toggle="modal" data-dismiss="modal" data-target="#feeds_image<?php echo $logId;?>" style="background-image:url('<?php echo $livefeedsimage;?>');">
												</div>
											</div>
											<!--Feeds Modal Starts-->
											<div id="feeds_image<?php echo $logId;?>" class="modal fade" role="dialog" tabindex="1">
												<div class="modal-dialog downloadapp-modal text-center width_auto">
													<!-- Modal content-->
													<div class="modal-content dis_inline_block">
														<div class="modal-body padding0">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<img src="<?php echo $livefeedsimage;?>" class="img-responsive feed_image" style="width: 300px;">
														</div>
													</div>
												</div>
											</div>
											<!--Feeds Modal Ends-->
											<?php
										}
									}
									elseif (isset($feedImages['item'])){
										$livefeedsitemimage=SITE_URL.'media/items/original/'.$itemimages;	
										?>
										<div class="status_img1">
											<div class="like_status_img" data-toggle="modal" data-dismiss="modal" data-target="#feeds_image<?php echo $logId;?>" style="background-image:url('<?php echo $livefeedsitemimage;?>');"></div>
										</div>
										<!--Feeds Modal Starts-->
										<div id="feeds_image<?php echo $logId;?>" class="modal fade" role="dialog" tabindex="1">
											<div class="modal-dialog downloadapp-modal text-center width_auto">
												<!-- Modal content-->
												<div class="modal-content dis_inline_block">
													<div class="modal-body padding0" style="width: 400px;
													height: 500px;background:rgba(0, 0, 0, 0) url('<?php echo $livefeedsitemimage;?>') no-repeat scroll center center;    background-size: auto 100% !important;">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<!--  <img src="<?php echo $livefeedsitemimage;?>" class="img-responsive feed_image" style="height: 300px;"> -->
												</div>
											</div>
										</div>
									</div>
									<!--Feeds Modal Ends-->
									<?php
								}
							}
							if(!empty($feedMessage) || $type=='checkin' || $type=='status' )
							{
								echo '<p class="time_text margin-top10 margin-bottom10 text-content more word_break">'.$feedMessage.'</p>';
								if ($type == 'status' || $type=='share' || $type=='checkin'){
									$pattern = '/<a[^<>]*?[^<>]*?>(.*?)<\/a>/';
									$atuserPattern = '/<span[^<>]*?[^<>]*?>(.@?)<\/span>/';
									$hashPattern = '/<span[^<>]*?[^<>]*?>(.*#)<\/span>/';
									$withoutAnchortag = preg_replace($pattern, '$1', $feedMessage);
									$withoutAtuserspan = preg_replace($atuserPattern, '$1', $withoutAnchortag);
									$withoutHashspan = preg_replace($hashPattern, '$1', $withoutAtuserspan);
									echo "<div class='status".$logId." deletestatus'>".$withoutHashspan."</div>";
									echo '<div class="activity_heading margin-top10 feed35">
									<div class="like-counter-cnt regular-font font_size13 dis_comment">';
									if(in_array($logId,$logids))
									{
										echo '<a href="javascript:void(0);" onclick="likestatus('.$logId.')" class="like-cnt primary-color-txt">
										<i class="fa fa-heart like-icon'.$logId.' margin-top0"></i>
										<span class="like-txt" id="like'.$logId.'">Unlike</span>
										</a>';
									}
									else
									{
										echo '<a href="javascript:void(0);" onclick="likestatus('.$logId.')" class="like-cnt primary-color-txt">
										<i class="fa fa-heart-o like-icon'.$logId.' margin-top0"></i>
										<span class="like-txt" id="like'.$logId.'">Like</span>
										</a>';
									}
									if($likecount=="")
										$likecount = 0;
									echo '<a href="javascript:void(0);" onclick="list_liked_users('.$logId.')" class="like-counter arrow_box" id="likecnt'.$logId.'">'.$likecount.'</a>
									</div>
									<a href="javascript:void(0);" onclick="showcomments('.$logId.')" class="add-to-list-cnt regular-font font_size13 dis_comment margin_left15_tab vertical_align_sub margin_19_comment" data-toggle="modal" data-target="#write-comment">
									<div class="comment_icon"></div>
									<div class="add-to-list-txt vertical_coment_txt">'; echo __d('user','Write a Comment'); echo'</div>
									</a>
									<a href="javascript:void(0);" class="prod-share-icon-cnt dis_comment regular-font font_size13 margin_left15_tab margin_19_comment">
									<div class="prod-share-icon"></div>
									<div class="add-to-list-txt vertical_coment_txt" onclick="share_feed('.$logId.')">';echo __d('user','Share'); echo'</div>
									</a>
									</div>';
									echo '<input type="hidden" value="'.$userid.'" id="loguser_id" />';
									echo '<input type="hidden" value="'.$loguser['username'].'" id="usernames">';
									echo '<input type="hidden" value="'.$loguser['id'].'" id="userid">';
									echo '<input type="hidden" value="'.$loguser['profile_image'].'" id="userimges">';
									echo '<div class="margin-top20 margin-bottom20 activity_heading commentarea'.$logId.'">';
									echo '<h4 class="comments_topic_margin text_center_seller word_break">';echo __d('user','Comments'); echo ':</h4>';
									echo  '<ol id="ulcomments'.$logId.'">';
									foreach($feedcomments as $fcomment)
									{
										echo '<div id="sa'.$logId.'"></div>';
										for($i=0;$i<count($fcomment[$logId]['comments']);$i++)
										{
											$commentusername = $fcomment[$logId]['username'][$i];
											$commentusernameurl = $fcomment[$logId]['username_url'][$i];
											$comments = $fcomment[$logId]['comments'][$i];
											$commentid = $fcomment[$logId]['id'][$i];
											$commentuserid = $fcomment[$logId]['userid'][$i];
											$profileimage = $fcomment[$logId]['profile_image'][$i];
											if($profileimage == "")
												$profileimage = "usrimg.jpg";
											$pattern = '/<a[^<>]*?[^<>]*?>(.*?)<\/a>/';
											$atuserPattern = '/<span[^<>]*?[^<>]*?>(.@?)<\/span>/';
											$hashPattern = '/<span[^<>]*?[^<>]*?>(.*#)<\/span>/';
											echo '<div class="comment-row row hor-padding status-cmnt comment delecmt_'.$commentid.' commentli" commid="'.$commentid.'">
											<div class="live_feeds_logo1 padding_right0_rtl col-xs-3 col-lg-2 padding-right0 padding-left0 image_center_mobile">
											<div class="live_feeds_logo" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$profileimage.');background-repeat:no-repeat;"></div>
											</div>
											<div class="comment-section col-xs-9 col-lg-10 padding-right0 border_bottom_grey padding-bottom10">
											<div class="bold-font comment-name">'.$commentusername.'</div>
											<div class="margin-top10 comment-txt regular-font font_size13">
											'.$comments.'
											</div>
											<div id="oritextvalafedit'.$commentid.'"></div>
											<div class="comment-autocompleteN'.$commentid.'" style="display: none;left:43px;width:548px;">
											<ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0">
											</ul>
											</div>';
											if($commentuserid==$userid){
												echo '<div class="comment-edit-cnt c-reply col-lg-12 no-hor-padding margin-top10">
												<a class="comment-delete red-txt" href="javascript:void(0);" onclick = "return deletefeedcmnt('.$commentid.','.$logId.')">';echo __d('user','Delete');echo '</a>
												</div>';
											}
											echo '</div>
											</div>';
										}
									}
									echo '</div>';
									if($feedcommentcount[$logId]>2)
									{
										echo '<div id="morefeed'.$logId.'" onclick="loadmorefeedcomments('.$logId.')" class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 regular-font font_size13 margin_bottom_mobile20 nodisply commentarea'.$logId.'"><a href="javascript:void(0);">'; echo __d('user','Load more comments'); echo '</a>
										</div>';
									}
								}
							}
							else{
								echo "<div style='padding:0 0 3px'></div>";
							}
							echo '</div>';
						}
						/*echo '<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top20 margin_bottom20_991"><a href="">+Load more Result</a></div>';*/
					}
					else
					{
						echo '<div class="livefeed-empty">
						<div style="position: relative; top: 18px;">
						Follow Popular persons to get feeds</div></div>';
					}
					?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 padding_recent_activities">
				<div class="margin-bottom10">
					<div class="activity_heading border_bottom_grey">
						<?php echo __d('user','Recent Activities'); ?>
					</div>
					<div class="activity_heading border_bottom_grey">
						<?php
						if (!empty($recentactivity)){
							foreach ($recentactivity as $recent){
								$type = $recent['type'];
								$activityUser = $recent['userid'];
								$image = json_decode($recent['image'],true);
								$ldate = $recent['cdate'];
								$itemimages = $image['item']['image'];
								if($itemimages=="")
									$itemimages = "usrimg.jpg";
								$activityTime = aty_time_diff($ldate);
								switch($type){
									case 'follow':
									$message = 'Followed '.$userDetails[$activityUser]['first_name'];
									break;
									case 'comment':
									$message = 'Commented on item';
									$imagelink = "<a href='".$image['item']['link']."'>
									<img src='".SITE_URL."media/items/thumb70/".$itemimages."' />
									</a>";
									break;
									case 'favorite':
									$message = $fantacy.' an item';
									if($itemimages != 0)
										$imagelink = "<a href='".$image['item']['link']."'>
									<img src='".SITE_URL."media/items/thumb70/".$itemimages."' />
									</a>";
									break;
									case 'sellermessage':
									$message = "Posted a seller message";
									break;
									case 'status':
									$message = "Posted a status";
									break;
									case 'orderstatus':
									$message = "Updated a order status";
									break;
								}
								echo '<p class="regular-font margin-bottom0 word_break">'.__d('user',$message).'</p>
								<p class="time_text">'.$activityTime.'</p>';
							}
						}
						else
						{
							echo "<span class='no-recentactivity'>No Recent Activity</span>";
						}
						?>
					</div>
				</div>
				<div class="margin-bottom20">
					<div class="activity_heading border_bottom_grey">
						<?php echo __d('user','Who to follow');?>
					</div>
					<div class="activity_heading border_bottom_grey hashtagwhofollow-content">
						<?php
						if(count($people_details)>0){
							foreach($people_details as $key=>$people)
							{
								if($people['profile_image']=="")
									$prof_img = "usrimg.jpg";
								else
									$prof_img = $people['profile_image'];
								echo '<div class="row margin-top15 whouser'.$people['id'].' list'.$key.'">
								<div class="col-xs-12 col-sm-1 col-md-2 col-lg-2">
								<a href="'.SITE_URL.'people/'.$people['username_url'].'">
								<div class="follow_logo1">
								<div class="live_feeds_logo" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$prof_img.');background-repeat:no-repeat;"></div>
								</div>
								</a>
								</div>
								<div class="col-xs-9 col-sm-8 col-md-8 col-lg-8">
								<a href="'.SITE_URL.'people/'.$people['username_url'].'">
								<div class="regular-font" style="word-break: break-all;">
								<span>'.$people['first_name'].$people['last_name'].'</span>
								</div>
								</a><a href="'.SITE_URL.'people/'.$people['username'].'">
								<p class="time_text extra_text_hide">@'.$people['username_url'].'</p>
								</a>
								</div>
								<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="btn to_add_friend pull-right padding_follow_btn "><a href="javascript:void(0);" onclick="hashtagfollow('.$people['id'].','.$key.')" class=""><div class="add_friend padding_follow_btn"></div></a></div></div>
								</div>';
								if ($followlistId == ''){
									$followlistId = $people["id"];
								}else{
									$followlistId .= ",".$people["id"];
								}
							}
						}
						else
						{
							echo '<div class="whotofollowerror">No more suggestions</div>';
						}
						if(empty($userid) || !isset($userid) || $userid == 0){
							echo "<input type='hidden' id='gstid' value='0' />";
						}else{
							echo "<input type='hidden' id='gstid' value='".$userid."' />";
						} ?>
						<input type="hidden" id="followuserlist" value="<?php echo $followlistId; ?>" />
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
</section>
<script type="text/javascript">
	$.ajaxSetup({cache: false});
	$(document).load(function(){
		$("#statusimg-cont").addClass("nodisply");
	});
/*$(document).ready(function(){
alert('dcdsv');
$("#status-textarea").keyup(function(){
textval = $("#status-textarea").val();
imagename = $("#image_computer").val();
/*if($.trim(textval)=="")
{
$("#statussave").attr("disabled",true);
}
if(imagename!="")
		{
			$("#statussave").attr("disabled",false);
		}
else if($.trim(textval)!="" || imagename!="")
{
$("#statussave").attr("disabled",false);
}
});
$(".livefeedcnt").hide();
$(document).keydown(function(e){
if(e.keyCode==27)
e.preventDefault();
});
});*/
var sIndex = 15, limit = 15, isPreviousEventComplete = true, isDataAvailable = true;
var baseurl = getBaseURL();
$("#feedcnt").removeClass("counter-label");
$("#feedcnt").html("");
loadmorecnt = 2;
function loadmorefeedcomments(logid)
{
	baseurl = getBaseURL();
	$.ajax({
		type: "POST",
		url: baseurl+'loadmorefeedcomments',
		data:  {"logid":logid,'offset':loadmorecnt},
		dataType: 'html',
		success: function(datas) {
			if($.trim(datas))
			{
				$("#ulcomments"+logid).append(datas);
				$("#morefeed"+logid).show();
				loadmorecnt+=2;
			}
			else
			{
				$("#morefeed"+logid).css('cursor','default');
				$("#morefeed"+logid).html('No more comments');
			}
		},
	});
}
$(window).scroll(function () {
	 //if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
	 	if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.5) {
	 		if (isPreviousEventComplete && isDataAvailable) {
	 			isPreviousEventComplete = false;
	 			$(".LoaderImage").css("display", "block");
	 			$.ajax({
	 				url: baseurl+'getmorefeeds/livefeeds?startIndex=' + sIndex,
	 				type: "GET",
	 				dataType: 'html',
	 				beforeSend: function () {
	 					$('#infscr-loading').show();
	 				},
	 				success: function (result) {
	 					$('#infscr-loading').hide();
	 					var out = result.toString().trim();
		/*if($.trim(out)=='')
	      		//$(window).unbind('scroll');
  		else */if($.trim(out) != '') {//When data is not available
  			$('.feeds-ol').append(result);
  		}else {
  			isDataAvailable = false;
  		}
  		sIndex = sIndex + limit;
  		isPreviousEventComplete = true;
  	}
  });
	 		}
	 	}
	 });
	</script>
	<div class="modal fade" id="cancel-order" role="dialog" tabindex="-1">
		<div class=" modal-dialog">
			<div class="modal-content">
				<div class=" login-body modal-body clearfix">
					<button class="close no" type="button">×</button>
					<div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
						<h2 class="popupheder login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding reporttxt">Are you sure to delete the post ?</h2>
					</div>
					<div class=" share-cnt-row col-md-12 padding-bottom10">
						<a class="margin-bottom10  btn txt-uppercase primary-color-bg bold-font yes" href="javascript:void(0);">Yes</a>
						<a class="cancelpop margin-bottom10 btn txt-uppercase primary-color-border-btn bold-font margin-left10 no" href="javascript:void(0);">No</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Write Comment Modal-->
	<div id="write-comment-modal" class="modal fade" role="dialog">
		<div class="modal-dialog downloadapp-modal">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="write-comment-container">
						<h2 class="bold-font margin-bottom10"><?php echo __d('user','WRITE A COMMENT'); ?><span class="primary-color-txt"></span></h2>
						<div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
							<textarea class="form-control" rows="5" id="comment_msg" maxlength="180" onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"  autocomplete="off" placeholder="<?php echo __d('user','Comment');?> , @<?php echo __d('user','mention');?>, #<?php echo __d('user','hashtag');?>"></textarea>
							<div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
								<ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0" role="menu"></ul>
							</div>
							<div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
								<button href="javascript:void(0);" id="commentssave" onclick ="return feedcomment();" class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10"><?php echo __d('user','SUBMIT'); ?></button>
							</div>
							<input type="hidden" id="feedcommentid">
							<div id="cmnterr" style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px">Please enter comment</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Write comment modal -->