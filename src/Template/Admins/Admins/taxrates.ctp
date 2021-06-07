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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Tax Rates'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Tax Rates'); ?></a></li>
                      <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	addtax"><?php echo __d('admin', 'Add Tax'); ?></a></li>
                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Tax Rates'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
<div class="btn-toolbar">
<?php if(count($taxrates->toArray())==0){ ?>
    <a  href="<?php echo $baseurl.'addtax/'; ?>"><input type="button" class="btn btn-info" value="+ <?php echo __d('admin', 'Add Tax'); ?>"></a>
    <?php } ?>
    <!--button class="btn">Import</button>
    <button class="btn">Export</button-->

</div>


						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">


<body class="">





<?php





				echo "<div id='userdata'>";
					echo  '<div class="table-responsive m-t-0">';
					echo '<table id="taxratestable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
						echo '<th class="aligncenter">'.__d('admin', 'S.No').'</th>';
						echo '<th class="aligncenter">'.__d('admin', 'Country Name').'</th>';
						echo '<th class="aligncenter">'.__d('admin', 'Tax Name').'</th>';
						echo '<th class="aligncenter">'.__d('admin', 'Percentage (%) ').'</th>';
						echo '<th class="aligncenter">'.__d('admin', 'Status').'</th>';
						echo '<th class="aligncenter" data-orderable="false">'.__d('admin', 'Action').'</th>';
						echo '</thead>';
						echo '<tbody>';
						$i = 0;
						if(count($taxrates->toArray())!=0)
						{
							foreach($taxrates as $taxes)
							{
								$tax_id = $taxes['id'];
								$i++;
								echo '<tr id="del_'.$tax_id.'">';
								echo '<td class="aligncenter">'.$i.'</td>';
								echo '<td class="aligncenter">'.$taxes['countryname'].'</td>';
								echo '<td class="aligncenter">'.$taxes['taxname'].'</td>';
								echo '<td class="aligncenter">'.$taxes['percentage'].'</td>';
								echo '<td class="aligncenter">'.$taxes['status'].'</td>';
								echo '<td class="aligncenter">
								<a href="'.$baseurl.'edittax/'.$taxes['id'].'"><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="'.__d('admin', 'Edit').'"></a>
								<a href="#" onclick="deletetax('.$tax_id.')"><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="'.__d('admin', 'Delete').'"></a>
								</td>';
								echo '</tr>';
							}
						}
						else
						{

							echo '<tr><td colspan="6" align="center">'.__d('admin', 'No Taxes Found').'</td></tr>';
						}
						echo '</tbody>';
					echo '</table>';








		echo "</div>";
	echo "</div>";
	echo "</div></div>";?>
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
    $('#taxratestable').DataTable({
    "bInfo" : false,
        dom: '<"usertoolbar">frtip'
       
    });
     $("div.usertoolbar").html('<a  href="<?php echo $baseurl.'addtax/'; ?>" ><input type="button" class="btn btn-info" value="+ <?php echo __d('admin', 'Add Tax'); ?>"></a>');
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