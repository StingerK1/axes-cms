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

    <!-- Comments --> 
    <div style="max-width:700px;margin:auto;">                   
        <h3>Comments</h3>                  
    </div>

    <!-- Leave a Comment -->
      <form style="max-width:700px;margin:auto;" action="comments_process.php?discussionId=<?= $_GET['discussionId'] ?>" method="post">
        <div class="panel">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-11">
                <input class="form-control" name="comment" id="comment" type="text" placeholder="Leave a Comment">
                </div>
                  <div class="col-md-1">
                    <input class="btn btn-primary" name="share" type="submit" style="color: #b4c8ea" value="Comment">
                  </div>             
                </div>
                <br>
              </div>         
            </div>
          </div>
        </div>
      </form>  

      <!-- Display Comments -->
      <div style="max-width:700px;margin:auto;" class="panel-body">
        <ul class="list-group">
          <?php while($row2 = $statement2->fetch()): ?>
            <li class="list-group-item">
              <div>
                <div>
                  <table id="display">
                    <tr>
                      <td style="color: gray"><img src="<?="uploads/" . $row2['image'] ?>" style="max-width:40px;margin:auto;" class="bd-placeholder-img rounded-circle" alt="" /> <i><?= $row2['username'] ?></i> - <?= date("M j, Y, g:i a", strtotime($row2['datetime'])) ?></td>
                    </tr>
                    <tr>
                      <td><b class="display-6" style="font-size: 30px"><?= $row2['comment'] ?></b></td>
                    </tr>
                  </table>
                  <div class="action">
                    <form action="comments_process.php?discussionId=<?= $_GET['discussionId'] ?>" method="post"> 
                      <input type="hidden" name="commentId" value="<?= $row2['commentId'] ?>" />
                      <!-- <?php if ($loggedInUser == $row2['username']): ?>
                        <a class="btn btn-primary" href="comments_edit.php?discussionId=<?= $row2['discussionId'] ?>&commentId=<?= $row2['commentId'] ?>">Edit</a>
                      <?php endif ?> -->
                      <?php if ($loggedInUser == 'admin' || $loggedInUser == $row2['username']): ?>
                        <div class="text-end">
                          <input type="submit" name="delete" class="btn btn-secondary" value="Delete" onclick="return confirm('Are you sure you wish to delete this comment?')" />
                        </div>
                      <?php endif ?>
                    </form>  
                  </div> 
                </div>
              </div>
            </li>
          <?php endwhile ?> 
        </ul>
      </div>  
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
    <script src="js/bootstrap.min.js"></script>

    </body>
</html>