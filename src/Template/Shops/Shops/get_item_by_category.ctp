<?php
use Cake\I18n\Time;


//echo '<div>'.ucfirst($categoryName).'</div>///';
// echo "COUNT=".count($item);
// echo"<pre>";print_r($item);die;
if ($item_count > 0 ) {
	if (isset($loguser['id']))
		echo '<input type="hidden" id="loguserid" value="' . $loguser['id'] . '">';
	else
		echo '<input type="hidden" id="loguserid" value="0">';

	echo '<input type="hidden" id="likebtncnt" value="' . $setngs['like_btn_cmnt'] . '" />';
	echo '<input type="hidden" id="likedbtncnt" value="' . $setngs['liked_btn_cmnt'] . '" />';
	//foreach ($item as $itemdata) {
		// foreach ($itemdata as $itms) {
		foreach ($item as $key => $itms) {
			//echo"<pre>";print_r($itms);die;
			// $itm_id = $itms['id'];
			// $item_title_url = $itms['item_title_url'];
			// $item_title = $itms['item_title'];
			// $image_name = $itms['photos'][0]['image_name'];
			// $price = $itms['price'];
			// $user_id = $itms['user_id'];
			// $item_price = $itms['price'];
			// $item_default_price = round($itms['price'] * $itms['forexrate']['price'], 2);
			// $itemid = base64_encode($itm_id . "_" . rand(1, 9999));
			// 			//$item_title = UrlfriendlyComponent::limit_char($item_title,12);

			// $item_price = $itms['price'];
			// $favorte_count = $itms['fav_count'];
			// $username = $itms['user']['username'];
			// $currencysymbol = $itms['forexrate']['currency_symbol'];
			// $items_image = $itms['photos'][0]['image_name'];
			// $item_image = $itms['photos'][0]['image_name'];
			// if ($item_image == "") {
			// 	$itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
			// } else {
			// 	$itemimage = WWW_ROOT . 'media/items/original/' . $item_image;
			// 	/*$header_response = get_headers($itemimage, 1);*/
			// 	if (file_exists($itemimage)) {
			// 		$itemimage = SITE_URL . 'media/items/original/' . $item_image;
			// 	} else {
			// 		$itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
			// 	}
			// }


			// $itemprice = $itms['price'];
			// $user_currency_price = $currencycomponent->conversion($itms['forexrate']['price'], $_SESSION['currency_value'], $itemprice);

			// if (isset($itms['photos'][0])) {
			// 	$image_name = $itms['photos'][0]['image_name'];
			// } else {
			// 	$image_name = "usrimg.jpg";
			// }
			// $shopname_url = $itms['shop']['shop_image'];
			// $username_url = $itms['user']['profile_image'];
			// if ($shopname_url == '') {
			// 	$shopname_url = 'usrimg.jpg';
			// }
			// if ($username_url == '') {
			// 	$username_url = 'usrimg.jpg';
			// }
			// $user_level = $itms['user']['user_level'];
			// $username = $itms['user']['username'];
			// $sellername = $itms['shop']['shop_name'];
			// $sellername_id = $itms['shop']['user_id'];
			// $sellername_url_ori = $itms['shop']['shop_name_url'];

			// $username_url_ori = $itms['user']['username_url'];
			// $favorte_count = $itms['fav_count'];

			// $item_price = $itms['price'];
			// $item_default_price = round($item_price * $itms['forexrate']['price'], 2);
			// $size_options = $itms['size_options'];
			// $sizeoptions = json_decode($size_options, true);
			// if (!empty($sizeoptions['size'])) {
			// 	$item_price = reset($sizeoptions['price']);
			// 	$item_default_price = round(reset($sizeoptions['price']) * $itms['Forexrates']['price'], 2);
			// }


			// echo '<span id="figcaption_titles' . $itms['id'] . '" figcaption_title ="' . $item_title . '" ></span>';
			// echo '<span class="figcaption" id="figcaption_title_url' . $itms['id'] . '" figcaption_url ="' . $item_title_url . '" style="position: relative; top: 10px; left: 7px;display:none;" >' . $item_title_url . '</span>';
			// echo '<span id="price_vals' . $itms['id'] . '" price_val="' . $_SESSION['currency_symbol'] . $user_currency_price . '" ></span>';
			// echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $itms['id'] . '" usernameval ="' . $username . '"></a>';
			// echo '<span id="img_' . $itms['id'] . '" class="nodisply">' . SITE_URL . 'media/items/original/' . $items_image . '</span>';
			// echo '<span class="fav_count" id="fav_count' . $itms['id'] . '" fav_counts ="' . $favorte_count . '" ></span>';
			// if ($loguser == "") {
			// 	$temp = "";
			// 	$temp1 = "";
			// } else {
			// 	$temp = "modal";
			// 	$temp1 = "#share-modal";
			// }
			$itm_id = $itms['id'];
			$item_title_url = $itms['item_title_url'];
			$item_title = $itms['item_title'];
			$image_name = $itms['photos'][0]['image_name'];
			$price = $itms['price'];
			$user_id = $itms['user_id'];
			$item_price = $itms['price'];
			$item_default_price = round($itms['price'] * $itms['forexrate']['price'], 2);
			$itemid = base64_encode($itm_id . "_" . rand(1, 9999));
			$item_price = $itms['price'];
			$favorte_count = $itms['fav_count'];
			$username = $itms['user']['username'];
			$currencysymbol = $itms['forexrate']['currency_symbol'];
			$items_image = $itms['photos'][0]['image_name'];
					//$item_title = UrlfriendlyComponent::limit_char($item_title,12);

			if (isset($itms['photos'][0])) {
				$image_name = $itms['photos'][0]['image_name'];
			} else {
				$image_name = "usrimg.jpg";
			}
			$shopname_url = $itms['shop']['shop_image'];
			$username_url = $itms['user']['profile_image'];
			if ($shopname_url == '') {
				$shopname_url = 'usrimg.jpg';
			}
			if ($username_url == '') {
				$username_url = 'usrimg.jpg';
			}
			$user_level = $itms['user']['user_level'];
			$username = $itms['user']['username'];
			$sellername = $itms['shop']['shop_name'];
			//echo "SELLER=".$sellername;
			$sellername_id = $itms['shop']['user_id'];
			$sellername_url_ori = $itms['shop']['shop_name_url'];

			$username_url_ori = $itms['user']['username_url'];
			$favorte_count = $itms['fav_count'];

			$item_price = $itms['price'];
			$item_default_price = round($item_price * $itms['forexrate']['price'], 2);
			$size_options = $itms['size_options'];
			$sizeoptions = json_decode($size_options, true);
			if (!empty($sizeoptions['size'])) {
				$item_price = reset($sizeoptions['price']);
				$item_default_price = round(reset($sizeoptions['price']) * $itms['Forexrates']['price'], 2);
			}

			$itemprice = $itms['price'];
			 $today = strtotime(date("Y-m-d"));
            $dealdate1 = date("Y-m-d", strtotime($itms['dealdate']));
            $dealDate = strtotime($dealdate1);
			$user_currency_price = $currencycomponent->conversion($itms['forexrate']['price'], $_SESSION['currency_value'], $itemprice);
			  if ($itms['discount_type'] == 'daily' && $itms == $today) {
			  		  $dealprice = $itemprice * ( 1 - $itms['discount'] / 100 );
                 $user_currency_price =  $currencycomponent->conversion($itms['forexrate']['price'],$_SESSION['currency_value'],$dealprice);
              
			  }
			  elseif($itms['discount_type'] == 'regular') {
			  	  $dealprice = $itemprice * ( 1 - $itms['discount'] / 100 );
                 $user_currency_price =  $currencycomponent->conversion($itms['forexrate']['price'],$_SESSION['currency_value'],$dealprice);
			  }

			 
			if ($loguser == "") {
				$temp = "";
				$temp1 = "";
			} else {
				$temp = "modal";
				$temp1 = "#share-modal";
			}
			 ?>
			  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 newdproduct">
                  <div class="product_cnt clearfix">
                    <a class="just_products" href="<?php echo SITE_URL.'listing/'.$itemid;?>">
  
                      <img src="<?php echo SITE_URL . 'media/items/original/' . $items_image;?>" class="justimg-responsive">
  
                    </a>
      <div class="hover-visible">

                    <span class="hover-icon-cnt like_hover unmatched" href="javascript:void(0);" onclick="itemcou(<?php echo $itms['id'];?>)">
                    <!--   <img src="<?php //echo SITE_URL.'/img/like.png'; ?>" id="like-icon<?php echo $popular['id'];?>" class="like-icon<?php echo $popular['id'];?>"> -->
                      <span class="like-txt<?php echo $itms['id'];?> nodisply" id="like-txt<?php echo $itms['id'];?>"><?php echo $setngs['like_btn_cmnt'];?></span>
                      <?php if (count($likeditemid) != 0 && in_array($itms['id'], $likeditemid)) {
                echo '<img src="' . SITE_URL . 'img/Heart filled@2x.png" id="like-icon' . $itms['id'] . '" class="like-icon' . $itms['id'] . '" alt="liked">
                <span style="display:none" class="like-txt' . $itms['id'] . ' nodisply" id="like-txt' . $itms['id'] . '" >' . $setngs['liked_btn_cmnt'] . '</span>';
              } else {
                
                echo '<img src="' . SITE_URL . 'img/like.png" id="like-icon' . $itms['id'] . '" class="like-icon' . $itms['id'] . '" alt="unliked">
                <span style="display:none" class="like-txt' . $itms['id'] . ' nodisply" id="like-txt' . $itms['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
              }?>
                    </span>

                    <span class="hover-icon-cnt share_hover" href="#" onclick="share_posts(<?php echo $itms['id'];?>);" data-toggle="modal"
                      data-target="#share-modal">
                      <img src="<?php echo SITE_URL.'/img/Mask Group 66.png'?>"> </span>

                    <span id="figcaption_titles<?php echo $itms['id'];?>" figcaption_title="<?php echo $itms['item_title'];?>"
                      style="display:none;width:0px !important;"><?php echo $itms['item_title'];?></span><span class="figcaption"
                      id="figcaption_title_url" figcaption_url="<?php echo $itms['item_title_url'];?>"
                      style="display:none;width:0px !important;"><?php echo $itms['item_title_url'];?></span><a href="<?php echo SITE_URL.'/people/'?>" id="user_n<?php echo $itms['id'];?>" usernameval="<?php echo $sellername;?>"
                      style="display:none;width:0px !important;"></a><span id="img_<?php echo $itms['id'];?>" class="nodisply"
                      style="display:none;width:0px !important;"><?php echo SITE_URL . 'media/items/original/' . $items_image;?></span><span
                      class="fav_count" id="fav_count<?php echo $itms['id'];?>" fav_counts="<?php echo $favorte_count;?>" style="display:none;width:0px !important;"><?php echo $favorte_count;?></span>
                  </div>
  
                    <div class="just_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                      <a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"
                        href="<?php echo SITE_URL.'listing/'.$itemid;?>">
                        <span><?php echo $item_title;?> </span> </a>
  
                      <!--<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
             ‎$ 24250</div>-->
  
                      <span id="price_vals<?php echo $itms['id'];?>" price_val="<?php echo $currencysymbol.' '.$user_currency_price;?>" style="display:none;width:0px !important;"></span>
                      <div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">‎<?php echo $currencysymbol.' '.$user_currency_price;?>
                      <?php if($itemprice!=$user_currency_price){ ?>
                      <strike class="bold-font"><?php echo $currencysymbol.' '.$itemprice;?></strike>
                  <?php }?>
                        ‎</div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                   
   						 <div class="d-flex ratings">
                            <div>
                              <?php 
                               for ($i = 1;$i <= 5;$i++)
                                {
                                    $status = ($i <= $itms['avg_rating']) ? 'fa fa-star checked' : 'fa fa-star';
                                    echo '<i id="" class="' . $status . '"></i>';
                                }
                              ?>
                            </div>
                            <div>
                               <span><?php if($itms['avg_rating']!="") echo '('.$reviewscount[$key].')'; else echo "(0)";?></span>
                            </div>

                        </div>
  
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                      	   <a href="<?php echo SITE_URL.'listing/'.$itemid;?>">
                        <div class="buyPlus">
                          <div class="buY"><button class="btn buyCart" tabindex="0">
                              <div class="pluS"><i class="fa fa-plus" aria-hidden="true"></i></div>
                              <div><?php echo __d('user', 'Buy'); ?></div>
                            </button></div>
  
                        </div>
                    </a>
                      </div>
                    </div>
  
  
                  </div>
                </div>
			 
		<?php 
		echo '<input type="hidden" value="' . $categoryId . '" id="hiddencatvalue">
		<input type="hidden" value="' . $currentUrl . '" id="currentCatPath">';

		}  // E O foreach
 		
	//}?>
	<!-- Share Modal -->
	<div id="share-modal" class="modal fade" role="dialog">
		<div class="modal-dialog downloadapp-modal">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="share-container margin-bottom20">
						<div class="share-cnt-row">
							<h2 class="bold-font text-center">
								<?php echo __d('user', 'SHARE THIS THING'); ?></h2>
								<div class="popup-heading-border"></div>
							</div>
							<div class="share-cnt-row">
								<div class="share-details-cnt margin-top30">

									<?php
									echo '<div class="share-details">
									<div class="share-img margin-right20"><img id="share_img" class="img-responsive" src=""></div>
									<div class="share-details-txt">
									<div class="bold-font" id="share_title"></div>
									<div class="">' . __d('user', 'By') . ' <span id="share_username"></span></div>
									<div class="bold-font margin-top20" id="share_price"></div>
									</div>
									</div>';
									?>

								</div>
							</div>
							<div class="share-cnt-row">
								<div class="share-details-cnt margin-top30 share-icons-cnt padding-top20 padding-bottom20">
									<div class="share-details margin-top10 margin-bottom10">
										<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-facebook-official facebook" target="_blank"></a>
										<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-twitter-square twitter" target="_blank"></a>
										<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa  fa-google-plus-square google" target="_blank"></a>
										<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-linkedin-square linkedin" target="_blank"></a>
										<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');" class="share-icons fa fa-stumbleupon stumbleupon" target="_blank"></a>
										<a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-tumblr-square tumblr" target="_blank"></a>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</div>
<?php
	} else {
		echo "false";die;
	}
?>

<script type="text/javascript">
	
	var BaseURL = getBaseURL();
var togSrc1 = [ BaseURL+"./img/like.png", BaseURL+"./img/Heart filled@2x.png" ];
var togSrc3 = [ BaseURL+"./img/like.png", BaseURL+"./img/Heart after like@2x.png" ];
// $(".likeIcon img").hover(function() {
// this.src =  togSrc1.reverse()[0];
// });
var togSrc4 = [ BaseURL+"./img/Heart after like@2x.png", BaseURL+"./img/Heart filled@2x.png" ];
// $('.like-icon').hover(function() { 
//     var id = $(this).attr('alt');
//     if(id=='unliked'){
//      this.src =  togSrc1.reverse()[0];
//    }
//    // else if(id=='liked'){
//    //   this.src =  togSrc4.reverse()[0];
//    // }
   
// });
// $(".likeIcon img").click(function() {
//   this.src =  togSrc3.reverse()[0];
// });
</script>