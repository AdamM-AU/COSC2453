<?PHP
require_once('tools.php');

$bookingData = Array("2022/07/09","Adam Mutimer","adam@techydata.com.au","0436007501","ACT","MON","9pm",1,"12.50",0,0,0,0,0,0,0,0,0,0,"12.50",1);

print_r(createBooking($bookingData));
?>