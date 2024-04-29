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
    <link rel="stylesheet" href="../css/services-swiper.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/main.js" defer></script>
    <script src="../js/calendar.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body>

    <?php include 'navbar-main.php'; ?>
    
    <section class="w-full min-h-screen bg-[#ebf0f4] dark:bg-[#0b1014] text-[#0e1011] dark:text-[#eef0f1]">
            <div class="mx-auto bg-white dark:bg-[#222f3a] shadow-lg p-5 pt-28 w-full max-w-full">
                <div class="title flex text-center justify-center font-bold">
                    <h1 class="text-3xl mb-2">Doctor's Schedule</h1>
                </div>
                <div class="instructions-tab text-center text-base font-medium mb-2">
                    <p><span class="font-bold">Note:</span> Yellow Color Coded dates indicates that the date has a scheduled doctor. Click "View Schedule" to view the details.</p>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-center border-t border-t-black dark:border-t-white dark:border-x-white px-2 py-2 border-x border-x-black">     
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
                <div id="calendar" class="overflow-x-auto w-full">
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