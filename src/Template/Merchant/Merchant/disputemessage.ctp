<?php 
$roundProfile = "";
$roundProfileFlag = 0;
if ($roundProf == "round")  {
	$roundProfile = "border-radius:40px;";
	$roundProfileFlag = 1;
} else {
	$roundProfile = "border-radius:8px;";
}
?>
<div class="row-fluid">		
	<div class="box span12">
		<!-- div class="box-header" data-original-title="">
			<h2><?php //echo __('Disputes');?></h2>
		</div -->
		<div class="box-content clearfix">
			<div class="container set_area">
        		<div id="content">
        			<h2 class="ptit m-t-30"><?php echo __('Dispute As Buyer'); ?></h2>
         		<div class="figure-row" style="padding: 20px 13px 18px;min-height:550px;">
					<?php foreach($messagedisp as $ky=>$msg) { 
						$msro = $msg['order_id'];
						$disputeid = $msg['dispid'];
						$newstatus = $msg['newstatus']; } ?>

						<div class="markshiporderidsma">
							<?php echo __('Dispute ID');?>: <?php echo $disputeid; ?>
						</div>
      				<br/>
       				<div class="markshiporderidsma">
       					<?php echo __('Status');?>: 
							<?php 
							if($orderdet['newstatusup'] == 'Reply'){
								echo 'Responded';
							}elseif($orderdet['newstatusup'] == 'Responded'){
								echo 'Reply';
							} elseif($orderdet['newstatusup'] == 'Admin'){
								echo 'Reply';
							} else {
							echo $orderdet['newstatusup']; } ?>
						</div> <br/>
       				
       				<?php if($orderdet['newstatus'] == 'Reopen') {	?>
      					<div class="markshiporderidsma" style="margin:0px 0px -20px 0px;font-weight:bold;">
					       	<?php echo $disputeid; echo '  This Dispute Id Is Reopen'; ?>
       					</div>
     					<?php } ?>
      
       				<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' &&  $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed' ) { ?>
   						<div style=" margin: 25px 0 0px;font-size: 16px;font-weight: bold;color: #7C7C7C;">
   							<?php echo __('Respond:');?>   						
   						</div> 
       				<?php } else { }?>
        	
        				<div class='container' style='padding:0px;'>
							<div class="vert-line row">
    
								<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed' ) { ?>

									<div class="sellercommandarea col-md-6 col-sm-6">
										<div class="sellerimg">
        									<?php if($buyerModel['user_level'] == 'shop') {
												if(!empty($buyerModel['profile_image'])){
													echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
												} else {
													echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
												}
							
											} else { 
        										echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';
												if(!empty($buyerModel['profile_image'])) {
													echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
												} else {
													echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
												}
						
												echo '</a>'; 
											} ?>
        								</div>
        								
        								<div class="">
        									<?php echo $this->Form->create('Dispute', array( 'id'=>'disputeform','onsubmit'=>'return rlyadmsg()', 'enctype' => 'multipart/form-data')); ?>
        				 						
        				 						<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed' ) { ?>
        				  							<textarea name="msg"  id="message" class="merchantcommand" rows="2" cols="15" style="width:82%;height:120px ! important;margin-top: 15px;" ></textarea>
        				  						<?php } else { ?>
        				   						<textarea name="msg" disabled id="message" class="merchantcommand" rows="2" cols="15" style="width:82%;height:120px ! important;margin-top: 15px;" ></textarea>
        				  						<?php } ?>
        										<br/>
        			
        										<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed' ) { ?>
        											
        											<div class="uploadWrapper">
    													<!-- p style="margin: 0 0 0 2px;">
    														<?php // echo __('Click to choose file'); ?>
    													</p -->
    													<div class="uploader" id="uniform-file_con">
    														<input type="file" name="data[Dispute][upload]" size="100" id="file_con" onchange="cpyname(this)">
    														<span> <i class="fa fa-plus" style="padding: 0 0 0 66px;"></i>
    														<?php echo __('Click to choose file'); ?> </span>
    													</div>
    													
													</div>

													<div class="postcommenterror" id="alert" style="font-size: 13px; margin: 10px 0px;color:red;font-weight:400;"></div>

        					 						<?php
													echo $this->Form->submit(__('Send '),array('class'=>'sellerpostcomntbtn btn btn-primary', 'div'=>false,'name'=>'buyconver','style'=>'margin: 0;}'));
														
														echo '<div id="file_name" style="font-size:13px;"></div>'; 
												} 
											echo $this->Form->end();	
											?>
     									</div>	
     								</div>
        						<?php } else {   }?>

								<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed' ) { ?>  
									<div style="position: absolute;width: 244px;margin: 0px 0 0 436px;">	
								<?php } else { ?>  
									<div style="left: 405px;position: relative !important;top: 220px;width: 244px;">
								<?php } ?>

    							<div style="margin: -215px 0 0;border:1px solid #CCCCCC;border-radius: 5px;">
    								<div style="text-align: center;border-radius:5px;border-top:0px solid #CCCCCC;font-size: 15px;font-weight: bold;color:#6D6D6F;"><?php echo __('Total Amount');?></div>
    								<table>

										<tr style="border-top:1px solid #CCCCCC;">
											<td valign="top" style="width:125px;border-right:1px solid #CCCCCC;">
												<label style="font-size:12px;font-weight: bold;margin:0 0 0 5px;"><?php echo __('Buyer');?></label>
												<br>

												<span style="margin: 0 0 0 5px;font-weight: bold;color: #2A5F95; font-size: 12px;">
													<?php echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';?><?php echo $orderdet['uname'];?></a>
												</span>
											</td>
											<td style="width:125px;">
												<label style="font-size:12px;font-weight: bold;margin:0 0 0 5px;"><?php echo __('Seller');?></label><br>
												<span style=" font-size: 12px;color: #2A5F95;font-weight: bold;margin: 0 0 0 5px;overflow: hidden; text-overflow: ellipsis;word-wrap: break-word;">
													<?php echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">'.orderdet['sname'].'</a>'; ?>
												</span>
											</td>
										</tr>

  										<tr style="border-top:1px solid #CCCCCC;">
  											<td colspan="2">
  												<span style="margin: 0 0 0 7px;font-size: 12px;font-weight: bold;"><?php echo __('Other Party:');?></span><span style="font-size:12px;font-weight:normal;margin: 0 0 0 7px;"><?php echo $orderdet['sname'];?></span>
  											</td>
  										</tr>

 										<tr style="border-top:1px solid #CCCCCC;">
 											<td colspan="2" style="width:150px; word-wrap: break-word;">
 												<span style="font-size: 12px;font-weight: bold;margin:0px 0px 0px 7px;">
 													<?php echo __('Invoice');?>:
 												</span><br/>

 												<?php foreach($orderitemmodel as $itemname) { 
													$p=$itemname['itemunitprice'];
													$q=$itemname['itemquantity'];
													$shi=$itemname['shippingprice'];
													echo '<span class="proname">'; 
														echo $itemname['itemname'];
													echo '</span>';

													echo '<span style="margin:0px 7px 0px 160px;float: right;font-size:12px;">';
													echo $p * $q + $shi . ' '.$currencyCode;
													echo '</span>'; 

													$pq += $p * $q ;  
													$sipe+= $shi; 
													$tot= $pq+$sipe; 
													$itemcounttoal= count($itemname['itemname']);?>
													<br/>
 												<?php } ?>
 											</td>
 										</tr>
 
  										<tr style="border-top:1px solid #CCCCCC;">
  											<td colspan="2">
  												<span style="margin: 0 0 0 7px;font-size: 12px;font-weight: bold;">
  													<?php echo __('Purchase Amount');?>:
  												</span>
  												<span style="font-size:12px;font-weight:normal;margin: 0 0 0 60px;">
  													<?php echo $orderdet['totprice']. '  '. $currencyCode;?>
  												</span>
  											</td>
  										</tr>
  
  									</table>

  									<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Accepeted'  && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed' && $orderdet['newstatus']!='Accepeted') { 

    									echo $this->Form->create('Cancel', array( 'id'=>'cancelform', 'class'=>'m-b-20 m-t-20 text-center')); 
										echo $this->Form->submit(__('Cancel'),array('class'=>'sellerpostcomntbtn btn btn-primary', 'div'=>false,'name'=>'cancel','style'=>''));
										echo $this->Form->end(); ?> 
									<?php } else { } ?>

									<?php if($orderdet['newstatus']=='Accepeted' && $orderdet['newstatusup']!='Resolved') {
										echo $this->Form->create('Resolved', array( 'id'=>'resolveform')); 
										echo $this->Form->submit(__('Resolved'),array('class'=>'sellerpostcomntbtn btn btn-primary', 'div'=>false,'name'=>'resolve','style'=>'margin-right:85px;margin-top: 9px;}'));
			
										echo $this->Form->end();
									} else { } ?> 				  
	    							</div>
	    						</div>

								<?php if($orderdet['newstatusup']!='Resolved' && $orderdet['newstatusup']!='Cancel' && $orderdet['newstatusup']!='Processing' && $orderdet['newstatusup']!='Closed' ) { ?>
 									<div class="prvconvcont" style="margin-top: 50px;">   
								<?php } else { ?>
									<div class="prvconvcont" style="margin-top: 188px;">  
								<?php }	?>
     							
     									<div class="prvconvhead"><?php echo __('Negotiation');?>: </div>
     
		     							<div class="prvcmntcont">
										
										<?php if (!empty($messagedisp)) {
				        					$cmntcontnr = 'style="text-align: right;"';
				        					$usrimg = 'style="float: right;"';
				        					$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';
				        					?>
										
											<?php
											if(!empty($messagedisp)) {
												foreach($messagedisp as $key=>$msg) {
													if ($key < 10) {
														$msrc = $msg['commented_by'];
														$msrd=date('d,M Y',$msg['date']);
														$msrm = $msg['message'];
														$msro = $msg['order_id'];
														$imagedisputes = $msg['imagedisputes'];
									 				
									 					 if ($msrc == 'Buyer') { ?>
									 						<div class="cmntcontnr">
									        					<div class="usrimg">
											        			<?php if($buyerModel['user_level'] == 'shop') { 

																	if(!empty($buyerModel['profile_image'])) {
																		echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
																	} else {
																		echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
																	}
																} else {
				        			
				        											echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';
																	if(!empty($buyerModel['profile_image'])) {
																		echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
																	} else {
																		echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
																	}
											
																	echo '</a>';

																} ?>
				        									</div>
						
															<div class="cmntdetails" style="vertical-align: top;">
																<p class="usrname">
																	<?php 
																	if($buyerModel['user_level'] == 'shop')
																	{ 
																		echo $buyerModel['first_name'];
																	} else { 
																		echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">'.$buyerModel['first_name'].'</p></a>'; 
																	} ?>
																	<p class="cmntdate"><?php echo $msrd;?></p>

																	<?php if($imagedisputes==''){} else { ?>
																		<p class="linimg" style="margin: 16px 0 12px;">
																			<?php echo '<a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" class="url" target="_blank">Image</a>';?>
																		</p>
																	<?php } ?>
																	<p class="comment" style="word-break:break-all; line-height: 15px;">
																		<?php echo $msrm; ?>
																	</p>
								
																</div>
															</div>
		        				
														<?php } elseif ($msrc == 'Seller') { ?>	
						
				<div class="cmntcontnr" style=" ">
					<div class="usrimg" style="float: right;">
						<?php  if($merchantModel['user_level'] == 'shop') {
							if(!empty($merchantModel['profile_image'])) {
								echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
							} else {
								echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
							}

						} else { 

							echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';
								if(!empty($merchantModel['profile_image'])) {
									echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
								} else {
									echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">';
								}

							echo '</a>';
						} ?>
					</div>

																<div class="cmntdetails buyercmntright">
													        		<p class="usrname" style="float: right; margin-right: 0px; margin-left: 20px;">
																		<?php if($merchantModel['user_level'] == 'shop') { 
																			echo $merchantModel['first_name'];
																		} else {
																			echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';?>
																				<?php echo $merchantModel['first_name'];?>
																			<?php echo '</a>';?>
																		<?php } ?>
																	</p>
																	<p class="cmntdate buyercmntright"><?php echo $msrd;?></p>

																	<p class="comment buyercmnt" style="word-break:break-all; line-height: 15px;"><?php echo $msrm; ?></p>

																	<?php if($imagedisputes==''){
																	} else { ?>
																		<p class="linimg linright" style="margin: 16px 0 12px;"><?php echo '<a href="'.MERCHANT_URL.'disputeimage/'.$imagedisputes.'" class="url" target="_blank">Image</a>';?>
																		</p>
																	<?php }?>
																</div>
															</div>
														<?php } else { ?>	
				
															<div class="cmntcontnr" style="">
									        					<div class="usrimg" style="float: right;">
											        				<?php 
				        											echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'vertical-align: bottom;">'; ?>
				        										</div>

																<div class="cmntdetails buyercmntright" style="width: 70%;">
				        											<p class="usrname" style="float: right; margin-right: 0px; margin-left: 20px;">
																		<a href="#"><?php echo $msrc;?></a>
																	</p>
																	<p class="cmntdate buyercmntright"><?php echo $msrd;?></p>

																	<p class="comment buyercmnt" style="word-break:break-all; line-height: 15px;"><?php echo $msrm; ?></p>
																</div>				
															</div>
														<?php } ?>			
													<?php
													}
												}
											} ?>
		              				<?php } else {
				        					echo "<div class='noordercmnt' style='text-align:center;margin-left: -265px;'>"?><?php echo __('No Conversation Found');echo "</div>";
				        					echo "</div>";
		        						} ?>
		        						</div>

											<?php if (count($messagedisp) > 9) { ?>
					        					<div class="loadmorecomment" style="font-size: 12px;" onclick="loadmorecomment('<?php echo $msro ?>')">
					        						<?php echo __('Load More');?>
					        						<div class="morecommentloader">
					        							<img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading" />
					        						</div>
					        					</div>
			        						<?php } ?>

									</div>
 								
 							</div> 
 						</div>

						<div class="prvconvcont" style="margin: 0px 0 0;">
							<input type="hidden" id="hiddenorderid" value="<?php echo $orderdet['userid']; ?>" />
				        	<input type="hidden" id="hiddenbuyerid" value="<?php echo $orderdet['selid']; ?>" />
				        	<input type="hidden" id="hiddenmerchantid" value="<?php echo $orderdet['uorderid']; ?>" />
				        	<input type="hidden" id="hiddenliid" value="<?php echo $orderdet['disid']; ?>" />
        	
						</div>

					</div>	
				</div>
			</div>
		</div>
	</div>
</div>	

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
		//getcurrentcmnt();
	});
	
	function getcurrentcmnt(){
		//if (cmntupdate == 1){
		//alert (order_id);
			cmntupdate = 0;
			$.ajax({
				url: baseurl+'getbuyercmnt',
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
		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'merchant/getmorecommentbuyer',
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
				        $('.loadmorecomment').html('No More Disputes');
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
    float: left;
    
    font-size:12px;
    font-weight: bold;
    }
    
    
 div.vert-line {overflow:hidden;}
div.vert-line>div+div{border-left:0px solid #004488;}
div.vert-line>div{
         float:left; }
         
         .uploadWrapper {
    overflow: hidden;
    position: relative;
    height: 30px;
    width: 400px;
    
}
.uploadWrapper input {
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
    opacity: 0;
    position: absolute;
    z-index: 1;
    width: 100%;
    height: 100%;
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
div.uploader{
margin-left: 150px;
}
.cmntcontnr
{
border:1px solid #e4e6eb;
padding: 10px;
margin: 10px;
height: auto;
width:850px;
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
width: 690px;
}
.buyercmntright{
float: right;
}
.linright {
margin-bottom: 12px;
    margin-right: -145px;
    margin-top: 25px;
	float: right;
}
.ptit{
font-weight: 600;
}
 
</style>
        			
<script>
function rlyadmsg() {
	var data = $('#rlyadmsg1').serialize();
	var message=$('#message').val();
	if($.trim(message) == ''){
		$("#alert").show();
		$('#message').val("");
		$('#alert').text('Enter the Text');
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);        					
        					
      return false;
   }

	$('#rlyadmsg1').submit();
	
}
        			
function cpyname(org)
{
	var ext = org.value.split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		$("#file_name").html('Please upload image files');
		$("#file_name").css("color","red");
		$("#file_con").val("");
	} else {
		$("#file_name").html("<a style='text-decoration:none;color:red;font-size:18px;' href='javascript:void(0);' onclick='remove_dispute_image();'> x </a>"+org.value);
		$("#file_name").css("color","black");
	}

}

function remove_dispute_image()
{
	$("#file_con").val("");
	$("#file_name").html("");
}

</script>
        			
