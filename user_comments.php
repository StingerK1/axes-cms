<?php


$thisPage = 'user_comments';

// Sets number of rows to be displayed per page.
$rows_per_page = 5;

// Connect to the database.
require('connect.php');

if(session_status() !== PHP_SESSION_ACTIVE) { 
  session_start(); 
} 

$query = "SELECT * FROM comments";
$statement = $db->prepare($query);
$statement->execute(); 

// Determine which page number visitor is currently on
if (!isset($_GET['page'])) {
  $page = 1;
}
else {
    $page = $_GET['page'];
}

// Counts the rows present in the database.
$number_of_rows = $statement->rowCount();

// Determines the number of total pages available.
$number_of_pages = ceil($number_of_rows / $rows_per_page);

// Determines the LIMIT starting number for display
$first_page = ($page - 1) * $rows_per_page;

// Retrieve selected results from database and display them on page
$query = "SELECT * FROM comments ORDER BY datetime DESC LIMIT " . $first_page . ',' . $rows_per_page;
$statement = $db->prepare($query);
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
                <a href="user_discussion.php" class="list-group-item"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>Discussions</a>
                <a href="user_comments.php" class="list-group-item active main-color-bg"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Comments</a>
                <a href="users.php" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users</a>
                <a href="admin.php" class="list-group-item"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>Overview</a>
            </div>
                
            </div>

            <!-- comments Overview -->
            <div class="col-md-9 mt-5">
                <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                    <h3 class="panel-title">Comments <span class="badge"><?= $number_of_rows ?></span></h3>
                </div>
                <div class="panel-body">
                    <br>
                    <table class="table tabie-striped table-hover">
                    <tr>
                        <th>Content</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    <?php while($row = $statement->fetch()): ?>
                        <tr>
                        <td><?= strlen($row['comment']) >= 50 ? substr($row['comment'], 0, 50) . "..." : $row['comment'] ?></td>
                        <td><?= date("M j, Y, g:i a", strtotime($row['datetime'])) ?></td>
                        
                        <input type="hidden" name="commentId" value="<?= $row['commentId'] ?>" />
                        <!-- <td><a class="btn btn-default" href="comments_edit.php?commentId=<?= $row['commentId']?>">Edit</a></form></td> -->
                        </tr>
                    <?php endwhile ?>
                    </table>
                </div>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation example" style="max-width:100px;margin:auto;" class="text-center">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a href="user_comments.php?page=<?= ($page - 1) ?>" aria-label="Previous" style="color: #0d6efd;" class="page-link">Previous</a>
                                </li>
                            <?php endif ?>
                            <?php for ($i = 1; $i <= $number_of_pages; $i++): ?>
                                <?php if ($page == $i) { $status = "active"; } else { $status = ""; } ?>
                                <li class="<?= $status ?>">
                                    <a href="user_comments.php?page=<?= $i ?>" class="page-link" style="background-color: #0d6efd; color: #fff;"><?= $i ?></a>
                                </li>
                            <?php endfor ?>
                            <?php if ($number_of_pages > $page): ?>
                                <li>
                                    <a href="user_comments.php?page=<?= ($page + 1) ?>" aria-label="Next" class="page-link" style="color: #0d6efd;">Next</a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </nav>

            </div>
            </div>
        </div>
        </section>

        <script>CKEDITOR.replace( 'comment' );</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
