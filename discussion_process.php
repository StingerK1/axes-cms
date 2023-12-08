<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (discussion_process.php) 
        CRUD for discusson page
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
    $discussionId = filter_input(INPUT_GET, 'discussionId', FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['userId'];
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $discussionPost = filter_input(INPUT_POST, 'discussionPost');

    // CREATE post if title and description are set.
    if ($_POST && strlen($_POST['title']) > 1 && strlen($_POST['discussionPost']) > 1 && isset($_SESSION['userId'])) {      

        // Connect to the database.
        require('connect.php');

        // Builds the SQL query and binds it above the sanitized values.
        $query = "INSERT INTO discussion (userId, title, discussionPost) VALUES (:userId, :title, :discussionPost)";
        $statement = $db->prepare($query);

        // Bind values to the parameters.
        $statement->bindValue(":userId", $userId);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':discussionPost', $discussionPost);
        
        // Executes the CREATE.
        $statement->execute();

        // Redirect after CREATE.
        header("Location: discussion.php");
        exit();
    }
}

function update() {

    // UPDATE blog if title, discussion post and if are present in POST.
    if ($_POST && strlen($_POST['title']) && strlen($_POST['discussionPost']) && strlen($_POST['discussionId'])) {
            
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $discussionPost = filter_input(INPUT_POST, 'discussionPost');
        $discussionId = filter_input(INPUT_POST, 'discussionId', FILTER_SANITIZE_NUMBER_INT);

        // Connect to the database.
        require('connect.php');

        // Builds the SQL query and binds it above the sanitized values.
        $query = "UPDATE discussion SET title = :title, discussionPost = :discussionPost WHERE discussionId = :discussionId";
        $statement = $db->prepare($query);

        // Bind values to the parameters.
        $statement->bindValue(':title', $title);       
        $statement->bindValue(':discussionPost', $discussionPost);
        $statement->bindValue(':discussionId', $discussionId, PDO::PARAM_INT);

        // Executes the UPDATE.
        $statement->execute();

        // Redirect after UPDATE.
        header("Location: discussion.php");
        exit();
    } 
    // Retrieves post to be edited, if discussionId GET parameter is in URL.
    else if (isset($_GET['discussionId'])) { 
    
        // Sanitize the discussionId. Like above but this time from INPUT_GET.
        $discussionId = filter_input(INPUT_GET, 'discussionId', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered discussionId.
        $query     = "SELECT * FROM discussion WHERE discussionId = :discussionId";
        $statement = $db->prepare($query);

        // Bind value to the parameter
        $statement->bindValue(':discussionId', $discussionId, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
    } 
    // False if we are not UPDATING or SELECTING.
    else {
        $discussionId = false; 
    }
}

function delete() {

    // Sanitize the id. 
    $discussionId = filter_input(INPUT_POST, 'discussionId', FILTER_SANITIZE_NUMBER_INT);
    
    // DELETE post if delete button is pressed.
    if($_POST && isset($_POST['delete'])) {
        
        // Connect to the database.
        require('connect.php');

        // Builds the SQL query and binds it above the sanitized values.
        $query     = "DELETE FROM discussion WHERE discussionId = :discussionId";
        $statement = $db->prepare($query);

        // Bind value to the parameter.
        $statement->bindValue(':discussionId', $discussionId, PDO::PARAM_INT);

        // Executes the DELETE.
        $statement->execute();

        // Redirect after DELETE.
        header("Location: discussion.php");
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
        <title>A(XES) | Home</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <h1>Oops!</h1>
                        <h2>An error occured while processing your post.</h2>
                        <div>
                            Sorry, the title and content must be at least one character.
                        </div>
                        <div>
                            <a href="user_index.php" class="btn btn-primary"></span> Take Me Home </a>
                            <button type="button" class="btn btn-primary" onclick="history.go(-1)">Return</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>