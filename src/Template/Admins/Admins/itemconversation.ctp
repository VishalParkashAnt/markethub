<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Seller Chat'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><a href="<?php echo $baseurl; ?>	contacteditem"><?php echo __d('admin', 'Manage Seller Chat'); ?></a></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Contacted Sellers'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">   

                    
				
	<?php	
	
//	echo "<a href='".SITE_URL.'adminitemview/'.$contactsellerModel[0]['itemid']."' target='_blank' title='View Item' style='float: right; margin-top: -40px;'>Product: ".$contactsellerModel[0]['itemname']."</a>";
	echo  '<div class="table-responsive m-t-0">';
                    echo '<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
                        echo '<thead>';
                        
				echo "<tr >";
					//echo "<th>".$this->Form->input('',array('type'=>'checkbox'))."</th>";
					echo "<th>".__d("admin", "Id")."</th>";					
					echo "<th>".__d("admin", "User Name")."</th>";
					echo "<th>".__d("admin", "Subject")."</th>";
					echo "<th>".__d("admin", "Action")."</th>";
				echo "</tr>";
				echo '<tbody>';
				if(!empty($contactsellerModel)){
					foreach($contactsellerModel as $key=>$temp){
						$csid = $temp['id'];
						$item_id = $temp['itemid'];
						$userName = $temp['buyername'];
						$subject = $temp['subject'];
					
						echo "<tr id='cs".$csid."'>";
							echo "<td>".$csid."</td>";
							echo "<td>".$userName."</td>";
							echo "<td>".$subject."</td>";
							echo '<td><a href="'.SITE_URL.'itemuserconversation/'.$csid.'/'.$item_id.'" style="cursor:pointer;"><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="'.__d('admin', 'View').'"></a></td>';
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
		
	echo "</div>";
?>
					</div>
				</div><!--/span-->
			
			</div>
        <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
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

