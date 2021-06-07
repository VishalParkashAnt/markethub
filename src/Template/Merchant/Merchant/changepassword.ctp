<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Change Password'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Change Password'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
                <div class="card-block">
                    <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Change Password'); ?></h4>
                    <hr>
                    <div class="col-md-6 col-sm-12 ">

                        <?php echo $this->Form->Create('password',array('url'=>array('controller' => '/','action' => '/changepassword'),'name'=>'fpassword','id'=>'changepassword'));
                        ?>
 
                        <div class="form-group">
                                <label> <?php echo __d('merchant','Old Password'); ?> </label>
                                <input  id='oldpassword' name="oldpassword" type="password" class="form-control" placeholder="" value="">
                                <small class="trn form-control-feedback f4-error f4-error-oldpassword"></small> 
                            </div>

                            <div class="form-group">
                                <label> <?php echo __d('merchant','New Password'); ?> </label>
                                <input id='newpassword' name="newpassword" type="password" class="form-control" placeholder="" value="">
                                <small class="trn form-control-feedback f4-error f4-error-newpassword"></small> 
                            </div>

                            <div class="form-group">
                                <label><?php echo __d('merchant','Confirm Password'); ?></label>
                                <input id='cpassword' name="cpassword" type="password" class="form-control" placeholder="" value="">
                                <small class="trn form-control-feedback f4-error f4-error-cpassword"></small> 
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

