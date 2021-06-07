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
                                     
                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Social Page Settings'); ?></li>
                                    </ol>
                                </div>

             
         </div>
    </div>

				
			
	<?php
	echo "<div class='containerdiv'>";
		echo $this->Form->Create('Socialpage',array('url'=>array('controller'=>'/admins','action'=>'/socialpagesetting')));
			echo '<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white">'.__d('admin', 'Social Page Settings').'</h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
					<h4 class="card-title">'.__d('admin', 'Instagram').'</h4>';
					echo '<div class="row">
                                            <div class="col-md-6">
                                                ';
				echo $this->Form->input('instagram_link',array('type'=>'text','label'=>__d('admin', 'Instagram Page'),'class'=>'form-control','value'=>$socialLink['instagram_link']));
				echo '<div></div></div></div>
					<h4 class="card-title">'.__d('admin', 'Facebook').'</h4>';
					echo '<div class="row">
                                            <div class="col-md-6">
                                                ';
				echo $this->Form->input('facebook_link',array('type'=>'text','label'=>__d('admin', 'Facebook Page'),'class'=>'form-control','value'=>$socialLink['facebook_link']));
						echo '<div></div></div></div>
					<h4 class="card-title">'.__d('admin', 'Twitter').'</h4>';
					echo ' <div class="row">
                                            <div class="col-md-6">
                                                ';
				echo $this->Form->input('twitter_link',array('type'=>'text','label'=>__d('admin', 'Twitter Page'),'class'=>'form-control','value'=>$socialLink['twitter_link']));
					echo '<div></div></div></div>';
				
			
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

