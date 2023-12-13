<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (artistcomments_process.php) 
        CRUD for comments on the artist posts
    */

    require('connect.php');
            
    if(session_status() !== PHP_SESSION_ACTIVE) { 
        session_start(); 
    } 

    if ($_POST) {
        if (isset($_POST['share'])) {
            share();
        }

        if (isset($_POST['save'])) {
            save();
        }

        if (isset($_POST['delete'])) {
            delete();
        }      
    }

    function share() {

        if (isset($_POST['captcha']) && $_SESSION['captchaText'] == $_POST['captcha']) {
            
            $userId = $_SESSION['userId'];
            $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $artistboardId = filter_input(INPUT_GET, 'artistBoardId', FILTER_SANITIZE_NUMBER_INT);

            if ($_POST && isset($_SESSION['userId']) && isset($_GET['artistBoardId']) && !empty($_POST['comment'])) {

                require('connect.php');

                $query = "INSERT INTO artistcomment (userId, comment, artistBoardId) VALUES (:userId, :comment, :artistBoardId)";
                $statement = $db->prepare($query);
            
                $statement->bindValue(":userId", $userId);
                $statement->bindValue(":comment", $comment);
                $statement->bindValue(":artistBoardId", $artistboardId);
            
                $statement->execute();
                header("Location: artistboard_show.php?artistBoardId=" . $_GET['artistBoardId']);
                exit();
            }
        }
    }   
    
    function save() {

        if ($_POST && !empty($_POST['comment']) && !empty($_POST['artistCommentId'])) {

            $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $artistCommentId = filter_input(INPUT_POST, 'artistCommentId', FILTER_SANITIZE_NUMBER_INT);

            require('connect.php');

            $query = "UPDATE artistcomment SET comment = :comment WHERE artistCommentId = :artistCommentId";
            $statement = $db->prepare($query);
      
            $statement->bindValue(':comment', $comment);
            $statement->bindValue(':artistCommentId', $artistCommentId, PDO::PARAM_INT);
            $statement->execute();
      
            header("Location: artistboard_show.php?artistBoardId=" . $_GET['artistBoardId']);
            exit();
        }
        else if (isset($_GET['artistCommentId'])) {
    
            $artistCommentId = filter_input(INPUT_GET, 'artistCommentId', FILTER_SANITIZE_NUMBER_INT);

            $query = "SELECT * FROM comments WHERE artistCommentId = :artistCommentId";
            $statement = $db->prepare($query);

            $statement->bindValue(':artistCommentId', $artistCommentId, PDO::PARAM_INT);
            $statement->execute();    
            }
        else {
            $artistCommentId = false;
        }
    }


    function delete() {

        $artistCommentId = filter_input(INPUT_POST, 'artistCommentId', FILTER_SANITIZE_NUMBER_INT);

        if ($_POST && isset($_POST['delete'])) {

            require('connect.php');

            $query = "DELETE FROM artistcomment WHERE artistCommentId = :artistCommentId";
            $statement = $db->prepare($query);
            $statement->bindValue('artistCommentId', $artistCommentId, PDO::PARAM_INT);
            $statement->execute();
        
            header("Location: artistboard_show.php?artistBoardId=" . $_GET['artistBoardId']);
            exit();
        }
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
            <div class="mb-5">
                <div class="text-center">
                    <h1 >Error!</h1>
                    <div>
                        Sorry, something went wrong. your comment could not be processed at this time.
                    </div>
                    <div  class="col-mb-12">
                        <button type="button" class="btn btn-primary" onclick="history.go(-1)">Return</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>