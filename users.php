<?php

$thisPage = 'users';

    // Connect to the database.
    require ('connect.php');

    if(session_status() !== PHP_SESSION_ACTIVE) { 
      session_start(); 
    } 
    
    // Build the parameterized SQL query.
    $query = "SELECT * FROM users ORDER BY joined DESC";
    $statement = $db->prepare($query);
    
    // Execute and fetch the return data.
    $statement->execute();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A(XES) | Admin</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.ckeditor.com/4.16.2/tandard/ckeditor.js"></script>
    </head>
  <body>

    <!-- Navigation Bar -->
    <?php include("nav.php") ?>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3 mt-5">
            
            <!-- List Group Status -->
            <div class="list-group">
                <a href="user_discussion.php" class="list-group-item"><span class="glyphicon glyphicon-music" aria-hidden="true"></span> Discussions</a>
                <a href="user_comments.php" class="list-group-item"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Comments</a>
                <a href="users.php" class="list-group-item active main-color-bg"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users</a>
                <a href="admin.php" class="list-group-item"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Overview</a>
            </div>

          </div>

          <!-- Users Overview -->
          <div class="col-md-9 mt-5">
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Users <span class="badge"><?= $row = $statement->rowCount() ?></span></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                <div class="text-end col-md-12">
                  <a class="btn btn-primary" href="user_create.php" role="button">Add user</a>
                </div>
                </div>
                <br>
                <table class="table tabie-striped table-hover">
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Joined</th>
                    <th></th>
                  </tr>
                  <?php while($row = $statement->fetch()): ?>
                    <tr>
                      <td><?= $row['username'] ?></td>
                      <td><?= $row['email'] ?></td>
                      <td><?= $row['hashpassword']?></td>
                      <td><?= date("F j, Y", strtotime($row['joined'])) ?></td>
                      <input type="hidden" name="userId" value="<?= $row['userId'] ?>" />
                      <td><a class="btn btn-default" href="edit_users.php?userId=<?= $row['userId'] ?>">Edit</a></td>
                    </tr>
                  <?php endwhile ?>
                </table>
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
