<?php
    $username = $_GET['username'];

    // MySQLi 객체 생성
    $mysqli = new mysqli("localhost", "root", "", "gande_member");

    // 연결 확인
    if ($mysqli->connect_error) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // SQL 쿼리 실행
    $stmt = $mysqli->prepare("SELECT * FROM gande_member WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // 결과 집합 확인
    if (mysqli_num_rows($result) == 0) {
?>
    <div style='font-family:"malgun gothic"'><?php echo $username; ?> 사용 가능한 아이디입니다.</div>
<?php
    } else {
?>
    <div style='font-family:"malgun gothic"; color:red;'><?php echo $username; ?> 중복된 아이디입니다.</div>
<?php
    echo "<script>opener.document.gande_member.chs.value='1';</script>";
    }

    // MySQLi 객체 해제
    $stmt->close();
    $mysqli->close();
?>
<meta charset="utf-8" />
<button value="닫기" onclick="window.close()">닫기</button>