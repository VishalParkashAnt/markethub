<?php
echo $this->element('numberconversion');
?>
<?php
if ($result == "livefeeds") {
    $result = "livefeeds";
} else {
    $result = "notification";
}
if (count($loguserdetails) > 0) {
    foreach ($loguserdetails as $log) {
        $logId       = $log['id'];
        $type        = $log['type'];
        $feedImages  = json_decode($log['image'], true);
        $notifymsg   = $log['notifymessage'];
        $feedMessage = $log['message'];
        $ldate       = $log['cdate'];
        $pastTime    = txt_time_diff($ldate);
        $logUserid   = $log['userid'];
        if (empty($feedImages['user']['link']))
            $feedImages['user']['link'] = 'javascript:void(0);';
        $userimages = $feedImages['user']['image'];
        if ($userimages == "")
            $userimages = "usrimg.jpg";
        $itemimages = $feedImages['item']['image'];
        if ($itemimages == "")
            $itemimages = "usrimg.jpg";
        $statusimages = $feedImages['status']['image'];
        if ($statusimages == "")
            $statusimages = "usrimg.jpg";
        $statusmessage = $feedImages['status']['message'];
        echo '<div class="activity_heading margin-top10 feed' . $logId . '">
    <div class="row">';
        if ($type == 'status' && $userid == $logUserid) {
            echo '<div class="dropdown pull-right margin-right20 float_right_mobile_rtl">
          <a data-toggle="dropdown" href="#" class="prod-share-icon-cnt">
                <div class="menu_like_status"></div>

            </a>
          <ul class="dropdown-menu dropdown-menu1 regular-font" role="menu" aria-labelledby="Label">
            <li><a href="javascript:void(0);" onclick="deletepost(' . $logId . ')">';
            echo __d('user', 'Delete');
            echo '</a></li>
          </ul>
    </div>';
        }
        echo '<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 span_1">
            <div class="live_feeds_logo1 image_center_mobile">
                <div class="live_feeds_logo" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $userimages . ');background-repeat:no-repeat;"></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8 margin_left20 margin-right20_mobile margin_left_0_tab span_8 text_center_seller">
            <div class="margin-left20 margin-right20 word_break">';
        $notifymsg = explode('-___-', $notifymsg);
        foreach ($notifymsg as $nmsg) {
            echo __d('user', $nmsg);
        }
        echo '</div>
            <p class="time_text margin-left20 margin-right20 extra_text_hide">' . $pastTime . '</p>

        </div>


    </div><p class="time_text margin-top10 margin-bottom10 text-content more word_break"></p>';
        if (isset($feedImages['item']) || isset($feedImages['status'])) {
            if (isset($feedImages['item'])) {
                $livefeedsitemimage = SITE_URL . 'media/items/original/' . $itemimages;
?>
       <div class="status_img1">
        <div class="like_status_img" data-toggle="modal" data-dismiss="modal" data-target="#feeds_image<?php
                echo $logId;
?>" style="background-image:url('<?php
                echo $livefeedsitemimage;
?>');"></div>
        </div>
    
    <!--Feeds Modal Starts-->
        <div id="feeds_image<?php
                echo $logId;
?>" class="modal fade" role="dialog" tabindex="1">
        <div class="modal-dialog downloadapp-modal text-center width_auto">
          <!-- Modal content-->
          <div class="modal-content dis_inline_block">
            <div class="modal-body padding0">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <img src="<?php
                echo $livefeedsitemimage;
?>" class="img-responsive feed_image">
            </div>
          </div>
        </div>
        </div>
    <!--Feeds Modal Ends-->
        
     <?php
            } elseif (isset($feedImages['status'])) {
                if (isset($statusmessage)) {
                    $pattern           = '/<a[^<>]*?[^<>]*?>(.*?)<\/a>/';
                    $atuserPattern     = '/<span[^<>]*?[^<>]*?>(.@?)<\/span>/';
                    $hashPattern       = '/<span[^<>]*?[^<>]*?>(.*#)<\/span>/';
                    $withoutAnchortag  = preg_replace($pattern, '$1', $statusmessage);
                    $withoutAtuserspan = preg_replace($atuserPattern, '$1', $withoutAnchortag);
                    $withoutHashspan   = preg_replace($hashPattern, '$1', $withoutAtuserspan);
                    echo "<div class='status'>" . $withoutHashspan . "</div>";
                } else {
                    //$livefeedsimage = SITE_URL . 'media/status/original/' . $statusimages;
                    $livefeedsimage = SITE_URL . 'media/status/original/' . $statusimages;
?>
   <div class="status_img1">
        <div class="like_status_img" data-toggle="modal" data-dismiss="modal" data-target="#feeds_image<?php
                    echo $logId;
?>" style="background-image:url('<?php
                    echo $livefeedsimage;
?>');">
        </div>
        </div>
    
    <!--Feeds Modal Starts-->
        <div id="feeds_image<?php
                    echo $logId;
?>" class="modal fade" role="dialog" tabindex="1">
        <div class="modal-dialog downloadapp-modal text-center width_auto">
          <!-- Modal content-->
          <div class="modal-content dis_inline_block">
            <div class="modal-body padding0">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <img src="<?php
                    echo $livefeedsimage;
?>" class="img-responsive feed_image">
            </div>
          </div>
        </div>
        </div>
    <!--Feeds Modal Ends-->
        
    <?php
                }
            }
        }
        if (!empty($feedMessage) || $type == 'checkin' || $type == 'status') {
            echo '<h4 class="bold-font margin-top20">' . __d('user', 'Message') . ': </h4>';
            echo '<p class="time_text margin-top10 margin-bottom10 text-content more word_break">' . $feedMessage . '</p>';
            if ($type == 'status' || $type == 'share' || $type == 'checkin') {
                $pattern           = '/<a[^<>]*?[^<>]*?>(.*?)<\/a>/';
                $atuserPattern     = '/<span[^<>]*?[^<>]*?>(.@?)<\/span>/';
                $hashPattern       = '/<span[^<>]*?[^<>]*?>(.*#)<\/span>/';
                $withoutAnchortag  = preg_replace($pattern, '$1', $feedMessage);
                $withoutAtuserspan = preg_replace($atuserPattern, '$1', $withoutAnchortag);
                $withoutHashspan   = preg_replace($hashPattern, '$1', $withoutAtuserspan);
                echo "<div class='status" . $logId . " deletestatus'>" . $withoutHashspan . "</div>";
                echo '<div class="activity_heading margin-top10 feed35">
                                <div class="like-counter-cnt regular-font font_size13 dis_comment">';
                if (in_array($logId, $logids)) {
                    echo '<a href="javascript:void(0);" onclick="likestatus(' . $logId . ')" class="like-cnt primary-color-txt">
        <i class="fa fa-heart like-icon' . $logId . ' margin-top0"></i>
        <span class="like-txt" id="like' . $logId . '">Unlike</span>
        </a>';
                } else {
                    echo '<a href="javascript:void(0);" onclick="likestatus(' . $logId . ')" class="like-cnt primary-color-txt">
        <i class="fa fa-heart-o like-icon' . $logId . ' margin-top0"></i>
        <span class="like-txt" id="like' . $logId . '">Like</span>
        </a>';
                }
                if ($likecount == "")
                    $likecount = 0;
                echo '<a href="javascript:void(0);" onclick="list_liked_users(' . $logId . ')" class="like-counter arrow_box" id="likecnt' . $logId . '">' . $likecount . '</a>
                </div>
                <a href="javascript:void(0);" onclick="showcomments(' . $logId . ')" class="add-to-list-cnt regular-font font_size13 dis_comment margin_left15_tab vertical_align_sub margin_19_comment" data-toggle="modal" data-target="#write-comment">
                    <div class="comment_icon"></div>
                    <div class="add-to-list-txt vertical_coment_txt">';
                echo __d('user', 'Write a Comment');
                echo '</div>
                </a>
                <a href="javascript:void(0);" class="prod-share-icon-cnt dis_comment regular-font font_size13 margin_left15_tab margin_19_comment">
                    <div class="prod-share-icon"></div>
                    <div class="add-to-list-txt vertical_coment_txt" onclick="share_feed(' . $logId . ')">';
                echo __d('user', 'Share');
                echo '</div>
                </a>
        </div>';
                echo '<input type="hidden" value="' . $userid . '" id="loguser_id" />';
                echo '<input type="hidden" value="' . $loguser['username'] . '" id="usernames">';
                echo '<input type="hidden" value="' . $loguser['id'] . '" id="userid">';
                echo '<input type="hidden" value="' . $loguser['profile_image'] . '" id="userimges">';
                echo '<div class="margin-top20 activity_heading nodisply commentarea' . $logId . '">
        <h4 class="comments_topic_margin text_center_seller word_break">';
                echo __d('user', 'Comments');
                echo ':</h4>';
                echo '<ol id="ulcomments' . $logId . '">';
                foreach ($feedcomments as $fcomment) {
                    echo '<div id="sa' . $logId . '"></div>';
                    for ($i = 0; $i < count($fcomment[$logId]['comments']); $i++) {
                        $commentusername    = $fcomment[$logId]['username'][$i];
                        $commentusernameurl = $fcomment[$logId]['username_url'][$i];
                        $comments           = $fcomment[$logId]['comments'][$i];
                        $commentid          = $fcomment[$logId]['id'][$i];
                        $commentuserid      = $fcomment[$logId]['userid'][$i];
                        $profileimage       = $fcomment[$logId]['profile_image'][$i];
                        if ($profileimage == "")
                            $profileimage = "usrimg.jpg";
                        $pattern       = '/<a[^<>]*?[^<>]*?>(.*?)<\/a>/';
                        $atuserPattern = '/<span[^<>]*?[^<>]*?>(.@?)<\/span>/';
                        $hashPattern   = '/<span[^<>]*?[^<>]*?>(.*#)<\/span>/';
                        echo '<div class="comment-row row hor-padding status-cmnt comment delecmt_' . $commentid . ' commentli" commid="' . $commentid . '">

                    <div class="live_feeds_logo1 padding_right0_rtl col-xs-3 col-lg-2 padding-right0 padding-left0 image_center_mobile">

                        <div class="live_feeds_logo" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $profileimage . ');background-repeat:no-repeat;"></div>

                    </div>
                    <div class="comment-section col-xs-9 col-lg-10 padding-right0 border_bottom_grey padding-bottom10">
                        <div class="bold-font comment-name">' . $commentusername . '</div>
                    
                        <div class="margin-top10 comment-txt regular-font font_size13">
                            ' . $comments . '
                        </div>

                        <div id="oritextvalafedit' . $commentid . '"></div>
                        <div class="comment-autocompleteN' . $commentid . '" style="display: none;left:43px;width:548px;">
                        <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0">
                        </ul>
                        </div>';
                        if ($commentuserid == $userid) {
                            echo '<div class="comment-edit-cnt c-reply col-lg-12 no-hor-padding margin-top10">

                    <a class="comment-delete red-txt" href="javascript:void(0);" onclick = "return deletefeedcmnt(' . $commentid . ',' . $logId . ')">Delete</a>
                </div>';
                        }
                        echo '</div>
            </div>';
                    }
                }
                echo '</div>';
                if ($feedcommentcount[$logId] > 2) {
                    echo '<div id="morefeed' . $logId . '" onclick="loadmorefeedcomments(' . $logId . ')" class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 regular-font font_size13 margin_bottom_mobile20 nodisply commentarea' . $logId . '"><a href="javascript:void(0);">Load more comments</a>
            </div>';
                }
            }
        } else {
            echo "<div style='padding:0 0 3px'></div>";
        }
        echo '</div>';
    }
} else {
}
?>