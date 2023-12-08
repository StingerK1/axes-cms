<?php

    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (admin.php) 
        Admin - manage user area (overview)
    */

$thisPage = 'admin';

    require ('connect.php');

    if(session_status() !== PHP_SESSION_ACTIVE) { 
      session_start(); 
    } 
    
    $query = "SELECT * FROM users ORDER BY joined DESC";
    $statement = $db->prepare($query);
    $statement->execute();

    $query2 = "SELECT * FROM discussion";
    $statement2 = $db->prepare($query2);
    $statement2->execute();
    
    $query3 = "SELECT * FROM comments";
    $statement3 = $db->prepare($query3);
    $statement3->execute();
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
                <a href="user_discussion.php" class="list-group-item"> Discussions</a>
                <a href="user_comments.php" class="list-group-item"> Comments</a>
                <a href="users.php" class="list-group-item"> Users</a>
                <a href="admin.php" class="list-group-item active main-color-bg"> Overview</a>
            </div>

          </div>

          <!-- Admin Overview -->
          <div class="col-md-9 mt-5">
              <div>
                <h3>Overview</h3>
              </div>
              <div>
                <h2 class="fs-5"> <?= $row = $statement->rowCount() ?> Users <?= $row2 = $statement2->rowCount() ?> Discussions <?= $row3 = $statement3->rowCount() ?> Comments</h2>
              </div>
              
            <!-- Latest Users -->
            <div>
              <div>
                <h3 class="fs-6">Latest Users</h3>
              </div>
              <div>
                <table class="table table-striped table-hover">
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Joined</th>
                  </tr>
                  <?php while($row = $statement->fetch()): ?>
                    <tr>
                      <td><?= $row['username'] ?></td>
                      <td><?= $row['email'] ?></td>
                      <td><?= $row['userType'] ?></td>
                      <td><?= date("F j, Y", strtotime($row['joined'])) ?></td>
                    </tr>  
                  <?php endwhile ?>                                 
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
