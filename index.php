<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Site</title>
        
        <link rel="stylesheet" href="assets/css/global.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="assets/js/global.js"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php
        include('core/database_connect.php');

        include('functions/global_lib.php');
        include('functions/login_lib.php');
        include('functions/login/is_logged_in.php');

        debug();

        include('core/header.php');

        ?>

        <?php
        // $has_arg = isset($_POST['f']);
        // if ($has_arg) {
        //     $post_function = $_POST['f'];
        //     include("functions/{$post_function}.php");
        // }

        ?>

        <?php
        // Redirect body to a php file
        $has_redirect = isset($_GET['r']);
        if ($has_redirect) {
            $redirect = $_GET['r'];

            include("view/{$redirect}.php");
        } else {
            $parseRedirect = 'home';
            include("view/{$parseRedirect}.php");
        }
       
        ?>


        <?php
        include('core/footer.php');
        ?>
    </body>
</html>