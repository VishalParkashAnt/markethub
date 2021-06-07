  <script>
  $(function() {
    $( "ul.droptrue" ).sortable({
      connectWith: "ul",
      placeholder: "ui-state-highlight",
      stop: function( event, ui ) {
			var selected = getdatafromli();
			console.log(selected);
			$('#widgets').val(selected);
          }
    });
 
    $( "#sortable1, #sortable3" ).disableSelection();
  });
  function getdatafromli(){
	  $.extend( $.fn, {
		    textnodes: function() {
		        return $(this).contents().filter(function(){
		            return this.nodeType === 3;
		        });
		    }
		});

		var nodes = $("#sortable3 li").textnodes();
		var data = '';
		for(var i=0; i<nodes.length;i++ ){
			if(data == ''){
				data += nodes[i]['data'];
			}else{
				data += "(,)"+nodes[i]['data'];
			}
		}
		console.log( nodes );
		return data;
  }
  </script>
   
   <style>
      .error {
         color:red;
         }
   </style>
   
   
   

 <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');

if(session_id() == '') {
session_start();
}
$site = $_SESSION['site_url'];
$media = $_SESSION['media_url'];
$username = @$_SESSION['media_server_username'];
$password = @$_SESSION['media_server_password'];
@$hostname = $_SESSION['media_host_name']; 
@$userid = $_SESSION['Auth']['Admin']['id'];
?>

   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Landing Page'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	landingpage"><?php echo __d('admin', 'Manage Landing Page'); ?></a></li>
                      <li class="breadcrumb-item"><?php echo $pagetitle; ?></li>
                     
                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Edit Slider'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    


	
						<div class="row-fluid">		
				<div class="box span12">

					<div class="box-content">


			
	<?php

	echo "<div class='containerdiv'>";
    echo $this->Form->Create('editslider',array('url'=>array('controller'=>'/admins','action'=>'/editslider/*'),'id'=>'editslider','onsubmit'=>'return validateaddslider();'));

      $display="display:none";
       $imageurl = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image';
				
				if ($sliderImage != ''){
					$display="display:block";
					$imageurl = SITE_URL.'images/slider/'.$sliderImage;
				}

     
       echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
          echo '<label>'.__d('admin', 'Select Slider Image').'</label>';       
          	
				echo "<div class='img_upld' style='float: none; min-height: 120px;'>";
				echo "<img id='show_url_0'  style='width: 100px; border: 1px solid rgb(221, 221, 221); padding: 5px; border-radius: 3px 3px 3px 3px;' src='".$imageurl."'>";
				echo '<div class="venueimg"><iframe class="image_iframe" id="frame_0" name="frame0" src="'.SITE_URL.'/slidereditupload.php?image=0&media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'" frameborder="0" height="40px" width="120px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;position: relative;"></iframe>';
				echo $this->Form->input('item_image', array('type'=>'hidden','id'=>'image_computer_0', 'class'=> 'fullwidth','class'=>'celeb_name','value'=>$sliderImage,'name'=>'sliderImage'));
				echo "<a href='javascript:void(0);' id='removeimg_0' style='".$display."; margin: 5px; float: left;' onclick='removeimg(0)'> <span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>";

				echo "</div>";
				echo "</div>";
				echo "<div class='sliderimageerror error'></div>";

				echo "<div class='sliderimguploaderr' id='sliderimguploaderr' style='color:red;display:none;width:700px;clear:both;'></div>";
      echo '</div></div></div>';

      echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
        echo $this->Form->input('sliderurl',array('type'=>'text','value'=>$sliderLink,'id'=>'sliderLink','class'=>'form-control'));
      echo '</div></div></div>';   
				$options[''] = __d('admin', 'Select Mode');
				$options['web'] = 'Web';
				$options['app'] = 'App';
			
     echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
        echo $this->Form->input('slider display on', array('options' => $options,'default'=>$sliderEffect,'id'=>'slidereffect','class'=>'form-control slidereffect'));
   echo '</div></div></div>';  
   echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';     
		echo $this->Form->input('editid',array('type'=>'hidden','value'=>$editid,'id'=>'editid'));
    echo '</div></div></div>';  
	
				echo "<div class='addurlerror error'></div>";
				echo '<div class="savebtn">';
				echo $this->Form->submit($pagetitle,array('div'=>false,'class'=>'btn btn-info reg_btn'));
				echo "</div>";
				echo $this->Form->end();  
               echo '<br>';


        ?>
        
        </div>
        <div class='slidererror error'></div>

		<div class="customslider">
					<P class="widgettophead"><?php echo __d('admin', 'Custom Sliders Already Active'); ?></P>
					<?php if (!empty($homepageModel->slider)) {
						$sliders = json_decode($homepageModel->slider, true);
						$slidercount = count($sliders);
						echo $this->Form->input('sliders',array('type'=>'hidden','value'=>$slidercount,'id'=>'widgets'));
						echo "<table class='table table-bordered table-striped table-condensed'>";
						echo "<thead>
								<tr>
									<th>#</th>
									<th>".__d("admin", "Slider Image")."</th>
									<th>".__d("admin", "Slider Link")."</th>
								<tr>
								</thead><tbody>";
						foreach ($sliders as $skey => $slider){
							$curskey  = $skey+1;
							echo "<tr>";
							echo "<td>$curskey</td>";
							echo "<td><img src=".$_SESSION['media_url']."images/slider/".$slider['image']." width='110'/></td>";
							echo "<td>".wordwrap($slider['link'],35,"<br>\n",TRUE)."</td>";
							echo "</tr>";
						}
						echo "</tbody></table>";
					}else{
						echo "<div class='slideerror'>".__d("admin", "No Sliders Found")."</div>";
					}?>
				</div>		
					
   <?php

		
		echo "</div>";
	echo "</div>";
?>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
				



<style>
	
   .sliderimageerror{
   color: red;
   }
   
</style>

   </div></div></div>
     

    
        </div>
    </div>
</div>
    



