<?php
    session_start();
    header('Content-Type: text/html; charset = utf-8');

    $selectedSeatNumbers = "좌석이 선택되지 않았습니다."; // 변수 초기화

    $conn = mysqli_connect("localhost", "root", "", "gande_member");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_GET['selectedTime']) && isset($_GET['currentDate'])) {
        $selectedTimeInfo = $_GET['selectedTime'];
        $currentDate = $_GET['currentDate'];

        // 세션에 선택한 시간대와 오늘의 날짜 저장
        $_SESSION['selectedTime'] = $selectedTimeInfo;
        $_SESSION['currentDate'] = $currentDate;
    } else {
        $selectedTimeInfo = '';
        $currentDate = '';
    }

    if (isset($_SESSION['username'])) {
        $is_login = false;
        if ($is_login) {
            $is_login = true;
            setcookie('username', $username, time() + 3600, '/');
            session_start();
            $_SESSION['username'] = $username;
        }

        $selectedTimeInfo = isset($_GET['selectedTime']) ? $_GET['selectedTime'] : '';
        $currentDate = isset($_GET['currentDate']) ? $_GET['currentDate'] : '';
?>

<!DOCTYPE html>
<html lang = "en">
<meta charset = "utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>예약 정보</title>
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

        input[type="submit"] {
            height: 35px;
            width: 180px;
            background-color: #3a3a3a;
            color: white;
            border: 2px solid #999;
            border: none;
            display: inline-block;
        }
    </style>
    <link rel = stylesheet href = 'details.css' type = 'text/css' />
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
            <form method = "post" action = "main.php">
                <?php
                    $sql = "SELECT * FROM gande_member WHERE username = '{$_SESSION['username']}'";
                    $result = mysqli_query($conn, $sql);
                    $gande_member = mysqli_fetch_array($result);
                    if (!$gande_member) { // 회원 정보가 없는 경우
                        echo "<script>alert('회원 정보를 찾을 수 없습니다.'); history.back();</script>";
                        exit;
                    }

                    $selectedTimeInfo = $_GET['selectedTime'];
                    $currentDate = $_GET['currentDate'];
                ?>
                <h1>예약 정보</h1>
                <br><fieldset>
                    <legend>예약 내용</legend>
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
                            <td>선택한 시간대</td>
                            <td><?php echo $selectedTimeInfo; ?></td>
                        </tr>
                        <tr>
                            <td>오늘의 날짜</td>
                            <td><?php echo $currentDate; ?></td>
                        </tr>
                        <tr>
                            <td>카페 이름</td>
                            <td><div class="cafe-container">
                                <select id="cafe">
                                    <option value>Grazie</option>
                                </select></td>
                            </div></td>
                        </tr>
                    </table>
                </fieldset>
                <br><br>
                <div class = "text-center">
                    <input type="reset" value="시간 다시 선택하기" onclick="location.href='realtime.php';"/>
                    <!-- 예약하기 버튼 -->
                    <input type="submit" value="예약하기" onclick="showConfirmation('<?php echo $selectedTimeInfo; ?>', '<?php echo $currentDate; ?>')"/>

                    <script>
                        function showConfirmation(selectedTime, currentDate) {
                            var confirmed = confirm("현재 선택한 시간대는 " + selectedTime + " 이며, 날짜는 " + currentDate + " 입니다. 예약 하시겠습니까?");
                            if (confirmed) {
                                location.href = `main.php?userselectedTime=${selectedTime}&currentDate=${currentDate}`;
                            }
                        }
                    </script>
                </div>
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