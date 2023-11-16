
<?php


$con = mysqli_connect("localhost","root","arktechdb","ojtDatabase");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

//$connect = new PDO("mysql:host=localhost;dbname=ojtDatabase", "root", "arktechdb");

?>