<?php

	if(isset($_SERVER['HTTPS'])) {
		$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	} else {
		$protocol = 'http';
	} 
	$site_url = $protocol."://". $_SERVER['SERVER_NAME'].'/dev/stratus/';  
	 

	@$ftmp = $_FILES['images']['tmp_name'];
	@$oname = $_FILES['images']['name'];
	@$fname = $_FILES['images']['name'];
	@$fsize = $_FILES['images']['size'];
	@$ftype = $_FILES['images']['type'];

	$type = $_POST['type'];

	if($type=="item")
		$user_image_path = "media/items/";
	elseif($type=="post" || $type=="feeds")
		$user_image_path = "media/status/";
	elseif($type=="dispute")
		$user_image_path = "disputeimage/";
	else
		$user_image_path = "media/avatars/";


	$thumbimage = "";
	$ext = strrchr($oname, '.');

	$appImageValues = getimagesize($ftmp); 
	$extensionarray = array('.jpg', '.png', '.jpeg');
	$imageSize = ($fsize / 1024) / 1024;
	$errmsg = ''; 

	if(isset($ftmp)) {   
		if(!in_array($ext, $extensionarray)) {
			echo '{"status": "false", "message": "Something went to be wrong"}';
			//$errmsg = 'Please upload only jpg, png, jpeg images for Site logo';	
		} elseif($imageSize > 200) {   
			echo '{"status": "false", "message": "Something went to be wrong"}';
			//$errmsg = 'Please upload image upto 10MB for Site logo';
		} elseif ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png")) {

				//$errmsg = ""; 
				$newname = time().'_'.rand(0,9).$ext;
				
				if($type=="dispute") {
					$thumbimage = $user_image_path;
				} else {
					$thumbimage = $user_image_path . "original/" ;
				}

				$thumbimage1 = $user_image_path . "thumb350/" . $newname;
				$thumbimage2 = $user_image_path . "thumb150/" . $newname;
				$thumbimage3 = $user_image_path . "thumb70/" . $newname;
				
				$result = move_uploaded_file($ftmp,$thumbimage.$newname);
				chmod($thumbimage. $newname, 0777); 

				if(empty($result)) {
					echo '{"status": "false", "message": "Something went to be wrong"}';
					die;
				}
								
				// create thumbnail here
				if($type =="item" || $type =="post" || $type =="feeds" || $type =="selfie" || $type =="dispute")
				{ 
					include_once "pThumb.php";	

					$img=new pThumb(); 
					$img->pSetSize('350', '300');
					$img->pSetQuality(100);
					$img->pCreate3($thumbimage.$newname);
					$img->pSave($thumbimage1);
					chmod($thumbimage1, 0777);

					$img = "";
					$img=new pThumb();					
					$img->pSetSize('180', '180');
					$img->pSetQuality(100);
					$img->pCreate2($thumbimage.$newname);
					$img->pSave($thumbimage2);
					chmod($thumbimage2, 0777);

					$img = "";	
					$img=new pThumb();	
					$img->pSetSize('100', '100');
					$img->pSetQuality(100);
					$img->pCreate($thumbimage.$newname);
					$img->pSave($thumbimage3);
					chmod($thumbimage3, 0777);
					$img = "";

				} else {

					require_once("resize-class.php");
					
					$resizeObj = new resize($thumbimage.$newname);
					$resizeObj -> resizeImage(350, 350, 'crop');
					$resizeObj -> saveImage($thumbimage1, 100);
					chmod($thumbimage1, 0777);

					$resizeObj = "";
					$resizeObj = new resize($thumbimage.$newname);
					$resizeObj -> resizeImage(150, 150, 'crop');
					$resizeObj -> saveImage($thumbimage2, 100);
					chmod($thumbimage2, 0777);
					
					$resizeObj = "";
					$resizeObj = new resize($thumbimage.$newname);
					$resizeObj -> resizeImage(70, 70, 'crop');
					$resizeObj -> saveImage($thumbimage3, 100);
					chmod($thumbimage3, 0777);
					
					$resizeObj = "";
				}
				?>

				{
  					"status": "true",
				  	"result": {
						"typePost": "<?php echo $_POST['type']; ?>",
						"typeGet": "<?php echo $_GET['type']; ?>",
						"name": "<?php echo $newname; ?>",
						"image": "<?php echo $site_url."".$thumbimage.$newname; ?>" 
				  	}
				}
	
		<?php }
	} else {
		echo '{"status": "false", "message": "Something went to be wrong"}';
	} 
?>
