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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Site Settings'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>

                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Social Id Settings'); ?></li>
                                    </ol>
                                </div>


         </div>
    </div>




	<?php
	echo "<div class='containerdiv'>";
		echo $this->Form->Create('Socialid',array('url'=>array('controller'=>'/admins','action'=>'/socialsetting')));

		echo '<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white">'.__d('admin', 'Social Id Settings').'</h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
					<h4 class="card-title">'.__d('admin', 'Facebook Settings').'</h4>';
					echo '<div class="row">
                                            <div class="col-md-6">
                                               ';
				echo $this->Form->input('FB_ID',array('type'=>'text', 'label'=>__d('admin', 'FB Id'),'class'=>'form-control','value'=>$socialId['FB_ID']));
				echo '<div></div></div></div>';
					echo '<div class="row">
                                            <div class="col-md-6">
                                                ';
				echo $this->Form->input('FB_SECRET',array('type'=>'text','label'=>__d('admin', 'FB Secret'),'class'=>'form-control','value'=>$socialId['FB_SECRET']));
				echo '<div></div></div></div>';


				echo '<h4 class="card-title">'.__d('admin', 'Twitter Settings').'</h4>';
					echo '<div class="row">
                                            <div class="col-md-6">
                                               ';
				echo $this->Form->input('TWITTER_ID',array('type'=>'text','label'=>__d('admin', 'Twitter Id'),'class'=>'form-control','value'=>$socialId['TWITTER_ID']));
				echo '<div></div></div></div>';
				echo '<div class="row">
                                            <div class="col-md-6">
                                               ';
				echo $this->Form->input('TWITTER_SECRET',array('type'=>'text','label'=>__d('admin', 'Twitter Secret'),'class'=>'form-control','value'=>$socialId['TWITTER_SECRET']));
				echo '<div></div></div></div>';
				echo '</fieldset>';

				echo '<fieldset>
					<h4 class="card-title">'.__d('admin', 'Google Settings').'</h4>';
					echo '<div class="row">
                                            <div class="col-md-6">
                                                ';
				echo $this->Form->input('GOOGLE_ID',array('type'=>'text','label'=>__d('admin', 'Google Id'),'class'=>'form-control','value'=>$socialId['GOOGLE_ID']));
				echo '<div></div></div></div>';
				echo '<div class="row">
                                            <div class="col-md-6">
                                                ';
				echo $this->Form->input('GOOGLE_SECRET',array('type'=>'text','label'=>__d('admin', 'Google Secret'),'class'=>'form-control','value'=>$socialId['GOOGLE_SECRET']));
				echo '<div></div></div></div>';
				echo '</fieldset>';

				echo '<fieldset>
					<h4 class="card-title">'.__d('admin', 'Gmail Settings').'</h4>';
					echo ' <div class="row">
                                            <div class="col-md-6">
                                                ';
				echo $this->Form->input('GMAIL_CLIENT_ID',array('type'=>'text','label'=>__d('admin', 'Gmail Client Id'),'class'=>'form-control','value'=>$socialId['GMAIL_CLIENT_ID']));
				echo '<div></div></div></div>';
				echo ' <div class="row">
                                            <div class="col-md-6">
                                                ';
				echo $this->Form->input('GMAIL_CLIENT_SECRET',array('type'=>'text','label'=>__d('admin', 'Gmail Client Secret'),'class'=>'form-control','value'=>$socialId['GMAIL_CLIENT_SECRET']));
				echo '<div></div></div></div>';
				echo '</fieldset>';

			echo "</div>";
			echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
		echo $this->Form->end();
	echo "</div>"; ?>


					</div>
				</div><!--/span-->

			</div><!--/row-->
	</div>
				</div><!--/span-->

			</div><!--/row-->



<style>

.show_hid{
	display:none;
}
</style>
