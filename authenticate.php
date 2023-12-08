<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (authenticate.php) 
        Asks for authentication to CRUD a creative post and discussion post.
    */

    define('ADMIN_LOGIN','april'); 
    define('ADMIN_PASSWORD','password123'); 
    
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) 
          || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN) 
          || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) { 
      header('HTTP/1.1 401 Unauthorized'); 
      header('WWW-Authenticate: Basic realm="Our Blog"'); 
      exit("Access Denied: Username and password required."); 
    }

?>