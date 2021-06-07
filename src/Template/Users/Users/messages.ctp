<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>

<!-- breadcrumb start -->
<div class="container-fluid margin-top10 no_hor_padding_mobile">
  <div class="container">
<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
     <div class="breadcrumb">
      <a href="<?php echo $baseurl;?>"><?php echo __d('user','Home');?></a>
      <span class="breadcrumb-divider1">/</span>
      <a href="#"><?php echo __d('user','Messages');?></a>
     
     </div>
    </div>
     
  </div>
    </div>
    <!-- breadcrumb end -->

	<div class="container margin_top165_mobile">
		<div id="sidebar" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 no-hor-padding sidebar is-affixed" style="">
			<div class="sidebar__inner border_right_grey" style="position: relative; ">
				<div class="mini-submenu profile-menu">
			        <!--<span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>-->
			    </div>
			    <!--SETTINGS SIDEBAR PAGE-->
				<?php echo $this->element('settingssidebar'); ?>

    			<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

			</div>
		</div>

		<div id="content" class="col-lg-9 col-md-9 col-sm-12 col-xs-12 no-hor-padding clearfix min-height-profile">
			<div class="meassage-wraper cnt-top-header border_bottom_grey col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height col-lg-9 col-md-9 col-sm-9 col-xs-12"><?php echo __d('user','Messages');?> </h2>

								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 border_left_grey mobile_border_bottom margin_bottom_mobile20 no-hor-padding">
									<span class="second_header_search full_width full_height  msg-search"><input type="text" id="searchkey" class="form-control shop_search" onkeyup="searchmsg();" placeholder="<?php echo __d('user','Search');?>">
									</span>
								</div>
								<input type="hidden" id="savesearchkey" value=""/>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">

							<div class="display_none">
								<div class="text-center padding-top30 padding-bottom30">
									<div class="outer_no_div">
										<div class="empty-icon no-messageicon"></div>
									</div>
									<h5><?php echo __d('user','No Conversations');?></h5>
								</div>
							</div>

							<div class="div-cover-box" id="loadmorecomment ">
							<h3 class="section_heading font13 bold-font margin0 extra_text_hide no-hor-padding padding-bottom15"><?php echo __d('user','Contact Seller Conversations');?></h3>

<?php
if (count($messageModel)>0) {
echo '<div id="myorderslist">';
$key = 0;
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
					$key ++;
					if($key % 2 == 0)
							echo '<div class="seller-view-row padding-top10 padding-bottom10 padding-right10 padding-left10 event-color-bg clearfix">';
					else
						echo '<div class="seller-view-row padding-top10 padding-bottom10 padding-right10 padding-left10 add-color-bg clearfix">';
								echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding negotian-by-info">


									<div class="negotaio-image">
										<div class="messag-img">
											<div class="clint-img order-img" style="background-image:url('.SITE_URL.'media/avatars/thumb150/'.$prof_img.');background-repeat:no-repeat;"></div>
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
		echo '</div>';


			if (count($messageModel) > 9) {
							echo '<div class="loadmorecomment centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20 trn" onclick="loadmorecomment()">
								<a href="javascript:void(0);">+ '.__d('user','Load More').'</a>
							</div>';
			}
	}
	else
	{
			echo '<div class="text-center padding-top30 padding-bottom30">
				<div class="outer_no_div">
					<div class="empty-icon no-messageicon"></div>
				</div>
				<h5>'.__d('user','Message box empty').'</h5>
			</div>';
	}
	?>
						</div>
						<div class="message-error trn nodisply centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20"></div>
						</div>
						<input type="hidden" id="savesearchkey" value=""/>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>


	<script type="text/javascript">
	var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 10;
	var baseurl = getBaseURL();

	function loadmorecomment(){
		if (loadmoreajax == 1 && loadmore == 1){
			var searchkey = $('#savesearchkey').val();
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'getmoremessage',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt, 'searchkey': searchkey},
				beforeSend: function(){
				},
				success: function(responce){
					if($.trim(responce)=='false'){
						loadmore = 0;
				        loadmoreajax = 1;
				        $('.loadmorecomment').html('No more messages');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
				        $('.loadmorecomment').css('cursor','default');
					}
					else if (responce != 'false'){
				        $('#myorderslist').append(responce);
				        loadmoreajax = 1;
						loadmorecmntcnt += 10;
					}
				}
			});
		}
	}
</script>