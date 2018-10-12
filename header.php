<header>
	<div class="header-content">
		<div class="header-content-title">
			<h1 class="titel boven">sprekende</h1>
			<h1 class="titel onder">kwaliteiten</h1>
		</div>
	</div>
	<div id="header-menu">
		<button onclick="header_show()"
        		class="menu-toggle"
				id="menu-toggle">
			<svg height="30" width="40">
				<g>
				<rect x="4.5" y="3.5" width="30" height="3" style="fill:rgb(0,0,0);stroke-width:3;stroke:rgb(0,0,0)" />
  					<ellipse cx="2" cy="5" rx="2" ry="1.5" style="fill:BLACK;stroke:BLACK;stroke-width:2" />
  					<ellipse cx="35" cy="5" rx="2" ry="1.5" style="fill:BLACK;stroke:BLACK;stroke-width:2" />

					<rect x="4.5" y="13.5" width="30" height="3" style="fill:rgb(0,0,0);stroke-width:3;stroke:rgb(0,0,0)" />
  					<ellipse cx="2" cy="15" rx="2" ry="1.5" style="fill:BLACK;stroke:BLACK;stroke-width:2" />
  					<ellipse cx="35" cy="15" rx="2" ry="1.5" style="fill:BLACK;stroke:BLACK;stroke-width:2" />

					<rect x="4.5" y="23.5" width="30" height="3" style="fill:rgb(0,0,0);stroke-width:3;stroke:rgb(0,0,0)" />
  					<ellipse cx="2" cy="25" rx="2" ry="1.5" style="fill:BLACK;stroke:BLACK;stroke-width:2" />
  					<ellipse cx="35" cy="25" rx="2" ry="1.5" style="fill:BLACK;stroke:BLACK;stroke-width:2" />
				</g>
				Sorry, your browser does not support inline SVG.
			</svg>
		</button>
		<div class="headvorm" id="menuheader">
			<?php if (isset($spelvorm)) { ?>
				<a class="headvorm-lesser"
			   		style="display:block;">
					Spel: <?php echo $spelvorm ?>
				</a>
			<?php
			}
			if (!isset($no_back_to_start)) {
			?>
			<a class="headvorm-lesser"
			   style="display:block;"
			   href="<?php
			   if (isset($in_sub_folder)) {
				   echo "../";
			   } else {
				   echo "./";
			   }
			   ?>">
				Terug naar start
			</a>
			<?php } ?>
			<a class="headvorm-lesser"
			   style="display:block;">
				Help
			</a>
			<?php if (isset($name)) { ?>
				<a id="player__name"
			   		class="headvorm-lesser"
			   		style="display:block;">
					<?php echo $name ?>
				</a>
			<?php } ?>
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
