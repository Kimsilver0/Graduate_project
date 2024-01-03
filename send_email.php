<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $number = $_POST["number"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        $to = "gracekim0513@naver.com"; // 받는 사람 이메일 주소 중요) new_cafe.php 폼처럼 수정하기!!!
        $subject = "새로운 메시지: $name";
        $body = "이름: $name\n전화번호: $number\n이메일: $email\n메시지:\n$message";

        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo "메시지가 성공적으로 전송되었습니다.";
        } else {
            echo "메시지 전송에 실패했습니다.";
        }
    }
?>