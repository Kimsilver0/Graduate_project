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

    $cafe_name = "";
    $address = "";
    $latitude = "";
    $longitude = "";
    $member_name = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 폼에서 제출된 데이터 가져오기
        $cafe_name = $_POST["cafe_name"];
        $address = $_POST["address"];
        $latitude = $_POST["latitude"];
        $longitude = $_POST["longitude"];
        $member_name = $_POST["member_name"];
    
        // SQL 쿼리 작성하여 데이터베이스에 카페 정보 삽입
        $sql = "INSERT INTO cafes (cafe_name, address, latitude, longitude, member_name) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
    
        // 바인딩 및 실행
        mysqli_stmt_bind_param($stmt, "ssdss", $cafe_name, $address, $latitude, $longitude, $member_name);
        $result = mysqli_stmt_execute($stmt);
    
        if ($result) {
            echo '<script>alert("카페가 추가 되었습니다.");</script>';
        } else {
            echo '<script>alert("카페 등록 중 오류가 발생했습니다.");</script>';
        }

        // 새로운 카페 정보를 세션에 추가
        if (!isset($_SESSION['cafes'])) {
            $_SESSION['cafes'] = array();
        }

        // 카페 정보를 추가
        $_SESSION['cafes'][] = array("name" => $cafe_name, "address" => $address);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Menu recommendation</title>
        <meta name="description" content="여러분의 취향을 담아 드립니다. " />
        <meta name="keywords" content="css3, perspective, 3d, jquery, transform3d, responsive, template, restaurant, menu, leaflet, folded, flyer, concept" />
        <meta name="author" content="Codrops" />
        <!--<link rel="shortcut icon" href="../favicon.ico">--> 
        <link rel="stylesheet" type="text/css" href="menu.css" />
		<link href='http://fonts.googleapis.com/css?family=Raleway:300,500|Arvo:700' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="custom.js"></script>
		<!--[if lte IE 8]><style>.support-note .note-ie{display:block;}</style><![endif]-->
    </head>
    <body>
        <div class="container">
		
			<!-- top bar -->
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
    				echo '<a href="logout.php"><strong>로그아웃</strong></a>';

					// echo '<li><a href="mypage.php">마이페이지</a></li>';
					} else {
    				// 로그아웃 상태
    				// 로그인 버튼 표시
    				echo '<a href="login.php"><strong>로그인</strong></a>';
					}
				?>
                    <a href="contact.php">
                        <strong>고객센터</strong>
                    </a>
                </span>
            </div><!--/top bar -->
			
			<header>
				<h1>Welcome to GANDE's MENU</h1>
				<h2>
                    여러분의 취향을 담아 드립니다. <a href="main.php">GANDE</a>
				</h2>
				
				<!--<div class="support-note">--><!-- let's check browser support with modernizr -->
				    <!--<span class="no-cssanimations">CSS animations are not supported in your browser</span>
					<span class="no-csstransforms">CSS transforms are not supported in your browser</span>
					<span class="no-csstransforms3d">CSS 3D transforms are not supported in your browser</span>
					<span class="no-csstransitions">CSS transitions are not supported in your browser</span>
					<span class="note-ie">Sorry, only modern browsers.</span>
				</div>-->
				
			</header>
			
			<section class="main">

				<div id="rm-container" class="rm-container">

					<div class="rm-wrapper">

						<div class="rm-cover">

							<div class="rm-front">
								<div class="rm-content">
									<br>
									<br>
									<h2>GANDE</h2>
									<h3>CAFE &amp; DESSERT</h3>

									<a href="#" class="rm-button-open">View Details</a>
                                    <script>
                                      const menuButton = document.getElementById("menu-button");
                                      menuButton.addEventListener("click", () => {
                                        document.body.classList.toggle("rm-open");
                                      });
                                    </script>
									<div class="rm-info">
										<p>
										<br>
										<strong>Copyright 2023. Gande ALL RIGHTS RESERVED.</strong><br>
										<strong>EMAIL</strong> gracekim0513@naver.com<br>
										<strong>EMAIL</strong> wldbs1110@naver.com</p>
									</div>

								</div><!-- /rm-content -->
							</div><!-- /rm-front -->

							<div class="rm-back">
								<div class="rm-content">
								<?php
								// 'username' 키가 설정되어 있는지 확인
								if (isset($_SESSION['username'])) {
    								// 설정된 경우, 사용자 이름을 가져옵니다.
    								$username = $_SESSION['username'];
    								$sql = "SELECT name, roles FROM gande_member WHERE username = '{$username}'";
    								$result = mysqli_query($conn, $sql);

    								// SQL 쿼리가 정상적으로 실행되었는지 확인합니다.
    								if (!$result) {
        								die(mysqli_error($conn));
    								}

    								// 사용자 이름을 출력합니다.
    								$row = mysqli_fetch_array($result);
    								if ($row) {
        								$name = $row['name'];
        								if (isset($_SESSION['roles']) && $_SESSION['roles'] === 'owner') {
                                            echo "<h4>{$name} 사장님의 카페 등록</h4>";
                                        } else {
                                            echo "<h4>{$name} 님의 선호 카페</h4>";
                                        }
    								} else {
        								echo "<p>로그인 후 선호하는 카페를 등록해주세요.</p>";
    								}
								} else {
    								// 설정되지 않은 경우, 로그인 후 선호하는 카페를 등록하라는 메시지를 출력합니다.
    								echo "<p>로그인 후 선호하는 카페를 등록해주세요.</p>";
								}
								?>
									<dl>
                                        <div class="rm-order">
										    <?php
										        if (isset($_SESSION['roles']) && $_SESSION['roles'] === 'owner') {
                                                    echo '<p><strong>카페 사장님이시라면?</strong><br>카페 등록 하기를 통해 사장님의 카페를 알려주세요!<br>';
											        echo '<a href = "new_cafe.php"><button type = "button">카페 등록하기</button></a>';
                                                    echo '<dt>만약 카페 사장님이 아닌 경우 카페를 등록하셨다면, 관리자에 의해 카페 등록이 취소 될 수 있습니다.<dt><br>';
										        } else {
											        echo '<dt><a href="cafelist.php">카페 등록하기</a><dt><br>';
										        }
										    ?>
										    </p>
									    </div>
                                        <?php
                                        // cafes 테이블에서 멤버 이름이 gande_member 테이블의 name과 같은 행을 가져온다.
                                        $sql = "SELECT * FROM cafes WHERE member_name = '{$name}'";
                                        $result = mysqli_query($conn, $sql);

                                        $count = 5;
                                        $index = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($index > $count) {
                                                break;
                                            }
                                            $cafe_name = $row['cafe_name'];
                                            $address = $row['address'];
                                            echo "<dt>{$index}. {$cafe_name}</dt>";
                                            echo "<dd>{$address}</dd>";
                                            $index++;
                                        }
                                        ?>
									</dl>

									<h4>카페 예약 하러 가기</h4>
									<dl>
										<dt><a href="reservation.php">예약하러 가기</a></dt><br><br>

										<dt>카페를 선택해서 좌석 예약 후, 날짜와 시간을 선택하세요 !</dt>
										<dd>GANDE를 통해 즐겁고 행복한 하루 되세요</dd>
									</dl>
								</div><!-- /rm-content -->
								<div class="rm-overlay"></div>

							</div><!-- /rm-back -->

						</div><!-- /rm-cover -->

						<div class="rm-middle">
							<div class="rm-inner">
								<div class="rm-content">
									<h4>위치 별 카페 추천</h4>
									<dl>
										<dt><a href="seoul_search.php">서울 카페 추천</a></dt>
										<dd>
											<?php
											// CSV 파일 열기
											$csvFile = fopen('R_Seoul.csv', 'r');

											// CSV 파일 내용을 읽어 배열로 저장
											$data = [];
											while (($row = fgetcsv($csvFile)) !== false) {
    											$data[] = $row;
											}

											// 랜덤으로 한 행 선택
											$randomRow = $data[array_rand($data)];

											// 선택된 행의 데이터 추출
											$cafeName = $randomRow[0];
											$address = $randomRow[1];

											// 선택된 데이터를 recommend.php 페이지에 출력
											echo "<p>오늘의 추천 카페(서울)</p>";
											echo "<p>카페 이름: $cafeName</p>";
											echo "<p>주소: $address</p>";

											// 파일 닫기
											fclose($csvFile);
											?>
										</dd>

										<dt><a href="gyeonggi_search.php">경기도 카페 추천</a></dt>
										<dd>
										<?php
											// CSV 파일 열기
											$csvFile = fopen('R_Gyeonggi.csv', 'r');

											// CSV 파일 내용을 읽어 배열로 저장
											$data = [];
											while (($row = fgetcsv($csvFile)) !== false) {
    											$data[] = $row;
											}

											// 랜덤으로 한 행 선택
											$randomRow = $data[array_rand($data)];

											// 선택된 행의 데이터 추출
											$cafeName = $randomRow[0];
											$address = $randomRow[1];

											// 선택된 데이터를 recommend.php 페이지에 출력
											echo "<p>오늘의 추천 카페(경기)</p>";
											echo "<p>카페 이름: $cafeName</p>";
											echo "<p>주소: $address</p>";

											// 파일 닫기
											fclose($csvFile);
											?>
										</dd>

										<dt><a href="chungbuk_search.php">충청북도 카페 추천</a></dt>
										<dd>
										<?php
											// CSV 파일 열기
											$csvFile = fopen('R_Chungbuk.csv', 'r');

											// CSV 파일 내용을 읽어 배열로 저장
											$data = [];
											while (($row = fgetcsv($csvFile)) !== false) {
    											$data[] = $row;
											}

											// 랜덤으로 한 행 선택
											$randomRow = $data[array_rand($data)];

											// 선택된 행의 데이터 추출
											$cafeName = $randomRow[0];
											$address = $randomRow[1];

											// 선택된 데이터를 recommend.php 페이지에 출력
											echo "<p>오늘의 추천 카페(충북)</p>";
											echo "<p>카페 이름: $cafeName</p>";
											echo "<p>주소: $address</p>";

											// 파일 닫기
											fclose($csvFile);
											?>
										</dd>

										<dt><a href="chungnam_search.php">충청남도 카페 추천</a></dt>
										<dd>
										<?php
											// CSV 파일 열기
											$csvFile = fopen('R_Chungnam.csv', 'r');

											// CSV 파일 내용을 읽어 배열로 저장
											$data = [];
											while (($row = fgetcsv($csvFile)) !== false) {
    											$data[] = $row;
											}

											// 랜덤으로 한 행 선택
											$randomRow = $data[array_rand($data)];

											// 선택된 행의 데이터 추출
											$cafeName = $randomRow[0];
											$address = $randomRow[1];

											// 선택된 데이터를 recommend.php 페이지에 출력
											echo "<p>오늘의 추천 카페(충남)</p>";
											echo "<p>카페 이름: $cafeName</p>";
											echo "<p>주소: $address</p>";

											// 파일 닫기
											fclose($csvFile);
											?>
										</dd>
									</dl>
								</div><!-- /rm-content -->
								<div class="rm-overlay"></div>
							</div><!-- /rm-inner -->
						</div><!-- /rm-middle -->

						<div class="rm-right">

							<div class="rm-front">
								
							</div>

							<div class="rm-back">
								<span class="rm-close">Close</span>
								<div class="rm-content">
									<h4>Gande's Hot Place</h4>
                                    <!--알고리즘 추천 -->
									<dl>
										<dt><a href="https://www.starbucks.co.kr/index.do">스타벅스 강남R점</a></dt>
										<dd>시그니처 로스팅, 가벼운 식사, 무료 Wi-Fi로 잘 알려진 미국 시애틀 기반의 커피하우스 체인점입니다!</dd>
										
										<dt><a href="https://www.instagram.com/cafe_annac">카페 안낙</a></dt>
										<dd>아산 신정호에 위치한 카페. 맛있는 커피와 디저트와 함께 아름다운 호수뷰를 구경하세요!</dd>
										
										<dt><a href="https://www.terarosa.com/market/main?viewName=redirect%3A%2Fmarket%2Fmain">테라로사 커피공장 강릉본점</a></dt>
										<dd>아름다운 강릉에서 커피 로스터리로 시작, 한국의 스페셜티 커피의 선구자인 테라로사에 방문하세요!</dd>
										
										<dt><a href="https://www.instagram.com/flower_illda/">카페 일다</a></dt>
										<dd>한창 좋아진게 나타나 보이다라는 뜻의 일다, 전대 후문에 위치한 카페입니다! </dd>
										
										<dt><a href="https://www.instagram.com/cafe_toenmaru/">카페 툇마루</a></dt>
										<dd>흑임자커피와 두부케이크가 유명한 카페 툇마루입니다. 초심을 잃지 않고 한잔한잔 준비합니다!</dd>
										
										<dt><a href="https://www.instagram.com/allthatcoffee/">올댓커피 본점</a></dt>
										<dd>에스프레소 및 커피와 디저트를 판매하는 한국의 에스프레소바 카페입니다.</dd>
									</dl>
								</div><!-- /rm-content -->
							</div><!-- /rm-back -->

						</div><!-- /rm-right -->
					</div><!-- /rm-wrapper -->

				</div><!-- /rm-container -->

			</section>
			
        </div>
		<!-- jQuery if needed -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="recommend.js"></script>
		<script type="text/javascript">
			$(function() {

				Menu.init();
			
			});
		</script>
    </body>
</html>