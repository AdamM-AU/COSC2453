<?PHP
	/*  
	 *	My A2 Functions 
	 *  By Adam Mutimer (s3875753)
	 */
	 
	 
// Open CSV and read into an array :)
function loadCSVArray( $filename ) {
	$csv = fopen($filename, 'r'); // Open file "read only"
	
	while ( !feof($csv) ) { // Read $csv and check for "end of file (EOF)" until we get  "end of file (EOF)"
		$row = fgetcsv($csv, 1000, ','); // Read each line of CSV into array $csvRows[], accept no more than 1000 lines, comma delimited
		
		if ($row[0] !== NULL) { // Skip empty/blank rows
			$csvRows[] = $row;
		}
	}
	
	fclose ($csv); // Close the file/file pointer
	return $csvRows; // Return the array to the calling module
}

// Return True if valid movie code or False if invalid
function checkMovieCode($movieCode) {
	$array = loadCSVArray( "movies.csv" );
	
	foreach ($array as $row) {
		$movieCodes[] = $row[1];
	}
	
	return in_array($movieCode, $movieCodes, false);
}

// Fetch movie by movie code
function getMovieByCode($movieCode) {
	$array = loadCSVArray( "movies.csv" );
	
	foreach ($array as $row) {
		if ($row[1] == $movieCode) {
			$movie = $row;
		}
	}
	return $movie;
}
?>