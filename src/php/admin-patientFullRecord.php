<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information</title>
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

    <section
            id="fullpatientInformation"
            class="w-full min-h-screen flex justify-center items-center pt-28 pb-10 p-5
            bg-[#f6fafc] dark:bg-[#17222a]"
            >
            <div
                class="w-full max-w-7xl mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]"
            >
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
            </section>

    
</body>
</html>