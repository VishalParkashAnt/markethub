<?php 
$roundProfile = "";
$roundProfileFlag = 0;
if ($roundProf == "round")  {
	$roundProfile = "border-radius:40px;";
	$roundProfileFlag = 1;
}else {
	$roundProfile = "border-radius:8px;";
}
?>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Dispute as seller'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item"><?php echo __d('merchant','Disputes'); ?></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Seller'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-block">
				<h4 class="text-themecolor m-b-0 m-t-0 clearfix">
					<span class="rightTitle"><?php echo __d('merchant','Dispute as seller'); ?></span>
					<ul id="nav-altertable" class="nav nav-pills" style="display: inline-flex; float: right;">
	                         <li class=" nav-item"> <a href="<?php echo MERCHANT_URL;?>/disputes/<?php echo $_SESSION['first_name'];?>?buyer" class="nav-link"> Back </a> </li>
	                </ul>
                </h4>
				<hr/>
				<!-- h4 class="card">Dispute as seller</h4 -->

				<?php foreach($messagedisp as $ky=>$msg) {
					$msro = $msg['dispid']; 
				}?>

				<div class="markshiporderidsma m-b-10">
					<?php echo __d('merchant','Dispute Id');?> <span class="m-r-10 m-l-10"> : </span><?php echo $msro; ?>
				</div> 
	         <div class="markshiporderidsma">
	         	<?php echo __d('merchant','Status');?> <span class="m-r-10 m-l-10"> : </span> 
					<?php 
					if($orderdet['newstatusup'] == 'Reply'){
						echo __d('merchant','Reply');
					}elseif($orderdet['newstatusup'] == 'Responded'){
						echo __d('merchant','Responded');
					}elseif($orderdet['newstatusup'] == 'Admin'){
						echo __d('merchant','Reply');
					}else{
					echo __d('merchant',$orderdet['newstatusup']); }?>
				</div> 
				<br/>

				<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed' ) { ?>
  					<h4 class="card"><?php echo __d('merchant','Respond')." : ";?></h4> 
  				<?php } ?>

  				<ul class="news col-md-12 col-sm-12 row list-unstyled p-0 m-0">
               <li class="col-md-6 col-sm-12">
               	<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed') { ?>
							<div class="sellercommandarea col-md-12 col-sm-12 p-0">
								<div class="sellerimg">
				        			<?php  if($merchantModel['user_level'] == 'shop') { 
										if(!empty($merchantModel['profile_image'])) {
											echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
											} else {
											echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
											}

									} else {
				        				echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';
											if(!empty($merchantModel['profile_image'])){
												//echo $buyerModel['profile_image'];
											echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
											}else{
											echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
											}
											
											echo '</a>'; 
									} ?>
     							</div>
     			
     							<div class="sellercommandcont">
     				
					        		<?php echo $this->Form->create('Dispute', array( 'id'=>'disputeform','onsubmit'=>'return rlyadmsg()', 'enctype' => 'multipart/form-data')); ?>
					        			<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed') { ?>

					        				  <textarea name="msg" id="message"  class="merchantcommand" maxlength="250" rows="2" cols="15" style="width:100%;height:120px ! important;margin-top: 15px;"></textarea>

						        		<?php } else {?>
						        		  		  <textarea name="msg" id="message" disabled class="merchantcommand" rows="2" cols="15" maxlength="250" style="width:95%;height:120px ! important;margin-top: 15px;"></textarea>
						        		<?php } ?>
					        			<br/>

										<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed') { ?>

											<div class="uploadWrapper">
												<!-- p style="margin: 0 0 0 2px;"><?php // echo __('Click to choose file');?></p -->
												<div class="uploader text-right" id="uniform-file_con">
													<input type="file" name="data[Dispute][upload]" size="100" id="file_con" onchange="cpyname(this)">
													<span> <i class="fa fa-plus" style="padding: 0 0 0 22px;"></i>
													<?php echo __d('merchant','Click to choose file'); ?> </span>
												</div>
											</div>
									<?php echo '<div id="file_name" class="trn" style="font-size:13px; color:red; font-weight:400;" class="m-b-10"></div>'; ?>
									<div class="postcommenterror trn" id="alert" style="font-size: 13px; margin: 10px 0px;color:red;font-weight:400;"></div>

					        		<?php
										echo $this->Form->submit(__d('merchant','Send'),array('class'=>'sellerpostcomntbtn btn btn-info m-b-30','div'=>false, 'name'=>'selconver','style'=>' margin: 0;'));
										echo $this->Form->end();
					        			 } 
									?> 		 
								</div>
							</div> 
						<?php } ?>
               </li>

               <li class="col-md-6 col-sm-12">
               	<div style="margin:0px 0px 0px 0px;border:1px solid #CCCCCC;border-radius: 5px;">
		   			   <div style="text-align: center;border:0px solid #CCCCCC;font-size: 15px;font-weight: bold;color:#6D6D6F;">		
		   			   	<?php echo __d('merchant','Total Amount');?>
		   			   </div>
		   				<table style="width:100%;">
								<tr style="border-top:1px solid #CCCCCC;">
									<td valign="top" style="width:125px;border-right:1px solid #CCCCCC;">
										<label style="font-size:12px;font-weight: bold;margin:0 0 0 5px;"><?php echo __d('merchant','Buyer');?></label><br>
										<span style="margin: 0 0 0 5px;font-weight: bold;color: #2A5F95;font-size: 12px;">
										<?php if($buyerModel['user_level'] == 'shop') { 
											 echo $orderdet['uname'];
											} else {
											 echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';?><?php echo $orderdet['uname'];?></a>
										<?php } ?></span>
									</td>
									<td style="width:125px;">
					   				<label style="font-size:12px;font-weight: bold;margin:0 0 0 5px;"><?php echo __d('merchant','Seller');?></label><br>
					    			<span style=" font-size: 12px;color: #2A5F95;font-weight: bold;margin: 0 0 0 5px;overflow: hidden;text-overflow: ellipsis;word-wrap: break-word;">
					    			<?php if($merchantModel['user_level'] == 'shop') { 
										 echo $orderdet['sname'];
										} else {
										echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';?><?php echo $orderdet['sname'];?></a>
									<?php } ?> </span></td>
								</tr>
	 							<tr style="border-top:1px solid #CCCCCC;">
	 								<td colspan="2"><span style="margin: 0 0 0 7px;font-size: 12px;font-weight: bold;"><?php echo __d('merchant','Other Party')." : ";?></span><span style="font-size:12px;font-weight:normal;margin: 0 0 0 7px;"><?php echo $orderdet['uname'];?></span>
	 								</td>
	 							</tr>
		 						<tr style="border-top:1px solid #CCCCCC;">
		 							<td colspan="2"><span style="margin:0px 0px 0px 7px;font-size: 12px;font-weight: bold;">
		 							<?php echo __d('merchant','Invoice');?>:</span><br/><?php

		 							$disputeitem = json_decode($orderdet['uorderstatus']);

		 							 foreach($orderitemmodel as $itemname){

		 							 	if(in_array($itemname['itemid'],$disputeitem))
	{
		 							  $p=$itemname['itemunitprice'];$q=$itemname['itemquantity'];$shi=$itemname['shippingprice'];echo '<span class="proname">'; echo $itemname['itemname'];
				 						echo '</span>';
				 						echo '<span style="margin:0px 7px 0px 160px;float:right;font-size:12px;">';echo $p * $q + $shi . ' '.$currencyCode;echo '</span>';
				 						$pq += $p * $q ;  $sipe+= $shi; $tot= $pq+$sipe; ?><br/><?php   } }?>
				 						</td>
				 					</tr>
			 						<tr style="border-top:1px solid #CCCCCC;">
			 							<td colspan="2"><span style="margin: 0 0 0 7px;font-size: 12px;font-weight: bold;"><?php echo __d('merchant','Purchase Amount');?>:</span><span style="font-size:12px;font-weight:normal;margin: 0 0 0 60px;"><?php echo $orderdet['totprice'].'  '.$currencyCode;?></span></td>
			 						</tr>
								</table>
			 
			 					<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Accepeted'  && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed'&& $orderdet['newstatus']!='Accepeted') { ?>
					    			<?php
					    			echo $this->Form->create('accept', array( 'id'=>'acceptform', 'class'=>'text-center m-b-20 m-t-20'));
									echo $this->Form->submit(__d('merchant','Accept'),array('class'=>'sellerpostcomntbtn btn btn-info m-b-30', 'div'=>false,'name'=>'accept','style'=>''));
									echo $this->Form->end();?>
							<?php } ?>				  
   								
   					</div>
               </li>
            </ul>

            <hr/>


            <div class="prvconvcont m-t-30" style="">
        		<h4 class="card row"><?php echo __d('merchant','Negotiation');?>: </h4>
        		
        		<div class="prvcmntcont row">
					<?php if (!empty($messagedisp)) {
    					$cmntcontnr = 'style="text-align: right;"';
    					$usrimg = 'style="float: right;"';
    					$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';
    					if(!empty($messagedisp)){
							foreach($messagedisp as $key=>$msg){
								if ($key < 5) {
						?>
							<?php 
								$msrc = $msg['commented_by'];
								$msrd=date('d,M Y',$msg['date']);
								$msrm = $msg['message'];
								$newdispstatus = $msg['newdispstatus'];
								$msro = $msg['order_id'];
								$imagesdisputes = $msg['imagedisputes'];
							 ?>
							<?php if ($msrc == 'Buyer') {?>
								<div class="cmntcontnr" style="">
		        					<div class="usrimg" style="float: right;">
				        			<?php  if($buyerModel['user_level'] == 'shop') { 

									if(!empty($buyerModel['profile_image'])){
											echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
											}else{
											echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
											}
									} else { 
				        					echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';
											if(!empty($buyerModel['profile_image'])){
											echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
											}else{
											echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
											}
											echo '</a>';
									}  ?>
									</div>

			        				<div class="cmntdetails buyercmntright" style="width: 70%;">
						        		<p class="usrname" style="float: right; margin-right: 0px; margin-left: 20px;">
										<?php  if($buyerModel['user_level'] == 'shop') { 
												echo $buyerModel['first_name'];
											} else { 
											   echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';?>
											<?php echo $buyerModel['first_name'];?></p><?php echo '</a>' ; 
											 }?>
										<p class="cmntdate buyercmntright"><?php echo $msrd;?></p>
										<p class="comment buyercmnt" style="word-break:break-all;"><?php echo $msrm; ?></p>
										<?php if($msg['imagedisputes'] == ''){ }else{?>	
										<p class="linimg linright" style=""><?php echo '<a href="'.SITE_URL.'disputeimage/'.$imagesdisputes.'" class="url" target="_blank">';?><?php echo __d('merchant','Image'); ?></a></p>
										<?php } ?>
										
					
									</div>
								</div>
					
							<?php } elseif ($msrc == 'Seller') { ?>
								<div class="cmntcontnr">
		        					<div class="usrimg" style="float: left;">
										<?php if($merchantModel['user_level'] == 'shop'){
											if(!empty($merchantModel['profile_image'])){
												echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
											}else{
												echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
											}

										} else {
		        			
					        				echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';
												if(!empty($merchantModel['profile_image'])){
												echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
												}else{
												echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
												}
												
												echo '</a>';
										}  ?>
		        					</div>
									<div class="cmntdetails">
										<?php  if($merchantModel['user_level'] == 'shop'){ ?>
										<p class="usrname"><?php echo $merchantModel['first_name'];?></p>
										<?php } else { ?>
										<p class="usrname"><?php echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';?>
										<?php echo $merchantModel['first_name'];?><?php echo '</a>';?></p>
										<?php } ?>
										<p class="cmntdate"><?php echo $msrd;?></p>
										<p class="comment" style="word-break:break-all; line-height: 15px;"><?php echo $msrm; ?></p>
										<?php if($msg['imagedisputes'] == ''){ }else{?>
								  		<p class="linimg" style="margin: 0 0 -12px;"><?php echo '<a href="'.SITE_URL.'disputeimage/'.$imagesdisputes.'" class="url" target="_blank">';?><?php echo __d('merchant','Image'); ?></a></p>
										<?php }?>
									</div>
								</div>
							<?php } else {?>	
								<div class="cmntcontnr" style="">
		        					<div class="usrimg" style="float: right;">
								
				        			<?php 
									echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
									 ?>
				        			</div>
					
									<div class="cmntdetails buyercmntright" style="width: 70%;">
						        	<p class="usrname" style="float: right; margin-right: 0px; margin-left: 20px;">
									<a href="#"><?php echo $msrc;?></a></p><p class="cmntdate buyercmntright"><?php echo $msrd;?></p>
									<p class="comment buyercmnt" style="word-break:break-all; line-height: 15px;"><?php echo $msrm; ?></p>
									</div>
								</div>
						<?php }?>	
					
						<?php
						}
						}
						}
						?>
				
        				
        			<?php } else {
        					echo "<div class='noordercmnt' style='text-align:center;margin-left: -265px;'>"?><?php echo __d('merchant','No Conversation Found');echo "</div>";
        					//echo "</div>";
        				}?>
        				</div>

        				<?php if (count($messagedisp) > 5) {?>
        					<div class="loadmorecomment trn" style="font-size: 12px;" onclick="loadmorecomment('<?php echo $msro ?>')">
        						<?php echo __d('merchant','Load More');?>
        						<div class="morecommentloader">
        							<img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading" />
        						</div>
        					</div>
        				<?php } ?>
   			
        		</div>

			</div>
		</div>
	</div>
</div>

			<input type="hidden" id="hiddenorderid" value="<?php echo $orderdet['userid']; ?>" />
        	<input type="hidden" id="hiddenbuyerid" value="<?php echo $orderdet['selid']; ?>" />
        	<input type="hidden" id="hiddenmerchantid" value="<?php echo $orderdet['uorderid']; ?>" />
        	<input type="hidden" id="hiddenliid" value="<?php echo $orderdet['disid']; ?>" />
        	<input id="file_name_hidden" type="hidden" value="">   
     
<div id="invoice-popup-overlay">
	<div class="invoice-popup">
	</div>
</div>

<script type="text/javascript">
	var crntcommentcnt = '<?php echo count($messagedisp); ?>';
	var order_id = '<?php echo $msro; ?>';
	//alert (order_id);
	var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 2;
	var baseurl = getBaseURL();

	$(document).ready(function(){
		getcurrentcmnt();
	});
	
	function getcurrentcmnt(){
		//if (cmntupdate == 1){
		//alert (order_id);
			cmntupdate = 0;
			$.ajax({
				url: baseurl+'getsellercmnt',
				type: 'POST',
				dataType: 'json',
				data: {'currentcont': crntcommentcnt, 'order_id': order_id, 'contact': 'buyer', },
				success: function(responce){
					if (responce) {
						var output = eval(responce);
						crntcommentcnt = output[0];
						var previousmsg = $('.prvcmntcont').html();
					    var currentmsg = output[1] + previousmsg;
				        $('.prvcmntcont').html(currentmsg);
				        cmntupdate = 1;
					}else{
						cmntupdate = 1;
					}
				}
			});
		//}
		console.log('Calling recursive function');
	}
	
	//setInterval(getcurrentcmnt, 5000);

	function loadmorecomment(mid){
		//alert(mid);
		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'merchant/getmorecommentseller',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt,'contact':'buyer','order_id':mid},
				beforeSend: function(){
					$('.morecommentloader img').show();
				},
				success: function(responce){
					var output = eval(responce);
					$('.morecommentloader img').hide();
					if($.trim(output[1])=='false' || $.trim(output[1])==''){
               			loadmore = 0;
				        loadmoreajax = 1;
				        var sessionlang = $("#languagecode").val();
						var translator = $('body').translate({t: dict});
						$(".loadmorecomment").removeAttr('data-trn-key');
    					$('.loadmorecomment').html('No More Disputes');
    					translator.lang(sessionlang);
				   } else {
				        $('.prvcmntcont').append(output[1]);
				        loadmoreajax = 1;
						loadmorecmntcnt += 1;
					}
				}
			});
		}
	}
</script>
<style>
@media screen and (min-width: 520px) {
    .card .card-block .text-themecolor ul.nav-pills > li > a {
        padding: 2px 8px;
        font-size: 14px;
    }
}   

@media (min-width: 320px) and (max-width: 480px) {
    .card .card-block .text-themecolor ul.nav-pills > li > a {
        padding: 0px 10px;
        font-size: 12px;
    }
    .proname {
    	width: 130px !important;
    }
}

@media (min-width: 320px) and (max-width: 767px) {
    .card .card-block ul.news > li {
        padding: 0px !important;
    }
}

news
.card .card-block .text-themecolor .rightTitle {
   padding: 2px 0px;    display: inline-block;
}
        			.merchantcommandss{
        			
        			width:630px;
        			}
        			.sub{
        			-moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #4882BC;
    background-image: linear-gradient(to top, #4882BC, #518BC5);
    border-color: #396C9D #396C9D #2F5A83;
    border-image: none;
    border-radius: 2px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 1px rgba(0, 0, 0, 0.11), 0 1px rgba(175, 207, 236, 0.1) inset;
    color: #FFFFFF;
    float: right;
    font-size: 12px;
    font-weight: bold;
    height: 31px;
    line-height: 1em;
    margin-bottom: 8px;
    margin-left: 9px;
    margin-right: 18px;
    padding: 0 12px;
    text-align: center;
    text-decoration: none;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.2);
    }
    .pmsg{
    color: #7C7C7C;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 12px;
    margin: 0 0 24px 0px;
    }
    
  .markshiporderidsma{
    font-size:12px;
    font-weight: 400;
    }
    div.vert-line {overflow:hidden;}
//div.vert-line>div+div{border-left:0px solid #004488;}
div.vert-line>div{
        // float:left; }

.uploadWrapper input {
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
    opacity: 0;
    position: absolute;
    z-index: 1;
    width: 40px;
    height: auto;
    cursor:pointer;
}
.uploadWrapper p {
    margin: 0 10px;
    position: absolute;
    line-height: 25px;
}
.proname{ 
    display:block;
    width:160px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin: 0 0 -18px 15px;
    font-size:12px;
}

.cmntcontnr
{
border:1px solid #e4e6eb;
padding: 10px;
margin: 0 0 10px;
width:100%;

}
.prvconvcont {
	padding:0px 15px !important;
}
.usrimg{
display: inline-block;
}
.cmntdetails{
display: inline-block;
    padding: 5px 10px;
    width: 70%;
line-height: 10px;
}
.morecommentloader img
{
display: none;
}
.loadmorecomment
{
cursor: pointer;
margin-left: 10px;		
}
.buyercmnt{
float: right;
text-align: right;
line-height: 15px;
width: 100%;
}
.buyercmntright{
float: right;
}
.linright {

	float: right;
}
.ptit{
font-weight: 600;
}
.usrimg img.photo {
	vertical-align: bottom !important;
}
      


        			</style>
        			<script>
        			function rlyadmsg(){
        				var data = $('#rlyadmsg1').serialize();
        				var filename = $("#file_name").html();
        				var file_name_hidden = $("#file_name_hidden").val();
        				var message = $.trim($('#message').val());

        				if($.trim(filename) != '' && ($.trim(message) != '')) {
        					if($.trim(filename) != $.trim(file_name_hidden)) {
        						var sessionlang = $("#languagecode").val();
								var translator = $('body').translate({t: dict});
								$("#alert").removeAttr('data-trn-key');
								$("#alert").show();
	        					$('#alert').text('Upload image error');
	        					translator.lang(sessionlang);
								setTimeout(function() {
									  $('#alert').fadeOut('slow');
									}, 4000);        					
	        					return false;
        					} /*else if(message.length < 10) {
        						var sessionlang = $("#languagecode").val();
								var translator = $('body').translate({t: dict});
								$("#alert").removeAttr('data-trn-key');
								$("#alert").show();
								$("#message").addClass("has-error");
	        					$('#alert').text('This field must have atleast 10 characters');
	        					translator.lang(sessionlang);
								setTimeout(function() {
									  $('#alert').fadeOut('slow');
									  $("#message").removeClass("has-error");
									}, 5000);        					
	        					return false;
        					} */
        					else if(message.length > 250) {
        						var sessionlang = $("#languagecode").val();
								var translator = $('body').translate({t: dict});
								$("#alert").removeAttr('data-trn-key');
								$("#alert").show();
								$("#message").addClass("has-error");
	        					$('#alert').text('This field must not exceed 250 characters');
	        					translator.lang(sessionlang);
								setTimeout(function() {
									  $('#alert').fadeOut('slow');
									  $("#message").removeClass("has-error");
									}, 5000);        					
	        					return false;
        					}
        					$('#rlyadmsg1').submit();
        				} else if($.trim(filename) != '' && ($.trim(filename) == $.trim(file_name_hidden))) {
        					$('#rlyadmsg1').submit();
        				} else if($.trim(message) != '') {
        					/*if(message.length < 10) {
        						var sessionlang = $("#languagecode").val();
								var translator = $('body').translate({t: dict});
								$("#alert").removeAttr('data-trn-key');
								$("#alert").show();
								$("#message").addClass("has-error");
	        					$('#alert').text('This field must have atleast 10 characters');
	        					translator.lang(sessionlang);
								setTimeout(function() {
									  $('#alert').fadeOut('slow');
									  $("#message").removeClass("has-error");
									}, 5000);        					
	        					return false;
        					} else*/ if(message.length > 250) {
        						var sessionlang = $("#languagecode").val();
								var translator = $('body').translate({t: dict});
								$("#alert").removeAttr('data-trn-key');
								$("#alert").show();
								$("#message").addClass("has-error");
	        					$('#alert').text('This field must not exceed 250 characters');
	        					translator.lang(sessionlang);
								setTimeout(function() {
									  $('#alert').fadeOut('slow');
									  $("#message").removeClass("has-error");
									}, 5000);        					
	        					return false;
        					}
        					$('#rlyadmsg1').submit();
        				} else {
        					var sessionlang = $("#languagecode").val();
							var translator = $('body').translate({t: dict});
							$("#alert").removeAttr('data-trn-key');
							$("#alert").show();
        					$("#message").val("");
        					$("#message").addClass("has-error");
        					$('#alert').text('This field is required (or) Upload a image');
        					translator.lang(sessionlang);
							setTimeout(function() {
								  $('#alert').fadeOut('slow');
								  $("#message").removeClass("has-error");
								}, 4000);        					
        					return false;
        				}        				
        			}
        			
        			function cpyname(org)
        			{
        				var ext = org.value.split('.').pop().toLowerCase();
						if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
							var sessionlang = $("#languagecode").val();
							var translator = $('body').translate({t: dict});
							$("#file_name").removeAttr('data-trn-key');
							$("#file_name").html('Please upload image files');
							translator.lang(sessionlang);
							$("#file_name").css("color","red");
							$("#filetype").val("");
							
						}
						else {
	        				$("#file_name").html(org.value);
	        				$("#file_name_hidden").val(org.value);        				
						$("#file_name").css("color","black");
						}
        			}
        			</script>
