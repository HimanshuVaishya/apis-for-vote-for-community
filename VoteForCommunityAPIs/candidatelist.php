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

$CCode = $_POST['communitycode'];

$query = "SELECT * FROM candidate WHERE communitycode = '$CCode'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Close the database connection
mysqli_close($conn);

echo json_encode($data);

?>
