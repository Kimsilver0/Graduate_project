<?php
	if($_POST['username'] != NULL){
	$username_check = "SELECT * FROM gande_member WHERE username='{$_POST['username']}'");
	$username_check = $username_check;
	
	if($username_check >= 1){
		echo "존재하는 아이디입니다.";
	} else {
		echo "존재하지 않는 아이디입니다.";
	}
} ?>