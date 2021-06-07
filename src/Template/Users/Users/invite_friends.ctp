<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<style>
a{
	cursor: pointer;
}
</style>
<section class="container-fluid side-collapse-container margin-top10 no_hor_padding_mobile">
	<div class="container">
			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">
			<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
				<div class="breadcrumb">
				  <a href="<?php echo $baseurl;?>"><?php echo __d('user','Home');?></a>
				  <span class="breadcrumb-divider1">/</span>
				  <a href="<?php echo $baseurl.'invite_friends/';?>"><?php echo __d('user','Invite Friends');?></a>
				</div>
			</div>
		</section>

		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">
		<?php if($banner_datas->status=='Active') {?>
			<div class="create_gift">
				 <?php  echo $banner_datas->html_source; ?>
			</div>
		<?php }?>
			<div class="create_gift">
						<h2 class="find_new_heading extra_text_hide margin-bottom5"><?php echo __d('user','Invite Friends to Join in ').'&nbsp;';?><?php echo ucwords(strtolower($sitesettings->site_name)); ?></h2>
						<p class="extra_text_hide margin-bottom0"><?php echo __d('user','Invite Your Friends and Earn Credits When They Join');?></p>
				</div>
				
			<div class="invite_bg text-center">
				<h4 class="bold-font margin-bottom5"><?php echo __d('user','Social Network');?></h4>
				<span><?php echo __d('user','Invite Friends to ').'&nbsp;'.ucwords(strtolower($sitesettings->site_name)).__d('user',' from Your Social Network');?></span>
				<h2 class="bold-font margin-top30 margin-bottom20 invite_social">
					<a onclick="socialsharef();"><?php echo __d('user','Facebook');?></a>
					<a onclick="socialsharetwt();"><?php echo __d('user','Twitter');?></a>
					
					<a onclick="socialshareg();"><?php echo __('Google+');?>&#x200E;</a>
				</h2>
				
			</div>
			<div class="invite_bg text-center invite_border">
				<div class="">
					<span><?php echo __d('user','We won"t share your contacts with anybody without your consent');?> </span>
					</div>
			</div>
			<div class="create_gift">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 border_btmMobile_gift padding_btm15_giftMobile">
					<?php 
					$siteurlsfor_ref = SITE_URL.'signup?referrer='.$username.'';
					$siteurlsref = SITE_URL.'referrer/'.$username.'';
					?>
					<input type="hidden" id="short_urls" value="<?php echo $siteurlsref; ?>" >
					<input type="hidden" id="orig_urls" value="<?php echo $siteurlsfor_ref; ?>" >
						<div class="referal hor-padding">
							<h4 class="bold-font txt-uppercase margin-bottom5"><?php echo __d('user','Referral Link');?></h4>
							<span><?php echo __d('user','Use this link to share on Twitter, Facebook or on an Email');?></span>
							<div class="margin-top20 margin-bottom20">
							<input class="popup-input full_width txt_color_form" name="fname" value="<?php echo $siteurlsref; ?>" type="text">
							</div>
							<div class="share-details-cnt margin-top15 margin-bottom15">
									<div class="share-details margin-top10 margin-bottom10 inlined-display">
										<a onclick="socialsharef();" class="share-icons fa fa-facebook-official"></a>
										<a onclick="socialsharetwt();" class="share-icons fa fa-twitter-square"></a>
										<a onclick="socialshareg();" class="share-icons fa  fa-google-plus-square"></a>
										<a onclick="socialsharel();" class="share-icons fa fa-linkedin-square"></a>
										<a onclick="socialsharetum();" class="share-icons fa fa-tumblr-square"></a>
									</div>
							</div>
							<span><span class="primary-color-txt"><?php echo __d('user','Tip!');?> </span> <?php echo __d('user','Earn more credits by sharing your link with friends on social network');?></span>
						</div> 
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 border_left_grey_gift">
						<div class="invite_email hor-padding">
							<h4 class="bold-font txt-uppercase margin-bottom5"><?php echo __d('user','Invite via Email');?></h4>
							<span><?php echo __d('user','Invite your friends to ').ucwords(strtolower($sitesettings->site_name)).__d('user',' via email');?></span>
							<div class="multiple-emailcls">
							<input type="text" id="example_emailBS" name="example_emailBS" class="popup-input full_width txt_color_form margin-top15 margin-bottom15" value="" placeholder="<?php echo __d('user','Enter email address');?>">

							</div>
							<textarea name="additionalnotes" data-gramm="false" id="additionalnotes" class="popup-input txt_color_form full_width" placeholder="<?php echo __d('user','Enter your Message (Optional)');?>"></textarea>
							<div class="btn primary-color-bg margin-top15">
								<input class="invite-friends-by-email txt-uppercase btn-primary-inpt" value="<?php echo __d('user','Send Invites');?>" type="submit">
							</div>
							<p class="emailerr red-txt" style="display: none;"><?php echo __d('user','Enter valid email');?></p>
							<img class='email-send-load' src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading..." style="width: 18px;display: none;" />
							<p class="after-sent" style="display:none;"><?php echo __('Invites Sent!');?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="create_gift border_top_grey text-center">
				<?php $creditamount=json_decode($sitesettings->site_changes,true); ?>
				<span><span class="red-txt"><?php echo __d('user','Bonus!');?></span> <?php echo __d('user','You will be rewarded with ').'&nbsp;'.$_SESSION['default_currency_symbol'].$creditamount['credit_amount'].__d('user',' if your friend signs up and makes a purchase within 60 days');?></span>
			</div>
		</section>
		
	</div>
	<input type="hidden" name="current_emailsBS" id="current_emailsBS" />
</section>
<!-- For the plug-in dependencies -->
	<script type="text/javascript" src='http://code.jquery.com/jquery-latest.min.js'></script>
	
	
<script type="text/javascript">
	/***** Multiple email ****/
    //Plug-in function for the bootstrap version of the multiple email
    $(function() {
      //To render the input device to multiple email input using BootStrap icon
      $('#example_emailBS').multiple_emails({position: "top"});
      //OR $('#example_emailBS').multiple_emails("Bootstrap");
      //Shows the value of the input device, which is in JSON format
      $('#current_emailsBS').val($('#example_emailBS').val());
      $('#example_emailBS').change( function(){
        $('#current_emailsBS').val($(this).val());
      });
    });


    var is_sending_invitation = false;
    $('.invite-friends-by-email').click(function(){
  	var msg = $('#additionalnotes').val();
  	$('.emailerr').hide();	
  	var current_emailsBS=$('#current_emailsBS').val();
  	if(current_emailsBS==""){
  	$('.emailerr').show();
  	setTimeout(function(){$('.emailerr').hide();}, 5000);
  	return false;
  	}
	var emails=[];
	var BaseURL=getBaseURL();
	if(!is_sending_invitation){
	  is_sending_invitation=true;
		$.ajax({
		url: BaseURL+"sendinviteemailref",
		type: "post",
		data : { 'emails': current_emailsBS, 'msg': msg},
		beforeSend: function(){
			$('.email-send-load').show();
		},
		success: function(responce){
			$('.email-send-load').hide();
			$('#additionalnotes').val('');
			$('#example_emailBS').val('');
		   	$('.after-sent').fadeIn();
		   	$('.multiple_emails-ul').html('');
		   	$('#current_emailsBS').val('');
	        email_addrs = [];
			setTimeout(function(){
				$('.after-sent').fadeOut();
			},2000);
	       is_sending_invitation=false;
	     }
	   });
	}
	return false;
    });
</script>

<script >
  window.___gcfg = {
    lang: 'en-US',
    parsetags: 'onload'
  };
</script>
<script src="https://apis.google.com/js/client:platform.js" async defer></script>
 <script src="https://connect.facebook.net/en_US/all.js">
   </script> 

   </script>
   <script>
 FB.init({ 
       appId:'<?php echo $socialId['FB_ID']; ?>', cookie:true, 
       status:true, xfbml:true 
     });
		
function FacebookInviteFriends()
{
//FB.ui({ method: 'apprequests', 
   //message: 'Invitation from <?php echo ucwords(strtolower($setngs[0]['Sitesetting']['site_name'])); ?>...'});

//alert('dd');
	FB.ui({ method: 'send', 
		   link: '<?php echo SITE_URL; ?>'});	   
}
  
 $('.btn-twitter-dlg').click(function(){
	<?php
if(isset($user_contacts)){
?>
   	$('#popup_container').show();
	$('#popup_container').css({"opacity":"1"});
   	$('.popup').show();
   	
   	
<?php
	}
	else
	{
?>
   		var BaseURL=getBaseURL();
   		window.location=BaseURL+'invite_friends/Twitter';
		<?php
	}
	?>


 })

 $('#gmail_invite').click(function(){
		var BaseURL=getBaseURL();
		//localo////window.location = 'https://accounts.google.com/o/oauth2/auth?client_id=146312791564-0cial8qh35dr3ekjqs3cjkf0gomjd2p6.apps.googleusercontent.com&redirect_uri='+BaseURL+'invite_friends/Google/&scope=https://www.google.com/m8/feeds/&response_type=code'
	<?php
if(isset($email_adderss)){
?>
   	$('#popup_container').show();
	$('#popup_container').css({"opacity":"1"});
   	$('.popup').show();
   	
   	
<?php
	}
	else
	{
	?>		
	 	window.location = 'https://accounts.google.com/o/oauth2/auth?client_id=<?php echo $socialId['GMAIL_CLIENT_ID']; ?>&redirect_uri='+BaseURL+'invite_friends/Google/&scope=https://www.google.com/m8/feeds/&response_type=code'
 	<?php
 	}
 	?>
	 
	 	
	 });
</script>
<style type="text/css">
	.invite_bg > h2 > a:last-child {
		border-right: none !important;
	}
</style>