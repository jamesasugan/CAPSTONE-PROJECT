<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Settings</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/profile.css">
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
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="../css/services-swiper.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/main.js" defer></script>
  </head>
  <body>

    <?php include 'navbar-main.php'; ?>

    <div class="flex flex-col sm:flex-row justify-center items-center">
    <div class="bg-white dark:bg-gray-800 p-5 w-full min-h-screen pt-10 sm:pt-20">
        <!-- Responsive Sidebar for profile settings -->
        <div class="flex flex-col sm:flex-row">
            <div class="w-full sm:w-80 p-5 border-b sm:border-b-0 sm:border-r mt-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mt-5 sm:mt-0">
                    Profile Settings
                </h2>
                <ul class="mt-5 text-lg sm:text-xl">
                    <li class="text-black dark:text-white font-semibold">
                        Personal Information
                    </li>
                    <li class="text-gray-600 dark:text-gray-400">
                        Security and Privacy
                    </li>
                    <li class="text-gray-600 dark:text-gray-400">
                        Appointment History
                    </li>
                </ul>
            </div>
          <!-- Main content area -->
          <div class="flex-1 p-10">
            <div class="bg-white dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-xl font-bold text-black dark:text-white mb-4">
                Personal Information
              </h3>
              <form id="personal-info" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  
                  <div class="form-group">
                    <label
                      for="first-name"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg overflow-hidden whitespace-nowrap text-overflow-ellipsis"
                      >First Name</label
                    >
                    <input
                      id="first-name"
                      name="first-name"
                      type="text"
                      value="James"
                      autocomplete="off"
                      required
                      disabled
                      placeholder="First Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-gray-200 dark:bg-gray-600 text-black disabled:bg-white disabled:text-gray-400 disabled:border-gray-300 whitespace-nowrap overflow-hidden text-ellipsis"
                      
                    />
                  </div>
                  <div class="form-group">
                    <label
                      for="middle-name"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis "
                      >Middle Name</label
                    >
                    <input
                      id="middle-name"
                      name="middle-name"
                      type="text"
                      value="Reid"
                      autocomplete="off"
                      required
                      disabled
                      placeholder="Middle Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-gray-200 dark:bg-gray-600 text-black disabled:bg-white disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                  <!-- Last Name & Contact Number -->
                  <div class="form-group">
                    <label
                      for="last-name"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                      >Last Name</label
                    >
                    <input
                      id="last-name"
                      name="last-name"
                      type="text"
                      value="Asugan"
                      autocomplete="off"
                      required
                      disabled
                      placeholder="Last Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-gray-200 dark:bg-gray-600 text-black disabled:bg-white disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                  <div class="form-group">
                    <label
                      for="contact-number"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                      >Contact Number</label
                    >
                    <input
                      id="contact-number"
                      name="contact-number"
                      type="tel"
                      value="05555555"
                      required
                      disabled
                      placeholder="Contact Number"
                      pattern="[0-9]{1,11}"
                      minlength="11"
                      maxlength="11"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-gray-200 dark:bg-gray-600 text-black disabled:bg-white disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                  <!-- Date of Birth, Sex -->
                  <div class="form-group">
                    <label
                      for="dob"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                      >Date of Birth</label
                    >
                    <input
                      id="dob"
                      name="dob"
                      type="date"
                      disabled
                      class="input input-bordered w-full p-2 text-xs sm:text-lg bg-gray-200 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white disabled:bg-white disabled:text-gray-400 disabled:border-gray-300"
                      required
                      
                    />
                  </div>
                  <div class="form-group">
                    <label
                      for="sex"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg"
                      >Sex</label
                    >
                    <select
                      id="sex"
                      name="sex"
                      class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-gray-200 dark:bg-gray-600 text-black disabled:bg-white disabled:text-gray-400 disabled:border-gray-300"
                      required
                      disabled
                    >
                      <option value="">Select...</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                  </div>
                  <!-- Address -->
                  <div class="form-group col-span-1 sm:col-span-">
                    <label
                      for="address"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg "
                      >Address</label
                    >
                    <input
                      id="address"
                      name="address"
                      type="text"
                      disabled
                      required
                      autocomplete="off"
                      placeholder="Address"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-gray-200 dark:bg-gray-600 text-black disabled:bg-white disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                  <!-- Email -->
                  <div class="form-group col-span-1 sm:col-span-">
                    <label
                      for="email"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg overflow-hidden whitespace-nowrap text-overflow-ellipsis"
                      >Email Address</label
                    >
                    <input
                      id="email"
                      name="email"
                      type="email"
                      disabled
                      autocomplete="email"
                      required
                      placeholder="Email"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-gray-200 dark:bg-gray-600 text-black disabled:bg-white disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                </div>
                <div class="flex justify-end space-x-2">
                        <button id="editButton" type="button" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7">
                            Edit
                        </button>
                        <input id="updateButton" type="submit" value="Update" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none hidden" onclick="toggleEdit(true)">               
                        <button id="cancelButton" type="button" class="btn bg-gray-300 text-black hover:bg-gray-400 border-none hidden" onclick="toggleEdit(false)">
                            Cancel
                        </button>
                    </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
