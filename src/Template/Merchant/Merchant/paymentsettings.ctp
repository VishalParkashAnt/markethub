<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Payment Settings'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Payment Settings'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
                <div class="card-block">
                    <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Payment Settings'); ?></h4>
                    <hr>
                    <div class="col-md-8 col-sm-12 ">

                        <?php echo $this->Form->Create('paymentsettings',array('url'=>array('controller' => '/','action' => '/paymentsettings'),'name'=>'paymentsettings','id'=>'paymentsettings'));
                        ?>

                        <?php /*
                            $paypalid = strtolower($shop_datas['braintree_type']); 
                            if($paypalid == "live"){
                                $live = "checked";
                                $sandbox = "";
                            } else {
                                $live = "";
                                $sandbox = "checked";
                            }
                        */

                        ?>
                            <!-- div class="form-group">
                                <label class="control-label text-left">Braintree Type</label>
                                <div>
                                    <label class="custom-control custom-radio">
                                        <input id="paypaltype" name="paypaltype" type="radio" value="live" <?php echo $live; ?> class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Live</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="paypaltype" name="paypaltype" type="radio" value="sandbox" <?php echo $sandbox; ?>  class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Sandbox</span>
                                    </label>
                                       
                                </div>
                            </div -->
                            <?php if(!empty($country_datas['country'])) { ?>
                            <div class="form-group">
                                <label> <?php echo __d('merchant','Default Country and Currency'); ?> </label>
                                <small class="form-control-feedback f4-success" style="font-size:14px;">
                                    <?php echo $country_datas['country']." - ".$shop_datas['currency']." (".$shop_datas['currencysymbol'].")"; ?>                      
                                </small>
                                <small class="form-control-feedback f4-success">
                                    <?php echo __d('merchant','Note: Please make sure the given Braintree Id was pointed with chosen currency'); ?>                      
                                </small>
                            <?php } ?>
                                
                            </div>
                            <div class="form-group">
                                <label> <?php echo __d('merchant','Currency Merchant Id'); ?> </label>
                                <input  id='braintreeid' name="braintreeid" type="text" class="form-control" placeholder="" value="<?php echo $shop_datas['braintree_id']; ?>">
                                <small class="trn form-control-feedback f4-error f4-error-braintreeid"></small> 
                            </div>

                            <div class="form-group">
                                <label><?php echo __d('merchant','Braintree Merchant account Id'); ?> </label>
                                <input id='merchantid' name="merchantid" type="text" class="form-control" placeholder="" value="<?php echo $shop_datas['merchant_id']; ?>">
                                <small class="trn form-control-feedback f4-error f4-error-merchantid"></small> 
                            </div>

                            <div class="form-group">
                                <label><?php echo __d('merchant','Braintree Public Key'); ?> </label>
                                <input id='publickey' name="publickey" type="text" class="form-control" placeholder="" value="<?php echo $shop_datas['braintree_publickey']; ?>">
                                <small class="trn form-control-feedback f4-error f4-error-publickey"></small> 
                            </div>

                            <div class="form-group">
                                <label><?php echo __d('merchant','Braintree Private Key'); ?> </label>
                                <input id='privatekey' name="privatekey" type="text" class="form-control" placeholder="" value="<?php echo $shop_datas['braintree_privatekey']; ?>">
                                <small class="trn form-control-feedback f4-error f4-error-privatekey"></small> 
                            </div>

                            <div class="button-group">
                                <button class="btn btn-rounded btn-info" type="submit"><i class="fa fa-check"></i>
                                <?php echo __d('merchant','Save'); ?></button>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
        </div>

    </div>
</div>

