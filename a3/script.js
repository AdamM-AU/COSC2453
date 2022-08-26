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
  // Validate Name Field - Western Alphabet plus punctuation
  var nameRegex = /^[a-z ,.'-]+$/i;
  var nameField = document.getElementByID('name').value();
  var nameResult = nameRegex.test(nameField);
  // Do something based on boolean result

  // Validate Mobile Field - Starts with 04 must contain 10 digits and optional spaces
  var mobileRegex = /^04(\s?[0-9]{2}\s?)([0-9]{3}\s?[0-9]{3}|[0-9]{2}\s?[0-9]{2}\s?[0-9]{2})$/;
  var mobileField = document.getElementByID('mobile').value();
  var mobileResult = mobileRegex.test(mobileField);
  // Do Something with result

}
