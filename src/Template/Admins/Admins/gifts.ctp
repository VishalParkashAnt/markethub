<?php use Cake\Routing\Router;
$baseurl = Router::url('/');

							$totContri = 0;
							if(count($ggAmtDatas)>0){	
							
							
							
								foreach($ggAmtDatas as $ggdata){	
								
									 echo $ggdata['User']['first_name'];
									
									 $lday=date("F j, Y ",$ggdata['cdate']); 
									 echo $lday; 
									echo $currencysymbol.$ggdata['amount']; 
								
								
								$totContri = $totContri+ $ggdata['amount'];
									} 
						
									
							}
								
							
						
				
					
			
				
				$cost = $items_list_data['total_amt'];
				
				$remainContri = $cost - $totContri;
				echo '<input type="hidden" id="lastestidggs" value="'.$items_list_data['id'].'" />';
				echo '<input type="hidden" id="costforitem" value="'.$cost.'" />';
				echo '<input type="hidden" id="itemidval" value="'.$item_datas['id'].'" />';
				echo '<input type="hidden" id="totalContribution" value="'.$totContri.'" />';
				echo '<input type="hidden" id="remainingContribution" value="'.$remainContri.'" />';
				$contributed = 0;
				if ($cost == $totContri){
					$contributed = 1;
				}
				
			
	
				
				
				



					

			

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
							<div class="prod-qty margin-top15"><?php echo __d('admin', 'Quantity only'); ?> <?php echo $item_datas['quantity'];?> <?php echo __d('admin', 'available'); ?></div>
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
							<div class="col-xs-12 col-sm-12 no-hor-padding"><?php echo __d('admin', 'Recipient'); ?></div>
						<div class="sold-by-info col-xs-12 col-sm-12 no-hor-padding margin-top15">
							<div class="sold-by-prof-pic-cnt">
								<div class="sold-by-prof-pic"></div>
							</div>
							<div class="sold-by-prof-detail">
								<div class="bold-font"><?php echo '<br>'.__d('admin', 'Recipient').':';
echo wordwrap($items_list_data['name'],25,"<br>\n",TRUE);echo "<br>";
$lday=date("F j, Y ",$items_list_data['c_date']);
echo $lday; ?></div>
								Recipient Address: 
						<?php echo $items_list_data['address1']; ?>, 
						<?php echo $items_list_data['address2']; ?><br>
						<?php echo $items_list_data['city']; ?>, 
						<?php echo $items_list_data['state']; ?><br>
						<?php echo $countrys_list_data['country']; ?></span></div>
								
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 no-hor-padding"><?php echo __d('admin', 'Contributions'); ?></div>
	<div class="sold-by-info col-xs-12 col-sm-12 no-hor-padding margin-top15">
							
							<div class="sold-by-prof-detail">
								<div class="bold-font">
				
					<?php if($paidamt == ''){
						$paidamt = '0.00';
					}else{
						$paidamt = $paidamt;
					}
					
					?>
					<?php 
						$ggid = $items_list_data['id'];
						$timeleft = time() - $items_list_data['c_date'];
						$daysleft = round((($timeleft/24)/60)/60);
						$datelast = $items_list_data['c_date'] + 604800;
						$statuss = $items_list_data['status']; ?>
						



						<?php if($statuss !='Active' && $statuss !='Completed'){ 
							$disabled = 'disabled';
							$items_list_data['status'] = 'Expired';?>
						<?php }elseif($statuss == 'Completed'){
							$disabled = 'disabled';
							$items_list_data['status'] = 'Completed';
						}elseif($datelast < time()){							
							$disabled = 'disabled';
							$items_list_data['status'] = 'Expired';
						}

							?> 
							<?php echo $currencysymbol.$paidamt; ?>/<?php echo $currencysymbol.$items_list_data['total_amt'] ; ?>
					<div><?php echo __d('admin', 'Pending:'); ?> <?php echo $currencysymbol.$remainContri; ?></div>
				</div>
				<?php 
					switch($items_list_data['status']){
						case 'Expired':
							$color = 'color: #952525';
							$disabled = 'disabled';
							break;
						case 'Completed':
							$color = 'color: #252595';
							$disabled = 'disabled';
							break;
						case 'Active':
							$color = 'color: #259525';
							break;
					}
				?>				
				<div class="contristatus">
					<div class="contristatusdiv">
						<?php echo __d('admin', 'Status');?>: <span style="<?php echo $color; ?>"><?php echo $items_list_data['status']; ?></span>
					</div>
					<div class="totcontri">
						<?php echo __d('admin', 'Total contributors');?>: <?php echo count($paidUserId);?> <?php echo __d('admin', 'people');?>
					</div>
				</div>
				<?php if ($items_list_data['status'] == 'Active') {?>
				<div class="contripayment" style="display:none;">					
					<span class="mincontri">Minimum contribution: <?php echo $_SESSION['default_currency_symbol']."5 ".$_SESSION['default_currency_code']; ?></span>
					<input type="text" id="ggamt" onkeyup="chknum(this,event);" placeholder="Enter Amount" style="padding: 7px; margin: 4px 0px;" maxlength="6">
					<div id="loadingimgsforgf<?php echo $ggid; ?>" style="display:none;text-align:center;">
						<img alt="Processing" src="<?php echo SITE_URL; ?>images/loading_blue.gif">
					</div>
					<button class="contribubtn-green" <?php echo $disabled; ?> onclick="contributeChkOut(<?php echo $ggid; ?>, <?php echo $currentUser; ?>)"><?php echo __d('admin', 'Contribute');?></button>
					<div id="gifterr" style="font-size:13px;color:red;"></div>
					
				</div>
				<?php } ?>
				<div class="notify">
						<?php echo __d('admin', 'This group gift must receive all contributions by');?> <?php $finaldate = $items_list_data['c_date'] + 604800;echo $lday=date("F j, Y ",$finaldate); ?> to be successful.
						</br><?php echo __d('admin', 'Unsuccessful gift will be refunded');?>.
				</span></div>
								
							</div>
						</div>


							
							</div>
						</div>
					
					</div>
				</div>
			  </div>
			  <div class="prod-desc-cnt col-xs-12 col-lg-12">
				<div class="col-xs-12 col-sm-12 no-hor-padding">
					<div class="bold-font desc-heading"><?php echo __d('admin', 'Description:');?></div>
					
				</div>
				<div class="col-xs-12 col-sm-12 no-hor-padding comment more margin-top20">
					<?php echo $item_datas['description']; ?>
				</div>
			  </div>

 <div class="prod-desc-cnt col-xs-12 col-lg-12">
				<div class="col-xs-12 col-sm-12 no-hor-padding">
					
					<div class="bold-font desc-heading"><?php echo __d('admin', 'Creator:');?></div>
					
				</div>
	<div class="sold-by-prof-pic-cnt">
								<div class="sold-by-prof-pic"></div>
							</div>
							<div class="sold-by-prof-detail">
				<div class="col-xs-12 col-sm-12 no-hor-padding comment more margin-top20">

					<?php 

echo wordwrap($createuserDetails['username'],25,"<br>\n",TRUE);
echo "<br>";
echo $lday; ?>
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