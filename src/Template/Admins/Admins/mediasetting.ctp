<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Media Management'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Media Management'); ?></a></li>
                     
                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Media Management'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    


	
						<div class="row-fluid">		
				<div class="box span12">

					<div class="box-content">



				
	
			
	<?php
	echo "<div class='containerdiv'>";
		echo $this->Form->Create('Sitesetting',array('url'=>array('controller'=>'/admins','action'=>'/mediasetting'),'id'=>'mediaform','onsubmit'=>'return mediavalidate();'));
			
			 echo '<div class="row">
                        <div class="col-md-6">
                        ';
				
				echo $this->Form->input('media_url',array('type'=>'text','label'=>__d('admin', 'Media URL'),'id'=>'media_url','class'=>'form-control','value'=>$site_datas['media_url']));
				echo '</div></div>';
				echo '<span style="font-size: 12px; opacity: 0.7;"><b style="color: red;">'.__d('admin', 'Note:').'</b> '.__d('admin', 'Instead of giving a Url like this').' <b style="color:red;">'.__d('admin', '(http://dev.example.com/default/)').'</b><br>'.__d('admin', 'Give it as ').'
							<b style="color:green;">'.__d('admin', '(http://example.com/dev/default/)').'</b><br></span>';
							 echo '<div class="row">
                        <div class="col-md-6">
                        ';
				
				echo $this->Form->input('media_server_hostname',array('type'=>'text','label'=>__d('admin', 'Media server Host Name'),'id'=>'media_server_hostname','class'=>'form-control','value'=>$site_datas['media_server_hostname']));
				echo '</div></div>';
				 echo '<div class="row">
                        <div class="col-md-6">
                        ';
				echo $this->Form->input('media_server_username',array('type'=>'text','label'=>__d('admin', 'Media server ftp Username'),'id'=>'media_server_username','class'=>'form-control','value'=>$site_datas['media_server_username']));
				echo '</div></div>';
				 echo '<div class="row">
                        <div class="col-md-6">
                        ';
				echo $this->Form->input('media_server_password',array('type'=>'password','label'=>__d('admin', 'Media server ftp Password'),'id'=>'media_server_password','class'=>'form-control','value'=>$site_datas['media_server_password']));
				
				echo '</div></div>'; ?>

				<div class="row">
					<div class="col-md-6">
						<div id="mediaerr_alrt" class="m-t-10 trn" style="font-size: 13px; color: red; display: none;"></div>
					</div>
				</div>

				<?php 
				
			echo $this->Form->submit(__d('admin', 'Submit'),array('div'=>false,'class'=>'btn btn-info m-t-10 reg_btn'));
		echo $this->Form->end();
	echo "</div>";
?>
					</div>
				</div><!--/span-->
			
			</div>						



<style>
	
.show_hid{
	display:none;
}
</style>


   </div></div></div>
     

    
        </div>
    </div>
</div>
    


    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>
