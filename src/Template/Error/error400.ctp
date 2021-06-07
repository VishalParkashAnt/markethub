    <?= $this->Html->css('frontcss/common.css') ?>
    <?= $this->Html->css('frontcss/core.css') ?>
    <?php
$this->layout = 'default';
//echo '<pre>';print_r($helpdata['err_code']);echo "sdfSD";
?>
    <section class="side-collapse-container margin-top20">
        <div class="container">
            <div class="">

                <section class="">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin_top_150_tab">
                        <div class="page-not-fount text-center margin-top50 margin-bottom50">
                            <div class="404img margin-top30">
                                <img src="<?php echo SITE_URL;?>images/404-img.png">
                            </div>
                            <h2 class="bold-font primary-color-txt text-center margin-top20">404</h2>
                            <div class="not-found-bold text-center margin-top10"><?php echo $helpdata['err_code'];?></div>
                            <div class="view-all-btn btn primary-color-bg">
                                    <a href="<?php echo SITE_URL;?>">Go Home</a>
                            </div>
                        </div>
                    </div>


                </section>
            </div>
        </div>
    </section>