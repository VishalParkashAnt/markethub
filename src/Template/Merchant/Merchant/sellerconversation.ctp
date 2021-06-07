<?php 
$roundProfile = "";
$roundProfileFlag = 0;
if ($roundProf == "round")  {
	$roundProfile = "border-radius:40px;";
	$roundProfileFlag = 1;
}
?>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Conversation'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Seller Conversation'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Seller Conversation'); ?></h4>
                <hr/>
		
				<div class="table-responsive nofilter">
        			<div class="markshiphead">
        				<label class="control-label text-left"><?php echo __d('merchant','Conversation with buyer');?></label>
                		<span style="margin:0px 10px;"> : </span>
                		<span>
                			<?php echo $buyerName; ?>
                		</span>
                	</div>
        			<div class="markshiporderid">
        				<label class="control-label text-left"><?php echo __d('merchant','Order Id');?></label>
                		<span style="margin:0px 10px;"> : </span>
                		<span>
                			<?php echo $orderModel['orderid']; ?>
                		</span>
                	</div>
	        		<div class="markshipstatus">
	        			<label class="control-label text-left"><?php echo __d('merchant','Status');?></label>
                		<span style="margin:0px 10px;"> : </span>
                		<span>
                			<?php if ($orderModel['status'] != '' && $orderModel['status'] != 'Paid'){
								echo __d('merchant',$orderModel['status']);
							} elseif ($orderModel['status'] != 'Paid') {
								echo __d('merchant','Pending');
							} else {
								echo __d('merchant','Delivered');
							} ?>
	                	</span>
        			</div>
        	
					<?php if ($orderModel['status'] != 'Delivered' && $orderModel['status'] != 'Paid'){ ?>
						<div class="sellercommandcont">
							<textarea id="postcommenterror" class="form-control merchantcommand m-t-15 m-b-10" maxlength="2500"></textarea>
	        				<small class="trn form-control-feedback postcommenterror f4-error f4-error-postcommenterror m-b-10"></small> 
	        				<button class="sellerpostcomntbtn btn btn-info" onclick="return postordersellercomment();">
	        					<?php echo __d('merchant','Send');?>
	        				</button>
	        				<div class="postcommentloader m-t-10">
	        					<img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading..." />
	        				</div>
						</div>
					<?php } ?>
				</div>
        	</div>
        </div>

         <div class="card m-t-20">
            <div class="card-block">
        		<h4 class="text-themecolor m-b-30 m-t-0"><?php echo __d('merchant','Previous Messages');?> </h4>
           			<?php if (count($ordercommentsModel) > 0) { ?>
           			<div class="prvcmntcont">
           			<?php
    					$cmntcontnr = 'style="text-align: right;"';
    					$usrimg = 'style="float: right;"';
    					$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';
    					foreach ($ordercommentsModel as $key => $ordercomment) {
    					if ($key < 5) {
    					if ($ordercomment['commentedby'] == 'seller') {
	        				?>
	        				<div class="cmntcontnr" style="margin: 0 0 10px;">
	        					<div class="usrimg" style="float: left;">
			        			<?php if($merchantModel['user_level'] == 'shop'){ 

								if(!empty($merchantModel['profile_image'])){
										echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
										}else{
										echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
										}

								} else { 
			        				echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';
										if(!empty($merchantModel['profile_image'])){
										echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
										}else{
										echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
										}
										
										echo '</a>';
								}  ?>
			        			</div>
			        			<div class="cmntdetails">
			        				<p class="usrname">
			        					<?php  if($merchantModel['user_level'] == 'shop'){ 
									echo $merchantModel['first_name']; 


								} else {									
								echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">'; 
			        						echo $merchantModel['first_name']; 
			        					echo '</a>';
								} ?>
			        				</p>
			        				<p class="cmntdate"><?php echo date('d,M Y',$ordercomment['createddate'])?></p>
			        				<p class="comment"><?php echo $ordercomment['comment']?></p>
			        			</div>
        					</div>
        				<?php } else {?>
        					<div class="cmntcontnr" style="text-align: right;margin: 0 0 10px;">
        					<div class="usrimg" style="float: right;">
		        			<?php 
		        				echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';
									if(!empty($buyerModel['profile_image'])){
									echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/'.$buyerModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
									}else{
									echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
									}
									
									echo '</a>'; ?>
		        			</div>
		        			<div class="cmntdetails">
		        				<p class="usrname" style="/*float: right; margin-left: 20px;*/ margin-right: 0px; ">
		        					<?php echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">'; 
		        						echo $buyerModel['first_name']; 
		        					echo '</a>'; ?>
		        				</p>
		        				<p class="cmntdate"><?php echo date('d,M Y',$ordercomment['createddate'])?></p>
		        				<p class="comment"><?php echo $ordercomment['comment']?></p>
		        			</div>
        				</div>
        				<?php }
        						}
        					} ?>
        				</div>
        				<?php
        				if (count($ordercommentsModel) > 5) { ?>
        					<div class="loadmorecomment" style="cursor: pointer;margin-left: 10px;" onclick="loadmorecomment('<?php echo $orderModel['orderid']; ?>')">
        						<?php echo __d('merchant','Load more comment');?>
        						<div class="morecommentloader" style="display: none;">
        							<img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading" />
        						</div>
        					</div>
        				<?php } }
        				else { ?>
        					<div class="prvcmntcont">
	                			<h6 class="card-title text-center"><?php echo __d('merchant','No Conversation Found');?></h6>
	                		</div>
        				<?php }?>
        			</div>
        	
        	<input type="hidden" id="hiddenorderid" value="<?php echo $orderModel['orderid']; ?>" />
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
		/*float: left;
	    margin-right: 20px;*/
	    margin-bottom: 5px;
	    padding: 0 0 2px;
	    text-transform: capitalize;
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
	.usrimg
	{
		display: inline-block;
	}
	p.comment {
		word-wrap: break-word;
	}
</style>

<script type="text/javascript">
	var crntcommentcnt = '<?php echo count($ordercommentsModel); ?>';
	var orderid = '<?php echo $orderModel['orderid']; ?>';
	var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 2;
	var baseurl = getBaseURL();

	$(document).ready(function(){
		//getcurrentcmnt();
	});
	
	function getcurrentcmnt(){
		//if (cmntupdate == 1){
			cmntupdate = 0;
			$.ajax({
				url: baseurl+'merchant/getrecentcmnt',
				type: 'POST',
				dataType: 'html',
				data: {'currentcont': crntcommentcnt, 'orderid': orderid, 'contact': 'seller' },
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
		//console.log('Calling recursive function');
	}
	
	//setInterval(getcurrentcmnt, 5000);

	function loadmorecomment(oid){
		if (loadmoreajax == 1 && loadmore == 1){
			loadmoreajax = 0;
			$.ajax({
				url: baseurl+'merchant/getmorecomment',
				type: 'POST',
				dataType: 'html',
				data: {'offset': loadmorecmntcnt,'contact':'seller','orderid':oid},
				beforeSend: function(){
					$('.morecommentloader img').show();
				},
				success: function(responce){
					$('.morecommentloader img').hide();
					var output = eval(responce);
			        if (output[1]){
			        	 $('.prvcmntcont').append(output[1]);
				        loadmoreajax = 1;
						loadmorecmntcnt += 1;
					}else{
						loadmore = 0;
				        loadmoreajax = 1;
				        $('.loadmorecomment').html('No more comments');
				        $('.loadmorecomment').css('cursor','default');
					}
				}
			});
		}
	}

function postordersellercomment() {
	var baseurl = getBaseURL()+'merchant/postordercomment';
	var orderid = $('#hiddenorderid').val();
	var merchantid = $('#hiddenmerchantid').val();
	var buyerid = $('#hiddenbuyerid').val();
	var comment = $('.merchantcommand').val();
	var usrimg = $('#hiddenusrimg').val();
	var usrname = $('#hiddenusrname').val();
	var usrurl = $('#hiddenusrurl').val();
	var postedby = "seller";
	var roundprofile = $('#hiddenroundprofile').val();

	if(IsDataValidation(comment, emptymsg, 'postcommenterror', 'length', '', 2500) == false) return false;
	
	$.ajax({
	      url: baseurl,
	      type: "post",
	      dataType: "html",
	      data : { 'orderid': orderid, 'merchantid': merchantid, 'buyerid': buyerid, 
    	  		'comment': comment, 'usrimg': usrimg, 'usrname': usrname, 'usrurl': usrurl,	'postedby': postedby, 'roundProfile': roundprofile},
	      beforeSend: function(){
	    	 $('.postcommentloader').show(); 
	      },
	      success: function(responce){
	          //alert(responce);
	    	$('.postcommentloader').hide(); 

		    $('.noordercmnt').html("");
		    var previousmsg = $('.prvcmntcont').html();
		    var currentmsg = responce + previousmsg;
	        $('.prvcmntcont').html(currentmsg);
	        $('.merchantcommand').val("");
	        $('.prvcmntcont > h6.card-title').remove();
	      }
	    });
	
}
</script>
