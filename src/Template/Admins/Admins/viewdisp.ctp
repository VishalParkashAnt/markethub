<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Dispute'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Dispute'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Dispute Details'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">


						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">






    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">



    
    <div style="text-align:right">
    <a href="javascript:history.back()"><input type="button" class="btn btn-info" value="<?php echo __d('user','Back');?>"></a>
    </div>
   

   		<table width="700px;">
   		<tr><td style="text-align:left;padding:0px;"></td><td style="padding:18px 14px 8px 13px;float:right;">

   	<?php $disp['resolvestatus'];?>
   	<?php if($disp['resolvestatus']!='Resolved' && $disp['newstatusup']!='Cancel' && $disp['newstatusup']!='Processing' && $disp['newstatusup']!='Closed') {?>
   		<?php //echo $this->Form->create('Dispute'); ?>
        				 <?php
			//echo $this->Form->submit('Resolve Now',array('class'=>'btn btn-success reg_btn', 'name'=>'resolve'));
		//echo $this->Form->end();
		$disid=$disp['disid'];
?>
						<?php
						if($disp['newstatusup'] == 'Processing'){?>
							<select id="<?php echo $disid;?>" name="<?php echo $disid;?>" style="width:110px;margin: 4px 0 0;" class="statuscurrent<?php echo $disid;?>" onchange="disputestatuscurrent('<?php echo $disid; ?>')">
							<option value="<?php echo $disp['newstatusup'];?>"><?php echo $disp['newstatusup'];?></option>
							<option value="Closed"><?php echo __d('admin', 'Closed'); ?></option>
							<option value="Reopen"><?php echo __d('admin', 'Reopen'); ?></option>

							</select>
						<?php }elseif($disp['newstatusup'] == 'Closed'){?>
							<select id="<?php echo $disid;?>" name="<?php echo $disid;?>" style="width:110px;margin: 4px 0 0;" class="statuscurrent<?php echo $disid;?>" onchange="disputestatuscurrent('<?php echo $disid; ?>')">
							<option value="<?php echo $disp['newstatusup'];?>"><?php echo $disp['newstatusup'];?></option>
							<option value="Processing"><?php echo __d('admin', 'Processing'); ?></option>
							<option value="Reopen"><?php echo __d('admin', 'Reopen'); ?></option>

						<?php }else{
                            /*if($disp['newstatusup']=="Accepeted)
                            {
                            $newstatusup ="Accepted";
                            }
                            else
                            {
                            $newstatusup = $disp['newstatusup'];
                            }*/
                            ?>
						<select id="<?php echo $disid;?>" name="data[<?php echo $disid;?>]" style="width:110px;margin: 4px 0 0;" class="statuscurrent<?php echo $disid;?>" onchange="disputestatuscurrent('<?php echo $disid; ?>')">
							<option value="<?php echo "Accepted";?>" style="border-bottom: 1px dashed black;"><?php echo "Accepted";?></option>
							<option value="Processing"><?php echo __d('admin', 'Processing'); ?></option>
							<option value="Closed"><?php echo __d('admin', 'Closed'); ?></option>
							<option value="Reopen"><?php echo __d('admin', 'Reopen'); ?></option>
						<?php }?>
						    <?php } else { }?>
   		</td></tr></table>

   		<table id="myTable" class="tablesorter table table-striped table-bordered" style="width: 689px;">
   		<tr><td style="font-size:13px;font-weight:bold;width:250px;"><?php echo __d('admin', 'Order Number'); ?></td><td style="padding: 9px 11px 4px 6px;"><?php echo $disp['uorderid']; ?></h3></td></tr>
   		<?php if($disp['itemdetail'] != 'null'){?>
   		<tr><td style="font-size:13px;font-weight:bold;width:250px;"><?php echo __d('admin', 'Product Detail'); ?></td><td>
   		<?php  $subjects = json_decode($disp['itemdetail'], true);
   		 foreach($subjects as $key=>$sub){?><!-- <span style="margin:0px;"> --><?php  //echo $sub;
   		?> <?php }?><?php  foreach($itemname as $name){?>
   		<span style="margin:0px;"><?php echo '<a class="viewitem" href="'.SITE_URL.'adminitemview/'.$name['itemid'].'" target="_blank">'?><?php echo $name['Order_items']['itemname'];?></a><br/></span><?php }?></td></tr><?php }else{ }?>
   		<tr><td style="font-size:13px;font-weight:bold;width:250px;"><?php echo __d('admin', 'Seller'); ?></td><td style="padding: 9px 11px 4px 6px;"><?php echo $disp['semail']; ?></td> </tr>
   		<tr><td style="font-size:13px;font-weight:bold;width:250px;"><?php echo __d('admin', 'Order Date'); ?></td> <td style="padding: 9px 11px 4px 6px;"><?php echo date('d, M Y',$orderModel['orderdate']); ?> </td></tr>
   		<tr><td style="font-size:13px;font-weight:bold;width:250px;"><?php echo __d('admin', 'Total Amount Paid'); ?></td><td style="padding: 20px 11px 3px 4px;"><?php  echo $currencySymbol.$disp['totprice']." ".$currencyCode; ?></td></tr>
   		<tr><td style="font-size:13px;font-weight:bold;width:250px;"><?php echo __d('admin', 'Status'); ?></td><td style="padding: 20px 11px 3px 4px;"><?php
        	if ($orderModel['status'] != '' && $orderModel['status'] != 'Paid'){
				echo "<span class='markshipstatusrslt'>".$orderModel['status']."</span>";
			}elseif ($orderModel['status'] != 'Paid'){
				echo "<span class='markshipstatusrslt'>".__d("admin","Pending")."</span>";
			}else {
				echo "<span class='markshipstatusrslt'>".__d("admin","Delivered")."</span>";
			}?></td></tr>
			<tr><td style="font-size:13px;font-weight:bold;width:250px;"><?php echo __d("admin","Dispute Status"); ?>"</td><td style="padding: 20px 11px 3px 4px;">
			<?php
			if($disp['newstatusup'] == 'Responded'){
				echo __d("admin","Seller Reply");
			}elseif($disp['newstatusup'] == 'Reply'){
				echo __d("admin","Buyer Reply");
			}elseif($disp['newstatusup'] == 'Accepeted'){
				echo __d("admin","Seller Accepeted Dispute");
			}elseif($disp['newstatusup'] == 'Cancel'){
				echo __d("admin","Buyer Cancel Dispute");
			}else{
				echo $disp['newstatusup'];
			}
			?></td></tr>
			<tr><td style="font-size:13px;font-weight:bold;width:250px;"><?php echo __d("admin","Shipping Address"); ?></td><td style="padding: 20px 11px 3px 4px;word-wrap: break-word;"><?php echo $userModel['first_name']; ?></br>
        			<?php
        			echo $shippingModel['address1'].",</br>";
        			if (!empty($shippingModel['address2'])){
        				echo $shippingModel['address2'].",</br>";
        			}
        			echo $shippingModel['city']." - ".$shippingModel['zipcode'].",</br>";
        			echo $shippingModel['state'].",</br>";
        			echo $shippingModel['country'].",</br>";
        			echo "Ph.: ".$shippingModel['phone'].".</br>";
        			?></tr>
        			<tr><td style="font-size:13px;font-weight:bold;width:250px;"><h3><?php echo __d("admin","What's the problem"); ?></h3></td><td style="padding: 20px 11px 3px 4px;" ><?php echo $disp['uorderplm']; ?></td></tr>
        			<tr><td style="font-size:13px;font-weight:bold;width:250px;">Message</td><td style="padding: 20px 11px 3px 4px;word-wrap: break-word;"><?php echo $disp['uordermsg']; ?></td></tr>
        			<?php if($disp['resolvestatus']!='Resolved' && $disp['newstatusup']!='Cancel' && $disp['newstatusup']!='Processing' && $disp['newstatusup']!='Closed') {?> </table>
        			<script>
        			function rlyadmsg(){
        				var data = $('#rlyadmsg1').serialize();
        				var message=$('#message').val();
        				if($.trim(message) == ''){
        					$("#alert").show();

        					$('#alert').text('<?php echo __d("admin","Enter the Text"); ?>');

        					return false;
        				}

                        $('#snd_btn').attr('disabled',true);

        				$('#rlyadmsg1').submit();

        			}
        			</script>
        			<table style="width:689px;">
   	<tr><td style="font-size:13px;font-weight:bold;text-align:left;padding:9px 0px 0px 0px;"><?php echo __d("admin","Reply Message"); ?></td></tr><tr><td style="padding: 9px 0px 0px 0px;text-align:left;">

 	<?php echo $this->Form->create('Dispcon', array( 'id'=>'rlyadmsg1','onsubmit'=>'return rlyadmsg()')); ?>
    <div class="input">

  <textarea name="msg" id="message" class="merchantcommandss"></textarea><?php echo "<div id='alert' style='color:red;float:left;height:0px;padding: 20px 0 0 530px;font-size:12px;font-weight:bold;'></div>"; ?></div></td></tr>
 <tr><td style="text-align: right;"> <?php
			echo $this->Form->submit(__d('admin', 'Send'),array('class'=>'btn btn-info reg_btn','id'=>'snd_btn'));
		echo $this->Form->end();

?>
 </td></tr> <?php } else {  }?> </table>
<div class="prvconvcont">
		<div class="prvconvhead" style="font-size:12px;font-weight:bold;"><?php echo __d("admin","Previous Messages: "); ?></div>
		<div class="prvcmntcont">
		<?php if (!empty($messagedisp)){
        					$cmntcontnr = 'style="text-align: right;"';
        					$usrimg = 'style="float: right;"';
        					$usrname = 'style="float: right; margin-right: 0px; margin-left: 20px;"';

        				?>
		<?php
					//echo "<pre>";print_r($itematas);

					//if(count($_GET)==0){
						if(!empty($messagedisp)){
						foreach($messagedisp as $key=>$msg){
							if ($key < 10) {
					?>
					<?php
					$msrc = $msg['commented_by'];
					$msrd=date('d,M Y',$msg['date']);
					$msrm = $msg['message'];
					$msro = $msg['order_id'];
					$imagedisputes = $msg['imagedisputes'];
					//$ro = $msg['msid'];
						 ?>
						 <div class="cmntcontnr">
						 <div class="usrimg">
						 <?php if ($msrc == 'Buyer') {?>
		        			<?php

		        				echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';
									if(!empty($buyerModel['profile_image'])){
									echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/'.$buyerModel['User']['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
									}else{
									echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
									}

									echo '</a>'; ?>
		        			</div>
					<div class="cmntdetails" style="margin: 0px 0px 20px 0px;border-radius: 5px;width:600px;">
					<p class="usrname"><?php echo '<a href="'.SITE_URL.'people/'.$buyerModel['username_url'].'" class="url">';?>
					<?php echo $buyerModel['first_name'];?></p><?php echo '</a>';?><p class="cmntdate"><?php echo $msrd;?></p>
					<p class="comment"><?php echo $msrm; ?></p>
					<p class="link" style="margin: 0 0 -11px;"><?php echo '<a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" class="url" target="_blank">';?><?php echo $imagedisputes; ?></a></p>
				<?php }elseif ($msrc == 'Seller') {?>
					</div>

					<div class="cmntcontnr">
        					<div class="usrimg">

		        			<?php

		        				echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';
									if(!empty($merchantModel['profile_image'])){
									echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/'.$merchantModel['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
									}else{
									echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
									}

									echo '</a>'; ?>
		        			</div>
					<div class="cmntdetails" style="border-radius: 5px;width:600px;">
					<p class="usrname"><?php echo '<a href="'.SITE_URL.'people/'.$merchantModel['username_url'].'" class="url">';?>
					<?php echo $merchantModel['first_name'];?><?php echo '</a>';?></p><p class="cmntdate"><?php echo $msrd;?></p>
					<p class="comment"><?php echo $msrm; ?></p>
					<p class="link" style="margin: 0 0 -11px;"><?php echo '<a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" class="url" target="_blank">';?><?php echo $imagedisputes; ?></a></p>

					</div>

					<?php }else {?>
					</div>

					<div class="cmntcontnr" >
        					<div class="usrimg" >

		        			<?php

		        				//echo '<a href="'.SITE_URL.'people/'.$merchantModel['User']['username_url'].'" class="url">';
									//if(!empty($merchantModel['User']['profile_image'])){
									//echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/'.$merchantModel['User']['profile_image'].'" alt="" class="photo" style="'.$roundProfile.'">';
									//}else{
									echo '<img src="'.$_SESSION['media_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
									//}

									//echo '</a>'; ?>
		        			</div>
					<div class="cmntdetails" style="border-radius: 5px;width:600px;">
					<p class="usrname"><a href="#"><?php echo $msrc;?></a></p><p class="cmntdate"><?php echo $msrd;?></p>
					<p class="comment"><?php echo $msrm; ?></p>
					<p class="link" style="margin: 0 0 -11px;"><?php echo '<a href="'.SITE_URL.'disputeimage/'.$imagedisputes.'" class="url" target="_blank">';?><?php echo $imagedisputes; ?></a></p>

					</div>
				<?php }?>
					</div>

					</div>


					<?php
					}
					}
					}

					//}?>
		</div>
		<?php if (count($messagedisp) > 9) {?>
        					<div class="loadmorecomment" onclick="loadmorecomment('<?php echo $msro ?>')">
        						<?php echo __d('admin', 'Load more'); ?>
        						<div class="morecommentloader">
        							<img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading" />
        						</div>
        					</div>
        			<?php } }else{
        					echo "<div class='noordercmnt' style='text-align:center;'>".__d("admin", "No Conversation Found")."</div>";
        					echo "</div>";
        				}?>
	</div>
		</div>	 		</div>


        <style>


       .loadmorecomment {
    background-color: #F2F2F2;
    border-radius: 4px;
    cursor: pointer;
    padding: 5px 0;
    text-align: center;
}
.prvcmntcont {
	-webkit-transition: all 1s ease-in-out;
	-moz-transition: all 1s ease-in-out;
	-o-transition: all 1s ease-in-out;
	transition: all 1s ease-in-out;
}
.morecommentloader {
    display: inline-block;
    left: 8px;
    position: relative;
    top: 2px;
}
.morecommentloader img {
    width: 16px;
    display: none;
}
.prvconvhead {
    margin-bottom: 12px;
    color: #7C7C7C;
    font-size: 16px;
    font-weight: bold;
}
.prvconvcont {
    margin-left: 10px;
}

.postcommentloader img {
    padding-top: 22%;
    width: 20px;
}
.postcommentloader {
    float: right;
    width: 30px;
    display: none;
}
.postcommenterror {
    color: #DF2525;
    float: right;
    padding-top: 1%;
}
.cmntdate {
    color: #7F7F7F;
}

.usrimg {
    display: inline-block;
    float: left;
    width: 50px;
}
.usrimg .photo {
    width: 40px;
    border-radius: 4px;
}
.cmntdetails {
    display: inline-block;
    width:64.5%;
    border: 1px solid rgba(0, 0, 0, 0.15);
    padding: 5px 10px;
}
.cmntcontnr {
    margin-bottom: 22px;

}
.cmntdetails .usrname {
    float: left;
    margin-right: 20px;
    text-transform: capitalize;
}
.cmntdetails .usrname a {
    color: #2A5F95;
    text-decoration: none;
    font-weight: bold;
}
.comment {
    white-space: normal;
    word-wrap: break-word;
    margin:0px 0px -6px 1px;
}
p {
    font-size: 13px;
    font-style: normal;
    line-height: 18px;
    padding: 0 0 10px;
}
.cmntdate {
    color: #7F7F7F;
}
.cmntdetails .usrname {
    float: left;
    margin-right: 20px;
    text-transform: capitalize;
}
.cmntdetails .usrname a {
    color: #2A5F95;
    text-decoration: none;
    font-weight: bold;
}
.comment {
    white-space: normal;
    word-wrap: break-word;
}
.prvconvhead {
    margin-bottom: 12px;
    color: #7C7C7C;
    font-size: 16px;
    font-weight: bold;
}
.prvconvcont {
    margin-left: 10px;
}

.merchantcommandss{

        			width:671px;
        			border-radius:5px;
        			}


.sellerdtls {
    //display: inline-block;
    //margin-left: 10px;
    font-size: 12px;
}
.sellerdtls .username a {
    color: #2A5F95;
    font-size: 12px;
    font-weight: bold;
    text-decoration: none;
    text-transform: capitalize;
}
.buyerorderheadul{
	border-bottom: 1px solid rgba(0,0,0,0.2);
	padding-top: 4%;
}
.sellerdtls .username {
    padding-bottom: 0;
}
.sellerdtls .usernameat {
    //color: #9D9D9D;
    //font-weight: bold;
    padding: 0;
}
.orderdetlshead {
    font-size: 12px;
    font-weight: normal;
}
.buyermarkshiporderid{
    font-size: 12px;
    font-weight: bold;
}
.buyerorderheadul{
	border-bottom: 1px solid rgba(0,0,0,0.2);
	padding-top: 4%;
}
.orderdetlshead {
    font-size: 12px;
    font-weight: normal;
}
.buyerviewshipaddr{
	margin-right: 3%;
    margin-top: 12px;
    width: 55%;
}
.buyerviewright {
    border-left: 1px solid rgba(0, 0, 0, 0.17);
    display: inline-block;
    margin-right: 10px;
    padding-left: 25px;
    width: 36%;
}
.buyerviewaddrhead {
    //color: #7C7C7C;
    font-size: 14px;
    //font-weight: bold;
}
.buyerviewshipdetails {
    font-size: 14px;
    color: #2D2D2D;
}
.buyermarkshipstatus{
    padding: 10px 0 0;
    font-size: 14px;
}

</style>



</div>

	</table></div>
					</div>
				</div><!--/span-->

			</div><!--/row-->
						<!-----Dispute Details------->

</div>
</div>



</div>

