<script>
	setInterval(() => {
		var t = new Date();
		let options = {
			year: 'numeric',
			month: 'numeric',
			day: 'numeric',
			hour: 'numeric',
			minute: 'numeric',
			second: 'numeric',
			hour12: false
		};
		t = new Intl.DateTimeFormat('sv', options).format(t);
		document.getElementById('time').innerHTML = t;
	}, 1000);
</script>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1C1C1C;">
	<a class="navbar-brand" href="/"><img class="img-responsive d-inline-block align-text-top" src="/_assets/_img/logo.png" alt="Logo" width="160" height="90"></a>
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNavDropdown">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="/hacks">ROM Hacks </a>
			</li> 
			<li class="nav-item">
				<a class="nav-link" href="/megapack">Megapack</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					Events
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="/events/league2023">League 2023 </a></li>
					<li><a class="dropdown-item" href="/events/ssrm2023">SSRM2023</a></li>
					<li><a class="dropdown-item" href="/events/wsrm2023">WSRM2023</a></li>
					<li><a class="dropdown-item" href="/events/league2022">League 2022</a></li>
					<li><a class="dropdown-item" href="/events/ssrm2022">SSRM2022</a></li>
					<li><a class="dropdown-item" href="/events/wsrm2022">WSRM2022</a></li>
					<li><a class="dropdown-item" href="/events/ssrm2021">SSRM2021</a></li>
					<li><a class="dropdown-item" href="/events/wsrm2021">WSRM2021</a></li>
					<li><a class="dropdown-item" href="/events/ssrm2020">SSRM2020</a></li>
				</ul>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					Gameplay Tools
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="/codes">Codes </a></li>
					<li><a class="dropdown-item" href="/stardisplay">Star Display</a></li>
					<li><a class="dropdown-item" href="/patcher">Online Patcher</a></li>
					<li><a class="dropdown-item" href="/plugins">Plugin Guide</a></li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/faq">FAQ</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="http://discord.sm64romhacks.com">Discord</a>
			</li>
<li class="nav-item">
	<a class="nav-link" href="https://ko-fi.com/marvjungs">Support!</a>
</li>
	<?php if(!filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN)) { ?>    
		<li class="nav-item"><a href="/login" class="nav-link" title="By logging in you agree with our Terms of Service">Login</a></li>
	<?php }?>
	<?php if(filter_var($_COOKIE['logged_in'], FILTER_VALIDATE_BOOLEAN)) { 
		if(in_array($_COOKIE['discord_id'], ADMIN_SITE)) {
			$available_actions = "&nbsp;<span class=\"badge badge-light\">" . sizeof(getAllPendingHacksFromDatabase($pdo)) . "</span>";
		}
		else {
			$available_actions = "&nbsp;";
		}
		?>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				<img src="<?php echo $avatar_url;?>" width=16 height=16 />&nbsp;<?php echo $_COOKIE['global_name'] . $available_actions;?>
				</a>
				<ul class="dropdown-menu">
					<?php if(in_array($_COOKIE['discord_id'], ADMIN_SITE)) { ?>
						<li><a class="dropdown-item" href="/admin">Admin Page</a></li>
						<li><a class="dropdown-item" href="/users">Users</a></li> <?php } ?>
				<li><a class="dropdown-item" href="/users/<?php print($_COOKIE['discord_id']);?>">Profile</a></li>
				<hr/>
				<li><a class="dropdown-item" href="/login/logout.php">Logout</a></li>
				<li><a class="dropdown-item text-danger" href="/login/deleteAccount.php">Delete Account</a></li>
				</ul></li><?php } ?>
		</ul>
	</div>
</nav>

<p id ="time" align=right style="height:22.5px"></p>
