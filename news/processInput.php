<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

$post_author = $_COOKIE['discord_id'];
$post_title = stripChars($_POST['post_title']);
$post_text = $_POST['post_text'];
$post_text = str_replace("\r\n", " <br/>", $post_text);
$post_text = stripChars($post_text);
$post_text = str_replace("&lt;br/&gt;", "<br/>", $post_text);


if (!filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN) || !in_array($_COOKIE['discord_id'], ADMIN_NEWS) || !isset($post_title) || !isset($post_text)) {
    header("Location: /");
    die();
}


addNewspostToDatabase($pdo, $post_title, $post_text, $post_author);

header("Location: /");
die();
