<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');

    $conn = mysqli_connect("localhost", "root", "", "gande_member");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $selectedTimeInfo = isset($_GET['selectedTime']) ? $_GET['selectedTime'] : '';
        $currentDate = isset($_GET['currentDate']) ? $_GET['currentDate'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>예약 정보</title>
    <script src="http://kit.fontawesome.com/e1a4d00b81.js" crossorigin="anonymous"></script>
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
    <link rel="stylesheet" href="details.css" type="text/css" />
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
                        echo '<a href="contact.php"><strong>고객센터</strong></a>';
                    } else {
                        // 로그아웃 상태
                        // 로그인 버튼 표시
                        echo '<a href="login.php"><strong>로그인</strong></a>';
                    }
                ?>
            </span>
        </div>
        <div class="find">
            <h1>예약 정보</h1>
            <br>
            <fieldset>
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
                        <td>
                            <div class="cafe-container">
                                <select id="cafe">
                                    <option value>Starbucks</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </body>
</html>

<?php 
    } else { // 로그인 되어 있지 않은 경우
        echo "<script>alert('로그인 후 이용해주세요.'); location.href='login.php';</script>";
        exit;
    }
?>