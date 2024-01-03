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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="seat.css" />
    <title>Cafe Seat Booking</title>
    <script src="seat.js"></script>
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
    <div class="movie-container">
      <label for="movie">Select Cafe: </label>
      <select id="movie">
        <option value="Starbucks">Starbucks</option>
        <option value="Twosome Place">Twosome Place</option>
        <option value="Coffee Bean">Coffee Bean</option>
        <option value="EDIYA Coffee">EDIYA Coffee</option>
        <option value="Mega Coffee">Mega Coffee</option>
        <option value="Compose Coffee">Compose Coffee</option>
        <option value="Grazie">Grazie</option>
      </select>
        <!-- 예약 페이지로 이동하는 버튼 추가 -->
        <button id="move-button">Move</button>
    </div>
    <script>
        // 예약 페이지로 이동하는 함수
        function redirectToReservationPage() {
            const movieSelect = document.getElementById('movie');
            const selectedCafe = movieSelect.value;
            let reservationPageUrl = '';

            switch (selectedCafe) {
                case 'Starbucks':
                    reservationPageUrl = 'Starbucks_reservation.php';
                    break;
                case 'Twosome Place':
                    reservationPageUrl = 'Twosome_reservation.php';
                    break;
                case 'Coffee Bean':
                    reservationPageUrl = 'CoffeeBean_reservation.php';
                    break;
                case 'EDIYA Coffee':
                    reservationPageUrl = 'EDIYA_reservation.php';
                    break;
                case 'Mega Coffee':
                    reservationPageUrl = 'Mega_reservation.php';
                    break;
                case 'Compose Coffee':
                    reservationPageUrl = 'Compose_reservation.php';
                    break;
                case 'Grazie':
                    reservationPageUrl = 'Grazie_reservation.php';
                    break;
                default:
                    // 선택한 카페가 없거나 유효하지 않은 경우
                    return;
            }

            // 예약 페이지로 이동
            window.location.href = reservationPageUrl;
        }

        // 예약 페이지로 이동하는 버튼 추가
        const moveButton = document.getElementById('move-button');
        moveButton.addEventListener('click', redirectToReservationPage);
    </script>
  </body>
</html>