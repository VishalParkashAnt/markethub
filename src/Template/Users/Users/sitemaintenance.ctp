<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $setngs['site_name']. ' - '.$title_for_layout;?></title>

    <!-- Bootstrap -->
    <link href="<?php echo SITE_URL;?>css/frontcss/bootstrap.min.css" rel="stylesheet">
    <!-- RTL Bootstrap
    <link href="css/boostrap-rtl.css" rel="stylesheet">-->

    <!-- Custom style -->
    <link href="<?php echo SITE_URL;?>css/frontcss/common.css" rel="stylesheet">
    <link href="<?php echo SITE_URL;?>css/frontcss/core.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITE_URL;?>css/jquery-ui.css">
    <!--<link href="css/rtl.css" rel="stylesheet">-->
    <!--Font awesome style-->
    <link href="<?php echo SITE_URL;?>css/frontcss/font-awesome.css" rel="stylesheet">
    <!--E O Font awesome style-->
<style type="text/css">
    /*************************maintenance page style***********************/
.maintain-page {
    background-color: #fff;
}
.maintain-bold {
    font-size: 36px;
    font-weight: bold;
    color: #666;
}
.maintain-normal {
    font-size: 24px;
    color: #555;
}
.maintain-img img {
   display: inline-block;
}


/*******************************************************************/
</style>
  </head>
  <body>

    <section class="maintain-page">
        <div class="container">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="maintenance-page">
                    <div class="maintain-fount text-center margin-top50 margin-bottom20">
                        <div class="maintain-img margin-top10">
                            <img class="img-responsive" src="images/maintenance.png">
                        </div>
                        <div class="maintain-bold text-center margin-top10">
                            <?php echo __d('user','Site is under Maintenance');?></div>
                        <p class="maintain-normal margin-top10 margin-bottom50"><?php if ($adminmessage == ""){$adminmessage = __d('user',"Please come back in few minutes");} ?>
                            <?php echo $adminmessage; ?>
                        </p>
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                        <a href="<?php echo SITE_URL; ?>"><?php echo __d('user','Check Now');?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

  </body>
</html>