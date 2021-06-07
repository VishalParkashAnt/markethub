<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Contact Seller Subjects'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Contact Seller Subjects'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Contact Seller Subjects'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">

<div class="btn-toolbar">
    <?php if(empty($subject_data)){ ?>

              <a href="<?php echo $baseurl.'addsubject/'; ?>" ><input type="button" class="btn btn-info" value="+ <?php echo __d('admin','Add Subject'); ?>"></a>

  <?php  } ?>
    <!--button class="btn">Import</button>
    <button class="btn">Export</button-->

</div>
                                    <!--
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id='usersrchSrch' onkeyup='search_func()'placeholder="<?php echo __d('admin', 'Search for...'); ?>">
                                                    <span class="input-group-btn">
                          <button class="btn btn-info" type="button" onclick='search_func();'><?php echo __d('admin', 'Search'); ?></button>
                        </span>
                                                </div>
                                            </div>
                                        </div>-->



<?php echo "<div id='userdata'>";
  echo  '<div class="table-responsive m-t-0">';
                    echo '<table id="contactsubjecttable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
                        echo '<thead>';

				echo "<tr>";

					echo "<th>".__d("admin", "Subject")."</th>";
					echo "<th data-orderable='false'>".__d("admin", "Actions")."</th>";
				echo "</tr>";
				echo '<tbody>';
				if(!empty($subject_data)){
					$subjects = json_decode($subject_data['queries'], true);
					foreach($subjects as $key=>$subject){
						echo "<tr id='subject".$key."'>";
							//echo "<td>".$this->Form->input('',array('type'=>'checkbox'))."</td>";
							echo "<td style='max-width: 600px;overflow: hidden;text-overflow: ellipsis;word-break:break-all;'>".$subject."</td>";

							echo "<td>
							<a href='".SITE_URL."addsubject/".$key."' title='Edit'><input type='button' class='btn btn-rounded btn-outline-info' style='width:auto; font-size: 11px;'' value='".__d("admin", "Edit")."'></a>
							<a onclick='return confirm(\"Are You Sure Delete This Text?\");' href='".SITE_URL."deletesubject/".$key."' title='Delete'><input type='button' class='btn btn-rounded btn-outline-danger' style='width:auto; font-size: 11px;'' value='".__d("admin", "Delete")."'></a></a>
							</td>";
						echo "</tr>";
					}
				}else{
					echo "<tr>";
						echo __d("admin", "No record Found");
					echo "</tr>";
				}
				echo '</tbody>';
			echo '</thead>';
		echo '</table>';







	echo "</div>";
?>
   			</div>
				</div><!--/span-->

			</div><!--/row-->
   	 </div>

  </div>

</div>
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
    $('#contactsubjecttable').DataTable({
        "bInfo" : false,
      dom: '<"usertoolbar">frtip'
    });
      $("div.usertoolbar").html('<a href="<?php echo $baseurl.'addsubject/'; ?>" ><input type="button" class="btn btn-info" value="+ <?php echo __d('admin','Add Subject'); ?>"></a>');
    </script>

