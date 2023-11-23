<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "votefcdb";

$conn = mysqli_connect($servername,$username,$password);
mysqli_select_db($conn, $db);

	if(isset($_POST['communitycode'], $_POST['code'], $_POST['name'], $_POST['email'], $_FILES['upload'])){
		$CCode = $_POST['communitycode'];
		$MCode = $_POST['code'];
		$MName = $_POST['name'];
		$MEmail = $_POST['email'];
		
		if($_FILES['upload']){
			$on = $_FILES['upload']['name'];
			$sn = $_FILES['upload']['tmp_name'];
			$newImageName = $CCode . '_' . $MCode .'.png';
			$dn = "images/" . $newImageName;
			move_uploaded_file($sn, $dn);
			
			$query = "Insert Into candidate (communitycode, code, name, email, image) values('$CCode', '$MCode', '$MName', '$MEmail', '$newImageName')";
			$res = mysqli_query($conn, $query);
			
			if($res == true){
				$response = array("status"=>"1","msg"=>"created account successfully");
			}else{
				$response = array("status"=>"0","msg"=>"faild to create account");
			}
			echo json_encode($response);
		}
	}
?>