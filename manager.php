<?php
	session_start();

	$conn = mysqli_connect("localhost", "root", "", "gande_member");

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// 로그인 처리 후, 쿠키에 로그인 정보 저장
	$is_login = false;
	if ($is_login) {
		$is_login = true;
    	setcookie('username', $username, time() + 3600, '/');
    	session_start();
    	$_SESSION['username'] = $username;
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>인증번호 입력</title>
    <script src="http://kit.fontawesome.com/e1a4d00b81.js" crossorigin="anonymous"></script>
    <style>
        *{
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
            text-decoration : none;
        }
        /* 스타일을 추가하여 팝업을 디자인할 수 있습니다. */
        body {
            background-color:#8fbc8f;
        }
        .popup {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
        }

        /* 스타일 추가: 숫자 입력란 스타일링 */
        .auth-code-input {
            width: 90%;
            font-size: 24px;
            text-align: center;
            padding: 8px;
        }
        .top {
            line-height: 24px;
            font-size: 11px;
            background: #fff;
            background: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            z-index: 9999;
            position: relative;
            font-family: Cambria, Georgia, serif;
            box-shadow: 1px 0px 2px rgba(0,0,0,0.2);
        }

        /* Clearfix hack by Nicolas Gallagher: http://nicolasgallagher.com/micro-clearfix-hack/ */

        .top:before,
        .top:after {
            content: " "; /* 1 */
            display: table; /* 2 */
        }

        .top:after {
            clear: both
        }

        .top a {
            padding: 0px 10px;
            letter-spacing: 1px;
            color: #333;
            display: inline-block;
        }

        .top a:hover {
            background: rgba(255,255,255,0.6)
        }

        .top span.right {
            float: right
        }

        .top span.right a {
            float: left;
            display: block;
        }
    </style>
</head>
<body>
<div class="top">
      <a href="main.php">
        <strong>&laquo; GANDE HOME </strong>
      </a>
      <span class="right">
        <?php
          if (isset($_SESSION['username']) || isset($_COOKIE['username'])) {
            // 로그인 상태
              if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                $sql = "SELECT name FROM gande_member WHERE username = '{$username}'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $name = $row['name'];
                  echo "<a href='mypage.php'><strong>{$name}님 환영합니다!</strong></a>";
                function redirect($url) {
                    header('Location: contact.php'.$url);
                    exit();
                }
              } else {
                $username = $_COOKIE['username'];
                $sql = "SELECT name FROM gande_member WHERE username = '{$username}'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $name = $row['name'];
                echo "<a href='mypage.php'><strong>{$name}님 환영합니다!</strong></a>";
              }
              // 로그아웃 버튼 표시
              echo '<a href="logout.php"><strong>로그아웃</strong></a>';

              // echo '<li><a href="mypage.php">마이페이지</a></li>';
            } else {
            echo '<a href="login.php"><strong>로그인</strong></a>';
          }
          echo '<a href="contact.php"><strong>고객센터</strong></a>';
        ?>
      </span>
    </div>
    <div class="popup" id="authPopup">
        <h2>Manage Code</h2>
        <input type="text" id="authCode" class="auth-code-input" maxlength="4">
        <br><br>
        <button onclick="checkAuthCode()">확인</button>
    </div>

    <script>
        function checkAuthCode() {
            var authCode = document.getElementById('authCode').value;

            if (authCode === '1234') {
                // 인증번호가 일치하는 경우 view_members.php로 이동
                alert('관리자님 계정입니다.');
                window.location.href = 'view_members.php';
            } else {
                // 인증번호가 일치하지 않는 경우 경고 메시지 표시
                alert('인증번호가 올바르지 않습니다. 다시 시도해 주세요.');
            }
        }

        // Enter 키 이벤트 핸들링
        document.getElementById('authCode').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                // Enter 키를 누른 경우 확인 함수를 직접 호출
                checkAuthCode();
            }
        });
    </script>
</body>
</html>