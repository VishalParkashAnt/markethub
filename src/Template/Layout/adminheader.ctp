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


    <?= $this->Html->css('assets/plugins/css-chart/css-chart.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('blue.css') ?>
    <?= $this->Html->css('scss/icons/material-design-iconic-font/css/materialdesignicons.min.css') ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
     <?= $this->Html->script('anekart.js') ?>
      <?= $this->Html->script('jQuery.print.js') ?>
    <?= $this->Html->script('assets/plugins/jquery/jquery.min.js') ?>
    <?= $this->Html->script('assets/plugins/bootstrap/js/tether.min.js') ?>
    <?= $this->Html->script('assets/plugins/bootstrap/js/bootstrap.min.js') ?>
    <?= $this->Html->script('jquery.slimscroll.js') ?>
    <?= $this->Html->script('waves.js') ?>
    <?= $this->Html->script('sidebarmenu.js') ?>
    <?= $this->Html->script('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') ?>
    <?= $this->Html->script('custom.min.js') ?>
    <?= $this->Html->script('assets/plugins/chartist-js/dist/chartist.min.js') ?>
    <?= $this->Html->script('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') ?>
    <?= $this->Html->script('assets/plugins/echarts/echarts-all.js') ?>
    <?= $this->Html->script('dashboard1.js') ?>
    <?= $this->Html->script('assets/plugins/styleswitcher/jQuery.style.switcher.js') ?>
 <?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>
<script>
 jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });</script>
</head>
<body class="fix-header fix-sidebar card-no-border">
    <?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
            

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
           
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
      
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
   
    <!-- ============================================================== -->
    <!-- End Wrapper -->
<?= $this->Flash->render() ?>
<?= $this->Html->script('assets/plugins/jquery/jquery.min.js') ?>
    <?= $this->Html->script('assets/plugins/bootstrap/js/tether.min.js') ?>
    <?= $this->Html->script('assets/plugins/bootstrap/js/bootstrap.min.js') ?>
    <?= $this->Html->script('jquery.slimscroll.js') ?>
    <?= $this->Html->script('waves.js') ?>
    <?= $this->Html->script('sidebarmenu.js') ?>
    <?= $this->Html->script('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') ?>
    <?= $this->Html->script('custom.min.js') ?>
    <?= $this->Html->script('assets/plugins/chartist-js/dist/chartist.min.js') ?>
    <?= $this->Html->script('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') ?>
    <?= $this->Html->script('assets/plugins/echarts/echarts-all.js') ?>
    <?= $this->Html->script('dashboard1.js') ?>
    <?= $this->Html->script('assets/plugins/styleswitcher/jQuery.style.switcher.js') ?>
</body>
</html>
