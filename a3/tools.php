<?php
	session_start(); // Start a session

	/*	
	 *	My Projects Functions - By Adam Mutimer (s3875753)
	 *
	 *	Function Outline:
	 *		loadCSVArray( SRING filename ) 		- Opens a CSV and Reads it into an array and returns the array
	 *		checkMovieCode( STRING movieCode ) 	- Checks MovieCode against the movie csv, returns boolean true or false
	 *		getMovieByCode( STRING MovieCode ) 	- Returns an array containing only the requested movie
	 *		createBooking( ARRAY bookingData )	- Creates a booking in the booking spreadsheet, Returns BookingID
	 *		checkBooking( ARRAY bookingData )	- Checks spreadsheet for bookings matching (BookingID OR Email OR Name OR Mobile)
	 *		retrieveBooking ( INT bookingID ) 	- Returns array containing booking information
	 *
	 */

	// Open CSV and read into an array :)
	// ADAM: Amend code to support 2D Keyed Array
	function loadCSVArray( $filename ) {
		$csv = fopen($filename, 'r'); // Open file "read only"
		$headings = fgetcsv($csv, 1000, ','); // Fetch Headings
		
		while ( !feof($csv) ) { // Read $csv and check for "end of file (EOF)" until we get  "end of file (EOF)"
			$row = fgetcsv($csv, 1000, ','); // Read each line of CSV into array $csvRows[], accept no more than 1000 lines, comma delimited
			
			if (!empty($row[0]) && !is_null($row[0])) { // Skip empty/blank rows
				$csvRows[] = array_combine($headings, $row); // use headings as keys on level 2
			}
		}
		
		fclose ($csv); // Close the file/file pointer
		unset($csv); // Unload from memory, garbage collector will do it when it's ready
		unset($headings);
		
		return $csvRows; // Return the array to the calling module
	}

	// Return True if valid movie code or False if invalid
	function checkMovieCode($movieCode) {
		$array = loadCSVArray( "movies.csv" );
		
		foreach ($array as $row) {
			$movieCodes[] = $row[1];
		}
		unset($array); // Unload from memory, garbage collector will do it when it's ready
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
		unset($array); // Unload from memory, garbage collector will do it when it's ready
		return $movie;
	}

?>