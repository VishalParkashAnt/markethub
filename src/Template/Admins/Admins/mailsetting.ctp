<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Email Management'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Email Management'); ?></a></li>
                     
                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Email Management'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    


	
						<div class="row-fluid">		
				<div class="box span12">

					<div class="box-content">


				
	
			
	<?php
	if($demo_active=="yes")
		$readonly = "readonly";
	else if($demo_active=="no")
		$readonly = "";
	
	echo "<div class='containerdiv'>";
		echo $this->Form->Create('Sitesetting',array('url'=>array('controller'=>'/admins','action'=>'/mailsetting'),'id'=>'mailform','onsubmit'=>'return mailform();'));
			
			 echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
				
				
				echo $this->Form->input('notification_email',array('type'=>'text','label'=>__d('admin','E-mail(Used for notifications on sale, disputes and comments on items)'),'id'=>'notification_email','class'=>'form-control','value'=>$site_datas['notification_email'],$readonly));
				echo '</div></div></div>';
				 echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
				echo $this->Form->input('support_email',array('type'=>'text','label'=>__d('admin','Support e-mail(Text from contact us page will be sent to this mail id)'),'id'=>'support_email','class'=>'form-control','value'=>$site_datas['support_email'],$readonly));
				echo '</div></div></div>';
				 echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
				echo $this->Form->input('noreply_name',array('type'=>'text','label'=>__d('admin','Site no-reply name for e-mail'),'id'=>'noreply_name','class'=>'form-control','value'=>$site_datas['noreply_name'],$readonly));
				echo '</div></div></div>';
				 echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
				
				echo $this->Form->input('noreply_host',array('type'=>'text','label'=>__d('admin','Site no-reply host'),'id'=>'noreply_host','class'=>'form-control','value'=>$site_datas['noreply_host'],$readonly));
				echo '</div></div></div>';
				 echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
				
				echo $this->Form->input('noreply_email',array('type'=>'text','label'=>__d('admin','Site no-reply e-mail'),'id'=>'noreply_email','class'=>'form-control','value'=>$site_datas['noreply_email'],$readonly));
				echo '</div></div></div>';
				 echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
				echo $this->Form->input('noreply_password',array('type'=>'password','label'=>__d('admin','Site no-reply e-mail password'),'id'=>'noreply_password','class'=>'form-control','value'=>$site_datas['noreply_password'],$readonly));
				echo '</div></div></div>';
				
				 echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
		if($site_datas['gmail_smtp']=="enable")		
	echo '<fieldset>
	<legend><b>'.__d('admin', 'Gmail SMTP Gateway').'</b></legend>
		<label for="gmail_smtpEnable">
				<input type="radio" checked="checked" value="enable" class="inputform gmail_smtp" id="gmail_smtpEnable" name="gmail_smtp">
				'.__d('admin', 'Enable').'
			</label>
		<label for="gmail_smtpDisable">
				<input type="radio" value="disable" class="inputform gmail_smtp" id="gmail_smtpDisable" name="gmail_smtp">
				'.__d('admin', 'Disable').'
			</label>
	</fieldset>';	
	else
	echo '<fieldset>
	<legend>'.__d('admin', 'Gmail SMTP Gateway').'</legend>
		<label for="gmail_smtpEnable">
				<input type="radio" value="enable" class="inputform gmail_smtp" id="gmail_smtpEnable" name="gmail_smtp">
				'.__d('admin', 'Enable').'
			</label>
		<label for="gmail_smtpDisable">
				<input type="radio" checked="checked" value="disable" class="inputform gmail_smtp" id="gmail_smtpDisable" name="gmail_smtp">
				'.__d('admin', 'Disable').'
			</label>
	</fieldset>';		
	echo '</div></div></div>';	
				
				 echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
				echo $this->Form->input('smtp port',array('type'=>'text','label'=>__d('admin','Gmail SMTP Port Number'),'id'=>'smtp_port','class'=>'form-control','value'=>$site_datas['smtp_port'],$readonly));
				echo '</div></div></div>';
				echo "<br clear='all' />";
				
				
				
				
			echo "</div>";
			echo $this->Form->submit(__d('admin','Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
		echo $this->Form->end();
	echo "</div>";
?>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
						<!-----Site settings------->	



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
