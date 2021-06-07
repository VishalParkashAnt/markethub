<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Seller'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Nonapproved Seller'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-25">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Nonapproved Seller'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">   
			
						
				
					<div class="box-content">   
	
	
	</div>
    <?php echo "<div id='userdata'>";
					 echo  '<div class="table-responsive m-t-0">';
                    echo '<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
                        echo '<thead>';
						?>
						
    
        <?php 
        echo '<tr>';
			echo '<th>'.__d('admin', 'Seller Name').'</th>';
			echo '<th>'.__d('admin', 'Brand Name').'</th>';
			echo '<th>'.__d('admin', 'Payment Details').'</th>';
			//echo '<th>Bank Acc. No.</th>';
			echo '<th>'.__d('admin', 'Phone No.').'</th>';
			echo '<th data-orderable="false">'.__d('admin', 'Status').'</th>';
			echo '<th data-orderable="false">'.__d('admin', 'Action').'</th>';
		echo '</tr>'; 
		?>
		
      </thead>
      <tbody>
      <?php
      if(!empty($sellerModel))
      {
  			foreach($sellerModel as $user_det){
				$id=$user_det['id'];
          $sellerId = $user_det['user_id'];
        $status=$user_det['seller_status'] ;
				echo '<tr id="del_'.$id.'">';
				if(empty($user_det['_matchingData']['Users']['first_name']))
					echo '<td>NA</td>';
					else
					echo '<td>'.$user_det['_matchingData']['Users']['first_name'].'</td>';
					echo '<td>'.$user_det['shop_name'].'</td>';
				
						echo '<td width="25%" class="namewrap">'.$user_det['braintree_id'].'</td>';
					//echo '<td>'.$user_det['Shop']['bank_account_no'].'</td>';
					echo '<td>'.$user_det['phone_no'].'</td>';
					echo '<td id="status'.$id.'">';
					if ($user_det['seller_status'] == 1) {
						echo '<button class="btn btn-warning" style="width: 60px; font-size: 11px;" onclick="changeSellerStatus_admin('.$id.','.$status.')">'.__d('admin', 'Disable').'</button></td>';
					} else {
						echo '<button class="btn btn-success" style="width: 60px; font-size: 11px;" onclick="changeSellerStatus_admin('.$id.','.$status.')">'.__d('admin', 'Enable').'</button></td>';
					}
				echo '<td>
      					 <a href="'.SITE_URL.'sellerinfo/'.$sellerId.'" style="cursor:pointer;"><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="'.__d('admin', 'View').'"></a>';
				echo '</td>';
			}
		}
		else
		{
			echo '<td colspan="6" align="center">'.__d('admin', 'No record found').'</td>';
		}
        ?>
        
      </tbody>
      
      
      
      
    </table>

      

    </div>
    </div>
   </div></div>                 
            
    
 </div>
   </div></div> 
    </div>
   </div></div> 
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
        "bInfo" : false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>


    
  </body>
</html>


