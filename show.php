<?php

// Connect to the database.
require('connect.php');

  // Starts session if active
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }

  // Displays the post & comment
  if (isset($_GET['discussionId'])) {

    $discussionId = filter_input(INPUT_GET, 'discussionId', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM discussion WHERE discussionId = :discussionId";
    $statement = $db->prepare($query);
    
    $statement->bindValue(':discussionId', $discussionId, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch(); 
    
    $query2 = "SELECT * FROM comments JOIN users ON comments.userId = users.userId WHERE comments.discussionId = :discussionId ORDER BY datetime DESC";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':discussionId', $discussionId, PDO::PARAM_INT);
    $statement2->execute();

  }

  else {
    $discussionId = false;
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>A(XES) | Show</title>
      <link href="css/style.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>

    <body>

<!-- Navigation Bar -->
<?php include("nav.php") ?>

    <div class="container">
      <br>
      <h1><?= $row['title'] ?></h1>
      <p>
        <small>
          <?= date('M j, Y, g:i a', strtotime($row['datetime'])) ?> -
          <a href="discussion_edit.php?discussionId=<?= $row['discussionId'] ?>">edit</a>
        </small>
      </p>
      <div><?= $row['discussionPost'] ?></div>
    </div>

    </body>
</html>