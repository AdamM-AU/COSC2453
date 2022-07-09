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
	 *		* Maths Related Sub-Functions - Called via primary functions *
	 *		calcSubTotal( bookingData )
	 *		calcGST( subTotal )
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
			$movieCodes[] = $row["CODE"];
		}
		unset($array); // Unload from memory, garbage collector will do it when it's ready
		return in_array($movieCode, $movieCodes, false);
	}

	// Fetch movie by movie code
	function getMovieByCode($movieCode) {
		$array = loadCSVArray( "movies.csv" );
		
		foreach ($array as $row) {
			if ($row["CODE"] == $movieCode) {
				$movie = $row;
			}
		}
		unset($array); // Unload from memory, garbage collector will do it when it's ready
		return $movie;
	}
	
	// Creates a booking in the booking spreadsheet, Returns BookingID
	function createBooking($bookingData) {
		$file = 'booking.csv'; // File used to store bookings
		
		// Calculate Totals and Taxes
		$receiptArray["STA"] = Array( "Seats" => $bookingData[8], "Price" => $bookingData[9], "SubTotal" => ($bookingData[9] * $bookingData[8]));
		$receiptArray["STP"] = Array( "Seats" => $bookingData[10], "Price" => $bookingData[11], "SubTotal" => ($bookingData[11] * $bookingData[10]));
		$receiptArray["STC"] = Array( "Seats" => $bookingData[12], "Price" => $bookingData[13], "SubTotal" => ($bookingData[13] * $bookingData[12]));
		$receiptArray["FCA"] = Array( "Seats" => $bookingData[14], "Price" => $bookingData[15], "SubTotal" => ($bookingData[15] * $bookingData[14]));
		$receiptArray["FCP"] = Array( "Seats" => $bookingData[16], "Price" => $bookingData[17], "SubTotal" => ($bookingData[17] * $bookingData[16]));
		$receiptArray["FCC"] = Array( "Seats" => $bookingData[18], "Price" => $bookingData[19], "SubTotal" => ($bookingData[19] * $bookingData[18]));
		
		// Calc Total
		$subTotal = 0;
		foreach ($receiptArray as $item) {
			$subTotal = $subTotal + $item["SubTotal"];
		}
		$receiptArray["Total"] = $subTotal;
		
		// Calc GST (Inclusive GST)
		$taxRate = 10; // 10% GST
		$receiptArray["GST"] = ($taxRate * $receiptArray["GST"]/100);
		
		// Update bookingData - We could assume the JS was not tampered with.. but lets not assume anything
		$bookingData["Total"] = $receiptArray["Total"];
		$bookingData["GST"] = $receiptArray["GST"];
		
		$csv = fopen($file, 'a+'); // Open the csv file, for write/appened/if non existant create file + read
		
		// Lock the file so no one else can touch it
		if (flock($csv, LOCK_EX)) {
			// File is locked continue
			
			// Get last row id - with out going though the entire csv line by line
			$rows = file($file); // Even tho the file is locked we can still read it :)
			$lastEnt = array_pop($rows); // Pops the array and returns last array item
			$lastEntContent = str_getcsv($lastEnt); // Parse CSV string into an array
			$lastID = $lastEntContent[1];
			
			// The last ID.. Like Magic :D
			if (!is_numeric($lastID)) {
				// if the lastID is not a number or numeric string then its the column title...
				$newID = 0;
			} else {
				$lastID = intval($lastEntContent[1]);
				$newID = (int)$lastID + 1; // Increment the lastID to give us the newID for this booking
			}
			
			// Cleanup
			unset($rows);
			unset($lastEnt);
			unset($lastEntContent);
			unset($lastID);
		
			// Rebuild the array to add our booking id
			$i = 0; // index counter
			foreach ($bookingData as $item) {
				if ($i == 1) {
					$newBookingData[] = $newID;
					$newBookingData[] = $item;
					$i = $i + 2; // increment index counter by 2
				} else {
					$newBookingData[] = $item;
					$i++;
				}
			}
			
			// Open target file
			fputcsv($csv, $newBookingData, ","); // convert and push array in to csv, comma delimited
			fflush($csv);
			flock($csv,LOCK_UN); // Release the file lock
			
			fclose($csv); // Close file

			// Cleanup
			unset($i);
			unset($bookingData);
			unset($newBookingData);
			unset($csv);
			unset($file);
			
		} else {
			fclose($csv); // Close file
			// Couldnt lock file, return false so we can throw an error
			return false;
		}
		
		$_SESSION["myLastBookingID"] = $newID; // Set a session variable with the the users last bookingID
		return $newID;
	}
	
	function checkBooking() {
	
	}
	
	function retrieveBooking() {
	
	}
?>