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

// 사용자가 입력한 데이터 가져오기
$name = $_POST['name'];
$phone = $_POST['phone'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'] . '@' . $_POST['eadress'];

// 체크박스 처리
$roles = isset($_POST['role']) ? $_POST['role'] : array(); // 사용자가 선택한 모든 회원 유형

if (!empty($roles)) {
    $roles_str = implode(",", $roles); // 선택한 회원 유형을 쉼표로 구분하여 문자열로 변환
} else {
    $roles_str = ""; // 선택한 회원 유형이 없을 경우 빈 문자열로 설정
}

// MySQL에 데이터 삽입
$sql = "INSERT INTO gande_member (name, phone, username, password, email, roles)
VALUES ('$name', '$phone', '$username', '$password', '$email', '$roles_str')";

if (mysqli_query($conn, $sql)) {
    $message = "회원 가입이 완료되었습니다.";
    echo "<script type='text/javascript'>alert('$message');
    window.location.href = 'login.php';</script>";
} else {
    echo "정보를 모두 입력하셨는지 확인해주세요." . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

<meta charset="utf-8" />