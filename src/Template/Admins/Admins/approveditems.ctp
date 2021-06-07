<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
 <style type="text/css">
   .table td, .table th
   {
     padding:0.75rem 0.15rem;
   }
    .namewrap
    {
        word-break: break-all;
    }
    .aligncenter
    {
       text-align:center;
    }
    .viewitem
    {
    padding-right:5px;
    }
</style>

<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Products'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Manage Approved Items'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Manage Approved Items'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">


						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">






  <label  style="display: inline;margin-right: 10px;"><?php echo __d('admin', 'Search by Date:'); ?></label>
  <div class="form-group row">
 
   <div class="col-md-3" style="margin-top:10px;">
<input type="text" class="form-control mydatepicker" name="startDate" placeholder="<?php echo __d('admin', 'Start Date'); ?>"  id="deal-start"/>
</div> <div class="col-md-3" style="margin-top:10px;">
<input type="text" class="form-control mydatepicker" name="endDate" placeholder="<?php echo __d('admin', 'End Date'); ?>"   id="deal-end"/>
</div> <div class="col-md-3" style="margin-top:10px;">
<input type="button" id="srchAffiliate" name="submit" value="<?php echo __d('admin', 'Search'); ?>" class="btn btn-info"  onclick="return srchapproveditems(); " />
<input type="button" id="resetapprov" name="resetapprov" value="<?php echo __d('admin', 'Reset'); ?>" class="btn btn-info"  onclick="return resetapproveditems(); " />
</div> <div class="col-md-3" style="margin-top:10px;">
<?php //echo $this->Html->link('Download all data(csv)',array('controller'=>'admins','action'=>'download'), array('target'=>'_blank','style'=>'font-size: 14px;')); ?>
<?php
if($demo_active!="yes")
{
?>
<input type="button" value="<?php echo __d('admin', 'Delete Selected'); ?>" class="btn btn-info" onclick="delete_approveditem()" >
<?php
}
?>

<span id="delerr" class="trn" style="float:right;margin-right:120px;font-size:13px;color:red;font-weight:bold;"></span>
</div>
<div id="errmsg" class="errdates trn"></div>
</div>

<?php
echo "<div id='searchite'>";
echo  '<div class="table-responsive m-t-0">';
					echo '<table id="approveditemstable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
				echo "<tr>";
					//echo "<th>".$this->Form->input('',array('type'=>'checkbox'))."</th>";
					echo "<th class='aligncenter'>".__d("admin", "Select")."</th>";
					echo "<th class='aligncenter'>".__d("admin", "Id")."</th>";
					echo "<th class='aligncenter'>".__d("admin", "Item title")."</th>";
					//echo "<th>Item description</th>";
					//echo "<th>Recipient</th>";
					echo "<th class='aligncenter'>".__d("admin", "Seller Name")."</th>";
					echo "<th class='aligncenter'>".__d("admin", "Seller Email")."</th>";
					 echo "<th class='aligncenter'>".__d("admin", "Price")."</th>";
          echo "<th class='aligncenter'>".__d("admin", "Quantity")."</th>";
          echo "<th class='aligncenter'>".__d("admin", "Size Options")."</th>";
          echo "<th class='aligncenter'>".__d("admin", "Created")."</th>";
          echo "<th class='aligncenter'>".__d("admin", "Mark Featured")."</th>";
          echo "<th class='aligncenter' data-orderable='false'>".__d("admin", "Status")."</th>";
          echo "<th class='aligncenter' data-orderable='false'>".__d("admin", "Action")."</th>";
				echo "</tr>";
       echo '</thead>';
				echo '<tbody>';
				if(!empty($item_datas)){
					foreach($item_datas as $key=>$temp){
            if ($temp['status'] == "draft") {
            $buttonLabel = __d("admin", "Publish");
            $color = "btn-success";
          } else {
            $buttonLabel = __d("admin", "Draft");
            $color = "btn-warning";
          }

						$item_id = $temp['id'];
						$item_title = $temp['item_title'];
						$item_description = $temp['item_description'];
						//$recipient = $temp['Item']['recipient'];
						$recipient = $temp['id'];
						$occasion = $temp['occasion'];
						$price = $temp['price'];
						$redirect = $temp['bm_redircturl'];
            $quantity = $temp['quantity'];
            $size_options = $temp['size_options'];
           // $username = $temp['_matchingData']['Users']['username'];
           // $useremail = $temp['_matchingData']['Users']['email'];
              $username = $temp['user']['username'];
              $useremail = $temp['user']['email'];
						echo "<tr id='item".$item_id."'>";
							//echo "<td>".$this->Form->input('',array('type'=>'checkbox'))."</td>";
							//echo "<td>".$this->Html->link($Item_name,array('controller'=>'/','action'=>'/admin/edit/category/'.$secid.'~'.$category_urlname))."</td>";

                          //echo '<td><input type="checkbox" value="'.$id.'" name="user'.$id.'" class="inactiveuser"/></td>';
							echo '<td class="aligncenter"><input type="checkbox" id="'.$item_id.'" value="'.$item_id.'" name="items'.$item_id.'" class="shareditem"></td>';
							echo "<td width='5%' class='aligncenter'>".$item_id."</td>";
							echo "<td class='aligncenter' style='max-width: 200px;word-break: break-all;text-overflow: ellipsis;'>".$item_title."</td>";
              echo "<td class='aligncenter'>".$username."</td>";
              echo "<td class='aligncenter'>".$useremail."</td>";
							//echo "<td style='width: 40%;word-break: break-all;'>".$item_description."</td>";
							//echo "<td>".$recipient."</td>";
							//echo "<td>".$occasion."</td>";
							echo "<td class='aligncenter'>".$price."</td>";
							echo "<td class='aligncenter'>".$quantity."</td>";


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
        foreach($size_option['price'] as $key=>$val)
        {
          $price_val[] = $val;
        }
        $count = count($size_val);
echo "<td class='aligncenter' style='max-width: 200px;word-break: break-all;text-overflow: ellipsis;'>";
        for($i=0;$i<$count;$i++)
        {
              echo $size_val[$i]."&nbsp;-&nbsp;".$unit_val[$i]."&nbsp;-&nbsp;".$price_val[$i]."<br>";
}  echo "</td>"; // echo "<td style='max-width: 200px;word-break: break-all;text-overflow: ellipsis;'>".$size_options."</td>";

              echo "<td class='aligncenter'>".date("m/d/Y",strtotime($temp['created_on']))."</td>";

              if ($temp['featured'] == 0){
                echo "<td class='aligncenter'><input type='checkbox' name='featured' id='featured".$item_id."' onchange='markfeature(\"$item_id\")' /></td>";
              }else{
                echo "<td class='aligncenter'><input type='checkbox' name='featured' id='featured".$item_id."' checked='checked' onchange='markfeature(\"$item_id\")' /></td>";
              }
              echo "<td class='aligncenter'> <span id='status".$item_id."'>";
                echo "<button class='btnappr btn ".$color."' onclick='changeItemStatus(".$item_id.",\"".$temp['status']."\");'>".$buttonLabel."</button>";


              echo "</span></td>";
							echo '<td width="12%" style="min-width:115px !important;" class="aligncenter">
									<a class="viewitem" href="'.SITE_URL.'adminitemview/'.$item_id.'" target="_blank"><span class="btn btn-success"><i class="mdi mdi-search-web"></i></span></a>';

      								if($demo_active!="yes")
      			 					echo '<a onclick = "deleteItemAdmin('.$item_id.');" role="button" data-toggle="modal" style="cursor:pointer;"><span class="btn btn-danger"><i class="mdi mdi-delete"></i></span></a>';
      			 					echo '</td>';
						echo "</tr>";
					}
				}else{
					echo "<tr><td colspan='8' align='center'>";
						echo __d("admin", "No record Found");
					echo "</td></tr>";
				}
				echo '</tbody>';
		echo '</table>';


	echo "</div>";

	echo "</div>";
?>
     </div></div></div>

        </div>
    </div>
</div>

    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    <script>
var invajax=0;
</script>
 <?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
  <?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>
  <script>
 jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });</script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#approveditemstable').DataTable({
    "bInfo" : false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "columnDefs": [
            {
                "targets": [ 3 ],
                "visible": false
            },
            {
                "targets": [ 4 ],
                "visible": false
            }
        ]
    });

    </script>
</body>

</html>


					</div>
				</div>

			</div>

		</div>
				</div>

			</div>