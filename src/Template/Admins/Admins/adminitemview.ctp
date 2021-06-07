<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<section class="container">
	<div class="prod-cnt col-xs-12 col-sm-12 col-lg-12 no-hor-padding">
		<div class="col-xs-12 col-sm-6 no-hor-padding">
			<div class="product-slider-cnt item-slider">
				<div id="carousel" class="carousel slide product-slider" data-ride="carousel" data-interval="false">
					<div class="carousel-inner">
						<?php
						$j = 0;
						if(count($photos)>0)
						{
							foreach($photos as $photo)
							{
								$item_image = $photo['image_name'];
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

								if($j==0)
									echo '<div class="item active thumb-image">';
								else
									echo '<div class="item">';
								echo '<img src="'.$itemimage.'" data-imagezoom="true">
							</div>';
							$j++;
						}
					}
					else
					{
						$itemimage = SITE_URL.'media/items/original/usrimg.jpg';
						echo '<div class="item active thumb-image">';
						echo '<img src="'.$itemimage.'" data-imagezoom="true">
					</div>';
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
						if(count($photos)>0)
						{
							foreach($photos as $photo)
							{
								$item_image = $photo['image_name'];
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

								echo '<div data-target="#carousel" data-slide-to="'.$k.'" class="thumb"><img src="'.$itemimage.'"></div>';
								$k++;
							}
						}
						else
						{
							$itemimage = SITE_URL.'media/items/original/usrimg.jpg';
							echo '<div data-target="#carousel" data-slide-to="'.$k.'" class="thumb"><img src="'.$itemimage.'"></div>';
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
			</h2><br>
			
			
			<?php
			$sizes = $item_datas['size_options'];
			$size_option = json_decode($sizes, true);
			$size_val = array();
			if(count($size_option['size']) > 0) { ?>
			<span class="input-number m-l-10 viewOpt">
				<label for="quantity" style="font-size: 14px; font-weight: 500;"><?php echo __d('merchant','Available Sizes'); ?> : </label>
				<?php
				foreach($size_option['size'] as $key=>$val)
				{
					$size_val[] = $val;
				}
				$count = count($size_val);
				for($i=0;$i<$count;$i++)
				{
					if($i == 0)
						echo $size_val[$i];
					else
						echo ", ".$size_val[$i];
				} ?>
			</span>
			<?php  }
			else
				{ ?>
			<h1 class="prod-cost bold-font margin-top10">
				$
				<?php  	echo $item_datas['price']; ?>
				<?php  }
				
				?> </h1>
				<div class="prod-qty margin-top15"><?php echo __d('admin', 'Quantity only '); ?><?php echo $item_datas['quantity'];?> <?php echo __d('admin', 'available'); ?></div>
				<input type="hidden" value="<?php echo $item_datas['quantity'];?>" id="quantity_val">
			</div>

			<div class="prod-detail-row col-xs-12 col-sm-12 no-hor-padding">
				<div class="prod-qty margin-top15">
					<div class="like-counter-cnt">
						<a href="javascript:void(0);" class="like-cnt primary-color-txt"><i class="fa fa-heart-o like-icon"></i><span class="like-txt"><?php echo __d('admin', 'Likes'); ?></span></a>
						<a href="javascript:void(0);" class="like-counter arrow_box"><?php if($item_datas['fav_count'] != 0)
							{
								echo $item_datas['fav_count'];
							}
							else
								{ echo 0; }
							?></a>
						</div>
					</div>



					<input type="hidden" value="<?php echo $item_datas['quantity'];?>" id="quantity_val">
				</div>

				<div class="prod-detail-row col-xs-12 col-sm-12 no-hor-padding">
					<div class="col-xs-12 col-sm-12 no-hor-padding margin-bottom20">
						<?php
						$sizes = json_decode($item_datas['size_options'],true);

						?>

					</div>
					<div class="col-xs-12 col-sm-12 no-hor-padding"><?php echo __d('admin', 'Sold By'); ?></div>
					<div class="sold-by-info col-xs-12 col-sm-12 no-hor-padding margin-top15">
						<div class="sold-by-prof-pic-cnt">
							<?php
							$userprofileimage = $users['profile_image'];
							if($userprofileimage=="")
								$userprofileimage = "usrimg.jpg";
							else
								$userprofileimage = $users['profile_image'];
							/* latest fixes 4.1 */
							echo '<a href="'.SITE_URL.'stores/'.$item_datas['shop']['shop_name_url'].'">';
							echo '<div class="sold-by-prof-pic" style="background-image:url('.SITE_URL.'media/avatars/thumb70/'.$userprofileimage.');background-repeat:no-repeat;"></div>';
							echo '</a>';
							/* latest fixes 4.1 */
							?>
						</div>
						<div class="sold-by-prof-detail">
							<div class="bold-font"><a href="<?php echo SITE_URL.'stores/'.$item_datas['shop']['shop_name_url']?>"><?php echo $users['first_name'];?></a></div>
							<div class="prod-qty margin-top15">
								<div class="margin-top10"><a href="javascript:void(0);" class="red-label"><?php
									if($users['seller_ratings'] != 0)
									{
										echo $users['seller_ratings'];
									}
									else
										{ echo 0; }
									?></a><span class="rating"><?php echo __d('admin', 'Ratings'); ?></span></div>
								</div>

							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="prod-cnt col-xs-12 col-lg-12">
		<div class="col-xs-12 col-sm-12 no-hor-padding">
			<br>
			<div class="bold-font desc-heading"><?php echo __d('admin', 'Description:'); ?></div>

		</div>
		<div class="col-xs-12 col-sm-12 no-hor-padding comment more margin-top20">
			<?php echo $item_datas['item_description']; ?>

		</div>
	</div>
	<div class="prod-desc-cnt col-xs-12 col-lg-12">
		<div class="col-xs-12 col-sm-12 no-hor-padding">
			<div class="bold-font desc-heading"><?php echo __d('admin', 'Comments:'); ?></div>
		</div>
		<div class="col-xs-12 col-sm-12 no-hor-padding comment more margin-top20">
			<?php
			foreach ($comments as $cmt) {
								//	print_r($cmt);
				echo $cmt->comments;
				echo '<br>';
			} ?>
		</div>
	</div>

	<div class="product-page-row col-xs-12 col-sm-12 no-hor-padding margin-top20">


	</div>


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
