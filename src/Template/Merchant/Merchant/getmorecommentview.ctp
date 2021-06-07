
<?php   $i = $dcount;  

$message = '';
if (!empty($messagesel)){ 
	foreach($messagesel as $key => $msg) {

	     $msro = $msg['uorderid'];
	     $usid = $loguser['id'];
	     $disputeid = $msg['disid'];
	     $useid = $msg['userid'];
	     $itemdetail = $msg['itemdetail'];
	     $sellername = $msg['sname'];
	     $usename = $msg['uname'];
	     $amount = $msg['totprice'];
	     $money = $msg['money'];
	     $newstatus = $msg['newstatus'];
	     $newstatusup = $msg['newstatusup'];
	     $usernames = $msg['username_url'];
	     $item_title_url = $msg['item_title_url'];

	  
	  	$message .='<tr>';
	   $message .='<td class="p-l-20">'.++$i.'</td>';

	   if($useid == $usid) {   
	      $message .='<td><span style="color:#66B5D2;">#'.$disputeid.'</span></td>';
	   } else {
	      $message .='<td><span style="color: #9f9f9f;">#'.$disputeid.'</span></td>';
	   }

	   if($useid == $usid) { 
	      $message .='<td>';
			if($itemdetail == 'null') {
			  $message .='<span style="color: #66B5D2;">'.$msro.'</span>';
			} else {
				$subjects = json_decode($itemdetail, true);
				foreach($subjects as $key=>$sub) {
				  $message .='<span style="color:#66B5D2;">'.$sub.'</span><br/>';
				}
			}
	      $message .='</td>';
	   } else {
	      $message .='<td>';
	         if($itemdetail == 'null') {
	            $message .='<span style="color: #9f9f9f;">'.$msro.'</span>';
	         } else { 
	            $subjects = json_decode($itemdetail, true);
	            foreach($subjects as $key=>$sub) {
	               $message .='<span style="color: #9f9f9f;">'.$sub.'</span><br/>';
	            }
	         }
	      $message .='</td>';
	   }

	   if($useid == $usid) {
	      $message .='<td style="width:200px; text-overflow: ellipsis; word-wrap: break-word; overflow:hidden; color:#66B5D2;">'.$sellername.'</td>';
	   } else {
	      $message .='<td style="width:200px; text-overflow: ellipsis; word-wrap: break-word; overflow:hidden; color: #9f9f9f;">'.$usename.'</td>';
	   }

	   if($useid == $usid) {
	      $message .='<td class="p-l-20"><span style="color:#66B5D2;">'.$amount.' '.$currencyCode.'</span></td>';
	   } else {
	      $message .='<td class="p-l-20"><span style="color: #9f9f9f;">'.$amount.' '.$currencyCode.'</span></td>';
	   }

	   if($useid == $usid) {
	      $message .='<td>';
         if($newstatusup == 'Reply') {
           $message .='<span style="color: #66B5D2;">Responded</span>';
         } elseif($newstatusup == 'Responded'){
           $message .='<span style="color: #66B5D2;">Reply</span>';
         }elseif($newstatusup == 'Admin'){
           $message .='<span style="color: #66B5D2;">Reply</span>';
         } else{
           $message .='<span style="color: #66B5D2;">'.$newstatusup.'</span>'; 
      	}
     		$message .='</td>';
	   } else {
	     	$message .='<td>';
	      if($newstatusup == 'Reply') {
           $message .='<span style="color: #9f9f9f;">Reply</span>';
        	} elseif($newstatusup == 'Responded') {
           $message .='<span style="color: #9f9f9f;">Responded</span>';
        	} elseif($newstatusup == 'Admin') {
           $message .='<span style="color: #9f9f9f;">Reply</span>';
        	} else {
           $message .='<span style="color: #9f9f9f;">'.$newstatusup.'</span>';
        	}
     		$message .='</td>';
	   }

	   if($useid == $usid) {         
			$message .='<td>';
			$message .='<a href="'.MERCHANT_URL.'/disputemessage/'.$msro.'"><span class="btn btn-success"><i class="fa fa-search-plus"></i></span></a>';
			$message .='</td>';
	   } else {
	   	$message .='<td>';
			$message .='<a href="'.MERCHANT_URL.'/disputeBuyer/'.$msro.'"><span class="btn btn-success"><i class="fa fa-search-plus"></i></span></a>';
			$message .='</td>';
	   }       
		$message .='</tr>';
	}
	$result[] = count($messagesel);
	$result[] = $message;
	$output = json_encode($result);
	echo $output;	
} else {
	echo "false";
} ?> 