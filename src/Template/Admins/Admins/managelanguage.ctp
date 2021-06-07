<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Languages'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Languages'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Languages'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">

<div class="btn-toolbar">
  <!--  <a  href="<?php echo $baseurl.'addlanguage/'; ?>" ><input type="button" class="btn btn-info" value="+ Add Language"></a>-->
    <!--button class="btn">Import</button>
    <button class="btn"><?php echo __d('admin', 'Export'); ?></button-->

</div>
                                    <!--
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id='usersrchSrch' onkeyup='search_func()'placeholder="Search for...">
                                                    <span class="input-group-btn">
                          <button class="btn btn-info" type="button" onclick='search_func();'>?php echo __d('admin', 'Search'); ?></button>
                        </span>
                                                </div>
                                            </div>
                                        </div>-->



<?php echo "<div id='userdata'>";
  echo  '<div class="table-responsive m-t-0">';
                    echo '<table id="managelanguagetable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
                        echo '<thead>';

							echo '<tr>';
								echo '<th>'.__d('admin', 'Id').'</th>';
								echo '<th>'.__d('admin', 'Country Name').'</th>';
								echo '<th>'.__d('admin', 'Currency Code').'</th>';
								echo '<th>'.__d('admin', 'Language Code').'</th>';
								echo '<th>'.__d('admin', 'Language Name').'</th>';
								echo '<th data-orderable="false">'.__d('admin', 'Action').'</th>';
							echo '</tr>';
							echo '<tbody>';
							$i = 1;
								foreach($language_datas as $key=>$language){
									$id=$language['id'];
									$countrycode = $language['countrycode'];
									echo '<tr id="del_'.$id.'">';
								        echo '<th>'.$id.'</td>';
										echo '<td class="invoiceId">'.$language['_matchingData']['Countries']['country'].'</td>';
										echo '<td class="invoiceNo">'.$language['countrycode'].'</td>';
										echo '<td class="invoiceNo">'.$language['languagecode'].'</td>';
										echo '<td class="invoiceNo">'.$language['languagename'].'</td>';?>
										<td>
											<?php
											if(in_array($countrycode,$shop_currency_code))
											{
											?>
		  								<a href="#" onclick='deletelanguage("<?php echo $id; ?>")'><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="<?php echo __d('admin','Delete'); ?>"></span></a>
										<?php
											}
											else
											{
											?>
											<a href="#" onclick='deletelanguage("<?php echo $id; ?>")'><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="<?php echo __d('admin','Delete'); ?>"></a>
											<?php
											}
											?>
		  								</td>

		  							<?php	//echo "    <span class='btn btn-danger' onclick='pricedelete(".$id.")'>Delete</span>";

									echo '</tr>';
									$i++;
								}
							echo '</tbody>';
						echo '</thead>';
					echo '</table>';



			echo '<div id="paypalfom"></div>';





		echo "</div>";
	echo "</div>";
	echo "</div>";
?>

   	 </div>

  </div>

</div>

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
    $('#managelanguagetable').DataTable({
    "bInfo" : false,
        dom: '<"usertoolbar">frtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
     $("div.usertoolbar").html('<a href="<?php echo $baseurl.'addlanguage/'; ?>" ><input type="button" class="btn btn-info" value="+ <?php echo __d('admin','Add Language'); ?>"></a>');
    </script>


  </body>
</html>


