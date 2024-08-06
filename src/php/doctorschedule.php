<!-- patient only -->

<?php
session_start();
require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::PATIENT]))
{
  return;
}

include_once '../Database/database_conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Schedule</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
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

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>




</head>
<body>

    <?php include 'navbar.php'; ?>
    
    <section class="w-full min-h-screen bg-[#ebf0f4] dark:bg-[#0b1014] text-[#0e1011] dark:text-[#eef0f1]">
        <div class="mx-auto min-h-screen bg-[#f6fafc] dark:bg-[#222f3a] shadow-lg p-5 pt-28 w-full max-w-full">
            <div class="title w-full text-center font-bold">
                <h1 class="text-3xl mb-2">Doctor's Schedule</h1>
            </div>
            <div class="instructions-tab w-full text-center text-base font-medium mb-2">
                <p><span class="font-bold">Note:</span> Yellow Color Coded dates indicates that the date has a scheduled doctor. Click "View Schedule" to view the details.</p>
            </div>
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
                                placeholder="Search" onkeyup="handleSearch('Search_input', getVisibleTableId())"
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
        </div>
    </section>




</body>
</html>