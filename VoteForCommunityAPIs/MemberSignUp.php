<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "votefcdb";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$CCode = $conn->real_escape_string($_POST['comcode']);
$MName = $conn->real_escape_string($_POST['name']);
$MCode = $conn->real_escape_string($_POST['memcode']);
$MEmail = $conn->real_escape_string($_POST['email']);
$Pass = $conn->real_escape_string($_POST['pass']);
$image = $conn->real_escape_string($_POST['upload']);

$CCodeQuery = "SELECT * FROM community WHERE code='$CCode'";
$CCoderaw = mysqli_query($conn, $CCodeQuery);
$ChkCode = mysqli_num_rows($CCoderaw);


if ($ChkCode > 0) {
    $query1 = "SELECT * FROM candidate WHERE code='$MCode' AND communitycode='$CCode'";
    $raw1 = mysqli_query($conn, $query1);
    $count1 = mysqli_num_rows($raw1);

    if ($count1 > 0) {
        $response = "code already";
    } else {
        $query2 = "SELECT * FROM candidate WHERE code='$$MCode'";
        $raw2 = mysqli_query($conn, $query2);
        $count2 = mysqli_num_rows($raw2);

        $query3 = "SELECT * FROM candidate WHERE email='$MEmail'";
        $raw3 = mysqli_query($conn, $query3);
        $count3 = mysqli_num_rows($raw3);

        if ($count2 > 0) {
            $response = "code already";
        } elseif ($count3 > 0) {
            $response = "email already";
        } else {
			$newImageName = $CCode . '_' . $MCode . '.png';
			$dn = "images/" . $newImageName;
			file_put_contents($dn, base64_decode($image));
			$query = "INSERT INTO candidate (communitycode, name, code, email, password, image) VALUES ('$CCode', '$MName', '$MCode', '$MEmail', '$Pass', '$newImageName')";
			$res = mysqli_query($conn, $query);

			if ($res) {
				$response  = "account created";
			} else {
				$response = "something went wrong with the query: " . mysqli_error($conn);
			}
        }
    }
} else {
    $response = "Community Code Does Not Exist";
}

// Close the database connection
mysqli_close($conn);
echo $response;
?>
