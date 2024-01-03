<?php
header('Content-Type: text/html; charset = utf-8');
if($_POST["name"] == "" || $_POST["email"] == ""){
		echo '<script> alert("항목을 입력하세요"); history.back(); </script>';
	} else{
	$name = $_POST['name'];
	$email = $_POST['email'].'@'.$_POST['eadress'];

$conn = mysqli_connect("localhost", "root", "", "gande_member");
$sql = "SELECT * FROM gande_member WHERE name = '{$name}' && email = '{$email}'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if($row["name"] == $name){
	echo "<script>alert('회원님의 ID는 ".$row['username']."입니다.');</script>";
	echo "<script>location.href='login.php';</script>"; // 로그인 페이지로 이동
} else{
echo "<script>alert('없는 계정입니다.'); history.back();</script>";
}
}
?>

<mata charset = "utf-8" />