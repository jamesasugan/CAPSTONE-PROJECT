<?php
include '../Database/database_conn.php';
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'patient') {
    header('Location: index.php');
}
$user_id = $_SESSION['user_id'];
$sql = 'SELECT role from tbl_staff where User_ID = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['role'] == 'doctor') {
        header('Location: staff-index.php');
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accounts</title>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  </head>
  <body>

  <?php include 'admin-navbar.php'; ?>

    <div
      id="doctorAccounts"
      class="p-10 pt-24 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]"
    >

    <!-- add new doctor button -->
        <div class="flex justify-end mb-5">
            <a href="admin-addnewDoctor.php" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded cursor-pointer border-none">Add new Staff</a>
        </div>
        

        <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black">
        <h3
          class="text-2xl sm:text-xl md:text-3xl w-full font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase"
        >
        <!-- palitan mo na lang to -->
          <!-- <span>Patient</span> -->
          <span id='accounts_title'>Doctor Accounts</span>
        </h3>
        <form action="#" method="POST" class="w-full sm:flex sm:items-center justify-end">
          <select onchange='switchTable()' name="chooseAccount" class="select select-bordered w-full sm:w-60 bg-[#0b6c95] font-medium text-white text-base sm:text-lg lg:text-xl mb-4 sm:mb-0 sm:mr-4">
              <option selected>Doctor Accounts</option>
              <option>Patient Accounts</option>
          </select>

          <!-- Search Input and Button -->
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
      </div>

      <!-- Table ng Doctor Accounts -->
      <div
        class="bg-gray-200 dark:bg-gray-700 p-5 overflow-y-auto"
        style="max-height: calc(80vh - 100px)"
       id='doctorsList'>
        <table id='accounts_table_doctor' class="table w-full">
          <thead>
            <tr
              class="font-bold text-black dark:text-white text-base sm:text-lg"
            >
              <th>Name</th>
              <th>Specialty</th>
              <th>Account Status</th>
              <th>Account Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id='' class="text-black dark:text-white text-base sm:text-lg">
          <?php
          $sql = "SELECT `tbl_accounts`.*, `tbl_staff`.*
FROM `tbl_accounts` 
JOIN `tbl_staff` ON `tbl_staff`.`User_ID` = `tbl_accounts`.`User_ID` where role = 'doctor' ;";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->get_result();
          while ($row = $result->fetch_assoc()) {
              $middleInitial =
                  strlen($row['Middle_Name']) >= 1
                      ? substr($row['Middle_Name'], 0, 1)
                      : '';

              echo '<tr
              class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white"
            >
              <td>' . $row['First_Name'] . ' ' . $middleInitial . '. ' . $row['Last_Name'] . '</td>
              <td>' . $row['speciality'] . '</td>
               <td>' . $row['status'] . '</td>
              <td>' . $row['account_created'] . '</td>
              <td>
                <button onclick="view_doctor.showModal();getStaffInfo(' . $row['Staff_ID'] . ')"><i class="fa-regular fa-eye"></i></button>
                <a class="text-error ml-5"><i class="fa-solid fa-trash"></i></i></a>
              </td>
            </tr>';
          }
          ?>


          </tbody>
        </table>
      </div>
      <!-- Table ng Doctor Accounts end -->


      <!-- Table ng Patient Accounts -->
      <div
        class="bg-gray-200 dark:bg-gray-700 p-5 overflow-y-auto hidden"
        style="max-height: calc(80vh - 100px)"
        id='patientList' >
        <table id='accounts_table_patient'  class="table w-full ">
          <thead>
            <tr
              class="font-bold text-black dark:text-white text-base sm:text-lg"
            >
              <th>Name</th>
              <th>Account Status</th>
              <th>Account Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id='' class="text-black dark:text-white text-base sm:text-lg">
          <?php
          $patientQuery = "SELECT account_user_info.*, tbl_accounts.*
                          FROM account_user_info JOIN tbl_accounts ON account_user_info.User_ID = tbl_accounts.User_ID;";
          $patient_stmt = $conn->prepare($patientQuery);
          $patient_stmt->execute();
          $patient_res = $patient_stmt->get_result();
          while ($row = $patient_res->fetch_assoc()) {
              $middleInitial =
                  strlen($row['Middle_Name']) >= 1
                      ? substr($row['Middle_Name'], 0, 1)
                      : '';
              $age = date_diff(
                  date_create($row['DateofBirth']),
                  date_create('today')
              )->y;
              echo '<tr
              class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white"
            >
              <td>' . $row['First_Name'] . ' ' . $middleInitial . '. ' . $row['Last_Name'] . '</td>

              <td>' . $row['status'] . '</td>
              <td>' . $row['account_created'] . '</td>
              <td class="pl-9">
                 <button onclick="view_patient.showModal();getPatientInfo(' . $row['user_info_ID'] . ')"><i class="fa-regular fa-eye"></i></button>
                 <a class="text-error"><i class="fa-solid fa-trash"></i></i></a>
              </td>
            </tr>';
          }
          ?>
            <!-- sample row -->

            <!-- sample row end -->

          </tbody>
        </table>
      </div>
    </div>
    <!-- Table ng Patient Accounts -->

  <dialog id="view_doctor" class="modal">
    <div class="modal-box w-11/12 max-w-7xl bg-gray-200 dark:bg-gray-700">

      <div class="flex flex-col sm:flex-row justify-between items-center">
        <div class="order-2 sm:order-1">
          <h3 class="font-bold text-black dark:text-white text-2xl sm:text-4xl mb-2 sm:mb-0">Doctor Information</h3>
        </div>
        <div class="order-1 sm:order-2 mb-2 sm:mb-0">
          <img src="../images/HCMC-blue.png" class="block h-10 lg:h-16 w-auto dark:hidden" alt="logo-light" />
          <img src="../images/HCMC-white.png" class="h-10 lg:h-16 w-auto hidden dark:block" alt="logo-dark" />
        </div>
      </div>

      <div class="patientInfo mb-10 mt-5 text-black dark:text-white">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-1 text-lg sm:text-xl">
          <p><strong>Name: </strong> <span id='Staff_name'>Walter White</span></p>

          <p><strong>Specialty: </strong><span id='Staff_speciality'> Pediatrics</span></p>
          <p><strong>Contact Number: </strong><span id='Staff_contact_number'> 099999999999</span></p>

          <p><strong>Email: </strong> <span id='Staff_email'>myemail@gmail.com</span></p>
          <p><strong>Sex: </strong> <span id='Staff_sex'>Male</span></p>


          <p><strong>Address: </strong><span id='Staff_address'> 1234 Health Ave, Immunization City</span></p>
          <p><strong>Date of Birth: </strong><span id='Staff_dateOfBirth'> June 21, 2024</span></p>
        </div>
      </div>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
        </form>
      </div>
    </div>
  </dialog>


  <dialog id="view_patient" class="modal">
    <div class="modal-box w-11/12 max-w-7xl bg-gray-200 dark:bg-gray-700">

      <div class="flex flex-col sm:flex-row justify-between items-center">
        <div class="order-2 sm:order-1">
          <h3 class="font-bold text-black dark:text-white text-2xl sm:text-4xl mb-2 sm:mb-0">Patient Information</h3>
        </div>
        <div class="order-1 sm:order-2 mb-2 sm:mb-0">
          <img src="../images/HCMC-blue.png" class="block h-10 lg:h-16 w-auto dark:hidden" alt="logo-light" />
          <img src="../images/HCMC-white.png" class="h-10 lg:h-16 w-auto hidden dark:block" alt="logo-dark" />
        </div>
      </div>

      <div class="patientInfo mb-10 mt-5 text-black dark:text-white">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-1 text-lg sm:text-xl">
          <p><strong>Name:</strong> <span id='patient_name'> Johny Edward Dionisio </span></p>
          <p><strong>Account Created: </strong> <span id='patient_Account_created'> May 21, 2024</span></p>

          <p><strong>Age: </strong> <span><span id='patient_age'> 21 </span></p>
          <p><strong>Sex: </strong><span id='patient_sex'> Male</p>

          <p><strong>Email: </strong><span id='patient_email'> myemail@gmail.com </span></p>
          <p><strong>Contact Number: </strong><span id='patient_contactNumber'> myemail@gmail.com </span></p>

          <p><strong>Address: </strong><span id='patient_address'> 1234 Health Ave, Immunization City </span></p>
          <p><strong>Date of Birth: </strong><span id='patient_Date_ofBirth'> June 21, 2024 </span></p>
        </div>
      </div>
      <!-- modal close btn -->
      <div class="modal-action">
        <form method="dialog">
          <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
        </form>
      </div>
    </div>
  </dialog>
<script src='../js/admin-accounts.js'></script>

  </body>
  <script src='../js/SearchTables.js'></script>
</html>
