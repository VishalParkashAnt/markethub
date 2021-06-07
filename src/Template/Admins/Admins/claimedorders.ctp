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
    .claimedord
    {
    margin:0 5px 0 0;
    }
</style>

<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Claimed orders'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Claimed orders'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Claimed orders'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">


						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">


<body class="">




<?php



		echo "<div id='userdata'>";
        echo  '<div class="table-responsive m-t-10">';
          echo '<table id="claimedorderstable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
            echo '<thead>';
							echo '<tr>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Order no.').'</th>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Merchant name').'</th>';
								//echo '<th style="cursor:pointer;">'.__d('admin', 'Shipped Status').'</th>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Order Date').'</th>';
									//echo '<th style="cursor:pointer;">'.__d('admin', 'Delivered Date').'</th>';
								echo '<th style="cursor:pointer;">'.__d('admin', 'Paid Amount').'</th>';

								echo '<th style="cursor:pointer;">'.__d('admin', 'Currency').'</th>';
								echo '<th style="cursor:pointer;" data-orderable="false">'.__d('admin', 'Status').'</th>';
								echo '<th style="cursor:pointer; width: 160px;" data-orderable="false">'.__d('admin', 'View').'</th>';
								echo '<th style="cursor:pointer;" data-orderable="false">'.__d('admin', 'Action').'</th>';
								//echo '<th style="cursor:pointer;">View</th>';
							echo '</tr>';
							echo '<tbody>';
							if(count($getitemuser->toArray()))
							{
								foreach($getitemuser as $key=>$user_det){
									$amount = 0;
									$id=$user_det['orderid'];
									//echo $order_status;
									echo '<tr id="del_'.$id.'">';
										echo '<td class="invoiceId">'.$user_det['orderid'].'</td>';
										if(empty($usernames[$user_det['merchant_id']]))
											echo '<td class="invoiceNo">'.__('NA').'</td>';
										else
											echo '<td class="invoiceNo">'.$usernames[$user_det['merchant_id']].'</td>';
										//echo '<td class="invoiceStatus">'.$order_status[$id].'</td>';
										$day1 = date('m/d/Y',$user_det['orderdate']);
										echo '<td class="invoiceDate">'.$day1.'</td>';
									$day=date('m/d/Y',$user_det['deliver_date']);
										//echo '<td class="invoiceDate">'.$day.'</td>';
                                        if($order_total[$id] == 0)
                                        {
                                            $uer_paid_amount = $user_det['discount_amount'];
                                        }else{
                                            $uer_paid_amount = $order_total[$id];
                                        }

										echo '<td class="invoicePayMthd">'.$uer_paid_amount.'</td>';

										echo '<td class="invoiceId">'.$order_currency[$id].'</td>';
										echo '<td class="invoiceId">'.$user_det['status'].'</td>';
										echo '<td>';
										?>
											<input type="hidden" id="currency<?php echo $id; ?>" value="<?php echo $order_currency[$id]; ?>" />
											<a style="text-decoration:none;" href="<?php echo SITE_URL.'viewclaimedorder/'.$id;?>">


											<input type="button" class="btn btn-success" style="width: auto; font-size: 11px;" value="<?php echo __d('admin', 'View'); ?>" />
											</a>


										<?php
											echo '<img class="inv-loader-'.$id.'" src="'.SITE_URL.'images/loading.gif" style="display:none;"></td>';
											echo '<td>';
                                          if($user_det['deliverytype']=='braintree'){
										echo '<input type="button" class="btn btn-primary claimedord" style="width: 65px; font-size: 11px;" value="'.__d('admin', 'Refund').'" onclick="refundorderamount(1,'.$id.')"/>';
                                        }
                                        else
                                        {
                                        echo '<input type="button" class="btn btn-primary claimedord" style="width: 65px; font-size: 11px;" value="'.__d('admin', 'Confirm').'" onclick="refundorderamount(2,'.$id.')"/>';
                                        }

		  								echo '<input type="button" class="btn btn-warning" style="width: 65px; font-size: 11px;" value="'.__d('admin', 'Solve').'" onclick="solveorder('.$id.')"/>';

											echo '</td>';

										/*echo '<td>
									<a class="viewitem" href="'.SITE_URL.'viewDeliver/'.$id.'" ><span class="btn btn-success"><i class="icon-zoom-in"></i></span></a></td>';*/
									echo '</tr>';
								}
							}
							else
							{
								echo '<tr><td colspan="11" align="center">'.__d('admin', 'No Orders Found').'</td></tr>';
							}
							echo '</tbody>';
						echo '</thead>';
					echo '</table>';



			echo '<div id="paypalfom"></div>';





	echo "</div>";
	echo "</div>";
?>
					</div>
				</div><!--/span-->

			</div><!--/row-->
						<!-----Merchant payment------->








<div id="invoice-popup-overlay1">
	<div class="invoice-popup">
	<div id="userdata" class="invoice-datas">
	<button class="btn btn-danger inv-close" onclick="close_button()" style="width: 90px; margin: 14px 6px 0px; font-size: 11px;float:right;"><?php echo __d('admin', 'Back'); ?></button>

<?php
echo '<table>';
echo $this->Form->Create('Orders',array('url'=>array('controller'=>'/','action'=>'/admin/merchant_payment_export')));
echo '<tr><td>';
echo $this->Form->input('orderdate',array('label'=>__d('admin', 'Start date:'), 'name'=>'start','class'=>'input datepicker','type'=>'text','id'=>'deal-start'));
echo '</td>';
echo '<td>';
echo $this->Form->input('orderdate',array('label'=>__d('admin', 'End date:'), 'name'=>'end','class'=>'input datepicker','type'=>'text','id'=>'deal-end'));
echo '</td><td>';

echo $this->Form->input('status',array('name'=>'status','type' => 'select',
    'options' => array('Paid'=>__d('admin', 'Paid'),'Delivered' => __d('admin', 'Delivered'), 'Shipped' => __d('admin', 'Shipped'),'Returned' => __d('admin', 'Returned'),'Claimed' => __d('admin', 'Claimed'),'Processing' => __d('admin', 'Processing') ,'' => __d('admin', 'Pending'))) );
    echo '</td><td>';
echo $this->Form->submit(__d('admin', 'Export'),array('onclick'=>'close_button()','div'=>false,'class'=>'btn btn-primary reg_btn','style'=>'margin-top:13px;'));
echo '</td></tr>';
echo $this->Form->end();
echo '</table>';
?>

	</div>
</div>

</div>

</div>



<style>
/**************Invoice Popup ************/


#invoice-popup-overlay1 {
	background: none repeat scroll 0 0 rgba(31, 33, 36, 0.898);
    display: none;
    height: 100%;
    left: 0;
    opacity: 0;
    overflow: scroll;
    padding: 0 24px 24px 0;
    position: fixed;
    top: 0;
    transition: opacity 0.2s ease 0s;
    width: 100%;
    z-index: 12;
}

#invoice-popup-overlay1 div.invoice-popup {
	width: 800px;
	margin: 92px auto;
}

#invoice-popup-overlay1 .invoice-popup div#userdata {
    background: none repeat scroll 0 0 #FFFFFF;
    padding: 25px 25px 100px;
}
</style>
<script type="text/javascript" src="<?php echo $baseurl; ?>jQuery.print.js"></script>
<script>
$(document).keydown(function(e) {

  if (e.keyCode == 27)
  {
 		$('#invoice-popup-overlay15').hide();
		$('#invoice-popup-overlay15').css("opacity", "0");
  }   // esc
});
$('.inv-print').live('click',function(){
	$(".invoice_datas").print();
	return (false);
});
$('.inv-close').live('click',function(){
		$('#invoice-popup-overlay15').hide();
		$('#invoice-popup-overlay15').css("opacity", "0");
	});

</script>
<style>
/**************Invoice Popup ************/


#invoice-popup-overlay15 {
	background: none repeat scroll 0 0 rgba(31, 33, 36, 0.898);
    display: none;
    height: 100%;
    left: 0;
    opacity: 0;
    overflow: scroll;
    padding: 0 24px 24px 0;
    position: absolute;
    top: 0;
    transition: opacity 0.2s ease 0s;
    width: 100%;
    z-index: 12;
}

#invoice-popup-overlay15 div.invoice-popup {
	width: 800px;
	margin: 92px auto;
}

#invoice-popup-overlay15 .invoice-popup div#userdata {
    background: none repeat scroll 0 0 #FFFFFF;
    padding: 25px 25px 150px;
}
</style>
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
    $('#claimedorderstable').DataTable({
    "bInfo" : false,
        dom: '<"usertoolbar">frtip',
         "order": [
                   // [3, 'desc']
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


