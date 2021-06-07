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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?php 
     $this->Html->meta('icon') ?>

    <!--<meta property="og:image" content="https://joysalescript.com/resized.php?src=https://joysalescript.com/media/item/25/9921586416427.png&w=200&h=200" />-->

    <?= $this->Html->css('frontcss/bootstrap.min.css') ?>
    <?= $this->Html->css('frontcss/common.css') ?>
    <?= $this->Html->css('frontcss/core.css') ?>
    <?= $this->Html->css('frontcss/font-awesome.css') ?>

    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('frontjs/custom.js') ?>
    <?= $this->Html->script('front.js') ?>
    <?= $this->Html->script('jquery.waypoints.min.js') ?>
    <?= $this->Html->script('jquery.magnific-popup.min.js') ?>
    <?= $this->Html->script('main.js') ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<?php
$baseurl = Router::url('/');
?>
 
    

    <section class="container">
   <?= $this->fetch('content') ?>
    </section>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <!-- Magnific Popup -->
  <!-- staggered grid js -->
  <script src="<?php echo $baseurl;?>js/salvattore.min.js"></script>
  <!-- Main JS -->
</body>
</html>
