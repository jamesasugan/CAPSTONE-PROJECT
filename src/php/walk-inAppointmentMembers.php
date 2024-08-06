<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Records</title>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
<?php include 'navbar.php'; ?>
    <div id="appointmentRecordsTab" class="p-10 pt-24 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]">
      <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black">
            <h3 class="text-lg text-center sm:text-start sm:text-3xl w-full font-bold text-black dark:text-white uppercase">
                Appointment Patient List
            </h3>
        <div class="w-full sm:flex sm:items-center justify-end">
            <!-- Search Input and Button -->
            <div class="flex w-full sm:w-auto">
            <input
                id='search'
                type="text"
                name="text"
                class="input input-bordered appearance-none w-full px-3 py-2 rounded-none bg-white dark:bg-gray-600 text-black dark:text-white border border-black border-r-0 dark:border-white"
                placeholder="Search"
                onkeyup='handleSearch("search", "TableList")'
            />
            <button type="submit" class="btn btn-square bg-gray-400 hover:bg-gray-500  rounded-none dark:bg-gray-500 dark:hover:bg-gray-300 border border-black border-l-0 dark:border-white">
                <i class="fa-solid fa-magnifying-glass text-black dark:text-white"></i>
            </button>
            </div>
        </div>
      </div>
      <!-- Table Container with scrolling -->
      <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden" style="max-height: calc(80vh - 100px)">
        <div class="p-5">
          <div style="overflow-y: auto; max-height: calc(75vh - 100px);">
            <table class="table w-full" id='TableList'>
              <thead class="sticky top-0 bg-neutral-300 dark:bg-gray-500 z-10" style="top: -1px;">
                <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                  <th class='cursor-pointer'>Name</th>
                  <th class='cursor-pointer'>Contact Number</th>
                  <th class='cursor-pointer' >Email</th>
                  <th class='cursor-pointer'>Action</th>
                </tr>
              </thead>
              <tbody class="text-black dark:text-white text-base sm:text-lg">
                <!-- sample row -->
                <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                    <td class="w-1/4">Rio Carl Dela Cruz</td>
                    <td>09512832512</td>
                    <td>riocarldelacruz@gmail.com</td>
                    <td><span class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded cursor-pointer border-none">Book this Patient</span></td>
                </tr> 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
</body>
</html>