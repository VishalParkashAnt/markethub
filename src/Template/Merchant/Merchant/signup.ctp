<?php
     use Cake\Routing\Router;
     $baseurl = Router::url('/');
?>
<!-- PRELOADER -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
    </svg>
</div>

<!-- MAIN WRAPPER STARTS -->
<?php $bgimage = "background-image:url(".SITE_URL."images/background/login-register.jpg)"; ?>
    
<div id="main-wrapper" class="login-register" style="<?php echo $bgimage;?>">

    <!-- CONTAINER STARTS -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 m-c-auto">
                <div class="col-lg-12 col-sbox">
                    <a href="<?php echo SITE_URL;?>merchant" class="text-center db">
                        <img src="<?php echo SITE_URL; ?>img/Logo@2x.png" alt="Home" style="width:200px;"/>
                       <!--  <img class="m-l-5" src="<?php echo SITE_URL; ?>images/logo-text.png" alt="Home" /> -->
                    </a><br/>
                </div>
            </div> 
        </div>

        <!-- FORM CREATION -->

            <?php echo $this->Form->Create('signup',array('url'=>array('controller' => '/','action' => '/signup'),'name'=>'merchantform','id'=>'merchantsignupform','onsubmit'=>"return merchantsignform()")); ?>

            <div class="row">
                <div class="col-lg-6 m-c-auto">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Create your Merchant Account</h4>
                        </div>

                        <div class="card-block">
                            <div class="form-body">
                                <h3 class="card-title">Account Information</h3>
                                <hr>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="First Name" id="firstname" name="firstname" class="form-control" onkeypress = "return isAlpha(event)" maxlength="30">
                                        <small class="form-control-feedback f4-error f4-error-firstname"> </small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Last Name" id="lastname" name="lastname"class="form-control" onkeypress="return isAlpha(event)" maxlength="30">
                                        <small class="form-control-feedback f4-error f4-error-lastname"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Email Address</label>
                                    <div class="col-md-9">
                                        <input placeholder="Email Address" id="email" name="email"class="form-control">
                                        <small class="form-control-feedback f4-error f4-error-email"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Username</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Username" id="username" name="username" class="form-control" onkeypress="return IsAlphaNumeric(event)" maxlength="30">
                                        <small class="form-control-feedback f4-error f4-error-username"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" placeholder="Password" id="password" name="password" class="form-control">
                                        <small class="form-control-feedback f4-error f4-error-password"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Confirm Password</label>
                                    <div class="col-md-9">
                                        <input type="password" placeholder="Confirm Password" id="cpassword" class="form-control">
                                        <small class="form-control-feedback f4-error f4-error-cpassword"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>

            <div class="row">
                <div class="col-lg-6 m-c-auto">
                    <div class="card card-outline-info">
                        <div class="card-block">
                            <div class="form-body">
                                <h3 class="card-title">Merchant Information</h3>
                                <hr>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Store Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="storename" name="storeurl" placeholder="Store Name" class="form-control" onkeypress="return IsAlphaNumeric(event)" maxlength="30">
                                        <small class="form-control-feedback f4-error f4-error-storename"> </small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Phone Number</label>
                                    <div class="col-md-9">
                                        <input type="text" id="storephonecode" name="storephonecode" placeholder="Country Code" class="form-control col-sm-4" onkeypress="return isNumber(event)" maxlength="5">
                                        <input type="text" id="storephonearea" name="storephonearea" placeholder="Area" class="form-control col-sm-2 mar-xs-t10" onkeypress="return isNumber(event)" maxlength="8">
                                        <input type="text" id="storephoneno" name="storephoneno" placeholder="Phone Number" class="form-control col-sm-5 col-rfloat mar-xs-t10"  onkeypress="return isNumber(event)" maxlength="15">
                                        <small class="form-control-feedback f4-error f4-error-storephonecode f4-error-storephonearea f4-error-storephoneno"></small> 
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
                                                <option value="Aliexpress">Aliexpress</option>
                                                <option value="Amazon">Amazon</option>
                                                <option value="Ebay">Ebay</option>
                                                <option value="Etsy">Etsy</option>
                                                <option value="Jd">Jd</option>
                                                <option value="Shopify">Shopify</option>
                                                <option value="Storenvy">Storenvy</option>
                                                <option value="Taobao">Taobao</option>
                                                <option value="Tmall">Tmall</option>
                                                <option value="Other">Other</option>
                                            <?php } ?>
                                        </select>
                                        <small class="form-control-feedback f4-error f4-error-storeplatform"></small> 
                                    </div>
                                </div>
                                */?>

                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Preferred Country and Currency</label>
                                    <div class="col-md-9">
                                        <?php
                                        echo '<select id="defaultcurrency" name="countryid" class="form-control custom-select">';
                                            echo '<option value="0">Select an option</option>';

                                            if(!empty($language_datas))
                                            {
                                                foreach($language_datas as $languages)
                                                {
                                                    echo '<option value="'.$languages['country']['id'].'">'.$languages['country']['country'].' - '.$languages['countrycode'].'</option>';
                                                }
                                            }
                                         echo '</select>';
                                         ?>
                                         <small class="form-control-feedback f4-error f4-error-defaultcurrency"></small>
                                         <small class="form-control-feedback f4-success">
                                            <?php echo __d('merchant','Note: Please make sure the given Braintree Id was pointed with chosen currency'); ?>                      
                                        </small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Currency Merchant Id</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Currency Merchant Id" name="braintreeid" id="braintreeid" class="form-control">
                                        <small class="form-control-feedback f4-error f4-error-braintreeid"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Braintree Merchant Id</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Braintree Merchant ID" name="merchantid" id="merchantid" class="form-control">
                                        <small class="form-control-feedback f4-error f4-error-merchantid"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Braintree Public Key</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Braintree Public Key" name="braintreepublickey" id="braintreepublickey" class="form-control">
                                        <small class="form-control-feedback f4-error f4-error-braintreepublickey"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Braintree Private Key</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Braintree Private Key" name="braintreeprivatekey" id="braintreeprivatekey"class="form-control">
                                        <small class="form-control-feedback f4-error f4-error-braintreeprivatekey"></small>
                                    </div>
                                </div>
                                <?php /*
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Do you have provide free wifi ?</label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="custom-control custom-radio">
                                                    <input name="wifi" type="radio" value="yes" checked class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Yes</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input name="wifi" type="radio" value="no" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">No</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Product Cateogories</label>
                                    <div class="col-md-9">
                                        <div id="prodcat" class="checkbox checkbox-success checkbox-circle">
                                        <?php
                                        $key = 1;
                                        if(!empty($cat_datas)){
                                            foreach($cat_datas as $cats){?>
                                                <div>
                                                <input type="checkbox" class="incontrol prodcat" id="prodcat<?php echo $key; ?>" name="prodcat[]" value="<?php echo $cats['id'];?>" ><label for="prodcat<?php echo $key; ?>" class="f4-chkbox"> <?php echo $cats['category_name']; ?></label>
                                                </div>

                                        <?php  ++$key; } } else {?>
                                            <input type="hidden"  name="prodcat" value="">
                                        <?php } ?>
                                        </div>
                                         <small class="form-control-feedback f4-error f4-error-prodcat"></small>
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
                <div class="col-lg-6 m-c-auto">
                    <div class="card card-outline-info">
                        <div class="card-block">
                            <div class="form-body">
                                <h3 class="card-title">Shipping Information</h3>
                                <hr>
                                <?php /*
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Free Pickup</label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="custom-control custom-radio">
                                                    <input id="pickup" name="pickup" type="radio" checked class="custom-control-input" value="yes">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Yes</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input id="pickup" name="pickup" type="radio" class="custom-control-input" value="no">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">No</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> */?>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Free delivery if order amount is greater than</label>
                                    <div class="form-group col-md-9">
                                        
                                            <input placeholder="" name="freeamt" id="freeamt" class="form-control col-md-6" type="text" onkeypress = "return pricefreeamt(event, 'pricefree', 'isNumberdot', 'freeamt', 'Enable free delivery to add amount')" onpaste = false>
                                            
                                            <div class="col-md-6" style="float:right;">
                                                <div class="form-check">
                                                    <label class="custom-control custom-radio">
                                                        <input id="pricefree" name="pricefree" type="radio" checked class="custom-control-input" value="yes">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Yes</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="pricefree" name="pricefree" type="radio" class="custom-control-input" value="no" onclick="return emptyfield('freeamt','','')">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <small class="form-control-feedback f4-error f4-error-freeamt"></small>
                                      
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"> Free delivery for postal codes</label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="custom-control custom-radio">
                                                    <input id="postalfree" name="postalfree" type="radio" checked class="custom-control-input" value="yes">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Yes</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input id="postalfree" name="postalfree" type="radio" class="custom-control-input" value="no" onclick="return emptyfield('postal_code','postalboxes','postadd')">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">No</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Postal Codes</label>
                                    <div class="col-lg-6">
                                        <div id="postal-codes"class="input-group">
                                            <input class="form-control postalcodes" id="postal_code" placeholder="Search for..." type="text" name="postalcodes[]" onkeyup="enable_add(this.value,'postadd');" onkeypress = "return pricefreeamt(event, 'postalfree', 'isNumber', 'postal-codes', 'Enable postal delivery to add codes')" onpaste = false />
                                            <span class="input-group-btn">
                                                <button id="postadd" class="btn btn-success" type="button" disabled="true" onclick="add_postalcode()">ADD</button>
                                            </span>
                                        </div>
                                        <div id="postalboxes"></div>
                                        <small class="trn form-control-feedback  f4-error f4-error-postal-codes"></small> 
                                    </div>
                                </div>
                            </div>     
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 m-c-auto">
                    <div class="card card-outline-info">
                        <div class="card-block">
                            <div class="form-body">
                                <h3 class="card-title">Business Address</h3>
                                <hr>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Address Line 1</label>
                                    <div class="col-md-9">
                                        <input type="text" id="address" name="address1" placeholder="Address" class="form-control">
                                        <small class="form-control-feedback f4-error f4-error-address"> </small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Address Line 2</label>
                                    <div class="col-md-9">
                                        <input type="text" id="address2" name="address2" placeholder="Address" class="form-control">
                                        <small class="form-control-feedback"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">City</label>
                                    <div class="col-md-9">
                                        <input type="text" id="city" name="city" placeholder="Address" class="form-control" value="">
                                        <small class="form-control-feedback f4-error f4-error-city"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">State/Province/Region </label>
                                    <div class="col-md-9">
                                        <input type="text" id="statprov" name="statprov" placeholder="State / Province / Region" class="form-control">
                                        <small class="form-control-feedback f4-error f4-error-statprov"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Country</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" id="country" name="country">
                                            <option value=""><?php echo 'Select Country';?></option>
                                            <?php 
                                            foreach ($countrylist as $country)
                                            { ?> 
                                                <option value="<?php echo $country['country'];?>"><?php echo $country['country']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <small class="form-control-feedback f4-error f4-error-country"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Zip/Postal Code </label>
                                    <div class="col-md-9">
                                        <input id="zipcode" type="text" placeholder="Zip / Postal Code" name="zipcode" class="form-control col-md-10 col-sm-10" onkeypress="return isNumber(event)">
                                        <span>
                                            <button id="postadd" class="btn btn-info" type="button" style="padding:9px 12px !important; float:right;" onclick="showAddress(); return false;">GO</button>
                                        </span>
                                        <input type="hidden" value="" name="searchaddress" id="googleaddress" />
                                        <small class="form-control-feedback f4-error f4-error-zipcode"></small> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Latitude </label>
                                    <div class="col-md-9">
                                        <input type="text"  id="latbox" name="latitude" placeholder="Latitude" class="form-control" onkeypress = "return false">
                                        <small class="form-control-feedback f4-error f4-error-latbox"></small> 
                                        <span id="laterr" style="font-size:13px;color:red;font-weight:bold;margin-left:220px;display: none;"><?php echo __('Click Go button to update latitude'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3">Longitude</label>
                                    <div class="col-md-9">
                                        <input type="text" id="lonbox" name="longitude" placeholder="Longitude" class="form-control" onkeypress = "return false">
                                        <small class="form-control-feedback f4-error f4-error-lonbox"></small> 
                                        <span id="lonerr" style="font-size:13px;color:red;font-weight:bold;margin-left:220px;display: none;"><?php echo __('Click Go button to update longitude'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                       <div class="checkbox checkbox-info checkbox-circle">
                                            <input checked="" type="checkbox" name="agree" value='yes' id="agree" >
                                            <label class="f4-chkbox" for="agree"> I have read and agree to the Merchant Terms of Conditions</label>
                                        </div>
                                        <small class="form-control-feedback f4-error f4-error-agree"></small>

                                        <small class="form-control-feedback f4-error f4-error-signerror"></small>

                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12 m-c-auto text-center">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Submit</button>
                                            <a href="<?php echo MERCHANT_URL; ?>/signup" type="button" class="btn btn-inverse">Reset</a>
                                        </div>
                                    </div>       
                                </div>

                                <hr/>
                                <div class="form-group row">
                                     <h6 class="card-title">To find the latitude and longitude of a point, Click or Drag on the map.</h6>
                                    <div class="col-md-12">
                                       <div id="map" class="gmaps"></div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group m-b-0">
                                  <div class="col-sm-12 text-center">
                                    <p>Do you have an account Login? <a href="<?php echo $baseurl; ?>merchant" class="text-primary m-l-5"><b> Login </b></a></p>
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
        
        <!-- Container Ends -->

        <footer class="footer">
            © 2017 Fantacy
        </footer>
    </div> 
    <!-- Main Wrapper Ends -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjd0I1Vvo22cSmIk-9UXLuB2dFpLeRizQ"></script>
    <script type="text/javascript" src="<?php echo SITE_URL.'js/googlemap.js';?>"></script>  
    <script>
    window.load = xz('0.0','0.0');
    </script>



    



