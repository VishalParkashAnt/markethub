<?php
namespace Cake\I18n;
use Cake\I18n\Time;
?>

          <!-- Top stores section -->
             <section class="dis_item store">
              <div class="section_header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                <h2 class="section_heading bold-font">
                 <?php echo __d('user','Top Stores');?></h2>
                <div class="view-all-btn btn primary-color-bg primary-color-bg pull-right">
                  <a href="<?php echo SITE_URL.'viewmorestores';?>"><?php echo __d('user','View all');?></a>
                </div>
              </div>
              <div class="row">
                <?php foreach($topStores as $store){?>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 newdproduct">
                  <div class="product_cnt clearfix">
                    <a class="just_products" href="<?php echo SITE_URL.'stores/'.$store['shop_name_url'];?>">
  
                      <img src="<?php echo $store['image'];?>" class="justimg-responsive">
  
                    </a>
  
  
                    <div class="just_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                      <a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"
                        href="<?php echo SITE_URL.'stores/'.$store['shop_name_url'];?>">
                        <span><?php echo $store['store_name'];?> </span> </a>
  <h3><?php echo $store['merchant_name'];?></h3>
    
                    </div>
  
  
                  </div>
                </div>
              <?php }?>
              
             
                </div>

              </section>

          <!-- E O top stores -->