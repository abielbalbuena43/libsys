<?php
// localhost
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "lms2"; 

// webhost
// $servername = "localhost";
// $username = "u281409180_lms";
// $password = "Delapaz2011"; 
// $dbname = "u281409180_lmsdb"; 

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>
