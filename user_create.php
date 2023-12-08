<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (register.php) 
        Asks for authentication to CRUD a creative post and discussion post.
    */

    if(session_status() !== PHP_SESSION_ACTIVE) { 
        session_start(); 
    } 

    require("connect.php");

    $errorMsg = "";
    $registerUser = filter_input(INPUT_POST, 'registerUser', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $registerName = filter_input(INPUT_POST, 'registerName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $registerEmail = filter_input(INPUT_POST, 'registerEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $registerPassword = filter_input(INPUT_POST, 'registerPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $hashPassword = password_hash($registerPassword, PASSWORD_DEFAULT);

    if (isset($_POST['register'])) {

      $registeredUsers = "INSERT INTO users (userId, email, username, hashpassword, fullName, userType) VALUES (NULL, '$registerEmail', '$registerUser', '$hashPassword', '$registerName', 'user')";

      if ($_POST['registerPassword'] == $_POST['reRegisterPassword']) {

        $query = "SELECT * FROM users WHERE username = ?";

        // To prepare the statement from the query.
        $statement = $db->prepare($query);

        // Executes the statement.
        $statement->execute([$registerUser]);

        // Counts each row present in the database.
        $row = $statement->rowCount();

        // If there are rows present
        if ($row > 0) {
          $errorMsg = "Username is already taken!";
        }
        else {
          $statement = $db->prepare($registeredUsers);
          $statement->execute();
          $row = $statement->fetch();

          // Stores session user and redirects after REGISTRATION.
          $_SESSION['loggedIn_user'] == 'admin';
          $_SESSION['userId'] == 'admin';
          header("Location: users.php");
        }
      }
      else {
        $errorMsg = "Passwords does not match! Please try again.";
      }

    }


?>


<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <script src="/docs/5.3/assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>A(XES) | Sign Up</title>
    <link href="css/style.css" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>

  <body>
    
    <!-- Navigation Bar -->
    <?php include("nav.php") ?>

    <!-- Login Form -->
    <div class="text-center mt-5">
        <form style="max-width:600px;margin:auto;" action="user_create.php" method="post">
          <h1 class="h3 mb-3 fw-normal">Add User</h1>

          <div class="form-floating">
            <input type="text" class="form-control mb-3" id="registerName" name="registerName" placeholder="fullname" required>
            <label for="floatingInput">Full Name</label>
          </div>
          <div class="form-floating">
            <input type="email" class="form-control mb-3" id="registerEmail" name="registerEmail" placeholder="email" required>
            <label for="floatingInput">Email</label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control mb-3" id="registerUser" name="registerUser" placeholder="username" required>
            <label for="floatingInput">Username</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control mb-3" id="registerPassword" name="registerPassword" placeholder="password" required>
            <label for="floatingPassword">Password</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control mb-3" id="reRegisterPassword" name="reRegisterPassword" placeholder="re-enter password" required>
            <label for="floatingPassword">Re-enter Password</label>
          </div>

          <input class="w-100 btn btn-lg btn-primary" name="register" type="submit" value="Submit">

          <!-- Alerts -->
          <?php if ($errorMsg): ?>
            <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <?= $errorMsg ?></div>
          <?php endif ?> 
        </form>
    </div>
  </body>
</html>







