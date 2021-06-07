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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Users'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Users'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-12 p-0">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Inactive Users'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                    <div class="row">


</div>
  <input type='hidden' value='<?php echo $pagecount; ?>' class='inactivecnt' />
<?php 
echo '<div class="btn-toolbar">
     <!--button class="btn btn-info" onclick="deleteinactiveusers()">'.__d('admin', 'Delete All').'</button-->
    <!--button class="btn">Import</button>
    <button class="btn">Export</button-->

</div>';
   echo  '<div class="table-responsive m-t-0">';
                    echo '<table id="inactiveuserstable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
                        echo '<thead>';
                        ?>


        <?php
        echo '<tr>';
            echo '<th class="aligncenter">#</th>';
            echo '<th class="aligncenter">'.__d('admin', 'User Name').'</th>';
            //echo '<th class="aligncenter">City</th>';
            echo '<th class="aligncenter">'.__d('admin', 'Email').'</th>';
            echo '<th class="aligncenter">'.__d('admin', 'Registered On').'</th>';
            echo '<th class="aligncenter" data-orderable="false">'.__d('admin', 'Status').'</th>';
            echo '<th class="aligncenter" data-orderable="false">'.__d('admin', 'Action').'</th>';
        echo '</tr>';
        ?>

      </thead>
      <tbody>
      <?php if(count($userdet)!=0){
            foreach($userdet as $user_det){
                $id=$user_det['id'];
               echo '<tr id="del_'.$id.'">';
                    echo '<td class="aligncenter"><input type="checkbox" value="'.$id.'" name="user'.$id.'" class="inactiveuser"/></td>';

                    echo '<td class="aligncenter">'.$user_det['username'].'</td>';

                    echo '<td class="aligncenter">'.$user_det['email'].'</td>';
                    $day=date('m/d/Y',strtotime($user_det['created_at']));
                    echo '<td class="aligncenter">'.$day.'</td>';
                    echo '<td class="aligncenter" id="status'.$id.'">';
                    if ($user_det['user_status'] == 'enable') {
                        echo '<button class="btn btn-rounded btn-outline-warning" style="font-size: 11px;" onclick="changeUserStatus('.$id.',\''.$user_det['user_status'].'\',\''.$user_det['user_level'].'\')">'.__d('admin', 'Disable').'</button></td>';
                    } else {
                        echo '<button class="btn btn-rounded btn-outline-success" style="font-size: 11px;" onclick="changeUserStatus('.$id.',\''.$user_det['user_status'].'\',\''.$user_det['user_level'].'\')">'.__d('admin', 'Enable').'</button></td>';
                    }
                    echo '<td class="aligncenter">
                    <a href="'.$baseurl.'edituser/'.$id.'"><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="'.__d('admin', 'Edit').'"></a>';
                    if($demo_active!='yes')
                    echo '<a onclick="deleteusrlists('.$id.',\'inactiveuser\')"><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="'.__d('admin', 'Delete').'"></a>';
                    echo '</td>';
                echo '</tr>';
            }
            }else{
                echo "<tr><td colspan='10' align='center'>";
                echo __d('admin', 'No Users Found'); 
                echo "</td></tr>";
            }
        ?>






 </tbody>
   </table>


            <button class="btn btn-info" style="margin-top:1.5%" onclick="deleteinactiveselected()">
                <?php echo __d('admin', 'Delete Selected'); ?>

            </button><div style="float:bottom;color:red;font-size:14px;display:none;" id="delerr"><?php echo __d('admin', 'Select Users to delete'); ?></div>



    </div></div></div>    </div>
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
    $('#inactiveuserstable').DataTable({
        "bInfo" : false,
       dom: '<"usertoolbar">frtip',
        "order": [
                    [0, 'desc']
                ]
    });
     $("div.usertoolbar").html('<input type="button" onclick="deleteinactiveusers()" class="btn btn-info" value="+ <?php echo __d('admin','Delete All'); ?>">');
    </script>

  </body>
</html>




