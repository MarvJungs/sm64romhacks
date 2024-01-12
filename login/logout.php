<?php

setcookie("logged_in", "", time() - (86400 * 30), "/");
setcookie("discord_id", "", time() - (86400 * 30), "/");
setcookie("name", "", time() - (86400 * 30), "/");
setcookie("avatar", "", time() - (86400 * 30), "/");
setcookie("email", "", time() - (86400 * 30), "/");
setcookie("global_name", "", time() - (86400 * 30), "/");
setcookie("twitch_handle", "", time() - (86400 * 30), "/");


header("Location: " . $_COOKIE['redirect']);
exit();
