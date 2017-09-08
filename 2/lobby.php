<html>
	<head>
		<title>Speelvorm 2</title>
		<script src="api/js/std.js"></script>
		<script>
			window.setInterval(function(){
				start_update();
				if (game_info["game_started"] == true) {
					window.location.href = 'game.php';
				}
			}, 3000);
		</script>
	</head>
	<body>
		<div id="main">
			<p id="leader"></p>
			<ol id="player_list">
			</ol>
		</div>
	</body>
</html>
