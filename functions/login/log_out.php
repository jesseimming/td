<?php

if ($is_logged_in) {
    setcookie('td_l', '{}', time() * 2, '/');

    header('Location: ./?r=home');
}

?>