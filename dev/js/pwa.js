// Initialize deferredPrompt for use later to show browser install prompt.
let deferredPrompt;

// window.addEventListener('beforeinstallprompt', (e) => {
//   // Prevent the mini-infobar from appearing on mobile
//   e.preventDefault();
//   // Stash the event so it can be triggered later.
//   deferredPrompt = e;
//   // Update UI notify the user they can install the PWA
//   showInstallPromotion();
//   // Optionally, send analytics event that PWA install promo was shown.
//   console.log(`'beforeinstallprompt' event was fired.`);
// });

// buttonInstall.addEventListener('click', async () => {
//   // Hide the app provided install promotion
//   hideInstallPromotion();
//   // Show the install prompt
//   deferredPrompt.prompt();
//   // Wait for the user to respond to the prompt
//   const { outcome } = await deferredPrompt.userChoice;
//   // Optionally, send analytics event with outcome of user choice
//   console.log(`User response to the install prompt: ${outcome}`);
//   // We've used the prompt, and can't use it again, throw it away
//   deferredPrompt = null;
// });

//https://web.dev/customize-install/#promote-installation
//https://stackoverflow.com/questions/61254435/pwa-prompt-for-add-to-home-screen-when-i-want
// const divInstall = document.getElementById("installContainer");
// const butInstall = document.getElementById("butInstall");

// /* Put code here */
// //step 1
// window.addEventListener('beforeinstallprompt', (event) => {
//   // Prevent the mini-infobar from appearing on mobile.
//   event.preventDefault();
//   console.log('👍', 'beforeinstallprompt', event);
//   // Stash the event so it can be triggered later.
//   window.deferredPrompt = event;
//   // Remove the 'hidden' class from the install button container.
//   divInstall.classList.toggle('hidden', false);
// });
// //step 2
// butInstall.addEventListener('click', async () => {
//   console.log('👍', 'butInstall-clicked');
//   const promptEvent = window.deferredPrompt;
//   if (!promptEvent) {
//     // The deferred prompt isn't available.
//     return;
//   }
//   // Show the install prompt.
//   promptEvent.prompt();
//   // Log the result
//   const result = await promptEvent.userChoice;
//   console.log('👍', 'userChoice', result);
//   // Reset the deferred prompt variable, since
//   // prompt() can only be called once.
//   window.deferredPrompt = null;
//   // Hide the install button.
//   divInstall.classList.toggle('hidden', true);
// });
// //step 3
// window.addEventListener('appinstalled', (event) => {
//   console.log('👍', 'appinstalled', event);
//   // Clear the deferredPrompt so it can be garbage collected
//   window.deferredPrompt = null;
// });

// /**
//  * Warn the page must be served over HTTPS
//  * The `beforeinstallprompt` event won't fire if the page is served over HTTP.
//  */
// if (window.location.protocol === "http:") {
//   const requireHTTPS = document.getElementById("requireHTTPS");
//   const link = requireHTTPS.querySelector("a");
//   link.href = window.location.href.replace("http://", "https://");
//   requireHTTPS.classList.remove("hidden");
// }

// /**
//  * Warn the page must not be served in an iframe.
//  */
// if (window.self !== window.top) {
//   const requireTopLevel = document.getElementById("requireTopLevel");
//   const link = requireTopLevel.querySelector("a");
//   link.href = window.location.href;
//   requireTopLevel.classList.remove("hidden");
// }
self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open('my-cache').then(function(cache) {
      return cache.addAll([
        '/',
        '/css/style.css',
        '/js/script.js'
      ]);
    })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request).then(function(response) {
      return response || fetch(event.request);
    })
  );
});

window.addEventListener('beforeinstallprompt', (event) => {
  // Prevent the default "Add to Home Screen" prompt
  event.preventDefault();

  // Save the event for later use
  deferredPrompt = event;

  // Automatically trigger the "Add to Home Screen" button display
  showAddToHomeScreenButton();
});

function showAddToHomeScreenButton() {
  const addToHomeScreenButton = document.getElementById('butInstall');

  if (addToHomeScreenButton) {
    addToHomeScreenButton.style.display = 'block';
    addToHomeScreenButton.addEventListener('click', addToHomeScreen);
  }
}

function addToHomeScreen() {
  // Show the native "Add to Home Screen" prompt
  deferredPrompt.prompt();

  // Wait for the user's response
  deferredPrompt.userChoice.then((choiceResult) => {
    if (choiceResult.outcome === 'accepted') {
      console.log('User added to home screen');
    } else {
      console.log('User dismissed the prompt');
    }

    // Reset the deferredPrompt variable
    deferredPrompt = null;
  });
}
