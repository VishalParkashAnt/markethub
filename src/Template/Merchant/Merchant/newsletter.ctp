<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Send Newsletter'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Newsletter'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Send Newsletter'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
                <div class="card-block">
                    <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Newsletter'); ?></h4>
                    <hr>
                    <div class="col-md-6 col-sm-12 ">

                        <?php echo $this->Form->Create('newsletter',array('url'=>array('controller' => '/','action' => '/newsletter'),'name'=>'newsletter','id'=>'newsletter' , 'onsubmit'=> 'return sendnewsletter()'));
                        ?>

                            <input type="hidden" id="nkey" value="<?php echo $shop_datas['news_key']; ?>">
                            <div class="form-group">
                                <label> <?php echo __d('merchant', 'Contact Group List'); ?> </label>
                                <select  id='listid' name="listname" class="form-control">
                                    <option value=""><?php echo __d('merchant','Choose an option'); ?></option>
                                    <?php if(count($result)>0)
                                    {
                                      foreach($result as $items)
                                      {
                                        echo '<option value="'.$items['id'].'">'.$items['name'].'</option>';
                                      }
                                    }
                                    ?>
                                </select>
                                <small class="trn form-control-feedback f4-error f4-error-listid"></small> 
                            </div>
                            <div class="form-group">
                                <label> <?php echo __d('merchant', 'Subject'); ?> </label>
                                <input  id='subject' name="subject" type="text" class="form-control" placeholder="" value="">
                                <small class="trn form-control-feedback f4-error f4-error-subject"></small> 
                            </div>

                            <div class="form-group">
                                <label> <?php echo __d('merchant', 'Message'); ?> </label>
                                <textarea id='message' rows="5" cols="20" name="message" type="text" class="form-control" placeholder="" value=""></textarea>
                                <small class="trn form-control-feedback f4-error f4-error-message"></small> 
                            </div>

                            <div class="button-group">
                                <button class="btn btn-rounded btn-info" type="submit" ><i class="fa fa-check"></i>
                                <?php echo __d('merchant','Send'); ?></button>
                                <div class="pushnotloader" style=" display:inline-block;">
                                    <img id="loading_image" src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading" style="width:20px; display:none; margin:0px 0px 0px 5px;"/>
                                </div>
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
    #listid {
      text-transform: capitalize;
    }
    #listid option {
      padding: 2px 5px;
    }
</style>
