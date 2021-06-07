 <?php 

     use Cake\Routing\Router;
     $baseurl = Router::url('/');
  ?>
  <!-- Preloader - style you can find in spinners.css -->
  <div class="preloader">
      <svg class="circular" viewBox="25 25 50 50">
          <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
      </svg>
  </div>
   
<?php $bgimage = "background-image:url(".SITE_URL."images/background/login-register.jpg)"; ?>
  <section id="wrapper">
    <div class="login-register" style="<?php echo $bgimage;?>"> 
        <div class="row">
          <div class="col-lg-12 m-c-auto">
              <div class="col-lg-12 col-sbox">
                  <a href="<?php echo SITE_URL;?>merchant" class="text-center db">
                      <img src="<?php echo SITE_URL;?>images/logo/<?php  echo $setngs->site_logo_icon; ?>" alt="Home" />
                      <img class="m-l-5" src="<?php echo SITE_URL;?>images/logo/<?php  echo $setngs->site_dark_logo; ?>" alt="Home" />
                  </a><br/>
              </div>
            </div> 
        </div>
        <div class="login-box card">
            <div class="card-block">
                <?php echo $this->Form->create('login',array('url'=>array('controller'=>'/','action'=>'/'),'id'=>'loginform','class'=>'form-horizontal form-material')); ?>
                    <h3 class="box-title m-b-20">Sign In</h3>
                    <!-- a href="javascript:void(0)" class="text-center db"><img src="images/logo-icon.png" alt="Home" /><br/><img src="images/logo-text.png" alt="Home" /></a -->  
            
                    <div class="form-group">
                      <div class="col-xs-12">
                        <input class="form-control" id="email" name="email" required="" type="email" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <input class="form-control" id="password" name="password" required="" type="password" placeholder="Password">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="checkbox checkbox-primary pull-left p-t-0">
                          <input id="checkbox-signup" value="1" name="remember" type="checkbox">
                          <label for="checkbox-signup"> Remember me </label>
                        </div>
                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password ?</a> 
                       </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                      </div>
                    </div>
                    <!-- div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                        <div class="social"><a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip"  title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a> <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip"  title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a> </div>
                      </div>
                    </div -->
                    <div class="form-group m-b-0">
                      <div class="col-sm-12 text-center">
                        <p>Don't have an account? <a href="<?php echo $baseurl; ?>merchant/signup" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                      </div>
                    </div>
                </form>

                <form class="form-horizontal" id="recoverform" action="<?php echo SITE_URL; ?>merchant/forgotpassword" method="post" accept-charset="utf-8"  onsubmit = "return forgotpassform()">
                    <div class="form-group">
                        <div class="col-xs-12 clearfix">
                            <h3 class="h3-title">Recover Password</h3>
                            <a href="javascript:void(0)" id="to-login" class="text-dark pull-right backlogin"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> 
                        </div>
                        <div class="col-xs-12">
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" id="forgotemail" type="text" placeholder="Email" name="forgotemail">
                            <small class="form-control-feedback f4-error f4-error-forgotemail"></small> 
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
              <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>
  </section>
