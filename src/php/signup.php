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
    <title>Sign Up</title>
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
      <div
        class="w-full lg:w-2/3 xl:w-2/5 flex flex-col justify-center bg-white"
      >
        <!-- Minimum width added -->
        <div class="mx-auto w-full max-w-xl px-6 lg:px-8 mt-5">
          <div class="logo-signin">
            <a href="login.php">
              <img
                class="mx-auto"
                src="../images/HCMC-blue.png"
                alt="Your Company"
              />
            </a>
          </div>
          <h2 class="mt-3 text-center text-3xl font-extrabold text-gray-900">
            Sign Up
          </h2>
          <div class="mt-4">
            <div class="form-box mb-5 py-4 px-4 sm:rounded-lg sm:px-10">
              <form id="signUp" class="space-y-6"  >
                <!-- First Name & Middle Initial -->
                <div class="grid grid-cols-2 gap-4">
                  <div class="login-form">
                    <label
                      for="first-name"
                      class="block font-medium text-black"
                    >
                      First Name
                    </label>
                    <input
                      id="first-name"
                      name="first_name"
                      type="text"
                      autocomplete="off"
                      required
                      placeholder="First Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm bg-white text-black"
                    />
                  </div>

                  <div class="login-form">
                    <label
                      for="middle-name"
                      class="block font-medium text-black"
                    >
                      Middle Name
                    </label>
                    <input
                      id="middle-name"
                      name="middle_name"
                      type="text"
                      autocomplete="off"
                      required
                      placeholder="Middle Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm bg-white text-black"
                    />
                  </div>
                </div>

                <!-- Last Name & Contact Number -->
                <div class="grid grid-cols-2 gap-4">
                  <div class="login-form">
                    <label for="last-name" class="block font-medium text-black">
                      Last Name
                    </label>
                    <input
                      id="last-name"
                      name="last_name"
                      type="text"
                      autocomplete="off"
                      required
                      placeholder="Last Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm bg-white text-black"
                    />
                  </div>

                  <div class="login-form">
                    <label
                      for="contact-number"
                      class="block font-medium text-black"
                    >
                      Contact Number
                    </label>
                    <input
                      id="contact-number"
                      name="contact_number"
                      type="tel"
                      required
                      autocomplete="off"
                      placeholder="Contact Number"
                      pattern="[0-9]{1,11}"
                      minlength="11"
                      maxlength="11"
                      title="Please enter up to 11 numeric characters."
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm bg-white text-black"
                    />
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="login-form">
                    <label for="dob" class="block font-medium text-black">
                      Date of Birth
                    </label>
                    <input
                      id="dob"
                      name="dob"
                      type="date"
                      required
                      class="input input-bordered [color-scheme:light] appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm bg-white text-black"
                    />
                  </div>

                  <div class="login-form">
                    <label for="sex" class="block font-medium text-black">
                      Sex
                    </label>
                    <select
                      id="sex"
                      name="sex"
                      required
                      class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white text-black"
                    >
                      <option value="">Select...</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                  </div>
                </div>

                <div class="grid grid-cols-1">
                  <div class="login-form">
                    <label for="address" class="block font-medium text-black">
                      Address
                    </label>
                    <input
                      id="address"
                      name="address"
                      type="text"
                      required
                      autocomplete="off"
                      placeholder="Address"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm bg-white text-black"
                    />
                  </div>
                </div>

                <!-- Email -->
                <div class="login-form">
                  <label for="email" class="block font-medium text-black">
                    Email
                  </label>
                  <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    placeholder="Email"
                    class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm bg-white text-black"
                  />
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 gap-4">
                  <div class="login-form">
                    <label for="password" class="block font-medium text-black"
                      >Password</label
                    >
                    <div class="relative">
                      <input
                        id="password"
                        type="password"
                        required
                        name="password"
                        autocomplete="off"
                        placeholder="Password"
                        class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white text-black"
                      />
                      <button
                        type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                        onclick="togglePasswordVisibility('password', 'password-icon')"
                      >
                        <span id="password-icon" class="fas fa-eye"></span>
                      </button>
                    </div>
                  </div>

                  <div class="login-form">
                    <label
                      for="confirm-password"
                      class="block font-medium text-black"
                      >Confirm Password</label
                    >
                    <div class="relative">
                      <input
                        id="confirm-password"
                        type="password"
                        name="conf_password"
                        required
                        autocomplete="off"
                        placeholder="Confirm Password"
                        class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white text-black"
                      />
                      <button
                        type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                        onclick="togglePasswordVisibility('confirm-password', 'confirm-password-icon')"
                      >
                        <span
                          id="confirm-password-icon"
                          class="fas fa-eye"
                        ></span>
                      </button>
                    </div>
                  </div>

                  <ul class="requirement-list">
                    <li>
                      <i class="fa-solid fa-circle"></i> At least 8 characters
                    </li>
                    <li>
                      <i class="fa-solid fa-circle"></i> At least one digit
                    </li>
                    <li>
                      <i class="fa-solid fa-circle"></i> At least one UPPERCASE
                      letter
                    </li>
                    <li>
                      <i class="fa-solid fa-circle"></i> No special characters
                    </li>
                  </ul>
                </div>
                <input type='hidden' value='patient' name='type'>
                <!-- Sign Up Button -->
                <div class="signup-btn">
                  <input
                    type="submit"
                    value="Sign Up"
                    required
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 mb-3"
                  />
                </div>
              </form>
              <p class="text-center text-black">
                Already have an Account?
                <a href="login.php" class="underline text-blue-700 font-bold"
                  >Sign In.</a
                >
              </p>
            </div>
          </div>

          <!-- eto notif pag nacreate account  -->

          <!-- eto notif pag nacreate account  -->
          <dialog id='notif' class='modal' onclick='toggleDialog("notif");' >
            <div class="flex justify-center" >
              <div role="alert" id='alert' class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
              <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span id='alert_text'>Account Created</span>
            </div>
            </div>
          </dialog>
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

    <script>
      function toggle_signUp_notif(notification_type){
        let notif_type = document.getElementById('alert');
        let notif_text = document.getElementById('alert_text');
        if (notification_type === 1){

          notif_type.classList.add('bg-success');
          notif_text.innerHTML = 'Account Created'
        }
        if (notification_type === 2 || notification_type === 3 || notification_type === 4){
          notif_type.classList.add('b-error');
          if (notification_type === 2){
            notif_text.innerHTML = 'Please Fill up the form';
          }else if (notification_type === 3){
            notif_text.innerHTML = 'Password do not match';
          }else{
            notif_text.innerHTML = 'Email already existing';
          }

        }


      }

      document.getElementById('signUp').addEventListener('submit', function(e){
        e.preventDefault();

        let form_data = new FormData(e.target)
        $.ajax({
          url: 'ajax.php?action=signup&type=patient',
          type: 'POST',
          data: form_data,
          processData: false,
          contentType: false,
          success: function(response) {
            if (parseInt(response) === 1) {
              toggle_signUp_notif(parseInt(response));
              toggleDialog('notif');
               setTimeout(function() {
              window.location.href = 'login.php';
            }, 2000);
          }
            } else {
              toggle_signUp_notif(parseInt(response));
              toggleDialog('notif');
            }
            e.target.reset();
          },
        })


      })

      function toggleDialog(id) {
        let dialog = document.getElementById(id);
        if (dialog) {
          if (dialog.hasAttribute('open')) {
            dialog.removeAttribute('open');
          } else {
            dialog.setAttribute('open', '');
          }
        }
      }

      document.addEventListener('DOMContentLoaded', function () {
        var inputDob = document.getElementById('dob');
        if (inputDob) {
          // Check if the element exists
          var today = new Date();
          var maxDate = today.toISOString().split('T')[0]; // format yyyy-mm-dd
          inputDob.max = maxDate;
        }
      });
    </script>
  </body>
</html>
