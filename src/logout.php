<?php
session_start();
session_unset();
session_destroy();

setcookie("background_color", "", time() - 3600, "/");
setcookie("font_color", "", time() - 3600, "/");

header("Location: login.html");
exit();
?>
