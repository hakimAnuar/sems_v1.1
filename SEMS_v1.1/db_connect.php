<?php 

// $conn= new mysqli('localhost','root','','sems')or 
// die("Could not connect to mysql".mysqli_error($con));

?>

<!-- -------------------------------------------------------------------------------------------------------------------------------------------------- -->

<?php
/* Database connection settings localhost*/
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sems';
$conn = mysqli_connect($host, $username, $password, $database);

// --------------------------------------------------------------------------------------------------------------------------------------------------

/* Database connection settings for navicat*/
// $host = '43.74.21.212';
// $username = 'soemmatecon';
// $password = 'matecon1234';
// $database = 'sems';
// $conn = mysqli_connect($host, $username, $password, $database);

// --------------------------------------------------------------------------------------------------------------------------------------------------

if(!$conn){
	echo 'Connection Error to database'.mysqli_connect_error();
}
?>