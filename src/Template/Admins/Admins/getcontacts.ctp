<div class="row page-titles m-b-20">
  <div class="col-md-12 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Contacts List'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('admin', 'Newsletter'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('admin', 'Get Contacts List'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
                <div class="card-block">
                    <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Contacts List'); ?></h4>
                    <hr>
                    <div class="col-md-6 col-sm-12 ">

                        
                            
                            <div class="form-group">
                                <label> <?php echo __d('admin', 'Contact Group List'); ?> </label>
                                <select  id='listid' name="listname" class="form-control">
                                  <option value=""><?php echo __d('admin', 'Choose an option'); ?></option>
                                <?php if(count($result)>0)
                                {
                                  foreach($result as $items)
                                  {
                                    echo '<option value="'.$items['id'].'">'.$items['name'].'</option>';
                                  }
                                }
                                ?>
                                </select>
                                <small class="form-control-feedback f4-error f4-error-listid"></small> 
                                <input id="apikey" type="hidden" value="<?php echo $settings_datas['news_key']; ?>">
                            </div>


                            <div class="button-group">
                                <button class="btn btn-rounded btn-info" onclick="get_contacts_list_admin()" ><i class="fa fa-check"></i>
                                <?php echo __d('admin', 'Get Contacts'); ?></button>

                                <a id="newcontact" href="https://login.mailchimp.com/" target="_blank" class="btn btn-rounded btn-success" style="font-family: sans-serif;"><i class="fa fa-plus"></i>
                                <?php echo __d('admin', 'Add New Contacts'); ?></a>

                            </div>





                        <div id="emailslist"></div>
                    </div>
                </div>
        </div>

    </div>
</div>
<style type="text/css">
    label {
        font-weight: 400 !important;
    }
    #newcontact:active, #newcontact:focus {
      background: #009efb !important;
      border: 1px solid #009efb !important;
      color: #ffffff !important; 
    }
    #listid {
      text-transform: capitalize;
    }
    #listid option {
      padding: 2px 5px;
    }
</style>
