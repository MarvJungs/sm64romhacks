<?php
$runner_names = file("runner_names.txt");
$twitch_names = file("twitch_names.txt");
?>

<script>
	function getTwitchMap() {
		var twitch_names = <?php echo json_encode($twitch_names) ?>;
		var runner_names = <?php echo json_encode($runner_names) ?>;

		var map = new Map();
		for (var i = 0; i < twitch_names.length; i++) {
			var twitch_name = twitch_names[i].replace("\r\n", "");
			var runner_name = runner_names[i].replace("\r\n", "");
			map.set(runner_name, twitch_name);
		}
		return map;
	}
</script>
