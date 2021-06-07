<?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
<?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Payment History'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Payment History'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <!-- h4 class="card-title">Data Table</h4 -->
                <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Payment History'); ?></h4>
                <hr/>
                <div class="prvcmntcont m-t-30">
                    <?php if (count($payment['Orders']) > 0) { ?>
                        <?php  echo '<span class="col-sm-3 p-l-0"> '.__d('merchant','Filters').' <!-- input type="text" id="ordersearchval" style="margin-top:7px;"  --> </span>
                            <input type="text" id="sdate" class="form-control datepicker-autostart col-sm-3" placeholder="'.__d('merchant','Start Date').'" style="margin-top:7px;color:#555555! important;">
                            <input type="text" id="edate" class="form-control datepicker-autoend col-sm-3" placeholder="'.__d('merchant','End Date').'" style="margin-top:7px;color:#555555! important;">
                            <!-- button class="btn btn-success" onclick="actionpay_history()" style="vertical-align:inherit;">Search</button>
                            <a class="btn btn-info clearResult" href="'.MERCHANT_URL.'/paymenthistory" style="vertical-align:inherit;">Reset</a -->';

                        ?>
                        <!-- small class="form-control-feedback f4-error f4-error-daterror m-t-20 col-sm-3"></small -->

                <div class="table-responsive nofilter">

                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="p-l-10"><?php echo __('#');?></th>
			        			<th><?php echo __d('merchant','Order Id');?></th>
			        			<th><?php echo __d('merchant','Date');?></th>
			        			<th><?php echo __d('merchant','Transaction Id');?></th>
			        			<th><?php echo __d('merchant','Gross Amount');?></th>
			        			<th><?php echo __d('merchant','Memo');?></th>
                                <th><?php echo __d('merchant','Payment Mode');?></th>
                                <th><?php echo __d('merchant','Status');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $incre = 0;
                            for($i=0;$i<count($payment['Orders']);$i++)
                            {
                                echo '<tr><td class="p-l-10">';
                                 echo ++$incre;
                                echo '</td><td>';
                                echo $payment['Orders'][$i]['orderid'];
                                echo '</td><td>';
                                echo $payment['Orders'][$i]['Date'];
                                echo '</td><td>';
                                echo $payment['Orders'][$i]['transactionid'];;
                                echo '</td><td>';
                                echo $payment['Orders'][$i]['totalcost'];
                                echo '</td><td>';
                                echo 'Payment for orders';
                                echo '</td><td class="paymethod">';
                                echo strtolower($payment['Orders'][$i]['paymentmethod']);
                                echo '</td><td>';
                                echo $payment['Orders'][$i]['status'];
                                echo '</td></tr>';
                            }

                        ?>

                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                	<h6 class="card-title text-center"><?php echo __d('merchant','No Payment Details Available');?></h6>
                <?php }?>
                </div>
                </div>
            </div>
        </div>
    </div>



<style>
@media screen and (min-width: 820px) {
    .table-responsive > #myTable_wrapper > .dt-buttons {
        margin: 70px 0px 20px !important;
    }
}
.paymethod {
    text-transform: capitalize;
}
</style>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
   

<script>
/*$(document).ready(function() {
$('#myTable').DataTable();
});*/


/*$('#myTable').DataTable({
        dom: 'Bfrtip',
         buttons: [
            'csv'        ]
    });

 jQuery('.datepicker-autostart, .datepicker-autoend').datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        todayHighlight: true
    });*/



   $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        var min = $('#sdate').datepicker("getDate");
        var max = $('#edate').datepicker("getDate");
        var startDate = new Date(data[2]);
        if (min == null && max == null) { return true; }
        if (min == null && startDate <= max) { return true;}
        if(max == null && startDate >= min) {return true;}
        if (startDate <= max && startDate >= min) { return true; }
        return false;
    }
  );


  $("#sdate, #edate").datepicker({ 
    onSelect: function () { 
        table.draw(); 
    }, 
    format: 'mm/dd/yyyy', 
    todayHighlight: true,
    clearBtn: true });

  var table = $('#myTable').DataTable({
      dom: 'Bfrtip',
         buttons: [
            'csv'        ]
  });

  $('#sdate, #edate').change(function () {
      table.draw();
  });

</script>

