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
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Payment Gateway'); ?></li>
                 </ol>
         </div>
    </div>
</div>
 	<?php echo $this->Form->Create('PaypalGateway',array('url'=>array('controller'=>'/','action'=>'/admins/pgsetup'),'onsubmit'=>'return paypalchk();')); ?>

	<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'PayPal'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                        <h4 class="card-title"><?php echo __d('admin', 'Paypal Payment Mode'); ?></h4>
                         <?php  if($paypalAdaptive['paymentMode']=="paypalnormal")
						{
							echo '<div class="col-md-6">
                                     <div class="form-group">
                                            <div class="form-check">
                                                <label class="custom-control custom-radio">
                                                <input type="radio" value="paypalnormal" checked="checked" onchange="paypalactive();" id="PaypalmodePaypalnormal" name="paypal_payment_mode" class="custom-control-input"
                                                            value="stripe">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">'.__d('admin', 'Paypal Normal').'</span></label>
                                                </div>
                                                </div>
                                            </div>
                                          
                                        </div>';
                                    }
								
						if(empty($paystatus['payment_type'])){
							$status = 'sandbox';
						}else{
							$status = $paystatus['payment_type'];
						}
						if($paystatus['payment_type']=="sandbox")
						{
							echo '<h4 class="card-title">'.__d('admin', 'Type').'</h4>
										<div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-check">
                                                 <label class="custom-control custom-radio">
                                                  <input type="radio" value="paypal" id="PaypalGatewayTypePaypal" name="type" class="custom-control-input"
                                                            >
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">'.__d('admin', 'Paypal(Live)').'</span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" value="sandbox" checked="checked" id="PaypalGatewayTypeSandbox" name="type" class="custom-control-input"
                                                            >
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">'.__d('admin', 'Sandbox(Test)').'</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>';
			}
			else if($paystatus['payment_type']=="paypal")
			{
			echo '<h4 class="card-title">'.__d('admin', 'Type').'</h4>
					<div class="col-md-6">
                        <div class="form-group">
                                                   
                         <div class="form-check">
                         <label class="custom-control custom-radio">
                         <input type="radio" value="paypal" id="PaypalGatewayTypePaypal" name="type" class="custom-control-input" checked="checked">
                                                            
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description">'.__d('admin', 'Paypal(Live)').'</span>
                               </label>
                           <label class="custom-control custom-radio">
                           <input type="radio" value="sandbox"  id="PaypalGatewayTypeSandbox" name="type" class="custom-control-input">
                                                            
                           <span class="custom-control-indicator"></span>
                           <span class="custom-control-description">'.__d('admin', 'Sandbox(Test)').'</span>
                                                        </label>
                                                    </div>
                                                </div>';
                                           
                }
				echo $this->Form->input('paypal_id',array('type'=>'text','label'=>__d('admin', 'Paypal Email Id'),'id'=>'paypal_id','name' => 'paypal_id','class'=>'form-control','data-role'=>'none','value'=>$paystatus['paypal_id']));
                echo '</div></div> <div class="col-lg-12"> <div class="form-group">';
				echo $this->Form->submit(__d('admin', 'Update'),array('div'=>false,'class'=>'btn btn-info'));
				echo '<span id="erralrt" style="font-size:13px;color:red;display:none;"></span>';
		echo $this->Form->end();

			 ?>

</div>
</div>
                                           
</div>

                                              </div>
                                            </div>
                                           
                                        </div>
                                           
                                          
                                      
                                                </div>
                                           