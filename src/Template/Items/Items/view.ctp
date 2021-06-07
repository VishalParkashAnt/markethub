<?php
namespace Cake\I18n;
use Cake\Routing\Router;
use Cake\I18n\Time;
$baseurl = Router::url('/');
$userid = $users->id;
//echo "are you there";die;
?>
   
  
   <!--section class="container-fluid no-hor-padding sticker-cnt"-->
   <section class="container-fluid side-collapse-container fullPage" style="margin-top:0px;">
 <div class="row parent_reverce">
      <section class="col-md-9 col-sm-12  ">
    <section class="mainPage prdDetail">
      <section class="clearfix">
         <div class="prod-cnt zoomEffect col-xs-12 col-sm-12   no-hor-padding">
            <div class="prdFull">
             
              <a href="<?php echo SITE_URL.'stores/'.$item_datas['shop']['shop_name_url'];?>">
               <div class="userName">
                <?php if($item_datas['user']['profile_image']!=""){
                  $user_img=SITE_URL.'/media/avatars/thumb70/'.$item_datas['user']['profile_image'];
                  
                } 
                else{
                  $user_img=SITE_URL.'img/user.png';
                }

                ?>
                  <div class="prudHead"><img src="<?php echo $user_img;?>" alt="img"></div>
               <div class="rossi"><?php echo $item_datas['user']['username'];?></div>
               </div>
             </a>
               <?php
            foreach ($item_datas['itemfavs'] as $useritemfav)
{
    if ($useritemfav->user_id == $loguser['id'])
    {
        $usecoun[] = $useritemfav->item_id;
    }
}
if (isset($usecoun) && in_array($item_datas['id'], $usecoun))
{
           
                $likeimage=SITE_URL.'images/icons/Heart_after_like@2x.png';
               echo' <span style="display:none;" id="like-txt' . $item_datas['id'] . '" class="like-txt' . $item_datas['id'] . '">' . $setngs['liked_btn_cmnt'] . '</span>';
            }
            else{
                $likeimage=SITE_URL.'images/icons/like.png';
                echo'<span style="display:none;" id="like-txt' . $item_datas['id'] . '" class="like-txt' . $item_datas['id'] . '">' . $setngs['like_btn_cmnt'] . '</span>';
            }
                            ?>
               <div class="likeFwd">
                   <a  href="#" onclick="itemcouview(<?php echo $item_datas['id']; ?>)"><div class="prdLik l1"><img class="tog like-icon" id="like-icon<?php echo $item_datas['id'];?>" src="<?php echo $likeimage;?>" alt="like"></div></a>
                   <?php if ($item_datas['affiliate_commission'] == 0) { ?>
                   <a class="" href="#" onclick="share_posts(<?php echo $item_datas['id']; ?>);" data-toggle="modal" data-target="#share-modal"><div class="prdLike"><div class="prudFwd">
                     <img src="<?php echo SITE_URL.'/img/Share 1@2x.png';?>" alt="share1">
                  </div></div></a>
                  <?php } ?>
               </div>
            </div>
           
            <div class="col-xs-12 col-sm-12 col-md-12 no-hor-padding">
               <div class="zoomEle">
                  <div class="zoom-left">
                    <?php
                 // echo"<pre>";print_r($photos);
                   $listitemimage = $item_datas['photos'][0]['image_name'];
                   $imageurl=SITE_URL . 'media/items/original/'.$listitemimage;
                  // echo "list=".$listitemimage;die;
                 // echo "firstimage=".$photos[0]['image_name'];die;
    ?>
                     <img style="border:1px solid #e8e8e6;" id="zoom_03" src="<?php echo $imageurl;?>" 
                     data-zoom-image="<?php echo $imageurl;?>"
                     width="411"  />
                     
                       <div class="clearfix"></div>
                     
                     <!-- <a id="prev"> Previous </a>
                     <a id="next"> Next </a> -->
                      
                       <div class="clearfix"></div>
                     
                     <div id="gallery_01" style="width: 500px; float:left;">
                      
                      <?php
    $k = 0;
    foreach ($photos as $photo)
    {
        $item_image = $photo['image_name'];
        if ($item_image == "")
        {
            $itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
        }
        else
        {
            $itemimage = WWW_ROOT . 'media/items/original/' . $item_image;
            /*$header_response = get_headers($itemimage, 1);*/
            if (file_exists($itemimage))
            {
                $itemimage = SITE_URL . 'media/items/original/' . $item_image;
            }
            else
            {
                $itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
            }
        }
       // $itemimage='https://www.elevateweb.co.uk/wp-content/themes/radial/zoom/images/small/image1.png';
       
    ?>
                     <a  href="#" class="elevatezoom-gallery <?php if($k==0) echo "active";?>" data-update="" data-image="<?php echo $itemimage;?>" 
                     data-zoom-image="<?php echo $itemimage;?>">
                     <img src="<?php echo $itemimage;?>"  width="100"  /></a>

                   <?php   $k++;}?>
                     
                 <!--     <a  href="#" class="elevatezoom-gallery"
                          data-image="https://www.elevateweb.co.uk/wp-content/themes/radial/zoom/images/small/image2.png"
                          data-zoom-image="https://www.elevateweb.co.uk/wp-content/themes/radial/zoom/images/large/image2.jpg"
                         ><img src="https://www.elevateweb.co.uk/wp-content/themes/radial/zoom/images/small/image2.png" width="100"  /></a>
                     
                    -->
                     
                    <!--  <a href="tester" class="elevatezoom-gallery" 
                          data-image="https://www.elevateweb.co.uk/wp-content/themes/radial/zoom/images/small/image4.png"
                          data-zoom-image="https://www.elevateweb.co.uk/wp-content/themes/radial/zoom/images/large/image4.jpg"
                          
                          class="slide-content"
                         ><img src="https://www.elevateweb.co.uk/wp-content/themes/radial/zoom/images/small/image4.png" width="100"  /></a>
                          -->
                     </div>
               </div>
               <!-- <div class="product-slider-cnt item-slider">
                  <div id="carousel" class="carousel slide product-slider" data-ride="carousel" data-interval="false">
                     <div class="carousel-inner">
                        <div class="item active thumb-image">
                           <img
                              src="http://services.hitasoft.in/dev/stratus/media/items/original/1609405546_203.jpg"
                              data-imagezoom="true">
                        </div>
                        <div class="item  thumb-image">
                           <img
                              src="http://services.hitasoft.in/dev/stratus/media/items/original/1609405546_203.jpg"
                              data-imagezoom="true">
                        </div>
                        <div class="item" id="video_carousel">
                           <iframe id="iframeYoutube" width="100%" height="315" src="https://www.youtube.com/embed/"
                              frameborder="0" allowfullscreen></iframe>
                        </div>
                     </div>
                  </div>
               </div> -->
            </div> <!-- /col-sm-6 -->
           
                <?php
$listitemimage = $item_datas['photos'][0]['image_name'];
if ($listitemimage == "") $listitemimage = "usrimg.jpg";
?>
  <span style="display:none" id="img_<?php echo $item_datas['id'];?>"><?php echo SITE_URL.'media/items/original/'.$listitemimage;?></span>
<?php
echo '<input type="hidden" id="img1_'.$item_datas['id'] . '" class="img_'.$item_datas['id'] . '" value="' . SITE_URL . 'media/items/original/' . $listitemimage . '">';
echo '<input type="hidden" id="itemid" value="' . $item_datas['id'] . '">';
echo '<input type="hidden" id="userid" value="' . $userid . '">';

echo '<input type="hidden" id="merchantid" value="' . $item_datas['user']['id'] . '">';
echo '<input type="hidden" id="merchantname" value="' . $item_datas['user']['username'] . '" />';
echo '<input type="hidden" id="itemname" value="' . $item_datas['item_title'] . '" />';
echo '<input type="hidden" value="' . $loguser['username'] . '" id="usernames" />';
echo '<input type="hidden" id="likebtncnt" value="' . $setngs['like_btn_cmnt'] . '" />';
echo '<input type="hidden" id="likedbtncnt" value="' . $setngs['liked_btn_cmnt'] . '" />';
echo '<input type="hidden" id="loguserid" value="' . $loguser['id'] . '">';
echo "<input type='hidden' id='featureditemid' value='" . $item_datas['id'] . "' />";
if (!empty($usershipping['profile_image']))
{
    echo '<input type="hidden" value="' . $usershipping['profile_image'] . '" id="userimges" />';
}
else
{
    echo '<input type="hidden" value="usrimg.jpg" id="userimges" />';
}
?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 no-hor-padding prducDes">
               <div class="">
                  <div class="prod-detail-row prdHead col-xs-12 col-sm-12 no-hor-padding">
                     <h2 class="prod-name prdName" style="word-break: break-all;">
                       <?php echo $item_datas['item_title'];?></h2>
                        <div class="reviews ">
                           <div class="rev_star_sec">
   
                              <div>
                              <?php 
                               for ($i = 1;$i <= 5;$i++)
                  {
                      $status = ($i <= $rating_reviews['item_reviews']['rating']) ? 'fa fa-star checked' : 'fa fa-star-o unchecked';
                      echo '<span id="' . $eachreviewval['rating'] . '" class="' . $status . '"></span>';
                  }
                              ?>
                                  </div>
   
                              <div class="reviews   ">
                                 <div class="ratin_no">
   
   
                                    <?php echo __d('user', 'Rating'); ?> (<?php echo $rating_reviews['item_reviews']['rating']; ?>) </div>
   
                                 <div class="fnt_detail">
                                   <?php
if ($rating_reviews['order_id'] != '' && $rating_reviews['review_id'] == '')
{

?>
    <span data-toggle="modal" data-target="#writereview"> <?php echo __d('user', 'Write review'); ?> </span>
                                        <?php
}elseif(($rating_reviews['item_reviews']['rating_count'] > 0) && $rating_reviews['review_id'] != ''){
    ?>
    <span> <a href="#" id="<?php echo $item_datas['id']; ?>" onclick="editreviews(this);"> <?php echo __d('user', 'Edit review'); ?></a> </span>
    <?php
}

echo '<input type="hidden" name="review_data" value="'.$rating_reviews['rating'].'~'.base64_encode($rating_reviews['reviews']).'" id="review_data" />';
echo '<input type="hidden" name="avg_rating" id="avg_rating" value="'.$rating_reviews['rating'].'" />';
?>
                                 </div>
   
                                 <!--<div class="fnt_detail">
                                 <span data-toggle="modal" data-target="#writereview"> write a review </span>
                              </div>-->
   
                              </div>
   
                           </div>
   
                        </div>
                        <div>
                           <div class="proDescript"><?php $description = $item_datas['item_description'];
if (strlen($description) > 500)
{
    $desc = substr($description, 0, 500);
    echo html_entity_decode($desc); ?>
                  <span class="ellipses">...&nbsp;&nbsp;</span>
                  <?php
    $desclength = strlen($description);
    $moredesc = substr($description, 500, $desclength);
?>
                  <span style="word-break: break-all;">
                  <input type="hidden" id="moremoredesc" value="<?php echo $moredesc; ?>">
                  <span class="moredesc" style="display:none;"></span>
                  </span>
                  <a class="morelink showmoredesc" href="javascript:;" onClick="showmoredesc()"><?php echo 'More Info'; ?></a>
                  <a class="morelink hidemoredesc" href="javascript:;" onClick="lessmoredesc()" style="display:none;"><?php echo 'Less Info'; ?></a>
                  <?php
}
else
{
    echo html_entity_decode($description);
} ?></div>
                        </div>
                        <?php
if ($loguser['id'] != $item_datas['user']['id'])
{
    $reportedUsers = json_decode($item_datas['report_flag'], true);
    if (in_array($loguser['id'], $reportedUsers))
    {
       echo '<a data-toggle="modal" id="reportmodal" data-target="#undoreport_order"><div class="rePort">
                          <img src="'.SITE_URL.'/img/Report.png" alt="unreport">
                           <span id="report_text">'.__d('user','UnReport').'</span></div></a>';
    }
    else
    {
        echo ' <a data-toggle="modal" id="reportmodal" data-target="#report_order"><div class="rePort">
                          <img src="'.SITE_URL.'/img/Report.png" alt="report">
                           <span id="report_text">'.__d('user','Report').'</span></div></a>';
    }
}
?>
                        
                    
                  </div>

             <!--- Review popup -->
<div id="writereview" class="modal fade" role="dialog">
              <div class="modal-dialog downloadapp-modal">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="write-comment-container">
                      <h2 class="bold-font margin-bottom10">
                        <?php echo __d('user','Write a Review'); ?> <label class="primary-color-txt"><?php echo $item_datas['item_title']; ?></label>
                      </h2>

                      
                      <div class="rev_star_sec">
                        
                        <br/>
                        <form id="ratingsForm0">
                              <div class="stars margin_top5min">
                                <input type="radio" name="star" class="star-1" id="star-1" />
                                <label class="star-1" for="star-1" onclick="ratingClick('1');">1</label>
                                <input type="radio" name="star" class="star-2" id="star-2" />
                                <label class="star-2" for="star-2" onclick="ratingClick('2');">2</label>
                                <input type="radio" name="star" class="star-3" id="star-3" />
                                <label class="star-3" for="star-3" onclick="ratingClick('3');">3</label>
                                <input type="radio" name="star" class="star-4" id="star-4" />
                                <label class="star-4" for="star-4" onclick="ratingClick('4');">4</label>
                                <input type="radio" name="star" class="star-5" id="star-5" />
                                <label class="star-5" for="star-5" onclick="ratingClick('5');">5</label>
                                <span></span>
                              </div>
                            </form>

                        <div class="reviews ">
                          <div class="current-rate"> (<?php echo $rating_reviews['item_reviews']['rating']; ?>) </div>
                        </div>
  
          <input type="hidden" id="rateval" value="<?php echo $rating_reviews['rating']; ?>">
          <input type="hidden" id="user_id" value="<?php echo $loguser['id']; ?>">
          <input type="hidden" id="item_id" value="<?php echo $item_datas['id']; ?>">
                    <input type="hidden" id="review_id" value="<?php echo $rating_reviews['review_id']; ?>">
          <input type="hidden" id="order_id" value="<?php echo $rating_reviews['order_id']; ?>">
                          
                      </div>


                      <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                        <textarea class="form-control" rows="5" id="review" maxlength="180"
                          onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"
                          autocomplete="off" placeholder="<?php echo __d('user','Write a Review'); ?>" style="white-space: pre-wrap;
"><?php echo (!empty($review_id)) ? $reviews : ''; ?></textarea>
                        <div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
                          <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0"
                            role="menu" style="border:none;"></ul>
                        </div>
                        <div id="ratingerrorspan">
                          
                        </div>
                        <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
                          <button class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10"
                            data-dismiss="modal">
                            <?php echo __d('user','CANCEL'); ?></button>
                          <button href="javascript:void(0);" id="commentssave" onclick="return submitreview();"
                            class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10">
                            <?php echo __d('user','SUBMIT'); ?></button>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
<!-- End -->

               
                 <img id="fullimgtag" style="display: none;" alt="<?php echo $item_datas['item_title']; ?>" title="<?php echo $item_datas['item_title']; ?>" src="<?php echo SITE_URL . 'media/items/original/' . $item_datas['photos'][0]['image_name']; ?>">
<input type="hidden" id="item-descript" value="<?php echo strip_tags($item_datas['item_description']); ?>">
<?php
echo '<input type="hidden" id="listingid" value="' . $item_datas['id'] . '" />';
echo '<input type="hidden" id="merchantid" value="' . $item_datas['user']['id'] . '" />';

$date = date('d');
          $month = date('m');
          $year = date('Y');
          $tdy = strtotime($month . '/' . $date . '/' . $year);
          $newdate = new Time($item_datas['dealdate']);
          $dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
          $dealstrtime = strtotime(date('Y-m-d',$dealdate));
          $todaystrtime = strtotime(date('Y-m-d',$tdy));
          $sizeoptions = json_decode($item_datas['size_options'], true);
//echo "dealti=".$dealstrtime."==".$todaystrtime;
//echo '<pre>'; print_r($sizeoptions); die;
foreach ($sizeoptions['price'] as $key => $value)
{
    $price[] = $value;
}
//echo "item_datas['discount_type']=".$item_datas['discount_type'];die;
 $user_currency_price = $currencycomponent->conversion($item_datas['forexrate']['price'], $_SESSION['currency_value'], $item_datas['price']);
 if(isset($_SESSION['currency_code']))
        {
 $final_price=$_SESSION['currency_symbol'].' '.$user_currency_price;
}
else{
  $final_price=$item_datas['forexrate']['currency_symbol'].' '.$user_currency_price;
}
if (($item_datas['discount_type'] == 'daily' && $dealstrtime == $todaystrtime) || 
    ($item_datas['discount_type'] != 'daily'))
{
  
  

    if($item_datas['discount_type'] == 'regular' || $item_datas['discount_type']=='daily')
    { 
      
        $price = $item_datas['price'];
        $discountprice = $price * (1 - $item_datas['discount'] / 100);
        $user_deal_currency_price = $currencycomponent->conversion($item_datas['forexrate']['price'], $_SESSION['currency_value'], $discountprice);
        if(isset($_SESSION['currency_code']))
        {
            $final_price=$_SESSION['currency_symbol'].' '.$user_deal_currency_price;
            $strike_price=$_SESSION['currency_symbol'].' '.$price;
        }else{
            $final_price=$item_datas['forexrate']['currency_symbol'].' '.$user_deal_currency_price;
           $strike_price=$_SESSION['currency_symbol'].' '.$price;
        }

    }else{
      
        if (isset($_SESSION['currency_code']))
        { ?>&#x200E;<?php
             $final_price=$_SESSION['currency_symbol'] . ' ' . $user_currency_price;
        }
        else
        {
        ?>&#x200E;<?php
                 $final_price=$item_datas['forexrate']['currency_symbol'] . ' ' . $item_datas['price'];
        }
    }

    
}
if ($item_datas['discount_type'] == 'daily' && $dealstrtime == $todaystrtime)
{
    date_default_timezone_set("Asia/KolKata");
    $date = date('d');
    $month = date('m');
    $year = date('Y');
    $today = $month . '/' . $date . '/' . $year;
    $date1 = date('Y-m-d H:i:s');
    $date2 = date("Y-m-d", strtotime($today)) . ' 24:00:00';
    $diff = abs(strtotime($date2) - strtotime($date1));
    $hours = floor(($diff % 86400) / 3600);
    $mins = floor(($diff % 86400 % 3600) / 60);
    $sec = ($diff % 60);
?>
                  <script type="text/javascript">
        // Initialize the Date object.
        //  The set methods should be filled in by PHP
        var _date = new Date();
        _date.setHours('<?php echo $hours; ?>');
        _date.setMinutes('<?php echo $mins; ?>');
        _date.setSeconds('<?php echo $sec; ?>');
        // Generates a HH:MM:SS string
        function parseDate(dateObj) {
          var output = "";
          if(dateObj.getHours() < 10) {
            output += "";
          }
          output += dateObj.getHours() + ":";
          if(dateObj.getMinutes() < 10) {
            output += "0";
          }
          output += dateObj.getMinutes() + ":";
          if(dateObj.getSeconds() < 10) {
            output += "0";
          }
          output += dateObj.getSeconds();
          console.log(output);
          return output;
        }
        // Start the countdown
        setInterval(function() {
          _date.setSeconds(_date.getSeconds() - 1);
          document.getElementById('timer').innerHTML = parseDate(_date);
        }, 1000);
      </script>
<?php }
?>
                  
               </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
               <div class="amtPrd">
                  <div class="d-flex align-item-center">
                   <div class="d-flex w-100">
                                       <div class="">
                                          <div class="price-tag facebook_discount">
                                          <div class="d-flex">
                                             <span class="deal-price"> <?php 
                                            echo $final_price;
                                              ?>
          </span>
          <?php /* Affiliate Commission 
if ($item_datas['affiliate_commission'] != 0)
{ ?>
<span class="percentage_tag"><?php echo $item_datas['affiliate_commission']." %"; ?></span>
<?php } */ ?>
                                           
                                          </div>
                                          <?php //echo $strike_price;
                                          if($strike_price!=""){?>
                                             <div>
                                                <strike class="pro-strike"><?php echo $strike_price;?></strike>
                                             </div>
                                           <?php }?>
                                          </div>
                                       </div>
                                       <?php if(!empty($item_datas['discount']) && $item_datas['discount']!=0){?>
                                       <div class="">
                                          <div class="timer-cnt">
                                             <img src="<?php echo SITE_URL; ?>/img/Timer@2x.png" style="height: 25px;width:25px;">  <?php echo $item_datas['discount'] . ' % ' . __d('user', 'off Ends in') . ' '; ?>
                                             <div>

                                                <span class="time bold-font" id="timer"></span>
                                             </div>
                                          </div>
                                       </div>
                                        <?php }?>


                                    </div>
      
                </div>  
                <!-- E O d-flex align-item-center -->
    
  
                <?php /* Affiliate Commission  */ 
if ($item_datas['affiliate_commission'] != 0)
{ ?> 
<div class="affiliate_items">

<span class="affiliate_text"> To get affiliate commission (<?php echo $item_datas['affiliate_commission']."%"; ?>) share this listing </span> 

<a class="" href="#" onclick="share_posts(<?php echo $item_datas['id']; ?>);" data-toggle="modal" data-target="#share-modal"><div class="prdLike"><div class="prudFwd">
 <img src="<?php echo SITE_URL.'/img/Share 1@2x.png';?>" alt="share1">
</div></div></a>


</div>              
<?php } ?>


                
                <?php  /* QUANTITY AVAILABILITY */
if ($item_datas['quantity'] < 10 && $item_datas['quantity'] != 0)
{ ?>
    <div class="prod-qty margin-top15"><?php echo __d('user', 'Quantity only'); ?> <b><?php echo $item_datas['quantity']; ?></b> <?php echo __d('user', 'available'); ?></div>
    <?php
}
/* CHECK SOLDOUT */
if ($item_datas['quantity'] <= 0)
{
    echo '<h1 class="red-txt">' . __d('user', 'Sold Out') . '</h1>';
}
?>
  <input type="hidden" value="<?php echo $item_datas['quantity']; ?>" id="quantity_val">
                  <div class="sizeQty">
                    <!--  <select class="selectpicker sizeS">
                          <option selected>Size</option>
                          <option>S</option>
                          <option>M</option>
                          <option>L</option>
                          <option>XL</option>
                          <option>XXL</option>
                      </select> -->
                      <!--CHANGE QUANTITY AND SIZES-->
    <?php
$soldout = 0;
$sizes = json_decode($item_datas['size_options'], true);
if (!empty($sizes) && $item_datas['quantity'] > 0)
{
    $sizeavail = 1;
    $ech = $item_datas['size_options']; 
    //echo '<pre>'; print_r(json_decode($item_datas['size_options'])); die;
    $eche = json_decode($ech, true);
    $echo = array_values($eche[0]);
    $count = count($eche[0]);
    $sz_count = count($eche['size']);
    $qty = reset($eche['unit']);

    //echo '<pre>'; print_r($eche); die;
    /*
    $sets = array();
    foreach($eche['size'] as $k => $key)
    {
        $sets['size'][base64_encode($key)] = $key;
    }
    */

    //echo '<pre>'; print_r($eche); die;

    $sizeVal = array();
    foreach ($eche['size'] as $val)
    {
        //echo '<pre>'; print_r($val); die;
        $qty = $eche['unit'][$val];
        //echo '<br/>';
        if ($qty > 0)
        {
            $sizeVal[] = $val;
        }
    }

    //echo '<pre>'; print_r($sizeVal);
    //die;
?>
              <input type="hidden" value="1" name="sizeset" id="sizeset">
              <?php if ($sizeVal[0] != '')
    { ?>
                
                    <select class="selectpicker sizeS"  id="size_opt" name='size_opt' onchange="itemlistingloadqty('<?php echo $item_datas['id']; ?>')">
                      <option value="" ><?php echo __d('user', 'Size'); ?></option>
                      <?php
        foreach ($eche['size'] as $sizeopt)
        {
            $qty = $eche['unit'][$sizeopt];
            if ($qty > 0)
            {
                $sizeVal[] = $val;
                echo '<option value="' . $sizeopt . '">' . $sizeopt . '</option>';
            }
        }


    //   }
    // }
?>
                    </select>
                   
                    
                    <select class="selectpicker quantityN" id="qty-counter" class="qty-counter" name='qty-counter' onchange="refreshList(event);" >
                        <option value="" ><?php echo __d('user', 'Quantity'); ?></option>
                     <?php $szeopt = json_decode($item_datas['size_options'], true);
        if (!empty($szeopt))
        {
            $ech = $item_datas['size_options']; //print_r($item_datas);
            $eche = json_decode($ech, true);
            foreach ($eche['size'] as $sizeopt)
            {
                $qty = $eche['unit'][$sizeopt];
                if ($qty > 0)
                {
                    $sizeVal[] = $val;
                }
            }
            $qty = $eche['unit'][$sizeVal[0]];
            if ($qty == '0')
            {
                $soldout = 1;
            }
        }
        else $qty = $item_datas['quantity'];
        if ($qty == '0')
        {
            $soldout = 1;
        }
        for ($i = 1;$i <= $qty;$i++)
        {
            echo '<option value="' . $i . '">' . $i . '</option>';
        } ?>
                 </select>
                    <?php
    }
}
else if ($item_datas['quantity'] > 0)
{
    $sizeavail = 0;
?>
    <input type="hidden" value="0" name="sizeset" id="sizeset">
   
        <select class="selectpicker quantityN qty-counter"  onchange="refreshList(event);" id="qty-counter" class="" name='qty-counter'>
          <option value="" ><?php echo __d('user', 'Quantity'); ?></option>
          <?php
    $qty = $item_datas['quantity'];
    if ($qty == 0)
    {
        $soldout = 1;
    }
    for ($i = 1;$i <= $qty;$i++)
    {
        echo '<option value="' . $i . '">' . $i . '</option>';
    } ?>
        </select>
      </div>
   <!--  </div> -->
    <?php
}
?>
<input type="hidden" id="sizeavail" value="<?php echo $sizeavail; ?>"/>


  <!--CHANGE QUANTITY AND SIZES-->  
                  </div>
                  <span class="size_error errcls red-txt" style="margin-left:30px;padding:3px;"><?php echo __d('user', 'Please select the size'); ?></span>
<span class="qty_error errcls red-txt" style="margin-left:30px;padding:3px;"><?php echo __d('user', 'Please select the quantity'); ?></span>
                  <div class="buyy">

                                    <?php if (!empty($sizes) && $soldout == '0')
{
    if (($item_datas['status'] == 'publish'))
    {
        if ($userid != '')
        {
?>                    
                      <a onclick="cart_show();" >
                        <div class="buyPlus">
                        <div class="buY">
                           <button class="btn buyCart"><span class="fontCart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                           </span><span> <?php echo __d('user','Add to cart');?></span></button>
                        </div>
                    
                     </div></a>
                      <?php
        }
        else
        { ?>
                      <a href="<?php echo $baseurl . 'login/'; ?>" class=""><?php echo __d('user', 'ADD TO CART'); ?> <div class="buyPlus">
                        <div class="buY">
                           <button class="btn buyCart"><span class="fontCart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                           </span><span> <?php echo __d('user','Add to cart');?></span></button>
                        </div>
                    
                     </div></a>
                      <?php
        } ?>
                    <?php
        /*if ($item_datas['cod']=='yes')
         {*/
        if ($userid != '')
        { ?>
                    <a onclick="return buynow_show();" class="">
                      <div class="buyPlus">
                        <div class="buY"><button class="btn buyCart"><span class="pluS"><i class="fa fa-plus" aria-hidden="true"></i></span> <span><?php echo __d('user','Buy');?></span></button></div>
                       
                     </div>
                    </a>
                    <?php
        }
        else
        { ?>
                    <a href="<?php echo $baseurl . 'login/'; ?>" class="">
                      <div class="buyPlus">
                        <div class="buY"><button class="btn buyCart"><span class="pluS"><i class="fa fa-plus" aria-hidden="true"></i></span> <span><?php echo __d('user','Buy');?></span></button></div>
                       
                     </div>
                    </a>
                    <?php
        }
        /*}*/
    }
}
else
{
    if (($item_datas['status'] == 'publish') && ($item_datas['quantity'] > 0) && $soldout == '0')
    {
        if ($userid != '')
        {
?>
                    <a onclick="cart_show();" class="">
                       <div class="buyPlus">
                        <div class="buY">
                           <button class="btn buyCart"><span class="fontCart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                           </span><span><?php echo __d('user','Add to cart');?></span></button>
                        </div>
                    
                     </div>
                    </a>
                    <?php
        }
        else
        { ?>
                    <a href="<?php echo $baseurl . 'login/'; ?>" class="">
                       <div class="buyPlus">
                        <div class="buY">
                           <button class="btn buyCart"><span class="fontCart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                           </span><span><?php echo __d('user','Add to cart');?></span></button>
                        </div>
                    
                     </div>
                    </a>
                    <?php
        } ?>
                  <?php
        /*if ($item_datas['cod']=='yes')
         {*/
        if ($userid != '')
        { ?>
                      <a onclick="return buynow_show();" class="">
                        <div class="buyPlus">
                        <div class="buY"><button class="btn buyCart"><span class="pluS"><i class="fa fa-plus" aria-hidden="true"></i></span> <span><?php echo __d('user','Buy');?></span></button></div>
                       
                     </div>
                      </a>
                      <?php
        }
        else
        { ?>
                      <a href="<?php echo $baseurl . 'login/'; ?>" class="">
                        <div class="buyPlus">
                        <div class="buY"><button class="btn buyCart"><span class="pluS"><i class="fa fa-plus" aria-hidden="true"></i></span> <span><?php echo __d('user','Buy');?></span></button></div>
                       
                     </div>
                      </a>
                      <?php
        }
        /*}*/
    }
    else
    { ?>
                    <?php
    }
}
?>
                <!--Values-->
                <input type="hidden" id="loggeduserid" value="<?php if ($loguser['id'] != "" && $loguser['id'] != '0')
{
    echo $loguser['id'];
}
else
{
    echo '0';
} ?>" />
                  <input type="hidden" value="<?php echo $cntry_code; ?>" id="shipping_method_id">
                  <input type="hidden" value="<?php echo $item_datas['id']; ?>" id="listing_id">
                  <input type="hidden" value="<?php echo $item_datas['user_id']; ?>" id="itemuserid" >
                     


                    <!--  <div class="buyPlus">
                        <div class="buY">
                           <button class="btn buyCart"><span class="fontCart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                           </span><span> Add to cart</span></button>
                        </div>
                     </div> -->



                  </div>
                  <div class="collGift">
                    <a href="javascript:void(0);" onclick="itemcoulist(<?php echo $item_datas['id']; ?>);" class="add-to-list-cnt">
                     <div class="colle_Gift">
                        <div class="addToColl">
                           <div class="collecTion"><img src="<?php echo SITE_URL.'/img/Add to collection@2x.png';?>" alt="collection"></div>
                           <div><?php echo __d('user','Add to collection');?></div>
                        </div>
                     </div>
                   </a>
                    <?php
if ($item_datas['quantity'] > 0)
{
?>
  <input id="itm_id" type="hidden" value="<?php echo $item_datas['id']; ?>">
  <?php  if ($userid != '')
    { ?>
                    <a href="javascript:void(0);" onclick="creategroupgift();" class="">
                     <div class="colle_Gift">
                        <div class="createGift">
                           <div class="giftIcon"><img src="<?php echo SITE_URL.'img/Gift@2x.png';?>" alt="gift"></div>
                           <div ><?php echo __d('user','Create Gift');?></div>
                        </div>
                     </div>
                    </a>
                   <?php } else{?>
                      <a href="<?php echo $baseurl . 'login/'; ?>" class="">
                     <div class="colle_Gift">
                        <div class="createGift">
                           <div class="giftIcon"><img src="<?php echo SITE_URL.'img/Gift@2x.png';?>" alt="gift"></div>
                           <div ><?php echo __d('user','Create Gift');?></div>
                        </div>
                     </div>
                    </a>
                   <?php } }?>
                  </div>
               </div>
            </div>
         <!-- </div>
 -->
       
         
         <div class="product-page-row col-xs-12 col-sm-12 no-hor-padding customEr">
            <div class="selfie-carousel-cnt col-xs-12  padding-left0">
               <div class="product_align_cnt col-sm-12 no-hor-padding">
                  <div class="item-prods grid selfie col-xs-12 col-sm-12 no-hor-padding">
                     <div class="section_header col-xs-12 col-sm-12 col-md-12   no-hor-padding">
                        <h2 class="section_heading custMer">
                           <?php echo __d('user','Customer Product Selfies');?>(<?php echo count($fashionimages); ?>)</h2>
                     </div>
                     <div class="text-center imgCus">

                      <?php
                      if(count($fashionimages)>0){
    $i = 0;
    foreach ($fashionimages as $fimages)
    {
        $fashionimage = $fimages['userimage'];
        $fashionuserimage = $fimages['user']['profile_image'];
        if ($fashionimage == "") 
          {$fashionuserimage = "img/user.png";
      }
      else{
        $fashionuserimage = "media/avatars/original/".$fashionimage;
        
        
      }
      $fashionusername = $fimages['user']['first_name'];
      echo '<a class="img-hover1 selfie_slider" href="javascript:void(0)" data-toggle="modal" data-target="#selfie-modal" onclick="show_fashion_image(' . $fimages['id'] . ',\'' . $fashionimage . '\');">';
    ?>
                        <div class="customImg"><img src="<?php echo SITE_URL.$fashionuserimage;?>" alt="user"></div>
                        
                      <?php echo '</a>';} }
                      else {
?>
                     <center class="noImg-prdct"> <div class="text-center padding-top30 padding-bottom30">
                        <div class="outer_no_div">
                          <div class="empty-icon no_follow_icon"></div>
                        </div>
                        <h5 class="empty-selpy"><?php echo __d('user', 'No product selfies'); ?></h5>
                      </div> </center>
                      <?php
}  ?>
                     </div>
                     <!-- end Bottom to top-->
                  </div>
               </div>
            </div>

           
         </div>

         <div class="review-pages-row col-xs-12 col-sm-12 no-hor-padding customEr"
            style="background-color: #ffffff;">
            <div class="descrp_header col-xs-12 col-sm-12 col-md-12   no-hor-padding">
<div class="ratReview">
   <div> <h2 class="section_heading quesAndans">
      <?php echo __d('user','Rating & Reviews');?></h2>
</div>
  <?php
if ($rating_reviews['item_reviews']['rating_count'] > 0)
{
?>
            <a href="<?php echo SITE_URL.'viewallreviews/'.$item_datas['id']; ?>"
              class=""><div class="viewAll">
   <button class="viewBtn"><?php echo __d('user','View all');?></button>
</div></a>
          <?php
} ?>

</div>
              
               <!-- <div class="QA_viewall">
                        <a href="http://services.hitasoft.in/dev/stratus//viewmore/recent"></a>
                        
                    </div> -->
               <div>
               </div>





            </div>


            <!-- <div class="review_rating_sec">


               <div class="row">

                  <div class="col-md-2">

                     <div class="reviews_counts countReview">
                        <div class="review_no">

                           <h1 class="rew_no"> 0 </h1>
                           <div class="st_rating_img">
                              <div id="storeitemratings">
                                 <label class="itemstars"><img
                                       src="http://services.hitasoft.in/dev/stratus//images/icons/star.png"></label>
                              </div>
                           </div>
                        </div>

                        <div class="no_of-revw"> 0 ratings 0 Reviews </div>

                     </div>
                  </div>



                  <div class="col-md-8">
                     <div class="reviewBar">
                     <div class="reviw_bar" id="NAN">
                        <div class="side">
                           <div class="no_star"> <span>5 </span>
                              <div id="storeitemratings">
                                 <label class="itemstarsactive"></label>
                                 <img src="http://services.hitasoft.in/dev/stratus//images/icons/star.png">
                              </div>
                           </div>
                        </div>
                        <div class="middle">
                           <div class="bar-container">
                              <div class="bar-0" style="width: NAN !important;"></div>
                           </div>
                        </div>
                        <div class="side right">
                           <div>0</div>
                        </div>
                     </div>
                     <div class="reviw_bar">
                        <div class="side">
                           <div class="no_star"> <span>4 </span>
                              <div id="storeitemratings">
                                 <img src="http://services.hitasoft.in/dev/stratus//images/icons/star.png">
                              </div>
                           </div>
                        </div>
                        <div class="middle">
                           <div class="bar-container">
                              <div class="bar-0" style="width: NAN !important;"></div>
                           </div>
                        </div>
                        <div class="side right">
                           <div>0</div>
                        </div>
                     </div>
                     <div class="reviw_bar">
                        <div class="side">
                           <div class="no_star"> <span>3 </span>
                              <div id="storeitemratings">
                                 <img src="http://services.hitasoft.in/dev/stratus//images/icons/star.png">
                              </div>
                           </div>
                        </div>
                        <div class="middle">
                           <div class="bar-container">
                              <div class="bar-0" style="width: NAN !important;"></div>
                           </div>
                        </div>
                        <div class="side right">
                           <div>0</div>
                        </div>
                     </div>
                     <div class="reviw_bar">
                        <div class="side">
                           <div class="no_star"> <span>2 </span>
                              <div id="storeitemratings">
                                 <img src="http://services.hitasoft.in/dev/stratus//images/icons/star.png">
                              </div>
                           </div>
                        </div>
                        <div class="middle">
                           <div class="bar-container">
                              <div class="bar-0" style="width: NAN !important;"></div>
                           </div>
                        </div>
                        <div class="side right">
                           <div>0</div>
                        </div>
                     </div>
                     <div class="reviw_bar">
                        <div class="side">
                           <div class="no_star"> <span>1 </span>
                              <div id="storeitemratings">
                                 <img src="http://services.hitasoft.in/dev/stratus//images/icons/star.png">
                              </div>
                           </div>
                        </div>
                        <div class="middle">
                           <div class="bar-container">
                              <div class="bar-0" style="width: NAN !important;"></div>
                           </div>
                        </div>
                        <div class="side right">
                           <div>0</div>
                        </div>
                     </div>

                  </div>

                  </div>



               </div>


            </div> -->


        <div class="review_rating_sec">


          <div class="row">

            <div class="col-md-2">

              <div class="reviews_counts countReview">
                <div class="review_no">

                  <h1 class="rew_no"> <?php echo $rating_reviews['item_reviews']['rating']; ?> </h1>
                  <div class="st_rating_img">
                    <div id="storeitemratings">
                      <?php
//if ($rating_reviews['item_reviews']['rating'] == 0)
//{
    echo '<label class="itemstars"><img src="'.SITE_URL.'/images/icons/star.png"></label>';
//}
//else
//{
  //  echo '<label class="itemstarsactive"></label>';
//}
?>
                      
                    </div> 
                   </div>
                </div>

                <div class="no_of-revw"> <?php echo $rating_reviews['item_reviews']['rating_count']; ?> <?php echo __d('user', 'ratings'); ?>  <?php echo $rating_reviews['item_reviews']['review_count']; ?> <?php echo __d('user', 'Reviews'); ?> </div>

              </div>
            </div>

                        <?php
                            $fivebar = ($rating_reviews['item_reviews']['five'] / $rating_reviews['item_reviews']['rating_count'] ) * 100;
                            $fourbar = ($rating_reviews['item_reviews']['four'] / $rating_reviews['item_reviews']['rating_count'] ) * 100;
                            $threebar = ($rating_reviews['item_reviews']['three'] / $rating_reviews['item_reviews']['rating_count'] ) * 100;
                            $twobar = ($rating_reviews['item_reviews']['two']/ $rating_reviews['item_reviews']['rating_count'] ) * 100;
                            $singlebar = ($rating_reviews['item_reviews']['one'] / $rating_reviews['item_reviews']['rating_count'] ) * 100;
                            
                        ?>


            <div class="col-md-8">

              <div class="reviw_bar" id="<?php echo $fivebar; ?>">
                <div class="side">
                  <div class="no_star"> <span>5 </span> 
                    <div id="storeitemratings">
                      <!--<label class="itemstarsactive"></label>-->
                                            <img src="<?php echo SITE_URL; ?>/images/icons/star.png">
                    </div> 
                   </div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div class="bar-<?php echo $rating_reviews['item_reviews']['five']; ?>" style="width: <?php echo $fivebar; ?>% !important;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo $rating_reviews['item_reviews']['five']; ?></div>
                </div>
              </div>
              <div class="reviw_bar">
                <div class="side">
                  <div class="no_star"> <span>4 </span> 
                    <div id="storeitemratings">
                      <img src="<?php echo SITE_URL; ?>/images/icons/star.png">
                    </div> 
                  </div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div class="bar-<?php echo $rating_reviews['item_reviews']['four']; ?>" style="width: <?php echo $fourbar; ?>% !important;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo $rating_reviews['item_reviews']['four']; ?></div>
                </div>
              </div>
              <div class="reviw_bar">
                <div class="side">
                  <div class="no_star"> <span>3 </span> 
                    <div id="storeitemratings">
                      <img src="<?php echo SITE_URL; ?>/images/icons/star.png">
                    </div> 
                   </div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div class="bar-<?php echo $rating_reviews['item_reviews']['three']; ?>" style="width: <?php echo $threebar; ?>% !important;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo $rating_reviews['item_reviews']['three']; ?></div>
                </div>
              </div>
              <div class="reviw_bar">
                <div class="side">
                  <div class="no_star"> <span>2 </span> 
                    <div id="storeitemratings">
                      <img src="<?php echo SITE_URL; ?>/images/icons/star.png">
                    </div> 
                   </div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div class="bar-<?php echo $rating_reviews['item_reviews']['two']; ?>" style="width: <?php echo $twobar; ?>% !important;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo $rating_reviews['item_reviews']['two']; ?></div>
                </div>
              </div>
              <div class="reviw_bar">
                <div class="side">
                  <div class="no_star"> <span>1 </span> 
                    <div id="storeitemratings">
                      <img src="<?php echo SITE_URL; ?>/images/icons/star.png">
                    </div> 
                   </div>
                </div>
                <div class="middle">
                  <div class="bar-container">
                    <div class="bar-<?php echo $rating_reviews['item_reviews']['one']; ?>" style="width: <?php echo $singlebar; ?>% !important;"></div>
                  </div>
                </div>
                <div class="side right">
                  <div><?php echo $rating_reviews['item_reviews']['one']; ?></div>
                </div>
              </div>



            </div>



          </div>


        </div>


       
        <?php
foreach ($rating_reviews['item_reviews']['result'] as $key => $eachreviewval)
{
?>
        <div class="row">
          <div class="col-md-12">

            <div class="users_deta">
              <div class="user_img">
              <a href="<?php echo $eachreviewval['username_url']; ?>">
                <img src="<?php echo $eachreviewval['user_image']; ?>" />
                </a>
              </div>

              <div class="cont-detail align-self-sm-center align-self-center  ml-3">
                <h2>
                                <a href="<?php echo $eachreviewval['username_url']; ?>">    <?php echo $eachreviewval['user_name']; ?></h2>
                                </a>
                <p class="cus_rev_cont"><?php //echo str_replace('&#13;&#10;', '<br/>', $eachreviewval['review']);  ?><?php echo $eachreviewval['review'];  ?></p>
                <div>
                <?php
    for ($i = 1;$i <= 5;$i++)
    {
        $status = ($i <= $eachreviewval['rating']) ? 'fa fa-star checked' : 'fa fa-star-o unchecked';
        echo '<span id="' . $eachreviewval['rating'] . '" class="' . $status . '"></span>';
    }
?>
                </div>

              </div>
            </div>
          </div>
        </div>
        
        <?php
}
?>
            

         </div>

        
<div class="product-page-row posCmmt col-xs-12 col-sm-12 " style="background-color: #ffffff;">
        <div class="ques-ans_sec">
          <div>
            <h2 class="section_heading quesAndans"><?php echo __d('user', 'Questions and Answers'); ?></h2>

          </div>
          <div>
          <?php
if (isset($loguser['id']))
{ 
    echo '<a href="#" class="col-xs-12 col-sm-4 QA_viewall btn prod-detail-btn" data-toggle="modal" data-target="#postaquestion"> <div class="postYourQn">'.__d('user','Post a Question').'</div></a>';
}
else
{
    echo '<a href="' . SITE_URL . 'login" class="col-xs-12 col-sm-4 QA_viewall btn prod-detail-btn"> '.__d('user','Post a Question').'</a>';
}
?>
          </div>
        </div>
        <div class="allQns">
        <?php
if (count($productfaq) > 0)
{   
             
              
    echo '<a href="' . SITE_URL . 'viewallfaq/' . $item_datas['id'] . '">  <div class="qns">
                  <div class="qnAns viewAllqn">'.__d('user','View All Questions and Answers').'</div>
               </div></a>';
}
else
{
    echo '<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_faq_icon"></div></div><h5 class="empty-selpy">'.__d('user', 'Post your query here..').'</h5></div>';
}
?>
        
        <!-- <hr> -->
        <?php
foreach ($productfaq as $faq_key => $faq_value)
{
    if ($faq_key > 2) continue;
?>
          <div>
          <div class="padding-left10">
            <div class="quanswre">
              <h2> Q: <?php echo $faq_value['content']; ?></h2>
              <?php
     if (isset($faq_value['answer']) && count($faq_value['answer']) > 0)
    {

        if(count($faq_value['answer']) ==  1)
        {
            foreach ($faq_value['answer'] as $anskey => $ansval)
            {
                if ($anskey > 0) continue;
                echo '<p class="ans_sty"> <strong>A:</strong> <span> ' . $ansval['content'] . '</span></p>';
            }
        }elseif(count($faq_value['answer']) > 1){
            foreach ($faq_value['answer'] as $anskey => $ansval)
            {
                if ($anskey > 0) continue;
                echo '<p class="ans_sty"> <strong>A:</strong> <span> ' . $ansval['content'] . '</span></p>';
            }

            ?>
                <a href="javascript:void(0);" class="view_QA"  onclick="read_other_answers(<?php echo $faq_value['question_id']; ?>,'<?php echo base64_encode($faq_value['content']); ?>');"><?php echo __d('user','Read other answers'); ?></a>
            <?php
        }
?>

                            
                        <?php
    }
    elseif (isset($order_id) && ($order_id != '') && (count($faq_value['answer']) == 0) && ($faq_value['user_id'] != $loguser['id']))
    {
        //echo $faq_value['user_id'].'faq';
        //echo '<br/>'.$loguser['id'];

?>
                            <a href="javascript:void(0);" class="view_QA"  onclick="read_other_answers(<?php echo $faq_value['question_id']; ?>,'<?php echo base64_encode($faq_value['content']); ?>');"><?php echo __d('user','Write answer'); ?></a>
                            <?php
    }elseif ((count($faq_value['answer']) == 0 && isset($order_id) && $order_id == '') || ($faq_value['user_id'] == $loguser['id']))
    {
        echo '<p class="ans_sty"> <span>'.__d('user','No Answer').'</span></p>';
    }
    elseif (count($faq_value['answer']) > 0)
    {
        foreach ($faq_value['answer'] as $anskey => $ansval)
        {
            if ($anskey > 0) continue;
            echo '<p class="ans_sty"> <strong>A:</strong> <span> ' . $ansval['content'] . '</span></p>';
        }
    }

?>
            </div>
          </div>
          <div>
            <?php
    //echo '<pre>'; print_r($faq_value); die;
   
?>
          </div>
          <hr>        
          </div>
        <?php
}
?>
      </div>
    <div id="postaquestion" class="modal fade" role="dialog">
        <div class="modal-dialog downloadapp-modal">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="write-comment-container">
                <h2 class="bold-font margin-bottom10">
                  <?php echo __d('user','WRITE A QUESTION'); ?> <label class="primary-color-txt"><?php
echo $item_datas['item_title']; ?></label>
                </h2>

                <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                <div id="errorspan_question"></div>
                  <textarea class="form-control" rows="5" id="questions" maxlength="180"
                    onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"
                    autocomplete="off" placeholder="<?php echo __d('user','Write a question about'); ?>"></textarea>
                  <div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
                    <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0"
                      role="menu" style="border:none;"></ul>
                  </div>
                  <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
                    <button class="btn filled-btn follow-btn primary-color-bg bold-font pull-right margin-top10"
                      data-dismiss="modal">
                      <?php echo __d('user','Cancel'); ?></button>
                      <!-- onclick ="return questionsubmit();" -->
                    <button href="javascript:void(0);" id="commentssave" onclick="return questionsubmit();"
                      class="btn filled-btn follow-btn bold-font primary-color-bg pull-right margin-top10">
                      <?php echo __d('user','Post Your Question'); ?></button>
                  </div>
                  <div id="cmnterr"
                    style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px">
                    Please enter comment</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

          <div id="read_answers" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class=" login-body modal-body clearfix">
            <button class="close" type="button" data-dismiss="modal">×</button>
            <div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
              <h2
                class="popupheder readansquestion bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                Q: how is look and feel ??</h2>
            </div>

            <?php
if (isset($order_id) && $order_id != '')
{
?>
                <div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top30" id="answer_forms">
                  <div id="errorspan"></div>
                      <textarea name="answer" onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');" id="answer" class="form-control" placeholder="Post your anwser"></textarea>
                      <input type="hidden" name="question_id" id="question_id" />       
                      
                  <div>                   
                    <button onclick ="return answersubmit();" class="btn filled-btn follow-btn primary-color-bg bold-font pull-right margin-top10">
                    Post answer</button>
                  </div>
                </div>
              <?php
}
?>
            
            <div id="answer-list-question">
            
            </div>
          </div>
        </div>
      </div>
    </div>



      </section>
     

      <section class="col-xs-12 col-sm-12 new-arrivals paddigs productSlider prdSlider clearfix">
         <div class="product_align_cnt  no-hor-padding">
            <div class="morePrdt allPdct"><?php echo __d('user','Popular Products');?></div>
            <?php
                  if(count($popular_products) == 0)
                  {
                    echo '<div class="text-center padding-top30 padding-bottom30">
                    <div class="outer_no_div">
                    <div class="empty-icon no_products_icon"></div>
                    </div>
                    <h5>' . __d('user', 'No Products') . '</h5>
                    </div>';
                  }
                  ?>
            <div class="item-slider grid no-hor-padding">
               <div class="no-hor-padding product-sec-slide heroSlider-fixed">
                <!--   <input type="hidden" id="likebtncnt" value="stratustes" /><input type="hidden" id="likedbtncnt"
                     value="stratust'd" />  -->
                  <div class=" new_arrivals ar_center prdtSlider">
                    <?php 
                      //print_r($popular_products);die;
                     foreach($popular_products as $key=>$eachitem)
                        {
                            $img_variable = $eachitem->photos;
                            $product_img = SITE_URL.'media/items/thumb350/'.$img_variable[0]->image_name;
                            $item_url = base64_encode($eachitem->id . "_" . rand(1, 9999));
                            $user_currency_price = $currencycomponent->conversion($eachitem['forexrate']['price'], $_SESSION['currency_value'], $eachitem->price);
                            $user_name = $eachitem['users']->user_name;
                            $favorte_count = $featured['fav_count'];
                             if(isset($_SESSION['currency_code'])){
                                   $currencyprice=$_SESSION['currency_symbol'].' '.$eachitem['price'];
                                 }
                                 else{
                                  $currencyprice=$eachitem['currency'].' '.$eachitem['price'];
                                 }
                           
                           

                    ?>
                     <div class="item1 box_shadow_img" style="width:250px!important;">
                        <div class="product_cnt clearfix">
                           <div class="imgDescription">
                           <a class="img-hover1" href="<?php echo SITE_URL.'listing/'.$item_url; ?>">
                              <div class="bg_product">
                                 <img src="<?php echo $product_img;?>" class="img-responsive">
                              </div>
                           </a>
                           <div class="prodDescrip new_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                              <div class="prdDescrip">
                                 <div class="imgDes">
                                   <a class="" href="<?php echo SITE_URL.'listing/'.$item_url; ?>">
                                     <div class="desCri"><?php echo (strlen($eachitem['item_title']) > 28 ) ? substr($eachitem['item_title'], 0, 28).'..' : $eachitem['item_title'] ; ?></div> </a>
                                     
                                     
                                    <!--  <span id="price_vals<?php echo $eachitem['id'];?>" price_val="" style="display:none;width:0px !important;"></span> -->
                                   </div>
                                     <?php
                                     //print_r($eachitem['itemfavs']);
            foreach ($eachitem['itemfavs'] as $useritemfav)
{
    if ($useritemfav->user_id == $loguser['id'])
    {
        $usecoun[] = $useritemfav->item_id;
    }
}
//echo 'EACH '.$eachitem['id'];

if (isset($usecoun) && in_array($eachitem['id'], $usecoun))
{
           
                $likeimage=SITE_URL.'images/icons/Heart_after_like@2x.png';
                $status = 'liked';
               echo' <span style="display:none;" id="like-txt' . $eachitem['id'] . '" class="like-txt' . $eachitem['id'] . '">' . $setngs['liked_btn_cmnt'] . '</span>';
            }
            else{
                $likeimage=SITE_URL.'images/icons/like.png';
                $status = 'unliked';
                echo'<span style="display:none;" id="like-txt' . $eachitems['id'] . '" class="like-txt' . $eachitem['id'] . '">' . $setngs['like_btn_cmnt'] . '</span>';
            }
                            ?>
                                   <div class="desIcon">
                                      <a class="" href="javascript:void(0);" onclick="itemcouview(<?php echo $eachitem['id']; ?>)"><div class="likeIcon"><img class="like-icon<?php echo $eachitem['id'];?>" id="like-icon<?php echo $eachitem['id'];?>" src="<?php echo $likeimage;?>" alt="<?php echo $status;?>"></div></a>
                                      <a class="" href="#" onclick="share_posts1(<?php echo $eachitem['id']; ?>);" data-toggle="modal" data-target="#share-modal">
                                        <div class="shareIcon"><img src="<?php echo SITE_URL.'/img/share.png';?>" alt="share"></div></a>
                                   </div>
                                 </div>
                                       <?php
                                
                                //echo strtotime(date('Y-m-d'));

                                $price = $eachitem['price'];
                                $date = date('d');
                                $month = date('m');
                                $year = date('y');
                                $tdy = strtotime($month . '/' . $date . '/' . $year);
                                $newdate = new Time($featured['dealdate']);
                                $dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
                                $dealstrtime = strtotime(date('Y-m-d'), strtotime($dealdate));
                                $todaystrtime = strtotime(date('Y-m-d'), $tdy);

                                  if(($eachitem['discount_type'] == 'daily' && 
                                     $dealstrtime == $todaystrtime) || ($eachitem['discount_type'] == 'regular'))
                                  {
                                     $dailydealdiscount = $eachitem['discount'];
                                     $unitPriceConvert = number_format((float)$price, 2, '.', '');
                                     $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);

                                     echo '<span id="price_vals'.$eachitem['id'].'" price_val="'.$_SESSION['currency_symbol'].$daily_price.'" style="display:none;width:0px !important;"></span>';

                                     ?>

                            <div class="price">&lrm;<?php if(isset($_SESSION['currency_symbol'])) echo $_SESSION['currency_symbol'].' '.$daily_price; else 
                            echo $eachitem['currency'].' '.$daily_price; ?> 
                            <strike class="bold-font"><?php if(isset($_SESSION['currency_symbol']))  echo $_SESSION['currency_symbol'].' '.$eachitem['price']; else echo $eachitem['currency'].' '.$eachitem['price']; ?></strike>
                            </div>
                            <?php
                               }else{
                                ?>
                                <div class="price">&lrm;<?php echo $currencyprice ?>
                            </div>
                                <?php
                               }
                                ?>
                             <!--  <div class="price ">
                                 $600
                           </div> -->
                          <!--  <span id="price_vals6" price_val="$300"
                           style="display:none;width:0px !important;"></span> -->
                              </div>
                              
                           </div>
                           
                        </div>

                     </div>

                   <?php 
//                                                          $item_title = $eachitem['item_title'];
// $item_title_url = $eachitem['item_title_url'];
// $item_price = $eachitem['price'];
// $favorte_count = $eachitem['fav_count'];
 $username = $eachitem['user']['username'];
 $items_image = SITE_URL.'media/items/thumb350/'.$eachitem['photos'][0]['image_name'];
// echo '<span id="figcaption_titles' . $eachitem['id'] . '" figcaption_title ="' . $item_title . '" style="display:none;"></span>';
// echo '<span class="figcaption" id="figcaption_title_url' . $eachitem['id'] . '" figcaption_url ="' . $item_title_url . '" style="position: relative; top: 10px; left: 7px;display:none;" >' . $item_title_url . '</span>';
// echo '<span id="price_vals' . $eachitem['id'] . '" price_val="' . $item_price . '" ></span>';
// echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $eachitem['id'] . '" usernameval ="' . $username . '"></a>';
// echo '<span class="fav_count" id="fav_count' . $eachitem['Item']['id'] . '" fav_counts ="' . $favorte_count . '" ></span>';
// echo '<span id="img_' . $eachitem['id'] . '" class="nodisply" style="display:none;width:0px !important;">' . $items_image . '</span>';
                  ?> 
                  <span id="figcaption_titles<?php echo $eachitem['id'];?>" figcaption_title="<?php echo $eachitem['item_title'];?>"
                      style="display:none;width:0px !important;"><?php echo $eachitem['item_title'];?></span><span class="figcaption"
                      id="figcaption_title_url" figcaption_url="<?php echo $eachitem['item_title_url'];?>"
                      style="display:none;width:0px !important;"><?php echo $eachitem['item_title_url'];?></span><a href="<?php echo SITE_URL.'/people/'?>" id="user_n<?php echo $eachitem['id'];?>" usernameval="<?php echo $username;?>"
                      style="display:none;width:0px !important;"></a><span id="img_<?php echo $eachitem['id'];?>" class="nodisply"
                      style="display:none;width:0px !important;"><?php echo $items_image;?></span><span
                      class="fav_count" id="fav_count<?php echo $eachitem['id'];?>" fav_counts="<?php echo $eachitem['like_count'];?>" style="display:none;width:0px !important;"><?php echo $eachitem['like_count'];?></span>
                       <span id="price_vals<?php echo $eachitem['id'];?>" price_val="<?php echo $currencyprice;?>" style="display:none;width:0px !important;"></span>
                 <?php }?>
                     
                  
                  </div>

               </div>
            </div>
         </div>
      </section>

       <section class="col-xs-12 col-sm-12 new-arrivals paddigs productSlider prdSlider clearfix">
         <div class="product_align_cnt  no-hor-padding">
            <div class="morePrdt allPdct"> <?php echo __d('user', 'More from'); ?> <?php echo $users['first_name']; ?></div>
            <?php
                  if(count($item_all) == 0)
                  {
                    echo '<div class="text-center padding-top30 padding-bottom30">
                    <div class="outer_no_div">
                    <div class="empty-icon no_products_icon"></div>
                    </div>
                    <h5>' . __d('user', 'No Products') . '</h5>
                    </div>';
                  }
                  ?>
            <div class="item-slider grid no-hor-padding">
               <div class="no-hor-padding product-sec-slide heroSlider-fixed">
                <!--   <input type="hidden" id="likebtncnt" value="stratustes" /><input type="hidden" id="likedbtncnt"
                     value="stratust'd" />  -->
                  <div class=" new_arrivals ar_center prdtSlider">
                    <?php 

                     foreach($item_all as $key=>$eachitem)
                        {
                            $img_variable = $eachitem->photos;
                            $product_img = SITE_URL.'media/items/thumb350/'.$img_variable[0]->image_name;
                            $item_url = base64_encode($eachitem->id . "_" . rand(1, 9999));
                            $user_currency_price = $currencycomponent->conversion($eachitem['forexrate']['price'], $_SESSION['currency_value'], $eachitem->price);
                            $user_name = $eachitem['users']->user_name;
                            $favorte_count = $featured['fav_count'];

                         

                    ?>
                     <div class="item1 box_shadow_img">
                        <div class="product_cnt clearfix">
                           <div class="imgDescription">
                           <a class="img-hover1" href="<?php echo SITE_URL.'listing/'.$item_url; ?>">
                              <div class="bg_product">
                                 <img src="<?php echo $product_img;?>" class="img-responsive">
                              </div>
                           </a>
                           <div class="prodDescrip new_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                              <div class="prdDescrip">
                                 <div class="imgDes">
                                   <a class="" href="<?php echo SITE_URL.'listing/'.$item_url; ?>">
                                     <div class="desCri"><?php echo (strlen($eachitem['item_title']) > 28 ) ? substr($eachitem['item_title'], 0, 28).'..' : $eachitem['item_title'] ; ?></div> </a>
                                     
                                     
                                    <!--  <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span> -->
                                   </div>
                                   <div class="desIcon">
                                     <?php

                                     
            foreach ($eachitem['itemfavs'] as $useritemfav)
{
    if ($useritemfav->user_id == $loguser['id'])
    {
        $usecoun[] = $useritemfav->item_id;
    }
}
if (isset($usecoun) && in_array($eachitem['id'], $usecoun))
{
           
                $likeimage=SITE_URL.'images/icons/Heart_after_like@2x.png';
               echo' <span style="display:none;" id="like-txt' . $eachitem['id'] . '" class="like-txt' . $eachitem['id'] . '">' . $setngs['liked_btn_cmnt'] . '</span>';
               $status = 'liked';
            }
            else{
                $likeimage=SITE_URL.'images/icons/like.png';
                echo'<span style="display:none;" id="like-txt' . $eachitem['id'] . '" class="like-txt' . $eachitem['id'] . '">' . $setngs['like_btn_cmnt'] . '</span>';
                $status = 'unliked';
            }
                            ?>
                                      <a class="" href="javascript:void(0);" onclick="itemcouview(<?php echo $eachitem['id']; ?>)"><div class="likeIcon"><img id="like-icon<?php echo $eachitem['id'];?>" class="like-icon<?php echo $eachitem['id'];?>" src="<?php echo $likeimage;?>" alt="<?php echo $status;?>"></div></a>
                                      <a class="" href="#" onclick="share_posts1(<?php echo $eachitem['id']; ?>);" data-toggle="modal" data-target="#share-modal">
                                        <div class="shareIcon"><img src="<?php echo SITE_URL.'/img/share.png';?>" alt="share"></div></a>
                                   </div>
                                 </div>
                                       <?php
                                
                                //echo strtotime(date('Y-m-d'));

                                $price = $eachitem['price'];
                                $date = date('d');
                                $month = date('m');
                                $year = date('y');
                                $tdy = strtotime($month . '/' . $date . '/' . $year);
                                $newdate = new Time($featured['dealdate']);
                                $dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);
                                $dealstrtime = strtotime(date('Y-m-d'), strtotime($dealdate));
                                $todaystrtime = strtotime(date('Y-m-d'), $tdy);

                                  if(($eachitem['discount_type'] == 'daily' && 
                                     $dealstrtime == $todaystrtime) || ($eachitem['discount_type'] == 'regular'))
                                  {
                                     $dailydealdiscount = $eachitem['discount'];
                                     $unitPriceConvert = number_format((float)$price, 2, '.', '');
                                     $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);

                                     echo '<span id="price_vals'.$eachitem['id'].'" price_val="'.$_SESSION['currency_symbol'].$daily_price.'" style="display:none;width:0px !important;"></span>';
                                     ?>
                           <!--  <div class="price">&lrm;<?php //echo $eachitem['currency'].' '.$daily_price; ?> &lrm;<strike class="bold-font"><?php //echo $eachitem['currency'].' '.$eachitem['price']; ?></strike>
                            </div> -->

                            <div class="price">&lrm;<?php if(isset($_SESSION['currency_symbol'])) echo $_SESSION['currency_symbol'].' '.$daily_price; else 
                            echo $eachitem['currency'].' '.$daily_price; ?> 
                            <strike class="bold-font"><?php if(isset($_SESSION['currency_symbol']))  echo $_SESSION['currency_symbol'].' '.$eachitem['price']; else echo $eachitem['currency'].' '.$eachitem['price']; ?></strike>
                            </div>
                            <?php
                               }else{
                                ?>
                                <div class="price">&lrm;<?php echo $eachitem['currency'].' '.$eachitem['price']; ?>
                            </div>
                                <?php
                                   $item_title = $eachitem['item_title'];
$item_title_url = $eachitem['item_title_url'];
$item_price = $eachitem['price'];
$favorte_count = $eachitem['fav_count'];
$username = $eachitem['user']['username'];
$items_image = SITE_URL.'media/items/thumb350/'.$eachitem['photos'][0]['image_name'];
echo '<span id="figcaption_titles' . $eachitem['id'] . '" figcaption_title ="' . $item_title . '" style="display:none;"></span>';
echo '<span class="figcaption" id="figcaption_title_url' . $eachitem['id'] . '" figcaption_url ="' . $item_title_url . '" style="position: relative; top: 10px; left: 7px;display:none;" >' . $item_title_url . '</span>';
echo '<span id="price_vals' . $eachitem['id'] . '" price_val="' . $item_price . '" ></span>';
echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $eachitem['id'] . '" usernameval ="' . $username . '"></a>';
echo '<span class="fav_count" id="fav_count' . $eachitem['Item']['id'] . '" fav_counts ="' . $favorte_count . '" ></span>';
echo '<span id="img_' . $eachitem['id'] . '" class="nodisply" style="display:none;width:0px !important;">' . $items_image . '</span>';
                               }
                                ?>
                             <!--  <div class="price ">
                                 $600
                           </div> -->
                          <!--  <span id="price_vals6" price_val="$300"
                           style="display:none;width:0px !important;"></span> -->
                              </div>
                              
                           </div>
                           
                        </div>

                     </div>
                      
                   <?php }?>
                     
                  
                  </div>

               </div>
            </div>
         </div>
      </section>

<!-- 
      <section class="col-xs-12 col-sm-12 new-arrivals paddigs prdSlider clearfix">
         <div class="product_align_cnt  no-hor-padding">
            <div class="morePrdt allPdct">More Product</div>
            <div class="item-slider grid no-hor-padding">
               <div class="no-hor-padding product-sec-slide heroSlider-fixed">
                  <input type="hidden" id="likebtncnt" value="stratustes" /><input type="hidden" id="likedbtncnt"
                     value="stratust'd" /> 
                  <div class=" new_arrivals ar_center">
                     <div class="item1 box_shadow_img">
                        <div class="product_cnt clearfix">
                           <div class="imgDescription">
                           <a class="img-hover1" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                              <div class="bg_product">
                                 <img src="http://services.hitasoft.in/dev/stratus/media/items/original/1594104017_71.jpeg" class="img-responsive">
                              </div>
                           </a>
                           <div class="prodDescrip new_prod_nam bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                              <div class="prdDescrip">
                                 <div class="imgDes">
                                   <a class="" href="http://services.hitasoft.in/dev/stratus/listing/Nl81NDg1">
                                     <div class="desCri">Fossil Watches, 1170-BL-BR the track</div> </a>
                                     
                                     
                                     <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                                   </div>
                                   <div class="desIcon">
                                     <div class="likeIcon"><img src="./img/like.png" alt="like"></div>
                                     <div class="shareIcon"><img src="./img/share.png" alt="share"></div>
                                   </div>
                                 </div>
                              <div class="price ">
                                 $600
                           </div>
                           <span id="price_vals6" price_val="$300"
                           style="display:none;width:0px !important;"></span>
                              </div>
                              
                           </div>
                           
                        </div>

                     </div>

                 
                  </div>

               </div>
            </div>
         </div>
      </section> -->
   </section>
      <!-- Add to list popup -->
  <!-- Add to list popup -->
<div id="add-to-list" class="modal fade" role="dialog" tabindex="-1" >
  <div class="modal-dialog login-popup">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body padding_btm45_mobile padding-top30">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="share-container margin-bottom20">
          <div class="share-cnt-row">
            <h2 class="bold-font text-center">
              <?php echo __d('user', 'Add to your Collection'); ?></h2>
              <div class="popup-heading-border"></div>
            </div>
            <div class="share-cnt-row">
              <div class="share-details-cnt margin-top30">
                <?php 
                 $listitemimage = $item_datas['photos'][0]['image_name'];
                   $imageurl=SITE_URL . 'media/items/original/'.$listitemimage;
                ?>
                <div class="share-details">
                  <div class="col-sm-6 col-xs-12">
                    <img id="selectimgs" class="img-responsive center-block" 
                    src="<?php echo $imageurl;?>" width="325">
                  </div>
                  <div class="col-sm-6 col-xs-12">
                    <div class="right_border">
                      <form class="categorycls" id="categorycls">
                        <?php
foreach ($items_list_data as $list_item)
{
    echo '<div class="checkbox checkbox-primary padding-bottom15 edit_popup_border margin-bottom20">
                          <input id="' . $list_item['id'] . '" name="category_items[]" value="' . $list_item['lists'] . '" type="checkbox">
                          <label for="' . $list_item['id'] . '">' . $list_item['lists'] . '</label>
                          </div>';
}
/* foreach ($prnt_cat_data as $main_cat) {
  echo '<div class="checkbox checkbox-primary padding-bottom15 edit_popup_border margin-bottom20">
    <input id="' . $main_cat['id'] . '" name="category_items[]" value="' . $main_cat['category_name'] . '" type="checkbox">
    <label for="' . $main_cat['id'] . '">' . $main_cat['category_name'] . '</label>
  </div>';
} */
echo '<div class="appen_div" ></div>';
?>
</form>
</div>
<div class="input-group list_create">
  <input type="text" id="new-create-list" name="list_name" class="form-control no_border" placeholder="List Name">
  <span class="input-group-btn btn primary-color-bg" id="list_createid">
    <a href="javascript:void(0);" >
      <?php echo __d('user', 'Create'); ?></a>
    </span>
  </div><!-- /input-group -->
  <div id="listerr" style="display:none;color:red;font-size:13px;">
    <?php echo __d('user', 'Enter list name'); ?></div>
    <div id="existslisterr" style="display:none;color:red;font-size:13px;">
      <?php echo __d('user', 'Collection already exists'); ?></div>
    </div>
  </div>
</div>
</div>
</div>
<div class="share-cnt-row padding-top30 text-center">
  <a href="javascript:void(0);" id="btn-doneid" class="edit_popup_button btn primary-color-bg bold-font transparent_border"><?php echo __d('user', 'Done'); ?></a>
</div>
</div>
</div>
</div>
</div>
      
      <!-- Add to list popup -->
     <?php
$item_title = $item_datas['item_title'];
$item_title_url = $item_datas['item_title_url'];
$item_price = $item_datas['price'];
$favorte_count = $item_datas['fav_count'];
$username = $item_datas['user']['username'];
$items_image = SITE_URL.'media/items/thumb350/'.$item_datas['photos'][0]['image_name'];
echo '<span id="figcaption_titles' . $item_datas['id'] . '" figcaption_title ="' . $item_title . '" style="display:none;"></span>';
echo '<span class="figcaption" id="figcaption_title_url' . $item_datas['id'] . '" figcaption_url ="' . $item_title_url . '" style="display:none;" >' . $item_title_url . '</span>';
echo '<span id="price_vals' . $item_datas['id'] . '" price_val="' . $item_price . '" style="display:none;" ></span>';
echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $item_datas['id'] . '" usernameval ="' . $username . '"></a>';
echo '<span class="fav_count" id="fav_count' . $item_datas['Item']['id'] . '" fav_counts ="' . $favorte_count . '" style="display:none;" ></span>';
echo '<span id="img_' . $item_datas['id'] . '" class="nodisply" style="display:none;width:0px !important;">' . $items_image . '</span>';
?>
  <!-- Write Comment Modal-->
<div id="write-comment-modal" class="modal fade" role="dialog">
  <div class="modal-dialog downloadapp-modal">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="write-comment-container">
          <h2 class="bold-font margin-bottom10" >
            <?php echo __d('user', 'WRITE A COMMENT'); ?><label class="primary-color-txt">(<?php echo $item_datas['item_title']; ?>)</label></h2>
            <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
              <textarea class="form-control" rows="5" id="comment_msg" maxlength="180" onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"  autocomplete="off" placeholder="<?php echo __d('user', 'Comment'); ?> , @<?php echo __d('user', 'mention'); ?>, #<?php echo __d('user', 'hashtag'); ?>"></textarea>
              <div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
                <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0" role="menu" style="border:none;"></ul>
              </div>
              <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
                <button class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10" data-dismiss="modal">
                CANCEL</button>
                <button href="javascript:void(0);" id="commentssave" onclick ="return cmntsubmit();" class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10">
                  <?php echo __d('user', 'SUBMIT'); ?></button>
                </div>
                <div id="cmnterr" style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px"><?php echo __d('user', 'Please enter comment'); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Write comment modal -->

    <!-- Write a Question and answers-->
    <div id="write-question-ans-modal" class="modal fade" role="dialog">
  <div class="modal-dialog downloadapp-modal">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="write-comment-container">
          <h2 class="bold-font margin-bottom10" >
            <?php echo __d('user', 'Write a Question'); ?><label class="primary-color-txt">(<?php echo $item_datas['item_title']; ?>)</label></h2>
            <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
            <div id="errorspan_question"></div>
              <textarea class="form-control" rows="5" id="questions" maxlength="180" onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"  autocomplete="off"></textarea>
              <div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
                <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0" role="menu" style="border:none;"></ul>
              </div>
              <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
                <button class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10" data-dismiss="modal">
                CANCEL</button>
                <button href="javascript:void(0);" id="questionsave" onclick ="return questionsubmit();" class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10">
                  <?php echo __d('user', 'SUBMIT'); ?></button>
                </div>
                <div id="cmnterr" style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px"><?php echo __d('user', 'Please enter comment'); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Question and answer -->

    <!-- Read other answers -->
    <div id="read-other-answers-modal" class="modal fade" role="dialog">
  <div class="modal-dialog downloadapp-modal">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="write-comment-container">
          <h2 class="bold-font margin-bottom10" id="question_tag" >
            Q:is it good one?<label class="primary-color-txt">(55)</label></h2>
            
            <div class="answers">
              A: no above 5year.
            </div>
            <div class="answers">
              A: no above 4year.
            </div>
            <div class="answers">
              A: no above 2year.
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End read other answers-->




     <!-- Reply answer -->
      <div id="write-answer-modal" class="modal fade" role="dialog">
      <div class="modal-dialog downloadapp-modal">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="write-comment-container">
              <h2 class="bold-font margin-bottom10">
                <?php echo __d('user', 'Write Answer'); ?><label class="primary-color-txt">(<?php echo $item_datas['item_title']; ?>)</label></h2>
                <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                  <textarea class="form-control" rows="5" id="answer" maxlength="180"  autocomplete="off"></textarea>
                  <div class="comment-autocomplete comment-autocompleteNedit" style="top:126px;width:100%;">
                    <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0" role="menu"></ul>
                  </div>
                  <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
                    <button href="javascript:void(0);" id="commentssave" onclick ="return answersubmit();" class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10"><?php echo __d('user', 'Save Answer'); ?></button>
                  </div>
                  <input type="hidden" id="question_id">
                  <div id="editcmnterr" style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px"><?php echo __d('user', 'Please enter comment'); ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- End reply answer -->



    <!-- Edit Comment Modal-->
    <div id="edit-comment-modal" class="modal fade" role="dialog">
      <div class="modal-dialog downloadapp-modal">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="write-comment-container">
              <h2 class="bold-font margin-bottom10">
                <?php echo __d('user', 'EDIT COMMENT'); ?><label class="primary-color-txt">(<?php echo $item_datas['item_title']; ?>)</label></h2>
                <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                  <textarea class="form-control" rows="5" id="txt1val" maxlength="180" onkeyup="ajaxuserautocedits(event,this.value, 'txt1val','comment-autocompleteNedit','0');"  autocomplete="off" placeholder="<?php echo __d('user', 'Comment , @mention, #hashtag'); ?>"></textarea>
                  <div class="comment-autocomplete comment-autocompleteNedit" style="top:126px;width:100%;">
                    <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0" role="menu"></ul>
                  </div>
                  <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
                    <button href="javascript:void(0);" id="commentssave" onclick ="return editcmntssave();" class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10"><?php echo __d('user', 'Save Comment'); ?></button>
                  </div>
                  <input type="hidden" id="commentid">
                  <div id="editcmnterr" style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px"><?php echo __d('user', 'Please enter comment'); ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Edit comment modal -->
      <!-- Share Modal -->
      <div id="share-modal" class="modal fade" role="dialog">
        <div class="modal-dialog downloadapp-modal">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="share-container margin-bottom20">
                <div class="share-cnt-row">
                  <h2 class="bold-font text-center"><?php echo __d('user', 'SHARE THIS THING'); ?></h2>
                  <div class="popup-heading-border"></div>
                </div>
                <div class="share-cnt-row">
                  <div class="share-details-cnt margin-top30">
                    <?php
echo '<div class="share-details">
                    <div class="share-img margin-right20">
                                        <img id="share_img" class="img-responsive" src=""></div>
                    <div class="share-details-txt">
                    <div class="bold-font" id="share_title"></div>
                    <div class="">' . __d('user', 'By') . ' <span id="share_username"></span></div>
                    <div class="bold-font margin-top20" id="share_price"></div>
                    </div>
                    </div>';
?>
                  </div>
                </div>
                <div class="share-cnt-row">
                  <div class="share-details-cnt margin-top30 share-icons-cnt padding-top20 padding-bottom20">
                    <div class="share-details margin-top10 margin-bottom10">
                      <a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-facebook-official facebook" target="_blank"></a>
                      <a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-twitter-square twitter" target="_blank"></a>
                      <a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa  fa-google-plus-square google" target="_blank"></a>
                      <a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-linkedin-square linkedin" target="_blank"></a>
                      <a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');" class="share-icons fa fa-stumbleupon stumbleupon" target="_blank"></a>
                      <a href="" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share-icons fa fa-tumblr-square tumblr" target="_blank"></a>
                    </div>
                  </div>
                </div>
        <!--div class="share-cnt-row">
          <div class="share-details-cnt margin-top30">
            <a href="" class="share-popup-btn btn primary-color-bg bold-font">CANCEL</a>
          </div>
        </div-->
      </div>
    </div>
  </div>
</div>
</div>
<!-- Share modal -->
      <!-- Contact Seller Modal-->
      <div id="contact-seller-modal" class="modal fade" role="dialog">
         <div class="modal-dialog downloadapp-modal">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-body">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="write-comment-container">
                     <h2 class="bold-font centered-text relatived-position">
                        CONTACT SELLER</h2>
                     <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                        <div class="col-xs-12 col-sm-12 no-hor-padding bold-font margin-bottom10">
                           Query about item</div>
                        <div class="site-dd dropdown col-xs-12 col-sm-12 no-hor-padding margin-bottom20">
                           <div class="selectdiv">
                              <select id="queryaboutitem" class="dropdown-toggle">
                                 <option value="">Select a Query</option>
                                 <option value="subject">subject</option>
                                 <option value="subject new 1">subject new 1</option>
                                 <option value="subject new 2">subject new 2</option>
                                 <option value="subject new 3">subject new 3</option>
                                 <option value="others">Others</option>
                              </select>
                           </div>
                        </div>
                        <div class="cs-subject nodisply">
                           <div class="col-xs-12 col-sm-12 no-hor-padding bold-font margin-bottom10">
                              Subject</div>
                           <input
                              class="form-control popup-input col-xs-12 col-sm-12 col-md-12   no-hor-padding"
                              id="subject">
                        </div>
                        <div class="col-xs-12 col-sm-12 no-hor-padding bold-font margin-bottom10">
                           Message</div>
                        <textarea class="form-control popup-input" rows="5" maxlength="500" id="message"
                           placeholder="Type your message"></textarea>
                        <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                           <a href="javascript:void(0);" onclick="sendmessage('buyer');"
                              class="btn filled-btn follow-btn primary-color-bg margin-top10">
                              SEND</a>
                        </div>
                        <div class="cs-error trn red-txt">Error</div>
                        <div class="trn" id="messageErr" style="color: red;"></div>
                        <div class="cs-success">Message Sent Successfully</div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Contact seller modal -->
      <!-- Selfie Modal-->
      <div id="selfie-modal" class="modal fade" role="dialog">
         <div class="modal-dialog selfie-modal">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-body">
                  <div class="selfie-modal-container">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <div class="selfie-modal-image col-xs-12 col-sm-12 no-hor-padding">
                        <img src="" id="fashionimage">
                     </div>
                     <div class="selfie-modal-info col-xs-12 col-sm-12 margin-top30">
                        <div class="selfie-modal-prof-pic" id="fashionuserimage"></div>
                        <div class="selfie-modal-prof-name bold-font" id="fashionusername"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Selfie Modal-->
    <div id="selfie-modal" class="modal fade" role="dialog">
      <div class="modal-dialog selfie-modal">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <div class="selfie-modal-container">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="selfie-modal-image col-xs-12 col-sm-12 no-hor-padding">
                <img src="" id="fashionimage"></div>
                <div class="selfie-modal-info col-xs-12 col-sm-12 margin-top30">
                  <div class="selfie-modal-prof-pic" id="fashionuserimage"></div>
                  <div class="selfie-modal-prof-name bold-font" id="fashionusername"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--- Selfie Modal --->
      <!-- Seller review Modal-->
      <div id="seller-review-modal" class="modal fade" role="dialog">
         <div class="modal-dialog downloadapp-modal">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-body">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="write-comment-container">
                     <h2 class="bold-font centered-text relatived-position">
                        <?php echo __d('user','SELLER REVIEW');?></h2>
                     <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                        <div class="col-xs-12 col-sm-12 no-hor-padding bold-font margin-bottom10">
                           <?php echo __d('user','Rating');?></div>
                        <br />
                        <!--<form id="ratingsForm0">
                                                            <div class="stars margin_top5min">
                                                                <input type="radio" name="star" class="star-1" id="star-1" />
                                                                <label class="star-1" for="star-1" onclick="ratingClick('1');">1</label>
                                                                <input type="radio" name="star" class="star-2" id="star-2" />
                                                                <label class="star-2" for="star-2" onclick="ratingClick('2');">2</label>
                                                                <input type="radio" name="star" class="star-3" id="star-3" />
                                                                <label class="star-3" for="star-3" onclick="ratingClick('3');">3</label>
                                                                <input type="radio" name="star" class="star-4" id="star-4" />
                                                                <label class="star-4" for="star-4" onclick="ratingClick('4');">4</label>
                                                                <input type="radio" name="star" class="star-5" id="star-5" />
                                                                <label class="star-5" for="star-5" onclick="ratingClick('5');">5</label>
                                                                <span></span>
                                                            </div>
                                                        </form>-->
                        <br />
                        <!--<center><span class="current-rate">0</span> Out of 5</center>-->
                        <!--<input type="hidden" id="rateval">-->
                        <div class="col-xs-12 col-sm-12 no-hor-padding bold-font margin-bottom10">Order Id</div>
                        <div class="site-dd dropdown col-xs-12 col-sm-12 no-hor-padding margin-bottom20">
                           <select id="ordername" class="dropdown-toggle"></select>
                        </div>
                        <div class="col-xs-12 col-sm-12 no-hor-padding bold-font margin-bottom10">
                           Review Title :</div>
                        <textarea class="form-control" rows="5" id="review_title" maxlength="50"></textarea>
                        <div class="col-xs-12 col-sm-12 no-hor-padding bold-font margin-bottom10">
                           Your Review :</div>
                        <textarea class="form-control" rows="5" id="review" maxlength="250"></textarea>
                        <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                           <a href="javascript:void(0);" onclick="review(203,70)"
                              class="btn filled-btn follow-btn primary-color-bg margin-top10">SEND</a>
                        </div>
                        <input type="hidden" id="uname" value="Demo">
                        <div style="color:red;font-size:13px;display:none;margin-right:30px;margin-top:3px;" class="trn"
                           id="raterr"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Seller review modal -->
      
      <div id="fb-root"></div>
     


      <div id="editreview" class="modal fade" role="dialog">
         <div class="modal-dialog downloadapp-modal">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-body">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="write-comment-container">
                     <h2 class="bold-font margin-bottom10">
                        Edit review <label class="primary-color-txt">fdgdfgf</label>
                     </h2>

                     <div id="ratingerrorspan">

                     </div>
                     <div class="rev_star_sec">

                        <br />
                        <!--<form id="ratingsForm0">
                                                            <div class="stars margin_top5min">
                                                                <input type="radio" name="star" class="star-1" id="star-1" />
                                                                <label class="star-1" for="star-1" onclick="ratingClick('1');">1</label>
                                                                <input type="radio" name="star" class="star-2" id="star-2" />
                                                                <label class="star-2" for="star-2" onclick="ratingClick('2');">2</label>
                                                                <input type="radio" name="star" class="star-3" id="star-3" />
                                                                <label class="star-3" for="star-3" onclick="ratingClick('3');">3</label>
                                                                <input type="radio" name="star" class="star-4" id="star-4" />
                                                                <label class="star-4" for="star-4" onclick="ratingClick('4');">4</label>
                                                                <input type="radio" name="star" class="star-5" id="star-5" />
                                                                <label class="star-5" for="star-5" onclick="ratingClick('5');">5</label>
                                                                <span></span>
                                                            </div>
                                                        </form>-->

                        <fieldset class="rating">
                           <input type="radio" id="star5" onclick="ratingClick('5');" name="rating" value="5">
                           <label class="full" for="star5" title="Awesome - 5 stars">

                           </label>
                           <input type="radio" id="star4half" onclick="ratingClick('4.5');" name="rating"
                              value="4 and a half">
                           <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>

                           <input type="radio" id="star4" onclick="ratingClick('4');" name="rating" value="4">
                           <label class="full" for="star4" title="Pretty good - 4 stars"></label>

                           <input type="radio" id="star3half" onclick="ratingClick('3.5');" name="rating"
                              value="3 and a half">
                           <label class="half" for="star3half" title="Meh - 3.5 stars"></label>

                           <input type="radio" id="star3" onclick="ratingClick('3');" name="rating" value="3">
                           <label class="full" for="star3" title="Meh - 3 stars"></label>

                           <input type="radio" id="star2half" onclick="ratingClick('2.5');" name="rating"
                              value="2 and a half">
                           <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>

                           <input type="radio" id="star2" name="rating" value="2">
                           <label class="full" for="star2" title="Kinda bad - 2 stars"></label>

                           <input type="radio" id="star1half" onclick="ratingClick('2');" name="rating"
                              value="1 and a half">
                           <label class="half" for="star1half" title="Meh - 1.5 stars"></label>

                           <input type="radio" id="star1" onclick="ratingClick('1');" name="rating" value="1"
                              checked="checked">
                           <label class="full" for="star1" title="Sucks big time - 1 star"></label>

                           <input type="radio" id="starhalf" onclick="ratingClick('0.5');" name="rating" value="half">
                           <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                        </fieldset>

                        <div class="reviews ">
                           <div class="current-rate"> </div>
                        </div>

                        <input type="hidden" id="rateval">
                        <input type="hidden" id="user_id" value="" />

                        <input type="hidden" id="item_id" value="">
                        <input type="hidden" id="order_id" value="">

                     </div>


                     <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                        <textarea class="form-control" rows="5" name="review" id="edit_review_data" maxlength="180"
                           onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"
                           autocomplete="off" placeholder="Write a Review"></textarea>
                        <div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
                           <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0" role="menu"
                              style="border:none;"></ul>
                        </div>
                        <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
                           <button class="btn filled-btn follow-btn primary-color-bg pull-right margin-top10"
                              data-dismiss="modal">
                              CANCEL</button>
                           <button href="javascript:void(0);" onclick="return updatereview(this);" id=""
                              class="btn filled-btn follow-btn primary-color-bg review_id pull-right margin-top10">
                              SUBMIT</button>
                        </div>
                        <div id="cmnterr"
                           style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px">
                           Please enter comment</div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade" id="report_order" role="dialog" tabindex="-1">
         <div class=" modal-dialog">
            <div class="modal-content">
               <div class=" login-body modal-body clearfix">
                  <button class="close" type="button" data-dismiss="modal">×</button>
                  <div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12   ">
                     <h2
                        class="popupheder login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12   no-hor-padding">
                        <?php echo __d('user','Report this as inappropriate or broken ?');?></h2>
                  </div>
                  <div class=" share-cnt-row col-md-12 padding-bottom10">
                     <button id="reportflag"
                        class="margin-bottom10  btn txt-uppercase primary-color-bg bold-font"><?php echo __d('user','Yes');?></button>
                     <a class="cancelpop margin-bottom10 btn txt-uppercase primary-color-border-btn bold-font margin-left10 no"
                        data-dismiss="modal" href="javascript:void(0);">
                        <?php echo __d('user','No');?></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="undoreport_order" role="dialog" tabindex="-1">
         <div class=" modal-dialog">
            <div class="modal-content">
               <div class=" login-body modal-body clearfix">
                  <button class="close" type="button" data-dismiss="modal">×</button>
                  <div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12   ">
                     <h2
                        class="popupheder login-header-text bold-font txt-uppercase col-xs-12 col-sm-12 col-md-12   no-hor-padding reporttxt trn">
                        <?php echo __d('user','Cancel report this ?');?></h2>
                  </div>
                  <div class=" share-cnt-row col-md-12 padding-bottom10">
                     <button id="unreportflag"
                        class="margin-bottom10  btn txt-uppercase primary-color-bg bold-font"><?php echo __d('user','Yes');?></button>
                     <a class="cancelpop margin-bottom10 btn txt-uppercase primary-color-border-btn bold-font margin-left10 no"
                        data-dismiss="modal" href="javascript:void(0);">
                        <?php echo __d('user','No');?></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
     
   </section>
   <!-- filters -->
    <section class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <div class="cateGory">
          <div class="category">
            <div id="sidebar">
              <div class="sidebar__inner border_right_grey" style="position: relative; ">
               
                <div id="accordion1" class="panel-group margin-bottom0">
                  <div id="" class="panel panel-default box_shadow0">
                    <div class="panel-heading padding0">
                      <a data-toggle="collapse" data-parent="#accordion1" href="#collapsezero" class=""
                        aria-expanded="true">
                        <h4 class="panel-title bold-font filter_accordion accordion_shop primary-color-bg white-txt">
                          <div class="inlined-display shop_filter_menu_padding">
                            <?php echo __d('user','Filters');?></div><i class="more-less glyphicon glyphicon-plus bold-font"></i>

                        </h4>
                      </a>
                    </div>
                    <div id="collapsezero" class="filteraccordian colla-hei panel-collapse collapse" aria-expanded="true">
                      <div class="no-hor-padding padding-top0">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                           <div class="parent">
                  <form action="<?php echo SITE_URL.'searchproduct'?>" method="post">
                  <input type="search" placeholder="<?php echo __d('user','Search here...');?>" class="" name="searchkey">
                  <div class="price_range">
                    <p><?php echo __d('user','Price Range');?></p>
                    <div class="priceSlider">
                   
                      <input id="range" type="range" min="0" max="5000" value="5000">
                    </div>
                      <span id="value" ></span>
                     <input type="hidden" id="price_value"  name="price" />
                  </div>

                  <input type="submit" class="btn primary-color-bg primary-color-bg deals" value="<?php echo __d('user','Search');?>" />
                </form>
                </div>
                          <div class="panel panel-default">
                            <div class="panel-heading padding0" role="tab" id="headingOne">
                              <a role="button" class="accordion_one" data-toggle="collapse" data-parent="#accordion"
                                href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title accordion_shop bold-font">
                                  <div class="inlined-display shop_filter_menu_padding">
                                    <?php echo __d('user','Categories');?></div><!-- <i class="more-less glyphicon glyphicon-minus"></i> -->

                                </h4>
                              </a>
                            </div>

                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                              aria-labelledby="headingOne">
                              <div class="panel-body list_menu" style="max-height: 350px">

                                <?php foreach($parent_categories as $parent_cat){
                                        $imageurl = SITE_URL.'images/category/'.$parent_cat->category_webicon;

                                  ?>
                                <a class="shop_menu" data-parent="#nested"
                                  href="<?php echo SITE_URL.'shop/'.$parent_cat->category_urlname;?>">
                                  <div class="icon">
                                    <img src="<?php echo $imageurl;?>">
                                  </div>
                                  <h4 class="panel-title sub_menu_panel"><?php echo $parent_cat->category_name?></h4>
                                </a>
                                <?php }?>
                              

                               
                              </div>
                            </div>
                          </div>


                        </div>



                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <object
                style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;"
                type="text/html"></object>
            </div>
          </div>
        </div>
      </section>
   <!-- E O filters -->
   <!-- script for header dropdown  -->
   <script>
//        $( ".logo" ).hover(function() {
         
//          if($(".drop").hasClass("open")){
//             $(".logoArrow").css('-webkit-transform', 'rotate(1turn)');
//   $(".logoArrow").css('-moz-transform', 'rotate(1turn)');
//   $(".logoArrow").css('transform', 'rotate(1turn)');
        
//       }
//       else{
//          $(".logoArrow").css('-webkit-transform', 'rotate(0.5turn)');
//   $(".logoArrow").css('-moz-transform', 'rotate(0.5turn)');
//   $(".logoArrow").css('transform', 'rotate(0.5turn)');

        
//       }
//        });
// $( ".logo" ).hover(function() {
//    $('.logoArrow i').toggleClass('rotate');
//     $('.logoArrow i').toggleClass('rotate-reset');
//        });
//        $( ".logoArrow" ).hover(function() {
//    $('.logoArrow i').toggleClass('rotate');
//     $('.logoArrow i').toggleClass('rotate-reset');
//        });
    
   </script>
   <script>
   //     $('.drop').hover(function() {
       
   //     $( '.dropdown-toggle', this ).trigger( 'click' );
   //   $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
   // }, function() {
   //   $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
   // });
   </script>
   <script>
      $(".currenCy").mouseover(function(){
        $( '.dropdown-toggle', this ).trigger( 'click' );
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    });
      $('.currenCy').hover(function() {
       
        $( '.dropdown-toggle', this ).trigger( 'click' );
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });
    </script>
   
   <!-- <script>
      $(".userProfDrop").mouseover(function(){
        $( '.dropdown-toggle', this ).trigger( 'click' );
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    });
      $('.userProfDrop').hover(function() {
       
        $( '.dropdown-toggle', this ).trigger( 'click' );
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });
    </script> -->
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <!-- Magnific Popup -->
   <!-- staggered grid js -->
   <!-- https://www.elevateweb.co.uk/wp-content/themes/radial/jquery.elevatezoom.min.js -->
   <!-- <script src="https://kenwheeler.github.io/slick/slick/slick.js"></script>
   <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
   <script type="text/javascript" src="https://www.elevateweb.co.uk/wp-content/themes/radial/jquery.elevatezoom.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
 <script>
  
   //  script for zoom 
    //if(window.matchMedia("(min-width: 767px)").matches){
      console.log("not mobile");
$("#zoom_03").elevateZoom({
  
    gallery:'gallery_01',
    cursor: 'pointer',
  easing : true,
    galleryActiveClass: 'active',
    imageCrossfade: true,
    loadingIcon: 'https://www.elevateweb.co.uk/spinner.gif'
});
//}

// $("#zoom_03").bind("click", function(e) {
//   // alert("fhjkd")
//     var ez = $('#zoom_03').data('elevateZoom');
//     $.fancybox(ez.getGalleryList());
//     return false;
// });
 </script>
  
   <script src="<?php echo $baseurl;?>js/salvattore.min.js"></script>
       <script src="<?php echo SITE_URL.'js/frontjs/slider.js';?>"></script>
       <script src="<?php echo SITE_URL.'js/multiple-emails.js';?>"></script>
       <script src="<?php echo SITE_URL.'js/frontjs/custom.js';?>"></script>
       <?php
       if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
       {
        ?>
        <script src="<?php echo SITE_URL.'js/frontjs/slider_rtl.js';?>"></script>
        <?php } else { ?>
        <script src="<?php echo SITE_URL.'js/frontjs/slider_ltr.js';?>"></script>
        <?php } ?>
        <script src="<?php echo SITE_URL.'js/jquery.translate.js';?>"></script>
        <script src="<?php echo SITE_URL.'js/translate.js';?>"></script>
   <!-- Main JS -->
   <!-- script for fixed side bar  -->
  <!--  <script>
      $(document).scroll(function () {
         if ($('.category').offset().top + $('.category').height() >= $('footer').offset().top - 10) {
            $('.category').css('position', 'absolute');
            $('.category').css('max-width', '100%');
         }

         if ($(document).scrollTop() + window.innerHeight < $('footer').offset().top) {
            $('.category').css('position', 'fixed');
            $('.category').css('max-width', '22%');
            //  $(".category").addClass("new");
         }

      });
   </script> -->

<!-- script for img toggle  -->
<script>
      var BaseURL = getBaseURL();
//    var togSrc = [ BaseURL+"./img/like.png", BaseURL+"./img/Heart after like@2x.png" ];

// $(".tog").click(function() {
// this.src =  togSrc.reverse()[0];
// });
</script>
<script>
  // var togSrc1 = [ BaseURL+"./img/like.png", BaseURL+"./img/Heart filled@2x.png" ];

// $(".likeIcon img").click(function() {
// this.src =  togSrc1.reverse()[0];
// });
</script>
<script>
   //var togSrc2 = [ BaseURL+"./img/share.png", BaseURL+"./img/Share filled.png" ];

// $(".shareIcon img").click(function() {
// this.src =  togSrc2.reverse()[0];
// });
</script>

   <script type="text/javascript">

      $(document).ready(function () {
         setTimeout(function () { $("#notify-message").hide(); }, 5000);
      });
      function shownotiresp() {
         var BaseURL = getBaseURL();
         var loguserid = $('#logguserid').val();
         //var loadingimg = $('.loading').val();
         if (pushnoii) {
            pushnoii = false;
            //alert(loguserid);
            $.ajax({
               url: BaseURL + "getpushajax/",
               type: "post",
               data: { 'loginuserid': loguserid },
               dataType: "html",
               beforeSend: function () {
                  $('.loading').show();
                  //$(button).attr("disabled", "disabled");
               },
               success: function (responce) {
                  //alert(responce);
                  $('#noticnts').hide();
                  //$(".feed-notification").show();
                  $('#pushappends').html(responce);
               }
            });
         }
      }

      /***************search menu***************************/

      $(function () {
         var availableTags = [
            "ActionScript",
            "AppleScript",
            "Asp",
            "BASIC",
            "C",
            "C++",
            "Clojure",
            "COBOL",
            "ColdFusion",
            "Erlang",
            "Fortran",
            "Groovy",
            "Haskell",
            "Java",
            "JavaScript",
            "Lisp",
            "Perl",
            "PHP",
            "Python",
            "Ruby",
            "Scala",
            "Scheme"
         ];
         $(".tags").autocomplete({
            source: availableTags
         });
      });


      /************Nav right to left slide************/
   </script>


 <!-- <style type="text/css">
   .price-tag {
      display: inline-block;
      margin: 0 10px;
      font-weight: bold;
      font-size: 14px;
   }

   .price-strike {
      font-size: 14px;
      margin: 0;
   }

   .percentage_tag {
      padding: 2px 6px 2px 6px;
   }
</style> -->

<script>
   window.fbAsyncInit = function () {
      FB.init({
         appId: '359140918389960'
         // status     : true,
         // xfbml      : true,
         // version    : 'v2.4'
      });
   };
   (function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) { return; }
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js";
      fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   function showmoredesc() {
      $('.ellipses').hide();
      $('.moredesc').slideToggle();
      $('.moredesc').css('display', 'inline');
      $('.showmoredesc').hide();
      $('.hidemoredesc').show();
      moredesc = $("#moremoredesc").val();
      $(".moredesc").html(moredesc).text();
   }
   function lessmoredesc() {
      $('.ellipses').show();
      $('.moredesc').slideToggle();
      $('.moredesc').css('display', 'none');
      $('.showmoredesc').show();
      $('.hidemoredesc').hide();
   }
</script>

<script>

   $('.new_arrivals').slick({
      slidesToShow: 3,
      // rtl: true,
      arrows: true,
      // centerMode: true,
      infinite: false,
      responsive: [
         {
            breakpoint: 992,
            settings: {
               arrows: true,
               centerMode: false,
               slidesToShow: 3,
               slidesToScroll: 1,
               // rtl: true,

            }
         },
         {
            breakpoint: 767,
            settings: {
               arrows: true,
               centerMode: false,
               slidesToShow: 2,
               slidesToScroll: 1,
               // rtl: true,

            }
         },
         {
            breakpoint: 600,
            settings: {
               arrows: true,
               centerMode: false,
               slidesToShow: 1,
               slidesToScroll: 1,
               // rtl: true,
            }
         },
         {
            breakpoint: 320,
            settings: {
               arrows: true,
               centerMode: false,
               slidesToShow: 1,
               slidesToScroll: 1,
               // rtl: true,
            }
         },
      ]
   });


   $('.new_arrivals_deal').slick({
      slidesToShow: 3,
      arrows: true,
      infinite: false,
      responsive: [
         {
            breakpoint: 992,
            settings: {
               arrows: true,
               centerMode: false,
               slidesToShow: 2,
               slidesToScroll: 1,

            }
         },
         {
            breakpoint: 600,
            settings: {
               arrows: true,
               centerMode: false,
               slidesToShow: 1,
               slidesToScroll: 1,
               // rtl: true,
            }
         },
      ]
   });


</script>


<script type="text/javascript">
   $(".button").on("click", function () {
    //alert("here");
      var $button = $(this);
      var oldValue = $("#qty-counter").val();
      var quantity = $("#quantity_val").val();
      if ($button.text() == "+") {
         if (oldValue < parseFloat(quantity))
            var newVal = parseFloat(oldValue) + 1;
      } else {
         // Don't allow decrementing below zero
         if (oldValue > 1) {
            var newVal = parseFloat(oldValue) - 1;
         } else {
            newVal = 1;
         }
      }
      $("#qty-counter").val(newVal);
   });
</script>
<style type="text/css">
   label.primary-color-txt {
      padding: 5px 0px;
      display: block;
      font-size: 15px;
      word-break: break-all;
      margin-top: 10px;
      font-weight: 500;
   }

   .site-dd select {
      background-color: transparent;
      border: 1px solid #dbdbdd;
      padding: 7px 10px;
      text-align: left;
      width: 100%;
   }

   .errcls {
      display: none;
   }
</style>
<script>

   (function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) { return; }
      js = d.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<script type="text/javascript">


   document.getElementById("facebooksharebtn").addEventListener("click", function (e) {
      e.preventDefault();
      window.fbAsyncInit = function () {
         FB.init({
            appId: appID,
            autoLogAppEvents: true,
            xfbml: true,
            version: 'v3.2'
         });
      };


      window.facebookShare = function (callback) {
         //alert('hi');
         var options = ({
            method: 'share',
            href: urlss
         }),
            status = '';

         FB.ui(options, function (response) {

            if (response && !response.error_code) {
               status = 'success';
               console.log('success');
               $.ajax({
                  url: BaseURL + 'sociallogin',
                  type: 'post',
                  data: {
                     'itemId': itemId,
                     'shopId': shopId
                  },
                  beforeSend: function () {
                     $('#popup_container').show();
                     $('#popup_container').css({
                        "opacity": "1"
                     });
                     $(".loading-coupon").show();
                     $('#facebook_coupon').show();
                  },
                  success: function (data) {

                     if (data != 'false') {
                        $('#share-social').hide();
                        $('#slideshow-box').hide();
                        $('#popup_container').show();
                        $('#popup_container').css({
                           "opacity": "1"
                        });
                        $(".loading-coupon").hide();
                        $('#new-couponcode').html('Your coupon code - <span class="red-txt">' + data + '</div>');
                        $('#facebook_coupon').show();
                        $('#facebooksharebtn').hide();
                     }
                  }
               });

            } else {
               status = 'error';
               console.log('error');
            }

            if (callback && typeof callback === "function") {
               callback.call(this, status);
            } else {
               return response;
            }
         });

      };


      var link = $('#discount_fb_share_url').html();
      var BaseURL = getBaseURL();
      var urlss = BaseURL + 'listing/' + link;
      var image = $('#fullimgtag').attr('src');
      var desc = $('#item-descript').val();
      var title = $('#fullimgtag').attr('title');
      var itemId = $('#listingid').val();
      var shopId = $('#merchantid').val();
      var appID = $("#default_fb_appid").val();
      var encry_urlss = encodeURIComponent(urlss);

      facebookShare(function (response) {
         // simple function callback
         console.log(response);
      });
   });

   $("textarea").keyup(function () {
      if ($(this).text().length > 500) {
         var text = $(this).text();
         $(this).text(text.substr(0, 500));
      }
   });

</script>

   <script>
      $(() => {
         var createSlick = () => {
            let slider = $(".Popular_sliders");


            slider.not('.slick-initialized').slick({
               rtl: rtl_slick(),
               autoplay: false,
               infinite: false,
               // rtl: false,
               arrows: false,
               slidesToShow: 3,
               slidesToScroll: 1,
               responsive: [
                  {
                     breakpoint: 1024,
                     settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        // rtl: true,
                        arrows: false,
                        adaptiveHeight: true,
                     },
                  },

                  {
                     breakpoint: 992,
                     settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        // rtl: true,
                        arrows: false,
                        adaptiveHeight: true,
                     },
                  },

                  {
                     breakpoint: 600,
                     settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        // rtl: true,
                        centerMode: false,
                        arrows: false,


                     },
                  },
               ],
            });
         }

         createSlick();

         $(window).on('resize orientationchange', createSlick);
      })
   </script>

   <script>

      $(document).ready(function () {

         $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: false,
            draggable: false,
            arrows: false,
            centerMode: true,
            fade: true,
            asNavFor: '.slider-nav'
         });
         $('.slider-nav').slick({
            slidesToShow: 4, // 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: true,
            // centerMode: true,

            infinite: false,
            arrows: true,
            focusOnSelect: true,

            responsive: [
               {
                  breakpoint: 1024,
                  settings: {
                     infinite: false,
                     slidesToShow: 4,
                     slidesToScroll: 1,
                     focusOnSelect: true
                  },
               },
               {
                  breakpoint: 600,
                  settings: {
                     infinite: false,
                     slidesToShow: 4,
                     slidesToScroll: 1,
                     focusOnSelect: true

                  },
               },

               {
                  breakpoint: 480,
                  settings: {
                     infinite: false,
                     arrows: true,
                     slidesToShow: 3,
                     slidesToScroll: 1,

                  },
               }


            ],
         });

         $('.slider-for1').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            centerMode: true,
            draggable: false,
            infinite: false,
            fade: true,
            asNavFor: '.slider-nav1'
         });
         $('.slider-nav1').slick({
            slidesToShow: 4, // 3,
            slidesToScroll: 3,
            asNavFor: '.slider-for1',
            dots: true,
            arrows: true,
            infinite: false,

            // centerMode: true,
            focusOnSelect: true,


            responsive: [
               {
                  breakpoint: 1024,
                  settings: {
                     infinite: false,
                     slidesToShow: 4,
                     slidesToScroll: 1,
                     focusOnSelect: true
                  },
               },
               {
                  breakpoint: 600,
                  settings: {
                     infinite: false,
                     slidesToShow: 4,
                     slidesToScroll: 1,
                     focusOnSelect: true

                  },
               },

               {
                  breakpoint: 480,
                  settings: {
                     infinite: false,
                     arrows: true,
                     slidesToShow: 3,
                     slidesToScroll: 1,

                  },
               }


            ],
         });


         $('.slider-for2').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            centerMode: true,
            draggable: false,
            infinite: false,
            fade: true,
            asNavFor: '.slider-nav2'
         });
         $('.slider-nav2').slick({
            slidesToShow: 4, // 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for2',
            dots: true,

            arrows: true,
            infinite: false,
            // centerMode: true,
            focusOnSelect: true,
            responsive: [
               {
                  breakpoint: 1024,
                  settings: {
                     infinite: false,
                     slidesToShow: 4,
                     slidesToScroll: 1,
                     focusOnSelect: true
                  },
               },
               {
                  breakpoint: 600,
                  settings: {
                     infinite: false,
                     slidesToShow: 4,
                     slidesToScroll: 1,
                     focusOnSelect: true

                  },
               },

               {
                  breakpoint: 480,
                  settings: {
                     infinite: false,
                     arrows: true,
                     slidesToShow: 3,
                     slidesToScroll: 1,

                  },
               }


            ],
         });


      });

   </script>

   <!-- vertical sliders  -->

   <script>
      $(document).ready(function () {

         $('.slider-verical_for3').each(function (key, item) {

            var sliderIdName = 'slider' + key;
            var sliderNavIdName = 'sliderNav' + key;

            this.id = sliderIdName;
            $('.slider-verical_nav3')[key].id = sliderNavIdName;

            var sliderId = '#' + sliderIdName;
            var sliderNavId = '#' + sliderNavIdName;

            $(sliderId).slick({
               slidesToShow: 1,
               slidesToScroll: 1,
               arrows: false,
               centerMode: true,
               fade: true,
               draggable: false,
               speed: 100,
               infinite: false,
               asNavFor: sliderNavId
            });

            $(sliderNavId).slick({
               slidesToShow: 4, // 3,
               slidesToScroll: 1,
               vertical: true,
               verticalSwiping: true,
               asNavFor: sliderId,
               dots: true,
               draggable: false,
               centerMode: true,
               centerPadding: '10px',
               infinite: false,
               arrows: true,
               focusOnSelect: true,

               responsive: [
                  {
                     breakpoint: 992,
                     settings: {
                        arrows: true,
                        infinite: false,
                        // rtl: true,
                        vertical: false,
                        centerMode: false,
                        slidesToShow: 4,
                        slidesToScroll: 1,

                     }
                  },
                  {
                     breakpoint: 480,
                     settings: {
                        arrows: true,
                        infinite: false,
                        // rtl: true,
                        vertical: false,
                        infinite: false,
                        centerMode: false,
                        arrows: true,
                        slidesToShow: 3,
                        slidesToScroll: 1,
                     }
                  },


               ],
            });

         });
      });
   </script>




 




   <script>
      function rtl_slick() {
         if ($('body').hasClass("rtl")) {
            return true;
         } else {
            return false;
         }
      }
      function setcategory(org)
  {
    $("#currentCategory").val(org.id);
    selectedCategory = $('#currentCatPath').val();
    var priceRange;var color;var sortPrice;var categoryId;
    $("input[name='price']:checked").each( function () {
      priceRange = $(this).val();
    });
    $("input[name='color']:checked").each( function () {
      color = $(this).val();
    });
    sortPrice = $("#sortvalue").val();
    if( typeof (priceRange) == 'undefined'){
      priceRange = "";
    }
    if( typeof (color) == 'undefined'){
      color = "";
    }
    if( typeof (sortPrice) == 'undefined'){
      sortPrice = "";
    }

    var searchKey = $('.search-string').val();
    var baseurl = getBaseURL()+"getItemByCategoryView";


    categoryId = $("#currentCategory").val();

    if(typeof(categoryId) == 'undefined')
    {
      categoryId = $('#hiddencatvalue').val();
    }

    $.ajax({
      url: baseurl,
      type: "post",
      data: {price : priceRange, color:color, category:selectedCategory, catids:categoryId, sortPrice:sortPrice, q:searchKey},
      dataType: "html",
      beforeSend: function () {
        //$('.stream').fadeOut("slow","linear");
        //$('.itemLoader').show();
    //$('.stream').hide();
  },
  success: function(responce){

    if($.trim(responce) == "")
    {
      $('.stream').html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
    }else if($.trim(responce) != 'false')
      {

          $('.stream').html(responce);
      }else
          $(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
          var sessionlang = $("#languagecode").val();
          var translator = $('body').translate({t: dict});
          translator.lang(sessionlang);
            //$('.stream').fadeIn("slow","linear");
            sIndex = 20;
            isDataAvailable = true;

    /*
    var tempp = responce.split('///');
    $('#catname').html(tempp[0]);
      $('#changecatname').html(tempp[0]);
      
        if($.trim(tempp[1]) == "")
        {
          $('.stream').html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
        }

        else if($.trim(tempp[1]) != 'false')
        {

          $('.stream').html(tempp[1]);
        }
        else
          $(".stream").html('<div class="text-center padding-top30 padding-bottom30"><div class="outer_no_div"><div class="empty-icon no_products_icon"></div></div><h5 class="trn">No Products</h5></div>');
        var sessionlang = $("#languagecode").val();
        var translator = $('body').translate({t: dict});
        translator.lang(sessionlang);
          //$('.stream').fadeIn("slow","linear");
          sIndex = 21;
          isDataAvailable = true;
          */
      }
  });
  }
//   $('#qty-counter').change(function(){
//     alert("works");
//     alert($(this).val());
// })
 function refreshList(){
  console.log("refreshList called");
  $('.selectpicker').selectpicker('refresh');
 }
   </script>
   <style>
      #ui-id-1.ui-menu {
         overflow-x: hidden;
         overflow-y: scroll;
         min-height: 50px;
         max-height: 150px;
      }


      .scrollbar {
         padding: 0 11px;
      }
      .zoomWrapper img{
        width:250px!important;
        height:250px!important;
      }
     /* #gallery_01 img{
         width:75px!important;
        height:auto!important;
      }*/
      a{
        cursor: pointer!important;
      }
      
      #figcaption_titles{
        display:none!important;
        width:0px!important;
      }

      .affiliate_text{
        color: #1B33B7;
        padding-left: 10px;

      }

      .affiliate_items{
        display: flex;
        align-items: center;
        flex-direction: row-reverse;
        margin: 15px 0 10px 0;
        justify-content: flex-end;

      }
     
     /* @media(min-width:767px) {
         .percentage_tag{
        margin-top: 10px;
    margin-left: 5px;
      }

}*/
@media (min-width: 360px) and (max-width: 767px) {
  .mainPage .ques-ans_sec{
    margin-left:15px!important;
  }
}
   </style>
   <script>
$(document).ready(function(){
    if(window.matchMedia("(max-width: 767px)").matches){
        // The viewport is less than 768 pixels wide
        // alert("This is a mobile device.");
        $(".filteraccordian").removeClass('in');

    } else{
        // The viewport is at least 768 pixels wide
       // alert("This is a tablet or desktop.");
       $(".filteraccordian").addClass('in');
    }
});
</script>
<script>
    $(window).on("load", function () {

      if(window.matchMedia("(max-width: 767px)").matches){
        // The viewport is less than 768 pixels wide
        // alert("This is a mobile device.");
        $(".filteraccordian").removeClass('in');

    } else{
        // The viewport is at least 768 pixels wide
       // alert("This is a tablet or desktop.");
       $(".filteraccordian").addClass('in');
    }
    
       $(".slide").css("width", "100%");
      var range = $("#range").attr("value");
     if(range=='5000'){
       $("#value").html(range+'+');
     }
     else{
       $("#value").html(range);
     }
     
     

      $(document).on('input change', '#range', function () {
        
        if($(this).val()=='5000'){
          $('#value').html($(this).val()+'+');
      
     }
     else{
       $('#value').html($(this).val());
     }
        
        $("#price_value").val($(this).val());
        var slideWidth = $(this).val() * 100 / 5000;

        $(".slide").css("width", slideWidth + "%");
      });
    });
document.getElementById("range").oninput = function() {
  var value = (this.value-this.min)/(this.max-this.min)*100
  this.style.background = 'linear-gradient(to right, #1B33B7 0%, #1B33B7 ' + value + '%, #cdcdcd ' + value + '%, #cdcdcd 100%)'
  
};
  </script>