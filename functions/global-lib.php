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

function validate_login($username) {
    global $con;
    global $current_iid;
    global $is_logged_in;

    $query = "SELECT username FROM `users` WHERE username = '{$username}' AND last_iid = '{$current_iid}';";

    $prepare = $con->prepare($query);

    if($prepare === false) {
        echo mysqli_error($con);
    } else{
        $prepare->bind_result($sql_username);

        if($prepare->execute()){
            $prepare->store_result();
            $prepare->fetch();
            
            if ($sql_username && $sql_username == $username) {
                return true;
            }
        }

        $prepare->close();
    }


    echo "----- Debug -----";
    prettyDump($query);
    prettyDump($_SERVER['REMOTE_ADDR']);

    return false;
}


function log_into($username, $password) {
   
}
?>