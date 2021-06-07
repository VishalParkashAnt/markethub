<body class="">
<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Commission'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	admin/viewcommission"><?php echo __d('admin', 'Commission'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Add Commission'); ?></li>
                 </ol>
         </div>
    </div>
</div>
 	<?php
  //echo $defaultCurrencySymbol['currency_symbol']; die;
            echo $this->Form->create('commision', array( 'onsubmit' => 'return commisionRange();'));
            ?>

	<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Add Commission'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                     <!--    <div class="row">
                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Apply To</label>

                                                        <select name ="applyto" class="form-control custom-select">
                                                            <option value="Seller"><?php echo __d('admin', 'Seller'); ?></option>
                                                        </select>

                                                </div>
                                            </div>
                                        </div>   -->
                                      <!--  <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label" id="commission_type" name="commission_type"><?php echo __d('admin', 'Commission Type'); ?></label>

                                                        <select class="form-control custom-select" name="commission_type">
                                                          <option value='%'>%</option>
                                                           <option value="<?php echo $defaultCurrencySymbol['currency_symbol']; ?>"><?php echo $defaultCurrencySymbol['currency_symbol']; ?></option>
                                                        </select>

                                                </div>
                                            </div></div>-->
                                            <?php
     echo $this->Form->input('applyto',array('type'=>'hidden','id'=>'applyto','value'=>'Seller','class'=>'form-control','data-role'=>'none','name'=>'applyto'));
     echo $this->Form->input('commission_type',array('type'=>'hidden','id'=>'commission_type','value'=>'%','class'=>'form-control','data-role'=>'none','name'=>'commission_type'));
          echo ' <div class="row">
                        <div class="col-md-6">
                                                <div class="form-group">';
            echo $this->Form->input('min_range',array('type'=>'text','label'=>__d('admin', 'Min Range in ').$defaultCurrencySymbol['currency_symbol'],'id'=>'minrange','class'=>'form-control','data-role'=>'none','name'=>'start_range'));
            echo '</div></div></div>';
             echo ' <div class="row">
                        <div class="col-md-6">
                                                <div class="form-group">';
                    echo $this->Form->input('max_range',array('type'=>'text','label'=>__d('admin', 'Max Range in ').$defaultCurrencySymbol['currency_symbol'],'id'=>'maxrange','class'=>'form-control','data-role'=>'none','name'=>'end_range'));
                      echo '</div></div></div>';
                     echo ' <div class="row">
                        <div class="col-md-6">
                                                <div class="form-group">';
                    echo $this->Form->input('commission_amount',array('type'=>'text','label'=>__d('admin', 'Commission Amount in %'),'value'=>'','class'=>'form-control','id'=>'commission','data-role'=>'none','name'=>'commission_amount'));
                      echo '</div></div></div>';

           ?>



            <div class="row">
                <div class="col-md-6">
        <label><?php echo __d('admin', 'Commission Details'); ?></label>
                  <div class="form-group">

            <textarea rows="5" cols="20" name="commissionDetails" id="commissionDetails" value="" class="form-control"></textarea><label></label></div></div></div>
              </div>    </div> <div class="col-lg-12"> <div class="form-group">
    <!--span style="color:red;"> *</span-->
        <input class="btn btn-info" type="submit" value="<?php echo __d('admin', 'Save'); ?>"/>
        <div id="commerr" class="trn" style="font-size:13px;color:red;">

</form>

                    </div>
                </div>

            </div>

                    </div>
                </div>

            </div>

                    </div>
