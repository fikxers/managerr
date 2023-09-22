// Service worker registration
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/service-worker.js')
    .then(registration => {
      console.log('Service worker registered:', registration);
      checkForAppInstalled(registration);
    })
    .catch(error => {
      console.error('Error registering service worker:', error);
    });
}

// Check if the app is already installed
function checkForAppInstalled(registration) {
  window.addEventListener('beforeinstallprompt', event => {
    event.preventDefault(); // Prevent the default browser prompt
    const deferredPrompt = event;
    // Show your custom "Add to Home Screen" button or UI element
    //showAddToHomeScreenButton(deferredPrompt, registration);
    deferredPrompt.prompt();
    // Handle the user's choice
    deferredPrompt.userChoice.then(choiceResult => {
      if (choiceResult.outcome === 'accepted') {
        console.log('User accepted the Add to Home Screen prompt');
      } else {
        console.log('User dismissed the Add to Home Screen prompt');
      }
      // Reset the deferredPrompt variable
      deferredPrompt = null;
    });
  });
  // Track the user's choice
  window.addEventListener('appinstalled', () => {
    console.log('App installed by the user');
    // Perform any necessary actions after the app is installed
  });
}

// Show the "Add to Home Screen" button
function showAddToHomeScreenButton(deferredPrompt, registration) {
  const addToHomeScreenButton = document.getElementById('butInstall');

  addToHomeScreenButton.style.display = 'block';
  addToHomeScreenButton.addEventListener('click', () => {
    addToHomeScreenButton.style.display = 'none';
    deferredPrompt.prompt(); // Show the browser's add to home screen prompt

    deferredPrompt.userChoice.then(choiceResult => {
      if (choiceResult.outcome === 'accepted') {
        console.log('User accepted the add to home screen prompt');
      } else {
        console.log('User dismissed the add to home screen prompt');
      }
      deferredPrompt = null; // Reset the deferredPrompt variable
    });
  });

  // Track the user's choice
  window.addEventListener('appinstalled', () => {
    console.log('App installed by the user');
    // Perform any necessary actions after the app is installed
  });
}