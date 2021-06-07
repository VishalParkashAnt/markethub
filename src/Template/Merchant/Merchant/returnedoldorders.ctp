<?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
<?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>

<script>
	var lastmenuid = 0;
	$(document).click(function(event) {
		  var target = $(event.target);

		  if (!target.hasClass('moreactions') && !target.hasClass('moreactionsli') && !target.hasClass('headarrdwn')) {
		    $('.moreactionlistmyord').hide();
		  }
	});

	$(document).ready(function(){
		$('.moreactionlistmyord').hide();
		$('.morecommentloader img').hide();
	});

	function openmenu(oid) {
		if (lastmenuid != 0 && lastmenuid != oid){
			$('.moreactionlistmyord'+lastmenuid).slideUp('fast');
		}
		lastmenuid = oid;
		$('.moreactionlistmyord'+oid).slideToggle('fast');
	}

</script>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Returned Orders'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Manage Orders');?> </a></li>
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/returnedorders"><?php echo __d('merchant','Returned Orders');?> </a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Old Orders');?> </li>
      </ol>
  </div>
</div>

<div class="row">		
	<div class="col-md-12">

		<div class="card">  
			<div class="card-block">
     			<h4 class="text-themecolor m-b-0 m-t-0 clearfix"> <?php echo __d('merchant','Old Orders');?>
	     			<ul class="nav nav-pills" style="display: inline-flex; float: right;">
	        			<li class=" nav-item"> 
	        				<a href="<?php echo MERCHANT_URL; ?>/returnedorders" class="nav-link"><?php echo __d('merchant','View recent orders');?> </a> 
	        			</li>
	    			</ul>
	 			</h4>
	 	    	<hr/>

        		<!-- div class="markshiphead m-b-15" style="font-size:12px;">
    				<?php //echo __('My Sales');?>
    				<span class="myordertimeline"> (<?php //echo __('Sales History');?>)
    				</span>
    			</div -->

         		<div class="prvcmntcont m-t-30"> 
         			<?php  
         			if (count($orderDetails) > 0) { 

						echo '<span class="col-sm-3 p-l-0"> '.__d('merchant','Filters').' <!-- input type="text" id="ordersearchval" style="margin-top:7px;"  --> </span>
						<input type="text" id="sdate" class="form-control datepicker-autostart col-sm-3" placeholder="'.__d('merchant','Start Date').'" style="margin-top:7px;color:#555555! important;">
						<input type="text" id="edate" class="form-control datepicker-autoend col-sm-3" placeholder="'.__d('merchant','End Date').'" style="margin-top:7px;color:#555555! important;">
						<!-- button class="btn btn-success" onclick="returnedoldorder_search()" style="vertical-align:inherit;">Search</button>
						<a class="btn btn-info clearResult" href="'.MERCHANT_URL.'/returnedoldorders" style="vertical-align:inherit;">Reset</a -->';
					?>
						<!-- small class="form-control-feedback f4-error f4-error-daterror m-t-20 col-sm-3"></small --> 
					
		<div class="table-responsive">
        	<table id="myTable" class="table table-bordered table-striped">
        		<thead>
        			<tr>
        				<th class="p-l-10"><?php echo __('#');?></th>
	        			<th><?php echo __d('merchant','Order Id');?></th>
	        			<th class="producttd"><?php echo __d('merchant','Products');?></th>
					<th><?php echo __d('merchant','Color / Size');?></th>
	        			<th><?php echo __d('merchant','Total');?></th>
	        			<th><?php echo __d('merchant','Sale Date');?></th>
	        			<th><?php echo __d('merchant','Status');?></th>
	        			<th><?php echo __d('merchant','View'); ?></th>
	        			<th><?php echo __d('merchant','Options');?></th>
	        		</tr>
        		</thead>
        		<tbody class="prvcmtload">
        			<?php 
        			//if(count($_GET)==0){
        				if(!empty($orderDetails)){
        					$i = 0;
				foreach($orderDetails as $ky=>$orderDetail){
				
					$orderid = $orderDetail['orderid'];
					$usid = $loguser['id'];
						?>
					<tr>
						<td class="p-l-10"><?php echo ++$i; ?></td>
						<td><?php echo $orderid; ?></td>
						<?php 
						echo "<td class='producttd'>";
						foreach ($orderDetail['orderitems'] as $orderItem){
							echo "<div class='myorderpro'><div class='myorderproitm'><a href=".MERCHANT_URL."/selleritemview/".$orderItem['itemid'].">".$orderItem['quantity']." x ".$orderItem['itemname']."</a></div>
								<div class='myorderpropri'>".$orderItem['cSymbol'].$orderItem['price']."</div></div>";
						}
						echo "</td>";?>
						<td><?php if(!empty($orderItem['size'])){
							echo $orderItem['size'];
							} else {
							echo 'N/A';
							} ?></td>
						<td style="text-align:center;"><?php echo $orderItem['cSymbol'].$orderDetail['price'] ?></td>
						<td><?php echo date('m/d/Y',$orderDetail['saledate']); ?></td>
						<?php 
							if ($orderDetail['status'] != '' && $orderDetail['status'] != 'Pending' && $orderDetail['status'] != 'Paid' && $orderDetail['status'] != 'Delivered'){
								$orderStatusCurrent = $orderDetail['status'];
								$statusColor = "#25A525";
							}elseif ($orderDetail['status'] != 'Paid' && $orderDetail['status'] != 'Delivered'){
								$orderStatusCurrent = "Pending";
								$statusColor = "#A52525";
							}else {
								$orderStatusCurrent = "Delivered";
								$statusColor = "#2525A5";
							}?>
						<td class="status<?php echo $orderid; ?>" style="width: 70px;color:<?php echo $statusColor; ?>;"><?php 
							echo __d('merchant',$orderStatusCurrent);
							?></td>
						<?php
							echo '<td>
				<a class="viewitem" href="'.MERCHANT_URL.'/viewreturn/'.$orderid.'" ><span class="btn btn-success">
				<i class="fa fa-search-plus"></i></span>
				</a></td>';
				?>
						<td class="lastmoreoptiontd" style="width:140px !important;">
							<div class="moreactionmyord">
								<span class="moreactions" style="cursor: pointer;" onclick="openmenu('<?php echo $orderid; ?>');">
								<?php echo __d('merchant','Actions'); ?><i class="fa fa-angle-down m-l-10"></i>
								</span>
								<div class="moreactionlistmyord moreactionlistmyord<?php echo $orderid; ?>">
									<ul class="leftcell list-unstyled m-0">
										
										<li class="moreactionsli curpoint" onclick="showInvoicePopup('<?php echo $orderid; ?>')"><?php echo __d('merchant','View Invoice');?>
											<img class="inv-loader-<?php echo $orderid; ?>" src="<?php echo SITE_URL; ?>images/loading.gif" style="display: none; float: right; width: 12px; padding-top: 6px;">
										</li>
										<?php 
										if ($orderDetail['status'] == 'Delivered' && $orderDetail['commentcount']>0 || $orderDetail['status'] == 'Paid' && $orderDetail['commentcount']>0)
										{
										?>										
										<li class="moreactionsli curpoint" onclick="markprocess('<?php echo $orderid; ?>','ContactBuyer')"><?php echo __d('merchant','View Conversation');?></li>
										<?php
										}
										else if ($orderDetail['status'] == 'Delivered' && $orderDetail['commentcount']==0 || $orderDetail['status']=='Paid' && $orderDetail['commentcount']==0)
										{
										}
										else
										{
										?>
										<li class="moreactionsli curpoint" onclick="markprocess('<?php echo $orderid; ?>','ContactBuyer')"><?php echo __d('merchant','Contact Buyer');?></li>										
										<?php
										}
										?>							
									</ul>
								</div>
							</div>
						</td>
					</tr>
							
				<?php
				} }?>
        		</tbody>
        	</table>
        	</div>
</div>
       
        			<?php } else{
        					echo "<div class='noordercmnt m-t-30 m-b-30' style='text-align:center;'> " ?><?php echo __d('merchant','No Orders Available');echo "</div>";
        					echo "</div>";
        				} ?>

		</div>	
	</div>

</div>
</div>			

<div id="invoice-popup-overlay">
	<div class="invoice-popup">
	</div>
</div>

<style>
.producttd {
	width: 150px !important;
	word-break: break-all !important;
}
.myorderpropri{
	margin-top: 10px !important;
}
.card .card-block .text-themecolor ul.nav-pills>li>a
{
    padding:0px 15px;
    font-size: 14px;
}
.moreactionlistmyord {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.08);
    font-size: 13px;
    position: absolute;
    z-index: 10;
    padding: 0px !important;
    max-width: 200px;
    min-width: 125px;
    display: none;
}
.moreactionlistmyord li:hover {
    background: #f6f6f6;
}
.moreactionlistmyord li {
    padding: 4px 10px;
    cursor: pointer;
    list-style: outside none none;
}
.moreactionlistmyord li + li {
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

</style>

<script>
$.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        var min = $('#sdate').datepicker("getDate");
        var max = $('#edate').datepicker("getDate");
        var startDate = new Date(data[5]);
        if (min == null && max == null) { return true; }
        if (min == null && startDate <= max) { return true;}
        if(max == null && startDate >= min) {return true;}
        if (startDate <= max && startDate >= min) { return true; }
        return false;
    }
  );


  $("#sdate, #edate").datepicker({ 
    onSelect: function () { 
        table.draw(); 
    }, 
    format: 'mm/dd/yyyy', 
    todayHighlight: true,
    clearBtn: true });

  var table = $('#myTable').DataTable({
      dom: 'Bfrtip'
  });

  $('#sdate, #edate').change(function () {
      table.draw();
  });
</script>

