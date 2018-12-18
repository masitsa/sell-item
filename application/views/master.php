<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/fontawesome/css/all.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/custom/css/style.css">
		<script src="<?php echo base_url();?>assets/jquery-3.3.1.min.js"></script>
		<title><?php echo $title;?></title>
	</head>
	<body class="<?php echo $body_class?>">
        <?php
        if($nav == TRUE)
        {
            ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#"><?php echo $this->config->item("site_name");?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <?php
        }
        ?>
        <div class="container">
            <?php 
            if(isset($success_message))
            {
                ?>
                <div class="alert alert-success">
                    <p><?php echo $success_message;?></p>
                </div>
                <?php
            }
            if(isset($error_message))
            {
                ?>
                <div class="alert alert-danger">
                    <p><?php echo $error_message;?></p>
                </div>
                <?php
            }
            ?>
		    <?php echo $content;?>
        </div>
		<script src="<?php echo base_url();?>assets/popper.min.js"></script>
		<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/custom/js/scripts.js"></script>
	</body>
</html>