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
    <link rel="stylesheet" href="EDIYA_seat.css" />
    <title>Cafe Seat Booking</title>
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
      <label for="movie">Pick a seat: </label>
      <select id="movie">
        <option value>EDIYA Coffee</option>
      </select>
    </div>

    <ul class="showcase">
      <li>
        <div class="seat"></div>
        <small>N/A</small>
      </li>
      <li>
        <div class="seat selected"></div>
        <small>Selected</small>
      </li>
      <li>
        <div class="seat occupied"></div>
        <small>Occupied</small>
      </li>
      <li>
        <div class="table"></div>
        <small>N/A</small>
      </li>
      <li>
        <div class="table selected"></div>
        <small>Selected</small>
      </li>
      <li>
        <div class="table occupied"></div>
        <small>Occupied</small>
      </li>
    </ul>

    <div class="container">
      <div class="screen"></div>
      <div class="row">
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="set">
            <div class="seat"></div>
            <div class="table"></div>
            <div class="seat"></div>
        </div>
        <div class="set">
            <div class="seat"></div>
            <div class="table"></div>
            <div class="seat"></div>
        </div>
        <div class="set">
            <div class="seat"></div>
            <div class="table"></div>
            <div class="seat"></div>
        </div>
      </div>
      <div class="row">
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
        <div class="col">
            <div class="set">
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
                <div class="seat"></div>
                <div class="table"></div>
                <div class="seat"></div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="set">
            <div class="seat"></div>
            <div class="table"></div>
            <div class="seat"></div>
        </div>
        <div class="set">
            <div class="seat"></div>
            <div class="table"></div>
            <div class="seat"></div>
        </div>
      </div>
      <div class="row">
        <div class="set">
            <div class="seat"></div>
            <div class="table"></div>
            <div class="seat"></div>
        </div>
        <div class="set">
            <div class="seat"></div>
            <div class="table"></div>
            <div class="seat"></div>
        </div>
      </div>
      <div class="row">
        <div class="set">
            <div class="seat"></div>
            <div class="table"></div>
            <div class="seat"></div>
        </div>
      </div>
    </div>

    <p class="text">
      You have selected <span id="count">0</span> seats and <span id="tableCount">0</span> tables
    </p>
    <p class="text">
      Total <span id="totalCount">0</span> Seats and already reserved <span id="reservedSeats">0</span> Seats
    </p>
    <a href="realtime.php" class="rm-button-open">Select Time -></a>
    <script src="seat.js"></script>
  </body>
</html>