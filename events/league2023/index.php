<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

?>

<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
	<title>sm64romhacks - League 2023</title> <!--CHANGE TITLE-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
	<meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
	<link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/_assets/_css/style.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="shortcut icon" href="/_assets/_img/icon.ico" />
	<script src="runners.js"></script>
	<script src="index.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
		<div align="center">
			<h1>SM64 ROMHACKS LEAGUE 2023 (September 16th - October 31st)</h1>
			<hr />
			<h2 id="countdown"></h2>
			<h2><b><u>TABLE OF CONTENTS</u></b></h2>
			<h5><a href="#what">1. What is a League?</a></h5>
			<h5><a href="#teams">2. How are Teams determined?</a></h5>
			<h5><a href="#points">3. How do I earn Points?</a></h5>
			<h6><a href="#calculator">3.1. Points Calculator</a></h6>
			<h5><a href="#src">4. Do I need to have my PBs on speedrun.com?</a></h5>
			<h5><a href="#categories">5. What categories are eligible?</a><br /></h5>
			<h5><a href="#howtojoin">6. Can I still join the League?</a></h5>
			<h5><a href="#leaderboard">7. Leaderboard</a></h5>
			<h5><a href="#streams">8. Streams</a></h5>
			<hr />
			The ongoing league features 3 hacks and multiple categories. The league starts immediately after the draft held on 16 September 2023 and runs through October 31st. The current individual user leaderboard can be found <a href="#leaderboard">here</a><br /><br />
			<h2 id="what">WHAT IS A LEAGUE?</h2>
			League is community event open to any speedrunners. Participants are drafted onto teams and can earn points for their team by getting PBs in the selected categories and submitting them to speedrun.com.<br /><br />
			<h3 id="teams">HOW ARE TEAMS DETERMINED?</h3>
			The teams are determined by a draft. Players that opt to be a captain are the ones that draft their teams. Anyone can signup to be a potential captain but the number of captains depends on how many people sign up. Generally, priority will be given to past league participants and known community members, but we will try to be as fair as possible to everyone. Everyone that signs up is guaranteed a spot. If we don't have an even number of players per team, we will try to recruit more runners for the smaller teams and/or adjust the team score for balance.<br /><br />
			<h3 id="points">HOW DO I EARN POINTS?</h3>
			Points are determined by Leaderboard position. The higher your rank is, the more points you get. The Basesystem is:
			<ul>
				<li>The last place gets 1 point.</li>
				<li>For each higher placement you get one extra point.</li>
				<li>If you are between place 6 and 10, your points increase by 2 instead of 1.</li>
				<li>If you are between place 1 and 5, your points increase by 3 instead of 2.</li>
				<li>Some categories give Bonuspoints onto the Basesystem due their lenght.</li>
				<li>Due The System being based off Leaderboard position, there is a maximum amount of points to catch per category.</li>
				<?php include 'pointsCalculator.php'; ?>
				<h3 id="src"> DO I NEED TO HAVE MY PBS ON SPEEDRUN.COM? </h3>
				To keep track of points PBs will have to be submitted by someone to speedrun.com. A mod can always submit for you if you prefer not to have a speedrun.com account.<br /><br />
				<h3 id="categories">WHICH CATEGORIES ARE ELIGIBLE?</h3>
				<ul>
					<li><b>Mario's New Earth - 70 Star</b></li>
					<li><b>Mario's New Earth - 125 Star</b></li>
					<li><b>SM64: The Green Stars - 1 Star</b></li>
					<li><b>SM64: The Green Stars - 81 Star</b></li>
					<li><b>SM64: The Green Stars - 131 Star</b></li>
					<li><b>Ztar Attack Rebooted - 12 Star</b></li>
					<li><b>Ztar Attack Rebooted - 96 Star</b></li>
					<li><b>Ztar Attack Rebooted - 170 Star</b></li>
				</ul>
				<br />
				<h3 id="howtojoin">CAN I STILL JOIN THE LEAGUE?</h3>
				<!--Yes, it is still possible to join in late! Just join the <a href="http://discord.sm64romhacks.com/">Discord</a>, head to <u>#speedrun-league-discussion-2023</u> and let an organizer know, they will then draft you to a team and you are in!<br/><br/>-->
				No, unfortunately all spaces are filled out now. Feel free to watch the league progressing by progressively checking out this page or supporting the runners! Their streams when they are live can be found <a href="#streams">here</a>! Otherwise try next year again!
				<h3 id="leaderboard">LEADERBOARD</h3>
				<table>
					<tr>
						<td>
							<div id="userLeaderboard"></div>
						</td>
						<td style="vertical-align:top">
							<div id="teamLeaderboard"></div>
						</td>
					</tr>
				</table><br />
				<table>
					<tr>
						<td>
							<div id="userLeaderboard"></div>
						</td>
						<td style="vertical-align:top">
							<div id="teamLeaderboard"></div>
						</td>
					</tr>
				</table><br />
				<h3 id="streams">STREAMS</h3>
				<?php include 'streams.php'; ?>
				<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
		</div>
	</div>
</body>

</html>
