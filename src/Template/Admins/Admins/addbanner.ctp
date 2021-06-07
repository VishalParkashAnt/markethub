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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Banner'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>

                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Add Banner'); ?></li>
                                    </ol>
                                </div>


         </div>
    </div>




<?php
	echo "<div class='containerdiv'>";
		
		echo $this->Form->Create('Banner',array('url'=>array('controller'=>'/admins','action'=>'/addbanner'),'id'=>'bannerform'));
			echo "<div id='alert' class='error'></div>"; ?>
				<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Add Banner'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">

				<?php
echo '<div class="row" style="display:none;">';
	echo '<div class="col-lg-5 col-xlg-4 col-md-6">
	<h5 class="card-title" style="margin-bottom:0px">'.__d('admin', 'Banner Place : Gift Card ').'</h5><span style="font-size: 15px; color:red">(Max-width:314px)</span><br>';
		if($giftName) {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name1','value'=>$giftName));
		}
		else {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name1'));
		}
		echo '<b>'.__d('admin', 'Html Source:').'</b>';echo '<br/>';
		if($giftSource){
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source1" value="">'.$giftSource.'</textarea>';
		}
		else
		{
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source1" ></textarea>';
		}
		echo '<input type="hidden" name="banner_type1" value="giftcard">';
		if($giftStatus == "Active") {
		echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio" checked="checked" value="Active" class="inputform status" id="statusActive" name="status1" style="margin-right:3px">' .__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio"  value="Inactive" class="inputform status" id="statusInactive" name="status1" style="margin-right:3px">' .__d('admin', 'De-active').'&nbsp;	
		</label>';
		} else {
		echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio"  value="Active" class="inputform status" id="statusActive" name="status1" style="margin-right:3px">' .__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio" checked="checked" value="Inactive" class="inputform status" id="statusInactive" name="status1" style="margin-right:3px">' .__d('admin', 'De-active').'&nbsp;	
		</label>';
		}
	echo '</div>';

	echo '<div class="col-lg-4 col-xlg-5 col-md-3">';
		echo '<img class="img-responsive" src="'.SITE_URL.'images/Type1.png">';
	echo '</div>';
echo '</div>';

echo '<div class="row" style="display:none;">';
	echo '<div class="col-lg-5 col-xlg-4 col-md-6">
	<h5 class="card-title" style="margin-bottom:0px">'.__d('admin', 'Banner Place : Product page ').'</h5><span style="font-size: 15px; color:red">(Max-width:314px)</span><br>';
		if($productName) {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name2','value'=>$productName));
		}
		else {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name2'));
		}
		echo '<b>'.__d('admin', 'Html Source:').'</b>';echo '<br/>';
		if($productSource){
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source2" value="">'.$productSource.'</textarea>';
		}
		else
		{
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source2" ></textarea>';
		}
		echo '<input type="hidden" name="banner_type2" value="product">';
		if($productStatus == "Active") {
	echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio" checked="checked" value="Active" class="inputform status" id="statusActive" name="status2">                                           '.__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio"  value="Inactive" class="inputform status" id="statusInactive" name="status2">
			'.__d('admin', 'De-active').'&nbsp;	
		</label>';
		} else {
		echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio"  value="Active" class="inputform status" id="statusActive" name="status2">
			'.__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio" checked="checked" value="Inactive" class="inputform status" id="statusInactive" name="status2">
			'.__d('admin', 'De-active').'&nbsp;	
		</label>';
		}
	echo '</div>';

	echo '<div class="col-lg-4 col-xlg-5 col-md-3">';
		echo '<img class="img-responsive" src="'.SITE_URL.'images/Type2.png">';
	echo '</div>';
echo '</div>';

echo '<div class="row">';
	echo '<div class="col-lg-5 col-xlg-4 col-md-6">
	<h5 class="card-title" style="margin-bottom:0px">'.__d('admin', 'Banner Place : Filter Page').'</h5> <span style="font-size: 15px; color:red">(Width:960px;Height:200px)</span><br>';
		if($shopName) {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name3','value'=>$shopName));
		}
		else {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name3'));
		}
		echo '<b>'.__d('admin', 'Html Source:').'</b>';echo '<br/>';
		if($shopSource){
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source3" value="">'.$shopSource.'</textarea>';
		}
		else
		{
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source3" ></textarea>';
		}
		echo '<input type="hidden" name="banner_type3" value="shop">';
		if($shopStatus == "Active") {
		echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio" checked="checked" value="Active" class="inputform status" id="statusActive" name="status3">
			'.__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio"  value="Inactive" class="inputform status" id="statusInactive" name="status3">
			'.__d('admin', 'De-active').'&nbsp;	
		</label>';
		} else {
		echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio"  value="Active" class="inputform status" id="statusActive" name="status3">
			'.__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio" checked="checked" value="Inactive" class="inputform status" id="statusInactive" name="status3">
			'.__d('admin', 'De-active').'&nbsp;	
		</label>';
		}
	echo '</div>';

	echo '<div class="col-lg-4 col-xlg-5 col-md-3">';
		echo '<img class="img-responsive" src="'.SITE_URL.'images/Type3456.png">';
	echo '</div>';
echo '</div>';

echo '<div class="row" style="display:none;">';
	echo '<div class="col-lg-5 col-xlg-4 col-md-6">
	<h5 class="card-title" style="margin-bottom:0px">'.__d('admin', 'Banner Place : Find Friends').'</h5><span style="font-size: 15px; color:red"> (Width:960px;Height:200px))</span><br>';
		if($findName) {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name4','value'=>$findName));
		}
		else {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name4'));
		}
		echo '<b>'.__d('admin', 'Html Source:').'</b>';echo '<br/>';
		if($findSource){
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source4" value="">'.$findSource.'</textarea>';
		}
		else
		{
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source4" ></textarea>';
		}
		echo '<input type="hidden" name="banner_type4" value="findfriends">';
		if($findStatus == "Active") {
	echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio" checked="checked" value="Active" class="inputform status" id="statusActive" name="status4">
			'.__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio"  value="Inactive" class="inputform status" id="statusInactive" name="status4">
			'.__d('admin', 'De-active').'&nbsp;	
		</label>';
		} else {
		echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio"  value="Active" class="inputform status" id="statusActive" name="status4">
			'.__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio" checked="checked" value="Inactive" class="inputform status" id="statusInactive" name="status4">
			'.__d('admin', 'De-active').'&nbsp;	
		</label>';
		}
	echo '</div>';

	echo '<div class="col-lg-4 col-xlg-5 col-md-3">';
		echo '<img class="img-responsive" src="'.SITE_URL.'images/Type3456.png">';
	echo '</div>';
echo '</div>';

echo '<div class="row" style="display:none;">';
	echo '<div class="col-lg-5 col-xlg-4 col-md-6">
	<h5 class="card-title" style="margin-bottom:0px">'.__d('admin', 'Banner Place : Invite Friends').'</h5><span style="font-size: 15px; color:red"> (Width:960px;Height:200px)</span><br>';
		if($inviteName) {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name5','value'=>$inviteName));
		}
		else {
		echo $this->Form->input('banner_name',array('type'=>'text','label'=>__d('admin', 'Banner Name'),'id'=>'banner_name1','class'=>'form-control','name' => 'banner_name5'));
		}
		echo '<b>'.__d('admin', 'Html Source:').'</b>';echo '<br/>';
		if($inviteSource){
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source5" value="">'.$inviteSource.'</textarea>';
		}
		else
		{
			echo '<textarea rows="7" class="form-control" cols="41" name="html_source5" ></textarea>';
		}
		echo '<input type="hidden" name="banner_type5" value="invitefriends">';
		if($inviteStatus == "Active") {
	echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio" checked="checked" value="Active" class="inputform status" id="statusActive" name="status5">
			'.__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio"  value="Inactive" class="inputform status" id="statusInactive" name="status5">
			'.__d('admin', 'De-active').'&nbsp;	
		</label>';
		} else {
	echo '<label style="margin-right:10px;">'.__d('admin', 'Status:').'</label>
		<label>
			<input type="radio"  value="Active" class="inputform status" id="statusActive" name="status5">
			'.__d('admin', 'Active').'&nbsp;	
		</label>
		<label>
			<input type="radio" checked="checked" value="Inactive" class="inputform status" id="statusInactive" name="status5">
			'.__d('admin', 'De-active').'&nbsp;	
		</label>';
		}
	echo '</div>';

	echo '<div class="col-lg-4 col-xlg-5 col-md-3">';
		echo '<img class="img-responsive" src="'.SITE_URL.'images/Type3456.png">';
	echo '</div>';
echo '</div>';


			

			echo $this->Form->submit(__d('admin', 'Submit'),array('class'=>'btn btn-info reg_btn'));
		echo $this->Form->end();
	echo "</div>";
?>

		</div>
				</div><!--/span-->

			</div><!--/row-->




 </div>

  </div>

</div>

</div>

  </div>

</div>
