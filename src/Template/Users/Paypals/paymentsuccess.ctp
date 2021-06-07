<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<section class="container-fluid side-collapse-container margin-top10 no_hor_padding_mobile margin_top165_mobile">
	<div class="container">
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top40 no-hor-padding">
		<div class="row">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 pos_rel responsive-none">
		<div class="primary-color-bg padding47"><div class="cod_deals"></div>
		<div class="arrow_right"></div></div>
		</div>	
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<div class="create_gift regular-font padding60_cod">
				<h1 class="bold-font line_height25"><?php echo __d('user','Thanks for your Purchase!');?></h1>
				<h5 class="line_height25"><?php echo __d('user','Your payment was successful. You will recieve an email shortly from ').$sitesettings['site_name'];?></h5>
					<div class="view-all-btn btn primary-color-bg">
						<a href="<?php echo $baseurl;?>"><?php echo __d('user','Continue Shopping');?></a>
					</div>
				</div>
			</div>
			</div>
		</section>
		</div>
</section>