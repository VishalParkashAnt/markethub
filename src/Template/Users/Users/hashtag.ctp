<section class="container-fluid side-collapse-container margin-top10 no_hor_padding_mobile margin_top165_mobile">
	<div class="container">


		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<h2 class="activity_heading txt-uppercase"><span class="dis_inline_block"><?php echo __d('user','Result');?></span> <span class="primary-color-txt">#<?php echo $tagName; ?></span></h2>
		</section>
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin-top10">
			<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
<?php
if(count($commentModel)>0)
{
				foreach($commentModel as $comment){
					$itemId = $comment['item']['id'];
					$itemname = $comment['item']['item_title'];
					$itemurl = $comment['item']['item_title_url'];
					$userComment = $comment['comments'];
					$username = $comment['user']['first_name'];
					$atusername = $comment['user']['username'];
					$usernameUrl = $comment['user']['username_url'];
					$profileImage = $comment['user']['profile_image'];
					$url = base64_encode($itemId . "_" . rand(1, 9999));

					if ($profileImage == "")
						$profileImage = "usrimg.jpg";
?>
					<div class="activity_heading">
						<div class="row">
							<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 span_1">
								<div class="live_feeds_logo1 image_center_mobile">
								<img alt="<?php echo $username; ?>" src="<?php echo $_SESSION['media_url'].
									'media/avatars/thumb70/'.$profileImage; ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8 margin_left20 margin-right20_mobile margin_left_0_tab span_8 text_center_seller">
								<div class="margin-left20 margin-right20 word_break">
									<a href="<?php echo SITE_URL."people/".$usernameUrl; ?>"
										title="<?php echo $username; ?>">
										<?php echo $username; ?>
										<span class='anchoratuser'><?php echo "@".$usernameUrl; ?></span>
									</a>
								</div>
								<p class="time_text margin-left20 margin-right20 extra_text_hide">
									<?php echo $userComment; ?>
								</p>
								<p class="time_text margin-left20 margin-right20 extra_text_hide">
								<?php echo __d('user','Commented On');?>:
									<?php if (!empty($itemname)){ ?>
									<a href="<?php echo SITE_URL."listing/".$url; ?>"
										title="<?php echo $itemname; ?>">
										<?php echo $itemname; ?>
									</a>
									<?php }else{
										echo __d('user',"Status");
									}?>
								</p>

							</div>


						</div>


					</div>
<?php } ?>



	<?php }
	else
	{
		echo '<div class="activity_heading"><div class="centered-text">'.__d('user','No comments found').'</div></div>';
	}
	?>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 padding_recent_activities">
				<div class="margin-bottom10">
				<div class="activity_heading border_bottom_grey">
				<?php echo __d('user','Popular Hashtags');?>
				</div>

				<div class="activity_heading border_bottom_grey primary-color-txt">
					<?php
					foreach ($trendingHashtags as $trendingNow){
						echo '<h5 class="margin-bottom15">
						<a href="'.SITE_URL.'hashtag/'.$trendingNow['hashtag'].'" class="regular-font margin-bottom0 word_break">#'.$trendingNow['hashtag'].'</a>
						</h5>';
					}
					?>
				</div>

				</div>

				<div class="margin-bottom20">
				<div class="activity_heading border_bottom_grey">
				<?php echo __d('user','Who to follow');?>
				</div>

				<div class="activity_heading border_bottom_grey hashtagwhofollow-content hashtagcomment-list">
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
				<div class="live_feeds_logo" style="background:url('.SITE_URL.'media/avatars/thumb70/'.$prof_img.')"></div>
			</div>
		</a>
		</div>

		<div class="col-xs-12 col-sm-11 col-md-10 col-lg-10">
		<a href="'.SITE_URL.'people/'.$people['username_url'].'">
			<div class="regular-font inlined-display word_break gradient_bg1">
				<span>'.$people['first_name'].$people['last_name'].'</span>
			</div>
		</a>
		<div class="btn to_add_friend pull-right padding_follow_btn"><a href="javascript:void(0);" onclick="hashtagfollow('.$people['id'].','.$key.')" class=""><div class="add_friend padding_follow_btn"></div></a></div>
		<a href="'.SITE_URL.'people/'.$people['username_url'].'">
			<p class="time_text extra_text_hide">@'.$people['username_url'].'</p>
		</a>
		</div>
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
	echo '<div class="whotofollowerror">'.__d('user','No more suggestions').'</div>';
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
var sIndex = 10, limit = 10, isPreviousEventComplete = true, isDataAvailable = true;
var baseurl = getBaseURL();
$(window).scroll(function () {
	 //if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
	if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.5) {
	  if (isPreviousEventComplete && isDataAvailable) {

	    isPreviousEventComplete = false;
	    $(".LoaderImage").css("display", "block");

	    $.ajax({
	      url: baseurl+'getmorehashtag/<?php echo $tagName; ?>?startIndex=' + sIndex,
	      type: "GET",
		  dataType: 'html',
	      beforeSend: function () {
				$('#infscr-loading').show();
			},
	      success: function (result) {
	      	$('#infscr-loading').hide();
	      	var out = result.toString();
	      	if($.trim(out)=='')
	      		isDataAvailable = false;
	      	else if (out != 'false') {//When data is not available
	        	$('.hashtagcomment-list').append(result);
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