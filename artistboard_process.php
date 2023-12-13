<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (artistboard_process.php) 
        CRUD for a(xis) page
    */


require('connect.php');

if(session_status() !== PHP_SESSION_ACTIVE) { 
    session_start(); 
} 

if ($_POST) {
    if (isset($_POST['create'])) {
        create();
    }

    if (isset($_POST['update'])) {
        update();
    }

    if (isset($_POST['delete'])) {
        delete();
    }      
}

function create() {

    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $artistBoardId = filter_input(INPUT_GET, 'artistBoardId', FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['userId'];
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $artistPost = filter_input(INPUT_POST, 'artistPost');

    // CREATE post if title and description are set.
    if ($_POST && strlen($_POST['title']) > 1 && strlen($_POST['artistPost']) > 1 && isset($_SESSION['userId'])) {      

        // Connect to the database.
        require('connect.php');

        // Builds the SQL query and binds it above the sanitized values.
        $query = "INSERT INTO artistboard (userId, title, artistPost) VALUES (:userId, :title, :artistPost)";
        $statement = $db->prepare($query);

        // Bind values to the parameters.
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':artistPost', $artistPost);
        
        // Executes the CREATE.
        $statement->execute();

        // Redirect after CREATE.
        header("Location: artistboard.php");
        exit();
    }
}

function update() {

    // UPDATE blog if title, artistboard post and if are present in POST.
    if ($_POST && strlen($_POST['title']) && strlen($_POST['artistPost']) && strlen($_POST['artistBoardId'])) {
            
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $artistPost = filter_input(INPUT_POST, 'artistPost');
        $artistBoardId = filter_input(INPUT_POST, 'artistBoardId', FILTER_SANITIZE_NUMBER_INT);

        // Connect to the database.
        require('connect.php');

        // Builds the SQL query and binds it above the sanitized values.
        $query = "UPDATE artistboard SET title = :title, artistPost = :artistPost WHERE artistBoardId = :artistBoardId";
        $statement = $db->prepare($query);

        // Bind values to the parameters.
        $statement->bindValue(':title', $title);       
        $statement->bindValue(':artistPost', $artistPost);
        $statement->bindValue(':artistBoardId', $artistBoardId, PDO::PARAM_INT);

        // Executes the UPDATE.
        $statement->execute();

        // Redirect after UPDATE.
        header("Location: artistboard.php");
        exit();
    } 
    // Retrieves post to be edited, if artistBoardId GET parameter is in URL.
    else if (isset($_GET['artistBoardId'])) { 
    
        // Sanitize the artistBoardId. Like above but this time from INPUT_GET.
        $artistBoardId = filter_input(INPUT_GET, 'artistBoardId', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered artistBoardId.
        $query     = "SELECT * FROM artistboard WHERE artistBoardId = :artistBoardId";
        $statement = $db->prepare($query);

        // Bind value to the parameter
        $statement->bindValue(':artistBoardId', $artistBoardId, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
    } 
    // False if we are not UPDATING or SELECTING.
    else {
        $artistBoardId = false; 
    }
}

function delete() {

    // Sanitize the id. 
    $artistBoardId = filter_input(INPUT_POST, 'artistBoardId', FILTER_SANITIZE_NUMBER_INT);
    
    // DELETE post if delete button is pressed.
    if($_POST && isset($_POST['delete'])) {
        
        // Connect to the database.
        require('connect.php');

        // Builds the SQL query and binds it above the sanitized values.
        $query     = "DELETE FROM artistboard WHERE artistBoardId = :artistBoardId";
        $statement = $db->prepare($query);

        // Bind value to the parameter.
        $statement->bindValue(':artistBoardId', $artistBoardId, PDO::PARAM_INT);

        // Executes the DELETE.
        $statement->execute();

        // Redirect after DELETE.
        header("Location: artistboard.php");
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
                        Sorry, the title and content must contain at least one character.
                    </div>
                    <div  class="col-mb-12">
                        <button type="button" class="btn btn-primary" onclick="history.go(-1)">Return</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>