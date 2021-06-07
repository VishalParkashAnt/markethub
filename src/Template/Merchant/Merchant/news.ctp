
<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','News'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','News'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <!-- h4 class="card-title">Data Table</h4 -->
                <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','News'); ?></h4>
                <hr/>
                 <h4 class="card"><?php echo __d('merchant','Add News'); ?></h4>
                 <ul class="news col-md-12 col-sm-12 list-unstyled p-0 m-0">
                    <li class="col-md-6 col-sm-12">
                        <?php echo $this->Form->Create('sellermsg',array('url'=>array('controller' => '/','action' => '/sellerpost'),'name'=>'','id'=>'msgForm')); ?>

                            <div class="form-group m-b-10">
                                <textarea id='message' name="message" type="text" class="form-control" rows="5" placeholder="" value=""></textarea>
                            </div>

                             <small class="trn form-control-feedback f4-error f4-error-message" style="margin-bottom: 15px;"></small>

                            <div class="button-group">
                                <button class="btn btn-rounded btn-info" type="submit"><i class="fa fa-check"></i>
                                <?php echo __d('merchant','Send'); ?></button>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </li>
                    <li class="col-md-6 col-sm-12">
                        <p style="font-weight:500;"><?php echo __d('merchant','What is the News'); ?> ?</p>
                        <p><?php echo __d('merchant','This is the news section where any merchant can update their followers with any new updates, sales or any upcome events on your merchant account.'); ?></p>
                        <p><?php echo __d('merchant','This notifications will be posted in their notification section. The users who connected with mobile apps will receive push notification updates from this sections.');?>
                        </p>
                    </li>
                 </ul>
                <hr/>
                <h4 class="card"><?php echo __d('merchant','View News'); ?></h4>
                <div class="table-responsive nofilter">

                <?php if (count($postmessage) > 0) { ?>
                    <table id="myTable" class="table table-bordered table-striped">
                         <thead>
                            <tr>
                                <td>#</td>
                                <td style="display: none;">ID</td>
                                <th><?php echo __d('merchant','News');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 0;
                            foreach($postmessage as $key=>$temp){
                                $bnr_id = $temp['id'];
                                $title = $temp['message'];
                        ?>
                                <tr>   
                                    <td><?php echo ++$i; ?></td>
                                    <td style="display: none;"><?php echo $bnr_id; ?></td>
                                    <td class="notification-item" style="padding: 10px; word-wrap: break-word; width: 100%;">
                                       <p class="m-0"><span class="title"> <?php echo $title; ?></span>
                                                               
                                       <span class="activity-reply">
                                            <?php 
                                              /*  $ldate =$temp['cdate'];
                                                echo '<small id="font_s_time" >'.UrlfriendlyComponent::txt_time_diff($ldate).'</small>'; */
                                            ?>
                                        </span>
                                       
                                    </td>
                                </tr>
                                </p>

                
                                
                        <?php                       
                            }

                        ?>

                        </tbody>
                    </table>
                <?php } else { ?>
                    <h6 class="card-title text-center"><?php echo __d('merchant','No Record Found');?></h6>
                <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
ul.news {
    display: inline-block;
}
ul.news > li
{
    float:left;
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
