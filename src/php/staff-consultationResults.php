<?php
session_start();
require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::STAFF]))
{
  return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Records</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/staff.css" />
    <link rel="stylesheet" href="../css/toast.css">
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/main.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<?php  
    include 'navbar.php';
    ?>

    <div class="p-10 pt-24 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]">
        <div class="text-center text-black dark:text-white mt-3 mb-3">
            <h1 class="text-2xl sm:text-4xl font-bold text-black dark:text-white uppercase">Consultation Records</h1>
        </div>

        <div class="flex justify-between mb-3"> 
            <button class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none" onclick="addFollowUp.showModal()">View/Add Follow Up Schedule</button>   
            <a href="#" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none">Add New Record</a>
        </div>

       


        <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black">
            <h3 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mb-4 sm:mb-0 mr-0 sm:mr-10">
                Franklin C. Saint
            </h3>

            <div class="flex w-full sm:w-auto">
                <input type="text" name="text" id='searchConsultation' class="input input-bordered appearance-none w-full px-3 py-2 rounded-none bg-white dark:bg-gray-600 text-black dark:text-white border border-black border-r-0 dark:border-white" placeholder="Search"/>
                <button type="submit" class="btn btn-square bg-gray-400 hover:bg-gray-500  rounded-none dark:bg-gray-500 dark:hover:bg-gray-300 border border-black border-l-0 dark:border-white">
                <i class="fa-solid fa-magnifying-glass text-black dark:text-white"></i>
                </button>
            </div>
        </div>

        <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden" style="max-height: calc(80vh - 100px);">
            <div class="p-5">
                <div style="overflow-y: auto; max-height: calc(65vh - 100px);">
                    <table class="table w-full" id="TableList">
                        <thead class="sticky top-0 bg-neutral-300 dark:bg-gray-500" style="top: -1px;">
                            <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                                <th>#</th>
                                <th>Service</th>
                                <th>Consultation Date</th>
                                <th class="pl-6 sm:pl-9">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-black dark:text-white text-base sm:text-lg">
                            <tr class="hover:bg-gray-300 dark:hover:bg-gray-600">
                                <td>1</td>
                                <td class="w-1/2">
                                    <li>Flu Vaccine</li>
                                    <li>Pneumococcal Vaccine Measles, Mumps, and Rubella Vaccine</li>
                                    <li>Monthly Immunization for babies</li>
                                    <li>Polio Vaccine</li>
                                </td>
                                <td>July 21, 2024</td>
                                <td> 
                                    <a href="staff-patientOverallRecord.php" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none" target="_blank">View More</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- labas mo to pag blangko -->
                    <h1 class="text-center font-medium text-2xl text-black dark:text-white mt-5">No Records</h1>

                </div>
            </div>
        </div>

         <!-- alert templates -->
         <!-- <div class="toastButtons">
            <button onclick="showToast()">Success</button>
            <button onclick="showToast()">Error</button>
            <button onclick="showToast()">Invalid</button>
         </div>
         <div id="toastBox"></div> -->
        <!-- alert templates -->
        
    </div>

    





    
    <dialog id="addFollowUp" class="modal">
        <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 font-bold text-2xl">✕</button>
            </form>

            <div id="followUpDetails" class="mt-8">
                <h2 class="text-2xl text-center font-semibold">Schedule the Patient for another Check-Up:</h2>

                <div class="flex justify-center mt-5">
                    <div class="w-1/2">
                    <form method="GET">
                        <label for="appointment-date" class="block text-md font-medium"> 
                            Follow Up Date: <span id='appointmentDateNote' class='text-base text-error hidden'> (NOT Available, please select another day)</span>
                        </label>
                        <input type="date" id="appointment-date" name="followUpDate" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]"/>
                        
                        <label for="appointment-time" class="block text-md font-medium">
                            Follow Up Time:
                        </label>
                        <select id="appointment-time"  required name="followUpTime" class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]">
                        </select>

                        <div class="flex justify-center mt-2">
                            <input type="submit" value="Submit" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none">
                        </div>
                    </form>
                    </div>
                </div>
            </div>

        </div>
    </dialog>

    <!-- script for toastAlerts only -->
    <!-- <script>

        let toastBox = document.getElementById('toastBox');
        
        function showToast(){
           let toast = document.createElement('div');
           toast.classList.add('toast');
           toast.innerHTML = 'Success';
           toastBox.appendChild(toast);
        }

    </script> -->
    

    <script src='../js/doctorAppoimtmentAvailability.js'></script>
</body>
</html>