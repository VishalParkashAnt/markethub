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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'FAQ'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>managefaq"><?php echo __d('admin', 'FAQ'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Edit FAQ'); ?></li>
                                    </ol>
                                </div>

             
         </div>
    </div>


<?php
	echo "<div class='containerdiv'>";
		
		
		echo $this->Form->Create('FAQ',array('url'=>array('controller'=>'/admins','action'=>'/editfaq/'.$getcolorval['id']),'id'=>'Faqform','onsubmit'=>'return addfaqform()'));
		?>
			<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Add FAQ'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">
                        	<?php
		
			echo $this->Form->input('faq_question',array('type'=>'text','maxlength'=>'','label'=>__d('admin', 'FAQ Question'),'id'=>'faq_question','class'=>'form-control','value'=>$getcolorval['faq_question']));
				echo'</div></div><br>';
		  echo' <div class="row">
                        <div class="col-md-6">';
			echo $this->Form->input('faq_answer',array('type'=>'textarea','maxlength'=>'','label'=>__d('admin', 'FAQ Answer'),'id'=>'faq_answer','class'=>'form-control','value'=>$getcolorval['faq_answer']));
				echo'</div></div><br>';
			?>
			
			
			
			<?php
			echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
			echo '<div id="faqrerr" style="font-size:13px;color:red;"></div>';
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