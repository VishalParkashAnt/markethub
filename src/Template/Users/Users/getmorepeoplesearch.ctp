	<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
	<?php
			if(count($people_details)>0)
			{
			foreach($people_details as $people)
			{
				$people_id=$people->id;
				//User Image
				$imgname = $_SESSION['media_url']."media/avatars/thumb70/".$people->profile_image;
				$imgsze = getimagesize($imgname);
				if(!empty($people->profile_image) && !empty($imgsze)){
					$imageUrl = $_SESSION['media_url']."media/avatars/thumb70/".$people->profile_image;
				}else{
					$imageUrl = $_SESSION['media_url']."media/avatars/thumb70/usrimg.jpg";
				}
			?>

			<div class="product_cnt col-lg-3 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
				<div class="find_people_image1">
					<div class="find_people_image" style="background-image:url('<?php echo $imageUrl;?>');background-repeat: no-repeat; border-radius: 5%;"></div>
				</div>
				<div class="find_people_followers">
				<div class="gradient_bg">
					<h4 class="margin-bottom0 extra_text_hide"><a href="<?php echo $baseurl.'people/'.$people->username;?>" style="color: #444444; text-transform: capitalize; "><?php echo strtolower($people->first_name.$people->last_name); ?></a></h4>
				</div><p class="profile_text margin-bottom20 extra_text_hide hor-padding">@<?php echo $people->username;?></p>
					<div class="btn user_followers_butn" id="follow_<?php echo $people_id;?>" onclick="getpeoplefollows('<?php echo $people_id;?>');">
						<a><?php echo __d('user','Follow');?></a>
					</div>
				</div>
			</div>

			<?php }?>
			</div>
		
			<div class="text-center padding-bottom20 padding-top20">
			<div class="padding-bottom10">
			<?php } 