<?php 
require("login_check.php"); 
?>

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
				id="menu-toggle"
				aria-haspopup="true"
				aria-controls="menuheader"
				aria-expanded="false"
				>
			<svg height="30" width="40">
				<g>
				<rect x="4.5" y="3.5" width="30" height="3"/>
  					<ellipse cx="2" cy="5" rx="2" ry="1.5"/>
  					<ellipse cx="35" cy="5" rx="2" ry="1.5"/>

					<rect x="4.5" y="13.5" width="30" height="3"/>
  					<ellipse cx="2" cy="15" rx="2" ry="1.5"/>
  					<ellipse cx="35" cy="15" rx="2" ry="1.5"/>

					<rect x="4.5" y="23.5" width="30" height="3"/>
  					<ellipse cx="2" cy="25" rx="2" ry="1.5"/>
  					<ellipse cx="35" cy="25" rx="2" ry="1.5"/>
				</g>
				Sorry, your browser does not support inline SVG.
			</svg>
		</button>
		<div class="headvorm"
			 id="menuheader"
			 role="menu"
			 aria-labelledby="menu-toggle"
			 >
			<?php if (isset($spelvorm)) { ?>
				<a class="headvorm-lesser"
			   		style="display:block;"
				   	role="menuitem">
					Spel: <?php echo $spelvorm ?>
				</a>
			<?php
			}
			if (!isset($no_back_to_start)) {
			?>
			<a class="headvorm-lesser"
			   style="display:block;"
			   role="menuitem"
			   href="<?php
			   if (isset($in_sub_folder)) {
				   echo "/../../";
			   } else {
				   echo "../";
			   }
			   ?>">
				Terug naar start
			</a>
			<?php } ?>
			<a class="headvorm-lesser"
			   style="display:block;"
			   role="menuitem">
				Help
			</a>
			<?php if (isset($name)) { ?>
				<a id="player__name"
			   		class="headvorm-lesser"
			   		style="display:block;"
				   	role="menuitem">
					<?php echo $name ?>
				</a>
			<?php } ?>
		</div>
	</div>
	<script>
		var Header = document.getElementById("menuheader");
		var menuToggler = document.getElementById('menu-toggle');
		function header_show(){
			Header.classList.add('zichtbaar');
			menuToggler.onclick = header_hide;
    		Header.setAttribute("aria-expanded", "true"); 
    		menuToggler.setAttribute("aria-expanded", "true"); 
		}

		function header_hide(){
  			Header.classList.remove('zichtbaar');
			menuToggler.onclick = header_show;
    		Header.setAttribute("aria-expanded", "false"); 
    		menuToggler.setAttribute("aria-expanded", "false"); 
		}
	</script>
</header>
