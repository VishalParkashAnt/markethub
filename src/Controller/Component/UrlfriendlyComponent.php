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
class UrlfriendlyComponent extends Component{
	
	function initialize1(&$controller , $settings = array()) {

		$this->controller=&$controller;

	}

	function initialize(array $config) {

		$controller = $this->_registry->getController();
		//$this->controller=&$controller;

	}

	//startup()
	
	function startup(&$controller) {
	}
	//called after Controller::beforeRender()
	function beforeRender(&$controller) {
	}
	//called after Controller::render()
	function shutdown(&$controller) {
	}
	//called before Controller::redirect()
	function beforeRedirect(&$controller, $url, $status=null, $exit=true) {
	}
	function redirectSomewhere($value) {
	// utilizing a controller method
	$this->controller->redirect($value);
	}

	function setModels($names) {
        $this->_dbModel = $names;
    }//setModels()

	function get_facebook_cookie($app_id, $app_secret) {
		$args = array();
		parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
		ksort($args);
		$payload = '';
		foreach ($args as $key => $value) {
		if ($key != 'sig') {
		$payload .= $key . '=' . $value;
		}
		}
		if (md5($payload . $app_secret) != $args['sig']) {
		return null;
		}
		return $args;
	}


	function getfilecontents($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$res=curl_exec($ch);
		$info=curl_getinfo($ch);
		curl_close($ch);
		if($res === false || $info['http_code'] !=200 ) { $ret=array(false,$info['http_code'],$res);}
		else{$ret=array(true,$info['http_code'],$res);}
		return $ret;
	}
	
	function get_name($str){		
		$name = array();
		preg_match_all("/\@\w+\b/", $str, $output);
		foreach($output[0] as $out) array_push ($name, str_replace('@','', $out));
		if (count ($name) >= 1) return $name;
		else return false;
	}
	
	 public static function getUrlShorten($url = null){
		$shorturl = '';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://api.bit.ly/shorten?version=2.0.1&login=helderh&longUrl=".$url."&apiKey=R_828015046ab107868e680095b2d56b1a");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$res=curl_exec($ch);
		$info=curl_getinfo($ch);
		curl_close($ch);
		if($res === false || $info['http_code'] !=200 ) { $ret=array(false,$info['http_code'],$res);}
		else{$ret=array(true,$info['http_code'],$res);}
		
		if($ret[1] == "200"){
			$results = json_decode($ret[2], true);
			//echo "<pre>";print_r($results);echo "</pre>";
			//$shorturl = trim($results['results'][$longurl]['shortUrl']);
			foreach($results['results'] as $result){
				$shorturl = $result['shortUrl'];
			}
		}
		return $shorturl;

    }
	
	function date_diff($d1, $d2){
		$d1 = (is_string($d1) ? strtotime($d1) : $d1);
		$d2 = (is_string($d2) ? strtotime($d2) : $d2);
		
		//echo $d1."  ";
		//echo $d2."  ";
		
		$diff_secs = abs($d1 - $d2);
		$base_year = min(date("Y", $d1), date("Y", $d2));

		$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		return array(
			"years" => date("Y", $diff) - $base_year,
			"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
			"months" => date("n", $diff) - 1,
			"days_total" => floor($diff_secs / (3600 * 24)),
			"days" => date("j", $diff) - 1,
			"hours_total" => floor($diff_secs / 3600),
			"hours" => date("G", $diff),
			"minutes_total" => floor($diff_secs / 60),
			"minutes" => (int) date("i", $diff),
			"seconds_total" => $diff_secs,
			"seconds" => (int) date("s", $diff)
		);
	}	
	
	public static function aty_time_diff($from, $now=0){
		$txt = '';
		if($now==0) $now = time();
		$diff=$now-$from;
		$activityat = $from;
		$days=intval($diff/86400);
		$diff=$diff%86400;
		$hours=intval($diff/3600);
		$diff=$diff%3600;
		$minutes=intval($diff/60);
		$from = explode("-",date("Y-m-d",$from));
		$to = explode("-",date("Y-m-d",$now));
		$months = ($to[0]-$from[0])*12+$to[1]-$from[1];
		if( $to[1] == $from[1] && $to[2] > $from[2]) $months--; // incomplete month
		if( $to[1] == ($from[1]+1)%12 && $to[2] < $from[2]) $months--;
	
		if ($months > 0) {
			$txt = date("j M",$activityat);
			return $txt;
		}elseif($days>1) $txt  .= " $days days";
		else if ($days==1) $txt  .= " $days day";
	
		if($days < 2){
			if($hours>1) $txt = " $hours hrs";
			else if ($hours==1) $txt  = " $hours hr";
	
			if($hours < 1){
				if($minutes>1) $txt = " $minutes mins";
				//else if ($minutes<1) $txt  .= " less than half minute";
				else if ($minutes==1) $txt  = " $minutes min";
			}
		}
	
		if($txt=='') $txt = ' '. "5 secs";
		return $txt .' '. 'ago';
	}

	function utils_makeUrlFriendly($output) {
		if ($output == '') return $output;

		$output = substr($output, 0, 240);
		$output = strtolower($output);
		$filepath = WWW_ROOT.DS."translit.txt";
		// echo $filepath;
		if (file_exists($filepath)) {
			$translations = parse_ini_file($filepath);
			// echo "<pre>"; print_r($translations); echo "</pre>";die;
			$output = strtr($output, $translations);
		} 
			
		//$output = preg_replace("/\s/e" , "_" , $output); 	// Replace spaces with underscores
		$output = str_replace(" ", "_", $output); 	
		$output = str_replace("_", "-", $output); 	
		$output = str_replace("&amp;", "", $output); 	 
		$output = str_replace("__", "_", $output); 	 
		$output = str_replace("/", "", $output);
		$output = str_replace("\\", "", $output);
		$output = str_replace("'", "", $output); 	 
		$output = str_replace(",", "", $output); 	 
		$output = str_replace(";", "", $output); 	 
		$output = str_replace(":", "", $output); 	 
		$output = str_replace(".", "-", $output); 	 
		$output = str_replace("?", "", $output); 	 
		$output = str_replace("=", "-", $output); 	 
		$output = str_replace("+", "", $output); 	 
		$output = str_replace("$", "", $output); 	 
		$output = str_replace("&", "", $output); 	 
		$output = str_replace("!", "", $output); 	 
		$output = str_replace(">>", "-", $output); 	 
		$output = str_replace(">", "-", $output); 	 
		$output = str_replace("<<", "-", $output); 	 
		$output = str_replace("<", "-", $output); 	 
		$output = str_replace("*", "", $output); 	 
		$output = str_replace(")", "", $output); 	 
		$output = str_replace("(", "", $output);
		$output = str_replace("[", "", $output);
		$output = str_replace("]", "", $output);
		$output = str_replace("^", "", $output);
		$output = str_replace("%", "", $output);
		$output = str_replace("#", "", $output);
		$output = str_replace("@", "", $output);
		$output = str_replace("`", "", $output);
		$output = str_replace("\"", "", $output);
		$output = str_replace("--", "-", $output);
		$output = str_replace("---", "-", $output);			
		
		
		$output = str_replace("�", "i", $output);
		$output = str_replace("�", "i", $output);
		$output = str_replace("�", "i", $output);
		$output = str_replace("�", "i", $output);
		$output = str_replace("�", "I", $output);
		$output = str_replace("�", "I", $output);
		$output = str_replace("�", "I", $output);
		$output = str_replace("�", "I", $output);		
		$output = str_replace("�", "o", $output);
		$output = str_replace("�", "o", $output);
		$output = str_replace("�", "o", $output);
		$output = str_replace("�", "o", $output);
		$output = str_replace("�", "o", $output);
		$output = str_replace("�", "o", $output);
		$output = str_replace("�", "O", $output);
		$output = str_replace("�", "O", $output);
		$output = str_replace("�", "O", $output);
		$output = str_replace("�", "O", $output);
		$output = str_replace("�", "O", $output);
		$output = str_replace("�", "O", $output);
		$output = str_replace("�", "u", $output);
		$output = str_replace("�", "u", $output);
		$output = str_replace("�", "u", $output);
		$output = str_replace("�", "u", $output);
		$output = str_replace("�", "U", $output);
		$output = str_replace("�", "U", $output);
		$output = str_replace("�", "U", $output);
		$output = str_replace("�", "U", $output);
		$output = str_replace("�", "e", $output);
		$output = str_replace("�", "e", $output);
		$output = str_replace("�", "e", $output);
		$output = str_replace("�", "e", $output);
		$output = str_replace("�", "E", $output);
		$output = str_replace("�", "E", $output);
		$output = str_replace("�", "E", $output);
		$output = str_replace("�", "E", $output);
		$output = str_replace("�", "a", $output);
		$output = str_replace("�", "a", $output);
		$output = str_replace("�", "a", $output);
		$output = str_replace("�", "a", $output);
		$output = str_replace("�", "a", $output);
		$output = str_replace("�", "a", $output);
		$output = str_replace("�", "A", $output);
		$output = str_replace("�", "A", $output);
		$output = str_replace("�", "A", $output);
		$output = str_replace("�", "A", $output);
		$output = str_replace("�", "A", $output);
		$output = str_replace("�", "A", $output);
		$output = str_replace("�", "n", $output);
		$output = str_replace("�", "N", $output);
		$output = str_replace("�", "ae", $output);
		$output = str_replace("�", "AE", $output);
		$output = str_replace("�", "ss", $output);
		$output = str_replace("�", "e", $output);
		$output = str_replace("�", "C", $output);
		$output = str_replace("�", "y", $output);
		$output = str_replace("�", "Y", $output);
		$output = str_replace("�", "y", $output);
		$output = str_replace("�", "Y", $output);
		$output = str_replace("�", "", $output);
		$output = str_replace("�", "", $output);
		$output = str_replace("�", "", $output);
		$output = str_replace("�", "s", $output);
		$output = str_replace("�", "s", $output);
		$output = str_replace("�", "Z", $output);
		$output = str_replace("�", "z", $output);
		$output = str_replace("�", "", $output);
		$output = str_replace("�", "", $output);
		return $output;
	}
	
	//GET UNIQUE CODE FUNCTION
	function get_uniquecode($seed_length = null) {
		//$seed = md5(srand((double)microtime()*1000000))."ABCDEFGHIJKLMNOPQRSTUVWXYZ234567892345678923456789";
		//$seed = md5(srand((double)microtime()*1000000))."ABCDEFGHIJKLMNOPQRSTUVWXYZ2345678923456789abcdefghijklmnopqrstuvwxyz23456789abcdefghijklmnopqrstuvwxyz";
		if(empty($seed_length)){
			$seed_length = 8;
		}
		$seed = md5(srand((double)microtime()*1000000) + (strtotime('now')))."ABCDEFGHIJKLMNOPQRSTUVWXYZ2345678923456789abcdefghijklmnopqrstuvwxyz23456789abcdefghijklmnopqrstuvwxyz";
		$str = '';
		srand((double)microtime()*1000000);
		for ($i=0;$i<$seed_length;$i++) {
			$str .= substr ($seed, rand() % 48, 1);
		}	
		return $str;
	}
	
	public static function txt_time_diff($from, $now=0){	
		$txt = '';
		if($now==0) $now = time();
		$diff=$now-$from;
		$days=intval($diff/86400);
		$diff=$diff%86400;
		$hours=intval($diff/3600);
		$diff=$diff%3600;
		$minutes=intval($diff/60);

		if($days>1) $txt  .= " $days".__d('user','days');
		else if ($days==1) $txt  .= " $days".__d('user','day');

		if($days < 2){
			if($hours>1) $txt .= " $hours".__d('user','hours');
			else if ($hours==1) $txt  .= " $hours".__d('user','hour');
		
			if($hours < 3){
				if($minutes>1) $txt .= " $minutes".__d('user','minutes');
				//else if ($minutes<1) $txt  .= " less than half minute";
				else if ($minutes==1) $txt  .= " $minutes".__d('user','minute');
			}
		}
		
		if($txt=='') $txt = ' '. "5".__d('user','seconds');
		return $txt .' '. __d('user','ago');		
	}
	
	public static function limit_text($text, $limit) {
		if (str_word_count($text, 0) > $limit) {
			$words = str_word_count($text, 2);
			$pos = array_keys($words);
			$text = substr($text, 0, $pos[$limit]) . '....';
		}
		return $text;
	}
	
	public static function limit_char($text, $limit) {
		if (strlen($text) > 13) {
			$text = substr($text, 0, $limit) . '...';
			return $text;
		}else{
			return $text;
		}
	}
	
	function RssFactory() {
	}
	
	// rss generator
	function GenRssByData($aRssData, $sTitle, $sMainLink, $sImage = '',$name) {
		$sRSSLast = '';
		if (isset($aRssData[0]))
			$sRSSLast = $aRssData[0]['DateTime'];
	
		$sUnitRSSFeed = '';
		foreach ($aRssData as $iUnitID => $aUnitInfo) {
			$sUnitUrl = $aUnitInfo['Link'];
			$sUnitGuid = $aUnitInfo['Guid'];
			$sUnitTitle = $aUnitInfo['Title'];
			$sUnitDate = $aUnitInfo['DateTime'];
			$sUnitDesc = $aUnitInfo['Desc'];
				
			
			$text = $aUnitInfo['Title'];
			$image = '<p><img class="center" src="'.SITE_URL.'media/items/original/'.$aUnitInfo['Image_name'].'"  /></p>';
			$description = $image . $text;
			
			
			$sUnitRSSFeed .= "<item><title><![CDATA[{$sUnitTitle}]]></title><link><![CDATA[{$sUnitUrl}]]></link><guid><![CDATA[{$sUnitGuid}]]></guid><description><![CDATA[{$description}]]></description><pubDate>{$sUnitDate}</pubDate></item>";
		}
	
		$sRSSTitle = "Fantacy {$name}";
		$ss = "Item fantacy'd by {$name}";
		$sRSSImage = ($sImage != '') ? "<image><url>{$sImage}</url><title>{$sRSSTitle}</title><link>{$sMainLink}</link></image>" : '';
		return "<?xml version=\"1.0\" encoding=\"UTF-8\"?><rss version=\"2.0\"><channel><title>{$sRSSTitle}</title><link>{$sMainLink}</link><description>{$ss}</description><lastBuildDate>{$sRSSLast}</lastBuildDate>{$sRSSImage}{$sUnitRSSFeed}</channel></rss>";
	}
	
	
}





?>
