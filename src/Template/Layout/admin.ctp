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

$cakeDescription = 'Admin Panel';
?>
<!DOCTYPE html>
<html>
<style type="text/css">
.footerstyleleft
{
    float:left;
    
}
.footerstyleright
{
    float:right;
    
}
@media (min-width: 321px) and (max-width: 690px) {.footerstyleleft
{
    float:none;
    text-align: center;
    
} }
@media (min-width: 321px) and (max-width: 690px) {.footerstyleright
{
    float:none;
    text-align: center;
    
} }
</style>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>


    <title>Monster Admin Template - The Most Complete & Trusted Bootstrap 4 Admin Template</title>

     <?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
    <?= $this->Html->css('assets/plugins/bootstrap/css/bootstrap.min.css') ?>
    <?= $this->Html->css('assets/plugins/chartist-js/dist/chartist.min.css') ?>
    <?= $this->Html->css('assets/plugins/chartist-js/dist/chartist-init.css') ?>
    <?= $this->Html->css('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') ?>
      <?= $this->Html->css('assets/plugins/html5-editor/bootstrap-wysihtml5.css') ?>

 <?= $this->Html->css('assets/plugins/jsgrid/dist/jsgrid.min.css') ?>

 <?= $this->Html->css('assets/plugins/jsgrid/dist/jsgrid-theme.min.css') ?>
   
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('blue.css') ?>
    <?= $this->Html->css('scss/icons/material-design-iconic-font/css/materialdesignicons.min.css') ?>
  <?= $this->Html->css('scss/icons/font-awesome/css/font-awesome.min.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->script('jquery.js') ?>
     <?= $this->Html->script('anekart.js') ?>
       <?= $this->Html->script('jsgrid-init.js') ?>
      <?= $this->Html->script('jQuery.print.js') ?>
    <?= $this->Html->script('assets/plugins/jquery/jquery.min.js') ?>

    <?= $this->Html->script('assets/plugins/bootstrap/js/tether.min.js') ?>
    <?= $this->Html->script('assets/plugins/bootstrap/js/bootstrap.min.js') ?>
    <?= $this->Html->script('jquery.slimscroll.js') ?>
    <?= $this->Html->script('waves.js') ?>
    <?= $this->Html->script('sidebarmenu.js') ?>
    <?= $this->Html->script('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') ?>
    <?= $this->Html->script('custom.min.js') ?>
   
    <?= $this->Html->script('dashboard1.js') ?>
     <?= $this->Html->script('seller.js') ?>
    <?= $this->Html->script('assets/plugins/styleswitcher/jQuery.style.switcher.js') ?>
 <?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>
 <?= $this->Html->script('assets/plugins/jsgrid/dist/jsgrid.min.js') ?>
 <?= $this->Html->script('assets/plugins/datatables/jquery.dataTables.min.js') ?>
  <?= $this->Html->script('assets/plugins/tinymce/tinymce.min.js') ?>
    <?= $this->Html->script('jquery-ui-1.10.3.custom.min.js') ?>
  <?= $this->Html->script('jquery.tablesorter') ?>
  <script src="<?php echo SITE_URL.'js/jquery.translate.js';?>"></script>
  <script src="<?php echo SITE_URL.'js/admintranslate.js';?>"></script>
  <!-- Main JS -->
<script>
 jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });</script>
</head>
<body class="fix-header fix-sidebar card-no-border">
    <input type="hidden" id="languagecode" value="<?php echo $_SESSION['languagecode'];?>">
<?php
$baseurl = Router::url('/');
$mailid = $_SESSION['Auth']['Admin']['email'];
$username = $_SESSION['Auth']['Admin']['username'];

$getmenus = json_decode($loguser['admin_menus']);
$access = $userDetails['user_level'];

//$access = $loguser['user_level'];
//print_r($loguser);
?>


    <!--div class="container clearfix">

    </div-->
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
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
                    <a class="navbar-brand" href="<?php echo $baseurl; ?>dashboard">

                     <!-- Logo icon -->
                        <b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="<?php echo $baseurl;?>images/logo/<?php  echo $setngs->site_logo_icon; ?>" class="logo-icon" alt="homepage" />
                            <!-- Light Logo icon -->
                            <!--<img src="<?php echo $baseurl;?>images/logo-light-icon.png" alt="homepage" class="light-logo" />-->
                        </b>
                        <!--End Logo icon -->
                       
                        <!-- Logo text -->
                        <span>
                         <!-- dark Logo text -->


                       <!--  <img src="<?php //echo $baseurl;?>images/logo-text.png" alt="homepage" class="dark-logo" />-->
                       <img src="<?php echo $baseurl;?>images/logo/<?php  echo $setngs->site_logo; ?>" alt="Fantacy" class="dark-logo"  />

                         <!-- Light Logo text -->
                        <!--<img src="<?php echo $baseurl;?>images/logo-light-text.png" class="light-logo" alt="homepage" />--></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0 ">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Comment -->

                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">

                            <div class="dropdown-menu mailbox animated bounceInDown" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">You have 4 new messages</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown mega-dropdown">
                            <div class="dropdown-menu animated bounceInDown">
                                <ul class="mega-dropdown-menu row">
                                    <li class="col-lg-3 col-xlg-2 m-b-30">
                                        <h4 class="m-b-20">CAROUSEL</h4>
                                        <!-- CAROUSEL -->
                                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner" role="listbox">
                                                <div class="carousel-item active">
                                                    <div class="container"> <img class="d-block img-fluid" src="../assets/images/big/img1.jpg" alt="First slide"></div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="container"><img class="d-block img-fluid" src="../assets/images/big/img2.jpg" alt="Second slide"></div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="container"><img class="d-block img-fluid" src="../assets/images/big/img3.jpg" alt="Third slide"></div>
                                                </div>
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                                        </div>
                                        <!-- End CAROUSEL -->
                                    </li>
                                    <li class="col-lg-3 m-b-30">
                                        <h4 class="m-b-20">ACCORDION</h4>
                                        <!-- Accordian -->
                                        <div id="accordion" class="nav-accordion" role="tablist" aria-multiselectable="true">
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingOne">
                                                    <h5 class="mb-0">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                  Collapsible Group Item #1
                                                </a>
                                              </h5> </div>
                                                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="card-block"> Anim pariatur cliche reprehenderit, enim eiusmod high. </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingTwo">
                                                    <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                  Collapsible Group Item #2
                                                </a>
                                              </h5> </div>
                                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="card-block"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingThree">
                                                    <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                  Collapsible Group Item #3
                                                </a>
                                              </h5> </div>
                                                <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                                    <div class="card-block"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-3  m-b-30">
                                        <h4 class="m-b-20">CONTACT US</h4>
                                        <!-- Contact -->
                                        <form>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputname1" placeholder="Enter Name"> </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control" placeholder="Enter email"> </div>
                                            <div class="form-group">
                                                <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </form>
                                    </li>
                                    <li class="col-lg-3 col-xlg-4 m-b-30">
                                        <h4 class="m-b-20">List style</h4>
                                        <!-- List style -->
                                        <ul class="list-style-none">
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> You can give link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Give link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another Give link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Forth link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another fifth link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo SITE_URL;?>media/avatars/thumb70/usrimg.jpg" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src= "<?php echo SITE_URL;?>media/avatars/thumb70/usrimg.jpg" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?php echo $username; ?></h4>
                                                <p class="text-muted"><?php echo $mailid; ?></p><a href="<?php echo $baseurl; ?>adminsetting" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>


                                    <li><a href="<?php echo $baseurl; ?>adminlogout"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if($_SESSION['languagecode']=='') { echo 'ENGLISH'.'<i class="fa fa-angle-down" style="margin-left:10px;"></i>';  } else{ echo $_SESSION['languagename'].'<i class="fa fa-angle-down" style="margin-left:10px;"></i>';

                            } ?>
                            </a>
                            <div class="dropdown-menu lang-dd dropdown-menu-right animated bounceInDown">

                            <?php
                            foreach ($languages as $lang) {
                                if($lang['languagecode'] != "ar")
                            echo'<a class="dropdown-item" >'.$lang['languagename'].'</a>';
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

                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <?php if (in_array("Home", $getmenus) || $access == 'god') { ?>
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu"><?php echo __d('admin','Dashboard');?> </span></a>
                            <ul aria-expanded="false" class="collapse">

                                <li><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin','Home');?></a></li>
                            </ul>
                        </li>
                          <?php } ?>

                        <li>
<?php if (in_array("Add User", $getmenus) || $access == 'god' || in_array("Approved Users", $getmenus) || in_array("Nonapproved Users", $getmenus)  || in_array("Inactive Users", $getmenus) || in_array("Inactive Users", $getmenus) || in_array("Approved Moderators", $getmenus) || in_array("Nonapproved Moderators", $getmenus)) { ?>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-account-circle"></i><span class="hide-menu"><?php echo __d('admin','User Management');?></span></a>
                        <?php } ?>
                            <ul aria-expanded="false" class="collapse">
                        <?php if (in_array("Add User", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>addmember"><?php echo __d('admin','Add User');?></a></li>
                            <?php } ?>
                                 <li>
<?php if ($access == 'god' || in_array("Approved Users", $getmenus) || in_array("Nonapproved Users", $getmenus)  || in_array("Inactive Users", $getmenus) || in_array("Manage User", $getmenus)) { ?>
                                 <a href="#" class="has-arrow"><?php echo __d('admin','Manage User');?></a>
                                 <?php } ?>
                                    <ul aria-expanded="false" class="collapse">
                          <?php if (in_array("Approved Users", $getmenus) || $access == 'god' || in_array("Manage User", $getmenus)) { ?>
                                        <li><a href="<?php echo $baseurl; ?>manageuser"><?php echo __d('admin','Approved Users');?></a></li>
                               <?php } ?>
                             <?php if (in_array("Nonapproved Users", $getmenus) || $access == 'god' || in_array("Manage User", $getmenus)) { ?>
                                        <li><a href="<?php echo $baseurl; ?>nonapproveduser"><?php echo __d('admin','Nonapproved Users');?></a></li>
                                 <?php } ?>
                            
                                    </ul>
                                </li>
                                <li>
<?php if ($access == 'god' || in_array("Approved Moderators", $getmenus) || in_array("Nonapproved Moderators", $getmenus) || in_array("Manage Moderator", $getmenus)) { ?>
                                <a href="#" class="has-arrow"><?php echo __d('admin','Manage Moderator');?></a>
                                 <?php } ?>
                                    <ul aria-expanded="false" class="collapse">
    <?php if (in_array("Approved Moderators", $getmenus) || in_array("Manage Moderator", $getmenus) || $access == 'god') { ?>
                                        <li><a href="<?php echo $baseurl; ?>managemoderator"><?php echo __d('admin','Approved Moderators');?></a></li>
                                    <?php } ?>
   <?php if (in_array("Nonapproved Moderators", $getmenus) || in_array("Manage Moderator", $getmenus)  || $access == 'god') { ?>
                                        <li><a href="<?php echo $baseurl; ?>nonapprovedmoderator"><?php echo __d('admin','Nonapproved Moderators');?></a></li>
                                    <?php } ?>

                                    </ul>
                                </li>

                                     <li>
 <?php if (in_array("Approved Sellers", $getmenus) || in_array("Nonapproved Sellers", $getmenus) || in_array("Manage Sellers", $getmenus) || $access == 'god') { ?>
                                <a href="#" class="has-arrow"><?php echo __d('admin','Manage Sellers');?></a>
           <?php } ?>
                                      <ul aria-expanded="false" class="collapse">
          <?php if (in_array("Manage Sellers", $getmenus) || $access == 'god') { ?>
                                        <li><a href="<?php echo $baseurl; ?>approvedseller"><?php echo __d('admin','Approved Sellers');?></a></li>
             <?php } ?>
               <?php if (in_array("Manage Sellers", $getmenus) || $access == 'god') { ?>
                                        <li><a href="<?php echo $baseurl; ?>nonapprovedseller"><?php echo __d('admin','Nonapproved Sellers');?></a></li>
                   <?php } ?>
                                    </ul>
                                </li>

                            </ul>
                        </li>


                        


                        <li>
 <?php if ($access == 'god' || in_array("New Orders", $getmenus) || in_array("Approved Orders", $getmenus) || in_array("Shipped Orders", $getmenus) || in_array("Delivered Orders", $getmenus) || in_array("Claimed Orders", $getmenus) || in_array("Returned Orders", $getmenus) || in_array("Braintree Setting", $getmenus) || in_array("Commission setup", $getmenus) || in_array("Invoices", $getmenus) || in_array("Tax Rates", $getmenus)) { ?>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-cash"></i><span class="hide-menu"><?php echo __d('admin','Payment');?></span></a>
                  <?php } ?>
                            <ul aria-expanded="false" class="collapse">
                           <?php if (in_array("Braintree Setting", $getmenus) || in_array("Payment Gateway", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>braintree_settings"><?php echo __d('admin','Braintree Setting');?></a></li>
                             <?php } ?>
                                <li>
<?php if ($access == 'god' || in_array("New Orders", $getmenus) || in_array("Approved Orders", $getmenus) || in_array("Shipped Orders", $getmenus) || in_array("Delivered Orders", $getmenus) || in_array("Claimed Orders", $getmenus) || in_array("Returned Orders", $getmenus) || in_array("Orders", $getmenus)) { ?>
                                <a href="#" class="has-arrow"><?php echo __d('admin','Orders');?></a>
                               <?php } ?>
                                     <ul aria-expanded="false" class="collapse">
     <?php if (in_array("New Orders", $getmenus) || in_array("Orders", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>neworders"><?php echo __d('admin','New Orders');?></a></li>
                            <?php } ?>
    <?php if (in_array("Approved Orders", $getmenus) || in_array("Orders", $getmenus) || $access == 'god') { ?>
                               <li><a href="<?php echo $baseurl; ?>approvedorders"><?php echo __d('admin','Approved Orders');?></a></li>
                              <?php } ?>
     <?php if (in_array("Shipped Orders", $getmenus) || in_array("Orders", $getmenus) || $access == 'god') { ?>
                               <li><a href="<?php echo $baseurl; ?>shippedorders"><?php echo __d('admin','Shipped Orders');?></a></li>
                              <?php } ?>
    <?php if (in_array("Delivered Orders", $getmenus) || in_array("Orders", $getmenus) || $access == 'god') { ?>
                               <li><a href="<?php echo $baseurl; ?>deliveredorders"><?php echo __d('admin','Delivered Orders');?></a></li>
                               <?php } ?>
    <?php if (in_array("Claimed Orders", $getmenus) || in_array("Orders", $getmenus) || $access == 'god') { ?>
                               <li><a href="<?php echo $baseurl; ?>claimedorders"><?php echo __d('admin','Claimed Orders');?></a></li>
                                <?php } ?>
    <?php /*if (in_array("Returned Orders", $getmenus) || in_array("Orders", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>returnedorders"><?php echo __d('admin','Returned Orders');?></a></li>
                                <?php }*/ ?>
    <?php if (in_array("Refunded Orders", $getmenus) || in_array("Orders", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>refundedorders"><?php echo __d('admin','Refunded Orders');?></a></li>
                                <?php } ?>
   <?php if (in_array("Cancelled Orders", $getmenus) || in_array("Orders", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>cancelledorders"><?php echo __d('admin','Cancelled Orders');?></a></li>
                                <?php } ?>
                            </ul>

                                </li>
                           <?php if (in_array("Commission setup", $getmenus) || in_array("Orders", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>admin/viewcommission"><?php echo __d('admin','Commission setup');?></a></li>
                           <?php } ?>
                         <?php if (in_array("Invoices", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>admin/invoice"><?php echo __d('admin','Invoices');?></a></li>
                             <?php } ?>
                               <?php if (in_array("Tax Rates", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>admin/taxrates"><?php echo __d('admin','Tax Rates');?></a></li>
                               <?php } ?>
                            </ul>
                        </li>
                      <!--  <li>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-key-variant"></i><span class="hide-menu">Coupons</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php //echo $baseurl; ?>admin/addcoupon">Add Coupon</a></li>
                                <li><a href="<?php //echo $baseurl; ?>admin/managecoupon">Manage Coupon</a></li>
                                <li><a href="<?php //echo $baseurl; ?>admin/couponlog">Coupon Logs</a></li>


                            </ul>
                        </li>-->
                         <li>
    <?php if (in_array("Add Gift card", $getmenus) || in_array("Logs", $getmenus) || $access == 'god') { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-gift"></i><span class="hide-menu"><?php echo __d('admin','Gift Card');?></span></a>
                             <?php } ?>
                            <ul aria-expanded="false" class="collapse">
                             <?php if (in_array("Add Gift card", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>giftcard"><?php echo __d('admin','Add Gift card');?></a></li>
                             <?php } ?>
                              <?php if (in_array("Logs", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>giftcardlog"><?php echo __d('admin','Logs');?></a></li>
                                <?php } ?>

                            </ul>
                        </li>
             <?php if (in_array("Manage Group gifts", $getmenus) || $access == 'god') { ?>
                         <li>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple-plus"></i><span class="hide-menu"><?php echo __d('admin','Group Gift');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                <li><a href="<?php echo $baseurl; ?>groupgift"><?php echo __d('admin','Manage Group gifts');?></a></li>

                            </ul>
                        </li>
                     <?php } ?>
                         <li>
 <?php if (in_array("Manage Categories", $getmenus) || in_array("Manage Nonapproved Items", $getmenus) || in_array("Manage Approved Items", $getmenus) || in_array("Manage Shared Items", $getmenus) || in_array("Manage Reported Items", $getmenus) || in_array("Manage Colors", $getmenus) || in_array("Manage Prices", $getmenus) || in_array("Manage Currency", $getmenus) || in_array("Approved Sellers", $getmenus) || in_array("Nonapproved Sellers", $getmenus)  || $access == 'god') { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-cart"></i><span class="hide-menu"><?php echo __d('admin','Store Preferences');?></span></a>
               <?php } ?>
                            <ul aria-expanded="false" class="collapse">
            <?php if (in_array("Manage Categories", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>viewcategory"><?php echo __d('admin','Manage Categories');?></a></li>
              <?php } ?>
             <?php if (in_array("Manage Nonapproved Items", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>nonapproveditems"><?php echo __d('admin','Manage Nonapproved Items');?></a></li>
             <?php } ?>
             <?php if (in_array("Manage Approved Items", $getmenus) || $access == 'god') { ?>
                                 <li><a href="<?php echo $baseurl; ?>approveditems"><?php echo __d('admin','Manage Approved Items');?></a></li>
              <?php } ?>

             <?php if (in_array("Manage Reported Items", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>reportitems"><?php echo __d('admin','Manage Reported Items');?></a></li>
                 <?php } ?>
             <?php if (in_array("Manage Prices", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>manageprice"><?php echo __d('admin','Manage Prices');?></a></li>
                <?php } ?>
             <?php if (in_array("Manage Colors", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>managecolors"><?php echo __d('admin','Manage Colors');?></a></li>
                 <?php } ?>
             <?php if (in_array("Manage Currency", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>managecurrency"><?php echo __d('admin','Manage Currency');?></a></li>
                    <?php } ?>
                                    </ul>
                        </li>
  
                         <li>
 <?php if (in_array("User Options", $getmenus) || in_array("Manage Dispute", $getmenus) || $access == 'god') { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-account-switch"></i><span class="hide-menu"><?php echo __d('admin','Disputes');?></span></a>
          <?php } ?>
                            <ul aria-expanded="false" class="collapse">
         <?php if (in_array("User Options", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>manageproblem"><?php echo __d('admin','User Options');?></a></li>
           <?php } ?>
                                  <li>
 <?php if (in_array("Manage Dispute", $getmenus) || $access == 'god') { ?>
                                  <a href="#" class="has-arrow"><?php echo __d('admin','Manage Dispute');?></a>
                         <?php } ?>
                                         <ul aria-expanded="false" class="collapse">
   <?php if (in_array("Manage Dispute", $getmenus) || $access == 'god') { ?>
                                        <li><a href="<?php echo $baseurl; ?>inactivedisp"><?php echo __d('admin','Inactive Dispute');?></a></li>
      <?php } ?>
    <?php if (in_array("Manage Dispute", $getmenus) || $access == 'god') { ?>
                                        <li><a href="<?php echo $baseurl; ?>processingdisp"><?php echo __d('admin','Processing Dispute');?></a></li>
  <?php } ?>
    <?php if (in_array("Manage Dispute", $getmenus) || $access == 'god') { ?>
                                        <li><a href="<?php echo $baseurl; ?>activedisp"><?php echo __d('admin','Active Dispute');?></a></li>
<?php } ?>
    <?php if (in_array("Manage Dispute", $getmenus) || $access == 'god') { ?>                                    <li><a href="<?php echo $baseurl; ?>closeddisp"><?php echo __d('admin','Closed Dispute');?></a></li>
    <?php } ?>
    <?php if (in_array("Manage Dispute", $getmenus) || $access == 'god') { ?>
                                          <li><a href="<?php echo $baseurl; ?>canceldisp"><?php echo __d('admin','Cancel Dispute');?></a></li>
   <?php } ?>
    <?php if (in_array("Manage Dispute", $getmenus) || $access == 'god') { ?>
                                           <li><a href="<?php echo $baseurl; ?>resolveddisp"><?php echo __d('admin','Resolved Dispute');?></a></li>
     <?php } ?>
                                       </ul>

                                </li>


                            </ul>
                        </li>
                         <li>
     <?php if (in_array("Manage Seller Chat", $getmenus) || in_array("Manage Subject", $getmenus) || $access == 'god') { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-facebook-messenger"></i><span class="hide-menu"><?php echo __d('admin','Messages');?></span></a>
       <?php } ?>
                            <ul aria-expanded="false" class="collapse">
   <?php if (in_array("Manage Seller Chat", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>contacteditem"><?php echo __d('admin','Manage Seller Chat');?></a></li>
   <?php } ?>
   <?php if (in_array("Manage Subject", $getmenus) || $access == 'god') { ?>                            <li><a href="<?php echo $baseurl; ?>contactsellersubject"><?php echo __d('admin','Manage Subject');?></a></li>
   <?php } ?>

                            </ul>
                        </li>
                         <li>
 <?php if (in_array("Site Management", $getmenus) || in_array("Media Management", $getmenus) || in_array("Email Management", $getmenus) || in_array("Manage Languages", $getmenus) || in_array("Mobile Apps Settings", $getmenus) || in_array("Social Settings", $getmenus) || in_array("Social Page Settings", $getmenus) || in_array("Manage Landing Page", $getmenus) || $access == 'god') { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-globe"></i><span class="hide-menu"><?php echo __d('admin','Site Management');?></span></a>
  <?php } ?>
                            <ul aria-expanded="false" class="collapse">
   <?php if (in_array("Site Management", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>sitesetting"><?php echo __d('admin','Site Management');?></a></li>
   <?php } ?>
   <?php if (in_array("Media Management", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>mediasetting"><?php echo __d('admin','Media Management');?></a></li>
  <?php } ?>
   <?php if (in_array("Email Management", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>mailsetting"><?php echo __d('admin','Email Management');?></a></li>
   <?php } ?>
   <?php if (in_array("Manage Languages", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>managelanguage"><?php echo __d('admin','Manage Languages');?></a></li>
<?php } ?>
<?php if (in_array("Manage Landing Page", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>landingpage"><?php echo __d('admin','Manage Landing Page');?></a></li>
<?php } ?>
   <?php if (in_array("Mobile Apps Settings", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>mobilesetting"><?php echo __d('admin','Mobile Apps Settings');?></a></li>
<?php } ?>
   <?php if (in_array("Social Settings", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>socialsetting"><?php echo __d('admin','Social Settings');?></a></li>
<?php } ?>
   <?php if (in_array("Social Page Settings", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>socialpagesetting"><?php echo __d('admin','Social Page Settings');?></a></li>
 <?php } ?>

                            </ul>
                        </li>
                         <li>

  <?php if (in_array("Add Contacts", $getmenus) || in_array("Add Contacts", $getmenus) || in_array("Send Newsletter", $getmenus) || in_array("Get Contact list", $getmenus) || in_array("Manage Newsletter", $getmenus) || $access == 'god') { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-email"></i><span class="hide-menu"><?php echo __d('admin','Newsletter');?></span></a>
   <?php } ?>
                            <ul aria-expanded="false" class="collapse">

  <?php if (in_array("Send Newsletter", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>newsletter"><?php echo __d('admin','Send Newsletter');?></a></li>
<?php } ?>
  <?php if (in_array("Get Contacts List", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>getcontacts"><?php echo __d('admin','Get Contacts List');?></a></li>
<?php } ?>
  <?php if (in_array("Manage Newsletter", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>managenewsletter"><?php echo __d('admin','Manage Newsletter');?></a></li>
  <?php } ?>

                            </ul>
                        </li>
                         <li>
 <?php if (in_array("Manage Modules", $getmenus) || in_array("Google Analytics", $getmenus) || $access == 'god') { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-cellphone"></i><span class="hide-menu"><?php echo __d('admin','General settings');?></span></a>
     <?php } ?>
                            <ul aria-expanded="false" class="collapse">
   <?php if (in_array("Manage Modules", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>managemodules"><?php echo __d('admin','Manage Modules');?></a></li>
     <?php } ?>
    <?php if (in_array("Google Analytics", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>googlecode"><?php echo __d('admin','Google Analytics');?></a></li>
        <?php } ?>
                            </ul>
                        </li>
     <?php if (in_array("Manage Banner", $getmenus) || $access == 'god') { ?>                    <li>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-content-duplicate"></i><span class="hide-menu"><?php echo __d('admin','Banner Settings');?></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo $baseurl; ?>addbanner"><?php echo __d('admin','Banners');?></a></li>


                            </ul>
                        </li>
       <?php } ?>
       <?php if (in_array("404 page", $getmenus) || $access == 'god') { ?>
                         <li>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-alert-circle"></i><span class="hide-menu"><?php echo __d('admin','Error pages');?></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo $baseurl; ?>404page"><?php echo __d('admin','404 Page');?></a></li>

                            </ul>
                        </li>
       <?php } ?>
                         <li>
 <?php if (in_array("About", $getmenus) || in_array("Documentation", $getmenus) || in_array("Press", $getmenus) || in_array("Pricing", $getmenus) || in_array("Talk", $getmenus) || $access == 'god') { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-page-layout-footer"></i><span class="hide-menu"><?php echo __d('admin','Footer Pages');?></span></a>
  <?php } ?>
                            <ul aria-expanded="false" class="collapse">
     <?php if (in_array("About", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>about"><?php echo __d('admin','About');?></a></li>
     <?php } ?>
     <?php if (in_array("Documentation", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>documentation"><?php echo __d('admin','Documentation');?></a></li>
      <?php } ?>
     <?php if (in_array("Press", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>press"><?php echo __d('admin','Press');?></a></li>
      <?php } ?>
     <?php if (in_array("Pricing", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>pricing"><?php echo __d('admin','Pricing');?></a></li>
      <?php } ?>
     <?php if (in_array("Talk", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>talk"><?php echo __d('admin','Talk');?></a></li>
     <?php } ?>

                            </ul>
                        </li>
                         <li>
<?php if (in_array("FAQ", $getmenus) || in_array("Contact", $getmenus) || in_array("Terms of Sale", $getmenus) || in_array("Terms of Service", $getmenus) || in_array("Privacy Policy", $getmenus) || in_array("Terms and Conditions", $getmenus) || in_array("Copyright Policy", $getmenus) || $access == 'god') { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-help-circle"></i><span class="hide-menu"><?php echo __d('admin','Help pages');?></span></a>
 <?php } ?>
                            <ul aria-expanded="false" class="collapse">
<?php if (in_array("Faq", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>managefaq"><?php echo __d('admin','FAQ');?></a></li>
 <?php } ?>
 <?php if (in_array("Contact", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>contactaddress"><?php echo __d('admin','Contact');?></a></li>
 <?php } ?>
 <?php if (in_array("Terms of Sale", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>termsofsale"><?php echo __d('admin','Terms of Sale');?></a></li>
 <?php } ?>
 <?php if (in_array("Terms of Service", $getmenus) || $access == 'god') { ?>
                                <li><a href="<?php echo $baseurl; ?>termsofservice"><?php echo __d('admin','Terms of Service');?></a></li>
 <?php } ?>
 <?php if (in_array("Privacy Policy", $getmenus) || $access == 'god') { ?>
                                  <li><a href="<?php echo $baseurl; ?>privacypolicy"><?php echo __d('admin','Privacy Policy');?></a></li>
 <?php } ?>
 <?php if (in_array("Terms and Conditions", $getmenus) || $access == 'god') { ?>
                                      <li><a href="<?php echo $baseurl; ?>termsandcondition"><?php echo __d('admin','Terms and Conditions');?></a></li>
 <?php } ?>
 <?php if (in_array("Copyright Policy", $getmenus) || $access == 'god') { ?>
                                        <li><a href="<?php echo $baseurl; ?>copyrightpolicy"><?php echo __d('admin','Copyright Policy');?></a></li>
 <?php } ?>
                            </ul>
                        </li>
                        <li class="nav-devider"></li>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
         
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="margin-bottom:35%">
            <?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer" style="width: auto; text-align: center;">
            <?php if($setngs->footer_active=="yes"){?>
            <div  class="footerstyleleft">
               <?php echo $setngs->footer_left; ?>
               </div>
                 <div class="footerstyleright">
               <?php echo $setngs->footer_right; ?>
               </div>
               <?php }?>
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
</body>
</html>
