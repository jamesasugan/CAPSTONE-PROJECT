<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Appointments</title>
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
    <script src="../js/admin-appointments.js" defer></script>
  </head>
  <body>

  <?php include 'admin-navbar.php'; ?>

    <div
      id="appointmentRecordsTab"
      class="p-10 pt-32 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]"
    >
      <div
        class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black"
      >
        <h3
          class="text-2xl sm:text-2xl md:text-4xl font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase"
        >
          Appointments
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
              <th>Patient #</th>
              <th>Name</th>
              <th>Preffered Date</th>
              <th>Preferred Time</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="text-black dark:text-white text-base sm:text-lg">
            <!-- sample row -->
            <tr
              class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white"
            >
              <th>1</th>
              <td>John Edward Dionisio</td>
              <td>May 10, 2024</td>
              <td class="pl-10">10:00 AM</td> <!-- alisin mo yung pl-10 pag nagoverlap yung ilalagay mo -->
              <td class="font-bold text-yellow-600 dark:text-yellow-300">Pending</td> 
              <!-- 
              Completed - text-green-500
              Cancelled - text-red-500
              Approved - text-blue-500
            -->

              <td class="pl-9">
                <!-- yung modal name viewAppointment2,3,4,5 dapat sa mga susunod, bawal parehas kase di maoopen -->
                <button onclick="viewAppointment.showModal()">
                  <i class="fa-regular fa-eye"></i>
                </button>
                <dialog id="viewAppointment" class="modal">
                  <div
                    id="patient-content"
                    class="modal-box h-auto w-11/12 max-w-7xl bg-gray-200 dark:bg-gray-700"
                  >
                    <div
                      class="flex flex-col sm:flex-row justify-between items-center"
                    >
                      <div class="order-2 sm:order-1">
                        <h3
                          class="font-bold text-black dark:text-white text-base sm:text-2xl md:text-3xl mb-2 sm:mb-0"
                        >
                          Patient's Appointment Form
                        </h3>
                      </div>
                      <div class="order-1 sm:order-2 mb-2 sm:mb-0">
                        <!-- Toggle between different logos for light/dark mode -->
                        <img
                          src="../images/HCMC-blue.png"
                          class="block h-10 lg:h-16 w-auto dark:hidden"
                          alt="logo-light"
                        />
                        <img
                          src="../images/HCMC-white.png"
                          class="h-10 lg:h-16 w-auto hidden dark:block"
                          alt="logo-dark"
                        />
                      </div>
                    </div>

                    <!-- staff action -->
                    <h1 class="text-base sm:text-xl font-bold">STATUS: <span class="font-bold text-yellow-500 dark:text-yellow-300">Pending</span></h1>  <!-- ayusin mo rin colors dito ah -->

                    <h2 class="text-base sm:text-xl font-bold mt-5">Edit Status of this Appointment</h2>
                    <form action="#" method="GET">
                      <ul class="items-center w-full text-lg font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg sm:flex mb-2">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                          <div class="flex items-center ps-3">
                            <input id="approve" type="radio" required name="list-status" class="radio radio-info" value="approve">
                            <label for="approve" class="w-full py-3 ms-2">Approve</label>
                          </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                          <div class="flex items-center ps-3">
                            <input id="reschedule" type="radio" required name="list-status" class="radio radio-info" value="reschedule">
                            <label for="reschedule" class="w-full py-3 ms-2">Reschedule</label>
                          </div>
                        </li>
                        <li class="w-full dark:border-gray-600">
                          <div class="flex items-center ps-3">
                            <input id="cancel" type="radio" required name="list-status" class="radio radio-info" value="cancel">
                            <label for="cancel" class="w-full py-3 ms-2">Cancel</label>
                          </div>
                        </li>
                      </ul>

                      <div class="flex flex-col sm:flex-row justify-between gap-4" id="reschedule-section" style="display: none;">
                        <div class="w-full">
                          <label for="rescheduled-date" class="block text-base sm:text-lg font-medium">
                            Rescheduled Date
                          </label>
                          <input
                            type="date"
                            id="rescheduled-date"
                            name="rescheduled-date"
                            class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]"
                          />
                        </div>
                        <div class="w-full">
                          <label for="rescheduled-time" class="block text-base sm:text-lg font-medium">
                            Rescheduled Time
                          </label>
                          <input
                            type="time"
                            id="rescheduled-time"
                            name="rescheduled-time"
                            min="08:00"
                            max="17:00"
                            class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]"
                          />
                        </div>
                      </div>

                      <div class="mb-3 mt-10">
                        <p><span class="font-bold text-blue-400">NOTE: </span>Remarks is set to default, if you want custom message, you can edit the text directly in the input field provided.</p>
                        <label for="remarks" class="block text-base sm:text-lg font-medium mt-2">
                          Remarks:
                        </label>
                        <input
                          type="text"
                          id="remarks"
                          name="remarks"
                          placeholder="Remarks here..."
                          required
                          class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 "
                        />
                      </div>

                      <p><span class="font-bold text-red-500">NOTE: </span>Once you click the submit button, it cannot be undone. Please confirm all the fields before submitting.</p>
                      <input type="submit" value="Submit" class="btn mt-1 bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7 mb-2">
                    </form>

                    <!-- pashow ulit nito pag nagedit at sinubmit -->
                    <div class="flex justify-center">
                      <div
                        role="alert"
                        class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="stroke-current shrink-0 h-6 w-6 mr-2"
                          fill="none"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                          />
                        </svg>
                        <span>Appointment Updated!</span>
                      </div>
                    </div>

                    <div class="mb-10"></div>
                    <div class="modal-action">
                      <form method="dialog">
                        <button
                          id="modalAppointmentbtn"
                          class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none"
                        >
                          Close
                        </button>
                      </form>
                    </div>


                    <!-- appointment form patient info. Nilagyan ko rin "History" sa ID dito katulad sa patient-profile appointment form -->
                    <form action="#" method="GET">
                      <fieldset class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <legend class="text-xl font-bold mb-2 col-span-full">Service:</legend>
                        <div class="flex flex-col w-full">           
                          <ul class="w-full text-lg font-medium text-gray-900 bg-gray-300 dark:bg-gray-600 border border-gray-200 rounded-lg dark:border-gray-600 dark:text-white">
                            <li class="border-b border-gray-400 dark:border-slate-300">
                              <label class="flex items-center pl-3 w-full cursor-pointer">
                                <input id="horizontal-list-radio-license" 
                                type="radio" 
                                value="Consultation" 
                                name="service" 
                                disabled
                                class="radio radio-info [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300" 
                                required>
                                <span class="py-3 ml-2 text-lg font-medium ">Consultation</span>
                              </label>
                            </li>
                            <li>
                              <label class="flex items-center pl-3 w-full cursor-pointer">
                                <input id="horizontal-list-radio-id" 
                                type="radio" 
                                value="Test/Procedure" 
                                name="service" 
                                disabled
                                class="radio radio-info [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300" 
                                required>
                                <span class="py-3 ml-2 text-lg font-medium ">Test/Procedure</span>
                              </label>
                            </li>
                          </ul>
                        </div>

                        <div class="w-full">
                          <label for="service-typeHistory" class="block text-lg font-medium mb-1">What type of service?</label>
                          <select
                            id="service-typeHistory"
                            required
                            disabled
                            class="select select-bordered w-full bg-gray-300 dark:bg-gray-600 text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300"
                            name="service-type"
                        >
                            <option value="lagay mo dito magic mo">Service na pinili ni patient dito</option>
                        </select>


                      </div>

                      <div class="w-full md:w-auto md:col-span-1">
                        <label for="appointment-dateHistory" class="block text-base sm:text-lg font-medium">
                          Appointment Date
                        </label>
                        <input
                          type="date"
                          id="appointment-dateHistory"
                          name="appointment-dateHistory"
                          disabled
                          required
                          class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300"
                        />
                      </div>
                      <div class="w-full md:w-auto md:col-span-1">
                        <label for="appointment-timeHistory" class="block text-base sm:text-lg font-medium">
                          Appointment Time
                        </label>
                        <input
                          type="time"
                          id="appointment-timeHistory"
                          name="appointment-timeHistory"
                          required
                          disabled
                          min="08:00"
                          max="17:00"
                          class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300"
                        />
                      </div>
                      </fieldset>



                        <h3 class="text-xl font-bold mt-5 mb-2">Personal Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                  <div>
                                      <label for="first-nameHistory" class="block text-base sm:text-lg font-medium">First Name</label>
                                      <input type="text" id="first-nameHistory" name="first-nameHistory" disabled autocomplete="off" placeholder="First Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300" />
                                  </div>
                                  <div>
                                      <label for="middle-nameHistory" class="block text-base sm:text-lg font-medium">Middle Name</label>
                                      <input type="text" id="middle-nameHistory" name="middle-nameHistory" disabled placeholder="Middle Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300" />
                                  </div>

                                  <div>
                                      <label for="last-nameHistory" class="block text-base sm:text-lg font-medium">Last Name</label>
                                      <input type="text" id="last-nameHistory" name="last-nameHistory" disabled placeholder="Last Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300" />
                                  </div>
                                  <div>
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
                                      class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300"
                                    />
                                  </div>
                                  <div>
                                      <label for="contact-numberHistory" class="block text-base sm:text-lg font-medium">Contact Number</label>
                                      <input id="contact-numberHistory" name="contact-numberHistory" disabled type="tel" required autocomplete="off" placeholder="Contact Number" pattern="[0-9]{1,11}" minlength="11" maxlength="11" title="Please enter up to 11 numeric characters." class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300" />
                                  </div>

                                  <div>
                                      <label for="sexHistory" class="block text-base sm:text-lg font-medium">Sex</label>
                                      <select id="sexHistory" required class="select select-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 text-lg disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300" name="sexHistory" disabled>
                                          <option value="" disabled selected>Select...</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                      </select>
                                  </div>
                                  <div>
                                      <label for="dobHistory" class="block text-base sm:text-lg font-medium">Date of Birth</label>
                                      <input type="date" id="dobHistory" name="dobHistory" disabled required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300" />
                                  </div>

                                  <div>
                                      <div class="block text-base sm:text-lg font-medium mb-1">Are you vaccinated?</div>
                                      <div class="flex items-center space-x-4 p-2 bg-gray-300 dark:bg-gray-600 rounded">
                                          <label class="flex items-center">
                                              <input type="radio" name="vaccinatedHistory" disabled value="yes" class="radio radio-primary disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300 [color-scheme:light] dark:[color-scheme:dark]" required>
                                              <span class="ml-2">Yes</span>
                                          </label>
                                          <label class="flex items-center">
                                              <input type="radio" name="vaccinatedHistory" disabled value="no" class="radio radio-primary disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300 [color-scheme:light] dark:[color-scheme:dark]" required>
                                              <span class="ml-2">No</span>
                                          </label>
                                      </div>
                                  </div>
                                  <div>
                                      <label for="addressHistory" class="block text-base sm:text-lg font-medium">Address</label>
                                      <input type="text" id="addressHistory" name="addressHistory" disabled autocomplete="off" placeholder="Address" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-gray-500 dark:disabled:text-gray-500 disabled:border-gray-300" />
                                  </div>
                              </div>

                      </form>

                    <!-- <button id="print-content">Print</button> wag muna -->
                 
                  </div>
                </dialog>
              </td>
              <!-- ito yung modal end -->
            </tr>
            <!-- sample row end -->

          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
