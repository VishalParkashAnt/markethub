<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>

 <div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Taxes'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>admin/taxrates"><?php echo __d('admin', 'Tax Rates'); ?></a></li>
                      <li class="breadcrumb-item"><?php echo __d('admin', 'Add Tax'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Add Tax'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">






<body class="">
    <!--<![endif]-->





<?php
	echo "<div class='containerdiv'>";


		echo $this->Form->Create('Tax',array('url'=>array('controller'=>'/','action'=>'/admins/addtax'),'id'=>'Categoryform','onsubmit'=>'return addtaxform()'));
		?>
		 <div class="row">
                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo __d('admin', 'Country'); ?></label>

		<select name="countryid" id="selct_lctn_bxs" class="form-control custom-select">
			<option value=""><?php echo __d('admin', 'Select a location...'); ?></option>
			<?php
				foreach($country_datas as $cnty){
					if($cntryid[$cntry_code] == $cnty['id']){
					echo "<option value='".$cnty['id']."' selected>".$cnty['Country']['country']."</option>";
					}else{
					echo "<option value='".$cnty['id']."' >".$cnty['country']."</option>";
					}
				}
			?>

		</select>
			<?php
			echo $this->Form->input('taxname',array('type'=>'text','maxlength'=>'20','label'=>__d('admin', 'Tax Name:'),'id'=>'tax_name','class'=>'form-control'));
			echo $this->Form->input('percentage',array('type'=>'text','maxlength'=>'20','label'=>__d('admin', 'Percentage (%) :'),'id'=>'percentage','class'=>'form-control'));
			echo $this->Form->input('Status', array('options' => array('enable' => __d('admin', 'Enable'), 'disable' => __d('admin', 'Disable')),'class' =>'form-control'));
  echo'</div>    </div> <div class="col-lg-12"> <div class="form-group">';
			echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
			echo '<div id="taxerr" class="trn" style="font-size:13px;color:red;"></div>';
		echo $this->Form->end();
	echo "</div></div></div>";
?>


</div>

</div>

</div>
</div></div>


<style>

.show_hid{
	display:none;
}
</style>
