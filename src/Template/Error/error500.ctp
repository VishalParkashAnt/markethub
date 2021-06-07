<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;
?>



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
                            <h2 class="bold-font primary-color-txt text-center margin-top20">500</h2>
                            <div class="not-found-bold text-center margin-top10">An Internal Error Has Occurred</div>
                            <div class="view-all-btn btn primary-color-bg">
                                    <a href="<?php echo SITE_URL;?>">Go Home</a>
                            </div>
                        </div>
                    </div>


                </section>
            </div>
        </div>
    </section>



<?php



if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?php if ($error instanceof Error) : ?>
        <strong>Error in: </strong>
        <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>

