<body class=""> 
  <!--<![endif]-->
  
  
 <div class="content">

 			<div class="box span12">
				<div class="box-header">
					<h2>Category</h2>
				</div>
				<div class="box-content" style="margin-bottom:-20px;">
			        <ul class="breadcrumb">
            <li><a href="<?php echo SITE_URL; ?>"><?php echo __d('admin', 'Home'); ?></a> <span class="divider">/</span></li>
           	<li><a href="<?php echo SITE_URL.'admin/view/category'; ?>"><?php echo __d('admin', 'Category'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo __d('admin', 'Add Category'); ?></li>
			        </ul>
				</div>
			</div> 
						<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><?php echo __d('admin', 'Category'); ?></h2>
						
					</div>
					<div class="box-content">
<?php
	echo "<div class='containerdiv'>";
		echo $this->Form->Create('Category',array('url'=>array('controller'=>'/','action'=>'/createcategory'),'id'=>'Categoryform'));
			if(!empty($mainsec)){
				foreach($mainsec as $main_sec){
					$options2[$main_sec['Category']['id']] =  $main_sec['Category']['category_name'];
				}
			}else{
				$options2 = '';
			}
			echo $this->Form->input('categories', array('options' => $options2,'empty' => __d('admin', '-- Select Main Category --'),'id'=>'mainsec','class'=>'inputform catchnge'));
			echo "<span><b>".__d("admin", "hints : if you select the main category , the below category will be treated as subcategory.")."</b></span>";
			echo $this->Form->input('categoryname',array('type'=>'text','label'=>__d('admin', 'Category Name'),'class'=>'inputform'));
			
			
			echo "<div id='forms'></div>";
			echo "<a href='javascript:void(0);' onclick='addform();' class='show_hid'>".__d("admin", "Add another Sub category")."</a>";
			//echo "<a href='javascript:void(0);' onclick='deleteform()' style='display:none;' class='deletfrm'>Delete</a>";
			echo $this->Form->submit(__d('admin', 'Submit'),array('div'=>false,'class'=>'btn btn-primary reg_btn'));
		echo $this->Form->end();
	echo "</div>";
?>


</div>

</div>

</div>



<style>
	
.show_hid{
	display:none;
}
</style>
