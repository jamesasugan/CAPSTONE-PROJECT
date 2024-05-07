<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accounts</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/staff.css" />
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

  <?php include 'admin-navbar.php'; ?>

    <div
      id="doctorAccounts"
      class="p-10 pt-24 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]"
    >

    <!-- add new doctor button -->
        <div class="flex justify-end mb-5">
            <a href="admin-addnewDoctor.php" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded cursor-pointer border-none">Add new Staff</a>
        </div>

      <div
        class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black"
      >
        <h3
          class="text-2xl sm:text-2xl md:text-4xl font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase"
        >
          Doctor Accounts
        </h3>
        <form action="#" method="POST" class="flex items-center">
          <input
            type="text"
            name="text"
            class="input input-bordered appearance-none w-full px-3 py-2 rounded-none bg-white dark:bg-gray-600 text-black dark:text-white border border-black border-r-0 dark:border-white"
            placeholder="Search"
          />
          <button
            type="submit"
            class="btn btn-square bg-gray-400 hover:bg-gray-500 rounded-none dark:bg-gray-500 dark:hover:bg-gray-300 border border-black border-l-0 dark:border-white"
          >
            <i
              class="fa-solid fa-magnifying-glass text-black dark:text-white"
            ></i>
          </button>
        </form>
      </div>

      <!-- Table Container with scrolling -->
      <div
        class="bg-gray-200 dark:bg-gray-700 p-5 overflow-y-auto"
        style="max-height: calc(80vh - 100px)"
      >
        <table class="table w-full">
          <thead>
            <tr
              class="font-bold text-black dark:text-white text-base sm:text-lg"
            >
              <th>Name</th>
              <th>Specialty</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="text-black dark:text-white text-base sm:text-lg">
            <!-- sample row -->
            <tr
              class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white"
            >
              <td>Walter White</td>
              <td>Pediatrics</td>
              <td class="pl-9">
                <button onclick="viewDoctor.showModal()"><i class="fa-regular fa-eye"></i></button>
                <dialog id="viewDoctor" class="modal">
                <div class="modal-box w-11/12 max-w-7xl bg-gray-200 dark:bg-gray-700">

                <div class="flex flex-col sm:flex-row justify-between items-center">
                      <div class="order-2 sm:order-1">
                          <h3 class="font-bold text-black dark:text-white text-2xl sm:text-4xl mb-2 sm:mb-0">Doctor's Information</h3>
                      </div>
                      <div class="order-1 sm:order-2 mb-2 sm:mb-0">
                          <img src="../images/HCMC-blue.png" class="block h-10 lg:h-16 w-auto dark:hidden" alt="logo-light" />
                          <img src="../images/HCMC-white.png" class="h-10 lg:h-16 w-auto hidden dark:block" alt="logo-dark" />
                      </div>
                  </div>

                  <div class="patientInfo mb-10 mt-5">
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-1 text-lg sm:text-xl">
                          <p><strong>Name:</strong> Walter White</p>
                          
                          <p><strong>Specialty:</strong> Pediatrics</p>
                          <p><strong>Contact Number:</strong> 099999999999</p>

                          <p><strong>Email:</strong> myemail@gmail.com</p>
                          <p><strong>Sex:</strong> Male</p>
                          

                          <p><strong>Address:</strong> 1234 Health Ave, Immunization City</p>
                          <p><strong>Date of Birth:</strong> June 21, 2024</p>
                      </div>
                  </div>
                    <div class="modal-action">
                    <form method="dialog">
                        <!-- if there is a button, it will close the modal -->
                        <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
                    </form>
                    </div>
                </div>
                </dialog>
              </td>
            </tr>
            <!-- sample row end -->
          

          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
