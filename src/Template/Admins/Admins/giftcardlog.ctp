<body class=""> 
  <!--<![endif]-->
    <style>
  .aligncenter
  {
     text-align:center;
  }
  .table td, .table th
  {
     padding: 0.75rem 0.10rem;
  }
  </style>
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Gift Card Logs'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><?php echo __d('admin', 'Gift Cards'); ?></li>
                     
                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Gift Card Logs'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    

	
					


<body class=""> 

	<?php
						
				echo "<div id='userdata'>";
					echo  '<div class="table-responsive m-t-0">';
					echo '<table id="giftcardstable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
							echo '<tr>';
								echo '<th class="aligncenter" style="cursor:pointer;">'.__d('admin', 'S.No').'</th>';
								echo '<th class="aligncenter" style="cursor:pointer;">'.__d('admin', 'Receiver name').'</th>';
								echo '<th class="aligncenter" style="cursor:pointer;">'.__d('admin', 'Email').'</th>';
								echo '<th class="aligncenter" style="cursor:pointer;">'.__d('admin', 'Sender name').'</th>';
								echo '<th class="aligncenter" style="cursor:pointer;">'.__d('admin', 'Amount').'</th>';
								echo '<th class="aligncenter" style="cursor:pointer;">'.__d('admin', 'Date').'</th>';
							echo '</tr>';
							echo '<tbody>';
							$i = 1;
                            if(count($giftcardlogval->toArray())!=0){
								foreach($giftcardlogval as $key=>$user_det){
									$id=$user_det['id'];
									echo '<tr id="del_'.$id.'">';
										echo '<td class="aligncenter">'.$i.'</td>';
										if(empty($user_det['reciptent_name']))
											echo '<td class="aligncenter">'.__d('admin', 'NA').'</td>';
										else
											echo '<td class="aligncenter">'.$user_det['reciptent_name'].'</td>';
										echo '<td class="invoiceNo">'.$user_det['reciptent_email'].'</td>';
										if(empty($user_det['_matchingData']['Users']['username']))
											echo '<td class="aligncenter">'.__d('admin', 'NA').'</td>';
										else
											echo '<td class="aligncenter">'.$user_det['_matchingData']['Users']['username'].'</td>';
										echo '<td class="aligncenter">'.$user_det['amount'].'</td>';
										$day=date('m/d/Y',$user_det['cdate']);
										echo '<td class="invoiceDate">'.$day.'</td>';
										$i++;
										
								}
                                }
                                else
                                {
                                    echo '<tr><td colspan="6" align="center">'.__d('admin', 'No Log Found').'</td></tr>';
                                }
							echo '</tbody>';
						echo '</thead>';
					echo '</table>';
					
					
					
		
		
			
					
					
		echo "</div>";
	echo "</div>";
	echo "</div>";
?>
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
     $('#giftcardstable').DataTable({
      "bInfo" : false,
        dom: '<"usertoolbar">frtip',
         "order": [
                    [5, 'desc']
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

</div>
   			
   	 
  </div>
</div>
   			
   			

