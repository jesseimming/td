<nav class="h-container">
    <!-- <img src="" alt="" class="h-img"> -->
    <div class="h-grouping">
        <div class="h-temp-img"></div>
        <ul class="h-content">
            <li class="h-item-content normalize-li">
                <a href="./" class="h-item-a normalize-a">Home</a>
                <a href="./" class="h-item-a normalize-a">Home2</a>
                <a href="./" class="h-item-a normalize-a">Home3</a>
            </li>
        </ul>
    </div>

    <div class="h-grouping">
        <a href="./?r=login" class="h-login-a normalize-a"><?php
        if ($is_logged_in) {
            echo "Logout";
        } else {
            echo "Login";
        }
        ?></a>
    </div>

</nav>