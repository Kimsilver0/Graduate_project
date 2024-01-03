<?php
    $user_input = '안녕하세요';
    $python = shell_exec("python3 innoturn_bot.py " . escapeshellarg($user_input));
    echo $python;
?>