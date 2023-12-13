<?php

    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (community_show.php) 
        Displays post by community
    */

    // Connect to the database.
    require('connect.php');

    if(session_status() !== PHP_SESSION_ACTIVE) { 
    session_start(); 
    }

    // To display artistboard according to its community
    if(isset($_GET['communityId'])) {
        
    $communityId = filter_input(INPUT_GET, 'communityId', FILTER_SANITIZE_NUMBER_INT);

    //    $query = "SELECT * FROM discussion JOIN users ON discussion.userId = users.userId ORDER BY datetime DESC LIMIT "
    //    $statement = $db->prepare($query);
    //    $statement->execute(); 

    $query2 = "SELECT * FROM discussion D JOIN users U ON D.userId = U.userId JOIN community C ON D.communityId = C.communityId WHERE D.communityId = :communityId ORDER BY D.datetime LIMIT 6";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":communityId", $communityId, PDO::PARAM_INT);
    $statement2->execute(); 
    
    }
    else {
    $communityId = false;
    }

    // Displays all community in a nav
    $community = "SELECT * FROM community ORDER BY communityId";
    $statement3 = $db->prepare($community);
    $statement3->execute();



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A(XES) | Community</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>

    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        

    <!-- Navigation Bar -->
    <?php include("nav.php") ?>

    <div style="background-image: linear-gradient(#b4c8ea, #ffdcdb);">
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="h1">Community</h1>
                    <p class="lead text-body-secondary">Filter discussion by your language!</p>
                </div>
            </div>
        </section>
    </div>
    <br>

    <!-- Display discussion by community -->
    <div class="container">
        <div class="row">
            <?php while($row = $statement2->fetch()): ?>
            <div class="col-lg-4" >
                <img src="<?="uploads/" . $row['image'] ?>" style="max-width:100px;margin:auto;" class="bd-placeholder-img rounded-circle" alt="<?= $row['username'] ?> profile">
                <h2><?=$row['title']?></h2>
                <p><?= $row['discussionPost'] ?></p><br>
                <p><a class="btn btn-primary" href="show.php?discussionId=<?= $row['discussionId'] ?>&communityId=<?= $row['communityId'] ?>&p=<?= (str_replace(' ', '-', strtolower($row['title']))) ?>">View Post »</a></p>        
            </div>
            <?php endwhile ?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
    <script src="js/bootstrap.min.js"></script>
</body>
</html>