<?php
namespace Cake\I18n;
use Cake\I18n\Time;
switch ($model){
        case 'recentlyadded':
            $data = $recentlyaddedModel;
            $viewmore = 'recent';
            $title = "NEW ARRIVALS";
            break;
        case 'mostpopular':
            $data = $mostpopularModel;
            $viewmore = 'popular';
            $title = "POPULAR PRODUCTS";
            break;
        case 'categories':
            $data = $categoryModel;
            $viewmore = 'categories';
            $title = "Categories";
            break;
        case 'top_rated':
            $data = $topratedModel;
            $viewmore = 'toprated';
            $title = "Top Rated Products";
            break;
        case 'discount_items':
            $data = $discount_items;
            $viewmore = 'discountproducts';
            $title = "Discount Items";
            break;
        case 'featured':
            $data = $featuredModel;
            $viewmore = 'featured';
            $title = "Featured Items";
            break;
    }
     if(count($data) > 0)
   {
?>
<section class="container new-arrivals">
            <div class="product_align_cnt col-sm-12 no-hor-padding">
                <div class="item-slider grid col-xs-12 col-sm-12 no-hor-padding">
                    <div class="section_header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                        <h2 class="section_heading bold-font">
                            <?php echo __d('user', $title); ?></h2>
                        <div class="view-all-btn btn primary-color-bg primary-color-bg pull-right">
                            <a href="<?php echo SITE_URL.'viewmore/'.$viewmore; ?>"><?php echo __d('user', 'View all'); ?></a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
<section class="container most_commt">


            <div class="popular_desktop_view"></div>


            <div class="row white-bg responsive_row">

                <div class="col-md-2">
                    <?php
      if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
      {
        ?><div dir="rtl"><?php } ?>
                        <div class="slider slider-verical_nav3 response-ht">
                        <?php
                        $mini=1;
                            foreach($data as $skey=>$sdata)
                            {
                              $itemprice = $sdata['price'];
                  $discountprice = $itemprice * ( 1 - $sdata['discount'] / 100 );

                $user_currency_price =  $currencycomponent->conversion($sdata['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

          $user_currency_dealprice = $currencycomponent->conversion($sdata['forexrate']['price'],$_SESSION['currency_value'],$discountprice);
                        ?>
                        <div class="slick-demo slider-div d<?php echo $mini; ?>">
                            <div class="popular_prod">
                                <div class="vertical_Thumbnail_img1 clearfix">

                                    <img src="<?php echo $sdata['image']; ?>" class="img-responsive_thumb" />

                                </div>

                            </div>
                        </div>
                        <?php 
                        $mini++;
                        } 
                        ?>
                        
                        

                        


                       </div>
                    <?php
      if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
      {
        ?></div><?php } ?>


                </div>

                <div class="col-md-10">
                    <div class="slider-wrapper">
                    <?php
      if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
      {
        ?>
                        <div dir="rtl"> <?php } ?>
                        <div class="slider slider-verical_for3">
                        
                        <?php
                            $max=1;
                            //echo '<pre>'; print_r($data); die;
                            foreach($data as $skey=>$sdata)
                            {
                              //print_r($sdata);die;
                              $itemprice = $sdata['price'];
                  $discountprice = $itemprice * ( 1 - $sdata['discount'] / 100 );

                $user_currency_price =  $currencycomponent->conversion($sdata['forexrate']['price'],$_SESSION['currency_value'],$itemprice);

          $user_currency_dealprice = $currencycomponent->conversion($sdata['forexrate']['price'],$_SESSION['currency_value'],$discountprice);
                        ?>
                        

                            <div class="slick-demo d<?php echo $max; ?>">


                                <div class="most_cmt_sect">
                                    <div class="item1 box_shadow_img">
                                        <div class="product_cnt clearfix">
                                            <a class="products-hovers" href="<?php echo $sdata['product_url']; ?>">
                                                <div class="mostpopular_imgs">
                                                    <img src="<?php echo $sdata['image']; ?>"
                                                        class="Recent_img-responsive img-fluid" />
                                                </div>
                                            </a>

                                        </div>

                                    </div>

                                    <?php
                           echo '<span id="figcaption_titles'.$sdata['id'].'" figcaption_title ="'.$sdata['item_title'].'" style="display:none;width:0px !important;"></span>';
            echo  '<span class="figcaption" id="figcaption_title_url'.$deal['id'].'" figcaption_url ="'.$sdata['item_title'].'" style="display:none;width:0px !important;" >'.$sdata['item_title'].'</span>';
            
            echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$deal['id'].'" usernameval ="'.$username.'" style="display:none;width:0px !important;"></a>';
            echo '<span id="img_'.$sdata['id'].'" class="nodisply" style="display:none;width:0px !important;">'.$sdata['image'].'</span>';
            echo '<span class="fav_count" id="fav_count'.$sdata['id'].'" fav_counts ="'.$favorte_count.'" style="display:none;width:0px !important;"></span>';
               
                           ?>
                                    <div class="most_comt_cont">

                                        <h1><a href="<?php echo $sdata['product_url']; ?>"><?php echo $sdata['item_title']; ?> </a></h1>

                                        <p class="most_p">
                                            <?php echo $sdata['item_description']; ?> 

                                            


                                        <!--<div class="cmdprice "> <?php echo $sdata['price']; ?>  </div>-->
                                         <div class="cmdprice">
                                        <?php
//echo .'deal'.strtotime(date('Y-m-d'));
      $price = $sdata['price'];
      $date = date('d');
          $month = date('m');
          $year = date('Y');
          $tdy = strtotime($month . '/' . $date . '/' . $year);
          $newdate = new Time($sdata['dealdatetwo']);
          $dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
      
      $dealstrtime = strtotime(date('Y-m-d',$dealdate));
      $todaystrtime = strtotime(date('Y-m-d',$tdy));

      if($sdata['discount_type'] == 'daily' && 
         $dealstrtime == $todaystrtime)
      {
         $dailydealdiscount = $sdata['discount'];
         $unitPriceConvert = number_format((float)$price, 2, '.', '');
         $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
         echo '<span id="price_vals'.$sdata['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_dealprice.'" style="display:none;width:0px !important;"></span>';
         ?>
<div class="cmdprice">&lrm;<?php echo $sdata['currency'].' '.$user_currency_dealprice; ?> &lrm;<strike class="bold-font h4" style="color:#a3a3a3 !important"><?php echo $_SESSION['currency_symbol'].' '.$user_currency_price; ?></strike></div>
<?php
   }elseif($sdata['discount_type'] == 'regular')
   {
         
         $unitPriceConvert = number_format((float)$price, 2, '.', '');
         $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
         echo '<span id="price_vals'.$sdata['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_dealprice.'" style="display:none;width:0px !important;"></span>';
      ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">&lrm;<?php echo $_SESSION['currency_symbol'].' '.$user_currency_dealprice; ?> &lrm;<strike class="bold-font h4" style="color:#a3a3a3 !important"><?php echo $_SESSION['currency_symbol'].' '.$user_currency_price; ?></strike></div>
<?php
   }else{
    echo '<span id="price_vals'.$sdata['id'].'" price_val="'.$_SESSION['currency_symbol'].$user_currency_price.'" style="display:none;width:0px !important;"></span>';
      ?>
<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
   <?php echo $_SESSION['currency_symbol']; ?><?php echo $user_currency_price; ?> 
</div>
<?php
   }
   ?>
   <div class="clearfix"></div>
    <div class="shareopt_visible ">

                                            <?php

        if (count($likeditemid) != 0 && in_array($sdata['id'], $likeditemid))
        {

?>
                                 <span class="visible-icon-cnt like_visible" href="#" onclick="itemcou1_cate(<?php echo $sdata['id']; ?>)">
                                    <img src="<?php echo SITE_URL; ?>images/icons/cate_heart.png"
                                       id="like-icon<?php echo $sdata['id']; ?>" class="like-icon<?php echo $sdata['id']; ?>">
                                       <span class="like-txt<?php echo $sdata['id']; ?> nodisply" id="like-txt<?php echo $sdata['id']; ?>">Fantacies</span></span>
                                 <?php
        }
        else
        {

?>
                                 <span class="visible-icon-cnt like_visible" href="#" onclick="itemcou1_cate(<?php echo $sdata['id']; ?>)">
                                    <img src="<?php echo SITE_URL; ?>images/icons/Heart.png"
                                    id="like-icon<?php echo $sdata['id']; ?>" class="like-icon<?php echo $sdata['id']; ?>">
                                    <span class="like-txt<?php echo $sdata['id']; ?> nodisply" id="like-txt<?php echo $sdata['id']; ?>">Fantacy</span></span>
                                 <?php
        }
?>
                                 <span class="visible-icon-cnt share_visible" href="#" onclick="share_posts(<?php echo $sdata['id']; ?>)" data-toggle="modal" data-target="#share-modal">
                                                <img src="<?php echo SITE_URL; ?>/images/icons/share_slide4.png"></span>


                                        </div>
   </div>






                                       


                                    </div>

                                </div>


                            </div>
                        
                        <?php } ?>
                        </div>
                <!-- </div>  -->
                <?php
      if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
      {
        ?></div><?php } ?>
                    </div>
                </div>



            </div>



        </section>
        <?php } ?>