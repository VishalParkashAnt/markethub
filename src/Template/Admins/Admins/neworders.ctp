<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Neworders'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Neworders'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Neworders'); ?></h4>
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
          echo '<table id="neworderstable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
            echo '<thead>';
						echo '<th>'.__d('admin', 'Order Id').'</th>';
						echo '<th>'.__d('admin', 'Merchant Name').'</th>';
						echo '<th>'.__d('admin', 'Order Status').'</th>';
						echo '<th>'.__d('admin', 'Order Date').'</th>';
						echo '<th>'.__d('admin', 'Currency').'</th>';
                        echo '<th>'.__d('admin', 'Amount').'</th>';
						echo '<th data-orderable="false">'.__d('admin', 'Action').'</th>';
						echo '</thead>';
						echo '<tbody>';
						$i = 0;

						if(count($getitemuser->toArray())!=0)
						{
							foreach($getitemuser as $getitemusers)
							{

									$day=date('m/d/Y',$getitemusers['orderdate']);
								$orderId = $getitemusers['orderid'];
								$i++;
								echo '<tr id="del_'.$orderId.'">';
								//echo '<td>'.$i.'</td>';
                echo '<td>'.$getitemusers['orderid'].'</td>';

								echo '<td>'.$getitemusers['_matchingData']['Users']['username'].'</td>';

								echo '<td>'.$getitemusers['status'].'</td>';
								echo '<td>'.$day.'</td>';
                echo '<td>'.$getitemusers['currency'].'</td>';
								echo '<td>'.$getitemusers['totalcost'].'</td>';

								echo '<td>
											  <a href="'.$baseurl.'viewneworder/'.$orderId.'"><input type="button" class="btn btn-rounded btn-outline-success" style="width:auto; font-size: 11px;"  value="'.__d('admin', 'View').'"></a>
											</td>';

								echo '</tr>';
							}
						}
						else
						{
                           
							echo '<tr><td colspan="6" align="center">'.__d('admin', 'No Orders Found').'</td></tr>';
						}
						echo '</tbody>';
					echo '</table>';








		echo "</div>";
	echo "</div>";
	echo "</div></div>";
 ?>
</div>
   	 	</div>
				</div>

			</div>






</div>


  </div>
</div>


<div id="invoice-popup-overlay15">
	<div class="invoice-popup">
	</div>



</div>

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
                    //[2, 'asc']
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
                   // table.order([2, 'desc']).draw();
                } else {
                    //table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#neworderstable').DataTable({
        "bInfo" : false,
        dom: '<"usertoolbar">frtip',
         "order": [
//                    [0, 'desc']
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


