<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

if (!filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN) || !in_array($_COOKIE['discord_id'], ADMIN_SITE)) {
	header("Location: /404.php");
	die();
}

if (sizeof($_GET) == 2 || intval($_GET['hack_id']) != 0) {
	$hack_id = intval($_GET['hack_id']);
	$patch = getPendingPatchFromDatabase($pdo, $hack_id);
	if ($_GET['mode'] == 'accept') {
		verifyPatchInDatabase($pdo, $hack_id);
		rename($_SERVER['DOCUMENT_ROOT'] . "/admin/" . $patch[0]['hack_patchname'] . '.zip', $_SERVER['DOCUMENT_ROOT'] . "/patch/" . $patch[0]['hack_patchname'] . '.zip');
	} else if (stripChars($_GET['mode']) == 'reject') {
		deleteHackAuthorFromDatabase($pdo, $hack_id);
		deletePatchFromDatabase($pdo, $hack_id);
		unlink($_SERVER['DOCUMENT_ROOT'] . "/admin/" . $patch[0]['hack_patchname'] . '.zip');
	}
	header("Location: /admin");
	die();
}

?>

<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
	<title>sm64romhacks - Admin Page</title> <!--CHANGE TITLE-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
	<meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
	<link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="shortcut icon" href="/_assets/_img/icon.ico" />
	<script src="admin.js?t=<?php print(filemtime('admin.js')); ?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
		<div align="center">
			<div id="admin-page"></div>

			<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
		</div>
	</div>
</body>

</html>
