/* Insert your javascript here */
// Scroll Spy: Copied from https://www.youtube.com/watch?v=DOTdvy9flyA (Trevor Reynolds)
// Modified by Adam Mutimer - to work a little better

window.onscroll = function () {
    // console.clear();
    // console.log("win y:" + window.scrollY);

    var navlinks = document.getElementsByTagName('nav')[0].getElementsByTagName('a');
    var sections = document.getElementsByTagName('main')[0].getElementsByTagName('section');
    var navbar = document.getElementsByTagName('nav'); // We need to take in to account the sticky navbar...

    for (var a = 0; a < sections.length; a++) {
        var arTop = parseInt(sections[a].offsetTop) - parseInt((navbar[0].offsetHeight * 2));
        var arBot = sections[a].offsetTop + sections[a].offsetHeight - parseInt(navbar[0].offsetHeight * 2);

        if (window.scrollY >= arTop && window.scrollY < arBot) {
            console.log(2);
            navlinks[a].parentElement.classList.add('active');

        } else {
            navlinks[a].parentElement.classList.remove('active');
        }
    }
}

function validateForm() {
  // Dirty but simple JS form Validation :)
  // By Adam Mutimer

  var errorCount = 0; // error counter, so we can return to the form after we have validated all the fields per run

  // Validate Name Field - Western Alphabet plus punctuation
  var nameRegex = /^[a-z ,.'-]+$/i; // Regex :)
  var nameField = document.getElementById('name').value; // Grab Form Field
  var nameResult = nameRegex.test(nameField); // test form field against regex

  if (nameResult == false) {
    document.getElementById('name-error').innerHTML = "<br />Invalid Name!"; // This is an error field in the form empty by default
    errorCount++;
  } else {
    document.getElementById('name-error').innerHTML = ""; // Empty the error field if we have run a validation and failed before
  }

  // Validate Mobile Field - Starts with 04 must contain 10 digits and optional spaces
  var mobileRegex = /^04(\s?[0-9]{2}\s?)([0-9]{3}\s?[0-9]{3}|[0-9]{2}\s?[0-9]{2}\s?[0-9]{2})$/;
  var mobileField = document.getElementById('mobile').value;
  var mobileResult = mobileRegex.test(mobileField);

  if (mobileResult == false) {
    document.getElementById('mobile-error').innerHTML = "<br />Invalid Mobile!";
    errorCount++;
  } else {
    document.getElementById('mobile-error').innerHTML = "";
  }

  // As i said we checked all the fields, and updated the counter as required
  // now we can return a single true or false back to the form, now all Validation
  // tasks are completed.
  if (errorCount > 0) {
    console.log(errorCount);
    return false; // Stop form submission
  } else {
    console.log(errorCount)
    return true; // Allow form submission
  }
}

function runningPriceCalculator() {
  // Live Total Price Calaculator
  // By Adam Mutimer <--- I do this so people can "borrow parts of my work" and know they have to say where they got it from unless they are very naughty...
  var runningTotal = 0.00;

// Magical Code goes here but first im going to have a smoke

if (runningTotal > 0.00) {
  document.getElementById('runningTotal').innerHTML = "Total: ";
  document.getElementById('runningPriceCalculator').innerHTML = "$" + runningTotal.toFixed(2); // We only ever want two decimal places
}

}
