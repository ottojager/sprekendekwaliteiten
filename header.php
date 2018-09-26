<header>
	<div class="header-content">
		<div class="header-content-logo">
			<img class="logo"
				 src="/sprekendekwaliteiten/afbeeldingen/logo-grote-schermen.png"
				 alt="logo">
		</div>
		<div class="header-content-title">
			<h1 class="titel boven">sprekende</h1>
			<h1 class="titel onder">kwaliteiten</h1>
		</div>
	</div>
	<div id="header-menu">
		<button onclick="header_show()"
        		class="menu-toggle"
				id="menu-toggle">
			<img src="http://reacursist.nl/dbconnect/wp-content/themes/dbconnect/../../uploads/2018/02/menu.png">
		</button>
		<div class="headvorm" id="menuheader"> 
			<a class="headvorm-lesser"
			   style="display:block;">
				Spel: Combi
			</a>
			<a class="headvorm-lesser"
			   style="display:block;"
			   href="./index.php">
				Terug naar start
			</a>
			<a class="headvorm-lesser"
			   style="display:block;">
				Help
			</a>
			<a class="headvorm-lesser"
			   style="display:block;">
				Naam speler
			</a>
		</div>
	</div>
	<script>
		var Header = document.getElementById("menuheader");
		function header_show(){
			Header.classList.add('zichtbaar');
			document.getElementById('menu-toggle').onclick = header_hide;
		}

		function header_hide(){
  			Header.classList.remove('zichtbaar');
			document.getElementById('menu-toggle').onclick = header_show;
		}
	</script>
</header>
