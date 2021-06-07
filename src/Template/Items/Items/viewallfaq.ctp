<section class="container margin_top165_mobile">
	
	<section class="breadcrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin_top_150_tab margin-md0 margin-top10 margin-bottom10">
                <div class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="breadcrumb-divider1">/</span>
                    <a href="<?php echo $item_url; ?>"><?php echo substr($item_data->item_title, 0, 40); ?>
                    	</a>
                    <span class="breadcrumb-divider1">/</span>
                    <!-- <a href="#" style="text-transform:capitalize;" id="changecatname">Faq</a> -->
                    <span>Faq</span>
                </div>
            </section>


 <div class="product-page-row col-xs-12 col-sm-12 no-hor-padding "
                style="background-color: #ffffff;">


                <div class="prod_abt_QA">

                    <h2 class="section_heading bold-font txt-uppercase">
                    <a href="<?php echo $item_url; ?>"><?php echo $item_data->item_title; ?>
                    	</a>
                    </h2>

                </div>

                <hr />

                <div class="ques-ans_sec">

                    <div>
                        <h2 class="section_heading bold-font"><?php echo __d('user','Questions and Answers'); ?></h2>

                    </div>

                   
                        <div>
                        <?php
                        	if(empty($loguser['id']))
                        	{
                        		?>
                        		<a href="<?php echo SITE_URL.'login'; ?>"
                                class="col-xs-12 col-sm-12 QA_viewall btn primary-color-border-btn prod-detail-btn bold-font"
                                > <?php echo __d('user','Post a Question'); ?></a>
                        		<?php
                        	}else{
                        		?>
                        		<a href="javascript:void(0);"
                                class="col-xs-12 col-sm-12 QA_viewall btn primary-color-border-btn prod-detail-btn bold-font"
                                data-toggle="modal" data-target="#postaquestion"><?php echo __d('user','Post a Question'); ?></a>
                        		<?php
                        	}
                        ?>
                            
                        </div>
                    


                </div>

                <hr>

                <?php
                echo '<input type="hidden" id="loguserid" value="' . $loguser['id'] . '">';
                foreach($productfaq as $faq_key=>$faq_value)
				{
				?>
					<div>
					<div class="ques-ans_sec">

						<div class="quanswre">

							<h2> Q: <?php echo $faq_value['content']; ?></h2>
								<?php
									if($order_id != '' && !isset($faq_value['answer']))
									{
										if($faq_value['user_id'] == $loguser['id'])
										{
											echo '<p class="ans_sty"> <strong>'.__d('user','No Answer').'</strong> </p>';
										}elseif($faq_value['user_id'] != $loguser['id']){
											?>
												<a href="javascript:void(0);" class="view_QA"  onclick="read_other_answers(<?php echo $faq_value['question_id']; ?>, '<?php echo substr($faq_value['content'], 0, 4); ?>');"><?php echo __d('user','Write answer'); ?></a>
											<?php
										}
									}elseif($order_id == '' && !isset($faq_value['answer']))
									{
										echo '<p class="ans_sty"> <strong>'.__d('user','No Answer').'</strong> </p>';
									}elseif(isset($faq_value['answer']) && $order_id != '')
									{
										$content = str_replace('<p dir="ltr">', '', $faq_value['answer']['content']);
							            $content = str_replace('</p>', '', $content);
										?>
										<p class="ans_sty"> <strong>A:</strong> <span> <?php echo $content; ?> </span>
										</p>
										
										<?php
									}elseif(isset($faq_value['answer']) && $order_id == ''){
										$content = str_replace('<p dir="ltr">', '', $faq_value['answer']['content']);
							            $content = str_replace('</p>', '', $content);
										?>
										<p class="ans_sty"> <strong>A:</strong> <span> <?php echo $content; ?> </span>
										</p>
									<?php }
								?>
						</div>
					</div>
					<div>
						<?php
							if((count($faq_value['answer']) != 0) && count($faq_value['answer']) > 1)
							{
						?>
								<a href="javascript:void(0);" class="view_QA"  onclick="read_other_answers(<?php echo $faq_value['question_id']; ?>, '<?php echo substr(base64_encode($faq_value['content']), 0, 4); ?>');"><?php echo __d('user','Read other answers'); ?>
								
								</a>
						<?php		
							}
						?>
					</div>
					<hr>				
					</div>
				<?php
				}
				?>
				<input type="hidden" name="faq_count" id="faq_count" value="<?php echo $faq_count; ?>" />
				<div id="appendfaq">
					
				</div>
				<input type="hidden" name="loadmorevalue" id="loadmorevalue" value="<?php echo count($productfaq); ?>" />
				<input type="hidden" name="item_id" id="item_id" value="<?php echo $item_data->id; ?>" />
				<input type="hidden" name="userid" id="userid" value="<?php echo $loguser['id']; ?>" />
                
				<?php
					if($faq_count > 10)
					{
						echo '<div class="load_more">
		                    <i class="more-less glyphicon glyphicon-plus"></i>
		                    <a href="javascript:void(0);" onclick="loadmorefaq();">Load more </a></div>';		
					}
				?>
                
        </section>


         <!-- reas othere answer modal popup  -->
		

		<div id="postaquestion" class="modal fade" role="dialog">
				<div class="modal-dialog downloadapp-modal">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-body">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<div class="write-comment-container">
								<h2 class="bold-font margin-bottom10">
									<?php echo __d('user','WRITE A QUESTION'); ?> <label class="primary-color-txt"><?php
									echo $item_data['item_title']; ?></label>
								</h2>

								<div class="comment-modal-cnt col-xs-12 col-sm-12 no-hor-padding margin-top10">
									<div id="errorspan_question"></div>
									<textarea class="form-control" rows="5" id="questions" maxlength="180"
										onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');"
										autocomplete="off" placeholder="<?php echo __d('user','Write a question about'); ?>"></textarea>
									<div class="comment-autocomplete comment-autocompleteN" style="top:126px;width:100%;">
										<ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0"
											role="menu" style="border:none;"></ul>
									</div>
									<div class="comment-modal-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
										<button class="btn filled-btn follow-btn primary-color-bg bold-font pull-right margin-top10"
											data-dismiss="modal">
											<?php echo __d('user','Cancel'); ?></button>
											<!-- onclick ="return questionsubmit();" -->
										<button href="javascript:void(0);" id="commentssave" onclick="return questionsubmit();"
											class="btn filled-btn follow-btn bold-font primary-color-bg pull-right margin-top10">
											<?php echo __d('user','Post Your Question'); ?></button>
									</div>
									<div id="cmnterr"
										style="font-size:13px;color:red;font-weight:bold;display:none;float:right;margin-right:34px">
										Please enter comment</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="read_answers" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class=" login-body modal-body clearfix">
						<button class="close" type="button" data-dismiss="modal">×</button>
						<div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
							<h2
								class="popupheder  bold-font txt-uppercase readansquestion col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								Q: how is look and feel ??</h2>
						</div>
						<div id="errorspan"></div>
						<?php
							if(isset($loguser['id']) && $order_id != '')
							{
								?>
								<div class="signup-left-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top30" id="answer_forms">
									<textarea name="answer" onkeyup="ajaxuserautoc(event,this.value, 'comment_msg','comment-autocompleteN','0');" id="answer" class="form-control" placeholder="Post your anwser"></textarea>
									<input type="hidden" name="question_id" id="question_id" />				
									
							<div>										
								<button onclick ="return answersubmit();" class="btn filled-btn follow-btn primary-color-bg bold-font pull-right margin-top10">
								Post your answer</button>
							</div>		
									
							</div>
								<?php
							}
						?>
						


						<div id="answer-list-question">
						<div class="modal_ques-ans_sec">

							<div class="quanswre">

								<p class="mod_ans_sty"> <strong>A:</strong> <span> Lorem ipsum dolor sit, quo. </span>
								</p>

								<p class="cus_nam">Anwar</p>


							</div>
						</div>
						<hr>
						<div class="modal_ques-ans_sec">

							<div class="quanswre">

								<p class="mod_ans_sty"> <strong>A:</strong>
									<span> Lorem ipsum dolor sit amet consectetur
										adipisicing elit. Dolorum itaque quidem,
										doloremque animi eius omnis cum sunt mollitia quibusdam assumenda. quo. </span>
								</p>

								<p class="cus_nam">Shivani</p>


							</div>
						</div>
						<hr>
						<div class="modal_ques-ans_sec">
							<div class="quanswre">
								<p class="mod_ans_sty"> <strong>A:</strong> <span>Lorem ipsum dolor sit, amet
										consectetur
										adipisicing elit. Amet, voluptatum! welmarikg lekpagko, quo. </span> </p>
								<p class="cus_nam">Anjali</p>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>