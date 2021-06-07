<link rel="stylesheet" href="<?php echo $_REQUEST['site_url']; ?>css/frontcss/font-awesome.css">
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
	height:100%;	
}
.file-holder1 .file-input-area1 {
	
    cursor: pointer;
    /* left: -137px; */
    /*left: -140px;*/
    margin: 0;
    position: absolute;
	top: 0;
    z-index: 3;
	height:100%;	
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
.edit-profile {
	background: #fff url("images/user-edit.jpeg") no-repeat scroll center center / cover ;
	height: 16px;
	padding: 0;
	width: 16px;
	
}
.remove-profile {
	background: #fff url("images/user-remove.jpeg") no-repeat scroll center center / cover ;
	height: 16px;
	padding: 0;
	width: 16px;
	
}
</style>
<?php 

	$media_url = $_REQUEST['site_url'];
	$site_url = $_REQUEST['site_url'];
	$userid = $_REQUEST['userid'];

	if (isset( $_REQUEST['groupgift']))
		$gg = $_REQUEST['groupgift'];
	if (isset( $_REQUEST['merchantprofile']))
		$merchant = $_REQUEST['merchantprofile'];


	@$ftmp = $_FILES['image']['tmp_name'];
	@$oname = $_FILES['image']['name'];
	@$fname = $_FILES['image']['name'];
	@$fsize = $_FILES['image']['size'];
	@$ftype = $_FILES['image']['type'];

	$user_image_path = "media/avatars/";
	$thumbimage = "";
	$ext = strrchr($oname, '.');   

	$appImageValues = getimagesize($ftmp); 
	$extensionarray = array('.jpg', '.png', '.jpeg');
	$imageSize = ($fsize / 1024) / 1024; 
	$errmsg = ''; 

	if(isset($ftmp)) {   
		if(!in_array($ext, $extensionarray)) {
			echo 'Please upload only jpg, png, jpeg images';	
			die;
			//$errmsg = 'Please upload only jpg, png, jpeg images for Site logo';	
		} elseif($imageSize > 2) {  
			echo 'Please upload image upto 2MB for images';   
			die;
			// $errmsg = 'Please upload image upto 10MB for Site logo';
		} elseif ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png")) {   

			$newname = time().'_'.$userid.$ext;
			$finalPath = $user_image_path . "original/";
			$thumbimage1 = $user_image_path . "thumb350/" . $newname;
			$thumbimage2 = $user_image_path . "thumb150/" . $newname;
			$thumbimage3 = $user_image_path . "thumb70/" . $newname;
			
			$result = move_uploaded_file($ftmp,$finalPath.$newname);
			
			chmod($finalPath.$newname, 0777);  

			if(empty($result)){
				echo "There was an error moving the uploaded file.";
				die;
			}
					
			// *** Include the class
			require_once("resize-class.php");
			
			$resizeObj = new resize($finalPath.$newname);
			$resizeObj -> resizeImage(150, 150, 'crop');
			$resizeObj -> saveImage($thumbimage2, 100);
			chmod($thumbimage2, 0644);

			$resizeObj = "";
			$resizeObj = new resize($finalPath.$newname);
			$resizeObj -> resizeImage(70, 70, 'crop');
			$resizeObj -> saveImage($thumbimage3, 100);
			chmod($thumbimage3, 0644);

			$resizeObj = "";
			$resizeObj = new resize($finalPath.$newname);
			$resizeObj -> resizeImage(350, 350, 'crop');
			$resizeObj -> saveImage($thumbimage1, 100);
			chmod($thumbimage1, 0644);
			
			$resizeObj = "";				
			$img_src = $site_url.$thumbimage3;
				
			?>

			<!-- Copy & Paste "Javascript Upload Script" -->
			<script>
				var par = window.parent.document;
				par.getElementById('show_url').src = '<?php echo $img_src; ?>';
				par.getElementById('image_computer').value = '<?php echo $newname; ?>';	
				var imagename = par.getElementById('image_computer').value;
				if(imagename){
					parent.document.getElementById('removeimg').style.display='block';
				}
			</script>
			<?php
		} else {
			echo "Error occurred in the file";   
			//$errmsg = 'Error occurred in the file';	
			die; 
		}
	}
      
?>
<script>
function upload(){
    var par = window.parent.document;
	document.getElementById('iform').submit();
	//par.getElementById('show_url').src = '<?php echo $site_url."img/indicator.gif";?>';
	par.getElementById('show_url').style.background = 'url(<?php echo $site_url."img/indicator.gif";?>)no-repeat scroll 50% center /contain';
}
</script>
<form id="iform" name="iform" class="settings" action="" method="post" enctype="multipart/form-data">
	<div class="row file-holder1">
		<div class="file file-input-js-active">
			<input type="file" value="Browse..." class="file-input-area1" id="file" style="opacity: 0;width:32px;filter: alpha(opacity = 0);" name="image" onchange="upload()"/>			
			<?php
			if (isset($merchant)){
				?>
				<div class="edit-profile" ></div>
			<?php }else { ?>
				<div class="edit-profile" ></div>
			<?php }?>
		</div>
	</div>
</form>
