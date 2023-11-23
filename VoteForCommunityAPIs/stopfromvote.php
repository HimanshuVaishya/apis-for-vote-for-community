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

$CCode = $_POST['commnitycode'];
$MCode= $_POST['candidatecode'];
$McanVote = $_POST['canVote'];

$query = "UPDATE candidate set canvote = '$McanVote' where code = '$MCode' and communitycode = '$CCode'";
$row = mysqli_query($conn, $query);

$response = array();

if ($row) {
    $response['message'] = "updated";
} else {
	$response['message'] = "failed";
}

// Close the database connection
mysqli_close($conn);

echo json_encode($response);
?>
