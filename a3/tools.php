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
		$array = loadCSVArray( "movies.txt" );

		foreach ($array as $row) {
			$movieCodes[] = $row["CODE"];
		}
		unset($array); // Unload from memory, garbage collector will do it when it's ready
		return in_array($movieCode, $movieCodes, false);
	}

	// Fetch movie by movie code
	function getMovieByCode($movieCode) {
		$array = loadCSVArray( "movies.txt" );

		foreach ($array as $row) {
			if ($row["CODE"] == $movieCode) {
				$movie = $row;
			}
		}
		unset($array); // Unload from memory, garbage collector will do it when it's ready
		return $movie;
	}

	// Creates a booking in the booking spreadsheet, Returns BookingID
	function createBooking($postData) {
		$file = 'booking.txt'; // File used to store bookings

		// Patch some postData
		if (!isset($postData['seats']['STA'])) { $postData['seats']['STA'] = 0;	}
		if (!isset($postData['seats']['STP'])) { $postData['seats']['STP'] = 0;	}
		if (!isset($postData['seats']['STC'])) { $postData['seats']['STC'] = 0;	}
		if (!isset($postData['seats']['FCA'])) { $postData['seats']['FCA'] = 0;	}
		if (!isset($postData['seats']['FCP'])) { $postData['seats']['FCP'] = 0;	}
		if (!isset($postData['seats']['FCC'])) { $postData['seats']['FCC'] = 0;	}


		$bookingData = [ date('Y/m/d'),
										 sanitize($postData['user']['name']), // Customer Name
										 sanitize($postData['user']['email']), // Customer Email
										 sanitize($postData['user']['mobile']), // Customer Movile
										 sanitize($postData['movie']), // Movie Code
										 sanitize($postData['day']), // Day of Movie Booking
										 0, // Time of Movie Booking
										 sanitize($postData['seats']['STA']) ?: 0, // # of Seats  $name = $name ?: 'joe'
										 0, // $ of Seats
										 sanitize($postData['seats']['STP']) ?: 0, // # of Seats
										 0, // $ of Seats
										 sanitize($postData['seats']['STC']) ?: 0, // # of Seats
										 0, // $ of Seats
										 sanitize($postData['seats']['FCA']) ?: 0, // # of Seats
										 0, // $ of Seats
										 sanitize($postData['seats']['FCP']) ?: 0, // # of Seats
										 0, // $ of Seats
										 sanitize($postData['seats']['FCC']) ?: 0, // # of Seats
										 0, // $ of Seats
									 ];

		// Work out movie time
		$movieData = getMovieByCode(sanitize($_POST['movie']));
		if ($bookingData[5] == "MON" || $bookingData[5] == "TUE") {
			$bookingData[6] = $movieData['Mon - Tue'];
		} else if ($bookingData[5] == "WED" || $bookingData[5] == "THU" || $bookingData[5] == "FRI") {
			$bookingData[6] = $movieData['Wed - Fri'];
		} else if ($bookingData[5] == "SAT" || $bookingData[5] == "SUN") {
			$bookingData[6] = $movieData['Sat - Sun'];
		} else {
			$bookingData[6] = "ERROR!!!";
		}


		// Working out ticket costs
		$ticketPricing = array('STA' => array('discPrice' => 15.00, 'fullPrice' => 20.50),
													 'STP' => array('discPrice' => 13.50, 'fullPrice' => 18.00),
													 'STC' => array('discPrice' => 12.00, 'fullPrice' => 16.50),
													 'FCA' => array('discPrice' => 24.00, 'fullPrice' => 30.00),
													 'FCP' => array('discPrice' => 22.50, 'fullPrice' => 27.00),
													 'FCC' => array('discPrice' => 21.00, 'fullPrice' => 24.00),
												 );

		$arrayKeys = array_keys($ticketPricing); // Array keys :)
		$ticketPrices = [];
		if ($bookingData[5] == "MON" || $bookingData[5] == "TUE" || $bookingData[5] == "WED" || $bookingData[5] == "THU" || $bookingData[5] == "FRI") {
			foreach($arrayKeys as $key) {
				array_push($ticketPrices, $ticketPricing[$key]['discPrice']);
			}
		} else {
			foreach($arrayKeys as $key) {
				array_push($ticketPrices, $ticketPricing[$key]['fullPrice']);
			}
		}
		// Populate Prices
		$bookingData[8]  = $ticketPrices[0]; // STA Price
		$bookingData[10] = $ticketPrices[1]; // STP Price
		$bookingData[12] = $ticketPrices[2]; // STC Price
		$bookingData[14] = $ticketPrices[3]; // FCA Price
		$bookingData[16] = $ticketPrices[4]; // FCP Price
		$bookingData[18] = $ticketPrices[5]; // FCC Price


		// Calculate Totals and Taxes
		$receiptArray["STA"] = Array( "Seats" => $bookingData[7], "Price" => $bookingData[8], "SubTotal" => ($bookingData[8] * $bookingData[7]));
		$receiptArray["STP"] = Array( "Seats" => $bookingData[9], "Price" => $bookingData[10], "SubTotal" => ($bookingData[10] * $bookingData[9]));
		$receiptArray["STC"] = Array( "Seats" => $bookingData[11], "Price" => $bookingData[12], "SubTotal" => ($bookingData[12] * $bookingData[11]));
		$receiptArray["FCA"] = Array( "Seats" => $bookingData[13], "Price" => $bookingData[14], "SubTotal" => ($bookingData[14] * $bookingData[13]));
		$receiptArray["FCP"] = Array( "Seats" => $bookingData[15], "Price" => $bookingData[16], "SubTotal" => ($bookingData[16] * $bookingData[15]));
		$receiptArray["FCC"] = Array( "Seats" => $bookingData[17], "Price" => $bookingData[18], "SubTotal" => ($bookingData[18] * $bookingData[17]));

		// Calc Total
		$subTotal = 0;
		foreach ($receiptArray as $item) {
			$subTotal = $subTotal + $item["SubTotal"];
		}
		$receiptArray["Total"] = $subTotal;

		// Calc GST (Inclusive GST)
		$taxRate = 10; // 10% GST
		$receiptArray["GST"] = ($taxRate * $receiptArray["Total"]/100);

		// Update bookingData - We could assume the JS was not tampered with.. but lets not assume anything
		$bookingData[19] = $receiptArray["Total"];
		$bookingData[20] = $receiptArray["GST"];

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

	function sanitize($string) {
		return htmlspecialchars($string);
	}
?>
