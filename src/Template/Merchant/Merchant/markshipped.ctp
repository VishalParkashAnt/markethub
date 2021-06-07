<?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
<?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
         <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Mark Shipped'); ?></h4>
         <hr/>
        
         <div class="table-responsive nofilter">
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
              if (!empty($orderModel['Orders']['status'])){
                echo __d('merchant',$orderModel['Orders']['status']); 
              }else{
                echo __d('merchant','Pending');
              }
            ?>
          </div>

         <div class="markshipbuyeraddr m-t-20">
            <h5 class="text-themecolor m-b-20"><?php echo __d('merchant','Buyer Details');?></h5>
            
            <div class="markshipbuyerdetails">
              <label class="control-label text-left"><?php echo __d('merchant','Name');?></label>
              <span style="margin:0px 10px;"> : </span>
              <span>
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
                  <?php echo __d('merchant','Subject');?>
               </label>

               <div class="trackinginput m-b-20">
                       <input type="text" class="form-control col-md-6" name="subject" id="emailsubject" value=""/>
                      <small class="trn form-control-feedback f4-error f4-error-emailsubject"></small> 
         
               </div>

               <label class="control-label trakinglabel text-left">
                  <?php echo __d('merchant','Message');?>
               </label>

                <div class="trackinginput m-b-20">
                        <textarea rows="10" cols="15" id="emailmessage" class="form-control col-md-6"></textarea>
                        <small class="trn form-control-feedback f4-error f4-error-emailmessage"></small> 
                </div>

                <div class="markshipbtn m-b-20">
                        <button class="markshippedbtn btn btn-info" onclick="return merchantmarkshipped();"><?php echo __d('merchant','Mark as Shipped');?></button>
                        <a href="<?php echo MERCHANT_URL; ?>/neworders">
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

<style>
label { font-weight: 400; }
</style>
