<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<style type="text/css">
.cursoronhand
{
	cursor:pointer;
}
</style>
<?php

			/* DEFAULT SHIPPING ADDRESS */
			$soldout = 0;
			$allproductship = 0;
			if ($usershippingdefault == 0)  {
				$usershippingdefault = $usershipping[0]['shippingid'];
			}
			if ($shipping_method_id == '') {
				$shipping_method_id = $usershipping[0]['countrycode'];
			}
			?>
			<div class="flexBox">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 mobile_second">
			<div class="white_bg margin-bottom10 table_responsive">
				<div class="white_bg scroll_cart">
						  <div class="hide_mobile_cart row hor-padding">
							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 no-hor-padding">
							<h2 class="table_bg"><?php echo __d('user','Item Details'); ?></h2>
							</div>
							<div class="no_border col-xs-12 col-sm-2 col-md-2 col-lg-2 no-hor-padding">
								<h2 class="text-center table_bg"><?php echo __d('user','Quantity');?></h2>
								</div>
								<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-hor-padding">
								<h2 class="table_bg text-center"><?php echo __d('user','Delivery');?></h2>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 no-hor-padding">
								<h2 class="table_bg text-center"><?php echo __d('user','Subtotal');?></h2>
								</div>
								</div>

							<div class="no_border">
							<?php
							/** OPEN CART SECTION **/
							$cod = 0;
							$pickkup = 0;
							$productId = array();
							$totalAmountPayable=0;
							$noshipping=0;
							$newvariants=0;
							$totalShippingPayable=0;
							$item_price = 0;
							$productshipp=0;
							foreach($opencart as $setcart)
							{

								$productship=0; // product can be shipped or not
								$imageurl=$baseurl.'listing/'.base64_encode($setcart['itemid']."_".rand(1,9999));
								$itemimageurl=$baseurl.'media/items/original/usrimg.jpg';
								$checkimageurl=WWW_ROOT.'media/items/thumb350/'.$setcart['image'];
								/** CHECK FILE EXISTS OR NOT **/
								if (file_exists($checkimageurl)) {
									$itemimageurl=SITE_URL.'media/items/thumb350/'.$setcart['image'];
								}
								//BRAINTREE PAYMENT
								$braintree_itemids[]=$setcart['itemid'];
								if($setcart['cod'] == 'yes') {
									$cod++;
								}
								unset($shpngs);
								$pricefree = $setcart['pricefree'];
								$postalfree = $setcart['postalfree'];
								$freeamt = $setcart['freeamt'];
								/* Free amount by seller conversion*/
								$freeamt =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['currency_value'],$freeamt);
								$postcodes = $setcart['postalcodes'];
								$seller_order_amt=$selleramount[$setcart['sellerid']];
								/* MULTIPLE CURRENCIES */
								/*if($itmscurrency>1)
								$unitprice[$setcart['itemid']] = round($setcart['price']*$setcart['foxexprice'],2);
								else
								$unitprice[$setcart['itemid']] = $setcart['price'];*/

								/** MULTIPLE CATEGORIES */
								$categoryids[$setcart['itemid']] = $setcart['category_id'];

								/* MULTIPLE QUANTITTIES */
							 	$item_total = $setcart['price'] * $setcart['qty'];
							 	$totalprice=0;
							 	$shipping=0;
							 	//$totalprice +=$item_total;
							 	//echo $item_total;
							 	/* CART ITEM DETAILS */
								$item_id[] = $setcart['itemid'];
								$itemuserid[] = $setcart['sellerid'];
								$itemuserids[$setcart['itemid']] = $setcart['sellerid'];
								$itemshopid[] = $setcart['shopid'];

							 	/* SHIPPINGS AMOUNT */
							 	foreach($setcart['shippingavailability'] as $shpng){
									if($pricefree=="yes" || $postalfree=="yes")
							 			{
							 				if($pricefree=="yes" && $seller_order_amt>=$freeamt)
							 				{
							 					if($seller_order_amt>=$freeamt)
							 					{
							 						$shpngs[$shpng->country_id] = '0';
							 					}
							 					else
							 					{
							 						if($itmscurrency>1)
							 							$shpngs[$shpng->country_id] = $shpng->primary_cost;
							 							else if($itmscurrency==1)
							 								$shpngs[$shpng->country_id] = $shpng->primary_cost;
							 					}
							 				}
							 				else if($postalfree=="yes" && in_array($userpostcode,$postcodes))
							 				{
							 					if(in_array($userpostcode,$postcodes))
							 						$shpngs[$shpng->country_id] = '0';
							 						else
							 						{
							 							if($itmscurrency>1)
							 								$shpngs[$shpng->country_id] = $shpng->primary_cost;
							 								else if($itmscurrency==1)
							 									$shpngs[$shpng->country_id] = $shpng->primary_cost;
							 						}
							 				}
							 				else
							 				{
							 					if($itmscurrency>1)
							 						$shpngs[$shpng->country_id] = $shpng->primary_cost;
							 						else if($itmscurrency==1)
							 							$shpngs[$shpng->country_id] = $shpng->primary_cost;
							 				}
							 			}
							 			else
							 			{
							 				if($itmscurrency>1)
							 					$shpngs[$shpng->country_id] = $shpng->primary_cost;
						 					else if($itmscurrency==1)
						 						$shpngs[$shpng->country_id] = $shpng->primary_cost;
							 			}
						 			}
						 			//echo "<pre>"; print_r($shpngs);
						 			$itemId=$setcart['itemid'];
						 			if(!in_array($setcart['itemid'], $productId)) {
							 		if (isset($shpngs[$shipping_method_id])) {

											if($pricefree=="yes" && $shopamount[$setcart['shopid']] >= $freeamt) {
								 				$totalprice = $totalprice + $item_total;
								 				$shipping = $shipping;
								 				$shipping_amount[$itemId]=0;
								 			} else if($postalfree=="yes" && in_array($userpostcode,$postcodes)) {
								 				$totalprice = $totalprice + $item_total;
								 				$shipping = $shipping;
								 				$shipping_amount[$itemId] =0;
								 			} else {
								 				$shipping = $shipping + $shpngs[$shipping_method_id];
								 				$shipping_amt[] = $shpngs[$shipping_method_id];
								 				/** CONVERT CURRENCY STARTS **/
												if(isset($_SESSION['currency_code']))
												{
													$shipping_amtt =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['currency_value'],$shpngs[$shipping_method_id]);
												}
												else
												{
													if($itmscurrency>1){
														$shipping_amtt =  $currencycomponent->conversion($setcart['foxexprice']
															,$_SESSION['default_currency_value'],
														$shpngs[$shipping_method_id]);
													}else{
														$shipping_amtt=$shpngs[$shipping_method_id];
													}
												}
												/** CONVERT CURRENCY ENDS **/
								 				$shipping_amount[$itemId] = round($shipping_amtt,2);
								 				$totalprice = $totalprice + $item_total + $shpngs[$shipping_method_id];
								 			}
									}else if(isset($shpngs[0])){
										if($pricefree=="yes" && $shopamount[$setcart['shopid']] >= $freeamt) {
											$shipping = $shipping;
											$totalprice = $totalprice + $item_total;
											$shipping_amount[$itemId] =0;
										} else if($postalfree=="yes" && in_array($userpostcode,$postcodes)) {
											$shipping = $shipping;
											$totalprice = $totalprice + $item_total;
											$shipping_amount[$itemId] =0;
										} else {
											$shipping = $shipping + $shpngs[0];
											$shipping_amt[] = $shpngs[0];
											/** CONVERT CURRENCY STARTS **/
											if(isset($_SESSION['currency_code']))
											{
												$shipping_amtt =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['currency_value'],$shpngs[0]);
											}
											else
											{
												if($itmscurrency>1){
													$shipping_amtt =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['default_currency_value'],
													$shpngs[0]);
												}else{
													$shipping_amtt=$shpngs[0];
												}
											}
											/** CONVERT CURRENCY ENDS **/
											$shipping_amount[$itemId] = round($shipping_amtt,2);
											$totalprice = $totalprice + $item_total + $shpngs[0];

										}
									}else {
							 			$allproductship++;
							 			$productship++;
							 			$productshipp++;
							 			$totalprice = $totalprice + $item_total;

							 		}
						 		} else {
						 			$totalprice = $totalprice + $item_total;
						 		}
						 		//$totalShippingPayable+=$shipping;
						 		 //echo $shipping;
								?>
							  <div class="row hor-padding">
								<div class="no_border padding_table margin-top10 col-xs-12 col-sm-5 col-md-5 col-lg-5">

								<div class="cart_dis_table">
									<div class="cart_dis_cell">
										<a target="_blank" href="<?php echo $imageurl;?>">
										<div class="cart_image" style="background-image:url('<?php echo $itemimageurl; ?>');background-repeat: no-repeat;" ></div></a>
									</div>
									<div class="cart_dis_cell">
										<h4 class="margin-left20 margin-right20 extra_text_tablecell text_right_rtl margin-top0"><?php echo $setcart['name'];?></h4>

										<div class="price margin-left20 margin-right20 margin-bottom5">
											<span class="hide_mobile_cart"><?php echo __d('user','Price'); echo':'; ?></span>
											<span class="<?php echo 'cart_price'.$setcart['cartid'];?>">
											<!--CONVERT CURRENCY STARTS-->
											<?php
											if(isset($_SESSION['currency_code']))
											{
											$convertcurrency =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['currency_value'],
												$setcart['price']);?>&#x200E;<?php
											echo $_SESSION['currency_symbol'].' '.$convertcurrency;
											$unitprice[$setcart['itemid']]=$convertcurrency;
											?>
											<?php }
											else
											{?>
												<?php
												if($itmscurrency>1)
												{
													$convertcurrency =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['default_currency_value'],
													$setcart['price']);?>&#x200E;<?php
													echo $_SESSION['default_currency_symbol'].' ';
													echo round($convertcurrency,2);
													$unitprice[$setcart['itemid']]=$convertcurrency;
												}

												else
												{
													$convertcurrency = $setcart['price'];?>&#x200E;
													<?php
													echo $setcart['currencysymbol'].' ';
													echo round($setcart['price'],2);
													$unitprice[$setcart['itemid']]=$setcart['price'];
												}
												?>
											<?php
											}
											$braintree_itemprices[$setcart['itemid']]=round($convertcurrency,2);
											?>
											<!--CONVERT CURRENCY ENDS-->
											<!-- DAILY DEALS CONVERT CURRENCY STARTS-->
											<?php
											if(isset($_SESSION['currency_code']))
											{
											$dealconvertcurrency =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['currency_value'],
												$setcart['priceas']);
											$dailydealscurrency=$_SESSION['currency_symbol'];
											$dailydealsprice=$dealconvertcurrency;
											?>
											<?php }
											else
											{
												?>
												<?php
												if($itmscurrency>1)
												{
													$dealconvertcurrency =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['default_currency_value'],
													$setcart['priceas']);
													$dailydealscurrency=$_SESSION['default_currency_symbol'];
													$dailydealsprice=$dealconvertcurrency;

												}

												else
												{
													$dailydealscurrency=$setcart['currencysymbol'];
													$dailydealsprice=round($setcart['priceas'],2);
												}
												?>
											<?php
											}
											?>

											<!--DAILY DEALS CONVERT CURRENCY ENDS-->
											</span>
											<input type="hidden" class="<?php echo 'unitprice'.$setcart['cartid'];?>" value="<?php echo $convertcurrency; ?>" />
											<?php if($setcart['dailydeals']=='YES'){ ?>
											<strike><?php echo $dailydealscurrency.$dailydealsprice;?></strike>
											<span class="off-txt"><?php echo $setcart['discount'].'%';?></span>
											<?php } ?>
										</div>
										<h6 class="text-left font_size13 margin-top5 margin-bottom5 margin-left20 margin-right20 text_right_rtl"><?php echo __d('user','Size'); echo':'; ?> <span dir="rtl"><?php if($setcart['size']!=""){ echo $setcart['size'];} else {echo __d('user','N/A');} ?></span></h6>
										<div class=" margin-left20 text-left text_right_rtl"><?php echo __d('user','Seller'); echo ':';?>
										<a href="<?php echo $baseurl.'stores/'.$setcart['shop_name'];?>" class="primary-color-txt cart_seller_border padding-right10 cursoronhand">
										&nbsp;<?php echo $setcart['sellername'];?></a>
										<a class="red-txt hide_mobile_cart cursoronhand" onclick="removecart('<?php echo $setcart['cartid']; ?>','<?php echo $userid;?>','<?php echo $setcart['shopid'];?>','<?php echo $setcart['sellerid']; ?>')"><?php echo __d('user','Remove');?></a></div>
										<h6 class="text_right_rtl margin-top5 margin-bottom8 margin-left20 margin-right20 hide_normal padding_left0_cart"><?php echo __d('user','Delivery');echo ':';?><span class="green-txt" dir="rtl">
										<?php

										if(isset($_SESSION['currency_code']))
											{
												$shipping =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['currency_value'],$shipping);?>&#x200E;<?php
												echo $_SESSION['currency_symbol'].' '.$shipping;
											}
											else
											{	
												if($itmscurrency>1){
													$shipping =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['default_currency_value'],
													$shipping);?>&#x200E;<?php
													echo $_SESSION['default_currency_symbol'].' ';
													echo $shipping;
												}else{ ?>&#x200E;<?php
													echo $setcart['currencysymbol'].' ';
													echo $shipping;
												}
											}
											?>
										&nbsp;</span></h6>
										<h6 class="text_right_rtl margin-top5 margin-bottom5 margin-left20 margin-right20 hide_normal padding_left0_cart">&nbsp;</h6>
									</div>
								</div>
								</div>
							<div class="no_border col-xs-5 col-sm-2 col-md-2 col-lg-2 margin-top10 margin_top0_cart_mobile product_cnt">
								<?php if($setcart['maxqty']=='0') {
											$soldout++;
											?>
											<div class="text-center">
											<span class="red-txt"><?php echo __d('user','Sold-Out');?></span>
											</div>
											<?php } else{ ?>
											<div class="qty-counter-cnt margin_left6_qtyMobile col-xs-4 col-sm-4 no-hor-padding qty_mobile">
											<a onclick="selectChange('<?php echo $setcart['cartid']; ?>','<?php echo $userid;?>','<?php echo $setcart['shopid'];?>','<?php echo $setcart['sellerid']; ?>','<?php echo $seltsize0; ?>','<?php echo $setcart['maxqty'];?>','<?php echo 'sub';?>')" class="qty-counter-ctrl bold-font float_none_mbl cursoronhand">-</a>
											<div class="qty-counter-label qty_border float_none_mbl">
											<span class="<?php echo 'qnty'.$setcart['cartid'];?>"><?php echo $setcart['qty'];?></span>
											</div>
											<a onclick="selectChange('<?php echo $setcart['cartid']; ?>','<?php echo $userid;?>','<?php echo $setcart['shopid'];?>','<?php echo $setcart['sellerid']; ?>','<?php echo $seltsize0; ?>','<?php echo $setcart['maxqty'];?>','<?php echo 'add';?>')" class="qty-counter-ctrl bold-font float_none_mbl cursoronhand">+</a>
											</div>
										<?php }?>

								</div>
								<div class="no_border col-xs-7 padding_left0_cart text_left_mobile col-sm-2 col-md-2 col-lg-2 margin-top10 text-center margin_top0_cart_mobile">
								<span class="deliver_txt_center hide_mobile_cart">
								<?php
				 						$process_time=$setcart['processtime'];
				 						if (isset($shpngs[$shipping_method_id]) || isset($shpngs[0])) {
					 						if($process_time == '1d'){
					 							echo __d('user','One business day');
					 						}elseif($process_time == '2d'){
					 							echo __d('user','Two business days');
					 						}elseif($process_time == '3d'){
					 							echo __d('user','Three business days');
					 						}elseif($process_time == '4d'){
					 							echo __d('user','Four business days');
					 						}elseif($process_time == '2ww'){
					 							echo __d('user','One-Two weeks');
					 						}elseif($process_time == '3w'){
					 							echo __d('user','Two-Three weeks');
					 						}elseif($process_time == '4w'){
					 							echo __d('user','Three-Four weeks');
					 						}elseif($process_time == '6w'){
					 							echo __d('user','Four-Six weeks');
					 						}elseif($process_time == '8w'){
					 							echo __d('user','Six-Eight weeks');
					 						}
				 						}else if($pickkup == $itm_counts) {
						 						echo __d('user','N/A');
						 				}else {
									 	echo "<div style='color:red;line-height: 1;'>";echo __d('user','Cannot Ship this Product to your Location');echo "</div> <input type='hidden' value='0' id='cantship' />";
									 	}
									 ?></span>
									 </div>
									 <?php
										$totalPrice =$convertcurrency*$setcart['qty'];
										$commiItemPrice = $totalPrice;
										/* Convert Comission */
										if(isset($_SESSION['currency_code']))
										{
											$commiItemPrice =  $currencycomponent->conversion($setcart['foxexprice'],$_SESSION['currency_value'],
												$commiItemPrice);
										}
										$amount=0;
										foreach($commissionDetails as $commission){
											$min_val = $commission['min_value'];
											$max_val =  $commission['max_value'];
											if(isset($_SESSION['currency_code']))
											{
												$min_val =  $currencycomponent->conversion($_SESSION['default_currency_value'],$_SESSION['currency_value'],
												$min_val);
											}

											if(isset($_SESSION['currency_code']))
											{
												$max_val =  $currencycomponent->conversion($_SESSION['default_currency_value'],$_SESSION['currency_value'],
												$max_val);
											}
											$active =  $commission['active'];
											if($commiItemPrice>=$min_val && $commiItemPrice<=$max_val){
												if($active=="1"){
													$amount = (floatval($commiItemPrice)/100)*$commission['amount'];
													$commiItemTotalPrice +=round($amount,2);
												}
											}
										}
										
										if($commissionCount==0)
										{
											$amount = (floatval($commiItemPrice)/100)*$sitesettings->credit_percentage;
											$commiItemTotalPrice +=round($amount,2);
										}
									?>
									<div class="no_border padding_left0_cart padding_right0_cart col-xs-7 col-sm-3 col-md-3 col-lg-3">
									<div class="">
									<h6 class="font_size13 text-right hide_mobile_cart"><?php echo __d('user','Price'); echo ':';?>
									<span class="<?php echo 'cart_price'.$setcart['cartid'];?>">
									<!--CONVERT CURRENCY STARTS-->
									<?php
											if(isset($_SESSION['currency_code']))
											{
												$item_total =$convertcurrency*$setcart['qty'];?>&#x200E;<?php
												echo $_SESSION['currency_symbol'].' '.round($item_total,2);
											}
											else
											{
												if($itmscurrency>1){
													$item_total =$convertcurrency*$setcart['qty'];?>&#x200E;<?php
													echo $_SESSION['default_currency_symbol'].' ';
													echo $item_total;
												}else{
													echo $setcart['currencysymbol'];
													echo round($item_total,2);
												}
											}
									/* AMOUNT CALCULATION FOR COUPON */
									$itemprices[$setcart['itemid']] += $item_total;
									?>
									<!--CONVERT CURRENCY ENDS-->
									</span>
									</h6>
									<h6 class="font_size13 text-right padding_left0_cart text_left_mobile margin_top0_cart_mobile hide_mobile_cart"><?php echo __d('user','Delivery'); echo':';?> <span class="green-txt">
									<!--CONVERT CURRENCY STARTS-->
									<?php
											if(isset($_SESSION['currency_code']))
											{
												?>&#x200E;<?php
												echo $_SESSION['currency_symbol'].' '.round($shipping,2);
											}
											else
											{
												if($itmscurrency>1){
													?>&#x200E;<?php
													echo $_SESSION['default_currency_symbol'].' ';
													echo round($shipping,2);
												}else{
													?>&#x200E;<?php
													echo $setcart['currencysymbol'].' ';
													echo round($shipping,2);
												}
											}
											$totalShippingPayable+=round($shipping,2);
									?>
									<!--CONVERT CURRENCY ENDS-->
									</span></h6>
									</div>
									<hr class="hr_price hide_mobile_cart">
									<h6 class="font_size13 bold-font text_left_mobile text-right margin_top0_cart_mobile hide_mobile_cart"><?php echo __d('user','Total'); echo ':';?> <span class="<?php echo 'cart_price'.$setcart['cartid'];?>">
									 <!--CONVERT CURRENCY STARTS-->
									<?php
											if(isset($_SESSION['currency_code']))
											{
												$totalprice = $item_total+$shipping;?>&#x200E;<?php
												echo $_SESSION['currency_symbol'].' '.$totalprice;
											}
											else
											{
												if($itmscurrency>1){
													$totalprice = $item_total+$shipping;?>&#x200E;<?php
													echo $_SESSION['default_currency_symbol'].' ';
													echo round($totalprice,2);
												}else{
													?>&#x200E;<?php
													echo $setcart['currencysymbol'].' ';
													echo round($totalprice,2);
												}
											}
									?>
									<!--CONVERT CURRENCY ENDS-->
									</span></h6>
								</div>
								<?php $item_price+=$item_total; ?>

							  </div>
							  <div class="row hor-padding"><div class="text-left padding_table col-xs-12 col-md-12 col-sm-12 col-lg-12 text_right_rtl vertical_align_top margin-bottom20 padding-top10"><span class="<?php echo 'red-txt errcls quantity_error'.$setcart['cartid'];?>"><?php echo __d('user','No more quantity available for this product');?></span>
							  <?php if($setcart['newvariants']=='1') { $newvariants++; ?>
							   <span class="red-txt"><?php echo __d('user',"This product variants are unavailable now. kindly remove the item to checkout");?></span>
							  <?php }?>
							  <?php
							  if($productship=='1') {
							  	?>
							   <span class="red-txt"><?php echo __d('user','Shipping is not available for this product');?></span>
							  <?php }?>
							</div></div>
							  <div class="text-left padding_table hide_normal border_top_grey border_bottom_remove margin-bottom20 col-xs-12 col-md-12 col-sm-12 col-lg-12 text_right_rtl vertical_align_top margin-bottom10 padding-top5 padding-bottom5"><h6 class="text-center font_size13"><a href="" onclick="removecart('<?php echo $setcart['cartid']; ?>','<?php echo $userid;?>','<?php echo $setcart['shopid'];?>','<?php echo $setcart['sellerid']; ?>')" class="red-txt cursoronhand"><?php echo __('Remove');?></a></h6></div>

							<?php  $productId[] = $setcart['itemid'];

								
							} ?>
								</div>
								<?php
								$item_id = json_encode($item_id);
								$item_id = str_replace("\""," ",$item_id);
								$itemuserid = json_encode(array_unique($itemuserid));
								$itemuserid = str_replace("\""," ",$itemuserid);
								$itemshopid = json_encode(array_unique($itemshopid));
								$itemshopid = str_replace("\""," ",$itemshopid);
								$iteprice =0;
								if(isset($getcouponvalue)){
									$discount = $getcouponvalue['couponpercentage'];
									$sourceid = $getcouponvalue['sourceid'];
									$sellerid = $getcouponvalue['sellerid'];
									if($getcouponvalue['type'] == 'item' || $getcouponvalue['type'] == 'facebook'){
										$iteprice = $itemprices[$sourceid];
										$calDiscount = round($iteprice * ($discount / 100),2);
										if (isset($shpngs[$shipping_method_id])) {
											$coupondiscount = $calDiscount;
										}else if(isset($shpngs[0])){
											$coupondiscount = $calDiscount;
										}else {
										$coupondiscount = 0;
										$disable = "disabled";
									}
									}
									else if($getcouponvalue['type'] == 'category'){
									foreach($categoryids as $key => $categ)
									{
										if($sellerid==$itemuserids[$key])
										{
											if($sourceid==$categ)
											{
												$iteprice += $itemprices[$key];
											}
										}
									}
									$calDiscount = round($iteprice * ($discount / 100),2);
									if (isset($shpngs[$shipping_method_id])) {
										$coupondiscount = $calDiscount;
									}else if(isset($shpngs[0])){
										$coupondiscount = $calDiscount;
									}else {
										$coupondiscount = 0;
										$disable = "disabled";
									}
									}
								else if($getcouponvalue['type']=='cart')
								{
									foreach($categoryids as $key => $categ)
									{
										if($sellerid==$itemuserids[$key])
										{
											$iteprice += $itemprices[$key];
										}
									}

									$calDiscount = round($iteprice * ($discount / 100),2);
									if (isset($shpngs[$shipping_method_id])) {
										$coupondiscount = $calDiscount;
									}else if(isset($shpngs[0])){
										$coupondiscount = $calDiscount;
									}else {
										$coupondiscount = 0;
										$disable = "disabled";
									}
								}
							}
							?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 border_top_grey hide_mobile_cart margin-top20">
								<div>
								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								</div>

								<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
								</div>

								<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
								</div>
								<div class="text-right col-xs-12 col-sm-4 col-md-4 col-lg-4 no-hor-padding" id="total_section">
										<div class="">
										<h6 class="font_size13"><?php echo __d('user','Item Total'); echo ':';?>
										<span class="subtotal"><div style="direction:LTR"><?php echo $item_price;?>
										<!--CONVERT CURRENCY STARTS-->
										<?php
												if(isset($_SESSION['currency_code']))
												{
													echo $_SESSION['currency_code'];
												}
												else
												{
													if($itmscurrency >1)
													echo $_SESSION['default_currency_code'];
													else
													echo round($itms_currency[0],2);
												}
										?></div>
										<!--CONVERT CURRENCY ENDS-->
										</span></h6>
										<h6 class="font_size13"><?php echo __d('user','Shipping Total'); echo ':';?> <span
										class="subtotal"><div style="direction:LTR"><?php echo $totalShippingPayable;?>
										<!--CONVERT CURRENCY STARTS-->
										<?php

												if(isset($_SESSION['currency_code']))
												{
													echo $_SESSION['currency_code'];
												}
												else
												{
													if($itmscurrency >1)
													echo $_SESSION['default_currency_code'];
													else
													echo round($itms_currency[0],2);
												}
										?></div>
										<!--CONVERT CURRENCY ENDS-->
										</span></h6>
										<?php
										if(!empty($tax_datas))
										{
										?>
										<?php
										$total_perc = 0 ;
										$total_tax_value = 0;
										foreach($tax_datas as $taxes)
										{
											$indv_perc = ($item_price * $taxes['percentage']) / 100;
										?>

										<h6 class="font_size13"><?php echo ucfirst($taxes['taxname']).' ('.$taxes['percentage'].'%) :';?>
										<span class="subtotal"><div style="direction:LTR"><?php echo round($indv_perc,2);?>
										<!--CONVERT CURRENCY STARTS-->
										<?php
												if(isset($_SESSION['currency_code']))
												{
													echo $_SESSION['currency_code'];
												}
												else
												{
													if($itmscurrency >1)
													echo $_SESSION['default_currency_code'];
													else
													echo round($itms_currency[0],2);
												}
										?></div>
										<!--CONVERT CURRENCY ENDS-->
										</span></h6>
										<?php $total_perc += $taxes['percentage'];
				   							$total_tax_value +=round($indv_perc,2); ?>
										<?php }
										$tax_perc = ($item_price * $total_perc) / 100;
										$total_price = $total_price + round($tax_perc,2);
										echo '<input type="hidden" value="'.$total_tax_value.'" id="tax_tot_val">';

										} ?>
										<?php $totalAmountPayable=round(($item_price+$totalShippingPayable+$total_tax_value),2);?>
										<?php if($setcoupon>0){?>
										<h6 class="font_size13"><?php echo __d('user','Discount'); echo ':';?> 
										<span class="discountotal red-txt">
										<div style="direction:LTR"><?php echo '-'; ?><?php echo $coupondiscount;?>
										<!--CONVERT CURRENCY STARTS-->
										<?php
												if(isset($_SESSION['currency_code']))
												{
													echo $_SESSION['currency_code'];
												}
												else
												{
													if($itmscurrency >1)
													echo $_SESSION['default_currency_code'];
													else
													echo round($itms_currency[0],2);
												}
										?></div>
										<!--CONVERT CURRENCY ENDS-->
											</span></h6><?php
										}else{
											$coupondiscount=0;
										}
										?>
										<?php if($getgiftcardValue!=""){
										$giftcardamount=$getgiftcardValue['avail_amount'];?>
										<!--CONVERT CURRENCY STARTS-->
										<?php
											if(isset($_SESSION['currency_code']))
											{
												$giftcardamount =  $currencycomponent->conversion($giftcardrate,$_SESSION['currency_value'],$giftcardamount);
											}
											else
											{
												if($itmscurrency>1){
													$giftcardamount =  $currencycomponent->conversion($giftcardrate,$_SESSION['default_currency_value'],$giftcardamount);
												}else{

													$giftcardamount =  $currencycomponent->conversion($giftcardrate,$itms_rate[0],$giftcardamount);
												}
											}

												if ($totalAmountPayable > $giftcardamount) {
												$giftamou = $giftcardamount;
											}
											else
											{
												$giftamou = $totalAmountPayable;
											}
										?>
										<!--CONVERT CURRENCY ENDS-->
										<h6 class="font_size13"><?php echo __d('user','Gift Card'); echo ':';?> 
										<span class="red-txt discountotal">
										<div style="direction:LTR"><?php echo '-'; ?>  <?php echo $giftamou;?>
										<!--CONVERT CURRENCY STARTS-->
										<?php
												if(isset($_SESSION['currency_code']))
												{
													echo $_SESSION['currency_code'];
												}
												else
												{
													if($itmscurrency >1)
													echo $_SESSION['default_currency_code'];
													else
													echo round($itms_currency[0],2);
												}
										?></div>
										<!--CONVERT CURRENCY ENDS-->
											</span></h6><?php
										}else{
											$giftcardamount=0;
										}
										?>
										<?php if($setcreditamount >0 && $setcoupon=='0' && $setgiftcard=='0'){ ?>
										<h6 class="font_size13"><?php echo __d('user','Credits'); echo':';  ?>
										<span class="red-txt creditstotal">
										<div style="direction:LTR"><?php echo '-';?><?php echo $creditamt;?>
										<!--CONVERT CURRENCY STARTS-->
										<?php
												if(isset($_SESSION['currency_code']))
												{
													echo $_SESSION['currency_code'];
												}
												else
												{
													if($itmscurrency >1)
													echo $_SESSION['default_currency_code'];
													else
													echo round($itms_currency[0],2);
												}
										?></div></span>
										<!--CONVERT CURRENCY ENDS-->
										</h6>
										<input type="hidden" id="availablee_creditsamt" value="<?php echo $creditamt;?>"/>
										<?php }else{
											$creditamt=''; ?>
											<input type="hidden" id="availablee_creditsamt" value=""/>
										<?php }?>
										</div>
										<hr class="hr_total">
									<h6 class="font_size13 bold-font clear"><?php echo __d('user','Total'); echo':';?>
									<span class="grandtotal"><div style="direction:LTR"><?php
									$totalamounttopay=round($totalAmountPayable-$coupondiscount-$giftcardamount-$creditamt,2);
									if($totalamounttopay <0 || $totalamounttopay=='0'){
										$totalamounttopay=0;
										echo '0';
									}else{ 
										echo round($totalamounttopay,2);
									}
									?>
									<!--CONVERT CURRENCY STARTS-->
										<?php
												if(isset($_SESSION['currency_code']))
												{
													echo $_SESSION['currency_code'];
												}
												else
												{
													if($itmscurrency >1)
													echo $_SESSION['default_currency_code'];
													else
													echo round($itms_currency[0],2);
												}
										?></div>
										<!--CONVERT CURRENCY ENDS-->
									</span></h6>
								</div>
								</div>
							</div>
							<!-- BRAINTREE PAYMENT STARTS-->
							<?php
							$paybraintree_itemids=json_encode($braintree_itemids);
							?>
							<form action="<?php echo SITE_URL.'braintree/checkouttoken/'?>" method="post"  id="paymentbraintreeform" name="paymentbraintreeform">
							<?php $totalAmountPay = $totalamounttopay*100;?>
								<input type="hidden" name="itemids" id="itemids" value="<?php echo $paybraintree_itemids;?>"/>
								<input type="hidden" name="itmunitPrice" id="itmunitprice" value='<?php echo serialize($braintree_itemprices); ?>'/>
								<input type="hidden" value="<?php echo $totalAmountPay; ?>" id="totalpriceb" name="totalPrice">
								<input type="hidden" value="<?php echo $totalAmountPayable*100; ?>" id="totalamount" name="totalamount">
								<?php
								if(isset($getcouponvalue)){
								echo '<input type="hidden" id="couponIdb" name="couponId" value="'.$getcouponvalue['id'].'" />';
								}else{
								echo '<input type="hidden" id="couponIdb" name="couponId" value="" />';
								}
								?>
								<?php
								if(isset($getgiftcardValue)){
								echo '<input type="hidden" name="giftcardId" id="giftcardIdb" value="'.$getgiftcardValue['id'].'" />';
								echo '<input type="hidden" name="giftcardAmount" id="giftcardAmount" value="'.$giftcardamount.'" />';
								}else{
								echo '<input type="hidden" name="giftcardId" id="giftcardIdb" value="" />';
								echo '<input type="hidden" name="giftcardAmount" id="giftcardAmount" value="'.$giftcardamount.'" />';
								}
								?>
								<input type="hidden" name="currentTime" value="<?php echo time(); ?>" id="currentTime" />
								<?php if(isset($creditamt)){ ?>
									<input type="hidden" name="userEnterCreditAmt" value="<?php echo $creditamt;?>" id="userEnterCreditAmt" />
							    <?php
								}
								else{?>
									<input type="hidden" name="userEnterCreditAmt" value="" id="userEnterCreditAmt" />
								<?php } ?>
								<?php
								if(isset($_SESSION['currency_code']))
								{
									?>
									<input type="hidden" name="currency" id="currencode" value="<?php echo $_SESSION['currency_code']; ?>"/>
								<?php

								}
								else{

								if($itmscurrency>1)
									{
									?>
									<input type="hidden" name="currency" id="currencode" value="<?php echo $_SESSION['default_currency_code']; ?>"/>
									<?php
									}
									else
									{
									?>
									<input type="hidden" name="currency" id="currencode" value="<?php echo $itms_currency[0]; ?>"/>
									<?php
									}
								}?>
								<input type="hidden" name="shipamnt" id="shipamntb" value='<?php echo serialize($shipping_amount); ?>'/>
							 	<input type="hidden" name="shippingId" value="" id="stripe_shipIdb" />
							 	<input type="hidden" name="taxamt" id="taxamtb" value="<?php echo $total_tax_value; ?>"/>
							</form>
							<!-- BRAINTREE PAYMENT ENDS -->
						  </div>
						  </div>
				
				<!--MOBILE RESPONSIVE CART DETAILS STARTS-->
				<div class="ship_cart_address hide_normal margin-bottom15 padding-top10 padding-bottom10">
					<h6 class="font_size13 border_bottom_grey padding-bottom10 margin-top0"><?php echo __d('user','Price Details');?></h6>
					<div class="row">
						<div class="col-xs-6 col-xm-6"><h6 class="font_size13"><?php echo __d('user','Price').'('.$total_itms.__d('user','items').')';?></h6></div>
						<div class="col-xs-6 col-xm-6 text-right">
						<h6 class="font_size13">
						<span class="subtotal"><?php echo $item_price;?>
						<!--CONVERT CURRENCY STARTS-->
						<?php

								if(isset($_SESSION['currency_code']))
								{
									echo $_SESSION['currency_code'];
								}
								else
								{
									if($itmscurrency >1)
									echo $_SESSION['default_currency_code'];
									else
									echo round($itms_currency[0],2);
								}
						?>
						<!--CONVERT CURRENCY ENDS-->
						</span></h6>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-xm-6"><h6 class="font_size13"><?php echo __('Shipping Total'); echo ':';?></h6></div>
						<div class="col-xs-6 col-xm-6 text-right">
						<h6 class="font_size13">
						<span
						class="subtotal"><?php echo round($totalShippingPayable,2);?>
						<!--CONVERT CURRENCY STARTS-->
						<?php
								if(isset($_SESSION['currency_code']))
								{
									echo $_SESSION['currency_code'];
								}
								else
								{
									if($itmscurrency >1)
									echo $_SESSION['default_currency_code'];
									else
									echo round($itms_currency[0],2);
								}
						?>
						<!--CONVERT CURRENCY ENDS-->

						</span></h6>
						</div>
					</div>
					<?php if(!empty($tax_datas)) {  ?>
					<div class="row">
						<div class="col-xs-6 col-xm-6"><h6 class="font_size13"><?php echo ucfirst($taxes['taxname']).' ('.$taxes['percentage'].'%) : ';?></h6></div>
						<div class="col-xs-6 col-xm-6 text-right">
						<h6 class="font_size13">
							<span class="subtotal"><?php echo round($indv_perc,2);?></span>
							<!--CONVERT CURRENCY STARTS-->
							<?php
									if(isset($_SESSION['currency_code']))
									{
										echo $_SESSION['currency_code'];
									}
									else
									{
										if($itmscurrency >1)
										echo $_SESSION['default_currency_code'];
										else
										echo round($itms_currency[0],2);
									}
							?>
							<!--CONVERT CURRENCY ENDS-->
							</h6>

						</div>
					</div>
					<?php }?>

					<?php if($setcreditamount >0 && $setcoupon=='0' && $setgiftcard=='0'){ ?>
					<div class="row">
					<div class="col-xs-6 col-xm-6"><h6 class="font_size13"><?php echo __d('user','Credits'); echo ':';?></h6></div>
					<div class="col-xs-6 col-xm-6 text-right"><h6 class="font_size13 red-txt"><?php echo '-'; echo $creditamt;?>
					<?php
						if(isset($_SESSION['currency_code']))
						{
						echo $_SESSION['currency_code'];
						}
						else
						{
						if($itmscurrency >1)
						echo $_SESSION['default_currency_code'];
						else
						echo round($itms_currency[0],2);
						}
						?>
					</h6>
					</div>
					</div>
					<?php }?>
					<?php if($getgiftcardValue!=""){?>
					<div class="row">
					<div class="col-xs-6 col-xm-6"><h6 class="font_size13"><?php echo __d('user','Gift Card'); echo ':';?></h6></div>
					<div class="col-xs-6 col-xm-6 text-right"><h6 class="font_size13 red-txt"><?php echo '-'; echo $giftcardamount;?>
					<?php
						if(isset($_SESSION['currency_code']))
						{
						echo $_SESSION['currency_code'];
						}
						else
						{
						if($itmscurrency >1)
						echo $_SESSION['default_currency_code'];
						else
						echo round($itms_currency[0],2);
						}
						?>		
					</h6></div>
					</div>
					<?php }?>
					<?php if($setcoupon>0){?>
					<div class="row">
					<div class="col-xs-6 col-xm-6"><h6 class="font_size13"><?php echo __d('user','Discount'); echo ':';?></h6></div>
					<div class="col-xs-6 col-xm-6 text-right"><h6 class="font_size13 red-txt"><?php echo '-'; echo $coupondiscount;?>
					<?php
						if(isset($_SESSION['currency_code']))
						{
						echo $_SESSION['currency_code'];
						}
						else
						{
						if($itmscurrency >1)
						echo $_SESSION['default_currency_code'];
						else
						echo round($itms_currency[0],2);
						}
						?>
					</h6></div>
					</div>
					<?php }?>

					<div class="row border_top_grey padding-top10">
						<div class="col-xs-6 col-xm-6"><h6 class="font_size13 bold-font"><?php echo __d('user','Amount Payable'); echo ':';?></h6></div>
						<div class="col-xs-6 col-xm-6 text-right">
						<h6 class="font_size13 bold-font clear"><span class="grandtotal">
						<?php echo $totalamounttopay;?>
						<!--CONVERT CURRENCY STARTS-->
						<?php
								if(isset($_SESSION['currency_code']))
								{
									echo $_SESSION['currency_code'];
								}
								else
								{
									if($itmscurrency >1)
									echo $_SESSION['default_currency_code'];
									else
									echo round($itms_currency[0],2);
								}
						?>
						<!--CONVERT CURRENCY ENDS-->
						</span></h6>
						</div>
					</div>
				</div>
				<!--MOBILE RESPONSIVE CART DETAILS ENDS-->
			<?php
			if($soldout==0 && $newvariants==0){?>
			<div id="parentHorizontalTab" class="white_bg">
            <ul class="resp-tabs-list hor_1 tab_cart_rtl nav nav-tabs">
            	<?php  $nocod=0; if($cod == $total_itms) {  $nocod=1; ?>
            	<?php } if($totalAmountPay >0) {
            	//$paypaltabactive='resp-tab-active';
            	//$paypalcontentactive='resp-tab-content-active';
            	?>
                <li class="horziontal_tab tab_li_rtl cart_tabs bold-font active"><a style="border:hidden!important;"data-toggle="tab" href="#braintree"><?php echo __d('user','Paypal Brain Tree');?></a></li>
                <?php }?>
                <li class="horziontal_tab tab_li_rtl cart_tabs bold-font"><a data-toggle="tab" href="#cod" style="border:hidden!important;"><?php echo __d('user','Cash on Delivery');?></a></li>
                <?php  if($totalAmountPay=='0' || $totalAmountPay<0) {?>
               <li class="horziontal_tab tab_li_rtl cart_tabs bold-font"><a data-toggle="tab" href="#placeorder" style="border:hidden!important;"><?php echo __d('user','Place order');?></a></li>
                <?php }?>


            </ul>
            <div class="resp-tabs-container hor_1 tab-content">
            	<?php if ($totalAmountPay>0){ ?>
                <div class="active_horizontal tab-pane fade in active padding-bottom10" id="braintree">
                   <div class="payment_dis_table margin-bottom15">
						<div class="payment_dis_cell">
							<div class="cod_image1 margin_top10_rtl">
							<div class="paypal_image"></div>
							</div>
						</div>
						<div class="payment_dis_cell">
						<h5 class="margin-left10 margin-bottom5 margin-right10 margin_top10_rtl line_height25"><?php echo __d('user','Paypal: 100% Payment Protection, Easy Return Policy');?></h5>
						<span class="margin-left10 margin-right10 margin_top10_rtl"><?php echo __d('user','By placing the order, I have read and agreed the'); ?>
						<?php echo $setngs['site_name'];?><?php echo __d('user',"'s");?> <a href="" class="primary-color-txt"><?php echo __d('user','Terms of Use');?></a></span>
						</div>
				   </div>
				   <?php ?>
				   <div class="view-all-btn btn primary-color-bg primary-color-bg paybybraintree" style="margin-left: 20px;margin-right:20px;margin-bottom: 20px;">
						<a><?php echo __d('user','Pay');?> </a>
					</div>
					<span id="shipnoterror" class="errcls red-txt" style="float:right;"><?php echo __d('user','Shipping not available. Please add any other shipping address');?></span>
					<?php  ?>
                </div>
                <?php }?>
                <div class="active_horizontal tab-pane fade padding-bottom10" id="cod">
                   <div class="payment_dis_table margin-bottom15">
						<div class="payment_dis_cell">
							<div class="cod_image1 margin_top10_rtl">
							<div class="cod_image"></div>
							</div>
						</div>
						<div class="payment_dis_cell">
						<?php if($nocod=='1' && $codavailability=='0' && $totalAmountPay>0) {?>
						<h5 class="margin-left10 margin-bottom5 margin-right10 margin_top10_rtl line_height25"><?php echo __d('user','Trust Pay: 100% Payment Protection, Easy Return Policy');?></h5>
						<span class="margin-left10 margin-right10 margin_top10_rtl"><?php echo __d('user','By placing the order, I have read and agreed the');
						echo $setngs['site_name'];?><?php echo __d('user',"'s");?> <a href="" class="primary-color-txt"><?php echo __d('user','Terms of Use');?></a></span>
						<?php
						}else { ?>
						<h5 class="margin-left10 margin-bottom5 margin-right10 margin_top10_rtl line_height25"><?php echo __d('user','Cash on Delivery is not available');?></h5>
						<?php }
						?>
						</div>
					 </div>
				   <?php if($nocod=='1' && $codavailability=='0' && $totalAmountPay>0) {?>
				   <div class="view-all-btn btn primary-color-bg primary-color-bg" style="margin-left: 20px;margin-right:20px;margin-bottom: 20px;">
						<a data-toggle="modal" id="codtoggle" onclick="return checkship()"><?php echo __d('user','Cash on Delivery');?> </a>
					</div>
					<span id="cshipnoterror" class="errcls red-txt" style="float:right;"><?php echo __d('user','Shipping not available. Please add any other shipping address');?></span>
					<?php }?>
                </div>
                <?php if ($totalAmountPay=='0' || $totalAmountPay<0) { ?>
 
				<div class="active_horizontal" id="freeorder">
                   <div class="payment_dis_table margin-bottom15">
						<div class="payment_dis_cell">
							<div class="cod_image1 margin_top10_rtl">
							<div class="paypal_image"></div>
							</div>
						</div>
						<div class="payment_dis_cell">
						<h5 class="margin-left10 margin-bottom5 margin-right10 margin_top10_rtl line_height25"><?php echo __d('user','Trust Pay: 100% Payment Protection, Easy Return Policy');?></h5>
						<span class="margin-left10 margin-right10 margin_top10_rtl"><?php echo __d('user','By placing the order, I have read and agreed the');
						echo $setngs['site_name'];?><?php echo __d('user',"'s");?> <a href="" class="primary-color-txt"><?php echo __d('user','Terms of Use');?></a></span>
						</div>
				   </div>
				   <div class="view-all-btn btn primary-color-bg primary-color-bg">
						<a data-toggle="modal" id="codtoggle" onclick="return checkship()"><?php echo __d('user','Place an Order');?> </a>
					</div>
					<span id="cshipnoterror" class="errcls red-txt" style="float:right;"><?php echo __d('user','Shipping not available. Please add any other shipping address');?></span>
                </div>
                <?php } ?>

            </div>

        </div>
        <?php }?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mobile_first padding_ship_address">
				<div class="ship_cart_address border_bottom_grey">
					<h4 class="bold-font margin-top0"><?php echo __d('user','Ship to');?></h4>
						<?php if (count($usershipping) > 0) { $disable='';  ?>
						<span><?php echo __d('user','Select your address');?></span>
						<div class="dropdown margin-top10 selectdiv">
						<select id="address-cart" onchange="cartshipping('<?php echo $setcart['shopid'];?>');">
							<?php
							 foreach ($usershipping as $usership) {
								$shipid = $usership['shippingid'];
								$nick = $usership['nickname'];
								if ($usershippingdefault == $shipid) {
									$selectedShipping = $nick;
									//echo '<option selected value="'.$shipid.'">'.UrlfriendlyComponent::limit_char($nick,30).'</option>';
									echo '<option selected value="'.$shipid.'">'.$nick.'</option>';
									$fullname = $usership['name'];
									$address1 = $usership['address1'];
									$address2 = $usership['address2'];
									$city = $usership['city'];
									$state = $usership['state'];
									$country = $usership['country'];
									$zip = $usership['zipcode'];
									$phone = $usership['phone'];
									if ($usershippingdefaultval == $shipid) {
									$default_address = "default";
									$default_count = 1;
									}
								}else{
									echo '<option value="'.$shipid.'">'.$nick.'</option>';
								if(count($usershipping)>1)
									$default_count = 0;
								}
							}?>
							 </select>
						</div>
						<div class="delivery_address margin-top50">
						<h5>&nbsp;</h5>
						<h5><?php echo $fullname ;?></h5>
						<h5><?php echo $address1 ;?></h5>
						<h5><?php echo $city ;?></h5>
						<h5><?php echo $state ;?></h5>
						<h5><?php echo $zip ;?></h5>
						<h5><?php echo $country ;?></h5>
						<span class="margin-top15"><?php echo $phone ;?></span>
						</div>
						<?php
							if($default_count==0) { ?>
								<div class="ship-addres centered-text font_size13 margin-top30 margin_bottom_mobile20">
								<a href="<?php echo $baseurl; ?>addaddress"><?php echo __d('user','Add Shipping Address');?></a></div>
							<?php
							}
							else{
							?>
								<div class="ship-addres centered-text font_size13 margin-top30 margin_bottom_mobile20">
								<a href="<?php echo $baseurl; ?>addaddress"><?php echo __d('user','Add Shipping Address');?></a></div>
							<?php }
						} else {
							$noshipping=1;
						?>
						<div class="ship-addres centered-text font_size13 margin-top30 margin_bottom_mobile20">
						<a href="<?php echo $baseurl; ?>addaddress"><?php echo __d('user','Add Shipping Address');?></a>
						<p id="shiperr" class="centered-text red-txt errcls"><?php echo __d('user','Please add the shipping address');?></p>
						</div>
						<?php } ?>
				</div>
				<div class="white_bg">
					<div class="panel-group" id="accordion_cart" role="tablist" aria-multiselectable="true">
					<?php if($soldout=='0' && $setgiftcard=='0' && $setcreditamount=='0') { $couponstyle="display:block;padding-bottom:20px"; } else { $couponstyle="display:none;padding-bottom:20px"; } ?>
					  <div class="panel panel-default applycouponcode" style="<?php echo $couponstyle;?>">
						<div class="panel-heading" role="tab" id="headingOne">
						<a role="button" data-toggle="collapse" data-parent="#accordion_cart" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						  <h4 class="panel-title accordion_cart bold-font no_hor_padding">
							 <?php echo __d('user','Coupon Code');?><i class="more_less_cart fa fa-angle-up pull-right fa_font_wt"></i>
							</h4>
						  </a>
						</div>
						<?php if(!isset($getcouponvalue) && $getcouponvalue==""){ ?>
						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" >
						<div class="panel-body padding-top0">

							<input class="form-control font_size13 margin-bottom10" name="couponcode" id="couponcode" placeholder="<?php echo __d('user','Enter your Coupon Code');?>">
							<p class="text-right errcls red-txt coupon_error"><?php echo __d('user','Please enter your coupon code');?></p>
							<p class="text-right errcls red-txt couponsnotvalid"><?php echo __d('user','Please enter a valid coupon code');?></p>
							<p class="text-right errcls red-txt couponsExpired"><?php echo __d('user','Coupon code you entered is expired');?></p>
							<p class="text-right errcls red-txt couponsntvalidsmer"><?php echo __d('user','Coupon code is not valid for this cart');?></p>
							<div class="row margin-top10">
								<div class="col-xs-6 col-sm-6 col-lg-6">
								<div class="btn primary-color-bg primary-color-bg">
									<a onclick="checksellercoupon('<?php echo $item_id;?>','<?php echo $itemuserid;?>','<?php echo $userid;?>','<?php echo $itemshopid;?>');"><?php echo __d('user','Apply Coupon');?></a>
								</div>
								</div>
							</div>
							</div>
							</div>
							<?php } else {?>
							<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body padding-top0">
								<div class="row margin-top10">
									<div class="col-xs-6 col-sm-6 col-lg-6">
									<div class="btn primary-color-bg primary-color-bg">
										<a onclick="removeoffers();"><?php echo __d('user','Remove the Coupon discount amount');?></a>
									</div>
									</div>
								</div>
							</div>
							 </div>
							<?php }?>

					  </div>
					  <?php
					   if(isset($getcouponvalue)){
					    echo '<input type="hidden" id="coupon_idhide" value="'.$getcouponvalue['id'].'" />';
					  }else{
					  	echo '<input type="hidden" id="coupon_idhide" value="" />';
					  }
					  ?>
					  <?php 
					  if(!isset($getcouponvalue) && $soldout=='0' && $setcreditamount=='0') { $giftcardstyle="display:block;padding-bottom:20px"; } else { $giftcardstyle="display:none;padding-bottom:20px"; } 
					  ?>
					  <div class="panel panel-default applygiftcard" style="<?php echo $giftcardstyle;?>">
						<div class="panel-heading" role="tab" id="headingTwo">
						 <a role="button" data-toggle="collapse" data-parent="#accordion_cart" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
						  <h4 class="panel-title accordion_cart bold-font no_hor_padding">
							 <?php echo __d('user','Apply Gift Card');?><i class="more_less_cart fa fa-angle-down pull-right fa_font_wt"></i>
							</h4>
							 <h4 class="panel-title accordion_cart bold-font display_none primary-color-txt">
							 <?php echo __d('user','Apply Gift Card');?><i class="fa fa-check pull-right"></i>
							</h4>
						  </a>
						</div>
						<?php if(!isset($getgiftcardValue) && $getgiftcardValue==""){ ?>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						   <div class="panel-body padding-top0">
							<input class="form-control font_size13 margin-bottom10" id="giftcode" placeholder="<?php echo __d('user','Enter your Giftcard Code');?>">
							<p id="giftcodesemp" class="text-right errcls red-txt"><?php echo __d('user','Please enter a valid code');?></p>
							<p id="giftcodesnotvalid" class=" text-right errcls red-txt"><?php echo __d('user','Please enter a valid giftcard code');?></p>
							<p id="giftcodesemp" class="text-right errcls red-txt"><?php echo __d('user','Please enter a valid giftcard code');?></p>
							<div class="row margin-top10">
								<div class="col-xs-6 col-sm-6 col-lg-6 ">
								<div class="btn primary-color-bg primary-color-bg ">
									<a onclick="Checkgiftcard();"><?php echo __d('user','Apply Gift Card');?></a>
									</div>
								</div>
							</div>
						  </div>
						</div>
						<?php }
						 else {?>
							<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body padding-top0">
								<div class="row margin-top10">
									<div class="col-xs-6 col-sm-6 col-lg-6">
									<div class="btn primary-color-bg primary-color-bg">
										<a onclick="removeoffers();"><?php echo __d('user','Remove the Giftcard amount');?></a>
									</div>
									</div>
								</div>
							</div>
							 </div>
							<?php }?>

					  </div>
					  <?php
					   if(isset($getgiftcardValue)){
					    echo '<input type="hidden" id="giftcard_idhide" value="'.$getgiftcardValue['id'].'" />';
					  }else{
					  	echo '<input type="hidden" id="giftcard_idhide" value="" />';
					  }
					  ?>

					  <?php if($soldout=='0' && $setcoupon=='0' && $setgiftcard=='0') { $applycreditamount="display:block"; } else { $applycreditamount="display:none"; } ?>
					  <div class="panel panel-default box_shadow0 applycreditamount" style="<?php echo $applycreditamount;?>">
						<div class="panel-heading" role="tab" id="headingThree">
						  <a role="button" data-toggle="collapse" data-parent="#accordion_cart" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
						  <h4 class="panel-title accordion_cart bold-font no_hor_padding">
							<?php echo __d('user','Use Credit Amount');?><i class="more_less_cart fa fa-angle-down pull-right fa_font_wt"></i>
							</h4>
						  </a>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<?php if($available_bal >0){
							if($setcreditamount >0 && $setcoupon=='0' && $setgiftcard=='0') {
							?>
							<div class="panel-body padding-top0">
								<div class="row margin-top10 padding-bottom10">
									<div class="col-xs-6 col-sm-6 col-lg-6">
									<div class="btn primary-color-bg primary-color-bg">
										<a onclick="removeoffers();"><?php echo __d('user','Remove the Credit Amount');?></a>
									</div>
									</div>
								</div>
							</div>
						  <?php }
						  else { ?>
						   <div class="panel-body padding-top0">
						   <div class="text-center">
							<h5 class="primary-color-txt"><?php echo __d('user','Total credits available'); echo':';?>
							<!--CONVERT CURRENCY STARTS-->
							<?php
							if(isset($_SESSION['currency_code']))
							{
								$available_bal =  $currencycomponent->conversion($_SESSION['default_currency_value'],$_SESSION['currency_value'],$available_bal);
								echo (round($available_bal,2))." ".$_SESSION['currency_code'];
							}
							else
							{
								if($itmscurrency>1){
									$available_bal =  $currencycomponent->conversion($_SESSION['default_currency_value'],
										$_SESSION['default_currency_value'],$available_bal);
									echo (round($available_bal,2))." ".$_SESSION['default_currency_code'];
								}

								else
								{	$available_bal =  $currencycomponent->conversion($_SESSION['default_currency_value'],$itms_rate[0],$available_bal);
									echo (round($available_bal,2))." ".$itms_currency[0];
								}

							}
							?>
							<!--CONVERT CURRENCY ENDS-->
							</h5>
							</div>
							<input type="text" id="userentercreditamt" name = "creadit_amount" class="form-control font_size13  margin-top10" placeholder="<?php echo __d('user','Enter your credit amount to use');?>" onkeypress="return isNumberdot(event);">
							<p id="crediterr" class="text-right red-txt errcls"><?php echo __d('user','Please enter a credit amount');?></p>
							<p id="creditamtexceed" class="text-right red-txt errcls"><?php echo __d('user','You can use cart allowed credits only');?></p>
								<p id="totalamtexceed" class="text-right red-txt errcls"><?php echo __d('user','Credit amount for this purchase is too high');?></p>
							<div class="row padding-bottom10">
							<div class="col-xs-6 col-sm-6 col-lg-6 ">
							<div class="btn primary-color-bg primary-color-bg  margin-top10">
								<a onclick="checkusercreditamntchek();"><?php echo __d('user','Apply'); ?></a>
								</div>
								</div>

							</div>
						  </div>
						  	<?php } ?>

						  <?php } else{?>
						  <div class="panel-body padding-top0">
							<div class="row">
							<div class="text-center">
							<h5 class="red-txt"><?php echo __d('user','Invite Friends & Earn Credit Points'); ?></h5>
							</div>
							</div>
						  </div>

						  <?php }?>
						</div>
						</div>

						<!-- COD Modal-->
						<div class="modal fade" id="cod-modal" role="dialog" tabindex="-1">
							<div class="modal-dialog">
							<!-- Modal content-->
							  <div class="pop-up modal-content">
								<div class="pop-up-cnt modal-body">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<h2 class="login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo __d('user','Confirm your order');?></h2>
													<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<?php echo $this->Captcha->create('securitycode');?>
													</div>
													<div class="padding-top15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding text-right">
														<div class="share-cnt-row create-dispute-btn">
															<button type="submit" class="margin-bottom10 edit_popup_button btn txt-uppercase primary-color-bg bold-font transparent_border codconfirm" onclick="make_cod_order();"><?php echo __d('user','Confirm Order'); ?></button>
															<button type="button" class="margin-bottom10 edit_popup_button btn white-color-bg txt-uppercase primary-color-border-btn bold-font margin-left10" data-dismiss="modal"><?php echo __d('user','Confirm Later'); ?></button>
														</div>
														<img src="<?php echo SITE_URL;?>images/loading.gif" alt="Loading" style="display:none;" id="codload"/>
														<div id="captcherr" style="display:none;" class="red-txt errcls"><?php echo __d('user','Security code is invalid');?></div>
													</div>
										</div>
									</div>
								</div>
							</div>
						  </div>
						<!-- COD Modal-->
				</div>

			</div>
			</div>
			</div>
			<input type='hidden' id='available_balance' value='<?php echo $available_bal; ?>' />
			<input type='hidden' id='shipping_addre' value='<?php echo count($usershipping); ?>' />
			<input type="hidden" id="commissionTotal"  value="<?php echo $commiItemTotalPrice; ?>" />
			<input type="hidden" id="itemcostTotal" value="<?php echo $item_price; ?>" />
			<input type="hidden" id="shippingTotal" value="<?php echo $totalShippingPayable; ?>" />

		<script type="text/javascript">
				var couajax=0;
				$( ".paybybraintree" ).click(function() {
				var checkshipping='<?php echo $noshipping; ?>';
				var proship='<?php echo $productshipp; ?>';

				 if(checkshipping=='1')
				 {
				 	$('#shiperr').fadeIn();
				 	setTimeout(function() {
				        $("#shiperr").fadeOut('slow');
				    }, 2000);
				 }
				 else if(proship == 1){
			$('#shipnoterror').fadeIn();
		 	setTimeout(function() {
		        $("#shipnoterror").fadeOut('slow');
		    }, 5000);
		 }
				 else{
					var shippingid = $('#address-cart').val();
					$('#stripe_shipIdb').val(shippingid);
					setTimeout("document.paymentbraintreeform.submit()", 2);
					$(".paybybraintree").attr('disabled','disabled');
				 }
				 });

				$("#securitycode").val("");
				jQuery('.creload').on('click', function() {
				    var mySrc = $(this).prev().attr('src');
				    var glue = '?';
				    if(mySrc.indexOf('?')!=-1)  {
				        glue = '&';
				    }
				    $(this).prev().attr('src', mySrc + glue + new Date().getTime());
				    return false;
				});

				function checkship()
	{
		var proship='<?php echo $productshipp; ?>';
		if(proship == 1)
		{
			$('#cshipnoterror').fadeIn();
		 	setTimeout(function() {
		        $("#cshipnoterror").fadeOut('slow');
		    }, 5000);
			return false;
		}
		$('#cod-modal').modal('toggle');	
	}
		</script>
		<?= $this->Html->script('easyResponsiveTabs.js') ?>
		


		<style type="text/css">
			.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
				color: #0659fd!important;
			}
			.nav-tabs>li>a, .nav-tabs>li>a:focus, .nav-tabs>li>a:hover{
				color: #333!important;
			}
			.payment_dis_cell{
				vertical-align: bottom;
				padding-left: 6px;
			}
				@media(max-width: 768px){
   .active > div{
				display:block!important;
			}
			ul.resp-tabs-list{
				display: block!important;
			}
			.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
				color: #0659fd!important;
			}
			.nav-tabs>li>a, .nav-tabs>li>a:focus, .nav-tabs>li>a:hover{
				color: #ccc!important;
			}
}

		</style>