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

    $selectedSeats = array();

    // URL 매개변수에서 선택된 좌석 정보 가져오기
    if (isset($_GET['selectedSeats'])) {
        $selectedSeatsString = $_GET['selectedSeats'];
        $selectedSeats = explode(',', $selectedSeatsString);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="realtime.css">
    <title>실시간 예약 페이지</title>
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
    <div class="reservation-info">
        <strong><?php echo "{$name}님 현재 예약 가능 시간은"; ?></strong>
        <span id="countdown-timer">3:00</span>
    </div>

    <!-- 선택된 좌석 정보 출력 -->
    <div class='selected-seats'>
        <h3>선택된 좌석:</h3>
        <ul>
            <?php
                if (!empty($selectedSeats)) {
                    foreach ($selectedSeats as $seat) {
                        echo "<li>{$seat}</li>";
                    }
                } else {
                    echo "<li>선택된 좌석이 없습니다.</li>";
                }
            ?>
        </ul>
    </div>

    <div class="calendar">
        <div class="calendar-header">
            <span id="current-month-year"></span>
        </div>
        <div class="calendar-weekdays">
            <div class="calendar-day">일</div>
            <div class="calendar-day">월</div>
            <div class="calendar-day">화</div>
            <div class="calendar-day">수</div>
            <div class="calendar-day">목</div>
            <div class="calendar-day">금</div>
            <div class="calendar-day">토</div>
        </div>
        <div class="calendar-grid" id="calendar-grid"></div>
    </div>

    <!-- 시간표를 표시할 영역 추가 -->
    <div id="timeTableContainer">
        <h2 id="selected-date">날짜를 선택하세요.</h2>
        <table id="timeTable">
            <caption></caption>
            <thead>
                <tr>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- 이 부분에 시간대를 추가할 수 있습니다. -->
            </tbody>
        </table>
    </div>

    <script src="realtime.js"></script>
</body>
</html>