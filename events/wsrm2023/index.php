<?php include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php'; ?>

<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
	<title>sm64romhacks - WSRM2023</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
	<meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
	<link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="shortcut icon" href="/_assets/_img/icon.ico" />
	<script src="/_assets/_js/horaro.js?t=<?php print(filemtime($_SERVER['DOCUMENT_ROOT'] . "/_assets/_js/horaro.js")); ?>"></script>
	<script src="wsrm2023.js?t=<?php print(filemtime('wsrm2023.js')) ?>)"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
		<div class="container">
			<div align="center">
				WSRM stands for Winter SM64 ROM Hacks Marathon and is a 3-4 days long Marathon featuring a variety of Runners and SM64 ROM Hacks!<br />
				The Marathon will be taking place from January 4th to 8th on the<a href="https://www.twitch.tv/sm64romhacks"> sm64romhacks Twitch channel!</a><br /><br />
				<h5>Unfortunately our submissions are closed. Try it next time again!</h5>
				<h5>The Schedule has been released!</h5>
				<div id="ticker"></div>
				<div id="schedule"></div>
				<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
			</div>

		</div>
	</div>
</body>

</html>