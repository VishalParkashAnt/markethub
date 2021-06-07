<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
?>

    <!-- breadcrumb start -->
<div class="container-fluid margin-top10 no_hor_padding_mobile">
  <div class="container">
<div class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-bottom10">
     <div class="breadcrumb">
      <a href="<?php echo $baseurl;?>"><?php echo __d('user','Home');?></a>
      <span class="breadcrumb-divider1">/</span>
      <a href="#"><?php echo __d('user','Group Gift List');?></a>
     
     </div>
    </div>
     
  </div>
    </div>
    <!-- breadcrumb end -->
<section class="container-fluid side-collapse-container no_hor_padding_mobile margin_top165_mobile">
		<div class="container">
			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="create_gift">
						<h2 class="find_new_heading extra_text_hide">
							<?php echo __d('user','Start a Group Gift Today');?></h2>
						<p class="extra_text_hide margin-bottom0 margin-top5">
							<?php echo __d('user','Gather your friends and give amazing gifts to the people you love');?></p>

						<ul class="margin-top20">
						<li><a href="<?php echo $baseurl.'groupgifts/';?>"><?php echo __d('user','Create New Gift');?></a></li>
						<li class="active bold-font"><a href="<?php echo $baseurl.'group_gift_lists/';?>"><?php echo __d('user','Group Gift List');?></a></li>
						</ul>
				</div>
			</section>

			<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top10 no-hor-padding">
				<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 margin_bottom_mobile20">
					<div class="create_gift">
					<h4 class="bold-font padding-bottom15"><?php echo __d('user','Group Gift History');?></h4>
	<?php
	if (count($gglistdatas) > 0 ) {
		echo '<div class="table-responsive">

			<table class="table table-hover animate-box fadeInDown animated table-customize" id="ggtable">
				<thead>
					<tr>
					<th>'.__d('user','Title').'</th>
					<th>'.__d('user','Contribution').'</th>
					<th>'.__d('user','Start Date').'</th>
					<th>'.__d('user','End Date').'</th>
					<th>'.__d('user','Status').'</th>
					<th>'.__d('user','View').'</th>
				</tr>
				</thead>
				<tbody>';
		foreach ($gglistdatas as $ggdata) {
			$ggid = $ggdata['id'];
			$fullname = $ggdata['name'];
			$address1 = $ggdata['address1'];
			$address2 = $ggdata['address2'];
			$city = $ggdata['city'];
			$state = $ggdata['state'];
			$country = $ggdata['country'];
			$zip = $ggdata['zipcode'];
			$datefirst = $ggdata['c_date'];//604800
			$datelast = $ggdata['c_date'] + 3600;
			$fday=date("F j, Y, g:i a",$datefirst);
			$lday=date("F j, Y, g:i a",$datelast);
			$statuss = $ggdata['status'];
			$amount = $ggdata['total_amt'];
			$balance_amt = $ggdata['balance_amt'];
			$title = $ggdata['title'];
					echo '<tr class="shipping'.$ggid.'">
						<td><a href="'.SITE_URL.'gifts/'.$ggid.'">'.$title.'</a></td>
						<td><span>&#x200E;'.$gglists[$ggid]['currency_symbol'].' '.($amount-$balance_amt).'</span>/<span>&#x200E;'.$gglists[$ggid]['currency_symbol'].' '.$amount.'</span></td>
						<td><span>'.$fday.'</span></td>
						<td><span>'.$lday.'</span></td>';
						if($statuss !='Active' && $statuss !='Completed'){
							echo '<td><span class="red-txt">'.__d('user','REFUNDED').'</span></td>';
						}
						elseif($statuss == 'Completed')
						{
							echo '<td><span class="green-txt">'.__d('user','COMPLETED').'</span></td>';
						}
						elseif($datelast < time())
						{
							echo '<td><span style="color:#04c;">'.__d('user','EXPIRED').'</span></td>';
						}
						elseif($statuss == 'Active')
						{
							echo '<td><span class="green-txt">'.__d('user','ACTIVE').'</span></td>';
						}
						echo '<td><a href="'.SITE_URL.'gifts/'.$ggid.'">'.__d('user','View').'</a></td>
					</tr>';
			}


				echo '</tbody>
			</table>
		</div>';
		/*echo '<div class="centered-text margin-top20 margin_bottom_mobile20"><a href="">+Load more Result</a></div>';*/
	}
	else
	{
		echo '<div class="centered-text margin-top20 margin_bottom_mobile20">'.__d('user','You haven’t created Group Gift yet').'.</div>';
	}
?>




				</div>
				</div>
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 padding_recent_activities">
				<div class="margin-bottom10">
				<div class="activity_heading border_bottom_grey extra_text_hide">
				<?php echo __d('user','Last Contributions');?>
				</div>
<?php
if (count($groupgiftpayment)>0){
		echo '<div class="activity_heading border_bottom_grey">';
foreach ($groupgiftpayment as $ggpayment){
$ggpayid = $ggpayment['id'];
			echo '<div class="margin-top20">
		<h5 class="bold-font margin-bottom0 extra_text_hide">'.$ggpayment['groupgiftuserdetail']['name'].'</h5>
			<h5 class="font_size13 regular-font margin-top5">'.__d('user','Contributed Amount').': <span class="primary-color-txt">&#x200E;'.$ggpays[$ggpayid]['currency_symbol'].' '.$ggpayment['groupgiftuserdetail']['total_amt'].'</span></h5>
			</div>';
}
		echo '</div>';
}
else
{
	echo '<div class="activity_heading primary-color-txt text-center">

		<span class="primary-color-txt line_height150 regular-font">'.__d('user','No Recent Activity').'</span>
	</div>';
}
?>
				</div>
			</div>
				</div>
			</section>
		</div>

	</section>

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
    $('#ggtable').DataTable({
    	 "language": {
    "paginate": {
      "previous": "<<",
      "next":">>"
    }
  },
        dom: 'Bfrtip',
          bInfo:false,
      
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>
    <style type="text/css">
.next{
  font-size: 13px !important;
    position:inherit; !important;
      display:inline-block !important;
}
</style>