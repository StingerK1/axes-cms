<?php

    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (discussion.php) 
        Page for registered user to post and view discussions 
    */

    $thisPage = 'discussion';

    //Sets numbers of rows to be displayed per page
    $rows_per_page = 6;

    //connec to the database
    require('connect.php');

    if(session_status() !==PHP_SESSION_ACTIVE) {
        session_start();
    }

    $query = "SELECT * FROM discussion";
    $statement = $db->prepare($query);
    $statement->execute();

    //Determines which page number visitor is currently on
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

    //Retrieve selected results from database and display them on page
    $query = "SELECT * FROM discussion JOIN users ON discussion.userId = users.userId ORDER BY datetime DESC LIMIT " . $first_page . ',' . $rows_per_page;
    $statement = $db->prepare($query);
    $statement->execute(); 
        
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A(XES) | Discussion</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>

    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        
        <!-- Navigation Bar -->
        <?php include("nav.php") ?>

        <!-- Home Page Content -->
        <div class="bg-img bg-cover">
            <div style="background-image: linear-gradient(#b4c8ea, #ffdcdb);">
                <section class="py-5 text-center container">
                    <div class="row py-lg-5">
                        <div class="col-lg-6 col-md-8 mx-auto">
                            <h1 class="fw-light">Discussions</h1>
                            <p class="lead text-body-secondary">Connect with fellow fans around the world.</p>
                            <a href="discussion_create.php" class="btn btn-primary" role="button" style="text-decoration: none">Share on A(XES)</a>
                        
                        </div>
                    </div>
                </section>
            </div>
            <br>
            <div class="container marketing">
            <!-- Three columns of text below the carousel -->   
                <div class="row">     
                    <?php while($row = $statement->fetch()): ?>    
                    <div class="col-lg-4">      
                        <img src="<?="uploads/" . $row['image'] ?>" style="max-width:100px;margin:auto;" class="bd-placeholder-img rounded-circle" alt="<?= $row['username'] ?> profile">
                        <h4 class="fw-normal"><?= $row['title'] ?></h4>
                        <p><?= strlen($row['discussionPost']) >= 110 ? substr($row['discussionPost'], 0, 110) . "..." : $row['discussionPost'] ?></p>
                        <p><a class="btn btn-primary" href="show.php?discussionId=<?= $row['discussionId'] ?>">View Post »</a></p>

                        <input type="hidden" name="userId" value="<?= $row['userId'] ?>" />
                    </div><!-- /.col-lg-4 -->
                    <?php endwhile ?>

                    <!-- Page -->
                    <nav aria-label="Page navigation example" style="max-width:100px;margin:auto;" class="text-center">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a href="discussion.php?page=<?= ($page - 1) ?>" aria-label="Previous" style="color: #0d6efd;" class="page-link">Previous</a>
                                </li>
                            <?php endif ?>
                            <?php for ($i = 1; $i <= $number_of_pages; $i++): ?>
                                <?php if ($page == $i) { $status = "active"; } else { $status = ""; } ?>
                                <li class="<?= $status ?>">
                                    <a href="discussion.php?page=<?= $i ?>" class="page-link" style="background-color: #0d6efd; color: #fff;"><?= $i ?></a>
                                </li>
                            <?php endfor ?>
                            <?php if ($number_of_pages > $page): ?>
                                <li>
                                    <a href="discussion.php?page=<?= ($page + 1) ?>" aria-label="Next" class="page-link" style="color: #0d6efd;">Next</a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </nav>

                </div><!-- /.row -->
            </div><!-- /.container marketing -->
        </div>    
    </body>
</html>
