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
<?php 
	echo '<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
echo "<tr>";
//echo "<th>".$this->Form->input('',array('type'=>'checkbox'))."</th>";
echo '<th class="aligncenter">'.__d('admin', 'Select').'</th>';
echo "<th class='aligncenter'>".__d("admin", "Id")."</th>";
echo "<th class='aligncenter'>".__d("admin", "Item title")."</th>";
//echo "<th>".__d("admin", "Item description")."</th>";
echo "<th class='aligncenter'>".__d("admin", "Price")."</th>";

echo "<th class='aligncenter'>".__d("admin", "Created")."</th>";
echo "<th class='aligncenter'>".__d("admin", "Item url")."</th>";

echo "<th class='aligncenter'>".__d("admin", "Action")."</th>";
echo "</tr>";
echo '<tbody>';
if(!empty($item_datas)){
	foreach($item_datas as $key=>$temp){
		
		$item_id = $temp['id'];
		$item_title = $temp['item_title'];
		$item_description = $temp['item_description'];
		$recipient = $temp['recipient'];
		$quantity = $temp['quantity'];
		$quantity_sold = $temp['quantity_sold'];
		$price = $temp['price'];
		$redirect = $temp['bm_redircturl'];
		$fav_count = $temp['fav_count'];
		$cateIdd = $temp['category_id'];

         $report_flag = $temp['report_flag'];
            $report = json_decode($report_flag,true);
            $report_count = count($report);
		echo "<tr id='item".$item_id."'>";
		echo '<td class="aligncenter"><div class="checker"><span><input type="checkbox" id="'.$item_id.'" value="'.$item_id.'" name="seldel[]"></span></div></td>';
		echo "<td class='aligncenter'>".$item_id."</td>";
		echo "<td class='aligncenter'>".$item_title."</td>";
		//echo "<td style='width: 40%;word-wrap: break-all;'>".$item_description."</td>";
	   echo "<td class='aligncenter'>".$price."</td>";
                            //echo "<td>".$quantity."</td>";
                            
                            echo "<td class='aligncenter'>".date("m/d/Y",strtotime($temp['created_on']))."</td>";

                            echo "<td class='aligncenter'>".$report_count."</td>";
                            
                        echo '<td class="aligncenter" style="width:320px !important;"><input type="button" class="btn btn-rounded btn-outline-warning" value="'.__d('admin', 'Draft').'" style="font-size:11px;" onclick="changereportItemStatus(\''.$item_id.'\',\''.$status.'\')">';
                echo '<input type="button" class="btn btn-rounded btn-outline-success" value="'.__d('admin', 'Ignore').'" style="font-size:11px;" onclick="ignorereport(\''.$item_id.'\')">';
              //echo "<td>".$quantity."</td>";
              
                    echo '<a href="'.SITE_URL.'adminitemview/'.$item_id.'" target="_blank"><input type="button" class="btn btn-rounded btn-outline-success" style="width:auto; font-size: 11px;" value="'.__d('admin', 'View').'"></a>';
              
              
                      if($demo_active!="yes")
                      echo '<a onclick = "deleteItem('.$item_id.');" role="button" data-toggle="modal" style="cursor:pointer;"><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="'.__d('admin', 'Delete').'"></a>';
                      echo '</td>';
                        echo "</tr>";
	}
}else{
	echo "<tr>";
      echo __d('admin', 'No record Found');
	echo "</tr>";
}
echo '</tbody>';
echo '</thead>';
echo '</table>';






echo "</div>";
?>
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
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
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


   			
   			
