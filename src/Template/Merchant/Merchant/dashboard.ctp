<style>
.icon-dash {
  border-radius: 3px;
  color: #fff;
  font-size: 20px;
  padding: 10px;
}
.icon-dash-blue {
   background: #009efb;
}
.icon-dash-green {
   background: #55ce63;
}
.icon-dash-pink {
    background: #e84c8a;
}
.icon-dash-red {
    background: #f62d51;
}
.icon-dash-violet {
    background: #7460ee;
}
.icon-dash-yellow {
    background: #ffbc34;
}
.icon-dash-lred {
    background: #fa603d;
}
.icon-dash-pale {
    background: #eae874;
}
ul.list-unstyled {
   margin:0px;
   padding:0px;
}
ul.list-unstyled > li{
   display: block;
   width: 100%;
   text-align: center;
}
.icon-dash-code {
  font-size: 24px;
  line-height: 40px;
  font-weight: 400;
}

.icon-dash-value {
  font-size: 21px;
  line-height: 40px;
  font-weight: 400;
  margin-top: 20px;
}
ul.list-unstyled > li:last-child > h6 {
   margin: 0px;
   font-size: 14px;
   font-weight: 400;
   line-height: 18px;
   color:#ccc;
   text-align: center;
}
/*.card .card-block:hover ul.list-unstyled > li:last-child > h6 {
   color:#009efb !important;
   -webkit-transition: all 0.4s ease-in-out;
   transition: all 0.4s ease-in-out;
}*/
.card .card-block:hover {
  background: #fdfdfd none repeat scroll 0 0;
  border-radius: 8px;
  box-shadow: 0 0 10px #ddd;
  transition: all 0.4s ease-in-out 0s;
}
.card .card-block {
   -webkit-transition: all 0.4s ease-in-out;
  transition: all 0.4s ease-in-out;
}
.card { 
   border-radius: 8px !important;
}
.table-responsive .table tbody tr td
{
   font-weight: 400 !important;
}
</style>

<?php 
   $total_admin_commission = round($total_admin_commission); 
   $total_order_paid = round($total_order_paid,2);
   $total_order_delivery = round($total_order_delivery,2);
   $total_revenue = round($total_revenue,2);
   $total_merchandize_value = round($total_merchandize_value,2);
   $total_complete_payment = round($total_complete_payment,2);
?>
 <!-- Row -->
<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Dashboard'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Dashboard'); ?></li>
      </ol>
  </div>
</div>
 <div class="row">
     <!-- Column -->
     <div class="col-lg-3 col-md-6">
         <div class="card">
             <div class="card-block">
               <ul class="col-md-12 col-sm-12 list-unstyled">
                  <li>
                     <div class="icon-dash icon-dash-blue fa fa-user-o"></div>
                     <div class="icon-dash-value">
                        <span class="icon-dash-code">
                          <?php echo $currencysymbol; ?>
                        </span>
                        <?php echo $total_order_paid; ?>
                     </div>
                  </li>
                  <li>
                     <h6><?php echo __d('merchant','Complete Order Amount');?></h6>
                  </li>
               </ul>
             </div>
         </div>
     </div>
     <div class="col-lg-3 col-md-6">
         <div class="card">
             <div class="card-block">
               <ul class="col-md-12 col-sm-12 list-unstyled">
                  <li>
                     <div class="icon-dash icon-dash-green fa fa-user-o"></div>
                     <div class="icon-dash-value">
                        <span class="icon-dash-code">
                          <?php echo $currencysymbol; ?>
                       </span>
                        <?php echo $total_order_delivery; ?>
                     </div>
                  </li>
                  <li>
                     <h6><?php echo __d('merchant','Incomplete Order Amount');?></h6>
                  </li>
               </ul>
             </div>
         </div>
     </div>
     <!-- Column -->
     <div class="col-lg-3 col-md-6">
         <div class="card">
             <div class="card-block">
                <ul class="col-md-12 col-sm-12 list-unstyled">
                  <li>
                     <div class="icon-dash icon-dash-pink fa fa-plus"></div>
                     <div class="icon-dash-value">
                        <?php echo $total_items; ?>
                     </div>
                  </li>
                  <li >
                     <h6><?php echo __d('merchant','Total Items');?></h6>
                  </li>
               </ul>
             </div>
         </div>
     </div>
     <!-- Column -->
     <div class="col-lg-3 col-md-6">
         <div class="card">
             <div class="card-block">
               <ul class="col-md-12 col-sm-12 list-unstyled">
                  <li>
                     <div class="icon-dash icon-dash-red fa fa-money"></div>
                     <div class="icon-dash-value">
                       <span class="icon-dash-code">
                          <?php echo $currencysymbol; ?>
                       </span>
                        <?php echo $total_merchandize_value; ?>
                     </div>
                  </li>
                  <li >
                     <h6><?php echo __d('merchant','Listed merchandize value');?></h6>
                  </li>
               </ul>
             </div>
         </div>
     </div>
 </div>
 <!-- Row -->

 <!-- Second Row -->
 <div class="row">
     <!-- Column -->
     <div class="col-lg-3 col-md-6">
         <div class="card">
             <div class="card-block">
               <ul class="col-md-12 col-sm-12 list-unstyled">
                  <li>
                     <div class="icon-dash icon-dash-lred fa fa-money"></div>
                     <div class="icon-dash-value">
                        <span class="icon-dash-code">
                          <?php echo $currencysymbol; ?>
                       </span>
                        <?php echo $total_complete_payment; ?>
                     </div>
                  </li>
                  <li >
                     <h6><?php echo __d('merchant','Completed Transactions');?></h6>
                  </li>
               </ul>
             </div>
         </div>
     </div>
     <div class="col-lg-3 col-md-6">
         <div class="card">
             <div class="card-block">
               <ul class="col-md-12 col-sm-12 list-unstyled">
                  <li>
                     <div class="icon-dash icon-dash-yellow fa fa-money"></div>
                     <div class="icon-dash-value">
                        <span class="icon-dash-code">
                          <?php echo $currencysymbol; ?>
                       </span>
                        <?php echo $total_revenue; ?>
                     </div>
                  </li>
                  <li >
                     <h6><?php echo __d('merchant','Total Revenue');?></h6>
                  </li>
               </ul>
             </div>
         </div>
     </div>
     <!-- Column -->
     <div class="col-lg-3 col-md-6">
         <div class="card">
             <div class="card-block">
               <ul class="col-md-12 col-sm-12 list-unstyled">
                  <li>
                     <div class="icon-dash icon-dash-violet fa fa-shopping-cart"></div>
                     <div class="icon-dash-value">
                        <?php echo $today_new_orders_count; ?>
                     </div>
                  </li>
                  <li >
                     <h6><?php echo __d('merchant','New Orders Today');?></h6>
                  </li>
               </ul>
             </div>
         </div>
     </div>
     <!-- Column -->
     <div class="col-lg-3 col-md-6">
         <div class="card">
             <div class="card-block">
               <ul class="col-md-12 col-sm-12 list-unstyled">
                  <li>
                     <div class="icon-dash icon-dash-pale fa fa-truck"></div>
                     <div class="icon-dash-value">
                        <?php echo $today_delivered_orders_count; ?>
                     </div>
                  </li>
                  <li >
                     <h6><?php echo __d('merchant','Delivered Orders Today');?></h6>
                  </li>
               </ul>
             </div>
         </div>
     </div>
 </div>
 <!-- Row -->

 <div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-block">
            <h4 class="text-themecolor m-b-0 m-t-0 clearfix"> <?php echo __d('merchant','Order History'); ?> </h4>

            <?php $count =  count($orderdetails);
               if($count > 0) { ?>
                  <div class="table-responsive nofilter">
                     <table class="table color-table info-table">
                        <thead>
                           <tr>
                              <th class="p-l-20">#</th>
                              <th><?php echo __d('merchant', 'Order Id'); ?></th>
                              <th><?php echo __d('merchant', 'Price'); ?></th>
                              <th><?php echo __d('merchant', 'Sale Date'); ?></th>
                              <th><?php echo __d('merchant', 'Status'); ?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 0; foreach($orderdetails as $orders) {  ?>
                              <tr>
                                 <td class="p-l-20">
                                    <?php echo ++$i; ?>
                                 </td>
                                 <td>
                                    <?php echo $orders['orderid']; ?>
                                 </td>
                                 <td>
                                    <?php echo $ordercurrency[$orders['orderid']].$orders['totalcost']; ?>
                                 </td>
                                 <td>
                                    <?php echo date('d/m/Y',$orders['orderdate']); ?>
                                 </td>
                                 <td>
                                    <?php echo __d('merchant',$orders['status']); ?>
                                 </td>
                              </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                     <p>
                        <a style="text-decoration:none; color: #009efb; font-weight: 400;" href="<?php echo MERCHANT_URL.'/neworders'; ?>">
                           <?php echo __d('merchant', 'More')." ..."; ?>
                        </a>
                     </p> 
                  </div>
               <?php } else { ?>
                  <div class="noordercmnt m-t-30" style="text-align:center; font-weight: 500; color: #cccccc; "><?php echo __d('merchant', 'No Orders Available'); ?></div>
               <?php } ?>
         </div>
      </div>
   </div>
</div>
               