	<section class="container-fluid side-collapse-container no_hor_padding_mobile margin_top165_mobile">
		<div class="container">
			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">
				<div class="find_new">
				<div class="row">
				<div class="col-xs-12 col-sm-5 col-md-7 col-lg-7">
					<h2 class="find_new_heading extra_text_hide">
						<?php echo __d('user','All Stores');?></h2>
				</div>
				<!--div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
					<span class="find_new_search invite_btn_mobile"><input type="text" class="form-control shop_search" placeholder="Search"></span>
				</div-->
				<!--div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
					<div class="btn to_add_friend pull-right invite_btn_padding invite_btn_mobile"><a href="" class=""><div class="invite_friends"></div>
					<span class="vertical_text_bottom text_grey_dark">Invite Friends</span></a></div>
				</div-->
				</div>
				</div>
			</section>

			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top20 no-hor-padding">
			<div>

          	<div class="row box1 allstores">
          	<?php
          	if(count($shopsdet)>0)
          	{
					foreach ($shopsdet as $shopdatas){  //print_r($shopdatas);
							$shop_name = $shopdatas['shop_name'];
							$shop_name_url = $shopdatas['shop_name_url'];
							$shop_img = $shopdatas['shop_image'];
							$shop_bannerimg = SITE_URL.'media/avatars/original/'.$shopdatas['shop_banner'];
							$merchant_name = $shopdatas['merchant_name'];
							$item_count = $shopdatas['item_count'];
							$shop_id = $shopdatas['id'];
							$shop_user_id = $shopdatas['user_id'];
							$follow_count = $shopdatas['follow_count'];
							$follow_shop = $shopdatas['follow_shop'];
							if($shop_name == "")
								$shop_name = $merchant_name;
							if($shop_img == "")
								$shop_img = "usrimg.jpg";
							if($shopdatas['shop_banner'] == "")
								$shop_bannerimg = SITE_URL.'images/banner_1.png';
										echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
											<div class="favourite_store" style="background-image:url('.$shop_bannerimg.');background-repeat:no-repeat;">

											</div>
												<div class="user_favourite_image1 margin_top_40min">
														<div class="user_favourite_image" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$shop_img.');background-repeat:no-repeat;"></div>
													</div>
											<div class="user_favourite">

												<h4 class="margin-bottom0 extra_text_hide">
												<a href="'.SITE_URL.'stores/'.$shop_name_url.'">'.$shop_name.'</a></h4>

												<p class="profile_text margin-bottom20 extra_text_hide">'.__d('user','By').' '.$merchant_name.'</p>';
            foreach($followcnt as $flcnt){
            	$flwrcntid[] = $flcnt['store_id'];
            }
            $userId = $loguser['id'];
          	echo '<input type="hidden" id ="gstid" value='.$userId.'>'; 
			if($shop_id != $loguser['id']){
            	if(in_array($shop_id,$flwrcntid)  && isset($loguser['id']) ){
            		$flw = false;
            	}else{
            		$flw = true;
            	}
            	if($flw)
            	{
				echo '<span id="folls'.$shop_id.'"><div class="user_followers_butn btn">
				<a href="javascript:void(0);" onclick="getshopfollows('.$shop_id.')">'.__d('user','Follow Store').'</a></div></span>';
            	}
            	else
            	{
			echo '<span id="unfolls'.$shop_id.'"><div class="btn user_unfollowers">
			<a href="javascript:void(0);" onclick="deleteshopfollows('.$shop_id.')">'.__d('user','Unfollow Store').'</a></div></span>';
			}
	echo '<span id="changebtnn'.$shop_id.'" ></span>';
	}
											echo '</div>
										</div>';
										}
			}
			else
			{
				echo '<div class="display_none text-center padding-top30 padding-bottom30">
										 <div class="outer_no_div">
										  <div class="empty-icon no_store_icon"></div>
										 </div>
										 <h5>'.__d('user','No Stores').'</h5>
										</div>';
			}
										?>
			</div>

			<div class="loadmorecomment centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 font_size13 margin-top20 margin_bottom_mobile20" onclick="loadmorecomment();"><a href="javascript:void(0);">+Load more Result</a>
			</div>
			</div>

			<div class="text-center display_none padding-bottom20 padding-top20">
			<div class="padding-bottom10">
			<div class="padding-bottom10">
				<div class="no_find_people"></div>
				<h5 class="regular-font">No people found for<span class="padding-left5 primary-color-txt">Eliyas</span></h5>
			</div>
				<div class="btn primary-color-bg view-all-btn-cnt">
							<a href="daily-deals.html">VIEW ALL Peoples<span class="view_all_arrow"></span></a>
				</div>
			</div>

			</section>
		</div>
	</section>

	<script type="text/javascript">
var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 10;
var baseurl = getBaseURL();


	function loadmorecomment(){
		//alert(uid);

		//alert(loadmorecmntcnt);

		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'getmorestores',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt},
				beforeSend: function(){
					//$('.morecommentloader img').show();
				},
				success: function(responce){
					//$('.morecommentloader img').hide();
					if($.trim(responce)=='false'){
						loadmore = 0;
				        loadmoreajax = 1;
				        $('.loadmorecomment').html('No more stores');
				        $('.loadmorecomment').css('cursor','default');
					}
					else if (responce != 'false'){
				        $('.allstores').append(responce);
				        loadmoreajax = 1;
						loadmorecmntcnt += 10;
					}
				}
			});
		}
	}



</script>