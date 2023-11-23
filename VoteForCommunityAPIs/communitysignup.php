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

$CCode = $_POST['code'];
$CName = $_POST['name'];
$CEmail = $_POST['email'];
$CPass = $_POST['password'];

$query1 = "SELECT * FROM community WHERE email='$CEmail' OR code='$CCode'";
$raw1 = mysqli_query($conn, $query1);
$count1 = mysqli_num_rows($raw1);

$response = array();

if ($count1 > 0) {
    $row = mysqli_fetch_assoc($raw1);
    if ($row['email'] == $CEmail) {
        $response['message'] = "email";
    } else {
        $response['message'] = "code";
    }
} else {
    $query = "INSERT INTO community (code, name, email, password) VALUES ('$CCode', '$CName', '$CEmail', '$CPass')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $response['message'] = "created";
    } else {
        $response['message'] = "failed";
    }
}

// Close the database connection
mysqli_close($conn);

echo json_encode($response);
?>
