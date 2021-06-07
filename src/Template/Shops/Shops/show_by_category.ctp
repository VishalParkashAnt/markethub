<?php
use Cake\Routing\Router;
use Cake\I18n\Time;
$baseurl = Router::url('/');
?>
<script type="text/javascript">
 var sIndex = 20, offSet = 20, isPreviousEventComplete = true,isDataAvailable=true;
</script>
<div class="row parent_reverce">
            <section class="col-md-9 col-lg-9 col-sm-12 no-hor-padding custom_height" >
                <div class="">
                    <div class="mainPage">
                        <section class="breadcrumb breadCrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom10" style="display: none;">
                            <div class="breadcrumb">
                               <a href="<?php echo $baseurl; ?>">Home</a>
								<span class="breadcrumb-divider1">/</span>
								<a href="#"><?php echo $this->request->getParam('controller'); ?></a>
								<span class="breadcrumb-divider1">/</span>
								<a href="#" style="text-transform:capitalize;" id="changecatname"><?php echo (!isset($bannerBreadcrumb)) ? strtolower($categoryName) : $bannerBreadcrumb ; ?></a>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="">
                    <div id="content" class="mainPage ">
                        <section class="clearfix dis_item">
                                 <div class="row stream">
                 <?php if (count($item->toArray()) != 0) { 
                 	foreach ($item as $key =>$itms) {
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
            <?php }?>
            <?php } else{ ?>
            	<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5><?php echo __d('user', 'No Products');?></h5></div>
            <?php }?>
           
            
  
              </div>
	                </section>
	            </div>
	        </div>
	    </section>
        <section class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
         <div class="cateGory">
         <div class="category">
            <div id="sidebar">
               <div class="sidebar__inner border_right_grey" style="position: relative; ">
                   <div class="parent">
                  <input type="search" placeholder="Search here..." class="" id="search_text" value="<?php echo $searchkey;?>">
                  <div class="price_range">
                    <p><?php echo __d('user', 'Price Range'); ?></p>
                    <div class="postcommentloader m-t-10 custom_loader" style="display: flex;
    justify-content: center;">
               <img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading..." />
                      </div>
                    <div class="priceSlider" style="display: none;">
                        
                    <!--   <span class="slide"></span> -->
                      <input id="range" type="range" min="0" max="5000" value="<?php if($search_price!="") echo $search_price; else echo '5000';?>">
                    </div>
                    <span id="value" style="display: none;" class="price_value"><?php if($search_price!="") echo $search_price; else echo '5000+';?></span>
                  </div>
                  <a href="javascript:void(0)" onclick="searchstring()"><div class="btn primary-color-bg primary-color-bg deals"><?php echo __d('user', 'Search'); ?></div></a>
                </div>
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
                                                        <div class="panel-heading padding0" role="tab" id="headingSort">
                                                            <div class="border_left_grey mobile_border_bottom padding0">
                                                                <ul class="padding-top13">
                                                                    <li class="dropdown sortDrop"><button class="dropdown-toggle padding-left10 padding-right10 text_grey shop_sortby_button sortByNew" data-toggle="dropdown" href="javascript:void(0)" aria-expanded="false"><span class="pull-left sorttxt trn" style="color: #000 !important;">
                                                                                <?php echo __d('user', 'Sort by : Newest'); ?></span>&nbsp;&nbsp;<i class="fa fa-angle-down padding-top3 padding_rght_10_mobletab pull-right"></i></button>
                                                                        <ul class="dropdown-menu popualrity_sort_menu sorTingDropDown">
                                                                            <li><a href="javascript:void(0);" onclick="setsort('new');">
                                                                                    <?php echo __d('user', 'Newest'); ?> </a></li>
                                                                            <li><a href="javascript:void(0);" onclick="setsort('asc');">
                                                                                    <?php echo __d('user', 'Price - Low to High'); ?> </a></li>
                                                                            <li><a href="javascript:void(0);" onclick="setsort('desc');">
                                                                                    <?php echo __d('user', 'Price - High to Low'); ?> </a></li>
                                                                        </ul>
                                                                        <input type="hidden" id="sortvalue" value="new">
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
									<div class="panel panel-default">
										<div class="panel-heading padding0" role="tab" id="headingOne">
											<a role="button" class="accordion_one" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												<h4 class="panel-title accordion_shop bold-font">
													<div class="inlined-display shop_filter_menu_padding">
														<?php echo __d('user', 'Categories'); ?></div><i class="more-less glyphicon glyphicon-minus"></i>

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
                                if($categoryName==$parent_cat['category_name']){
                                  $activeclass='active';
                                }
                                else{
                                  $activeclass='';
                                }
																echo '<a href="javascript:void(0);" class="shop_menu '.$activeclass.'" onclick="setcategory(this);" id="' . $parentcatid . '-_-0-_-0" value="' . $parentcatid . '">

																' . __d('user',$parent_cat['category_name']) . '
																</a>
																';
															} else {
                                if($categoryName==$parent_cat['category_name']){
                                 // echo "catname=".$categoryName;
                                  $activeclass='active';
                                  $activestyle='style="color: #1b33b7 !important;"';
                                }
                                else{
                                   $activeclass='';
                                  $activestyle='';
                                }
																$cls = 'shop_menu';
																if (count($sub_categories[$parentcatid]) > 0)
																$cls = 'shop_menu1';

																echo '
																<a data-toggle="collapse" class="'.$cls.' '.$activeclass.' highlight" data-parent="#nested" href="#nested-collapseOne' . $parentcatid . '" >
																<h4 class="panel-title sub_menu_panel" '.$activestyle.'>
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
																	<a href="javascript:void(0);" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-0-_-0">
																	' . __d('user', 'View All') . '
																</a></div>
																	';
																}

																foreach ($sub_categories[$parentcatid] as $sub_cat) {

																	$subcatid = $sub_cat['categoryid'];
																	$subcatname = $sub_cat['category_name'];
																	echo '
																	<div class="checkbox checkbox-primary padding-bottom15">';
																	if (count($super_categories[$parentcatid][$subcatid]) <= 0) {
																		echo '<a href="javascript:void(0);" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-' . $subcatid . '-_-0">' . __d('user',$subcatname) . '</a>';
																	} else {
																		echo '<a data-toggle="collapse" data-parent="#nested-collapseOne' . $parentcatid . '" href="#nested-collapseTwo' . $subcatid . '" class="shop_menu highlight">
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
												echo '<div class="checkbox checkbox-primary padding-bottom15"><a href="javascript:void(0);" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-' . $subcatid . '-_-0">' . __d('user', 'View All') . '</a></div>';
											}

											foreach ($super_categories[$parentcatid][$subcatid] as $super_cat) {
												$supercatid = $super_cat['categoryid'];
												$supercatname = $super_cat['category_name'];
												echo '
												<div class="checkbox checkbox-primary padding-bottom15">
												<a href="javascript:void(0);" class="shop_menu" onclick="setcategory(this);" id="' . $parentcatid . '-_-' . $subcatid . '-_-' . $supercatid . '">' . __d('user',$supercatname) . '</a>
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

				<div class="panel-heading padding0" role="tab" id="headingThree">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
						<h4 class="panel-title accordion_shop bold-font">
							<div class="inlined-display shop_filter_menu_padding">
								<?php echo __d('user', 'By Color'); ?></div><i class="more-less glyphicon glyphicon-plus"></i>

							</h4>
						</a>
					</div>

					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="panel-body list_menu" style="max-height: 150px;
    overflow-y: auto;">
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






<input type="hidden" value="<?php echo $currentIds; ?>" id="currentCategory">


</div>
<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>
</div>	

<?php
if (!empty($loguser)) {
	echo "<input type='hidden' id='loguserid' value='" . $loguser['id'] . "' />";
} else {
	echo "<input type='hidden' id='loguserid' value='0' />";
}
echo '<input type="hidden" id="likebtncnt" value="' . $setngs['like_btn_cmnt'] . '" />';
echo '<input type="hidden" id="likedbtncnt" value="' . $setngs['liked_btn_cmnt'] . '" />';

?>

<script type="text/javascript">
	//var sIndex = 20, offSet = 20, isPreviousEventComplete = true, isDataAvailable = true;
  isDataAvailable = true;
	var baseurl = getBaseURL();
	$(window).scroll(function () {
		//console.log("revealed");
		//return false;
	 //if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
	 	if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.5) {
      //console.log("available");
	 		if (isPreviousEventComplete && isDataAvailable) {

	 			console.log(sIndex+' offset');

	 			isPreviousEventComplete = false;
	 			var selectedCategory = $('.sub-category').val();
	 			if (selectedCategory == '') {
	 				selectedCategory = $('#currentCatPath').val();
	 			}
	 			var priceRange;var color;var sortPrice;var categoryId;
	 			// $("input[name='price']:checked").each( function () {
	 			// 	priceRange = $(this).val();
	 			// });
	 			var price=$(".price_value").html();
		  if(price!="" && price!="0" && price!='5000+'){
      priceRange='0-'+price;
    }
    else{
      priceRange="";
    }
		
		var searchKey=$("#search_text").val();
		//alert(priceRange+"==="+searchKey);
		var spclChars = "!@#$%^&*()"; // specify special characters

	for (var i = 0; i < searchKey.length; i++)
	{
			if (spclChars.indexOf(searchKey.charAt(i)) != -1)
			{
				alert ("Special characters are not allowed.");
				document.getElementById("search_text").value = "";
				return false;
			}
	} 
	 			$("input[name='color']:checked").each( function () {
	 				color = $(this).val();
	 			});
	 			$("input[name='sort']:checked").each( function () {
	 				sortPrice = $(this).val();
	 			});

	 			if( typeof (priceRange) == 'undefined'){
	 				priceRange = "";
	 			}
	 			if( typeof (color) == 'undefined'){
	 				color = "";
	 			}
	 			if( typeof (sortPrice) == 'undefined'){
	 				sortPrice = "";
	 			}

	 			categoryId = $("#currentCategory").val();
	 			if(typeof(categoryId) == 'undefined')
	 			{
	 				categoryId = $('#hiddencatvalue').val();
	 			}


	 			//var searchKey = $('.search-string').val();
	 			var baseurl = getBaseURL()+"getItemByCategory";
	 			$(".LoaderImage").css("display", "block");

	 			$.ajax({
	 				type: "POST",
	 				url: baseurl+'?startIndex=' + sIndex + '&offset=' + offSet,
	 				data: {price : priceRange, color:color, category:selectedCategory, catids:categoryId, sortPrice:sortPrice, q:searchKey,categorychanged:"no"},
	 				beforeSend: function () {
	 					$('#infscr-loading').show();
	 				},
	 				dataType: 'html',
	 				success: function (responce) {

	 					

	 					$('#infscr-loading').hide();
	 					//var tempp = responce.split('///');
	 					var tempp = responce;
	 					var out = tempp.toString();
	 					if($.trim(out)=='')
	 					{

	 						$(window).unbind('scroll');
	 					}
      	else if ($.trim(tempp) != 'false') {

      		$('.stream').append(tempp);
      	}else {
      		isDataAvailable = false;
      	}
      	sIndex = sIndex + offSet;
      	isPreviousEventComplete = true;
      }
  });

	 		}
	 	}
	 });


	</script>

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
			<!--div class="share-cnt-row">
				<div class="share-details-cnt margin-top30">
					<a href="" class="share-popup-btn btn primary-color-bg bold-font">CANCEL</a>
				</div>
			</div-->
		</div>
	</div>
</div>

</div>
</div>
<!-- Share modal -->

<script type="text/javascript">
	$(':checkbox').on('change',function(){
		var th = $(this), name = th.attr('name');
		if(th.is(':checked')){
			$(':checkbox[name="'  + name + '"]').not(th).prop('checked',false);
		}


		selectedCategory = $('#currentCatPath').val();
		var priceRange;var color;var sortPrice;var categoryId;
		// $("input[name='price']:checked").each( function () {
		// 	priceRange = $(this).val();
		// });
		var price=$(".price_value").html();
		  if(price!="" && price!="0" && price!='5000+'){
      priceRange='0-'+price;
    }
    else{
      priceRange="";
    }
		
		var searchKey=$("#search_text").val();
		//alert(priceRange+"==="+searchKey);
		var spclChars = "!@#$%^&*()"; // specify special characters

	for (var i = 0; i < searchKey.length; i++)
	{
			if (spclChars.indexOf(searchKey.charAt(i)) != -1)
			{
				alert ("Special characters are not allowed.");
				document.getElementById("search_text").value = "";
				return false;
			}
	} 
		$("input[name='color']:checked").each( function () {
			color = $(this).val();
		});
		sortPrice = $("#sortvalue").val();
		if( typeof (priceRange) == 'undefined'){
			priceRange = "";
		}
		if( typeof (color) == 'undefined'){
			color = "";
		}
		if( typeof (sortPrice) == 'undefined'){
			sortPrice = "";
		}

		//var searchKey = $('.search-string').val();
		var baseurl = getBaseURL()+"getItemByCategory";


		categoryId = $("#currentCategory").val();

		//alert(priceRange);

		if(typeof(categoryId) == 'undefined')
		{
			categoryId = $('#hiddencatvalue').val();
		}

		$.ajax({
			url: baseurl,
			type: "post",
			data: {price : priceRange, color:color, category:selectedCategory, catids:categoryId, sortPrice:sortPrice, q:searchKey},
			dataType: "html",
			beforeSend: function () {
    	  //$('.stream').fadeOut("slow","linear");
    	  //$('.itemLoader').show();
	  //$('.stream').hide();
	},
	success: function(responce){
    	  //$('.itemLoader').hide();
    	  /*
    	  var tempp = responce.split('///');
    	  if($.trim(tempp[1]) != 'false')
    	  	$('.stream').html(tempp[1]);
    	  else
    	  	$(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
    	  var sessionlang = $("#languagecode").val();
    	  var translator = $('body').translate({t: dict});
    	  translator.lang(sessionlang);
          //$('.stream').fadeIn("slow","linear");
          sIndex = 21;
          isDataAvailable = true;
          */

           if($.trim(responce) != 'false'){
            // $(".breadCrumb").show();
            $('.stream').html(responce);
           }
    	  	
    	  else{
           $(".breadCrumb").hide();
    	  	$(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn"><?php echo __d('user', 'No products'); ?></h5></div>');
        }
    	  var sessionlang = $("#languagecode").val();
    	  var translator = $('body').translate({t: dict});
    	  translator.lang(sessionlang);
          //$('.stream').fadeIn("slow","linear");
          sIndex = 21;
          isDataAvailable = true;

      }
  });

	});

	function setsort(sortval)
	{
		$("#sortvalue").val(sortval);
		var sessionlang = $("#languagecode").val();
		var translator = $('body').translate({t: dict});
		if(sortval == "new")
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('Sort by: Newest');
		}
		else if(sortval == 'asc')
		{	
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('Sort by: Price - Low to High');
		}
		else if(sortval == 'desc')
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('Sort by: Price - High to Low');
		}
		translator.lang(sessionlang);
		selectedCategory = $('#currentCatPath').val();
		var priceRange;var color;var sortPrice;var categoryId;
		// $("input[name='price']:checked").each( function () {
		// 	priceRange = $(this).val();
		// });
		var price=$(".price_value").html();
		  if(price!="" && price!="0" && price!='5000+'){
      priceRange='0-'+price;
    }
    else{
      priceRange="";
    }
		
		var searchKey=$("#search_text").val();
		//alert(priceRange+"==="+searchKey);
		var spclChars = "!@#$%^&*()"; // specify special characters

	for (var i = 0; i < searchKey.length; i++)
	{
			if (spclChars.indexOf(searchKey.charAt(i)) != -1)
			{
				alert ("Special characters are not allowed.");
				document.getElementById("search_text").value = "";
				return false;
			}
	} 
		$("input[name='color']:checked").each( function () {
			color = $(this).val();
		});
		sortPrice = $("#sortvalue").val();
		if( typeof (priceRange) == 'undefined'){
			priceRange = "";
		}
		if( typeof (color) == 'undefined'){
			color = "";
		}
		if( typeof (sortPrice) == 'undefined'){
			sortPrice = "";
		}

		//var searchKey = $('.search-string').val();
		var baseurl = getBaseURL()+"getItemByCategory";


		categoryId = $("#currentCategory").val();

		if(typeof(categoryId) == 'undefined')
		{
			categoryId = $('#hiddencatvalue').val();
		}

		$.ajax({
			url: baseurl,
			type: "post",
			data: {price : priceRange, color:color, category:selectedCategory, catids:categoryId, sortPrice:sortPrice, q:searchKey},
			dataType: "html",
			beforeSend: function () {
    	  //$('.stream').fadeOut("slow","linear");
    	  //$('.itemLoader').show();
	  //$('.stream').hide();
	},
	success: function(responce){
   // alert(responce);
    	  //$('.itemLoader').hide();
    	  /*
    	  var tempp = responce.split('///');
    	  if($.trim(tempp[1]) != 'false')
    	  	$('.stream').html(tempp[1]);
    	  else
    	  	$(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class"trn">No Products</h5></div>');
    	  var sessionlang = $("#languagecode").val();
    	  var translator = $('body').translate({t: dict});
    	  translator.lang(sessionlang);
          
          sIndex = 21;
          isDataAvailable = true;
          */
          if($.trim(responce) != 'false'){
            // $(".breadCrumb").show();
              $('.stream').html(responce);
          }
    	  
    	  else{
            $(".breadCrumb").hide();
    	  	$(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
        }
	    	var sessionlang = $("#languagecode").val();
	    	var translator = $('body').translate({t: dict});
	    	translator.lang(sessionlang);
	          //$('.stream').fadeIn("slow","linear");
	        sIndex = 21;
	        isDataAvailable = true;
      }
  });
	}

	function setcategory(org)
	{
		//alert("setcategory called");
    $(".shop_menu").removeClass('active');
    $(".shop_menu1").removeClass('active');
    //$(".sub_menu_panel").attr('style','color:#16161F !important')
     $(".shop_menu1").children('h4').attr('style','color:#16161F !important');
		$("#currentCategory").val(org.id);
   // alert(org.id);
    $("#"+org.id).addClass('active');
		selectedCategory = $('#currentCatPath').val();
		var priceRange;var color;var sortPrice;var categoryId;
		// $("input[name='price']:checked").each( function () {
		// 	priceRange = $(this).val();
		// });
		var price=$(".price_value").html();
		  if(price!="" && price!="0" && price!='5000+'){
      priceRange='0-'+price;
    }
    else{
      priceRange="";
    }
		
		var searchKey=$("#search_text").val();
		//alert(priceRange+"==="+searchKey);
		var spclChars = "!@#$%^&*()"; // specify special characters

	for (var i = 0; i < searchKey.length; i++)
	{
			if (spclChars.indexOf(searchKey.charAt(i)) != -1)
			{
				alert ("Special characters are not allowed.");
				document.getElementById("search_text").value = "";
				return false;
			}
	} 
		$("input[name='color']:checked").each( function () {
			color = $(this).val();
		});
		sortPrice = $("#sortvalue").val();
		if( typeof (priceRange) == 'undefined'){
			priceRange = "";
		}
		if( typeof (color) == 'undefined'){
			color = "";
		}
		if( typeof (sortPrice) == 'undefined'){
			sortPrice = "";
		}

		//var searchKey = $('.search-string').val();
		var baseurl = getBaseURL()+"getItemByCategory";


		categoryId = $("#currentCategory").val();

		if(typeof(categoryId) == 'undefined')
		{
			categoryId = $('#hiddencatvalue').val();
		}

		$.ajax({
			url: baseurl,
			type: "post",
			data: {price : priceRange, color:color, category:selectedCategory, catids:categoryId, sortPrice:sortPrice, q:searchKey},
			dataType: "html",
			beforeSend: function () {
    	  //$('.stream').fadeOut("slow","linear");
    	  //$('.itemLoader').show();
	  //$('.stream').hide();
	},
	success: function(responce){
		//console.log(responce);
		//alert(responce);
		if($.trim(responce) == "")
		{
      $(".breadCrumb").hide();
			$('.stream').html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
		}else if($.trim(responce) != 'false')
    	{
       // $(".breadCrumb").show();
    	  	$('.stream').html(responce);
    	}else{
        $(".breadCrumb").hide();
          $(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
      }
    	  
    	  	var sessionlang = $("#languagecode").val();
    	  	var translator = $('body').translate({t: dict});
    	  	translator.lang(sessionlang);
          	//$('.stream').fadeIn("slow","linear");
          	sIndex = 20;
          	isDataAvailable = true;

		/*
		var tempp = responce.split('///');
		$('#catname').html(tempp[0]);
		  $('#changecatname').html(tempp[0]);
    	
    	  if($.trim(tempp[1]) == "")
    	  {
    	  	$('.stream').html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
    	  }

    	  else if($.trim(tempp[1]) != 'false')
    	  {

    	  	$('.stream').html(tempp[1]);
    	  }
    	  else
    	  	$(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
    	  var sessionlang = $("#languagecode").val();
    	  var translator = $('body').translate({t: dict});
    	  translator.lang(sessionlang);
          //$('.stream').fadeIn("slow","linear");
          sIndex = 21;
          isDataAvailable = true;
          */
      }
  });
	}

	function searchstring()
	{
		$('#search-string').focus();
		selectedCategory = $('#currentCatPath').val();
		var priceRange;var color;var sortPrice;var categoryId;
		var price=$(".price_value").html();
		if(price!="" && price!="0" && price!='5000+'){
			priceRange='0-'+price;
		}
		else{
			priceRange="";
		}
		
		var searchKey=$("#search_text").val();
		//alert(priceRange+"==="+searchKey);
		var spclChars = "!@#$%^&*()"; // specify special characters

	for (var i = 0; i < searchKey.length; i++)
	{
			if (spclChars.indexOf(searchKey.charAt(i)) != -1)
			{
				alert ("Special characters are not allowed.");
				document.getElementById("search_text").value = "";
				return false;
			}
	} 
		//return false;
		// $("input[name='price']:checked").each( function () {
		// 	priceRange = $(this).val();
		// });

		//alert(priceRange);

		$("input[name='color']:checked").each( function () {
			color = $(this).val();
		});
		sortPrice = $("#sortvalue").val();
		if( typeof (priceRange) == 'undefined'){
			priceRange = "";
		}
		if( typeof (color) == 'undefined'){
			color = "";
		}
		if( typeof (sortPrice) == 'undefined'){
			sortPrice = "";
		}

		//var searchKey = $('.search-string').val();
		// if(searchKey.length<3 && searchKey.length>0){
		// 	return false;
		// }
		var baseurl = getBaseURL()+"getItemByCategory";
	

categoryId = $("#currentCategory").val();

if(typeof(categoryId) == 'undefined')
{
	categoryId = $('#hiddencatvalue').val();
}
isPreviousEventComplete=true;
sIndex = 20; 
offSet = 20;
isDataAvailable=true;
$.ajax({
	url: baseurl,
	type: "post",
	data: {price : priceRange, color:color, category:selectedCategory, catids:categoryId, sortPrice:sortPrice, q:searchKey},
	dataType: "html",
	beforeSend: function () {
    	  //$('.stream').fadeOut("slow","linear");
    	  //$('.itemLoader').show();
	  //$('.stream').hide();
	},
	success: function(responce){
		//alert(responce);
    	  //$('.itemLoader').hide();
    	  //alert('loader');
    	  /*
    	  var tempp = responce.split('///');
    	  if($.trim(tempp[1]) == "")
    	  {
    	  	$('.stream').html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
    	  }

    	  else if($.trim(tempp[1]) != 'false')
    	  {

    	  	$('.stream').html(tempp[1]);
    	  }
    	  else
    	  	$(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
    	  var sessionlang = $("#languagecode").val();
    	  var translator = $('body').translate({t: dict});
    	  translator.lang(sessionlang);
          //$('.stream').fadeIn("slow","linear");
          sIndex = 21;
          isDataAvailable = true;
          */
          if($.trim(responce) == "" || $.trim(responce) == 'false')
		{
      $(".breadCrumb").hide();
			$('.stream').html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
		}else if($.trim(responce) != 'false')
    	{
    		//alert(responce);
      //  $(".breadCrumb").show();
    	  	$('.stream').html(responce);
    	  }
    	// else{

    	// }
    	//   	$(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
	    // 	var sessionlang = $("#languagecode").val();
	    // 	var translator = $('body').translate({t: dict});
	    // 	translator.lang(sessionlang);
	    //       //$('.stream').fadeIn("slow","linear");
	    //     sIndex = 21;
	    //     isDataAvailable = true;



      }
  });
}
</script>
<script>
    $(window).on("load", function () {
      $('.postcommentloader').show();
       var rangeval = $("#range").val();
       var min=$("#range").attr('min');
       var max=$("#range").attr('max');
     
        var value = (rangeval-min)/(max-min)*100;
          console.log(min+"=="+max+"value="+value);
  document.getElementById("range").style.background = 'linear-gradient(to right, #1B33B7 0%, #1B33B7 ' + value + '%, #cdcdcd ' + value + '%, #cdcdcd 100%)';
  $('.postcommentloader').hide();
      $(".priceSlider").show();
      $("#value").show();
     //  var range = $("#range").attr("value");
     
     // if(range=='5000'){
     //   $("#value").html(range+'+');
     // }
     // else{
     //   $("#value").html(range);
     // }
     //  //alert(range);
     //  if(range==""){
     //  	  $(".slide").css("width", "100%");
     //  }
     //  else{

     //  	 var slideWidth = range * 100 / 5000;
     //  	 console.log(slideWidth);
     //    $(".slide").css("width", slideWidth + "%");
     //  }
    

      $(document).on('input change', '#range', function () {
      	
        if($(this).val()=='5000'){
          $('#value').html($(this).val()+'+');
     }
     else{
       $('#value').html($(this).val());
     }
        var slideWidth = $(this).val() * 100 / 5000;

        $(".slide").css("width", slideWidth + "%");
      });
    });

  </script>

 
<style type="text/css">
.checkbox input[type="checkbox"]
{
	left: 45px;
	width: 120px;
}
.shop_menu1.active{
  color: #1b33b7 !important;
}
.list_menu1{
  max-height: 150px;
    overflow-y: auto;
}
@media(min-width:767px) {
.custom_height{
  min-height:780px;
}
}
.postcommentloader{
  display: flex;
    justify-content: center;
}
/*.price_range #range {
  background: linear-gradient(to right, #cdcdcd 0%, #cdcdcd 50%, #cdcdcd 50%, #cdcdcd 100%);
}*/
</style>
<script type="text/javascript">

  $(".highlight").on('click', function () {
       // alert("highlight");
            $(".shop_menu1").children('h4').attr('style','color:#16161F !important');
              $(".shop_menu1").removeClass('active');
    $(".shop_menu").removeClass('active');
        $(this).children('h4').attr('style','color:#1b33b7 !important');
    $(this).addClass('active');

    });
   
   

    //   $(document).scroll(function () {
    //       console.log("scroll called");
    //   //       var elmnt = document.getElementById("content");
    //   // var x = elmnt.scrollHeight;
    //   var x = $('#content')[0].scrollHeight;
    //   //  var x = $('.allImg').height();
    //   var y = $('.category').height();
    //   console.log("x="+x+"y="+y);
    //   if (x > y) {

    //     if ($('.category').offset().top + $('.category').height() >= $('footer').offset().top - 10) {
    //       console.log("static");
    //       $('.category').css('position', 'static');
    //       $('.category').css('max-width', '100%');
    //     }

    //     if ($(document).scrollTop() + window.innerHeight < $('footer').offset().top) {
    //         console.log("fixed");
    //       $('.category').css('position', 'fixed');
    //       $('.category').css('max-width', '20%');
    //     }

    //   }
    //   else{
    //     console.log("called");
    //      $('.category').css('position', 'static');
    //        $('.category').css('max-width', '100%');
    //         $('.category').css('min-height', '100%');
    //   }
    // });
    $(".checkbox").click(function () {
      console.log("checkbox scroll");
      // $(document).scroll(function () {
      //   //  alert(x)
      //   //  alert(y)
      //   var x = $('#content')[0].scrollHeight;
      //   var y = $('.category').height();

      //   if (x > y) {

      //     if ($('.category').offset().top + $('.category').height() >= $('footer').offset().top - 10) {
      //       $('.category').css('position', 'static');
      //       $('.category').css('max-width', '100%');
      //     }

      //     if ($(document).scrollTop() + window.innerHeight < $('footer').offset().top) {
      //       $('.category').css('position', 'fixed');
      //       $('.category').css('max-width', '20%');
      //     }

      //   }
      // });
    })
    document.getElementById("range").oninput = function() {
  var value = (this.value-this.min)/(this.max-this.min)*100
  this.style.background = 'linear-gradient(to right, #1B33B7 0%, #1B33B7 ' + value + '%, #cdcdcd ' + value + '%, #cdcdcd 100%)'
  
};
</script>
