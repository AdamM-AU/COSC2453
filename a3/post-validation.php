<?php

// Didnt like the supplied function at all, made my own
function validateBooking() {
  require('tools.php'); // We need to borrow some things

  $errors = []; // new empty array to return error messages

   // Check Movie code...ZZZzzzzzzz
   if (empty($_POST(['movie'])) || checkMovieCode($_POST(['movie']))) {
     $errors['movie'] = "Invalid or Missing Movie Code!";
   }

   // Check booking details
   // day is valid, seat type and the price is valid
   // if day and seat type is valid...are they valid for the movie?

   // Check User Details 
   // name, email, mobile - using regex's :)

   // if we have errors return false, is no errors return true....
   if (errors.length > 0) {
     return false;
   } else {
     return true;
   }
}
?>
