<?php 
if(session_id() == '') {
session_start();
}
$site = SITE_URL;
$media = SITE_URL;
@$username = @$_SESSION['media_server_username'];
@$password = @$_SESSION['media_server_password']; 
@$hostname = $_SESSION['media_host_name'];

$roundProfile = "";
$roundProfileFlag = 0;
if ($roundProf == "round")  {
    $roundProfile = "border-radius:40px; box-shadow:0 0 10px #d5d6d7;";
    $roundProfileFlag = 1;
} else if ($roundProf == "square") {
   $roundProfile = "border-radius:5px; box-shadow:0 0 10px #d5d6d7;";
}
?>
<style type="text/css">
.box-info {
   border:1px solid #d5d6d7;   padding:5px;   border-radius: 10px;
}

@media (min-width: 320px) and (max-width: 480px) {
  a > img#fullimgtag {
    height:auto !important;
     width: 100%; 
  }
}
@media screen and (min-width: 481px) {
  a > img#fullimgtag {
     width: auto;
  }
}
@media (min-width: 768px) and (max-width: 1023px) {
  .itemAddedUserDetails.box-right-panel {
    margin-top: 20px;
  }
}

.box-text-head {
   color: #1999eb;   margin-left: 20px;
}
.box-right-panel {
   border: 1px solid #d5d6d7;   padding: 15px;   border-radius: 10px;
}
.box-viewtitle {
  color: rgb(25, 153, 235);  font-size: 13px;  font-weight: 600;  margin-bottom: 15px;
  text-transform: uppercase;
}
.viewprice {
  font-size: 22px;  font-weight: 500;  margin-right: 5px;
}
.prices {
  font-size: 14px;  font-weight: 400;  margin-top: 15px;
}
.viewOpt {
   color:#999999; font-family: sans-serif;
}
/*.thing-description {
   display: none;
}*/
.thing-description p{
   margin-bottom: 2px;
   word-break: break-all;
}
.thing-description p a.morelink {
  margin-top: 5px;
  text-align: right;
  font-weight: 400;
  display: block
}
h3.text-themecolor{
  word-break: break-all;
}
.more-enable a {
   color: #009efb;
}
.more-enable {
   font-family: sans-serif; font-weight: 400; text-align: right;
}
a.buyitbtn {
  display: block; float: right;  font-weight: 500;  padding: 5px 10px;  border-radius: 5px;
}
a.coupbtn, a.coupbtn:focus, a.coupbtn:hover {
  border-radius: 5px;  display: block;  font-weight: 500;  margin: auto;  padding: 5px 10px;
  text-align: center;  width: 70%;
}
.box-viewtitle-two {
  background: #f7f7f7 none repeat scroll 0 0;  border-radius: 5px;  padding: 5px 10px;
}
ul.pic-more {
   border-top: 1px solid #f9f9f9;
}
ul.pic-more a {
    display: block;   width: 70px;    height: 70px;    cursor: pointer;
    background: transparent none no-repeat center center;    background-size: cover;
    border-radius: 5px; border: 1px solid #f5f5f5;
}
ul.pic-more a > img {
   border-radius: 5px;
}
ul.pic-more > li + li {
   margin-left:10px;
}
ul.pic-more > li {
   float:left;  margin-top: 20px;
}


</style>

<?=  $this->Html->css('frontcss/bootstrap.min.css')?>

<!-- scrollable image view -->

<div class="container">
   <div class="row m-t-30">
      <div class="col-lg-7 col-md-12 col-sm-12">
         <div class = "box-info">
          


            <div class="product-slider-cnt item-slider">
            <div id="carousel" class="carousel slide product-slider" data-ride="carousel" data-interval="false">
              <div class="carousel-inner">
              <?php
              $j = 0;
              foreach($item_datas['photos'] as $photo)
              {



                $item_image = $photo['image_name'];
            if($item_image == "")
            {
              $itemimage = SITE_URL.'media/items/original/usrimg.jpg';
            }
            else
            {
              $itemimage = WWW_ROOT.'media/items/original/'.$item_image;
              /*$header_response = get_headers($itemimage, 1);*/
              if (file_exists($itemimage))
              {
                $itemimage = SITE_URL.'media/items/original/'.$item_image;
              }
              else
              {
                $itemimage = SITE_URL.'media/items/original/usrimg.jpg';
              }
            }
                if($j==0)
                echo '<div class="item active thumb-image">';
                else
                echo '<div class="item">';
                echo '<img src="'.$itemimage.'" data-imagezoom="true">
                </div>';
                $j++;
              }

                $submitID = $item_datas['videourrl'];

                if (strpos($submitID, '/') === false) {
                  $videoID = $submitID;
                }else {
                  preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $submitID, $matches);
                  if (isset($matches[1]))
                  {
                    $videoID = $matches[1];
                  }else {
                    $videoID = '';
                  }
                }
                //echo $videoID;die;

                // echo '<div class="item" id="video_carousel">
                // <iframe id="iframeYoutube" width="100%" height="315"  src="https://www.youtube.com/embed/'.$videoID.'" frameborder="0" allowfullscreen></iframe>

                // </div>';


              ?>
              </div>
            </div>
            <?php
            if(count($item_datas['photos'])>1)
            {
              ?>
            <div class="clearfix">
              <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding product-sec-slide heroSlider-fixed" id="sliderIdName">
                     <div class="slider slider-for">
                      <div class="slider responsive_product">

                  <?php
                  $k = 0;
                  foreach($item_datas['photos'] as $photo)
                  {

                $item_image = $photo['image_name'];
            if($item_image == "")
            {
              $itemimage = SITE_URL.'media/items/original/usrimg.jpg';
            }
            else
            {
              $itemimage = WWW_ROOT.'media/items/original/'.$item_image;
              /*$header_response = get_headers($itemimage, 1);*/
              if (file_exists($itemimage))
              {
                $itemimage = SITE_URL.'media/items/original/'.$item_image;
              }
              else
              {
                $itemimage = SITE_URL.'media/items/original/usrimg.jpg';
              }
            }
                    echo '<div class="item0">';
                    echo '<div data-target="#carousel" data-slide-to="'.$k.'" class="thumb"><img src="'.$itemimage.'"></div>';
                    $k++;
                    echo '</div>';
                  }
              if($item_datas['videourrl']!="")
              {
                $submitID = $item_datas['videourrl'];

                if (strpos($submitID, '/') === false) {
                  $videoID = $submitID;
                }else {
                  preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $submitID, $matches);
                  if (isset($matches[1]))
                  {
                    $videoID = $matches[1];
                  }else {
                    $videoID = '';
                  }
                }
                //echo $videoID;die;
                  echo '<div class="item0">
                  <div data-target="#carousel" data-slide-to="'.$k.'" class="thumb">
                  <div class="videooverlaydiv"></div>
                  <a  href="javascript:void(0);"><img src="http://i1.ytimg.com/vi/' .$videoID. '/1.jpg" style="width:70px;height:70px;" /></a>
                  </div></div>';
                }

                  ?>


        </div>


        <!-- control arrows -->
       <?php 
       if (count($item_datas['photos'])>=7) { ?>
          <div class="prev2 preb cr-prev">
          <span class="fa fa-angle-left" aria-hidden="true"></span>
        </div>
        <div class="next2 cr-next nexb">
          <span class="fa  fa-angle-right" aria-hidden="true"></span>
        </div>
     <?php  }else{ ?>
       <div class="prev2 preb cr-prev" style="display: none;">
          <span class="fa fa-angle-left" aria-hidden="true"></span>
        </div>
        <div class="next2 cr-next nexb" style="display: none;">
          <span class="fa  fa-angle-right" aria-hidden="true"></span>
        </div>
  <?php   }

       ?>
        </div>

      </div>
            </div><!-- /clearfix -->
<?php } else if(count($item_datas['photos'])==1 && $item_datas['videourrl'] != "") { ?>

            <div class="clearfix">
              <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding product-sec-slide heroSlider-fixed" id="sliderIdName">
                     <div class="slider slider-for">
                      <div class="slider responsive_product">

                  <?php
                  $k = 0;
                  foreach($item_datas['photos'] as $photo)
                  {

                $item_image = $photo['image_name'];
            if($item_image == "")
            {
              $itemimage = SITE_URL.'media/items/original/usrimg.jpg';
            }
            else
            {
              $itemimage = WWW_ROOT.'media/items/original/'.$item_image;
              /*$header_response = get_headers($itemimage, 1);*/
              if (file_exists($itemimage))
              {
                $itemimage = SITE_URL.'media/items/original/'.$item_image;
              }
              else
              {
                $itemimage = SITE_URL.'media/items/original/usrimg.jpg';
              }
            }
                    echo '<div class="item0">';
                    echo '<div data-target="#carousel" data-slide-to="'.$k.'" class="thumb"><img src="'.$itemimage.'"></div>';
                    $k++;
                    echo '</div>';
                  }

                $submitID = $item_datas['videourrl'];

                if (strpos($submitID, '/') === false) {
                  $videoID = $submitID;
                }else {
                  preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $submitID, $matches);
                  if (isset($matches[1]))
                  {
                    $videoID = $matches[1];
                  }else {
                    $videoID = '';
                  }
                }
                //echo $videoID;die;
                  echo '<div class="item0">
                  <div data-target="#carousel" data-slide-to="'.$k.'" class="thumb">
                  <div class="videooverlaydiv" onclick="showvideourll(\''.$videoID.'\');"></div>
                  <a  href="javascript:void(0);" onclick="showvideourll(\''.$videoID.'\');"><img src="http://i1.ytimg.com/vi/' .$videoID. '/1.jpg" style="width:70px;height:70px;" /></a>
                  </div></div>';

                  /*echo '';
                    echo '<div data-target="#carousel" data-slide-to="'.$k.'" class="thumb"><img src="'.$itemimage.'"></div>';
                    $k++;
                    echo '</div>';*/
                  ?>


        </div>


        <!-- control arrows -->
        <div class="prev2 cr-prev">
          <span class="fa fa-angle-left" aria-hidden="true"></span>
        </div>
        <div class="next2 cr-next">
          <span class="fa  fa-angle-right" aria-hidden="true"></span>
        </div>
        </div>

      </div>
            </div><!-- /clearfix -->
  <?php } ?>


          </div>







            <h4 class="box-text-head m-t-10" style="word-break: break-all;"><?php echo $item_datas['item_title'];?></h4> 
            <div style="font-weight:400;" class="m-l-20 m-b-10"><?php echo __d('merchant','by'); ?>
               <a class="username" href="<?php echo MERCHANT_URL."/dashboard"; ?>">
                  <?php echo $item_datas['user']['username']; ?>
               </a>
               <span style="margin-left: 10px;" title="<?php echo __d('merchant','Like'); ?>"><i class="fa fa-thumbs-up" style="margin-right:5px;"></i><?php if(trim($item_datas['fav_count'])=="") echo "0"; else echo $item_datas['fav_count']; ?> </span>
               <span style="margin-left: 10px;" title="<?php echo __d('merchant','Comments'); ?>"><i class="fa fa-comment" style="margin-right:5px;"></i><?php if(trim($item_datas['comment_count'])=="") echo "0"; else echo $item_datas['comment_count']; ?> </span>
               <span style="margin-left: 10px;" title="<?php echo __d('merchant','Product Selfies'); ?>"><i class="fa fa-image" style="margin-right:5px;"></i><?php echo count($FashionuserDet); ?> </span>
            </div>
            <?php   
               foreach($item_datas['itemfavs'] as $useritemfav){
                   if($useritemfav['user_id'] == $userid ){
                       $usecoun[] = $useritemfav['item_id'];
                   }
               }              
               echo '<input type="hidden" id="likebtncnt" value="'.$setngs['like_btn_cmnt'].'" />';
               echo '<input type="hidden" id="likedbtncnt" value="'.$setngs['liked_btn_cmnt'].'" />';
            ?>      
            <?php 
               $itemcolor = $item_datas['item_color'];
               $itemidse = $item_datas['id'];
               $itemcolor = json_decode($itemcolor,true);
            ?>
         </div>

         <?php 
            $item_title = $item_datas['item_title'];
            $item_price = $item_datas['price'];
            $favorte_count = $item_datas['fav_count'];
            $username = $item_datas['user']['username'];
            
            echo '<span id="figcaption_titles'.$item_datas['id'].'" figcaption_title ="'.$item_title.'" ></span>';
            echo '<span id="price_vals'.$item_datas['id'].'" price_val="'.$item_price.'" ></span>';
            echo '<a href="'.SITE_URL."people/".$username.'"  id="user_n'.$item_datas['id'].'" usernameval ="'.$username.'"></a>';
            echo '<span class="fav_count" id="fav_count'.$item_datas['id'].'" fav_counts ="'.$favorte_count.'" ></span>';

            ?>      
                    
            <div id="links"></div>

      </div>

      <div class="col-lg-5 col-md-12 col-sm-12">
         <?php if(($item_datas['status'] != '')) { ?>
            <aside id="sidebar" style="background:none;" >
               <?php 
                   $itemcolor = $item_datas['item_color'];
                   $itemidse = $item_datas['id'];
                   $itemcolor = json_decode($itemcolor,true);
               ?> 

               <?php
                  if(!empty($loguser)) {
                       echo "<input type='hidden' id='loguserid' value='".$loguser['id']."' />";
                       echo "<input type='hidden' id='featureditemid' value='".$item_datas['id']."' />";
                  } else { 
                       echo "<input type='hidden' id='loguserid' value='0' />";
                  }
                   
                   echo '<input type="hidden" id="listingid" value="'.$item_datas['id'].'" />';
                   echo '<input type="hidden" id="shopid" value="'.$item_datas['shop']['id'].'" />';
                   echo '<input type="hidden" id="lastestidgg" value="" />';
                   echo '<input type="hidden" id="totitemshipcost" value="" />';
                   echo '<input type="hidden" id="recepietName" value="" />';
                   echo '<input type="hidden" id="recepietcity" value="" />';
               ?>
              
               <div class="itemAddedUserDetails box-right-panel">
                  <?php
                  if(!empty($item_datas["user"]["profile_image"])) {
                       echo " <a href='".SITE_URL."people/".$item_datas["user"]["username_url"]."'    class='vcard'><img style='margin-right: 15px;$roundProfile width:40px;' src='".SITE_URL."media/avatars/thumb70/".$item_all[0]["user"]["profile_image"]."' /></a>";
                  } else {
                       echo " <a class='imagebor' href='".SITE_URL."people/".$item_datas["user"]["username_url"]."'  ><img src='".SITE_URL."media/avatars/thumb70/usrimg.jpg' style='".$roundProfile."width:40px;margin-right: 15px;' /></a>";
                  }
                           
                  if($userid != $item_datas['user']['id']) {
                       
                       foreach($followcnt as $flcnt){
                           $flwrcntid[] = $flcnt['user_id'];
                               
                       }
                       //echo "<pre>";print_r($flwrcntid);die;
                       if($userid != $item_datas['user']['id']){
                           if(isset($flwrcntid) && in_array($item_datas['user']['id'],$flwrcntid)){
                               $flw = false;
                           }else{
                               $flw = true;
                           }
                       
                       
                           if($flw){
                       
                               if(empty($item_datas['user']['id'])){
                                   echo "<input type='hidden' id='gstid' value='0' />";
                               }else{
                                   echo "<input type='hidden' id='gstid' value='".$userid."' />";
                               }
                           }
                           echo '<span id="changebtn'.$item_datas['user']['id'].'" ></span>';
                       
                       }
                       
                   }   

                  ?>
                  <a href = "<?php echo MERCHANT_URL; ?>" class = 'box-viewtitle' title = '<?php echo $item_datas["user"]["username"]; ?>'>
                     <?php echo $item_datas["user"]["username"];?>
                  </a>
                           
                           
                  <?php if ($item_datas['price'] != 0 && $item_datas['price'] != '' && empty($item_datas['size_options'])) { ?>
                     <p class="prices m-b-5">
                         <strong class="viewprice"><?php echo $item_currency_sym.$item_datas['price']."</strong>".$item_currency_code; ?><br>
                         <input type="hidden" id="price" value="<?php echo $item_datas['price']; ?>">    
                     </p>
                  <?php } ?>
                              
                  <?php if(($item_datas['status'] == 'things')) { ?>
                     <h3 class="text-themecolor">
                        <?php echo $item_datas['item_title']; ?>
                     </h3>

                     <div class="thing-description">
                      <?php  $description=$item_datas['item_description']; 

                      if(strlen($description) > 120) {
                            $desc = substr($description,0,120);
                            echo html_entity_decode($desc);?>
                            <span class="ellipses">...&nbsp;&nbsp;</span>

                          <?php 
                            $desclength = strlen($description);
                            $moredesc = substr($description,120,$desclength);
                            ?>

              
                            <input type="hidden" id="moremoredesc" value="<?php echo $moredesc;?>">
                              <span class="moredesc" style="display:none;"></span>

                              <a class="morelink showmoredesc" href="javascript:;" onClick="showmoredesc()"><?php echo 'More Info'; ?></a>
                              <a class="morelink hidemoredesc" href="javascript:;" onClick="lessmoredesc()" style="display:none;"><?php echo 'Less Info'; ?></a>
                              <?php 
                        } else {
                              echo html_entity_decode($description); 
                        }?>
                      </div>
                        
                     <!-- div class="thing-description"> 
                        <div style="font-size:13px; font-weight: 400;"> <?php echo $item_datas['item_description']; ?></div>
                     </div -->

                     <?php /* if (strlen($item_datas['item_description']) > 15) { ?>
                        <div class="more-enable m-t-5">
                           <a href="javascript:void(0);" id="full-description">
                              <?php echo __d('merchant','more');?>
                           </a>
                        </div>
                     <?php } */ ?>

                     <div class="clearfix">
                        <a href="<?php echo  $item_datas['bm_redircturl']; ?>" class="buyitbtn btn-success" target="_blank" ><?php echo __d('merchant','Buy It'); ?></a>
                     </div>                      
                               
                  <?php } else { ?>         
                     <div class="option-area m-t-20">
                        <?php if(empty($item_datas['size_options'])) {  ?>
                          <label for="quantity" style="font-size: 14px; font-weight: 500;"><?php echo __d('merchant','Quantity'); ?> : </label>
                          <span class="input-number m-l-10 viewOpt">
                              <?php if($item_datas['quantity']<=0){
                                         echo __d('merchant','Sold Out');
                                     }else{
                                         echo __d('merchant','Only')." ".$item_datas['quantity']." Available ";
                                     }
                               ?>
                          </span>
                        <?php } else { ?>
                          <div>
                            <label for="quantity" style="font-size: 14px; font-weight: 500;"><?php echo __d('merchant','Quantity'); ?> : </label>
                            <span class="input-number m-l-10 viewOpt">
                                <?php if($item_datas['quantity']<=0){
                                           echo __d('merchant','Sold Out');
                                       }else{
                                           echo __d('merchant','Only')." ".$item_datas['quantity']." Available ";
                                       }
                                 ?>
                            </span>
                          </div>

                           <label for="quantity" style="font-size: 14px; font-weight: 500;"><?php echo __d('merchant','Available Sizes'); ?> : </label>
                           <span class="input-number m-l-10 viewOpt">
                            <?php    
                              $sizes = $item_datas['size_options'];
                              $size_option = json_decode($sizes, true);
                              $size_val = array();
                               
                              if(count($size_option['size']) > 0) {
                                foreach($size_option['size'] as $key=>$val)
                                {
                                      $size_val[] = $val;
                                }
                                $count = count($size_val);
                                for($i=0;$i<$count;$i++)
                                {
                                  if($i == 0)
                                    echo $size_val[$i];
                                  else
                                    echo ", ".$size_val[$i];
                                }
                              } else {
                                echo __d('merchant','Not available');
                              }
                              
                            ?>   
                          </span>

                        <?php } ?>

                        <?php 
                           $process_time = $item_datas['processing_time'];
                           if($process_time == '1d') {
                               $process_time = "One business day";
                           }elseif($process_time == '2d'){
                               $process_time = "Two business days";
                           }elseif($process_time == '3d'){
                               $process_time = "Three business days";
                           }elseif($process_time == '4d'){
                               $process_time = "Four business days";
                           }elseif($process_time == '2ww'){
                               $process_time = "One - Two week business days";
                           }elseif($process_time == '3w'){
                               $process_time = "Two - Three week business days";
                           }elseif($process_time == '4w'){
                               $process_time = "Three - Four week business days";
                           }elseif($process_time == '6w'){
                               $process_time = "Four - Six week business days";
                           }elseif($process_time == '8w'){
                               $process_time = "Six - Eight week business days";
                           }
                        ?>
                        <br clear="all" />
                        <div class="shippingTime">
                           <img src="<?php echo SITE_URL; ?>images/shippingicon.gif" alt="<?php echo __d('merchant','Shipping'); ?> : " />
                           <span class="shipperiod viewOpt m-l-10"><?php echo __d('merchant',$process_time); ?></span>
                        </div>
                     </div>
                  <?php } ?>
               </div>

               <?php if(($item_datas['status'] != 'things')) { 
                   if($item_datas['status']=='publish') {  ?>
                     
                     <div class="box-right-panel m-t-20">
                       <h3 class="text-themecolor box-viewtitle-two"><?php echo __d('merchant','Coupon');?></h3>
                       <a class="coupbtn btn-success m-t-20" href="<?php echo MERCHANT_URL.'/additemcoupon/'.$item_datas['id'];?>"><?php echo __d('merchant','Generate Coupon'); ?></a>
                     </div>
                  <?php   }  ?>
                   
                  <div class="box-right-panel m-t-20">
                     <h3 class="text-themecolor">
                        <?php echo $item_datas['item_title']; ?>
                     </h3>
                        
                     <!-- div class="thing-description"> 
                        <div style="font-size:13px; font-weight: 400;"> <?php echo $item_datas['item_description']; ?></div>
                     </div-->

                     <?php /*if (strlen($item_datas['item_description']) > 15) { ?>
                        <div class="more-enable m-t-5 m-b-20">
                           <a href="javascript:void(0);" id="full-description">
                              <?php echo __d('merchant','more');?>
                           </a>
                        </div>
                     <?php }*/ ?>
                     <div class="thing-description">
                      <?php  $description=$item_datas['item_description']; 

                      if(strlen($description) > 120) {
                            $desc = substr($description,0,120);
                            echo html_entity_decode($desc);?>
                            <span class="ellipses">...&nbsp;&nbsp;</span>

                          <?php 
                            $desclength = strlen($description);
                            $moredesc = substr($description,120,$desclength);
                            ?>

              
                            <input type="hidden" id="moremoredesc" value="<?php echo $moredesc;?>">
                              <span class="moredesc" style="display:none;"></span>

                              <a class="morelink showmoredesc" href="javascript:;" onClick="showmoredesc()"><?php echo 'More Info'; ?></a>
                              <a class="morelink hidemoredesc" href="javascript:;" onClick="lessmoredesc()" style="display:none;"><?php echo 'Less Info'; ?></a>
                              <?php 
                        } else {
                              echo html_entity_decode($description); 
                        }?>
                      </div>


                   
                    <!--  <?php
                         if(!empty($item_datas['photos'][1])) { ?>

                           <ul class="pic-more list-unstyled clearfix">
                             <?php foreach($item_datas['photos'] as $phts) {
                                 //echo "<pre>";print_r($phts);
                                 echo '<li class="proimgovrlay"><a class="smlght" href="#" data-img-src="'.SITE_URL.'media/items/original/'.$phts['image_name'].'" style="background-image:url(\''.SITE_URL.'media/items/thumb70/'.$phts['image_name'].'\')"></a>
                                         <img src="'.SITE_URL.'media/items/original/'.$phts['image_name'].'" style="display:none;" /></li>';
                                 
                             } ?>
                           </ul>

                     <?php } ?>
 -->
                     <?php if(!empty($item_datas['videourrl'])) {
                        $submitID = $item_datas['videourrl'];
                      //  $submitID = "https://www.youtube.com/watch?v=LCcRsteVBns";
                       
                       if (strpos($submitID, '/') === false) {
                           $videoID = $submitID;
                       }else {
                           preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $submitID, $matches);
                           if (isset($matches[1]))
                           {
                               $videoID = $matches[1];
                           }else {
                               $videoID = '';
                           }
                       }

                        echo "<ul class='pic-more list-unstyled clearfix'>";  
                           echo '<li class="proimgovrlay">
                              <a  href="javascript:void(0);" onclick="showvideourll(\''.$videoID.'\');"><img src="http://i1.ytimg.com/vi/' .$videoID. '/1.jpg" style="width:70px;height:70px;" /></a>
                           </li> 
                        </ul>';
                     } ?>
                   
                  </div>
               <?php } ?>                          
                   
               <?php
                 echo "</div>";
                 if(!empty($loguser)){
                     echo "<input type='hidden' id='loguserid' value='".$loguser['id']."' />";
                     echo "<input type='hidden' id='featureditemid' value='".$item_datas['id']."' />";
                 }else{
                     echo "<input type='hidden' id='loguserid' value='0' />";
                 }
                 
                 echo '<input type="hidden" id="listingid" value="'.$item_datas['id'].'" />';
                 echo '<input type="hidden" id="shopid" value="'.$item_datas['shop']['id'].'" />';
                 echo '<input type="hidden" id="lastestidgg" value="" />';
                 echo '<input type="hidden" id="totitemshipcost" value="" />';
                 echo '<input type="hidden" id="recepietName" value="" />';
                 echo '<input type="hidden" id="recepietcity" value="" />';
               ?>
           </aside>
         <?php  }   ?> 
      </div>
   </div>
</div>

<!-- popups -->
<div id="popup_container" style="display: none; opacity: 0;">
   <!--share-social-->
   <div id="videourrls" class="popup ly-title share-new"  style="opacity: 1; display: none; width: 645px; margin: 75px auto 0;">  
      <p class="ltit">
         <span >Video</span>
         <button type="button" class="ly-close" title="Close" id="btn_close_share"><img src="<?php echo SITE_URL.'images/closebt.png'; ?>" ></button>
      </p>
      <div class="share-via">
         <?php 
            echo "<div id=\"ytvply\">
                  <object width=\"644\" height=\"362\"><param name=\"movie\" value=\"https://www.youtube.com/v/" .$videoID. "?version=3&rel=0&modestbranding=1\"></param>
                  <param name=\"allowFullScreen\" value=\"true\"></param>
                  <param name=\"allowscriptaccess\" value=\"always\">
                  <param name=\"allownetworking\" value=\"internal\"></param>
                  <embed src=\"https://www.youtube.com/v/" .$videoID. "?version=3&rel=0&modestbranding=1&hl=en_US\" type=\"application/x-shockwave-flash\" width=\"644\" height=\"362\" allowscriptaccess=\"always\" allowfullscreen=\"true\" allownetworking=\"internal\">
                  </embed>
                  </object>
                  </div>" ;
         ?>
      </div>
   </div>
      <!--/share-social-->
</div>
<!-- end popups -->





<script>

function showmoredesc() {
  $('.ellipses').hide();
  $('.moredesc').slideToggle();
  $('.moredesc').css('display','inline');
  $('.showmoredesc').hide();
  $('.hidemoredesc').show();
  moredesc = $("#moremoredesc").val();
  $(".moredesc").html(moredesc).text();
}

function lessmoredesc() {
  $('.ellipses').show();
  $('.moredesc').slideToggle();
  $('.moredesc').css('display','none');
  $('.showmoredesc').show();
  $('.hidemoredesc').hide();
}

   /*$(document).ready(function () {
       $(document).on('click','#full-description',function(){
         $(".thing-description").slideDown();
         $(".more-enable").html('<a href="javascript:void(0);" id="less-decription"> less </a>');
       });

       $(document).on('click','#less-decription',function(){
         $(".thing-description").slideUp();
         $(".more-enable").html('<a href="javascript:void(0);" id="full-description"> more </a>');
       });
   });*/
</script>

<style type="text/css">
.popup .ltit {
    -moz-box-sizing: border-box;
    background-image: linear-gradient(to bottom, #F7F7F7, #F2F2F2);  border-bottom-color: #CDCFD2;    box-shadow: none;    color: #444444;    font-size: 15px;    margin: 0;
    padding: 14px 13px 13px 15px;    text-shadow: 0 1px 0 #FFFFFF;    top: 0;    font-weight: 500;
}

#popup_container {
    background: none repeat scroll 0 0 rgba(31, 33, 36, 0.898);    display: block;
    height: 100%;    left: 0;    opacity: 1;    overflow: hidden;    padding: 0px;
    position: fixed;    top: 0;    transition: opacity 0.2s ease 0s;    width: 100%;
    z-index: 9999;
}

.popup.ly-title .ly-close {
  background: transparent none repeat scroll 0 0;
  float: right;
  height: 40px;
  left: 8px;
  padding: 0;
  position: relative;
  top: -8px;
  width: 40px;
  z-index: 15;
  cursor: pointer;
}

.ly-title .ly-close {
  background: transparent none repeat scroll 0 0;
  border-left: 1px solid #d7d7d8;
  border-right: none;
  border-top: none;
  border-bottom: none;
}


</style>
