<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (index.php)
        Displays the home page for non registered user and registered users.
    */

    $thisPage = 'index';

    // Connect to the database.
    require('connect.php');

    $rows_per_page = 3;

    $query = "SELECT * FROM discussion ORDER BY datetime DESC LIMIT 3";
    $statement = $db->prepare($query);
    $statement->execute(); 

    $query2 = "SELECT * FROM discussion JOIN users ON discussion.userId = users.userId ORDER BY datetime DESC LIMIT 3";
    $statement2 = $db->prepare($query2);
    $statement2->execute(); 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A(XES) | Home</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>

    <body>        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #b4c8ea">
        <div class="container-fluid">
            <div class="mx-auto order-0">
                <a class="navbar-brand mx-auto" href="#">A(XES)</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Welcome Guest</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Sign In</a></li>			
                </ul>		  
            </div>
        </div>
    </nav>
        
    <!-- Home Page Content -->
    <div style="background-image: linear-gradient(#b4c8ea, #ffdcdb);">
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">A(XIS) Official Fanclub</h1>
                    <p class="lead text-body-secondary">Rules</p>
                    <p class="lead text-body-secondary">Please do not post any hate related subjects</p>
                    <p class="lead text-body-secondary">Roleplaying or immitating an artist is prohibited</p>
                    <a href="register.php" class="btn btn-primary my-2">Sign Up!</a>
                    </p>
                </div>
            </div>
        </section>
    </div>

    <br>
    <div class="container marketing">
        <!-- Three columns of text below the carousel -->
        <div class="row">     
            <?php while($row = $statement2->fetch()): ?>    
            <div class="col-lg-4">      
                <img src="<?="uploads/" . $row['image'] ?>" class="bd-placeholder-img rounded-circle" alt="<?= $row['username'] ?> profile">
                <h2 class="fw-normal"><?= $row['title'] ?></h2>
                <p><?= strlen($row['discussionPost']) >= 110 ? substr($row['discussionPost'], 0, 110) . "..." : $row['discussionPost'] ?></p>
                <p><a class="btn btn-primary" href="login.php">View Post »</a></p>

                <input type="hidden" name="userId" value="<?= $row['userId'] ?>" />
            </div><!-- /.col-lg-4 -->
            <?php endwhile ?>
        </div><!-- /.row -->
    </div><!-- /.container marketing -->
</body>
</html>

