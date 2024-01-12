<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';
$data = getRandomHackFromDatabase($pdo);
$data = $data[0]['hack_name'];
header("Location: " . '/hacks/' . getURLEncodedName($data));
die();
