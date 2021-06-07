<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
if (count($itemDetails) != 0) {
foreach($itemDetails as $deals)
{
	$itemid = base64_encode($deals->id."_".rand(1,9999));
	$item_title = $deals['item_title'];
	$item_title_url = $deals['item_title_url'];
	$item_price = $deals['price'];
	$favorte_count = $deals['fav_count'];
	$username = $deals['user']['username'];
	$currencysymbol = $deals['forexrate']['currency_symbol'];
	$items_image = $deals['photos'][0]['image_name'];
	$itemprice = $deals['price'];
	$user_currency_price =  $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$itemprice);
	echo '<span id="figcaption_titles'.$deals['id'].'" figcaption_title ="'.$item_title.'" ></span>';
	echo  '<span class="figcaption" id="figcaption_title_url'.$deals['id'].'" figcaption_url ="'.$item_title_url.'" style="position: relative; top: 10px; left: 7px;display:none;" >'.$item_title_url.'</span>';
	echo '<span id="price_vals'.$deals['id'].'" price_val="'.$currencysymbol.$item_price.'" ></span>';
	echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$deals['id'].'" usernameval ="'.$username.'"></a>';
	echo '<span id="img_'.$deals['id'].'" class="nodisply">'.SITE_URL.'media/items/original/'.$items_image.'</span>';
	echo '<span class="fav_count" id="fav_count'.$deals['id'].'" fav_counts ="'.$favorte_count.'" ></span>';
	$item_image = $deals['photos'][0]['image_name'];
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
	?>
	<div class="item">
		<div class="grid cs-style-3 no-hor-padding">
			<div class="image-grid col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div><figure class="animate-box bounceIn animated">
					<a href="<?php echo $baseurl.'listing/'.$itemid;?>" class="fh5co-board-img">
						<img class="img-responsive" src="<?php echo $itemimage;?>" alt="img">
					</a>
				</figure></div>
				<div class="rate_section bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="product_name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<a href=""><?php echo $deals->item_title;?></a></div>
							<?php  $tdy = date("n/d/y");
							if($deals['dailydeal'] =='yes' && $deals['dealdate'] == $tdy){
								echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
								$dealprice = $itemprice * ( 1 - $deals['discount'] / 100 );
								$user_currency_dealprice = $currencycomponent->conversion($deals['forexrate']['price'],$_SESSION['currency_value'],$dealprice);
								if(isset($_SESSION['currency_code'])){?>&#x200E;<?php

									echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice;
								}
								else{?>&#x200E;<?php
									echo $deals['forexrate']['currency_symbol'].' '.$dealprice;
								}
								echo ' ';
								if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
									echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
								}
								else{?>&#x200E;<?php
									echo '<strike class="bold-font">'.$deals['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
								}
								echo '</div>';}
								else
								{
									echo '<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
									if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
										echo $_SESSION['currency_symbol'].' '.$user_currency_price;
									}
									else{?>&#x200E;<?php
										echo $deals['forexrate']['currency_symbol'].' '.$itemprice;}
										echo '</div>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div><?php echo '~|~'; ?>
			<?php }}
			else {
            echo 'false';
        }
			?>
