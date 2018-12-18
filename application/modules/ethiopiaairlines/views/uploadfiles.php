<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>Ethiopian Airlines</title>
    </head>
    <body>
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="ethiopian.png" width="50" height="30" class="d-inline-block align-top" alt="">
                <h1>Ethiopian Airlines</h1>
            </a>
        </nav>
        <br>
        <div class="container">
            <?php
                if(!empty($error)){
                    ?>
                    <div class="alert alert-danger"><?php echo $error;?></div>
                    <?php
                }

                $response_error = $this->session->userdata("error_message");
                if(!empty($response_error)){
                    ?>
                    <div class="alert alert-danger"><?php echo $response_error;?></div>
                    <?php
                    $this->session->unset_userdata("error_message");
                }
                
                $success = $this->session->userdata("success_message");
                if(!empty($success)){
                    ?>
                    <div class="alert alert-success"><?php echo $success;?></div>
                    <?php
                    $this->session->unset_userdata("success_message");
                }
            ?>
            <form action="<?php echo site_url().$this->uri->uri_string();?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fileUpload">File Name: *</label>
                    <input type="text" name="file_name" id="file_name" class="form-control" required> <br>
                </div>

                <div class="form-group">
                    <label for="fileUpload">Select file to upload: *</label>
                    <input type="file" name="xmlfile" id="xmlfile" class="form-control" required> <br>
                </div>
                <input type="submit" value="Upload XML File" name="submit" class="btn btn-sm btn-info">
            </form>        
        </div>
    </body>
</html>