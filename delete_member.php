<?php
// MySQL 데이터베이스에 연결
$servername = "localhost";
$hostname = "root";
$password = "";
$dbname = "gande_member";

$conn = mysqli_connect($servername, $hostname, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 회원 아이디 (username)를 POST로 받아옵니다.
$delete_username = $_POST['username_to_delete']; // 이 부분을 수정하세요

// MySQL에서 해당 아이디를 가진 회원 삭제
$sql = "DELETE FROM members WHERE username = '$delete_username'";

if (mysqli_query($conn, $sql)) {
    echo "회원 정보가 삭제되었습니다.";
} else {
    echo "회원 정보 삭제 중 오류 발생: " . mysqli_error($conn);
}

mysqli_close($conn);
?>