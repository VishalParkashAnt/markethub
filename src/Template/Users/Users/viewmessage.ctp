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
			<div class="cnt-top-header border_bottom_grey col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12"> <?php echo __d('user','Message Detail');?> </h2>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin-top10 fint-height margin-bottom10 text-right responsive-text-center">
							<?php
								echo '<a href="'.$baseurl.'messages" class="primary-color-txt"><i class="fa fa-angle-left margin-both5"></i> '.__d('user','Back to messages').' </a>';
							?>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">



								<div class="border_bottom_grey clearfix no-hor-padding padding-bottom15">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding dispu-id">
										<div class="dispu-id-number">
											<div class="inline-block"><?php echo __d('user','Subject');?>: </div>
											<div class="inline-block"><?php echo $contactsellerModel['subject'];?> </div>
										</div>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding text-right responsive-text-center">
										<div class="inline-block"><?php echo __d('user','Item');?>: </div>
										<?php
										$itemid = $itemDetails['itemid'];
										$itemurl = base64_encode($itemid."_".rand(1,9999));
										echo '<a href="'.$baseurl.'listing/'.$itemurl.'">
										<span class="inline-block color-pink">'.$itemDetails['item'].' </span>
										</a>';
										?>
									</div>
								</div>
								<!-- chat area section -->
								
								<!-- chat area section -->
<?php
echo '<div class="prvcmntcont" style=" width: 830px;height: 550px;overflow-y: scroll;">';
if (count($csmessageModel)>0){
        					$cmntcontnr = 'style="text-align: right;"';
        					$usrimg = 'style="float: right;"';
        					$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';

        					foreach ($csmessageModel as $key => $csmessage) {
        						//if ($key < 5) {
        							if ($csmessage['sentby'] == $currentUser) {
					$prof_img = $merchantModel['profile_image'];
					if(empty($prof_img)){
						$prof_img = "usrimg.jpg";
					}
							echo '<div id="111" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border_bottom_grey padding-top20 padding-bottom20 hor-padding negotian-by-info clearfix">
									<div class="negotaio-image">
										<div class="messag-img">
											<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'">
												<div class="clint-img admin-img" style="background-image:url('.SITE_URL.'media/avatars/thumb150/'.$prof_img.');background-repeat:no-repeat;"></div>
											</a>
										</div>
										
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

					$prof_img = $buyerModel['profile_image'];
					if(empty($prof_img)){
						$prof_img = "usrimg.jpg";
					}
							echo '<div id="222" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 negotiatin-chat-cover no-hor-padding clearfix">
									<div class="chatflow padding-top20 padding-bottom30 no-hor-padding clearfix ">
										<div class="nogatim-chat">
											<div class="messag-img">
												<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'">
													<div class="clint-img stranger-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$prof_img.');background-repeat:no-repeat;"></div>
												</a>
											</div>
										</div>
										<div class="messanger-details">
											<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'">
												<div class="bold-font margin-top0 margin-bottom10 ">'.$buyerModel['first_name'].'</div>
											</a>
												<div class="font-color margin-bottom10">'.date('d,M Y',$csmessage['createdat']).'</div>
												<div class="font-color margin-bottom10 foldtxt">'.$csmessage['message'].'</div>

										</div>
									</div>
							</div>';
							}
						//	}
							}


	}
	else
	{
		echo __d('user','No Conversation Found');
	}
	echo '</div>';
							if (count($csmessageModel) > 5)
							{
								/*echo '<div class="loadmorecomment centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20 trn" onclick="loadmorecomment('.$contactsellerModel['id'].')" style="cursor: pointer;"><a href="javascript:void(0);">+ '.__d('user','Load More').'</a>
								<div class="morecommentloader" style="display: none;">
        							<img src="'.$baseurl.'images/loading.gif" alt="Loading" />
        						</div>
        					</div>';*/
							}
?>
	
        	<input type="hidden" id="hiddencsid" value="<?php echo $contactsellerModel['id']; ?>" />
        	<input type="hidden" id="hiddenbuyerid" value="<?php echo $buyerModel['id']; ?>" />
        	<input type="hidden" id="hiddenmerchantid" value="<?php echo $merchantModel['id']; ?>" />
        	<input type="hidden" id="hiddenusrname" value="<?php echo $merchantModel['first_name']; ?>" />
        	<input type="hidden" id="hiddenusrimg" value="<?php echo $merchantModel['profile_image']; ?>" />
        	<input type="hidden" id="hiddenusrurl" value="<?php echo $merchantModel['username_url']; ?>" />
        	<input type="hidden" id="hiddenroundprofile" value="<?php echo $roundProfile; ?>" />

        		<!-- chat area section -->
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 chating-area hor-padding padding-top15 padding-bottom15 clearfix margin-top20">
									<textarea maxlength="250" data-gramm="false" id="mercntcmnd" class="chat-textarea font-color col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" rows="4" placeholder="<?php echo __d('user','Type your message here');?>"></textarea>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top15 no-hor-padding clearfix">
										<div class="footer-acnt-save">
											<div class="btn primary-color-bg primary-color-bg bold-font txt-uppercase pull-right">
												<input class="sellerpostcomntbtn btn-primary-inpt txt-uppercase" value="<?php echo __d('user','Send');?>" type="submit" onclick="return postmessage(<?php echo "'".$currentUser."'";?>)">
											</div>
									<div class="postcommenterror trn" style="color: #ffffff;font-weight: bold;"></div>
										</div>
									</div>
								</div>
								<!-- chat area section -->
							
				</div>

        </div> </div>		
		

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>

	<script type="text/javascript">
    var currentUser = '<?php echo $currentUser; ?>';
	var crntcommentcnt = '<?php echo count($csmessageModel); ?>';
	var csid = '<?php echo $contactsellerModel['id']; ?>';
	var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 5;
	var baseurl = getBaseURL();

	function loadmorecomment(oid){
		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'getmoreviewmessage',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt,'contact':currentUser,'csid':csid},
				beforeSend: function(){
					$('.morecommentloader img').show();
				},
				success: function(responce){
					$('.morecommentloader img').hide();
					if($.trim(responce)=='false'){
						loadmore = 0;
				        loadmoreajax = 1;
				        $('.loadmorecomment').html('No more messages');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
					}
					else if (responce != 'false'){
				        $('.prvcmntcont').append(responce);
				        loadmoreajax = 1;
						loadmorecmntcnt += 5;
					}
				}
			});
		}
	}
</script>