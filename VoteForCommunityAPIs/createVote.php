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
$candidateList = $_POST['candidatelist'];
$title = $_POST['title'];

$deletequery1 = "DELETE FROM votecandidatelist WHERE communitycode = '$CCode'";
mysqli_query($conn, $deletequery1);
$deletequery2 = "DELETE FROM voted WHERE communitycode = '$CCode'";
mysqli_query($conn, $deletequery2);
$deletequery3 = "DELETE FROM votelist WHERE communitycode = '$CCode'";
mysqli_query($conn, $deletequery3);


$query = "INSERT INTO votelist (communitycode, title) VALUES ('$CCode', '$title')";
$result = mysqli_query($conn, $query);

$response = array();

if ($result) {
	$candidate = explode(',', $candidateList);
	foreach ($candidate as $CodeName) {
		$parts = explode('_', $CodeName);
		$candidateCode = $parts[0];
		$candidateName = $parts[1];
		$query1 = "INSERT INTO votecandidatelist (communitycode, candidatecode, candidatename) VALUES ('$CCode','$candidateCode', '$candidateName')";
		$result1 = mysqli_query($conn, $query1);
	}
	$response['message'] = "created";
} else {
	$response['message'] = "failed";
}

// Close the database connection
mysqli_close($conn);

echo json_encode($response);
?>
