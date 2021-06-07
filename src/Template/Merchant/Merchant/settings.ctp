<?php
     use Cake\Routing\Router;
     $baseurl = Router::url('/');

     $userid = $loguser['id'];
     $site = $_SESSION['site_url'];
     @$username = $_SESSION['media_server_username'];
     @$password = $_SESSION['media_server_password'];
     @$hostname = $_SESSION['media_host_name'];
?>
<!-- PRELOADER -->
<!-- div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
    </svg>
</div -->

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Seller Information'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Merchant');?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Seller Information'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Edit Seller'); ?></li>
      </ol>
  </div>
</div>

    <!-- CONTAINER STARTS -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <!-- h4 class="card-title">Data Table</h4 -->
                <h4 class="text-themecolor m-b-0 m-t-0" style="display: inline-block;"><?php echo __d('merchant','Edit Seller'); ?></h4>

                <?php
                    echo "<span id = 'status".trim($editsetting['shop']['id'])."'>";
                    if ($editsetting['shop']['store_enable'] == 'enable') { ?>
                        <a class="btn btn-danger disable_link" onclick="changeSellerStatus(<?php echo $editsetting['shop']['id']; ?>, '<?php echo trim($editsetting['shop']['store_enable']); ?>')"> <?php echo __d('merchant','Disable Store'); ?> </a>
                <?php } else { ?>
                    <a class="btn btn-success disable_link" onclick="changeSellerStatus(<?php echo $editsetting['shop']['id']; ?>,'<?php echo trim($editsetting['shop']['store_enable']); ?>')"> <?php echo __d('merchant','Enable Store'); ?> </a>
                <?php } echo "</span>"; ?>
                <hr/>
        
        <!-- FORM CREATION -->

            <?php echo $this->Form->Create('settings',array('url'=>array('controller' => '/','action' => '/sellerinformation/'),'name'=>'merchantform','id'=>'editmerchantsignupform','onsubmit'=>"return editmerchantsignform()")); ?>

            <div class="row">
                <div class="col-lg-9 m-c-auto">
                    <div class="card card-outline-info m-t-30">

                        <div class="card-block">
                            <div class="form-body">
                                <h5 class="card-title"><?php echo __d('merchant','Account Information'); ?></h5>
                                <hr>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','First Name'); ?></label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="<?php echo __d('merchant','First Name'); ?>" id="firstname" name="firstname" class="form-control" onkeypress = "return isAlpha(event)" maxlength="30" value = "<?php echo $editsetting['first_name']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-firstname"> </small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Last Name');?></label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="<?php echo __d('merchant','Last Name'); ?>" id="lastname" name="lastname"class="form-control" onkeypress="return isAlpha(event)" maxlength="30" value = "<?php echo $editsetting['last_name']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-lastname"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Email Address'); ?></label>
                                    <div class="col-md-9">
                                        <input placeholder="<?php echo __d('merchant','Email Address'); ?>" disabled="disabled" id="email" name="email"class="form-control" value = "<?php echo $editsetting['email']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-email"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Username'); ?></label>
                                    <div class="col-md-9">
                                        <input type="text" disabled="disabled" placeholder="<?php echo __d('merchant','Username'); ?>" id="username" name="username" class="form-control" onkeypress="return IsAlphaNumeric(event)" maxlength="30" value = "<?php echo $editsetting['username']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-username"></small> 
                                    </div>
                                </div>

                                <div class="form-group row">  
                                    <label class="control-label text-left col-md-3" style="margin:auto 0px;"><?php echo __d('merchant','Profile Image');?></label>
                                    <?php 
                                    if(empty($editsetting['profile_image'])) {
                                        $image_computer = '';
                                    }else{
                                        $image_computer = $editsetting['profile_image'];
                                    }
                                       
                                    echo "<div class='col-lg-3 col-md-5'>";
                                    echo '<div class="venueimg">
                                        <iframe class="image_iframe" id="frame" name="frame" src="'.$site.'userupload.php?media_url='.$site.'&site_url='.$site.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'&userid='.$userid.'&merchantprofile=merchant'.'" frameborder="0" height="70px" width="30px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;"></iframe>';
                                        echo $this->Form->input('profile_image', array('type'=>'hidden','id'=>'image_computer', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$image_computer,'name'=>'profile_image'));

                                        if(!empty(trim($image_computer))) {
                                            echo "<a href='javascript:void(0);' id='removeimg' class='pic-remove' onclick='removeusrimg(\" 1 \")'>";
                                            echo '<i class="fa fa-close"></i>';
                                            echo "</a>";
                                        } else { 
                                            echo "<a href='javascript:void(0);' id='removeimg' class='pic-remove' style='display: none;' onclick='removeusrimg(\" 1 \")'> " ?>
                                            <?php echo'<i class="fa fa-close"></i>'; 
                                            echo "</a>";
                                         }
                                        echo "</div>";
                                        if(!empty(trim($image_computer))){
                                        ?>
                                        <img class="" id="show_url" src="<?php echo $_SESSION['site_url'].'media/avatars/thumb70/'.$image_computer; ?>" style="float: left;width: 70px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px;" >
                                        <?php
                                        } else { ?>
                                        <img class="" id="show_url" src="<?php echo $_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg'; ?>" style="float: left;width: 70px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px;" >

                                        <?php
                                        }
                                    echo "</div>";
                                    ?>
                                </div>   
                            </div>
                        </div>
                    </div>
                 </div>
            </div>

            <div class="row">
                <div class="col-lg-9 m-c-auto">
                    <div class="card card-outline-info">
                        <div class="card-block">
                            <div class="form-body">
                                <h5 class="card-title"><?php echo __d('merchant','Merchant Information'); ?></h5>
                                <hr>




                               
                 <div class="form-group row">
                    <label class="control-label text-left col-md-3" style="margin:auto 0px;"><?php echo __d('merchant','Shop Image');?></label>
                    <?php 
                    if(empty($editsetting['shop']['shop_image'])){
                        $image_shop = '';
                    }else{
                        $image_shop = $editsetting['shop']['shop_image'];
                    }
               
                    echo "<div class='col-lg-3 col-md-5'>";
                    echo '<div class="venueimg">
                            <iframe class="image_iframe" id="frame" name="frame" src="'.$site.'shopupload.php?media_url='.$site.'&site_url='.$site.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'&userid='.$userid.'" frameborder="0" height="70px" width="30px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;"></iframe>';
                            echo $this->Form->input('shop_image', array('type'=>'hidden','id'=>'image_shop', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$image_shop,'name'=>'shop_image'));
                            if(!empty($image_shop)){
                                echo "<a href='javascript:void(0);' id='removeimg2' class='pic-remove' onclick='removeshopimg(\" 1 \")'>";
                                    echo '<i class="fa fa-close"></i>';
                                echo "</a>";
                            } else {
                                echo "<a href='javascript:void(0);' id='removeimg2' class='pic-remove' style='display: none;' onclick='removeshopimg(\" 1 \")'> " ?>
                                <?php echo'<i class="fa fa-close"></i>'; 
                                echo "</a>";
                            }
                            echo "</div>";

                            if(!empty($image_shop)){
                                echo "<img id='show_url2'  style='float: left; width: 70px; height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px;' src='".$_SESSION['site_url']."media/avatars/thumb70/".$image_shop."'>";
                            }else{
                                echo "<img id='show_url2'  style='float: left; width: 70px; height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px;' src='".$_SESSION['site_url']."media/avatars/thumb70/usrimg.jpg'>";
                            }
                        echo "</div>";
                        ?>
                </div>

                <div class="form-group row">
                    <label class="control-label text-left col-md-3">
                        <?php echo __d('merchant','Banner Image');
                        echo "<br />";
                        echo __('(960px X 200px)'); ?>
                    </label>
                    
                    <?php 
                        if(empty($editsetting['shop']['shop_banner'])){
                            $image_banner = '';
                        }else{
                            $image_banner = $editsetting['shop']['shop_banner'];
                        }
                echo "<div class='col-lg-5 col-md-10'>";
                    echo '<div class="venueimg">
                        <iframe class="image_iframe" id="frame" name="frame" src="'.$site.'bannerupload.php?media_url='.$site.'&site_url='.$site.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'&userid='.$userid.'" frameborder="0" height="100px" width="30px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;"></iframe>';
                echo $this->Form->input('shop_banner', array('type'=>'hidden','id'=>'image_banner', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$image_banner,'name'=>'shop_banner'));

                if(!empty($image_banner)){
                    echo "<a href='javascript:void(0);' id='removeimg1' class='banner-remove' onclick='removebannerimg(\" 2 \")'>";
                    echo '<i class="fa fa-close"></i>';
                    echo "</a>";
                }else{
                echo "<a href='javascript:void(0);' id='removeimg1' class='banner-remove' style='display: none;' onclick='removebannerimg(\" 2 \")'> " ?>
                <?php echo '<i class="fa fa-close"></i>'; 
                echo "</a>"; }
                                        echo "</div>";
                                        if(!empty(trim($image_banner))) {
                                        echo "<img id='show_url1'  style='width: 200px;height:100px;' src='".$_SESSION['site_url']."media/avatars/thumb350/".$image_banner."'>";
                                        }else{
                                        echo "<img id='show_url1'  style='width: 100px;height:100px;' src='".$_SESSION['site_url']."media/avatars/thumb350/usrimg.jpg'>";
                                        }
                                echo "</div>";
            ?>            
            
          </div>




                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Shop Description'); ?> </label>
                                    <div class="col-md-9">
                                        <textarea id="storedescription" rows="5" name="storedescription" placeholder="Store Description" class="form-control" maxlength="250"><?php echo $editsetting['shop']['shop_description']; ?></textarea>
                                        <small class="trn form-control-feedback f4-error f4-error-storedescription"> </small> 
                                    </div>
                                </div>

                                <!-- div class="form-group row">
                                    <label class="control-label text-left col-md-3">Company Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="companyname" name="companyname" placeholder="Company Name" class="form-control" onkeypress="return IsAlphaNumeric(event)" maxlength="30" value="<?php echo $editsetting['shop']['shop_name']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-companyname"> </small> 
                                    </div>
                                </div -->
                                <?php $phoneno = $editsetting['shop']['phone_no'];
                                    $numbers = explode('-',$phoneno); ?>        

                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Phone Number'); ?></label>
                                    <div class="col-md-9">
                                        <input type="text" id="storephonecode" name="storephonecode" placeholder="<?php echo __d('merchant','Country Code'); ?>" class="form-control col-sm-4" onkeypress="return isNumber(event)" maxlength="5" value="<?php echo trim($numbers[0]); ?>">
                                        <input type="text" id="storephonearea" name="storephonearea" placeholder="<?php echo __d('merchant','Area'); ?>" class="form-control col-sm-2 mar-xs-t10" onkeypress="return isNumber(event)" maxlength="8" value="<?php echo trim($numbers[1]); ?>">
                                        <input type="text" id="storephoneno" name="storephoneno" placeholder="<?php echo __d('merchant','Phone Number'); ?>" class="form-control col-sm-5 col-rfloat mar-xs-t10"  onkeypress="return isNumber(event)" maxlength="15" value="<?php echo trim($numbers[2]); ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-storephonecode f4-error-storephonearea f4-error-storephoneno"></small> 
                                    </div>
                                </div>
                                <?php /*
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Store Platform</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" id="storeplatform" name="storeplatform">
                                            <option value="">Choose One</option>

                                            <?php if(!empty($_SESSION['storeplat'])) {  ?>
                                                <option value="<?php echo $_SESSION['storeplat'];?>" selected><?php echo $_SESSION['storeplat'];?></option>
                                            <?php } else { ?>
                                                <option value="Aliexpress" <?php if($editsetting['shop']['store_platform'] == 'Aliexpress'): ?> selected="selected" <?php endif ?> >Aliexpress</option>
                                                <option value="Amazon" <?php if($editsetting['shop']['store_platform'] == 'Amazon'): ?> selected="selected" <?php endif ?> >Amazon</option>

                                                <option value="Ebay" <?php if($editsetting['shop']['store_platform'] == 'Ebay'): ?> selected="selected" <?php endif ?> >Ebay</option>
                                                <option value="Etsy" <?php if($editsetting['shop']['store_platform'] == 'Etsy'): ?> selected="selected" <?php endif ?> >Etsy</option>
                                                <option value="Jd" <?php if($editsetting['shop']['store_platform'] == 'Jd'): ?> selected="selected" <?php endif ?> >Jd</option>
                                                <option value="Shopify" <?php if($editsetting['shop']['store_platform'] == 'Shopify'): ?> selected="selected" <?php endif ?> >Shopify</option>
                                                <option value="Storenvy" <?php if($editsetting['shop']['store_platform'] == 'Storenvy'): ?> selected="selected" <?php endif ?> >Storenvy</option>
                                                <option value="Taobao" <?php if($editsetting['shop']['store_platform'] == 'Taobao'): ?> selected="selected" <?php endif ?> >Taobao</option>
                                                <option value="Tmall" <?php if($editsetting['shop']['store_platform'] == 'Tmall'): ?> selected="selected" <?php endif ?> >Tmall</option>
                                                <option value="Other" <?php if($editsetting['shop']['store_platform'] == 'Other'): ?> selected="selected" <?php endif ?> >Other</option>
                                            <?php } ?>
                                        </select>
                                        <small class="trn form-control-feedback f4-error f4-error-storeplatform"></small> 
                                    </div>
                                </div>
                                */ ?>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Store Name'); ?></label>
                                    <div class="col-md-9">
                                        <input type="text" id="storename" name="storeurl" placeholder="<?php echo __d('merchant','Store Name'); ?>" class="form-control" disabled="disabled" onkeypress="return IsAlphaNumeric(event)" maxlength="30" value="<?php echo $editsetting['shop']['shop_name']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-storename"> </small> 
                                    </div>
                                </div>

                                <!-- div class="form-group row">
                                    <label class="control-label text-left col-md-3">Braintree Merchant Id</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Username" name="braintreeid" id="braintreeid" class="form-control" value="<?php //echo $editsetting['shop']['braintree_id']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-braintreeid"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Braintree Public Key</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Username" name="braintreepublickey" id="braintreepublickey" class="form-control" value="<?php //echo $editsetting['shop']['braintree_publickey']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-braintreepublickey"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Braintree Private Key</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Username" name="braintreeprivatekey" id="braintreeprivatekey"class="form-control" value="<?php //echo $editsetting['shop']['braintree_privatekey']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-braintreeprivatekey"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Do you have provide free wifi'); ?> ?</label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <?php
                                                if($editsetting['shop']['wifi'] == "yes")
                                                { ?>
                                                    <label class="custom-control custom-radio">
                                                        <input name="wifi" type="radio" value="yes" checked class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?></span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input name="wifi" type="radio" value="no" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
                                                    </label>
                                                <?php } else { ?>
                                                    <label class="custom-control custom-radio">
                                                        <input name="wifi" type="radio" value="yes" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?></span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input name="wifi" type="radio" value="no" checked class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
                                                    </label>

                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div -->

                                <?php /*
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Preferred Country</label>
                                    <div class="col-md-9">
                                        <?php
                                        echo '<select name="countryid" class="form-control custom-select">';
                                            echo '<option value="0">Select Currency</option>';

                                            if(!empty($language_datas))
                                            {
                                                foreach($language_datas as $languages)
                                                {
                                                    echo '<option value="'.$languages['country']['id'].'">'.$languages['country']['country'].'</option>';
                                                }
                                            }
                                         echo '</select>';
                                         ?>
                                    </div>
                                </div>
                                */ ?>
                                <?php /*
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Product Cateogories</label>
                                    <div class="col-md-9">
                                        <div id="prodcat" class="checkbox checkbox-success checkbox-circle">
                                        <?php
                                        $key = 1;
                                        if(!empty($cat_datas)){
                                            foreach($cat_datas as $cats){

                                            $category=$editsetting['shop']['product_category'];
                                            $prodcat = json_decode($category,true); ?>

                                            <div>    <?php 
                                            if(in_array($cats['id'],$prodcat)) { ?>
                                                <input type="checkbox" class="incontrol prodcat" id="prodcat<?php echo $key; ?>" name="prodcat[]" value="<?php echo $cats['id'];?>" checked ><label for="prodcat<?php echo $key; ?>" class="f4-chkbox"> <?php echo $cats['category_name']; ?></label>
                                            <?php } else { ?>
                                                <input type="checkbox" class="incontrol prodcat" id="prodcat<?php echo $key; ?>" name="prodcat[]" value="<?php echo $cats['id'];?>" ><label for="prodcat<?php echo $key; ?>" class="f4-chkbox"> <?php echo $cats['category_name']; ?></label>
                                            <?php } ?>
                                            </div>

                                        <?php  ++$key; } } else {?>
                                            <input type="hidden"  name="prodcat" value="">
                                        <?php } ?>
                                        </div>
                                         <small class="trn form-control-feedback f4-error f4-error-prodcat"></small>
                                        <!-- div class="checkbox checkbox-info checkbox-circle">
                                            <input id="prodcat" name="prodcat[]" checked="" type="checkbox" value="1">
                                            <label for="prodcat"> Info </label>
                                        </div>
                                        <div class="checkbox checkbox-info checkbox-circle">
                                            <input id="prodcat" name="prodcat[]" checked="" type="checkbox" value="2">
                                            <label for="prodcat"> Info </label>
                                        </div -->
                                    </div>
                                </div> 

                                */ ?>
                            </div>     
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9 m-c-auto">
                    <div class="card card-outline-info">
                        <div class="card-block">
                            <div class="form-body">
                                <h5 class="card-title"><?php echo __d('merchant','Shipping Information'); ?></h5>
                                <hr>
                                <?php /*
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Free Pickup'); ?></label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <?php
                                                if($editsetting['shop']['pickup']=='yes')
                                                { ?>
                                                    <label class="custom-control custom-radio">
                                                        <input id="pickup" name="pickup" type="radio" checked class="custom-control-input" value="yes">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?></span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="pickup" name="pickup" type="radio" class="custom-control-input" value="no">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
                                                    </label>
                                                <?php } else { ?>
                                                    <label class="custom-control custom-radio">
                                                        <input id="pickup" name="pickup" type="radio" class="custom-control-input" value="yes">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?></span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="pickup" name="pickup" type="radio" checked class="custom-control-input" value="no">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
                                                    </label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> */ ?>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Free delivery if order amount is greater than'); ?></label>
                                    <div class="form-group col-md-9">

                                        <?php 

                                        $free_amount = trim($editsetting['shop']['freeamt']);

                                        if($free_amount=="" || $free_amount==0)
                                           $freeamt = "";
                                       else
                                           $freeamt = $editsetting['shop']['freeamt'];
                                        ?>
                                            <input placeholder="" name="freeamt" id="freeamt" class="form-control col-md-6" type="text" value="<?php echo $freeamt; ?>" onkeypress = "return pricefreeamt(event, 'pricefree', 'isNumberdot', 'freeamt', 'Enable free delivery to add amount')" onpaste = "false" maxlength="6">
                                            
                                            <div class="col-md-6" style="float:right;">
                                                <div class="form-check">
                                                <?php 
                                                    if($editsetting['shop']['pricefree']=='yes')
                                                { ?>
                                                    <label class="custom-control custom-radio">
                                                        <input id="pricefree" name="pricefree" type="radio" checked class="custom-control-input" value="yes">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?></span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="pricefree" name="pricefree" type="radio" class="custom-control-input" value="no" onclick="return emptyfield('freeamt','','')">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
                                                    </label>
                                                <?php } else { ?>
                                                    <label class="custom-control custom-radio">
                                                        <input id="pricefree" name="pricefree" type="radio" class="custom-control-input" value="yes">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?></span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="pricefree" name="pricefree" type="radio" checked class="custom-control-input" value="no" onclick="return emptyfield('freeamt','','')">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
                                                    </label>
                                                <?php } ?>
                                                </div>
                                            </div>
                                            <small class="trn form-control-feedback f4-error f4-error-freeamt"></small>
                                      
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"> <?php echo __d('merchant','Free delivery for postal codes') ?></label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                            <?php
                                            if($editsetting['shop']['postalfree']=='yes')
                                            {
                                            ?> 
                                                <label class="custom-control custom-radio">
                                                    <input id="postalfree" name="postalfree" type="radio" checked class="custom-control-input" value="yes">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?> </span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input id="postalfree" name="postalfree" type="radio" class="custom-control-input" value="no" onclick="return emptyfield('postal_code','postalboxes','postadd')">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
                                                </label>
                                            <?php } else { ?>
                                                <label class="custom-control custom-radio">
                                                    <input id="postalfree" name="postalfree" type="radio" class="custom-control-input" value="yes">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?> </span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input id="postalfree" checked name="postalfree" type="radio" class="custom-control-input" value="no" onclick="return emptyfield('postal_code','postalboxes','postadd')">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description"><?php echo __d('merchant','No'); ?> </span>
                                                </label>
                                            <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Postal Codes'); ?></label>
                                    <div class="col-lg-6">
                                        <div id="postal-codes"class="input-group">
                                            <input class="form-control postalcodes" id="postal_code" placeholder="<?php echo __d('merchant','Search for'); ?> ..." type="text" name="postalcodes[]" onkeyup="enable_add(this.value,'postadd');" onkeypress = "return pricefreeamt(event, 'postalfree', 'isNumber', 'postal-codes', 'Enable postal delivery to add codes')" onpaste = false />
                                            <span class="input-group-btn">
                                                <button id="postadd" class="btn btn-success" type="button" disabled="true" onclick="add_postalcode()"><?php echo __d('merchant','ADD'); ?></button>
                                            </span>
                                        </div>
                                        <div id="postalboxes">
                                            <?php
                                            if($editsetting['shop']['postalfree']=='yes')
                                            {
                                               $postalcodes = $editsetting['shop']['postalcodes'];
                                               $postcodes = json_decode($postalcodes,true);
                                               foreach($postcodes as $key => $post)
                                               { 
                                                    echo '<div class="input-group" id="pc_'.$post.'">
                                                        <input value="'.$post.'" name="postalcodes[]" class="form-control postalcodes" onkeypress="return isNumber(event)" type="text" readonly>
                                                        <span class="input-group-btn btn" onclick="delete_post_code(this);"><i class="icon-trash"></i></span>
                                                    </div>';
                                                }
                                            }
                                           ?>
                                        </div>
                                        <small class="trn form-control-feedback  f4-error f4-error-postal-codes"></small> 
                                    </div>
                                </div>
                            </div>     
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-9 m-c-auto">
                    <div class="card card-outline-info">
                        <div class="card-block">
                            <div class="form-body">
                                <h5 class="card-title"><?php echo __d('merchant','Business Address'); ?></h5>
                                <hr>

                                <?php $address = $editsetting['shop']['shop_address']; 
                                    $addresplit = explode('~',$address); ?>

                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Address Line'); ?> 1</label>
                                    <div class="col-md-9">
                                        <input type="text" value="<?php echo $addresplit[0]; ?>" id="address" name="address1" placeholder="<?php echo __d('merchant','Address'); ?>" class="form-control">
                                        <small class="trn form-control-feedback f4-error f4-error-address"> </small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Address Line'); ?> 2</label>
                                    <div class="col-md-9">
                                        <input type="text" id="address2" value="<?php echo $addresplit[1]; ?>" name="address2" placeholder="<?php echo __d('merchant','Address'); ?>" class="form-control">
                                        <small class="trn form-control-feedback"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','City'); ?></label>
                                    <div class="col-md-9">
                                        <input type="text" id="city" value="<?php echo $addresplit[2]; ?>" name="city" placeholder="<?php echo __d('merchant','City'); ?>" class="form-control" value="">
                                        <small class="trn form-control-feedback f4-error f4-error-city"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','State / Province / Region'); ?> </label>
                                    <div class="col-md-9">
                                        <input type="text" id="statprov" value="<?php echo $addresplit[3]; ?>" name="statprov" placeholder="<?php echo __d('merchant','State / Province / Region'); ?>" class="form-control">
                                        <small class="trn form-control-feedback f4-error f4-error-statprov"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Country'); ?></label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" id="country" name="country">
                                            <option value=""><?php echo __d('merchant','Select Country'); ?></option>
                                            <?php  $selected = ''; 
                                            foreach ($countrylist as $country)
                                            { 
                                                if($addresplit[4] == $country ['country']) {
                                                        $selected = 'selected';
                                            ?> 
                                                    <option value="<?php echo $country['country'];?>" <?php echo $selected;?> ><?php echo $country['country']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $country['country'];?>"><?php echo $country['country']; ?></option>

                                            <?php } } $selected = ''; ?>
                                        </select>
                                        <small class="trn form-control-feedback f4-error f4-error-country"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Zip / Postal Code'); ?> </label>
                                    <div class="col-md-9">
                                        <input id="zipcode" type="text" placeholder="<?php echo __d('merchant','Zip / Postal Code'); ?>" name="zipcode" value="<?php echo $addresplit[5];?>" class="form-control col-md-10 col-sm-10" onkeypress="return isNumber(event)">
                                        <span>
                                            <button id="postadd" class="btn btn-info" type="button" style="padding:9px 12px !important; float:right;" onclick="showAddress(); return false;"><?php echo __d('merchant','GO'); ?></button>
                                        </span>
                                        <input type="hidden" value="" name="searchaddress" id="googleaddress" />
                                        <small class="trn form-control-feedback f4-error f4-error-zipcode"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Latitude'); ?> </label>
                                    <div class="col-md-9">
                                        <input type="text"  id="latbox" name="latitude" placeholder="<?php echo __d('merchant','Latitude'); ?>" class="form-control" onkeypress = "return false" value="<?php echo $editsetting['shop']['shop_latitude']; ?>" >
                                        <small class="trn form-control-feedback f4-error f4-error-latbox"></small> 
                                        <span id="laterr" style="font-size:13px;color:red;font-weight:bold;margin-left:220px;display: none;"><?php echo __d('merchant','Click Go button to update latitude'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"><?php echo __d('merchant','Longitude'); ?></label>
                                    <div class="col-md-9">
                                        <input type="text" id="lonbox" name="longitude" placeholder="<?php echo __d('merchant','Longitude'); ?>" class="form-control" onkeypress = "return false" value="<?php echo $editsetting['shop']['shop_longitude']; ?>">
                                        <small class="trn form-control-feedback f4-error f4-error-lonbox"></small> 
                                        <span id="lonerr" style="font-size:13px;color:red;font-weight:bold;margin-left:220px;display: none;"><?php echo __d('merchant','Click Go button to update longitude'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                       <div class="checkbox checkbox-info checkbox-circle">
                                            <input checked="" type="checkbox" name="agree" value='yes' id="agree" >
                                            <label class="f4-chkbox" for="agree"> <?php echo __d('merchant','I have read and agree to the Merchant Terms of Conditions'); ?></label>
                                        </div>
                                        <small class="trn form-control-feedback f4-error f4-error-agree"></small>

                                        <small class="trn form-control-feedback f4-error f4-error-signerror"></small>

                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12 m-c-auto text-center">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo __d('merchant','Submit'); ?></button>
                                            <button type="button" class="btn btn-inverse"><?php echo __d('merchant','Cancel'); ?></button>
                                        </div>
                                    </div>       
                                </div>

                                <hr/>
                                <div class="form-group row">
                                     <h6 class="card-title"><?php echo __d('merchant','To find the latitude and longitude of a point, Click or Drag on the map'); ?>.</h6>
                                    <div class="col-md-12">
                                       <div id="map" class="gmaps"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>

            <!-- Form Ends -->
            
        </div>
    </div>
        <!-- Container Ends -->
    </div> 
    <!-- Main Wrapper Ends -->
</div>
<style>
.card-outline-info > .card-block {
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 8px;
}
.disable_link, .disable_link:hover, .disable_link:focus {
  color: #fff !important;
  display: inline-block;
  float: right;
  font-size: 13px;
  font-weight: 500;
  padding: 5px 10px;
}

.pic-remove, .pic-remove:focus {
  background: #fff none repeat scroll 0 0;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 100%;
  color: rgba(0, 0, 0, 0.15);
  font-size: 10px;
  left: 105px;
  padding: 0 4px;
  position: absolute;
  top: -5px;
}
.banner-remove, .banner-remove:focus {
  background: #fff none repeat scroll 0 0;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 100%;
  color: rgba(0, 0, 0, 0.15);
  font-size: 10px;
  left: 235px;
  padding: 0 4px;
  position: absolute;
  top: -10px;
}

.banner-remove:hover, .pic-remove:hover {
    border-color: #009efb;
    color: #009efb;   
}

#show_url1 {
    border: 1px solid rgb(221, 221, 221); padding: 5px;
}

</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjd0I1Vvo22cSmIk-9UXLuB2dFpLeRizQ"></script>
<script type="text/javascript" src="<?php echo SITE_URL.'js/googlemap.js';?>"></script>  
<script>
    var lat = $('#latbox').val();
    var lon = $('#lonbox').val();
    window.load = xz(lat,lon);
</script>



    



