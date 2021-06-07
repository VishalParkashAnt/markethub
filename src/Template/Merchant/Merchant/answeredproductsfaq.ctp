<?= $this->Html->css('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>
<?= $this->Html->script('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>

<div class="row page-titles m-b-20">
  <div class="col-md-6 col-lg-12 align-self-center">
      <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Manage Products FAQ'); ?></h3>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo MERCHANT_URL;?>/dashboard">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo __d('merchant','Manage Products FAQ'); ?></a></li>
      </ol>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <!-- h4 class="card-title">Data Table</h4 -->
                <h4 class="text-themecolor m-b-0 m-t-0"><?php echo __d('merchant','Products'); ?></h4>
                <hr/>
                <div class="prvcmntcont m-t-30">
                  <?php 
                  //echo '<pre>'; print_r($faq_datas); die;
                  if (count($faq_datas) > 0) { 
                      if($sdate!="" && $edate!="") {
                        $sdate = date("m/d/Y", strtotime($sdate));
                        $edate = date("m/d/Y", strtotime($edate));

                        //$sdate = "";
                        //$edate = "";

                      } else {
                        $sdate = "";
                        $edate = "";
                      }

                    ?>
                     <?php  echo '<span class="col-sm-3 p-l-0">'.__d('merchant','Date Filter').'</span>
                        <input type="text" id="sdate" class="form-control datepicker-autostart col-sm-3" placeholder="'.__d('merchant','Start Date').'" style="margin-top:7px;color:#555555! important;" value='.$sdate.'>
                        <input type="text" id="edate" class="form-control datepicker-autoend col-sm-3" placeholder="'.__d('merchant','End Date').'" style="margin-top:7px;color:#555555! important;" value='.$edate.'>

                        <!-- button class="btn btn-success" onclick="actionItem_datesearch()" style="vertical-align:inherit;">Search</button>

                        <a class="btn btn-info clearResult" href="'.MERCHANT_URL.'/updateproducts" style="vertical-align:inherit;">Reset</a -->';

                        ?>
                        <!-- small class="form-control-feedback f4-error f4-error-daterror m-t-20 col-sm-3"></small -->
                 

                <div class="table-responsive">

                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th class="p-l-10"><?php echo __('#');?></th>
			        			<!-- th><?php //echo __('Id');?></th -->
			        			<th><?php echo __d('merchant','Product Questions');?></th>
                    <th><?php echo __d('merchant','Created');?></th>
                    <th><?php echo __d('merchant','Actions');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $incre = 0;
               foreach($faq_datas as $key=>$temp) {
                  
                  
                  $size_options ="";
                  if(!empty($temp['size_options']))
                     
                     echo "<tr id='item".$temp->id."'>";
                     //echo "<td>".$item_id."</td>";
                     echo "<td class='p-l-10'>".++$incre."</td>";
                     echo "<td style='max-width: 150px;word-break: break-all;text-overflow: ellipsis;'>".$temp->content."</td>";
                     echo "<td>".date("m/d/Y",strtotime($temp['created_on']))."</td>";
                    
                     echo '<td style="min-width:175px !important;"><a class="viewitem" href="javascript:void(0);" id="'.$temp->id.'" onclick="postyouranswer(this);"><span class="btn btn-success"><i class="fa fa-search-plus"></i></span></a>';
                           //    if($demo_active!="yes")
                               echo '<a onclick = "deletefaq('.$temp->id.');" role="button" data-toggle="modal" style="cursor:pointer;" class="m-l-5"><span class="btn btn-danger"><i class="fa fa-trash"></i></span></a>';
                               echo '</td>';
                  echo "</tr>";
               }
             ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                	<h6 class="card-title text-center m-t-30 m-b-30"><?php echo __d('merchant','No Questions Available');?></h6>
                <?php }?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<div id="postyouranswer" class="modal fade" role="dialog">
        <div class="modal-dialog downloadapp-modal">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="write-comment-container">
                <h2 class="bold-font margin-bottom10">
                  Post your answer <label class="primary-color-txt" id="item_title"></label>
                </h2>
                <form method="post" action="<?php echo SITE_URL.'merchant/submitanswer';?>">
                <div id="item_datas"></div>
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $loguser['id']; ?>" />
                <div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
                <div id="errorspan_question"></div>
                  <textarea class="form-control" rows="5" id="questions" maxlength="180"
                    onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"
                    autocomplete="off" name="content" placeholder="Write a Question about"></textarea>
                  <div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
                    <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0"
                      role="menu" style="border:none;"></ul>
                  </div>
                  <div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
                    <button class="btn filled-btn follow-btn primary-color-bg bold-font pull-right margin-top10"
                      data-dismiss="modal">
                      CANCEL</button>
                      <!-- onclick ="return questionsubmit();" -->
                    <button type="submit" id="commentssave" 
                      class="btn filled-btn follow-btn bold-font primary-color-bg pull-right margin-top10">
                      Post YourQuestion</button>
                  </div>
                  <div id="cmnterr"
                    style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px">
                    Please enter comment</div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

<script>
/*var o = document.getElementById( 'sdate' );
  o.addEventListener( 'keydown', function( e ) {
      if( e.keyCode >= 37 && e.keyCode <= 40 ) {
          return; // arrow keys
      }
      if( e.keyCode === 8 || e.keyCode === 46 ) {
          return; // backspace / delete
      }
      e.preventDefault( );
  }, false );*/

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
      dom: 'Bfrtip'
  });

  $('#sdate, #edate').change(function () {
      table.draw();
  });


</script>
