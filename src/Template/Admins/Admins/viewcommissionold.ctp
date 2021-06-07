<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
   
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-6 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Commission</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard">Home</a></li>
                     <li class="breadcrumb-item active">Commission</li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white">Commission</h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    
<div class="btn-toolbar">
    <a  href="<?php echo $baseurl.'admin/commission/'; ?>" ><input type="button" class="btn btn-info" value="+ Add Commision"></a>
    <!--button class="btn">Import</button>
    <button class="btn">Export</button-->
  
</div>

	<!-----View Commission------->				
						<div class="row-fluid">		
				<div class="box span12">

					<div class="box-content">

						<?php
	echo "<div id='search_user1'>";
	echo "<div class='container-fluid'>";
						
				echo "<div id='userdata'>";
					echo '<table id="myTable" class="tablesorter table table-striped table-bordered table-condensed">';
						echo '<thead>';
							echo '<tr>';
								echo '<th style="cursor:pointer;">Id</th>';
								echo '<th style="cursor:pointer;">Apply to</th>';
								echo '<th style="cursor:pointer;">Commission type</th>';
								echo '<th style="cursor:pointer;">Amount</th>';
								echo '<th style="cursor:pointer;">Min value</th>';
								echo '<th style="cursor:pointer;">Max value</th>';
								echo '<th style="cursor:pointer;">Date</th>';
								echo '<th style="cursor:pointer;">Details</th>';
								echo '<th style="cursor:pointer;">Status</th>';
								echo '<th style="cursor:pointer;width:10%;">Action</th>';
							echo '</tr>';
							echo '<tbody>';
								foreach($getcommivalue as $key=>$user_det){
									$id=$user_det['id'];
									echo '<tr id="del_'.$id.'">';
										echo '<td class="invoiceId">'.$user_det['id'].'</td>';
										echo '<td class="invoiceNo">'.$user_det['applyto'].'</td>';
										echo '<td class="invoiceStatus">'.$user_det['type'].'</td>';
										if($user_det['Commission']['type'] == '%'){
										echo '<td class="invoiceStatus">'.$user_det['amount'].'%</td>';
										}else{
										echo '<td class="invoiceStatus">'.$_SESSION['currency_symbol'].$user_det['amount'].'</td>';
										}
										echo '<td class="invoiceStatus" style="word-break:break-all;">'.$user_det['min_value'].'</td>';
										echo '<td class="invoiceStatus" style="word-break:break-all;">'.$user_det['max_value'].'</td>';
										$day=date('m/d/Y',$user_det['cdate']);
										echo '<td class="invoiceDate">'.$day.'</td>';
										echo '<td class="invoiceNo" style=" width: 30%;word-break: break-all;">'.$user_det['commission_details'].'</td>';
										echo '<td>'; ?>
										<?php if($user_det['active']=='0'){ ?>
		  								<a  href="<?php echo $baseurl.'activatecommission/dact@'.$id;?> "><input type="button" class="btn btn-success" style="width:75px; font-size: 11px;"  value="Active" /></a>
		  								<?php }else{ ?>
		  								<a  href="<?php echo $baseurl.'activatecommission/act@'.$id;?> "><input type="button" class="btn btn-warning" style="width:75px; font-size: 11px;"  value="Activated" /></a>
										<?php } ?>
										<?php 	
											echo '<img class="inv-loader-'.$id.'" src="'.$baseurl.'images/loading.gif" style="display:none;"></td>';
										echo '<td>'; ?>
										<a  href="<?php echo $baseurl.'editcommission/'.$id;?> "><span class="btn btn-info"><i class="icon-edit" ></i></span></a>
										
										<?php echo '<a onclick = "deletecommision('.$id.');" role="button" data-toggle="modal" style="cursor:pointer;"><span class="btn btn-danger"><i class="icon-trash"></i></span></a>'; ?>
		  								<?php 	
											echo '<img class="inv-loader-'.$id.'" src="'.$baseurl.'images/loading.gif" style="display:none;"></td>';
									echo '</tr>';
								}
							echo '</tbody>';
						echo '</thead>';
					echo '</table>';
					
					echo '</div></div></div></div>'
					
			
			

?>
<div class="pagination pagination-centered">
<?= $this->Paginator->prev('« Previous') ?>
<?= $this->Paginator->numbers() ?>


<?= $this->Paginator->next('Next »') ?>

<?= $this->Paginator->counter() ?>
</div>
					</div>
				</div>
			
			</div>




   			
   			
</div>
   			
   	 
  </div>
</div>


