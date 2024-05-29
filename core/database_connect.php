<?php
session_start();

/**
 * Voor de MAC gebruikers;
 */
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "td";



$con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($con -> connect_errno) {
    echo "Failed to connect to MySQL: " . $con -> connect_error;
    exit();
}

// define("BASEURL","http://localhost/sch/notion/module4.1/deel3/");
// define("BASEURL_CMS","http://localhost/sch/notion/module4.1/deel3/admin/");
// define("BASEURL_AB","/opt/lampp/htdocs/sch/notion/module4.1/deel3/");