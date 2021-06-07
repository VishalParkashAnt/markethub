<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/',true);
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Group Gifts'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Manage Group Gifts'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Manage Group Gifts'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">



<body class="">




					<div class="table-responsive m-t-0">
					<table id="groupgiftstable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?php echo __d('admin','Name');?></th>
						<th><?php echo __d('admin','Contribution');?></th>
						<th><?php echo __d('admin','Start date');?></th>
						<th><?php echo __d('admin','End date');?></th>
						<th data-orderable="false"><?php echo __d('admin','Status');?></th>
						<th data-orderable="false"><?php echo __d('admin','Action');?></th>
					</tr>
				</thead>
				<tbody>
				<?php //print_r($shippingModel);

					if(count($gglistsData->toArray())!=0){
					foreach ($gglistsData as $ggdata) {

					$ggid = $ggdata['id'];
					$fullname = $ggdata['name'];
					$address1 = $ggdata['address1'];
					$address2 = $ggdata['address2'];
					$city = $ggdata['city'];
					$state = $ggdata['state'];
					$country = $ggdata['country'];
					$zip = $ggdata['zipcode'];
					$datefirst = $ggdata['c_date'];
					$datelast = $ggdata['c_date'] + 3600;
					//$fday=date("F j, Y, g:i a",$datefirst);
					//$lday=date("F j, Y, g:i a",$datelast);
					$fday=date("F j, Y",$datefirst);
					$lday=date("F j, Y",$datelast);
					$statuss = $ggdata['status'];
					$amount = $ggdata['total_amt'];
					$balance_amt = $ggdata['balance_amt'];
					if(empty($fullname))
					{
						$fullname = "N/A";
					}

					?>
					<tr class="shipping<?php echo $ggid; ?>">
						<td><b><?php echo wordwrap($fullname,25,"<br>\n",TRUE); ?></b></td>
						<td><?php //echo $statuss;
						foreach ($currencydata as $currencydatas) {
							if($currencydatas['id']==$ggdata['_matchingData']['Items']['currencyid'])
							{
								$currency_symbol=$currencydatas['currency_symbol'];
							}
						}
						echo $currency_symbol.($amount-$balance_amt).'/ '.$currency_symbol.$amount;
						?></td>
						<!-- td><?php echo $fullname."<br>".$address1."<br>".$city." ".$state." ".$zip."<br>".$country; ?></td-->
						<td><?php echo $fday; ?></td>
						<td><?php echo $lday; ?></td>
						<td><?php if($statuss !='Active' && $statuss !='Completed'){ ?>
						<?php echo "<span style='color:#009900'>"?><?php echo __('Refunded');echo "</span>"; ?>
						<?php }elseif($statuss == 'Completed'){
							echo '<span style="color:#0f0">'.__d('admin','Completed');echo "</span>";
						}elseif($datelast < time()){
							echo '<span style="color:#f00">'.__d('admin','Expired');echo "</span>";
						}elseif($statuss == 'Active'){
							echo "<span style='color:#3333df'>". __d('admin','Active');echo "</span>";
						}
							?></td>
						<?php
						echo '<td><a href="'.SITE_URL.'giftdetail/'.$ggid.'/'.$currency_symbol.'"><input type="button" class="btn btn-rounded btn-outline-success" style="width:auto; font-size: 11px;" value="'.__d('admin','View').'"></a></td>';
						?>

					</tr>
				<?php }
					}else{
				echo "<tr><td colspan='10' align='center'>";
                echo __d('admin', 'No Groupgift Found');
				echo "</td></tr>";
				} ?>
				</tbody>
				</table>



    </div>
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
    $('#groupgiftstable').DataTable({
        "bInfo" : false,
        dom: '<"usertoolbar">frtip',
         "order": [
                  //  [2, 'desc']
                ]
    });
    </script>




  </body>
</html>
