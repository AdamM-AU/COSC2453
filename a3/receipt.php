<pre>
<?PHP
require_once('tools.php'); // Special Functions - Adam Mutimer

if (!isset($_SESSION['myLastBookingID'])) {
  header("Location: index.php");
} else if (isset($_GET["error"])) {
  if (!isset($_SESSION['myLastBookingERROR'])) {
    header("Location: index.php");
  } else {
    print_r($_SESSION['myLastBookingERROR']);
  }
} else {

$booking = retrieveBooking($_SESSION['myLastBookingID']); // Booking is pulled back from the CSV file :D oh my god hahaha

echo "\n\n";
echo "Lunardo Cinema's\n";
echo "123 Smith Street,\nJohndoe, Victoria\n";
echo "Phone: (03) 1234 1234";
echo "\n\n";
echo "-------------------------------------------\n";
echo "Order Date: " . $booking['Order Date'] . "\n";
echo "Booking ID: " . $booking['BookingID'] . "\n";
echo "-------------------------------------------\n";

echo "Name: " . $booking['Name'] . "\n";
echo "Email: " . $booking['Email'] . "\n";
echo "Mobile: " . $booking['Mobile'] . "\n";
echo "-------------------------------------------\n\n";
echo "Session Time: " . $booking['Day of Movie'] . " @ " . $booking['Time of Movie'] ."\n";
echo "\n-----------------SEATING-------------------\n\n";
if ($booking['# STA'] > 0 ) {
  echo "Standard Adult: " . $booking['# STA'] . ' @  $' . number_format((float)$booking['$ STA'], 2, '.', '') . "/ea\n";
}

if ($booking['# STP'] > 0 ) {
  echo "Standard Concession: " . $booking['# STP'] . ' @  $' . number_format((float)$booking['$ STP'], 2, '.', '') . "/ea\n";
}

if ($booking['# STC'] > 0 ) {
  echo "Standard Child: " . $booking['# STC'] . ' @  $' . number_format((float)$booking['$ STC'], 2, '.', '') . "/ea\n";
}

if ($booking['# FCA'] > 0 ) {
  echo "First Class Adult: " . $booking['# FCA'] . ' @  $' . number_format((float)$booking['$ FCA'], 2, '.', '') . "/ea\n";
}

if ($booking['# FCP'] > 0 ) {
  echo "First Class Concession: " . $booking['# FCP'] . ' @  $' . number_format((float)$booking['$ FCP'], 2, '.', '') . "/ea\n";
}

if ($booking['# FCC'] > 0 ) {
  echo "First Class Child: " . $booking['# FCC'] . ' @  $' . number_format((float)$booking['$ FCC'], 2, '.', '') . "/ea\n";
}
echo "\n-------------------------------------------\n";
echo "Sub-Total: $" . number_format((float)$booking['Total'] - $booking['GST'], 2, '.', '') . "\n";
echo "GST: $" . number_format((float)$booking['GST'], 2, '.', '') . "\n";
echo "Total: $" . number_format((float)$booking['Total'], 2, '.', '') . "\n";
}
?>
</pre>
