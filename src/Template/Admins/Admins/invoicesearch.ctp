<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   


  
   
   
		
<?php


						
				echo "<div id='userdata'>";
					echo '<table id="myTable" class="tablesorter table table-striped table-bordered table-condensed">';
						echo '<thead>';
						echo '<th style="cursor:pointer;"> '.$this->Paginator->sort('orderid', __d('admin', 'Order Id'), array('escape' => false)).'</th>';
						echo '<th>'.__d('admin', 'Invoice No').'</th>';
						echo '<th style="cursor:pointer;"> '.$this->Paginator->sort('invoicedate', __d('admin', 'Invoice Date'), array('escape' => false)).'</th>';
						echo '<th>'.__d('admin', 'Invoice status').'</th>';
						echo '<th>'.__d('admin', 'Payment Method').'</th>';
						echo '<th>'.__d('admin', 'Action').'</th>';
						echo '</thead>';
						echo '<tbody>';
						$i = 0;

						if(!empty($invoiceorders))
						{
							foreach($invoiceorders as $invoices)
							{
									$day=date('m/d/Y',$invoices['invoicedate']);
								$invoice_id = $invoices['invoiceid'];
								$i++;
								echo '<tr id="del_'.$invoice_id.'">';
								//echo '<td>'.$i.'</td>';
								echo '<td>'.$invoices['_matchingData']['Invoiceorders']['orderid'].'</td>';

								echo '<td>'.$invoices['invoiceno'].'</td>';
								echo '<td>'.$day.'</td>';
								echo '<td>'.$invoices['invoicestatus'].'</td>';
								echo '<td>'.$invoices['paymentmethod'].'</td>';
								echo '<td>
											<input type="button" class="btn btn-success" style="width:auto; font-size: 11px;" onclick="showInvoicePopup(\''.$invoice_id.'\')" value="View">
											</td>';
								
								echo '</tr>';
							}
						}
						else
						{

							echo '<tr><td colspan="6" align="center">'.__d('admin', 'No taxes found').'</td></tr>';
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
    position: fixed;
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