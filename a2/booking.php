<?PHP
    /* 
	 * Assignment 2 - By Adam Mutimer (s3875753)
	 * 	https://github.com/AdamM-AU
	 *
	*/
	
	// Its good practice to set the timezone when using date functions, also prevents php warnings - Adam Mutimer
	date_default_timezone_set("Australia/Melbourne");
	
	require_once('functions.php'); // Special Functions - Adam Mutimer
?>
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Lunardo Cinema's - Bookings</title>
    
		<!-- Keep wireframe.css for debugging, add your css to style.css -->
		<link id='wireframecss' type="text/css" rel="stylesheet" href="../wireframe.css" disabled>
		<link id='stylecss' type="text/css" rel="stylesheet" href="style.css?t=<?PHP echo filemtime("style.css"); // BAD PRACTICE: Not all systems allow PHP Short Tags "<? =" - Adam Mutimer ?>">
		<script src='../wireframe.js'></script>
	</head>

	<body>
		<header>
			<div class="header-logo" id="home">
				<img class="logo-img" src="../../media/a2-logo.png">
			</div>
			<div class="header-text">
				<h1>Lunardo Cinema's</h1>
			</div>
		</header>

		<nav>
			<ul id="navbar">
				<li><a class="active" href="index.php">Home</a></li>
			</ul>
		</nav>

		<main>

			<section class="movie" id="movie">
				<div class="container">				
					<?PHP
					// Change Content based on 3 DIGIT code supplied in URL
					if ($validCode = checkMovieCode($_GET['code']) == TRUE) {
						$movie = getMovieByCode($_GET['code']);
						echo "<h1 class=\"center booking-movie-title\">$movie[0]</h1>\n";
						echo "\t\t\t\t\t" . "<h3 class=\"center\">Rating: $movie[6]</h3>\n";
						echo "\t\t\t\t\t" . '<iframe style="display:block;" width="560" height="315" src="' . $movie[8] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' . "\n";
						echo "\t\t\t\t\t" . "<p class=\"center\">$movie[9]</p>\n";						
						
					} else {
						echo "<h1 class=\"center\">ERROR: MOVIE CODE INVALID!</h1>";
					}
					?>
				</div>
			</section>
				<?PHP
					// If Valid Code display this html
					if ($validCode) {
				?>
			<section class="booking" id="booking">
				<div class="container">				
					// Booking Form
				</div>
			</section>					
				<?PHP
				}
				?>
				
		</main>
		
		<footer>
			<div class="table-grid-footer">
				<div class="grid-item">info@lunardo.com.au</div>
				<div class="grid-item">(03) 1234 1234</div>
				<div class="grid-item">123 Smith Street,
					<br>Johndoe, Victoria
				</div>
			</div>
			<hr>
			<div class="center">Copytight&copy; <?PHP echo date("Y"); // Use Servers Year for copyright ?>
			<!--
				// THIS IS BAD PRACTICE TO RELY ON THE DATE ON THE CLIENTS MACHINE - Adam Mutimer
			<script>
				document.write(new Date().getFullYear()); PHP Alternative: 
			</script> 
			-->
			- Adam Mutimer (s3875753). Last modified <?= date ("Y F d  H:i", filemtime($_SERVER['SCRIPT_FILENAME'])); ?>, <a href="https://github.com/AdamM-AU/wp" target="_blank">GitHub Repository</a>.
			</div>
			<div class="center">
				Disclaimer: This website is not a real website and is being developed as part of a School of Science Web Programming course at RMIT University in Melbourne, Australia.
			</div>
			<div class="center">
				<button id='toggleWireframeCSS' onclick='toggleWireframe()'>Toggle Wireframe CSS</button>
			</div>
		</footer>
		
		<aside id="debug">
			<hr>
			<h3>Debug Area</h3>
			<pre>
GET Contains:
<?php print_r($_GET) ?>
POST Contains:
<?php print_r($_POST) ?>
SESSION Contains:
<?php print_r($_SESSION) ?>
			</pre>
		</aside>

	</body>
</html>
