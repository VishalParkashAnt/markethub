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
            <h3 class="text-themecolor m-b-0 m-t-0">Site Management</h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard">Home</a></li>
                                      
                                        <li class="breadcrumb-item active">Site Management</li>
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
                        <h4 class="m-b-0 text-white">Site Management</h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">';
			echo "<div id='forms'><div class='col-md-6'>";
 
				echo $this->Form->input('site_name',array('type'=>'text','label'=>'Site Name','id'=>'site_name','class'=>'form-control','value'=>$site_datas['site_name'],$readonly));	
						
				echo $this->Form->input('id',array('type'=>'hidden','label'=>'Site Name','id'=>'id','class'=>'inputform','value'=>$site_datas['id']));			
echo '<br>';
				
				echo $this->Form->input('site_title',array('type'=>'text','label'=>'Site Title','id'=>'site_title','class'=>'form-control','value'=>$site_datas['site_title'],$readonly));
				echo '<br>';
				echo $this->Form->input('meta_key',array('type'=>'text','label'=>'Html Meta Keyword','id'=>'meta_key','class'=>'form-control','value'=>$site_datas['meta_key'],$readonly));
				echo '<br>';
				echo $this->Form->input('meta_desc',array('type'=>'text','label'=>'Html Meta Description','id'=>'meta_desc','class'=>'form-control','value'=>$site_datas['meta_desc'],$readonly));		echo '<br>';		
				
				if($siteChanges['profile_image_view']=="square")
				echo '<fieldset>
					<h5 class="card-title">Profile Image Style</h5>
					<label for="profile_image_styleSquare">
						<input type="radio" checked="checked" value="square" class="inputform profile_image_style" id="profile_image_styleSquare" name="profile_image_style">
						Square
					</label>
					<label for="profile_image_styleRound">
						<input type="radio" value="round" class="inputform profile_image_style" id="profile_image_styleRound" name="profile_image_style">
						Round
					</label>
					</fieldset>';
				else
				echo '<fieldset>
					<h5 class="card-title">Profile Image Style</h5>
					<label for="profile_image_styleSquare">
						<input type="radio" value="square" class="inputform profile_image_style" id="profile_image_styleSquare" name="profile_image_style">
						Square
					</label>
					<label for="profile_image_styleRound">
						<input type="radio" checked="checked" value="round" class="inputform profile_image_style" id="profile_image_styleRound" name="profile_image_style">
						Round
					</label>
					</fieldset>';
				
		
				
				//echo $this->Form->input('welcome_email',array('type'=>'radio','options'=>array('yes'=>'Yes','no'=>'No'),'legend'=>'Welcome Email for New User','id'=>'welcome_email','class'=>'inputform welcome_email','default'=>$site_datas['Sitesetting']['welcome_email']));
				
				//echo $this->Form->input('profile_image_style',array('type'=>'radio','options'=>array('square'=>'Square','round'=>'Round'),'label'=>'How the Profile Images should be view','id'=>'profile_image_style','class'=>'inputform profile_image_style','name'=>'profile_image_style','default'=>$siteChanges['profile_image_view']));
				
				echo '<br>';
				if($site_datas['affiliate_enb']=="enable")
				echo '<fieldset>
				<h5 class="card-title">Affiliate System</h5>
				<label for="affiliatepgmEnable">
					<input type="radio" checked="checked" value="enable" class="inputform profile_image_style" id="affiliatepgmEnable" name="affiliate_enb">
					enable
				</label>
				<label for="affiliatepgmDisable">
					<input type="radio" value="disable" class="inputform profile_image_style" id="affiliatepgmDisable" name="affiliate_enb">
					disable
				</label>
				</fieldset>';
				else
				echo '<fieldset>
				<h5 class="card-title">Affiliate System</h5>
				<label for="affiliatepgmEnable">
					<input type="radio" value="enable" class="inputform profile_image_style" id="affiliatepgmEnable" name="affiliate_enb">
					enable
				</label>
				<label for="affiliatepgmDisable">
					<input type="radio" checked="checked" value="disable" class="inputform profile_image_style" id="affiliatepgmDisable" name="affiliate_enb">
					disable
				</label>
				</fieldset>';
				
				//echo $this->Form->input('affiliate_system',array('type'=>'radio','options'=>array('enable'=>'enable','disable'=>'disable'),'label'=>'Select affiliate system','id'=>'affiliatepgm','class'=>'inputform profile_image_style','name'=>'affiliate_enb','default'=>$site_datas['Sitesetting']['affiliate_enb']));
				echo '<br>';
				if($site_datas['welcome_email']=="yes")
				echo '<fieldset>
				<h5 class="card-title">Welcome Email</h5>
				<label for="welcome_emailYes">
					<input type="radio" checked="checked" value="yes" class="inputform welcome_email" id="welcome_emailYes" name="welcome_email">
					Yes
				</label>
				<label for="welcome_emailNo">
					<input type="radio" value="no" class="inputform welcome_email" id="welcome_emailNo" name="welcome_email">
					No
				</label>
				</fieldset>';
				else
				echo '<fieldset>
				<h5 class="card-title">Welcome Email</h5>
				<label for="welcome_emailYes">
					<input type="radio" value="yes" class="inputform welcome_email" id="welcome_emailYes" name="welcome_email">
					Yes
				</label>
				<label for="welcome_emailNo">
					<input type="radio" checked="checked" value="no" class="inputform welcome_email" id="welcome_emailNo" name="welcome_email">
					No
				</label>
				</fieldset>';
				
				//echo $this->Form->input('welcome_email',array('type'=>'radio','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>'Send welcome mail for newly signed up users','id'=>'welcome_email','class'=>'inputform welcome_email','default'=>$site_datas['Sitesetting']['welcome_email']));
				echo '<br>';
				if($site_datas['signup_active']=="yes")
				echo '<fieldset>
				<h5 class="card-title">Signup Active</h5>
				<label for="signup_activeYes">
					<input type="radio" checked="checked" value="yes" class="inputform signup_active" id="signup_activeYes" name="signup_active">
					Yes
				</label>
				<label for="signup_activeNo">
					<input type="radio" value="no" class="inputform signup_active" id="signup_activeNo" name="signup_active">
					No
				</label>
				</fieldset>';
				else
				echo '<fieldset>
				<h5 class="card-title">Signup Active</h5>
				<label for="signup_activeYes">
					<input type="radio" value="yes" class="inputform signup_active" id="signup_activeYes" name="signup_active">
					Yes
				</label>
				<label for="signup_activeNo">
					<input type="radio" checked="checked" value="no" class="inputform signup_active" id="signup_activeNo" name="signup_active">
					No
				</label>
				</fieldset>';
				echo '<br>';
				if($site_datas['cod']=="enable")
				echo '<fieldset>
				<h5 class="card-title">Cash On Delivery</h5>
				<label for="cod_activeYes">
					<input type="radio" checked="checked" value="enable" class="inputform cod_active" id="cod_activeYes" name="cod">
					Enable
				</label>
				<label for="cod_activeNo">
					<input type="radio" value="disable" class="inputform cod_active" id="cod_activeNo" name="cod">
					Disable
				</label>
				</fieldset>';
				else
				echo '<fieldset>
				<h5 class="card-title">Cash On Delivery</h5>
				<label for="cod_activeYes">
					<input type="radio" value="enable" class="inputform cod_active" id="cod_activeYes" name="cod">
					Enable
				</label>
				<label for="cod_activeNo">
					<input type="radio" checked="checked" value="disable" class="inputform cod_active" id="cod_activeNo" name="cod">
					Disable
				</label>
				</fieldset>';	
				
				
				//echo $this->Form->input('signup_active',array('type'=>'radio','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>'Auto activate members on signing up','id'=>'signup_active','class'=>'inputform signup_active','default'=>$site_datas['Sitesetting']['signup_active']));
				
				
				
				echo "<br clear='all' />";
				
				echo "<b>Like Button logo</b>";
				//$site_datas['Sitesetting']['site_likebtn_logo']='';
				echo "<div class='form-group'>";
					if($demo_active!='yes')
					{
						echo '<div class="venueimg"><iframe class="image_iframe" id="frame" name="frame" src="'.$this->webroot.'adminlikebtnadd.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left; margin-left: 16px;"></iframe>';												
							echo $this->Form->input('site_likebtn_logo', array('type'=>'hidden','id'=>'image_computer_like', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['site_likebtn_logo'],'name'=>'site_likebtn_logo'));
							if(!empty($site_datas['site_likebtn_logo'])){  echo "<a href='javascript:void(0);' id='removeimg_like' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg_like(\" 1 \")'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>"; }
							else{echo "<a href='javascript:void(0);' id='removeimg_like' style='display: none; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg_like(\" 1 \")'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>"; }
						echo "</div>";
					}
						if(!empty($site_datas['site_likebtn_logo'])){
						echo "<img id='show_url_like'  style='float: left;margin-left: 10px;margin-right:20px;width: 40px;height:40px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$baseurl."images/logo/".$site_datas['site_likebtn_logo']."?".rand(1,00)."'>";
						}else{
						echo "<img id='show_url_like'  style='float: left;margin-left: 10px;margin-right:20px;width: 40px;height:40px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$baseurl."images/fantacylike.png'>";
						}
				echo '<div style="color:red;display:none;width:800px;" id="likebtnlogoerr"></div>';		
				echo "</div>";

				echo "<br clear='all' />";
					
				
				
				
				
				echo "<b>Site Logo</b>";
				//$site_datas['Sitesetting']['site_logo']='';
				echo "<div class='form-group'>";
					if($demo_active!='yes')
					{
						echo '<div class="venueimg"><iframe class="image_iframe" id="frame" name="frame" src="'.$this->webroot.'admin_update.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&sitelogo=sitelogo&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left; margin-left: 16px;"></iframe>';												
							echo $this->Form->input('site_logo', array('type'=>'hidden','id'=>'image_computer', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['site_logo'],'name'=>'site_logo'));
							if(!empty($site_datas['site_logo'])){  echo "<a href='javascript:void(0);' id='removeimg'' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg(\" 1 \")'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>"; }else{echo "<a href='javascript:void(0);' id='removeimg' style='display: none; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg(\" 1 \")'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>"; }
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
				
				echo "<b>Site Logo Icon</b>";
				//$site_datas['Sitesetting']['site_logo_icon']='';
				echo "<div class='form-group'>";
					if($demo_active!='yes')
					{
						echo '<div class="venueimg"><iframe class="image_iframe" id="frame_icon" name="frame_icon" src="'.$this->webroot.'admin_update_icon.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left; margin-left: 16px;"></iframe>';												
							echo $this->Form->input('item_image', array('type'=>'text','id'=>'image_computer_icon', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['site_logo_icon'],'name'=>'site_logo_icon'));
							if(!empty($site_datas['site_logo_icon'])){  echo "<a href='javascript:void(0);' id='removeimgicon'' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimgicon(\" 1 \")'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>"; }else{echo "<a href='javascript:void(0);' id='removeimgicon' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimgicon(\" 1 \")'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>"; }
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
				echo "<b>Favicon</b>";
				echo "<div class='favicon'>";
					if($demo_active!='yes')
					{
						echo '<div class="favimg"><iframe class="image_fav" id="fav" name="fav" src="'.$this->webroot.'adminfavupload.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left; margin-left: 16px;"></iframe>';												
							//echo $this->Form->input('item_image', array('type'=>'hidden','id'=>'image_computer_fav', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['Sitesetting']['site_likebtn_logo'],'name'=>'site_likebtn_logo'));
							 echo "<a href='javascript:void(0);' id='removeimg_fav' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hiddden;' onclick='removeusrimg_fav(\" 1 \")'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>"; 
							//}else{echo "<a href='javascript:void(0);' id='removeimg_like' style='display: none; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg_like(\" 1 \")'><span class='btn btn-danger'><i class='icon-trash'></i></span></a>"; }
						echo "</div>";
					}
						
						echo "<img id='show_url_fav'  style='float: left;margin-left: 10px;margin-right:20px;width: 40px;height:40px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url."favicon.ico?".rand(1,00)."'>";
				echo '<div style="color:red;display:none;width:800px;" id="faviconerr"></div>';						
				echo "</div>";
				echo "<br clear='all' />";
					
				
				echo "<br>";					
				
				
				//$site_datas['Sitesetting']['site_logo']='';
				echo "<b>Default User Profile Image</b>";
				echo "<div class='form-group'>";
					if($demo_active!='yes')
					{
						echo '<div class="usrimg"><iframe class="image_usr" id="usr" name="usr" src="'.$this->webroot.'adminupload.php?media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'" frameborder="0" height="40px" width="130px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left; margin-left: 16px;"></iframe>';												
							//echo $this->Form->input('item_image', array('type'=>'hidden','id'=>'image_computer_usr', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$site_datas['Sitesetting']['site_logo'],'name'=>'site_logo'));
							 echo "<a href='javascript:void(0);' id='removeimg_usr' style='display: inline; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg_usr(\" 1 \")'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>"; 
							//}else{echo "<a href='javascript:void(0);' id='removeimg' style='display: none; margin-top: 5px; float: left;height:auto;overflow:hidden;' onclick='removeusrimg(\" 1 \")'><span class='btn btn-danger'><i class='icon-trash'></i></span></a>"; }
						echo "</div>";
					}	

						echo "<img id='show_url_usr'  style='float: left;margin-left: 10px;margin-right:20px;width: 100px;height:70px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;background-color:#000000;' src='".$site_url."media/avatars/thumb70/usrimg.jpg?".rand(1,00)."'>";

				echo '<div style="color:red;display:none;width:800px;" id="usrprofileimgerr"></div>';			
				echo "</div>"; 

				echo '<br><br><br>';
		
				

				echo $this->Form->input('like_btn_cmnt',array('type'=>'text','label'=>'Like button letters(Example Like it)','id'=>'support_email','class'=>'form-control','maxlength'=>'10','value'=>$site_datas['like_btn_cmnt'],$readonly));
				echo '<br>';
				
				echo $this->Form->input('liked_btn_cmnt',array('type'=>'text','label'=>'Liked button letters(Example Liked)','id'=>'support_email','class'=>'form-control','maxlength'=>'10','value'=>$site_datas['liked_btn_cmnt'],$readonly));
				echo '<br>';
		                echo $this->Form->input('unlike_btn_cmnt',array('type'=>'text','label'=>'UnLike button letters(Example Unlike)','id'=>'unlike_btn','class'=>'form-control','maxlength'=>'10','value'=>$site_datas['unlike_btn_cmnt'],$readonly));				echo '<br>';
				echo $this->Form->input('landing_video',array('type'=>'text','label'=>'Landing Page Video url','id'=>'landing_video','class'=>'form-control','value'=>$site_datas['landing_video'],$readonly));			
				echo '<br>';
				echo $this->Form->input('credit_amount',array('type'=>'text','label'=>'User Credit Amount','id'=>'credit_amount','class'=>'form-control','value'=>$siteChanges['credit_amount'],$readonly));
				echo '<br>';
				echo $this->Form->input('numofdays_received',array('type'=>'text','label'=>'Number of days to update (user could not change the order status to received)','id'=>'numofdays_update','class'=>'form-control','value'=>$site_datas['numofdays_received'],$readonly));				
				echo '<br>';
				echo $this->Form->input('credit_percentage',array('type'=>'text','label'=>'If no commission enabled default commission percentage on User Credit Amount (%)','id'=>'credit_percentage','class'=>'form-control','value'=>$site_datas['credit_percentage'],$readonly));
				echo '<br>';
			echo '<label>Default Shipping Country</label>';	
			echo '<select name="default_ship_country" class="form-control">';
			foreach($country_datas as $country)
			{
			    if($site_datas['default_ship_country']==$country['id'])
			    echo '<option value="'.$country['id'].'" selected>'.$country['country'].'</option>';
			    else
			    echo '<option value="'.$country['id'].'">'.$country['country'].'</option>';
			}
			echo '</select>';
			
			echo '<br><br><label>Gender <span style="font-size:13px;">(Enter values separated by comma)</span></label>';
			$gender_type = $site_datas['gender_type'];
			$gen_type = json_decode($gender_type,true);
			$gender = $gen_type[0];
			for($i=1;$i<count($gen_type);$i++)
			{
			    $gender.= ",".$gen_type[$i];
			}
			echo '<input type="text" class="form-control" name="gender_type" value="'.$gender.'">';
					
			echo '<br><br><label>User Location (in kilometer)</label>';
			$userloc = $site_datas['userloc'];
			echo '<input type="text" class="form-control" name="userloc" value="'.$userloc.'">';
			echo '<br><br>';
			echo '<label>Signup Credit Points</label>';
			$signup_credit = $site_datas['signup_credit'];
			echo '<input type="text" class="form-control" name="signup_credit" id="signup_credit" value="'.$signup_credit.'">';
			echo '<br><br>';
			echo '<label>Checkin Credit Points</label>';
			$checkin_credit = $site_datas['checkin_credit'];
			echo '<input type="text" class="form-control" name="checkin_credit" id="checkin_credit" value="'.$checkin_credit.'">';
			echo '<br><br>';
			echo '<label>Order Count For Featured Store</label>';
			$order_count = $site_datas['order_count'];
			echo '<input type="text" class="form-control" name="order_count" id="order_count" value="'.$order_count.'">';
			echo '<br><br>';
			echo '<label>Checkin Count For Featured Store</label>';
			$checkin_count = $site_datas['checkin_count'];
			echo '<input type="text" class="form-control" name="checkin_count" id="checkin_count" value="'.$checkin_count.'">';
			
				/******** Footer content ***********/
				echo '<br><br>';
				echo '<label>Footer Content (Left) </label>';
				echo '<textarea rows="5" class="form-control" cols="100" name="footer_left" '.$readonly.'>'.$site_datas['footer_left'].'</textarea>';
				echo '<br>';
				echo '<label>Footer Content (Right) </label>';
				echo '<textarea rows="5" cols="100" class="form-control" name="footer_right" '.$readonly.'>'.$site_datas['footer_right'].'</textarea>';				
				echo '<br><br>';
				if($site_datas['footer_active']=="yes")
					echo '<fieldset>
					<h5 class="card-title">Footer Active</h5>
					<label for="footer_activeYes">
						<input type="radio" checked="checked" value="yes" class="inputform footer_active" id="footer_activeYes" name="footer_active">
						Yes
					</label>
					<label for="footer_activeNo">
						<input type="radio" value="no" class="inputform footer_active" id="footer_activeNo" name="footer_active">
						No
					</label>
					</fieldset>';
				else				
					echo '<fieldset>
					<h5 class="card-title">Footer Active</h5>
					<label for="footer_activeYes">
						<input type="radio" value="yes" class="inputform footer_active" id="footer_activeYes" name="footer_active">
						Yes
					</label>
					<label for="footer_activeNo">
						<input type="radio" checked="checked" value="no" class="inputform footer_active" id="footer_activeNo" name="footer_active">
						No
					</label>
					</fieldset>';	
				
				/******** Footer content ***********/	
		
			echo '<br>';

			echo $this->Form->submit('Submit',array('div'=>false,'class'=>'btn btn-info reg_btn'));
			echo '<span style="color:red;display:none;" id="unlike_val">Please enter unlike button value</span>';
			//echo '<span style="color:red;display:none;" id="siteerrormsg"></span>';
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
function removeusrimgicon(val){
	$('#image_computer_icon').val('');
	$('#show_url_icon').attr({src: "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"});
	$('#removeimgicon').hide();
}
function removeusrimg_fav(val){
	//$('#image_computer_fav').val('');
	$('#show_url_fav').attr({src: "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"});
	$('#removeimg_fav').hide();
}
function removeusrimg_usr(val){
	//$('#image_computer_usr').val('');
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
