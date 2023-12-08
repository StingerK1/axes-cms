<?php

    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (edit_profile.php) 
        for registered user to view and edit their profile
    */

    $thisPage = 'edit_profile';

    // Connect to the database
    require('connect.php');

    $errorMessage = "";

    // Starts session if active
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Displays the user and profile
    if (isset($_GET['userId'])) {

        $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM users WHERE userId = :userId";
        $statement = $db->prepare($query);   
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();	

        $row = $statement->fetch();  

    }
    else {
        $userId = false;
    }

    include('lib/ImageResize.php'); 
    include('lib/ImageResizeException.php'); 
    use \Gumlet\ImageResize;

    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
        
        $current_folder = dirname(__FILE__);
        
        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
        
        return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    function file_is_an_image($temporary_path, $new_path) {

        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }
    
    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

    if ($image_upload_detected) { 

        $image_filename        = $_FILES['image']['name'];
        $temporary_path        = $_FILES['image']['tmp_name'];
        $new_path              = file_upload_path($image_filename);
        $img_file              = pathinfo($new_path, PATHINFO_EXTENSION);
        $img_extensions        = ['gif', 'jpg', 'jpeg', 'png'];
        
        if (file_is_an_image($temporary_path, $new_path)) {

            move_uploaded_file($temporary_path, $new_path);

            if (in_array($img_file, $img_extensions)) {

                $img_name = substr($image_filename, 0, -4);
                $img_resize = $img_name . '.' . $img_file;
                $image_size  = new ImageResize($new_path);
                $image_size ->resizeToWidth(264);
                $image_size ->save('uploads\\' . $img_resize);
                
            }
        }
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>A(XES) | My Account</title>
            <link href="css/style.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        </head>

        <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- Navigation Bar -->
        <?php include("nav.php") ?>

        <div class="container bootstrap snippets bootdey"><hr>
            <div class="row">

                <!-- Image -->
                <div class="col-md-3">
                    <div class="text-center">
                    <img src="<?="uploads/" . $row['image'] ?>" class="bd-placeholder-img rounded-circle" alt="<?= $row['username'] ?> profile">
                    <h6>Upload your profile photo...</h6>

                    <form method="post" enctype="multipart/form-data">  
                        <input type="file" name="image" id="image" class="form-control"><br/>
                        <input type="submit" name="upload" value="Upload Image" class="btn btn-primary">
                    </form>
                    <br>

                    <form action="pfp_process.php?userId=<?= $row['userId'] ?>" method="post">
                        <?php if ($image_upload_detected): ?>
                            <input type="label" name="image" id="image" value="<?= $_FILES['image']['name'] ?>" class="form-control" /><br>
                        <?php elseif ($upload_error_detected): ?>
                            <div class="alert alert-danger alert-dismissable">
                                <a class="panel-close close" data-dismiss="alert">×</a> 
                                Error Number: <?= $_FILES['image']['error'] ?>
                            </div>
                        <?php endif ?>
                            <input type="submit" name="submit" value="Submit" class="btn btn-info">
                            <input type="submit" name="remove" value="Remove" class="btn btn-info" onclick="return confirm('Are you sure you wish to delete your photo?')"><br><br>
                    </form>
                    </div>
                </div>
                
                <!-- User Information -->
                <div class="col-md-9 personal-info">
                    <h3>Personal Information</h3><br>
                    <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Username:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="<?= $row['username'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email:</label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="<?= $row['email'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">User Type: <?= $row['userType'] ?></label>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-8 control-label">Joined: <?= date("F j, Y, g:i a", strtotime($row['joined'])) ?></label>
                    </div>
                    </form>
                </div>

            </div><hr>
        </div>
    </body>
</html>