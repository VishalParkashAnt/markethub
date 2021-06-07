<?php namespace Cake\I18n;
use Cake\I18n\Time;?>
	<section class="container-fluid side-collapse-container margin-top20">
		<div class="container">
			<section class="popular-pdt-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!--Breadcrumb-->
				<section class="container breadcrumb margin-top10 col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="breadcrumb-cnt">
						<a href="<?php echo SITE_URL; ?>"><?php echo __d('user','Home'); ?></a>
						<span class="breadcrumb-divider fa fa-angle-right"></span>
						<a href="javascript:void(0);">
							<?php echo __d('user','Affiliate Products'); ?>
						</a>
					</div>
				</section>
				<div class="d-flex affiliated">
				<h2 class="section_heading bold-font centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom5 padding-top10">
				<?php echo __d('user','Affiliate Products'); ?>
				</h2>

				<div class="drope_down" >
            <ul class="">
              <li class="dropdown"><button
                  class="dropdown-toggle padding-left10 padding-right10 text_grey shop_sortby_button"
                  data-toggle="dropdown" href="javascript:void(0)" aria-expanded="false"><span
                    class="pull-left sorttxt trn"><?php echo __d('user','Choose Commission'); ?></span>&nbsp;&nbsp;<i
                    class="fa fa-angle-down padding-top3 padding_rght_10_mobletab pull-right"></i></button>
                <ul class="dropdown-menu popualrity_sort_menu">
                	<li><a href="javascript:void(0);" onclick="setsort('0');">
						<?php echo __d('user', 'Choose Commission'); ?>
					</a></li>
                  	<li><a href="javascript:void(0);" onclick="setsort('1-10');">
						<?php echo __d('user', '1% - 10%'); ?>
					</a></li>
					<li><a href="javascript:void(0);" onclick="setsort('11-20');">
						<?php echo __d('user', '11% - 20%'); ?>
					</a></li>
					<li><a href="javascript:void(0);" onclick="setsort('21-30');">
						<?php echo __d('user', '21% - 30%'); ?>
					</a></li>
					<li><a href="javascript:void(0);" onclick="setsort('31-40');">
						<?php echo __d('user', '31% - 40%'); ?>
					</a></li>
					<li><a href="javascript:void(0);" onclick="setsort('41-50');">
						<?php echo __d('user', '41% - 50%'); ?>
					</a></li>
					<li><a href="javascript:void(0);" onclick="setsort('51-60');">
						<?php echo __d('user', '51% - 60%'); ?>
					</a></li>
					<li><a href="javascript:void(0);" onclick="setsort('61-70');">
						<?php echo __d('user', '61% - 70%'); ?>
					</a></li>
					<li><a href="javascript:void(0);" onclick="setsort('71-80');">
						<?php echo __d('user', '71% - 80%'); ?>
					</a></li>
					<li><a href="javascript:void(0);" onclick="setsort('81-90');">
						<?php echo __d('user', '81% - 90%'); ?>
					</a></li>
					<li><a href="javascript:void(0);" onclick="setsort('91-100');">
						<?php echo __d('user', '91% - 100%'); ?>
					</a></li>
                </ul>
                <input type="hidden" id="sortvalue" value="0">
              </li>
            </ul>

          </div>
				</div>
				<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom10">
					<span class="primary-color-txt font-size12">
						<?php
							if($countitemModel > 0 && $countitemModel == 1) {
								echo $countitemModel." ".__d('user','product');
							} else {
								//echo $countitemModel." ".__d('user','products');
							}
						?>
					</span>
				</div>


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
				if ($viewType == 'dailydeals'){
					if($countitemModel > 0 && $countitemModel == 1) {
					echo '<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom20"><div class="timer-cnt"><img src="'.SITE_URL.'images/icons/timer.png"><span class="time bold-font " id="timer"> Left</span></div></div>';
				}
				}
				?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding stream">
				<?php
				if(count($items_data)>0){
foreach($items_data as $itms)
{

	//echo $itms['dealdate']; 
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
				echo '<span id="price_vals'.$itms['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_price.'" ></span>';
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
				echo '<input type="hidden" id="likebtncnt" value="'.$setngs['like_btn_cmnt'].'" />';
				echo '<input type="hidden" id="likedbtncnt" value="'.$setngs['liked_btn_cmnt'].'" />';
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

	echo '<div class="item1 box_shadow_img"><div class="product_cnt box_shadow_img col-lg-3 col-md-6 col-sm-6 col-xs-12 margin-bottom20 newdproduct">
		<a class="img-hover" href="'.SITE_URL.'listing/'.$itemid.'">
			<img src="'.$itemimage.'" class="img-responsive" />		</a>
			<div class="hover-visible">
				<span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou('.$itms['id'].')">
								';
								
					if(count($likeditemid)!=0 &&  in_array($itms['id'],$likeditemid)){
							/*echo 	'<i class="fa fa-heart like-icon'.$itms['id'].'" id="like-icon'.$itms['id'].'"></i>*/
	echo '<img src="'.SITE_URL.'img/Heart filled@2x.png" id="like-icon'.$itms['id'].'" class="like-icon'.$itms['id'].'">						
								<span class="like-txt'.$itms['id'].' nodisply" id="like-txt'.$itms['id'].'" >Fantacies</span>';}
								else
								{
				/*echo 	'<i class="fa fa-heart-o like-icon'.$itms['id'].'" id="like-icon'.$itms['id'].'"></i>*/
echo '<img src="'.SITE_URL.'img/like.png" id="like-icon'.$itms['id'].'" class="like-icon'.$itms['id'].'">											<span class="like-txt'.$itms['id'].' nodisply" id="like-txt'.$itms['id'].'" >'.$setngs['like_btn_cmnt'].'</span>';
								}
				echo '</span>
				<span class="hover-icon-cnt share_hover" href="javascript:void(0)" onclick="share_posts('.$itms['id'].');" data-toggle="'.$temp.'" data-target="'.$temp1.'"><img src="'.SITE_URL.'images/icons/share_icon.png"></span>
			</div>


		<div class="rate_section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="product_name bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="">'.substr($itms['item_title'],0,75 ).'</a><br/><div class="d-flex justify-content-between align-items-center w-100">';




				$date = date('d');
					$month = date('m');
					$year = date('Y');
					$tdy = strtotime($month . '/' . $date . '/' . $year);
					//$newdate = strtotime($itms['dealdate']);
					$newdate = strtotime(date('Y-m-d',strtotime($itms['dealdate'])));
					//echo '<br/>'.$itms['discount_type'];
					//$newdate = $itms['dealdate'];
					//$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
					$newdate = new Time($itms['dealdate']);
					$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
					//echo '<br/>'.$itms['dealdate'];
					//echo 'dd'.$newdate.'-'.strtotime(date('Y-m-d'));
					$dealstrtime = strtotime(date('Y-m-d',$dealdate));
					$todaystrtime = strtotime(date('Y-m-d',$tdy));
				 	if($itms['discount_type'] =='daily' && $dealstrtime == $todaystrtime){
				 		
			echo '<div class="price">';

			
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
			
echo '</div>';}
elseif($itms['discount_type'] =='regular'){
echo '<div class="price">';

			
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
					
				if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo '<strike class="bold-font">'.$_SESSION['currency_symbol'].' '.$user_currency_price.'</strike>';
				}
					else{?>&#x200E;<?php
				echo '<strike class="bold-font">'.$itms['forexrate']['currency_symbol'].' '.$itemprice.'</strike>';
			}
			
echo '</div>';
}else
{
	
	echo '<div class="price">';

	if(isset($_SESSION['currency_code'])){?>&#x200E;<?php
					echo $_SESSION['currency_symbol'].' '.$user_currency_price;
				}
					else{?>&#x200E;<?php
					echo $itms['forexrate']['currency_symbol'].' '.$itemprice;}
				
				echo '</div>';
}
echo '<div class="percentage_tag">'.$itms['affiliate_commission'].' % </div></div>';
				
			echo '</div>
		</div>
	</div>';
}
}
else
{
		echo '<div class="text-center padding-top30 padding-bottom30">
	 <div class="outer_no_div">
	  <div class="empty-icon no_products_icon"></div>
	 </div>
	 <h5>'.__d('user','No Products').'</h5>
	</div>';
}
?>



				</div>

			</section>
		</div>
	</section>
<?php
if(isset($loguser['id']))
	echo '<input type="hidden" id="loguserid" value="'.$loguser['id'].'">';
else
	echo '<input type="hidden" id="loguserid" value="0">';
?>

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
						<?php echo __d('user','SHARE THIS THING');?></h2>
					<div class="popup-heading-border"></div>
				</div>
				<div class="share-cnt-row">
					<div class="share-details-cnt margin-top30">

					<?php
						echo '<div class="share-details">
							<div class="share-img margin-right20"><img id="share_img" class="img-responsive" src=""></div>
							<div class="share-details-txt">
								<div class="bold-font" id="share_title"></div>
								<div class="">'.__d('user','By').' <span id="share_username"></span></div>
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
	var sIndex = 20, offSet = 20, isPreviousEventComplete = true, isDataAvailable = true;
	var baseurl = getBaseURL();

$(window).scroll(function () {
 //if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
	if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.5) {
		
  if (isPreviousEventComplete && isDataAvailable) {

    isPreviousEventComplete = false;
    $(".LoaderImage").css("display", "block");
   	var sortCommission=$("#sortvalue").val();
    $.ajax({
      type: "GET",
       url: baseurl+'getitembycommission?offset=' + sIndex + '&limit=' + offSet+ '&sortCommission=' + sortCommission,
      beforeSend: function () {
			$('#infscr-loading').show();
		},
	  dataType: 'html',
      success: function (result) {

      	//alert(result);
		
      	$('#infscr-loading').hide();
      	var out = result.toString();
	      	if($.trim(out)=='false')
	      	$(window).unbind('scroll');
	      	else if ($.trim(out) != 'false') {//When data is not available
        	$(".stream").append(result);
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

function setsort(sortval)
	{
		$("#sortvalue").val(sortval);
		var sessionlang = $("#languagecode").val();
		var translator = $('body').translate({t: dict});
		if(sortval == "0")
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('Choose Commission');
		}
		if(sortval == "1-10")
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('1% - 10%');
		}
		else if(sortval == '11-20')
		{	
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('11% - 20%');
		}
		else if(sortval == '21-30')
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('21% - 30%');
		}
		else if(sortval == '31-40')
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('31% - 40%');
		}
		else if(sortval == '41-50')
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('41% - 50%');
		}
		else if(sortval == '51-60')
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('51% - 60%');
		}
		else if(sortval == '61-70')
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('61% - 70%');
		}
		else if(sortval == '71-80')
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('71% - 80%');
		}
		else if(sortval == '81-90')
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('81% - 90%');
		}
		else if(sortval == '91-100')
		{
			$(".sorttxt").removeAttr("data-trn-key");
			$(".sorttxt").html('91% - 100%');
		}

		translator.lang(sessionlang);
		
		var sortPrice;
		
		sortCommission = $("#sortvalue").val();
		
		if( typeof (sortCommission) == 'undefined'){
			sortCommission = "";
		}

		
		var baseurl = getBaseURL()+"getitembycommission";

		$.ajax({
			url: baseurl,
			type: "post",
			data: {sortCommission:sortCommission},
			dataType: "html",
			beforeSend: function () {
			},
			success: function(responce){
    	 
          if($.trim(responce) != 'false')
    	  	$('.stream').html(responce);
    	  else
    	  	$(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
	    	var sessionlang = $("#languagecode").val();
	    	var translator = $('body').translate({t: dict});
	    	translator.lang(sessionlang);
	          
	        sIndex = 21;
	        isDataAvailable = true;
      }
  });
	}

</script>
<style type="text/css">
	@media(min-width:767px) {
	.drope_down{
	width:200px!important;
	}
}
</style>