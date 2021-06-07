<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Newsletter'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo SITE_URL;?>/dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('admin', 'Newsletter'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('admin', 'Manage Newsletter'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
                <div class="card-block">
                    <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Newsletter'); ?></h4>
                    <hr>
                    <div class="col-md-12 col-sm-12 ">

                        <?php echo $this->Form->Create('managenewsletter',array('url'=>array('controller' => '/admins','action' => '/managenewsletter'),'name'=>'managenewsletter','id'=>'managenewsletter'));
                        ?>
                            
                            <div class="form-group">
                                <label> <?php echo __d('merchant', 'Mail Chimp API Key'); ?> </label>
                                <input  id='apikey' name="apikey" type="text" class="form-control" placeholder="" value="<?php echo $settings_datas['news_key']; ?>">
                                <small class="form-control-feedback f4-error f4-error-apikey"></small> 
                            </div>


                            <div class="button-group">
                                <button class="btn btn-rounded btn-info" onclick="validate_news()" ><i class="fa fa-check"></i>
                                <?php echo __d('admin', 'Send'); ?></button>
                            </div>



                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
        </div>

    </div>
</div>
<style type="text/css">
    label {
        font-weight: 400 !important;
    }
</style>
