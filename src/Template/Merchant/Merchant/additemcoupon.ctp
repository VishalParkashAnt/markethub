<?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
<?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Item Coupons'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Coupons'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Manage Coupons'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Item Coupons'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
                <div class="card-block">
                    <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Item Coupons'); ?></h4>
                    <hr>
                    <div class="col-md-6 col-sm-12 ">

                        <?php echo $this->Form->Create('additemcoupon',array('url'=>array('controller' => '/','action' => '/additemcoupon/'.$id),'name'=>'additemcoupon','id'=>'additemcoupon'));

                        if($sellercoupon['couponcode']!="")
                            $disabled = "disabled";
                        else
                            $disabled = "";

                        ?>


                            <div class="form-group clearfix">
                                <label><?php echo __d('merchant','Coupon Code'); ?> </label>

                                <input id="couponcodes" name="code" type="text" class="form-control" placeholder="" value="<?php echo $sellercoupon['couponcode'];?>" <?php echo $disabled;?> > 

                                <?php if($sellercoupon['couponcode']==""){?>
                                    <button type="button" id="generate_coupon" class="btn btn-rounded btn-sm btn-info m-t-15" style="float:right;"> <?php echo __d('merchant','Generate Code'); ?> </button>
                                <?php } ?>

                                <small class="trn form-control-feedback f4-error f4-error-couponcodes"></small> 
                                
                            </div>

                            <div class="form-group">
                                <label><?php echo __d('merchant','Coupon Usage Count'); ?> </label>
                                <input id="couponrange" type="text" class="form-control" placeholder="" name="range" value="<?php echo $sellercoupon['totalrange']; ?>" maxlength="4"> 
                                <small class="trn form-control-feedback f4-error f4-error-couponrange"></small> 
                            </div>

                            <div class="form-group">
                                <label><?php echo __d('merchant','Start Date'); ?> </label>
                                <input id="dealstart" name="fromdate" type="text" class="form-control datepicker-autostart" placeholder="MM/DD/YYYY" value="<?php echo $sellercoupon['validfrom']; ?>">
                                <small class="trn form-control-feedback f4-error f4-error-dealstart"></small> 
                            </div>

                            <div class="form-group">
                                <label><?php echo __d('merchant','End Date'); ?> </label>
                                <input id="dealend" name="enddate" type="text" class="form-control datepicker-autoclose" placeholder="MM/DD/YYYY" value="<?php echo $sellercoupon['validto']; ?>">
                                <small class="trn form-control-feedback f4-error f4-error-dealend"></small> 
                            </div>

                            <div class="form-group">
                                <label><?php echo __d('merchant','Discount Percentage'); ?> (%) </label>
                                <input  id='couponamounts' name="amount" maxlength='3' type="text" class="form-control" placeholder="" value="<?php echo $sellercoupon['couponpercentage']; ?>">
                                <small class="trn form-control-feedback f4-error f4-error-couponamounts"></small> 
                            </div>

                             <small class="trn form-control-feedback f4-error f4-error-couponerror" style="margin-bottom: 15px;"></small>

                            <div class="button-group">
                                <button class="btn btn-rounded btn-info" type="submit"><i class="fa fa-check"></i>
                                <?php echo __d('merchant','Save'); ?></button>
                                <!--button class="btn btn-rounded btn-danger" type="button">Cancel</button -->
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
        </div>

    </div>
</div>

<script>
    jQuery('.datepicker-autostart').datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        todayHighlight: true
    });
    jQuery('.datepicker-autoclose').datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        todayHighlight: true
        //startDate: truncateDate(new Date())
    });

    function truncateDate(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }
</script>
