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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>GANDE 위치</title>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=c3xl3fv80u"></script>
    <link rel = stylesheet href = 'location.css' type = 'text/css' />
</head>
<body>
<header>
        <div class="header-container">
            <h1><img src="innoturn_logo.png" alt=""></h1>
            <ul class="nav-menu">
				<?php
					if (isset($_SESSION['username']) || isset($_COOKIE['username'])) {
    				// 로그인 상태
    				if (isset($_SESSION['username'])) {
        				$username = $_SESSION['username'];
						$sql = "SELECT name FROM gande_member WHERE username = '{$username}'";
            			$result = mysqli_query($conn, $sql);
            			$row = mysqli_fetch_array($result);
            			$name = $row['name'];
						echo "<li><a href='mypage.php'>{$name}님 환영합니다!</a></li>";
    				} else {
        				$username = $_COOKIE['username'];
						$sql = "SELECT name FROM gande_member WHERE username = '{$username}'";
            			$result = mysqli_query($conn, $sql);
            			$row = mysqli_fetch_array($result);
            			$name = $row['name'];
            			echo "<li><a href='mypage.php'>{$name}님 환영합니다!</a></li>";
    				}
    				// 로그아웃 버튼 표시
    				echo '<li><a href="logout.php">로그아웃</a></li>';

					// echo '<li><a href="mypage.php">마이페이지</a></li>';
					} else {
    				// 로그아웃 상태
    				// 로그인 버튼 표시
    				echo '<li><a href="login.php">로그인</a></li>';
					}
				?>
                <li><a href="gande_member.php">회원가입</a></li>
				<li><a href="contact.php">고객센터</a><li>
            </ul>
        </div>
    </header>
    <nav>
        <ul>
			<li><a href="main.php">Home</a></li>
			<li><a href="location.php">LOCATION</a></li>
			<li><a href="map.php">POSITION</a></li>
			<li><a href="reservation.php">RESERVATION</a></li>
		</ul>
	</nav>
    <div id="map"></div>

    <script>
        var position = new naver.maps.LatLng(37.467595074554644, 126.8879765964386);

        var mapOptions = {
            center: position,
            zoom: 17.5,
            scaleControl: false,
            logoControl: false,
            mapDataControl: false,
            zoomControl: true,
            minZoom: 5
        };

        var map = new naver.maps.Map('map', mapOptions);

        var markerOptions = {
            position: position,
            map: map
        };

        var marker = new naver.maps.Marker(markerOptions);
    </script>
</body>
</html>