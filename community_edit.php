<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (community_edit.php) 
        Where registered users can edit communities
    */

    // Prompt for authentication and connect to the database.
    require('connect.php');

    if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
    }

    // Build and prepare SQL String with :communityId placeholder parameter.
    $query     = "SELECT * FROM community WHERE communityId = :communityId LIMIT 1";
    $statement = $db->prepare($query);

    // Sanitize $_GET['communityId'] to ensure it's a number.
    $communityId = filter_input(INPUT_GET, 'communityId', FILTER_SANITIZE_NUMBER_INT);

    // Bind the :communityId parameter in the query to the sanitized
    // $id specifying a binding-type of Integer.
    $statement->bindValue('communityId', $communityId, PDO::PARAM_INT);
    $statement->execute();

    // Fetch the row selected by primary key communityId.
    $row = $statement->fetch();

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

    <section id="main">
        <div class="container">
            <div class="row">
                <!-- Edit Overview -->
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading main-color-bg">
                            <h3 class="col-md-3 mt-5">Edit Community</h3>
                        </div>
                        <div class="panel-body">
                            <form action="community_process.php" method="post">
                                <div class="form-group">
                                    <label>Language</label>
                                    <input type="text" name="communityName" id="communityName" class="form-control" value="<?= $row['community']?>" />
                                </div>

                                <div class="modal-footer">
                                    <?php if ($loggedInUser == 'admin'): ?>   
                                    <input type="submit" name="modify" class="btn btn-primary main-color-bg" value="Modify">
                                    <input type="submit" class="btn btn-primary trigger-btn" data-dismiss="modal" name="remove" value="Remove" onclick="return confirm('Are you sure you wish to remove this community?')" />
                                    <?php else: ?>
                                    <input type="submit" name="modify" class="btn btn-primary main-color-bg" value="Modify">
                                    <input type="button" class="btn btn-primary" value="Close" onclick="history.go(-1)">
                                    <?php endif ?>  
                                    
                                    <input type="hidden" name="communityId" value="<?= $row['communityId'] ?>" />
                                </div>
                            </form>
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
