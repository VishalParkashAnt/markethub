<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Item Coupons'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Coupons'); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/itemcoupons"><?php echo __d('merchant','Manage Coupons'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Item Coupons'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <!-- h4 class="card-title">Data Table</h4 -->
                <h4 class="text-themecolor m-b-0 m-t-0 clearfix"><span class="rightTitle"><?php echo __d('merchant','Manage Coupons'); ?></span>
                 <ul id = "nav-altertable" class="nav nav-pills" style="display: inline-flex; float: right;">
                    <li class=" nav-item"> <a href="<?php echo MERCHANT_URL; ?>/cartcoupons" class="nav-link"><?php echo __d('merchant','Cart Coupons'); ?></a> </li>
                    <li class="nav-item"> <a href="#" class="nav-link active"><?php echo __d('merchant','Item Coupons'); ?></a> </li>
                    <li class="nav-item"> <a href="<?php echo MERCHANT_URL; ?>/categorycoupons" class="nav-link"><?php echo __d('merchant','Category Coupons'); ?></a> </li>
                </ul></h4>
                <hr/>
                <div class="table-responsive nofilter">

                	<?php if (count($getcouponval) > 0) { ?>
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="p-l-10"><?php echo __('#');?></th>
			        			<th><?php echo __d('merchant','Coupon Code');?></th>
                                <th class="producttd"><?php echo __d('merchant','Product title');?></th>
			        			<th><?php echo __d('merchant','Total Coupons');?></th>
			        			<th><?php echo __d('merchant','Remaining');?></th>
			        			<th><?php echo __d('merchant','Percentage');?></th>
			        			<th><?php echo __d('merchant','Start Date');?></th>
                                <th><?php echo __d('merchant','End Date');?></th>
                                <th class="w-115"><?php echo __d('merchant','Actions');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 0;
                            foreach($getcouponval as $key=>$user_det)
                            {
                                $id=$user_det['id'];
                                echo "<tr id='del_".$id."'><td class='p-l-10'>";
                                echo ++$i;
                                echo '</td><td>';
                                echo $user_det['couponcode'];
                                echo '</td><td class="producttd" style="text-transform:capitalize;">';
                                echo strtolower($user_det['item']['item_title']);
                                echo '</td><td>';
                                echo $user_det['totalrange'];
                                echo '</td><td>';
                                echo $user_det['remainrange'];
                                echo '</td><td>';
                                echo $user_det['couponpercentage'];
                                echo '</td><td>';
                                echo $user_det['validfrom'];
                                echo '</td><td>';
                                echo $user_det['validto'];
                                echo '</td><td>';
                                $sourceid = $user_det['sourceid'];
                                $couponid = $user_det['id'];
                                echo "<a data-ajax='false'  href=".MERCHANT_URL."/additemcoupon/".$sourceid."><span class='btn btn-info'><i class='fa fa-edit'></i></span></a>
                                        <a href='#'' onclick='deletecoupon(".$couponid.")'><span class='btn btn-danger'><i class='fa fa-trash-o'></i></span></a>";

                                echo '</td></tr>';
                            }

                        ?>

                        </tbody>
                    </table>
                <?php } else { ?>
                	<h6 class="card-title text-center"><?php echo __d('merchant','No Coupons Found');?></h6>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>

@media screen and (min-width: 520px) {
    .card .card-block .text-themecolor ul.nav-pills > li > a {
        padding: 2px 8px;
        font-size: 14px;
    }
}   

@media (min-width: 320px) and (max-width: 480px) {
    .card .card-block .text-themecolor ul.nav-pills > li > a {
        padding: 0px 10px;
        font-size: 12px;
    }
}

.producttd {
    width: 150px !important;
    word-break: break-all !important;
}
.card .card-block .text-themecolor ul.nav-pills>li>a.active
{
    background-color: rgb(25, 153, 235);
}
.card .card-block .text-themecolor .rightTitle {
   padding: 2px 0px;    display: inline-block;
}

table#myTable td, table#myTable th{
    padding:0.75rem 10px !important;
}

.w-115 {
    width: 115px !important;
    min-width: 115px !important;
}

</style>
<script>
$('#myTable').DataTable({
        dom: 'Bfrtip'
    });
</script>
