<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (login.php) 
        login page
    */

    session_start();
    require("connect.php");

    $errorMsg = "";
    $loginId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);
    $userLogin = filter_input(INPUT_POST, 'userLogin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $passwordLogin = filter_input(INPUT_POST, 'passwordLogin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (isset($_POST['signin'])) {

      $query = "SELECT * FROM users WHERE username = '$userLogin'";

      // To prepare the statement from the query.
      $statement = $db->prepare($query);

      // Executes the statement.
      $statement->execute();

      // Counts each row present in the database.
      $row = $statement->rowCount();

      // If there is a row present, fetch it.
      if ($_POST && $row == 1) {
        $row = $statement->fetch();

        if (password_verify($passwordLogin, $row['hashpassword'])) {
          $_SESSION['loggedIn_user'] = $userLogin;
          $_SESSION['userId'] = $row['userId'];
          header("Location: user_index.php");
        }
        else {
          $errorMsg = "Incorrect password! Please try again.";
        }
      }
      else {
        $errorMsg = "Sorry, user does not exist!";
      }
    }


?>


<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <script src="/docs/5.3/assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>A(XES) | Login</title>
    <link href="css/style.css" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="signin.css" rel="stylesheet">
  </head>

  <body>

    <!-- Login Form -->
    <div class="text-center mt-5">
        <form style="max-width:350px;margin:auto;" action="login.php" method="post">
          <div class="text-start">
            <a href="javascript:window.history.back();" class="btn btn-primary" role="button" style="text-decoration: none">Back</a>
          </div>
          <img class="mb-4" src="uploads\Axes.png" alt="" width="92" height="77"></a>
          <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

          <div class="form-floating">
            <input type="text" class="form-control mb-3" id="floatingInput" name="userLogin" placeholder="username" required>
            <label for="floatingInput">Username</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control mb-3" id="floatingPassword" name="passwordLogin" placeholder="password" required>
            <label for="floatingPassword">Password</label>
          </div>

          <div class="checkbox mb-3">
            <label><input type="checkbox" value="remember-me"> Remember me</label>
          </div>

          <input class="w-100 btn btn-lg btn-primary" name="signin" type="submit" value="Sign in">
          <p class="text-center"><a href="register.php">Create a New Account ?</a></p>
          <p class="mt-5 mb-3 text-muted">© 2023–2024</p>

          <!-- Alerts -->
          <?php if ($errorMsg): ?>
            <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <?= $errorMsg ?></div>
          <?php endif ?> 
        </form>
    </div>
  </body>
</html>







