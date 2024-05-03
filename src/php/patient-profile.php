<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Settings</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
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
    <script src="../js/patient-profile.js" defer></script>
  </head>
  <body>

    <?php include 'navbar-main.php'; ?>

    <div class="flex flex-col sm:flex-row justify-center items-center">
    <div class="bg-[#ebf0f4] dark:bg-[#17222a] p-5 w-full min-h-screen pt-10 sm:pt-20">
        <!-- Responsive Sidebar for profile settings -->
        <div class="flex flex-col sm:flex-row">
        <div class="w-full sm:w-80 p-5 border-b sm:border-b-0 sm:border-r mt-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mt-5 sm:mt-0">
                    Profile Settings
                </h2>
                <ul class="mt-5 text-lg sm:text-xl">
                    <li id="personalInfoTab" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                        Personal Information
                    </li>
                    <li id="passwordTab" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                        Password
                    </li>
                    <li id="appointmentHistoryTab" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                        Appointment History
                    </li>
                </ul>
          </div>




          <!-- Personal Information -->
          <div id="personalInfo" class="flex-1 p-10 ">
            <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl font-bold text-black dark:text-white mb-4">
                Personal Information
              </h3>
              <form id="personal-info" action="#" method="POST" class="space-y-6">
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
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300 whitespace-nowrap overflow-hidden text-ellipsis"
                      
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
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
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
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
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
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
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
                      class="input input-bordered w-full p-2 text-xs sm:text-lg bg-white dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
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
                      class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
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
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                  <!-- Email -->
                  <div class="form-group col-span-1 sm:col-span-1">
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
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                </div>
                <div class="flex justify-end space-x-2">
                        <button id="editButton" type="button" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7">
                            Edit
                        </button>
                        <input id="updateButton" type="submit" value="Update" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none hidden" onclick="toggleEdit(true)">               
                        <button id="cancelButton" type="button" class="btn bg-white text-black hover:bg-gray-400 border-none hidden" onclick="toggleEdit(false)">
                            Cancel
                        </button>
                    </div>

                    <!-- pashow nito pag nag update info patient -->
                    <div class="flex justify-center">
                        <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Information Updated</span>
                        </div>
                    </div>
                 
              </form>
            </div>
          </div>

          <!-- Password tab -->
          <div id="passwordSection" class="flex-1 p-10 hidden">
          <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl font-bold text-black dark:text-white mb-4">
                  Password
              </h3>
              <form id="security-form" action="#" method="POST" class="space-y-6">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <!-- Password Field -->
                      <div class="form-group">
                          <label for="password" class="block font-medium text-black dark:text-white">Password</label>
                          <div class="relative">
                              <input id="password" 
                                  type="password" 
                                  required 
                                  value="Passwordko1"
                                  disabled
                                  autocomplete="off" 
                                  placeholder="Password" 
                                  class="input input-bordered w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"/>
                                  <button 
                                  type="button" 
                                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                    <span id="password-icon" class="fas fa-eye"></span>
                                </button>

                          </div>
                      </div>

                      <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="confirm-password" class="block font-medium text-black dark:text-white">Confirm Password</label>
                    <div class="relative">
                      <input id="confirm-password" 
                      type="password" 
                      value="Passwordko1"
                      required 
                      disabled
                      autocomplete="off" 
                      placeholder="Confirm Password" 
                      class="input input-bordered w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"/>
                      <button 
                      type="button" 
                      class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <span id="confirm-password-icon" class="fas fa-eye"></span>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Requirements List (only displayed during password change) -->
                <div class="requirement-list hidden">
                  <li><i class="fa-solid fa-circle"></i> At least 8 characters</li>
                  <li><i class="fa-solid fa-circle"></i> At least one digit</li>
                  <li><i class="fa-solid fa-circle"></i> At least one UPPERCASE letter</li>
                  <li><i class="fa-solid fa-circle"></i> No special characters</li>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-2">
                  <button id="editSecurityBtn" type="button" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7" onclick="toggleSecurityEdit(true)">
                      Edit
                  </button>

                    <input id="updateSecurityBtn" type="submit" value="Update" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none hidden" onclick="toggleSecurityEdit(true)">
                    <button id="cancelSecurityBtn" type="button" class="btn bg-white text-black hover:bg-gray-400 border-none hidden" onclick="toggleSecurityEdit(false)">
                        Cancel
                    </button>
                </div>

                <!-- pashow nito pag nag update password patient -->
                <div class="flex justify-center">
                        <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Password Updated</span>
                        </div>
                    </div>
                    
              </form>
          </div>
        </div>

        <!-- Appointment Tab -->
        <div id="appointmentHistory" class="flex-1 p-10 hidden">
          <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl font-bold text-black dark:text-white mb-4">
                  Appointment History
              </h3>
              <div class="overflow-x-auto">
                <table class="table">
                  <!-- head -->
                  <thead>
                    <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                      <th>Name</th>
                      <th>Service</th>
                      <th>Date </th>
                      <th>Time</th>
                      <th>Status</th>
                      <th>Remarks</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- kapag pending text-yellow-500 -->
                    <tr class="text-base hover:bg-gray-300  dark:hover:bg-gray-600 font-medium text-black dark:text-white">               
                      <td>Cy Ganderton</td>
                      <td>Consultation</td>
                      <td>21/05/2024</td>
                      <td>12:00</td>
                      <td class="font-bold text-yellow-500 dark:text-yellow-300 ">Pending</td> 
                      <td>Your schedule is being process</td>

                      <!-- ito yung modal. hindi maoopen yung mga sumunod na modal kapag yung "cancel_modal" name parehas, dapat magkaiba. ex: cancel_modal2..3..4..5 sa mga susunod. ikaw na bahala hackerman -->
                      <td class="pl-9"> 
                        <button onclick="cancel_modal.showModal()"><i class="fa-solid fa-pen-to-square"></i></button>
                        <form action="#" method="POST">
                          <dialog id="cancel_modal" class="modal">
                          <div class="modal-box bg-gray-200 dark:bg-gray-700">
                            <h3 class="font-bold text-xl text-black dark:text-white mb-2">Cancel Appointment?</h3>

                            <p class="text-black dark:text-white">Are you sure you want to cancel your appointment?
                              <br><span class="font-bold text-red-400"> This action is permanent and cannot be undone.</span> </p>
                              <p class="py-4 text-black dark:text-white">Please enter your password to avoid accidentally cancelling your Appointment</p>

                            <div class="form-group mb-4">
                              
                              <label for="dlt-password" class="block font-medium text-black dark:text-white">Confirm Password</label>
                              <div class="relative">
                                <input id="dlt-password" type="password" required autocomplete="off" placeholder="Enter your password" 
                                class="input input-bordered w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white dark:bg-gray-600 text-black dark:text-white">
                              </div>
                            </div>
                            <div class="flex justify-end space-x-2">
                              <input type="submit" value="Submit" class="btn btn-error hover:bg-red-700 text-white font-bold border-none px-7">
                              <button type="button" class="btn bg-white text-black hover:bg-gray-400 border-none" onclick="cancel_modal.close()">Cancel</button>
                            </div>                 
                          </div>
                        </dialog>
                        </form>
                      </td>
                    </tr>
                    <!-- kapag completed text-green-500 -->
                    <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                      <td>Hart Hagerty</td>
                      <td>Test/Procedure</td>
                      <td>02/05/2024</td>
                      <td>09:00</td>
                      <td class="font-bold text-green-500">Completed</td>
                      <td>Appointment completed</td>
                      <td class="pl-9"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></td>
                    </tr>
                    <!-- kapag approved text-blue-500 -->
                    <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                      <td>Brice Swyre</td>
                      <td>Consultation</td>
                      <td>14/05/2024</td>
                      <td>05:00</td>
                      <td class="font-bold text-blue-500">Approved</td>
                      <td>Your appointment is now listed, comply on the set date and time</td>
                      <td class="pl-9"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></td>
                    </tr>
                    <!-- kapag cancelled text-red-500 -->
                    <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                      <td>John Edward Dionisio</td>
                      <td>Test/Procedure</td>
                      <td>04/15/2024</td>
                      <td>03:00</td>
                      <td class="font-bold text-red-500">Cancelled</td>
                      <td>Your Appointment has been Cancelled due to unforeseen circumstances. <a href="bookappointment.php" class="text-blue-500 underline">Rebook now</a> if you want to continue</td>
                      <td class="pl-9"><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></td>
                    </tr>
                  </tbody>
                </table>
              </div>

          </div>
        </div>

        </div>
      </div>
    </div>
      
  </body>
</html>

              