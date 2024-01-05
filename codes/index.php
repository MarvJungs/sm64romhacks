<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

?>

<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
	<title>sm64romhacks - Practice Codes</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
	<meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
	<link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="shortcut icon" href="/_assets/_img/icon.ico" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
	<div align=center>
		<div class="container">
			<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
			<table border="1">
				<tr align="center">
					<td>
						<h4><u>Table of Contents</u></h4><br />
						<ol>
							<table>
								<tr align="left">
									<td>
										<li><u><a href="#Timer">Timer</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Select">Reset at Star Select</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Castle">Timer in Castle</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Timer_Fix">Timer Fix</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Centi">Timer Display Centiseconds</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Prevent_Reset_at_Races">Prevent Timer Reset at Start of Koopa Races or Slide</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Prevent_Stop_at_Races">Prevent Timer Stop at Start of Koopa Races or Slide</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Paused">Run Timer while Paused</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Speed">Speed Display</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Reset">Level Reset (L)</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Camera_Fix">Level Reset Camera Fix</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Star_Select">Star Select (L+R)</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#No_Music">No Music</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#No_SFX">No SFX</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#Jabo HUD Fix">Jabo HUD Fix</a></u></li>
									</td>
								</tr>
								<tr align="left">
									<td>
										<li><u><a href="#L">L to Levitate</a></u></li>
									</td>
								</tr>
							</table>
						</ol>
					</td>
				</tr>
			</table>
			<hr />
			<h6 id="Timer"><u>Timer:</u></h6>
			<code>
				81249688 A03B<br />
				81249690 2400<br />
				8024B197 0040<br />
				8124DC7C A1A0<br />
				8124DC7E 00EE<br />
				D033AFA1 0020<br />
				8133B26C 0000<br />
				8124A024 1000<br />
				<hr />
			</code>
			<h6 id="Select"><u>Timer Reset at Star Select:</u></h6>
			<code>
				D033B239 0004<br />
				8133B26C 0000<br />
				<hr />
			</code>
			<h6 id="Castle"><u>Show Timer in Castle:</u></h6>
			<code>
				812E3E28 2400<br />
				<hr />
			</code>
			<h6 id="Timer_Fix"><u>Slide Timer Fix</u></h6>
			<code>
				81250736 B26C<br />
				81250738 29CF<br />
				8125073A 0006<br />
				<hr />
			</code>
			<h6 id="Centi"><u>Make Timer Display Centiseconds</u></h6>
			<code>
				802E3A63 00B4<br />
				812E39C8 2401<br />
				812E39CA 000A<br />
				812E3A00 0321<br />
				812E3A02 0018<br />
				812E3A04 0000<br />
				812E3A06 4812<br />
				812E3A08 2401<br />
				812E3A0A 0003<br />
				812E3A0C 0121<br />
				812E3A0E 001A<br />
				812E3A10 0000<br />
				812E3A12 5012<br />
				812E3A14 A7AA<br />
				812E3A16 0024<br />
				<hr />
			</code>
			<h6 id="Prevent_Reset_at_Races"><u>Prevent Timer Reset at the Start of Koopa Races and Slide</u></h6>
			<ul>
				<li>Breaks the <a href="#Timer_Fix">Slide Timer Fix</a> code.</li>
			</ul>
			<code>
				8124963C 2400<br />
				<hr />
			</code>
			<h6 id="Prevent_Stop_at_Races"><u>Prevent Timer Stop at the End of Koopa Races and Slide</u></h6>
			<ul>
				<li>Breaks the <a href="#Timer_Fix">Slide Timer Fix</a> code.</li>
			</ul>
			<code>
				81249660 2400<br />
				<hr />
			</code>
			<h6 id="Paused"><u>Run Timer While Paused</u></h6>
			<code>
				81336198 8060<br />
				8133619A 0000<br />
				81600000 3C0E<br />
				81600002 8034<br />
				81600004 81CF<br />
				81600006 B25E<br />
				81600008 11E0<br />
				8160000A 0005<br />
				8160000C 95CF<br />
				8160000E B26C<br />
				81600010 29F8<br />
				81600012 464F<br />
				81600014 1300<br />
				81600016 0002<br />
				81600018 25EF<br />
				8160001A 0001<br />
				8160001C A5CF<br />
				8160001E B26C<br />
				81600020 0809<br />
				81600022 2E80<br />
				81600024 2400<br />
				<hr />
			</code>
			<h6 id="Speed"><u>Speed Display</u></h6>
			<code>
				81253738 2400<br />
				812537C8 2400<br />
				81253814 2400<br />
				<hr />
			</code>
			<h6 id="Reset"><u>Level Reset (L)</u></h6>
			<code>
				8129CE9C 2400<br />
				8129CEC0 2400<br />
				D033AFA1 0020<br />
				8033B21E 0008<br />
				D033AFA1 0020<br />
				8133B262 0000<br />
				D033AFA1 0020<br />
				8133B218 0000<br />
				D033AFA1 0020<br />
				8033B248 0002<br />
				D033AFA1 0020<br />
				81361414 0005<br />
				<hr />
			</code>
			<h6 id="Camera_Fix"><u>Level Reset Camera Fix</u></h6>
			<code>
				D233B249 001D<br />
				812872DA 0001<br />
				D033B249 001D<br />
				812872DA 0000<br />
				<hr />
			</code>
			<h6 id="Star_Select"><u>Star Select (L+R)</u></h6>
			<code>
				D033AFA1 0030<br />
				80370000 0030<br />
				D233AFA1 0030<br />
				80370000 0000<br />
				D033B249 000D<br />
				80370001 000D<br />
				D233B249 000D<br />
				80370001 0000<br />
				D1370000 300D<br />
				8133B24A 020A<br />
				D1370000 3000<br />
				8133B24A 010A<br />
				D033AFA1 0030<br />
				8033B21E 0008<br />
				D033AFA1 0030<br />
				8133B238 0004<br />
				D033AFA1 0030<br />
				8033B248 0002<br />
				D033AFA1 0030<br />
				8133B26C 0000<br />
				<hr />
			</code>
			<h6 id="No_Music"><u>No Music</u></h6>
			<code>
				8131D3F4 2405<br />
				8131D3F6 0000<br />
				<hr />
			</code>
			<h6 id="No_SFX"><u>No SFX</u></h6>
			<code>
				8131EB00 03E0<br />
				8131EB02 0008<br />
				8131EB04 2400<br />
				<hr />
			</code>
			<h6 id="Jabo HUD Fix"><u>Jabo HUD Fix</u></h6>
			<code>
				802D6BCB 0010<br />
				812D6C66 0455<br />
				812D6DB2 1B60<br />
				802E2DA7 0010<br />
				812E2E3E 0455<br />
				812E309A 0455<br />
				812E3AA2 1B60<br />
				812E3BAE 1B60<br />
				<hr />
			</code>
			<h6 id="L"><u>L to Levitate</u></h6>
			<code>
				D033AFA1 0020<br />
				8133B1BC 4220<br />
				D033AFA1 0020<br />
				8133B17C 0300<br />
				D033AFA1 0020<br />
				8133B17E 0880<br />
			</code>
		</div>
		<hr /><br />
		Codes taken from: <a href="https://sites.google.com/view/supermario64/code">https://sites.google.com/view/supermario64/code</a><br /><br />
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
	</div>
</body>

</html>
