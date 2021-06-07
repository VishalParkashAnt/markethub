<?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
<?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Shipping Details'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Add Shipping Details'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
         <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Add Shipping Details'); ?></h4>
         <hr/>
        
         <div class="table-responsive nofilter">
          <?php 
            $shipmentDate = '';
            $trackid = '';
            $couriername = '';
            $courierservice = '';
            $notes = '';
            if (!empty($trackingModel)){
              $title = __('Edit Shipping Details');
              echo '<input type="hidden" id="trackid" value="'.$trackingModel['id'].'" />';
              $shipmentDate = $trackingModel['shippingdate'];
              $trackid = $trackingModel['trackingid'];
              $couriername = $trackingModel['couriername'];
              $courierservice = $trackingModel['courierservice'];
              $notes = $trackingModel['notes'];
              
            }else{
              $title = __('Add Shipping Details');
              echo '<input type="hidden" id="trackid" value="0" />';
            }
          ?>
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
            <?php 
              if (!empty($orderModel['status'])){
                echo __d('merchant',$orderModel['status']); 
                echo '<input type="hidden" id="hiddenorderstatus" value="'.$orderModel['status'].'" />';
              }else{
                echo __d('merchant','Pending');
                echo '<input type="hidden" id="hiddenorderstatus" value="Pending" />';
              }
            ?>
          </div>

         <div class="markshipbuyeraddr m-t-20">
            <h5 class="text-themecolor m-b-20"><?php echo __d('merchant','Buyer Details');?></h5>
            
            <div class="markshipbuyerdetails">
              <label class="control-label text-left"><?php echo __d('merchant','Name');?></label>
              <span style="margin:0px 10px;"> : </span>
           <input type="hidden" id="hiddenorderid" value="<?php echo $orderModel['orderid']; ?>" />
            <input type="hidden" id="hiddenbuyeremail" value="<?php echo $userModel['email']; ?>" />
            <input type="hidden" id="hiddenbuyername" value="<?php echo $userModel['first_name']; ?>" />   <span>
                      <?php echo $userModel['first_name']; ?>
              </span>
            </div>

            <div>
              <label class="control-label text-left">
                <?php echo __d('merchant','Address');?>
              </label>
              <span style="margin:0px 10px;"> : </span>
              <div class="inblock">
                <?php 
                  $buyershipaddr = '';
                  if (!empty($shippingModel['address1']))
                     $buyershipaddr .= $shippingModel['address1'].",<br />";
                  if (!empty($shippingModel['address2'])){
                    $buyershipaddr .= $shippingModel['address2'].",<br />";
                  }
                  if (!empty($shippingModel['city']))
                     $buyershipaddr .= $shippingModel['city'];
                  if (!empty($shippingModel['zipcode']))
                     $buyershipaddr .= " - ".$shippingModel['zipcode'].",<br />";
                  if (!empty($shippingModel['state']))
                     $buyershipaddr .= $shippingModel['state'].",<br />";
                  if (!empty($shippingModel['country']))
                  $buyershipaddr .= $shippingModel['country'].",<br />";
                  if (!empty($shippingModel['phone']))
                     $buyershipaddr .= "Ph. : ".$shippingModel['phone'].".<br />";
                  
                  echo $buyershipaddr;
              
                  echo '<input type="hidden" id="hiddenbuyeraddress" value="'.$buyershipaddr.'" />';
                ?>
              </div>
            </div>

        	   <div class="markshipemailcont m-t-30">
               <label class="control-label text-left">
                  <?php echo __d('merchant','Shipment Date');?>
               </label>

        		   <div class="trackinginput m-b-20">
        			   <input type="text" class="form-control col-md-6" name="shipmentdate" id="shipmentdate" value="<?php if($shipmentDate != "")echo date('m/d/Y',$shipmentDate); ?>"/>
        			  <small class="trn form-control-feedback f4-error f4-error-shipmentdate"></small> 
                     
        		   </div>

               <label class="control-label text-left">
                  <?php echo __d('merchant','Shipping Method');?>
               </label>
           		<div class="trackinginput m-b-20">
           			<input type="text" name="couriername" class="form-control col-md-3" id="couriername" value="<?php echo $couriername; ?>" placeholder="<?php echo __d('merchant','Enter the Courier'); ?>"/>
           			<input type="text" name="courierservice" class="form-control col-md-3" id="courierservice" value="<?php echo $courierservice; ?>" placeholder="<?php echo __d('merchant','Shipping Service'); ?>"/>
           			<small class="trn form-control-feedback f4-error f4-error-couriername"></small> 
           		</div>

               <label class="control-label text-left">
                  <?php echo __d('merchant','Tracking Id');?>
               </label>
           		<div class="trackinginput m-b-20">
           			<input type="text" name="trackingid" class="form-control col-md-6" id="trackingid" value="<?php echo $trackid; ?>"/>
           			<small class="trn form-control-feedback f4-error f4-error-trackingid"></small> 
           		</div>


               <label class="control-label trakinglabel text-left">
                  <?php echo __d('merchant','Additional Notes');?>
               </label>

           		<div class="trackinginput m-b-20">
           			<textarea rows="10" cols="15" id="notes" class="form-control col-md-6" maxlength="250"><?php echo $notes; ?></textarea>
                <small class="trn form-control-feedback f4-error f4-error-notes"></small>
           		</div>

           		<div class="markshipbtn m-b-20">
           			<button class="markshippedbtn btn btn-info" id="savebtn" onclick="return merchantaddtracking();"><?php echo __d('merchant','Save');?></button>
           			<a href="javascript:void(0);" onclick="history.back();">
           				<button class="markshippedbtn btn btn-danger" style="margin-right:0;"><?php echo __d('merchant','Cancel');?></button>
           			</a>
           		</div>

         	</div>
           	<input type="hidden" id="hiddenorderid" value="<?php echo $orderModel['orderid']; ?>" />
           	<input type="hidden" id="hiddenbuyeremail" value="<?php echo $userModel['email']; ?>" />
           	<input type="hidden" id="hiddenbuyername" value="<?php echo $userModel['first_name']; ?>" />
         </div>	
	   </div>
	
      </div>	
   </div>			
   </div>
   </div>

<script type="text/javascript">

jQuery('#shipmentdate').datepicker({
     format: 'mm/dd/yyyy',
     autoclose: true,
     todayHighlight: true
     //startDate: truncateDate(new Date())
 });

 function truncateDate(date) {
     return new Date(date.getFullYear(), date.getMonth(), date.getDate());
 }

$(document).ready(function(){
   $( "#shipmentdate" ).on("keypress", function(){
      return false;
   });
});
</script>

<style>
label { font-weight: 400; }
</style>

