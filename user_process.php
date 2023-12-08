<?php

require('connect.php');

if(session_status() !== PHP_SESSION_ACTIVE) { 
    session_start(); 
} 

if ($_POST) {
    if (isset($_POST['update'])) {
        update();
    }

    if (isset($_POST['delete'])) {
        delete();
    }      
}

function update() {

    // UPDATE blog if title, description and if are present in POST.
    if ($_POST && strlen($_POST['userType']) && strlen($_POST['userId'])) {
            
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);

        // Connect to the database.
        require('connect.php');

        // Builds the SQL query and binds it above the sanitized values.
        $query = "UPDATE users SET username = :username, email = :email, userType = :userType WHERE userId = :userId";
        $statement = $db->prepare($query);

        // Bind values to the parameters.
        $statement->bindValue(':username', $username);       
        $statement->bindValue(':email', $email);
        $statement->bindValue(':userType', $userType);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
           
        // Executes the UPDATE.
        $statement->execute();

        // Redirect after UPDATE.
        header("Location: users.php");
        exit();
    } 
    // Retrieves post to be edited, if id GET parameter is in URL.
    else if (isset($_GET['userId'])) { 
    
        // Sanitize the id. Like above but this time from INPUT_GET.
        $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered id.
        $query     = "SELECT * FROM users WHERE userId = :userId";
        $statement = $db->prepare($query);

        // Bind value to the parameter
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
    } 
    // False if we are not UPDATING or SELECTING.
    else {
        $userId = false; 
    }
}

function delete() {

    // Sanitize the id. 
    $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);
    
    // DELETE post if delete button is pressed.
    if($_POST && isset($_POST['delete'])) {
        
        // Connect to the database.
        require('connect.php');

        // Builds the SQL query and binds it above the sanitized values.
        $query     = "DELETE FROM users WHERE userId = :userId";
        $statement = $db->prepare($query);

        // Bind value to the parameter.
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);

        // Executes the DELETE.
        $statement->execute();

        // Redirect after DELETE.
        header("Location: users.php");
        exit();
    } 
}    

?>

