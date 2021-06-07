<?php
namespace Cake\Controller\Component;

use Cake\Auth\Storage\StorageInterface;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Core\App;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\Event\EventDispatcherTrait;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Network\Exception\ForbiddenException;
use Cake\Routing\Router;
use Cake\Utility\Hash;	
class FileUploadComponent extends Component{
	
	function initialize(&$controller , $settings = array()) {
	
		$this->controller=&$controller;
	
	}
	//startup()
	
	function startup(&$controller) {
	}
	//called before Controller::redirect()
	function beforeRedirect(&$controller, $url, $status=null, $exit=true) {
	}
	//called after Controller::beforeRender()
	function beforeRender(&$controller) {
	}
	//called after Controller::render()
	function shutdown(&$controller) {
	}
	
	public function upload ($imageurl,$fileName=Null,$type="user"){
		
		global $setngs;
		global $loguser;
		$userId = $loguser[0]['User']['id'];
		$mediaUserName = $setngs[0]['Sitesetting']['media_server_username'];
		$hostName = $setngs[0]['Sitesetting']['media_server_hostname'];
		$media_url = $setngs[0]['Sitesetting']['media_url'];
		$password = $setngs[0]['Sitesetting']['media_server_password'];
		$site_url = SITE_URL;
		
		if ($media_url == ''){
			$media_url = $site_url;
		}
		
		if ($type == "item"){
			$user_image_path = "media/items/";
		}else{
			$user_image_path = "media/avatars/";
		}
		$newimage = "";
		$thumbimage = "";
		$newname = time().'_'.$userId.".jpg";
		if($fileName != Null){
			$newname = $fileName;
		}
		$finalPath = $user_image_path . "original/";
		$thumbimage1 = $user_image_path . "thumb350/" . $newname;
		$thumbimage2 = $user_image_path . "thumb150/" . $newname;
		$thumbimage3 = $user_image_path . "thumb70/" . $newname;
		$out = 0;
		while ($out == 0) {
		$i = file_get_contents($imageurl);
			if ($i != false){
				$out = 1;
			}
		}
		//chmod($image_save, 0644);
		$fori = fopen($finalPath.$newname,'wb');
		fwrite($fori,$i);
		fclose($fori);
		chmod($finalPath.$newname, 0666);
		
		if ($media_url != $site_url) {
			$host = explode("/", $media_url);
			print_r($host);
			$count = count($host)-1;
			$path = 'public_html/';$i = 3;
			while ($i < $count){
				$path .= $host[$i]."/";
				$i += 1;
			}
			
			// set up basic connection
			$conn_id = ftp_connect($hostName);
			
			// login with username and password
			$login_result = ftp_login($conn_id, $mediaUserName, $password);
				
			//check if directory exists and if not then create it
			if(!@ftp_chdir($conn_id, $path.$finalPath)) {
				//create diectory
				ftp_mkdir($conn_id, $path.$finalPath);
				//change directory
				ftp_chdir($conn_id, $path.$finalPath);
			}
			//echo "Dir: ".ftp_pwd($conn_id);
				
			$ret = ftp_nb_put($conn_id, $newname, $finalPath.$newname, FTP_BINARY, FTP_AUTORESUME);
			while(FTP_MOREDATA == $ret) {
				$ret = ftp_nb_continue($conn_id);
			}
				
			if($ret == FTP_FINISHED) {
				//success message
			} else {
				$error["result"] = "Failed uploading file '" . $newname . "'.";
			}
			// close the connection
			//ftp_close($conn_id);
		}
		
		// *** Include the class
		//require_once( WWW_ROOT . "resize-class.php");
		require_once("newresizeclass.php");
		
		// *** 1) Initialize / load image
		/* $resizeObj = new resize($finalPath.$newname);
		 	
		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
		$resizeObj -> resizeImage(150, 150, 'auto');
			
		// *** 3) Save image
		$resizeObj -> saveImage($thumbimage2, 100);
		chmod($thumbimage2, 0644);
		$resizeObj = ""; */
			
		$newresizeObj = new SimpleImage();
			
		$newresizeObj->load($finalPath.$newname);
		$newresizeObj->resizeToWidth(150);
		$newresizeObj->resizeToHeight(150);
		$newresizeObj->save($thumbimage2);
			
		$newresizeObj = "";
		chmod($thumbimage2, 0644);
		
		/* require_once( WWW_ROOT . 'pThumb.php' );
		$img=new pThumb();
		$img->pSetSize('150', '150');
		$img->pSetQuality(100);
		$img->pCreate($finalPath.$newname, 150, 150);
		$img->pSave($thumbimage2); 
		chmod($thumbimage2, 0644);
		$img = "";*/
		
		if ($media_url != $site_url) {
			ftp_cdup($conn_id);
			//echo "Dir: ".ftp_pwd($conn_id);
			if(!@ftp_chdir($conn_id, "thumb150")) {
				//create diectory
				ftp_mkdir($conn_id, "thumb150");
				//change directory
				ftp_chdir($conn_id, "thumb150");
			}
			//echo "Dir: ".ftp_pwd($conn_id);
		
			$ret = ftp_nb_put($conn_id, $newname, $thumbimage2, FTP_BINARY, FTP_AUTORESUME);
			while(FTP_MOREDATA == $ret) {
				$ret = ftp_nb_continue($conn_id);
			}
		
			if($ret == FTP_FINISHED) {
				//success message
			} else {
				$error["result"] = "Failed uploading file '" . $newname . "'.";
			}
			unlink($thumbimage2);
		}
		
		// *** 1) Initialize / load image
		/* $resizeObj = new resize($finalPath.$newname);
		
		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
		$resizeObj -> resizeImage(70, 70, 'auto');
		
		// *** 3) Save image
		$resizeObj -> saveImage($thumbimage3, 100);
		chmod($thumbimage3, 0644);
		$resizeObj = ""; */
		
		$newresizeObj = new SimpleImage();
		
		$newresizeObj->load($finalPath.$newname);
		$newresizeObj->resizeToWidth(70);
		$newresizeObj->resizeToHeight(70);
		$newresizeObj->save($thumbimage3);
		
		$newresizeObj = "";
		chmod($thumbimage3, 0644);
		
		/* $img=new pThumb();
		
		$img->pSetSize('70', '70');
		$img->pSetQuality(80);
		$img->pCreate($finalPath.$newname, 70, 70);
		$img->pSave($thumbimage3);
		chmod($thumbimage3, 0644);
		$img = ""; */
		
		if ($media_url != $site_url) {
			ftp_cdup($conn_id);
			//echo "Dir: ".ftp_pwd($conn_id);
			if(!@ftp_chdir($conn_id, "thumb70")) {
				//create diectory
				ftp_mkdir($conn_id, "thumb70");
				//change directory
				ftp_chdir($conn_id, "thumb70");
			}
			//echo "Dir: ".ftp_pwd($conn_id);
		
			$ret = ftp_nb_put($conn_id, $newname, $thumbimage3, FTP_BINARY, FTP_AUTORESUME);
			while(FTP_MOREDATA == $ret) {
				$ret = ftp_nb_continue($conn_id);
			}
		
			if($ret == FTP_FINISHED) {
				//success message
			} else {
				$error["result"] = "Failed uploading file '" . $newname . "'.";
			}
			unlink($thumbimage3);
		}
		
		// *** 1) Initialize / load image
		//$resizeObj = new resize($finalPath.$newname);
		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
		//$resizeObj -> resizeImage(350, 350, 'auto');
		
		// *** 3) Save image
		//$resizeObj -> saveImage($thumbimage1, 100);
		//$resizeObj = "";
		
		$newresizeObj = new SimpleImage();
		
		$newresizeObj->load($finalPath.$newname);
		$newresizeObj->resizeToWidth(350);
		$newresizeObj->resizeToHeight(350);
		$newresizeObj->save($thumbimage1);
		
		$newresizeObj = "";
		chmod($thumbimage1, 0644);
		
		$heightandwidth = getimagesize($finalPath.$newname);
		/* $img=new pThumb();
		//if($heightandwidth[0]>70 || $heightandwidth[1]>70){
		$img->pSetSize('350', '350');
		$img->pSetQuality(80);
		$img->pCreate($finalPath.$newname, $heightandwidth[0], $heightandwidth[1]);
		//}
		$img->pSave($thumbimage1);
		chmod($thumbimage1, 0644);
		$img = ""; */
		
		if ($media_url != $site_url) {
			ftp_cdup($conn_id);
			//echo "Dir: ".ftp_pwd($conn_id);
			if(!@ftp_chdir($conn_id, "thumb350")) {
				//create diectory
				ftp_mkdir($conn_id, "thumb350");
				//change directory
				ftp_chdir($conn_id, "thumb350");
			}
			//echo "Dir: ".ftp_pwd($conn_id);
		
			$ret = ftp_nb_put($conn_id, $newname, $thumbimage1, FTP_BINARY, FTP_AUTORESUME);
			while(FTP_MOREDATA == $ret) {
				$ret = ftp_nb_continue($conn_id);
			}
		
			if($ret == FTP_FINISHED) {
				//success message
			} else {
				$error["result"] = "Failed uploading file '" . $newname . "'.";
			}
			unlink($thumbimage1);
			unlink($finalPath.$newname);
			ftp_close($conn_id);
			$img_src = "http://".$media_url.$thumbimage3;
		} else {
			$img_src = $site_url.$thumbimage3;
		}
		
	}
}
