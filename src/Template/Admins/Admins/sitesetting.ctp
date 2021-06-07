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
        <div class="col-md-6 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Site Management'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>

                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Site Management'); ?></li>
                                    </ol>
                                </div>


         </div>
    </div>



<?php
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




					<div class="box-content">




	<?php

	if($demo_active=="yes")
	{
		$readonly = "readonly";
	}
	else if($demo_active=="no")
	{
		$readonly = "";
	}

	echo "<div class='containerdiv'>";
		echo $this->Form->Create('Sitesetting',array('url'=>array('controller'=>'/admins','action'=>'/sitesetting'),'id'=>'siteform','onsubmit'=>'return validate_site();'));
				echo '<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white">'.__d('admin', 'Site Management').'</h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">';
			echo "<div id='forms'><div class='col-md-6'>";

				echo $this->Form->input('site_name',array('type'=>'text','label'=>__d('admin', 'Site Name'),'id'=>'site_name','class'=>'form-control','value'=>$site_datas['site_name'],$readonly));

				echo $this->Form->input('id',array('type'=>'hidden','label'=>__d('admin', 'Site Name'),'id'=>'id','class'=>'inputform','value'=>$site_datas['id']));


				echo $this->Form->input('site_title',array('type'=>'text','label'=>__d('admin', 'Site Title'),'id'=>'site_title','class'=>'form-control','value'=>$site_datas['site_title'],$readonly));
			
				echo $this->Form->input('meta_key',array('type'=>'text','label'=>__d('admin', 'Html Meta Keyword'),'id'=>'meta_key','class'=>'form-control','value'=>$site_datas['meta_key'],$readonly));
				
				echo $this->Form->input('meta_desc',array('type'=>'text','label'=>__d('admin', 'Html Meta Description'),'id'=>'meta_desc','class'=>'form-control','value'=>$site_datas['meta_desc'],$readonly));		


				if($site_datas['welcome_email']=="yes")
				echo '<fieldset>
				<h5 class="card-title">'.__d('admin', 'Welcome Email').'</h5>
				<label for="welcome_emailYes">
					<input type="radio" checked="checked" value="yes" class="inputform welcome_email" id="welcome_emailYes" name="welcome_email">
					'.__d('admin', 'Yes').'
				</label>
				<label for="welcome_emailNo">
					<input type="radio" value="no" class="inputform welcome_email" id="welcome_emailNo" name="welcome_email">
					'.__d('admin', 'No').'
				</label>
				</fieldset>';
				else
				echo '<fieldset>
				<h5 class="card-title">'.__d('admin', 'Welcome Email').'</h5>
				<label for="welcome_emailYes">
					<input type="radio" value="yes" class="inputform welcome_email" id="welcome_emailYes" name="welcome_email">
					'.__d('admin', 'Yes').'
				</label>
				<label for="welcome_emailNo">
					<input type="radio" checked="checked" value="no" class="inputform welcome_email" id="welcome_emailNo" name="welcome_email">
					'.__d('admin', 'No').'
				</label>
				</fieldset>';

				//echo $this->Form->input('welcome_email',array('type'=>'radio','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>'Send welcome mail for newly signed up users','id'=>'welcome_email','class'=>'inputform welcome_email','default'=>$site_datas['Sitesetting']['welcome_email']));
				echo '<br>';
				if($site_datas['signup_active']=="yes")
				echo '<fieldset>
				<h5 class="card-title">'.__d('admin', 'Signup Active').'</h5>
				<label for="signup_activeYes">
					<input type="radio" checked="checked" value="yes" class="inputform signup_active" id="signup_activeYes" name="signup_active">
					'.__d('admin', 'Yes').'
				</label>
				<label for="signup_activeNo">
					<input type="radio" value="no" class="inputform signup_active" id="signup_activeNo" name="signup_active">
					'.__d('admin', 'No').'
				</label>
				</fieldset>';
				else
				echo '<fieldset>
				<h5 class="card-title">'.__d('admin', 'Signup Active').'</h5>
				<label for="signup_activeYes">
					<input type="radio" value="yes" class="inputform signup_active" id="signup_activeYes" name="signup_active">
					'.__d('admin', 'Yes').'
				</label>
				<label for="signup_activeNo">
					<input type="radio" checked="checked" value="no" class="inputform signup_active" id="signup_activeNo" name="signup_active">
					'.__d('admin', 'No').'
				</label>
				</fieldset>';
				echo '<br>';
				if($site_datas['cod']=="enable")
				echo '<fieldset>
				<h5 class="card-title">'.__d('admin', 'Cash On Delivery').'</h5>
				<label for="cod_activeYes">
					<input type="radio" checked="checked" value="enable" class="inputform cod_active" id="cod_activeYes" name="cod">
					'.__d('admin', 'Enable').'
				</label>
				<label for="cod_activeNo">
					<input type="radio" value="disable" class="inputform cod_active" id="cod_activeNo" name="cod">
					'.__d('admin', 'Disable').'
				</label>
				</fieldset>';
				else
				echo '<fieldset>
				<h5 class="card-title">'.__d('admin', 'Cash On Delivery').'</h5>
				<label for="cod_activeYes">
					<input type="radio" value="enable" class="inputform cod_active" id="cod_activeYes" name="cod">
					'.__d('admin', 'Enable').'
				</label>
				<label for="cod_activeNo">
					<input type="radio" checked="checked" value="disable" class="inputform cod_active" id="cod_activeNo" name="cod">
					'.__d('admin', 'Disable').'
				</label>
				</fieldset>';


				//echo $this->Form->input('signup_active',array('type'=>'radio','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>'Auto activate members on signing up','id'=>'signup_active','class'=>'inputform signup_active','default'=>$site_datas['Sitesetting']['signup_active']));



				echo "<br clear='all' />";







				echo "<b>".__d("admin", "Site Logo")."</b>";
				//$site_datas['Sitesetting']['site_logo']='';
				echo "<div class='form-group'>";
					if($demo_active!='yes')
					{
						echo '<div class="venueimg"><iframe class="image_iframe" id="frame" name="frame" src="'.$this->webroot.'admin_update.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&sitelogo=sitelogo&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;"></iframe>';
							echo $this->Form->input('site_logo', array('type'=>'hidden','id'=>'image_computer', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['site_logo'],'name'=>'site_logo'));
							if(!empty($site_datas['site_logo'])){  echo "<a href='javascript:void(0);' id='removeimg'' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg(\" 1 \")'></a>"; }else{echo "<a href='javascript:void(0);' id='removeimg' style='display: none; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg(\" 1 \")'></a>"; }
						echo "</div>";
					}
						if(!empty($site_datas['site_logo'])){
						echo "<img id='show_url'  style='float: left;margin-left: 10px;margin-right:20px;width: 100px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url."images/logo/".$site_datas['site_logo']."?".rand(1,00)."'>";
						}else{
						echo "<img id='show_url'  style='float: left;margin-left: 10px;margin-right:20px;width: 100px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url."images/logo.png'>";
						}
				echo '<div style="color:red;display:none;width:800px;" id="sitelogoerr"></div>';
				echo "</div>";
				echo "<br clear='all' />";

				//logo dark version

				echo "<b>".__d("admin", "Logo Dark Version")."</b>";
				//$site_datas['Sitesetting']['site_logo']='';
				echo "<div class='form-group'>";
					if($demo_active!='yes')
					{
						echo '<div class="venueimg"><iframe class="image_iframe" id="darkframe" name="darkframe" src="'.$this->webroot.'admin_dark_update.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&sitelogo=sitelogo&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;"></iframe>';
							echo $this->Form->input('site_dark_logo', array('type'=>'hidden','id'=>'image_dark', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['site_dark_logo'],'name'=>'site_dark_logo'));
							if(!empty($site_datas['site_dark_logo'])){  echo "<a href='javascript:void(0);' id='removedarkimg'' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removedarkimg(\" 1 \")'></a>"; }else{echo "<a href='javascript:void(0);' id='removedarkimg' style='display: none; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removedarkimg(\" 1 \")'></a>"; }
						echo "</div>";
					}
						if(!empty($site_datas['site_dark_logo'])){
						echo "<img id='show_dark_url'  style='float: left;margin-left: 10px;margin-right:20px;width: 100px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#fff;' src='".$site_url."images/logo/".$site_datas['site_dark_logo']."?".rand(1,00)."'>";
						}else{
						echo "<img id='show_dark_url'  style='float: left;margin-left: 10px;margin-right:20px;width: 100px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#fff;' src='".$site_url."images/logo.png'>";
						}
				echo '<div style="color:red;display:none;width:800px;" id="sitelogoerr"></div>';
				echo "</div>";
				echo "<br clear='all' />";



				echo "<b>".__d("admin", "Site Logo Icon")."</b>";
				//$site_datas['Sitesetting']['site_logo_icon']='';
				echo "<div class='form-group'>";
					if($demo_active!='yes')
					{
						echo '<div class="venueimg"><iframe class="image_iframe" id="frame_icon" name="frame_icon" src="'.$this->webroot.'admin_update_icon.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;"></iframe>';
							echo $this->Form->input('site_logo_icon', array('type'=>'hidden','id'=>'image_computer_icon', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['site_logo_icon'],'name'=>'site_logo_icon'));
							if(!empty($site_datas['site_logo_icon'])){  echo "<a href='javascript:void(0);' id='removeimgicon'' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimgicon(\" 1 \")'></a>"; }else{echo "<a href='javascript:void(0);' id='removeimgicon' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimgicon(\" 1 \")'></a>"; }
						echo "</div>";
					}
						if(!empty($site_datas['site_logo_icon'])){
						echo "<img id='show_url_icon'  style='float: left;margin-left: 10px;margin-right:20px;width: 100px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url."images/logo/".$site_datas['site_logo_icon']."?".rand(1,00)."'>";
						}else{
						echo "<img id='show_url_icon'  style='float: left;margin-left: 10px;margin-right:20px;width: 100px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url."images/logo/logo_icon.png'>";
						}
				echo '<div style="color:red;display:none;width:800px;" id="sitelogoiconerr"></div>';
				echo "</div>";
				echo "<br clear='all' />";





				//$site_datas['Sitesetting']['site_likebtn_logo']='';
				echo "<b>".__d("admin", "Favicon")."</b>";
				echo "<div class='favicon'>";
					if($demo_active!='yes')
					{
						echo '<div class="favimg"><iframe class="image_fav" id="fav" name="fav" src="'.$this->webroot.'adminfavupload.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;"></iframe>';
							echo $this->Form->input('favicon_image', array('type'=>'hidden','id'=>'image_computer_fav', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['favicon_image'],'name'=>'favicon_image'));
							if(!empty($site_datas['favicon_image'])){
							 echo "<a href='javascript:void(0);' id='removeimg_fav' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg_fav(\" 1 \")'></a>";

							}else{echo "<a href='javascript:void(0);' id='removeimg_fav' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg_fav(\" 1 \")'></a>";
							 }
						echo "</div>";
					}
					if(!empty($site_datas['favicon_image'])){
						echo "<img id='show_url_fav'  style='float: left;margin-left: 10px;width: 40px;height:40px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url.$site_datas['favicon_image']."?".rand(1,00)."'>";
                                               }else{
						echo "<img id='show_url_fav'  style='float: left;margin-left: 10px;margin-right:20px;width: 40px;height:40px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url."favicon.ico?".rand(1,00)."'>";
                                         }
				echo '<div style="color:red;display:none;width:800px;" id="faviconerr"></div>';
				echo "</div>";
				echo "<br clear='all' />";


				echo "<br>";


				//$site_datas['Sitesetting']['site_logo']='';
				echo "<b>".__d("admin", "Default User Profile Image")."</b>";
				echo "<div class='form-group'>";
					if($demo_active!='yes')
					{
						echo '<div class="usrimg"><iframe class="image_usr" id="usr" name="usr" src="'.$this->webroot.'adminupload.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;"></iframe>';
							echo $this->Form->input('user_default_image', array('type'=>'hidden','id'=>'image_computer_usr', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['user_default_image'],'name'=>'user_default_image'));
					       if(!empty($site_datas['user_default_image'])){
							 echo "<a href='javascript:void(0);' id='removeimg_usr' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg_usr(\" 1 \")'></a>";
							}else{echo "<a href='javascript:void(0);' id='removeimg_usr' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg_usr(\" 1 \")'></a>"; }
						echo "</div>";
					}

						 if(!empty($site_datas['user_default_image'])){
						echo "<img id='show_url_usr'  style='float: left;margin-left: 10px;margin-right:20px;width: 100px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url."media/avatars/thumb70/".$site_datas['user_default_image']."?".rand(1,00)."'>";
                                                }else{
						echo "<img id='show_url_usr'  style='float: left;margin-left: 10px;margin-right:20px;width: 100px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url."media/avatars/thumb70/usrimg.jpg?".rand(1,00)."'>";
                              }
				echo '<div style="color:red;display:none;width:800px;" id="usrprofileimgerr"></div>';
				echo "</div>";

				echo '<br><br><br>';



				echo $this->Form->input('like_btn_cmnt',array('type'=>'text','label'=>__d('admin', 'Like button letters(Example Like it)'),'id'=>'support_email','class'=>'form-control','maxlength'=>'10','value'=>$site_datas['like_btn_cmnt'],$readonly));
			
				echo $this->Form->input('liked_btn_cmnt',array('type'=>'text','label'=>__d('admin', 'Liked button letters(Example Liked)'),'id'=>'support_email','class'=>'form-control','maxlength'=>'10','value'=>$site_datas['liked_btn_cmnt'],$readonly));
			
		        echo $this->Form->input('unlike_btn_cmnt',array('type'=>'text','label'=>__d('admin', 'UnLike button letters(Example Unlike)'),'id'=>'unlike_btn','class'=>'form-control','maxlength'=>'10','value'=>$site_datas['unlike_btn_cmnt'],$readonly));				

				echo $this->Form->input('credit_amount',array('type'=>'text','label'=>__d('admin', 'User Credit Amount').' '.'('.$_SESSION['currency_symbol'].')','id'=>'credit_amount','class'=>'form-control','maxlength'=>'6','value'=>$siteChanges['credit_amount'],$readonly));
			

				//echo $this->Form->input('credit_percentage',array('type'=>'text','label'=>__d('admin', 'If no commission enabled default commission percentage on User Credit Amount (%)'),'id'=>'credit_percentage','class'=>'form-control','value'=>$site_datas['credit_percentage'],'maxlength'=>'2',$readonly));
			
				echo '<label>'.__d('admin', 'Footer Content (Left)').' </label>';
				echo '<textarea rows="5" class="form-control" cols="100" name="footer_left" '.$readonly.'>'.$site_datas['footer_left'].'</textarea>';
				echo '<br>';
				echo '<label>'.__d('admin', 'Footer Content (Right)').' </label>';
				echo '<textarea rows="5" cols="100" class="form-control" name="footer_right" '.$readonly.'>'.$site_datas['footer_right'].'</textarea>';
				echo '<br><br>';
				if($site_datas['footer_active']=="yes")
					echo '<fieldset>
					<h5 class="card-title">'.__d('admin', 'Footer Content Active').'</h5>
					<label for="footer_activeYes">
						<input type="radio" checked="checked" value="yes" class="inputform footer_active" id="footer_activeYes" name="footer_active">
						'.__d('admin', 'Yes').'
					</label>
					<label for="footer_activeNo">
						<input type="radio" value="no" class="inputform footer_active" id="footer_activeNo" name="footer_active">
						'.__d('admin', 'No').'
					</label>
					</fieldset>';
				else
					echo '<fieldset>
					<h5 class="card-title">'.__d('admin', 'Footer Content Active').'</h5>
					<label for="footer_activeYes">
						<input type="radio" value="yes" class="inputform footer_active" id="footer_activeYes" name="footer_active">
						'.__d('admin', 'Yes').'
					</label>
					<label for="footer_activeNo">
						<input type="radio" checked="checked" value="no" class="inputform footer_active" id="footer_activeNo" name="footer_active">
						'.__d('admin', 'No').'
					</label>
					</fieldset>';

				/******** Footer content ***********/

			echo '<br>';

			echo $this->Form->submit(__d('admin', 'Submit'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
			echo '<span style="color:red;display:none;" id="unlike_val">'.__d('admin', 'Please enter unlike button value').'</span>';
			echo '<span style="color:red;display:none;" class="trn" id="siteerrormsg"></span>';
		echo $this->Form->end();
	echo "</div></div>";
?>
					</div>
				</div><!--/span-->

			</div><!--/row-->



<style>

.show_hid{
	display:none;
}
</style>
<script>
function removeusrimg_like(val){
	$('#image_computer_like').val('');
	$('#show_url_like').attr({src: "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"});
	$('#removeimg_like').hide();
}
function removeusrimg(val){
	$('#image_computer').val('');
	$('#show_url').attr({src: "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"});
	$('#removeimg').hide();
}
function removedarkimg(val){
	$('#image_dark').val('');
	$('#show_dark_url').attr({src: "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"});
	$('#removedarkimg').hide();
}
function removeusrimgicon(val){
	$('#image_computer_icon').val('');
	$('#show_url_icon').attr({src: "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"});
	$('#removeimgicon').hide();
}
function removeusrimg_fav(val){
	$('#image_computer_fav').val('');
	$('#show_url_fav').attr({src: "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"});
	$('#removeimg_fav').hide();
}
function removeusrimg_usr(val){
	$('#image_computer_usr').val('');
	$('#show_url_usr').attr({src: "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"});
	$('#removeimg_usr').hide();
}
</script>


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
    <script>
	var loginSession = readCookie('PHPSESSID');
	function readCookie(name) {
	    var nameEQ = escape(name) + "=";
	    var ca = document.cookie.split(';');//console.log(document.cookie);
	    for (var i = 0; i < ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
	        if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
	    }
	    return null;
	}
	if (typeof timerId != 'undefined'){
		clearInterval(timerId);
	}
	var timerId = setInterval(function() {
		var currentSession = readCookie('PHPSESSID');
	    if(loginSession != currentSession) {
		    //console.log('in reload '+loginSession+" "+currentSession);
		    window.location = 'http://localhost/sellnu/';
		    clearInterval(timerId);
	        //Or whatever else you want!
	    }

	},1000);
</script>

  </body>
</html>
