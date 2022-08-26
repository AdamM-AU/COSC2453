<?PHP
    /*
	 * Assignment 2 - By Adam Mutimer (s3875753)
	 * 	https://github.com/AdamM-AU
	 *
	*/

	// Its good practice to set the timezone when using date functions, also prevents php warnings - Adam Mutimer
	date_default_timezone_set("Australia/Melbourne");

	require_once('tools.php'); // Special Functions - Adam Mutimer
	require_once('post-validation.php'); // Special Functions - Adam Mutimer

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$valid = validateBooking();
		if (!$valid) {
			// Naughty People are visiting!
			header("Location: index.php");
		} else {
			createBooking($_POST);
		}
	}

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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="script.js"></script>

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
				<div class="container center">
					<?PHP
					// Change Content based on 3 DIGIT code supplied in URL
					$movieCode = htmlspecialchars($_GET['code']); // Sanitize

					if ($validCode = checkMovieCode($movieCode) == TRUE) {
						$movie = getMovieByCode($movieCode);
						echo "<h1 class=\"center booking-movie-title\">" . $movie["Movie Title"] . "</h1>\n";
						echo "\t\t\t\t\t" . "<h3>Rating: " . $movie["Rating"] . "</h3>\n";
						echo "\t\t\t\t\t" . '<iframe style="display:block;" width="560" height="315" src="' . $movie["Trailer"] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' . "\n";
						echo "\t\t\t\t\t" . "<p>" . $movie["Blip"] . "</p><br>\n";
						echo "\t\t\t\t\t" . "<h3>The Cast:</h3>\n";
						echo "\t\t\t\t\t" . "<p>" . $movie["Actors"] . "</p><br>\n";

					} else {
						echo "<h1 class=\"center\">ERROR: MOVIE CODE INVALID!</h1>";
						header("Location: index.php");
					}
					?>
				<?PHP
					// If Valid Code display this html
					if ($validCode) {
				?>
					<h2>Booking Information</h2>
					<table class="booking-table">
					<form id="booking" name="booking" method="post" action="" onsubmit="return validateForm()">
						<input type="hidden" name="movie" value="<?PHP echo $movieCode; ?>" readonly>
						<tr>
							<td><label class = 'booking-label' for='STA'>Standard Adult</label></td>
							<td>
								<select id="STA" name="seats[STA]" data-full="20.50" data-disc="15.00" onchange='runningPriceCalculator()'>
									<option disabled selected>Select Required Tickets</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</td>
						</tr>

						<tr>
							<td><label class="booking-label" for="STP">Standard Concession</label></td>
							<td>
								<select id="STP" name="seats[STP]" data-full="18.00" data-disc="13.50" onchange='runningPriceCalculator()'>
									<option disabled selected>Select Required Tickets</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</td>
						</tr>

						<tr>
							<td><label class="booking-label" for="STC">Standard Child</label></td>
							<td>
								<select id="STC" name="seats[STC]" data-full="16.50" data-disc="12.00" onchange='runningPriceCalculator()'>
									<option disabled selected>Select Required Tickets</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</td>
						</tr>

						<tr>
							<td><label class="booking-label" for="FCA">First Class Adult</label></td>
							<td>
								<select id="FCA" name="seats[FCA]" data-full="30.00" data-disc="24.00" onchange='runningPriceCalculator()'>
									<option disabled selected>Select Required Tickets</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</td>
						</tr>

						<tr>
							<td><label class="booking-label" for="FCP">First Class Concession</label></td>
							<td>
								<select id="FCP" name="seats[FCP]" data-full="27.00" data-disc="22.50" onchange='runningPriceCalculator()'>
									<option disabled selected>Select Required Tickets</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</td>
						</tr>

						<tr>
							<td><label class="booking-label" for="FCC">First Class Child</label></td>
							<td>
								<select id="FCC" name="seats[FCC]" data-full="24.00" data-disc="21.00" onchange='runningPriceCalculator()'>
									<option disabled selected>Select Required Tickets</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</td>
						</tr>
						</table>

						<hr>
						<h3>Day &amp; Time</h3>
						<?PHP
							// Monday & Tuesday
							if (!empty($movie["Mon - Tue"])) {
								echo "<span class=\"radio-btn\">";
								echo "\t<input type=\"radio\" id=\"MON\" name=\"day\" value=\"MON\" data-pricing=\"discprice\" onchange='runningPriceCalculator()'>";
								echo "\t<label for=\"MON\">Monday: " . $movie["Mon - Tue"] . "</label>";
								echo "</span>";

								echo "<span class=\"radio-btn\">";
								echo "\t<input type=\"radio\" id=\"TUE\" name=\"day\" value=\"TUE\" data-pricing=\"discprice\" onchange='runningPriceCalculator()'>";
								echo "\t<label for=\"TUE\">Tuesday: " . $movie["Mon - Tue"] . "</label>";
								echo "</span>";
							}

							// Wednesday - Friday
							if (!empty($movie["Wed - Fri"])) {
								echo "<span class=\"radio-btn\">";
								echo "\t<input type=\"radio\" id=\"WED\" name=\"day\" value=\"WED\" data-pricing=\"discprice\" onchange='runningPriceCalculator()'>";
								echo "\t<label for=\"WED\">Wednesday: " . $movie["Wed - Fri"] . "</label>";
								echo "</span>";

								echo "<span class=\"radio-btn\">";
								echo "\t<input type=\"radio\" id=\"THU\" name=\"day\" value=\"THU\" data-pricing=\"discprice\" onchange='runningPriceCalculator()'>";
								echo "\t<label for=\"THU\">Thursday: " . $movie["Wed - Fri"] . "</label>";
								echo "</span>";

								echo "<span class=\"radio-btn\">";
								echo "\t<input type=\"radio\" id=\"FRI\" name=\"day\" value=\"FRI\" data-pricing=\"discprice\" onchange='runningPriceCalculator()'>";
								echo "\t<label for=\"FRI\">Friday: " . $movie["Wed - Fri"] . "</label>";
								echo "</span>";
							}

							// Saturday & Sunday
							if (!empty($movie["Sat - Sun"])) {
								echo "<span class=\"radio-btn\">";
								echo "\t<input type=\"radio\" id=\"SAT\" name=\"day\" value=\"SAT\" data-pricing=\"fullprice\" onchange='runningPriceCalculator()'>";
								echo "\t<label for=\"SAT\">Saturday: " . $movie["Sat - Sun"] . "</label>";
								echo "</span>";

								echo "<span class=\"radio-btn\">";
								echo "\t<input type=\"radio\" id=\"SUN\" name=\"day\" value=\"SUN\" data-pricing=\"fullprice\" onchange='runningPriceCalculator()'>";
								echo "\t<label for=\"SUN\">Sunday: " . $movie["Sat - Sun"] . "</label>";
								echo "</span>";
							}

						?>
						<br>
						<br>
						<span class="runningTotal" id="runningTotal"></span><span class="runningTotal" id="runningPriceCalculator"></span>
						<br>
						<br>
						<hr>

						<h3>Your Details</h3>
						<label class="booking-label" for="name">Full Name:</label><br>
						<input type="text" id="name" name="user[name]" placeholder="John Snow" required>
						<span id="name-error" class="validation-error"></span><br>

						<label class="booklabel" for="email">Email:</label><br>
						<input type="email" id="email" name="user[email]email" placeholder="YOU@SOMEWHERE.COM" required><br>

						<label class="booklabel" for="mobile">Mobile Number:</label><br>
						<input type="tel" id="mobile" name="user[mobile]"  placeholder="04XXXXXXXX" required>
						<span id="mobile-error" class="validation-error"></span><br>

						<br>
						<br>
						<button id="submit" class="btn btn-primary" type="submit">Create Booking</button
					</form>
				<?PHP
				}
				?>

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
