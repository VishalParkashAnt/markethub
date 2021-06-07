          	<?php
          	if(count($shopsdet)>0)
          	{
					foreach ($shopsdet as $shopdatas){
							$shop_name = $shopdatas['shop_name'];
							$shop_name_url = $shopdatas['shop_name_url'];
							$shop_img = $shopdatas['shop_image'];
							$merchant_name = $shopdatas['merchant_name'];
							$item_count = $shopdatas['item_count'];
							$shop_id = $shopdatas['id'];
							$shop_user_id = $shopdatas['user_id'];
							$follow_count = $shopdatas['follow_count'];
							$follow_shop = $shopdatas['follow_shop'];
										echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20">
											<div class="favourite_store">

											</div>
												<div class="user_favourite_image1 margin_top_40min">
														<div class="user_favourite_image"></div>
													</div>
											<div class="user_favourite">
												<h4 class="margin-bottom0 extra_text_hide">'.$shop_name.'</h4>
												<p class="profile_text margin-bottom20 extra_text_hide">By '.$merchant_name.'</p>';
            foreach($followcnt as $flcnt){
            	$flwrcntid[] = $flcnt['store_id'];
            }

			if($shop_id != $loguser['id']){
            	if(in_array($shop_id,$flwrcntid)  && isset($loguser['id']) ){
            		$flw = false;
            	}else{
            		$flw = true;
            	}
            	if($flw)
            	{
				echo '<span id="folls'.$shop_id.'"><div class="user_followers_butn btn">
				<a href="javascript:void(0);" onclick="getshopfollows('.$shop_id.')">Follow Store</a></div></span>';
            	}
            	else
            	{
			echo '<span id="unfolls'.$shop_id.'"><div class="btn user_unfollowers">
			<a href="javascript:void(0);" onclick="deleteshopfollows('.$shop_id.')">Unfollow Store</a></div></span>';
			}
	echo '<span id="changebtnn'.$shop_id.'" ></span>';
	}
											echo '</div>
										</div>';
										}
			}
			else
			{
			echo 'false';
			}
										?>