<?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
<?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Manage Products'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Manage Products'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Edit Products'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <!-- h4 class="card-title">Data Table</h4 -->
                <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Products'); ?></h4>
                <hr/>
                <div class="prvcmntcont m-t-30">
                  <?php if (count($item_datas) > 0) { 
                      if($sdate!="" && $edate!="") {
                        $sdate = date("m/d/Y", strtotime($sdate));
                        $edate = date("m/d/Y", strtotime($edate));

                        //$sdate = "";
                        //$edate = "";

                      } else {
                        $sdate = "";
                        $edate = "";
                      }

                    ?>
                     <?php  echo '<span class="col-sm-3 p-l-0">'.__d('merchant','Date Filter').'</span>
                        <input type="text" id="sdate" class="form-control datepicker-autostart col-sm-3" placeholder="'.__d('merchant','Start Date').'" style="margin-top:7px;color:#555555! important;" value='.$sdate.'>
                        <input type="text" id="edate" class="form-control datepicker-autoend col-sm-3" placeholder="'.__d('merchant','End Date').'" style="margin-top:7px;color:#555555! important;" value='.$edate.'>

                        <!-- button class="btn btn-success" onclick="actionItem_datesearch()" style="vertical-align:inherit;">Search</button>

                        <a class="btn btn-info clearResult" href="'.MERCHANT_URL.'/updateproducts" style="vertical-align:inherit;">Reset</a -->';

                        ?>
                        <!-- small class="form-control-feedback f4-error f4-error-daterror m-t-20 col-sm-3"></small -->
                 

                <div class="table-responsive">

                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th class="p-l-10"><?php echo __('#');?></th>
			        			<!-- th><?php //echo __('Id');?></th -->
			        			<th><?php echo __d('merchant','Product title');?></th>
			        			<th><?php echo __d('merchant','Price');?></th>
			        			<th><?php echo __d('merchant','Quantity');?></th>
			        			<th><?php echo __d('merchant','Size Options');?></th>
                        <th><?php echo __d('merchant','Created');?></th>
                        <th><?php echo __d('merchant','Status');?></th>
                        <th><?php echo __d('merchant','Actions');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $incre = 0;
               foreach($item_datas as $key=>$temp) {
                  if ($temp['status'] == "draft") {
                     $buttonLabel = "Publish";
                     $color = "btn-success";
                  } else {
                     $buttonLabel = "Draft";
                     $color = "btn-warning";
                  }
                  $item_id = $temp['id'];
                  //$item_sku_id = $temp['Item']['skuid'];
                  $item_title = $temp['item_title'];
                  $item_description = $temp['item_description'];
                  //$recipient = $temp['Item']['recipient'];
                  $recipient = $temp['id'];
                  $occasion = $temp['occasion'];
                  $price = $temp['price'];
                  $quantity = $temp['quantity'];
                  $size_options ="";
                  if(!empty($temp['size_options']))
                     $size_options = $temp['size_options'];
                     echo "<tr id='item".$item_id."'>";
                     //echo "<td>".$item_id."</td>";
                     echo "<td class='p-l-10'>".++$incre."</td>";
                     echo "<td style='max-width: 150px;word-break: break-all;text-overflow: ellipsis;'>".$item_title."</td>";

                     echo "<td>"; 
                      if(!empty($size_options))
                        echo " - ";
                      else 
                        echo $price;
                     echo "</td>";
                     echo "<td>".$quantity."</td>";
                     if(!empty($size_options))
                     {
                        $sizes = $size_options;
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
                        if(!empty($size_option['price'])) {
                           foreach($size_option['price'] as $key=>$val)
                           {
                              $price_val[] = $val;
                           }
                        }
                        $count = count($size_val);
                        echo "<td style='max-width: 200px;word-break: break-all;text-overflow: ellipsis;'>";
                        for($i=0;$i<$count;$i++)
                        {  
                           /*$pr_val = "";
                           if(!empty($price_val[$i]))
                              $pr_val = $price_val[$i];
                           echo $size_val[$i]."&nbsp;-&nbsp;".$unit_val[$i]."&nbsp;-&nbsp;".$pr_val."<br>";*/
                           if($i == 0) {
                            echo $size_val[$i];
                           } else {
                            echo ", ".$size_val[$i];
                           }
                        }  echo "</td>"; 
                     } else {
                        echo "<td> - </td>";
                     }
                     echo "<td>".date("m/d/Y",strtotime($temp['created_on']))."</td>";
   
                     echo "<td>".$temp['status']."</td>";
                    
                     echo '<td style="min-width:175px !important;"><a class="viewitem" href="'.MERCHANT_URL.'/selleritemview/'.$item_id.'" target="_blank"><span class="btn btn-success"><i class="fa fa-search-plus"></i></span></a>
                               <a href="'.MERCHANT_URL.'/editselleritem/'.$item_id.'" style="cursor:pointer;"><span class="btn btn-info"><i class="fa fa-edit"></i></span></a>';
                           //    if($demo_active!="yes")
                               echo '<a onclick = "deleteItem('.$item_id.');" role="button" data-toggle="modal" style="cursor:pointer;" class="m-l-5"><span class="btn btn-danger"><i class="fa fa-trash"></i></span></a>';
                               echo '</td>';
                  echo "</tr>";
               }
             ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                	<h6 class="card-title text-center m-t-30 m-b-30"><?php echo __d('merchant','No Product Available');?></h6>
                <?php }?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<script>
/*var o = document.getElementById( 'sdate' );
  o.addEventListener( 'keydown', function( e ) {
      if( e.keyCode >= 37 && e.keyCode <= 40 ) {
          return; // arrow keys
      }
      if( e.keyCode === 8 || e.keyCode === 46 ) {
          return; // backspace / delete
      }
      e.preventDefault( );
  }, false );*/

  $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        var min = $('#sdate').datepicker("getDate");
        var max = $('#edate').datepicker("getDate");
        var startDate = new Date(data[5]);
        if (min == null && max == null) { return true; }
        if (min == null && startDate <= max) { return true;}
        if(max == null && startDate >= min) {return true;}
        if (startDate <= max && startDate >= min) { return true; }
        return false;
    }
  );


  $("#sdate, #edate").datepicker({ 
    onSelect: function () { 
        table.draw(); 
    }, 
    format: 'mm/dd/yyyy', 
    todayHighlight: true,
    clearBtn: true });

  var table = $('#myTable').DataTable({
      dom: 'Bfrtip'
  });

  $('#sdate, #edate').change(function () {
      table.draw();
  });
</script>
