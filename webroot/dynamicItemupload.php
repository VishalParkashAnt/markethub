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
.glyphicons.upload:before {
    content: "+";
}
.glyphicons:before {
    color: #1D1D1B;
    display: inline-block;
    font: 24px/1em 'Glyphicons Regular';
    left: 0;
    margin: 0 5px 0 0;
    position: absolute;
    text-transform: none;
    top: 0;
    vertical-align: middle;
}
.glyphicons {
    color: #1D1D1B;
    display: inline-block;
    padding-left: 48px;
    position: relative;
    text-decoration: none;
    vertical-align: middle;
}
.glyphicons {
    line-height: 11px;
    overflow: visible;
    padding-right: 10px;
}
.uploaderMark i.glyphicons:before {
    font-size: 36px;
    font-weight: bold;
}
.uploaderMark {
    background-color: #F1F1F1;
    height: 130px;
    text-align: center;
    width: 100%;
}
.uploaderMark i {
    margin-left: 30px;
    margin-top: 70px;
    position: relative;
    top: -32px;
}
.file-holder1 .file-input-area1 {
	
    cursor: pointer;
    /* left: -137px; */
    left: -140px;
    margin: 0;
    position: absolute;
	top: 0;
    z-index: 3;
    height: 130px;	
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
    padding: 4px 10px;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
    width: 103px;
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
$image_id = $_REQUEST['image'];

@$ftmp = $_FILES['image']['tmp_name'];
@$oname = $_FILES['image']['name'];
@$fname = $_FILES['image']['name'];
@$fsize = $_FILES['image']['size'];
@$ftype = $_FILES['image']['type'];

$user_image_path = "media/items/";
$thumbimage = "";
$newname = ""; 
$ext = strrchr($oname, '.');

if(isset($ftmp)) {    
	$appImageValues = getimagesize($ftmp); 
	$extensionarray = array('.jpg', '.png', '.jpeg'); 
	$imageSize = ($fsize / 1024) / 1024; 
	$errmsg = ''; 

	
		if(!in_array($ext, $extensionarray)) {
			echo "Please upload only jpg, png, jpeg images";
			//$errmsg = 'Please upload only jpg, png, jpeg images';	 
			die;
		} elseif($imageSize > 2) {  
			echo 'Please upload image upto 2MB for images'; 
			//$errmsg = 'Please upload image upto 2MB for images'; 
			die; 
		} elseif ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png")) {

				$newname = time().'_'.$userid.$ext;
				$finalPath = $thumbimage = $user_image_path . "original/" ;

				$thumbimage1 = $user_image_path . "thumb350/" . $newname;
				$thumbimage2 = $user_image_path . "thumb150/" . $newname;
				$thumbimage3 = $user_image_path . "thumb70/" . $newname;
				
				$result = move_uploaded_file($ftmp,$thumbimage.$newname);

				chmod($thumbimage. $newname, 0777);

				if(empty($result)) { 
					echo "There was an error moving the uploaded file."; 
					die; 
				}

				require_once("newresizeclass.php");

				
				$newresizeObj = new SimpleImage();
				$newresizeObj->load($finalPath.$newname);
				$newresizeObj->resizeToWidth(350);
				$newresizeObj->resizeToHeight(350);
				$newresizeObj->save($thumbimage1);
				
				chmod($thumbimage1, 0777); 

				$newresizeObj = ""; 										
				$newresizeObj = new SimpleImage(); 
				$newresizeObj->load($finalPath.$newname);
				$newresizeObj->resizeToWidth(150);
				$newresizeObj->resizeToHeight(150);
				$newresizeObj->save($thumbimage2);
					
				chmod($thumbimage1, 0777); 

				$newresizeObj = ""; 
				$newresizeObj = new SimpleImage();				
				$newresizeObj->load($finalPath.$newname);
				$newresizeObj->resizeToWidth(70);
				$newresizeObj->resizeToHeight(70);
				$newresizeObj->save($thumbimage3);
					
				chmod($thumbimage1, 0777); 

				$newresizeObj = "";
				$img_src = $site_url.$thumbimage2;
				
			?>
			<!-- Copy & Paste "Javascript Upload Script" -->
			<script>
				
				var par = window.parent.document;
				var img = parseInt(par.getElementById('imageCount').value);
				par.getElementById('imageCount').value = img + 1;
				var img = parseInt(par.getElementById('delimageCount').value);
				par.getElementById('delimageCount').value = img + 1;				
				par.getElementById('show_url_'+img).src = '<?php echo $img_src; ?>';
				par.getElementById('removeimg_'+img).setAttribute('onclick','removeDynamicimg('+img+')');
				par.getElementById('image_computer_'+img).value = '<?php echo $newname; ?>';
				var imagename = par.getElementById('image_computer_'+img).value;
				if(imagename){
					parent.document.getElementById('removeimg_'+img).style.display='block';
					//parent.document.getElementById('frame_'+img).style.display='none';
				}
			</script>
			<?php
		} else { 
			echo 'Please upload only jpg, png, jpeg images';
			die; 
		}
	}
 
?>
<!-- Copy & Paste "Form" -->
<script type="text/javascript" src="js/jquery.js"></script>
<script>
var par = window.parent.document;
function upload(){
var file = document.getElementById("file").value;
var fsize = ($('#file')[0].files[0].size/1024)/1024;
var ftype = $('#file')[0].files[0].type;

//alert(ftype);
       
        
       if(ftype == 'image/jpeg' || ftype == 'image/jpg' || ftype == 'image/png' || ftype == 'image/gif')
	{
	if(fsize <= 2.5 )
	{
	$(".file-holder1").hide();
	var img = par.getElementById('delimageCount').value;
	var textToAppend = "<div id='image_"+img+"' class='item_images_' style='float:left;margin: 0 5px 5px;height:130px;'><img id='show_url_"+img+"' src='<?php echo $site_url."images/loader.gif";?>' width='130px' height='130px'/>";
	textToAppend += '<input type="hidden" value="" class="celeb_name" id="image_computer_'+img+'" name="data[image][]">';
	textToAppend +='<a id="removeimg_'+img+'" onclick="removeDynamicimgbefore('+
			img+')" href="javascript:void(0);" style="bottom:136px;left:103px;position:relative;width:25px;"><div style="background-color: #f3f3f3;border-radius: 20px;width:25px;color:#009efb;text-align:center;"><i class="fa fa-close remove_21"></i></div></a></div>';
	var div = par.getElementById('uploadedimages');
	
	div.innerHTML = div.innerHTML + textToAppend;
	document.getElementById('iform').submit();
	}
	
	else {
		alert("Image size upto 2.5 MB");
	}
	}
	else {
		alert("select a image file please");
	  }
    
	//par.getElementById('show_url_'+img).src = '<?php echo $site_url."img/indicator.gif";?>';
	//$('.uploadedimages').append(textToAppend);
	//document.getElementsByClassName("uploaderMark").style.display='block';
	//$(".uploaderMark").show();
}
</script>
<!-- <form id="iform" name="iform" action="" method="post" enctype="multipart/form-data">
<input id="file" type="file" onchange="upload()" name="image">
<input id="file" type="file" onchange="upload()" name="image" onclick="parent.document.getElementById('removeimg').style.display='block';">
</form>-->

<form id="iform" name="iform" class="settings" action="" method="post" enctype="multipart/form-data">
	<div class="row file-holder1">
		<div class="file file-input-js-active">
			<input type="file" value="Browse..." class="file-input-area1" id="file" style="opacity: 0;filter: alpha(opacity = 0);" name="image" onchange="upload()"/>
			<!-- <input type="text" id="input_value" value="Add Photos" class="btn text file-input-value" 
				readonly="readonly"/> -->
			<div class="uploaderMark"><i class="glyphicons upload"></i>&nbsp;<span style="margin-left:1px; position:relative; left:-6px;">Add</span></div>
		</div>
	</div>
</form>

