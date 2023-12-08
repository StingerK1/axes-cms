<?php

        /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (discussion_create.php) 
        Page for registered users to create a post
    */


    require('connect.php');

    $errorMsg = "";

    if(session_status() !== PHP_SESSION_ACTIVE) { 
        session_start(); 
    } 

    if (isset($_GET['userId'])) {

        $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM discussion WHERE userId = :userId";
        $statement = $db->prepare($query);
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch();
    }
    else {
        $userId = false;
    }
  
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A(XES) | Share</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        
        <!-- Navigation Bar -->
        <?php include("nav.php") ?>

            <div class="container mt-5">
                <div class="panel panel-default">
                    <div class="col-md-12">
                        <form style="max-width:600px;margin:auto;" action="discussion_process.php" method="post">
                            <h1>Create Post</h1>
                            <div class="col-md-12">
                                <label>Title</label>
                                <input type="text" name="title" id="title" class="form-control mb-3" />
                            </div>
                            <div class="col-md-12">
                                <label>Content</label>
                                <textarea name="discussionPost" id="discussionPost" class="form-control mb-3" rows="4" style="resize: none;"></textarea>
                            </div> 
                            <div class="col=md-12">
                                <br>
                                <input type="submit" name="create" class="btn btn-primary" value="Post">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>CKEDITOR.replace( 'discussionPost' );</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>