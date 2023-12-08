<?php

    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (logout.php) 
        Logs out a user and deletes their session.
    */

    session_start();
    session_destroy();
    header("Location:index.php");

?>