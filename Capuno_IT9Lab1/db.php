<?php

// $host="localhost";
// $user = "root";
// $password = "";
// $dbname = "assessment_db";


$conn = mysqli_connect("localhost", "root", "", "assessment_db");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
    echo "Connection failed: " . mysqli_connect_error();
}
else{
    
}

?>