<?php
if (isset($_COOKIE["notification"])) {
    echo "<div class='notification'>" . $_COOKIE["notification"] . "</div>";
    setcookie("notification", "", time() - 3600); // Clear the notification cookie
}
