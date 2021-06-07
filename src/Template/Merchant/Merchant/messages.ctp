<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Seller Conversation'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Messages'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Seller Conversation'); ?></li>

      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <!-- h4 class="card-title">Data Table</h4 -->
                <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Contact Seller Conversations'); ?></h4>
                <hr/>
                <div class="table-responsive nofilter">

                	<?php if (!empty($messageModel)) { ?>
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
			        			<th><?php echo __d('merchant','From');?></th>
			        			<th><?php echo __d('merchant','To');?></th>
			        			<th><?php echo __d('merchant','Item');?></th>
			        			<th><?php echo __d('merchant','Subject');?></th>
			        			<th><?php echo __d('merchant','Actions');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach($messageModel as $ky=>$message){
                            	$csId = $message['csid'];
                            	$item = $message['item'];
                            	$itemid = $message['itemid'];
                            	$itemurl = $message['itemurl'];
                            ?>
                        		<tr>
                        			<td><?php echo $message['from']; ?></td>
                        			<td><?php echo $message['to']; ?></td>
                        			<td><a href="<?php echo MERCHANT_URL.'/selleritemview/'.$itemid; ?>"><?php echo $item; ?></a></td>
                        			<td><?php echo $message['subject']; ?></td>
                        			<td><a href="<?php echo MERCHANT_URL.'/viewmessage/'.$csId; ?>"><?php echo __('View');?></a></td>
                        		</tr>
                            			
                            <?php
                            		
                            }  ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                	<h6 class="card-title text-center"><?php echo __d('merchant','No Messages Found');?></h6>
                <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/*$(document).ready(function() {
$('#myTable').DataTable();
});*/


$('#myTable').DataTable({
        dom: 'Bfrtip'
    });
</script>
