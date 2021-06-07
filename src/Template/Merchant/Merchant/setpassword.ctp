<?php 
if(session_id() == '') {
session_start();
}
$site = SITE_URL;
$media = SITE_URL;
@$username = @$_SESSION['media_server_username'];
@$password = @$_SESSION['media_server_password']; 
@$hostname = $_SESSION['media_host_name'];

$roundProfile = "";
$roundProfileFlag = 0;
if ($roundProf == "round")  {
    $roundProfile = "border-radius:40px; box-shadow:0 0 10px #d5d6d7;";
    $roundProfileFlag = 1;
} else if ($roundProf == "square") {
   $roundProfile = "border-radius:5px; box-shadow:0 0 10px #d5d6d7;";
}
?>
<style type="text/css">

</style>

<div class="container">
  <div class="row m-t-40">
    <div class="col-lg-6 col-md-12 col-sm-12" style="margin:auto !important;">
        <div class="card">
                <div class="card-block">
                    <h4 class="text-themecolor m-b-0 m-t-0">Generate New Password</h4>
                    <hr>
                    <div class="col-md-12 col-sm-12 ">

                        <?php echo $this->Form->Create('setpassword',array('url'=>array('controller' => '/','action' => '/setpassword'),'name'=>'spassword','id'=>'setpassword'));
                        ?>
 
                            <div class="form-group">
                                <label> New Password </label>
                                <input id='newpassword' name="newpassword" type="password" class="form-control" placeholder="" value="">
                                <small class="form-control-feedback f4-error f4-error-newpassword"></small> 
                            </div>

                            <div class="form-group">
                                <label>Confirm Password </label>
                                <input id='cpassword' name="cpassword" type="password" class="form-control" placeholder="" value="">
                                <small class="form-control-feedback f4-error f4-error-cpassword"></small> 
                            </div>

                            <input type="hidden" value="<?php echo $email; ?>" name="email" />
                            <input type="hidden" value="<?php echo $veri_pass; ?>" name="verify_pass" />

                            <div class="button-group">
                                <button class="btn btn-rounded btn-info" type="submit"><i class="fa fa-check"></i>
                                Save</button>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
        </div>

    </div>
</div>
</div>
