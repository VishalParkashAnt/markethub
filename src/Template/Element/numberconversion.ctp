<?php
	function format_number($n) {
		// first strip any formatting;
		$n = (0+str_replace(",","",$n));

		// is this a number?
		if(!is_numeric($n)) return false;

		// now filter it;
		if($n>=1000000000000) return round(($n/1000000000000),1).' T';
		else if($n>=1000000000) return round(($n/1000000000),1).' B';
		else if($n>=1000000) return round(($n/1000000),1).' M';
		else if($n>=1000) return round(($n/1000),1).' K';

		return number_format($n);
	}

	function aty_time_diff($from, $now=0){
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
		}elseif($days>1) $txt  .= " $days ".__d('user','days');
		else if ($days==1) $txt  .= " $days ".__d('user','day');

		if($days < 2){
			if($hours>1) $txt = " $hours ".__d('user','hours');
			else if ($hours==1) $txt  = " $hours ".__d('user','hour');

			if($hours < 1){
				if($minutes>1) $txt = " $minutes ".__d('user','minutes');
				//else if ($minutes<1) $txt  .= " less than half minute";
				else if ($minutes==1) $txt  = " $minutes ".__d('user','minute');
			}
		}

		if($txt=='') $txt = ' '. "5 ".__d('user','seconds');
		return $txt .' '.__d('user','ago');
	}

	function txt_time_diff($from, $now=0){
		$txt = '';
		if($now==0) $now = time();
		$diff=$now-$from;
		$days=intval($diff/86400);
		$diff=$diff%86400;
		$hours=intval($diff/3600);
		$diff=$diff%3600;
		$minutes=intval($diff/60);

		if($days>1) $txt  .= " $days ".__d('user','days');
		else if ($days==1) $txt  .= " $days ".__d('user','day');

		if($days < 2){
			if($hours>1) $txt .= " $hours ".__d('user','hours');
			else if ($hours==1) $txt  .= " $hours ".__d('user','hour');

			if($hours < 3){
				if($minutes>1) $txt .= " $minutes ".__d('user','minutes');
				//else if ($minutes<1) $txt  .= " less than half minute";
				else if ($minutes==1) $txt  .= " $minutes ".__d('user','minute');
			}
		}

		if($txt=='') $txt = ' '. "5 ".__d('user','seconds');
		return $txt .' '. __d('user','ago');
	}

	function limit_char($text, $limit) {
		if (strlen($text) > 13) {
			$text = substr($text, 0, $limit) . '...';
			return $text;
		}else{
			return $text;
		}
	}
	?>