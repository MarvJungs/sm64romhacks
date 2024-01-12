<?php

include($_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php');

$hack_id = intval($_GET['hack_id']);

//Only serve patchfile if client is not a bot
if (!is_bot()) {

    $patchname = getPatchFromDatabase($pdo, $hack_id)[0]['hack_patchname'];

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/patch/$patchname.zip")) updateDownloadCounter($pdo, $hack_id);


    header("Location: /patch/" . $patchname . ".zip");
    die();
}
