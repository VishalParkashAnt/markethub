<body class=""> 
  <!--<![endif]-->
  
    <?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>
 <style type="text/css">
   .table td, .table th
   {
     padding:0.75rem 0.15rem;
   }
    .namewrap
    {
        word-break: break-all;
    }
    .aligncenter
    {
       text-align:center;
    }
    .viewitem
    {
    padding-right:5px;
    }
</style>  
       
    
<div class="content">
 	<div class="row page-titles">
        <div class="col-md-6 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Products'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item"><a href="#"><?php echo __d('admin', 'Manage Shared Items'); ?></a></li>
                     
                 </ol>
         </div>
    </div>
</div>

<div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Manage Shared Items'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">                    

	
						<div class="row-fluid">		
				<div class="box span12">

					<div class="box-content">


					
						
				
				
  <label  style="display: inline;margin-right: 10px;"><?php echo __d('admin', 'Search by Date:'); ?></label>
  <div class="form-group row">
  <div class="col-md-3">
<input type="text" class="form-control mydatepicker" name="startDate" placeholder="<?php echo __d('admin', 'Start Date'); ?>"  id="deal-start"/>
</div><div class="col-md-3">
<input type="text" class="form-control mydatepicker" name="endDate" placeholder="<?php echo __d('admin', 'End Date'); ?>"   id="deal-end"/>
</div><div class="col-md-3">
<input type="button" id="srchAffiliate" name="submit" value="<?php echo __d('admin', 'Search'); ?>" class="btn btn-info" style="margin: 0px 10px 10px; border-radius: inherit;vertical-align:inherit;" onclick="return srchAffiliate(); " />
</div><div class="col-md-3">
<?php //echo $this->Html->link('Download all data(csv)',array('controller'=>'admins','action'=>'download'), array('target'=>'_blank','style'=>'font-size: 14px;')); ?>
<?php
if($demo_active!="yes")
{
?>
<input type="button" value="<?php echo __d('admin', 'Delete Selected'); ?>" class="btn btn-info" onclick="delete_affiliate()" >
<?php
}
?>

<span id="delerr" style="float:right;margin-right:120px;font-size:13px;color:red;font-weight:bold;"></span>
</div></div>
  
  
  

<?php		
echo "<div id='searchite'>";
echo  '<div class="table-responsive m-t-0">';
					echo '<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
						echo '<thead>';
				echo "<tr>";
					//echo "<th class='aligncenter'>".$this->Form->input('',array('type'=>'checkbox'))."</th>";
					echo '<th class="aligncenter">'.__d('admin', 'Select').'</th>';
					echo "<th class='aligncenter'>".__d("admin", "Id")."</th>";					
					echo "<th class='aligncenter'>".__d("admin", "Item title")."</th>";
					//echo "<th class='aligncenter'>".__d("admin", "Item description")."</th>";
					//echo "<th class='aligncenter'>".__d("admin", "Recipient")."</th>";
					
					
					
					//echo "<th>".__d("admin", "Occasion")."</th>";
					echo "<th class='aligncenter'>".__d("admin", "Price")."</th>";
					//echo "<th>".__d("admin", "Quantity")."</th>";
					echo "<th class='aligncenter'>".__d("admin", "Created")."</th>";
					echo "<th class='aligncenter'>".__d("admin", "Item url")."</th>";
					echo "<th class='aligncenter' data-orderable='false'>".__d("admin", "Action")."</th>";
				echo "</tr>";
				echo '<tbody>';
				if(!empty($item_datas)){
					foreach($item_datas as $key=>$temp){
					
						$item_id = $temp['id'];
						$item_title = $temp['item_title'];
						$item_description = $temp['item_description'];
						//$recipient = $temp['Item']['recipient'];
						$recipient = $temp['id'];
						$occasion = $temp['occasion'];
						$price = $temp['price'];
						$redirect = $temp['bm_redircturl'];
						echo "<tr id='item".$item_id."'>";
							//echo "<td>".$this->Form->input('',array('type'=>'checkbox'))."</td>";
							//echo "<td class='aligncenter'>".$this->Html->link($Item_name,array('controller'=>'/','action'=>'/admin/edit/category/'.$secid.'~'.$category_urlname))."</td>";

                          //echo '<td><input type="checkbox" value="'.$id.'" name="user'.$id.'" class="inactiveuser"/></td>';
							echo '<td class="aligncenter"><input type="checkbox" id="'.$item_id.'" value="'.$item_id.'" name="items'.$item_id.'" class="shareditem"></td>';
							echo "<td class='aligncenter'>".$item_id."</td>";
							echo "<td class='aligncenter' style='max-width: 150px;word-break: break-all;text-overflow: ellipsis;'>".$item_title."</td>";
							//echo "<td class='aligncenter' style='width: 40%;word-break: break-all;'>".$item_description."</td>";
							//echo "<td class='aligncenter'>".$recipient."</td>";
							//echo "<td>".$occasion."</td>";
							echo "<td class='aligncenter'>".$price."</td>";
							//echo "<td class='aligncenter'>".$quantity."</td>";
							
							echo "<td class='aligncenter'>".date("m/d/Y",strtotime($temp['created_on']))."</td>";

							echo "<td class='aligncenter' style='width: 200px;word-break: break-all;'><a style='color:#333333;' href='".$redirect."' target='_blank'>".$redirect."</td>";
							
							echo '<td class="aligncenter" style="width:250px !important;">
									<a class="viewitem" href="'.SITE_URL.'adminitemview/'.$item_id.'" target="_blank"><input type="button" class="btn btn-rounded btn-outline-success" style="width:auto; font-size: 11px;" value="'.__d('admin', 'View').'"></a>';
									
      								if($demo_active!="yes")
      			 					echo '<a onclick = "deleteItem('.$item_id.');" role="button" data-toggle="modal" style="cursor:pointer;"><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="'.__d('admin', 'Delete').'"></a>';
      			 					echo '</td>';
						echo "</tr>";
					}
				}else{
					echo "<tr><td colspan='8' align='center'>";
					echo __d('admin', 'No record Found');
					echo "</td></tr>";
				}
				echo '</tbody>';
			echo '</thead>';
		echo '</table>';
		
	
	
		
		
	echo "</div>";
		
	echo "</div>";
?>
     </div></div></div>
    
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


   			
   			
