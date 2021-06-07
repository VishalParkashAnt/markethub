<?php
//echo "viewallreviews page";die;
?>
<section class="container margin_top165_mobile">
	
	<section class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-md0 margin-top10 margin-bottom10">
		<div class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="breadcrumb-divider1">/</span>
                    <a href="<?php echo $item_url; ?>"><?php echo substr($item_data->item_title, 0, 40); ?>
                    	</a>
                    <span class="breadcrumb-divider1">/</span>
                    <!-- <a href="#" style="text-transform:capitalize;" id="changecatname">Faq</a> -->
                    <span>Faq</span>
                </div>
                
            </section>
	
<div class="product-page-row col-xs-12 col-sm-12 no-hor-padding "
                style="background-color: #ffffff;">

                <div class="prod_abt_QA">

                    <h2 class="section_heading bold-font txt-uppercase">
                    <a href="<?php echo $item_url; ?>"><?php echo substr($item_data->item_title, 0, 70); ?>                   	</a>
                    </h2>

                </div>
                <hr />

                <div class="ques-ans_sec">

                    <div>
                        <h2 class="section_heading bold-font"><?php echo __d('user','Reviews & Ratings'); ?></h2>

                    </div>
                            
                        </div>

                

                <hr>

                <?php
foreach ($reviews as $key => $eachreview)
{
?>
					<div>
					<div class="row">
					<div class="col-md-12">

						<div class="users_deta">
							<div class="user_img">
							<a href="<?php echo $eachreview['username_url']; ?>">
								<img src="<?php echo $eachreview['user_image']; ?>">
								</a>
							</div>

							<div class="cont-detail align-self-sm-center align-self-center  ml-3">
								<h2><a href="<?php echo $eachreview['username_url']; ?>"><?php echo $eachreview['user_name']; ?></a></h2>
								<p class="cus_rev_cont"><?php echo str_replace('&#13;&#10;', '<br/>', $eachreview['review']); ?></p>
								<?php
    echo '<div>';
    for ($i = 1;$i <= 5;$i++)
    {
        $status = ($i <= $eachreview['rating']) ? 'fa fa-star checked' : 'fa fa-star-o unchecked';
        echo '<span id="' . $eachreview['rating'] . '" class="' . $status . '"></span>';
    }
    echo '</div>';
?>

							</div>
						</div>
					</div>
				</div>			
					</div>
				<?php
}
?>
				<input type="hidden" name="faq_count" id="faq_count" value="<?php echo $faq_count; ?>" />
				<div id="appendfaq">
					
				</div>
				<input type="hidden" name="loadmorevalue" id="loadmorevalue" value="<?php echo count($productfaq); ?>" />
				<input type="hidden" name="item_id" id="item_id" value="<?php echo $item_data->id; ?>" />
				<input type="hidden" name="userid" id="userid" value="<?php echo $loguser['id']; ?>" />
                
				<?php
if ($faq_count > 2)
{
    echo '<div class="load_more">
		                    <i class="more-less glyphicon glyphicon-plus"></i>
		                    <a href="javascript:void(0);" onclick="loadmorefaq();">'.__d('user','Load more').'</a></div>';
}
?>
</div>
                
        </section>


         <!-- reas othere answer modal popup  -->
