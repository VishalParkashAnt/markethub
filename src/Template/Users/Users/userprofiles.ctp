<?php
namespace Cake\I18n;
use Cake\Routing\Router;
use Cake\I18n\Time;
$baseurl = Router::url('/');
//echo "here";die;
?>
<?php
   if (count($_GET) == 0)
    {
        $title='All Products';
    }
    else if(isset($_REQUEST['lists'])){
        $title='My Collections';
    }
    else if(isset($_REQUEST['stores'])){
        $title='FAVOURITE STORE';
    }
    else if(isset($_REQUEST['followers'])){
        $title='Followers';
    }
    else if(isset($_REQUEST['followings'])){
        $title='Following';
    }
  

?>

<section class="container-fluid side-collapse-container fullPage" style="margin-top:0px;">
  
  
  
  <section class="">
    <div class="">
      
      
      <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">
        
        <div class="row">
          
            <div class="col-md-9 col-sm-12 no-hor-padding">
              <div class=" mainPage">
                <div class="col-xs-12 col-sm-12 allPdct">
                  <div class="profAllproduct"><?php echo __d('user', $title);?></div>
                </div>
              <!--   <div class="allImg allPrdt"> -->
                  <div class="allImg allPrdt" style="overflow: unset;">
                    <?php 
                    if (count($_GET) == 0)
                {
                  $selectedTab = 'fantacy';
                    if(count($itematas)>0){
                        foreach ($itematas as $key => $itemdata) {
                            $image_name = $itemdata[photos][0]['image_name'];
            $itemid = base64_encode($itemdata->id . "_" . rand(1, 9999));
            $item_title = $itemdata['item_title'];
            $item_title_url = $itemdata['item_title_url'];
            $item_price = $itemdata['price'];
            $favorte_count = $itemdata['fav_count'];
            $username = $itemdata['user']['username'];
            $currencysymbol = $itemdata['forexrate']['currency_symbol'];
            $items_image = $itemdata['photos'][0]['image_name'];
            $dealprice = $item_price * (1 - $itemdata['discount'] / 100);

            $itemprice = $itemdata['price'];

            $user_currency_price = $currencycomponent->conversion($itemdata['forexrate']['price'], $_SESSION['currency_value'], $itemprice);
             $item_image = $itemdata['photos'][0]['image_name'];
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




                         ?>
                           <a class="" href="<?php echo $baseurl . 'listing/' . $itemid;?>">
                       <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="bg_product">
                      <img src="<?php echo SITE_URL.'media/items/original/'.$items_image;?>" class="img-responsive" id="image_<?php echo $itemdata['id'];?>"/>
                   <!--    <input type="hidden" id="img_<?php echo $itemdata['id'];?>" value="<?php echo SITE_URL.'media/items/original/'.$items_image;?>"> -->
                   <span style="display: none;" id="img_<?php echo $itemdata['id'];?>"><?php echo SITE_URL.'media/items/original/'.$items_image;?></span>
                    </div>
                    <div class="prodDescrip new_prod_nam bold-font ">
                      <div class="prdDescrip">
                        <div class="imgDes">
                          <a class="" href="<?php echo $baseurl . 'listing/' . $itemid;?>">
                            <div class="desCri" id="figcaption_titles<?php echo $itemdata['id'];?>" figcaption_title="<?php echo $item_title;?>"><?php echo $item_title;?></div> </a>
                            
                            
                            <span id="price_vals<?php echo $itemdata['id'];?>" price_val="<?php echo $_SESSION['currency_symbol'] . $user_currency_price;?>" style="display:none;width:0px !important;"></span>
                          </div>
                          <input type="hidden" id="user_n<?php echo $itemdata['id'];?>" usernameval="<?php echo $username;?>">
                            <input type="hidden" id="fav_count<?php echo $itemdata['id'];?>" class="fav_count<?php echo $itemdata['id'];?>"fav_counts="<?php echo $favorte_count;?>">
                         
                          <div class="desIcon">
                            <?php
                             foreach ($itemdata['itemfavs'] as $useritemfav)
            {
                if ($useritemfav['user_id'] == $userid)
                {
                    $usecoun[] = $useritemfav['item_id'];
                }
            }
            if (isset($usecoun) && in_array($itemdata['id'], $usecoun))
            {
                $likeimage=SITE_URL.'images/icons/Heart_after_like@2x.png';
                  echo' <span style="display:none;"class="like-txt' . $itemdata['id'] . '">' . $setngs['liked_btn_cmnt'] . '</span>';
            }
            else{
                $likeimage=SITE_URL.'images/icons/like.png';
                   echo'<span style="display:none;" class="like-txt' . $itemdata['id'] . '">' . $setngs['like_btn_cmnt'] . '</span>';
            }
                            ?>
                            <a href="javascript:void(0)" onclick="itemcouview(<?php echo $itemdata['id'];?>)">
                            <div class="likeIcon" >
                              
                                <img src="<?php echo $likeimage;?>" alt="like" id="like-icon<?php echo $itemdata['id'];?>" class="like-icon<?php echo $itemdata['id'];?>"></div></a>
                            <div class="shareIcon" class="hover-icon-cnt share_hover" href="javascript:void(0)" onclick="share_posts(<?php echo $itemdata['id'];?>)" data-toggle="modal" data-target="#share-modal" ><img src="<?php echo SITE_URL.'img/share.png';?>" alt="share"></div>
                          </div>
                        </div>
                        <div class="price ">
                         <?php echo $_SESSION['currency_symbol'] . $user_currency_price;?>
                        </div>
                      </div>
                    </div>
                </a>
                  <?php      }
                    
                        ?>
                    <?php } else{ ?>
                        <div class="text-center padding-top30 padding-bottom30">
                                            <div class="outer_no_div">
                                                <div class="empty-icon no_products_icon"></div>
                                            </div>
                                            <h5><?php echo __d('user', 'No Products');?></h5>
                                        </div>
                  <?php   } }?>
                                                    <?php
                    if (isset($_REQUEST['lists']))
                    {
                        $selectedTab = 'lists';
                    ?>

                                        <div class="row hor-padding padding-top0 hor_1 resp-tab-content-active profile-content">
                                            <div>
                                                <!-- <h2 class="margin-bottom40 user_profile_inner_heading padd_lft10_mobile" id="category-tabs"><?php echo __d('user', 'My Collections'); ?></h2> -->
                                                <?php
                                if (count($itemListsAll) > 0)
                                {
                                    foreach ($itemListsAll as $list)
                                    {
                                        $lists_name = $list['lists'];
                                        $listimage = $userdetail['profile_image'];
                                        if ($listimage == "") $listimage = "usrimg.jpg";
                                        echo '<div class="product_cnt col-lg-4 col-md-4 col-sm-6 col-xs-6 margin-bottom20">
                                                        <a href="javascript:void(0);" onclick="show_lists(' . $list->id . ');" data-toggle="modal" data-target="#user_lists">
                                                            <div class="img_list_tab" style="background-image:url(' . SITE_URL . 'media/avatars/original/' . $listimage . ');background-repeat:no-repeat;">

                                                                <div class="trans">
                                                                    <p class="text-center trans_text white-txt">' . $lists_name . '</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>';
        }
    }
    else
    {
        echo '                  <div class="text-center padding-top30 padding-bottom30">
                                                <div class="outer_no_div">
                                                    <div class="empty-icon no_list_icon"></div>
                                                </div>
                                                <h5>' . __d('user', 'No List') . '</h5>
                                            </div>';
    }
?>




                                        <!--div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12"><a href="">+ load more</a></div-->
                                    </div>

                                </div><!---tab2 content ends---->
                                <?php
} ?>
                                <?php
if (isset($_REQUEST['stores']))
{
    $selectedTab = 'stores';
    if (count($shopsdet) > 0)
    {

        echo '<div class="row padding-top0 resp-tab-content-active profile-content">
                                       
                                           ';

        foreach ($shopsdet as $shopdatas)
        { //print_r($shopdatas);
            $shop_name = $shopdatas['shop_name'];
            $shop_name_url = $shopdatas['shop_name_url'];
            $shop_img = $shopdatas['shop_image'];
            $merchant_name = $shopdatas['merchant_name'];
            $item_count = $shopdatas['item_count'];
            $shop_id = $shopdatas['id'];
            $shop_user_id = $shopdatas['user_id'];
            $follow_count = $shopdatas['follow_count'];
            $follow_shop = $shopdatas['follow_shop'];
            $shopBanner = $shopdatas['shop_banner'];
            if ($shop_img == "") $shop_img = "usrimg.jpg";

            if (!empty($shopBanner))
            {
                $shop_bannerimg = SITE_URL . 'media/avatars/original/' . $shopBanner;
            }
            else
            {
                $shop_bannerimg = SITE_URL . 'images/banner_1.png';
            }

            echo '<div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="favourite_store" style="background-image:url(' . $shop_bannerimg . ');background-repeat:no-repeat;">

                        </div>
                        <div class="user_favourite_image1 margin_top_40min">
                            <a href=' . SITE_URL . 'stores/' . $shop_name_url . '><div class="user_favourite_image" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $shop_img . ');background-repeat:no-repeat;"></div></a>
                        </div>
                        <div class="user_favourite">
                            <h4 class="margin-bottom0 extra_text_hide">' . $shop_name . '</h4>
                            <p class="profile_text margin-bottom20 extra_text_hide">' . __d('user', 'By') . ' ' . $merchant_name . '</p>';

            foreach ($followcnt as $flcnt)
            {
                $flwrcntid[] = $flcnt['store_id'];
            }

            if ($shop_id != $loguser['id'])
            {
                if (in_array($shop_id, $flwrcntid) && isset($loguser['id']))
                {
                    $flw = false;
                }
                else
                {
                    $flw = true;
                }
                if ($flw)
                {
                    echo '<span id="folls' . $shop_id . '"><div class="user_followers_butn btn">
                                    <a href="javascript:void(0);" onclick="getshopfollows(' . $shop_id . ')">' . __d('user', 'Follow Store') . '</a></div></span>';
                }
                else
                {
                    echo '<span id="unfolls' . $shop_id . '"><div class="btn user_unfollowers">
                                    <a href="javascript:void(0);" onclick="deleteshopfollows(' . $shop_id . ')">' . __d('user', 'Unfollow Store') . '</a></div></span>';
                }
                echo '<span id="changebtnn' . $shop_id . '"></span>';
            }
            echo '</div>
                        </div>';
        }

    }
    else
    {
        echo '<div class="text-center padding-top30 padding-bottom30">
                    <div class="outer_no_div">
                        <div class="empty-icon no_store_icon"></div>
                    </div>
                    <h5>' . __d('user', 'No Stores') . '</h5>
                </div>';
    }
    echo '</div>';
}
?>
        <?php
if (isset($_REQUEST['followers']))
{
    $selectedTab = 'followers';

    echo '<div class="row padding-top0 resp-tab-content-active profile-content">';
    if (count($people_details) > 0)
    {
        echo '<div>
                ';
                // <h2 class="user_profile_inner_heading margin-bottom40 padd_lft10_mobile">' . __d('user', 'Followers') . '</h2>
        foreach ($people_details as $ppl)
        {
            $profile_img = $ppl['profile_image'];
            $user_nam_url = $ppl['username_url'];
            if ($profile_img == "") $profile_img = "usrimg.jpg";
            echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20 following' . $ppl['id'] . '">
                    <div class="user_follower_image1">




                        <a href=' . SITE_URL . 'people/' . $user_nam_url . '><div class="user_follower_image" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $profile_img . ')"></div></a>

                    </div>
                    <div class="user_followers follow_bg">
                        <h4 class="margin-bottom0 extra_text_hide">' . $ppl['first_name'] . '</h4>
                        <p class="profile_text margin-bottom20 extra_text_hide">@' . $ppl['username'] . '</p>';
            foreach ($followerscnt as $flcnt)
            {
                $followerscntid[] = $flcnt['user_id'];

            }

            if ($userid != $ppl['id'])
            {
                //print_r($ppls['User']['id']);echo "<=>".$loguser[0]['User']['id']."/";print_r($flwrcntid);
                /*if(in_array($ppls['User']['id'],$flwrcntid)  && isset($loguser[0]['User']['id']) ){
                $flw = false;
                }else {
                $flw = true;
                }*/
                if (in_array($ppl['id'], $followerscntid) && isset($loguser['id']))
                {
                    $flw = false;
                }
                else
                {
                    $flw = true;
                }
                if ($flw)
                {
                    echo '<span id="foll' . $ppl['id'] . '"><div class="btn folow_btn_user_profile editProf" style="color:white;">
                                <a href="javascript:void(0);" onclick="getfollows(' . $ppl['id'] . ')">' . __d('user', 'Follow') . '</a></div></span>';
                }
                else
                {
                    echo '<span id="unfoll' . $ppl['id'] . '"><div class="btn folow_btn_user_profile editProf" style="color:white;">
                                <a href="javascript:void(0);" onclick="deletefollows(' . $ppl['id'] . ')">' . __d('user', 'Unfollow') . '</a></div></span>';
                }

                echo '<span id="changebtn' . $ppl['id'] . '" ></span>';
            }
            echo '</div></div>';

        }
        echo '</div>';

    }
    else
    {

        echo '<div class="text-center padding-top30 padding-bottom30">
                    <div class="outer_no_div">
                        <div class="empty-icon no_follow_icon"></div>
                    </div>
                    <h5>' . __d('user', 'No Followers') . '</h5>
                </div>';
    }
    echo '</div><!---tab4 content ends---->';
} ?>
        <?php
if (isset($_REQUEST['followings']))
{
    $selectedTab = 'followings';
    echo '<div class="row padding-top0 resp-tab-content-active profile-content">';
    if (count($people_details_for_following) > 0)
    {

        echo '<div>
                ';
        foreach ($people_details_for_following as $ppl)
        {
            $profile_img = $ppl['profile_image'];
            $user_nam_url = $ppl['username_url'];
            if ($profile_img == "") $profile_img = "usrimg.jpg";
            echo '<div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20 following' . $ppl['id'] . '">
                    <div class="user_follower_image1">




                        <a href=' . SITE_URL . 'people/' . $user_nam_url . '><div class="user_follower_image" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $profile_img . ')"></div></a>

                    </div>
                    <div class="user_followers follow_bg">
                        <h4 class="margin-bottom0 extra_text_hide">' . $ppl['first_name'] . '</h4>
                        <p class="profile_text margin-bottom20 extra_text_hide">@' . $ppl['username'] . '</p>';
            foreach ($followerscnt as $flcnt)
            {
                $followerscntid[] = $flcnt['user_id'];

            }

            if ($userid != $ppl['id'])
            {
                //print_r($ppls['User']['id']);echo "<=>".$loguser[0]['User']['id']."/";print_r($flwrcntid);
                /*if(in_array($ppls['User']['id'],$flwrcntid)  && isset($loguser[0]['User']['id']) ){
                $flw = false;
                }else {
                $flw = true;
                }*/
                if (in_array($ppl['id'], $followerscntid) && isset($loguser['id']))
                {
                    $flw = false;
                }
                else
                {
                    $flw = true;
                }
                if ($flw)
                {
                    echo '<span id="foll' . $ppl['id'] . '"><div class="btn folow_btn_user_profile editProf" style="color:white;">
                                <a href="javascript:void(0);" onclick="getfollows(' . $ppl['id'] . ')">' . __d('user', 'Follow') . '</a></div></span>';
                }
                else
                {
                    echo '<span id="unfoll' . $ppl['id'] . '"><div class="btn folow_btn_user_profile editProf">
                                <a href="javascript:void(0);" onclick="deletefollows(' . $ppl['id'] . ')">' . __d('user', 'Unfollow') . '</a></div></span>';
                }

                echo '<span id="changebtn' . $ppl['id'] . '" ></span>';
            }
            echo '</div></div>';

        }
        echo '</div>';

    }
    else
    {

        echo '<div class="text-center padding-top30 padding-bottom30">
                    <div class="outer_no_div">
                        <div class="empty-icon no_follow_icon"></div>
                    </div>
                    <h5>' . __d('user', 'No Following') . '</h5>
                </div>';
    }
    echo '</div>';
} ?>


                </div>
 
    </div>

    </div>
    <?php $user_imges = $userdetail['profile_image'];
if ($user_imges == "") $user_imges = "usrimg.jpg";
else $user_imges = $userdetail['profile_image'];?>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
    <div class="category">
    <ul class="profileSidebar">
    <li class="sideProf profDetail">

      <div class="user_image1">
        <div class="user_image"
        style="background: url(<?php echo SITE_URL.'media/avatars/thumb70/'.$user_imges ;?>) no-repeat scroll 50% 0 / cover;">
      </div>
    </div>
    </li>
    <li class="sideProf profDetail">
    <div><h2 class="profiName" style="clear:both;"><?php echo $userdetail['first_name'];?></h2></div>
    </li>
    <li class="sideProf profDetail">
    <div> <p class="profText">@<?php echo $userdetail['username_url'];?></p></div>
    </li>
    <li class="sideProf profDetail">
     <?php  if (isset($loguser['id']) && $loguser['id'] == $userdetail['id'])
{  ?>
    <div><a href="<?php echo SITE_URL.'profile';?>"><button class="btn folow_btn_user_profile editProf"><?php echo __d('user', 'Edit Profile'); ?></button></a></div>
<?php }
else
{
    if ($userid != $userdetail['id'])
    {
        foreach ($flwrscnt as $flcnt)
        {
            if ($flcnt['follow_user_id'] == $userid)
            {
                $flwrcntid[] = $flcnt['user_id'];
            }

        }
        if ($userid != $userdetail['id'])
        {
            if (!in_array($userdetail['id'], $flwrcntid))
            {
                $flw = true;
            }
            else
            {
                $flw = false;
            }
            if ($flw)
            {
                echo '<span id="foll' . $userdetail['id'] . '"><div class="btn folow_btn_user_profile editProf">
                                <a href="javascript:void(0);" style="color:white;" class="" onclick="getfollows(' . $userdetail['id'] . ')">' . __d('user', 'Follow') . '</a></div></span>';
            }
            else
            {
                echo '<span id="unfoll' . $userdetail['id'] . '"><div class=" btn folow_btn_user_profile editProf">
                                <a href="javascript:void(0);"style="color:white;" class="" onclick="deletefollows(' . $userdetail['id'] . ')">' . __d('user', 'Unfollow') . '</a></div></span>';
            }
            if (isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == 'ar')
            {
                echo '<span id="changebtn' . $userdetail['id'] . '" style="float:left;"  class="margin-bottom20"></span>';
            }
            else
            {
                echo '<span id="changebtn' . $userdetail['id'] . '" style=""  class="margin-bottom20"></span>';
            }
        }
    }
}
?>
    </li>

    <li class="sideProf user_view"> <a href="<?php echo $baseurl . 'people/' . $_SESSION['username_urls']; ?>"><span>
    <?php echo $setngs['liked_btn_cmnt'];?></span><span class="rtl_tab_list" style="padding-left:2px">(<?php echo $itemfavcount; ?>)</span></a></li>
    <li class="sideProf"> <a href="<?php echo $baseurl . 'people/' . $_SESSION['username_urls'] . '?lists'; ?>"><span><?php echo __d('user', 'Collection'); ?></span><span class="rtl_tab_list"
      style="padding-left:2px">(<?php echo $itemListsCount; ?>)</span></a></li>
      <li class="sideProf"> <a href="<?php echo $baseurl . 'people/' . $_SESSION['username_urls'] . '?stores'; ?>"><span><?php echo __d('user', 'Favourite Store'); ?></span><span class="rtl_tab_list"
        style="padding-left:2px">(<?php echo $storeCount; ?>)</span></a></li>
        <li class="sideProf"> <a href="<?php echo $baseurl . 'people/' . $_SESSION['username_urls'] . '?followers'; ?>"><span><?php echo __d('user', 'Followers'); ?></span><span class="rtl_tab_list"
          style="padding-left:2px">(<?php echo count($people_details); ?>)</span></a></li>
          <li class="sideProf"> <a href="<?php echo $baseurl . 'people/' . $_SESSION['username_urls'] . '?followings'; ?>"><span><?php echo __d('user', 'Following'); ?></span><span class="rtl_tab_list"
            style="padding-left:2px">(<?php echo count($people_details_for_following); ?>)</span></a></li>
          </ul>
        </div>
      </div>
      <!---tab1 content ends---->
      
    </div>
    
    </div>


    </section>
    </div>
    </section>
   <?php
/* latest fixes 4.1 */
if (empty($userid))
{
    echo "<input type='hidden' id='gstid' value='0' />";
    echo "<input type='hidden' id='loguserid' value='0' />";
}
else
{
    echo "<input type='hidden' id='gstid' value='" . $userid . "' />";
    echo "<input type='hidden' id='loguserid' value='" . $loguser['id'] . "' />";
}
/* latest fixes 4.1 */
echo "<input type='hidden' id='selectedtab' value='" . $selectedTab . "' />";
echo '<input type="hidden" id="likebtncnt" value="' . $setngs['like_btn_cmnt'] . '" />';
echo '<input type="hidden" id="likedbtncnt" value="' . $setngs['liked_btn_cmnt'] . '" />';
?>
    <!--User list popup-->
    <div class="modal fade" id="user_list" role="dialog" tabindex="-1">
    <div class="login-popup modal-dialog">

    <!-- Modal content-->
    <div class="pop-up modal-content user_list_width" style="width:100%;">
    <div class="pop-up-cnt login-body modal-body" style="width:100%;">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <div>
    <div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding scroll_user">
      <!---- list products---->
      <div id="listproducts">
        
      </div>
      <!---- list products---->
      
    </div>

    </div>
    </div>
    </div>
    </div>
    </div>
    <!--User list popup-->

   
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
                            <div class="share-img margin-right20"><img id="share_img" class="img-responsive" src=""></div>
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

    <script type="text/javascript">
    var sIndex = 15, offSet = 15, isPreviousEventComplete = true, isDataAvailable = true;
    var baseurl = getBaseURL(); var selectedtab = $('#selectedtab').val();

    $(window).scroll(function () {
    //if ($(document).height() - 50 <= $(window).scrollTop() + $(window).height()) {
    if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.5) {
    if (isPreviousEventComplete && isDataAvailable) {

    isPreviousEventComplete = false;
    var baseurl = getBaseURL() + "getmoreprofile";
    $(".LoaderImage").css("display", "block");
    if (selectedtab != 'write_review') {
      $.ajax({
        type: "POST",
        url: baseurl + '?startIndex=' + sIndex + '&offset=' + offSet + '&tab=' + selectedtab,
        data: {},
        beforeSend: function () {
          $('#infscr-loading').show();
        },
        dataType: 'html',
        success: function (responce) {
          $('#infscr-loading').hide();
          if ($.trim(responce) == '')
          $(window).unbind('scroll');
          else if ($.trim(responce) != 'false') {
            if (selectedtab == 'added') {
              $('.profile-content').append(responce);
            } else if (selectedtab == 'fantacy') {
              $('.profile-content').append(responce);
            } else if (selectedtab == 'ownit') {
              $('.profile-content').append(responce);
            } else if (selectedtab == 'wantit') {
              $('.profile-content').append(responce);
            } else if (selectedtab == 'lists') {
              $('.profile-content').append(responce);
            } else if (selectedtab == 'followers') {
              $('.profile-content').append(responce);
            } else if (selectedtab == 'followings') {
              $('.profile-content').append(responce);
            }
            else if (selectedtab == 'stores') {
              $('.profile-content').append(responce);
            }
          } else {
            isDataAvailable = false;
          }
          sIndex = sIndex + offSet;
          isPreviousEventComplete = true;
        }
      });
    }
    }
    }
    });
    </script>
    <!-- Add to list popup -->
    <div id="add-to-list" class="modal fade" role="dialog" tabindex="-1" >
        <div class="modal-dialog login-popup">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body padding_btm45_mobile padding-top30">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="share-container margin-bottom20">
                        <div class="share-cnt-row">
                            <h2 class="bold-font text-center">Add to your Collection</h2>
                            <div class="popup-heading-border"></div>
                        </div>
                        <div class="share-cnt-row">
                            <div class="share-details-cnt margin-top30">
                                <div class="share-details">
                                    <div class="col-sm-6 col-xs-12">
                                        <img id="selectimgs" class="img-responsive center-block" src="images/Home/home-2.png" width="325">
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
foreach ($prnt_cat_data as $main_cat)
{
    echo '<div class="checkbox checkbox-primary padding-bottom15 edit_popup_border margin-bottom20">
                                                <input id="' . $main_cat['id'] . '" name="category_items[]" value="' . $main_cat['category_name'] . '" type="checkbox">
                                                <label for="' . $main_cat['id'] . '">' . $main_cat['category_name'] . '</label>
                                            </div>';
}
echo '<div class="appen_div" ></div>';
?>
                                    </form>
                                </div>
                                <div class="input-group list_create">
                                    <input type="text" id="new-create-list" name="list_name" class="form-control no_border" placeholder="List Name">
                                    <span class="input-group-btn btn primary-color-bg" id="list_createid">
                                        <a href="javascript:void(0);" >Create</a>
                                    </span>
                                </div><!-- /input-group -->
                                <div id="listerr" style="display:none;color:red;font-size:13px;">Enter list name</div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="share-cnt-row padding-top30 text-center">
                    <a href="javascript:void(0);" id="btn-doneid" class="edit_popup_button btn primary-color-bg bold-font transparent_border">Done</a>
                    <a href="javascript:void(0);" class="edit_popup_button btn primary-color-border-btn bold-font margin-left10 btn-unfancy"><?php echo $setngs['unlike_btn_cmnt']; ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
    <!-- Add to list popup -->
    </section>

                                                                              <!-- Main JS -->
                                                                              <!-- script for header dropdown  -->
                                                                              
                                                                              
                                                                     