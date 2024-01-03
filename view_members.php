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
    <title>Member List</title>
    <script src="http://kit.fontawesome.com/e1a4d00b81.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
            background-color: #8fbc8f;
        }
        h1 {
            background-color: #4E9258;
            color: #fff;
            padding: 10px;
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
            border-radius: 5px;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid #ddd;
            font-weight: bold;
            border-radius: 5px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            background-color: #f2f2f2;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .delete-button {
            background-color: lightgray;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: red;
        }
        .top {
            line-height: 24px;
            font-size: 11px;
            background: #fff;
            background: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            z-index: 9999;
            position: relative;
            font-family: Cambria, Georgia, serif;
            box-shadow: 1px 0px 2px rgba(0,0,0,0.2);
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
        }

        /* Clearfix hack by Nicolas Gallagher: http://nicolasgallagher.com/micro-clearfix-hack/ */

        .top:before,
        .top:after {
            content: " "; /* 1 */
            display: table; /* 2 */
        }

        .top:after {
            clear: both
        }

        .top a {
            padding: 0px 10px;
            letter-spacing: 1px;
            color: #333;
            display: inline-block;
        }

        .top a:hover {
            background: rgba(255,255,255,0.6)
        }

        .top span.right {
            float: right
        }

        .top span.right a {
            float: left;
            display: block;
        }
    </style>
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
<h1 style="display: flex; justify-content: space-between;">
    <span style="order: 1; align-items:center; text-align: center;">User List</span>
    <a href="view_contact.php" style="text-decoration: none; order: 2;">
    <button id="contactButton" style="background-color: #4E9258; color:black; font-size: 20px; border-radius: 10px; border:1px solid white;border-radius= 5px; padding: 8px 20px;"><strong>Contact list</strong></button>
    </a>
</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>

        <?php
        // MySQL 데이터베이스에 연결
        $servername = "localhost";
        $hostname = "root";
        $password = "";
        $dbname = "gande_member";

        $conn = mysqli_connect($servername, $hostname, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // POST 요청을 처리하여 삭제 버튼을 클릭한 경우 해당 회원 정보 삭제
        if (isset($_POST['delete_member'])) {
            $username = $_POST['name'];

            // 회원 정보 삭제 쿼리
            $delete_sql = "DELETE FROM members WHERE id = $username";
            if (mysqli_query($conn, $delete_sql)) {
            } else {
                echo "회원 정보를 삭제하는 중 오류가 발생했습니다.";
            }
        }

        // MySQL에서 데이터 선택
        $sql = "SELECT * FROM members";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['roles'] . "</td>";

                // 삭제 버튼 추가
                echo "<td>";
                echo "<form method='post' action='view_members.php'>";
                echo "<input type='hidden' name='member_id' value='" . $row['id'] . "'>";
                echo "<input type='submit' name='delete_member' value='삭제' class='delete-button'>";
                echo "</form>";
                echo "</td>";

                echo "</tr>";
            }
        } else {
            echo "저장된 회원 정보가 없습니다.";
        }

        mysqli_close($conn);
        ?>
    </table>
    <script>
        // 삭제 버튼 클릭 시 경고창 표시
        var deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                var confirmDelete = confirm('정말로 이 회원을 삭제하시겠습니까?');
                if (!confirmDelete) {
                    event.preventDefault(); // 삭제를 취소
                }
            });
        });
            
        // 버튼 요소 가져오기
        var contactButton = document.getElementById("contactButton");

        // 버튼 클릭 이벤트 핸들러 추가
        contactButton.addEventListener("click", function() {
            contactButton.style.backgroundColor = "red";

            // 500밀리초(0.5초) 후에 배경색을 원래대로 복원
            setTimeout(function() {
                contactButton.style.backgroundColor = "";
            }, 500); // 0.5초
        });
    </script>
</body>
</html>