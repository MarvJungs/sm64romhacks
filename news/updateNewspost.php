<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

if (!isset($_POST['post_id'])) {
    header("Location: /");
    die();
}
$post_author = $_COOKIE['discord_id'];
$post_title = stripChars($_POST['post_title']);
$post_text = $_POST['post_text'];
$post_text = str_replace("\r\n", " <br/>", $post_text);
$post_text = stripChars($post_text);
$post_text = str_replace("&lt;br/&gt;", "<br/>", $post_text);
$post_id = intval($_POST['post_id']);



updateNewspostInDatabase($pdo, $post_id, $post_author, $post_title, $post_text);

header("Location: /");
die();
