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
            <h3 class="text-themecolor m-b-0 m-t-0">
<?php echo __d('admin', 'Manage Modules'); ?>

</h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>

                                        <li class="breadcrumb-item active">
<?php echo __d('admin', 'Manage Modules'); ?>

</li>
                                    </ol>
                                </div>


         </div>
    </div>

	<?php
	echo "<div class='containerdiv'>";

	echo $this->Form->Create('Managemodule',array('url'=>array('controller'=>'/admins',
				'action'=>'/managemodules')));
		//echo $this->Form->Create('Managemodule',array('url'=>array('controller'=>'/','action'=>'/managemodules')));
		?>
		<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Manage Modules'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">


			<?php echo "<div id='forms'>";
				echo $this->Form->input('id',array('type'=>'hidden','class'=>'inputform','value'=>$modeule_datas['id']));

				if(empty($modeule_datas['display_banner'])){
					$status = 'no';
				}else{
					$status = $modeule_datas['display_banner'];
				}

				  echo '<div class="row">
                        <div class="col-md-6">';



				if($modeule_datas['display_banner']=="yes")
				echo '<label>'.__d('admin', 'Display Banner').'</label><br />
				<label for="display_bannerYes">
					<input type="radio" checked="checked" value="yes" class="inputform status" id="display_bannerYes" name="display_banner">
					'.__d('admin', 'Yes').'
				</label>
				<label for="display_bannerNo">
					<input type="radio" value="no" class="inputform status" id="display_bannerNo" name="display_banner">
					'.__d('admin', 'No').'
				</label>';
				else
				echo '<label>'.__d('admin', 'Display Banner').'</label><br />
				<label for="display_bannerYes">
					<input type="radio" value="yes" class="inputform status" id="display_bannerYes" name="display_banner">
					'.__d('admin', 'Yes').'
				</label>
				<label for="display_bannerNo">
					<input type="radio" checked="checked" value="no" class="inputform status" id="display_bannerNo" name="display_banner">
					'.__d('admin', 'No').'
				</label>';

				echo '</div></div>';
			if($demo_active!="yes")
			{
				if(empty($modeule_datas['site_maintenance_mode'])){
					$mode = 'no';
				}else{
					$mode = $modeule_datas['site_maintenance_mode'];
				}
				  echo '<div class="row">
                        <div class="col-md-6">';
				if($modeule_datas['site_maintenance_mode']=="yes")
			echo '<label>'.__d('admin', 'Site Maintenance Mode').'</label><br />
				<label>
					<input type="radio" checked="checked" value="yes" class="inputform status" id="display_bannerYes" name="site_maintenance_mode">
					'.__d('admin', 'Yes').'
				</label>
				<label>
					<input type="radio" value="no" class="inputform status" id="display_bannerNo" name="site_maintenance_mode">
					'.__d('admin', 'No').'
				</label>';
				else
					echo '<label>'.__d('admin', 'Site Maintenance Mode').'</label><br />

				<label>
					<input type="radio" value="yes" class="inputform status" id="display_bannerYes" name="site_maintenance_mode">
					'.__d('admin', 'Yes').'
				</label>
				<label>
					<input type="radio" checked="checked" value="no" class="inputform status" id="display_bannerNo" name="site_maintenance_mode">
					'.__d('admin', 'No').'
				</label>';
				echo '</div></div>';

				  echo '<div class="row">
                        <div class="col-md-6">';
				echo $this->Form->input('maintenance_text',array('type'=>'text','label'=>__d('admin','Text to be displayed when site is under maintenance'),'id'=>'maintenance_text','name'=>'maintenance_text','class'=>'form-control','value'=>$modeule_datas['maintenance_text']));
				echo '</div></div>';
			}


			echo $this->Form->submit(__d('admin','Update'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
		echo $this->Form->end();
	echo "</div>";
?>

					</div>
				</div><!--/span-->

			</div><!--/row-->
				</div>
				</div><!--/span-->

			</div><!--/row-->
				</div>
				</div><!--/span-->

			</div><!--/row-->
						<!-----Manage Modules------->



   </div></div></div>


