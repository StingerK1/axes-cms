<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (community_process.php) 
        CRUD for communities
    */


    // Connect to the database.
    require('connect.php');
            
    if(session_status() !== PHP_SESSION_ACTIVE) { 
        session_start(); 
    } 

    if ($_POST) {
        if (isset($_POST['add'])) {
            add();
        }

        if (isset($_POST['modify'])) {
            modify();
        }

        if (isset($_POST['remove'])) {
            remove();
        }      
    }

    function add() {

        $communityName = filter_input(INPUT_POST, 'communityName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $communityId = filter_input(INPUT_GET, 'communityId', FILTER_SANITIZE_NUMBER_INT);

        if ($_POST && strlen($_POST['communityName']) > 1) {

            require('connect.php');

            $query = "INSERT INTO community (communityId, community) VALUES (:communityId, :communityName)";
            $statement = $db->prepare($query);
        
            $statement->bindValue(":communityId", $communityId);
            $statement->bindValue(":communityName", $communityName);
        
            $statement->execute();
            header("Location: community.php");
            exit();
        }  
    }

    function modify() {

        if ($_POST && !empty($_POST['communityName']) && !empty($_POST['communityId'])) {

            $communityName = filter_input(INPUT_POST, 'communityName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $communityId = filter_input(INPUT_POST, 'communityId', FILTER_SANITIZE_NUMBER_INT);

            require('connect.php');

            $query = "UPDATE community SET community = :communityName WHERE communityId = :communityId";
            $statement = $db->prepare($query);
    
            $statement->bindValue(':communityName', $communityName);
            $statement->bindValue(':communityId', $communityId, PDO::PARAM_INT);
            $statement->execute();
    
            header("Location: community.php");
            exit();
        }
        else if (isset($_GET['communityId'])) {
    
            $communityId = filter_input(INPUT_GET, 'communityId', FILTER_SANITIZE_NUMBER_INT);

            $query = "SELECT * FROM community WHERE communityId = :communityId";
            $statement = $db->prepare($query);

            $statement->bindValue(':communityId', $communityId, PDO::PARAM_INT);
            $statement->execute();    
            }
        else {
            $communityId = false;
        }
    }

    function remove() {

        $communityId = filter_input(INPUT_POST, 'communityId', FILTER_SANITIZE_NUMBER_INT);

        if ($_POST && isset($_POST['remove'])) {

            require('connect.php');

            $query = "DELETE FROM community WHERE communityId = :communityId";
            $statement = $db->prepare($query);
            $statement->bindValue('communityId', $communityId, PDO::PARAM_INT);
            $statement->execute();
        
            header("Location: community.php");
            exit();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A(XES) | Error</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    
    <body>
        <div class="container">
            <div class="mb-5">
                <div class="text-center">
                    <h1 >Error!</h1>
                    <div>
                        Sorry, something went wrong; your request could not be procesed at this moment.
                    </div>
                    <div  class="col-mb-12">
                        <button type="button" class="btn btn-primary" onclick="history.go(-1)">Return</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>