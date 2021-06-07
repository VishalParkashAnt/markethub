<?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
<?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>
<?= $this->Html->script('assets/plugins/tinymce/tinymce.min.js') ?>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Edit Products'); ?></h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Manage Products'); ?></a></li>
      <li class="breadcrumb-item active"><?php echo __d('merchant','Edit Products'); ?></li>
    </ol>
  </div>
</div>

<?php
if(session_id() == '') {
session_start();
}
$userid = $loguser['id'];
$site = $_SESSION['site_url'];
$media = $_SESSION['site_url'];
@$username = $_SESSION['media_server_username'];
@$password = $_SESSION['media_server_password'];
@$hostname = $_SESSION['media_host_name'];
?>
<input type="hidden" value="<?php echo $loguser['id']; ?>" id="userid">

<div class="row">
 <div class="col-12">
  <div class="card">
   <div class="card-block">
    <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Edit Products'); ?></h4>
    <hr>
    <div class="row">
      <!-- LEFT COLUMN STARTS-->
      <div class="col-lg-8 col-md-8 col-sm-12 ">
        <?php echo $this->Form->Create('Item', array('url' => array('controller' => '/','action' => '/editselleritem/'.$item['id']),'name' => 'itemform', 'id' => 'itemform')); ?>

        <div class="form-group">
          <input type="hidden" id="itemid" value="<?php echo $item['id'];?>">
          <div class="box-addTitle"> <?php echo __d('merchant','Pick Category');?> </div>
          <div class="row m-0">
            <div class="col-md-4 p-l-0">
              <select class="form-control custom-select" id="cate_id" name="category_id">
                <option value=""><?php echo __d('merchant','Select Category'); ?></option>
                <?php
                foreach($cat_datas as $cats){
                if($cats['id'] == $item['category_id'])
                echo "<option value=".$cats['id']." selected = 'selected'>".$cats['category_name']."</option>";
                else
                echo "<option value=".$cats['id'].">".$cats['category_name']."</option>";
              }
              ?>  
            </select> 
            <small class="trn form-control-feedback f4-error f4-error-cate_id"></small>
          </div>
          <?php 
          if (empty($superSub_datas)) { ?>                   
          <div id='categ-container-2' class="col-md-4 p-l-0" style="display:none;">
            <select class="form-control custom-select" id="cate_id2" name="supersubcat">
            </select> 
            <small class="trn form-control-feedback f4-error f4-error-cate_id2"></small>
          </div>
          <?php } else { ?>
          <div id='categ-container-2' class="col-md-4 p-l-0">
            <select class="form-control custom-select active" id="cate_id2" name="supersubcat">
              <option value=""><?php echo __d('merchant','Select Category'); ?></option>
              <?php
              foreach($superSub_datas as $cats){
              if($cats['id'] == $item['super_catid'])
              echo "<option value=".$cats['id']." selected = 'selected'>".$cats['category_name']."</option>";
              else
              echo "<option value=".$cats['id'].">".$cats['category_name']."</option>";
            }
            ?>
          </select> 
          <small class="trn form-control-feedback f4-error f4-error-cate_id2"></small>
        </div>

        <?php } ?>

        <?php  
        if(empty($Sub_datas)) { ?>
        <div  id='categ-container-3' class="col-md-4 p-l-0" style="display:none;">
          <select class="form-control custom-select" id="cate_id3" name="subcat">
          </select> 
          <small class="trn form-control-feedback f4-error f4-error-cate_id3"></small>
        </div>
        <?php } else { ?>
        <div  id='categ-container-3' class="col-md-4 p-l-0">
          <select class="form-control custom-select active" id="cate_id3" name="subcat">
            <option value=""><?php echo __d('merchant','Select Category'); ?></option>
            <?php
            foreach($Sub_datas as $cats) {
            if($cats['id'] == $item['sub_catid'])
            echo "<option value=".$cats['id']." selected = 'selected'>".$cats['category_name']."</option>";
            else
            echo "<option value=".$cats['id'].">".$cats['category_name']."</option>";
          }
          ?>
        </select> 
        <small class="trn form-control-feedback f4-error f4-error-cate_id3"></small>
      </div>
      <?php } ?>
    </div>
  </div>




  <div class="form-group">
    <div class="box-addTitle"> <?php echo __d('merchant','MAKE IT FUN : UPLOAD PHOTOS!'); ?> </div>
    
    <dd style="padding: 20px 10px;border:1px solid #d4d4d4;width:100%;border-style: dashed;border-width:2px;">

      <?php 
      $image_computer = '';
      echo "<div class='input_wrap_popup'>";
        echo "<span class='bills additem-label'>";
         //echo __('Upload Photos:'); 
       echo "</span>";
       echo "<div class='imageuploader'>";
         echo '<div class="imageuploaderframe">';
           echo '<div id="uploadedimages">';
             foreach ($item['photos'] as $photoKey => $photo){
             $imageName = $photo['image_name'];
             $imageUrl = $media.'media/items/thumb350/'.$imageName;
             echo '<div class="item_images_" id="image_'.$photoKey.'" style="float:left;margin: 0 5px 5px;height:130px;">
              <img width="130px" height="130px" src="'.$imageUrl.'" id="show_url_'.$photoKey.'">
              <input type="hidden" name="data[image][]" id="image_computer_'.$photoKey.'" class="celeb_name" value="'.$imageName.'">
              <a href="javascript:void(0);" onclick="removeDynamicimg('.$photoKey.')" id="removeimg_'.$photoKey.'" style="bottom: 136px; left: 103px; position: relative; width: 25px; display: block;">
                <div style="background-color: #f3f3f3;border-radius: 20px;width:25px;color:#009efb;text-align:center;"><i class="fa fa-close remove_21"></i></div>
              </a>
            </div>';
          }
        echo '</div>';
        echo '<input id="imageCount" class="imageCount" type="hidden" value="'.count($item['photos']).'" name="imageCount">';
        echo '<input id="delimageCount" class="imageCount" type="hidden" value="'.count($item['photos']).'" name="imageCount">';
        $i = 25;
        echo '<div style="float:left;">';
         echo '<iframe class="image_iframe" id="frame_'.$i.'" name="frame'.$i.'" src="'.$site.'dynamicItemupload.php?image='.$i.'&media_url='.$media.'&site_url='.$site.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'&userid='.$userid.'" frameborder="0" height="130px" width="120px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;left: 5px;position: relative;"></iframe>';
       echo '</div>';

     echo '</div>';
   echo "</div>";
   
 echo "</div>";
 
 
 echo "<br clear='all' />";
 
 ?>          
</dd>
<small class="trn form-control-feedback f4-error f4-error-image"></small> 

</div>



<div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Product Title'); ?> </div>
  <input  id='title' name="item_title" type="text" class="form-control" placeholder="" value="<?php echo $item['item_title']; ?>" maxlength="80">
  <small class="trn form-control-feedback f4-error f4-error-title"></small> 
</div>

<div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Provide More Details About Your Product'); ?> </div>
  <input  id='description' name="item_description" type="textarea" class="form-control" placeholder="" value="<?php echo $item['item_description']; ?>">
  <small class="trn form-control-feedback f4-error f4-error-description"></small> 
</div>

<div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Add youtube video link (optional)');?> </div>
  <input  id='videourl' name="item_videourrl" type="text" class="form-control" placeholder="Type here to add" value="<?php echo $item['videourrl']; ?>">
  <small class="trn form-control-feedback f4-error f4-error-videourl"></small> 
</div>

<div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Barcode number'); ?> </div>
  <input  id='skuid' name="item_skuid" type="text" class="form-control" placeholder="" value="<?php echo $item['skuid']; ?>">
  <small class="trn form-control-feedback f4-error f4-error-skuid"></small> 
</div>

<div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Product Color'); ?> </div>
  <div class="col-md-4 p-l-0">
   <select class="form-control custom-select" id="detectmethod" name="colormethod" onchange="detect_method()">
    <option value=""><?php echo __d('merchant','Select');?></option>
    <?php if($item['item_color_method']=='0')
    { ?>
      <option value="auto" selected><?php echo __d('merchant','Auto Detection');?></option>
      <option value="manual"><?php echo __d('merchant','Choose Manually');?></option>
      <?php } else if($item['item_color_method']=='1') { ?>
      <option value="auto"><?php echo __d('merchant','Auto Detection');?></option>
      <option value="manual" selected><?php echo __d('merchant','Choose Manually');?></option>
      <?php } else { ?>
      <option value="auto"><?php echo __d('merchant','Auto Detection');?></option>
      <option value="manual"><?php echo __d('merchant','Choose Manually');?></option>
      <?php } ?>
    </select> 
  </div>
  <small class="trn form-control-feedback f4-error f4-error-detectmethod"></small> 
</div>

<?php $style = "";
if($item['item_color_method']!='1') {
$style ="display: none;";
}
?>

<div id="manual_select" class="form-group" style="<?php echo $style; ?>">
  <div class="box-addTitle"> <?php echo __d('merchant','Select Color'); ?> </div>
  <div class="row m-0">
   <div class="col-md-4 p-l-0">
    <select id="item_color_manual" multiple="multiple" class="form-control custom-select del-icon"  name="itemcolor[]" style="height: 90px;">
      <?php if($item['item_color_method']=='1')
      { 
        foreach($color_datas as $colors) {
        $item_colors = $item['item_color'];
        $itemcolors = json_decode($item_colors,true);
        if(in_array($colors['color_name'],$itemcolors))
        echo "<option value='".$colors['color_name']."' selected>".$colors['color_name']."</option>";
        else
        echo "<option value='".$colors['color_name']."'>".$colors['color_name']."</option>";
      }
    } else {
    foreach($color_datas as $colors){
    echo "<option value='".$colors['color_name']."'>".$colors['color_name']."</option>";
  }
}
?>
</select> 
</div>
<small class="trn form-control-feedback f4-error f4-error-item_color_manual"></small> 
</div>
</div>


<div class="form-group">
        <div class="box-addTitle"> <?php echo __d('merchant','Affiliate Commission')." (%) "; ?> </div>
        <div class="col-md-4 p-l-0">
        <input  id='affiliate_commission' name="affiliate_commission" type="text" class="form-control" placeholder="1 - 100 %" value="<?php echo $item['affiliate_commission']; ?>" onkeypress="return isNumber(event)" maxlength="3">
        </div>
        <small class="trn form-control-feedback f4-error f4-error-affiliate_commission"></small> 
      </div>

<?php if(!empty($item['size_options'])) { 
$yes_size_avail = "checked";
$no_size_avail = "";
$pricecontent = "display : none;";
$sizecontent = "display : block;";
} else {
$yes_size_avail = "";
$no_size_avail = "checked";
$pricecontent = "display : block;";
$sizecontent = "display : none;";
} ?>
<div class="form-group">
 <div class="box-addTitle"> <?php echo __d('merchant','Size Availability'); ?> </div>
 <div>
   <label class="custom-control custom-radio">
     <input id="deal" name="sizeavail" type="radio" value="yes" <?php echo $yes_size_avail; ?> class="custom-control-input" onclick="selectSizeavail(this)">
     <span class="custom-control-indicator"></span>
     <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?></span>
   </label>
   <label class="custom-control custom-radio">
     <input id="deal" name="sizeavail" type="radio" value="no" <?php echo $no_size_avail; ?> class="custom-control-input" onclick="selectSizeavail(this)">
     <span class="custom-control-indicator"></span>
     <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
   </label>     
 </div>
</div>
<div class="price-content" style="<?php echo $pricecontent; ?>">
  <div class="form-group">
    <div class="box-addTitle"> <?php echo __d('merchant','Product price'); ?> </div>
    <input  id='price' name="item_price" type="text" class="form-control" placeholder="" value="<?php if(trim($item['size_options']) =="") echo $item['price']; ?>" maxlength = "9">
    <small class="trn form-control-feedback f4-error f4-error-price"></small> 
  </div>

  <div class="form-group">
    <div class="box-addTitle"> <?php echo __d('merchant','Available quantity'); ?> </div>
    <input  id='quantity' name="item_quantity" type="text" class="form-control" placeholder="" value="<?php echo $item['quantity']; ?>" maxlength="3">
    <small class="trn form-control-feedback f4-error f4-error-quantity"></small> 
  </div>
</div>

<div class="size-content m-t-20" style="<?php echo $sizecontent; ?>">
  <div class="form-group">
    <div class="box-addTitle"> <?php echo __d('merchant',"Available Varients and It's Prices"); ?> </div>
    <div class="row m-0">
      <?php 
      $sizes = $item['size_options'];
      $size_option = json_decode($sizes, true);
      $size_val = array();
      $unit_val = array();
      $price_val = array();
      foreach($size_option['size'] as $key=>$val)
      {
        $size_val[] = $val;
      }
      foreach($size_option['unit'] as $key=>$val)
      {
        $unit_val[] = $val;
      }
      foreach($size_option['price'] as $key=>$val)
      {
        $price_val[] = $val;
      }
      echo '<br />';
      $count = count($size_val);

      //echo '<pre>'; print_r($size_val); die; 


      
      ?>

      <div id="sizeOption">

        <?php
        for($i=0;$i<$count;$i++)
        {
          if(preg_match('/[A-Za-z0-9]/', $size_val[$i])) {
            $size_newval = $size_val[$i];
          }else{
            $size_nam = base64_encode($size_val[$i]);
            $size_newval = str_replace('=', date('ymdhis'), $size_nam);
          }

          $size_newval = str_replace('=', date('ymdhis'), base64_encode($size_val[$i]));

          echo '<div style="height:auto;overflow:hidden;display:inline-flex;" id="tot'.$size_newval.'">';
            echo "<div class='box-innerBorder'>";
              echo "<span class='box-subTitle'> Property </span>";
              echo "<input id='sizepro".$size_val[$i]."' readonly='' class='form-control' placeholder='Ex: XL' value='".$size_val[$i]."' style='width:100px;' name='size[".$size_val[$i]."]' type='text'>";
              echo '<span class="box-subTitle m-l-20"> Units </span>';

              echo '<input id="sizeunits'.$size_val[$i].'" readonly="" name="unit['.$size_val[$i].']" class="form-control" placeholder="Ex: 10" onkeyup="chknum(this,event);" maxlength="3" style="width:100px;" value="'.$unit_val[$i].'" type="text">';

              echo '<span class="box-subTitle m-l-20"> Price </span>';
              echo '<input id="sizeprice'.$size_val[$i].'" class="form-control" placeholder="Ex: 500" onkeyup="chknum(this,event);" name="prices['.$size_val[$i].']" value="'.$price_val[$i].'" maxlength="6" style="width:100px;" readonly="" type="text">';
            echo '</div>';?>

            <div style="font-size: 18px;margin:auto 5px;">
              <a class="remove" style="color:#595959;" href="javascript:void(0)" id="remove<?php echo $size_val[$i]; ?>" onclick="edititemremovesizeoptions('<?php echo $size_newval; ?>')">
                <i class="fa fa-trash"></i>
              </a>
            </div>                            
            <?php echo '</div>'; }         
            ?>
            
          </div>
          <div class="box-innerBorder">
            <span class="box-subTitle"> <?php echo __d('merchant','Property'); ?> </span>
            <input  id='size_property' type="text" class="form-control" placeholder="Ex: XL" value="" name="listing[property]" style="width:100px;">
            <span class="box-subTitle m-l-20"> <?php echo __d('merchant','Units'); ?> </span>
            <input  id='size_units' type="text" class="form-control" placeholder="Ex: 10" onkeypress="return isNumber(event)" maxlength="3" name="listing[size]" style="width:100px;">
            <span class="box-subTitle m-l-20"> <?php echo __d('merchant','Price'); ?> </span>
            <input  id='size_price' type="text" class="form-control" placeholder="Ex: 500" onkeyup="chknum(this,event);" maxlength="6" name="price" style="width:100px;"><br/>
            <small id="sizeerr" class="trn form-control-feedback f4-error">
            </small>
          </div>
          <small id="sizeoptionerr" class="trn form-control-feedback f4-error f4-error-sizeoptionerr">
          </small>
        </div>
        <div id="add_more" style="display:inline-block; margin-left:10px; font-size:14px; color: #009efb; cursor: pointer; margin-top:10px; font-weight: 500;" onclick="sizeAdd()">
          + <?php echo __d('merchant','Add More Items'); ?>
        </div>
      </div>
    </div>

    <?php
    if($item['discount_type'] == 'daily') {
    $dailycheck = 'checked';
    $nocheck = '';
    $contectdisplay = '';
    $contectsdisplay = '';
    $discount = $item['discount'];
    $regulardiscount = '';
    $regular_content = "display:none;";
    $date = $item['dealdate'];
    // $dealdate = date('m/d/Y',strtotime($date));
    if(empty($date))
    $dealdate = date('m/d/Y');
    else
    $dealdate = date('m/d/Y',strtotime($date));
  } elseif($item['discount_type'] == 'regular'){
    $yescheck = '';
    $regularcheck = 'checked';
    $contectdisplay = 'display:none;';
    $contectsdisplay = '';
    $regular_content = "";
    $regulardiscount = $item['discount'];
    $dealdate = '';
  } else {
  $yescheck = '';
  $nocheck = 'checked';
  $regular_content = "display:none;";
  $contectdisplay = 'display:none;';
  //$contectdisplay = 'display:none;';
} 
?>
<div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Discounts'); ?> </div>
  <div>
   <label class="custom-control custom-radio">
     <input id="deal" name="deal" type="radio" value="daily" <?php echo $dailycheck; ?> class="custom-control-input" onclick="selectDeal(this)">
     <span class="custom-control-indicator"></span>
     <span class="custom-control-description"><?php echo __d('merchant','Daily Deals'); ?></span>
   </label>
   <label class="custom-control custom-radio">
     <input id="deal" name="deal" type="radio" value="regular" <?php echo $regularcheck; ?> class="custom-control-input" onclick="selectDeal(this)">
     <span class="custom-control-indicator"></span>
     <span class="custom-control-description"><?php echo __d('merchant','Regular discounts'); ?></span>
   </label>

   <label class="custom-control custom-radio">
     <input id="deal" name="deal" type="radio" value="no" <?php echo $nocheck; ?> class="custom-control-input" onclick="selectDeal(this)">
     <span class="custom-control-indicator"></span>
     <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
   </label>     
 </div>
 <small class="trn form-control-feedback f4-error f4-error-discount"></small> 
</div>

<div class="deal-content" style="<?php echo $contectdisplay; ?>">
 <div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Discount'); ?> (%) </div>
  <input  id='discount' name="discount" type="text" class="form-control" placeholder="" value="<?php echo $discount; ?>" maxlength="2" style="width:140px;" onkeypress="return isNumber(event)">
  <small class="trn form-control-feedback f4-error f4-error-discount"></small> 
</div>

<div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Date of your deal'); ?> </div>
  <input  id='dealstart' name="dealstart" type="text" class="form-control datepicker-autostart" placeholder="MM/DD/YYYY" value="<?php echo  $dealdate; ?>" style="width:140px;">
  <small class="trn form-control-feedback f4-error f4-error-dealstart"></small> 
</div>
</div>

<div class="deal-content-updated" style="<?php echo $regular_content; ?>">
 <div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Discount'); ?> (%) </div>
  <input  id='regular_discount' name="regular_discount" type="text" class="form-control" placeholder="" value="<?php echo $regulardiscount; ?>" maxlength="2" style="width:140px;" onkeypress="return isNumber(event)">
  <small class="trn form-control-feedback f4-error f4-error-regulardiscount"></small> 
</div>

</div>

<?php if($setngs['cod']=='enable' || $item['cod']=='yes')
{ 
  if($item['cod']=='yes') { 
  $yescod = "checked";
  $nocod = "";
} else {
$yescod = "";
$nocod = "checked";
}


?>

<div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Cash on delivery'); ?> </div>
  <div>
    <label class="custom-control custom-radio">
      <input id="cod" name="cod" type="radio" value="yes" <?php echo $yescod; ?> class="custom-control-input">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?></span>
    </label>
    <label class="custom-control custom-radio">
      <input id="cod" name="cod" type="radio" value="no" <?php echo $nocod; ?> class="custom-control-input">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
    </label>    
  </div>
</div>

<?php } ?>

<?php if($item['share_coupon'] == 'yes') {
$yescoupon = "checked";
$nocoupon = "";
$couponcontent = "";
} else {
$nocoupon = "checked";
$yescoupon = "";
$couponcontent = "display: none;";
}
?>

<div class="form-group">
  <div class="box-addTitle"> <?php echo __d('merchant','Discount on Facebook share'); ?> </div>
  <div>
   <label class="custom-control custom-radio">
     <input id="share" name="shareCoupon" type="radio" value="yes" <?php echo $yescoupon; ?> class="custom-control-input">
     <span class="custom-control-indicator"></span>
     <span class="custom-control-description"><?php echo __d('merchant','Yes'); ?></span>
   </label>
   <label class="custom-control custom-radio">
     <input id="share" name="shareCoupon" type="radio" value="no" <?php echo $nocoupon; ?> class="custom-control-input">
     <span class="custom-control-indicator"></span>
     <span class="custom-control-description"><?php echo __d('merchant','No'); ?></span>
   </label>

   <div class="m-b-10 m-t-10" id="sharediscount" style="<?php echo $couponcontent; ?>">
    <input  id='share_discountAmnt' name="share_discountAmnt" type="text" class="form-control" placeholder="Enter Value" maxlength="3" value="<?php if($item['share_discountAmount'] != 0 && $item['share_discountAmount'] != '') { echo $item['share_discountAmount']; } ?>" style="width:140px;" onkeypress="return isNumberdot(event)">
    
    <span style=""> % </span>
    <small class="trn form-control-feedback f4-error f4-error-share_discountAmnt">
    </small>
    <small class="trn form-control-feedback f4-success">
      <?php echo __d('merchant','Please update with your coupon percentange'); ?>                            
    </small>
  </div>  
</div>
</div>

<?php /*<div class="form-group">
  <div class="box-addTitle"> Available Varients and It's Prices </div>
  <div class="row m-0">
    <?php 
    $sizes = $item['size_options'];
    $size_option = json_decode($sizes, true);
    $size_val = array();
    $unit_val = array();
    $price_val = array();
    foreach($size_option['size'] as $key=>$val)
    {
      $size_val[] = $val;
    }
    foreach($size_option['unit'] as $key=>$val)
    {
      $unit_val[] = $val;
    }
    foreach($size_option['price'] as $key=>$val)
    {
      $price_val[] = $val;
    }
    echo '<br />';
    $count = count($size_val); ?>

    <div id="sizeOption">

      <?php
      for($i=0;$i<$count;$i++)
      {
        echo '<div style="height:auto;overflow:hidden;display:inline-flex;" id="tot'.$size_val[$i].'">';
          echo "<div class='box-innerBorder'>";
            echo "<span class='box-subTitle'> Property </span>";
            echo "<input id='sizepro".$size_val[$i]."' readonly='' class='form-control' placeholder='Ex: XL' value='".$size_val[$i]."' style='width:100px;' name='size[".$size_val[$i]."]' type='text'>";
            echo '<span class="box-subTitle m-l-20"> Units </span>';

            echo '<input id="sizeunits'.$size_val[$i].'" readonly="" name="unit['.$size_val[$i].']" class="form-control" placeholder="Ex: 10" onkeyup="chknum(this,event);" maxlength="3" style="width:100px;" value="'.$unit_val[$i].'" type="text">';

            echo '<span class="box-subTitle m-l-20"> Price </span>';
            echo '<input id="sizeprice'.$size_val[$i].'" class="form-control" placeholder="Ex: 500" onkeyup="chknum(this,event);" name="prices['.$size_val[$i].']" value="'.$price_val[$i].'" maxlength="6" style="width:100px;" readonly="" type="text">';
          echo '</div>';
          echo '<div style="font-size: 18px;margin:auto 5px;"><a class="remove" style="color:#595959;" href="javascript:void(0)" id="remove'.$size_val[$i].'" onclick="removesizeoption('.$size_val[$i].')"><i class="fa fa-trash"></i></a></div></div>';
        }         
        ?>
        
      </div>
      <div class="box-innerBorder">
        <span class="box-subTitle"> Property </span>
        <input  id='size_property' type="text" class="form-control" placeholder="Ex: XL" value="" name="listing[property]" style="width:100px;">
        <span class="box-subTitle m-l-20"> Units </span>
        <input  id='size_units' type="text" class="form-control" placeholder="Ex: 10" onkeyup="chknum(this,event);" maxlength="3" name="listing[size]" style="width:100px;">
        <span class="box-subTitle m-l-20"> Price </span>
        <input  id='size_price' type="text" class="form-control" placeholder="Ex: 500" onkeyup="chknum(this,event);" maxlength="6" name="price" style="width:100px;"><br/>
        <small id="sizeerr" class="trn form-control-feedback f4-error">
        </small>
      </div>
    </div>
    <div id="add_more" style="display:block; margin-left:10px; font-size:14px; color: #009efb; cursor: pointer; margin-top:10px; font-weight: 500;" onclick="sizeAdd()">
      + Add More Items
    </div>
  </div> */ ?>
  <?php /*
  <div class="row p-0">
    <div class="form-group col-lg-6 col-md-6 col-sm-6">
      <div class="box-addTitle"> <?php echo __d('merchant','Which Gender The Product For ?'); ?> </div>
      <div class="row m-0">
        <div class="col-md-8 p-l-0">
          <select class="form-control custom-select" id="gender" name="occasion">
            <option value=""><?php echo __d('merchant','Select Gender');?></option>
            <?php
            $gender_type = $setngs['gender_type'];
            $gen_type = json_decode($gender_type,true);
            $gen_id = trim($item['occasion']);
            for($i=0;$i<count($gen_type);$i++)
            {
              if($gen_id != "" && $gen_id == $i)
              echo '<option value='.$i.' selected>'.$gen_type[$i].'</option>';
              else
              echo '<option value='.$i.'>'.$gen_type[$i].'</option>';
            }
            ?>
          </select>
          <small class="trn form-control-feedback f4-error f4-error-gender"></small> 
        </div>
      </div>
    </div>

                      <!-- div class="form-group col-lg-6 col-md-6 col-sm-6">
                        <div class="box-addTitle"> Relationship</div>
                        <div class="row m-0">
                           <div class="col-md-10 p-l-0">
                              <select class="form-control custom-select del-icon" multiple="multiple" id="rship" name="recipient[]" style="height:90px;">
                                <?php /*
                                  $receipent = json_decode($item['recipient'],true);
                                  foreach($rcpnt_datas as $rcpnt){
                                    if(in_array($rcpnt['id'],$receipent)) {
                                      echo "<option value='".$rcpnt['id']."' selected>".$rcpnt['recipient_name']."</option>";
                                    } else {
                                      echo "<option value='".$rcpnt['id']."'>".$rcpnt['recipient_name']."</option>";
                                    }
                                  }*/
                               /* ?>
                              </select>
                              <div class="m-t-10" style="font-size:11px;"><?php // echo __('To whom is it for?'); ?><span class="optional"><?php // echo __(' choose multiple by pressing ctrl'); ?></span></div>
                               <small class="trn form-control-feedback f4-error f4-error-rship"></small> 
                          </div>
                        </div>
                      </div -->
                    </div> */ ?>

                    <div class="row p-0">
                      <div class="form-group col-lg-6 col-md-6 col-sm-6">
                        <div class="box-addTitle"> <?php echo __d('merchant','Delivered Within'); ?> </div>
                        <div class="row m-0">
                          <div class="col-md-10 p-l-0">
                            <?php 
                            $process = $item['processing_time'];
                            ?>
                            <select class="form-control custom-select" id="processing_time" name="processing_time_id">
                              <option value=""><?php echo __d('merchant','Ready to delivery'); ?>...</option>
                              <optgroup label="----------------------------"></optgroup>
                              <option value="1d" <?php if ($process == '1d') { echo "selected"; } ?>>1 <?php echo __d('merchant','business day'); ?></option>
                              <option value="2d" <?php if ($process == '2d') { echo "selected"; } ?>>1-2 <?php echo __d('merchant','business days'); ?></option>
                              <option value="3d" <?php if ($process == '3d') { echo "selected"; } ?>>1-3 <?php echo __d('merchant','business days'); ?></option>
                              <option value="4d" <?php if ($process == '4d') { echo "selected"; } ?>>3-5 <?php echo __d('merchant','business days'); ?></option>
                              <option value="2ww" <?php if ($process == '2ww') { echo "selected"; } ?>>1-2 <?php echo __d('merchant','weeks'); ?></option>
                              <option value="3w" <?php if ($process == '3w') { echo "selected"; } ?>>2-3 <?php echo __d('merchant','weeks'); ?></option>
                              <option value="4w" <?php if ($process == '4w') { echo "selected"; } ?>>3-4 <?php echo __d('merchant','weeks'); ?></option>
                              <option value="6w" <?php if ($process == '6w') { echo "selected"; } ?>>4-6 <?php echo __d('merchant','weeks'); ?></option>
                              <option value="8w" <?php if ($process == '8w') { echo "selected"; } ?>>6-8 <?php echo __d('merchant','weeks'); ?></option>
                            </select>
                            <small class="trn form-control-feedback f4-error f4-error-processing_time"></small> 
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-lg-6 col-md-6 col-sm-6">
                        <div class="box-addTitle"> <?php echo __d('merchant','Ships To'); ?> </div>
                        <div class="row m-0">
                          <div class="col-md-12 p-l-0">
                            <select class="form-control custom-select" id="selct_lctn_bxs" name="ship_from_country">
                              <option value=""><?php echo __d('merchant','Select a location'); ?></option>
                              <?php
                              foreach($cntry as $cnty){
                              if($item['ship_from_country'] == $cnty['id']){
                              echo "<option value='".$cnty['id']."' selected>".$cnty['country']."</option>";
                            }else{
                            echo "<option value='".$cnty['id']."' >".$cnty['country']."</option>";
                          }
                        }
                        ?>
                      </select>
                      <small class="trn form-control-feedback f4-error f4-error-selct_lctn_bxs"></small> 
                    </div>
                  </div>
                </div>
              </div> 

              <div class="row p-0">
                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                  <div class="box-addTitle"> <?php echo __d('merchant','Ship Details'); ?> </div>
                  <div class="set-shipping-rates" style="margin:0px;">
                    <table class="shipping-rates msm" id="shpng_div">
                      <thead>
                        <tr>
                          <th class="ship-to text-center"><?php echo __d('merchant','Ships to'); ?></th>
                          <th class="text-center"><?php echo __d('merchant','Cost');?></th>
                          <th class="text-center"><?php echo __d('merchant','');?></th>
                        </tr>
                      </thead>
                      <tbody> 
                        <?php
                        $everyWhere = 0;
                        $default_ship_count = 0;
                        foreach ($item['shipings'] as $shiping) {
                        if ($shiping['country_id'] == 0) { ?>
                        <tr class="new-shipping-location E">       
                          <td id="E" style="width: 250px;">         
                            <div class="input-group-location">     
                              <span><?php echo __d('merchant','Everywhere else'); ?></span>     
                              <a href="#" class="tt-trigger">?</a>     
                              <div class="tt">         
                                <div class="tt-inner">            
                                  <p><?php echo __d('merchant','Sets the shipping costs for EVERY country not covered by country specific shipping costs. This is optional.');?> </p> 
                                  <span class="tt-arrow"></span>         
                                </div>     
                              </div>                             
                              <input type="hidden" value="true" name="everywhere_shipping[enabled]">
                            </div>         
                            <div class="regions-box"></div>       
                          </td>      
                          <td style="max-width: 250px;" class="p-t-10">           
                            <div class="input-group-price price-input primary-shipping-price" style="display: inline-flex;">  <span style="margin:auto 10px;"><?php echo $sellercurrencysymbol; ?></span>               
                              <input type="text" value="<?php echo $shiping['primary_cost'];?>" class="money form-control" onkeyup="chknum(this,event);" maxlength="6" name="everywhere_shipping[1][primary]">            
                            </div>       
                          </td>
                          <td class="input-group-close" style="width: 150px;">      
                            <div class="primary-shipping-price text-center" style="font-size: 18px;">
                              <a class="remove" href="javascript:void(0)" id="E"  style="color: #595959; font-size: 18px;">
                                <span class="fa fa-trash"> </span>
                              </a>
                            </div> 
                          </td>  
                        </tr>   
                        <?php $everyWhere = 1; } else { ?>
                        <?php if ($shiping['country_id'] != $sellercountryid) { ?>
                        <tr class="new-shipping-location <?php echo $shiping['country_id']; ?>">       
                          <td id="<?php echo $shiping['country_id']; ?>" style="width: 250px;">        
                            <div class="input-group-location"><?php echo $countryName[$shiping['country_id']]; ?></div>         
                            <div class="regions-box"></div>       
                          </td>       
                          <td style="max-width: 250px;" class="p-t-10">          
                            <div class="input-group-price price-input primary-shipping-price" style="display: inline-flex;"> 
                              <span style="margin:auto 10px;"><?php echo $sellercurrencysymbol; ?></span>              
                              <input type="text" value="<?php echo $shiping['primary_cost'];?>" onkeyup="chknum(this,event);" maxlength="6" class="money form-control" name="country_shipping[<?php echo $shiping['country_id']; ?>][0][primary]">            
                            </div>       
                          </td>     
                          
                          <td class="input-group-close" style="width: 150px;">       
                            <div class="primary-shipping-price text-center">
                              <a class="remove" href="javascript:void(0)" id="<?php echo $shiping['country_id']; ?>" style="color: #595959; font-size: 18px;">
                                <span class="fa fa-trash"> </span>
                              </a>
                            </div> 
                          </td>
                        </tr>
                        <?php } else {
                        $default_ship_count = 1;
                        ?>
                        <tr class="new-shipping-location <?php echo $shiping['country_id']; ?>">       
                          <td id="<?php echo $shiping['country_id']; ?>" style="width: 250px;">        
                            <div class="input-group-location"><?php echo $countryName[$shiping['country_id']]; ?> <span class="m-l-10">( <?php echo __d('merchant','default'); ?> )</span></div>         
                            <div class="regions-box"></div>       
                          </td>       
                          <td style="max-width: 250px;" class="p-t-10">          
                            <div class="input-group-price price-input default-shipping-price" style="display: inline-flex;"> 
                              <span style="margin:auto 10px;"><?php echo $sellercurrencysymbol; ?></span>              
                              <input type="text" value="<?php echo $shiping['primary_cost'];?>" onkeyup="chknum(this,event);" maxlength="6" class="money form-control" name="country_shipping[<?php echo $shiping['country_id']; ?>][0][primary]">            
                            </div>       
                          </td>     
                          
                          <td class="input-group-close" style="width: 150px;">       
                            <div class="primary-shipping-price text-center">
                              <a href="javascript:void(0)" id="<?php echo $shiping['country_id']; ?>" style="color: #595959; font-size: 18px;">
                                <span class="glyphicons "> </span>
                              </a>
                            </div> 
                          </td>
                        </tr>

                        <?php } } } 
                        if($default_ship_count == 0) { 
                        ?>
                        <tr class="new-shipping-location <?php echo $sellercountryid; ?>">       
                          <td id="<?php echo $sellercountryid; ?>" style="width: 250px;">        
                            <div class="input-group-location"><?php echo $sellercountry; ?> <span class="m-l-10">( <?php echo __d('merchant','default'); ?> )</span></div>         
                            <div class="regions-box"></div>       
                          </td>       
                          <td style="max-width: 250px;" class="p-t-10">          
                            <div class="input-group-price price-input default-shipping-price" style="display: inline-flex;"> 
                              <span style="margin:auto 10px;"><?php echo $sellercurrencysymbol; ?></span>              
                              <input type="text" value="" onkeyup="chknum(this,event);" maxlength="6" class="money form-control" name="country_shipping[<?php echo $sellercountryid; ?>][0][primary]">            
                            </div>       
                          </td>     
                          
                          <td class="input-group-close" style="width: 150px;">       
                            <div class="primary-shipping-price text-center">
                              <a href="javascript:void(0)" id="<?php echo $sellercountryid; ?>" style="color: #595959; font-size: 18px;">
                                <span class="glyphicons "> </span>
                              </a>
                            </div> 
                          </td>
                        </tr>
                        <?php }

                        if ($everyWhere != 1) { ?>
                        <tr class="new-shipping-location E" style="width: 250px;">       
                          <td id="E" style="width: 250px;">         
                            <div class="input-group-location">     
                              <span><?php echo __d('merchant','Everywhere else'); ?></span>     
                              
                              <input type="hidden" value="true" name="everywhere_shipping[enabled]">
                            </div>         
                            <div class="regions-box"></div>       
                          </td>      
                          <td style="max-width: 250px;" class="p-t-10">           
                            <div class="input-group-price price-input primary-shipping-price" style="display: inline-flex;">   
                              <span style="margin:auto 10px;"><?php echo $sellercurrencysymbol; ?></span>         
                              <input type="text" value="" class="money form-control" onkeyup="chknum(this,event);" maxlength="6" name="everywhere_shipping[1][primary]">            
                            </div>       
                          </td>      

                          <td class="input-group-close" style="width: 150px;">       
                            <div class="primary-shipping-price text-center">
                              <a class="remove" href="javascript:void(0)" id="E" style="color: #595959; font-size: 18px;">
                                <span class="fa fa-trash"> </span>
                              </a>
                            </div> 
                          </td>  
                        </tr>
                        <?php }
                        ?>
                      </tbody>

                    </table>
                    <small id="shipcosterror" class="trn form-control-feedback f4-error m-t-10"></small> 

                    <small class="trn form-control-feedback f4-error f4-error-itemformerror"></small> 
                  </div>
                </div>
              </div>

              <input type='hidden' id="default_currency_symbol" value="<?php echo $sellercurrencysymbol; ?>" />
              <input type="hidden" id="incrmt_val" value="3" />
              <input type="hidden" id="addlocntn" value="2" />

              <div class="col-md-12 m-c-auto text-center">
               <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo __d('merchant','Submit'); ?> </button>
               <a href="<?php echo MERCHANT_URL; ?>/editproducts" type="button" class="btn btn-danger"> <?php echo __d('merchant','Reset'); ?> </a>
             </div>



             <?php echo $this->Form->end(); ?>
           </div>
           <!-- LEFT COLUMN ENDS-->

           <!-- RIGHT COLUMN STARTS-->
           <div class="col-lg-4 col-md-4 col-sm-12 ">
            <div class="box-lt-title text-center"><?php echo __d('merchant','SELLER TIPS'); ?></div>
            <ul class="box-lt-message">
             <li><?php echo __d('merchant',"Be original. What's different about what you have to offer ?"); ?> </li>
             <li><?php echo __d('merchant','Be as specific as you can about the service you are offering and exactly what the Buyer will receive if they purchase your Hourlie'); ?>.</li>
             <li><?php echo __d('merchant','Set a realistic delivery timeframe. Late delivery will lead to unhappy Buyers and will affect your rankings'); ?>.</li>
             <li> <?php echo __d('merchant','Make your Hourlie stand out with great quality images or even video illustrating the service that you are offering'); ?>.</li>
             <li> <?php echo __d('merchant','Make sure your Hourly meets all other posting policies'); ?>.</li>
           </ul>

           <div class="box-lt-title text-center m-t-30"><?php echo __d('merchant','COMMISSIONS'); ?></div>
           <div class="table-design m-t-10">
             <table id="tabledesign" style="border:none; width:100%; text-align:center;">
              <thead class="m-b-10">
               <tr style="border:none; color:#000;">
                <th style=""><?php echo __d('merchant','Price'); ?></th>
                <th style=""><?php echo __d('merchant','Commission'); ?></th>
                <th style=""><?php echo __d('merchant','Type'); ?></th>
              </tr style="border:none;">
            </thead>
            <tbody>
             <?php 
             foreach($commisionrate as $val){
             $min=$val['min_value'];
             $max=$val['max_value'];
             $type=$val['type'];
             $amount=$val['amount'];
             $des=$val['commission_details'];
             echo "<tr>";
               echo "<td style='border:none;'>".$min."-".$max."</td>";
               echo "<td style='border:none;text-align:center;'>".$amount."</td>";
               echo "<td style='border:none;text-align:center;'> ".$type."</td>";
             echo "</tr>";
           } 
           ?>  
                           <!-- tr>  
                              <td>1000 - 2000 </td>
                              <td>50000</td>
                              <td>%</td>
                           </tr>
                           <tr>  
                              <td>1000 - 2000 </td>
                              <td>50000</td>
                              <td>%</td>
                            </tr -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- RIGHT COLUMN ENDS -->

                  </div>
                </div>
              </div>
            </div>
          </div>
          <style>
          .tt {
            background-color: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.25);
            color: #333333;
            display: none;
            font-size: 12px;
            margin-top: 5px;
            padding: 5px;
            position: absolute;
            text-align: justify;
            width: 200px;
            z-index: 21;
          }
        </style>
        <script>
          $( ".tt-trigger" ).mouseover(function() {
            $(".tt").show();
          });
          $( ".tt-trigger" ).mouseout(function() {
            $(".tt").hide();
          });
        </script>
        <script>
         jQuery('.datepicker-autostart').datepicker({
          format: 'mm/dd/yyyy',
          autoclose: true,
          todayHighlight: true
        });

         $(document).ready(function(){
          $( "#datepicker-autostart" ).on("keypress", function(){
            return false;
          });
        });
      </script>
      <script>
        tinymce.init({selector:'#description',
          plugins: ["lists paste"],
          toolbar: "undo redo | bold italic | bullist numlist outdent indent",
          paste_as_text: true,
          menubar : false
        });
      </script>

      <script>
        $(document).ready(function(){
          var oldskuid = $("#skuid").val();
          $("#skuid").blur(function(){
            var skuid = $("#skuid").val();
            var itemid = $("#itemid").val();
            var userid = $("#userid").val();
            var BaseURL=getBaseURL();
            if($.trim(skuid) != "" && ($.trim(oldskuid) != $.trim(skuid))) {
              $.ajax({
                type: "POST",
                url: BaseURL+'merchant/checkskuid',
                data: {"skuid":skuid,'itemid':itemid,'userid':userid},

        /*beforeSend: function() {
        $(".submitbtn").attr("disabled", "disabled");
      },*/

      success: function(responce) {
        if($.trim(responce) == "exists"){
          var sessionlang = $("#languagecode").val();
          var translator = $('body').translate({t: dict});
          $(".f4-error-skuid").removeAttr('data-trn-key');
          $(".f4-error-skuid").show();
          $("#skuid").val("");
          $(".f4-error-skuid").text("Code Number already exists");
          translator.lang(sessionlang);
          $("#skuid").keydown(function(){
            $(".f4-error-skuid").hide();
            $(".f4-error-skuid").text("");
          });
          return false;
        } else {
          return true;  
        }   
      }

    });
            }
          });
        });

        function sizeAdd() {
         var property = $('#size_property').val();
         var unit = $('#size_units').val();
         var price = $('#size_price').val();
         var validChecker = true;
         var sessionlang = $("#languagecode").val();
         var translator = $('body').translate({t: dict});
         prop = property.replace(/ /g,"-");


         Baseurl = getBaseURL();
         if(property=='' && unit=='' && price==''){
          $("#sizeerr").show();
          $("#sizeerr").removeAttr('data-trn-key');
          $('#sizeerr').text('Give Property and Units');
          translator.lang(sessionlang);
          setTimeout(function() {
            $('#sizeerr').fadeOut('slow');
          }, 5000);    
          return false;   
        } 
        if (unit.localeCompare(Math.round(unit))) {
          $("#sizeerr").show();
          $("#sizeerr").removeAttr('data-trn-key');
          $('#sizeerr').text('Please enter valid unit for the item');
          translator.lang(sessionlang);
          setTimeout(function() {
            $('#sizeerr').fadeOut('slow');
          }, 5000);    
          return false;   
        } else if(unit < 1) {
          $("#sizeerr").show();
          $("#sizeerr").removeAttr('data-trn-key');
          $('#sizeerr').text('Unit Should not be less than 1');
          translator.lang(sessionlang);
          setTimeout(function() {
            $('#sizeerr').fadeOut('slow');
          }, 5000);    
          return false;
        }
        else if(price == "")
        {
          $("#sizeerr").show();
          $("#sizeerr").removeAttr('data-trn-key');
          $('#sizeerr').text('Price value should not be empty');
          translator.lang(sessionlang);
          setTimeout(function() {
            $('#sizeerr').fadeOut('slow');
          }, 5000);    
          return false;   
        }
        else if(price<1)
        {
          $("#sizeerr").show();
          $("#sizeerr").removeAttr('data-trn-key');
          $('#sizeerr').text('Price value should be at least 1');
          translator.lang(sessionlang);
          setTimeout(function() {
            $('#sizeerr').fadeOut('slow');
          }, 5000);    
          return false;   
        }
        else if(price > 0) {
          var number = price.split('.');
          if(number.length == 1 && price.localeCompare(Math.round(price))) {
            msg = "Price with zeros or invalid decimal value at beginning is not allowed";  validChecker = false;
          } else if(number.length > 1 && number[0].localeCompare(Math.round(number[0]))) {
            msg = "Price with zeros or invalid decimal value at beginning is not allowed";  validChecker = false;
          }
          if(number.length > 1 && number[1].length == 0) {
            msg = "Decimal price value is not valid"; validChecker = false;
          } else if(number[0].length > 6) {
            msg = "Decimal price value should not exceed 999999 (6 digit)"; validChecker = false;
          }

          if(validChecker == false) {
            $("#sizeerr").show();
            $("#sizeerr").removeAttr('data-trn-key');
            $('#sizeerr').text(msg);
            translator.lang(sessionlang);
            setTimeout(function() {
              $('#sizeerr').fadeOut('slow');
            }, 5000);    
            return false;
          }  
        }
        if(property != '' && unit != '' && price!='')
        {
          var format = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;

          
          origprop = property;
          if(format.test(property) == true)
          {
            let converstr = btoa(property);
            property = converstr.replace(/=/g, makeid(3));
            existsize = $("#sizeOption").find("#tot"+property).html();  
            let inputname = origprop;
          }else{
            existsize = $("#sizeOption").find("#tot"+property).html();
            property = property;
            let inputname = origprop;
          }
          //existsize = $("#tot"+property).html();

          //alert(existsize);
          //return false;
          if(existsize!=null)
          {
            $("#sizeerr").show();
            $("#sizeerr").removeAttr('data-trn-key');
            $('#sizeerr').text('Size already exists');
            translator.lang(sessionlang);
            setTimeout(function() {
              $('#sizeerr').fadeOut('slow');
            }, 5000);
            return false;
          }
          else
          {
            var htms = '<div style="height:auto;overflow:hidden;display:inline-flex;" id="tot'+property+'"><div class="box-innerBorder"><span class="box-subTitle"> Property </span>';

            if(format.test(origprop) == true)
            {
            htms += '<input id="sizePro" readonly class="form-control" placeholder="Ex: XL" value="'+origprop+'" style="width:100px;" name="size['+origprop+']" type="text">';
            }else{
              htms += '<input id="sizePro" readonly class="form-control" placeholder="Ex: XL" value="'+origprop+'" style="width:100px;" name="size['+origprop+']" type="text">';
            }

            htms += '<span class="box-subTitle m-l-20"> Units </span>';

            htms += '<input id="size_units'+unit+'" readonly name="unit['+origprop+']" class="form-control" placeholder="Ex: 10" onkeypress="return isNumber(event)" maxlength="3" style="width:100px;" type="text" value="'+unit+'">';

            htms += '<span class="box-subTitle m-l-20"> Price </span>';

            htms += '<input id="size_price'+price+'" class="form-control" placeholder="Ex: 500" onkeyup="chknum(this,event);" name="prices['+origprop+']" value="'+price+'" maxlength="6" style="width:100px;" type="text" readonly>';
            htms += '</div>';
            
            htms += '<div style="font-size: 18px;margin:auto 5px;"><a class="remove" style="color:#595959;" href="javascript:void(0)" id="'+property+'"><i class="fa fa-trash"></i></a></div></div>';
           
            
            
            $("#sizeOption").append(htms);  
      //$("#size_option_org").hide();
      $("#add_more").show();
      $('#size_property').val('');
      $('#size_units').val('');
      $('#size_price').val('');
      
      if(format.test(property) == true)
            {
      $("#"+btoa(property)).on('click',function(){
        //alert(this.id);
        //$("."+property).remove();
          //alert("#tot"+btoa(property)); return false;
          $("#tot"+btoa(property)).attr('style','');  
          $("#tot"+btoa(property)).remove();  
        
        
        //$("."+unit).remove();
        //$("."+price).remove();
        //$("#"+property).remove();
        return false;
      });
    }else{
       $("#"+property).on('click',function(){
        //alert(this.id);
        //$("."+property).remove();
          //alert("#tot"+btoa(property)); return false;
          $("#tot"+property).attr('style','');  
          $("#tot"+property).remove();  
        
        
        //$("."+unit).remove();
        //$("."+price).remove();
        //$("#"+property).remove();
        return false;
      });
    }
    }
  }   
}


function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

$("#selct_lctn_bxs").change(function(){
  var incrmt_val = $("#incrmt_val").val();
  incrmt_val++;
  $('.f4-error-selct_lctn_bxs').hide();
  var sessionlang = $("#languagecode").val();
  var translator = $('body').translate({t: dict});
  
  var lctn = $("#selct_lctn_bxs :selected").val();
  var lctn_name = $("#selct_lctn_bxs :selected").text();
  var default_currency = $("#default_currency_symbol").val();

  if ($('#shpng_div tbody tr').hasClass(lctn)){
    $(".f4-error-selct_lctn_bxs").removeAttr('data-trn-key');
    $('.f4-error-selct_lctn_bxs').html("Country already exist");
    translator.lang(sessionlang);
    $('.f4-error-selct_lctn_bxs').show();
    return;
  } else if (lctn == '') {
    return;
  }

  var htms = '<tr class="new-shipping-location '+lctn+'">';
  htms += '<td id="'+lctn+'" style="width: 250px;">';
  htms += '<div class="input-group-location">'+lctn_name+'</div>';
  htms += '<div class="regions-box"></div>';
  htms += '</td>';      
  htms += '<td class="p-t-10" style="max-width: 250px;">';
  htms += '<div class="input-group-price price-input primary-shipping-price" style="display:inline-flex;">';
  htms += '<span style="margin:auto 10px;">'+default_currency+' </span>';
  htms += '<input type="text" value="" class="money form-control" onkeyup="chknum(this,event);" maxlength="6" name="country_shipping['+lctn+']['+incrmt_val+'][primary]">';
  htms += '</div>';
  htms += '</td>';  
  htms += '<td class="input-group-close">';
  htms += '<div class="primary-shipping-price text-center"><a class="remove" href="javascript:void(0)" id='+lctn+' style="color: #595959; font-size: 18px;"><span  class="fa fa-trash"> </span></a></div>';
  htms += '</td>';
  htms += '</tr> ';
  
  $("#shpng_div tbody").prepend(htms);  
  $("#incrmt_val").val(incrmt_val);
  document.getElementById('selct_lctn_bxs').selectedIndex = "";
});


$("#cate_id").change(function(){
  var cate_id = $("#cate_id :selected").val();
  var catedata = $("#cate_id").val();
  var langcat = $("#mainsubcat_lang").val();
  //var Baseurl = getBaseURL();
  var url = location.href;
  var Baseurl = url.substring(0, url.indexOf('/', 40));
  var items="";
  /* latest fixes 4.1 */
  $("#categ-container-2").hide();
  $("#cate_id2").html(""); 
  $("#categ-container-3").hide();
  $("#cate_id3").html(""); 
  /* latest fixes 4.1 */
  if(cate_id != ''){
   $.getJSON(Baseurl+"/merchant/suprsubcategry?cate_id="+cate_id+"&suprsub=yes",function(data){
    if(data!="0")
    {
      items+="<option value=''> "+langcat+" </option>";
      $.each(data,function(index,cate) 
      {
        if(cate.Name != undefined){
          items+="<option value='"+cate.ID+"'>"+cate.Name+"</option>";
        }
      });

      $("#categ-container-2").show();
      $("#cate_id2").html(items);
      if(!$("#cate_id2").hasClass('active'))
        $("#cate_id2").addClass('active');
    }
    else
    {
      $("#categ-container-2").hide();
      $("#cate_id2").html("");
      if($("#cate_id2").hasClass('active'))
        $("#cate_id2").removeClass('active');
      if($("#cate_id3").hasClass('active'))
        $("#cate_id3").removeClass('active');
    }
  });
 }else{
  $("#cate_id2").html("");
  if($("#cate_id2").hasClass('active'))
    $("#cate_id2").removeClass('active');
  if($("#cate_id3").hasClass('active'))
    $("#cate_id3").removeClass('active');
}   
if($.trim(catedata) == ''){
  $("#categ-container-2").hide();
  $("#cate_id2").html(""); 
  $("#categ-container-3").hide();
  $("#cate_id3").html(""); 
}

});

$("#cate_id2").change(function(){
  var cate_id = $("#cate_id2 :selected").val();
  var catedata = $("#cate_id2").val();
  var langcat = $("#mainsubcat_lang").val();
  //var Baseurl = getBaseURL();
  var url = location.href;
  var Baseurl = url.substring(0, url.indexOf('/', 40));
      // alert(cate_id);
      var items="";
      if(cate_id != ''){
       $.getJSON(Baseurl+"/merchant/suprsubcategry?cate_id="+cate_id+"&suprsub=no",function(data){
          //alert(data);
          // return false;
          if(data!=0 && data!="")
          {
            items+="<option value=''> "+langcat+" </option>";
            $.each(data,function(index,cate) 
            {
              if(cate.Name != undefined){
                items+="<option value='"+cate.ID+"'>"+cate.Name+"</option>";
              }
            });
            $("#categ-container-3").show();
            $("#cate_id3").html(items); 
            if(!$("#cate_id3").hasClass('active'))
              $("#cate_id3").addClass('active');
          }
          else
          {
            $("#categ-container-3").hide();
            $("#cate_id3").html(""); 
            if($("#cate_id3").hasClass('active'))
              $("#cate_id3").removeClass('active');
          }
        });
     }else{
      $("#cate_id3").html(''); 
      if($("#cate_id3").hasClass('active'))
        $("#cate_id3").removeClass('active');

    } 
    if($.trim(catedata) == ''){
     $("#categ-container-3").hide();
     $("#cate_id3").html(""); 
   }
 }); 


</script>
