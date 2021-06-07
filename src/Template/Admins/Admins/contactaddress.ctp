<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Contact Address'); ?>

</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"> <?php echo __d('admin', 'Contact Address'); ?>

</a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"> <?php echo __d('admin', 'Contact Address'); ?>

</h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">


						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">



<?php
//	echo $main;

    echo $this->Form->Create('contactaddress',array('url'=>array('controller'=>'/admins','action'=>'/contactaddress/'),'onsubmit'=>'return contactaddress()','enctype'=>'multipart/form-data'));

    echo '<div class="row"><div class="col-md-6"><div class="form-group">';
        echo $this->Form->input('emailid',array('type'=>'text','label'=>__d('admin', 'Email Address'),'class'=>'form-control','value'=>$cemailid));
        echo '<div></div></div></div></div>';
     echo '<div class="row"><div class="col-md-6"><div class="form-group">';
        echo $this->Form->input('mobno',array('type'=>'text','label'=>__d('admin', 'Mobile Number'),'class'=>'form-control','value'=>$cmobno));
        echo '<div></div></div></div></div>';
    echo '<div class="row"><div class="col-md-6">
 <label class="field_title" for="cntaddress">'.__d('admin', 'Contact Address').'</label>
    <div class="form-group">';
        echo $this->Form->input('cntaddress',array('type'=>'textarea','label'=>'','class'=>'form-control','value'=>$ccntaddress));
        echo '<div></div></div></div></div>';

		echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn' ));
      echo "<div id='alert' class='trn' style='color: red; font-size: 13px;'></div>";
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