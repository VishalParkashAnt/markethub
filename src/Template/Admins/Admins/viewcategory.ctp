<body class="">
  <!--<![endif]-->

    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>


<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Categories'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Category'); ?></a></li>

                 </ol>
         </div>
    </div>
</div>

<div class="">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Category'); ?></h4>
                 </div>
                 <div class="card-block ">
                    <div class="form-body">
<div class="btn-toolbar">
  <!--  <a  href="<?php echo $baseurl.'addcategory/'; ?>" ><input type="button" class="btn btn-info" value="+ Add Category"></a>-->
    <!--button class="btn">Import</button>
    <button class="btn">Export</button-->

</div>

						<div class="row-fluid">
				<div class="box span12">

					<div class="box-content">


<body class="">

<?php
	echo "<div class='containerdiv'>";

			echo "<div id='caterr' style='font-size:13px;color:red;padding:10px;text-align:center;display:block;' class='trn'></div>";
		echo  '<div class="table-responsive m-t-0">';
					echo '<table id="viewcategorytable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
				echo "<tr>";
					//echo "<th>".$this->Form->input('',array('type'=>'checkbox'))."</th>";
					echo "<th>".__d("admin", "Category Name")."</th>";
					echo "<th>".__d("admin", "Category Parent")."</th>";
					echo "<th>".__d("admin", "Category Sub Parent")."</th>";
					echo "<th>".__d("admin", "Created Date")."</th>";
					echo "<th>".__d("admin", "Mark as featured")."</th>";
					//echo "<th>".__d("admin", "Modification Date")."</th>";
					echo "<th data-orderable='false'>".__d("admin", "Delete Category")."</th>";
				echo "</tr>";
				echo '</thead>';
				echo '<tbody>';
				if(!empty($main_catdata)){
					foreach($main_catdata as $suprs){
						$mnscns[$suprs['id']] = $suprs['category_name'];
						$cat_urlnme[$suprs['id']] = $suprs['category_urlname'];
					}

					//echo "<pre>";print_r($super_sub_catdata);die;
					foreach($super_sub_catdata as $key=>$temp){
						$secid = $temp['id'];
						foreach($temp['Item'] as $temp_item)
						{
							$item_cat_id[] = $temp_item['category_id'];
						}
						foreach($temp['Item_created'] as $temp_item)
						{
							$item_supcat_id[] = $temp_item['super_catid'];
						}
						foreach($temp['Item_modified'] as $temp_item)
						{
							$item_sub_id[] = $temp_item['sub_catid'];
						}
						$sec_parent = $temp['category_parent'];
						$sub_sec_parent = $temp['category_sub_parent'];
						$category_name = $temp['category_name'];
						$category_urlname = $temp['category_urlname'];
						echo "<tr id='catgy".$secid."'>";
							//echo "<td>".$this->Form->input('',array('type'=>'checkbox'))."</td>";
							if(in_array($secid,$item_cat_id) || in_array($secid,$item_supcat_id) || in_array($secid,$item_subcat_id))
							{
							echo "<td>";
							echo '<input type="hidden" value="'.$secid.'" id="catid'.$secid.'">';
										echo '<a href="'. SITE_URL.'editcategory/'.$secid.'~'.$category_urlname.' ">'.$category_name.'</a>';

							//echo $this->Html->link($category_name,array('controller'=>'/','action'=>'edit123category/'.$secid.'~'.$category_urlname))."</td>";
							}
							else
							echo "<td>";
						echo '<input type="hidden" value="'.$secid.'" id="catid'.$secid.'">';
										echo '<a href="'. SITE_URL.'editcategory/'.$secid.'~'.$category_urlname.' ">'.$category_name.'</a></td>';
							if(!empty($mnscns[$sec_parent])){
								//echo "<td>".$mnscns[$sec_parent]."</td>";


								echo "<td>";
										echo '<a href="'. SITE_URL.'editcategory/'.$sec_parent.'~'.$cat_urlnme[$sec_parent].' ">'.$mnscns[$sec_parent].'</a></td>';
								//.$this->Html->link($mnscns[$sec_parent],array('controller'=>'/','action'=>'edit456category/'.$sec_parent.'~'.$cat_urlnme[$sec_parent]))."</td>";
							}else{
								echo "<td>-</td>";
							}
							if(!empty($mnscns[$sub_sec_parent])){
								//echo "<td>".$mnscns[$sub_sec_parent]."</td>";

									echo "<td>";
										echo '<a href="'. SITE_URL.'editcategory/'.$sub_sec_parent.'~'.$cat_urlnme[$sub_sec_parent].' ">'.$mnscns[$sub_sec_parent].'</a></td>';
								//echo "<td>".$this->Html->link($mnscns[$sub_sec_parent],array('controller'=>'/','action'=>'789editcategory/'.$sub_sec_parent.'~'.$cat_urlnme[$sub_sec_parent]))."</td>";
							}else{
								echo "<td>-</td>";
							}
							echo "<td>".date("m/d/Y",strtotime($temp['created_at']))."</td>";
							if(empty($mnscns[$sec_parent])){
								if ($temp['featured'] == 0){
                echo "<td class='aligncenter' style='text-align:center;'><input type='checkbox' name='featured' id='featured".$secid."' onchange='markfeaturecat(\"$secid\")' /></td>";
              }else{
                echo "<td class='aligncenter' style='text-align:center;'><input type='checkbox' name='featured' id='featured".$secid."' checked='checked' onchange='markfeaturecat(\"$secid\")' /></td>";
              }
          }
           else{
           	echo "<td style='text-align:center;'>-</td>";
           }
							//echo "<td>".date("m/d/Y",strtotime($temp['Category']['modified_at']))."</td>";

							echo "<td> <a id='linkid".$secid."' onclick='deleteCategory(".$secid.");'> <input type='button' class='btn btn-rounded btn-outline-danger' style='width:auto; font-size: 11px;'' value='".__d("admin", "Delete")."'></a>
							<div id='err".$secid."' style='font-size:13px;color:red;display:none;'>".__d("admin", "Can not delete this category")."</div>
							</td>";
						echo "</tr>";

					}
				}else{
					echo "<tr>";
						echo __d("admin", "No record Found");
					echo "</tr>";
				}
				echo '</tbody>';
		echo '</table>';
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
    /*$('#viewcategorytable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });*/

    $('#viewcategorytable').DataTable({
     "bInfo" : false,
        dom: '<"usertoolbar">frt<"catinfo">ip',
         "order": [
                    [3, 'desc']
                ]
    });
    $("div.usertoolbar").html('<a  href="<?php echo $baseurl.'addcategory/'; ?>" ><input type="button" class="btn btn-info" value="+ <?php echo __d('admin', 'Add Category'); ?>"></a>');
    $("div.catinfo").html('<?php echo __d('admin', '<b>Note : </b> The category cannot be deleted if there is one or more products added already to it'); ?>');
    </script>

</body>

</html>


					</div>
				</div>

			</div>

		</div>
				</div>

			</div>




