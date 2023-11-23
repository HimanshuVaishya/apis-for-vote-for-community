<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "votefcdb";

$conn = new mysqli($servername,$username,$password,$db);

if($conn->connect_error){
	die("Connection Faild".$conn->connect_error);
}

$CCode = $_POST['comcode'];
$MCode = $_POST['memcode'];
$Pass = $_POST['pass'];

$query = "select email from candidate where communitycode='$CCode' and code='$MCode' and password='$Pass'";

$raw = mysqli_query($conn, $query);

if ($raw) {
    $count = mysqli_num_rows($raw);
    if ($count > 0) {
        $row = mysqli_fetch_assoc($raw);
        $email = $row['email'];

        $response['message'] =  $email;
    } else {
        $response['message'] =  "wrong";
    }
}else {
        $response['message'] =  "wrong";
}
// Close the database connection
mysqli_close($conn);

echo json_encode($response);
?>