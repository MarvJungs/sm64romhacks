<?php

include($_SERVER['DOCUMENT_ROOT'] . '/_includes/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/_includes/db.php');

if ($_GET['type'] == 'normal') {
	print(json_encode(getMegapackHacksFromDatabase($pdo)));
} else if ($_GET['type'] == 'kaizo') {
	print(json_encode(getMegapackKaizoHacksFromDatabase($pdo)));
}
