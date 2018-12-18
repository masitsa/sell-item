<?php 
$is_company = set_value("is_company");
if($is_company == 1)
{
    $yes_checked = "checked";
    $no_checked = "";
}

else
{
    $yes_checked = "";
    $no_checked = "checked";
}
?>
<div class="row main">
    <div class="main-login main-center">
        <h5>ADVERTISER REGISTRATION</h5>
        <?php echo form_open($this->uri->uri_string());?>
            
            <div class="form-group">
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="name" value="<?php echo set_value("name");?>" placeholder="Enter your Name"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                        <input type="email" class="form-control" name="email" value="<?php echo set_value("email");?>" placeholder="Enter your Email"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-phone" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="phone" value="<?php echo set_value("phone");?>" placeholder="Enter your Phone"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="password" value="<?php echo set_value("password");?>" placeholder="Enter your Password"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="confirm" value="<?php echo set_value("confirm");?>" placeholder="Confirm your Password"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="cols-sm-2 control-label">Are you registering as a company?</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="radio radio-primary">
                            <input type="radio" name="is_company" id="radio1" value="1" <?php echo $yes_checked?> onclick="showCompanyForm()">
                            <label for="radio1">
                                Yes
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="radio radio-primary">
                            <input type="radio" name="is_company" id="radio2" value="0" <?php echo $no_checked?> onclick="hideCompanyForm()">
                            <label for="radio2">
                                No
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="companyForm" style="display:none">
                <div class="form-group">
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-building" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="company_name" value="<?php echo set_value("company_name");?>" placeholder="Enter your Company Name"/>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-phone" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="company_phone" value="<?php echo set_value("company_phone");?>" placeholder="Enter your Company Phone"/>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                            <input type="email" class="form-control" name="company_email" value="<?php echo set_value("company_email");?>" placeholder="Enter your Company Email"/>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-map-marker" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="company_location" value="<?php echo set_value("company_location");?>" placeholder="Enter your Company Location"/>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-thumbtack" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="company_kra_pin" value="<?php echo set_value("company_kra_pin");?>" placeholder="Enter your Company KRA Pin"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" id="button" class="btn btn-primary btn-lg btn-block login-button">Register</button>
            </div>

            <p>Already registered?</p>

            <div class="form-group">
                <?php echo anchor('advertiser-login', 'Login', array('title' => 'Login', 'id' => 'button', 'class' => 'btn btn-warning btn-lg btn-block login-button'));?>
            </div>
            
        <?php echo form_close();?>
    </div>
</div>

<script type="text/javascript">
    var is_company = "<?php echo $is_company;?>";
    if(is_company == 1)
    {
        showCompanyForm();
    }
    function showCompanyForm()
    {
        document.getElementById("companyForm").style.display = "block";
    }
    function hideCompanyForm()
    {
        document.getElementById("companyForm").style.display = "none";
    }
</script>