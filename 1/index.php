<html>
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
    </head>
    <body>
        <div>
        	<div id="slot1"></div>
        	<div id="slot2"></div>
        	<div id="slot3"></div>
        	<div id="slot4"></div>
        	<div id="slot5"></div>
        	<div id="slot6"></div>
        	<div id="slot7"></div>
        	<div id="slot8"></div>
		</div>
        <div id="current" aria-live="assertive" style="background-color:green;"></div>
		<button id="backButton" onclick="backButton(this)" style="background-color:lightblue;">terug</button>
        <div id="graveyard" style="background-color:red;">oude</div>
    </body>
</html>