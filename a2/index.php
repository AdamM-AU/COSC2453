<?PHP
    /* 
	 * Assignment 2 - By Adam Mutimer (s3875753)
	 * 	https://github.com/AdamM-AU
	 *
	*/
	
	// Its good practice to set the timezone when using date functions, also prevents php warnings - Adam Mutimer
	date_default_timezone_set("Australia/Melbourne");
?>
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Assignment 2</title>
    
		<!-- Keep wireframe.css for debugging, add your css to style.css -->
		<link id='wireframecss' type="text/css" rel="stylesheet" href="../wireframe.css" disabled>
		<link id='stylecss' type="text/css" rel="stylesheet" href="style.css?t=<?PHP echo filemtime("style.css"); // BAD PRACTICE: Not all systems allow PHP Short Tags "<? =" - Adam Mutimer ?>">
		<script src='../wireframe.js'></script>
	</head>

	<body>

		<header>
			<div>Put company logo and name here</div>
		</header>

		<nav>
			<div>Put website navigation links here</div>
		</nav>

		<main>
			<article id='Website Under Construction'>
				<!-- Creative Commons image sourced from https://pixabay.com/en/maintenance-under-construction-2422173/ and used for educational purposes only -->
				<img src='../../media/website-under-construction.png' alt='Website Under Construction' />
			</article>
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
