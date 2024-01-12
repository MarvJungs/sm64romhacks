<?php
if (!filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN)) header("Location: init-oauth.php");
else {
    header("Location: " . $_COOKIE['redirect']);
}
die();
