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
    <script src="../js/staff-patientsRecord.js" defer></script>
  </head>
  <body>

    <?php include 'staff-navbar.php'; ?>

    <div id="patients-recordTab" class="p-10 pt-32 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]">
      <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black ">
        <h3 class="text-2xl sm:text-4xl font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase">
          Patients
        </h3>
        <form action="#" method="POST" class="flex items-center">
          <input 
              type="text" 
              name="text"
              class="input input-bordered appearance-none w-full px-3 py-2 rounded-none bg-white dark:bg-gray-600 text-black dark:text-white border border-black border-r-0 dark:border-white" 
              placeholder="Search"
          />
          <button type="submit" class="btn btn-square bg-gray-400 hover:bg-gray-500  rounded-none dark:bg-gray-500 dark:hover:bg-gray-300 border border-black border-l-0 dark:border-white">
              <i class="fa-solid fa-magnifying-glass text-black dark:text-white"></i>
          </button>
        </form>
      </div>

      <!-- Table Container with scrolling -->
      <div class="bg-gray-200 dark:bg-gray-700 p-5 overflow-y-auto" style="max-height: calc(80vh - 100px);">
        <table class="table w-full">
          <thead>
            <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
              <th>Patient #</th>
              <th>Name</th>
              <th>Age</th>
              <th>Sex</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="text-black dark:text-white text-base sm:text-lg">

            <!-- sample row -->
            <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
              <th>1</th>
              <td>John Edward Dionisio</td>
              <td>21</td>
              <td>Male</td>
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

                  <h2 class="text-xl font-semibold mt-5">Patient #<span>1</span></h2>  <!-- ibahin mo to -->
                  <h2 class="patient-name text-xl font-semibold">Dionisio, John Edward</h2>

                  <!-- <button id="print-content">Print</button> wag muna -->

                  <form id="patientForm" action="#" method="POST" >
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    
                    <label class="flex items-center gap-2">
                        Age:
                        <input type="text" 
                              name="age" 
                              value="21" 
                              required 
                              disabled
                              class="w-auto input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Age" />
                    </label>
                    
                    <label class="flex items-center">
                        Consultation Date: &nbsp; 
                        <input type="date" 
                              name="consultation-date" 
                              required 
                              disabled 
                              class="grow input input-bordered w-auto p-2 text-xs sm:text-lg bg-white dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Consultation Date" />
                    </label>

                    <label class="flex items-center gap-2">
                        Sex:
                        <input type="text" 
                              name="Sex" 
                              value="Male" 
                              required 
                              disabled
                              class="w-auto input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Sex" />
                    </label>

                    <label class="flex items-center gap-2">
                        Consultant:
                        <input type="text" 
                              name="consultant-name" 
                              value="Walter White" 
                              required 
                              disabled
                              class="w-full sm:w-auto input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Consultant Name" />
                    </label>
                </div>


                  <div class="grid grid-cols-1 gap-4 mb-4">
                      <label class="flex items-center gap-2">
                          Temperature (Celsius):
                          <input type="text" 
                          name="temperature" 
                          value="36" 
                          required 
                          disabled 
                          class="w-32 sm:w-auto input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Temperature" />
                      </label>

                      <label class="flex items-center gap-2">
                          Blood Pressure:
                          <input type="text" 
                          name="blood-pressure" 
                          value="123/50" 
                          required 
                          disabled 
                          class="w-32 sm:w-auto input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Blood Pressure" />
                      </label>

                      <label class="flex items-center gap-2">
                          Saturation:
                          <input type="text" name="saturation" value="di ko alam basta text" required disabled class="w-full input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Saturation" />
                      </label>
                  </div>

                  <div class="grid grid-cols-1 gap-4 mb-4">
                      <label class="flex items-center gap-2 w-full">
                          Chief Complaint:
                          <input type="text" 
                          name="chief-complaint" 
                          value="Dinadaing ng patient" 
                          required 
                          disabled 
                          class="grow w-0 sm:w-auto input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Chief Complaint" />
                      </label>

                      <label class="flex items-center gap-2">
                          Objective:
                          <input type="text" name="objective" value="Physical Examination" required disabled class="w-full input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Objective" />
                      </label>

                      <label class="flex items-center gap-2">
                          Assessment:
                          <input type="text" name="Assessment" value="Diagnosis ng doctor sa patient" required disabled class="w-full input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Assessment" />
                      </label>

                      <label class="flex items-center gap-2">
                          Treatment Plan:
                          <input type="text" name="Treatment-plan" value="Treatment plan" required disabled class="grow w-0 sm:w-auto input input-bordered bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" placeholder="Treatment Plan" />
                      </label>

                      <!-- Images dito. pag nag upload sa upload file button dito lalabas dapat. kapag kunwari lima inupload na picture dapat lima din tong buong DIV -->
                        <div class="flex justify-center items-center w-full">
                            <img class="h-auto max-w-full" 
                            src="../images/APE.jpg" 
                            alt="image description">
                        </div>
                        
                        

                  </div>

                  <div class="chart-actions text-center my-4">           
                    
                      <input type="file" accept="image/*" disabled class="file-input file-input-bordered file-input-info mb-3 w-full max-w-xs bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" />

                      <div id="editControls" class="space-x-4">
                        <a href="#" id="editBtn" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Patient Information
                        </a>                    
                        <input id="updateBtn" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none hidden" type="submit" value="Update">
                        <button id="cancelBtn" class="btn bg-white text-black hover:bg-gray-400 border-none hidden">Cancel</button>
                    </div>
                  </div>
                  </form>

                  <!-- pashow ulit nito pag nagedit at sinubmit -->
                  <div class="flex justify-center">
                        <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Patient Information Updated!</span>
                        </div>
                    </div>

                    <div class="modal-action">
                      <form method="dialog">
                        <button class="btn bg-white text-black hover:bg-gray-400 border-none">Close</button>
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

   

<!-- <script>
  const printBtn = document.getElementById('print-content');

  printBtn.addEventListener('click', function(){
    print();
  });
</script> -->

    

  </body>
</html>
