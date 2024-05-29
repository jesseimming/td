<?php

function check_if_logged_in($username) {
    global $con;
    global $current_iid;

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

function validate_login($username, $password) {
    global $con;
    global $current_iid;

    $query = "SELECT username FROM `users` WHERE username = '{$username}' AND password = '{$password}';";

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
    }

    $prepare->close();

    return false;
}

function update_last_iid($username, $password) {
    global $con;
    global $current_iid;

    $query = "UPDATE `users` SET last_iid = '{$current_iid}' WHERE username = '{$username}' AND password = '{$password}';";

    $prepare = $con->prepare($query);

    if($prepare === false) {
        echo mysqli_error($con);
    } else{
        $prepare->execute();
    }

    $prepare->close();
}


?>