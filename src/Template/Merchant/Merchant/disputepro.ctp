
<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php if(isset($_REQUEST['seller'])) {  echo __d('merchant','Closed Disputes');  } elseif(isset($_REQUEST['buyer'])) { echo __d('merchant','Active Disputes');  } else {  echo __d('merchant','Disputes');  } ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Disputes'); ?></a></li>
          <li class="breadcrumb-item active"><?php if(isset($_REQUEST['seller'])) {  echo __d('merchant','Closed Disputes'); } elseif(isset($_REQUEST['buyer'])) {  echo __d('merchant','Active Disputes'); } ?></li>
      </ol>
  </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <!-- h4 class="card-title">Data Table</h4 -->
                <h4 class="text-themecolor m-b-0 m-t-0 clearfix"><span class="rightTitle"><?php echo __d('merchant','Disputes'); ?></span>
                 <ul id="nav-altertable" class="nav nav-pills" style="display: inline-flex; float: right;">
                     <?php 
                    if(isset($_REQUEST['buyer'])) { ?>
                        <li class=" nav-item"> <a href="javascript:void(0)" class="nav-link active"><?php echo __d('merchant','Active Disputes'); ?></a> </li>
                        <li class="nav-item"> <a href="<?php echo MERCHANT_URL;?>/disputes/<?php echo $_SESSION['first_name'];?>?seller" class="nav-link"><?php echo __d('merchant','Closed Disputes');?></a> </li>
                    <?php } else if(isset($_REQUEST['seller'])) {  ?>
                        <li class=" nav-item"> <a href="<?php echo MERCHANT_URL;?>/disputes/<?php echo $_SESSION['first_name'];?>?buyer" class="nav-link"><?php echo __d('merchant','Active Disputes');?></a> </li>
                        <li class="nav-item"> <a href="javascript:void(0)" class="nav-link active"><?php echo __d('merchant','Closed Disputes');?></a> </li>
                    <?php } ?>
                </ul></h4>
                <hr/>


               <div class="prvcmntcont"> 
                  <div class="table-responsive nofilter">
                	<?php if(isset($_REQUEST['buyer'])) { 
                        if (!empty($messagesel)) { ?>
                           <table class="table color-table info-table">
                           <thead>
                               <tr>
                           <th class = "p-l-20 "><?php echo __d('merchant', '#');?></th>
   			        			<th><?php echo __d('merchant', 'Dispute Id');?></th>
   			        			<th><?php echo __d('merchant', 'Dispute On');?></th>
   			        			<th><?php echo __d('merchant', 'Other Party');?></th>
   			        			<th><?php echo __d('merchant', 'Dispute Amount');?></th>
   			        			<th><?php echo __d('merchant', 'Status');?></th>
                           <th><?php echo __d('merchant', 'Actions');?></th>
                               </tr>
                           </thead>
                           <tbody class="myorderlisttbody">
                           <?php   $i = 0;   
                              foreach($messagesel as $key => $msg) {
                                 if ($key < 10) {

                                    $msro = $msg['uorderid'];
                                    $usid = $loguser['id'];
                                    $disputeid = $msg['disid'];
                                    $useid = $msg['userid'];
                                    $itemdetail = $msg['itemdetail'];
                                    $sellername = $msg['sname'];
                                    $usename = $msg['uname'];
                                    $amount = $msg['totprice'];
                                    $money = $msg['money'];
                                    $newstatus = $msg['newstatus'];
                                    $newstatusup = $msg['newstatusup'];
                                    $usernames = $msg['username_url'];
                                    $item_title_url = $msg['item_title_url'];
                                    $createdate = date("d/m/Y",$msg['orderdatedisp']);
               
                                 ?>
                                 <tr>  
                                    <td class="p-l-20"><?php echo ++$i; ?></td>
                                    <?php if($useid == $usid) { ?>        
                                       <td><span style="color:#66B5D2;">#<?php echo $disputeid;?></span></td>
                                    <?php } else { ?>
                                       <td><span style="color: #9f9f9f;">#<?php echo $disputeid;?></span></td>
                                    <?php }?>

                                    <?php if(!empty($createdate)) { ?>
                                      <td class="p-l-20" style="color: #9f9f9f;"><?php echo $createdate; ?></td>
                                    <?php } else { ?>
                                      <td class="p-l-20" style="color: #9f9f9f;"><?php echo " - "; ?></td>
                                    <?php } ?>

                                    <?php /* if($useid == $usid) { ?> 
                                       <td> <?php if($itemdetail == 'null') {
                                          echo '<span style="color: #66B5D2;">'; echo $msro;echo '</span>';
                                       } else {
                                          $subjects = json_decode($itemdetail,true);
                                          foreach($subjects as $key=>$sub) { 
                                            if((trim($sub)!="")) { ?>

                                             <span style="color:#66B5D2;"><?php  echo $sub;  ?></span><br/>
                                          <?php 
                                          } }
                                       } ?>
                                       </td>
                                    <?php } else { ?>
                                       <td> 
                                          <?php if($itemdetail == 'null') {
                                             echo '<span style="color: #9f9f9f;">';
                                             echo $msro;echo '</span>';
                                          } else { 
                                             $subjects = json_decode($itemdetail, true);
                                             foreach($subjects as $key=>$sub) { 
                                              if((trim($sub)!="")) { ?>
                                                <span style="color: #9f9f9f;"><?php  echo $sub; ?></span><br/>
                                              <?php 
                                              } }
                                          } ?>
                                       </td>
                                    <?php } */ ?>

                                    <?php if($useid == $usid) { ?>
                                       <td style="width:200px; text-overflow: ellipsis; word-wrap: break-word; overflow:hidden; color:#66B5D2;">
                                          <?php echo $sellername; ?>
                                       </td>
                                    <?php } else { ?>
                                       <td style="width:200px; text-overflow: ellipsis; word-wrap: break-word; overflow:hidden; color: #9f9f9f;"><?php echo $usename;?>
                                       </td>
                                    <?php } ?>

                                    <?php if($useid == $usid) { ?>
                                       <td class="p-l-20">
                                          <span style="color:#66B5D2;">
                                          <?php echo $amount .' ' .$currencyCode;?></span>
                                       </td>
                                    <?php } else { ?> 
                                       <td class="p-l-20">
                                          <span style="color: #9f9f9f;">
                                          <?php echo $amount .' '.$currencyCode;?>
                                          </span>
                                       </td>
                                    <?php } ?>

                                    <?php if($useid == $usid) { ?>     
                                    <td>  
                                        <?php 
                                        if($newstatusup == 'Reply') {
                                          echo '<span style="color: #66B5D2;">';
                                          echo __d('merchant','Responded');
                                          echo '</span>';
                                        }elseif($newstatusup == 'Responded'){
                                          echo '<span style="color: #66B5D2;">';
                                          echo __d('merchant','Reply');
                                          echo '</span>';
                                        }elseif($newstatusup == 'Admin'){
                                          echo '<span style="color: #66B5D2;">';
                                          echo __d('merchant','Reply');
                                          echo '</span>';
                                        } else{
                                          echo '<span style="color: #66B5D2;">';
                                          echo __d('merchant',$newstatusup);
                                          echo '</span>'; 
                                       }?>
                                    </td>   
                                    <?php } else { ?>
                                    <td>
                                       <?php 
                                       if($newstatusup == 'Reply'){
                                          echo '<span style="color: #9f9f9f;">';
                                          echo __d('merchant','Reply');
                                          echo '</span>';
                                       } elseif($newstatusup == 'Responded') {
                                          echo '<span style="color: #9f9f9f;">';
                                          echo __d('merchant','Responded');
                                          echo '</span>';
                                       } elseif($newstatusup == 'Admin') {
                                          echo '<span style="color: #9f9f9f;">';
                                          echo __d('merchant','Reply');
                                          echo '</span>';
                                       } else {
                                          echo '<span style="color: #9f9f9f;">';
                                          echo __d('merchant',$newstatusup);  
                                          echo '</span>';
                                       }?>
                                    </td>   
                                    <?php } ?>

                                    <?php if($useid == $usid) { ?>         
                                       <td>
                                          <a href="<?php echo MERCHANT_URL; ?>/disputemessage/<?php echo $msro;?>"> 
                                             <span class="btn btn-success">
                                                <i class="fa fa-search-plus"></i>
                                             </span> 
                                          </a>
                                       </td>
                                    <?php } else { ?>
                                       <td>
                                          <a href="<?php echo MERCHANT_URL; ?>/disputeBuyer/<?php echo $msro;?>"> 
                                             <span class="btn btn-success">
                                                <i class="fa fa-search-plus"></i>
                                             </span>
                                          </a>
                                       </td>
                                    <?php } ?>       
                                 </tr>
                              <?php  } } ?>    
                           </tbody>
                        </table>

                        <?php if (count($messagesel) > 9) { ?>
                           <div class="loadmorecomment" onclick="loadmorecomment('<?php echo $usid ?>')">
                                 <?php echo __d('merchant', 'Load More');?>
                                 <div class="morecommentloader">
                                    <img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading" />
                                 </div>
                           </div>
                        <?php } ?>

                <?php } else { ?>
                	<h6 class="card-title text-center"><?php echo __d('merchant', 'No Conversation Found'); ?></h6>
                <?php } } ?>




                <?php if(isset($_REQUEST['seller'])) { 
                        if (!empty($messagebuyer)) { ?>
                           <table class="table color-table info-table">
                           <thead>
                               <tr>
                           <th class = "p-l-20 "><?php echo __d('merchant', '#');?></th>
                           <th><?php echo __d('merchant', 'Dispute Id');?></th>
                           <th><?php echo __d('merchant', 'Dispute On');?></th>
                           <th><?php echo __d('merchant', 'Other Party');?></th>
                           <th><?php echo __d('merchant', 'Dispute Amount');?></th>
                           <th><?php echo __d('merchant', 'Status');?></th>
                           <th><?php echo __d('merchant', 'Actions');?></th>
                               </tr>
                           </thead>
                           <tbody class="myorderlisttbodyseller">
                           <?php   $i = 0;   
                              foreach($messagebuyer as $key => $msg) {
                                 if ($key < 10) {

                                    $msro = $msg['uorderid'];
                                    $usid = $loguser['id'];
                                    $disputeid = $msg['disid'];
                                    $useid = $msg['userid'];
                                    $selid = $msg['selid'];
                                    $itemdetail = $msg['itemdetail'];
                                    $sellername = $msg['sname'];
                                    $usename = $msg['uname'];
                                    $amount = $msg['totprice'];
                                    $money = $msg['money'];
                                    $newstatus = $msg['newstatus'];
                                    $newstatusup = $msg['newstatusup'];
                                    $usernames = $msg['username_url'];
                                    $item_title_url = $msg['item_title_url'];
                                    $createdate = date("d/m/Y",$msg['orderdatedisp']);
               
                                 ?>
                                 <tr>
                                    <td class="p-l-20"><?php echo ++$i; ?></td>
                                    <?php if($usid != $selid) { ?>        
                                       <td><span style="color:#66B5D2;">#<?php echo $disputeid;?></span></td>
                                    <?php } else { ?>
                                       <td><span style="color: #9f9f9f;">#<?php echo $disputeid;?></span></td>
                                    <?php } ?>
                                 
                                    <?php if(!empty($createdate)) { ?>
                                      <td class="p-l-20" style="color: #9f9f9f;"><?php echo $createdate; ?></td>
                                    <?php } else { ?>
                                      <td class="p-l-20" style="color: #9f9f9f;"><?php echo " - "; ?></td>
                                    <?php } ?>

                                    <?php /* if($usid != $selid) { ?> 
                                       <td> <?php if($itemdetail == 'null') {
                                          echo '<span style="color: #66B5D2;">'; echo $msro;echo '</span>';
                                       } else {
                                          $subjects = json_decode($itemdetail,true);
                                          foreach($subjects as $key=>$sub) {
                                              if((trim($sub)!="")) { ?>

                                             <span style="color:#66B5D2;"><?php  echo $sub;  ?></span><br/>
                                          <?php 
                                          } }
                                       } ?>
                                       </td>
                                    <?php } else { ?>
                                       <td> 
                                          <?php if($itemdetail == 'null') {
                                             echo '<span style="color: #9f9f9f;">';
                                             echo $msro;echo '</span>';
                                          } else { 
                                             $subjects = json_decode($itemdetail, true);
                                             foreach($subjects as $key=>$sub) {
                                              if((trim($sub)!="")) { ?>
                                                <span style="color: #9f9f9f;"><?php  echo $sub; ?></span><br/>
                                              <?php 
                                              } }
                                          } ?>
                                       </td>
                                    <?php } */ ?>

                                    <?php if($usid != $selid) { ?>
                                       <td style="width:200px; text-overflow: ellipsis; word-wrap: break-word; overflow:hidden; color:#66B5D2;">
                                          <?php echo $sellername; ?>
                                       </td>
                                    <?php } else { ?>
                                       <td style="width:200px; text-overflow: ellipsis; word-wrap: break-word; overflow:hidden; color: #9f9f9f;"><?php echo $usename;?>
                                       </td>
                                    <?php } ?>

                                    <?php if($usid != $selid) { ?>
                                       <td class="p-l-20">
                                          <span style="color:#66B5D2;">
                                          <?php echo $amount .' ' .$currencyCode;?></span>
                                       </td>
                                    <?php } else { ?> 
                                       <td class="p-l-20">
                                          <span style="color: #9f9f9f;">
                                          <?php echo $amount .' '.$currencyCode;?>
                                          </span>
                                       </td>
                                    <?php } ?>

                                    <?php if($usid != $selid) { ?>     
                                    <td>  
                                        <?php 
                                        if($newstatusup == 'Reply') {
                                          echo '<span style="color: #66B5D2;">';
                                          echo __d('merchant','Responded');
                                          echo '</span>';
                                        }elseif($newstatusup == 'Responded'){
                                          echo '<span style="color: #66B5D2;">';
                                          echo __d('merchant','Reply');
                                          echo '</span>';
                                        }elseif($newstatusup == 'Admin'){
                                          echo '<span style="color: #66B5D2;">';
                                          echo __d('merchant','Reply');
                                          echo '</span>';
                                        } else{
                                          echo '<span style="color: #66B5D2;">';
                                          echo __d('merchant',$newstatusup);
                                          echo '</span>'; 
                                       }?>
                                    </td>   
                                    <?php } else { ?>
                                    <td>
                                       <?php 
                                       if($newstatusup == 'Reply'){
                                          echo '<span style="color: #9f9f9f;">';
                                          echo __d('merchant','Reply');
                                          echo '</span>';
                                       } elseif($newstatusup == 'Responded') {
                                          echo '<span style="color: #9f9f9f;">';
                                          echo __d('merchant','Responded');
                                          echo '</span>';
                                       } elseif($newstatusup == 'Admin') {
                                          echo '<span style="color: #9f9f9f;">';
                                          echo __d('merchant','Reply');
                                          echo '</span>';
                                       } else {
                                          echo '<span style="color: #9f9f9f;">';
                                          echo __d('merchant',$newstatusup);  
                                          echo '</span>';
                                       }?>
                                    </td>   
                                    <?php } ?>

                                    <?php if($usid != $selid) { ?>         
                                       <td>
                                          <a href="<?php echo MERCHANT_URL; ?>/disputemessage/<?php echo $msro;?>"> 
                                             <span class="btn btn-success">
                                                <i class="fa fa-search-plus"></i>
                                             </span> 
                                          </a>
                                       </td>
                                    <?php } else { ?>
                                       <td>
                                          <a href="<?php echo MERCHANT_URL; ?>/disputeBuyer/<?php echo $msro;?>"> 
                                             <span class="btn btn-success">
                                                <i class="fa fa-search-plus"></i>
                                             </span>
                                          </a>
                                       </td>
                                    <?php } ?>       
                                 </tr>
                              <?php  } } ?>    
                           </tbody>
                        </table>

                        <?php if (count($messagebuyer) > 9) { ?>
                           <div class="loadmorecomment" onclick="sellercomment('<?php echo $usid ?>')">
                                 <?php echo __d('merchant', 'Load More');?>
                                 <div class="morecommentloader">
                                    <img src="<?php echo SITE_URL; ?>images/loading.gif" alt="Loading" />
                                 </div>
                           </div>
                        <?php } ?>

                <?php } else { ?>
                  <h6 class="card-title text-center"><?php echo __d('merchant', 'No Conversation Found'); ?></h6>
                <?php } } ?>
                </div>
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
.card .card-block .text-themecolor .rightTitle {
   padding: 2px 0px;    display: inline-block;
}
.card .card-block .text-themecolor ul.nav-pills>li>a.active
{
    background-color: rgb(25, 153, 235);
}
tbody.myorderlisttbody tr td,tbody.myorderlisttbodyseller tr td
{
   font-weight: 500 !important;
}
.loadmorecomment {
   font-size: 12px;font-weight: bold; margin: 25px 0px 0px 0px; cursor: pointer;
   display: inline-block; font-size:12px; color: #cccccc; 
}
.loadmorecomment:hover, .loadmorecomment:focus {
   color: rgb(25, 153, 235); 
}
.morecommentloader {
   display: none;
}
ul li.nav-item > a {
   font-weight: 500;
}
</style>

<script type="text/javascript">
   var crntcnt = '<?php echo count($messagesel); ?>';
   var order_id = '<?php echo $usid; ?>';
   var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecnt = 2;
   var baseurl = getBaseURL();

   function getcurrentcmnt() {
         cmntupdate = 0;
         $.ajax({
            url: baseurl+'merchant/getrecentdispallbuyer',
            type: 'POST',
            dataType: 'html',
            data: {'currentcont': crntcnt, 'order_id': order_id, 'contact': 'buyer'},
            success: function(responce) {
               if($.trim(responce)=='false' || $.trim(responce)=='') {
                  cmntupdate = 1;
               } else {
                  var output = eval(responce);
                  crntcnt = output[0];
                   var currentmsg = output[1];
                    $('.myorderlisttbody').html(currentmsg);
                    cmntupdate = 1;
               }
            }
         });
      console.log('Calling recursive function');
   }
   
   setInterval(getcurrentcmnt, 500000);

   function loadmorecomment(uid) {
      if (loadmoreajax == 1 && loadmore == 1){
         loadmoreajax = 0;
         $.ajax({
            url: baseurl+'merchant/getmorecommentview',
            type: 'POST',
            dataType: 'html',
            data: {'offset': loadmorecnt,'contact':'buyer','order_id':order_id, 'dcount': crntcnt},
            beforeSend: function(){
               $('.morecommentloader img').show();
            },
            success: function(responce){
               $('.morecommentloader img').hide();
               if($.trim(responce)=='false' || $.trim(responce)==''){
                  loadmore = 0;
                  loadmoreajax = 1;
                  $('.loadmorecomment').html('No More Disputes');
                  $('.loadmorecomment').css('cursor','default');
               }else{
                  var output = eval(responce);
                  $('.myorderlisttbody').append(output[1]);
                  crntcnt = output[0]+parseInt(crntcnt);
                  loadmoreajax = 1;
                  loadmorecnt += 1;
               }
            }
         });
      }
   }  
</script>


<script type="text/javascript">
   var crntcommentcnt = '<?php echo count($messagebuyer); ?>';
   var order_id = '<?php echo $usid; ?>';
   //alert (order_id);
   var cmntupdate = 1, loadmoreajax = 1, loadmore = 1, loadmorecmntcnt = 2;
   var baseurl = getBaseURL();

   function getcurrentsellercmnt(){
      cmntupdate = 0;
      $.ajax({
         url: baseurl+'merchant/getrecentdispallseller',
         type: 'POST',
         dataType: 'html',
         data: {'currentcont': crntcommentcnt, 'order_id': order_id, 'contact': 'buyer', },
         success: function(responce){
            if($.trim(responce)=='false' || $.trim(responce)=='') {
                  cmntupdate = 1;
            } else {
               var output = eval(responce);
               crntcommentcnt = output[0];
                var currentmsg = output[1];
                 $('.myorderlisttbodyseller').html(currentmsg);
                 cmntupdate = 1;
            }
         }
      });
      console.log('Calling recursive function');
   }
   
   setInterval(getcurrentsellercmnt, 500000);

   function sellercomment(sid){
      if (loadmoreajax == 1 && loadmore == 1){
         loadmoreajax = 0;
         $.ajax({
            url: baseurl+'merchant/getmorecommentviewseller',
            type: 'POST',
            dataType: 'html',
            data: {'offset': loadmorecmntcnt, 'contact':'buyer', 'order_id':order_id, 'dcount': crntcommentcnt},
            beforeSend: function(){
               $('.morecommentloader img').show();
            },
            success: function(responce){
               $('.morecommentloader img').hide();

               if($.trim(responce)=='false' || $.trim(responce)==''){
                  loadmore = 0;
                  loadmoreajax = 1;
                  $('.loadmorecomment').html('No More Disputes');
                  $('.loadmorecomment').css('cursor','default');
               }else{
                  var output = eval(responce);
                  $('.myorderlisttbodyseller').append(output[1]);
                  crntcommentcnt = output[0]+parseInt(crntcommentcnt);
                  loadmoreajax = 1;
                  loadmorecmntcnt += 1;
               }
            }
         });
      }
   }
   
</script>

