<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Coupons'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Coupons'); ?></a></li>
                     <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>admin/addcoupon"><?php echo __d('admin', 'Add Coupon'); ?></a></li>
                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Coupons'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    

	
						<div class="row-fluid">		
				


<body class=""> 
			<?php
			echo "<div class='btn-toolbar'>";
			echo '<a data-ajax="false" class="btn btn-info" href="'.$baseurl.'admin/addcoupon/"><i class="icon-plus"></i> '.__d('admin','Add Coupon').'</a>';
			echo '</div>';
		
		


	
								
				echo "<div id='userdata'>";
					echo  '<div class="table-responsive m-t-40">';
					echo '<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
							echo '<tr>';
								echo '<th>'.__d('admin','S.No').'</th>';
								echo '<th>'.__d('admin','Coupon Code').'</th>';
								//echo '<th style="cursor:pointer;">Type</th>';
								echo '<th>'.__d('admin','Total Coupon').'</th>';
								echo '<th>'.__d('admin','Remaining').'</th>';
								echo '<th>'.__d('admin','Amount').'</th>';
								echo '<th>'.__d('admin','Start Date').'</th>';
								echo '<th>'.__d('admin','Expire Date').'</th>';
								echo '<th>'.__d('admin','Created Date').'</th>';
								//echo '<th style="cursor:pointer;">Valid all product</th>';
								echo '<th>'.__d('admin','Action').'</th>';
							echo '</tr>';
							echo '<tbody>';
							$i++;
								if(!empty($getcouponval)){
								foreach($getcouponval as $key=>$user_det){
									$id=$user_det['id'];
									$couponcode=$user_det['couponcode'];
									echo '<tr id="del_'.$id.'">';
										echo '<td class="invoiceId">'.$i.'</td>';
										echo '<td class="invoiceNo">'.$user_det['couponcode'].'</td>';
										//echo '<td class="invoiceNo">'.$user_det['coupontype'].'</td>';
										echo '<td class="invoiceNo">'.$user_det['totalrange'].'</td>';
										echo '<td class="invoiceNo">'.$user_det['validrange'].'</td>';
										echo '<td class="invoiceNo">'.$user_det['discount_amount'].'</td>';
										echo '<td class="invoiceNo">'.$user_det['validfromdate'].'</td>';
										echo '<td class="invoiceNo">'.$user_det['validtodate'].'</td>';
										$day=date('m/d/Y',$user_det['cdate']);
										echo '<td class="invoiceDate">'.$day.'</td>';
										$i++;
									
										/*if($user_det['Coupon']['select_merchant'] == '0'){
											echo '<td class="invoiceId">Yes</td>';
										}else{
											echo '<td class="invoiceId">No</td>';
										}*/
										?>
										<td>
										<a data-ajax="false"  href="<?php echo $baseurl.'editcoupon/'.$id.'/'.$couponcode;?> "><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="<?php echo __d('admin','Edit'); ?>"></a>
		  								<a href="#" onclick='deletecoupon("<?php echo $id; ?>")'><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="<?php echo __d('admin','Delete'); ?>"></a>
		  							
		  							<?php	
									echo '</tr>';
								}
								}else{
									echo "<tr><td colspan='10' align='center'>";
									echo __d('admin','No record Found');
									echo "</td></tr>";
								}
							echo '</tbody>';
						echo '</thead>';
					echo '</table>';
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
   			
   			
</div>
   			
   	 
  </div>
</div>