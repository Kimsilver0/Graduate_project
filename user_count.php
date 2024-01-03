<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$hostname = "root";
$password = "";
$dbname = "gande_member";

// DB 연결을 생성합니다.
$conn = new mysqli($servername, $hostname, $password, $dbname);

// DB 연결 오류를 확인합니다.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// gande_member 테이블에서 회원 수를 측정합니다.
$sql = "SELECT COUNT(*) as count FROM gande_member";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$count = $row['count'];

// 회원 수를 반환합니다.
echo $count;

// DB 연결을 닫습니다.
$conn->close();
?>