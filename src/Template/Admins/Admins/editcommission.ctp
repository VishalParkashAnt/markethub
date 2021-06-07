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
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>admin/viewcommission"><?php echo __d('admin', 'Commission'); ?></a></li>
                     <li class="breadcrumb-item active"><a href="<?php echo $baseurl; ?>admin/commission"><?php echo __d('admin', 'Add Commission'); ?></a></li>
                 </ol>
         </div>
    </div>
</div>
<?php


//echo 'hi'.$defaultCurrencySymbol['currency_symbol'];  die;
        echo $this->Form->create('commision', array( 'onsubmit' => 'return editcommisionRange('.$getcommivalues['id'].');'), array('url' => array('controller' => '/', 'action' => '/editcommission/'.$getcommivalues['id'])));
      ?>



    <div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Edit Commission'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                   <!--     <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
        <label class="control-label"><?php echo __d('admin', 'Apply To'); ?></label>

        <select name ="applyto" class="form-control custom-select">
            <option value="Seller"><?php echo __d('admin', 'Seller'); ?></option>
        </select></div>
                          </div>
                          </div>

        <div class="row">
        <div class="col-md-6">
        <div class="form-group">
        <label class="control-label" id="commission_type" name="commission_type"><?php echo __d('admin', 'Commission Type'); ?></label>
         <select class="form-control custom-select" name="commission_type">
        <?php

        if($getcommivalues['type']=='%'){
        echo "<option value='%'  selected= 'selected' >%</option>";
        echo '<option value="$">$</option>';
        }elseif($getcommivalues['type']=='$'){
        echo "<option value='%' >%</option>";
        echo '<option value="'.$defaultCurrencySymbol['currency_symbol'].'"  selected= "selected" >'.$defaultCurrencySymbol['currency_symbol'].'</option>';
        }
        ?>
          </select>
        </label>
        </div> </div>
        </div>-->

         <?php
     echo $this->Form->input('applyto',array('type'=>'hidden','id'=>'applyto','value'=>'Seller','class'=>'form-control','data-role'=>'none','name'=>'applyto'));
     echo $this->Form->input('commission_type',array('type'=>'hidden','id'=>'commission_type','value'=>$getcommivalues["type"],'class'=>'form-control','data-role'=>'none','name'=>'commission_type'));

          echo ' <div class="row">
                        <div class="col-md-6">
                                                <div class="form-group">';
          echo $this->Form->input('min_range',array('type'=>'text','label'=>__d('admin','Min Range in').$defaultCurrencySymbol['currency_symbol'],'id'=>'minrange','class'=>'form-control','data-role'=>'none','name'=>'start_range','value'=>$getcommivalues["min_value"]));
           echo '</div></div></div>';
           echo ' <div class="row">
                        <div class="col-md-6">
                                                <div class="form-group">';
                    echo $this->Form->input('max_range',array('type'=>'text','label'=>__d('admin','Max Range in').$defaultCurrencySymbol['currency_symbol'],'id'=>'maxrange','class'=>'form-control','data-role'=>'none','name'=>'end_range','value'=>$getcommivalues["max_value"]));
                     echo '</div></div></div>';
                     echo ' <div class="row">
                        <div class="col-md-6">
                                                <div class="form-group">';
                    echo $this->Form->input('commission_amount',array('type'=>'text','label'=>__d('admin','Commission Amount in %'),'value'=>'','class'=>'form-control','data-role'=>'none','name'=>'commission_amount','value'=>$getcommivalues["amount"],'id'=>'commission'));
                     echo '</div></div></div>';


           ?>



       <div class="row">
                <div class="col-md-6">
        <label><?php echo __d('admin', 'Commission Details'); ?></label>
                  <div class="form-group">

         <textarea rows="5" cols="20" name="commissionDetails" id="commissionDetails" value="" class="form-control"><?php echo $getcommivalues["commission_details"]; ?></textarea>
     <label></label></div></div></div>


  </div>    </div> <div class="col-lg-12"> <div class="form-group">

    <input class="btn btn-info" type="submit" value="<?php echo __d('admin', 'Save'); ?>"/>
    <div id="commerr" style="font-size:13px;color:red;" class="trn"></div>

</form>

          </div>
        </div>
      </div>







     </div>

  </div>

</div>

