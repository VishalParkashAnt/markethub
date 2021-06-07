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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Currency'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>managecurrency"><?php echo __d('admin', 'Currency'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Edit Currency'); ?></li>
                                    </ol>
                                </div>


         </div>
    </div>



<?php
	echo "<div class='containerdiv'>";
    $id = $currency_data['id'];
		echo $this->Form->Create('Currency',array('url'=>array('controller'=>'/admins','action'=>'/editcurrency/'.$id),'id'=>'Categoryform','onsubmit'=>'return Price()'));

		//echo $this->Form->Create('pricerange',array('id'=>'Categoryform','onsubmit'=>'return Price_range();'));
		?>
			<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Edit Currency'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">
                        	<?php
			//echo $this->Form->input('from',array('type'=>'text','label'=>'Price Range From','id'=>'Category_name','class'=>'inputform'));
			//echo $this->Form->input('to',array('type'=>'text','label'=>'Price Range To','id'=>'Category_name','class'=>'inputform'));
			echo $this->Form->input('price',array('type'=>'text','label'=>__d('admin', 'Rate'),'id'=>'inputform1','class'=>'form-control','value' => $currency_data['price']));
			echo '</div></div> ';
			echo '<br>';

			echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn' ));
		echo $this->Form->end();
		echo '<div style="font-size:13px;color:red;" class="trn" id="priceerr"></div>';
	echo "</div>";
?>


</div>

</div>

</div>

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
