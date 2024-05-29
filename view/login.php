<?php
// Log out check
include('functions/login/log_out.php');

// Log in request
$has_function = isset($_POST['f']);
if ($has_function && $_POST['f'] == 'login-into') {
    include('functions/login/log_into.php');
}
?>

<h2 class="login-txt">Login</h2>

<form action="./?r=login" method="POST" id="form-login">
    <input type="hidden" name="f" value="login-into">
    
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="login-button">Login</button>
</form>