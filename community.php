<?php 

    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (community.php) 
        Categories for community.
    */

    $thisPage = '';

    // Connect to the database.
    require('connect.php');

    if(session_status() !== PHP_SESSION_ACTIVE) { 
      session_start(); 
    } 

    $query = "SELECT * FROM community ORDER BY communityId";
    $statement = $db->prepare($query);
    $statement->execute();
  
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


    <section id="main">
      <div class="container">
        <div class="row">

          <!-- Community Overview -->
          <div class="col-mt-9">
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="col-md-3 mt-5">Community <span class="badge"><?= $row = $statement->rowCount() ?></span></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-7">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Language
                    </button>
                  </div>
                </div>
                <br>
                <table class="table tabie-striped table-hover">
                  <tr>
                    <th>#</th>
                    <th>Language</th>
                    <th></th>
                  </tr>
                  <?php while($row = $statement->fetch()): ?>
                    <tr>
                      <td><?= $row['communityId'] ?></td>
                      <td><?= $row['community'] ?></td>
                      
                      <input type="hidden" name="communityId" value="<?= $row['communityId'] ?>" />
                      <td><a class="btn btn-default" href="community_edit.php?communityId=<?= $row['communityId'] ?>">Edit</a></td>
                    </tr>
                  <?php endwhile ?>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- Add Community Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="community_process.php" method="post">

            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Community</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <label>Language</label>
              <input type="text" name="communityName" id="communityName" class="form-control" placeholder="Add a Language">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" name="add" class="btn btn-primary" value="Add">
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
