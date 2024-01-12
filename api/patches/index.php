<?php

include($_SERVER['DOCUMENT_ROOT'] . '/_includes/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/_includes/db.php');

createUsersDatabase($pdo);
createNewspostDatabase($pdo);
createHacksDatabase($pdo);
createAuthorsDatabase($pdo);
createHackAuthorsDatabase($pdo);


if (isset($_GET['hack_id'])) {
    print(json_encode(getPatchFromDatabase($pdo, $_GET['hack_id'])));
} else {
    print(json_encode(getAllPatchesFromDatabase($pdo)));
}
