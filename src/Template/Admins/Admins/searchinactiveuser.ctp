<?php echo "<div id='userdata'>";
    if($srcs!="")
    {
        echo __d('admin', 'Search results for :').' <b>'.$srcs.'</b>';
        echo '<br /><br />';
    }
                    echo '<table id="myTable" class="tablesorter table table-striped table-bordered table-condensed">';
                        echo '<thead>';
                        ?>
                        
    
        <?php 
        echo '<tr>';
            echo '<th>#</th>';
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
      <?php if(!empty($userdet)){
            foreach($userdet as $user_det){
                $id=$user_det['id'];
               echo '<tr id="del_'.$id.'">';
                    echo '<td><input type="checkbox" value="'.$id.'" name="user'.$id.'" class="inactiveuser"/></td>';
              
                    echo '<td>'.$user_det['username'].'</td>';
                    
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
                    echo ' </td>';
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

   
            <button class="btn btn-info" onclick="deleteinactiveselected()">            
              <?php echo __d('admin', 'Delete Selected'); ?>
            </button><div style="float:bottom;color:red;font-size:14px;display:none;" id="delerr"> <?php echo __d('admin', 'Select Users to delete'); ?></div>
       

<?php
    
    if($pagecount > 0){  ?>                    
       <div class="pagination pagination-centered">
<?= $this->Paginator->prev('« '.__d('admin', 'Previous')) ?>
<?= $this->Paginator->numbers() ?>


<?= $this->Paginator->next(__d('admin', 'Next').' »') ?>

<?= $this->Paginator->counter() ?>
</div>
<?php  }   
?>   
    
    </div></div></div>    </div>    
    </div>
    </div>    


    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>



                
