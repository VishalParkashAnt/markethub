<style>
.aligncenter
{
  text-align: center;
}
</style>
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
					//echo "<th>".__d("admin", "Item description")."</th>";
					//echo "<th>".__d("admin", "Recipient")."</th>";
					
					 echo "<th class='aligncenter'>".__d("admin", "Price")."</th>";
          echo "<th class='aligncenter'>".__d("admin", "Quantity")."</th>";
          echo "<th class='aligncenter'>".__d("admin", "Size Options")."</th>";
          echo "<th class='aligncenter'>".__d("admin", "Created")."</th>";
          echo "<th class='aligncenter'>".__d("admin", "Mark Featured")."</th>";
          echo "<th class='aligncenter' data-orderable='false'>".__d("admin", "Status")."</th>";
          echo "<th class='aligncenter' data-orderable='false'>".__d("admin", "Action")."</th>";
				echo "</tr>";
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

						echo "<tr id='item".$item_id."'>";
							//echo "<td>".$this->Form->input('',array('type'=>'checkbox'))."</td>";
							//echo "<td>".$this->Html->link($Item_name,array('controller'=>'/','action'=>'/admin/edit/category/'.$secid.'~'.$category_urlname))."</td>";

                          //echo '<td><input type="checkbox" value="'.$id.'" name="user'.$id.'" class="inactiveuser"/></td>';
							echo '<td class="aligncenter"><input type="checkbox" id="'.$item_id.'" value="'.$item_id.'" name="items'.$item_id.'" class="shareditem"></td>';
							echo "<td width='5%' class='aligncenter'>".$item_id."</td>";
							echo "<td width='13%' class='aligncenter'>".$item_title."</td>";
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
echo "<td style='max-width: 200px;word-break: break-all;text-overflow: ellipsis;'>";
        for($i=0;$i<$count;$i++)
        {
              echo $size_val[$i]."&nbsp;-&nbsp;".$unit_val[$i]."&nbsp;-&nbsp;".$price_val[$i]."<br>";
}  echo "</td>"; // echo "<td style='max-width: 200px;word-break: break-all;text-overflow: ellipsis;'>".$size_options."</td>";

              echo "<td class='aligncenter'>".date("m/d/Y",strtotime($temp['created_on']))."</td>";
              if ($temp['Item']['featured'] == 0){
                echo "<td class='aligncenter'><input type='checkbox' name='featured' id='featured".$item_id."' onchange='markfeature(\"$item_id\")' /></td>";
              }else{
                echo "<td class='aligncenter'><input type='checkbox' name='featured' id='featured".$item_id."' checked='checked' onchange='markfeature(\"$item_id\")' /></td>";
              }
              echo "<td class='aligncenter'> <span id='status".$item_id."'>";
                echo "<button class='btn ".$color."' style='font-size:11px;width:60px;' onclick='changeItemStatus(".$item_id.",\"".$temp['status']."\");'>".$buttonLabel."</button>";
    
              //   <a class="viewitem" href="'.SITE_URL.'admin/edititem/'.$item_id.'" style="cursor:pointer;"><span class="btn btn-info"><i class="mdi mdi-border-color"></i></span></a>'
              echo "</span></td>";
							echo '<td width="16%" class="aligncenter">
									<a class="viewitem" href="'.SITE_URL.'adminitemview/'.$item_id.'" target="_blank"><span class="btn btn-success"><i class="mdi mdi-search-web"></i></span></a>';
      								if($demo_active!="yes")
      			 					echo '<a onclick = "deleteItem('.$item_id.');" role="button" data-toggle="modal" style="cursor:pointer;"><span class="btn btn-danger"><i class="mdi mdi-delete"></i></span></a>';
      			 					echo '</td>';
						echo "</tr>";
					}
				}else{
					echo "<tr><td colspan='8' align='center'>";
						echo __d('admin', 'No record Found');
					echo "</td></tr>";
				}
				echo '</tbody>';
			echo '</thead>';
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
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      /* , "columnDefs": [
            {
                "targets": [ 3 ],
                "visible": false
            },
            {
                "targets": [ 4 ],
                "visible": false
            }
        ]*/
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


   			
   			
