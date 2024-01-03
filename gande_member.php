<?php
//    include "db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>간디 회원가입</title>
    <link rel = stylesheet href = 'gm.css' type = 'text/css'>
    <script type = "text/javascript" src = "jquery.js"></script>
    <script>
        function checkusername(){
	        var username = document.getElementById("uname").value;
	        if(username)
	        {
		        url = "check.php?username="+username;
			        window.open(url,"chkusername","width=300,height=100");
		    } else{
			    alert("아이디를 입력하세요");
		    }
	    }
    </script>
</head>
<body>
        <form method = "post" action = "gande_member_ok.php">
            <h1>회원가입</h1>
                    <table>
                        <tr>
                            <td>이름</td>
                            <td><input type="text" size="20" name="name" placeholder="이름"></td>
                        </tr>
                        <tr>
                            <td>전화번호</td>
                            <td><input type="text" size="20" name="phone" placeholder="전화번호"></td>
                        </tr>
                        <tr>
                            <td>아이디</td>
                            <td><input type="text" size="20" name="username" id = "uname" placeholder="아이디">
                            <input type = "button" value = "중복검사" onclick = "checkusername();" />
                            <input type = "hidden" value = "0" name = "chs" /></td>
                        </tr>
                        <tr>
                            <td>비밀번호</td>
                            <td><input type="password" size="20" name="password" minlength="8" maxlength = "20" placeholder="비밀번호">
                            <p>※ 비밀번호는 <span class="num">문자, 숫자, 특수문자(~!@#$%^&*)의 조합 8자리 이상 20자리 이하</span>로 입력이 가능합니다.</p></td>
                        </tr>
                        <tr>
                            <td>이메일</td>
                            <td><input type="text" size = "20" name="email">@<select name="eadress"><option value="naver.com">naver.com</option><option value="gmail.com">gmail.com</option><option value="daum.net">daum.net</option></select></td>
                        </tr>
                        <tr>
                            <td>회원 유형</td>
                            <td>
                                <input type="checkbox" name="role[]" value="customer"> 카페 고객
                                <input type="checkbox" name="role[]" value="owner"> 카페 사장님
                            </td>
                        </tr>
                    </table>
                    <br><br>
            <div class = "text-center">    
                <input type="submit" value="가입하기" />
                <?php
                    if (isset($_POST['chs']) && $_POST['chs'] != "1") {
                        echo "<script>alert('아이디 중복 검사를 해주세요.');</script>";
                        exit;
                    }
                ?>
                <input type="reset" value="이미 가입" onclick="location.href='login.php';"/>
            </div>
        </form>
</body>
</html>