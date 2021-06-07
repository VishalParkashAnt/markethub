<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
		<section class="container product-page-cnt">
			<div class="prod-cnt col-xs-12 col-sm-12 col-lg-12 no-hor-padding">
				<div class="col-xs-12 col-sm-6 no-hor-padding">
					<div class="product-slider-cnt item-slider">
						<div id="carousel" class="carousel slide product-slider" data-ride="carousel" data-interval="false">
							<div class="carousel-inner">
							<?php
							$j = 0;
							foreach($photos as $photo)
							{
								if($j==0)
								echo '<div class="item active thumb-image">';
								else
								echo '<div class="item">';
								echo '<img src="'.$baseurl.'media/items/original/'.$photo['image_name'].'" data-imagezoom="true">
								</div>';
								$j++;
							}
							?>
							</div>
						</div>
						<div class="clearfix">
							<div id="thumbcarousel" class="carousel slide product-thumb-slider" data-interval="false">
								<div class="carousel-inner">
									<div class="item active">
									<?php
									$k = 0;
									foreach($photos as $photo)
									{
										echo '<div data-target="#carousel" data-slide-to="'.$k.'" class="thumb"><img src="'.$baseurl.'media/items/original/'.$photo['image_name'].'"></div>';
										$k++;
									}
									?>


									</div><!-- /item -->
								</div><!-- /carousel-inner -->
								<a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								</a>
								<a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
									<i class="fa fa-angle-right"></i>
								</a>
							</div> <!-- /thumbcarousel -->
						</div><!-- /clearfix -->
					</div>
				</div> <!-- /col-sm-6 -->
				<div class="col-xs-12 col-sm-6 no-hor-padding">
					<div class="prod-detail-cnt col-xs-12 col-sm-12 no-hor-padding">
						<div class="prod-detail-row col-xs-12 col-sm-12 no-hor-padding">
							<h2 class="prod-name bold-font">
							<?php echo $item_datas['item_title'];?>
							</h2>
							<h1 class="prod-cost bold-font margin-top10">
							$
							<?php
							echo $item_datas['price'];
							?></h1>
							<div class="prod-qty margin-top15">Quantity only <?php echo $item_datas['quantity'];?> available</div>
							<input type="hidden" value="<?php echo $item_datas['quantity'];?>" id="quantity_val">
						</div>

						<div class="prod-detail-row col-xs-12 col-sm-12 no-hor-padding">
							<div class="col-xs-12 col-sm-12 no-hor-padding margin-bottom20">
						<?php
						$sizes = json_decode($item_datas['size_options'],true);
						if(!empty($sizes))
						{
						?>
								 <div class="site-dd size-dd dropdown col-xs-12 col-sm-4 no-hor-padding">

									  <!--span class="fa fa-angle-down pull-right"></span-->
									  <select class="dropdown-toggle">
										<option>7</option>
										<option>8</option>
										<option>9</option>
									  </select>
								</div>
						<?php
						}
						?>
								
							</div>
							<div class="col-xs-12 col-sm-12 no-hor-padding">Recipient</div>
						<div class="sold-by-info col-xs-12 col-sm-12 no-hor-padding margin-top15">
							<div class="sold-by-prof-pic-cnt">
								<div class="sold-by-prof-pic"></div>
							</div>
							<div class="sold-by-prof-detail">
								<div class="bold-font"><?php echo '<br>Recipient :';
echo wordwrap($items_list_data['name'],25,"<br>\n",TRUE);
$lday=date("F j, Y ",$items_list_data['c_date']);
echo $lday; ?></div>
								<div class="margin-top10"><a href="" data-toggle="modal" data-target="#seller-review-modal" class="red-label">4.2</a><span class="rating"><h2>Recipient Address: </h2>
						<?php echo $items_list_data['address1']; ?>, 
						<?php echo $items_list_data['address2']; ?><br>
						<?php echo $items_list_data['city']; ?>, 
						<?php echo $items_list_data['state']; ?><br>
						<?php echo $countrys_list_data['country']; ?></span></div>
								
							</div>
						</div>
							
							</div>
						</div>
					
					</div>
				</div>
			  </div>
			  <div class="prod-desc-cnt col-xs-12 col-lg-12">
				<div class="col-xs-12 col-sm-12 no-hor-padding">
					<div class="bold-font desc-heading">Description:</div>
					
				</div>
				<div class="col-xs-12 col-sm-12 no-hor-padding comment more margin-top20">
					<?php echo $item_datas['description']; ?>
				</div>
			  </div>
			  <div class="product-page-row col-xs-12 col-sm-12 no-hor-padding margin-top20">
				
				
			  </div>
			 
					
				  <a class="left carousel-control" href="#popularCarousel" data-slide="prev"><i class="fa  fa-angle-left"></i></a>
				  <a class="right carousel-control" href="#popularCarousel" data-slide="next"><i class="fa  fa-angle-right"></i></a>
				</div>
			  <!-- end Bottom to top-->
			</div>
		</div>
	</section>

	<script type="text/javascript">
	$(".button").on("click", function() {

  var $button = $(this);
  var oldValue = $("#qty-counter").html();
  var quantity = $("#quantity_val").val();
  if ($button.text() == "+") {
  		if(oldValue < parseFloat(quantity))
	  var newVal = parseFloat(oldValue) + 1;

	} else {
   // Don't allow decrementing below zero
    if (oldValue > 1) {
      var newVal = parseFloat(oldValue) - 1;
    } else {
      newVal = 1;
    }
  }

  $("#qty-counter").html(newVal);

});
	</script>
<style type="text/css">
.site-dd select {
    background-color: transparent;
    border: 1px solid #dbdbdd;
    padding: 12px;
    text-align: left;
    width: 100%;
}
</style>