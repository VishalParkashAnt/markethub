<body class=""> 
<?php
   use Cake\Routing\Router;
$baseurl = Router::url('/');

?>
   
   
 <div class="content">
 	 <div class="row page-titles">
        <div class="col-md-6 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Payment Gateway'); ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
             <li class="breadcrumb-item active"><?php echo __d('admin', 'Payment Gateway'); ?></li>
         </ol>
        </div>
         </div>
 <?php echo $this->Form->Create('PaypalGateway',array('url'=>array('controller'=>'/','action'=>'/admins/stripesetup'),'onsubmit'=>'return stripechk();')); ?>
            
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
             <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Stripe'); ?></h4>
            </div>
        <div class="card-block">
            <div class="form-body">
                <div class="form-group">
                                                   
<?php
if(empty($paystatus['stripe_type'])){
                $status = 'sandbox';
            }else{
                $status = $paystatus['stripe_type'];
            }
            if($paystatus['stripe_type']=="sandbox")
            {
            echo '<h4 class="card-title">'.__d('admin', 'Type').'</h4>
                    <div class="col-md-6">
                    <div class="form-group">
                    <div class="form-check">
                    <label class="custom-control custom-radio">
                    <input id="StripeGatewayTypeStripe" name="type" type="radio" class="custom-control-input" value="stripe">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">'.__d('admin', 'Stripe(Live)').'</span>
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
                                        </div>';
            }
            else
            {
            echo '<h4 class="card-title">'.__d('admin', 'Type').'</h4>
                    <div class="col-md-6">
                    <div class="form-group">
                    <div class="form-check">
                    <label class="custom-control custom-radio">
                    <input id="StripeGatewayTypeStripe" name="type" type="radio" class="custom-control-input" value="stripe" checked="checked">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">'.__d('admin', 'Stripe(Live)').'</span>
                    </label>
                    <label class="custom-control custom-radio">
                    <input id="StripeGatewayTypeSandbox" name="type" type="radio" class="custom-control-input" value="sandbox" >
                                                          
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">'.__d('admin', 'Sandbox(Test)').'</span>
                                                        </label>
                                                    </div>
                                                </div>';
            }
           
            echo $this->Form->input('publish_key',array('type'=>'text','label'=>__d('admin', 'Stripe Publishable Key'),'id'=>'stripe_publish','class'=>'form-control','data-role'=>'none','value'=>$paystatus['stripe_publish']));
            echo $this->Form->input('secret_key',array('type'=>'text','label'=>__d('admin', 'Stripe Secret Key'),'id'=>'stripe_secret','class'=>'form-control','data-role'=>'none','value'=>$paystatus['stripe_secret']));
               echo '</div> </div><div class="col-lg-12"> <div class="form-group">';
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
                                            </div>
                                           
                                        </div>
 			
			
  
  
  		