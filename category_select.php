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
<html lang="en" dir="1tr"> 
    <head>
        <meta charset="utf-8">
        <title>카테고리 선택하기</title>
        <link rel="stylesheet" href="cube.css">
        <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
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
                <a href="contact.php">
                    <strong>고객센터</strong>
                </a>
            </span>
        </div>
        <div class="container">
            <input type="button" value="CATEGORY">
            <div class="box">
                <div class="card" id="front"><a href ="" style="text-decoration: none;">COFFEE</a></div>
                <div class="card" id="back"><a href ="#" style="text-decoration: none;">BAKERY</a></div>
                <div class="card" id="left"><a href ="#" style="text-decoration: none;">DESSERT</a></div>
                <div class="card" id="right"><a href ="#" style="text-decoration: none;">DRINKS</a></div>
                <div class="card" id="top"><a href ="#" style="text-decoration: none;">ICECREAM</a></div>
                <div class="card" id="bottom"><a href ="#" style="text-decoration: none;">ETC</a></div>
            </div>
        </div>
        <div>
            <div class="flow-container">
                <div class="flow-text">
                    <div class="flow-wrap">메뉴를 클릭하시면 해당 페이지로 이동합니다.</div>
                    <div class="flow-wrap">메뉴를 클릭하시면 해당 페이지로 이동합니다.</div>
                    <div class="flow-wrap">메뉴를 클릭하시면 해당 페이지로 이동합니다.</div>
                </div>
            </div>
        </div>
    </body>
</html>