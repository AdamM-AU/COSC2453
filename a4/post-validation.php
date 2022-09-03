<?php

// Didnt like the supplied function at all, made my own
function validateBooking() {
  $errors = []; // new empty array to return error messages

   if (empty($_POST['movie']) || !checkMovieCode(sanitize($_POST['movie']))) {
     $errors['movie'] = "Invalid or Missing Movie Code!";
     return false; // STOP HERE DONT EVEN BOTHER WITH ANYMORE CHECKS, THEY ARE CLEARLY DISHONEST!
   }

   // Check booking details
   $movieData = getMovieByCode(sanitize($_POST['movie']));
   $day = sanitize($_POST['day']);

   // Day of booking
   if ($day == "MON" || $day == "TUE") {
     if (empty($movieData['Mon - Tue'])) {
       $errors['day'] = "Invalid booking time/day for movie!";
     }
   } else if ($day == "WED" || $day == "THU" || $day == "FRI") {
     if (empty($movieData['Wed - Fri'])) {
       $errors['day'] = "Invalid booking time/day for movie!";
     }
   } else if ($day == "SAT" || $day == "SUN") {
     if (empty($movieData['Sat - Sun'])) {
       $errors['day'] = "Invalid booking time/day for movie!";
     }
   }

   // Check seats are valid
   $selectedSeating = $_POST['seats'];
   $arrayKeys = array_keys($selectedSeating);
   $validSeatCodes = [ "FCC", "FCP", "FCA", "STC", "STP", "STA"];
   $badSeatCount = 0;
   $badSeatNumCount = 0;

   foreach($arrayKeys as $key) {
    $seatType = $key;
   	$seatCount = $selectedSeating[$key];

    $validSeat = array_search($seatType, $validSeatCodes);
    if ($validSeat == false) {
      $badSeatCount++;
    }

    if ($seatCount < 1 && $seatCount > 10) {
      $badSeatNumCount++;
    }
   }

   if ($badSeatCount > 0) {
     $errors['seats']['type'] = "Invalid Seat Type!";
   }

   if ($badSeatNumCount > 0) {
     $errors['seats']['tickets'] = "Invalid Seat Tickets!";
   }
   // Check User Details
   $userName = sanitize($_POST['user']['name']);

   $userNameRegex = '/^[a-z ,.\'-]+$/i'; // Western Alphabet plus punctuation

   $userEmail = sanitize($_POST['user']['email']);
   $userEmailRegex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

   $userMobile = sanitize($_POST['user']['mobile']);
   $userMobileRegex = '/^04(\s?[0-9]{2}\s?)([0-9]{3}\s?[0-9]{3}|[0-9]{2}\s?[0-9]{2}\s?[0-9]{2})$/'; // Starts with 04 must contain 10 digits and optional spaces

   // NAME
   if (empty($userName)) {
     $errors['user']['name'] = "Name can't be empty";
   } else if (preg_match($userNameRegex, $userName) == false) {
     $errors['user']['name'] = "Name is invalid!";
   } else {
   }

   // EMAIL
   if (empty($userEmail)) {
     $errors['user']['email'] = "Email can't be empty";
   } else if (preg_match($userEmailRegex, $userEmail) == false) {
     $errors['user']['email'] = "Email is invalid!";
   } else {
   }

   // MOBILE
   if (empty($userMobile)) {
     $errors['user']['mobile'] = "Mobile can't be empty";
   } else if (preg_match($userMobileRegex, $userMobile) == false) {
     $errors['user']['mobile'] = "Mobile is invalid!";
   } else {
   }
   $_SESSION['errors'] = $errors;

   // if we have errors return false, is no errors return true....
   if (sizeof($errors,0) > 0) {
     return false;
   } else {
     return true;
   }
}
?>
