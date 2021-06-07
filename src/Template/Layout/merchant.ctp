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
    <!--Steps Css-->
    <?= $this->Html->css('assets/plugins/wizard/steps.css') ?>
    <?= $this->Html->css('assets/plugins/sweetalert/sweetalert.css') ?>
    <!-- Custom CSS -->
    <!-- toast CSS -->
    <?= $this->Html->css('assets/plugins/toast-master/css/jquery.toast.css') ?>
    <?= $this->Html->css('style.css') ?>

    <!-- You can change the theme colors from here -->
    <?= $this->Html->css('blue.css') ?>
     <!-- ?= $this->Html->css('cake.css') ? -->
     <?= $this->Html->css('seller.css') ?>
       <?php
      if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
      {
        ?>
        <?= $this->Html->css('rtl.css') ?>
        <?php } ?>
        <?= $this->Html->css('frontcss/slider.css') ?>
      <!-- merchant landing css -->
     <?=  $this->Html->css('merchantcore.css')?>
      <?=  $this->Html->css('common.css')?>
      
      <!-- merchant landing css -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <!-- PRODUCT IMAGE SLIDER-->
        <?= $this->Html->script('jquery.min.js') ?>
        <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('assets/plugins/jquery/jquery.min.js') ?>
    <?= $this->Html->script('jquery.translate.js') ?>
    <?= $this->Html->script('sellertranslate.js') ?>
</head>
<body>
<?php if(isset($title_for_default) || isset($title_for_password)) { ?>
     <style type="text/css">
        .topbar > .navbar {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.08);
        }
        .mainfooter {
            background: rgb(25, 153, 235) none repeat scroll 0 0;   border-top: 1px solid #d5d6d7;  color: #fff;    font-weight: 500;   margin-top: 30px;
            padding: 15px;  text-align: center; position: absolute; left:0px; right:0px;
        }
        @media (min-width: 320px) and (max-width: 480px) {
            .mainfooter > div {
                font-size: 12px !important;
                text-align: center !important;
            }
             .mainfooter > div + div {
                margin-top: 5px !important;
            }
        }
        @media (min-width: 320px) and (max-width: 1000px) {
            .mainfooter {
            bottom: 0px;
            }
        }
        @media screen and (min-width: 1001px) {
          .mainfooter {
            bottom: 0px;
            }       
        }
        @media screen and (min-width: 481px) {
          a > img#fullimgtag {
             width: auto;
          }
          .mainfooter {
            bottom: -100px;
            }
        }
    </style>
    <header class="topbar">
        <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo MERCHANT_URL; ?>">
                    <!-- Logo icon -->
                    <b>
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!--img src="<?php echo SITE_URL; ?>images/logo-icon.png" alt="" class="dark-logo" /-->
                        <!-- Light Logo icon -->
                        <!--img src="<?php echo SITE_URL; ?>images/logo-light-icon.png" alt="" class="light-logo" /-->
                          <img src="<?php echo SITE_URL;?>images/logo/<?php  echo $setngs->site_logo; ?>" alt="Fantacy" class="dark-logo"  />
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span>
                     <!-- dark Logo text -->
                   <!--   <img src="<?php echo SITE_URL; ?>images/logo-text.png" alt="Fantacy" class="dark-logo" style="color: #009efb;" /> -->
                     <!-- Light Logo text -->
                    <!--  <img src="<?php echo SITE_URL; ?>images/logo-light-text.png" class="light-logo" style="color: #009efb;" alt="Fantacy" /> -->

                 </span> </a>
            </div>
        </nav>
    </header>
<?php } ?>
<?= $this->Flash->render() ?>
<?php echo $this->fetch('content');?>

<?php if(isset($title_for_default)) { ?>
    <footer class="mainfooter row">
        <div class="col-md-6 col-sm-6 text-left"><?php echo $setngs['footer_left']; ?></div>
        <div class="col-md-6 col-sm-6 text-right"><?php echo $setngs['footer_right']; ?></div>
    </footer>
<?php } ?>

  
   <script src="<?php echo SITE_URL.'js/frontjs/slider.js';?>"></script>
  <?php
       if(isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
       {
        ?>
        <script src="<?php echo SITE_URL.'js/frontjs/slider_rtl.js';?>"></script>
        <?php } else { ?>
        <script src="<?php echo SITE_URL.'js/frontjs/slider_ltr.js';?>"></script>
        <?php } ?>
    <!-- Bootstrap tether Core JavaScript -->
    <?= $this->Html->script('assets/plugins/bootstrap/js/tether.min.js') ?>
    <?= $this->Html->script('assets/plugins/bootstrap/js/bootstrap.min.js') ?>
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
    <?= $this->Html->script('assets/plugins/moment/min/moment.min.js') ?>
    <?= $this->Html->script('assets/plugins/wizard/jquery.steps.min.js') ?>
    <?= $this->Html->script('assets/plugins/wizard/jquery.validate.min.js') ?>
    <?= $this->Html->script('assets/plugins/sweetalert/sweetalert.min.js') ?>
    <!-- ?= $this->Html->script('assets/plugins/styleswitcher/steps.js') ? -->
    <?= $this->Html->script('assets/plugins/styleswitcher/jQuery.style.switcher.js') ?>

    
      <!--Seller.js-->
    <?= $this->Html->script('seller.js') ?>
    <style type="text/css">
        .slick-dots{
            display: none;
        }
    </style>
</body>
</html>