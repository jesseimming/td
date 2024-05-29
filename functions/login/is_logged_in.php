<?php

if (!isset($_COOKIE['td_l'])) {
    setcookie('td_l', '{"username":""}', time() + (86400 * 30), "/");
}

$login_data = $_COOKIE['td_l'];
$login_data_decode = json_decode($login_data, true);

$is_logged_in = false;

if (
    $login_data_decode
) {
    $is_logged_in = check_if_logged_in($login_data_decode['username']);
}

?>