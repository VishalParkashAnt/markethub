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
      <a href="#"><?php echo __d('user','Disputes');?></a>
     
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
							<h2 class="user_profile_inner_heading pro-title-head section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<?php echo __d('user','Dispute Buyer');?> </h2>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin-top10 fint-height margin-bottom10 text-right responsive-text-center">
								<a href="<?php echo SITE_URL.'dispute/'.$loguser['username_url'].'?buyer';?>" class="primary-color-txt"><i class="fa fa-angle-left margin-both5"></i>
									<?php echo __d('user','Back to disputes');?> </a>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">
							<div class="border font-color clearfix">
		<?php
		foreach($messagedisp as $ky=>$msg){
			$msro = $msg['order_id'];
			$disputeid = $msg['dispid'];
			$newstatus = $msg['newstatus'];
		}
		?>

								<div class="border_bottom_grey clearfix hor-padding padding-top10 padding-bottom10">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6  margin-top5 no-hor-padding dispu-id">
										<div class="dispu-id-number">
											<div><?php echo __d('user','Dispute ID');?>: </div>
											<div class="bold-font">
											<?php
											echo $disputeid;
											?>
											</div>
										</div>
									</div>
									<div class="dip-status col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding text-right responsive-text-center">
											<div><?php echo __d('user','Status');?>: </div>
											<div class="primary-color-txt bold-font">
       <?php
       if($orderdet['newstatusup'] == 'Reply'){
       	echo __d('user','Responded');
       }elseif($orderdet['newstatusup'] == 'Responded'){
       	echo __d('user','Reply');
       } elseif($orderdet['newstatusup'] == 'Admin'){
       	echo __d('user','Reply');
       } elseif($orderdet['newstatusup'] == 'Cancel'){
       	echo __d('user','Resolved');
       } else{
       	if(strtolower($orderdet['newstatusup']) == "accepeted")
	       echo __d('user',"Accepted");
	    else
	    	echo __d('user',$orderdet['newstatusup']);
		}
       ?>
											</div>
									</div>
								</div>

								<div class="padding-left10 padding-right10 padding-top10 padding-bottom10 clearfix">
									<div class="border_bottom_grey padding-bottom10 clearfix">
										<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 hor-padding border_right_grey responsive-no-border">
											<div class="buyer-inital col-xs-4 col-sm-3 col-md-3 col-lg-2 no-hor-padding">
												<span class="white-txt txt-uppercase"> M </span>
											</div>
											<div class="buyer-detail col-xs-9 col-sm-9 col-md-9 col-lg-10">
												<p class="margin-bottom0"><?php echo __d('user','Buyer');?></p>
												<p><b><?php echo $orderdet['uname'];?></b></p>
											</div>
										</div>
										<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8 hor-padding">
											<div class="seller-inital col-xs-4 col-sm-2 col-md-2 col-lg-1 no-hor-padding">
												<span class="white-txt txt-uppercase"> S </span>
											</div>
											<div class="buyer-detail col-xs-9 col-sm-10 col-md-10 col-lg-11">
												<p class="margin-bottom0"><?php echo __d('user','Seller');?></p>
												<p><b><?php echo $orderdet['sname'];?></b></p>
											</div>
										</div>
									</div>

									<div class="invoice-section">
										<h6><?php echo __d('user','Invoice');?>:</h6>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<p class="red-txt"><?php echo __d('user','Order ID');?>: <?php echo $orderdet['uorderid']; ?></p>

<?php

$disputeitem = json_decode($orderdet['uorderstatus']);

foreach($orderitemmodel as $itemname){

	if(in_array($itemname['itemid'],$disputeitem))
	{
		$p=$itemname['itemunitprice'];
	$q=$itemname['itemquantity'];
	$shi=$itemname['shippingprice'];
	echo '<br><div class="purchase-name">';
	echo $itemname['itemname'];
 echo '</div>';
 echo '<div class="item-price pull-right hor-padding">';echo $p * $q + $shi . ' '.$currencyCode;
echo '</div><br>';
$pq += $p * $q ;
$sipe+= $shi;
$tot= $pq+$sipe;
$itemcounttoal= count($itemname['itemname']);
	}
	
}
?>

										</div>
									</div>

								</div>

								<div class="total-amount padding-left10 padding-right10 padding-top10 padding-bottom10">
									<div class="purchase-name"><?php echo __d('user','Purchase Amount');?></div>
									<div class="item-price pull-right hor-padding"><b><?php echo $orderdet['totprice']. '  '. $currencyCode;?></b></div>
								</div>

							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-top20 padding-bottom10 no-hor-padding">
								<!--button class="resolv-btn btn primary-color-bg bold-font txt-uppercase margin-right10"> Resolved </button>
								<button class="resolv-btn btn bold-font red-btn txt-uppercase"> Cancel Dispute </button-->

  <?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Accepeted'  && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed' && $orderdet['newstatus']!='Accepeted') {?>
    <?php echo $this->Form->create('Cancel', array( 'id'=>'cancelform','onclick'=>'return cancelsubform();'));
    echo '<input type="hidden" value="cancel" name="cancel">';
			echo $this->Form->submit(__d('user','Cancel'),array('class'=>'sellerpostcomntbtn resolv-btn btn bold-font red-btn txt-uppercase', 'div'=>false,'name'=>'cancel','style'=>'margin-right:85px;margin-top: 9px;
}'));

		echo $this->Form->end();
		//echo "<div id='alert' style='color:red;float:right;height:0px; padding: 9px 0px 0 0;margin: 0 -117px 0 21px;font-weight:bold;font-size:12px;'></div>";
?>  <?php }else{ }?>
		<?php if($orderdet['newstatus']=='Accepeted' && $orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel') {?>
    <?php echo $this->Form->create('Resolved', array( 'id'=>'resolveform','onclick'=>'return resolvesubform();'));
    		echo '<input type="hidden" value="resolve" name="resolve">';
			echo $this->Form->submit(__d('user','Resolved'),array('class'=>'sellerpostcomntbtn resolv-btn btn primary-color-bg bold-font txt-uppercase margin-right10', 'div'=>false,'name'=>'resolve','style'=>'margin-right:85px;margin-top: 9px;
}'));

		echo $this->Form->end();
		//echo "<div id='alert' style='color:red;float:right;height:0px; padding: 9px 0px 0 0;margin: 0 -117px 0 21px;font-weight:bold;font-size:12px;'></div>";
?>  <?php }else{ }?>

							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-top20 padding-bottom10 no-hor-padding">
								<h5 class="bold-font sub-header"> <?php echo __d('user','Negotiation');?>: </h5>
							</div>
							<!-- new loadmore change -->
							<!--<div class="chatflow padding-top10 border_bottom_grey padding-bottom30 hor-padding clearfix ">
							</div>
							<div class="chatflow padding-top10 border_bottom_grey padding-bottom30 hor-padding clearfix ">
							<?php if (count($messagedisp) > 9) { ?>
					<div class="loadmorecomment centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20 trn" onclick="loadmorecomment(<?php echo $msro;?>)" style="cursor: pointer;"> <a href="javascript:void(0);">+ &nbsp;&nbsp;<?php echo __d('user','Load More');?></a>
				<div class="morecommentloader" style="display: none;">
					<img src="'.SITE_URL.'images/loading.gif" alt="Loading" />
				</div>
			</div>

			 <?php } ?>
							</div>-->
							<!-- end loadmore section -->
							<div class="prvcmntcont" style=" width: 100%;height: 550px;overflow-y: scroll;">
							
<?php
	if(!empty($messagedisp)){
	foreach($messagedisp as $key=>$msg){
		$msgCount=count($messagedisp);
		$start=$msgCount-10;
		//if ($key < 10) { //old
		//if ($key >= $start) { //new
		
$msrc = $msg['commented_by'];
$msrd=date('d,M Y',$msg['date']);
$msrm = $msg['message'];
$msro = $msg['order_id'];
$imagedisputes = $msg['imagedisputes'];
if ($msrc == 'Buyer') {
$profile_image = $buyerModel['profile_image'];
if($profile_image == "")
$profile_image = "usrimg.jpg";
		echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border_bottom_grey padding-top10 padding-bottom20 hor-padding negotian-by-info clearfix">
				<div class="negotaio-image">
					<div class="messag-img">
					<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'">
						<div class="clint-img admin-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$profile_image.');background-repeat:no-repeat;"></div>
					</a>
					</div>
				</div>
				<div class="negotation-details margin-both15">
				<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'">
					<div class="bold-font primary-color-txt">'.$buyerModel['first_name'].'</div>
				</a>';
				echo '<div class="font-color margin-bottom5">'.$msrd.'</div>';
				echo '<p class="font-color margin-bottom10" style="word-break:break-all;">'.$msrm.'</p>';
		if($imagedisputes!='')
		{
			echo '<div class="text-left">
				<div class="attached-file col-lg-12 col-md-12 col-sm-12 col-xs-12 grey-color-bg hor-padding">
						<!--<div class="pointer left-pointer"></div>-->
						<p class="text_grey_dark margin-both5 margin-top5 bold-font margin-bottom5">
						'.__d('user','Download File').'</p>
						<div class="custm-file">
							<div class="file-name">
							<a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" target="_blank">
							<img src="'.SITE_URL.'images/icons/attach.png" class="url" height="16" width="16" style="height:16px!important;width:16px!important;">&nbsp;'.$imagedisputes.'</a>
							</div>
						</div>
						<p class="text_grey_dark margin-both5 margin-top5 margin-bottom5"></p></br>
					</div>
					
			</div>';
		}

				echo '</div>



		</div>';
}elseif ($msrc == 'Seller') {
$profile_image = $merchantModel['profile_image'];
if($profile_image == "")
$profile_image = "usrimg.jpg";
		echo '

		<!-- new right content start -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 negotiatin-chat-cover no-hor-padding clearfix">

				<div class="chatflow padding-top10 border_bottom_grey padding-bottom30 hor-padding clearfix ">
									<div class="nogatim-chat">
										<div class="messag-img">
										<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'">
											<div class="clint-img admin-img stranger-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$profile_image.');background-repeat:no-repeat;"></div>
											</a>
										</div>
									</div>
									<div class="messanger-details margin-both15">
									<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'">
									<div class="bold-font">'.$merchantModel['first_name'].'</div>
									</a>';
									
									echo '<div class="font-color margin-bottom5">'.$msrd.'</div>';
									echo '<div class="font-color margin-bottom10" style="word-break:break-all;">'.$msrm.'</div>';
									if($imagedisputes!='')
		{

								echo '<div class="attached-file col-lg-12 col-md-12 col-sm-12 col-xs-12 grey-color-bg hor-padding">
												<!--<div class="pointer right-pointer"></div>-->
												<p class="text_grey_dark margin-both5 margin-top5 bold-font margin-bottom5">Download File</p>
												<div class="custm-file">

													<div class="file-name">
													 <a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" target="_blank"> <img src="'.SITE_URL.'images/icons/attach.png" width="16" height="16" style="height:16px!important;width:16px!important;"> '.$imagedisputes.' 
													 </a>
													 </div>
												</div>
												<p class="text_grey_dark margin-both5 margin-top5 margin-bottom5"></p></br>
										</div>';
									}
								echo '</div>
				</div>

			</div><!-- new right content end -->';


		
}
else
{

$profile_image = "usrimg.jpg";
echo '
	<!-- new right content start -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 negotiatin-chat-cover no-hor-padding clearfix">

				<div class="chatflow padding-top10 border_bottom_grey padding-bottom30 hor-padding clearfix ">
									<div class="nogatim-chat">
										<div class="messag-img">
										<div class="clint-img admin-img stranger-img" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$profile_image.');background-repeat:no-repeat;"></div></div>
									</div>
									<div class="messanger-details margin-both15">
									<div class="bold-font margin-top0 margin-bottom10 ">'.$adminModel['first_name'].'</div>';
									echo '<div class="font-color margin-bottom5">'.$msrd.'</div>';
									echo '<div class="font-color margin-bottom5">'.$msrm.'</div>';
									if($imagedisputes!='')
		{

								echo '<div class="attached-file col-lg-12 col-md-12 col-sm-12 col-xs-12 grey-color-bg hor-padding">
												<!--<div class="pointer right-pointer"></div>-->
												<p class="text_grey_dark margin-both5 margin-top5 bold-font margin-bottom5">
						'.__d('user','Download File').'</p>
												<div class="custm-file">

													<div class="file-name">
													 <a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" target="_blank">'.$imagedisputes.' <img src="'.SITE_URL.'images/icons/attach.png" width="16" height="16" style="height:16px!important;width:16px!important;">
													 </a>
													 </div>
												</div>
												<p class="text_grey_dark margin-both5 margin-top5 margin-bottom5"></p></br>
										</div>';
									}
								echo '</div>
				</div>

			</div><!-- new right content end -->';
		
}
//} new
//}  old
}

echo '</div>';
	/*if (count($messagedisp) > 9) {
		echo '<div class="loadmorecomment centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20 trn" onclick="loadmorecomment('.$msro.')" style="cursor: pointer;"><a href="javascript:void(0);">+ '.__d('user','Load More').'</a>
				<div class="morecommentloader" style="display: none;">
					<img src="'.SITE_URL.'images/loading.gif" alt="Loading" />
				</div>
			</div>';

	}*/
}
else
{
	echo __d('user','No Conversation Found');
}
?>

						</div>
				<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel') {?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 negotiatin-chat-cover no-hor-padding clearfix">
							<?php
if($orderdet['Dispute']['newstatusup']!='Resolved' && $orderdet['Dispute']['newstatusup']!='Cancel' && $orderdet['Dispute']['newstatusup']!='Processing' && $orderdet['Dispute']['newstatusup']!='Closed' )
{
	echo $this->Form->create('Dispute', array( 'id'=>'disputeform','onsubmit'=>'return rlyadmsg()', 'enctype' => 'multipart/form-data'));
?>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 chating-area hor-padding padding-top15 padding-bottom15 clearfix">
								<textarea class="chat-textarea font-color col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="data[Dispute][msg]"  id="message" class="merchantcommand" rows="4" cols="15" placeholder="<?php echo __d('user','Type your message here');?>"></textarea>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top15 no-hor-padding clearfix">
									<div class="footer-acnt-save">
										<div class="btn primary-color-bg primary-color-bg bold-font txt-uppercase pull-right">
											<input class="btn-primary-inpt txt-uppercase sellerpostcomntbtn" value="<?php echo __d('user','Send');?>" type="submit">
										</div>
										<span><a class="white-txt deactivate-txt pull-right margin-both10" href="javascript:void(0);"><input type="file" class="disputeimgbtn" name="data[Dispute][upload]" size="100" id="file_con" onchange="cpyname(this)" />+ <?php echo __d('user','Click to choose file');?></a></span><?php
echo '<input type="hidden" value="Send " name="buyconver">';
echo '<div id="file_name" style="font-size:13px;color:#fff;"></div>';
echo $this->Form->end();
} ?>
<div id="alert" class="trn" style="color: #ffffff;font-weight: bold;"></div>
									</div>
								</div>
							</div>


						</div>
				<?php } ?>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>

        			<script>

	var crntcommentcnt = '<?php echo count($messagedisp); ?>';
	var order_id = '<?php echo $msro; ?>';
	var loadmorecmntcnt2='<?php echo $start;?>';
	//alert (order_id);
	var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 10;
	var baseurl = getBaseURL();

	$(document).ready(function(){
		//getcurrentcmnt();
	});

	function getcurrentcmnt(){
		//if (cmntupdate == 1){
		//alert (order_id);
			cmntupdate = 0;
			$.ajax({
				url: baseurl+'getbuyercmnt',
				type: 'POST',
				dataType: 'html',
				data: {'currentcont': crntcommentcnt, 'order_id': order_id, 'contact': 'buyer', },
				success: function(responce){
					if (responce) {
						var output = eval(responce);
						crntcommentcnt = output[0];
						var previousmsg = $('.prvcmntcont').html();
					    var currentmsg = output[1] + previousmsg;
				        //$('.prvcmntcont').html(currentmsg);
				        cmntupdate = 1;
					}else{
						cmntupdate = 1;
					}
				}
			});
		//}
		console.log('Calling recursive function');
	}

	setInterval(getcurrentcmnt, 5000);

	function loadmorecomment(mid){
		//alert(mid);
		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'getmorecommentbuyer',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt2,'contact':'buyer','order_id':mid},
				beforeSend: function(){
					$('.morecommentloader img').show();
				},
				success: function(responce){
					$('.morecommentloader img').hide();
					if (responce != 'false'){
						var output = eval(responce);
				      //  $('.prvcmntcont').append(output[1]);
				        $('.prvcmntcont').prepend(output[1]);
				        loadmoreajax = 1;
						loadmorecmntcnt += 10;
					}else{
						loadmore = 0;
				        loadmoreajax = 1;
				        $('.loadmorecomment').html('No More Dispute Comments');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
					}
				}
			});
		}
	}

        			$(document).ready(function(){

        			});
        			function rlyadmsg(){
        				var data = $('#rlyadmsg1').serialize();
        				var message=$('#message').val();
        				if($.trim(message) == ''){
        					$("#alert").show();
        					$('#message').val("");
        					$('#alert').text('Enter the Text');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
    translator.lang(sessionlang);
						setTimeout(function() {
			 				 $('#alert').fadeOut('slow');
						}, 5000);

        					return false;
        				}
        				//
        				$('#rlyadmsg1').submit();

        			}
        			function cpyname(org)
        			{
        				$("#file_name").html("<a style='text-decoration:none;color:red;font-size:18px;' href='javascript:void(0);' onclick='remove_dispute_image();'> x </a>"+org.value);
        			}
				function remove_dispute_image()
				{
					$("#file_con").val("");
					$("#file_name").html("");
				}
        			</script>