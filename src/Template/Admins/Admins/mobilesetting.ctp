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
<?php echo __d('admin', 'Mobile Apps Settings'); ?>

</h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>

                                        <li class="breadcrumb-item active">
<?php echo __d('admin', 'Manage Apps Links'); ?>

</li>
                                    </ol>
                                </div>


         </div>
    </div>




		<?php
		//$_SESSION['Auth']['Admin']['language_settings']['languages'];
$androidLink = $androidurl;
$iosLink = $iosurl;

		echo $this->Form->Create('mobile',array('url'=>array('controller'=>'/admins',
				'action'=>'/mobilesetting')));
		?>

		<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Manage Apps Links'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">
				<?php echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
        echo $this->Form->input('android_app_url',array('type'=>'text','value'=>$androidLink,'id'=>'androidLink','class'=>'form-control','label'=>''.__d('admin','Android App Url').''));
      echo '</div></div></div>';

      echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
        echo $this->Form->input('ios_app_url',array('type'=>'text','value'=>$iosLink,'id'=>'iosLink','class'=>'form-control','label'=>''.__d('admin','Ios App Url').''));
      echo '</div></div></div>';  ?>
			</div></div>
			<?php echo "<div class='addurlerror error trn'></div>"; ?>
			<div class="form-group">
		<?php echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn' ));
		echo $this->Form->end();
	?></div>
	</div>		</div>
				</div><!--/span-->

			</div><!--/row-->
						<!-----Mobile Apps Settings------->





</div>

</div>

</div>




<style>

.show_hid{
	display:none;
}
</style>
