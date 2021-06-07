<?php namespace Cake\I18n;
use Cake\I18n\Time;?>
	<section class="container-fluid side-collapse-container margin-top20">
		<div class="container">
			<section class="popular-pdt-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!--Breadcrumb-->
				<section class="container breadcrumb margin-top10 col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="breadcrumb-cnt">
						<a href="<?php echo SITE_URL; ?>">Home</a>
						<span class="breadcrumb-divider fa fa-angle-right"></span>
						<a href="javascript:void(0);">
							<?php
								echo 'Popular stores';
							?>
						</a>
					</div>
				</section>
				<h2 class="section_heading bold-font centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-bottom5 padding-top10">
				<?php
					echo __d('user','Popular stores');
				?>
				</h2>
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

				<div class="row">

				<?php
							$store = 1;
							foreach($popularstores as $storeKey=>$storeModel)
							{
								$shop_url = SITE_URL . 'stores/' . $storeModel['shop_name_url'];
								//echo '<pre>'; print_r($storeModel); die;
						?>
							


							<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
				<div class="item<?php echo $store; ?> box_shadow_img ">
								<div class="product_cnt clearfix">
									<a class="products-hovers" id="shop_url<?php echo $storeModel['store_id']; ?>" href="<?php echo $shop_url; ?>">
										<div class="store_imgs">
											<img src="<?php echo $storeModel['image']; ?>" class=" img-responsive" id="store_img_<?php echo $storeModel['store_id']; ?>"">
										</div>
									</a>
									<div class="hover-visible">
										<span class="hover-icon-cnt share_hover" href="javascript:void(0)"
											onclick="share_store(<?php echo $storeModel['store_id']; ?>);"><img
												src="https://fantacyscript.com/images/icons/share_icon.png"></span>
									</div>

									<div class="just_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="#">
												<span id="store_names_<?php echo $storeModel['store_id']; ?>"><?php echo $storeModel['store_name']; ?> </span> </a>
											<div id="merchant_name_<?php echo $storeModel['store_id']; ?>" class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<?php echo $storeModel['merchant_name']; ?>  </div>
		
										</div>
								</div>

							</div>


				</div>
							<?php 
							$store++;
							} 
							?>
					</div>
				

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
	var viewmoretype = '<?php echo $viewType; ?>';
	var baseurl = getBaseURL();

$(window).scroll(function () {
 //if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
	if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.5) {
		
  if (isPreviousEventComplete && isDataAvailable) {

    isPreviousEventComplete = false;
    $(".LoaderImage").css("display", "block");

    $.ajax({
      type: "GET",
      url: baseurl+'getviewmore?startIndex=' + sIndex + '&offset=' + offSet + '&viewmoretype='+viewmoretype,
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
</script>