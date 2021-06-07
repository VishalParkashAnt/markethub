<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<style type="text/css">
.errcls
{
	color:red;
	display: none;
}

</style>
<div class="container-fluid margin-top10 no_hor_padding_mobile">
  <div class="container">
	<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
		<div class="breadcrumb margin-bottom0">
	      <a href="<?php echo $baseurl; ?>"><?php echo __d('user','Home'); ?></a>
	      <span class="breadcrumb-divider1">/</span>
	      <a href="<?php echo $baseurl.'search/people/'; ?>"><?php echo __d('user','Find People'); ?></a>
	     
	     </div>
    </div>

  </div>
    </div>

	<section class="container-fluid side-collapse-container no_hor_padding_mobile">
		<div class="container">
		<?php
			$usid = $userid;
		//echo $banner_datas->status;
		if($banner_datas->status=='Active')
					{
						echo '<div id="bannerimg">';
						echo $banner_datas->html_source;
						echo '</div>';
					}?>
			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">
				<div class="find_new">
				<div class="row">
				<div class="col-xs-12 col-sm-5 col-md-7 col-lg-7">
					<h2 class="find_new_heading extra_text_hide"><?php echo __d('user','Find New People');?></h2>
					<p class="extra_text_hide margin-bottom0"><?php echo __d('user','Follow People to discover new things');?></p>
				</div>
				<?php echo $this->Form->create('Findpeople', ['url' => ['controller' => 'Users', 'action' => 'peoplesearch'],'onsubmit'=>'return searchvalchk();']);
				?>
				<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
					<span class="find_new_search invite_btn_mobile">
					<input type="text" id="sval" name="search_people" class="form-control shop_search" placeholder="<?php echo __d('user','Search');?>" autocomplete="off"></span>
				<?php
				echo '<p id="sererr" class="errcls">'.__d('user','Please enter value to search').'</p>';
				?>

				</div>

				</form>
				<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
					<div class="btn to_add_friend pull-right invite_btn_padding invite_btn_mobile"><a
					href="<?php echo $baseurl.'invite_friends/'; ?>" class=""><div class="invite_friends"></div>
					<span class="vertical_text_bottom text_grey_dark"><?php echo __d('user','Invite Friends');?></span></a></div>
				</div>
				</div>
				</div>
			</section>

			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top20 no-hor-padding">
			<div>

			<div class="row box1" id="peoplesearch">

			<?php
			if(count($people_details)>0)
			{
			foreach($people_details as $key => $people)
			{
				if($key<10)
{
				$people_id=$people->id;
				//User Image
				$imgname = $_SESSION['media_url']."media/avatars/thumb70/".$people->profile_image;
				$imgsze = getimagesize($imgname);
				if(!empty($people->profile_image) && !empty($imgsze)){
					$imageUrl = $_SESSION['media_url']."media/avatars/thumb70/".$people->profile_image;
				}else{
					$imageUrl = $_SESSION['media_url']."media/avatars/thumb70/usrimg.jpg";
				}
			?>

			<div class="product_cnt col-lg-3 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
				<div class="find_people_image1">
					<div class="find_people_image" style="background-image:url('<?php echo $imageUrl;?>');background-repeat: no-repeat; border-radius: 5%;"></div>
				</div>
				<div class="find_people_followers">
				<div class="gradient_bg">
					<h4 class="margin-bottom0 extra_text_hide"><a href="<?php echo $baseurl.'people/'.$people->username;?>" style="color: #444444; text-transform: capitalize; "><?php echo strtolower($people->first_name.$people->last_name); ?></a></h4>
				</div><p class="profile_text margin-bottom20 extra_text_hide hor-padding">@<?php echo $people->username;?></p>
					<div class="btn user_followers_butn" id="follow_<?php echo $people_id;?>" onclick="getpeoplefollows('<?php echo $people_id;?>');">
						<a><?php echo __d('user','Follow');?></a>
					</div>
				</div>
			</div>

			<?php }}?>
			</div>
			<?php
if(count($people_details)>9)
{

							echo '<div class="loadmorecomment centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20 trn" onclick="loadmorepeople()">
								<a href="javascript:void(0);">+ '.__d('user','Load More').'</a>
							</div>';
}
?>
			<div class="text-center padding-bottom20 padding-top20">
			<div class="padding-bottom10">
			<?php } else {?>
			<div class="text-center padding-top30 padding-bottom30">
				<div class="outer_no_div">
				<div class="empty-icon no_follow_icon"></div>
				</div>
				<h5><?php echo __d('user','No People');?></h5>
			</div>

			<?php } ?>
			<?php 
			if($issearch=='1'){
				$style="";
			}
			else{
				$style="display:none";
			}
			?>

			 
				<div class="btn primary-color-bg view-all-btn-cnt" style="<?php echo $style;?>">
							<a style="text-transform: uppercase;" href="<?php echo $baseurl.'search/people/'; ?>" ><?php echo __d('user','VIEW ALL');?><span class="view_all_arrow"></span></a>
				</div>
			</div>

			</div>

			</section>
		</div>
	</section>




	<script type="text/javascript">
var crntcommentcnt = '<?php echo count($people_details); ?>';
//var order_id = '<?php// echo $usid; ?>';
//alert (order_id);
var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 10;
var baseurl = getBaseURL();


	function loadmorepeople1(){
		alert('fvf'); return false;
		
		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'getmorepeoplesearch',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt,'userid':upid},
				beforeSend: function(){
					
					$('.morecommentloader img').show();
				},
				success: function(responce){
					alert('fd'); return false;
					$('.morecommentloader img').hide();
					if (responce){

						var output = eval(responce);
				        $('.row box1').append(output[1]);
				        loadmoreajax = 1;
						loadmorecmntcnt += 10;
					}else{
						loadmore = 0;
				        loadmoreajax = 1;
				        $('.loadmorecomment').html('No More Users');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
				         $('.loadmorecomment').css('cursor','default');
					}
				}
				error: function () {
					alert('err'); return false;
					// body...
				}
			});
		}
	}



</script>
<script type="text/javascript">
var crntcommentcnt = '<?php echo count($people_details); ?>';
//var order_id = '<?php// echo $usid; ?>';
//alert (order_id);
var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 10;
var baseurl = getBaseURL();
	

	  function loadmorepeople()
	{

		//var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 10;
		var baseurl = getBaseURL();
		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'getmorepeoplesearch',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt},
				beforeSend: function(){
					
					$('.morecommentloader img').show();
				},
				success: function(responce){
				//	alert(responce); return false;
					$('.morecommentloader img').hide();
					if (responce){

						//var output = eval(responce);
				        $('#peoplesearch').append(responce);
				        loadmoreajax = 1;
						loadmorecmntcnt += 10;
					}else{
						loadmore = 0;
				        loadmoreajax = 1;
				        $('.loadmorecomment').html('No More Users');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
				         $('.loadmorecomment').css('cursor','default');
					}
				}
			
			});
		}
			
	}




</script>