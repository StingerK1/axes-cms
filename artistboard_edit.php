<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (artistboard_edit.php) 
        Where artist and admin can edit posts
    */

    // Prompt for authentication and connect to the database.
    require('connect.php');   

    // Build and prepare SQL String with :artistboardId placeholder parameter.
    $query     = "SELECT * FROM artistboard WHERE artistBoardId = :artistBoardId LIMIT 1"; 
    $statement = $db->prepare($query);

    // Sanitize $_GET['artistboardId'] to ensure it's a number.
    $artistBoardId = filter_input(INPUT_GET, 'artistBoardId', FILTER_SANITIZE_NUMBER_INT);

    // Bind the :artistboardId parameter in the query to the sanitized
    // $artistboardId specifying a binding-type of Integer.
    $statement->bindValue(':artistBoardId', $artistBoardId, PDO::PARAM_INT);
    $statement->execute();
    
    // Fetch the row selected by primary key artistboardId.
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
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    </head>

    <!-- Edit overview -->
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- Navigation Bar -->
        <?php include("nav.php") ?>

        <div class="container mt-5">
            <div class="panel panel-default">
                <div class="col-md-12">
                    <form style="max-width:600px;margin:auto;" action="artistboard_process.php" method="post">
                        <h1>Edit Post</h1>
                        <div class="col-md-12">
                            <label>Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?= $row['title'] ?>" />
                        </div>
                        <div class="col-md-12">
                            <label>Content</label>
                            <textarea name="artistPost" id="content" class="form-control" rows="4" style="resize: none;"><?= $row['artistPost'] ?></textarea>
                        </div> 
                        <div class="col=md-12">
                            <br>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                            <input type="submit" class="btn btn-primary" name="delete" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')">
                        </div>

                        <input type="hidden" name="artistBoardId" value="<?= $row['artistBoardId'] ?>" />
                    </form>
                </div>
            </div>
        </div>

        <!-- WYSIWYG Editor -->
        <script>CKEDITOR.replace( 'artistPost' );</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
