 <?php echo "<div id='userdata'>";
	    echo __d('admin', 'Search results for :').' <b>'.$srcs.'</b>';
	    echo '<br /><br />';
					echo '<table id="myTable" class="tablesorter table table-striped table-bordered table-condensed">';
						echo '<thead>';
						?>
						
    
        <?php 
        echo '<tr>';
	        if (isset($search)){
	        	echo '<th>#</th>';
	        }
			echo '<th>'.__d('admin', 'User Name').'</th>';
			//echo '<th>'.__d('admin', 'City').'</th>';
			echo '<th>'.__d('admin', 'Email').'</th>';
			echo '<th>'.__d('admin', 'Registered On').'</th>';
			echo '<th>'.__d('admin', 'Status').'</th>';
			echo '<th>'.__d('admin', 'Action').'</th>';
		echo '</tr>'; 
		?>
		
      </thead>
      <tbody>
      <?php
      	if(count($userdet)!=0)
      	{
  			foreach($userdet as $user_det){
				$id=$user_det['id'];
				if($user_det['user_level']=='god' && $user_det['admin_menus']=='')
				{
					$style = "font-weight:bold;color:#0040FF;";
				}
				else if($user_det['user_level']=='god' && $user_det['admin_menus']!='')
				{
					$style = "font-weight:bold;";
				}
				else
				{
					$style = "";
				}
				echo '<tr id="del_'.$id.'" style="'.$style.'">';
					if (isset($search)){
						echo '<td><input type="checkbox" value="'.$id.'" name="user'.$id.'" class="inactiveuser"/></td>';
					}
					echo '<td>'.$user_det['username'].'</td>';
					//echo '<td>'.$user_det['User']['city'].'</td>';
					echo '<td>'.$user_det['email'].'</td>';
					$day=date('m/d/Y',strtotime($user_det['created_at']));
					echo '<td>'.$day.'</td>';
					 echo '<td id="status'.$id.'">';
                    if ($user_det['user_status'] == 'enable') {
                        echo '<button class="btn btn-warning" style="width: 60px; font-size: 11px;" onclick="changeUserStatus('.$id.',\''.$user_det['user_status'].'\',\''.$user_det['user_level'].'\')">'.__d('admin', 'Disable').'</button></td>';
                    } else {
                        echo '<button class="btn btn-success" style="width: 60px; font-size: 11px;" onclick="changeUserStatus('.$id.',\''.$user_det['user_status'].'\',\''.$user_det['user_level'].'\')">'.__d('admin', 'Enable').'</button></td>';
                    }
                    echo '<td>
                    <a href="'.$baseurl.'edituser/'.$id.'"><span class="btn btn-info"><i class="icon-edit"></i></span></a>';
                    if($demo_active!='yes')
                    echo '<a onclick="deleteusrlists('.$id.')"><span class="btn btn-danger"><i class="icon-trash" style="cursor:pointer;"></i></span></a>';
                    echo '</td>';
                echo '</tr>';
            }
            }else{
                echo "<tr><td colspan='10' align='center'>";
                echo __d('admin', 'No record Found');
                echo "</td></tr>";
            }
        ?>
        
        
      </tbody>
      
      
      
      
    </table>
    <?php if (isset($search)){ ?>
    <div class='deleteselectbtn' style='text-align:right;'>
    	<a href="javascript:deleteinactiveselected();" >
    		<button class="btn btn-primary">
    			<?php echo __d('admin', 'Delete Selected'); ?>
    			<img class='deleteselectload' src='<?php echo SITE_URL.'images/loading.gif'?>' style="width: 18px; display: none;" />
    		</button>
    	</a>
    </div>
    <?php } ?>
<?php
    
    if($pagecount > 0){  ?>                    
       <div class="pagination pagination-centered">
<?= $this->Paginator->prev('« '.__d('admin', 'Previous')) ?>
<?= $this->Paginator->numbers() ?>


<?= $this->Paginator->next(__d('admin', 'Next').'»') ?>

<?= $this->Paginator->counter() ?>
</div>
<?php  }   
?>   
    
    </div></div></div>    </div>    
    </div>
    </div>    