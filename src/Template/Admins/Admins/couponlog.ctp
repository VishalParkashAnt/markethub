
<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Coupon Logs'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>taxrates"><?php echo __d('admin', 'Coupons'); ?></a></li>
                     <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>taxrates"><?php echo __d('admin', 'Coupon Logs'); ?></a></li>
                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Coupon Logs'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    

	
				


<body class=""> 

	
			
<?php

	
						
				echo "<div id='userdata'>";
				echo  '<div class="table-responsive m-t-40">';
					echo '  <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
							echo '<tr>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'S.No').'</th>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Coupon Code').'</th>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Username').'</th>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Order Id').'</th>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Order Status').'</th>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Date').'</th>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Action').'</th>';
							echo '</tr>';
							echo '<tbody>';
							$i = 1;
							if(!empty($getlogcouponval)){
								foreach($getlogcouponval as $key=>$user_det){
		
									$id=$user_det['id'];

									echo '<tr id="del_'.$id.'">';
										echo '<td class="invoiceNo">'.$i.'</td>';
										foreach($coupon_values as $coupons)
										{
											if($coupons['id']==$user_det['coupon_id'])
											{
												$couponcode = $coupons['couponcode'];
											}
										}

																						
										echo '<td class="invoiceNo">'.$couponcode.'</td>';
										//if(empty($user_det['username']))
										//	echo '<td class="invoiceNo">NA</td>';
										//else
										foreach($user_details  as $user_name)
										{
											$username = $user_name['username'];
										}
											echo '<td class="invoiceNo">'.$username.'</td>';
										$day=date('m/d/Y',$user_det['cdate']);
										foreach($order_det as $orderdetails)
										{
											if($orderdetails['coupon_id']==$user_det['coupon_id'] && $orderdetails['userid']==$user_det['user_id'] && $orderdetails['orderdate']==$user_det['cdate'])
											{
												$orderId = $orderdetails['orderid'];
												$orderStatus = $orderdetails['status'];
												if($orderStatus=="")
												$orderStatus = "Pending";
												else
												$orderStatus = $orderdetails['status'];
											}
										}										
										echo '<td class="orderId">'.$orderId.'</td>';
										echo '<td class="orderStatus">'.$orderStatus.'</td>';
										echo '<td class="invoiceDate">'.$day.'</td>';
										echo '<td>
									<a class="viewitem" href="'.$baseurl.'viewcoupon/'.$orderId.'" ><input type="button" class="btn btn-rounded btn-outline-success" style="width:auto; font-size: 11px;" value="'.__d('admin', 'View').'"></td>';
										$i++;
									
										
								}
								}else{
									echo "<tr><td colspan='10' align='center'>";
									echo __d("admin", "No record Found");
									echo "</td></tr>";
								}
							echo '</tbody>';
						echo '</thead>';
					echo '</table>';
					
					
					
			echo '</div></div></div></div>'
					
			
			

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

</div>
   			
   	 
  </div>
</div>
   			
   			
