<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patients Records</title>
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

    <div id="patients-recordTab" class="p-10 pt-24 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]">

      <!-- add walk in patient button -->
      <div class="flex justify-end mb-5">
            <a href="admin-addwalkInPatient.php" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded cursor-pointer border-none">Add Walk In Patient</a>
        </div>

            <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black">
                <h3 class="text-2xl sm:text-4xl font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase mr-0 sm:mr-10">
                  Patients
                </h3>
                <form action="#" method="POST" class="w-full sm:flex sm:items-center justify-end">
                  <select name="sort" class="select select-bordered text-black dark:text-white w-full sm:w-40 bg-gray-300 dark:bg-gray-600 text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 mb-4 sm:mb-0 sm:mr-4">
                    <option disabled selected>Sort by</option>
                    <optgroup label="Name">
                      <option>A-Z</option>
                      <option>Z-A</option>
                    </optgroup>
                    <optgroup label="Visit">
                      <option>Initial Visit</option>
                      <option>Follow-up Visit</option>
                      <option>Clearance Visit</option>
                    </optgroup>
                    <optgroup label="Appointment Type">
                      <option>Walk In</option>
                      <option>Online</option>
                    </optgroup>
                    <optgroup label="Status">
                      <option>To be Seen</option>
                      <option>Completed</option>
                    </optgroup>
                  </select>

                  <!-- Search Input and Button -->
                  <div class="flex w-full sm:w-auto">
                    <input 
                      type="text" 
                      name="text"
                      class="input input-bordered appearance-none w-full px-3 py-2 rounded-none bg-white dark:bg-gray-600 text-black dark:text-white border border-black border-r-0 dark:border-white" 
                      placeholder="Search"
                    />
                    <button type="submit" class="btn btn-square bg-gray-400 hover:bg-gray-500  rounded-none dark:bg-gray-500 dark:hover:bg-gray-300 border border-black border-l-0 dark:border-white">
                      <i class="fa-solid fa-magnifying-glass text-black dark:text-white"></i>
                    </button>
                  </div>
                </form>
          </div>

      <!-- Table Container with scrolling -->
      <div class="bg-gray-200 dark:bg-gray-700 p-5 overflow-y-auto" style="max-height: calc(80vh - 100px);">
        <table class="table w-full">
          <thead>
            <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
              <th>Name</th>
              <th>Age</th>
              <th>Sex</th>
              <th>Appointment Type</th>
              <th>Service</th>
              <th>Visit</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="text-black dark:text-white text-base sm:text-lg">

            <!-- sample row -->
            <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
              <td>John Edward Dionisio</td>
              <td>21</td>
              <td>Male</td>
              <td>Walk In</td>
              <td>OB-GYNE</td>
              <td>Follow-up</td>
              <td class="font-bold text-yellow-600 dark:text-yellow-300">To be Seen</td>
              <!-- Status List
                   Completed = text-green-500
                   Waiting for Results = text-yellow-600 dark:text-yellow-300
                   No Show =  text-red-500
            -->

              <!-- view information modal -->
              <td class="pl-9">
              <!-- yung modal name view_info2,3,4,5 dapat sa mga susunod, bawal parehas kase di maoopen -->
                <button onclick="view_info1.showModal()"><i class="fa-regular fa-eye"></i></button> 
                <dialog id="view_info1" class="modal">

                  <div id="patient-content" class="modal-box h-auto w-11/12 max-w-7xl bg-gray-200 dark:bg-gray-700">

                  <div class="flex flex-col sm:flex-row justify-between items-center">
                      <div class="order-2 sm:order-1">
                          <h3 class="font-bold text-black dark:text-white text-2xl sm:text-4xl mb-2 sm:mb-0">Patient's Chart</h3>
                      </div>
                      <div class="order-1 sm:order-2 mb-2 sm:mb-0">
                          <!-- Toggle between different logos for light/dark mode -->
                          <img src="../images/HCMC-blue.png" class="block h-10 lg:h-16 w-auto dark:hidden" alt="logo-light" />
                          <img src="../images/HCMC-white.png" class="h-10 lg:h-16 w-auto hidden dark:block" alt="logo-dark" />
                      </div>
                  </div>

                  

                  <!-- <button id="print-content">Print</button> wag muna -->

                  <div class="patientInfo mb-10 mt-5">
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-1 text-lg sm:text-xl">
                        <h2 class="text-lg sm:text-xl font-bold">Status: <span class="text-yellow-600 dark:text-yellow-300">To be Seen</span></h2>
                            <p><strong>Appointment Type:</strong> Walk In</p>

                            <p><strong>Service:</strong> Consultation</p>
                            <p><strong>Service Type:</strong> OB-GYNE</p>

                            <p><strong>Name:</strong> John Edward E. Dionisio</p>
                            <p><strong>Contact Number:</strong> 099999999999</p>

                            <p><strong>Sex:</strong> Male</p>
                            <p><strong>Email:</strong> myemail@gmail.com</p>

                            <p><strong>Vaccinated:</strong> Yes</p>

                            <p><strong>Address:</strong> 1234 Health Ave, Immunization City</p>
                            <p><strong>Date of Birth:</strong> June 21, 2024</p>
                      </div>
                  </div>

                  <div class="modal-action">
                      <form method="dialog">
                        <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
                      </form>
                    </div>



                  <form id="patientForm" action="#" method="POST" >

                  <label class="block font-bold text-lg"> Current Visit Status:
                  <ul class="items-center w-full text-lg font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg sm:flex mb-5">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                          <div class="flex items-center ps-3">
                            <input id="initial" type="radio" disabled required name="list-status" class="radio radio-info" value="initial">
                            <label for="initial" class="w-full py-3 ms-2">Initial</label>
                          </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                          <div class="flex items-center ps-3">
                            <input id="followUp" type="radio" disabled required name="list-status" class="radio radio-info" value="followUp">
                            <label for="followUp" class="w-full py-3 ms-2">Follow-up</label>
                          </div>
                        </li>
                        <li class="w-full dark:border-gray-600">
                          <div class="flex items-center ps-3">
                            <input id="clearance" type="radio" disabled required name="list-status" class="radio radio-info" value="clearance">
                            <label for="clearance" class="w-full py-3 ms-2">Clearance</label>
                          </div>
                        </li>
                      </ul>
                      </label>

                      <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                          <select name="sort" class="select select-bordered text-black dark:text-white w-full sm:w-48  bg-gray-300 dark:bg-gray-600 text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 mb-4 sm:mb-0 sm:mr-4">
                              <option disabled selected>Follow Up #</option>                  
                              <option>First</option>
                              <option>Second</option>
                          </select>
                      </div>

                      <h3 class="font-bold text-center text-black dark:text-white text-xl sm:text-2xl mb-5 sm:mb-0">First Follow Up</h3>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 mt-5">                              
                    <div>
                        <label class="block">
                            Consultation Date:
                            <input type="date" 
                                name="consultation-date" 
                                required 
                                disabled 
                                class="input input-bordered w-full p-2 bg-white dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white" />
                        </label>
                    </div>
                    <div>
                        <label class="block">
                            Consultant:
                            <input type="text" 
                                name="consultant-name" 
                                value="Walter White" 
                                required 
                                disabled
                                placeholder="Consultant Name"
                                class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white" />
                        </label>
                    </div>
                    <div>
                        <label class="block">
                            Temperature (Celsius):
                            <input type="text" 
                            name="temperature" 
                            value="36" 
                            required 
                            disabled 
                            placeholder="Temperature in Celsius"
                            class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white" />
                        </label>
                    </div>
                    <div>
                        <label class="block">
                            Blood Pressure:
                            <input type="text" 
                            name="blood-pressure" 
                            value="123/50" 
                            required 
                            disabled 
                            placeholder="Blood Pressure"
                            class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white" />
                        </label>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-4 mb-14">
                    <label class="block">
                        Saturation:
                        <input type="text" name="saturation" value="di ko alam basta text" required placeholder="Saturation" disabled class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white" />
                    </label>
                    <label class="block">Chief Complaint:
                    <textarea id="chiefComplaint" rows="4" name="Chief Complaint" disabled class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" placeholder="Chief Complaint"></textarea>
                    </label>
                    <label class="block">Physical Examination:
                    <textarea id="physicalExamination" rows="4" name="Physical Examination" disabled class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" placeholder="Physical Examination"></textarea>
                    </label>
                    <label class="block">Assessment:
                    <textarea id="assessment" rows="4" name="Assessment" disabled class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" placeholder="Assessment"></textarea>
                    </label>
                    <label class="block">Treatment Plan:
                    <textarea id="treatmentPlan" rows="4" name="Treatment Plan" disabled class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" placeholder="Treatment Plan"></textarea>
                    </label>
                </div>

                <div class="border border-gray-400 mb-10"></div>

                <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center"> Results</h2>
                      <!-- Images dito. pag nag upload sa upload file button dito lalabas dapat. kapag kunwari lima inupload na picture dapat lima din tong buong DIV -->
                        <div class="flex justify-center items-center w-full">
                            <img class="h-auto max-w-full" 
                            src="../images/example.jpg" 
                            alt="image description">
                        </div>

                  </form>                  
                  </div>

                </dialog>
              </td>
            </tr>
            <!-- sample row end -->


           

          </tbody>
        </table>
      </div>
    </div>

   

<!-- <script>
  const printBtn = document.getElementById('print-content');

  printBtn.addEventListener('click', function(){
    print();
  });
</script> -->

    

  </body>
</html>
