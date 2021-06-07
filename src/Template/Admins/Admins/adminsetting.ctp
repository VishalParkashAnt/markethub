<script>
	$(document).ready(function(){
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
    </style>
  <body class="">
  <!--<![endif]-->


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Admin Settings'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Admin Settings'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>


				<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Profile'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">


						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">
</div>






		<?php

   			echo $this->Form->create('signup', array('url' => array('controller' => '/', 'action' => '/admins/adminsetting'), 'id'=>'adduserform1','onsubmit'=>'return chngeadmindet()'));

		
			echo "<div class='row'>";
			echo "<div class='col-md-6'><label>".__d("admin", "First Name")."</label>";
				echo "<input type='text' style='color:#555555! important;' class='form-control' id='firstname' name='firstname' placeholder='".__d("admin", "First Name")."' value='".$userDett['first_name']."' />";
			echo "</div></div>";


			echo "<div class='row'>";
				echo "<div class='col-md-6'><label>".__d("admin", "User Name")."</label>";
				echo '<input type="text" style="color:#555555! important;" id="lastname" class="form-control" name="lastname" placeholder="'.__d('admin', 'Last Name').'" value="'.$userDett['last_name'].'"/>';
			echo "</div></div>";
				echo "<div class='row'>";
				echo "<div class='col-md-6'><label>".__d("admin", "Email")."</label>";
				echo '<input type="text" style="color:#555555! important;" id="email" name="email" placeholder="'.__d('admin', 'E-mail').'"  class="form-control" value="'.$userDett['email'].'">';
			echo "</div></div>";
			echo "<div class='row'>";
				echo "<div class='col-md-6'><label>".__d("admin", "Password")."</label>";
				echo '<input type="password" style="color:#555555! important;" id="password" name="password" placeholder="'.__d('admin', 'Password').'"  class="form-control" value="">';
			echo "</div></div><br>";

				echo "<div id='alert' class='trn' style='color: #E8222F; font-size: 15px;'></div>";

			echo "<div class='enter_sub_pop' style='float: left;'>";
				echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));

			echo "</div><br />";

		echo $this->Form->end();




		?>
   					</div>
				</div><!--/span-->

			</div><!--/row-->
						<!-----Admin settings------->




   	 </div>

  </div>

</div>
