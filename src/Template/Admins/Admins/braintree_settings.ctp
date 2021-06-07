<body class="">
<?php
   use Cake\Routing\Router;
$baseurl = Router::url('/');

?>


 <div class="content">
 	 <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Payment Gateway'); ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
             <li class="breadcrumb-item active"><?php echo __d('admin', 'Payment Gateway'); ?></li>
         </ol>
        </div>
         </div>


</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
             <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Braintree'); ?></h4>
            </div>
        <div class="card-block">
            <div class="form-body">
                <div class="form-group">
                    <?php echo '<h4 class="card-title">'.__d('user', 'Account').'</h4>'; ?>
                    <form method="post" action="<?php echo SITE_URL.'braintree_settings/1';?>" onsubmit="return bt_account_update();">
                        <?php echo '<div class="col-md-6">';
                            echo $this->Form->input('Currency Code',array('options' => array('' => __d('admin', 'Select Currency'),'AED'=>'AED','ALL' => 'ALL','AMD' => 'AMD','AOA'=>'AOA','ARS'=>'ARS','AUD' => 'AUD','AWG'=>'AWG','AZN'=>'AZN','BAM'=>'BAM','BBD'=>'BBD','BDT'=>'BDT','BGN'=>'BGN','BHD'=>'BHD','BIF'=>'BIF','BMD'=>'BMD','BND'=>'BND','BOB'=>'BOB','BRL' => 'BRL','BSD'=>'BSD','BWP'=>'BWP','BYN'=>'BYN','BZD'=>'BZD','CAD' => 'CAD','CHF'=>'CHF','CLP'=>'CLP','CNY'=>'CNY','COP'=>'COP','CRC'=>'CRC','CUP'=>'CUP','CVE'=>'CVE', 'CZK' => 'CZK','DJF'=>'DJF','DKK' => 'DKK','DOP'=>'DOP','DZD'=>'DZD','EGP'=>'EGP','ERN'=>'ERN','ETB'=>'ETB', 'EUR' => 'EUR','FJD'=>'FJD','FKP'=>'FKP','GBP'=>'GBP','GEL'=>'GEL','GHS'=>'GHS','GIP'=>'GIP','GMD'=>'GMD','GNF'=>'GNF','GTQ'=>'GTQ','GYD'=>'GYD','HKD' => 'HKD','HNL'=>'HNL','HRK'=>'HRK','HTG'=>'HTG', 'HUF' => 'HUF','IDR'=>'IDR', 'ILS' => 'ILS','INR'=>'INR','IRR'=>'IRR','ISK'=>'ISK','JMD'=>'JMD', 'JPY' => 'JPY','KES'=>'KES','KGS'=>'KGS','KHR'=>'KHR','KMF'=>'KMF','KRW'=>'KRW','KYD'=>'KYD','KZT'=>'KZT','LAK'=>'LAK','LBP'=>'LBP','LKR'=>'LKR','LRD'=>'LRD','LSL'=>'LSL','MAD'=>'MAD','MDL'=>'MDL','MKD'=>'MKD','MMK'=>'MMK','MNT'=>'MNT','MOP'=>'MOP','MUR'=>'MUR','MVR'=>'MVR','MWK'=>'MWK','MXN'=>'MXN', 'MYR' => 'MYR','NAD'=>'NAD','NGN'=>'NGN','NIO'=>'NIO','NOK' => 'NOK','NPR'=>'NPR', 'NZD' => 'NZD', 'PHP' => 'PHP', 'PLN' => 'PLN', 'GBP' => 'GBP', 'RUB' => 'RUB', 'SGD' => 'SGD', 'SEK' => 'SEK',  'TWD' => 'TWD', 'THB' => 'THB', 'TRY' => 'TRY', 'USD' => 'USD' ), 'id' => 'currency_code','name' => 'currency_code' ,'class'=> 'form-control','onchange' => 'currencyCode();','default'=> $braintree_setting_code));

                             echo $this->Form->input('merchant_account_id',array('type'=>'text','label'=>__d('admin', 'Braintree Merchant Account Id'),'id'=>'merchant_account_id','class'=>'form-control','name' => 'merchant_account_id','data-role'=>'none','value'=> $braintree_setting_data)); 

                            echo '</div> <div class="col-lg-12"> 
                                <div class="form-group">';
                            echo '<div id="accounterr_alrt" class="m-b-20 trn" style="font-size:13px;color:red;display:none;"></div>';
                            echo $this->Form->submit(__d('admin', 'Update'),array('div'=>false,'class'=>'btn btn-info'));

                            echo '</div> </div></div>';
                            echo $this->Form->end();

                        ?>
                </div>

                <div class="form-group m-t-40">
                    <form method="post" action="<?php echo SITE_URL.'braintree_settings/2';?>" onsubmit="return stripechk();">

                        <?php
                        if(empty($paystatus['type'])){
                                        $status = 'sandbox';
                        }else{
                            $status = $paystatus['type'];
                        }
                        if($paystatus['type']=="sandbox")
                        {
                            echo '<div id="braintree_sandbox"><h4 class="card-title">'.__d('admin', 'Type').'</h4>
                                <div class="col-md-6">
                                <div class="form-group">
                                <div class="form-check">
                                <label class="custom-control custom-radio">
                                <input id="StripeGatewayTypeStripe" name="type" type="radio" class="custom-control-input" value="braintree">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">'.__d('admin', 'Braintree(Live)').'</span>
                                </label>
                                <label class="custom-control custom-radio">
                                <input id="StripeGatewayTypeSandbox" name="type" type="radio" class="custom-control-input" value="sandbox"
                                                                        checked="checked">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">'.__d('admin', 'Sandbox(Test)').'</span>
                                </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div></div>';
                        }
                        else
                        {
                            echo '<div id="braintree_live"><h4 class="card-title">Type</h4>
                                <div class="col-md-6">
                                <div class="form-group">
                                <div class="form-check">
                                <label class="custom-control custom-radio">
                                <input id="StripeGatewayTypeStripe" name="type" type="radio" class="custom-control-input" value="braintree" checked="checked">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">'.__d('admin', 'Braintree(Live)').'</span>
                                </label>
                                <label class="custom-control custom-radio">
                                <input id="StripeGatewayTypeSandbox" name="type" type="radio" class="custom-control-input" value="sandbox" >

                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">'.__d('admin', 'Sandbox(Test)').'</span>
                                                                    </label>
                                                                </div>
                                                            </div></div>';
                        } ?>

                        <?php
                            echo '<div class="col-md-6">';
                            echo $this->Form->input('merchant_id',array('type'=>'text','label'=>__d('admin', 'Braintree Merchant Id'),'id'=>'merchant_id','class'=>'form-control','disabled' => 'disabled','name' => 'merchant_id','data-role'=>'none','value'=>$paystatus['merchant_id']));
                            echo $this->Form->input('publish_key',array('type'=>'text','label'=>__d('admin', 'Braintree Public Key'),'id'=>'braintree_public','class'=>'form-control','disabled' => 'disabled','name'=> 'public_key','data-role'=>'none','value'=>$paystatus['public_key']));
                            echo $this->Form->input('secret_key',array('type'=>'text','label'=>__d('admin', 'Braintree Private Key'),'id'=>'braintree_private','class'=>'form-control','disabled' => 'disabled','name'=> 'private_key','data-role'=>'none','value'=>$paystatus['private_key']));
                               echo '</div> <div class="col-lg-12"> <div class="form-group">';
                            echo $this->Form->submit(__d('admin', 'Update'),array('div'=>false,'class'=>'btn btn-info'));
                            echo '<span id="erralrt" style="font-size:13px;color:red;display:none;"></span> </div>
                                            </div>';
                    echo $this->Form->end();

                        ?>



                                                

                </div>

            </div>
        </div>

    </div>




            </div>
        </div>




