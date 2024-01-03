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
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>GANDE's MENU</title>
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
					<span class="demo-note">여러분의 취향 카페를 메뉴판에서 확인하려면 아래 메뉴판을 참조해주세요!</span>
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

									<div class="rm-logo"></div>
									<h2>GANDE</h2>
									<h3>CAFE &amp; DESSERT</h3>

									<a href="#" class="rm-button-open">View the Menu</a>
                                    <script>
                                      const menuButton = document.getElementById("menu-button");
                                      menuButton.addEventListener("click", () => {
                                        document.body.classList.toggle("rm-open");
                                      });
                                    </script>
									<div class="rm-info">
										<p>
										<strong>GANDE</strong><br>
										SOONCHUNHYANG UNIVERSITY<br>
										DEPARTMENT OF COMPUTER SOFTWARE ENGINEERING<br>
										<strong>Phone</strong> 01012345678<br>
										<strong>EMAIL</strong> gracekim0513@naver.com</p>
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
    								$sql = "SELECT name FROM gande_member WHERE username = '{$username}'";
    								$result = mysqli_query($conn, $sql);

    								// SQL 쿼리가 정상적으로 실행되었는지 확인합니다.
    								if (!$result) {
        								die(mysqli_error($conn));
    								}

    								// 사용자 이름을 출력합니다.
    								$row = mysqli_fetch_array($result);
    								if ($row) {
        								$name = $row['name'];
        								echo "<h4>{$name}님의 선호 카페</h4>";
    								} else {
        								echo "<p>로그인 후 선호하는 카페를 등록해주세요.</p>";
    								}
								} else {
    								// 설정되지 않은 경우, 로그인 후 선호하는 카페를 등록하라는 메시지를 출력합니다.
    								echo "<p>로그인 후 선호하는 카페를 등록해주세요.</p>";
								}
								?>
									<dl>
										<dt>Bella's Artichokes</dt>
										<dd>Roasted artichokes with chipotle aioli and cream cheese</dd>

										<dt>Bruschetta Blue Delight</dt>
										<dd>Blue cheese and citrus bruschetta</dd>

										<dt>Pomme Dulse</dt>
										<dd>Baked potatoes with crisped dulse</dd>

										<dt><a href="http://herbivoracious.com/2011/11/crostini-with-young-pecorino-grilled-figs-and-arugula-mint-pesto-recipe.html" class="rm-viewdetails" data-thumb="images/1.jpg">Green Love Crostini</a></dt>
										<dd>Crostini with young pecorino, grilled figs and arugula &amp; mint pesto</dd>
										
										<dt>Focaccia di Carciofi</dt>
										<dd>Artichoke focaccia with fresh thyme</dd>
									</dl>

									<h4>카페 예약 하러 가기</h4>
									<dl>
										<dt>Green Delight</dt>
										<dd>Watercress, frisee and avocado salad</dd>

										<dt><a href="http://herbivoracious.com/2010/02/thai-tofu-salad-recipe.html" class="rm-viewdetails" data-thumb="images/13.jpg">Gourmet Yam Taohu</a></dt>
										<dd>Thai tofu salad yam taohu</dd>

										<dt>Panini Deluxe</dt>
										<dd>Buffalo mozzarella basil panini</dd>
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
										<dt><a href="http://herbivoracious.com/2009/03/panfried-gnocchi-with-arugula-recipe.html" class="rm-viewdetails" data-thumb="images/11.jpg">Crispy Gnocchi with Arugula</a></dt>
										<dd>Pan-fried potato gnocchi with arugula salad</dd>

										<dt>Sea Palm Spicy Peanut Curry</dt>
										<dd>Tender sea palm noodles, seasoned vegetables, spicy peanut curry and tempeh fenel croquettes</dd>

										<dt><a href="http://herbivoracious.com/2012/09/caviar-lentil-salad-with-arugula-crispy-shallots-and-roasted-garlic-recipe.html" class="rm-viewdetails" data-thumb="images/8.jpg">Lentil Caviar &amp; Arugula</a></dt>
										<dd>Black lentil curry with arugula salad, caramelized shallots and roasted garlic</dd>

										<dt>Tamari-Maple Glazed Tofu</dt>
										<dd>Wasabi emulsion, sesame seeds and scallions</dd>

										<dt>Maple Barbeque Tofu</dt>
										<dd>Grilled marinated tofu, maple barbeque sauce, tahini slaw, grilled seasonal vegetables and mashed potatoes</dd>
																													
										<dt><a href="http://herbivoracious.com/2012/07/king-oyster-mushroom-with-roasted-cherries-and-sage-no-that-isnt-meat-recipe-and-thought-process.html" class="rm-viewdetails" data-thumb="images/4.jpg">Luxur Oyster</a></dt>
										<dd>King oyster mushroom with roasted cherries and sage</dd>
										
										<dt><a href="http://herbivoracious.com/2012/09/rigatoni-with-roasted-cauliflower-and-spicy-tomato-sauce-recipe.html" class="rm-viewdetails" data-thumb="images/3.jpg">Rigatoni di Cavolfiore</a></dt>
										<dd>Rigatoni with roasted cauliflower and spicy tomato sauce</dd>
										
										<dt><a href="http://herbivoracious.com/2012/06/saffron-chickpea-stew-with-grilled-porcini-mushroom-recipe.html" class="rm-viewdetails" data-thumb="images/14.jpg">Saffron Chana Secret</a></dt>
										<dd>Saffron chickpea stew with grilled porcini mushrooms</dd>
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
									<h4>오늘의 카페 추천</h4>
                                    <!--알고리즘 추천 -->
									<dl>
										<dt><a href="http://herbivoracious.com/2012/08/crepes-with-roasted-french-plums-yogurt-and-honey.html" class="rm-viewdetails" data-thumb="images/5.jpg">French Plum Crepes</a></dt>
										<dd>Crepes with roasted french plums, yogurt &amp; honey</dd>
										
										<dt><a href="http://herbivoracious.com/2012/05/butterscotch-pudding-with-bittersweet-ganache-and-caramelize-white-chocolate-crunchies-recipe.html" class="rm-viewdetails" data-thumb="images/6.jpg">Butterscotch Pudding</a></dt>
										<dd>Butterscotch pudding with bittersweet ganache and caramelize white chocolate crispies</dd>
										
										<dt><a href="http://herbivoracious.com/2009/12/gateaux-de-crepes-recipe.html" class="rm-viewdetails" data-thumb="images/12.jpg">Chocolate Gâteau de Crêpes</a></dt>
										<dd>Gâteau de crêpes with chocolate pastry cream and dulce de leche</dd>
										
										<dt><a href="http://herbivoracious.com/2009/05/dutch-baby-with-sauteed-apples-giant-ovenbaked-pancakes-recipe.html" class="rm-viewdetails" data-thumb="images/10.jpg">Dutch Baby With Sauteed Apples</a></dt>
										<dd>Dutch ginat oven-baked pancakes with sauteed apples</dd>
										
										<dt><a href="http://herbivoracious.com/2008/08/blueberry-napol.html" class="rm-viewdetails" data-thumb="images/7.jpg">Blueberry Napoleon</a></dt>
										<dd>Blueberry Napoleon with crème fraîche and raspberry powder</dd>
										
										<dt><a href="http://herbivoracious.com/2008/09/rings-of-saturn.html" class="rm-viewdetails" data-thumb="images/2.jpg">Rings of Saturn</a></dt>
										<dd>Saturn peach on challah french toast</dd>
										
										<dt><a href="http://herbivoracious.com/2008/04/recipe-atayef.html" class="rm-viewdetails" data-thumb="images/9.jpg">Classic Atayef</a></dt>
										<dd>Syrian ricotta-filled dessert pancakes</dd>
									</dl>
									<div class="rm-order">
										<p><strong>카페 사장님이시라면?</strong><br>카페 등록 하기를 통해 사장님의 카페를 알려주세요!<br>
										<?php
										if (isset($_SESSION['roles']) && $_SESSION['roles'] === 'owner') {
											echo '<a href = ""><button type = "button">카페 등록하기</button></a>';
										} else {
											echo '카페 사장님만 작성할 수 있습니다!';
										}
										?>
										</p>
									</div>
								</div><!-- /rm-content -->
							</div><!-- /rm-back -->

						</div><!-- /rm-right -->
					</div><!-- /rm-wrapper -->

				</div><!-- /rm-container -->

			</section>
			
        </div>
		<!-- jQuery if needed -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="menu.js"></script>
		<script type="text/javascript">
			$(function() {

				Menu.init();
			
			});
		</script>
    </body>
</html>