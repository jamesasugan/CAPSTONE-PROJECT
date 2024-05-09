<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Archive Accounts</title>
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

      <!-- delete all patient records content
        yung name din ng modal dito pre deleteAll_records1,2,3,4 -->
      <div class="flex justify-end mb-5">
            <button class="btn btn-error" onclick="deleteAll_records.showModal()">Delete All Patient Records</button>

            <dialog id="deleteAll_records" class="modal">
                <div class="modal-box bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                    <h3 class="font-bold text-xl">Delete All Patient Records</h3>
                    <form action="#" method="POST">
                        <div class="form-group">  
                            <p class="text-black dark:text-white mt-5 font-medium mb-1">Are you sure you want to permanently Delete all Archived Patient Records?
                                <br><span class="font-bold text-red-400">This action is permanent and cannot be undone.</span>
                            </p>
                            <p class="text-black dark:text-white mt-2 mb-1">Please enter your password to avoid accidental deletion</p>

                                <label for="dlt-password" class="block font-medium text-black dark:text-white">Confirm Password</label>
                                <div class="relative">
                                    <input id="dlt-password" type="password" required autocomplete="off" placeholder="Enter your password" 
                                    class="input input-bordered w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white dark:bg-gray-600 text-black dark:text-white mb-2">
                                </div>
                                <!-- delete button -->
                            <input type="submit" value="Delete All" class="btn btn-error">   
                        </div> 
                    </form>                                      
                      

                    <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button in form, it will close the modal -->
                            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
        <!-- delete all patient records content end -->

            <div class="flex flex-col sm:flex-row  justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black">
                <h3 class="text-2xl sm:text-2xl md:text-4xl font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase mr-0 sm:mr-10">
                  Archived Records
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
              <th>Unarchive</th>
              <th>Delete</th>
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

              <!-- yung modal name pre ah dapat view_archive1,2,3,4 yung mga sunod -->
              <td class="pl-9">
                <button onclick="view_archive.showModal()"><i class="fa-regular fa-eye"></i></button>          
              </td>

              <td class="pl-12"><button onclick="unarchive_record.showModal()"><i class="fa-solid fa-address-book"></i></button></td>

              <!-- yung modal name din dito dapat delete_record1,2,3,4, yung mga sunod -->
              <td class="pl-9"><button onclick="delete_record.showModal()"><i class="fa-solid fa-trash text-red-500"></i></button></td>
            </tr>
            <!-- sample row end -->


           

          </tbody>
        </table>
      </div>
    </div>


    <!-- modal content for view patient records -->
            <dialog id="view_archive" class="modal">
                <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                <h2 class="text-3xl font-bold mb-2">Patient's Chart</h2>
                
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


                                <!-- lalabas lang to sa follow up stage.
                                    nilipat ko muna ng pwesto, nilabas ko sa form kase pag nasa form nagkakaerror, gawan mo na lang sariling form siguro to
                            -->
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                                <select name="sort" class="select select-bordered text-black dark:text-white w-full sm:w-48  bg-gray-300 dark:bg-gray-600 text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 mb-4 sm:mb-0 sm:mr-4 disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400">
                                    <option disabled selected>Follow Up #</option>                  
                                    <option>First</option>
                                    <option>Second</option>
                                </select>
                            </div>
                            <h3 class="font-bold text-center text-black dark:text-white text-xl sm:text-2xl mb-5 sm:mb-0">First Follow Up</h3>
                            <!-- lalabas lang to sa follow up stage end -->

                        <form id="patientForm" action="#" method="POST" >

                        <label class="block font-bold text-lg"> Current Visit Status:
                        <ul class="items-center w-full text-lg font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg sm:flex mb-5">
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="initial" type="radio" required name="list-status" class="radio radio-info" value="initial">
                                    <label for="initial" class="w-full py-3 ms-2">Initial</label>
                                </div>
                                </li>
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="followUp" type="radio" required name="list-status" class="radio radio-info" value="followUp">
                                    <label for="followUp" class="w-full py-3 ms-2">Follow-up</label>
                                </div>
                                </li>
                            </ul>
                            </label>

                            


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 mt-5">                              
                            <div>
                                <label class="block">
                                    Consultation Date:
                                    <input type="date" 
                                        name="consultation-date" 
                                        required 
                                        disabled 
                                        class="input input-bordered w-full p-2 bg-white dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
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
                                        class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Weight:
                                    <input type="text" 
                                    name="weight" 
                                    value="36" 
                                    required 
                                    disabled 
                                    placeholder="Weight"
                                    class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Heart Rate:
                                    <input type="text" 
                                    name="heart-rate" 
                                    value="36" 
                                    required 
                                    disabled 
                                    placeholder="Heart Rate"
                                    class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
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
                                    class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
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
                                    class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
                                </label>
                            </div>             
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4 mb-14">
                            <label class="block">
                                Saturation:
                                <input type="text" name="saturation" required placeholder="Saturation" disabled class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
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

                        <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Results</h2>
                            <!-- Images dito. pag nag upload sa upload file button dito lalabas dapat. kapag kunwari lima inupload na picture dapat lima din tong buong DIV -->
                                <div class="flex justify-center items-center w-full mb-3">
                                    <img class="h-auto max-w-full" 
                                    src="../images/example.jpg" 
                                    alt="image description">
                                </div>
                            <!-- images dito end -->

                        </form>                         
                </div>
            </dialog>
            <!-- modal content for view patient records end -->



            <!-- modal content for permanent delete record -->
            <dialog id="delete_record" class="modal">
                <div class="modal-box bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                    <h3 class="font-bold text-xl">Are you sure you want to permanently <span class="text-red-500">Delete</span>  this Patient Record?</h3>
                        <button class="btn btn-error mt-5">Delete Record</button>

                    <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button in form, it will close the modal -->
                            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
                        </form>
                    </div>
                </div>
            </dialog>
            <!-- modal content for permanent delete record end -->
            


            <!-- unarchive modal content -->
            <dialog id="unarchive_record" class="modal">
                <div class="modal-box bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                    <h3 class="font-bold text-xl">Unarchive Patient Record</h3>
                    <p class="text-black dark:text-white mt-2 mb-1 font-medium">This record will become available again at the Patient Chart List</p>

                        <button class="btn btn-info mt-1">Unarchive</button>
                    </form>                                      
                      

                    <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button in form, it will close the modal -->
                            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
                        </form>
                    </div>
                </div>
            </dialog>
            <!-- unarchive modal content end -->
   




<!-- <script>
  const printBtn = document.getElementById('print-content');

  printBtn.addEventListener('click', function(){
    print();
  });
</script> -->
  </body>
</html>
