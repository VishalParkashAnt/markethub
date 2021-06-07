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
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'User'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>contacteditem"><?php echo __d('admin', 'Manage Seller Chat'); ?></a></li>
                                          <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>contacteditem"><?php echo __d('admin', 'Item Conversation Users'); ?></a></li>
                                       
                                    </ol>
                                </div>

             
         </div>
    </div>

		<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'User Conversation'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="row">
                        <div class="col-md-12">

    
<div class="btn-toolbar">
	<a href="<?php echo SITE_URL.'deletecsconversation/'.$csid.'/'.$itemid; ?>" ><button class="btn btn-info"><i class="mdi mdi-delete"></i> <?php echo __d('admin', 'Delete Conversations'); ?> </button></a>
	</div><br>

   
   

<?php	

	echo "<div class='containerdiv'>";
		
	
  		echo "<div id='searchite'>";
			echo "<div class='conversation'>";
				foreach ($csmessageModel as $csmessage){
					foreach ($contactsellerModel as $contactseller)
					{

					if ($csmessage['sentby'] == 'buyer'){
						$contactPerson = $contactseller['buyername'];
					}else{
						$contactPerson = $contactseller['sellername'];
					}
				}
					echo $contactPerson." : ".$csmessage['message']."</br></br>";
				}
			echo "</div>";
		echo "</div>";
		
	echo "</div>";
?>		</div>
				</div>
			
			</div>
						



     </div></div></div>
     

    
        </div>
    </div>
</div>
    


   
    
  </body>
</html>
