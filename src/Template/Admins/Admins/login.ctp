  <?php /*echo $this->Form->create('login',array('url'=>array('controller'=>'/admins','action'=>'/login'),'id'=>'adminloginform')); ?>
  <?php /*echo $this->Form->create('login',array('url'=>array('controller'=>'/admins','action'=>'/login'),'id'=>'adminloginform')); ?>
Email ID:<input type="text" name="email">
Password:<input type="password" name="password">
<input type="submit" value="login">
</form>*/?>
 <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" >        
            <div class="login-box card">
            <div class="card-block">
                <?php echo $this->Form->create('login',array('url'=>array('controller'=>'/admins','action'=>'/login'),'class'=>'form-horizontal form-material','id'=>'loginform','onsubmit'=>'return validsigninfrm()')); ?>
               
                <div class="fantacylogo"><span class="fantacytxt"><img src="<?php echo SITE_URL;?>images/logo/<?php  echo $setngs->site_logo_icon; ?>" alt="homepage" class="dark-logo" /></span><span><img src="<?php echo SITE_URL;?>images/logo/<?php  echo $setngs->site_dark_logo; ?>" alt="homepage" class="dark-logo" /></span></div>

                    <h3 class="box-title m-b-20"><?php echo __d('admin', 'Sign In'); ?></h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <!--<input class="form-control" type="text"  placeholder="<?php echo __d('admin', 'Email ID'); ?>" name="email" id="email" value="<?php if(!empty($getemailval))  { echo $getemailval; } ?>"> -->
                                <input class="form-control" type="text"  placeholder="<?php echo __d('admin', 'Email ID'); ?>" name="email" id="email">

                            </div><div id='alert_em' style='color:red;float:right;margin-top:-30px;height:0px;font-size:13px;'></div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <!-- 
                            <input class="form-control" type="password"  placeholder="<?php echo __d('admin', 'Password'); ?>" name="password" id="password"> 
                            -->
                            <input class="form-control" type="password"  placeholder="<?php echo __d('admin', 'Password'); ?>" name="password" id="password"> 

                            </div><div id='alert_pass' style='color:red;float:right;margin-top:-30px;height:0px;font-size:13px;'></div>
                    </div>
                    <?php if(!empty($errmsg)) { ?>
                    <div class="errmsg"><?php echo $errmsg; ?></div>
                    <?php } ?>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit"><?php echo __d('admin', 'Log In'); ?></button><div id="alert_tot"></div>
                        </div>
                    </div>
                  
                 
                </form>
               
            </div>
          </div>
        </div>
        
    </section>

            

     
           
