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
    <meta charset="utf-8">
    <title>Gande korea cafe list</title>
    <link rel = stylesheet href = 'map.css' type = 'text/css' />
    <script src="http://kit.fontawesome.com/e1a4d00b81.js" crossorigin="anonymous"></script>
    <style>
        #map {
            height: 95vh; /* 화면 높이의 80%로 설정, 필요에 따라 조절 가능 */
            width: 100%;
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
            
			} else {
    			// 로그아웃 상태
    			// 로그인 버튼 표시
    			echo '<li><a href="login.php">로그인</a></li>';
			}
		?>

        <a href="contact.php" style="text-decoration: none;">
            <strong>고객센터</strong>
        </a>
    </span>
</div><!--/top bar -->
    <!-- 지도를 표시할 div 입니다 -->
    <div id="map"></div>

   <script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=2f5a41f263030fafcd0f9e3e1ed71321&libraries=clusterer"></script>
    <script type="text/javascript" src="markers.js"></script>
    <script>
        const mapContainer = document.getElementById('map'); // 지도를 표시할 div 
        const mapOption = { 
            center: new kakao.maps.LatLng(36.7696923, 126.931490), // 지도의 중심좌표
            level: 12 // 지도의 확대 레벨
        };

        // 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
        const map = new kakao.maps.Map(mapContainer, mapOption); 

        const imageSrc = 'marker.png'; // Make sure this path is correct
        const imageSize = new kakao.maps.Size(30, 35); // Adjust the size as needed

        
        // 마커 클러스터러를 생성합니다 - 지도를 축소했을때 마커의 분포를 숫자로 표시 
        const clusterer = new kakao.maps.MarkerClusterer({
            map: map, // 마커들을 클러스터로 관리하고 표시할 지도 객체 
            averageCenter: true, // 클러스터에 포함된 마커들의 평균 위치를 클러스터 마커 위치로 설정 
            minLevel: 10 // 클러스터 할 최소 지도 레벨 
        });

        const markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize); 

        for (const place of places) {
            const LatLng = new kakao.maps.LatLng(place.lat,place.long)
            const marker =  new kakao.maps.Marker({
                title : place.title,
                position : LatLng,
                image : markerImage 
            }); // markers.js에 표시된 배열 양식대로 장소이름,위경도 불러오기 
            

            // 클러스터러에 마커들을 추가합니다
            clusterer.addMarker(marker);
        } //kakao not define 오류 해결 / 배열 다시 정의 

    
    </script>
</body>
</html>