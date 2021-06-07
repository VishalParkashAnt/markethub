<?php
use Cake\Routing\Router;
?>


  <body class="">
  <!--<![endif]-->

<div class="content">
<?php
$baseurl = Router::url('/');
?>

			<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Contact Seller Subject'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>contactsellersubject"><?php echo __d('admin', 'Contact Seller Subject'); ?></a></li>

                                    </ol>
                                </div>


         </div>
    </div>






    <?php //echo $this->Form->create('Dispplm', array( 'id'=>'rlyadmsg1','onsubmit'=>'return rlyadmsg()')); ?>
    <?php echo $this->Form->Create('Dispplm',array('url'=>array('controller'=>'/','action'=>'/admins/addsubject/'.$id),'id'=>'rlyadmsg1','onsubmit'=>'return rlyadmsg();'));?>
    	<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Add Subject'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-6">
    <div class="form-group">
    <input type="text" name="subject" id="message" value="<?php echo $query;?>" class="form-control">
 </div>
 <?php //echo "<div id='doalert' class='doalert' style='color:red;float:right;height:0px;padding:5px 725px 0px 0px;'></div>"; ?>
  <?php
			echo $this->Form->submit(__d('admin', 'Save'),array('class'=>'btn btn-info'));
		echo $this->Form->end();

?>
 <div id="doalert" class="trn" style="color: red; font-size: 13px; padding-top: 10px; display: none;"></div>
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
