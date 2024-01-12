<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

?>
<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
	<title>sm64romhacks - Online Patcher</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
	<meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
	<link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/_assets/_css/RomPatcher.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="shortcut icon" href="/_assets/_img/icon.ico" />
	<script type="text/javascript" src="/_assets/_js/RomPatcher.js/js/locale.js"></script>
	<script type="text/javascript" src="/_assets/_js/RomPatcher.js/js/RomPatcher.js"></script>
	<script type="text/javascript" src="/_assets/_js/RomPatcher.js/js/MarcFile.js"></script>
	<script type="text/javascript" src="/_assets/_js/RomPatcher.js/js/crc.js"></script>
	<script type="text/javascript" src="/_assets/_js/RomPatcher.js/js/formats/zip.js"></script>
	<script type="text/javascript" src="/_assets/_js/RomPatcher.js/js/formats/bps.js"></script>

	<script type="text/javascript" src="/_assets/_js/RomPatcher.js/js/zip.js/zip.js"></script>
	<!-- <script type="text/javascript" src="/_assets/_js/RomPatcher.js/js/libunrar/rpc.js"></script> -->
	<!--<script type="text/javascript" src="/_assets/_js/RomPatcher.js/js/custompatcher.js"></script>-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
	<script type="text/javascript">
		// CUSTOM PATCHER EXAMPLE
		// uncomment this to build your own custom exclusive patcher for your hacks/translations
		// user will only need to provide the ROM file, as patches will be fetched from your server!
		// a crc (or various crcs) can be provided for source files, allowing old formats like IPS to have validation!
		//var CUSTOM_PATCHER= setUpCustomPatcher();
		//console.log(CUSTOM_PATCHER)
	</script>
</head>
<!--END OF HEAD-->

<body>
	<div class="container">
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
		<div align="center">
			<h1>Online Patcher</h1>
			<ol>
				<table>
					<tr align="left">
						<td>
							<li>Select your UNMODIFIED ROM <b>(Make sure it has a <i>.z64</i> extension)</b></li>
						</td>
					</tr>
					<tr align="left">
						<td>
							<li>Select the bps-Patch you want to apply (it may also be a .zip file with the .bps file in it)</li>
						</td>
					</tr>
					<tr align="left">
						<td>
							<li>Press on "Apply Patch"</li>
						</td>
					</tr>
					<tr align="left">
						<td>
							<li>Profit!</li>
						</td>
					</tr>
				</table>
			</ol>

			<div id="wrapper">
				<div id="tab0" class="tab text-dark">
					<div class="row m-b">
						<div class="leftcol text-right"><label for="input-file-rom" data-localize="rom_file">ROM file:</label></div>
						<div class="rightcol">
							<input type="file" id="input-file-rom" class="enabled" />
						</div>
					</div>
					<div class="row m-b" id="rom-info">
						<div class="leftcol text-right">CRC32:</div>
						<div class="rightcol"><span id="crc32"></span></div>
						<div class="leftcol text-right">MD5:</div>
						<div class="rightcol"><span id="md5"></span></div>
						<div class="leftcol text-right">SHA-1:</div>
						<div class="rightcol"><span id="sha1"></span></div>
					</div>
					<div class="row m-b hide" id="row-removeheader">
						<div class="leftcol text-right"></div>
						<div class="rightcol">
							<input type="checkbox" id="checkbox-removeheader" /> <label for="checkbox-removeheader" data-localize="remove_header">Remove header before patching</label>
						</div>
					</div>
					<div class="row m-b hide" id="row-addheader">
						<div class="leftcol text-right"></div>
						<div class="rightcol">
							<input type="checkbox" id="checkbox-addheader" /> <label for="checkbox-addheader" data-localize="add_header">Add temporary header</label> <small>(<label id="headersize" for="checkbox-addheader"></label>)</small>
						</div>
					</div>

					<div class="row m-b" id="row-file-patch">
						<div class="leftcol text-right"><label for="input-file-patch" data-localize="patch_file">Patch file:</label></div>
						<div class="rightcol">
							<input type="file" id="input-file-patch" accept=".bps,.zip" />
						</div>
					</div>

					<div class="buttons">
						<span id="message-apply" class="message"></span>
						<button id="button-apply" data-localize="apply_patch" class="disabled" disabled>Apply patch</button>
					</div>
				</div>
			</div>

			<!-- FOOTER -->
			<footer>
				Rom Patcher JS <small>v2.8.1</small> by <a href="https://github.com/marcrobledo/">Marc Robledo</a>
				<br />
				<img src="/_assets/_img/icons/icon_github.svg" class="icon github" /> <a href="https://github.com/marcrobledo/RomPatcher.js/" target="_blank">See on GitHub</a>
				<img src="/_assets/_img/icons/icon_heart.svg" class="icon heart" /> <a href="https://www.paypal.me/marcrobledo/5" target="_blank" rel="nofollow">Donate</a>
			</footer>

		</div>
	</div>
	<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
	</div>
</body>

</html>