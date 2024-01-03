<?php
session_start(); // 세션 시작
unset($_SESSION['username']);
// 쿠키 삭제
setcookie('username', '', time() - 3600, '/');
// 로그인 페이지로 이동
header('Location: main.php'); // 로그인 페이지로 이동
exit;
?>