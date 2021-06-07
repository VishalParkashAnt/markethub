
  <!--<![endif]-->

     <style>


#sortable1, #sortable2, #sortable3 {

    min-height: 274px;
    padding: 0;
}
 .error {
         color:red;
         }
    .todo ul li {
    background: #fff;
    margin-left: 0 !important;
    padding: 10px 10px 10px 35px;
    border-bottom: 1px solid #e4e6eb;
    font-size: 12px;
    position: relative;
   }
.todo ul {
  list-style: none;
}
</style>


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
  function deletelandingpage($curskey) {
    $baseurl = getBaseURL();
//alert($baseurl);
    if(confirm("Are you sure want to delete this Item"))
	{

		window.location.replace($baseurl+"deleteslider/"+$curskey);
	}
}
  </script>

 <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Landing Page'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Manage Landing Page'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Manage Landing Page'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">



						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">



	<?php

	echo "<div class='containerdiv'>";
    echo $this->Form->Create('Managelandingpage',array('url'=>array('controller'=>'/admins','action'=>'/landingpage'),'id'=>'mailform','onsubmit'=>'return validatelandingpage();'));

//print_r($homepagesettings);
//echo $homepagesettings->layout;

      if(empty($homepagesettings->layout)){
          $layoutstatus = 'default';
        }else{
          $layoutstatus = $homepagesettings->layout;
        }
         $displaydiv = "display:block;";
            if ($layoutstatus == 'default'){
              $displaydiv = "display:none;";
            }
            $options2['default'] = "Default";
            $options2['custom'] = "Custom";

       echo '<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">';
        echo $this->Form->input('Layout', array('options' => $options2,'default'=>$layoutstatus,
            'id'=>'layout','label'=>''.__d('admin','Layout').'','class'=>'form-control', 'onchange'=>
            '$(".customslider").slideToggle();$(".widgetsselector").slideToggle();'));
        echo '</div></div></div>';

			$availwidgets = array(__d('admin', 'Recently Added'),__d('admin', 'Most Popular'), __d('admin', 'Most Commented'), __d('admin', 'Top Stores'),
             __d('admin', 'Featured Items'));
        if (!empty($homepagesettings->widgets)){
          $widgets = $homepagesettings->widgets;
          $widgetarray = explode('(,)', $widgets);
        }else{
          $widgets = '';
          $widgetarray = array();
        }
       if (!empty($homepagesettings->properties)){
          $sliderProperty = json_decode($homepagesettings->properties,true);
        }
       echo $this->Form->input('widgets',array('type'=>'hidden','value'=>$widgets,'id'=>'widgets'));
     ?>
        <div class="customslider" style="<?php echo $displaydiv;?>">
        <?php



		   if (!empty($homepagesettings->slider)) {
						$sliders = json_decode($homepagesettings->slider, true);
						$slidercount = count($sliders);
						echo '<P class="widgettophead">'.__d('admin', 'Manage Custom Slider').'</P>';
						echo $this->Form->input('sliders',array('type'=>'hidden','value'=>$slidercount,'id'=>'sliders'));
						echo "<table class='table-responsive tablesorter table table-striped table-bordered table-condensed'>";
						echo "<thead>
								<tr>
									<th>#</th>
									<th>".__d("admin", "Slider Image")."</th>
									<th>".__d("admin", "Slider Link")."</th>
									<th>".__d("admin", "Actions")."</th>
								<tr>
								</thead><tbody>";
						foreach ($sliders as $skey => $slider){
							$curskey  = $skey+1;
							echo "<tr>";
							echo "<td>$curskey</td>";
							echo "<td><img src=".SITE_URL."images/slider/".$slider['image']." width='110'/></td>";
							echo "<td>".wordwrap($slider['link'],35,"<br>\n",TRUE)."</td>";
							echo "<td><a href='".SITE_URL."editslider/".$curskey."' data-toggle='tooltip' title='Edit'><span class='btn btn-info'><i class='fa fa-edit'></i></span></a>
							<a onclick = 'deletelandingpage(".$curskey.")' data-toggle='tooltip' title='Delete'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a></td>";

							echo "</tr>";
						}
						echo "</tbody></table>";
					}else{
						echo "<div class='slideerror'>".__d("admin", "No Sliders Found")."</div>";
					}

        ?>
        	<a class="btn btn-info" href="<?php echo SITE_URL;?>addslider" title="add slider">
						<?php echo __d('admin', 'Add Slider'); ?>
		    </a>
        </div>
        <div class='slidererror error trn'></div>

        	<div class="widgetsselector" style="<?php echo $displaydiv;?>">
				<P class="widgettophead" style="margin-top:20px;"><?php echo __d('admin', 'Choose Widgets (Drag and Drop)'); ?></P>
				<div style="with:98% !important;height:auto;overflow:hidden;">
					<div class="availwidget" style="width:auto;float:left; margin-bottom:15px;">

						<h4><?php echo __d('admin', 'Available Widgets'); ?></h4>
					<div class="box-content" style="width:200px;border:1px solid;margin:0px;min-height:230px;">
						<div class="todo">
						<ul id="sortable1" class="droptrue">
						<?php
						if (!empty($widgetarray)){
						foreach($availwidgets as $avail){
							if (!in_array($avail, $widgetarray)){
						?>
						  <li class="date" style="list-style:none;cursor:pointer;font-size:14px;background:#F9F9F9;"><?php echo $avail; ?></li>
						 <?php } } }else{
						 	foreach($availwidgets as $avail){
						 		?>
 								<li class="ui-state-default" style="list-style:none;cursor:pointer;"><?php echo $avail; ?></li>
 						<?php } } ?>
						</ul>
						</div>
					</div>

					</div>

               <div class="availwidget" style="width:auto;float:left;">
				<h4><?php echo __d('admin', 'Selected Widgets'); ?></h4>
				<div class="box-content" style="width:200px;border:1px solid;margin:0px;min-height:230px;">
						<div class="todo">
									<ul id="sortable3" class="droptrue">
						<?php if (!empty($widgetarray)){
						 foreach($widgetarray as $avail){
						 ?>
						<li class="date" style="list-style:none;cursor:pointer;font-size:14px;background:#F9F9F9;"><?php echo $avail; ?></li>
						<?php
						  } } ?>
						</ul>
						</div>
					</div>

				</div>
				</div>
				<div class='widgeterror error trn'></div></br>

		</div>


   <?php

			echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
		echo $this->Form->end();
		echo "</div>";
	echo "</div>";
?>
					</div>
				</div><!--/span-->

			</div><!--/row-->




<style>

.show_hid{
	display:none;
}
</style>

   </div></div></div>



        </div>
    </div>
</div>



<script src="<?php echo SITE_URL; ?>js/colpick.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/colpick.css" type="text/css"/>
<script type="text/javascript">
$('#sliderbg').colpick({
	layout:'hex',
	submit:0,
	colorScheme:'light',
	onChange:function(hsb,hex,rgb,el,bySetColor) {
		//$(el).css('border-color','#'+hex);
		$('#sliderbg').val("#"+hex);
		// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
		if(!bySetColor) $(el).val("#"+hex);
	}
}).keyup(function(){
	$(this).colpickSetColor(this.value);
});
</script>


 <?= $this->Html->script('jquery.tablesorter') ?>