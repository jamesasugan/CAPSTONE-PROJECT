<?php
session_start(); ?>

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

    <?php include 'staff-navbar.php'; ?>

    <div id="patients-recordTab" class="p-10 pt-32 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]">
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
              <td>Initial Visit</td>
              <!-- 
                Follow-up Visit
                Clearance Visit
               -->
              <td class="font-bold text-yellow-600 dark:text-yellow-300">To be Seen</td>
              <!-- Status List
                   Completed = text-green-500     
                   No Show =  text-red-500
            -->
              <td class="pl-9">
                <a href="staff-patientFullRecord.php"><i class="fa-regular fa-eye"></i></a>
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
