  <!-- Signup wizard Modal-1 -->
  <div id="signup-wizard-modal-1" class="modal fade" role="dialog">
    <div class="modal-dialog downloadapp-modal">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <div class="signup-welcome-container margin-bottom50 margin-top50">
            <div class="signup-welcome-row text-center"><i class="primary-color-txt fa fa-smile-o"></i></div>
            <div class="signup-welcome-row text-center margin-top30"><h3 class="bold-font"><?php echo __d('user','WELCOME TO');?> <?php echo $setngs['site_name'];?></h3></div>
            <div class="signup-welcome-row text-center margin-top30 margin-bottom30"><?php echo __d('user','Thanks for activating your account. Exciting shopping experience is waiting for you.');?></div>
          </div>
        </div>
        <div class="wizard-btn-cnt">
          <a href="javascript:void(0);" onclick="close_welcome();" class="wiz-btn text-center dark-grey-bg bold-font"><?php echo __d('user','SKIP');?></a>
          <a href="javascript:void(0);" id="wiz-1-btn" class="embed-modal wiz-btn text-center primary-color-bg bold-font" data-toggle="modal" data-dismiss="modal" data-target="#signup-wizard-modal-2" data-backdrop="static" data-keyboard="false"><?php echo __d('user', 'NEXT'); ?></a>
        </div>
      </div>
    </div>
  </div>
  <!-- Signup wizard Modal-2 -->
  <div id="signup-wizard-modal-2" class="modal fade" role="dialog">
    <div class="modal-dialog downloadapp-modal">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <div class="signup-welcome-container">
            <div class="signup-welcome-row text-center"><h3 class="bold-font"><?php echo __d('user','FOLLOW');?> <?php echo $setngs['site_name'];?> <?php echo __d('user','PEOPLE');?></h3></div>
            <div class="signup-welcome-row text-center"><?php echo __d('user','Follow a few top contributors to discover great things.');?></div>
            <div class="signup-follow-cnt text-center margin-top20">
              <?php
              foreach ($followpeople as $people) {
                $profile_img = $people['profile_image'];
                if($profile_img == "")
                  $profile_img ="usrimg.jpg";
                echo '<div class="signup-follow-row margin-top20">
                <div class="signup-follow-left">
                <div class="signup-follow-prof-img margin-right10">
                <img class="img-responsive" src="'.SITE_URL.'media/avatars/thumb70/'.$profile_img.'"></div>
                <div class="signup-follow-prof-details">
                <div class="signup-follow-name bold-font">'.$people['first_name'].'</div>
                <div class="signup-follow-id">@'.$people['username'].'</div>
                </div>
                </div>
                <div class="signup-follow-right pull-right">
                <span id="foll'.$people['id'].'">
                <div class="user_followers_butn btn">
                <a href="javascript:void(0);" onclick="getfollows('.$people['id'].')">'.__d('user','Follow').'</a>
                </div>
                </span>
                <span id="changebtn'.$people['id'].'"></span>
                </div>
                </div>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="wizard-btn-cnt">
          <a href="" class="embed-modal wiz-btn text-center primary-color-bg bold-font" data-toggle="modal" data-dismiss="modal" data-target="#signup-wizard-modal-3" data-backdrop="static" data-keyboard="false" style="width: 100%;">
            <?php echo __d('user', 'NEXT'); ?></a>
          </div>
        </div>
      </div>
    </div>
    <!-- Signup wizard Modal-3 -->
    <div id="signup-wizard-modal-3" class="modal fade" role="dialog">
      <div class="modal-dialog downloadapp-modal">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <div class="signup-welcome-container">
              <div class="signup-welcome-row text-center"><h3 class="bold-font"><?php echo __d('user','FOLLOW').' '.$setngs['site_name'].' '.__d('user','STORES');?></h3></div>
              <div class="signup-welcome-row text-center"><?php echo __d('user','Follow a few top contributors to discover great things.');?></div>
              <div class="signup-follow-cnt text-center margin-top20">
                <?php
                foreach ($itemvalforfant as $item) {
                  $item_image = $item['photos'][0]['image_name'];
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
                  echo '<input type="hidden" id="likebtncnt" value="'.$setngs['like_btn_cmnt'].'" />';
                  echo '<input type="hidden" id="likedbtncnt" value="'.$setngs['liked_btn_cmnt'].'" />';
                  echo '
                  <div class="product_cnt col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom20 fh5co-board-img">
                  <a class="img-hover" href="javascript:void(0)">
                  <img src="'.$itemimage.'" class="img-responsive" />
                  </a>
                  <div class="hover-visible">
                  <span class="hover-icon-cnt like_hover white-txt" href="javascript:void(0)" data-toggle="modal" data-target="#edit1-modal" onclick="itemcou('.$item['id'].')">
                  <i class="fa fa-heart-o like-icon"></i>
                  <span class="like-txt nodisply">'.$setngs['like_btn_cmnt'].'</span>
                  </span>
                  </div>
                  <div class="rate_section padding-left0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                  <div class="product_name bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                  <a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="">'.$item['item_title'].'</a><br/>
                  <span class="price"><a class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="">$'.$item['forexrate']['currency_symbol'].$item['price'].'</a></span>
                  </div>
                  </div>
                  </div>
                  ';
                }
                ?>
              </div>
            </div>
          </div>
          <div class="wizard-btn-cnt">
            <a href="" class="embed-modal wiz-btn text-center primary-color-bg bold-font" data-toggle="modal" data-dismiss="modal" data-target="#signup-wizard-modal-4" data-backdrop="static" data-keyboard="false" style="width: 100%;"><?php echo __d('user', 'NEXT'); ?></a>
          </div>
        </div>
      </div>
    </div>
    <div id="signup-wizard-modal-4" class="modal fade" role="dialog">
      <div class="modal-dialog downloadapp-modal">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <div class="signup-welcome-container margin-bottom50 margin-top50">
              <div class="signup-welcome-row text-center"><i class="primary-color-txt fa fa-smile-o"></i></div>
              <div class="signup-welcome-row text-center margin-top30"><h3 class="bold-font"><?php echo __d('user','WELL DONE');?></h3></div>
              <div class="signup-welcome-row text-center margin-top30 margin-bottom30">
                <a class="btn follow-btn primary-color-bg pull-right margin-top10" href="<?php echo SITE_URL;?>"><?php echo __d('user','Happy Shopping');?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      var baseurl = getBaseURL();
      $('#signup-wizard-modal-1').modal({
        backdrop: 'static',
        keyboard: 'false',
        show:'true'
      })
      function close_welcome()
      {
        window.location = baseurl;
      }
    </script>