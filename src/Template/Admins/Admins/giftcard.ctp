
<body class="">
  <!--<![endif]-->

      <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');


?>





<div class="content">
  <div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Gift Cards'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>  dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Gift Cards'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>



	 <?php
   echo $this->Form->Create('Item',array('url'=>array('controller'=>'/admins','action'=>'/giftcard/'),'onsubmit'=>'return giftcard()','enctype'=>'multipart/form-data'));

   ?>
    <div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Gift Card'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">

                  <div class="form-group">
                    <label class="field_title" for="title"><?php echo __d('admin', 'Title'); ?> <span class="req">*</span></label>
                    <div class="form_input">
                     <input name="title" value="<?php echo $giftDetails['title']; ?>" id="gift_title" type="text" tabindex="1" class="form-control style="color:#555555! important;" title="Please enter the title"/>
                      </div>
                       <span id="gift_titletext" class="trn" style="font-size:13px;"></span>
                  </div></div></div>
                     <div class="row">
                        <div class="col-md-6">
                  <div class="form-group">
                    <label class="field_title" for="description"><?php echo __d('admin', 'Description'); ?> <span class="req">*</span></label>

                      <textarea name="description" id="gift_desc" tabindex="2"  class="form-control" title="Please enter the description"><?php echo $giftDetails['description']; ?></textarea>
                   </div></div></div>
                    <span id="gift_desctext" class="trn" style="font-size:13px;"></span>
                  </div>
                  <label class="field_title" for="gift_image"><?php echo __d('admin', 'Image'); ?></label>
                  <div class="row" id="giftimagewrap">
                    <div class="col-md-6">


                                <input type="file" id="input-file-now-custom-1" class="dropify" data-default-file="<?php echo $baseurl;?>media/items/thumb150/<?php echo $giftDetails['image'];?>" name="image" defaultValue="<?php echo $giftDetails['image']?>"/>
                            </div>
                        </div>



                  <?php
               /*   $i=1;
        	echo "<div class='img_upld'>";
        	if(!empty($giftDetails['image'])){
        		$image = $giftDetails['image'];
        		echo "<img id='show_url_".$i."'  style='width: 100px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;' src='".$baseurl.'media/items/thumb150/'.$image."'>";
        	}else{
        		$image='';
        		echo "<img id='show_url_".$i."'  style='width: 100px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;' src='http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image'>";
        	}*/



                  ?>



                  <!--  div class="form_grid_12">
                    <label class="field_title" for="gift_image"><?php echo __d('admin', 'Image'); ?></label>
                    <div class="form_input">
                      <input name="gift_image" id="gift_image" type="file" tabindex="5" class="large tipTop" title="Please select the giftcard image"/>
                    </div>
                    <div class="form_input"><img src="http://pleasureriver.com/images/giftcards/d342fa6bce0de522e7ae8f3ab672a279.png" width="100px"/></div>
                  </div-->
                   <div class="row">
                        <div class="col-md-6">
                        <br>
                            <label class="field_title" for="amounts"><?php echo __d('admin', 'Amounts'); ?><span class="req">*</span></label>
                  <div class="form-group">

                      <textarea name="amounts" id="tags_Amt"  tabindex="2"  class="form-control" title="Please enter the Amount"><?php echo $giftDetails['amounts']; ?></textarea>
                   </div>
                      <span class=" label_intro"><?php echo __d('admin', 'Example : 10,20,30'); ?></span>

                  </div> </div>

                <div class="row">
                  <div class="col-md-6">
				<div class="form-control gitcardbtn">
					<button type="submit" class="btn btn-info" tabindex="15"><span><?php echo __d('admin', 'Submit'); ?></span></button>
				</div>
			</div>
    </div>
      <div id='alert' class='errsmall trn'></div>
                  </div>

			</div>

		<?php
		echo $this->Form->end();
		?>		</div>
				</div><!--/span-->

			</div>


<?= $this->Html->css('assets/plugins/dropify/dist/css/dropify.min.css') ?>
<?= $this->Html->script('assets/plugins/dropify/dist/js/dropify.min.js') ?>

 <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>