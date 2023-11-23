<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "votefcdb";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$CCode = $conn->real_escape_string($_POST['communitycode']);
$MCode = $conn->real_escape_string($_POST['votercode']);
$candidateCode = $conn->real_escape_string($_POST['candidatecode']);

$query = "SELECT canvote FROM candidate WHERE communitycode='$CCode' AND code='$MCode'";
$result = $conn->query($query);

$response = array();

if ($result) {
    $count = $result->num_rows;

    if ($count > 0) {
        $row = $result->fetch_assoc();
        $isVote = $row['canvote'];

        if ($isVote == "1") {
            $checkVoteQuery = "SELECT * FROM voted WHERE communitycode = '$CCode' AND fromvote = '$MCode'";
            $checkVoteResult = $conn->query($checkVoteQuery);

            $checkVoteCount = $checkVoteResult->num_rows;

            if ($checkVoteCount == 0) {
                $updateVoteQuery = "UPDATE votecandidatelist SET count = count + 1 WHERE communitycode = '$CCode' AND candidatecode = '$candidateCode'";
                $updateVoteResult = $conn->query($updateVoteQuery);

                if ($updateVoteResult) {
					$insertVoteQuery = "INSERT INTO voted (communitycode, fromvote) VALUES('$CCode', '$MCode')";
					$insertVoteResult = $conn->query($insertVoteQuery);
					if($insertVoteResult){
						$response['message'] = "vote recorded";
					}else{
						$response['message'] = "Something went wrong";
					}
                } else {
                    $response['message'] = "Something went wrong";
                }
            } else {
                $response['message'] = "already voted";
            }
        } else {
            $response['message'] = "You can't vote, please contact your organization";
        }
    } else {
        $response['message'] = "Something went wrong with retrieving voter information";
    }
} else {
    $response['message'] = "Query execution failed: " . $conn->error;
}

// Close the database connection
$conn->close();

echo json_encode($response);
?>
