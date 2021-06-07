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
            <div class="signup-welcome-row text-center"><h3 class="bold-font"><?php echo __d('user','FOLLOW');?> <?php echo strtoupper($setngs['site_name']);?> <?php echo __d('user','PEOPLE');?></h3></div>
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
              <div class="signup-follow-prof-details" style="width:auto;!important">
              <div class="signup-follow-name bold-font">'.$people['first_name'].'</div>
              <div class="signup-follow-id">@'.$people['first_name'].' '.$people['last_name'].'</div>
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
        <a href="" class="embed-modal wiz-btn text-center primary-color-bg bold-font" data-toggle="modal" data-dismiss="modal" data-target="#signup-wizard-modal-3" data-backdrop="static" data-keyboard="false" style="width: 100%;"><?php echo __d('user', 'NEXT'); ?></a>
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
          <div class="signup-welcome-row text-center"><h3 class="bold-font"><?php echo __d('user','FOLLOW');?> <?php echo strtoupper($setngs['site_name']);?> <?php echo __d('user','STORES');?></h3></div>
          <div class="signup-welcome-row text-center"><?php echo __d('user','Follow a few top contributors to discover great things.');?></div>
          <div class="signup-follow-cnt text-center margin-top20">
            <?php
            foreach ($followstore as $store) {
              $shop_img = $store['shop_image'];
              if($shop_img == "")
                $shop_img ="usrimg.jpg";
              echo '<div class="signup-follow-row margin-top20">
              <div class="signup-follow-left">
              <div class="signup-follow-prof-img margin-right10">
              <img class="img-responsive" src="'.SITE_URL.'media/avatars/thumb70/'.$shop_img.'"></div>
              <div class="signup-follow-prof-details" style="width:auto;!important">
              <div class="signup-follow-name bold-font">'.$store['shop_name'].'</div>
              <div class="signup-follow-id">@'.$store['merchant_name'].'</div>
              </div>
              </div>
              <div class="signup-follow-right pull-right">
              <span id="folls'.$store['id'].'">
              <div class="user_followers_butn btn">
              <a href="javascript:void(0);" onclick="getshopfollows('.$store['id'].')">'.__d('user','Follow Store').'</a>
              </div>
              </span>
              <span id="changebtnn'.$store['id'].'"></span>
              </div>
              </div>';
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
<!-- Signup wizard Modal-4>-->
<div id="signup-wizard-modal-4" class="modal fade" role="dialog">
  <div class="modal-dialog downloadapp-modal">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <div class="signup-welcome-container margin-bottom50 margin-top50">
          <div class="signup-welcome-row text-center"><i class="primary-color-txt fa fa-smile-o"></i></div>
          <div class="signup-welcome-row text-center margin-top30"><h3 class="bold-font"><?php echo __d('user','WELL DONE');?></h3></div>
          <div class="signup-welcome-row text-center margin-top30 margin-bottom30">
            <!-- <a class="btn follow-btn primary-color-bg pull-right margin-top10" href="<?php //echo SITE_URL;?>"><?php //echo __d('user','Happy Shopping');?></a> -->
            <a class="btn follow-btn primary-color-bg pull-right margin-top10" href="javascript:void(0);" onclick="close_welcome();"><?php echo __d('user','Happy Shopping');?></a>
            
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
    var backurl = "<?php echo $_SESSION['backURL']; ?>";
    //alert(backurl);
    if(backurl != "") {
    window.location = backurl;
    } else {
    window.location = baseurl;
    }
  }
</script>