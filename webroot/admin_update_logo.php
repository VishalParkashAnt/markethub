
<style>
body{
	margin:0px;
}
.file-holder .file-input-area {
	
    cursor: pointer;
    /* left: -137px; */
    left: -86px;
    margin: 0;
    position: absolute;
	top: 0;
    z-index: 3;
	height:32px;	
}
.file-holder1 .file-input-area1 {
	
    cursor: pointer;
    /* left: -137px; */
    left: -140px;
    margin: 0;
    position: absolute;
	top: 0;
    z-index: 3;
	height:32px;	
}
.btn {
    -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #F5F5F5;
    background-image: -moz-linear-gradient(center top , #FFFFFF, #E6E6E6);
    background-repeat: repeat-x;
    border-color: #E6E6E6 #E6E6E6 #B3B3B3;
    border-radius: 4px 4px 4px 4px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
    color: #333333;
    cursor: pointer;
    display: inline-block;
    font-size: 13px;
    height: 30px;
    line-height: 18px;
    margin-bottom: 0;
    margin-top: 5px;
    padding: 4px 1px;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
	width: 118px !important;
}
.btn:hover {
  color: #333333;
  text-decoration: none;
  background-color: #e6e6e6;
  *background-color: #d9d9d9;
  /* Buttons in IE7 don't get borders, so darken on hover */

  background-position: 0 -15px;
  -webkit-transition: background-position 0.1s linear;
     -moz-transition: background-position 0.1s linear;
      -ms-transition: background-position 0.1s linear;
       -o-transition: background-position 0.1s linear;
          transition: background-position 0.1s linear;
}
#iform{
	margin:0px;
}
</style>
<?php

	$media_url = $_REQUEST['media_url'];
	$site_url = $_REQUEST['site_url'];
	$userid = $_REQUEST['userid'];
	$sitelogo = $_REQUEST['sitelogo'];

	// FILE PARAMS
	@$ftmp = $_FILES['image']['tmp_name'];
	@$oname = $_FILES['image']['name'];
	@$fname = $_FILES['image']['name'];
	@$fsize = $_FILES['image']['size'];
	@$ftype = $_FILES['image']['type'];   
  
	// OTHER PARAMS
	$user_image_path = "images/logo/";
	$thumbimage = "";
	$ext = strrchr($oname, '.');

	$appImageValues = getimagesize($ftmp); 
	$extensionarray = array('.jpg', '.png', '.jpeg');
	$imageSize = ($fsize / 1024) / 1024;
	$errmsg = '';

	if(isset($ftmp)) {   
		if(!in_array($ext, $extensionarray)) {
			$errmsg = 'Please upload only jpg, png, jpeg images for Site logo';	
		} elseif($imageSize > 10) {  
			$errmsg = 'Please upload image upto 10MB for Site logo';
		} elseif ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png")) { 

			$newname = time().'_'.$userid.$ext;
			$finalPath = $user_image_path;
			$thumbimage1 = $user_image_path . $newname;
			
			$originalImage = $ftmp; 
			$outputImage = $finalPath."logo.png"; 
			$quality = 9;
				
			if (preg_match('/jpg|jpeg/i',$ext))
				$imageTmp=imagecreatefromjpeg($originalImage);
			else if (preg_match('/png/i',$ext))
				$imageTmp=imagecreatefrompng($originalImage);
			else
				return 0;
				
			// quality is a value from 0 (worst) to 100 (best)
			imagepng($imageTmp, $outputImage, $quality);
			imagedestroy($imageTmp); 
				
			$result = move_uploaded_file($ftmp,$finalPath.$newname);
			chmod($finalPath.$newname, 0777); 	 	
				
			$img_src = $site_url.$thumbimage1.'?'.rand(0,1000);
			
			?>
			<!-- Copy & Paste "Javascript Upload Script" -->
			<script>
				var par = window.parent.document;
				par.getElementById('show_url').src = '<?php echo $img_src; ?>';
				par.getElementById('image_computer_logo').value = '<?php echo $newname; ?>';	
				var imagename = par.getElementById('image_computer_logo').value;
				if(imagename){
					parent.document.getElementById('removeimg').style.display='block';
				}
			</script>
			<?php    
		} else {
			$errmsg = 'Please upload only jpg, png, jpeg images';
		}  
	}
?>
<script>
function upload(){
    var par = window.parent.document;
	document.getElementById('iform').submit();
	/*par.getElementById('show_url').src = '<?php //echo $site_url."img/indicator.gif";?>';*/
     par.getElementById('image_computer_logo').value = '<?php echo $newname; ?>';
}

parent.document.getElementById('sitelogoerr').style.display = 'block';
parent.document.getElementById('sitelogoerr').innerHTML = '<?php echo $errmsg; ?>';
setTimeout(function() {
			 parent.document.getElementById('sitelogoerr').innerHTML = '';
			}, 5000);
</script>
<!-- <form id="iform" name="iform" action="" method="post" enctype="multipart/form-data">
<input id="file" type="file" onchange="upload()" name="image">
<input id="file" type="file" onchange="upload()" name="image" onclick="parent.document.getElementById('removeimg').style.display='block';">
</form>-->

<form id="iform" name="iform" class="settings" action="" method="post" enctype="multipart/form-data">
	<div class="row file-holder1">
		<div class="file file-input-js-active">
			<input type="file" value="Browse..." class="file-input-area1" id="file" style="opacity: 0;filter: alpha(opacity = 0);" name="image" onchange="upload()"/>
			<input type="text" id="input_value" value="Change image" class="btn text file-input-value" readonly="readonly"/>			
		</div>
	</div>
</form>
