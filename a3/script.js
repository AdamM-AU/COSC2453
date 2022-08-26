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
  var counter = 0;

  //
  // -------------------------------------------
  // SEATING: Fetch form custom data attributes
  //
  var reqSeating = document.getElementsByTagName('select');
  var reqSeatingArr = [];

  while (counter < reqSeating.length) {
    // Fetch attributes - convert some to integers, other to float
    var seatType = reqSeating[counter].getAttribute('id');
    var fullPrice = parseFloat(reqSeating[counter].getAttribute('data-full'));
    var discPrice = parseFloat(reqSeating[counter].getAttribute('data-disc'));
    var seatCount = parseInt(reqSeating[counter].value);

    // Check seatCount to make sure its an int if not make it 0
    if (!Number.isInteger(seatCount)) {
      seatCount = 0;
    }

    // Only add to array if we need too...
    if (seatCount > 0) {
      var item = { seatType: seatType, data: { seatCount: seatCount, fullPrice: fullPrice, discPrice: discPrice} };
      reqSeatingArr.push(item);
    }
    counter++;
  }
  counter = 0; // Reset Counter
  console.log(reqSeatingArr);

  //
  // -------------------------------------------
  // DAY-TIME: Fetch form custom data attributes
  //
  var dayTime = document.querySelectorAll('input[name="day"]');
  var dayTimeArr = [];

  while (counter < dayTime.length) {
    var selected = dayTime[counter].checked;
    var day = dayTime[counter].value;
    var priceType = dayTime[counter].getAttribute('data-pricing');

    // Only add to array if item is checked
    if (selected) {
      item = { day: day, priceType: priceType };
      dayTimeArr.push(item);
    }
    counter++;
  }
  counter = 0;
  console.log(dayTimeArr);

  // Now the calculations begin... maybe.. if we have two arrays with data
  if (reqSeatingArr.length > 0 && dayTimeArr.length > 0) {

    // Loop though the days slected then loop though tickets
    for (let i = 0; i < dayTimeArr.length; i++) {
      for (let x = 0; x < reqSeatingArr.length; x++) {
        if (dayTimeArr[i].priceType == "discprice") {
          runningTotal = runningTotal + (reqSeatingArr[x].data.discPrice * reqSeatingArr[x].data.seatCount);
        } else {
          runningTotal = runningTotal + (reqSeatingArr[x].data.fullPrice * reqSeatingArr[x].data.seatCount);
        }
      }
    }
    // puke out the result
    if (runningTotal > 0.00) {
      document.getElementById('runningTotal').innerHTML = "Total: ";
      document.getElementById('runningPriceCalculator').innerHTML = "$" + runningTotal.toFixed(2); // We only ever want two decimal places
    }
  }
}
