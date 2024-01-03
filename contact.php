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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact page</title>
    <link rel="stylesheet" href="contact.css" />
    <script
    src="http://kit.fontawesome.com/e1a4d00b81.js" crssorigin="anonymous">
    </script>
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
				// 로그아웃 상태
    			// 로그인 버튼 표시
    			echo '<a href="login.php"><strong>로그인</strong></a>';
				}
			?>
        </span>
    </div>
    <div class="answer"> 
        <form action="send_email.php" method="post">
            <div class="row">
                <div class="input-group">
                    <input type="text" id="name" required />
                    <label for="name"><i class="fas fa-user"></i>Your Name</label>
                </div>
                <div class="input-group">
                    <input type="text" id="number" required />
                    <label for="number"><i class="fas fa-phone-square-alt"></i>Your PhoneNumber</label>
                </div>
            </div>
            <div class="input-group">
                <input type="text" id="email" required /> 
                <label for="email"><i class="fas fa-envelope"></i>Email Id</label>
            </div>
            <div class="input-group">
                <textarea id="message" rows="8" required></textarea>
                <label for="message">Your Messages</label>
            </div>
            <button type="submit">SUBMIT<i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</body>
</html>