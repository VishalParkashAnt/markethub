<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');

if(count($userDetails)>0)
{
	foreach($userDetails as $people)
	{
		$people_id=$people->id;
		$username_url = $people->username_url;
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
				<?php echo '<a href="'.SITE_URL."people/".$username_url.'">';?><div class="find_people_image" style="background:url('<?php echo $imageUrl;?>');"></div></a>
			</div>
			<div class="find_people_followers">
				<div class="gradient_bg">
					<h4 class="margin-bottom0 extra_text_hide"><?php echo '<a href="'.SITE_URL."people/".$username_url.'">';?><?php echo $people->first_name.$people->last_name; ?></a></h4>
				</div><p class="profile_text margin-bottom20 extra_text_hide hor-padding">@ <?php echo $people->username;?></p>
				<?php
				if($userid != $people['id']){
					foreach($followcnt as $flcnt){
						if($flcnt['follow_user_id'] == $userid){
							$flwrcntid[] = $flcnt['user_id'];
						}
					}
					if($userid != $people['id']){
						if(!in_array($people['id'],$flwrcntid)){
							$flw = true;
						}else{
							$flw = false;
						}
						if($flw)
						{
							echo '<span id="foll'.$people['id'].'"><div class="btn user_followers_butn" id="follow_'.$people['id'].'">
							<a href="javascript:void(0);" class="" onclick="getpeoplefollows('.$people['id'].')">'.__d('user','Follow').'</a></div></span>';
						}
						else
						{
							echo '<span id="unfoll'.$people['id'].'"><div class="btn user_followers_butn" id="follow_'.$people['id'].'">
							<a href="javascript:void(0);" class="" onclick="deletepeoplefollows('.$people['id'].')">'.__d('user','Unfollow').'</a></div></span>';
						}
						echo '<span id="changebtn'.$people['id'].'" style="float:right;"></span>';
					}
				}
				?>
			</div>
		</div>
	<?php }}
	else {
            echo 'false';
        }
			?>