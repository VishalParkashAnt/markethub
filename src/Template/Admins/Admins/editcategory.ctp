<?php
use Cake\Routing\Router;
?>


  <body class="">
  <!--<![endif]-->

<div class="content">
<?php
$baseurl = Router::url('/');
if(session_id() == '') {
session_start();
}
$site = $_SESSION['site_url'];
$media = $_SESSION['media_url'];
$username = @$_SESSION['media_server_username'];
$password = @$_SESSION['media_server_password'];
@$hostname = $_SESSION['media_host_name'];
@$userid = $_SESSION['Auth']['Admin']['id'];

?>

			<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Categories'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>viewcategory"><?php echo __d('admin', 'Categories'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Edit Category'); ?></li>
                                    </ol>
                                </div>


         </div>
    </div>


<?php


echo "<div class='containerdiv'>";

		  $display="display:none";
       $imageurl = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image';
       $iconurl = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image';

				if ($category_webicon != ''){
					$display="display:block";
					$iconurl = SITE_URL.'images/category/'.$category_webicon;
					//echo"icon=".$iconurl;
				}

				if ($category_webimage != ''){
					$display="display:block";
					$imageurl = SITE_URL.'images/category/'.$category_webimage;
					//echo"img=".$imageurl;
				}
echo "<div class='containerdiv'>";


	echo $this->Form->Create('Category',array('url'=>array('controller'=>'/','action'=>'/admins/editcategory/'.$id),'id'=>'EditCategoryform','onsubmit'=>'return editcategoryform();')); ?>


	<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Edit Category'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">
                        	<?php
		if(!empty($mainsec[0]['category_parent'])){
			foreach($mainsec_prnts as $main_sec){
				$options2[$main_sec['id']] =  $main_sec['category_name'];
			}
		}else{
			$options2 = '';
		}
		if(!empty($mainsec[0]['category_parent'])){

			echo $this->Form->input('categories', array('options' => $options2,'default'=>$mainsec[0]['category_parent'],'label'=>__d('admin','Main Category'),'id'=>'mainsec','class'=>'form-control'));




			echo "<br clear='all' />";
		  /*echo "<span><b>hints : if you select the main category , the below category will be treated as subcategory.</b></span>";
			echo "<br clear='all' />";*/
			$check=1;
		}
		if(!empty($mainsec[0]['category_sub_parent'])){

			echo $this->Form->input('categoryname',array('type'=>'text','value'=>$mainsunprnts[0]['category_name'],'label'=>__d('admin','Sub Category'),'id'=>'category_name','class'=>'form-control'));
			echo "<input type='hidden' value='yes' name='disabled' />";



		}else{

			echo $this->Form->input('categoryname',array('type'=>'text','value'=>$mainsec[0]['category_name'],'label'=>__d('admin','Sub Category'),'id'=>'category_name','class'=>'form-control'));
			if($check!=1)
			{
				echo "<div class='img_upld' style='float: none; min-height: 120px;'>";
				echo '<label>'.__d('admin', 'Select Icon').'</label><br>';
				echo "<img id='show_webicon_url'  style='width: 100px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;' src='".$iconurl."'>";
				echo '<div class="venueimg"><iframe class="image_iframe" id="frame_0" name="frame0" src="'.SITE_URL.'/categoryupload.php?image=0&media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'&type=icon" frameborder="0" height="40px" width="120px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;position: relative;"></iframe>';
				echo $this->Form->input('category_webicon', array('type'=>'hidden','id'=>'category_webicon', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$category_webicon,'name'=>'category_webicon'));
				echo "<a href='javascript:void(0);' id='removeimg_0' style='".$display."; margin: 5px; float: left;' onclick='removecatimg(0)'> <span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>";

				echo "</div>";
				echo "</div>";
				echo "<div class='sliderimguploaderr' id='sliderimguploaderr' style='color:red;display:none;width:700px;clear:both;'></div>";
				echo "<div class='sliderimageerror_icon error'></div></br>";



			}


			echo "<input type='hidden' value='no' name='disabled' />";
		}
		echo $this->Form->input('created_by',array('type'=>'hidden','value'=>$mainsec[0]['created_by']));
		echo $this->Form->input('secid',array('type'=>'hidden','value'=>$mainsec[0]['id']));
		echo $this->Form->input('subparid',array('type'=>'hidden','value'=>$mainsec[0]['category_sub_parent']));

		echo "<br clear='all' />";

		echo "<div id='forms'>";
			if(!empty($mainsec[0]['category_sub_parent'])){
				echo '<label>'.__d('admin','Add Sub of Sub category').'</label><br /><input name="categoryname_2" value="'.$mainsec[0]['category_name'].'" id="Category_names" class="form-control" type="text" />';
			}else{
				echo '<input name="categoryname_2" value="" id="Category_names" class="form-control" type="hidden" />';
			}
		echo "</div>";
		if($check!=1)
			{
		echo' <div class="col-md-6" style="margin-left: -13px;">';
				echo '<label>'.__d('admin', 'Select Web image').'</label><br>';
				echo "<img id='show_webimage_url'  style='width: 100px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;' src='".$imageurl."'>";
				echo '<div class="venueimg"><iframe class="image_iframe" id="frame_1" name="frame1" src="'.SITE_URL.'/categoryupload.php?image=0&media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'&type=image" frameborder="0" height="40px" width="120px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;position: relative;"></iframe>';
				echo $this->Form->input('category_webicon', array('type'=>'hidden','id'=>'category_webimage', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$category_webimage,'name'=>'category_webimage'));
				echo "<a href='javascript:void(0);' id='removeimg_1' style='".$display."; margin: 5px; float: left;' onclick='removecatimg(1)'> <span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>";

				echo "</div>";
				echo "</div>";
				echo "<div class='sliderimguploaderr' id='sliderimguploaderr' style='color:red;display:none;width:700px;clear:both;'></div>";
				echo "<div class='sliderimageerror_image error'></div>";
		 }
		echo "<br clear='all' />";
		if(!empty($mainsec[0]['category_parent']) && empty($mainsec[0]['category_sub_parent'])){
			echo "<a href='javascript:void(0);' onclick='addformss();' class='show_hid'>".__d("admin","Add another Sub category")."</a>";
		}

		//echo "<a href='javascript:void(0);' onclick='deleteform()' style='display:none;' class='deletfrm'>Delete</a>";
		echo $this->Form->submit(__d('admin','Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
	echo '<br />';
			echo "<div id='alert' class='trn' style='color: red; font-size: 13px;'></div>";
	echo $this->Form->end();
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
</div>
</div>