<?php
include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';



$id = intval($_GET['id']);
$newspost = getNewspostFromDatabase($pdo, $id);
$author_id = $newspost['post_author'];
$user_id = $_COOKIE['discord_id'];
if ($id == 0 || !filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN) || !in_array($user_id, ADMIN_NEWS) && $user_id != $author_id) {
	header("Location: /");
	die();
}
?>

<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
	<title>sm64romhacks - Edit Newspost</title> <!--CHANGE TITLE-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
	<meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
	<link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="shortcut icon" href="/_assets/_img/icon.ico" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
	<script src="editNewspost.js?t=<?php print(filemtime('editNewspost.js')); ?>"></script>
</head>

<body>
	<div class="container">
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
		<div align="center">
			<!--HTML CONTENT HERE-->
			<form action="updateNewspost.php" method="post">
				<input type="hidden" id="post_id" class="form-control" name="post_id">
				<table>
					<tr>
						<td><label for="post_title" class="form-label">Title</label></td>
						<td><input type="text" id="post_title" class="form-control" name="post_title"></td>
					</tr>
					<tr>
						<td style="vertical-align: top;"><label for="post_text" class="form-label">Text</label></td>
						<td><textarea name="post_text" id="post_text" cols="100" rows="10" class="form-control"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><button class="btn btn-primary" type="submit">Save Changes!</button></td>
					</tr>
				</table>
			</form>

			<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
		</div>
	</div>
</body>

</html>