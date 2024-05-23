<?php
session_start();
if (isset($_SESSION['user_type'])) {
    header('Location: index.php');
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log In</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script
      src="https://kit.fontawesome.com/70df29d299.js"
      crossorigin="anonymous"
    ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" type="image/x-icon" href="../images/logosmall.png" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <script
      type="module"
      src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule=""
      src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"
    ></script>
    <script src="../js/login.js" defer></script>
  </head>
  <body>
    <section class="min-h-screen flex items-stretch">
      <!-- Form Section -->
      <div class="w-full lg:w-2/5 flex flex-col justify-center bg-white">
        <!-- Minimum width added -->
        <div class="mx-auto w-full max-w-3xl px-6 py-12 lg:px-8">
          <div class="logo-signin">
            <img
              class="mx-auto"
              src="../images/HCMC-blue.png"
              alt="Your Company"
            />
          </div>

          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Sign in
          </h2>
          <div class="mt-8">
            <div class="form-box py-8 px-4 sm:rounded-lg sm:px-10">
              <form id='login_form' class="space-y-6" >
                <div class="login-form">
                  <label
                    for="email"
                    class="block text-base font-medium text-gray-700"
                  >
                    Email Address
                  </label>
                  <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    placeholder="Email"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm bg-white text-black"
                  />
                </div>

                <div class="login-form relative">
                  <label
                    for="password"
                    class="block text-base font-medium text-gray-700"
                    >Password</label
                  >
                  <div class="relative">
                    <input
                      id="password"
                      name="password"
                      type="password"
                      autocomplete="current-password"
                      required
                      placeholder="Password"
                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white text-black"
                    />
                    <button
                      type="button"
                      class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                      onclick="togglePasswordVisibility('password', 'password-icon')"
                    >
                      <span id="password-icon" class="fas fa-eye"></span>
                    </button>
                  </div>
                  <div class="flex justify-end mt-2">
                    <a
                      href="forgot.html"
                      class="text-sm text-black hover:text-gray-800-"
                      >Forgot password?</a
                    >
                  </div>
                </div>

                <div class="signup-btn">
                  <button
                    type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 mb-3"
                  >
                    Sign in
                  </button>
                </div>
              </form>
              <p class="text-center text-sm text-black">
                Don't have an account yet?<br />
                <a
                  href='signup.php'
                  class="font-semibold leading-6 underline text-blue-700"
                  >Create account.</a
                >
              </p>


              <div id='login_alert' role="alert" class="alert alert-error mt-1 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Email doesn't exist</span>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- Image on the right -->
      <div
        class="lg:flex w-2/3 hidden bg-gray-500 bg-no-repeat bg-cover relative items-center text-white"
        style="background-image: url(../images/family\ medicine.png)"
      >
        <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
        <div class="w-full px-24 z-10">
          <h1 class="text-5xl font-bold text-left tracking-wide">
            Holistic Choice Multispecialty Clinic
          </h1>
          <p class="text-3xl my-4">
            Providing reliable Medical Services since 20--
          </p>
        </div>
        <div
          class="bottom-0 absolute p-4 text-center right-0 left-0 flex justify-center space-x-4 text-3xl"
        >
          <a
            href="https://www.facebook.com/HCMC.ONLINE"
            target="_blank"
            class="footer-link mr-2 text-current no-underline transform hover:scale-125 transition-transform duration-200"
          >
            <i class="fab fa-facebook-f"></i>
          </a>
          <a
            href="mailto:example@gmail.com"
            class="footer-link text-current no-underline transform hover:scale-125 transition-transform duration-200"
          >
            <i class="fas fa-envelope"></i>
          </a>
        </div>
      </div>
    </section>
  </body>
  <script>
    function toggleAlert(response) {
      // Select the alert container
      const alertContainer = document.getElementById('login_alert');

      // Select the alert message element
      const alertMessage = alertContainer.querySelector('span');

      // Remove the 'hidden' class from the alert container
      alertContainer.classList.remove('hidden');

      // Depending on the response, update the alert message
      if (response === 2) {
        // Set the alert message for incorrect password
        alertMessage.textContent = 'Incorrect Password';
      } else if (response === 3) {
        // Set the alert message for invalid email
        alertMessage.textContent = 'Invalid Email';
      }
    }

    document.getElementById('login_form').addEventListener('submit', function(e){
      e.preventDefault();
      let form_data = new FormData(e.target)
      $.ajax({
        url: 'ajax.php?action=login',
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        success: function(response) {
          console.log(response);
          if (response === '1') {
            window.location.href = 'index.php'; // Redirect to index.php
          } else if (response === '2') {
            toggleAlert(parseInt(response));
          } else if (response === '3') {
            toggleAlert(parseInt(response));
          } else {
            alert(response);
          }
          e.target.reset();
        },
      });
    });
  </script>
</html>
