<?php
  /*
      Name: April Donne Pecson
      Project - A(xes) CMS Application (artistboard_show.php) 
      Shows the post and comments of the selected artist post
  */

  // Connect to the database.
  require('connect.php');

  // Starts session if active
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }

  // Displays the post & comment
  if (isset($_GET['artistBoardId'])) {

    $artistBoardId = filter_input(INPUT_GET, 'artistBoardId', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM artistboard JOIN users ON artistboard.userId = users.userId WHERE artistBoardId = :artistBoardId";
    $statement = $db->prepare($query);    
    $statement->bindValue(':artistBoardId', $artistBoardId, PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch(); 
    
    $query2 = "SELECT * FROM artistcomment AC JOIN users U
                ON AC.userId = U.userId JOIN artistboard AB
                ON AC.artistBoardId = AB.artistBoardId
                WHERE AC.artistBoardId = :artistBoardId 
                ORDER BY AC.datetime DESC";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':artistBoardId', $artistBoardId, PDO::PARAM_INT);
    $statement2->execute();
    $row2 = $statement2->fetch();

  }
  else {
    $artistBoardId = false;
  }

  if (isset($_SESSION['loggedIn_user']) && isset($_SESSION['userId'])) {
    $loggedInUser = $_SESSION['loggedIn_user'];
    $userId = $_SESSION['userId'];
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Navigation Bar -->
    <?php include("nav.php") ?>

    <div class="container">
      <br>
      <h1><?= $row['title'] ?></h1>
      <p>
        <small>
          <?= date('M j, Y, g:i a', strtotime($row['datetime'])) ?>
          <?php if ($loggedInUser == $row['username'] || $loggedInUser == 'admin'): ?>
          <a href="artistboard_edit.php?artistBoardId=<?= $row['artistBoardId'] ?>&artistBoardId=<?= $row2['artistBoardId'] ?>">edit</a>
          <?php endif ?>
        </small>
      </p>
      <div><?= $row['artistPost'] ?></div>
    </div>

    <!-- Comments --> 
    <div style="max-width:700px;margin:auto;">                   
        <h3>Comments</h3>                  
    </div>

    <!-- Leave a Comment -->
      <form style="max-width:700px;margin:auto;" action="artistcomment_process.php?artistBoardId=<?= $_GET['artistBoardId'] ?>" method="post">
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
                <!-- Captcha -->
                <div class="text-center mb-5">
                  <div class="input-group">
                    <img src="captcha.php" alt="CAPTCHA" class="captcha-image center-block">    
                    <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Enter your code here">
                  </div>         
                </div>
              </div>         
            </div>
          </div>
        </div>
      </form>  

      <!-- Show Comments -->
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
                    <form action="artistcomment_process.php?artistBoardId=<?= $_GET['artistBoardId'] ?>" method="post"> 
                      <input type="hidden" name="artistCommentId" value="<?= $row2['artistCommentId'] ?>" />
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