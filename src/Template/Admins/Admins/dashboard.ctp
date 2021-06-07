<?php ?>
<script type="text/javascript">
$(document).ready(function(){
<?php


$admin_menus = json_decode($logadminmenus,true);

//if($loguserlevel=="moderator" || !in_array('Manage User',$admin_menus) || !in_array('Manage Sellers',$admin_menus) || !in_array('Manage Items',$admin_menus))

if($loguserlevel=="moderator" && !in_array('Manage User',$admin_menus))
{
?>

$(".box-content a").css("cursor","default").click(false);

<?php
}

if($loguserlevel=="moderator" && !in_array('Manage Sellers',$admin_menus))
{
?>

$(".seller-view").css("cursor","default").click(false);

<?php
}

if($loguserlevel=="moderator" && !in_array('Manage Items',$admin_menus))
{
?>

$(".item-view").css("cursor","default").click(false);

<?php
}
?>
});
</script>
<style type="text/css">
    .namewrap
    {
        word-break: break-all;
    }
    .pushnotloader {
     background: url('images/loaderdot.gif') 50% 50% no-repeat rgb(249,249,249);
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    opacity: 0.4;
    z-index: 999;
}
</style>

  <div class="content">


                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-12 col-12 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Dashboard'); ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('admin', 'Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo __d('admin', 'Dashboard'); ?></li>
                        </ol>
                    </div>
     <?php if($visitcount == 1) { ?>
                    <div class="col-md-12 col-12 align-self-center">
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert"> x </button>
        <strong><?php echo __d('admin', 'Welcome:'); ?></strong> <?php echo __d('admin', 'Admin!'); ?>
    </div>
    <?php } ?>

                    </div>
                </div>
            	<?php $total_admin_commission = round($total_admin_commission,2);
						      $total_complete_payment = round($total_complete_payment,2);
						      $total_merchandize_value = round($total_merchandize_value,2); ?>

                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'Users'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-danger"><i class="mdi mdi-account"></i></span> <?php echo $total_usrs; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'Active Users'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-info"><i class="mdi mdi-account-outline"></i></span> <?php echo $enbleusrs; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div>
                       <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'Active Merchants'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-warning"><i class="mdi mdi-account-outline"></i></span> <?php echo $enable_sellers; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div>

                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'Today Registered Users'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-success"><i class="mdi mdi-account-outline"></i></span> <?php echo $todayregister_user; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'Total Items'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-primary"><i class="mdi mdi-basket-fill"></i></span> <?php echo $total_items; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'Claimed Orders'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-youtube"><i class="mdi mdi-cart-off"></i></span> <?php echo $claimedOrders; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->
             
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'Active Disputes'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-info"><i class="mdi mdi-recycle"></i></span> <?php echo $disp_data; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <!--div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'Total Revenue'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-success"><i class="mdi mdi-cash"></i></span> <?php echo $total_admin_commission; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div-->
                    <!-- Column -->
                    <!-- Column -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'New Orders Today'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-danger"><i class="mdi mdi-cart"></i></span> <?php echo $today_new_orders_count; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h6 class="card-title"><?php echo __d('admin', 'Delivered Orders Today'); ?></h6>
                                <div class="text-left">
                                    <h4 class="font-light m-b-0"><span class="btn btn-warning"><i class="mdi mdi-truck-delivery"></i></span> <?php echo $today_delivered_orders_count; ?></h2>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>






<div class="row-fluid">







						<div style="with:98% ! important;">
						<div style="width:70%;float:left;">

					</div>
				  <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title"><?php echo __d('admin', 'Users'); ?></h4>
						<table class="table">
              <thead>
                <tr>
                  <th><?php echo __d('admin', 'First Name'); ?></th>
                 <!--th>Last Name</th-->
                  <th><?php echo __d('admin', 'Username'); ?></th>
                </tr>
              </thead>
              <tbody>

              <?php
              //echo "<pre>";print_r($user_datas);die;

              foreach($user_datas as $users){       ?>
	            <tr>
                  <td class="namewrap" width="50%"><?php echo $users['first_name']; ?></td>
                  <!--td><?php //echo $users['User']['last_name']; ?></td-->
                  <td class="namewrap"><?php echo $users['username']; ?></td>
                </tr>

                <?php } ?>

              </tbody>

            </table>
             <p><a style="text-decoration:none;" data-ajax="false" href="<?php echo SITE_URL.'manageuser/'; ?>"><?php echo __d('admin', 'More....'); ?></a></p>
					</div>
				</div><!--/span-->

			</div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">
<?php echo __d('admin', 'Send Push Notification'); ?>
</h4>
<?php echo $this->Form->Create('pushnot',array('url'=>array('controller'=>'/','action'=>'/admins/sendpushnot'),'id'=>'pushnotify','onsubmit'=>'return sendpushnot();')); ?>

                                <div class="message-box">
						          <div class="form-group">
						          	<?php
						            echo "<label>".__d('admin', "Message")."</label>";
						            echo $this->Form->input('message',array('type'=>'textarea','label'=>false,'id'=>'message','class'=>'form-control','value'=>'','style'=>' height:100px;'));

						           	echo '<div class="message-error adminitemerror trn" style="color:#982525"></div></div>';

						           	echo '<input type="button" class="btn btn-info" id="sendpush" value="'.__d('admin', 'Send').'" onclick="sendpushnot();">';

						           	echo '<div id="successalert" class="message-success adminitemerror trn" style="color:#259825;display:inline-block; margin-left:20px;"></div>';
                                    echo '<div id="pushnotloader"></div>';
						echo $this->Form->end();
						            ?>

							</div>
						</div>
						<!------------Send push notification------->
						</div></div>

            </table>

        </div>
    </div>


</div>




            </div>
        </div>
    </div>

    <style>

</style>


    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
        setTimeout(function(){$('.alert').fadeOut();}, 2000);
    </script>

  </body>
</html>

