<script src="js/vendor/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="js/vendor/bootstrap.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
<script src="js/easing.min.js"></script>
<script src="js/hoverIntent.js"></script>
<script src="js/superfish.min.js"></script>
<script src="js/mn-accordion.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery.circlechart.js"></script>
<script src="js/mail-script.js"></script>
<script src="js/main.js"></script>
<script>
  // document.getElementById('nextTabBtn').addEventListener('click', function () {
  //   // Get the currently active tab
  //   var activeTab = document.querySelector('.nav-link.active');

  //   // Find the next tab
  //   var nextTab = activeTab.parentElement.nextElementSibling;
    
  //   if (nextTab) {
  //     // Activate the next tab
  //     nextTab.querySelector('a').click();
  //   } else {
  //     // If there is no next tab, you can loop back to the first tab
  //     document.querySelector('.nav-item:first-child a').click();
  //   }
  // });

    // Get all the buttons with the class 'my-button'  
    var buttons = document.getElementsByClassName('nxt');  
  
    // Loop over all the buttons and add an event listener to each one  
    for (var i = 0; i < buttons.length; i++) {  
      buttons[i].addEventListener('click', function() {  
        //alert('Button clicked!');  
        // Get the currently active tab
	    var activeTab = document.querySelector('.nav-link.active');

	    // Find the next tab
	    var nextTab = activeTab.parentElement.nextElementSibling;
	    
	    if (nextTab) {
	      // Activate the next tab
	      nextTab.querySelector('a').click();
	    } else {
	      // If there is no next tab, you can loop back to the first tab
	      document.querySelector('.nav-item:first-child a').click();
	    }
      });  
    }  
</script>  
</body>
</html>