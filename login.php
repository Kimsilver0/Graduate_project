<?php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>간디 로그인</title>
    <script>
        function checkCapsLock(event) {
            var capsLockOn = event.getModifierState && event.getModifierState('CapsLock');
            var capsLockMsg = document.getElementById('capsLockMsg');
    
            if (capsLockOn) {
                capsLockMsg.innerHTML = "Caps Lock이 켜져 있습니다.";
                capsLockMsg.style.display = "block";
            } else {
                capsLockMsg.innerHTML = "";
                capsLockMsg.style.display = "none";
            }
        }
    </script>
    <link rel = stylesheet href = 'login.css' type = 'text/css' />
</head>
<body>
    <div id = "login_box">
        <h1>Welcome GANDE</h1>
            <form method = "post" action = "login_ok.php">
                <table align = "center" border = "0" cellspacing = "0" width = "300">
                    <tr>
                        <td width = "130" colspan = "1">
                        <input type = "text" name = "username" class = "inph" onkeydown="checkCapsLock(event)">
                        <p id="capsLockMsg"></p>
                        </td>
                        <td rowspan = "2" align = "center" width = "100">
                            <button type = "submit" id = "btn">로그인</button>
                        </td>
                    </tr>
                    <tr>
                        <td width = "130" colspan = "1">
                        <input type = "password" name = "password" class = "inph" onkeydown="checkCapsLock(event)">
                        <p id="capsLockMsg"></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "3" align = "left" class = "cl">
                        <br><br><input type = "checkbox" name = "remember_me" value = "1"> 자동로그인
                    </tr>
                </table>
                <div class = "text-center">
                    <input type="reset" value="회원 가입" onclick="location.href='gande_member.php';"/>
                    <input type="reset" value="계정 찾기" onclick="location.href='gande_member_find.php';"/>
                </div>
            </form>
    </div>
</body>
</html>