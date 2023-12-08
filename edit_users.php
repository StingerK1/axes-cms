<?php

    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (edit_users.php) 
        for admin to edit users 
    */

    // Prompt for authentication and connect to the database.
    require('connect.php');

    if(session_status() !== PHP_SESSION_ACTIVE) { 
      session_start(); 
    } 

    // Build and prepare SQL String with :userId placeholder parameter.
    $query     = "SELECT * FROM users WHERE userId = :userId LIMIT 1";
    $statement = $db->prepare($query);
    
    // Sanitize $_GET['userId'] to ensure it's a number.
    $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);

    // Bind the :userId parameter in the query to the sanitized
    // $id specifying a binding-type of Integer.
    $statement->bindValue('userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    
    // Fetch the row selected by primary key userId.
    $row = $statement->fetch();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A(XES) | Edit Users</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>

    <body>

    <!-- Navigation Bar -->
    <?php include("nav.php") ?>

    <section id="main">
    <div class="container mt-5">
        <div class="row">

        <!-- Edit Overview -->
        <div class="col-md-9" style="max-width:500px;margin:auto;">
            <div class="panel panel-default">
            <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Edit User</h3>
            </div>
            <div class="panel-body">
                <form action="user_process.php" method="post">
                    <div>
                        <label>Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?= $row['username']?>" readonly />
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $row['email'] ?>" readonly />
                    </div> 
                    <div>
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="<?= $row['hashpassword'] ?>" readonly />
                    </div> 
                    <div>
                        <label>User Type</label>
                        <input type="text" name="userType" id="userType" class="form-control" value="<?= $row['userType'] ?>"/>
                    </div>

                    <div>
                        <input type="hidden" name="userId" value="<?= $row['userId'] ?>" />
                        <div class="container mt-3">
                            <input type="submit" name="update" class="btn btn-primary main-color-bg" value="Update">
                            <input type="submit" name="delete" class="btn btn-secondary" value="Delete" onclick="return confirm('Are you sure you wish to delete this comment?')" />
                        </div>
                    </div>
                </form>
            </div>
            </div>
            
        </div>
        </div>
    </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>
