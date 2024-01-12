<?php
include($_SERVER['DOCUMENT_ROOT'] . "/_includes/config.php");
$discord_url = DISCORD_REDIRECT_URL;
header("Location: $discord_url");
exit();
