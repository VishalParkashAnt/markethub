 <body class=""> 
<script type="text/javascript" src="<?php echo SITE_URL; ?>tinymce/tinymce.min.js"></script>
<script>
	$(document).ready(function(){
		//alert($.browser.msie);
		if ($.browser.msie) {
			$('.placeholder').each(function(){
			//$('input[placeholder]').each(function(){
			   
				var input = $(this);       
			   
				$(input).val(input.attr('placeholder'));
					   
				$(input).focus(function(){
					 if (input.val() == input.attr('placeholder')) {
						 input.val('');
					 }
				});
			   
				$(input).blur(function(){
					if (input.val() == '' || input.val() == input.attr('placeholder')) {
						input.val(input.attr('placeholder'));
					}
				});
			});
		}
    });

$("#cate_id").change(function(){
		var cate_id = $("#cate_id :selected").val();
		// alert(cate_id);
		var items="";
		if(cate_id != ''){
			 $.getJSON(BaseURL+"suprsubcategry?cate_id="+cate_id+"&suprsub=yes",function(data){
				// alert(data);
				// return false;
				items+="<option value=''>Select Category</option>";
				$.each(data,function(index,cate) 
				{
				  items+="<option value='"+cate.ID+"'>"+cate.Name+"</option>";
				});
				$("#categ-container-2").removeClass('inactive');
				$("#categ-container-2 label").removeClass('invisible');
				$("#categ-selectbx-2").html(items); 
			});
		}else{
			$("#categ-container-2").addClass('inactive');
			$("#categ-container-2 label").addClass('invisible');
			$("#categ-selectbx-2").html(''); 
		}		
	});
	
	$("#categ-selectbx-2").change(function(){
		var cate_id = $("#categ-selectbx-2 :selected").val();
		// alert(cate_id);
		var items="";
		if(cate_id != ''){
			 $.getJSON(BaseURL+"suprsubcategry?cate_id="+cate_id+"&suprsub=no",function(data){
				// alert(data);
				// return false;
				items+="<option value=''>Select Category</option>";
				$.each(data,function(index,cate) 
				{
				  items+="<option value='"+cate.ID+"'>"+cate.Name+"</option>";
				});
				$("#categ-container-3").removeClass('inactive');
				$("#categ-container-3 label").removeClass('invisible');
				$("#categ-selectbx-3").html(items); 
			});
		}else{
			$("#categ-container-3").addClass('inactive');
			$("#categ-container-3 label").addClass('invisible');
			$("#categ-selectbx-3").html(''); 
		}		
	});

</script>
 
 

    
  
    
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-6 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Edit Item'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Edit Item'); ?></a></li>
                     
                 </ol>
         </div>
    </div>
</div>

  
				<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Edit Item'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    

	
						<div class="row-fluid">		
				<div class="box span12">

					<div class="box-content">
</div>
   			<?php
if(session_id() == '') {
session_start();
}
$site = $_SESSION['site_url'];
$media = $_SESSION['media_url'];
@$username = $_SESSION['media_server_username'];
@$password = $_SESSION['media_server_password'];
@$hostname = $_SESSION['media_host_name'];
@$userid = $loguser[0]['User']['id'];
	//$whomade = array('Idid' => 'I did','memberofmyshop' => 'A member of my shop','cmpnyorperson' => 'Another company or person');
	
	echo "<div class='containerdiv'>";
		echo $this->Form->Create('Item',array('url'=>array('controller'=>'admins','action'=>'editItem/'.$itemId),'id'=>'itemform','onsubmit'=>'return validate()'));
			
			echo "<div id='forms'>";
			
		?>
			<div class="sect">
                <div class="section-inner aboutitm clear">                                
			<label><?php echo __d('admin', 'Category'); ?></label>
					<div class="row">
						<input type="hidden" id="itemid" value="<?php echo $itemId;?>">
							<br>
			<?php
							$catarr = array();
							foreach($cat_datas as $cats){
								$catarr[$cats['id']] = $cats['category_name'];
							}
							echo "<div id='categ-container-1' class='select-group' style='float:left;'>";
							echo $this->Form->input('category_id',array('type'=>'select','options'=>$catarr,'label'=>__d('admin', 'What is it?'),'id'=>'cate_id','class'=>'form-control','empty'=>__d('admin', 'Select a Category'),'default'=>$item['category_id']));			
							echo "</div>";
			
			if (!empty($superSub_datas)){ ?>
			<div id='categ-container-2' class='select-group ' style='float:left;'>
			<?php
								foreach ($superSub_datas as $superSub){
									$superSubarr[$superSub['id']] = $superSub['category_name'];
								}
								echo $this->Form->input('supersubcat',array('type'=>'select','options'=>$superSubarr,'label'=>__d('admin', 'What type? (optional)'),'id'=>'categ-selectbx-2','class'=>'form-control','empty'=>__d('admin', 'Select a Category'),'default'=>$item['super_catid']));			
			echo "</div>";					
			}else {	?>
							<div id='categ-container-2' class='select-group inactive ' style='float:left;margin-left:20px;'>
								<label class="invisible">'.__d('admin', 'What type? (optional)').'</label>
								<select name="data['Item']['supersubcat']" id="categ-selectbx-2" class="form-control">
								</select>
							</div>
			<?php } 
			if (!empty($Sub_datas)){ ?>
			<div id='categ-container-3' class='select-group ' style='float:left;'>
			<?php
								foreach ($Sub_datas as $Sub_data){
									$Subarr[$Sub_data['id']] = $Sub_data['category_name'];
								}
								echo $this->Form->input('subcat',array('type'=>'select','options'=>$Subarr,'label'=>__d('admin', 'Type (optional)'),'id'=>'categ-selectbx-3','class'=>'form-control','empty'=>__d('admin', 'Select a Category'),'default'=>$item['sub_catid']));			
			echo "</div>";					
			}else {	?>
							<div id='categ-container-3' class='select-group inactive ' style='float:left;margin-left:20px;'>
								<label class="invisible"><?php echo __d('admin', 'Type (optional)'); ?></label>
								<select name="data['Item']['subcat']" id="categ-selectbx-3">
								</select>
							</div>
			<?php } ?>			
						</div>
					</div>
			<?php
				echo '<br clear="all" /><div class="cat-error adminitemerror" style="color:red"></div>';
							
							
					echo '<br clear="all">';
					echo '<label>'.__d('admin', 'Upload Photos').'</label>';
					$image_computer = '';
					echo "<div class='input_wrap_popup'>";
						echo "<span class='bills additem-label'>";
						 //echo __('Upload Photos:'); 
						 echo "</span>";
						 echo "<div class='imageuploader'>";
							 echo '<div class="imageuploaderframe">';
								 echo '<div id="uploadedimages">';
								 	foreach ($item['Photo'] as $photoKey => $photo){
								 		$imageName = $photo['image_name'];
								 		$imageUrl = $_SESSION['media_url'].'media/items/thumb350/'.$imageName;
								 		echo '<div class="item_images_" id="image_'.$photoKey.'" style="float:left;margin: 0 5px 5px;height:130px;">
								 		<img width="130px" height="130px" src="'.$imageUrl.'" id="show_url_'.$photoKey.'">
								 		<input type="hidden" name="data[image][]" id="image_computer_'.$photoKey.'" class="celeb_name" value="'.$imageName.'">
								 		<a href="javascript:void(0);" onclick="removeDynamicimg('.$photoKey.')" class="" id="removeimg_'.$photoKey.'" style="display: block;bottom:129px;left:114px;position:relative;width:25px;">
										<div style="background-color: #f3f3f3;border-radius: 20px;width:25px;"><i class="glyphicons remove_21"></i></div>										
										</a>
								 		</div>';
								 	}
								 echo '</div>';
								 echo '<input id="imageCount" class="imageCount" type="hidden" value="'.count($item['Photo']).'" name="imageCount">';
								 echo '<input id="delimageCount" class="imageCount" type="hidden" value="'.count($item['Photo']).'" name="imageCount">';
								 $i = 12;
								 echo '<iframe class="image_iframe" id="frame_'.$i.'" name="frame'.$i.'" src="'.$this->webroot.'dynamicUpload.php?image='.$i.'&media_url='.$media.'&site_url='.$site.'&userid='.$userid.'&username='.$username.'&password='.$password.'&hostname='.$hostname.'" frameborder="0" height="130px" width="120px" scrolling="no" HSPACE=0 VSPACE=0 style="float:left;left: 5px;position: relative;"></iframe>';
							 echo '</div>';
						 echo "</div>";
						
					echo "</div>";
					
					
					
				echo "<br clear='all' /><div class='photo-error adminitemerror' style='color:red'></div><br clear='all' />";

				
				echo "<div class='input-group'>";
					echo "<span class='bills additem-label'>".__d("admin", "Item Title")."</span>";
					
					echo "<input type='text' id='title' name ='data[Item][item_title]' class='input-xlarge itemtitle' maxlength='180' value='".$item['item_title']."'>";
				echo '<div class="title-error adminitemerror" style="color:red"></div></div>';
				
				
				echo "<br clear='all' />";
			
				echo "<div class='input-group'>";
					echo "<label>".__d("admin", "Item Description")."</label>";
					echo $this->Form->input('item_description',array('type'=>'textarea','label'=>false,'id'=>'description','class'=>'input-xlarge','value'=>$item['item_description']));
		
					
				echo '<div class="description-error adminitemerror" style="color:red"></div></div>';
				echo "<br clear='all' />";
				echo "<div class='input-group'>";
				echo "<span class='bills additem-label'>".__d("admin", "Video Url")."</span>";
					
				echo "<input type='text' id='video' name ='data[Item][item_video]' class='input-xlarge itemvideo' maxlength='180' value='".$item['videourrl']."' placeholder='YouTube Url or YouTube video id' style='color:#555555! important;'>";
				echo '<div class="video-error adminitemerror" style="color:red"></div></div>';
				
				echo "<br clear='all' />";?>
				<dl>
				<p><b><?php echo __d('admin', 'SKU (Stock Keeping Unit)'); ?></b></p>
				<dd>
				<?php
				echo '<input type="text" style="width:64.1%;height:30px;" id="skuid" name="data[Item][skuid]" class="inputform text" value="'.$item['skuid'].'">';
				?>
									</dd>
								</dl>		
								<div id="skuiderr" style="font-size:13px;color: red;font-weight:bold;margin-left: 10px;"></div>
								<?php 		
				echo "<span class='bills additem-label'>".__d("admin", "Item Color")."</span>";
				echo '<select id="detectmethod" onchange="detect_method()" name="data[colormethod]">';
				if($item['item_color_method']=='0')
				{
					echo '<option value="auto" selected>'.__d('admin', 'Auto Detection').'</option>
					<option value="manual">'.__d('admin', 'Choose Manually').'</option>';
				}
				else if($item['item_color_method']=='1')
				{
					echo '<option value="auto">'.__d('admin', 'Auto Detection').'</option>
					<option value="manual" selected>'.__d('admin', 'Choose Manually').'</option>';
				}
				echo '</select>';
				echo "<br clear='all' />";
				if($item['item_color_method']=='1')
				{
					echo '<div id="manual_select">';
					echo "<span class='bills additem-label'>".__d("admin", "Select Color")."</span>";
					echo '<select id="item_color_manual" name="itemcolor[]" multiple="multiple" style="height: 90px;margin-bottom: 10px;" >';
					foreach($color_datas as $colors){
						$item_colors = $item['item_color'];
						$itemcolors = json_decode($item_colors,true);
						if(in_array($colors['color_name'],$itemcolors))
							echo "<option value='".$colors['color_name']."' selected>".$colors['color_name']."</option>";
						else
							echo "<option value='".$colors['color_name']."'>".$colors['color_name']."</option>";
					}
					echo '</select>';
					echo '</div>';
					echo '<div class="color-error adminitemerror" style="color:red"></div>';
					echo "<br clear='all' />";
				}
				echo '<div id="manual_select" style="display:none;">';
				echo "<span class='bills additem-label'>".__d("admin", "Select Color")."</span>";
				echo '<select id="item_color_manual" name="itemcolor[]" multiple="multiple" style="height: 90px;margin-bottom: 10px;" >';
				$i = 0;
				foreach($color_datas as $colors){
					$item_colors = $item['item_color'];
					$itemcolors = json_decode($item_colors,true);
					if($itemcolors[$i]==$colors['color_name'])
						echo "<option value='".$colors['color_name']."' selected>".$colors['color_name']."</option>";
					else
						echo "<option value='".$colors['color_name']."'>".$colors['color_name']."</option>";
					$i++;
				}
				echo '</select>';
				echo '</div>';
				echo '<div class="color-error adminitemerror" style="color:red"></div>';
				echo "<br clear='all' />";				
				
			?>

			<div class=""  style = "float: none;border-bottom: 0 none;">
                <div class="section-inner clear">
					<div class="input-group clear input-group-error" id="item-price">
						<label>
							<?php echo __d('admin', 'Price'); ?>
						</label>
						<span class="price-input">
							<span><?php echo $item['currencysymbol'];?></span>
							<input type="text" value="<?php echo $item['Item']['price'] ?>" class="input-xlarge money text text-small" id="price" name="listing[price]"  maxlength = "6" onkeydown="chknum(this,event);">
							<span><?php echo $item['currency'];?></span>
						</span><p class="inline-message inline-error"></p>
						

						<input type="hidden" value="on" name="non_taxable">
						<div class="price-error adminitemerror" style="color:red"></div>
					</div>								
					<div class="input-group clear" id="item-quantity">
						<label><?php echo __d('admin', 'Quantity'); ?></label>
						<input type="text" value="<?php echo $item['quantity'] ?>" maxlength="3" class="input-xlarge text text-small" id="quantity" name="listing[quantity]" onkeydown="chknum(this,event);">
						<div class="qty-error adminitemerror" style="color:red"></div>
					</div>
				<br clear='all' />	
				<?php
				if($setngs[0]['Sitesetting']['cod']=='enable')
				{
				echo '<label>'.__d('admin', 'Cash On Delivery').'</label>';
				if($item['cod']=='yes')
				{
				?>
				<input type="radio" name="cod" value="yes" checked="checked" style="margin-left: 0;"><span style="font-size:13px;margin-left:5px;"><?php echo __d('admin', 'Yes'); ?></span><br />
				<input type="radio" name="cod" value="no" style="margin-left: 0;"><span style="font-size:13px;margin-left:5px;"><?php echo __d('admin', 'No'); ?></span></br />
				<?php
				}
				else
				{
				?>
				<input type="radio" name="cod" value="yes" style="margin-left: 0;"><span style="font-size:13px;margin-left:5px;"><?php echo __d('admin', 'Yes'); ?></span><br />
				<input type="radio" name="cod" value="no" checked="checked" style="margin-left: 0;"><span style="font-size:13px;margin-left:5px;"><?php echo __d('admin', 'No'); ?></span></br />
				<?php
				}
				}
				?>
					
				</div>
			</div>
		<br/>
		
				<dt><?php echo __d('admin', 'Product sizes'); ?></dt>

				
					<dp>
					<?php echo __d('admin', 'Property:');  ?>
					<input type="text" class="inputform" id="size_property" name="listing[property]" placeholder="Ex: XL" style="color: #555555 !important;"/>
					</dp>
					
					<dn>				
					<?php echo __d('admin', 'Units:');  ?>	
					<input type="text" class="inputform" onkeydown="chknum(this,event);" maxlength="3" id="size_units" name="listing[size]" placeholder="Ex: 10" style="color: #555555 !important;"/>
					</dn>
					
					<dm>
					<?php echo __d('admin', 'Price:');  ?>	
					<input type="text" class="inputform" onkeydown="chknum(this,event);" maxlength="6" id="size_price"  name="price" placeholder="Ex: 500" style="color: #555555 !important;"/>
					</dm>
					

					<input type="button" onclick="sizeAdd()" value="<?php echo __d('admin', 'Add');  ?>" class="btn btn-primary">
					<!--?php echo $this->Form->submit('Add',array('class'=>'btn-add','style'=>'margin: -39px 130px;', 'onclick'=>'sizeAdd(); return false;')); ?-->
					<a class="remove" href="javascript:void(0)" id="E" style="display:none";><span  class="glyphicons bin" style="display:none";></span></a>
					<div id="sizeerr" style="font-size:13px;color:red;font-weight:bold;"></div>
				<div id="sizeOption">
				</div>
				<?php 
				$sizes = $item['size_options'];
				$size_option = json_decode($sizes, true);
				$size_val = array();
				$unit_val = array();
				$price_val = array();
				foreach($size_option['size'] as $key=>$val)
				{
					$size_val[] = $val;
				}
				foreach($size_option['unit'] as $key=>$val)
				{
					$unit_val[] = $val;
				}
				foreach($size_option['price'] as $key=>$val)
				{
					$price_val[] = $val;
				}	
				$count = count($size_val);
				for($i=0;$i<$count;$i++)
				{
					echo '<dp class="size'.$i.'">
					'.__d('admin', 'Property:').'	
					<input readonly type="text" class="inputform" id="size_property" name="size['.$size_val[$i].']" value="'.$size_val[$i].'" placeholder="Ex: XL" style="color: #555555 !important;"/>
					</dp> ';
					echo '<dn class="unit'.$i.'">				
					'.__d('admin', 'Units:').'	
					<input readonly type="text" class="inputform" id="size_units" onkeydown="chknum(this,event);" maxlength="3" name="unit['.$size_val[$i].']" value="'.$unit_val[$i].'" placeholder="Ex: 10" style="color: #555555 !important;"/>
					</dn> ';
					echo '<dm class="price'.$i.'">
					'.__d('admin', 'Price:').'	 	
					<input readonly type="text" class="inputform" id="size_price" onkeydown="chknum(this,event);" maxlength="6" name="price['.$size_val[$i].']" value="'.$price_val[$i].'"  placeholder="Ex: 500" style="color: #555555 !important;"/>
					</dm>';
					echo '<a style="margin-left:-25px;" class="remove" id="remove'.$i.'" href="javascript:void(0)" id="'.$size_val[$i].'" onclick="removesizeoption('.$i.')"><span  class="glyphicons bin"> </span><br /></a>';
				}					
				?>
				<br />
			<div class="input-group clear" id="occasion">
					<label><?php echo __d('admin', 'Gender'); ?> <span class="sub-title"><?php echo __d('admin', 'Which gender the item for ?'); ?></span></label>
					<select name="property[occasion]">
						<?php
						$gender_type = $setngs[0]['Sitesetting']['gender_type'];
						$gen_type = json_decode($gender_type,true);
						for($i=0;$i<count($gen_type);$i++)
						{
							if($item['Item']['occassion']==$i)
							echo '<option value='.$i.' selected>'.$gen_type[$i].'</option>';
							else
							echo '<option value='.$i.'>'.$gen_type[$i].'</option>';
						}
						?>
					</select>
                    <!--<a class="overlay-trigger" href="" rel="#occasion-help">Why only one occasion?</a>-->
				</div></div><br/>
			<div data-variation="property[recipient]" class="input-group clear" id="recipient">
						<label><?php echo __d('admin', 'Relationship'); ?><span class="sub-title"><?php echo __d('admin', 'To whom is it for?'); ?>
><span class="optional"><?php echo __d('admin', 'choose multiple by pressing ctrl'); ?></span></span>
						</label>
						<select name="recipient[]" multiple="multiple" >
							<?php
							$receipent = json_decode($item['recipient'],true);
							$select = "";
							foreach($rcpnt_datas as $rcpnt){
								if(in_array($rcpnt['id'],$receipent)){
									$select = "selected";
								}
								echo "<option value='".$rcpnt['id']."' ".$select.">".$rcpnt['recipient_name']."</option>";
								$select = "";
							}
							?>
						</select>
						<!--<a class="overlay-trigger" href="" rel="#recipient-help">What if my item is for everyone?</a>-->
					</div>
			<div class="input-group clear" id="shipping">
    <h4><?php echo __d('admin', 'Shipping'); ?></h4>
    <div class="shipping-settings">
	  <!-- SHIPPING PROFILES-->
	  
	  <?php 
	  $process = $item['processing_time'];
	  ?>
	  <!-- PROCESSING TIME -->
		<div class="clear" id="processing-options">
				<label><?php echo __d('admin', 'Processing time'); ?></label>
				<select id="processing-time-id" name="processing_time_id">
					<option value=""><?php echo __d('admin', 'Ready to ship in...'); ?></option>
					<optgroup label="----------------------------"></optgroup>
					<?php
					if ($process == '1d'){
						echo '<option selected value="1d">'.__d('admin', '1 business day').'</option>';
					}else{
						echo '<option value="1d">'.__d('admin', '1 business day').'</option>';
					}
					if ($process == '2d'){
						echo '<option selected value="2d">'.__d('admin', '1-2 business days').'</option>';
					}else{
						echo '<option value="2d">'.__d('admin', '1-2 business days').'</option>';
					}
					
					if ($process == '3d'){
						echo '<option selected value="3d">'.__d('admin', '1-3 business days').'</option>';
					}else{
						echo '<option value="3d">'.__d('admin', '1-3 business days').'</option>';
					}
					
					if ($process == '4d'){
						echo '<option selected value="4d">'.__d('admin', '3-5 business days').'</option>';
					}else{
						echo '<option value="4d">'.__d('admin', '3-5 business days').'</option>';
					}
					
					if ($process == '2ww'){
						echo '<option selected value="2ww">'.__d('admin', '1-2 weeks').'</option>';
					}else{
						echo '<option value="2ww">'.__d('admin', '1-2 weeks').'</option>';
					}
					
					if ($process == '3w'){
						echo '<option selected value="3w">'.__d('admin', '2-3 weeks').'</option>';
					}else{
						echo '<option value="3w">'.__d('admin', '2-3 weeks').'</option>';
					}
					
					if ($process == '4w'){
						echo '<option selected value="4w">'.__d('admin', '3-4 weeks').'</option>';
					}else{
						echo '<option value="4w">'.__d('admin', '3-4 weeks').'</option>';
					}
					
					if ($process == '6w'){
						echo '<option selected selected value="6w">'.__d('admin', '4-6 weeks').'</option>';
					}else{
						echo '<option value="6w">'.__d('admin', '4-6 weeks').'</option>';
					}
					
					if ($process == '8w'){
						echo '<option selected value="8w">'.__d('admin', '6-8 weeks').'</option>';
					}else{
						echo '<option value="8w">'.__d('admin', '6-8 weeks').'</option>';
					}
					
					if ($process == 'custom'){
						//echo '<option selected value="custom">Custom range</option>';
					}else{
						//echo '<option value="custom">Custom range</option>';
					} ?>
				</select>
			<div class="proc-error adminitemerror" style="color:red"></div>
			<div class="custom-range" id="processing-time-days" style="display:none;">
				<select name="processing_min">
					<option><?php echo __d('admin', 'From...'); ?></option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
					<option>9</option>
					<option>10</option>
				</select>
				<span class="range-divider">&mdash;</span>
				<select name="processing_max">
					<option><?php echo __d('admin', 'To...'); ?></option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
					<option>9</option>
					<option>10</option>
				</select>

				<input type="radio" value="D" name="processing_time_units" id="business-days" checked="checked">
				<span for="business-days"><?php echo __d('admin', 'business days'); ?></span>
				<input type="radio" value="W" name="processing_time_units" id="weeks">
				<span for="weeks"><?php echo __d('admin', 'weeks'); ?></span>
			</div>

		</div>
	
	<!-- SHIPS FROM -->
	<input type="hidden" value="'.$cntryid[$cntry_code].'" id="origin_country_id">
	<div class=" shipping-origin-select shipping-origin-select-noprofiles">
		<label><?php echo __d('admin', 'Ships from'); ?></label>
		<select name="ship_from_country" id="selct_lctn_bxs">
			<option value=""><?php echo __d('admin', 'Select a location...'); ?></option>
			<?php
				foreach($cntry as $cnty){
					if($item['ship_from_country'] == $cnty['id']){
					echo "<option value='".$cnty['id']."' selected>".$cnty['country']."</option>";
					}else{
					echo "<option value='".$cnty['id']."' >".$cnty['country']."</option>";
					}
				}
			?>

		</select>
					<span class="shippingcountryerror" style="color:red"></span>
		
	</div>
	<div class="shipfrom-error adminitemerror" style="color:red"></div>
	
	
	
  <!-- SHIPPING RATES -->
  <div style="" class="set-shipping-rates">
        <table class="tablesorter table table-striped table-bordered table-condensed" id="shpng_div">
		   <thead>
              <tr>
                  <th class="ship-to"><?php echo __d('admin', 'Ships to'); ?></th>
                  <th><?php echo __d('admin', 'Cost'); ?></th>
                  <th colspan="2"><?php echo __d('admin', 'Remove'); ?></th>
              </tr>
           </thead>
           <tbody> 
           <?php
           $everyWhere = 0;
           foreach ($item['Shiping'] as $shiping) {
           	if ($shiping['country_id'] == 0){ ?>
				<tr class="new-shipping-location E">       
					<td id="E">         
						<div class="input-group-location">     
							<span><?php echo __d('admin', 'Everywhere else'); ?></span>     
							     
							<input type="hidden" value="true" name="everywhere_shipping[enabled]">
						</div>         
						<div class="regions-box"></div>       
					</td>      
					<td>           
						<div class="input-group input-group-price price-input primary-shipping-price">               
							<?php echo $item['currencysymbol'];?>               
							<input type="text" value="<?php echo $shiping['primary_cost'];?>" id="shippingPrice" class="money text text-small input-small" onkeydown="chknum(this,event);" maxlength="6" name="everywhere_shipping[1][primary]">            
						</div>       
					</td>      
    
					<td class="input-group-close">       
						<div class="shippingClose input-group input-group-price price-input primary-shipping-price shippingClose">
							<a class="remove" href="javascript:void(0)" id="E"><i class="icon-trash"></i></a>
						</div> 
					</td>  
				</tr>   
			<?php $everyWhere = 1; }else { ?>
				<tr class="new-shipping-location <?php echo $shiping['country_id']; ?>">       
					<td id="<?php echo $shiping['country_id']; ?>">        
						<div class="input-group-location"><?php echo $countryName[$shiping['country_id']]; ?></div>         
						<div class="regions-box"></div>       
					</td>       
					<td>          
						<div class="input-group input-group-price price-input primary-shipping-price"> 
							<?php echo $item['currencysymbol'];?>               
							<input type="text" value="<?php echo $shiping['primary_cost'];?>" id="shippingPrice" class="money text text-small input-small" onkeydown="chknum(this,event);" maxlength="6" name="country_shipping[<?php echo $shiping['country_id']; ?>][0][primary]">            
						</div>       
					</td>     
					      
					<td class="input-group-close">       
						<div class="shippingClose input-group input-group-price price-input primary-shipping-price">
							<a class="remove" href="javascript:void(0)" id="<?php echo $shiping['country_id']; ?>"><i class="icon-trash"></i></a>
						</div> 
					</td>  
				</tr>
			<?php } } 
			if ($everyWhere != 1) { ?>
				<tr class="new-shipping-location E">       
					<td id="E">         
						<div class="input-group-location">     
							<span><?php echo __d('admin', 'Everywhere else'); ?></span>     
							     
							<input type="hidden" value="true" name="everywhere_shipping[enabled]">
						</div>         
						<div class="regions-box"></div>       
					</td>      
					<td>           
						<div class="input-group input-group-price price-input primary-shipping-price">               
							$               
							<input type="text" value="" id="shippingPrice" class="money text text-small input-small" onkeydown="chknum(this,event);" maxlength="6" name="everywhere_shipping[1][primary]">            
						</div>       
					</td>      
    
					<td class="input-group-close">       
						<div class="input-group input-group-price price-input primary-shipping-price shippingClose">
							<a class="remove" href="javascript:void(0)" id="E"><i class="icon-trash"></i></a>
						</div> 
					</td>  
				</tr>
			<?php }
			?>
			</tbody>
		 </table>
			<!--<span class="button-medium button-medium-grey" id="add_shipping_location"><span><input type="button" value="Add location"></span></span>-->
		</div>
	</div></div>
	<input type="hidden" id="incrmt_val" value="3" />
	<input type="hidden" id="addlocntn" value="2" />
			<?php
				echo "<div id='alert' style='color:red;margin-top:15px;'></div>";
			echo "</div>";
			echo $this->Form->submit(__d('admin', 'Submit'),array('class'=>'btn btn-primary reg_btn'));
			echo "<div class='form-error' style='color:red;'></div>";
		echo $this->Form->end();
	echo "</div>";
?>
</div></div>

   			
   			
   	 </div>
      
  </div>

</div>

<script>setTimeout(function(){$('#flashmsg').fadeOut();}, 2000);</script>
<script>
        tinymce.init({selector:'#description',
            plugins: [
                      "advlist autolink lists link image charmap print preview anchor",
                      "searchreplace visualblocks code fullscreen",
                      "insertdatetime table contextmenu paste"],
                      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
                  });
</script>
<script>
var invajax=0;
</script>
