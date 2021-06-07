<?php 
$roundProfile = "";
$roundProfileFlag = 0;
if ($roundProf == "round")  {
	$roundProfile = "border-radius:40px; border:1px solid #f5f5f5;";
	$roundProfileFlag = 1;
} else {
	$roundProfile = "border-radius:5px; border:1px solid #f5f5f5;";
}
?>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Messages'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Messages'); ?></li>
          <!-- li class="breadcrumb-item ">View Messages</li --> 
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <h4 class="text-themecolor m-b-0 m-t-0 clearfix">
                	<span class="rightTitle"><?php echo __d('merchant','Messages'); ?></span>
                	<ul id="nav-altertable" class="nav nav-pills" style="display: inline-flex; float: right;">
                         <li class=" nav-item"> <a href="<?php echo MERCHANT_URL;?>/messages" class="nav-link"> Back </a> </li>
                    </ul>
                </h4>
                <hr/>
                <div class="table-responsive nofilter">
                	<div class="boxMsghead">
                		<label class="control-label text-left"><?php echo __d('merchant','Subject');?></label>
                		<span style="margin:0px 10px;"> : </span>
                		<span>
                			<?php echo $contactsellerModel['subject']; ?>
                		</span>
                	</div>

        			<div class="markshiporderid m-b-20">
        				<label class="control-label text-left"><?php echo __d('merchant','Item Name');?></label>
                		<span style="margin:0px 10px;"> : </span>
                		<span>
                			<a href="<?php echo MERCHANT_URL.'/selleritemview/'.$itemDetails['itemid']; ?>">
                				<?php echo $itemDetails['item']; ?>
                			</a>
                		</span>
        			</div>

        			<div class="sellerimg">
	        			<?php if($merchantModel['user_level'] == 'shop'){
							if(!empty($merchantModel['profile_image'])){
								echo '<img src="'.SITE_URL.'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
							}else{
							echo '<img src="'.SITE_URL.'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
							}
						} else { 
	        				echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';

							if(!empty($merchantModel['profile_image'])){
								echo '<img src="'.SITE_URL.'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
							}else{
								echo '<img src="'.SITE_URL.'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
							}
							echo '</a>';
						} ?>
        			</div>

        			<div class="sellercommandcont">
        				<textarea id="postcommenterror" class="form-control merchantcommand m-t-15 m-b-10"></textarea>
        				<small class="trn form-control-feedback postcommenterror f4-error f4-error-postcommenterror m-b-10"></small> 
        				<button class="sellerpostcomntbtn btn btn-info" onclick="return postmessage('<?php echo $currentUser; ?>');">
        					<?php echo __d('merchant','Send');?>
        				</button>
        				<div class="postcommentloader m-t-10">
        					<img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading..." />
        				</div>
        				
        			</div>
        		</div>
        	</div>
        </div>
        <div class="card m-t-20">
            <div class="card-block">
        			<h4 class="text-themecolor m-b-30 m-t-0"><?php echo __d('merchant','Previous Messages'); ?></h4>

        			
                    <?php if (!empty($csmessageModel)){ ?>
                    <div class="prvcmntcont">
                    <?php
					$cmntcontnr = 'style="text-align: right;"';
					$usrimg = 'style="float: right;"';
					$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';
					foreach ($csmessageModel as $key => $csmessage) {
						if ($key < 5) {
							if ($csmessage['sentby'] == $currentUser) {
        				?>
        					<div class="cmntcontnr" style="margin: 0 0 10px;">
        						<div class="usrimg">
		        				<?php  if($merchantModel['user_level'] == 'shop'){
									if(!empty($merchantModel['profile_image'])){
										echo '<img src="'.SITE_URL.'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
									} else {
										echo '<img src="'.SITE_URL.'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
									}

								} else { 
		        					echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';
									if(!empty($merchantModel['profile_image'])){
										echo '<img src="'.SITE_URL.'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
									} else {
										echo '<img src="'.SITE_URL.'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
									}
									echo '</a>'; 

								}  ?>
		        				</div>
		        				<div class="cmntdetails">
		        					<p class="usrname">
		        					<?php if($merchantModel['user_level'] == 'shop'){
										echo $merchantModel['first_name']; 
									} else {
										echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">'; 
		        							echo $merchantModel['first_name'];
		        						echo '</a>'; 
							  		} ?>
		        					</p>

		        					<p class="cmntdate">
		        						<?php echo date('d,M Y',$csmessage['createdat'])?>
		        					</p>
		        					<p class="comment">
		        						<?php echo $csmessage['message']; ?>
		        					</p>
		        				</div>
        					</div>
        				<?php } else { ?>
        					<div class="cmntcontnr" style="text-align: right;margin: 0 0 10px;">
        						<div class="usrimg" style="float: right;">
		        					<?php  
		        					echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';

									if(!empty($buyerModel['profile_image'])){
										echo '<img src="'.SITE_URL.'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
									} else {
										echo '<img src="'.SITE_URL.'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
									}									
									echo '</a>'; ?>
		        				</div>
		        			
		        				<div class="cmntdetails">
			        				<p class="usrname" style="float: right; margin-right: 0px; margin-left: 20px;">
			        					<?php echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">'; 
			        						echo $buyerModel['first_name']; 
			        					echo '</a>'; ?>
			        				</p>
			        				<p class="cmntdate"><?php echo date('d,M Y',$csmessage['createdat'])?></p>
			        				<p class="comment"><?php echo $csmessage['message']; ?></p>
		        				</div>
        					</div>
        				<?php }
        				}
        			}
        			?> 
        			</div>
        			<?php         			
        			if (count($csmessageModel) > 5) {?>
    					<div class="loadmorecomment" onclick="loadmorecomment('<?php echo $contactsellerModel['id']; ?>')">
    						<?php echo __d('merchant','Load More');?>
    						<div class="morecommentloader">
    							<img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading" />
    						</div>
    					</div>
        			<?php } 
        			} else { ?>
        			 	<div class="prvcmntcont">
	                		<h6 class="card-title text-center"><?php echo __('No Messages Found');?></h6>
	                	</div>
	                <?php }?>
                	
            </div>

            <input type="hidden" id="hiddencsid" value="<?php echo $contactsellerModel['id']; ?>" />
        	<input type="hidden" id="hiddenbuyerid" value="<?php echo $buyerModel['id']; ?>" />
        	<input type="hidden" id="hiddenmerchantid" value="<?php echo $merchantModel['id']; ?>" />
        	<input type="hidden" id="hiddenusrname" value="<?php echo $merchantModel['first_name']; ?>" />
        	<input type="hidden" id="hiddenusrimg" value="<?php echo $merchantModel['profile_image']; ?>" />
        	<input type="hidden" id="hiddenusrurl" value="<?php echo $merchantModel['username_url']; ?>" />
        	<input type="hidden" id="hiddenroundprofile" value="<?php echo $roundProfile; ?>" />

        </div>
    </div>
</div>

<style type="text/css">
	.morecommentloader img
	{
		display: none;

	}
	.postcommentloader
	{
		display: none;
	}
	.loadmorecomment
	{
		cursor: pointer;
		margin-left: 10px;		
	}
	.cmntcontnr
	{
		border:1px solid #e4e6eb;
		padding: 10px;
		margin: 10px;
	}
	.usrname
	{
		float: left;
	    margin-right: 20px;
	    margin-bottom: 0px;
	    padding: 0 0 2px;
	    text-transform: capitalize;
	    width: 100%;
	}
	.sellerimg
	{
		display: inline-block;
	}
	.cmntdetails
	{
		display: inline-block;
	    padding: 5px 10px;
	    width: 70%;
	}
	.cmntdetails .comment {
		word-break: break-all !important;
	}
	.usrimg
	{
		display: inline-block;
		vertical-align: top;
	}

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
	}
	.card .card-block .text-themecolor .rightTitle {
	   padding: 2px 0px;    display: inline-block;
	}
</style>

<script type="text/javascript">
    var currentUser = '<?php echo $currentUser; ?>';
	var crntcommentcnt = '<?php echo count($csmessageModel); ?>';
	var csid = '<?php echo $contactsellerModel['id']; ?>';
	var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 2;
	var baseurl = getBaseURL();

	function loadmorecomment(oid){
		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'merchant/getmoreviewmessage',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt,'contact':currentUser,'csid':csid},
				beforeSend: function(){
					$('.morecommentloader img').show();
				},
				success: function(responce){
					$('.morecommentloader img').hide();
					if($.trim(responce)=='false' || $.trim(responce)==''){
						loadmore = 0;
				        loadmoreajax = 1;
				        $('.loadmorecomment').html('No more messages');
				        $('.loadmorecomment').css('cursor','default');
					}						
					else if (responce != 'false'){
				        $('.prvcmntcont').append(responce);
				        loadmoreajax = 1;
						loadmorecmntcnt += 1;
					}
				}
			});
		}
	}
	
	function postmessage(sender){
	$('.postcommenterror').html('');
	var baseurl = getBaseURL()+'/merchant/replymessage';
	var message = $('#postcommenterror').val();
	var csid = $('#hiddencsid').val();
	
	if ($.trim(message) == ''){
        $('#postcommenterror').val("");
	    if(IsDataValidation(message, emptymsg, 'postcommenterror', '', '', '') == false) return false;
	}
	
	var merchantId = $('#hiddenmerchantid').val();
	var buyerId = $('#hiddenbuyerid').val();
	var usrimg = $('#hiddenusrimg').val();
	var username = $('#hiddenusrname').val();
	var usrurl = $('#hiddenusrurl').val();
	var roundprofile = $('#hiddenroundprofile').val();
	

		$.ajax({
	      url: baseurl,
	      type: "post",
	      dataType: "html",
	      data : { 'csid': csid, 'merchantId': merchantId, 'buyerId': buyerId, 'message': message, 'username': username, 'sender': sender, 'usrimg': usrimg, 'username': username, 'usrurl': usrurl, 'roundprofile': roundprofile},
	      beforeSend: function(){
	    	 $('.postcommentloader').show(); 
	    	// $('.sellerpostcomntbtn').css({'padding':'0 24px 0 10px'});
	      },
	      success: function(responce){
	    	$('.postcommentloader').hide(); 
	    	// $('.sellerpostcomntbtn').css({'padding':'0 15px'});
	    	$('#postcommenterror').val('');
	    	var currentData = $('.prvcmntcont').html();
	    	var combinedData = responce + currentData;
	    	$('.prvcmntcont').html(combinedData);
		    //$('.noordercmnt').html("");
	        //$('#postcommenterror').val("");
	      }
	   });
	}
	
</script>
