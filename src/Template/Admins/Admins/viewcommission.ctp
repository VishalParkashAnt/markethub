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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Commission'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Commission'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Commission'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
   <?php 

   echo "<div class='containerdiv'>";
    echo $this->Form->Create('Sitesetting',array('url'=>array('controller'=>'/admins','action'=>'/viewcommission'),'id'=>'siteform','onsubmit'=>'return validate_commission();'));
    
    echo '<label>'.__d('admin', 'Default commission Percentage').' </label>';

    echo $this->Form->input('credit_percentage',array('type'=>'text','label'=>false,'id'=>'credit_percentage','class'=>'form-control col-md-6','value'=>$site_datas['credit_percentage'],'maxlength'=>'2',$readonly));

    echo '<span style="color:red;font-size: 0.9em;padding-top: 10px;">'.__d('admin', 'note: If Commission disabled means default percentage calculate from each order').' </span><br>';

    echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));

    echo $this->Form->end();
    echo '</div><br>';

   ?>

</div>
<style>
.submit{
  padding-top:10px;
}
</style>
<!--div id="alertmsg" class="successmsg"></div-->


                              <div id="userdata">
                                <div class="table-responsive m-t-0">
                                    <table id="commissiontable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                              <!--  <th><?php echo __d('admin', 'Apply To'); ?></th>
                                                <th class="aligncenter"><?php echo __d('admin', 'Commission Type'); ?></th>-->
                                                <th class="aligncenter"><?php echo __d('admin', 'Amount (%)'); ?></th>
                                                <th class="aligncenter"><?php echo __d('admin', 'Min Value'); ?></th>
                                                <th class="aligncenter"><?php echo __d('admin', 'Max value'); ?></th>
                                                 <th class="aligncenter"><?php echo __d('admin', 'Date'); ?></th>
                                                  <th class="aligncenter"><?php echo __d('admin', 'Details'); ?></th>
                                                   <th class="aligncenter"><?php echo __d('admin', 'Status'); ?></th>
                                                    <th class="aligncenter" data-orderable="false"><?php echo __d('admin', 'Action'); ?></th>
                                            </tr>
                                        </thead>


						<?php

							echo '<tbody>';
             // if(count($getcommivalue->toArray())!=0){
								foreach($getcommivalue as $key=>$user_det){
									$id=$user_det['id'];
									echo '<tr id="del_'.$id.'">';
										echo '<td class="invoiceId aligncenter">'.$user_det['id'].'</td>';
										/*echo '<td class="invoiceNo aligncenter">'.$user_det['applyto'].'</td>';
										echo '<td class="invoiceStatus aligncenter">'.$user_det['type'].'</td>';
										if($user_det['Commission']['type'] == '%'){
										echo '<td class="invoiceStatus aligncenter">'.$user_det['amount'].'%</td>';
										}else{
										echo '<td class="invoiceStatus aligncenter">'.$_SESSION['currency_symbol'].$user_det['amount'].'</td>';
										}*/
                                        echo '<td class="invoiceStatus aligncenter">'.$user_det['amount'].'</td>';
										echo '<td class="invoiceStatus aligncenter" style="word-break:break-all;">'.$user_det['min_value'].'</td>';
										echo '<td class="invoiceStatus aligncenter" style="word-break:break-all;">'.$user_det['max_value'].'</td>';
										$day=date('m/d/Y',$user_det['cdate']);
										echo '<td class="invoiceDate aligncenter">'.$day.'</td>';
										echo '<td class="invoiceNo aligncenter" style=" width: 30%;word-break: break-all;">'.$user_det['commission_details'].'</td>';
										echo '<td class="aligncenter">'; ?>
										<?php if($user_det['active']=='0'){ ?>
		  								<a  href="<?php echo $baseurl.'activatecommission/dact@'.$id;?> "><input type="button" class="btn btn-rounded btn-outline-success" style="font-size: 11px;"  value="<?php echo __d('admin', 'Active'); ?>" /></a>
		  								<?php }else{ ?>
		  								<a  href="<?php echo $baseurl.'activatecommission/act@'.$id;?> "><input type="button" class="btn btn-rounded btn-outline-warning" style="font-size: 11px;"  value="<?php echo __d('admin', 'Activated'); ?>" /></a>
										<?php } ?>
										<?php
											echo '<img class="inv-loader-'.$id.'" src="'.$baseurl.'images/loading.gif" style="display:none;"></td>';
										echo '<td class="aligncenter" width="20%">'; ?>
										<a  href="<?php echo $baseurl.'editcommission/'.$id;?> "><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="<?php echo __d('admin', 'Edit'); ?>"></a>

										<?php echo '<a onclick = "deletecommision('.$id.');" role="button" data-toggle="modal" style="cursor:pointer;"><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="'.__d('admin', 'Delete').'"></a>'; ?>
		  								<?php
											echo '<img class="inv-loader-'.$id.'" src="'.$baseurl.'images/loading.gif" style="display:none;"></td>';
									echo '</tr>';
								}
             //   }
              //  else
                //{
               // echo '<tr><td colspan="11" align="center">'.__d('admin', 'No Commission Found').'</td></tr>';
                //}
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
    $('#commissiontable').DataTable({
          "bInfo" : false,
          dom: '<"usertoolbar">frtip',
         "order": [
                    [0, 'desc']
                ]
    });

     $("div.usertoolbar").html('<a  href="<?php echo $baseurl.'admin/commission/'; ?>" ><input type="button" class="btn btn-info" value="+ <?php echo __d('admin', 'Add Commission'); ?>"></a>');
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


