<?php namespace Cake\I18n;
use Cake\I18n\Time;
				if(count($items_data)>0){
foreach($items_data as $itms)
{
				$usercmntcount='';

				$itemid = base64_encode($itms->id."_".rand(1,9999));
				$item_title = $itms['item_title'];
				$item_title_url = $itms['item_title_url'];
				$item_price = $itms['price'];
				$favorte_count = $itms['fav_count'];
				$username = $itms['user']['username'];
				$currencysymbol = $itms['forexrate']['currency_symbol'];
				$items_image = $itms['photos'][0]['image_name'];
				$dealprice = $item_price * ( 1 - $itms['discount'] / 100 );


					$itemprice = $itms['price'];

$user_currency_price =  $currencycomponent->conversion($itms['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

				echo '<span id="figcaption_titles'.$itms['id'].'" figcaption_title ="'.$item_title.'" ></span>';
				echo  '<span class="figcaption" id="figcaption_title_url'.$itms['id'].'" figcaption_url ="'.$item_title_url.'" style="position: relative; top: 10px; left: 7px;display:none;" >'.$item_title_url.'</span>';
				echo '<span id="price_vals'.$user_currency_price.'" price_val="'.$_SESSION['currency_symbol'].$item_price.'" ></span>';
				echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$itms['id'].'" usernameval ="'.$username.'"></a>';
				echo '<span id="img_'.$itms['id'].'" class="nodisply">'.SITE_URL.'media/items/original/'.$items_image.'</span>';
				echo '<span class="fav_count" id="fav_count'.$itms['id'].'" fav_counts ="'.$favorte_count.'" ></span>';

				$item_image = $itms['photos'][0]['image_name'];
						if($item_image == "")
						{
							$itemimage = SITE_URL.'media/items/original/usrimg.jpg';
						}
						else
						{
							$itemimage = WWW_ROOT.'media/items/original/'.$item_image;
							/*$header_response = get_headers($itemimage, 1);*/
							if (file_exists($itemimage))
							{
								$itemimage = SITE_URL.'media/items/original/'.$item_image;
							}
							else
							{
								$itemimage = SITE_URL.'media/items/original/usrimg.jpg';
							}
						}
				$itemid = base64_encode($itms['id']."_".rand(1,9999));

	if($loguser=="")
{
	$temp = ""; 
	$temp1= "";
}
else
{
	$temp = "modal";
	$temp1=  "#share-modal";
}



	echo '<div class="item1 box_shadow_img"><div class="product_cnt box_shadow_img col-lg-3 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
		<a class="img-hover" href="'.SITE_URL.'listing/'.$itemid.'">
			<img src="'.$itemimage.'" class="img-responsive" /></a>
			<div class="hover-visible">
				<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou('.$itms['id'].')">	';
								
					if(count($likeditemid)!=0 &&  in_array($itms['id'],$likeditemid)){
							/*echo 	'<i class="fa fa-heart like-icon'.$itms['id'].'" id="like-icon'.$itms['id'].'"></i>*/
echo '<img src="'.SITE_URL.'images/icons/liked-w.png" id="like-icon'.$itms['id'].'" class="like-icon'.$itms['id'].'">							
								<span class="like-txt'.$itms['id'].' nodisply" id="like-txt'.$itms['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';}
								else
								{
				/*echo 	'<i class="fa fa-heart-o like-icon'.$itms['id'].'" id="like-icon'.$itms['id'].'"></i>*/
echo '<img src="'.SITE_URL.'images/icons/heart_icon.png" id="like-icon'.$itms['id'].'" class="like-icon'.$itms['id'].'">
												<span class="like-txt'.$itms['id'].' nodisply" id="like-txt'.$itms['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';
								}
				echo '</span>
				<span class="hover-icon-cnt share_hover" href="javascript:void(0)" onclick="share_posts('.$itms['id'].');" data-toggle="'.$temp.'" data-target="'.$temp1.'"><img src="'.SITE_URL.'images/icons/share_icon.png"></span>
			</div>
		

		<div class="rate_section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="product_name bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="">'.$itms['item_title'].'</a><br/>';


				$date = date('d');
					$month = date('m');
					$year = date('y');
					$tdy = strtotime($month . '/' . $date . '/' . $year);
					$newdate = new Time($item['dealdate']);
					$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
					
						
			if($itms['discount_type'] =='daily' && $dealdate >= $tdy){
				echo 'daily deal';
			echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

			
//

$dealprice = $itemprice * ( 1 - $itms['discount'] / 100 );

$user_currency_dealprice = $currencycomponent->conversion($itms['forexrate']['price'],$_SESSION['currency_value'],$dealprice);

 if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
					}
					else{?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
						echo $itms['forexrate']['currency_symbol'].' '.$dealprice;
				}
					echo ' ';
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$itms['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}
			
echo '</div>';
}elseif($itms['discount_type'] =='regular'){
	echo 'regular';
echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

			
//

$dealprice = $itemprice * ( 1 - $itms['discount'] / 100 );

$user_currency_dealprice = $currencycomponent->conversion($itms['forexrate']['price'],$_SESSION['currency_value'],$dealprice);

 if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					//echo '('.$_SESSION['currency_symbol'].' '.$user_currency_dealprice.')';
					echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
					}
					else{?>&#x200E;<?php
					//echo ' ('.$deal['forexrate']['currency_symbol'].' '.$discountprice.')';
						echo $itms['forexrate']['currency_symbol'].' '.$dealprice;
				}
					echo ' ';
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$itms['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}
			
echo '</div>';
}else{
	echo 'no deal';
	echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';

	if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo $_SESSION['currency_symbol'].' '.$user_currency_price;
				}
					else{?>&#x200E;<?php
					echo $itms['forexrate']['currency_symbol'].' '.$itemprice;}
				
				echo '</div>';
}
				
			echo '</div>
		</div>
	</div>';
}

}
else
{
		echo 'false';
}
return false;
?>