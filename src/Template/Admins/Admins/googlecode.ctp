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
            <?php echo __d('admin', 'Google Analytics'); ?>

</h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                       
                                        <li class="breadcrumb-item active">
<?php echo __d('admin', 'Google Analytics'); ?>
</li>
                                    </ol>
                                </div>

             
         </div>
    </div>
	
<?php
	echo "<div class='containerdiv'>";
	echo $this->Form->Create('Googlecode',array('url'=>array('controller'=>'/admins',
				'action'=>'/googlecode')));
				?>
		<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Google Analytics'); ?>
</h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
	<?php
				echo $this->Form->input('id',array('type'=>'hidden','class'=>'inputform','value'=>$google_datas['id']));
				
				//echo $this->Form->input('google_code',array('type'=>'textarea','label'=>'Google Analytics code','id'=>'google_code','class'=>'inputform','value'=>$google_datas['Googlecode']['google_code']));
			   // echo 'Google Analytics Code : ';echo '<br>';
			    echo '<label>'. __d('admin', 'Google Analytics Code :').'</label>';echo '<br>';
				 echo ' <div class="row">
                        <div class="col-md-6">';
				echo '<textarea rows="5" cols="20" name="google_code" id="google_code" class = "form-control">'.$google_datas['google_code'].'</textarea>';
				echo '</div></div> <div class="row" style="margin-bottom:15px">
                        <div class="col-md-6">';
				//echo '<br>';
				if(empty($google_datas['status'])){
					$status = 'no';
				}else{
					$status = $google_datas['status'];
				}
				if($google_datas['status']=="yes")
				echo '<label>'.__d('admin', 'Active').'</label><br>
				
					<input type="radio" checked="checked" value="yes" class="inputform status" id="statusYes" name="status">
					'.__d('admin', 'Yes').'
				
					<input type="radio" value="no" class="inputform status" id="statusNo" name="status">
					'.__d('admin', 'No').'
				';
				else
				echo '<label>'.__d('admin', 'Active').'</label><br>
				
					<input type="radio" value="yes" class="inputform status" id="statusYes" name="status">
					'.__d('admin', 'Yes').'
				
				
					<input type="radio" checked="checked" value="no" class="inputform status" id="statusNo" name="status">
					'.__d('admin', 'No').'
				';
				
				//echo $this->Form->input('status',array('type'=>'radio','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>'Enable google analytics','id'=>'status','class'=>'inputform status','default'=>$status));
				
			
				echo '</div></div>';
			echo $this->Form->submit(__d('admin', 'Update'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
		echo $this->Form->end();
	echo "</div>";
?>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
						<!-----Google Analytics------->	
</div>
				</div><!--/span-->
			
			</div><!--/row-->


 </div></div></div>
     
</div>
				</div><!--/span-->
			
			</div><!--/row-->
    
  </body>
</html>
