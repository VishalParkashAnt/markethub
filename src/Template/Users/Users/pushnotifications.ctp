<?php echo $this->element('numberconversion'); ?>
<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
if($result == "livefeeds") {
	$result = "livefeeds";
} else {
	$result = "notification";

}
?>
<section class="container-fluid side-collapse-container margin-top10 no_hor_padding_mobile">
	<div class="container no_hor_padding_mobile">
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
				<div class="breadcrumb">
				  <a href="<?php echo $baseurl;?>"><?php echo __d('user','Home');?></a>
				  <span class="breadcrumb-divider1">/</span>
				  <a href="<?php echo $baseurl.'push_notifications/';?>"><?php echo __d('user','Notifications');?></a>

				</div>
			</div>
		</section>
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="find_new">
				<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<h2 class="find_new_heading extra_text_hide margin-top10"><?php echo __d('user','Notifications');?></h2>

				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="btn to_add_friend pull-right invite_btn_padding invite_btn_mobile"><a href="<?php echo $baseurl.'notifications/';?>" class="">
					<div class="settings"></div>
					<span class="vertical_align_top text_grey_dark margin-left5"><?php echo __d('user','Settings');?></span></a></div>
				</div>
				</div>
				</div>
		</section>
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding margin-top10">
			<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 feeds-ol">
			<?php
			if (!empty($loguserdetails)){
				foreach ($loguserdetails as $log){
					$logId = $log->id;
					$type = $log->type;
					$feedImages = json_decode($log->image,true);
					$notifymsg = $log->notifymessage;
					$feedMessage = $log->message;
					$ldate = $log->cdate;
					//$pastTime = UrlfriendlyComponent::txt_time_diff($ldate);
					$pastTime = txt_time_diff($ldate);
					$logUserid = $log->userid;
					if (empty($feedImages['link']))
					$feedImages['link'] = 'javascript:void(0);';
					//echo "<pre>";
					//print_r($feedImages);
				?>
				<div class="activity_heading">
					<div class="row">
						<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 span_1">
							<div class="live_feeds_logo1 image_center_mobile">
								<a href="<?php echo $feedImages['user']['link']; ?>" >
								<?php
								$feedimage = $feedImages['user']['image'];
								if($feedimage=="")
								$feedimage = "usrimg.jpg";
								?>
								<img class="live_feeds_logo" src="<?php echo  SITE_URL.'media/avatars/thumb150/'.$feedimage;?>">
								</a>
							</div>
						</div>
						<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8 margin_left20 margin-right20_mobile margin_left_0_tab span_8 text_center_seller">
						<?php $notifymsg = explode('-___-', $notifymsg); ?>
							<div class="margin-left20 margin-right20 word_break">
							<span class="dis_inline_block"> <?php echo __d('user',$notifymsg[0]);?> </span>
							<span class="font_size13 regular-font dis_inline_block">
							<?php echo __d('user',$notifymsg[1]);?>
							</span><span class="font_size13 regular-font"> <?php echo __d('user',$notifymsg[2]);?> </span></div>
							<p class="time_text margin-left20 margin-right20 extra_text_hide"><?php echo $pastTime; ?></p>

						</div>
					</div>
					<div class="margin-top10">
						<?php if (isset($feedImages['item']) || isset($feedImages['status'])){ ?>
						<div class='feed-content'>
							<?php if (isset($feedImages['item'])){ ?>
								<a href='<?php echo $feedImages['item']['link']; ?>' >
									<div class="like_status_img" style="background: url(<?php echo  SITE_URL.'media/items/original/'.$feedImages['item']['image'];?>)"></div>
								</a>
							<?php }elseif(isset($feedImages['status'])){ ?>
								<div class="like_status_img" style="background: url(<?php echo  SITE_URL.'media/items/original/'.$feedImages['status']['image'];?>)"></div>
							<?php } ?>
						</div>
						<?php } if(!empty($feedMessage)) { ?>
							<h4 class="bold-font margin-top20"><?php echo __d('user','Message'); ?>: </h4>
							<p class="time_text margin-top10 text-content dolessmore margin-bottom10 dolessmoreblock dlmcontract">
								<?php echo $feedMessage; ?>
								<div class="lm-control"><a href="javascript:void(0)" class="view-details"></a></div>
							</p>
						<?php } ?>
					</div>
				</div>
				<div> &nbsp;</div>

			<?php }}
			else{
				echo '<div class="activity_heading">
					<div class="row">Follow Popular persons to get feeds</div></div>';
			}
			?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 padding_recent_activities">
				<div class="margin-bottom20">
				<div class="activity_heading border_bottom_grey"><?php echo __d('user','Who to follow');?>
				</div>
				<div class="activity_heading border_bottom_grey hashtagwhofollow-content">
				<!--NOTIFICATIONS WHO TO FOLLOW-->
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
				<img class="live_feeds_logo" src="'.SITE_URL.'media/avatars/thumb70/'.$prof_img.'">
				</div>
				</a>
				</div>

				<div class="col-xs-12 col-sm-11 col-md-10 col-lg-10">
				<a href="'.SITE_URL.'people/'.$people['username_url'].'">
				<div class="regular-font inlined-display word_break gradient_bg1">
				<span class="followname_cap">'.strtolower($people['first_name']).' '.strtolower($people['last_name']).'</span>
				</div>
				</a>
				<div class="btn to_add_friend pull-right padding_follow_btn"><a href="javascript:void(0);" onclick="hashtagfollow('.$people['id'].','.$key.')" class=""><div class="add_friend padding_follow_btn"></div></a></div>
				<a href="'.SITE_URL.'people/'.$people['username'].'">
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
<script>
	var	url_status=true;
	var item_save = true;
	var pushnoii = true;
	var cartnoii = true;
	<?php if ($params['action'] != 'index'){ ?>
	var imgLoad = imagesLoaded('.fantacygrid');
	imgLoad.on( 'progress', function( instance, image ) {
		  var result = image.isLoaded ? 'loaded' : 'broken';
		  if (result == 'broken')
			  image.img.src = '<?php echo $_SESSION['media_url']; ?>media/avatars/original/usrimg.jpg';
		  console.log( 'image is ' + result + ' for ' + image.img.src );
		});
	<?php } ?>
</script>
<script type="text/javascript">
var sIndex = 15, limit = 15, isPreviousEventComplete = true, isDataAvailable = true;
var baseurl = getBaseURL();
var result= $("#result").val(); 
$(window).scroll(function () {
	 //if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
	if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.5) {	 
	  if (isPreviousEventComplete && isDataAvailable) {

	    isPreviousEventComplete = false;
	    $(".LoaderImage").css("display", "block");

	    $.ajax({
	        url: baseurl+'getmorefeeds/<?php echo $result; ?>?startIndex=' + sIndex,
	      type: "GET",
		  dataType: 'html',
	      beforeSend: function () {
				$('#infscr-loading').show();
			},
	      success: function (result) {
	      	$('#infscr-loading').hide();
	      	var out = result.toString();
	      	console.log(out);
	      	if($.trim(out)=='')
	      	$(window).unbind('scroll');	      	
	      	else if (out != '') {
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
<style type="text/css">
	img.live_feeds_logo { 
		border-radius: 2px !important;
	}
	/*.activity_heading > div > h6.bold-font {
		color: rgb(25,153,235);
		letter-spacing: 0.07em;
	}*/
	.followname_cap {
		text-transform: capitalize;
		color: #333333;
	}
</style>



