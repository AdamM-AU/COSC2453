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
		<title>Lunardo Cinema's</title>
    
		<!-- Keep wireframe.css for debugging, add your css to style.css -->
		<link id='wireframecss' type="text/css" rel="stylesheet" href="../wireframe.css" disabled>
		<link id='stylecss' type="text/css" rel="stylesheet" href="style.css?t=<?PHP echo filemtime("style.css"); // BAD PRACTICE: Not all systems allow PHP Short Tags "<? =" - Adam Mutimer ?>">
		<script src='../wireframe.js'></script>
	</head>

	<body>

		<header>
			<div class="header-logo" id="header">
				<img class="logo-img" src="../../media/a2-logo.png">
			</div>
			<div class="header-text">
				<h1>Lunardo Cinema's</h1>
			</div>
		</header>

		<nav>
			<div>Put website navigation links here</div>
		</nav>

		<main>
			<section class="home" id="home">
				Shit user sees first
			</section>
			
			<section class="seats-prices" id="seats-prices">
				<h2>Seats &amp; Prices</h2>
				<table class="seats-prices-table">
					<tr>
						<th>Seats</th>
						<th>Price</th>
						<th>Discounted Price</th>
					</tr>
					<?PHP
					// Populate Table with CSV Data, Just for the heck of it...
						$baseIndent = "\t\t\t\t\t\t";
						$data = loadCSVArray("seatPricesTypes.csv");
						
						// Loop Array and write each row to the table
						foreach ($data as $row) {
							echo "\n" . $baseIndent . "<tr>\n";
							echo $baseIndent . "\t<td>$row[0]</td>\n";
							echo $baseIndent . "\t<td>$row[3]</td>\n";
							echo $baseIndent . "\t<td>$row[2]</td>\n";
							echo $baseIndent . "</tr>\n";
						}
					?>
				</table>
			</section>
			
			<section class="now-showing" id="now-showing">
			<h2>Now Showing</h2>
				<div class="table-grid-movies">
				<?PHP
				// Populate Table with CSV data, Just because we can....
					$baseIndent = "\t\t\t\t\t\t";
					$data = loadCSVArray("movies.csv");
					
					// Loop Array and write each array row as a grid item
					foreach ($data as $row) {
						echo "\n" . $baseIndent . "<div class=\"grid-item\">\n";

						echo "\t" . $baseIndent . "<table>\n";
						echo "\t\t" . $baseIndent . "<tr>\n";
						echo "\t\t\t" . $baseIndent . "\t<td colspan=\"2\" class=\"movie-title\">$row[0]</td>\n";
						echo "\t\t" . $baseIndent . "</tr>\n";
						echo "\t\t" . $baseIndent . "<tr>\n";
						echo "\t\t\t" . $baseIndent . "\t<td rowspan=\"2\"><img class=\"movie-poster\" src=\"../../media/a2/$row[7]\"></td>\n";
						echo "\t\t\t" . $baseIndent . "\t<td>Rating: $row[6]</td>\n";
						echo "\t\t" . $baseIndent . "</tr>\n";
						echo "\t\t" . $baseIndent . "<tr>\n";
						echo "\t\t\t" . $baseIndent . "\t<td colspan=\"2\"><a href=\"$row[5]\" target=\"_blank\">IMDB: Movie Information</a></td>\n";
						echo "\t\t" . $baseIndent . "</tr>\n";						
						echo "\t" . $baseIndent . "</table>\n";
						
						echo "\n" . $baseIndent . "</div>\n";
					}
				
				?>
				</div>
				Movies
				
			</section>
		</main>

		<footer>
			<div>Copytight&copy; <?PHP echo date("Y"); // Use Servers Year for copyright ?>
			<!--
				// THIS IS BAD PRACTICE TO RELY ON THE DATE ON THE CLIENTS MACHINE - Adam Mutimer
			<script>
				document.write(new Date().getFullYear()); <!-- PHP Alternative: 
			</script> 
			-->
			- Adam Mutimer (s3875753). Last modified <?= date ("Y F d  H:i", filemtime($_SERVER['SCRIPT_FILENAME'])); ?>.
			</div>
			<div>
				Disclaimer: This website is not a real website and is being developed as part of a School of Science Web Programming course at RMIT University in Melbourne, Australia.
			</div>
			<div>
				<button id='toggleWireframeCSS' onclick='toggleWireframe()'>Toggle Wireframe CSS</button>
			</div>
		</footer>
		
	</body>
</html>
