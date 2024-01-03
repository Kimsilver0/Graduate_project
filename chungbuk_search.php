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
    <title>원하는 카페를 검색하세요!</title>
    <link rel="stylesheet" type="text/css" href="cafelist.css">
    <script src="http://kit.fontawesome.com/e1a4d00b81.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- top bar -->
    <div class="top">
        <a href="main.php" style="float: left; text-decoration: none;">
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
                echo '<a href="login.php" style="text-decoration: none;"><strong>로그인</strong></a>';
            }
            ?>
            <a href="contact.php" style="text-decoration: none;">
                <strong>고객센터</strong>
            </a>
        </span>
    </div><!--/top bar -->
    <h1>SEARCH YOUR CAFE !</h1>

    <form method="post" action="">
        <input type="text" id="search" name="search"><br>
        <input type="submit" value="검색">
        <br>
    </form>

    <ul>
        <?php
        $message = ""; // 초기 메시지 변수를 설정합니다.
        $found = false; // 검색 결과 여부를 저장하는 변수를 초기화합니다.

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $search = $_POST["search"];
            $files = array(
                "R_Chungbuk.csv",
            );

            foreach ($files as $file) {
                if (!empty($search)) { // $search가 비어 있지 않은 경우에만 데이터 출력
                    if (($handle = fopen($file, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            if (count($data) > 3) {
                                $cafe_name = $data[0];
                                $address = $data[1];
                                $latitude = $data[2];
                                $longitude = $data[3];

                                if (stripos($cafe_name, $search) !== false) {
                                    // 각 데이터를 리스트 항목으로 출력
                                    echo "<li class='cafe-item' data-cafe-name='$cafe_name' data-address='$address' data-latitude='$latitude' data-longitude='$longitude'>";
                                    echo "<h3>$cafe_name</h3>";
                                    echo "<p>도로명주소: $address</p>";
                                    echo "<p>위도: $latitude</p>";
                                    echo "<p>경도: $longitude</p>";
                                    echo "</li>";

                                    $found = true; // 검색 결과를 찾았음을 표시합니다.
                                }
                            } else {
                                $message = "찾으시는 카페가 없습니다."; // 데이터 형식 오류 메시지
                            }
                        }
                        fclose($handle);
                    } else {
                        $message = "파일을 열 수 없습니다."; // 파일 열기 오류 메시지
                    }
                } else {
                    $message = "검색어를 입력하세요."; // 검색어 입력 안한 경우 메시지
                }
            }
        }

        if (!$found) {
            if (!empty($message)) {
                echo "<li>$message</li>";
            }
        }
        ?>
    </ul>

    <script>
        // 카드 클릭 이벤트를 막음
        document.querySelectorAll('li').forEach(function(card) {
            card.addEventListener('click', function(event) {
                event.preventDefault(); // 기본 동작을 막음
            });
        });
    </script>
</body>
</html>