<style>
.errcls
{
	display: none;
}
.ui-autocomplete, ui-autocomplete-input {z-index:1000}
</style>
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
      <a href="#"><?php echo __d('user','Gift Card');?></a>
     
     </div>
    </div>
     
  </div>
    </div>
    <!-- breadcrumb end -->

<!-- GIFTCARD DETAILS-->
<?php
$getgiftcard = json_decode($setngs['giftcard'],true);
$giftcard_title = $getgiftcard['title'];
$giftcard_desc = $getgiftcard['description'];
$giftcard_image ='media/items/thumb150/'.$getgiftcard['image'];

?>
<div class="container margin_top165_mobile">
		<div id="sidebar" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 no-hor-padding sidebar is-affixed" style="">
			<div class="sidebar__inner border_right_grey" style="position: relative; ">
				<div class="mini-submenu profile-menu">
			        <!--<span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>-->
			    </div>
			 	<!--SETTINGS SIDEBAR PAGE-->
				<?php echo $this->element('settingssidebar'); ?>

    			<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

			</div>
		</div>

		<div id="content" class="col-lg-9 col-md-9 col-sm-12 col-xs-12 no-hor-padding clearfix min-height-profile">
			<div class="cnt-top-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="user_profile_inner_heading pro-title-head margin-bottom0 section_heading bold-font extra_text_hide fint-height col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo $setngs['site_name'].' '.__d('user','Gift Card');?> </h2>
							<p class="pro-title-head margin-top0 col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php echo __d('user','Gather your friends and give amazing gifts from Fantacy to people you love.');?></p>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding popular-pdt-cnt margin_top0_tab margin0_mobile clearfix">

							<div class="gift-card">
								<ul class="nav nav-pills border_bottom_grey home-page-tab col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<li class="active"><a class="" data-toggle="pill" href="#create-new"><?php echo __d('user','Create New');?></a></li>
									<li class=""><a class="" data-toggle="pill" href="#gift-card-list"><?php echo __d('user','Gift Card List');?></a></li>
								</ul>

								<div class="tab-content section_container col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top30 no-hor-padding">
									<div id="create-new" class="tab-pane fade in active">
										<div class="section_container clearfix">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top10 padding-bottom30 no-hor-padding">
												<div id="giftcard-bg" class="giftcard-img"  style="background:url('<?php echo $giftcard_image; ?>');background-repeat: no-repeat;">
													<div class="bubble white-txt">
														
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<h5 class="bold-font text-center txt-uppercase col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<?php echo  $giftcard_title; ?> </h5>
												<p class="text-center col-xs-12 col-sm-10 col-md-10 col-lg-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
													<?php echo  $giftcard_desc; ?></p>
											</div>
											<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 padding-top40 no-hor-padding">
											<form method="post" action="<?php echo $baseurl.'braintree/checkouttokengift/';?>" onsubmit="return giftcardchk();">
												<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
															<?php
															$currency_symbol=$_SESSION['default_currency_symbol'];
															$currency_code=$_SESSION['default_currency_code'];
															if(isset($_SESSION['currency_code'])){
																$currency_symbol=$_SESSION['currency_symbol'];
																$currency_code=$_SESSION['currency_code'];
															}
															?>
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
																<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Value');?></div>
																<div class="selectdiv divtwo">
																<?php $amount = explode(',', $item_datas['amounts']);
																//print_r($amount);?>
																 <select name="gift_amount" id="gift_amount" onchange="ChangeGiftCurrency(this.value);";>
																	  <option value=""><?php echo __d('user','Select Amount');?></option>
																	<?php for($i=0;$i<count($amount);$i++){
																	echo '<option value="'.$amount[$i].'">&#x200E;'.$currency_symbol.' '.$amount[$i].'</option>';
																	}?>
																  </select>
																	<span id="gifterr" class="errcls red-txt"> <?php echo __d('user','Please select the gift amount'); ?></span>
																	<input type="hidden" name="giftcard_currencycode" value="<?php echo $currency_code;?>"/>

																</div>
															</div>
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-hor-padding">
															<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font"><?php echo __d('user','Recipient');?></div>
																<div class="divtwo">
																  <input class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" name="gift_recipient" id="gift_recipient" placeholder="<?php echo __d('user','Recipient name');?>"
																  value="" type="text" autocomplete="off"
																  oninput="autocompleteusername();">
																</div>
																<?php
																    echo '<div class="comment-autocompleteemail comment-autocompleteemailN col-lg-12 no-padding" style="display: none;">';
																	echo '<ul class="usersearchemail col-lg-12 no-padding">';

																	echo '</ul>';
																	echo '</div>';
																?>

															</div>
															<div id="recipNameErr" class="errcls red-txt"><?php echo __d('user','Please select the recipient to gift');?></div>
													</div>
													<div class="email-addr padding-bottom15 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding adres-alighn">
														<div class="popup-label-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding bold-font">
														<?php echo __d('user','Personal Message');?></div>
														<textarea maxlength="250" class="popup-input col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" rows="4" id="gift_message" name="gift_message" placeholder="<?php echo __d('user','Type your message');?>"></textarea>
														<div id="messageErr" class="errcls red-txt"><?php echo __d('user','Please enter your message');?></div>

													</div>

													<div class="padding-top15 margin-both5 clearfix">
														<div class="">
															<div class="footer-acnt-save">
																<div class="btn primary-color-bg bold-font pull-right">
																	<input class="txt-uppercase btn-primary-inpt" id="paygiftcard" value="<?php echo __d('user','Pay');?>" type="submit">
																</div>
															</div>
														</div>
													</div>
												</form>
											</div>

										</div>
									</div>

									<div id="gift-card-list" class="tab-pane fade">
										<div class="section_container clearfix">

										<div class="display_none">
											<div class="text-center padding-top30 padding-bottom30">
												<div class="outer_no_div">
													<div class="empty-icon no-gift"></div>
												</div>
												<h5><?php echo __d('user','No Gift card list'); ?></h5>
											</div>
										</div>

										<div class="disput-table div-cover-box">
											<ul class="nav nav-pills home-page-tab col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<li class="active"><a class="" data-toggle="pill" href="#sent-card"><?php echo __d('user','Sent');?></a></li>
												<li class=""><a class="" data-toggle="pill" href="#recieved-card"><?php echo __d('user','Received');?></a></li>
											</ul>
											<div class="tab-content section_container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<div id="sent-card" class="tab-pane fade in active">
													<div class="section_container">
														<div class="table-responsive">
														<?php
													  echo '<table id="giftcard_sent" class="giftcardTable table table-hover animate-box fadeInDown animated table-customize">
														<thead>
															<th>'.__d('user','Receiver').'</th>
															<th>'.__d('user','Date').'</th>
															<th>'.__d('user','Message').'</th>
															<th>'.__d('user','Total Amount').'</th>
															<th>'.__d('user','Available Amount').'</th>
															<th>'.__d('user','Key').'</th>
															<th>'.__d('user','Status').'</th>
														</thead>
														<tbody>';
													if (count($giftcarddets)>0) {
															if(isset($_SESSION['currency_code'])){
																$currency_symbol =  $_SESSION['currency_symbol'];
																$currency_rate=$_SESSION['currency_value'];
															}
															else{
																$currency_symbol =$_SESSION['default_currency_symbol'];
																$currency_rate=$_SESSION['default_currency_value'];
															}
													foreach($giftcarddets as $gif){

													

														
														$gift_amount = $currencycomponent->conversion($gif['forexrate']['price'],$currency_rate,$gif['amount']);
														$gift_avail_amount = $currencycomponent->conversion($gif['forexrate']['price'],$currency_rate,$gif['avail_amount']);
															echo '<tr>';
															if($gif['reciptent_name']=="")
																echo '<td>'.__d('user','Removed User').'</td>';
															else
																echo '<td>'.$gif['reciptent_name'].'</td>';
															echo '<td>'.date('m/d/Y',$gif['cdate']).'</td>
																<td><div style="word-break:break-all;">'.$gif['message'].'</div></td>
																<td>&#x200E;'.$currency_symbol.' '.$gift_amount.'</td>
																<td>&#x200E;'.$currency_symbol.' '.$gift_avail_amount.'</td>
																<td class="primary-color-txt">'.$gif['giftcard_key'].'</td>
																<td>'.__d('user','Sent').'</td>
															</tr>';
													}}
													else{
														echo '<tr><td colspan="7">'.__d('user','No gift cards sent').'</td></tr>';
													}

														echo '</tbody>
													</table>';


													?>
														</div>
														<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20">
															<a href=""></a>
														</div>
													</div>
												</div>

												<div id="recieved-card" class="tab-pane fade in">
													<div class="section_container">
													<div class="table-responsive">
														<?php
													echo '<table id="giftcard_rec" class="giftcardTable table table-hover animate-box fadeInDown animated table-customize">
													<thead>
													<th>'.__d('user','Receiver').'</th>
													<th>'.__d('user','Date').'</th>
													<th>'.__d('user','Message').'</th>
													<th>'.__d('user','Total Amount').'</th>
													<th>'.__d('user','Available Amount').'</th>
													<th>'.__d('user','Key').'</th>
													<th>'.__d('user','Status').'</th>
													</thead>
													<tbody>';
													if (count($giftcarddets_recv)>0) {

														if(isset($_SESSION['currency_code'])){
																$currency_symbol =  $_SESSION['currency_symbol'];
																$currency_rate=$_SESSION['currency_value'];
															}
															else{
																$currency_symbol =$_SESSION['default_currency_symbol'];
																$currency_rate=$_SESSION['default_currency_value'];
															}
													foreach($giftcarddets_recv as $gif)
													{

														$gift_amount = $currencycomponent->conversion($gif['forexrate']['price'],$currency_rate,$gif['amount']);
														$gift_avail_amount = $currencycomponent->conversion($gif['forexrate']['price'],$currency_rate,$gif['avail_amount']);
													echo '<tr>';
													if($gif['user']['username']=="")
													echo '<td>'.__d('user','Removed User').'</td>';
													else
													echo '<td>'.$gif['user']['username'].'</td>';
													echo '<td>'.date('m/d/Y',$gif['cdate']).'</td>
													<td><div style="word-break:break-all;">'.$gif['message'].'</div></td>
													<td>&#x200E;'.$currency_symbol.' '.$gift_amount.'</td>
													<td>&#x200E;'.$currency_symbol.' '.$gift_avail_amount.'</td>
													<td class="primary-color-txt">'.$gif['giftcard_key'].'</td>
													<td>'.__d('user','Received').'</td>
													</tr>';
													}}

													else{
														echo '<tr><td colspan="7">'.__d('user','No gift cards received').'</td></tr>';
													}

													echo '</tbody>
													</table>';

													?>
														</div>
														<div class="centered-text col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top20">
															<a href=""></a>
														</div>
													</div>
												</div>
											</div>
										</div>
										</div>
									</div>

								</div>
							</div>
					</div>
		</div>

		<object style="display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%;overflow: hidden; pointer-events: none; z-index: -1;" type="text/html"></object>

	</div>
	<style type="text/css">
	.dropdown-menu > li > div {
	clear: both;
	color: #333;
	display: block;
	font-weight: 400;
	line-height: 1.42857;
	padding: 3px 20px;
	white-space: nowrap;
	}

	.addposition{
		position: relative !important;
		text-decoration: none;
	}

	.dropdown-menu > li > div {
	display: block;
	padding: 3px 20px;
	clear: both;
	font-weight: normal;
	line-height: 1.42857143;
	color: #333;
	white-space: nowrap;
	}
	.dropdown-menu > li > div:hover,
	.dropdown-menu > li > div:focus {
	color: #262626;
	text-decoration: none;
	background-color: #f5f5f5;
	}
	.dropdown-menu > .active > div,
	.dropdown-menu > .active > div:hover,
	.dropdown-menu > .active > div:focus {
	color: #fff;
	text-decoration: none;
	background-color: #337ab7;
	outline: 0;
	}
	.dropdown-menu > .disabled > div,
	.dropdown-menu > .disabled > div:hover,
	.dropdown-menu > .disabled > div:focus {
	color: #777;
	}
	.dropdown-menu > .disabled > div:hover,
	.dropdown-menu > .disabled > div:focus {
	text-decoration: none;
	cursor: not-allowed;
	background-color: transparent;
	background-image: none;
	filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
	}
	</style>



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
    $('.giftcardTable').DataTable({
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
