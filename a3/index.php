<?PHP
    /*
	 * Assignment 2 - By Adam Mutimer (s3875753)
	 * 	https://github.com/AdamM-AU
	 *
	*/

	// Its good practice to set the timezone when using date functions, also prevents php warnings - Adam Mutimer
	date_default_timezone_set("Australia/Melbourne");

	require_once('tools.php'); // Special Functions - Adam Mutimer
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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="script.js"></script>

		<script>
		$(document).ready(function(){
			$("#navbar a").click(function(e) {
				e.preventDefault();
				$('html, body').animate({
					scrollTop: $($.attr(this, 'href')).offset().top - $("#navbar").height()
				}, 0);
			});
		});
		</script>

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

		<nav id="nav">
			<ul id="navbar">
				<li><a id="home" href="#home">Home</a></li>
				<li><a href="#seats-prices">Seats &amp; Prices</a></li>
				<li><a href="#now-showing">Now Showing</a></li>
			</ul>
		</nav>

		<main>
			<section class="home" id="home">
				<div class="container about-us">
					<h2>About Us</h2>
					<p>Thank you for choosing Lunardo Cinema’s after extensive remodelling and improvements to our facilities, we have now re-opened our doors
						and are able to provide our customers with first-class reclinable seating and offer the latest in high-quality projection and sound system
						supporting 3D Dolby Vision and Dolby Atmos sound.
					</p>
					<p>Book now and join us for the cinema experience of a lifetime!</p>
					<img src="../../media/a2/Dolby.Vision.Logo.png">&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="../../media/a2/Dolby_Atmos_Logo.png">
				</div>
			</section>

			<section class="seats-prices" id="seats-prices">
				<div class="container center">
					<h2>Seats &amp; Prices</h2>
					<p>Lunardo Cinemas now has new First class and standard seating.<br />
						<img src="../../media/a2/first-class.png">&nbsp;
						<img src="../../media/a2/standard.png"><br />
					</p>
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
							$i = 0; // Row counter
							foreach ($data as $row) {
								echo "\n" . $baseIndent . "<tr>\n";
								echo $baseIndent . "\t<td>" . $row["Seat Type"] . "</td>\n";
								echo $baseIndent . "\t<td>" . $row["Normal Prices"] . "</td>\n";
								echo $baseIndent . "\t<td>" . $row["Discounted Prices"] . "</td>\n";
								echo $baseIndent . "</tr>\n";
								$i++; // Increment row counter
							}
						?>
					</table>
					<p class="italic">* Discounted prices apply for weekday afternoons and all day on Mondays.</p>
				</div>
			</section>

			<section class="now-showing" id="now-showing">
				<div class="container">
					<h2>Now Showing</h2>
						<div class="table-grid-movies">
						<?PHP
						// Populate Table with CSV data, Just because we can....
							$baseIndent = "\t\t\t\t\t\t";
							$data = loadCSVArray("movies.csv");

							// Loop Array and write each array row as a grid item
							foreach ($data as $row) {
								echo "\n" . $baseIndent . "<div class=\"grid-item\">\n";
								echo $baseIndent . "\t<div class=\"grid-item-inner\">\n";
								echo $baseIndent . "\t\t<div class=\"grid-item-front\">\n";

								echo "\t\t\t" . $baseIndent . "<table class=\"table-grid-movies-subtable\">\n";

								echo "\t\t\t\t" . $baseIndent . "<tr>\n";
								echo "\t\t\t\t" . $baseIndent . "\t<td colspan=\"2\" class=\"movie-title\">" . $row["Movie Title"] . "</td>\n";
								echo "\t\t\t\t" . $baseIndent . "</tr>\n";

								echo "\t\t\t\t" . $baseIndent . "<tr>\n";
								echo "\t\t\t\t" . $baseIndent . "\t<td rowspan=\"2\"><img class=\"movie-poster\" src=\"../../media/a2/" . $row["CoverImage"] . "\"></td>\n";
								echo "\t\t\t\t" . $baseIndent . "\t<td></td>\n";
								echo "\t\t\t\t" . $baseIndent . "</tr>\n";

								echo "\t\t\t\t" . $baseIndent . "<tr>\n";
								echo "\t\t\t\t" . $baseIndent . "\t<td colspan=\"2\">Rating: " . $row["Rating"] . "</td>\n";
								echo "\t\t\t\t" . $baseIndent . "</tr>\n";

								echo "\t\t\t" . $baseIndent . "</table>\n";

								echo $baseIndent . "\t\t</div>\n";

								echo $baseIndent . "\t\t<div class=\"grid-item-back\">\n";

								echo "<p>" . $row["Blip"] . "</p>";

								if (empty($row["Mon - Tue"])) {
									echo "Mon - Tue: No Sessions<br>";
								} else {
									echo "Mon - Tue: " . $row["Mon - Tue"] . "<br>";
								}

								if (empty($row["Wed - Fri"])) {
									echo "Wed - Fri: No Sessions<br>";
								} else {
									echo "Wed - Fri: ". $row["Wed - Fri"] . "<br>";
								}

								if (empty($row["Sat - Sun"])) {
									echo "Sat - Sun: No Sessions<br>";
								} else {
									echo "Sat - Sun: " . $row["Sat - Sun"] . "<br>";
								}

								echo "<br><a href=\"" . $row["IMDB Link"] . "\" target=\"_blank\">IMDB: Movie Information</a>";
								echo "<br><a href=\"booking.php?code=" . $row["CODE"] . "\" target=\"_blank\">Book Now!</a>";

								echo $baseIndent . "\t\t</div>\n";

								echo $baseIndent . "\t</div>\n";
								echo $baseIndent . "</div>\n";
							}

						?>
					</div>
				</div>
			</section>
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

	</body>
</html>
