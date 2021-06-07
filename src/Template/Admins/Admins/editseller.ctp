<body class="">
<?php
   use Cake\Routing\Router;
$baseurl = Router::url('/');

?>


 <div class="content">
 	 <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Nonapproved Seller'); ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>nonapprovedseller"><?php echo __d('admin', 'Nonapproved Seller'); ?></a></li>
             <li class="breadcrumb-item active"><?php echo __d('admin', 'Edit Seller'); ?></li>
         </ol>
        </div>
         </div>
   			<?php

	echo "<div class='containerdiv'>";
		echo $this->Form->Create('merchant',array('url'=>array('controller'=>'admins','action'=>'editseller/'.$shopModel['id']), 'id'=>'sellerchk','onsubmit'=>'return sellersignupfrm()'));

		?>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
             <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Edit Seller'); ?></h4>
            </div>
        <div class="card-block">
            <div class="form-body">
                <div class="form-group">

<?php

		echo '<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">';
					echo "<label>".__d("admin", "Brand")."</label>";

					echo "<input type='text' id='brand_name' name ='brand_name' class='form-control' maxlength='180' value='".$shopModel['shop_name']."'>";
				echo '<div class="brand_name-error adminitemerror trn" style="color:red"></div>';

				echo '</div></div></div>';



			echo '<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">';
					echo "<label>".__d("admin", "Merchant Name")."</label>";
					echo $this->Form->input('merchant_name',array('type'=>'text','label'=>false,'id'=>'merchant_name','class'=>'form-control','value'=>$shopModel['merchant_name']));


				echo '<div class="merchant_name-error adminitemerror trn" style="color:red"></div>';
					echo '</div></div></div>';
				echo ' <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">';



					echo "<label>".__d("admin", "Braintree Id")."</label>";
					echo $this->Form->input('braintree_id',array('type'=>'text','label'=>false,'id'=>'stripeId','class'=>'form-control','value'=>$shopModel['braintree_id']));

					echo '<div class="stripeId-error adminitemerror trn" style="color:red"></div>';
					echo '</div></div></div>';

			echo '<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">';
					echo "<label>".__d("admin", "Phone Number")."</label>";
					echo $this->Form->input('person_phone_number',array('type'=>'text','label'=>false,'id'=>'person_phone_number','class'=>'form-control','value'=>$shopModel['phone_no']));


				echo '<div class="person_phone_number-error adminitemerror trn" style="color:red"></div></div>';
					echo '</div></div></div>';
			echo ' <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">';
					echo "<label>".__d("admin", "Office Address")."</label>";
					echo $this->Form->input('officeaddress',array('type'=>'textarea','label'=>false,'id'=>'officeaddress','class'=>'form-control','value'=>$shopModel['shop_address']));


				echo '<div class="officeaddress-error adminitemerror trn" style="color:red"></div>';
					echo '</div></div></div>';
				echo ' <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">';
					echo "<label>".__d("admin", "Latitude")."</label>";
					echo $this->Form->input('bankaccountno',array('type'=>'text','label'=>false,'id'=>'latid','class'=>'form-control','value'=>$shopModel['shop_latitude']));


				echo '<div class="latid-error adminitemerror trn" style="color:red"></div>';
					echo '</div></div></div>';
				echo ' <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">';
					echo "<label>".__d("admin", "Longitude")."</label>";
					echo $this->Form->input('mpowerid',array('type'=>'text','label'=>false,'id'=>'longid','class'=>'form-control','value'=>$shopModel['shop_longitude']));


				echo '<div class="longid-error adminitemerror trn" style="color:red"></div>';
					echo '</div></div></div>';

			?>
	<input type="hidden" name="status" value="<?php echo $shopModel['seller_status']; ?>" />
			<?php
				echo "<div id='alert' style='color:red;margin-top:15px;'></div>";

			echo $this->Form->submit(__d('admin', 'Submit'),array('class'=>'btn btn-info reg_btn'));
			echo "<div class='form-error trn' style='color:red;'></div>";
		echo $this->Form->end();
	echo "</div>";
?>
<style>

.show_hid{
	display:none;
}

</style>


   	 </div>

  </div>

</div>
	 </div>

  </div>

</div>	 </div>

  </div>

</div>