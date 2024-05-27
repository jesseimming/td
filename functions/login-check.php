<?php
$login_data = $_COOKIE['td_l'];
$login_data_decode = json_decode($login_data, true);

$is_logged_in = false;

if (
    $login_data_decode
) {
    $is_logged_in = validate_login($login_data_decode['username']);
}

print_r($is_logged_in);
?>