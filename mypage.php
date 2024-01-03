<?php
    session_start();
    header('Content-Type: text/html; charset = utf-8');
	$conn = mysqli_connect("localhost", "root", "", "gande_member");

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
    if (isset($_SESSION['username'])) {

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
<html lang = "en">
<head>
    <meta charset = "utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내 정보</title>
    <script
    src="http://kit.fontawesome.com/e1a4d00b81.js" crssorigin="anonymous">
    </script>
    <style>
        * {margin: 0 auto;}
        a {
            color: #333;
            text-decoration: none;
        }
        .find {
            text-align: center;
            width: 500px;
            height: 200px;
            margin-top: 280px;
            align-items: center;
        }
    </style>
    <link rel = stylesheet href = 'mypage.css' type = 'text/css' />
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
                    echo '<a href="contact.php"><strong>고객센터</strong></a>';
			    ?>
            </span>
        </div>
        <div class = "find">
            <form method = "post" action = "gande_member_update.php">
                <?php
                    $sql = "SELECT * FROM gande_member WHERE username = '{$_SESSION['username']}'";
                    $result = mysqli_query($conn, $sql);
                    $gande_member = mysqli_fetch_array($result);
                    if (!$gande_member) { // 회원 정보가 없는 경우
                        echo "<script>alert('회원 정보를 찾을 수 없습니다.'); history.back();</script>";
                        exit;
                    }
                ?>
                <h1>내 정보</h1>
                <br><fieldset>
                    <legend>마이페이지</legend>
                    <table>
                        <tr>
                            <td>이름</td>
                            <td><input type = "text" size = "20" name = "name" placeholder = "이름" value = "<?php echo $gande_member['name']; ?>"></td>
                        </tr>
                        <tr>
                            <td>전화번호</td>
                            <td><input type = "text" size = "20" name = "phone" placeholder = "전화번호" value = "<?php echo $gande_member['phone']; ?>"></td>
                        </tr>
                        <tr>
                            <td>아이디</td>
                            <td><input type = "text" size = "20" name = "username" value = "<?php echo $_SESSION['username']; ?>"></td>
                        </tr>
                        <tr>
                            <td>비밀번호</td>
                            <td><input type = "password" size = "20" name = "password" placeholder = "비밀번호"></td>
                        </tr>
                        <tr>
                            <td>이메일</td>
                            <td><input type = "text" size = "20" name = "email" placeholder = "이메일" value = "<?php echo $gande_member['email']; ?>"></td>
                        </tr>
                    </table>
                </fieldset>
                <br><br><input type = "reset" value = "정보변경" />
            </form>
        </div>
    </body>
</html>
<?php 
    } else { // 로그인 되어 있지 않은 경우
        echo "<script>alert('로그인 후 이용해주세요.'); location.href='login.php';</script>";
        exit;
    }
?>