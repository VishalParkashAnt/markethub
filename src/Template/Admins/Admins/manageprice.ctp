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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Prices'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Manage Prices'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Manage Prices'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">

<div class="btn-toolbar">
   <!-- <a  href="<?php echo $baseurl.'addprice/'; ?>" ><input type="button" class="btn btn-info" value="+ Add Price"></a>-->

</div>


<?php echo "<div id='userdata'>";
  echo  '<div class="table-responsive m-t-0">';
                    echo '<table id="managepricetable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
                        echo '<thead>';

							echo '<tr>';
								echo '<th class="aligncenter">'.__d('admin', 'S.No').'</th>';
								echo '<th class="aligncenter">'.__d('admin', 'Price Range').'</th>';
								echo '<th class="aligncenter">'.__d('admin', 'Date').'</th>';
								echo '<th class="aligncenter" data-orderable="false">'.__d('admin', 'Date').'</th>';
							echo '</tr>';
							echo '<tbody>';
							$i = 0;
							if(!empty($getpriceval))
							{
								foreach($getpriceval as $key=>$user_det){
									$i++;
									$id=$user_det['id'];
									echo '<tr id="del_'.$id.'">';
									echo '<td class="aligncenter">'.$id.'</td>';
										//echo '<td class="aligncenter">'.$user_det['Price']['id'].'</td>';
										echo '<td class="aligncenter">'.$default_currency_symbol.
												$user_det['from']. ' - '.$default_currency_symbol.
												$user_det['to'].'</td>';
										$day=date('m/d/Y',$user_det['cdate']);
										echo '<td class="aligncenter">'.$day.'</td>';
										echo '<td class="aligncenter">'; ?>
										<a href="<?php echo SITE_URL.'editprice/'.$id;?> "><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="<?php echo __d('admin','Edit'); ?>"></a>
		  								<a href="#" onclick='pricedelete("<?php echo $id; ?>")'><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="<?php echo __d('admin','Delete'); ?>"></a>

		  							<?php	//echo "    <span class='btn btn-danger' onclick='pricedelete(".$id.")'>Delete</span>";

									echo '</tr>';
								}
							}
							else
							{
								echo '<tr><td colspan="6" align="center">'.__d('admin', 'No records found').'</td></tr>';
							}
							echo '</tbody>';
						echo '</thead>';
					echo '</table>';




	echo "</div>";
	echo "</div>";
?>

   	 </div>

  </div>

</div>
	 </div>

  </div>

</div>
	 </div>

  </div>

</div>
 <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>

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
    $('#managepricetable').DataTable({
     "bInfo" : false,
       // dom: 'Bfrtip',
        dom: '<"usertoolbar">frtip',
         "order": [
                    [2, 'desc']
                ]
    });
      $("div.usertoolbar").html('<a href="<?php echo $baseurl.'addprice/'; ?>" ><input type="button" class="btn btn-info" value="+ <?php echo __d('admin','Add Price'); ?>"></a>');

    </script>



  </body>
</html>


