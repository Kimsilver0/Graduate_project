<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "gande_member");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
    <title>카페 등록</title>
    <link rel="stylesheet" type="text/css" href="new_cafe.css">
    <script src="http://kit.fontawesome.com/e1a4d00b81.js" crossorigin="anonymous"></script>
    
<body>
    <!-- top bar -->
    <div class="top">
        <a href="main.php" style="float: left; text-decoration: none;">
            <strong>&laquo; GANDE HOME</strong>
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

                    // 'roles' 값을 설정합니다.
                    $_SESSION['roles'] = 'owner';
                    $_SESSION['roles'] = 'customer';
                    function redirect($url) {
                        header('Location: menu.php'.$url);
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
                echo '<a href="logout.php" style="text-decoration: none;"><strong>로그아웃</strong></a>';
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
    <h1>Registeration Form</h1>

    <!-- 카페 등록 버튼 -->
    <button id="registerCafeBtn">New</button>

   <!-- 카페 등록 팝업 모달 -->
        <div id="registerCafeModal" class="modal">
            <div class="modal-content">
                <span id="closeModal" style="float: right; cursor: pointer;">&times;</span>
                <h2>사장님의 카페 등록</h2>
                <form id="cafeForm" action="recommend.php" method="post">
                    <input type="text" id="cafe_name" name="cafe_name" required placeholder="카페 이름"><br>
                    <input type="text" id="address" name="address" required placeholder="주소"><br>
                    <input type="text" id="latitude" name="latitude" required placeholder="위도"><br>
                    <input type="text" id="longitude" name="longitude" required placeholder="경도"><br>
                    <input type="text" id="member_name" name="member_name" value="<?php echo $name; ?>"><br>
                    <input type="submit" value="등록" id="registerButton">
                </form>
            </div>
        </div>

    <script>
        // 모달 열기 버튼 클릭 시
        document.getElementById("registerCafeBtn").onclick = function () {
            document.getElementById("registerCafeModal").style.display = "block";
        }

        // 모달 닫기 버튼 클릭 시
        document.getElementById("closeModal").onclick = function () {
            document.getElementById("registerCafeModal").style.display = "none";
        }
        // 모달 외부 클릭 시 모달 닫기
        window.onclick = function (event) {
            if (event.target == document.getElementById("registerCafeModal")) {
                document.getElementById("registerCafeModal").style.display = "none";
            }
        }
    </script>
</body>
</html>
