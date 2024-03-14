// Initialize Firebase

  
  // Google Sign-In Provider
  const provider = new firebase.auth.GoogleAuthProvider();
  
  // Google Sign-In Button
  function renderGoogleSignInButton() {
    gapi.signin2.render('google-sign-in-button', {
      'scope': 'profile email',
      'width': 240,
      'height': 50,
      'longtitle': true,
      'theme': 'dark',
      'onsuccess': onSignIn,
      'onfailure': onFailure
    });
  }
  
  // Sign in with Google
  function onSignIn(googleUser) {
    const idToken = googleUser.getAuthResponse().id_token;
    const credential = firebase.auth.GoogleAuthProvider.credential(idToken);
  
    firebase.auth().signInWithCredential(credential)
      .then((result) => {
        // Successful sign-in
        const user = result.user;
        redirectToSuccessPage(user.email);
      })
      .catch((error) => {
        // Handle sign-in error
        console.error(error);
      });
  }
  
  // Sign-in failure
  function onFailure(error) {
    console.error(error);
  }
  
  // Redirect to success page
  function redirectToSuccessPage(email) {
    window.location.href = `success.html?email=${encodeURIComponent(email)}`;
  }
  
  // Render the Google Sign-In button
  window.onload = function() {
    gapi.load('auth2', function() {
      gapi.auth2.init().then(renderGoogleSignInButton);
    });
  }