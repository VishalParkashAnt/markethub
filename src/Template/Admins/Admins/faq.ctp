<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'FAQ'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"> <?php echo __d('admin', 'FAQ'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"> <?php echo __d('admin', 'FAQ'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">


						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">



<?php



		echo $this->Form->Create('faq');
		 echo '<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-block">';

                               echo $this->Form->input('main',array('type'=>'textarea','style'=>'width:350px;','id'=>'mymce','label'=>''.__d('admin','Main').'','value'=>$main));


                          echo '</div>
                        </div>
                    </div>
                </div>';


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
    </script>