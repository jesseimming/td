<?php
function redirect($url) {
    header("Location: {$url}");
    
    exit;
}

function prettyDump ( $var ) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

function get_iid() {
    $string = "";

    $agent = $_SERVER['HTTP_USER_AGENT'];
    $addr = $_SERVER['REMOTE_ADDR'];

    $string = $agent . $addr;

    return md5($string);
}

$current_iid = get_iid();

function debug() {
    global $is_logged_in;
    global $current_iid;

    echo "________ COOKIE ________";
    prettyDump($_COOKIE);

    echo "________ LOGIN ________";
    print("<br>Is logged in: " . ($is_logged_in ? "Yes" : "No"));
    print("<br>Your iid (identification id): " . $current_iid);
}


?>