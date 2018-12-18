<div class="row main">
    <div class="main-login main-center">
        <h5>ADVERTISER LOGIN</h5>
        <?php echo form_open($this->uri->uri_string());?>
            <div class="form-group">
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                        <input type="email" class="form-control" name="email" placeholder="Enter your Email"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Enter your Password"/>
                    </div>
                </div>
            </div>

            <div class="form-group ">
                <button type="submit" id="button" class="btn btn-primary btn-lg btn-block login-button">Login</button>
            </div>

            <p>Not registered?</p>

            <div class="form-group ">
                <?php echo anchor('advertiser-registration', 'Register', array('title' => 'Register', 'id' => 'button', 'class' => 'btn btn-warning btn-lg btn-block login-button'));?>
            </div>
            
        <?php echo form_close();?>
    </div>
</div>