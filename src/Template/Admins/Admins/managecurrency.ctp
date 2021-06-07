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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Manage Currency'); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>	dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                     <li class="breadcrumb-item active"><?php echo __d('admin', 'Manage Currency'); ?></li>
                 </ol>
         </div>
    </div>
</div>
<div class="col-lg-25">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Manage Currency'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
		<?php
		echo "<div class='btn-toolbar'>";
		if(empty($getcurrencyval))
		{
		$currencyurl = SITE_URL.'adddefaultcurrency/';
		$currencytxt = 'Add Default Currency';
		$btncurrency = '<a href="'.SITE_URL.'adddefaultcurrency/" class="btn btn-info"><i class="icon-plus"></i> '.__d('admin','Add Default Currency').'</a>';
		}
		else
		{
		$currencyurl = SITE_URL.'addcurrency/';
		$currencytxt = 'Add Currency';
		$btncurrency ='<a href="'.SITE_URL.'addcurrency/" class="btn btn-info"><i class="icon-plus"></i> '.__d('admin','Add Currency').'</a>';
		}
		echo "</div>";
		?>

					<div class="box-content">


<?php //echo $this->Html->link('Download all data(csv)',array('controller'=>'admins','action'=>'download'), array('target'=>'_blank','style'=>'font-size: 14px;')); ?>

<div id="loading_img" style="display:none;text-align:center;">
<img src="<?php echo SITE_URL; ?>images/loading_blue.gif" alt="Loading...">
</div>



<?php

	 echo  '<div class="table-responsive m-t-0">';
                    echo '<table id="managecurrencytable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
                        echo '<thead>';
				echo "<tr>";
					//echo "<th>".$this->Form->input('',array('type'=>'checkbox'))."</th>";
					echo "<th class='aligncenter'>".__d("admin","Id")."</th>";
					echo "<th class='aligncenter'>".__d("admin","Currency Code")."</th>";
					echo "<th class='aligncenter'>".__d("admin","Currency Name")."</th>";
					//echo "<th>Recipient</th>";
					//echo "<th>Occasion</th>";
					echo "<th class='aligncenter'>".__d("admin","Currency Symbol")."</th>";
					echo "<th class='aligncenter'>".__d("admin","Rate (Equivalent ".$_SESSION['currency_symbol'].")")."</th>";
					//echo "<th>Created</th>";
					//echo "<th>Mark Featured</th>";
					echo "<th class='aligncenter' data-orderable='false'>".__d("admin","Status")."</th>";
					echo "<th class='aligncenter' data-orderable='false'>".__d("admin","Action")."</th>";
				echo "</tr>";
				echo '<tbody>';
				if(!empty($getcurrencyval)){
				$i = 1;
					foreach($getcurrencyval as $key=>$temp){
					if ($temp['cstatus'] == "enable") {
						$buttonLabel = "Disable";
						$color = "btn-warning";
					} else {
						$buttonLabel = "Enable";
						$color = "btn-success";
					}
						$id = $temp['id'];
						$currency_code = $temp['currency_code'];
						$currency_name = $temp['currency_name'];
						$currency_symbol = $temp['currency_symbol'];
						$price = $temp['price'];

						//echo $this->Form->Create('forexrate',array('url'=>array('controller'=>'/admins','action'=>'/editcurrency/'.$temp['id']),'id'=>'Categoryform'));

							echo '<tr id="del_'.$id.'">';
							echo "<td class='aligncenter'>".$i."</td>";
							echo "<td class='aligncenter'>".$currency_code."</td>";
							echo "<td class='aligncenter'>".$currency_name."</td>";

							echo "<td class='aligncenter'>".$currency_symbol."</td>";
							echo "<td class='aligncenter'>".$price."</td>";
							//echo "<td>".$price."</td>";

							$i++;
							/*if ($temp['cstatus'] != 'default' && $temp['cstatus']=='enable'){
								echo  '<td class="aligncenter">'.$this->Form->input(''.$temp['currency_code'].'',array('type'=>'text','class'=>'inputform'.$id.'','label' => '','onkeyup'=>'checknum(this)', 'value'=>$temp['price'])).'</td>';
							}else{
								echo  '<td class="aligncenter">'.$this->Form->input(''.$temp['currency_code'].'',array('type'=>'text','class'=>'inputform'.$id.'', 'disabled','label' => '', 'value'=>$temp['price'])).'</td>';
							}*/

			if($temp['cstatus'] == 'default')
			{
			$color = "btn-default";
			echo "<td class='aligncenter'> <span id='status".$id."'>";
			echo "<button class='btn btn-inverse' type='button' style='cursor:default;'>".__d("admin","Default")."</button>";
			echo "</span></td>";
			echo "<td>&nbsp</td>";

			}
			elseif ($temp['cstatus'] != 'default' && $temp['cstatus']=='enable') {
			echo "<td class='aligncenter'> <span id='status".$id."'>";
			echo "<button class='btn ".$color."' onclick='return changeCurrencyStatus(".$id.",\"".$temp['cstatus']."\")'>".__d('admin',$buttonLabel)."</button>";
			echo "</span></td>";
			 ?>


			<td class='aligncenter'><a href="<?php echo SITE_URL.'editcurrency/'.$id;?> "><input type="button" class="btn btn-rounded btn-outline-info" style="width:auto; font-size: 11px;" value="<?php echo __d('admin','Edit'); ?>"></a>
				</td>
				 <?php
			}
			else
			{
			echo "<td class='aligncenter'> <span id='status".$id."'>";
			echo "<button class='btn ".$color."' onclick='return changeCurrencyStatus(".$id.",\"".$temp['cstatus']."\")'>".__d('admin',$buttonLabel)."</button>";
			echo "</span></td>";
			echo '<td class="aligncenter" width="20%">
				 <a onclick = "deleteCurrency('.$id.');" role="button" data-toggle="modal" style="cursor:pointer;"><input type="button" class="btn btn-rounded btn-outline-danger" style="width:auto; font-size: 11px;" value="'.__d('admin','Delete').'"></a></td>';
			}


				echo "</tr>";
					}
				}else{
					echo "<tr>";
						echo __d('admin','No record Found');
					echo "</tr>";
				}
				echo '</tbody>';
			echo '</thead>';
		echo '</table>';
//echo "<button class='btn ".$color."'>Save</button>";

//echo $this->Form->submit(__d('admin',Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
echo $this->Form->end();







	echo "</div>";

	echo "</div>";
?>
     </div></div></div>

        </div>
    </div>
</div>
    <script type="text/javascript">
    function test()
    {
    	alert('f');
    }
    </script>


    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>

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
    $('#managecurrencytable').DataTable({
    	"bInfo" : false,
    	
        dom: '<"usertoolbar">frtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
     $("div.usertoolbar").html('<a href="<?php echo $currencyurl; ?>" class="btn btn-info"><i class="icon-plus"></i> <?php echo __d('admin',$currencytxt); ?></a>');
    </script>

  </body>
</html>


