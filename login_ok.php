<?php
    session_start(); // 세션 시작
    $servername = "localhost"; // 데이터베이스 서버 이름
    $hostname = "root"; // 데이터베이스 사용자 이름
    $password = ""; // 데이터베이스 사용자 비밀번호
    $dbname = "gande_member"; // 데이터베이스 이름

    // 데이터베이스 연결 생성
    $conn = mysqli_connect($servername, $hostname, $password, $dbname);

    // 입력된 아이디와 비밀번호
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL 쿼리문 작성
    $sql = "SELECT * FROM gande_member WHERE username = '$username' AND password = '$password'";

    // SQL 쿼리문 실행
    $result = mysqli_query($conn, $sql);

    // 쿼리문 결과 확인
    if(mysqli_num_rows($result) == 1) { // 일치하는 결과가 1개인 경우
        $row = mysqli_fetch_assoc($result); // 결과 데이터 가져오기
        $_SESSION['username'] = $row['username']; // 세션 생성 및 아이디 저장
        echo "<script>alert('로그인 완료!');</script>";
        echo "<script>location.href='main.php';</script>";
    } else { // 일치하는 결과가 없는 경우
        session_start();

        if(isset($_SESSION['login_attempt']) && $_SESSION['login_attempt'] >= 5) {
        // 사용자가 로그인 시도 5회 이상일 때, 로그인 버튼을 막음
        //    echo "<script>document.getElementById('btn').disabled = true;</script>";
    
        // 로그인 시도를 1분 후에 다시 시도할 수 있도록 시간을 알려줌
            $remaining_time = 60 - (time() - $_SESSION['last_login_attempt_time']);
            echo "<script>alert('로그인 시도 횟수를 초과하셨습니다. 1분 후에 다시 시도해주세요.');</script>";
            echo "<script>document.getElementById('btn').innerHTML = '로그인 (' + $remaining_time + '초 후 다시 시도)';</script>";
    
        // 로그인 시도 횟수 초기화
        if($remaining_time <= 0) {
            unset($_SESSION['login_attempt']);
            unset($_SESSION['last_login_attempt_time']);
        }
        }

        // 로그인 시도 횟수 저장
        if(isset($_POST['username']) && isset($_POST['password'])) {
        // 로그인 폼에 입력된 사용자 정보를 확인하는 로직
        if(mysqli_num_rows($result) == 1) {
        // 로그인 성공 시, 로그인 시도 횟수 초기화
            unset($_SESSION['login_attempt']);
            unset($_SESSION['last_login_attempt_time']);
        
        // 로그인 성공 후 다음 페이지로 이동
            header('Location: main.php');
            exit;
        } else {
            // 로그인 실패 시, 로그인 시도 횟수 증가
            if(isset($_SESSION['login_attempt'])) {
                $_SESSION['login_attempt'] += 1;
            } else {
                $_SESSION['login_attempt'] = 1;
            }
          
            // 마지막 로그인 시도 시간 저장
            $_SESSION['last_login_attempt_time'] = time();
        
            // 로그인 실패 후 사용자에게 알림
            echo "<script>alert('아이디와 비밀번호를 확인해주세요.');</script>";
        }
    }
        echo "<script>location.href='login.php';</script>"; // 로그인 페이지로 이동
    }

    mysqli_close($conn); // 데이터베이스 연결 종료
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <script>
        function checkCapsLock(event) {
            var capsLockOn = event.getModifierState && event.getModifierState('CapsLock');
            var capsLockMsg = document.getElementById('capsLockMsg');
    
            if (capsLockOn) {
                capsLockMsg.innerHTML = "Caps Lock이 켜져 있습니다.";
            } else {
                capsLockMsg.innerHTML = "";
            }
        }
    </script>
</head>
</html>