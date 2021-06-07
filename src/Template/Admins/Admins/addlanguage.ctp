<?php
use Cake\Routing\Router;
?>


  <body class="">
  <!--<![endif]-->

<div class="content">
<?php
$baseurl = Router::url('/');
?>

			<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'User'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>managelanguage"><?php echo __d('admin', 'Manage Languages'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Add Language'); ?></li>
                                    </ol>
                                </div>


         </div>
    </div>



		<?php
		echo $this->Form->Create('Language',array('url'=>array('controller'=>'/admins','action'=>'/addlanguage'),'id'=>'languageform','onsubmit'=>'return addlanguageform();'));
		?>
	<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Add Language'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">
 <div class="form-group">

				<label><?php echo __d('admin', 'Country'); ?></label>
		<select name="countryid" id="countryname" class="form-control">
			<option value=""><?php echo __d('admin', 'Select a location...'); ?></option>
			<?php
				foreach($country_datas as $cnty){
					//if($cntryid[$cntry_code] == $cnty['id']){
					//echo "<option value='".$cnty['id']."' selected>".$cnty['country']."</option>";
					//}else{
					echo "<option value='".$cnty['id']."' >".$cnty['country']."</option>";
					//}
				}
			?>

		</select></div>
	</div></div>
	   <div class="row">
                        <div class="col-md-6">
 <div class="form-group">

		<?php
		echo $this->Form->input('countrycode',array('label'=>__d('admin', 'Currency Code'),'options' => array('' => __d('admin', 'Select Currency'),'AUD' => 'AUD', 'BRL' => 'BRL', 'CAD' => 'CAD', 'CZK' => 'CZK', 'DKK' => 'DKK', 'EUR' => 'EUR', 'HKD' => 'HKD', 'HUF' => 'HUF', 'ILS' => 'ILS', 'JPY' => 'JPY', 'MYR' => 'MYR', 'MXN' => 'MXN', 'NOK' => 'NOK', 'NZD' => 'NZD', 'PHP' => 'PHP', 'PLN' => 'PLN', 'GBP' => 'GBP', 'RUB' => 'RUB', 'SGD' => 'SGD', 'SEK' => 'SEK', 'CHF' => 'CHF', 'TWD' => 'TWD', 'THB' => 'THB', 'TRY' => 'TRY', 'USD' => 'USD' ), 'id' => 'countrycode','class'=>'form-control'));
		echo '</div></div></div>';
		echo '<div class="row">
                        <div class="col-md-6">
 <div class="form-group">';
			//echo $this->Form->input('countrycode',array('type'=>'text','label'=>'Currency Code','id'=>'countrycode','class'=>'inputform1'));
			echo $this->Form->input('languagecode',array('type'=>'text','label'=>__d('admin', 'Language Code'),'id'=>'languagecodes','class'=>'form-control','maxlength'=>'3'));
			echo '</div></div></div>';
			echo '<div class="row">
                        <div class="col-md-6">
 <div class="form-group">';
			echo $this->Form->input('languagename',array('type'=>'text','label'=>__d('admin', 'Language Name'),'id'=>'languagename','class'=>'form-control'));
			echo '</div></div></div>';



			echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn' ));
				echo '<div style="font-size:13px;color:red;" class="trn" id="langerr"></div>';
		echo $this->Form->end();

	echo "</div>";
?>


</div>

</div>

</div>

</div>

</div>

</div>

<style>

.show_hid{
	display:none;
}
</style>
