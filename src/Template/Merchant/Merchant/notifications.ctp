<style>
/* Notification */
    #myTable ul.notify-message {
        display: inline-flex;
        padding: 0px !important;
        list-style: none;
        margin:0px !important;
    }
    #myTable ul+ul {
        border-top: 1px solid rgba(120, 130, 140, 0.13);
    }
    #myTable ul.notify-message .notify-content {
        padding-left:15px;
        font-size: 14px;  
        font-weight: 400;
        margin:auto !important;
    }
    #myTable ul.notify-message .notify-content > span > a {
        border: none;   display: inline-block;  padding: 0px;
        background: none; text-transform: capitalize;
    }
    #myTable ul.notify-message .notify-content > span > a:hover{
        background: none;
    }
    #myTable ul.notify-message .notify-content .notify-desc {
        display: block; word-break: break-all;
    }
    #myTable ul.notify-message .notify-image img {
        height: 50px; width:50px; border-radius: 100px; display: block;
    }
    .notify-subtitle, .notify-desc a {
        color: #009efb !important; font-weight: 400;
    }
</style>
<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Notifications'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard"><?php echo __d('merchant','Home'); ?></a></li>
          <li class="breadcrumb-item active"><?php echo __d('merchant','Notifications'); ?></li>
      </ol>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-block">
        <!-- h4 class="card-title">Data Table</h4 -->
        <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Notifications'); ?></h4>
        <hr/>
        <div class="table-responsive nofilter">

        <?php if (count($logmessage) > 0) { ?>
        <table id="myTable" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th style="display: none;"><?php echo __('#');?></th>
                <!-- th><?php //echo __d('merchant','Type');?></th -->
                <th><?php echo __d('merchant','Notify Message');?></th>
            </tr>
          </thead>
          <tbody>
            <?php
              $i = 0;
              foreach($logmessage as $logs) {
            ?>
              <tr>  
                <td style="display: none;"><?php echo ++$i; ?></td> 
                <!-- td><?php //echo $logs['type']; ?></td -->
                <td>
                  <?php if($logs['type']=="follow" || $logs['type']=="review") { ?>
                    <ul class="notify-message">
                       <li class="notify-image">
                          <?php 
                          $io = array();
                          $io = json_decode($logs['image'],true);
                          if(!empty(trim($io['user']['image']))) { ?> 
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                         <?php } else { ?>
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                         <?php } ?>
                       </li>
                       <li class="notify-content">
                          <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>     
                          <span class="notify-desc">
                            <?php echo $notifymsg[0]." ".__d('merchant',trim($notifymsg[1])); ?>
                          </span>
                          <?php if(!empty($logs['message'])) { ?>
                              <br />
                              <span class="notify-desc">
                                <span class="notify-subtitle">
                                   <?php echo __d('merchant','Message')." "; ?>
                                </span>
                                <span style="margin:0px 2px;"> - </span>
                                <?php echo $logs['message']; ?>
                              </span>
                          <?php } ?>

                       </li>
                    </ul>
                  <?php } else if($logs['type']=="sellermessage") { ?>
                    <ul class="notify-message">
                       <li class="notify-image">
                          <?php 
                          $io = array();
                          $io = json_decode($logs['image'],true);
                          if(!empty(trim($io['user']['image']))) { ?> 
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                         <?php } else { ?>
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                         <?php } ?>
                       </li>
                       <li class="notify-content">
                          <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>     
                          <span class="notify-desc">
                            <?php echo __d('merchant',trim($notifymsg[0]))." ".$notifymsg[1]." ".__d('merchant',trim($notifymsg[2])); ?>
                          </span>
                          <?php if(!empty($logs['message'])) { ?>
                              <br />
                              <span class="notify-desc">
                                <span class="notify-subtitle">
                                   <?php echo __d('merchant','Message')." "; ?>
                                </span>
                                <span style="margin:0px 2px;"> - </span>
                                <?php echo $logs['message']; ?>
                              </span>
                          <?php } ?>

                       </li>
                    </ul>
                  <?php } else if($logs['type']=="admin" || $logs['type']=="credit") { ?>
                    <ul class="notify-message">
                       <li class="notify-image">
                          <?php 
                          $io = array();
                          $io = json_decode($logs['image'],true);
                          if(!empty(trim($io['user']['image']))) { ?> 
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                         <?php } else { ?>
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                         <?php } ?>
                       </li>
                       <li class="notify-content">
                          <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>     
                          <span class="notify-desc">
                            <?php if(count($notifymsg)>2) { 
                                echo $notifymsg[0]." ".__d('merchant',trim($notifymsg[1]))." ".$notifymsg[2]; 
                              } else {
                                echo __d('merchant',trim($notifymsg[0]))." ".$notifymsg[1];
                              }
                            ?>

                          </span>
                          <?php if(!empty($logs['message'])) { ?>
                              <br />
                              <span class="notify-desc">
                                <span class="notify-subtitle">
                                   <?php echo __d('merchant','Message')." "; ?>
                                </span>
                                <span style="margin:0px 2px;"> - </span>
                                <?php echo $logs['message']; ?>
                              </span>
                          <?php } ?>

                       </li>
                    </ul>
                    <?php } else if($logs['type']=="admin_commision") { ?>
                    <ul class="notify-message">
                       <li class="notify-image">
                          <?php 
                          $io = array();
                          $io = json_decode($logs['image'],true);
                          if(!empty(trim($io['user']['image']))) { ?> 
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                         <?php } else { ?>
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                         <?php } ?>
                       </li>
                       <li class="notify-content">
                          <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>     
                          <span class="notify-desc">
                            <?php if(count($notifymsg)>2) { 
                                echo __d('merchant',trim($notifymsg[0]))." ".__d('merchant',trim($notifymsg[1]))." ".$notifymsg[2]; 
                              } else {
                                echo __d('merchant',trim($notifymsg[0]))." ".__d('merchant',trim($notifymsg[1]));
                              }
                            ?>

                          </span>
                          <?php if(!empty($logs['message'])) { ?>
                              <br />
                              <span class="notify-desc">
                                <span class="notify-subtitle">
                                   <?php echo __d('merchant','Message')." "; ?>
                                </span>
                                <span style="margin:0px 2px;"> - </span>
                                <?php echo $logs['message']; ?>
                              </span>
                          <?php } ?>

                       </li>
                    </ul>
                  <?php } else if($logs['type']=="ordermessage") { ?>
                    <ul class="notify-message">
                       <li class="notify-image">
                          <?php 
                          $io = array();
                          $io = json_decode($logs['image'],true);
                          if(!empty(trim($io['user']['image']))) { ?> 
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                         <?php } else { ?>
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                         <?php } ?>
                       </li>
                       <li class="notify-content">
                          <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>     
                          <span class="notify-desc">
                            <?php echo __d('merchant',trim($notifymsg[0]))." ".$notifymsg[1]." ".__d('merchant',trim($notifymsg[2]))." ".$notifymsg[3]; ?>
                          </span>
                          <?php if(!empty($logs['message'])) { ?>
                              <br />
                              <span class="notify-desc">
                                <span class="notify-subtitle">
                                   <?php echo __d('merchant','Message')." "; ?>
                                </span>
                                <span style="margin:0px 2px;"> - </span>
                                <?php echo $logs['message']; ?>
                              </span>
                          <?php } ?>

                       </li>
                    </ul>
                  <?php } else if($logs['type']=="chatmessage" || $logs['type']=="dispute" || $logs['type']=="groupgift" || $logs['type']=="orderstatus") { ?>
                    <ul class="notify-message">
                       <li class="notify-image">
                          <?php 
                          $io = array();
                          $io = json_decode($logs['image'],true);
                          if(!empty(trim($io['user']['image']))) { ?> 
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                         <?php } else { ?>
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                         <?php } ?>
                       </li>
                       <li class="notify-content">
                          <?php $notifymsg = explode("-___-", $logs['notifymessage']); ?>     
                          <span class="notify-desc">
                            <?php echo $notifymsg[0]." ".__d('merchant',trim($notifymsg[1]))." ".$notifymsg[2]; ?>
                          </span>
                          <?php if(!empty($logs['message'])) { ?>
                              <br />
                              <span class="notify-desc">
                                <span class="notify-subtitle">
                                   <?php echo __d('merchant','Message')." "; ?>
                                </span>
                                <span style="margin:0px 2px;"> - </span>
                                <?php echo $logs['message']; ?>
                              </span>
                          <?php } ?>

                       </li>
                    </ul>
                  <?php } else { ?>
                    <ul class="notify-message">
                       <li class="notify-image">
                          <?php 
                          $io = array();
                          $io = json_decode($logs['image'],true);
                          if(!empty(trim($io['user']['image']))) { ?> 
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/<?php echo $io['user']['image']; ?>"/>
                         <?php } else { ?>
                             <img src="<?php echo SITE_URL; ?>media/avatars/thumb70/usrimg.jpg"/>
                         <?php } ?>
                       </li>
                       <li class="notify-content">
                          <?php $notifymsg = str_replace("-___-","  ",$logs['notifymessage']); ?>     
                          <span class="notify-desc">
                            <?php echo $notifymsg; ?>
                          </span>
                          <?php if(!empty($logs['message'])) { ?>
                              <br />
                              <span class="notify-desc">
                                <span class="notify-subtitle">
                                   <?php echo __d('merchant','Message')." "; ?>
                                </span>
                                <span style="margin:0px 2px;"> - </span>
                                <?php echo $logs['message']; ?>
                              </span>
                          <?php } ?>

                       </li>
                    </ul>
                  <?php } ?>
                </td>
              </tr>   
          <?php                       
              }

          ?>

                        </tbody>
                    </table>
                <?php } else { ?>
                    <h6 class="card-title text-center"><?php echo __d('merchant','No Notifications Found');?></h6>
                <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/*$(document).ready(function() {
$('#myTable').DataTable();
});*/


/*$('#myTable').DataTable({
        dom: 'Bfrtip'
    });*/
</script>
