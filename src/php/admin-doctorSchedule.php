<?php
session_start();
require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::ADMIN]))
{
  return;
}

include '../Database/database_conn.php';
?>

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
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/main.js" defer></script>
    <script src="../js/calendar.js" defer></script>
    <script src="../js/admin-doctorschedule.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<?php include 'navbar.php'; ?>
    
    <section class="w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a] text-[#0e1011] dark:text-[#eef0f1]">
            <div class="mx-auto bg-[#f6fafc] dark:bg-[#222f3a] shadow-lg p-5 pt-28 w-full max-w-full">
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
                                    name="DoctorID"
                                    class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                                    required
                                    disabled
                                    >
                                    <option value="">Select a Doctor</option>
                                      <?php
                                      $sql =
                                          "SELECT * FROM tbl_staff where role = 'doctor' ";
                                      $stmt = $conn->prepare($sql);
                                      $stmt->execute();
                                      $result = $stmt->get_result();
                                      while ($row = $result->fetch_assoc()) {
                                          $middleInitial =
                                              strlen($row['Middle_Name']) >= 1
                                                  ? substr(
                                                      $row['Middle_Name'],
                                                      0,
                                                      1
                                                  )
                                                  : '';
                                          echo '<option value="' .
                                              $row['Staff_ID'] .
                                              '">' .
                                              $row['First_Name'] .
                                              ' ' .
                                              $middleInitial .
                                              '. ' .
                                              $row['Last_Name'] .
                                              '</option>';
                                      }
                                      ?>
                                    </select>
                                </div>   

                                <div class="form-group">
                                  <H1 id='speciality' class='card-title'></H1>
                                </div>   
                            </div>
                            <fieldset class="mb-4"> 
                                <legend class="text-xl font-medium mb-2">Select the Days of Doctor's Schedule in a Week</legend>
                                <ul class="flex flex-wrap text-base sm:text-lg font-medium text-gray-900 border border-gray-400 rounded-lg dark:border-gray-400 dark:text-white bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:light]">
                                    <!-- Monday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r last:border-r-0 last:border-b-0 md:last:border-r sm:last:border-b-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="monday-checkbox" type="checkbox" disabled name="monday" value="monday" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="monday-checkbox" class="ml-2 flex-grow py-3">Monday</label>
                                        </div>
                                    </li>
                                    <!-- Tuesday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r last:border-r-0 last:border-b-0 md:last:border-r sm:last:border-b-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="tuesday-checkbox" type="checkbox" disabled name="tuesday" value="tuesday" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="tuesday-checkbox" class="ml-2 flex-grow py-3">Tuesday</label>
                                        </div>
                                    </li>
                                    <!-- Wednesday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r md:border-r last:border-r-0 last:border-b-0 md:last:border-r-0 sm:last:border-b-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="wednesday-checkbox" type="checkbox" disabled name="wednesday" value="wednesday" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="wednesday-checkbox" class="ml-2 flex-grow py-3">Wednesday</label>
                                        </div>
                                    </li>

                                    <!-- Thursday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r md:border-b-0 last:border-r-0 last:border-b-0 md:last:border-r sm:last:border-b-0 sm:last:border-r-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="thursday-checkbox" type="checkbox" disabled name="thursday" value="thursday" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="thursday-checkbox" class="ml-2 flex-grow py-3">Thursday</label>
                                        </div>
                                    </li>

                                    <!-- Friday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r last:border-r-0 last:border-b-0 md:border-b-0 md:last:border-r sm:border-b-0 sm:border-r-0 sm:last:border-b-0 sm:odd:border-r sm:even:border-r-0 border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="friday-checkbox" type="checkbox" disabled name="friday" value="friday" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="friday-checkbox" class="ml-2 flex-grow py-3">Friday</label>
                                        </div>
                                    </li>

                                    <!-- Saturday Item -->
                                    <li class="flex-grow w-full sm:w-1/2 md:w-1/3 border-b border-r last:border-r-0 last:border-b-0 md:last:border-r sm:last:border-b-0 sm:odd:border-r border-gray-400 dark:border-gray-400">
                                        <div class="flex items-center p-3">
                                            <input id="saturday-checkbox" type="checkbox" disabled name="saturday" value="saturday" class="checkbox checkbox-info text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-300 dark:border-gray-500">
                                            <label for="saturday-checkbox" class="ml-2 flex-grow py-3">Saturday</label>
                                        </div>
                                    </li>
                                </ul>
                                <div id="checkboxAlert" class="flex justify-center hidden mt-2">
                                    <div role="alert" class="alert alert-warning w-auto font-medium">
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
                            <div class="flex flex-col space-y-4">
                                <div class="text-gray-700 dark:text-white text-base sm:text-lg font-medium">
                                    Select your Start and End Date Schedule:
                                </div>
                                <div id="repeatRangeDates" class="mt-4 space-y-2 mx-auto w-full">
                                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                                        <div class="flex flex-col space-y-2 sm:space-y-0 sm:w-1/2">
                                            <label for="repeatStart">Select Start Date:</label>
                                            <input type="date" id="repeatStart" disabled name="repeatStart" class="input input-bordered w-full bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" />
                                        </div>
                                        <div class="flex flex-col space-y-2 sm:space-y-0 sm:w-1/2">
                                            <label for="repeatEnd">Select End Date:</label>
                                            <input type="date" id="repeatEnd" disabled name="repeatEnd" class="input input-bordered w-full bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" />
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            
                            <div class="flex justify-end space-x-2">
                                <button id="editSchedule" type="button" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7">
                                    Add Schedule
                                </button>
                                <input id="updateSchedule" type="submit" value="Submit" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none hidden">
                                <button id="cancelSchedule" type="button" class="btn bg-white text-black hover:bg-gray-400 border-none hidden">
                                    Cancel
                                </button>
                            </div>

                        </form>
                        

                        <!-- Delete Schedule. tatlo may pangalang deleteSched dito ah -->
                        <button id="deleteButton" class="btn btn-error mt-5" onclick="deleteSched.showModal()">Delete Schedule</button>                   
                        <dialog id="deleteSched" class="modal">
                            <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                                <h3 class="font-bold text-xl sm:text-3xl">Delete Schedule</h3>
                                
                                
                              <form id='deleteSchedForm' action="#" method="GET" class="space-y-4">
                                <div class="form-group mt-5">
                                    <label
                                    for="dltDoctorSched"
                                    class="block font-medium text-black dark:text-white text-base sm:text-lg"
                                    >Select Doctor's Name:</label
                                    >
                                    <select
                                    id="dltDoctorSched"
                                    name="dltDoctorSched"
                                    class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                                    required
                                    >
                                      <option value="" disabled selected>Select a Doctor</option>
                                        <?php
                                        $sql =
                                            "SELECT * FROM tbl_staff where role = 'doctor' ";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $middleInitial =
                                                strlen($row['Middle_Name']) >= 1
                                                    ? substr(
                                                        $row['Middle_Name'],
                                                        0,
                                                        1
                                                    )
                                                    : '';
                                            echo '<option value="' .
                                                $row['Staff_ID'] .
                                                '">' .
                                                $row['First_Name'] .
                                                ' ' .
                                                $middleInitial .
                                                '. ' .
                                                $row['Last_Name'] .
                                                '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>   
                                    <!-- Radio Buttons for Deletion Options -->
                                    <p class="text-lg sm:text-xl font-medium">How do you want to delete Doctor's schedule?</p>
                                    <ul class="items-center w-full text-lg font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg sm:flex">
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <div class="flex items-center ps-3">
                                                <input id="deleteAll" type="radio" required name="list-radio"  class="radio radio-info" value="deleteAll">
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
                                        <p class="text-black dark:text-white mt-16">Are you sure you want to delete this schedule?
                                            <br><span class="font-bold text-red-400">This action is permanent and cannot be undone.</span>
                                        </p>
                                        <p class="text-black dark:text-white mt-2 mb-1">Please enter your password to confirm deleting schedule</p>
                                        <label for="dlt-password" class="block font-medium text-black dark:text-white">Confirm Password</label>
                                        <div class="relative">
                                            <input name='conf_password' id="dlt-password" type="password" required autocomplete="off" placeholder="Enter your password"
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




                <!-- pending card -->
                <div class="flex justify-center items-center mb-5">
                    <div class="flex flex-col w-full sm:w-96 shadow-xl bg-[#cadcec] dark:bg-[#0F1E2B] border border-[#35485a] dark:border-[#8c9caa]">
                        <div class="flex-grow">
                            <div class="card-body">
                                <div class="icon flex justify-center">
                                    <span class="font-bold text-6xl sm:text-7xl mt-2 overflow-hidden whitespace-nowrap text-overflow-ellipsis">35</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-actions justify-center mt-auto">
                            <button class="btn text-base sm:text-lg rounded-none w-full bg-[#78afe2] dark:bg-[#1C3F61] uppercase text-[#0e1011] dark:text-[#eef0f1] hover:bg-[#224362] hover:text-[#eef0f1] dark:hover:bg-[#9dbedd] dark:hover:text-[#0e1011] border-[#35485a] dark:border-[#8c9caa] overflow-hidden whitespace-nowrap text-overflow-ellipsis" onclick="viewPendingSched.showModal(); getReqRec(); getDelRec()">View Pendings</button>
                        </div>
                    </div>
                </div>

                  <!-- calendar ui -->                       
                <div class="flex flex-col lg:flex-row justify-between lg:items-stretch">
                    <div class="w-full lg:w-4/5 lg:pr-4">
                        <div class="flex flex-col md:flex-row justify-between items-center border-t border-t-black dark:border-t-white dark:border-x-white px-2 py-2 border-x border-x-black">     
                            <div class="ml-20"></div>              
                            <div id="currentMonth" class="text-lg sm:text-2xl font-bold my-2 md:my-0 mx-auto"></div>
                            <div class="calendar-btn text-xs sm:text-base md:text-lg">
                                <button id="prevMonth" class="font-bold py-2 px-4 rounded">
                                    <i class="fa-sharp fa-solid fa-arrow-left text-white"></i>
                                </button>
                                <button id="nextMonth" class="font-bold py-2 px-4 rounded">
                                    <i class="fa-sharp fa-solid fa-arrow-right text-white"></i>
                                </button>
                            </div>
                        </div>
                        <div id="calendar" class="overflow-x-auto w-full">
                            <!-- Calendar grid will be generated here -->
                        </div>
                    </div>
                    <div class="w-full lg:w-1/5 border border-black dark:border-gray-300 p-4 mt-4 lg:mt-0 overflow-y-auto scrollbar">
                        <div id="scheduleDetails" class="text-center h-5/6">       
                            <div id="modalTitle" class="text-xl font-bold mb-2 leading-6 text-black dark:text-white"></div>
                            <div class="border-t border-gray-400 my-2"></div>

                            <!-- hide mo tong search form kapag walang schedule -->
                            <form action="#" method="POST" class="w-full flex justify-center">
                                <div class="flex w-full sm:w-auto">
                                    <input
                                    id='Search_input'
                                    type="text" 
                                    name="text"
                                    class="input input-bordered appearance-none w-full px-3 py-2 rounded-none bg-white dark:bg-gray-600 text-black dark:text-white border border-black border-r-0 dark:border-white" 
                                    placeholder="Search" onkeyup="//handleSearch('Search_input', getVisibleTableId())"
                                    />
                                    <button type="submit" class="btn btn-square bg-gray-400 hover:bg-gray-500  rounded-none dark:bg-gray-500 dark:hover:bg-gray-300 border border-black border-l-0 dark:border-white">
                                    <i class="fa-solid fa-magnifying-glass text-black dark:text-white"></i>
                                    </button>
                                </div>
                            </form>
                            
                            <div class="px-7 py-3 w-full">
                                <p id="modalContent" class="text-sm text-black dark:text-white "></p>
                            </div>
                            
                            <div id="scheduleContent" class="text-base font-medium">No schedule</div>

                        </div>
                    </div>
                </div>


                <!-- modal for view pending schedules -->
                <dialog id="viewPendingSched" class="modal">
                    <div class="modal-box w-11/12 max-w-7xl bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1] p-0">
                        <div class="modal-header sticky top-0 bg-gray-200 dark:bg-gray-700 z-10 px-10 pt-10">

                        <!-- gawin mong "Pending Deletion Schedules" pag pinili sa dropdown yung Delete schedules -->
                            <h3 class="font-bold text-3xl mb-0 text-center">Pending Schedules</h3>

                                <div class="modal-action flex justify-end">
                                    <form method="dialog">
                                        <button class="btn bg-white text-black hover:bg-gray-400 border-none mb-3">Close</button>
                                    </form>
                                </div>      
                            <div class="border border-gray-600 dark:border-slate-300"></div>
                        </div>

                    <div class="p-10">
                        <div class="mt-5 w-2/4 mb-5">
                            <label for="selectPending" class="block font-medium text-black dark:text-white text-base sm:text-lg">Select Pending Actions</label>
                            <select onchange='switchTable()' id="chooseTable" name="chooseTable" class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white " required>
                                <option selected value="Pending Add Schedules">Pending Add Schedules</option>
                                <option value="Pending Delete Schedules">Pending Delete Schedules</option>
                            </select>
                        </div>
                       
                        <!-- table for Adding Schedules -->
                        <div id='addSched' class="overflow-x-auto">
                            <table class="table">
                                <thead class="bg-neutral-300 dark:bg-gray-500">
                                <tr class="font-bold text-black dark:text-white text-base sm:text-lg ">
                                    <th>Name</th>
                                    <th>Days in a Week</th>
                                    <th>Start to End Time</th>
                                    <th>Start to End Date</th>
                                    <!-- <th>Status</th>  di ko sure kung need to-->
                                    <th class="pl-16">Action</th>
                                </tr>
                                </thead>
                                <tbody id='schedReqRec'>
                                <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                                    <!-- dapat may Dr. sa bawat name ah -->
                                    <td class="w-1/4">Dr. Hart Hagerty</td>
                                    <td class="w-1/4">Monday, Tuesday, Wednesday, Thursday, Friday, Saturday</td>
                                    <td class="w-1/4">10:00 AM to 03:00 PM</td>
                                    <td class="w-1/4">June 2, 2024 to July 21, 2024</td>

                                    <!-- <td class="font-bold text-green-500">Accepted</td> -->
                                    <!-- Declined = text-red-500 -->

                                    <td class="w-1/4">
                                        <div class="flex justify-between">
                                            <button class="bg-blue-500 p-2 rounded-md mr-5 text-white font-medium">Accept</button>
                                            <button class="bg-red-500 p-2 rounded-md text-white font-medium">Decline</button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- table for Adding Schedules end-->

                        <!-- table for Deleting Schedules -->
                        <div id='deleteSchedTBL' class="overflow-x-auto hidden">
                            <table class="table">
                                <thead class="bg-neutral-300 dark:bg-gray-500">
                                <tr class="font-bold text-black dark:text-white text-base sm:text-lg ">
                                    <th>Name</th>
                                    <th>Deletion Type</th>
                                    <th>Date</th>
                                    <th class="pl-16">Action</th>
                                </tr>
                                </thead>
                                <tbody id='PendingDelSched'>
                                <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                                    <!-- dapat may Dr. sa bawat name ah -->
                                    <td class="w-1/4">Dr. Hart Hagerty</td>
                                    <td>All</td>
                                    <!--  ito mga values sa Deletion Type
                                          All, Day, Custom Range -->

                                    <td class="w-1/4">All</td>
                                    <!--  ito mga values sa Date
                                          All(kapag all), 
                                          July 1, 2024(kapag Delete Day)
                                          August 1, 2024 to September 2, 2024(kapag delete custom range)
                                          -->

                                    <td class="w-1/4">
                                        <div>
                                            <button class="bg-blue-500 p-2 rounded-md mr-5 text-white font-medium">Accept</button>
                                            <button class="bg-red-500 p-2 rounded-md text-white font-medium">Decline</button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- table for Deleting Schedules end -->
                    </div>



                        
                    </div>
                  <dialog id="declineSchedAlert" class='modal bg-black bg-opacity-50' onclick='toggleDialog(this.id); getReqRec(); getDelRec()'>
                    <div class='absolute top-20'>
                      <div  class="flex justify-center  mt-2">
                        <div role="alert" class="alert alert-error w-auto font-medium">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          <span>Schedule Request has been declined</span>
                        </div>
                      </div>
                    </div>
                  </dialog>
                  <dialog id="declineDelSchedAlert" class='modal bg-black bg-opacity-50' onclick='toggleDialog(this.id); getReqRec(); getDelRec()'>
                    <div class='absolute top-20'>
                      <div  class="flex justify-center  mt-2">
                        <div role="alert" class="alert alert-warning w-auto font-medium">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          <span>Delete schedule request has been declined</span>
                        </div>
                      </div>
                    </div>
                  </dialog>
                </dialog>

        </section>
    <dialog id="scheSet" class='modal bg-opacity-50 bg-black'>
      <div class='absolute top-20'>
        <div  class="flex justify-center  mt-2">
          <div role="alert" class="alert alert-success w-auto font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Schedule successfully set</span>
          </div>
        </div>
      </div>
    </dialog>
    <dialog id="delSchedApprove" class='modal bg-opacity-50 bg-black'>
      <div class='absolute top-20'>
        <div  class="flex justify-center  mt-2">
          <div role="alert" class="alert alert-error w-auto font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Schedule has been deleted</span>
          </div>
        </div>
      </div>
    </dialog>

</body>

<script>
  function ApproveSchedReq(sched_id , staff_id) {
    $.ajax({
      url: 'ajax.php?action=approveSchedReq&sched_id=' + encodeURIComponent(sched_id) + '&staff_id=' +encodeURIComponent(staff_id),
      type: 'GET',
      dataType: 'html',
      success: function(response) {
        if (parseInt(response) === 1) {
          toggleDialog('viewPendingSched');
          toggleDialog('scheSet');
          window.location.href = 'admin-doctorSchedule.php';

        } else {
          console.log(response);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
  }

  function declineSchedReq(sched_id) {
    $.ajax({
      url: 'ajax.php?action=schedReqdecline&data_id=' + encodeURIComponent(sched_id),
      type: 'GET',
      dataType: 'html',
      success: function(response) {
        if (parseInt(response) === 1) {
          toggleDialog('declineSchedAlert');
        } else {
          console.log(response);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
  }


  function ApproveDelSchedReq(Del_sched_id , staff_id) {
    $.ajax({
      url: 'ajax.php?action=approveDelSchedReq&del_sched_id=' + encodeURIComponent(Del_sched_id) + '&staff_id=' +encodeURIComponent(staff_id),
      type: 'GET',
      dataType: 'html',
      success: function(response) {
        if (parseInt(response) === 1) {
          toggleDialog('viewPendingSched');
          toggleDialog('delSchedApprove');
          window.location.href = 'admin-doctorSchedule.php';


        } else {
          console.log(response);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
  }
  function declineDelSchedReq(delSchedID) {
    $.ajax({
      url: 'ajax.php?action=declineDel&data_id=' + encodeURIComponent(delSchedID),
      type: 'GET',
      dataType: 'html',
      success: function(response) {
        if (parseInt(response) === 1) {
          toggleDialog('declineDelSchedAlert');
        } else {
          console.log(response);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
  }

  function getReqRec(){
    $.ajax({
      url: 'ajax.php?action=DoctorSchedRec',
      type: 'GET',
      data: 'html',

      success: function(response) {
        if (response) {
          $('#schedReqRec').html(response);
        }
      },
    });
  }
  function getDelRec(){
    $.ajax({
      url: 'ajax.php?action=getPendingDelSched',
      type: 'GET',
      data: 'html',

      success: function(response) {
        if (response) {
          $('#PendingDelSched').html(response);
        }
      },
    });
  }
  function switchTable() {
    let select = document.querySelector("select[name='chooseTable']");
    let addSched = document.getElementById("addSched");
    let delSched = document.getElementById("deleteSchedTBL");

    if (select.value === "Pending Add Schedules") {
      delSched.classList.add('hidden');
      addSched.classList.remove('hidden')
    } else if (select.value === "Pending Delete Schedules") {
      addSched.classList.add('hidden');
      delSched.classList.remove('hidden');
    }
  }
  document.getElementById('DoctorName').addEventListener('change', function() {
    var selectedStaffId = this.value;
    if (selectedStaffId) {
      getSpeciality(selectedStaffId);
    } else {
      document.querySelector('#speciality').textContent = '';
    }
  });
  function getSpeciality(staff_id){
    $.ajax({
      url: 'ajax.php?action=getStaffinfo&staff_id=' + staff_id,
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        if (data && data.speciality) {
          document.querySelector('#speciality').textContent = data.speciality;
        } else {
          document.querySelector('#speciality').textContent = '';
        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching data:', error);
        document.querySelector('#speciality').textContent = '';
      }
    });
  }
  function checkCheckboxes(form) {
    const checkboxes = document.querySelectorAll( '#'+ form + ' input[type="checkbox"]');
    const checkboxAlert = document.getElementById('checkboxAlert');
    const isAtLeastOneChecked = Array.from(checkboxes).some(
      (checkbox) => checkbox.checked,
    );
    if (isAtLeastOneChecked) {
      checkboxAlert.classList.add('hidden');
      return true;
    }
    else {
      checkboxAlert.classList.remove('hidden')
      return  false;
    }
  }
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
  document.getElementById('availability-form').addEventListener('submit',function(e){
    e.preventDefault();
    if (checkCheckboxes('availability-form')){

      let form_data = new FormData(e.target);
      $.ajax({
        url: 'ajax.php?action=AdminAddDoctorAvailability',
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        success: function(response) {
          if (parseInt(response) === 1) {
            toggleDialog('scheSet')
            e.target.reset();
            setTimeout(function() {
              toggleDialog('scheSet')
              window.location.href='admin-doctorSchedule.php';
            }, 3000);
          }
          }
        ,
      });
    }

  });
  document.getElementById('deleteSchedForm').addEventListener('submit', function(e){
    e.preventDefault()
    let form_data = new FormData(e.target);
    $.ajax({
      url: 'ajax.php?action=deleteSched',
      type: 'POST',
      data: form_data,
      processData: false,
      contentType: false,
      success: function(response) {
        if (parseInt(response) === 1) {
          window.location.href='admin-doctorSchedule.php';
        }
        console.log(response);
      },
    });
    });

</script>
</html>