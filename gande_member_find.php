<?php
    header('Content-Type: text/html; charset = utf-8');
    if(isset($_SESSION['username'])) {
        echo "<script>alert('잘못된 접근입니다.'); history.back(); </script>";
    } else { ?>
<!DOCTYPE html>
<html>
<head>
<mata charset = "utr-8" />
<title>아이디 찾기</title>
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
        margin-top: 300px;
        align-items: center;
    }
</style>
<link rel = stylesheet href = 'gm_find.css' type = 'text/css' />
</head>
<body>
    <div class = "find">
        <form method = "post" action = "gande_member_find_id.php">
            <h1>GANDE 계정 찾기</h1>
                <br><fieldset>
                    <legend>아이디 찾기</legend>
                        <table>
                            <tr>
                                <td>이름</td>
                                <td><input type="text" size="35" name="name" placeholder="이름"></td>
                            </tr>
                            <tr>
                                <td>이메일</td>
                                <td><input type="text" name="email">@<select name="eadress"><option value="naver.com">naver.com</option>
                                <option value="daum.net">daum.net</option><option value="gmail.com">gmail.com</option></select></td>
                            </tr>
                        </table>
                </fieldset>
            <br><input type="submit" value="아이디 찾기"/>
            <br><br><input type="reset" value="메인 화면으로 이동" onclick="location.href='main.php';"/>
        </form>
    </div>
</body>
</html>
<?php } ?>