<?php

    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (pfp_process.php)
        Where authenticated users and admin can upload and remove their profile photos.
    */

    // Connect to the database.
    require('connect.php');

    if(session_status() !== PHP_SESSION_ACTIVE) { 
        session_start(); 
    } 

    if ($_POST) {
        if (isset($_POST['submit'])) {
            submit();
        }

        if (isset($_POST['remove'])) {
            remove();
        }    
    }

    function submit() {

        $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);

        require('connect.php');

        $query = "UPDATE users SET image = :image WHERE userId = :userId";
        $statement = $db->prepare($query);

        $statement->bindValue(':image', $image);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();

        header("Location: edit_profile.php?userId=" . $_GET['userId']);
        exit();
    }

    function remove() {

        $image =  filter_input(INPUT_POST, 'image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);

        require('connect.php');

        $query = "DELETE FROM users WHERE userId = :userId";
        $statement = $db->prepare($query);

        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        unlink('uploads/' . $image.'jpg');
        $statement->execute();

        header("Location: edit_profile.php?userId=" . $_GET['userId']);
        exit();

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> A(XES) | Error Page </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-template">
                        <h1>Oops!</h1>
                        <h2>An error occured while uploading your photo.</h2>
                        <div class="error-details">
                            Sorry, there is something wrong with your photo.
                        </div>
                        <div class="error-actions">
                            <a href="user_index.php" class="btn btn-default main-color-bg btn-lg"><span class="glyphicon glyphicon-home"></span> Take Me Home </a>
                            <button type="button" class="btn btn-default btn-lg" onclick="history.go(-1)">Return</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>