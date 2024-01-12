<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

?>


<!DOCTYPE HTML>
<html>

<head>
	<title>sm64romhacks - Megapack</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification megapack" />
	<meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
	<link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="shortcut icon" href="/_assets/_img/icon.ico" />
	<script src="/megapack/megapack.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
		<div align="center">
			<h1>Grand ROM Hack Megapack</h1>
			<p>This megapack offers a selection of major Super Mario 64 ROM hacks which are universally considered to be the greatest. This is in hope to provide an ideal starter pack which serves as an easily accessible introduction to the world of ROM hacks.</p>
			<i>Contents of this page was last updated: 2024-01-01 (yyyy-mm-dd)</i>
			<table>
				<tr>
					<td>
						<div class="btn-group-lg"><a class="btn btn-primary" href="Grand%20Rom%20Hack%20Megapack%202023%20(Final Edition).zip" style="margin-bottom: 24px;">Download Megapack</a></div>
					</td>
					<td>
						<div class="btn-group-lg"><a class="btn btn-primary" href="Grand%20SM64%20Kaizo%20Megapack%202023%20(Final Edition).zip" style="margin-bottom: 24px;">Download KAIZO Megapack</a></div>
					</td>
				</tr>
			</table>
			Difficulty:
			<select class="form-select" id="tagInput">
				<option value="" selected>Select A Difficulty</option>
				<option value="easy">Easy</option>
				<option value="normal">Normal</option>
				<option value="advanced">Advanced</option>
				<option value="kaizo">Kaizo</option>
			</select><br /><br />

			<div id="normalmegapack">
				<h5>Normal Megapack Hacks</h5>
			</div><br /><br />
			<div id="kaizomegapack">
				<h5>Kaizo Megapack Hacks</h5>
			</div>

			<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>

		</div>
</body>

</html>