<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (nav.php) 
        Shows the navigation bar of each page.
    */

    $loggedInUser = "";

    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }

    if (isset($_SESSION['loggedIn_user']) && isset($_SESSION['userId'])) {
      $loggedInUser = $_SESSION['loggedIn_user'];
      $userId = $_SESSION['userId'];
    }

    $artristNav = "SELECT * FROM artistboard JOIN users ON artistboard.userId = users.userId";
    $artistStat = $db->prepare($artristNav);
    $artistStat->execute();

?>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg" style="background-color: #b4c8ea">
    <div class="container-fluid">
        <div class="mx-auto order-0">
            <a class="navbar-brand mx-auto" href="user_index.php">A(XES)</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Categories -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="<?= ($thisPage == 'user_index') ? 'active' : '' ?>"><a class="nav-link" aria-current="page" href="user_index.php">Home</a></li>
                <li class="<?= ($thisPage == 'discussion') ? 'active' : '' ?>"><a class="nav-link" href="discussion.php">Discussion</a></li>
                <li class="<?= ($thisPage == 'artistboard') ? 'active' : '' ?> nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Artists</a>
                    <ul class="dropdown-menu">
                        <?php while($artistRow = $artistStat->fetch()): ?>
                            <li class="active"><a class="nav-link" href="artist.php"><?= $artistRow['fullName'] ?></a></li>
                        <?php endwhile ?>    
                    </ul>
                </li>
                <li class="<?= ($thisPage == 'creative') ? 'active' : '' ?>"><a class="nav-link" href="creative.php">Creative</a></li>
                <?php if ($loggedInUser == 'admin'): ?>
                <li class="<?= ($thisPage == 'admin') ? 'active' : '' ?>"><a class="nav-link" href="admin.php">Admin</a></li>
            <?php endif ?>
            </ul>

            <!-- Logout -->
            <?php if ($loggedInUser): ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Welcome <?= $loggedInUser ?></a></li>
                <li class="<?= ($thisPage == 'edit_profile') ? 'active' : '' ?>"><a class="nav-link" href="edit_profile.php?userId=<?= $userId ?>">My Account</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>			
            </ul>
            <?php endif ?>	
            
        </div>
    </div>
</nav>







