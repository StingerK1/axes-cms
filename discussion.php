<?php

    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (discussion.php) 
        Page for registered user to post and view discussions 
    */

    $thisPage = 'discussion';

    //connec to the database
    require('connect.php');

    if(session_status() !==PHP_SESSION_ACTIVE) {
        session_start();
    }

    $query = "SELECT * FROM discussion";
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
                        <h4 class="fw-normal"><?= $row['title'] ?></h4>
                        <p><?= strlen($row['discussionPost']) >= 110 ? substr($row['discussionPost'], 0, 110) . "..." : $row['discussionPost'] ?></p>
                        <p><a class="btn btn-primary" href="show.php?discussionId=<?= $row['discussionId'] ?>">View Post »</a></p>

                        <input type="hidden" name="userId" value="<?= $row['userId'] ?>" />
                    </div><!-- /.col-lg-4 -->
                    <?php endwhile ?>

                </div><!-- /.row -->
            </div><!-- /.container marketing -->
        </div>    
    </body>
</html>
