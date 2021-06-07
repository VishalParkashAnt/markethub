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
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags-->
  <title> <?php
            if(!empty($title_for_landing))
                echo $title_for_landing." - ";
        ?><?= $cakeDescription ?></title>
   <!-- Bootstrap Core CSS -->
    <?= $this->Html->css('merchant-bootstrap.min.css') ?>
     <?=  $this->Html->css('merchantcore.css')?>
      <?=  $this->Html->css('merchantcommon.css')?>
       <?=  $this->Html->css('font-awesome-merchant.css')?>
	<!-- Custom style -->

  <!--<link href="css/common.css" rel="stylesheet">
	<link href="css/core.css" rel="stylesheet">
	<link href="css/font-awesome-merchant.css" rel="stylesheet">-->


  <style>
    body, html, .wrapper-landing {
      height: 100%;
      margin: 0;
    }
  </style>

  </head>
  <body>
   

<?= $this->Flash->render() ?>
<?php echo $this->fetch('content');?>




   <?= $this->Html->script('merchant/merchant-jquery.min.js') ?>
    <?= $this->Html->script('merchant/merchant-bootstrap.min.js') ?>
  </body>
</html>