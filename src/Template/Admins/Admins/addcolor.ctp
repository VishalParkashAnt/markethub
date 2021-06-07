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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Colors'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>managecolors"><?php echo __d('admin', 'Colors'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Add Color'); ?></li>
                                    </ol>
                                </div>


         </div>
    </div>





<?php
	echo "<div class='containerdiv'>";


		echo $this->Form->Create('Color',array('url'=>array('controller'=>'/admins','action'=>'/addcolor'),'id'=>'Categoryform','onsubmit'=>'return addcolorform()'));
		?>
				<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Add Color'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">
                        	<?php

			echo $this->Form->input('colorname',array('type'=>'text','maxlength'=>'20','label'=> __d('admin', 'Color Name'),'id'=>'Color_name','class'=>'form-control'));
			?>
		</div></div>
		<br clear="all" />
		 <div class="row">
                        <div class="col-md-6">
                        	<label class="control-label"><?php echo __d('admin', 'RGB Range'); ?></label>
			<br clear="all" />
			<input type="text" maxlength="3" name="rgbval1" class="form-control" style="width:60px !important;" onkeyup="chknum(this,event)">
			<input type="text" maxlength="3" name="rgbval2" class="form-control" style="width:60px !important;" onkeyup="chknum(this,event)">
			<input type="text" maxlength="3" name="rgbval3" class="form-control" style="width:60px !important;" onkeyup="chknum(this,event)">

		</div></div>
		<br clear="all" />
			<?php
			echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
			echo '<div id="colorerr" class="trn" style="font-size:13px;color:red;"></div>';
		echo $this->Form->end();

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
