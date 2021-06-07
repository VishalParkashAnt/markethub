<?php
namespace Cake\I18n;
use Cake\I18n\Time;
//echo $this->element($slider,array('model'=>$model));
?>
	<!-- Discount section -->
            <section class="dis_item">
            <div class="section_header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
              <h2 class="section_heading bold-font">
               <?php echo __d('user','Discount Items');?></h2>
              <div class="view-all-btn btn primary-color-bg primary-color-bg pull-right">
                <a href="<?php echo SITE_URL.'viewmore/discountproducts';?>"><?php echo __d('user','View all');?></a>
              </div>
            </div>

            <div class="row">
              <?php foreach($discountproducts as $key => $discountproduct){

              ?>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 newdproduct">
                <div class="product_cnt clearfix">
                  <a class="just_products" href="<?php echo $discountproduct['product_url'];?>">

                    <img src="<?php echo $discountproduct['orig_image'];?>" class="justimg-responsive">

                  </a>

                     <div class="hover-visible">

                    <span class="hover-icon-cnt like_hover unmatched" href="javascript:void(0);" onclick="itemcou(<?php echo $discountproduct['id'];?>)">
                    <!--   <img src="<?php //echo SITE_URL.'/img/like.png'; ?>" id="like-icon<?php echo $popular['id'];?>" class="like-icon<?php echo $popular['id'];?>"> -->
                      <span class="like-txt<?php echo $discountproduct['id'];?> nodisply" id="like-txt<?php echo $discountproduct['id'];?>"><?php echo $setngs['like_btn_cmnt'];?></span>
                      <?php if (count($likeditemid) != 0 && in_array($discountproduct['id'], $likeditemid)) {
                echo '<img src="' . SITE_URL . 'img/Heart filled@2x.png" id="like-icon' . $discountproduct['id'] . '" class="like-icon' . $discountproduct['id'] . '" alt="liked">
                <span style="display:none" class="like-txt' . $discountproduct['id'] . ' nodisply" id="like-txt' . $discountproduct['id'] . '" >' . $setngs['liked_btn_cmnt'] . '</span>';
              } else {
                
                echo '<img src="' . SITE_URL . 'img/like.png" id="like-icon' . $discountproduct['id'] . '" class="like-icon' . $discountproduct['id'] . '" alt="unliked">
                <span style="display:none" class="like-txt' . $discountproduct['id'] . ' nodisply" id="like-txt' . $discountproduct['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
              }?>
                    </span>

                    <span class="hover-icon-cnt share_hover" href="#" onclick="share_posts(<?php echo $discountproduct['id'];?>);" data-toggle="modal"
                      data-target="#share-modal">
                      <img src="<?php echo SITE_URL.'/img/Mask Group 66.png'?>"> </span>

                    <span id="figcaption_titles<?php echo $discountproduct['id'];?>" figcaption_title="<?php echo $discountproduct['item_title'];?>"
                      style="display:none;width:0px !important;"><?php echo $discountproduct['item_title'];?></span><span class="figcaption"
                      id="figcaption_title_url" figcaption_url="<?php echo $discountproduct['item_title_url'];?>"
                      style="display:none;width:0px !important;"><?php echo $discountproduct['item_title_url'];?></span><a href="<?php echo SITE_URL.'/people/'?>" id="user_n<?php echo $discountproduct['id'];?>" usernameval="<?php echo $discountproduct['shop_name'];?>"
                      style="display:none;width:0px !important;"></a><span id="img_<?php echo $discountproduct['id'];?>" class="nodisply"
                      style="display:none;width:0px !important;"><?php echo $discountproduct['image'];?></span><span
                      class="fav_count" id="fav_count<?php echo $discountproduct['id'];?>" fav_counts="<?php echo $discountproduct['like_count'];?>" style="display:none;width:0px !important;"><?php echo $discountproduct['like_count'];?></span>
                  </div>

                  <div class="just_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                    <a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"
                      href="<?php echo $discountproduct['product_url'];?>">
                      <span><?php echo $discountproduct['item_title'];?></span> </a>

                    <!--<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
           ‎$ 24250</div>-->

                   
                   <?php  if(isset($_SESSION['currency_code'])){
                      $discount_price=$_SESSION['currency_symbol'].' '.$discountproduct['currency_discount_price'];
                   }
                   else{
                    $discount_price=$discountproduct['currency'].' '.$discountproduct['discount_price'];
                   }
                   ?>
                    <span id="price_vals<?php echo $discountproduct['id'];?>" price_val="<?php echo $discount_price;?>" style="display:none;width:0px !important;"></span>
                    <div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">‎<?php echo $discount_price;?>
                      ‎<strike class="bold-font">
                        <?php 
                      if(isset($_SESSION['currency_code'])){
                      echo $_SESSION['currency_symbol'].' '.$discountproduct['mainprice'];
                        }
                        else{
                           echo $discountproduct['currency'].' '.$discountproduct['mainprice'];
                      } 
                      ?>
                      </strike></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                      <div class="d-flex ratings">
                              <div>
                              <?php 
                               for ($i = 1;$i <= 5;$i++)
                  {
                      $status = ($i <= $discountproduct['avg_rating']) ? 'fa fa-star checked' : 'fa fa-star';
                      echo '<i id="" class="' . $status . '"></i>';
                  }
                              ?>
                            </div><div>
                               <span><?php if($discountproduct['avg_rating']!="") echo '('.$discountproduct['rating_count'].')'; else echo "(0)";?></span>
                                  </div>
   
                      </div>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                      <a href="<?php echo $discountproduct['product_url'];?>"></a>
                      <div class="buyPlus">
                        <div class="buY"><button href="<?php echo $discountproduct['product_url'];?>" class="btn buyCart" tabindex="0">
                            <div class="pluS"><i class="fa fa-plus" aria-hidden="true"></i></div>
                            <div><?php echo __d('user','Buy');?></div>
                          </button></div>

                      </div>
                    </a>
                    </div>
                  </div>


                </div>
              </div>
            <?php }?>



             
            

            </div>


          </section>
          <!-- E O discount section -->
