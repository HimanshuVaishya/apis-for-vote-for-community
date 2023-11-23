<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "votefcdb";

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$CEmail = $_POST['email'];
$CPass = $_POST['password'];

$query = "select code, name from community where email='$CEmail' and password='$CPass'";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
$count = mysqli_num_rows($result);

$response = array();

if($count == 1){
	$row = mysqli_fetch_assoc($result);
	$response['message'] =$row['code']."_".$row['name']."_exist";
}else{
	$response['message'] ="failed";
}
 echo json_encode($response);
?>