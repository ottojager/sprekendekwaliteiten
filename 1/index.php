<html lang="nl=NL">
    <head>
        <script type="text/javascript">
            var cardStack = 
                <?php
                $db = mysqli_connect('localhost', 'root');
                mysqli_select_db($db, "kwaliteitenspel");
                $sql = "SELECT * FROM cards";
                $result = mysqli_query($db, $sql);
                $array = array();
                while ($card = mysqli_fetch_assoc($result)) {
                    $array[] = $card['name'];
                }
                echo json_encode($array);
                ?>
            ;   
        </script>
        <script type="text/javascript" src="singleplayer.js" defer></script>
        <link rel="stylesheet" href="stylesheet.css" type="text/css">
    </head>
    <body>
        <ul>
        	<li id="slot1"></li>
        	<li id="slot2"></li>
        	<li id="slot3"></li>
        	<li id="slot4"></li>
        	<li id="slot5"></li>
        	<li id="slot6"></li>
        	<li id="slot7"></li>
        	<li id="slot8"></li>
		</ul>
        <div id="current"></div>
		<button id="backButton" onclick="backButton(this)">terug</button>
        <div id="graveyard">oude</div>
    </body>
</html>