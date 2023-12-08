<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (comments_process.php) 
        CRUD for comments
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
            
        $userId = $_SESSION['userId'];
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $discussionId = filter_input(INPUT_GET, 'discussionId', FILTER_SANITIZE_NUMBER_INT);

        if ($_POST && isset($_SESSION['userId']) && isset($_GET['discussionId']) && !empty($_POST['comment'])) {

            require('connect.php');

            $query = "INSERT INTO comments (userId, comment, discussionId) VALUES (:userId, :comment, :discussionId)";
            $statement = $db->prepare($query);
        
            $statement->bindValue(":userId", $userId);
            $statement->bindValue(":comment", $comment);
            $statement->bindValue(":discussionId", $discussionId);
        
            $statement->execute();
            header("Location: show.php?discussionId=" . $_GET['discussionId']);
            exit();
        }
        
    }   
    
    function save() {

        if ($_POST && !empty($_POST['comment']) && !empty($_POST['commentId'])) {

            $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);

            require('connect.php');

            $query = "UPDATE comments SET comment = :comment WHERE commentId = :commentId";
            $statement = $db->prepare($query);
      
            $statement->bindValue(':comment', $comment);
            $statement->bindValue(':commentId', $commentId, PDO::PARAM_INT);
            $statement->execute();
      
            header("Location: user_show.php?discussionId=" . $_GET['discussionId']);
            exit();
        }
        else if (isset($_GET['commentId'])) {
    
            $commentId = filter_input(INPUT_GET, 'commentId', FILTER_SANITIZE_NUMBER_INT);

            $query = "SELECT * FROM comments WHERE commentId = :commentId";
            $statement = $db->prepare($query);

            $statement->bindValue(':commentId', $commentId, PDO::PARAM_INT);
            $statement->execute();    
            }
        else {
            $commentId = false;
        }
    }


    function delete() {

        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);

        if ($_POST && isset($_POST['delete'])) {

            require('connect.php');

            $query = "DELETE FROM comments WHERE commentId = :commentId";
            $statement = $db->prepare($query);
            $statement->bindValue('commentId', $commentId, PDO::PARAM_INT);
            $statement->execute();
        
            header("Location: show.php?discussionId=" . $_GET['discussionId']);
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
<title> Soundemic | Error Page </title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Oops!</h1>
                    <h2>An error occured while processing your comment.</h2>
                    <div>
                        Sorry, your comment must be at least one character.
                    </div>
                    <div>
                        <a href="user_index.php" class="btn btn-primary">Take Me Home </a>
                        <button type="button" class="btn btn-primary" onclick="history.go(-1)">Return</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>