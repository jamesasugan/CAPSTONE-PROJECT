<?php
session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Schedule</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/staff.css" />
    <link rel="stylesheet" href="../css/calendar.css">
    <script
      src="https://kit.fontawesome.com/70df29d299.js"
      crossorigin="anonymous"
    ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" type="image/x-icon" href="../images/logosmall.png">
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="../css/services-swiper.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/main.js" defer></script>
    <script src="../js/calendar.js" defer></script>
    <script src="../js/admin-doctorschedule.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <?php include 'admin-navbar.php'; ?>
    
    <section class="w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a] text-[#0e1011] dark:text-[#eef0f1]">
            <div class="mx-auto bg-white dark:bg-[#222f3a] shadow-lg p-5 pt-28 w-full max-w-full">
                <div class="title flex text-center justify-center font-bold">
                    <h1 class="text-4xl mb-2">Doctor's Schedule</h1>
                </div>

                <div id="set-doctorSchedule" class="flex-1 px-4 sm:px-10 py-10">
                    <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
                        <h3 class="text-3xl font-bold text-black dark:text-white mb-4">
                            Set Doctor's Schedule
                        </h3>
                        <form id="availability-form" action="#" method="GET" class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label
                                    for="DoctorName"
                                    class="block font-medium text-black dark:text-white text-base sm:text-lg"
                                    >Doctor's Name:</label
                                    >
                                    <select
                                    id="DoctorName"
                                    name="DoctorName"
                                    class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                                    required
                                    disabled
                                    >
                                    <option value="">Select a Doctor</option>
                                    <option value="John Edward Dionisio">John Edward Dionisio</option>
                                    <option value="Cy Anthony Cruz">Cy Anthony Cruz</option>
                                    <option value="Clent Juarez">Clent Juarez</option>
                                    <option value="Walter White Jr.">Walter White Jr.</option>
                                    </select>
                                </div>   

                                <div class="form-group">
                                    <label
                                    for="department"
                                    class="block font-medium text-black dark:text-white text-base sm:text-lg"
                                    >Department:</label
                                    >
                                    <select
                                    id="department"
                                    name="department"
                                    class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                                    required
                                    disabled
                                    >
                                    <option value="">Select Department</option>
                                    <option value="Internal Medicine">Internal Medicine</option>
                                    <option value="OB-GYNE">OB-GYNE</option>
                                    <option value="Family Medicine">Family Medicine</option>
                                    <option value="Pediatrics">Pediatrics</option>
                                    <option value="General Medicine">General Medicine</option>
                                    <option value="Surgery">Surgery</option>
                                    </select>
                                </div>   
                            </div>

                            <fieldset class="mb-4"> 
                                <legend class="text-xl font-medium mb-2">Select the Days of Doctor's Schedule in a Week</legend>
                                <ul class="flex flex-wrap text-base sm:text-lg font-medium text-gray-900 border border-gray-400 rounded-lg dark:border-gray-400 dark:text-white bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:light]">
                                    <!-- Monday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r last:border-r-0 last:border-b-0 md:last:border-r sm:last:border-b-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="monday-checkbox" type="checkbox" disabled name="monday" value="" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="monday-checkbox" class="ml-2 flex-grow py-3">Monday</label>
                                        </div>
                                    </li>
                                    <!-- Tuesday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r last:border-r-0 last:border-b-0 md:last:border-r sm:last:border-b-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="tuesday-checkbox" type="checkbox" disabled name="tuesday" value="" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="tuesday-checkbox" class="ml-2 flex-grow py-3">Tuesday</label>
                                        </div>
                                    </li>
                                    <!-- Wednesday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r md:border-r last:border-r-0 last:border-b-0 md:last:border-r-0 sm:last:border-b-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="wednesday-checkbox" type="checkbox" disabled name="wednesday" value="" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="wednesday-checkbox" class="ml-2 flex-grow py-3">Wednesday</label>
                                        </div>
                                    </li>

                                    <!-- Thursday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r md:border-b-0 last:border-r-0 last:border-b-0 md:last:border-r sm:last:border-b-0 sm:last:border-r-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="thursday-checkbox" type="checkbox" disabled name="thursday" value="" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="thursday-checkbox" class="ml-2 flex-grow py-3">Thursday</label>
                                        </div>
                                    </li>

                                    <!-- Friday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r last:border-r-0 last:border-b-0 md:border-b-0 md:last:border-r sm:border-b-0 sm:border-r-0 sm:last:border-b-0 sm:odd:border-r sm:even:border-r-0 border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="friday-checkbox" type="checkbox" disabled name="friday" value="" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="friday-checkbox" class="ml-2 flex-grow py-3">Friday</label>
                                        </div>
                                    </li>

                                    <!-- Saturday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r last:border-r-0 last:border-b-0 md:last:border-r sm:last:border-b-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="saturday-checkbox" type="checkbox" disabled name="saturday" value="" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="saturday-checkbox" class="ml-2 flex-grow py-3">Saturday</label>
                                        </div>
                                    </li>
                                </ul>
                                <div id="checkboxAlert" class="flex justify-center hidden mt-2">
                                    <div role="alert" class="alert alert-info w-auto font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Please select at least one day.</span>
                                    </div>
                                </div>

                            </fieldset>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="form-group">
                                        <div class="block text-base sm:text-lg font-medium">
                                            Start Time:
                                        </div>
                                        <input
                                            type="time"
                                            id="availabilityIn"
                                            name="availability-timeIn"
                                            disabled
                                            required
                                            placeholder="Select Start Time"
                                            class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300 [color-scheme:light] dark:[color-scheme:dark]"
                                        />
                                    </div>     

                                    <div class="form-group">
                                        <div class="block text-base sm:text-lg font-medium">
                                            End Time:
                                        </div>
                                        <input
                                            type="time"
                                            id="availabilityEnd"
                                            name="availability-timeEnd"
                                            disabled
                                            required
                                            placeholder="Select End Time"
                                            class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300 [color-scheme:light] dark:[color-scheme:dark]"
                                        />
                                    </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row items-center space-x-0 sm:space-x-4">
                                <div class="text-gray-700 dark:text-white text-base sm:text-lg font-medium">
                                    Repeat Every Week:
                                </div>
                                <div class="flex flex-col sm:flex-row space-x-0 sm:space-x-4 space-y-2 sm:space-y-0">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" disabled required name="repeat" value="yes" class="radio radio-info [color-scheme:light] dark:[color-scheme:dark]" id="yesRadio">
                                        <span class="text-gray-700 dark:text-white font-medium">Yes</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" disabled required name="repeat" value="no" class="radio radio-info [color-scheme:light] dark:[color-scheme:dark]" id="noRadio">
                                        <span class="text-gray-700 dark:text-white font-medium">No</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4 space-y-2 mx-auto">
                                <div class="note font-medium text-gray-700 dark:text-white" id="yesNote" style="display: none;">
                                    <p>Selecting "Yes" will make the schedule recur weekly. You can edit or delete any schedule as needed.</p>
                                </div>
                                <div class="note font-medium text-gray-700 dark:text-white" id="noNote" style="display: none;">
                                    <p>Selecting "No" means the schedule is set only for the selected week.<br>To continue the same schedule into subsequent weeks, you will need to manually set it again for each week.</p>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-2">
                                <button id="editSchedule" type="button" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7">
                                    Edit Schedule
                                </button>
                                <input id="updateSchedule" type="submit" value="Update" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none hidden">
                                <button id="cancelSchedule" type="button" class="btn bg-white text-black hover:bg-gray-400 border-none hidden">
                                    Cancel
                                </button>
                            </div>

                        </form>
                        

                        <!-- Delete Schedule. tatlo may pangalang deleteSched dito ah -->
                        <button id="deleteButton" class="btn btn-error mt-5" onclick="deleteSched.showModal()">Delete Schedule</button>                   
                        <dialog id="deleteSched" class="modal">
                            <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                                <h3 class="font-bold text-xl sm:text-3xl">Delete/Reset Schedule</h3>
                                <p class="py-4 text-lg sm:text-xl font-medium">How do you want to delete your schedule?</p>
                                
                                <form action="#" method="GET" class="space-y-4">
                                    <!-- Radio Buttons for Deletion Options -->
                                    <ul class="items-center w-full text-lg font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg sm:flex">
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <div class="flex items-center ps-3">
                                                <input id="deleteAll" type="radio" required name="list-radio" class="radio radio-info" value="deleteAll">
                                                <label for="deleteAll" class="w-full py-3 ms-2">Delete All</label>
                                            </div>
                                        </li>
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <div class="flex items-center ps-3">
                                                <input id="deleteDay" type="radio" required name="list-radio" class="radio radio-info" value="deleteDay">
                                                <label for="deleteDay" class="w-full py-3 ms-2">Delete Day</label>
                                            </div>
                                        </li>
                                        <li class="w-full dark:border-gray-600">
                                            <div class="flex items-center ps-3">
                                                <input id="customDelete" type="radio" required name="list-radio" class="radio radio-info" value="customDelete">
                                                <label for="customDelete" class="w-full py-3 ms-2">Custom Delete Range</label>
                                            </div>
                                        </li>
                                    </ul>

                                    <!-- Delete all -->
                                    <div id="deleteAllNote" class="note font-medium text-gray-700 dark:text-white text-lg" style="display: none;">
                                        <p><span class="font-bold text-blue-500">NOTE:</span> This will delete all your set schedules and you will need to set it all again.</p>
                                    </div>

                                    <!-- Delete Day -->
                                    <div id="deleteDayNote" class="note font-medium text-gray-700 dark:text-white text-lg" style="display: none;">
                                        <p><span class="font-bold text-blue-500 mb-1">NOTE:</span> This will delete your selected date. This is best when you are not available on the set schedule.</p>
                                        <label for="deleteDayDate">Select Date:</label>
                                        <input type="date" id="deleteDayDate" name="delete-dayDate" class="input input-bordered w-full bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]">
                                    </div>

                                    <!-- Delete Range -->
                                    <div id="customDeleteNote" class="note font-medium text-gray-700 dark:text-white text-lg" style="display: none;">
                                        <p><span class="font-bold text-blue-500">NOTE:</span> This will delete all your selected date from the selected starting date to ending date.</p>
                                        <p class="mb-1">Please select a starting date to ending date.</p>
                                        <label for="startDate">Select Starting Date:</label>
                                        <input type="date" id="startDate" name="start-date" class="input input-bordered w-full bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]">
                                        <label for="endDate">Select End Date:</label>
                                        <input type="date" id="endDate" name="end-date" class="input input-bordered w-full bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]">
                                    </div>


                                    <!-- Confirmation and Password Input -->
                                    <div class="form-group">  
                                        <p class="text-black dark:text-white mt-16">Are you sure you want to delete your schedule?
                                            <br><span class="font-bold text-red-400">This action is permanent and cannot be undone.</span>
                                        </p>
                                        <p class="text-black dark:text-white mt-2 mb-1">Please enter your password to avoid accidentally deleting your schedule</p>
                                        <label for="dlt-password" class="block font-medium text-black dark:text-white">Confirm Password</label>
                                        <div class="relative">
                                            <input id="dlt-password" type="password" required autocomplete="off" placeholder="Enter your password" 
                                            class="input input-bordered w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white dark:bg-gray-600 text-black dark:text-white">
                                        </div>
                                    </div>                                       
                                    <!-- delete button -->
                                    <input type="submit" value="Delete" class="btn btn-error">                        
                                </form>

                                <!-- close button modal -->
                                <div class="modal-action">                          
                                    <form method="dialog">                                    
                                        <button class="btn bg-white text-black hover:bg-gray-400 border-none">Close</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>

                    </div>
                </div>


                <!-- calendar section -->
                <div class="flex flex-col md:flex-row justify-between items-center border-t border-t-black dark:border-t-white dark:border-x-white px-2 py-2 border-x border-x-black bg-white dark:bg-[#17222a]">     
                    <div class="ml-20"></div>              
                    <div id="currentMonth" class="text-lg sm:text-2xl font-bold  my-2 md:my-0 mx-auto"></div>
                    <div class="calendar-btn text-xs sm:text-base md:text-lg">
                        <button id="prevMonth" class="font-bold py-2 px-4 rounded">
                            <i class="fa-sharp fa-solid fa-arrow-left text-white"></i>
                        </button>
                        <button id="nextMonth" class="font-bold py-2 px-4 rounded">
                            <i class="fa-sharp fa-solid fa-arrow-right text-white"></i>
                        </button>
                    </div>
                    
                </div>
                <div id="calendar" class="overflow-x-auto w-full bg-white dark:bg-[#17222a]">
                    <!-- Calendar grid will be generated here -->
                </div>
            </div>

            <!-- Modal -->
            <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 mt-5 hidden overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 w-full max-w-md lg:max-w-lg shadow-lg rounded-md bg-white dark:bg-[#222f3a]">
                    <div class="mt-3 text-center">
                        <h3 id="modalTitle" class="text-lg leading-6 font-bold text-black dark:text-white"></h3>
                        <div class="mt-2 px-7 py-3">
                            <p id="modalContent" class="max-h-[400px] overflow-y-auto text-sm text-black dark:text-white scrollbar"></p>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button id="closeModal" class="px-4 py-2 bg-[#0b6c95] hover:bg-[#11485f] text-white text-base font-medium rounded-md w-1/2 shadow-sm focus:outline-none focus:ring-2">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</body>
</html>