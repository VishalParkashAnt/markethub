<body class=""> 
<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Coupons'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	admin/managecoupon"><?php echo __d('admin', 'Coupons'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Edit Coupon'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<body class=""> 
  <!--<![endif]-->
     
   
	<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Edit Coupon'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
   
   
 
 

            
  

<?php
		echo $this->Form->Create('Coupon',array( 'onsubmit' => 'return couponform();'),array('url'=>array('controller'=>'/','action'=>'/admins/editcoupon/'.$getcouponval['id'].'/'.$getcouponval['couponcode']),'id'=>'couponform'));?>

		 <div class="row">
         <div class="col-md-6">
         <div class="form-group">
         <label class="control-label" id="coupon_code" name="coupon_code"><?php echo __d('admin', 'Coupon Code'); ?></label>
        <input type="text" disabled="true" id="couponcodes" class="form-control" name="couponcode" value="<?php echo $getcouponval['couponcode'];?>" maxlength=20>
         </div></div></div>
       
          <div class="row">
         <div class="col-md-6">
         <div class="form-group">
         <label class="control-label" id="range" name="range"><?php echo __d('admin', 'Coupon Usage'); ?></label>
        <input type="text" id="couponrange" class="form-control" name="couponrange" value="<?php echo $getcouponval['validrange'];?>" maxlength=20>
         </div></div></div>
          <div class="row">
         <div class="col-md-6">
         <div class="form-group">
         <label class="control-label" id="startdate" name="startdate"><?php echo __d('admin', 'Start date'); ?></label>
        <input type="text" id="deal-start" class="form-control mydatepicker" name="fromdate" value="<?php echo $getcouponval['validfromdate'];?>" maxlength=20 placeholder="<?php echo __d('admin', 'mm/dd/yyyy'); ?>">
         </div></div></div>
          <div class="row">
         <div class="col-md-6">
         <div class="form-group">
         <label class="control-label" id="enddate" name="startdate"><?php echo __d('admin', 'Expire date'); ?></label>
        <input type="text" id="deal-end" class="form-control mydatepicker" name="enddate" value="<?php echo $getcouponval['validtodate'];?>" maxlength=20 placeholder="<?php echo __d('admin', 'mm/dd/yyyy'); ?>">
         </div></div></div>


		<?php
	
			echo $this->Form->input('coupontype',array('type'=>'hidden','name'=>'coupontype','value'=>'percent','class'=>'form-control'));
			//echo $this->Form->input('amount',array('type'=>'text','maxlength'=>'20','label'=>'Discount amount:','class'=>'inputform'));
			echo '<label>'.__d('admin', 'Discount percentage(%):').'<span class="currency_symbol"></span></label>';
			echo "<input type='text' maxlength='3' name='amount' id='amountss' value='".$getcouponval['discount_amount']."' class='form-control'>";
				
			echo "<input type='hidden' value='0' name='select_merchant' id='select_merchant'>";
			//echo '<select name="select_merchant" id="select_merchant" >';
				//echo '<option value="0">Apply Coupon to All product</option>';
				//echo '<option value="1">Apply Coupon to Select Merchant</option>';
			//echo '</select>	';
			
			echo '<br clear="all" />';
			?>
			<div id="invoice-popup-overlayss" style="display:none;">
			<div class="invoice-popup">
			<div id="merchantdetails_all">
			<table>
			<tr>
			<td>
			<?php foreach($getmerchant_name as $shopname){
				echo '<span style=" margin-top: 10px; ">';
					echo "<input type='checkbox' name='merchant_id[]' value='".$shopname['user_id']."' >";
					echo $shopname['shop_name']."<br />";
				echo '</span>';
			}
						
			
			echo '<a id="save_merchant" href="#"><input type="button"  class="btn btn-primary" value="'.__d('admin', 'Save').'"></a>';
			
			?>
			</td>
			</tr>			
			</table>
			</div>
			</div>
			</div>
			<?php
			
			echo '<br />';
			echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
			echo '<div id="couponerr" style="display:none;font-size:13px;color:red;"></div>';
		echo $this->Form->end();
	echo "</div>";
?>

					</div>
				</div><!--/span-->
			
			</div><!--/row-->
					
			





</div>




<style>
	
.show_hid{
	display:none;
}
</style>
<script>
var invajax=0;
</script>
 <?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
  <?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>
  <script>
 jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });</script>