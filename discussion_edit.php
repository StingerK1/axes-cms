<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (edit.php) 
        Where authenticated users and admin can edit posts
    */

    // Prompt for authentication and connect to the database.
    require('connect.php');   

    // Build and prepare SQL String with :discussionId placeholder parameter.
    $query     = "SELECT * FROM discussion WHERE discussionId = :discussionId LIMIT 1"; 
    $statement = $db->prepare($query);

    // Sanitize $_GET['discussionId'] to ensure it's a number.
    $discussionId = filter_input(INPUT_GET, 'discussionId', FILTER_SANITIZE_NUMBER_INT);

    // Bind the :discussionId parameter in the query to the sanitized
    // $discussionId specifying a binding-type of Integer.
    $statement->bindValue(':discussionId', $discussionId, PDO::PARAM_INT);
    $statement->execute();
    
    // Fetch the row selected by primary key discussionId.
    $row = $statement->fetch();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A(XES) | Edit Post</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>

    <!-- Edit overview -->
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- Navigation Bar -->
        <?php include("nav.php") ?>

        <div class="container mt-5">
            <div class="panel panel-default">
                <div class="col-md-12">
                <form style="max-width:600px;margin:auto;" action="discussion_process.php" method="post">
                    <h1>Edit Post</h1>
                    <div class="col-md-12">
                        <label>Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?= $row['title'] ?>" />
                    </div>
                    <div class="col-md-12">
                        <label>Content</label>
                        <textarea name="discussionPost" id="content" class="form-control" rows="4" style="resize: none;"><?= $row['discussionPost'] ?></textarea>
                    </div> 
                    <div class="col=md-12">
                        <br>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <input type="submit" class="btn btn-primary" name="delete" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')">
                    </div>

                    <input type="hidden" name="discussionId" value="<?= $row['discussionId'] ?>" />
                </form>
            </div>
        </div>

    </body>
</html>
