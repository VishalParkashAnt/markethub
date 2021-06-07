<?php
use Cake\Routing\Router;
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Merchant Panel';
$baseurl = Router::url('/');
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <?= $this->Html->charset() ?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITE_URL; ?>/favicon.ico">
    <title>
        <?php
            if(!empty($title_for_layout))
                echo $title_for_layout." - ";
        ?><?= $cakeDescription ?>
    </title>
    <?php //$this->Html->meta('icon') ?>
    <!-- Bootstrap Core CSS -->
    <?= $this->Html->css('assets/plugins/bootstrap/css/bootstrap.min.css') ?>

    <?= $this->Html->css('assets/plugins/toast-master/css/jquery.toast.css') ?>
    <?= $this->Html->css('style.css') ?>
    <!-- You can change the theme colors from here -->
    <?= $this->Html->css('blue.css') ?>
      <!-- ?= $this->Html->css('cake.css') ? -->
    <?= $this->Html->css('seller.css') ?>

    <!-- Bootstrap tether Core JavaScript -->
    <?= $this->Html->script('assets/plugins/jquery/jquery.min.js') ?>
    <?= $this->Html->script('assets/plugins/bootstrap/js/tether.min.js') ?>
    <?= $this->Html->script('assets/plugins/bootstrap/js/bootstrap.min.js') ?>
    <?= $this->Html->script('jquery.translate.js') ?>
    <?= $this->Html->script('sellertranslate.js') ?>

    <script src="<?php echo SITE_URL; ?>css/assets/plugins/datatables/jquery.dataTables.min.js"></script>

    <?= $this->Html->script('seller.js') ?>
    <style>
        .dropdown-item.active, .dropdown-item:active {
          background-color: #009efb !important;
        }
        #user_email {
          color: #54667a;
          font-size: 15px;
          font-weight: 500;
          overflow-wrap: break-word;
          text-overflow: ellipsis;
          word-break: break-all;
          margin: 10px 0px 0px;
        }
        #pro_edit:focus, #pro_edit:hover {
            background: #009efb none repeat scroll 0 0;
        }

        /* Notification */
        .notify-cnt {
            color: #009efb !important;
            font-weight: 500;
            font-size: 14px;
        }
        .notify-title {
            color: #009efb !important;
        }
        .message-center > ul.notify-message {
            display: inline-flex;
            padding: 15px 10px !important;
        }
        .message-center > ul+ul {
            border-top: 1px solid rgba(120, 130, 140, 0.13);
        }
        .message-center > ul.notify-message .notify-content {
            padding-left:15px;
            font-size: 13px;
            font-weight: 400;
        }
        .message-center > ul.notify-message .notify-content > span > a {
            border: none;   display: inline-block;  padding: 0px;
            background: none; text-transform: capitalize;
        }
        .message-center > ul.notify-message .notify-content > span > a:hover{
            background: none;
        }
        .message-center > ul.notify-message .notify-content .notify-desc {
            display: block;
            word-break: break-all;
        }
        .message-center > ul.notify-message .notify-image img {
            height: 40px; width:40px; border-radius: 100px;
        }
        #all_notify {
            font-size: 12px;  font-weight: 400;
        }
        #all_notify:hover {
            color: #009efb !important;
        }
        #langstatus {
            font-size: 16px;
            font-weight: 400;
        }
        #merchantlanguage > .dropdown-menu {
            min-width: 100px !important;
        }
        #merchantlanguage > .dropdown-menu > a {
            padding: 5px 12px;
            font-size: 15px;
            font-weight: 400;
            text-align: center;
        }
        #notify_count > span {
         padding:5px 10px; float:right; font-weight: bold;
        }

    </style>
</head>
<body class="fix-header fix-sidebar card-no-border">
<?php
  if(!empty($menu_highlight) && $menu_highlight == "couponactive") {
      $chighlight = "active";
  } else {
      $chighlight = "";
  }

  if(!empty($menu_highlight) && $menu_highlight == "disputeactive") {
      $dhighlight = "active";
  } else {
      $dhighlight = "";
  }
      
?>              
<?= $this->Flash->render() ?>

 <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>

    <input id='languagecode' type="hidden" value="<?php echo trim($_SESSION['languagecode']); ?>">
    <input id='mainsubcat_lang' type="hidden" value="<?php echo __d('merchant', 'Select Category'); ?>">

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo SITE_URL; ?>merchant/dashboard">
                        <!-- Logo icon -->
                        <b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="<?php echo $baseurl;?>images/logo/<?php  echo $setngs->site_logo_icon; ?>" alt="" class="logo-icon" />
                            <!-- Light Logo icon -->
                            <!--<img src="<?php //echo SITE_URL; ?>images/logo-light-icon.png" alt="" class="light-logo" />-->
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span>
                         <!-- dark Logo text -->
                         <img src="<?php echo $baseurl;?>images/logo/<?php  echo $setngs->site_logo; ?>" alt="Fantacy" class="dark-logo" />
                         <!-- Light Logo text -->
                         <!--<img src="<?php //echo SITE_URL; ?>images/logo-light-text.png" class="light-logo" style="color: #009efb;" alt="Fantacy" />--></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <input id='notify_usercount' type="hidden" value="<?php echo trim($userLogData['unread_notify_cnt']); ?>">

                    <ul class="navbar-nav mr-auto mt-md-0 ">
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>

                        <li class="nav-item dropdown">
                            <a id="load_notify" class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="mdi mdi-message"></i>
                              <?php if(!empty(trim($userLogData['unread_notify_cnt'])) && (trim($userLogData['unread_notify_cnt'])) > 0) { ?>
                                 <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                              <?php } ?>
                            </a>
                            <div class="dropdown-menu mailbox animated bounceInDown">
                                <ul>
                                    <?php if(count($recentlogs) <= 0) { ?>
                                        <li style="padding: 15px 0px;">
                                            <div class="notify-cnt text-center">
                                               <?php echo __d('merchant', 'No Notifications'); ?>
                                            </div>
                                        </li>
                                    <?php } else { ?>
                                    <li>
                                        <div class="drop-title notify-title">Notifications
                                        <?php if(trim($userLogData['unread_notify_cnt']) != "" && (trim($userLogData['unread_notify_cnt'])) >= 0) {?>
                                            <span id="notify_count"></span>
                                        <?php } ?>
                                        </div>
                                    </li>
                                    <li>
                                       <div class="message-center m-b-10">
                                       <?php foreach($recentlogs as $key => $logs) { ?>
                                          <?php if($logs['type']=="follow" || $logs['type']=="review") { ?>
                                             <ul class="notify-message">
                                                <li class="notify-image">
                                                   <?php
                                                   $io = array();
                                                   $io = json_decode($logs['image'],true);
                                                   if(!empty(trim($io['user']['image']))) { ?>
                                                      <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                                                  <?php } else { ?>
                                                      <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                                                  <?php } ?>
                                                </li>
                                                <li class="notify-content">
                                                   <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>
                                                   <span class="notify-desc">
                                                     <?php echo $notifymsg[0]." ".__d('merchant',trim($notifymsg[1])); ?>
                                                   </span>
                                                </li>
                                             </ul>
                                       <?php } else if($logs['type']=="sellermessage") { ?>
                                          <ul class="notify-message">
                                             <li class="notify-image">
                                                <?php
                                                $io = array();
                                                $io = json_decode($logs['image'],true);
                                                if(!empty(trim($io['user']['image']))) { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                                               <?php } else { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                                               <?php } ?>
                                             </li>
                                             <li class="notify-content">
                                                <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>
                                                <span class="notify-desc">
                                                  <?php echo __d('merchant',trim($notifymsg[0]))." ".$notifymsg[1]." ".__d('merchant',trim($notifymsg[2])); ?>
                                                </span>
                                             </li>
                                          </ul>
                                       <?php } else if($logs['type']=="admin" || $logs['type']=="credit") { ?>
                                          <ul class="notify-message">
                                             <li class="notify-image">
                                                <?php
                                                $io = array();
                                                $io = json_decode($logs['image'],true);
                                                if(!empty(trim($io['user']['image']))) { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                                               <?php } else { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                                               <?php } ?>
                                             </li>
                                             <li class="notify-content">
                                                <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>
                                                <span class="notify-desc">
                                                <?php if(count($notifymsg)>2) {
                                                  echo $notifymsg[0]." ".__d('merchant',trim($notifymsg[1]))." ".$notifymsg[2];
                                                } else {
                                                  echo __d('merchant',trim($notifymsg[0]))." ".$notifymsg[1];
                                                } ?>
                                                </span>
                                             </li>
                                          </ul>
                                       <?php } else if($logs['type']=="admin_commision") { ?>
                                          <ul class="notify-message">
                                             <li class="notify-image">
                                                <?php
                                                $io = array();
                                                $io = json_decode($logs['image'],true);
                                                if(!empty(trim($io['user']['image']))) { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                                               <?php } else { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                                               <?php } ?>
                                             </li>
                                             <li class="notify-content">
                                                <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>
                                                <span class="notify-desc">
                                                <?php if(count($notifymsg)>2) {
                                                  echo __d('merchant',trim($notifymsg[0]))." ".__d('merchant',trim($notifymsg[1]))." ".$notifymsg[2];
                                                } else {
                                                  echo __d('merchant',trim($notifymsg[0]))." ".__d('merchant',trim($notifymsg[1]));
                                                } ?>
                                                </span>
                                             </li>
                                          </ul>   
                                       <?php } else if($logs['type']=="ordermessage") { ?>
                                          <ul class="notify-message">
                                             <li class="notify-image">
                                                <?php
                                                $io = array();
                                                $io = json_decode($logs['image'],true);
                                                if(!empty(trim($io['user']['image']))) { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                                               <?php } else { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                                               <?php } ?>
                                             </li>
                                             <li class="notify-content">
                                                <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>
                                                <span class="notify-desc">
                                                  <?php echo __d('merchant',trim($notifymsg[0]))." ".$notifymsg[1]." ".__d('merchant',trim($notifymsg[2]))." ".$notifymsg[3]; ?>
                                                </span>
                                             </li>
                                          </ul>
                                       <?php } else if($logs['type']=="chatmessage" || $logs['type']=="dispute" || $logs['type']=="groupgift" || $logs['type']=="orderstatus") { ?>
                                           <ul class="notify-message">
                                             <li class="notify-image">
                                                <?php
                                                $io = array();
                                                $io = json_decode($logs['image'],true);
                                                if(!empty(trim($io['user']['image']))) { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                                               <?php } else { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                                               <?php } ?>
                                             </li>
                                             <li class="notify-content">
                                                <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>
                                                <span class="notify-desc">
                                                  <?php echo $notifymsg[0]." ".__d('merchant',trim($notifymsg[1]))." ".$notifymsg[2]; ?>
                                                </span>
                                             </li>
                                          </ul>
                                       <?php } else { ?>
                                          <ul class="notify-message">
                                             <li class="notify-image">
                                                <?php
                                                $io = array();
                                                $io = json_decode($logs['image'],true);
                                                if(!empty(trim($io['user']['image']))) { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                                               <?php } else { ?>
                                                   <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                                               <?php } ?>
                                             </li>
                                             <li class="notify-content">
                                                <?php $notifymsg = str_replace("-___-"," ",$logs['notifymessage']); ?>
                                                <span class="notify-desc">
                                                  <?php echo $notifymsg; ?>
                                                </span>
                                             </li>
                                          </ul>
                                       <?php } } ?>
                                       </div>
                                    </li>
                                    <li>
                                        <a id="all_notify" class="nav-link text-center" href="<?php echo SITE_URL;?>merchant/notifications"> <?php echo __d('merchant', 'Check all notifications'); ?> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>

                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                if(!empty(trim($userLogData['profile_image']))) { ?>
                                    <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $userLogData['profile_image']; ?>" alt="Fantacy" class="profile-pic" />
                                <?php } else { ?>
                                    <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"  class="profile-pic" />
                                <?php } ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box row m-0">
                                            <div class="u-img col-sm-4 p-0">
                                                <?php if(!empty(trim($userLogData['profile_image']))) { ?>
                                                    <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $userLogData['profile_image']; ?>" alt="Fantacy" />
                                                <?php } else { ?>
                                                    <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg" alt="Fantacy" />
                                                <?php } ?>
                                            </div>
                                            <div class="u-text col-sm-8 text-center p-r-10">
                                                <h5 style="text-transform: capitalize; color:#009efb; word-break: break-all !important;"><?php echo $userLogData['first_name'];?></h5>
                                                <a id="pro_edit" href="<?php echo SITE_URL;?>merchant/sellerinformation" class="btn btn-rounded btn-info btn-sm m-t-5"><?php echo __d('merchant','Edit Profile'); ?></a>
                                            </div>
                                            <!-- h6 id="user_email" class="col-sm-12 p-0"><?php // echo "@ ".$userLogData['username'];?></h6 -->
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <!-- li><a href="#"><i class="ti-user"></i> My Profile</a></li -->
                                    <li><a href="<?php echo MERCHANT_URL;?>/messages"><i class="ti-email"></i> <?php echo __d('merchant','Messages'); ?> </a></li>
                                    <li><a href="<?php echo MERCHANT_URL;?>/news"><i class="ti-wallet"></i> <?php echo __d('merchant','News'); ?> </a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo MERCHANT_URL;?>/changepassword"><i class="ti-settings"></i> <?php echo __d('merchant','Change Password'); ?></a></li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <?php  if ($this->request->session()->read('Auth.Merchant')) { ?>
                                            <li>
                                                <a href="<?php echo SITE_URL;?>merchant/logout">
                                                    <i class="fa fa-power-off"></i> <?php echo __d('merchant','Logout'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li id="merchantlanguage" class="nav-item dropdown">
                            <a id="langstatus" class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <?php if($_SESSION['languagecode']=='') { echo __d('merchant','English'); } else { echo __d('merchant',$_SESSION['languagename']); } ?>
                            </a>

                           <div class="dropdown-menu  dropdown-menu-right animated bounceInDown">
                           <?php
                              foreach ($languages as $lang) {
                                if(strtolower($lang['languagename']) == "english" || strtolower($lang['languagename']) == "french" ||strtolower($lang['languagename']) == "spanish" ) {
                                 echo'<a class="dropdown-item" href="'.MERCHANT_URL.'/language/'.$lang['languagename'].'">'.__d('merchant',$lang['languagename']).'</a>';
                                }
                              }
                           ?>
                           </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li>
                            <a href="<?php echo MERCHANT_URL;?>/dashboard"><i class="mdi mdi-gauge"></i><span class="hide-menu"> <?php echo __d('merchant','Dashboard'); ?> </span></a>
                        </li>

                        <li class="three-column">
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-filmstrip"></i><span class="hide-menu"> <?php echo __d('merchant','Manage Products'); ?> </span></a>
                            <ul aria-expanded#"false" class="collapse">
                                <li><?= $this->Html->link(__d('merchant','Add Products'), ['action' => 'createitem']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','Manage Products'), ['action' => 'updateproducts']) ?></li>
                                
                                <!-- li><? //= $this->Html->link('Mass Upload', ['action' => 'dashboard']) ?></li -->
                            </ul>
                        </li>

                        <li class="three-column">
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-filmstrip"></i><span class="hide-menu"> <?php echo __d('merchant','Manage FAQS'); ?> </span></a>
                            <ul aria-expanded#"false" class="collapse">
                                <li><?= $this->Html->link(__d('merchant','Not answered'), ['action' => 'productsfaq']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','Answered'), ['action' => 'answeredproductsfaq']) ?></li>
                                <!-- li><? //= $this->Html->link('Mass Upload', ['action' => 'dashboard']) ?></li -->
                            </ul>
                        </li>



                        <!-- li>
                            <a href="<?php // echo MERCHANT_URL;?>/messages"><i class="mdi mdi-gauge"></i><span class="hide-menu"> Messages </span></a>
                        </li -->

                        <!-- li>
                            <a href="<?php // echo MERCHANT_URL;?>/news"><i class="mdi mdi-gauge"></i><span class="hide-menu"> News </span></a>
                        </li -->

                        <li class="three-column">
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-cart"></i><span class="hide-menu"> <?php echo __d('merchant', 'Manage Orders'); ?> </span></a>
                            <ul aria-expanded#"false" class="collapse">
                                <li><?= $this->Html->link(__d('merchant','Fulfil Orders'), ['action' => 'fulfillorders']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','New Orders'), ['action' => 'actionrequired']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','History Orders'), ['action' => 'history']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','Claimed Orders'), ['action' => 'claimed']) ?></li>
                                <!-- li><?// = $this->Html->link(__d('merchant','Returned Orders'), ['action' => 'returned']) ?></li -->
                                <li><?= $this->Html->link(__d('merchant','Cancelled Orders'), ['action' => 'cancelled']) ?></li>
                            </ul>
                        </li>

                        <li class="three-column <?php echo $chighlight; ?>">
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-cards-outline"></i><span class="hide-menu"> <?php echo __d('merchant','Coupons'); ?> </span></a>
                            <ul aria-expanded#"false" class="collapse">
                                <li><?= $this->Html->link(__d('merchant','Manage Coupons'), ['action' => 'itemcoupons'], ['class' => $chighlight]) ?></li>
                                <li><?= $this->Html->link(__d('merchant','Add Category Coupon'), ['action' => 'addcategorycoupon']) ?></li>
                            </ul>
                        </li>

                        <li class="three-column">
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu"> <?php echo __d('merchant','Abandon Cart'); ?> </span></a>
                            <ul aria-expanded#"false" class="collapse">
                                <li><?= $this->Html->link(__d('merchant','Manage Cart Details'), ['action' => 'cartdetails']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','Add Cart Coupon'), ['action' => 'addcartcoupon']) ?></li>
                            </ul>
                        </li>

                        <li class = "<?php echo $dhighlight; ?>">
                            <a class="<?php echo $dhighlight; ?>" href="<?php echo MERCHANT_URL;?>/disputes/<?php echo $_SESSION['first_name'];?>?buyer"><i class="mdi mdi-account-multiple"></i><span class="hide-menu"> <?php echo __d('merchant','Disputes'); ?> </span></a>
                        </li>

                        <li class="three-column">
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-email-outline"></i><span class="hide-menu"> <?php echo __d('merchant','Newsletter'); ?> </span></a>
                            <ul aria-expanded#"false" class="collapse">
                                <!-- ?= $this->Html->link('Add Contacts', ['action' => 'addnews']) ? -->
                                <li><?= $this->Html->link(__d('merchant','Send Newsletter'), ['action' => 'newsletter']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','Get Contacts List'), ['action' => 'getcontacts']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','Manage Newsletter'), ['action' => 'managenewsletter']) ?></li>
                            </ul>
                        </li>

                        <li class="three-column">
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-cash"></i><span class="hide-menu"> <?php echo __d('merchant','Payment'); ?> </span></a>
                            <ul aria-expanded#"false" class="collapse">
                                <li><?= $this->Html->link(__d('merchant','Payment Settings'), ['action' => 'paymentsettings']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','Payment History'), ['action' => 'paymenthistory']) ?></li>
                            </ul>
                        </li>

                        <li class="three-column">
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu"> <?php echo __d('merchant','Merchant'); ?> </span></a>
                            <ul aria-expanded#"false" class="collapse">
                                <li><?= $this->Html->link(__d('merchant','Seller Information'), ['action' => 'settings']) ?></li>
                                <li><?= $this->Html->link(__d('merchant','Fashion User Image'), ['action' => 'userphotoupload']) ?></li>
                            </ul>
                        </li>

                        <!-- li class="nav-devider"></li -->


                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
                <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper p-b-0">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div -->
                    <!-- div class="col-md-6 col-4 align-self-center">
                        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                    </div>
                </div -->
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <?php echo $this->fetch('content');?>

 <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme working">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer m-t-10 logfooter row">
                <div class="col-md-6 col-sm-6"><?php echo $setngs['footer_left']; ?></div>
                <div  class="col-md-6 col-sm-6 text-right"><?php echo $setngs['footer_right']; ?></div>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- slimscrollbar scrollbar JavaScript -->
    <?= $this->Html->script('jquery.slimscroll.js') ?>
    <!--Wave Effects -->
    <?= $this->Html->script('waves.js') ?>
    <!--Menu sidebar -->
    <?= $this->Html->script('sidebarmenu.js') ?>
    <!--stickey kit -->
    <?= $this->Html->script('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') ?>
    <!--Custom JavaScript -->
     <?= $this->Html->script('custom.min.js') ?>

    <?= $this->Html->script('assets/plugins/styleswitcher/jQuery.style.switcher.js') ?>
    <script>
      $( document ).ready(function() {
      var foo_height = $('.page-wrapper').outerHeight();
      var footer_hgt = $('.logfooter').outerHeight();
      foo_height = foo_height - footer_hgt;
       $('.page-wrapper > .container-fluid').css({'min-height':foo_height});
    });
    </script>


</body>
</html>