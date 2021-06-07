<?php
namespace Cake\I18n;
use Cake\I18n\Time;
$widgets = explode('(,)',$homepageModel['widgets']);
$sliders = json_decode($homepageModel['slider'], true);
$webslidercount = 0;
$appslidercount = 0;
foreach ($sliders as $key => $webslider) {
	if($webslider['mode'] == 'web')
		$webslidercount++;
	if($webslider['mode'] == 'app')
		$appslidercount++;
}
//$slidercount = count($sliders);
$sliderProperty = json_decode($homepageModel['properties'], true);
$sliderstyle = "style='box-shadow:none;height:".$sliderProperty['sliderheight'].";background-color:".$sliderProperty['sliderbg'].";'";

$widgetSettings = json_decode($homepageModel['widget_settings']);
?>

 <div class="row">
      <section class="col-md-9 col-sm-12 no-hor-padding ">
      <section class="side-collapse-container mainPage">

         <section class="slider">
            <div class="banner"> 
            <?php
			  $sliderkey = 0;
			  //echo '<pre>';print_r($sliders);
			  //foreach($sliders as $skey => $slider){
			  	if($sliders[0]['mode'] == 'web'){ 
            	echo '<a href="'.$sliders[0]['link'].'" target="_blank" style="display:block;">
						  		<img src="'.SITE_URL.'images/slider/'.$sliders[0]['image'].'" alt="'.$sliders[0]['image'].'">
						  	</a>';
				 }?>
            </div>
         </section>
         <!--Daily Deals-->
			<?php	date_default_timezone_set("Asia/KolKata");
				$date = date('d');
				$month = date('m');
				$year = date('Y');
				$today = $month.'/'.$date.'/'.$year;
				$date1 = date('Y-m-d H:i:s');
				$date2 = date("Y-m-d", strtotime($today)).' 24:00:00';
				$diff = abs(strtotime($date2) - strtotime($date1));

				$hours = floor(($diff % 86400) / 3600);
				$mins = floor(($diff % 86400 % 3600) / 60);
				$sec = ($diff % 60);

				?>
				<script type="text/javascript">
				// Initialize the Date object.
				//  The set methods should be filled in by PHP

				var _date = new Date();
				_date.setHours(<?php echo $hours; ?>);
				_date.setMinutes(<?php echo $mins; ?>);
				_date.setSeconds(<?php echo $sec; ?>);

				// Generates a HH:MM:SS string
				function parseDate(dateObj) {
				  var output = "";
				  if(dateObj.getHours() < 10) {
				      output += "";
				  }
				  output += dateObj.getHours() + ":";

				  if(dateObj.getMinutes() < 10) {
				   output += "0";
				  }
				  output += dateObj.getMinutes() + ":";

				  if(dateObj.getSeconds() < 10) {
				   output += "0";
				  }
				  output += dateObj.getSeconds();
				  console.log(output);
				  return output;
				}

				// Start the countdown
				setInterval(function() {
				    _date.setSeconds(_date.getSeconds() - 1);
				    document.getElementById('timer').innerHTML = parseDate(_date);
				}, 1000);
				 </script>
         <?php
		if(count($todaydeal) > 0)
		{
		?>
         <section class="new-arrivals paddigs todaysDeal clearfix">
            <div class="product_align_cnt  no-hor-padding">
               <div class="item-slider grid no-hor-padding">
                  <div class="section_header tdyDeal col-xs-12 col-sm-3 col-md-3 col-lg-3">
                     <div class="todayDeal">
                        <div>
                     <div class="deals"><h2 class="section_heading bold-font">
                        Todays Deal</h2></div>
                        <div class="timerToday deals">
                           <div class="timer"><img src="./img/Timer@2x.png" alt="timer"></div>
                           <div class="timerClock" id="timer"></div>
                        </div>
                     <div class="view-all-btn btn primary-color-bg primary-color-bg deals">
                        <a href="<?php echo SITE_URL.'viewmore/dailydeals';?>"><?php echo __d('user','View All');?></a>

                     </div>
                  </div>
                  </div>
                  </div>

                  <div
                     class=" col-xs-12 col-sm-7 col-md-8 col-lg-8  product-sec-slide heroSlider-fixed">
                    
                     <div class=" new_arrivals ar_center homeSlider">
                     	<?php
						//echo '<pre>'; print_r($data); die;
							foreach($todaydeal as $dealkey => $deal)
							{
								$itemid = base64_encode($deal->id."_".rand(1,9999));

								$item_title = $deal['item_title'];
								$item_title_url = $deal['item_title_url'];
								$item_price = $deal['price'];
								$favorte_count = $deal['fav_count'];
								$username = $deal['user']['username'];
								$currencysymbol = $deal['forexrate']['currency_symbol'];
								$items_image = $deal['photos'][0]['image_name'];



										$item_image = $deal['photos'][0]['image_name'];
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


									$itemprice = $deal['price'];
					$discountprice = $itemprice * ( 1 - $deal['discount'] / 100 );

					$item_url = base64_encode($deal['id']."_".rand(1,9999));

					$user_currency_price =  $currencycomponent->conversion($deal['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

					$user_currency_dealprice = $currencycomponent->conversion($deal['forexrate']['price'],$_SESSION['currency_value'],$discountprice);
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
						?>
                        <div class="item1 box_shadow_img">
                           <div class="product_cnt clearfix">
                              <div class="imgDescription">
                              <a class="img-hover1" href="<?php echo SITE_URL.'listing/'.$item_url; ?>">
                                 <div class="bg_product">
                                    <img src="<?php echo $itemimage; ?>" class="img-responsive">
                                 </div>
                              </a>
                              <div class="prodDescrip new_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                                 <div class="imgDes">
                                 <a class=""
                                    href="<?php echo SITE_URL.'listing/'.$item_url; ?>">
                                     <div class="desCri"><?php echo $deal['item_title'];?></div> </a>

                                 <div class="price ">
                                    $600
                                 </div>
                                 <span id="price_vals6" price_val="$300"
                                    style="display:none;width:0px !important;"></span>
                                 </div>
                                 
                              </div>
                              </div>
                              
                           </div>

                        </div>
                        <?php }	?>
                        <!-- <div class="item1 box_shadow_img">
                           <div class="product_cnt clearfix">
                              <div class="imgDescription">
                              <a class="img-hover1" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                 <div class="bg_product">
                                    <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                 </div>
                              </a>

                              


                              <div class="prodDescrip new_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                                 <div class="imgDes">
                                 <a class=""
                                    href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                     <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>

                                 <div class="price ">
                                    $600
                                 </div>
                                 <span id="price_vals6" price_val="$300"
                                    style="display:none;width:0px !important;"></span>
                                 </div>
                                 
                              </div>
                              </div>
                              
                           </div>

                        </div> -->

                        
                     </div>

                  </div>
               </div>
            </div>
         </section>
         <?php }  ?>
         <section class="clearfix">
            <div class="allImg">
               <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                 <div class="bg_product">
                   <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                 </div>
                 <div class="prodDescrip new_prod_nam bold-font ">
                   <div class="prdDescrip">
                     <div class="imgDes">
                       <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                         <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                         
                         
                         <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                       </div>
                       <div class="desIcon">
                         <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                         <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                       </div>
                     </div>
                     <div class="price ">
                       $600
                     </div>
                   </div>
                 </div>

                 <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                   <div class="bg_product">
                     <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                   </div>
                   <div class="prodDescrip new_prod_nam bold-font ">
                     <div class="prdDescrip">
                       <div class="imgDes">
                         <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                           <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                           
                           
                           <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                         </div>
                         <div class="desIcon">
                           <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                           <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                         </div>
                       </div>
                       <div class="price ">
                         $600
                       </div>
                     </div>
                   </div>

                   <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                     <div class="bg_product">
                       <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                     </div>
                     <div class="prodDescrip new_prod_nam bold-font ">
                       <div class="prdDescrip">
                         <div class="imgDes">
                           <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                             <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                             
                             
                             <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                           </div>
                           <div class="desIcon">
                             <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                             <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                           </div>
                         </div>
                         <div class="price ">
                           $600
                         </div>
                       </div>
                     </div>


                     <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                       <div class="bg_product">
                         <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                       </div>
                       <div class="prodDescrip new_prod_nam bold-font ">
                         <div class="prdDescrip">
                           <div class="imgDes">
                             <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                               <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                               
                               
                               <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                             </div>
                             <div class="desIcon">
                               <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                               <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                             </div>
                           </div>
                           <div class="price ">
                             $600
                           </div>
                         </div>
                       </div>

                       <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                         <div class="bg_product">
                           <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                         </div>
                         <div class="prodDescrip new_prod_nam bold-font ">
                           <div class="prdDescrip">
                             <div class="imgDes">
                               <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                 <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                 
                                 
                                 <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                               </div>
                               <div class="desIcon">
                                 <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                 <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                               </div>
                             </div>
                             <div class="price ">
                               $600
                             </div>
                           </div>
                         </div>

                         <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                           <div class="bg_product">
                             <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                           </div>
                           <div class="prodDescrip new_prod_nam bold-font ">
                             <div class="prdDescrip">
                               <div class="imgDes">
                                 <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                   <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                   
                                   
                                   <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                 </div>
                                 <div class="desIcon">
                                   <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                   <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                 </div>
                               </div>
                               <div class="price ">
                                 $600
                               </div>
                             </div>
                           </div>

                           <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                             <div class="bg_product">
                               <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                             </div>
                             <div class="prodDescrip new_prod_nam bold-font ">
                               <div class="prdDescrip">
                                 <div class="imgDes">
                                   <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                     <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                     
                                     
                                     <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                   </div>
                                   <div class="desIcon">
                                     <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                     <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                   </div>
                                 </div>
                                 <div class="price ">
                                   $600
                                 </div>
                               </div>
                             </div>

                             <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                               <div class="bg_product">
                                 <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                               </div>
                               <div class="prodDescrip new_prod_nam bold-font ">
                                 <div class="prdDescrip">
                                   <div class="imgDes">
                                     <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                       <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                       
                                       
                                       <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                     </div>
                                     <div class="desIcon">
                                       <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                       <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                     </div>
                                   </div>
                                   <div class="price ">
                                     $600
                                   </div>
                                 </div>
                               </div>

                               <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                 <div class="bg_product">
                                   <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                 </div>
                                 <div class="prodDescrip new_prod_nam bold-font ">
                                   <div class="prdDescrip">
                                     <div class="imgDes">
                                       <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                         <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                         
                                         
                                         <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                       </div>
                                       <div class="desIcon">
                                         <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                         <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                       </div>
                                     </div>
                                     <div class="price ">
                                       $600
                                     </div>
                                   </div>
                                 </div>

                                 <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                   <div class="bg_product">
                                     <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                   </div>
                                   <div class="prodDescrip new_prod_nam bold-font ">
                                     <div class="prdDescrip">
                                       <div class="imgDes">
                                         <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                           <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                           
                                           
                                           <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                         </div>
                                         <div class="desIcon">
                                           <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                           <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                         </div>
                                       </div>
                                       <div class="price ">
                                         $600
                                       </div>
                                     </div>
                                   </div>


                                   <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                     <div class="bg_product">
                                       <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                     </div>
                                     <div class="prodDescrip new_prod_nam bold-font ">
                                       <div class="prdDescrip">
                                         <div class="imgDes">
                                           <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                             <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                             
                                             
                                             <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                           </div>
                                           <div class="desIcon">
                                             <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                             <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                           </div>
                                         </div>
                                         <div class="price ">
                                           $600
                                         </div>
                                       </div>
                                     </div>


                                     <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                       <div class="bg_product">
                                         <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                       </div>
                                       <div class="prodDescrip new_prod_nam bold-font ">
                                         <div class="prdDescrip">
                                           <div class="imgDes">
                                             <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                               <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                               
                                               
                                               <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                             </div>
                                             <div class="desIcon">
                                               <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                               <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                             </div>
                                           </div>
                                           <div class="price ">
                                             $600
                                           </div>
                                         </div>
                                       </div>

                                       <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                         <div class="bg_product">
                                           <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                         </div>
                                         <div class="prodDescrip new_prod_nam bold-font ">
                                           <div class="prdDescrip">
                                             <div class="imgDes">
                                               <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                                 <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                                 
                                                 
                                                 <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                               </div>
                                               <div class="desIcon">
                                                 <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                                 <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                               </div>
                                             </div>
                                             <div class="price ">
                                               $600
                                             </div>
                                           </div>
                                         </div>

                                         <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                           <div class="bg_product">
                                             <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                           </div>
                                           <div class="prodDescrip new_prod_nam bold-font ">
                                             <div class="prdDescrip">
                                               <div class="imgDes">
                                                 <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                                   <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                                   
                                                   
                                                   <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                                 </div>
                                                 <div class="desIcon">
                                                   <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                                   <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                                 </div>
                                               </div>
                                               <div class="price ">
                                                 $600
                                               </div>
                                             </div>
                                           </div>

                                           <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                             <div class="bg_product">
                                               <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                             </div>
                                             <div class="prodDescrip new_prod_nam bold-font ">
                                               <div class="prdDescrip">
                                                 <div class="imgDes">
                                                   <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                                     <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                                     
                                                     
                                                     <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                                   </div>
                                                   <div class="desIcon">
                                                     <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                                     <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                                   </div>
                                                 </div>
                                                 <div class="price ">
                                                   $600
                                                 </div>
                                               </div>
                                             </div>

                                             <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                               <div class="bg_product">
                                                 <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                               </div>
                                               <div class="prodDescrip new_prod_nam bold-font ">
                                                 <div class="prdDescrip">
                                                   <div class="imgDes">
                                                     <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                                       <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                                       
                                                       
                                                       <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                                     </div>
                                                     <div class="desIcon">
                                                       <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                                       <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                                     </div>
                                                   </div>
                                                   <div class="price ">
                                                     $600
                                                   </div>
                                                 </div>
                                               </div>

                                               <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                 <div class="bg_product">
                                                   <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                                 </div>
                                                 <div class="prodDescrip new_prod_nam bold-font ">
                                                   <div class="prdDescrip">
                                                     <div class="imgDes">
                                                       <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                                         <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                                         
                                                         
                                                         <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                                       </div>
                                                       <div class="desIcon">
                                                         <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                                         <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                                       </div>
                                                     </div>
                                                     <div class="price ">
                                                       $600
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                   <div class="bg_product">
                                                     <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                                                   </div>
                                                   <div class="prodDescrip new_prod_nam bold-font ">
                                                     <div class="prdDescrip">
                                                       <div class="imgDes">
                                                         <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                                           <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                                           
                                                           
                                                           <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                                         </div>
                                                         <div class="desIcon">
                                                           <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                                           <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                                         </div>
                                                       </div>
                                                       <div class="price ">
                                                         $600
                                                       </div>
                                                     </div>
                                                   </div>

                                                   <div class="view-all-btn loadMore btn primary-color-bg primary-color-bg deals">
                                                      <a href="http://services.hitasoft.in/dev/stratus/viewmore/popular">Load more</a>
                                                   </div>  
             </div>
       
         </section>
      </section>
   </section>
      <section class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
         <div class="cateGory">
         <div class="category">
            <div id="sidebar">
               <div class="sidebar__inner border_right_grey" style="position: relative; ">
                  
         		<div id="accordion1" class="panel-group margin-bottom0">
				<div id="" class="panel panel-default box_shadow0">
					<div class="panel-heading padding0">
						<a data-toggle="collapse" data-parent="#accordion1" href="#collapsezero" class="" aria-expanded="true">
							<h4 class="panel-title bold-font filter_accordion accordion_shop primary-color-bg white-txt">
								<div class="inlined-display shop_filter_menu_padding">
									<?php echo __d('user', 'Filter'); ?></div><i class="more-less glyphicon glyphicon-minus bold-font white-txt"></i>
								</h4>
							</a>
						</div>
						<div id="collapsezero" class="colla-hei panel-collapse collapse in" aria-expanded="true">
							<div class="no-hor-padding padding-top0">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading padding0" role="tab" id="headingOne">
											<a role="button" class="accordion_one" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												<h4 class="panel-title accordion_shop bold-font">
													<div class="inlined-display shop_filter_menu_padding">
														<?php echo __d('user', 'Categories'); ?></div><!-- <i class="more-less glyphicon glyphicon-minus"></i> -->

													</h4>
												</a>
											</div>

											<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
												<div class="panel-body list_menu">
													<div class="panel-group" id="nested">
														<?php
														foreach ($parent_categories as $parent_cat) {
															$parentcatid = $parent_cat['id'];
															echo '<div class="panel panel-default box_shadow0">
															<div class="panel-heading">
															<div class="checkbox checkbox-primary">';
															if (count($sub_categories[$parentcatid]) <= 0) {
																echo '<a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-0-_-0" value="' . $parentcatid . '">

																' . __d('user',$parent_cat['category_name']) . '
																</a>
																';
															} else {
																$cls = 'shop_menu';
																if (count($sub_categories[$parentcatid]) > 0)
																$cls = 'shop_menu1';

																echo '
																<a data-toggle="collapse" class="'.$cls.'" data-parent="#nested" href="#nested-collapseOne' . $parentcatid . '">
																<h4 class="panel-title sub_menu_panel">
																' . __d('user',$parent_cat['category_name']);
																//if (count($sub_categories[$parentcatid]) > 0)
																	//echo '<i class="more-less glyphicon glyphicon-plus"></i>';
																echo '</h4>
																</a>
																';
															}
															echo '</div>
															</div><!--/.panel-heading -->';
															if (count($sub_categories[$parentcatid]) > 0) {
																echo '<div id="nested-collapseOne' . $parentcatid . '" class="panel-collapse collapse">
																<div class="pad_left25">
																';
																if (count($sub_categories[$parentcatid]) > 0) {
																	echo '<div class="checkbox checkbox-primary padding-bottom15">
																	<a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-0-_-0">
																	<h4 class="panel-title sub_menu_panel">
																	' . __d('user', 'View All') . '
																	</h4></a></div>
																	';
																}

																foreach ($sub_categories[$parentcatid] as $sub_cat) {

																	$subcatid = $sub_cat['categoryid'];
																	$subcatname = $sub_cat['category_name'];
																	echo '
																	<div class="checkbox checkbox-primary padding-bottom15">';
																	if (count($super_categories[$parentcatid][$subcatid]) <= 0) {
																		echo '<a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-' . $subcatid . '-_-0">' . __d('user',$subcatname) . '</a>';
																	} else {
																		echo '<a data-toggle="collapse" data-parent="#nested-collapseOne' . $parentcatid . '" href="#nested-collapseTwo' . $subcatid . '" class="shop_menu active">
																		' .__d('user', $subcatname ). '
																		<i class="more-less glyphicon glyphicon-plus"></i>
																		</a>';
																	}
										/*echo '<input id="'.$parentcatid.'-_-'.$subcatid.'-_-0" value="'.$parentcatid.'-'.$subcatid.'" type="checkbox" name="category">
										<label for="'.$parentcatid.'-_-'.$subcatid.'-_-0">
										<a data-toggle="collapse" data-parent="#nested-collapseOne'.$parentcatid.'" href="#nested-collapseTwo'.$subcatid.'" class="shop_menu active">
										'.$subcatname.'
										</a>
										</label>';*/
										echo '</div>
										';
										if (count($super_categories[$parentcatid][$subcatid]) > 0) {
											echo '<div id="nested-collapseTwo' . $subcatid . '" class="panel-collapse collapse">
											<div class="pad_left25">
											';

											if (count($super_categories[$parentcatid][$subcatid]) > 0) {
												echo '<div class="checkbox checkbox-primary padding-bottom15"><a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-' . $subcatid . '-_-0">' . __d('user', 'View All') . '</a></div>';
											}

											foreach ($super_categories[$parentcatid][$subcatid] as $super_cat) {
												$supercatid = $super_cat['categoryid'];
												$supercatname = $super_cat['category_name'];
												echo '
												<div class="checkbox checkbox-primary padding-bottom15">
												<a href="'.SITE_URL.'shop/'.$parent_cat['category_urlname'].'" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-' . $subcatid . '-_-' . $supercatid . '">' . __d('user',$supercatname) . '</a>
												</div>
												';
											}
											echo '
											</div>
											</div>';
										}
									}
									echo '
									</div><!--/.panel-body -->
									</div><!--/.panel-collapse -->';
								}
								echo '</div><!-- /.panel -->';
							}
							?>

						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading padding0" role="tab" id="headingTwo">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
						<h4 class="panel-title accordion_shop bold-font">
							<?php echo __d('user','By Price'); ?><i class="more-less glyphicon glyphicon-plus"></i>
						</h4>
					</a>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body list_menu">
						<?php
						foreach ($price_val as $price) {
							echo '<div class="checkbox checkbox-primary padding-bottom15">
							<input id="price' . $price['id'] . '" value="' . $price['from'] . '-' . $price['to'] . '" type="checkbox" name="price">
							<label for="price' . $price['id'] . '">' . $price['from'] . '-' . $price['to'] . '</label>
							</div>';
						}
						?>
					</div>
				</div>
			</div>

			<div class="panel panel-default">

				<div class="panel-heading padding0" role="tab" id="headingThree">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
						<h4 class="panel-title accordion_shop bold-font">
							<div class="inlined-display shop_filter_menu_padding">
								<?php echo __d('user', 'By Color'); ?></div><i class="more-less glyphicon glyphicon-plus"></i>

							</h4>
						</a>
					</div>

					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="panel-body list_menu">
							<?php
							foreach ($color_val as $color) {
								echo '<div class="checkbox checkbox-primary padding-bottom15">
								<input id="color' . $color['id'] . '" value="' . $color['color_name'] . '" type="checkbox" name="color">
								<label for="color' . $color['id'] . '">
								<span class="color_box" style="background: ' . $color['color_name'] . ';"></span>
								' . $color['color_name'] . '</label>
								</div>';
							}
							?>
						</div>
					</div>
				</div>


			</div>
                
         
         
                  </div>
         
               </div>
            </div>
         </div>
         </div>
         <object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>
         </div>
         </div>
         </div>
      </div>
      </section>
   </div>



<?php
//print_r($loguser); die;
if(isset($loguser['id'])){
	echo '<input type="hidden" id="loguserid" value="'.$loguser['id'].'">';
}
else{
	echo '<input type="hidden" id="loguserid" value="0">';
}
echo '<input type="hidden" id="likebtncnt" value="'.$setngs['like_btn_cmnt'].'" />';
echo '<input type="hidden" id="likedbtncnt" value="'.$setngs['liked_btn_cmnt'].'" />';

?>

	