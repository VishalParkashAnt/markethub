<?php
use Cake\Routing\Router;
?>
<script>
	$(document).ready(function(){

		/*$("input[name=chkbox]").click(function() {
			chkd = $(this).parent().attr("class");
			if(chkd=="checked")
			$(this).parent().removeClass("checked");
			else
			$(this).parent().addClass("checked");
		});	*/
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

		//alert($.browser.msie);
		if ($.browser.msie) {
			$('.placeholder').each(function(){
			//$('input[placeholder]').each(function(){

				var input = $(this);

				$(input).val(input.attr('placeholder'));

				$(input).focus(function(){
					 if (input.val() == input.attr('placeholder')) {
						 input.val('');
					 }
				});

				$(input).blur(function(){
					if (input.val() == '' || input.val() == input.attr('placeholder')) {
						input.val(input.attr('placeholder'));
					}
				});
			});
		}
    });
</script>
   <style type="text/css">

      #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
        .claimedorder
        {
       margin-bottom: 10px;
        }
    </style>
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
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>manageuser"><?php echo __d('admin', 'Users'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'User'); ?></li>
                 </ol>
         </div>
    </div>
</div>




				<?php echo $this->Form->Create('signup',array('url'=>array('controller'=>'/','action'=>'/admins/edituser/'.$user_datas['id'].''),'id'=>'adduserform1','onsubmit'=>'return edituserform();')); ?>

				<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'User'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">
   			<?php

									echo '<div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'Name').'</label>';




				echo '<input type="text" maxlength="30" id="firstname" name="firstname" value="'.$user_datas["first_name"].'"
						 class="form-control style="color:#555555! important;" />';
			echo "</div></div></div>";




			echo '<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'User Name').'</label>';
				echo '<input type="text" id="username" name="username" value="'.$user_datas["username"].'" placeholder="'.__d('admin', 'Username').'" class="form-control" style="color:#555555! important;" readonly>';
			echo "</div></div></div>";

			echo '<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'E-Mail').'</label>';
				echo '<input type="password" id="email" name="email" value="'.$user_datas["email"].'" placeholder="'.__d('admin', 'E-mail').'" class="form-control" style="color:#555555! important;" readonly>';
			echo "</div></div></div>";

			echo '<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">'.__d('admin', 'Password').'</label>';
				echo '<input type="password" id="password" name="password" value="'.$user_datas["password"].'" placeholder="'.__d('admin', 'password').'"  class="form-control" style="color:#555555! important;" readonly>';
			echo "</div></div></div>";

// echo ' <div class="row">
//                                             <div class="col-md-6">
//                                                 <div class="form-group">
//                                                     <label class="control-label">'.__d('admin', 'Phone Number: ').'</label>';
// 				echo '<input type="text" id="phone_no" name="phone_no" value="'.$user_datas["phone_no"].'" placeholder="'.__d('admin', 'Phone Number').'" class="form-control" style="color:#555555! important;">';
// 				echo '<p style="color:red ! important;"> Note: Enter the phone number using their country code. <b> Ex: +91 </b></p>';
// 			echo "</div></div></div>";

				echo '<input type="hidden" id="userid" name="userid" value="'.$userid.'">';
				echo '<input type="hidden" id="menulist" name="menulist" value="'.$user_datas["admin_menus"].'">';


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






                                                    echo "<div class='input_wrap_popup'>";
			if($user_datas['user_level']=="shop")
			{
				echo '<input type="hidden" value="shop" name="usr_access">';
				echo '<input type="text" value="Seller (Can not change)" readonly class="form-control"></div></div></div></div>';
			}
			else
			{
				echo '<select id="usr_access" name="usr_access" class="form-control" onchange="showrestriction()">';
				if($user_datas['user_level']=="normal")
				{
					echo '<option value="normal" selected>'.__d('admin', 'User').'</option>';
					echo '<option value="moderator">'.__d('admin', 'Moderator').'</option>';
				}
				else if($user_datas['user_level']=="moderator")
				{
					echo '<option value="normal">'.__d('admin', 'User').'</option>';
					echo '<option value="moderator" selected>'.__d('admin', 'Moderator').'</option>';
				}
				echo '</select></div></div>';
				if($user_datas['user_level']=="moderator")
				echo '<button type="button" class="btn btn-info" id="restrict" style="vertical-align:top;top:0px;position:relative;" value="restrict" onclick="admin_menu_list()">'.__d('admin', 'Restriction').'</button>';
				else
				echo '<button type="button" class="btn btn-info" id="restrict" style="display:none;top:-5px;position:relative;" value="restrict" onclick="admin_menu_list()">'.__d('admin', 'Restriction').'</button>';
				echo "</div></div>";
				echo '</td></tr>';
			}
			echo "<div class='form-group'>";
			//	echo '<input type="hidden" id="menulist" name="menulist" value="">';
				echo "</div>";

			/*echo '<select id="usr_access" class="form-control" name="usr_access" onchange="showrestriction()">';
			echo '<option value="" >Select User Type</option>';
			echo '<option value="normal">User</option>';
			//echo '<option value="god">Admin</option>';
			echo '<option value="moderator">Moderator</option>';
			echo '</select>';
			echo '<button type="button" class="btn btn-info" id="restrict" value="restrict" style="display:none;vertical-align:top;left:5px;position:relative;" onclick="admin_menu_list()">Restriction</button>';
			echo "</div></div></div>";*/



			echo "<div class='enter_sub_pop' style='float: left;'>";
				echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));

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

<script type="text/javascript">

	$(document).ready(function(){

   $(document).keyup(function(e) {
        if (e.keyCode == 27) { // esc keycode
           $('#invoice-popup-overlay1').hide();
		   $('#invoice-popup-overlay1').css("opacity", "0");
        }
    });

});
</script>


<!--script>
	$('#invoice-popup-overlay1, .inv-close1').live ('click',function(){
		$('#invoice-popup-overlay1').hide();
		$('#invoice-popup-overlay1').css("opacity", "0");
	});
</script-->

