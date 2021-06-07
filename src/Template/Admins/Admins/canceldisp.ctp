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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Disputes'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Manage Disputes'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Cancel Disputes'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">


						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">


	 <?php
	echo "<div class='containerdiv'>";
	echo  '<div class="table-responsive m-t-0">';
					echo '  <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
			echo '<thead>';
				echo "<tr >";
					//echo "<th>".$this->Form->input('',array('type'=>'checkbox'))."</th>";

					echo "<th class='aligncenter' style='cursor:pointer;'>".__d("admin", "Order ID")."</th>";
					echo "<th class='aligncenter' style='cursor:pointer;'>".__d("admin", "User Name")."</th>";
					echo "<th class='aligncenter' style='cursor:pointer;'>".__d("admin", "Seller Name")."</th>";
					echo "<th class='aligncenter' style='cursor:pointer;'>".__d("admin", "Dispute Type")."</th>";
					echo "<th class='aligncenter' style='cursor:pointer;'>".__d("admin", "Problem")."</th>";
					echo "<th class='aligncenter' style='cursor:pointer;'>".__d("admin", "Current Status")."</th>";
					echo "<th class='aligncenter' style='cursor:pointer;'>".__d("admin", "Change Status")."</th>";
					echo "<th class='aligncenter' style='cursor:pointer;'>".__d("admin", "Dispute Status")."</th>";
					echo "<th class='aligncenter' style='cursor:pointer;min-width:105px!important;'>".__d("admin", "Action")."</th>";


				echo "</tr>";
				echo '<tbody>';
				if(count($order_data)!=0){
					foreach($order_data as $orders){



					$id = $orders['uorderid'];
					$disid = $orders['disid'];
					$uname = $orders['uname'];
					$sname = $orders['sname'];
					$pbm = $orders['uorderplm'];
					$newstatusup = $orders['newstatusup'];
					//if($newstatusup != 'Processing' && $newstatusup != 'Cancel' && $newstatusup != 'Closed' && $newstatusup != 'Resolved')
					//{
					echo "<tr id='scatgys".$disid."'>";
											echo "<td class='aligncenter'>".$id."</td>";?>

											<?php
											if(empty($uname))
												echo "<td class='aligncenter'>".__d("admin", "NA")."</td>";
											else
												echo "<td class='aligncenter'>".$uname."</td>";
											if(empty($sname))
												echo "<td class='aligncenter'>".__d("admin", "NA")."</td>";
											else
												echo "<td class='aligncenter'>".$sname."</td>";
											if($orders['orderitem'] == 'Item'){
												echo "<td class='aligncenter'>".__d("admin", "Product")."</td>";
											}else{echo "<td class='aligncenter'>".$orders['orderitem']."</td>";}
											echo "<td class='aligncenter' style='max-width:150px;word-wrap: break-word;'>".$pbm."</td>";

											echo "<td class='aligncenter'>";

												echo $orders['newstatusup'];


											echo "</td>";

											echo "<td class='aligncenter'>";

										?>
										<form name="search_form" id="search_form">

										<?php

											if($orders['_matchingData']['Orders']['status']== ''){
												$options = array('Pending' => __d('admin', 'Pending'), 'Processing' => __d('admin', 'Processing'),'Shipped' => __d('admin', 'Shipped'), 'Delivered' => __d('admin', 'Delivered'));
												echo $this->Form->input(''.$id.'', array( 'type' => 'select','label' => '' ,'class' =>'resolvestatus'.$id.'','onchange'=> "disputestatus('$id');",'options' => $options,'selected' => __d('admin', 'Pending'),'style' => 'width:98px ! important;'));
											}else{

											$selected= $orders['_matchingData']['Orders']['status'];
				                                $options = array('Pending' => __d('admin', 'Pending'), 'Processing' => __d('admin', 'Processing'),'Shipped' => __d('admin', 'Shipped'), 'Delivered' => __d('admin', 'Delivered'));
				                                echo $this->Form->input(''.$id.'', array( 'type' => 'select','label' => '' ,'class' =>'resolvestatus'.$id.'','onchange'=> "disputestatus('$id');",'options' => $options,'default' => $selected,'style' => 'width:98px ! important;'));
				                                //echo $ajax->submit('update', array('url'=>array('controller'=>'deals', 'action'=>'cart'), 'update' =>'shoppingcart'));
											}
				                              //  echo $this->Form->end(); ?>
				                              </form>
				                              <td class='aligncenter'><form name="searchdisp_form" id="searchdisp_form">
										<?php if($newstatusup == 'Processing'){?>
											<select id="<?php echo $disid;?>" name="data[<?php echo $disid;?>]" style="width:98px;margin: 0 0 2px;" class="statuscurrent<?php echo $disid;?>" onchange="disputestatuscurrent('<?php echo $disid; ?>')">
											<option value="<?php echo $newstatusup;?>"><?php echo $newstatusup;?></option>
											<option value="Closed"><?php echo __d('admin', 'Closed'); ?></option>

											</select>
										<?php }elseif($newstatusup == 'Closed'){?>
											<select id="<?php echo $disid;?>" name="data[<?php echo $disid;?>]" style="width:98px;margin: 0 0 2px;" class="statuscurrent<?php echo $disid;?>" onchange="disputestatuscurrent('<?php echo $disid; ?>')">
											<option value="<?php echo $newstatusup;?>"><?php echo $newstatusup;?></option>
											<option value="Processing"><?php echo __d('admin', 'Processing'); ?></option>
										<?php }else{?>
										<select id="<?php echo $disid;?>" name="data[<?php echo $disid;?>]" style="width:98px;margin: 0 0 2px;" class="statuscurrent<?php echo $disid;?>" onchange="disputestatuscurrent('<?php echo $disid; ?>')">
											<option value="<?php echo $newstatusup;?>" style="border-bottom: 1px dashed black;"><?php echo $newstatusup;?></option>
											<option value="Processing"><?php echo __d('admin', 'Processing'); ?></option>
											<option value="Closed"><?php echo __d('admin', 'Closed'); ?></option>
										<?php }?>
										    </form>  </td>
				                                <?php
										echo "</td>";

						echo "<td class='aligncenter' style='width: 100px !important;'>";
						echo '<a href="'.SITE_URL.'viewdisp/'.$disid.'"><span class="btn btn-success"><i class="mdi mdi-search-web"></i></span></a>';
						echo '<a onclick="deletedisp('.$disid.')"><span class="btn btn-danger"><i class="mdi mdi-delete"></i></span></a> ';

						echo "</td>";
											echo "</tr>";
					//}





			}
				}else{
						echo "<tr>";
					echo "<td style='margin:0px;height:70px;' colspan='9'>";
					echo "<div style='text-align: center;'>";
				    echo __d('admin', 'No Disputes Found'); 
					echo "</div>";
						echo "</td>";
					echo "</tr>";
				}
				echo '</tbody>';
			echo '</thead>';
		echo '</table>';







	echo "</div>";
?>

					</div>

				<?php //}?>






				</div><!--/span-->

			</div><!--/row-->
						<!-----Dispute Management------->


</div>
</div>




<script type="text/javascript">
function disputestatuscurrent(disid){
	//alert(disid);

	if (confirm(<?php echo __d("admin", "Are you sure you want to Change this Dispute?" ); ?>)) {
	var BaseURL=getBaseURL();
	var selector = '.statuscurrent'+disid;
	var status = '.status'+disid;
	var statuscurrent = $(selector).val();
	//var uoid = $('#uoid :selected').val();
	//var status = $(select).val();
	//alert(selector);
	//alert(status);
	//alert(statuscurrent);
	$(status).html(statuscurrent);

<style type="text/css">




    .feedsandtrentss > .active > a, .feedsandtrentss > .active > a:hover {
    background-color: #36A9E1;
    cursor: default;


}
    .myfeedsse{
	   float: left;
	   margin: 5px 10px 0 -26px;
}
.myfeedsse a {
    border: medium none;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    color: #393D4D !important;
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
    margin: 0 10px -2px 12px;
    padding: 0 13px 5px 11px;
    text-align: center;
    text-decoration: none;
    text-transform: none;
}
.myfeedsse a:hover{
	background-color: #36A9E1;
}
form{
margin : 0;
}

</style>
  <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    <script>
var invajax=0;
</script>
 <?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
  <?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>
  <script>
 jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });</script>
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




