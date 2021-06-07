<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Manage Cart Details'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Abandon Cart'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Manage Cart Details'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <!-- h4 class="card-title">Data Table</h4 -->
                <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Manage Cart Details'); ?></h4>
                <hr/>
                <div class="table-responsive nofilter">
                
                    <?php if (count($cartdetail) > 0) { ?>
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-80"><?php echo __('#');?></th>
                                <th><?php echo __d('merchant','User Name');?></th>
                                <th><?php echo __d('merchant','Item Details');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                          $i = 1;
                          foreach($cartdetail as $key => $value)
                          {
                               echo '<tr>';
                               echo '<td>'.$i.'</td>';
                               echo '<td>';
                               echo $username[$key]['username'];
                               echo '<br />('.$username[$key]['email'].')';
                               echo '</td>';
                               echo '<td class="producttd" style="text-align:left;">';                                      
                               foreach($value as $keys => $values)
                               {
                                     echo __d('merchant','Item Name')." : ";
                                     echo $values['itemname'];echo '<br ><br />';
                                     echo __d('merchant','Quantity')." : ".$values['quantity'];
                                     echo '<br />';
                                     echo __d('merchant','Created At')." : ".date('Y-m-d',strtotime($values['createdat']));
                                     echo '<br />';
                               }
                               echo '</td>';
                               $i++;
                               echo '</tr>';
                          }
                        ?>

                        </tbody>
                    </table>
                <?php } else { ?>
                    <h6 class="card-title text-center"><?php echo __d('merchant','No Cart Details Found');?></h6>
                <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.w-80 {
    width: 80px !important;
    min-width: 80px !important;
}
.producttd {
    word-break: break-all !important;
  }
</style>
<script>
/*$(document).ready(function() {
$('#myTable').DataTable();
});*/


$('#myTable').DataTable({
        dom: 'Bfrtip'
    });
</script>
