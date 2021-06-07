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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'User'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>manageuser"><?php echo __d('admin', 'Users'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Add User'); ?></li>
                                    </ol>
                                </div>


         </div>
    </div>





				<?php echo $this->Form->Create('signup',array('url'=>array('controller'=>'/','action'=>'/admins/addmember'),'id'=>'adduserform1','onsubmit'=>'return adduserform();')); ?>

				<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Add User'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">
   			<?php

									echo '<div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'Name').'</label>';




				echo '<input type="text"  maxlength="30" value="" id="firstname" name="firstname" placeholder="'.__d('admin', 'Full Name').'" class="form-control style="color:#555555! important;" />';
			echo "</div></div></div>";





			echo '<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'User Name').'</label>';
				echo '<input type="text"  maxlength="30" id="username" name="username" value="" placeholder="'.__d('admin', 'Username').'" class="form-control" style="color:#555555! important;">';
			echo "</div></div></div>";

			echo ' <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'E-Mail').'</label>';
				echo '<input type="text" id="email" name="email" value="" placeholder="'.__d('admin', 'E-mail').'" class="form-control" style="color:#555555! important;">';
			echo "</div></div></div>";

			echo ' <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'Password').'</label>';
				echo '<input type="password" id="password" name="password"  placeholder="'.__d('admin', 'Password').'"  class="form-control" style="color:#555555! important;">';
			echo "</div></div></div>";

			echo ' <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'Confirm Password').'</label>';
				echo '<input type="password" id="rpassword" name="rpassword"  placeholder="'.__d('admin', 'Confirm Password').'" class="form-control"  style="color:#555555! important;">';
			echo "</div></div></div>";

// echo ' <div class="row">
//                                             <div class="col-md-6">
//                                                 <div class="form-group">
//                                                     <label class="control-label">'.__d('admin', 'Phone Number: ').'</label>';
// 				echo '<input type="text" id="phone_no" name="phone_no" value="" placeholder="'.__d('admin', 'Phone Number').'" class="form-control" style="color:#555555! important;">';
// 				echo '<p style="color:red ! important;"> Note: Enter the phone number using their country code. <b> Ex: +91 </b></p>';
// 			echo "</div></div></div>";


			/*echo "<div class='input_wrap_popup'>";
				echo "<span class='labelclass' style='margin-bottom: 3px;margin-top: 0px;margin-left: 20px;width: 85px;'>Gender : </span>";
				echo "<span style='font-weight: bold; font-size: 16px;'>";
					echo $this->Form->radio('gender',array( 'male'=>'Male', 'female'=>'Female'),array('fieldset'=>false,'label'=>false,'legend'=>false,'name'=>'data[signup][gender]','class'=>'genderradio'));
				echo "</span>";
			echo "</div>";
			echo "<br clear='all' />";
					*/

			echo '<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'User Type').'</label>';

			echo '<select id="usr_access" class="form-control" name="usr_access" onchange="showrestriction()">';
			echo '<option value="" >'.__d('admin', 'Select User Type').'</option>';
			echo '<option value="normal">'.__d('admin', 'User').'</option>';
			//echo '<option value="god">Admin</option>';
			echo '<option value="moderator">'.__d('admin', 'Moderator').'</option>';
			echo '</select></div>';
			echo '<button type="button" class="btn btn-info" id="restrict" value="restrict" style="display:none;vertical-align:top;left:5px;position:relative;" onclick="admin_menu_list()">'.__d('admin','Restriction').'</button>';
			echo "</div></div>";
				echo "<div class='form-group'>";
				echo '<input type="hidden" id="menulist" name="menulist" value="">';
		echo "</div>";

			/*echo "<div class='input_wrap_popup'>";
			echo '<select id="usr_access" name="usr_country">';
			echo '<option value="" >Choose Country</option>';
			foreach($countries as $countri){
				echo '<option value="'.$countri['Countries']['country'].'">'.$countri['Countries']['country'].'</option>';
			}
			echo '</select>';
			echo "</div>";*/

			//$this->Form->input('Leaf.id', array('type'=>'select', 'label'=>'Leaf', 'options'=>$leafs, 'default'=>'3'));


			//echo '<span class="termsline">By clicking Register, you confirm that you accept our <a href="'.SITE_URL.'terms" target="_blank">Terms of Use</a> and <a href="'.SITE_URL.'terms" target="_blank" style="color:#1BB3E2;">Privacy Policy.</a></span>';
			//echo "<br clear='all'/><br/>";
			echo "<div class='enter_sub_pop' style='float: left;'>";
				echo $this->Form->submit(__d('admin', 'Add Member'),array('div'=>false,'class'=>'btn btn-info reg_btn'));

			echo "</div>";
			echo '<br /><br />';
			echo "<div id='alert' style='color: red; font-size: 13px;' class='trn'></div>";
		echo $this->Form->end();

		?>

   			<br />
   	 </div>

  </div>

</div>

</div>
	</div>



</div>

<div id="invoice-popup-overlay1">
	<div class="invoice-popup">
<!--button class="btn btn-danger inv-close1" id="btn_close" style="width: 90px; margin: 14px 6px 0px; font-size: 11px;float:right;">Back</button-->
<div id="userdata" class="invoice-datas" style="height:auto;overflow:hidden;">
<?php echo $this->element('menu_select'); ?>
</div>
	</div>



</div>
</div>
	</div>



</div>
<!--script>
	$('#invoice-popup-overlay1, .inv-close1').live ('click',function(){
		$('#invoice-popup-overlay1').hide();
		$('#invoice-popup-overlay1').css("opacity", "0");
	});
</script-->


<script type="text/javascript">

	$(document).ready(function(){

   $(document).keyup(function(e) {
        if (e.keyCode == 27) { // esc keycode
           $('#invoice-popup-overlay1').hide();
		   $('#invoice-popup-overlay1').css("opacity", "0");
        }
    });
    $("input[name=chkbox]").click( function () {

       var clsname = $(this).attr("class");
       var ischecked = $(this).prop("checked");
       var parentcls = clsname.replace("chk", "");

       if (ischecked==true) {
      		// $("."+parentcls).prop('checked',true);
      	var checkedChild = $('.'+clsname+':checked').length;
        var numberOfChild = $('.'+clsname).length;
        if (checkedChild == numberOfChild){
           $("."+parentcls).prop('checked', true);
        }
       }
       else
       {
			$("."+parentcls).prop('checked',false);
			$("#sel_all").prop('checked',false);

       }
   });
});
</script>
