<?php
namespace Cake\I18n;
use Cake\I18n\Time;
//echo $this->element($slider,array('model'=>$model));
//echo"<pre>";print_r($featuredModel);die;
?>
  <!-- Featured items section -->
          <section class="newverticalslick clearfix">
            <div class="section_header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding clearfix">
              <h2 class="section_heading bold-font">
                 <?php echo __d('user','Featured Items');?></h2>
              <div class="view-all-btn btn primary-color-bg primary-color-bg pull-right">
                <a href="<?php echo SITE_URL.'viewmore/featured';?>"><?php echo __d('user','View all');?></a>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding clearfix">
              <div class="white-bg responsive_row">

                <section class="banner-section">
                  <div class="">
                    <div class="vehicle-detail-banner banner-content clearfix">
                      <div class="banner-slider">
                        <div class="row">
                          <div class="col-lg-2" style="padding-left: 0;">
                            <div class="slider slider-nav thumb-image custom_featured_slider_nav">
                               <?php foreach($featuredModel as $featured){
                               

                                 ?>
                              <div class="thumbnail-image">
                                <div class="thumbImg">
                                  <img
                                    src="<?php echo $featured['image'];?>"
                                    alt="slider-img">
                                </div>

                              </div>
                            <?php }?>
                             
                             
                            

                            </div>
                          </div>
                          <div class="col-lg-10 no-hor-padding">
                            <div class="slider slider-for custom_featured_slider_for">
                                <?php foreach($featuredModel as $featured){

                                   if(isset($featured['currency_discount_price']) ){

                                  if(isset($_SESSION['currency_code'])){
                                      $price=$_SESSION['currency_symbol'].' '.$featured['currency_discount_price'];
                                   }
                                   else{
                                    $price=$featured['currency'].' '.$featured['discount_price'];
                                   }
                                }
                                else {
                                   if(isset($_SESSION['currency_symbol'])){
                                   $price=$_SESSION['currency_symbol'].' '.$featured['mainprice'];
                                 }
                                 else{
                                   $price=$featured['currency'].' '.$featured['mainprice'];
                                 }
                               
                                }

                                  ?>
                              <div class="slider-banner-image">
                                <div class="d-flex">
                                  <div class="prod_img">
                                    <img
                                      src="<?php echo $featured['orig_image'];?>"
                                      alt="Car-Image">
                                  </div>
                                  <div class="prod_detail newdproduct">
                                    <div class="just_prod_nam">
                                      <h2><a href="<?php echo $featured['product_url']?>"><?php echo $featured['item_title'];?></a></h2>
                                      <p class="desc"><?php echo $featured['item_description'];?></p>

                                      <!--<div class="cmdprice "> 999  </div>-->
                                      <div class="cmdprice">
                                        <div class="price d-flex">
                                          <div class="bold-font"><?php echo $price;?><?php 
                                          if(isset($featured['currency_discount_price']) ) {?>
                                            <strike><?php if(isset($_SESSION['currency_symbol'])){
                                              echo $_SESSION['currency_symbol'].' '.$featured['mainprice'];
                                            } else{echo $featured['currency'].' '.$featured['mainprice'];
                                          }?>
                                              
                                            </strike>
                                          <?php }?></div>
                                        </div>
                                        <div class="d-flex ratings">
                                       <div>
                                      <?php 
                                      for ($i = 1;$i <= 5;$i++)
                                    {
                                        $status = ($i <= $featured['avg_rating']) ? 'fa fa-star checked' : 'fa fa-star';
                                        echo '<i id="" class="' . $status . '"></i>';
                                    }
                                   ?>
                            </div><div>
                                <span><?php if($featured['avg_rating']!="") echo '('.$featured['rating_count'].')'; else echo "(0)";?></span>
                                  </div>
                                        </div>

                                        <div class="visible-icon-cnt like_visible" href="#" onclick="itemcou(<?php echo $featured['id'];?>)">
                                              <!--   <span style="display: none;"class="like-txt<?php //echo $featured['id'];?> nodisply" id="like-txt<?php echo $featured['id'];?>"><?php //echo $setngs['like_btn_cmnt'];?></span> -->
                      <?php if (count($likeditemid) != 0 && in_array($featured['id'], $likeditemid)) {
                echo '<img src="' . SITE_URL . 'img/Heart filled@2x.png" class="slider_like_img like-icon' . $featured['id'] . '" id="like-icon' . $featured['id'] . '" alt="liked">
                <span style="display:none" class="like-txt' . $featured['id'] . ' nodisply" id="like-txt' . $featured['id'] . '" >' . $setngs['liked_btn_cmnt'] . '</span>';
              } else {
                
                echo '<img src="' . SITE_URL . 'img/Like.png" class="slider_like_img like-icon' . $featured['id'] . '" id="like-icon' . $featured['id'] . '" alt="unliked">
                <span style="display:none" class="like-txt' . $featured['id'] . ' nodisply" id="like-txt' . $featured['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
              }?>
                                        </div>
                                        <div class="visible-icon-cnt share_visible" href="#" onclick="share_posts(<?php echo $featured['id'];?>)"
                                          data-toggle="modal" data-target="#share-modal">
                                          <img src="<?php echo SITE_URL.'/img/Mask Group 66.png'?>" class="share_img_icon" id="like-icon<?php echo $featured['id'];?>">
                                            <span id="figcaption_titles<?php echo $featured['id'];?>" figcaption_title="<?php echo $featured['item_title'];?>"
                      style="display:none;width:0px !important;"><?php echo $featured['item_title'];?></span><span class="figcaption"
                      id="figcaption_title_url" figcaption_url="<?php echo $featured['item_title_url'];?>"
                      style="display:none;width:0px !important;"><?php echo $featured['item_title_url'];?></span><a href="<?php echo SITE_URL.'/people/'?>" id="user_n<?php echo $featured['id'];?>" usernameval="<?php echo $featured['shop_name'];?>"
                      style="display:none;width:0px !important;"></a><span id="img_<?php echo $featured['id'];?>" class="nodisply"
                      style="display:none;width:0px !important;"><?php echo $featured['image'];?></span><span
                      class="fav_count" id="fav_count<?php echo $featured['id'];?>" fav_counts="<?php echo $featured['like_count'];?>" style="display:none;width:0px !important;"><?php echo $featured['like_count'];?></span>
                       <span id="price_vals<?php echo $featured['id'];?>" price_val="<?php echo $price;?>" style="display:none;width:0px !important;"></span>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding clearfix">
                                            <a href="<?php echo $featured['product_url'];?>">
                                          <div class="buyPlus">
                                            <div class="buY"><button class="btn buyCart" tabindex="0">
                                                <div class="pluS"><i class="fa fa-plus" aria-hidden="true"></i></div>
                                                <div><?php echo __d('user','Buy');?></div>
                                              </button></div>

                                          </div>
                                        </a>
                                        </div>

                                      </div>
                                    </div>
                                  </div>
                                </div>

                              </div>
                            <?php }?>
                             
                              <!--   <div class="slider-banner-image">

                                </div> -->

                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                </section>



              </div>

            </div>
          </section>

          <!-- E O featured items section -->