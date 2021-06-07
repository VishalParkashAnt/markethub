<style>
.fashion-img > img {
	border-radius: 100%;
	height: 70px;
	width: 70px;
}
</style>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Fashion User Image'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Merchant'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Fashion User Image'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-block">
            <!-- h4 class="card-title">Data Table</h4 -->
            <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Fashion User Image'); ?></h4>
            <hr/>
      		
         	<div class="prvcmntcont m-t-30"> 
					<?php if (count($fashionuser) > 0) { ?>
        			<div class="table-responsive nofilter">
	        			<table id="myTables" class="table table-bordered table-striped">
			        		<thead>
			        			<tr><th class="p-l-10"><?php echo __('#'); ?></th>
			        				<!-- th><?php //echo __('F.No'); ?></th -->
									<th><?php echo __d('merchant','Buyer');?></th>
				        			<th><?php echo __d('merchant','Fashion User Image');?></th>
				        			<th class="producttd"><?php echo __d('merchant','Products');?></th>
				        			<th><?php echo __d('merchant','Created Date');?></th>
				        			<th><?php echo __d('merchant','Status');?></th>
				        			<th><?php echo __d('merchant','Actions');?></th>
				        		</tr>
			        		</thead>
	        				<tbody class="pvrcmntload">
	        					<?php 
	        						if(!empty($fashionuser)) {
	        							$i = 0;
										foreach($fashionuser as $orderDetail) {

										$fid = $orderDetail['id'];
										$usid = $loguser['id'];
								?>
								<tr id="odr<?php echo $fid; ?>">
									<td class="p-l-10"><?php echo ++$i; ?></td>
									<!-- td><?php // echo $fid; ?></td -->
									<td><?php if(!empty(trim($orderDetail['user']['username'])))
											echo $orderDetail['user']['username'];
											else echo " --- "; ?></td>
									<?php 
										echo "<td class='fashion-img text-center'>";
										if(!empty(trim($orderDetail['userimage'])))
										{
											echo"<img src='".SITE_URL."media/avatars/original/".$orderDetail['userimage']."' />";
										}
										else
										{
											echo"<img src='".SITE_URL."media/avatars/thumb70/usrimg.jpg'/>";
										}
										echo "</td>";
									?>
									<td class="producttd">
										<?php if(!empty(trim($orderDetail['item']['item_title'])))
												echo $orderDetail['item']['item_title'];
											else echo " --- "; ?>
									</td>
									<td><?php echo date('d/m/Y',$orderDetail['cdate']); ?></td>

									<?php 	
									if($orderDetail['status'] == 'No')
									{	
										$value = '1';	
										echo '<td id="charity_btn'.$fid.'">
													<buttton type="button" onclick=changevalue('.$fid.','.$value.'); class="btn btn-success">'.__d('merchant','Show').'</button>
														</td>'; 
									}
									else
									{
										$value = '0';
										echo '<td id="charity_btn'.$fid.'">
											<buttton type="button" onclick=changevalue('.$fid.','.$value.'); class="btn btn-info">'.__d('merchant','Hide').'</button>
											</td>';
									}	
									?>
							
									<td><?php echo '<a onclick = "deletefashion('.$fid.');" role="button" data-toggle="modal" style="cursor:pointer;"><span class="btn btn-danger"><i class="icon-trash"></i></span></a>';
									 ?></td>
							
								</tr>	
								<?php } }?>
	        				</tbody>
	        			</table>
					</div>
		        	<?php 
					} else {
		        					echo "<div class='noordercmnt m-b-30' style='text-align:center;'>" ?>
		        						<?php echo __d('merchant','No Orders Available');
		        					echo "</div>";
		        				} ?>
				</div>	
	</div>
		
</div>		
</div>
</div>

<div id="invoice-popup-overlay">
	<div class="invoice-popup">
	</div>
</div>
<style type="text/css">
	#myTables_filter {
		margin-bottom: 30px !important;
	}
	.producttd {
		width: 150px !important;
		word-break: break-all !important;
	}
</style>
<script type="text/javascript" src="<?php echo SITE_URL; ?>js/jQuery.print.js"></script>

<script>
$('#myTables').DataTable({
        dom: 'Bfrtip'
    });
</script>
<script type="text/javascript">

	var baseurl = getBaseURL();
	
	function deletefashion(id) {
		var eleid = "#odr"+id;
		if(confirm("Are you sure want to delete this fashion")) {
			$.ajax({
		      url: baseurl+"merchant/deleteitemfashion/"+id,
		      type: "post",
		      dataType: "html",
		      success: function(responce){
		    	  if (responce == 'false') {
		    		//  alert('Unable to process now');
		    	  } else {
		            $(eleid).remove();
		            window.location.reload();
		    	  }
		      }
		    });
		}
	}

	function changevalue(id, value)
	{
		$.ajax({
		      url: baseurl+"merchant/updatephotofashion",
		      type: "post",
		      data : { 'id': id, 'value': value },
		      dataType: "html",
		      success: function(responce){
		      	if(responce!="false")
		    	  		window.location.reload();
		      }
		});	


	}
	
</script>
