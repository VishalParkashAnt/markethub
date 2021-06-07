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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Seller Chat'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Message Lists'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Message Lists'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">   
                              

                                 



<?php 
  echo  '<div class="table-responsive m-t-0">';
                    echo '<table id="contacteditemtable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
                        echo '<thead>';
                        
				
				echo "<tr>";
                    
                    echo "<th class='aligncenter'>".__d("admin", "Id")."</th>";                 
                    echo "<th class='aligncenter'>".__d("admin", "Item Name")."</th>";
                    echo "<th class='aligncenter'>".__d("admin", "Seller Name")."</th>";
                    echo "<th class='aligncenter' data-orderable='false'>".__d("admin", "Chats")."</th>";
                    echo "<th class='aligncenter' data-orderable='false'>".__d("admin", "Action")."</th>";
                echo "</tr>";
                echo '<tbody>';
                if(!empty($item_datas)){
                    foreach($item_datas as $key=>$temp){
                        $csid = $temp['id'];
                        $item_id = $temp['itemid'];
                        
                        $itemid = base64_encode($item_id."_".rand(1,9999));
                        $itemName = $temp['itemname'];
                        $userName = $temp['sellername'];
                        if(empty($userName))
                            $userName = "NA";
                        else
                            $userName = $temp['sellername'];
                        $chatCount = $temp['count_itemid'];
                        echo "<tr id='cs".$csid."'>";
                            echo "<td class='aligncenter'>".$csid."</td>";
                            echo '<td class="aligncenter" style="word-break:break-all;width:50%;"><a href="'.$baseurl.'adminitemview/'.$itemid.'" title="View Item" target="_blank">'.$itemName.'</a></td>';
                            echo "<td class='aligncenter'>".$userName."</td>";
                            echo "<td class='aligncenter'>".$chatCount." Chat(s)</td>";
                            echo '<td class="aligncenter">
                            <a href="'.SITE_URL.'itemconversation/'.$item_id.'" style="cursor:pointer;"><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="'.__d('admin', 'Users List').'"></a>
                            </td>';
                        echo "</tr>";
                    }
                }else{
                    echo "<tr><td colspan='10' align='center'>";
                        echo __d("admin", "No record Found");
                    echo "</td></tr>";
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
    $('#contacteditemtable').DataTable({
        "bInfo" : false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>

