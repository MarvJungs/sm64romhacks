<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

if (!filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN) || !in_array($_COOKIE['discord_id'], ADMIN_NEWS)) {
	header("Location: /");
	die();
}
?>
<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
	<title>sm64romhacks - Add Newspost</title> <!--CHANGE TITLE-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
	<meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
	<link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="shortcut icon" href="/_assets/_img/icon.ico" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
		<div align="center">
			<h1>Add Newspost!</h1>
			<span class="text-muted">Hint: Currently no Markup is possible, therefore please only insert plain text here.</span>
			<form action="processInput.php" method="post">
				<table class="table">
					<tr>
						<td class="text-right"><label for="post_title" class="form-label">Title</label></td>
						<td><input type="text" id="post_title" class="form-control" name="post_title"></td>
					</tr>
					<tr>
						<td class="text-right" style="vertical-align: top;"><label for="post_text" class="form-label">Text</label></td>
						<td><textarea name="post_text" id="post_text" cols="30" rows="10" class="form-control"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="text-center"><button class="btn btn-primary" type="submit">Add Newspost!</button></td>
					</tr>
				</table>
			</form>
			<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
		</div>
	</div>
</body>

</html>