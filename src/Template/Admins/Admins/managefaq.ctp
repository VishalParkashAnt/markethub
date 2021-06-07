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
  .namewrap
  {
    word-break:break-all;
  }
  </style>
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'FAQ'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'FAQ'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'FAQ'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">

<div class="btn-toolbar">
   <!-- <a  href="<?php echo $baseurl.'addfaq/'; ?>" ><input type="button" class="btn btn-info" value="+ Add FAQ"></a>-->
    <!--button class="btn">Import</button>
    <button class="btn"><?php echo __d('admin', 'Export'); ?></button-->

</div>
                                    <!--
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id='usersrchSrch' onkeyup='search_func()'placeholder="Search for...">
                                                    <span class="input-group-btn">
                          <button class="btn btn-info" type="button" onclick='search_func();'><?php echo __d('admin', 'Search'); ?></button>
                        </span>
                                                </div>
                                            </div>
                                        </div>-->



<?php echo "<div id='userdata'>";
  echo  '<div class="table-responsive m-t-0">';
                    echo '<table id="faqtable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
                        echo '<thead>';

							echo '<tr>';
								echo '<th class="aligncenter">'.__d('admin', 'Id').'</th>';
								echo '<th class="aligncenter">'.__d('admin', 'Question').'</th>';
								//echo '<th>Answer</th>';
								//echo '<th>Date</th>';
								echo '<th class="aligncenter" data-orderable="false">'.__d('admin', 'Action').'</th>';
							echo '</tr>';
							echo '<tbody>';
								foreach($getcolorval as $key=>$user_det){
									$id=$user_det['id'];
									echo '<tr id="del_'.$id.'">';
										echo '<td class="invoiceId aligncenter">'.$user_det['id'].'</td>';
										echo '<td class="invoiceNo aligncenter namewrap" width="60%">'.$user_det['faq_question'].'</td>';
										//echo '<td class="invoiceNo aligncenter">'.$user_det['Faq']['faq_answer'].'</td>';
										//$day=date('m/d/Y',$user_det['Color']['cdate']);
										//echo '<td class="invoiceDate aligncenter">'.$day.'</td>';
										echo '<td class="aligncenter">'; ?>
										<a href="<?php echo SITE_URL.'editfaq/'.$id;?> "><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="<?php echo __d('admin','Edit'); ?>"></a>
		  								<a onclick='deletefaq("<?php echo $id; ?>")'><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="<?php echo __d('admin','Delete'); ?>">

		  							<?php	//echo "    <span class='btn btn-danger' onclick='pricedelete(".$id.")'>Delete</span>";

									echo '</tr>';
								}
							echo '</tbody>';
						echo '</thead>';
					echo '</table>';







		echo "</div>";
	echo "</div>";
	echo "</div>";
?>

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
    $('#faqtable').DataTable({
    "bInfo" : false,
        dom: '<"usertoolbar">frtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
      $("div.usertoolbar").html('<a href="<?php echo $baseurl.'addfaq/'; ?>" ><input type="button" class="btn btn-info" value="+ <?php echo __d('admin','Add FAQ'); ?>"></a>');
    </script>



  </body>
</html>



