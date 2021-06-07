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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Invoices'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Invoices'); ?></a></li>
                     
                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Invoices'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    

	
						<div class="row-fluid">		
				<div class="box span12">

					<div class="box-content">


<body class=""> 
  
   
   
		
<?php

	
						
				echo "<div id='userdata'>";
				echo  '<div class="table-responsive m-t-0">';
					echo '<table id="invoicetable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
						echo '<th class="aligncenter">'.__d('admin', 'Order Id').'</th>';
						echo '<th class="aligncenter">'.__d('admin', 'Invoice No').'</th>';
						echo '<th class="aligncenter">'.__d('admin', 'Invoice Date').'</th>';
						echo '<th class="aligncenter">'.__d('admin', 'Invoice status').'</th>';
						echo '<th class="aligncenter">'.__d('admin', 'Payment Method').'</th>';
						echo '<th class="aligncenter" data-orderable="false">'.__d('admin', 'Action').'</th>';
						echo '</thead>';
						echo '<tbody>';
						$i = 0;

						if(count($invoiceorders->toArray())!=0)
						{
							foreach($invoiceorders as $invoices)
							{
									$day=date('m/d/Y',$invoices['invoicedate']);
                  //$day=date('m/d/Y',$invoices['invoicedate']);
								$invoice_id = $invoices['invoiceid'];
								$i++;
								echo '<tr id="del_'.$invoice_id.'">';
								//echo '<td>'.$i.'</td>';
								echo '<td class="aligncenter">'.$invoices['_matchingData']['Invoiceorders']['orderid'].'</td>';

								echo '<td class="aligncenter">'.$invoices['invoiceno'].'</td>';
								echo '<td class="aligncenter">'.$day.'</td>';
								echo '<td class="aligncenter">'.$invoices['invoicestatus'].'</td>';
								echo '<td class="aligncenter">'.$invoices['paymentmethod'].'</td>';
								echo '<td class="aligncenter">
											<input type="button" class="btn btn-rounded btn-outline-success" style="width:auto; font-size: 11px;" onclick="showInvoicePopupAdmin(\''.$invoice_id.'\')" value="'.__d('admin', 'View').'">
											</td>';
								
								echo '</tr>';
							}
						}
						else
						{

							echo '<tr><td colspan="6" align="center">'.__d('admin', 'No Invoice found').'</td></tr>';
						}
						echo '</tbody>';
					echo '</table>';
					
					
					
		

			
					
					
		echo "</div>";
	echo "</div>";
	echo "</div></div>";
	if($pagecount>0){
?>
<div class="pagination pagination-centered">
<?= $this->Paginator->prev('« '.__d('admin', 'Previous')) ?>
<?= $this->Paginator->numbers() ?>


<?= $this->Paginator->next(__d('admin', 'Next').' »') ?>

<?= $this->Paginator->counter()  ?>
<?php } ?>
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
/*
$('.inv-close').live('click',function(){
		$('#invoice-popup-overlay15').hide();
		$('#invoice-popup-overlay15').css("opacity", "0");
	});
	*/

</script>

<script type="text/javascript">
  
  $(document).ready(function(){

   $(document).keyup(function(e) { 
        if (e.keyCode == 27) { // esc keycode
           $('#invoice-popup-overlay1').hide();
       $('#invoice-popup-overlay1').css("opacity", "0");
        }
    });
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
    z-index: 1001;
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
    $('#invoicetable').DataTable({
        "bInfo" : false,
        dom: '<"usertoolbar">frtip',
         "columnDefs" : [{"targets":3, "type":"date-eu"}],
         "order": [
                    [1, 'desc']
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


