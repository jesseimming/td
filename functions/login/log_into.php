<?php

$username = $_POST['username'];
$password = $_POST['password'];

$is_valid_login = validate_login($username, $password);

if ($is_valid_login) {
    $json_string = '{"username": "' . $username . '"}';

    update_last_iid($username, $password);
    
    setcookie('td_l', $json_string, time() * 2, "/");

    echo "Logged in!";

    ?>

    <a href="./" class="redirect">Go home</a>

    <?php
    exit;
} else {
    echo "Invalid login!";
}

?>