<?php

include $_SERVER['DOCUMENT_ROOT'] . '/_includes/includes.php';

?>

<!DOCTYPE HTML>
<html>
<!--BEGINNING OF HEAD-->

<head>
	<title>sm64romhacks - League 2022</title> <!--CHANGE TITLE-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="super mario, romhacks, hack, speedrun, sm64hacks, sm64romhacks, rom, modification" />
	<meta name="description" content="Welcome to SM64ROMHacks! We have a really big collection of SM64 ROM Hacks which wait to be played! Community News/Events will also be tracked here" />
	<link rel="stylesheet" type="text/css" href="/_assets/_css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="shortcut icon" href="/_assets/_img/icon.ico" />
	<script defer src="index.js"></script>
	<script src="pointsTable.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
	<style>
		td,
		input {
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container">
		<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/header.php'); ?>
		<div align="center">
			<h1>SM64 ROMHACKS LEAGUE (Sepember 17th - November 30th)</h1>
			<hr />
			<h2><b><u>TABLE OF CONTENTS</u></b></h2>
			<h5><a href="#what">1. What is a League?</a></h5>
			<h5><a href="#teams">2. How are Teams determined?</a></h5>
			<h5><a href="#points">3. How do I earn Points?</a></h5>
			<h6><a href="#calculator">3.1. Points Calculator</a></h6>
			<h5><a href="#src">4. Do I need to have my PBs on speedrun.com?</a></h5>
			<h5><a href="#categories">5. What categories are eligible?</a><br /></h5>
			<h5><a href="#howtojoin">6. Can I still join the League?</a></h5>
			<h5><a href="#leaderboard">7. Leaderboard</a></h5>
			<h5><a href="#results">8. Race Results</a></h5>
			<h6><a href="#race1">8.1. Race 1: Super Mario Star Road 20 Star</a></h6>
			<h6><a href="#race2">8.2. Race 2: Despair Mario's Gambit 64 0 Star</a></h6>
			<h6><a href="#race3">8.3. Race 3: Star Revenge 2: Act 1 To The Moon 16 Star</a></h6>
			<h6><a href="#race4">8.4. Race 4: Super Mario 74 10 Star</a></h6>
			<h6><a href="#race5">8.5. Race 5: Lug's Delightful Dioramas 51 Star</a></h6>
			<h6><a href="#race6">8.6. Race 6: Super Mario 74 50 Star</a></h6>
			<h6><a href="#race7">8.7. Race 7: Despair Mario's Gambit 64 53 Star</a></h6>
			<h6><a href="#race8">8.8. Race 8: Super Mario Star Road 80 Star</a></h6>
			<h6><a href="#race9">8.9. Race 9: Star Revenge 2 Act 1 To The Moon 41 Star</a></h6>
			<h6><a href="#race10">8.10. Race 10: Super Mario 74 110 Star</a></h6>
			<h6><a href="#race11">8.11. Race 11: Super Mario Star Road 130 Star</a></h6>
			<h6><a href="#race12">8.12. Race 12: Star revenge 2 Act 1: To The Moon 85 Star</a></h6>
			<h6><a href="#race13">8.13. Race 13: Lug's Delightful Dioramas 74 Star</a></h6>
			<h6><a href="#race14">8.14. Race 14: Despair Mario's Gambit 64 120 Star</a></h6>
			<hr />
			The ongoing league features 5 hacks and multiple categories. The league starts immediately after the draft held on 17 September 2022 and runs through November 30th. The current individual user leaderboard can be found <a href="#leaderboard">here</a><br /><br />
			<h2 id="what">WHAT IS A LEAGUE?</h2>
			League is community event open to any speedrunners. Participants are drafted onto teams and can earn points for their team by getting PBs in the selected categories and submitting them to speedrun.com. Participants may also participate in the races held every weekend and gain points for participation and placement in the race.<br /><br />
			<h3 id="teams">HOW ARE TEAMS DETERMINED?</h3>
			The teams are determined by a draft. Players that opt to be a captain are the ones that draft their teams. Anyone can signup to be a potential captain but the number of captains depends on how many people sign up. Generally, priority will be given to past league participants and known community members, but we will try to be as fair as possible to everyone. Everyone that signs up is guaranteed a spot. If we don't have an even number of players per team, we will try to recruit more runners for the smaller teams and/or adjust the team score for balance.<br /><br />
			<h3 id="points">HOW DO I EARN POINTS?</h3>
			The point system is subject to change as more people submit, a lot of hacks don't have many runs so it's hard to assign points, but in general these are the ways to earn points.
			<ol>
				<li>For each main category a player can claim a lump sum by getting <u>ANY PB</u> in that category, regardless of the time. This is meant to encourage people to do multiple categories. These "bonus points" can only be claimed once per category.</li>
				<li>You earn a certain number of points per second shaved off your pb under certain time thresholds. This is tiered so that you get more points per second as your times get better.</li>
				<li>Races will be held every weekend for points. You will get points for participating and bonus points for how well you place, this isn't a big way to get points, just a thing to encourage more runs and reward people with small points for those who are still trying and perhaps not pbing.</li>
			</ol>
			<?php include 'pointsCalculator.php'; ?>
			<b>A short explanation video by <u>AussieAdam</u> can be found <a target="_blank" href="https://youtu.be/q43GDGeJYk0">here</a></b>
			<br /><br />
			<h3 id="src"> DO I NEED TO HAVE MY PBS ON SPEEDRUN.COM? </h3>
			To keep track of points PBs will have to be submitted by someone to speedrun.com. A mod can always submit for you if you prefer not to have a speedrun.com account.<br /><br />
			<h3 id="categories">WHICH CATEGORIES ARE ELIGIBLE?</h3>
			<ul>
				<li><b>Despair Mario's Gambit 64 - 0 Star</b></li>
				<li><b>Despair Mario's Gambit 64 - 53 Star</b></li>
				<li><b>Despair Mario's Gambit 64 - 120 Star</b></li>
				<li><b>Lug's Delightful Dioramas - 51 Star</b></li>
				<li><b>Lug's Delightful Dioramas - 74 Star</b></li>
				<li><b>Star Revenge 2 Act 1: To the Moon - 16 Star</b></li>
				<li><b>Star Revenge 2 Act 1: To the Moon - 41 Star</b></li>
				<li><b>Star Revenge 2 Act 1: To the Moon - 85 Star</b></li>
				<li><b>Super Mario Star Road - 20 Star</b></li>
				<li><b>Super Mario Star Road - 80 Star</b></li>
				<li><b>Super Mario Star Road - 130 Star</b></li>
				<li><b>Super Mario 74 - 10 Star</b></li>
				<li><b>Super Mario 74 - 50 Star</b></li>
				<li><b>Super Mario 74 - 110 Star</b></li>
				<li><b>Super Mario 74 - 151 Star</b></li>
			</ul>
			<br />
			<h3 id="howtojoin">CAN I STILL JOIN THE LEAGUE?</h3>
			Yes, it is still possible to join in late! Just join the <a href="http://discord.sm64romhacks.com/">Discord</a>, head to <u>#speedrun-league-discussion</u> and let an organizer know, they will then draft you to a team and you are in!<br /><br />
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
			<h3 id="results">RACE RESULTS</h3>
			<h4 id="race1">Race 1: Super Mario Star Road 20 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time 1</td>
					<td>Time 2</td>
					<td>Time 3</td>
					<td>Average</td>
				</tr>
				<tr>
					<td>1</td>
					<td>Dackage</td>
					<td>12:33</td>
					<td>12:53</td>
					<td>12:30</td>
					<td>12:38</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Tomatobird8</td>
					<td>N/A</td>
					<td>13:21</td>
					<td>14:21</td>
					<td>14:01</td>
				</tr>
				<tr>
					<td>3</td>
					<td>SigotuSR</td>
					<td>13:53</td>
					<td>15:18</td>
					<td>14:35</td>
					<td>14:35</td>
				</tr>
				<tr>
					<td>4</td>
					<td>justinnyk</td>
					<td>18:40</td>
					<td>16:04</td>
					<td>17:08</td>
					<td>17:17</td>
				</tr>
				<tr>
					<td>5</td>
					<td>KingToad</td>
					<td>N/A</td>
					<td>15:39</td>
					<td>21:34</td>
					<td>18:36</td>
				</tr>
				<tr>
					<td>6</td>
					<td>DarkMan</td>
					<td>21:15</td>
					<td>14:46</td>
					<td>21:03</td>
					<td>19:01</td>
				</tr>
				<tr>
					<td>7</td>
					<td>CometOfDoom</td>
					<td>20:05</td>
					<td>21:49</td>
					<td>17:13</td>
					<td>19:42</td>
				</tr>
				<tr>
					<td>8</td>
					<td>Mushie64</td>
					<td>29:41</td>
					<td>N/A</td>
					<td>18:04</td>
					<td>23:52</td>
				</tr>
				<tr>
					<td>9</td>
					<td>SuperGamer</td>
					<td>N/A</td>
					<td>22:41</td>
					<td>26:07</td>
					<td>24:24</td>
				</tr>
				<tr>
					<td>10</td>
					<td>ZenonX</td>
					<td>25:18</td>
					<td>31:28</td>
					<td>17:55</td>
					<td>24:53</td>
				</tr>
				<tr>
					<td>11</td>
					<td>Okami</td>
					<td>N/A</td>
					<td>26:06</td>
					<td>24:50</td>
					<td>25:28</td>
				</tr>
				<tr>
					<td>12</td>
					<td>Alex_Vloggen</td>
					<td>27:11</td>
					<td>29:19</td>
					<td>25:22</td>
					<td>27:17</td>
				</tr>
				<tr>
					<td>13</td>
					<td>montyvr</td>
					<td>26:34</td>
					<td>29:58</td>
					<td>27:35</td>
					<td>28:02</td>
				</tr>
				<tr>
					<td>14</td>
					<td>IwerSonsch</td>
					<td>33:06</td>
					<td>26:19</td>
					<td>N/A</td>
					<td>29:42</td>
				</tr>
			</table><br />

			<h4 id="race2">Race 2: Despair Mario's Gambit 64 0 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time 1</td>
					<td>Time 2</td>
					<td>Time 3</td>
					<td>Average</td>
				</tr>
				<tr>
					<td>1</td>
					<td>SigotuSR</td>
					<td>4:32</td>
					<td>4:54</td>
					<td>4:24</td>
					<td>4:36</td>
				</tr>
				<tr>
					<td>2</td>
					<td>amsixx</td>
					<td>N/A</td>
					<td>5:06</td>
					<td>5:00</td>
					<td>5:03</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Tomatobird8</td>
					<td>5:07</td>
					<td>4:37</td>
					<td>5:53</td>
					<td>5:12</td>
				</tr>
				<tr>
					<td>4</td>
					<td>mojopug</td>
					<td>6:44</td>
					<td>6:14</td>
					<td>5:40</td>
					<td>6:12</td>
				</tr>
				<tr>
					<td>5</td>
					<td>CometOfDoom</td>
					<td>6:22</td>
					<td>7:42</td>
					<td>5:55</td>
					<td>6:39</td>
				</tr>
				<tr>
					<td>6</td>
					<td>justinnyk</td>
					<td>6:28</td>
					<td>8:18</td>
					<td>5:50</td>
					<td>6:52</td>
				</tr>
				<tr>
					<td>7</td>
					<td>KingToad</td>
					<td>6:58</td>
					<td>7:43</td>
					<td>6:07</td>
					<td>6:56</td>
				</tr>
				<tr>
					<td>8</td>
					<td>meseinsanity</td>
					<td>6:11</td>
					<td>5:56</td>
					<td>8:50</td>
					<td>6:59</td>
				</tr>
				<tr>
					<td>9</td>
					<td>diamondflash</td>
					<td>7:01</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>7:01</td>
				</tr>
				<tr>
					<td>10</td>
					<td>Dackage</td>
					<td>6:58</td>
					<td>6:04</td>
					<td>8:05</td>
					<td>7:02</td>
				</tr>
				<tr>
					<td>11</td>
					<td>Luvbaseball</td>
					<td>4:54</td>
					<td>12:18</td>
					<td>4:36</td>
					<td>7:16</td>
				</tr>
				<tr>
					<td>12</td>
					<td>Alex_Vloggen</td>
					<td>11:09</td>
					<td>5:19</td>
					<td>5:36</td>
					<td>7:21</td>
				</tr>
				<tr>
					<td>13</td>
					<td>Darkman</td>
					<td>9:00</td>
					<td>7:03</td>
					<td>8:20</td>
					<td>8:07</td>
				</tr>
				<tr>
					<td>14</td>
					<td>christianvega</td>
					<td>9:47</td>
					<td>10:16</td>
					<td>7:37</td>
					<td>9:13</td>
				</tr>
				<tr>
					<td>14</td>
					<td>ZenonX</td>
					<td>8:40</td>
					<td>6:14</td>
					<td>12:46</td>
					<td>9:13</td>
				</tr>
				<tr>
					<td>16</td>
					<td>IwerSonsch</td>
					<td>N/A</td>
					<td>10:56</td>
					<td>8:01</td>
					<td>9:28</td>
				</tr>
				<tr>
					<td>17</td>
					<td>montyvr</td>
					<td>13:16</td>
					<td>10:35</td>
					<td>7:01</td>
					<td>10:17</td>
				</tr>
			</table><br />

			<h4 id="race3">Race 3: Star Revenge 2: Act 1 To The Moon 16 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time 1</td>
					<td>Time 2</td>
					<td>Time 3</td>
					<td>Average</td>
				</tr>
				<tr>
					<td>1</td>
					<td>katze789</td>
					<td>21:38</td>
					<td>18:27</td>
					<td>18:14</td>
					<td>19:26</td>
				</tr>
				<tr>
					<td>2</td>
					<td>SigotuSR</td>
					<td>21:41</td>
					<td>19:52</td>
					<td>18:22</td>
					<td>19:58</td>
				</tr>
				<tr>
					<td>3</td>
					<td>SubmarineCpt</td>
					<td>18:25</td>
					<td>23:48</td>
					<td>19:00</td>
					<td>20:24</td>
				</tr>
				<tr>
					<td>4</td>
					<td>Luvbaseball</td>
					<td>20:16</td>
					<td>20:03</td>
					<td>23:04</td>
					<td>21:07</td>
				</tr>
				<tr>
					<td>5</td>
					<td>Tomatobird8</td>
					<td>20:52</td>
					<td>26:54</td>
					<td>22:10</td>
					<td>23:18</td>
				</tr>
				<tr>
					<td>6</td>
					<td>justinnyk</td>
					<td>N/A</td>
					<td>26:35</td>
					<td>24:24</td>
					<td>25:29</td>
				</tr>
				<tr>
					<td>7</td>
					<td>Dackage</td>
					<td>26:23</td>
					<td>26:35</td>
					<td>23:32</td>
					<td>25:30</td>
				</tr>
				<tr>
					<td>8</td>
					<td>DarkMan</td>
					<td>32:41</td>
					<td>32:03</td>
					<td>27:51</td>
					<td>30:51</td>
				</tr>
				<tr>
					<td>9</td>
					<td>IwerSonsch</td>
					<td>45:53</td>
					<td>30:30</td>
					<td>35_27</td>
					<td>37:16</td>
				</tr>
			</table><br />

			<h4 id="race4">Race 4: Super Mario 74 10 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time 1</td>
					<td>Time 2</td>
					<td>Time 3</td>
					<td>Average</td>
				</tr>
				<tr>
					<td>1</td>
					<td>SigotuSR</td>
					<td>9:10</td>
					<td>9:17</td>
					<td>9:52</td>
					<td>9:26</td>
				</tr>
				<tr>
					<td>2</td>
					<td>katze789</td>
					<td>11:49</td>
					<td>10:37</td>
					<td>9:57</td>
					<td>10:47</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Tomatobird8</td>
					<td>11:02</td>
					<td>10:58</td>
					<td>N/A</td>
					<td>11:00</td>
				</tr>
				<tr>
					<td>4</td>
					<td>Luvbaseball</td>
					<td>10:49</td>
					<td>10:56</td>
					<td>11:21</td>
					<td>11:02</td>
				</tr>
				<tr>
					<td>5</td>
					<td>KingToad</td>
					<td>11:37</td>
					<td>11:40</td>
					<td>10:22</td>
					<td>11:13</td>
				</tr>
				<tr>
					<td>6</td>
					<td>Dackage</td>
					<td>11:59</td>
					<td>12:43</td>
					<td>10:56</td>
					<td>11:52</td>
				</tr>
				<tr>
					<td>7</td>
					<td>Lahmus</td>
					<td>13:20</td>
					<td>13:44</td>
					<td>10:30</td>
					<td>12:31</td>
				</tr>
				<tr>
					<td>8</td>
					<td>montyvr</td>
					<td>13:41</td>
					<td>12:30</td>
					<td>15:54</td>
					<td>14:01</td>
				</tr>
				<tr>
					<td>9</td>
					<td>justinnyk</td>
					<td>14:32</td>
					<td>14:12</td>
					<td>13:43</td>
					<td>14:09</td>
				</tr>
				<tr>
					<td>10</td>
					<td>Okami</td>
					<td>18:02</td>
					<td>13:28</td>
					<td>13:04</td>
					<td>14:51</td>
				</tr>
				<tr>
					<td>11</td>
					<td>DarkMan</td>
					<td>18:59</td>
					<td>16:51</td>
					<td>14:15</td>
					<td>16:41</td>
				</tr>
				<tr>
					<td>12</td>
					<td>christianvega</td>
					<td>27:50</td>
					<td>14:45</td>
					<td>12:14</td>
					<td>18:16</td>
				</tr>
			</table><br />

			<h4 id="race5">Race 5: Lug's Delightful Dioramas 51 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>katze789</td>
					<td>28:28</td>
				</tr>
				<tr>
					<td>2</td>
					<td>RedSlim77</td>
					<td>33:58</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Lahmus</td>
					<td>35:27</td>
				</tr>
				<tr>
					<td>4</td>
					<td>matgeo</td>
					<td>42:29</td>
				</tr>
				<tr>
					<td>5</td>
					<td>AndrewSM64</td>
					<td>42:53</td>
				</tr>
				<tr>
					<td>6</td>
					<td>Dackage</td>
					<td>45:59</td>
				</tr>
				<tr>
					<td>7</td>
					<td>TheReverserOfTime</td>
					<td>46:30</td>
				</tr>
				<tr>
					<td>8</td>
					<td>DarkMan</td>
					<td>51:47</td>
				</tr>
			</table><br />

			<h4 id="race6">Race 6: Super Mario 74 50 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>CaptainBowser</td>
					<td>28:04</td>
				</tr>
				<tr>
					<td>2</td>
					<td>katze789</td>
					<td>30:01</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Tomatobird8</td>
					<td>32:30</td>
				</tr>
				<tr>
					<td>4</td>
					<td>KingToad64</td>
					<td>32:44</td>
				</tr>
				<tr>
					<td>5</td>
					<td>Okami</td>
					<td>33:18</td>
				</tr>
				<tr>
					<td>6</td>
					<td>Dackage</td>
					<td>33:45</td>
				</tr>
				<tr>
					<td>7</td>
					<td>Lahmus</td>
					<td>35:53</td>
				</tr>
				<tr>
					<td>8</td>
					<td>DarkMan</td>
					<td>37:53</td>
				</tr>
				<tr>
					<td>9</td>
					<td>DarkMan</td>
					<td>40:35</td>
				</tr>
				<tr>
					<td>10</td>
					<td>christianvega</td>
					<td>51:42</td>
				</tr>
			</table><br />

			<h4 id="race7">Race 7: Despair Mario's Gambit 64 53 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>CaptainBowser</td>
					<td>31:55</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Luvbaseball</td>
					<td>35:41</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Muimania</td>
					<td>36:25</td>
				</tr>
				<tr>
					<td>4</td>
					<td>amsixx</td>
					<td>36:54</td>
				</tr>
				<tr>
					<td>5</td>
					<td>IwerSonsch</td>
					<td>40:04</td>
				</tr>
				<tr>
					<td>6</td>
					<td>Dackage</td>
					<td>41:16</td>
				</tr>
				<tr>
					<td>7</td>
					<td>DJTala</td>
					<td>42:13</td>
				</tr>
				<tr>
					<td>8</td>
					<td>aJames_30</td>
					<td>45:28</td>
				</tr>
				<tr>
					<td>9</td>
					<td>justinnyk</td>
					<td>45:36</td>
				</tr>
				<tr>
					<td>10</td>
					<td>DarkMan</td>
					<td>1:00:18</td>
				</tr>
				<tr>
					<td>11</td>
					<td>christianvega</td>
					<td>1:03:54</td>
				</tr>
			</table><br />

			<h4 id="race8">Race 8: Super Mario Star Road 80 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>Dackage</td>
					<td>55:47</td>
				</tr>
				<tr>
					<td>2</td>
					<td>SuperViperT302</td>
					<td>1:08:22</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Luvbaseball</td>
					<td>1:14:06</td>
				</tr>
				<tr>
					<td>4</td>
					<td>justinnyk</td>
					<td>1:21:44</td>
				</tr>
				<tr>
					<td>5</td>
					<td>DarkMan</td>
					<td>1:49:00</td>
				</tr>
			</table><br />

			<h4 id="race9">Race 9: Star Revenge 2 Act 1 To The Moon 41 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>SubmarineCpt</td>
					<td>35:05</td>
				</tr>
				<tr>
					<td>2</td>
					<td>katze789</td>
					<td>37:03</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Dackage</td>
					<td>44:09</td>
				</tr>
				<tr>
					<td>4</td>
					<td>Tomatobird8</td>
					<td>44:13</td>
				</tr>
				<tr>
					<td>5</td>
					<td>Luvbaseball</td>
					<td>46:42</td>
				</tr>
				<tr>
					<td>6</td>
					<td>DarkMan</td>
					<td>1:05:47</td>
				</tr>
			</table><br />

			<h4 id="race10">Race 10: Super Mario 74 110 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>CaptainBowser</td>
					<td>1:11:01</td>
				</tr>
				<tr>
					<td>2</td>
					<td>katze789</td>
					<td>1:11:59</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Tomatobird8</td>
					<td>1:18:28</td>
				</tr>
				<tr>
					<td>4</td>
					<td>Luvbaseball</td>
					<td>1:21:24</td>
				</tr>
				<tr>
					<td>5</td>
					<td>Okami</td>
					<td>1:27:51</td>
				</tr>
				<tr>
					<td>6</td>
					<td>Lahmus</td>
					<td>1:32:52</td>
				</tr>
				<tr>
					<td>7</td>
					<td>Sodium</td>
					<td>1:36:12</td>
				</tr>
				<tr>
					<td>8</td>
					<td>Alex_Vloggen</td>
					<td>2:03:02</td>
				</tr>
				<tr>
					<td>9</td>
					<td>DarkMan</td>
					<td>2:31:45</td>
				</tr>
			</table><br />

			<h4 id="race11">Race 11: Super Mario Star Road 130 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>Dackage</td>
					<td>1:54:23</td>
				</tr>
				<tr>
					<td>2</td>
					<td>katze789</td>
					<td>2:07:43</td>
				</tr>
				<tr>
					<td>3</td>
					<td>DarkMan</td>
					<td>3:50:00</td>
				</tr>
			</table><br />

			<h4 id="race12">Race 12: Star Revenge 2 Act 1: To the Moon 85 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>katze789</td>
					<td>1:33:43</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Tomatobird8</td>
					<td>1:39:32</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Luvbaseball</td>
					<td>1:52:08</td>
				</tr>
			</table><br />

			<h4 id="race13">Race 13: Lug's Delightful Dioramas 74 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>katze789</td>
					<td>49:53</td>
				</tr>
				<tr>
					<td>2</td>
					<td>matgeo</td<td>1:01:40</td>>
				</tr>
				<tr>
					<td>3</td>
					<td>Luvbaseball</td>
					<td>1:21:27</td>
				</tr>
				<tr>
					<td>4</td>
					<td>WesDogg</td>
					<td>1:36:29</td>
				</tr>
				<tr>
					<td>5</td>
					<td>DarkMan</td>
					<td>2:24:54</td>
				</tr>
			</table><br />

			<h4 id="race14">Race 14: Despair Mario's Gambit 64 120 Star</h4>
			<table border=1>
				<tr>
					<td>Place</td>
					<td>Runner</td>
					<td>Time</td>
				</tr>
				<tr>
					<td>1</td>
					<td>Xalince</td>
					<td>1:41:19</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Muimania</td>
					<td>1:41:51</td>
				</tr>
				<tr>
					<td>3</td>
					<td>aglab2</td>
					<td>1:46:20</td>
				</tr>
				<tr>
					<td>4</td>
					<td>Okami</td>
					<td>2:23:31</td>
				</tr>
			</table>
			<?php include($_SERVER['DOCUMENT_ROOT'] . '/_includes/footer.php'); ?>
		</div>
	</div>
</body>

</html>
