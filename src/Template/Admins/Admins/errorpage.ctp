<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>

<div class="content">
    <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Error Page'); ?> <?php echo $setngs[0]['site_name']; ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Error Page'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Error Page'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">


                        <div class="row-fluid">
                <div class="box span12">

                    <div class="box-content">

 <section class="side-collapse-container margin-top20">
        <div class="container">
            <div class="">

                <section class="">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin_top_150_tab">
                        <div class="page-not-fount text-center margin-top50 margin-bottom50">
                            <div class="404img margin-top30">
                                <img src="<?php echo SITE_URL.'images/404-img.png' ?>">
                            </div>
                            <h2 class="bold-font primary-color-txt text-center margin-top40">404</h2>
                            <div class="not-found-bold text-center margin-top20"><?php echo $main;?> </div>

                            <div class="view-all-btn btn primary-color-bg">
                                    <a href="homepage.html">Go Home</a>
                            </div>
                        </di>
                    </div>


                </section>
            </div>
        </div>
    </section>

<?php



        echo $this->Form->Create('about');



         echo '<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-block">';

                               echo $this->Form->input('main',array('type'=>'textarea','style'=>'width:350px;','id'=>'mymce','label'=>''.__d('admin','Main').'','value'=>$main));


                          echo'  </div>
                        </div>
                    </div>
                </div>';


        //echo $this->Form->input('main',array('type'=>'textarea','style'=>'width:350px;','id'=>'description','class'=>'inputform','value'=>$main));
        //echo $this->Form->input('sub',array('type'=>'textarea','id'=>'description1','style'=>'width:350px;','class'=>'inputform','value'=>$sub));

        /*echo $this->Form->input('profile',array('type'=>'textarea','id'=>'description','style'=>'width:350px;','label'=>__d('admin', 'Profile and Account'),'class'=>'inputform','value'=>$profile));
        echo $this->Form->input('merchant',array('type'=>'textarea','id'=>'description','style'=>'width:350px;','class'=>'inputform','value'=>$merchant));*/

        echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn' ));
        echo $this->Form->end();
    echo "</div>";
?>
</div></div>
</div>

</div>

</div>
</div>

</div>

</div>
</div>

</div>

</div>


<style>

.show_hid{
    display:none;
}
</style>

  <script>
    $(document).ready(function() {

        if ($("#mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
    });
    </script>url = Router::url('/');
?>
  <style type="text/css">
        .error-box
        {
            position: static;
            background: url(<?php echo $baseurl; ?>css/assets/images/background/error-bg.jpg) no-repeat center center #fff !important;
        }
    </style>

<body class="fix-header card-no-border">

</html>