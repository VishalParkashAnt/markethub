<?php
namespace Cake\I18n;
use Cake\I18n\Time;
//echo $this->element($slider, array('model'=>$model));
//echo"<pre>";print_r($recentlyadded);die;
?>
 <!-- New arrivals section -->
             <section class="newverticalslick two clearfix">
            <div class="section_header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding clearfix">
              <h2 class="section_heading bold-font">
                <?php echo __d('user','New Arrivals');?></h2>
              <div class="view-all-btn btn primary-color-bg primary-color-bg pull-right">
                <a href="<?php echo SITE_URL.'viewmore/recent';?>"><?php echo __d('user','View all');?></a>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 no-hor-padding clearfix">

              <section class="">

                <div class="vehicle-detail-banner banner-content clearfix">
                  <div class="banner-slider">
                    <div class="col-lg-9 no-hor-padding">
                      <div class="slider slider-for custom_recent_slider_for1">
                        <?php foreach($recentlyaddedModel1 as $recent1){
                          if(strlen($recent1['item_description'])>50){
                              $item_description = substr($recent1['item_description'],0,50);
                                $item_description=$item_description.'...';

                          }
                        
                           if(isset($recent1['currency_discount_price']) ){

                                  if(isset($_SESSION['currency_code'])){
                                      $price=$_SESSION['currency_symbol'].' '.$recent1['currency_discount_price'];
                                   }
                                   else{
                                    $price=$recent1['currency'].' '.$recent1['discount_price'];
                                   }
                                }
                                else {
                                   if(isset($_SESSION['currency_code'])){
                                   $price=$_SESSION['currency_symbol'].' '.$recent1['mainprice'];
                                 }
                                 else{
                                   $price=$recent1['currency'].' '.$recent1['mainprice'];
                                 }
                               
                                }

                          ?>
                        <div class="slider-banner-image">
                          <div class="">
                            <div class="prod_img">
                              <img
                                src="<?php echo $recent1['orig_image'];?>"
                                alt="Car-Image">
                            </div>
                            <div class="prod_detail newdproduct clearfix">
                              <div class="just_prod_nam">
                                <h2><a href="<?php echo $recent1['product_url'];?>"><?php echo $recent1['item_title'];?></a></h2>
                                <p class="desc"><?php echo $item_description;?></p>

                                <!--<div class="cmdprice "> 999  </div>-->
                                <div class="cmdprice">
                                  <div class="price d-flex">
                                          <div class="bold-font"><?php echo $price;?><?php 
                                          if(isset($recent1['currency_discount_price']) ) {
                                            if(isset($_SESSION['currency_symbol'])){
                                              $original_price= $_SESSION['currency_symbol'].' '.$recent1['mainprice'];
                                            }
                                            else{
                                               $original_price= $recent1['currency'].' '.$recent1['mainprice'];
                                            }
                                            ?>
                                            <strike><?php echo $original_price;?>
                                              
                                            </strike>
                                          <?php }?></div>
                                        </div>
                                  <div class="d-flex ratings">
                                         <div>
                                      <?php 
                                      for ($i = 1;$i <= 5;$i++)
                                    {
                                        $status = ($i <= $recent1['avg_rating']) ? 'fa fa-star checked' : 'fa fa-star';
                                        echo '<i id="" class="' . $status . '"></i>';
                                    }
                                   ?>
                            </div><div>
                                <span><?php if($recent1['avg_rating']!="") echo '('.$recent1['rating_count'].')'; else echo "(0)";?></span>
                                  </div>
                                  </div>

                                  <div class="visible-icon-cnt like_visible" href="#" onclick="itemcou(<?php echo $recent1['id'];?>)">
                                              <!--   <span style="display: none;"class="like-txt<?php //echo $recent1['id'];?> nodisply" id="like-txt<?php echo $recent1['id'];?>"><?php //echo $setngs['like_btn_cmnt'];?></span> -->
                      <?php if (count($likeditemid) != 0 && in_array($recent1['id'], $likeditemid)) {
                echo '<img src="' . SITE_URL . 'img/Heart filled@2x.png"  id="like-icon' . $recent1['id'] . '" class="slider_like_img like-icon' . $recent1['id'] . '" alt="liked">
                <span style="display:none" class="like-txt' . $recent1['id'] . ' nodisply" id="like-txt' . $recent1['id'] . '" >' . $setngs['liked_btn_cmnt'] . '</span>';
              } else {
                
                echo '<img src="' . SITE_URL . 'img/Like.png" id="like-icon' . $recent1['id'] . '" class="slider_like_img like-icon' . $recent1['id'] . '" alt="unliked">
                <span style="display:none" class="like-txt' . $recent1['id'] . ' nodisply" id="like-txt' . $recent1['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
              }?>
                                        </div>
                                  <div class="visible-icon-cnt share_visible" href="#" onclick="share_posts(<?php echo $recent1['id'];?>)"
                                          data-toggle="modal" data-target="#share-modal">
                                          <img src="<?php echo SITE_URL.'/img/Mask Group 66.png'?>" class="share_img_icon" id="like-icon<?php echo $recent1['id'];?>">
                                            <span id="figcaption_titles<?php echo $recent1['id'];?>" figcaption_title="<?php echo $recent1['item_title'];?>"
                      style="display:none;width:0px !important;"><?php echo $recent1['item_title'];?></span><span class="figcaption"
                      id="figcaption_title_url" figcaption_url="<?php echo $recent1['item_title_url'];?>"
                      style="display:none;width:0px !important;"><?php echo $recent1['item_title_url'];?></span><a href="<?php echo SITE_URL.'/people/'?>" id="user_n<?php echo $recent1['id'];?>" usernameval="<?php echo $recent1['shop_name'];?>"
                      style="display:none;width:0px !important;"></a><span id="img_<?php echo $recent1['id'];?>" class="nodisply"
                      style="display:none;width:0px !important;"><?php echo $recent1['image'];?></span><span
                      class="fav_count" id="fav_count<?php echo $recent1['id'];?>" fav_counts="<?php echo $recent1['like_count'];?>" style="display:none;width:0px !important;"><?php echo $recent1['like_count'];?></span>
                       <span id="price_vals<?php echo $recent1['id'];?>" price_val="<?php echo $price;?>" style="display:none;width:0px !important;"></span>
                                        </div>
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding clearfix">
                                      <a href="<?php echo $recent1['product_url'];?>">
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
                      
                      </div>
                    </div>
                    <div class="col-lg-3" style="padding: 0;">
                      <div class="slider slider-nav thumb-image custom_recent_slider_nav1">
                        <?php foreach($recentlyaddedModel1 as $recent1){?>
                        <div class="thumbnail-image">
                          <div class="thumbImg">
                            <img
                              src="<?php echo $recent1['image'];?>"
                              alt="slider-img">
                          </div>

                        </div>
                      <?php }?>
                       
                        
                       
                      

                      </div>
                    </div>

                  </div>
                </div>

              </section>


            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 two clearfix">

              <section class="">

                <div class="vehicle-detail-banner banner-content clearfix">
                  <div class="banner-slider">
                    <div class="col-lg-9 no-hor-padding">
                      <div class="slider slider-for custom_recent_slider_for2">
                        <?php foreach($recentlyaddedModel2 as $recent2){
                           if(strlen($recent2['item_description'])>50){
                              $item_description = substr($recent2['item_description'],0,50);
                              $item_description=$item_description.'...';
                              //echo "desc=".$item_description; die;
                          }
                           if(isset($recent2['currency_discount_price']) ){

                                  if(isset($_SESSION['currency_code'])){
                                      $price=$_SESSION['currency_symbol'].' '.$recent2['currency_discount_price'];
                                   }
                                   else{
                                    $price=$recent2['currency'].' '.$recent2['discount_price'];
                                   }
                                }
                                else {
                                  if(isset($_SESSION['currency_symbol'])){
                                   $price=$_SESSION['currency_symbol'].' '.$recent2['mainprice'];
                                 }
                                 else{
                                   $price=$recent2['currency'].' '.$recent2['mainprice'];
                                 }
                               
                                }

                          ?>
                        <div class="slider-banner-image">
                          <div class="">
                            <div class="prod_img">
                              <img
                                src="<?php echo $recent2['orig_image'];?>"
                                alt="Car-Image">
                            </div>
                            <div class="prod_detail newdproduct clearfix">
                              <div class="just_prod_nam">
                                <h2><a href="<?php echo $recent2['product_url'];?>"><?php echo $recent2['item_title'];?></a></h2>
                                <p class="desc"><?php echo $item_description;?></p>

                                <!--<div class="cmdprice "> 999  </div>-->
                                <div class="cmdprice">
                                  <div class="price d-flex">
                                          <div class="bold-font"><?php echo $price;?><?php 
                                          if(isset($recent2['currency_discount_price']) ) {
                                            if(isset($_SESSION['currency_symbol'])){
                                              $original_price= $_SESSION['currency_symbol'].' '.$recent2['mainprice'];
                                            }
                                            else{
                                               $original_price= $recent2['currency'].' '.$recent2['mainprice'];
                                            }

                                            ?>
                                            <strike><?php echo $original_price;?>
                                              
                                            </strike>
                                          <?php }?></div>
                                        </div>
                                  <div class="d-flex ratings">
                                         <div>
                                      <?php 
                                      for ($i = 1;$i <= 5;$i++)
                                    {
                                        $status = ($i <= $recent2['avg_rating']) ? 'fa fa-star checked' : 'fa fa-star';
                                        echo '<i id="" class="' . $status . '"></i>';
                                    }
                                   ?>
                            </div><div>
                                <span><?php if($recent2['avg_rating']!="") echo '('.$recent2['rating_count'].')'; else echo "(0)";?></span>
                                  </div>
                                  </div>

                                  <div class="visible-icon-cnt like_visible" href="#" onclick="itemcou(<?php echo $recent2['id'];?>)">
                                              <!--   <span style="display: none;"class="like-txt<?php //echo $recent1['id'];?> nodisply" id="like-txt<?php echo $recent1['id'];?>"><?php //echo $setngs['like_btn_cmnt'];?></span> -->
                      <?php if (count($likeditemid) != 0 && in_array($recent2['id'], $likeditemid)) {
                echo '<img src="' . SITE_URL . 'img/Heart filled@2x.png" id="like-icon' . $recent2['id'] . '" class="slider_like_img like-icon' . $recent2['id'] . '" alt="liked">
                <span style="display:none" class="like-txt' . $recent2['id'] . ' nodisply" id="like-txt' . $recent2['id'] . '" >' . $setngs['liked_btn_cmnt'] . '</span>';
              } else {
                
                echo '<img src="' . SITE_URL . 'img/Like.png" id="like-icon' . $recent2['id'] . '" class="slider_like_img like-icon' . $recent2['id'] . '" alt="unliked">
                <span style="display:none" class="like-txt' . $recent2['id'] . ' nodisply" id="like-txt' . $recent2['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
              }?>
                                        </div>
                                  <div class="visible-icon-cnt share_visible" href="#" onclick="share_posts(<?php echo $recent2['id'];?>)"
                                          data-toggle="modal" data-target="#share-modal">
                                          <img src="<?php echo SITE_URL.'/img/Mask Group 66.png'?>" class="share_img_icon" id="like-icon<?php echo $recent2['id'];?>">
                                            <span id="figcaption_titles<?php echo $recent2['id'];?>" figcaption_title="<?php echo $recent2['item_title'];?>"
                      style="display:none;width:0px !important;"><?php echo $recent2['item_title'];?></span><span class="figcaption"
                      id="figcaption_title_url" figcaption_url="<?php echo $recent2['item_title_url'];?>"
                      style="display:none;width:0px !important;"><?php echo $recent2['item_title_url'];?></span><a href="<?php echo SITE_URL.'/people/'?>" id="user_n<?php echo $recent2['id'];?>" usernameval="<?php echo $recent2['shop_name'];?>"
                      style="display:none;width:0px !important;"></a><span id="img_<?php echo $recent2['id'];?>" class="nodisply"
                      style="display:none;width:0px !important;"><?php echo $recent2['image'];?></span><span
                      class="fav_count" id="fav_count<?php echo $recent2['id'];?>" fav_counts="<?php echo $recent2['like_count'];?>" style="display:none;width:0px !important;"><?php echo $recent2['like_count'];?></span>
                       <span id="price_vals<?php echo $recent2['id'];?>" price_val="<?php echo $price;?>" style="display:none;width:0px !important;"></span>
                                        </div>
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding clearfix">
                                      <a href="<?php echo $recent2['product_url'];?>">
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
                        
                      </div>
                    </div>
                    <div class="col-lg-3" style="padding: 0;">
                      <div class="slider slider-nav thumb-image custom_recent_slider_nav2">
                         <?php foreach($recentlyaddedModel2 as $recent2){?>
                        <div class="thumbnail-image">
                          <div class="thumbImg">
                            <img
                              src="<?php echo $recent2['image'];?>"
                              alt="slider-img">
                          </div>

                        </div>
                      <?php }?>
                     

                      </div>
                    </div>

                  </div>
                </div>

              </section>

            </div>

          </section>

          <!-- E O new arrivals section -->	