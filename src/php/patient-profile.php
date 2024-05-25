<?php
session_start();
include '../Database/database_conn.php';
if (!isset($_SESSION['user_type']) or $_SESSION['user_type'] !== 'patient') {
    header('Location: index.php');
}
include "ReuseFunction.php";
$user_id = $_SESSION['user_id'];






?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Settings</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
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
    <script src="../js/patient-profile.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  </head>
  <body>

    <?php include 'navbar-main.php'; ?>

    <div class="flex flex-col sm:flex-row justify-center items-center">
    <div class="bg-[#ebf0f4] dark:bg-[#17222a] p-5 w-full min-h-screen pt-10 sm:pt-20">
        <!-- Responsive Sidebar for profile settings -->
        <div class="flex flex-col sm:flex-row">
        <div class="w-full sm:w-80 p-5 border-b sm:border-b-0 sm:border-r mt-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mt-5 sm:mt-0">
                    Profile Settings
                </h2>
                <ul class="mt-5 text-lg sm:text-xl">
                    <li id="personalInfoTab" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                        Personal Information
                    </li>
                    <li id="passwordTab" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                        Password
                    </li>
                    <li id="appointmentHistoryTab" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                        Appointment History
                    </li>
                    <li id="recordHistoryTab" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                        Record History
                    </li>
                </ul>
          </div>


          <div id="personalInfo" class="flex-1 p-10">
            <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl font-bold text-black dark:text-white mb-4">
                Personal Information
              </h3>
              <form id="personal-info" action="#" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  
                  <div class="form-group">
                    <label
                      for="first-name"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg overflow-hidden whitespace-nowrap text-overflow-ellipsis"
                      >First Name</label
                    >
                    <input
                      id="first-name"
                      name="first-name"
                      type="text"
                      value=""
                      autocomplete="off"
                      required
                      disabled
                      placeholder="First Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300 whitespace-nowrap overflow-hidden text-ellipsis"
                      
                    />
                  </div>
                  <div class="form-group">
                    <label
                      for="middle-name"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis "
                      >Middle Name</label
                    >
                    <input
                      id="middle-name"
                      name="middle-name"
                      type="text"
                      value=""
                      autocomplete="off"
                      required
                      disabled
                      placeholder="Middle Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                  <!-- Last Name & Contact Number -->
                  <div class="form-group">
                    <label
                      for="last-name"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                      >Last Name</label
                    >
                    <input
                      id="last-name"
                      name="last-name"
                      type="text"
                      value=""
                      autocomplete="off"
                      required
                      disabled
                      placeholder="Last Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                  <div class="form-group">
                    <label
                      for="contact-number"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                      >Contact Number</label
                    >
                    <input
                      id="contact-number"
                      name="contact-number"
                      type="tel"
                      value=""
                      required
                      disabled
                      placeholder="Contact Number"
                      pattern="[0-9]{1,11}"
                      minlength="11"
                      maxlength="11"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                  <!-- Date of Birth, Sex -->
                  <div class="form-group">
                    <label
                      for="dob"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                      >Date of Birth</label
                    >
                    <input
                      id="dob"
                      name="dob"
                      type="date"
                      disabled
                      class="input input-bordered w-full p-2 text-xs sm:text-lg bg-white dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      required
                      
                    />
                  </div>
                  <div class="form-group">
                    <label
                      for="sex"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg"
                      >Sex</label
                    >
                    <select
                      id="sex"
                      name="sex"
                      class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      required
                      disabled
                    >
                      <option value="">Select...</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <!-- Address -->
                  <div class="form-group col-span-1 sm:col-span-">
                    <label
                      for="address"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg "
                      >Address</label
                    >
                    <input
                      id="address"
                      name="address"
                      type="text"
                      disabled
                      required
                      autocomplete="off"
                      placeholder="Address"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                  <!-- Email -->
                  <div class="form-group col-span-1 sm:col-span-1">
                    <label
                      for="email"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg overflow-hidden whitespace-nowrap text-overflow-ellipsis"
                      >Email Address</label
                    >
                    <input
                      id="email"
                      name="email"
                      type="email"
                      disabled
                      autocomplete="email"
                      required
                      placeholder="Email"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      
                    />
                  </div>
                </div>
                <div class="flex justify-end space-x-2">
                        <button id="editButton" type="button" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7">
                            Edit
                        </button>
                        <input id="updateButton" type="submit" value="Update" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none hidden" onclick="toggleEdit(true)">               
                        <button id="cancelButton" type="button" class="btn bg-white text-black hover:bg-gray-400 border-none hidden" onclick="toggleEdit(false)">
                            Cancel
                        </button>
                    </div>

                    <!-- pashow nito pag nag update info patient -->

                 
              </form>
            </div>
          </div>

          <!-- Password tab -->
          <div id="passwordSection" class="flex-1 p-10 hidden">
          <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl font-bold text-black dark:text-white mb-4">
                  Password
              </h3>
              <form id="security-form" action="#" method="POST" class="space-y-6">
                <input type='hidden' name='editPass' value='true'>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <!-- Password Field -->
                      <div class="form-group">
                          <label for="password" class="block font-medium text-black dark:text-white">Password</label>
                          <div class="relative">
                              <input id="password" 
                                  type="password"
                                     name="newPass"
                                  required
                                  disabled
                                  autocomplete="off" 
                                  placeholder="Password" 
                                  class="input input-bordered w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"/>
                                  <button 
                                  type="button" 
                                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                    <span id="password-icon" class="fas fa-eye"></span>
                                </button>

                          </div>
                      </div>

                      <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="confirm-password" class="block font-medium text-black dark:text-white">Confirm Password</label>
                    <div class="relative">
                      <input id="confirm-password" 
                      type="password"
                             name="confPass"
                      required 
                      disabled
                      autocomplete="off" 
                      placeholder="Confirm Password" 
                      class="input input-bordered w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"/>
                      <button 
                      type="button" 
                      class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <span id="confirm-password-icon" class="fas fa-eye"></span>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Requirements List (only displayed during password change) -->
                <div class="requirement-list hidden">
                  <li><i class="fa-solid fa-circle"></i> At least 8 characters</li>
                  <li><i class="fa-solid fa-circle"></i> At least one digit</li>
                  <li><i class="fa-solid fa-circle"></i> At least one UPPERCASE letter</li>
                  <li><i class="fa-solid fa-circle"></i> No special characters</li>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-2">
                  <button id="editSecurityBtn" type="button" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7" onclick="toggleSecurityEdit(true)">
                      Edit
                  </button>

                    <input id="updateSecurityBtn" type="submit" value="Update" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none hidden" onclick="toggleSecurityEdit(true)">
                    <button id="cancelSecurityBtn" type="button" class="btn bg-white text-black hover:bg-gray-400 border-none hidden" onclick="toggleSecurityEdit(false)">
                        Cancel
                    </button>
                </div>
              </form>
          </div>
        </div>

        <!-- Appointment Tab -->
        <div id="appointmentHistory" class="flex-1 p-10 ">
          <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl font-bold text-black dark:text-white mb-4">
                  Appointment History
              </h3>
              <div class="overflow-x-auto">
                <table class="table">
                  <!-- head -->
                  <thead>
                    <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                      <th>Name</th>
                      <th>Date </th>
                      <th>Time</th>
                      <th>Status</th>
                      <th>Remarks</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php

                      $sql = "
                      SELECT `tbl_patient`.*, `tbl_appointment`.*
FROM `account_user_info`
JOIN `tbl_patient` ON `tbl_patient`.`user_info_ID` = `account_user_info`.`user_info_ID`
JOIN `tbl_appointment` ON `tbl_appointment`.`Patient_ID` = `tbl_patient`.`Patient_ID`
WHERE `account_user_info`.`User_ID` = ?
ORDER BY CASE WHEN `tbl_appointment`.`Status` = 'pending' THEN 0 ELSE 1 END, `tbl_appointment`.`AppointmentCreated`;
";
                      $stmt = $conn->prepare($sql);
                      $stmt->bind_param('i', $user_id);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              $middleInitial =
                                  strlen($row['Middle_Name']) >= 1
                                      ? substr($row['Middle_Name'], 0, 1)
                                      : '';
                              $status_color = '';

                              if ($row['Status'] == 'pending') {
                                  $status_color = 'text-yellow-600';
                              } elseif ($row['Status'] == 'completed') {
                                  $status_color = 'text-green-500';
                              } elseif ($row['Status'] == 'approved') {
                                  $status_color = 'text-blue-500';
                              } elseif ($row['Status'] == 'cancelled') {
                                  $status_color = 'text-red-500';
                              }
                              $appointment_schedule =
                                  $row['Appointment_schedule'];
                              $date = isset($appointment_schedule)
                                  ? date(
                                      'F j, Y',
                                      strtotime($appointment_schedule)
                                  )
                                  : 'N/A';
                              $time = isset($appointment_schedule)
                                  ? date(
                                      'g:ia',
                                      strtotime($appointment_schedule)
                                  )
                                  : 'N/A';
                              echo '
                         <tr class="text-base hover:bg-gray-300  dark:hover:bg-gray-600 font-medium text-black dark:text-white">               
                        <td>' . $row['First_Name'] . ' ' . $middleInitial . ' ' .
                                  $row['Middle_Name'] . '</td>
          
                       <td>' . $date . '</td>
                        <td>' . $time . '</td>
                       <td class="font-bold  ' . $status_color . ' ">' . ucfirst($row['Status']) . '</td> 
                       <td>' . $row['Remarks'] . '</td>';
                              if ($row['Status'] == 'pending') {
                                echo '<td class="pl-9"> 
                          <button onclick="toggleDialog(\'viewandCancel\');getAppointmentId(' . $row['Appointment_ID'] . ')"><i class="fa-regular fa-eye"></i></button>
                        </td>';
                              }
                              echo '</tr>';
                          }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>

            </div>
          </div>

          <div id="recordHistory" class="flex-1 p-10 hidden">
          <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl font-bold text-black dark:text-white mb-4">
                  Record History
              </h3>
              <div class="overflow-x-auto">
                <table class="table">
                  <!-- head -->
                  <thead>
                    <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                      <th>Name</th>
                      <th>Last visit</th>
                      <th>Schedule </th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                    <tbody>
                    <?php
                    $getAccOwner_Info = "
        SELECT *  FROM account_user_info
        WHERE User_ID = ?;
    ";
                    $getAccOwner_InfoSTMT = $conn->prepare($getAccOwner_Info);
                    $getAccOwner_InfoSTMT->bind_param('i', $user_id);
                    $getAccOwner_InfoSTMT->execute();
                    $res = $getAccOwner_InfoSTMT->get_result();
                    $row = $res->fetch_assoc();

                    $accountOwner_ID = $row['user_info_ID'];

                    $getaccOwnerPatientChart = "SELECT pc.Chart_id,p.Patient_ID, p.First_Name, p.Middle_Name, 
       p.Last_Name, pc.followUp_schedule, pc.patient_Status FROM tbl_patient_chart AS pc 
           JOIN tbl_appointment AS a ON pc.Appointment_id = a.Appointment_ID 
           JOIN tbl_patient AS p ON a.Patient_ID = p.Patient_ID 
            WHERE p.user_info_ID = ?
              AND pc.patient_Status IN ('To be Seen', 'Follow Up', 'Completed')
            ORDER BY pc.followUp_schedule;

";

                    $stmt = $conn->prepare($getaccOwnerPatientChart);
                    $stmt->bind_param('i', $accountOwner_ID);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row= $result->fetch_assoc()){
                        $middleInitial = (strlen($row['Middle_Name']) >= 1) ? substr($row['Middle_Name'], 0, 1) : '';
                        $date = date("F j, Y", strtotime($row['followUp_schedule']));
                        $time = date("g:ia", strtotime($row['followUp_schedule']));
                        $followUpschedule = $date . ' ' . $time == 'January 1, 1970 1:00am' ? "No schedule" : $date . ' ' . $time;

                        $statusClass = '';
                        switch ($row['patient_Status']) {
                            case 'To be seen':
                                $statusClass = 'text-yellow-600 dark:text-yellow-300';
                                break;
                            case 'Follow Up':
                                $statusClass = 'text-info';
                                break;
                            case 'Completed':
                                $statusClass = 'text-green-500';
                                break;
                            default:
                                $statusClass = ''; // Default class if none of the above match
                                break;
                        }
                        echo '<tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
              <td>'.$row['First_Name'].' '.$middleInitial.'.. '.$row['Last_Name'].'</td>
         
              <td>'.getLastPatientVisit($row['Chart_id']).'</td>
       
              <td>'.$followUpschedule.'</td>
              <td class="font-bold '.$statusClass.'">'.$row['patient_Status'].'</td>
              <!-- Status List
                   To be seen = text-yellow-600 dark:text-yellow-300
                   Follow Up = text-info
                   Completed = text-green-500
                   Waiting for Results = text-yellow-600 dark:text-yellow-300
                   No Show =  text-red-500
            -->

              <!-- view information -->
              <td class="pl-9 ">
                <a href="patient-fullRecord.php?id='.$row['Patient_ID'] .'&chart_id='. $row['Chart_id'].'"><i class="fa-regular fa-eye"></i></a>
                </td>
            </tr>
                ';
                    }

                    ?>
                    </tbody>
                  </table>
                </div>

            </div>
          </div>

          </div>
        </div>
      </div>


      <dialog id="viewandCancel" class="modal bg-black bg-opacity-50">
        <dialog id='errorAlert' class='modal ' onclick='toggleDialog("errorAlert");toggleSecurityEdit(false);toggleEdit(false)' >
          <div class="flex justify-center bg-red-600" >
            <div role="alert" class="inline-flex items-center border  px-4 py-3 rounded relative">
              <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span id='errorAlert'>Somthing went wrong</span>
            </div>
          </div>
        </dialog>
        <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700">
          <h3 class="font-bold text-xl text-black dark:text-white mt-10">Do you want to Cancel your Appointment?</h3>
          <p class="font-bold text-red-400">This action is permanent and cannot be undone.</p>
          <p class="mt-2 text-black dark:text-white">Please enter your password to avoid accidentally cancelling your Appointment</p>
          <form id='cancel_appoinment' action="#" method="POST">
            <div class="form-group mb-4">
              <label for="dlt-password" class="block font-medium text-black dark:text-white">Confirm Password</label>
              <div class="relative">
                <input id="dlt-password" name='conf_pass' type="password" required autocomplete="off" placeholder="Enter your password"
                       class="input input-bordered w-full px-3 py-2 border border-gray-300 rounded-md
                       shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white dark:bg-gray-600 text-black dark:text-white">
              </div>
              <input type='hidden' id='appoint_id' name='appointment_id' value=''>
            </div>
            <input type="submit" value="Submit" class="btn btn-error hover:bg-red-700 text-white font-bold border-none px-7">
          </form>
          <div class="modal-action">
            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none" onclick='toggleDialog("viewandCancel")'>Close</button>
          </div>
        </div>

      </dialog>
    <dialog id='profileAlert' class='modal' onclick='toggleDialog("profileAlert");toggleSecurityEdit(false);toggleEdit(false)' >
      <div class="flex justify-center" >
        <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span id='textInfo'></span>
        </div>
      </div>
    </dialog>

      <script src='../js/usersInfo.js' defer></script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
          const items = document.querySelectorAll('.sidebar-item');
          items.forEach((item) => {
            item.addEventListener('click', function () {
              items.forEach((innerItem) => {
                // Remove active classes
                innerItem.classList.remove('bg-[#0b6c95]', 'text-white', 'font-bold');
                innerItem.classList.add('text-black', 'dark:text-white');
              });
              // Add active classes to the clicked item
              item.classList.add('bg-[#0b6c95]', 'text-white', 'font-bold');
              item.classList.remove('text-black', 'dark:text-white');
            });
          });
            <?php
            if (isset($_GET['route']) and $_GET['route'] == 'appointmentHistory'):
            ?>
          // Set initial active state
          document.getElementById('appointmentHistoryTab').click();
            <?php else:?>
          document.getElementById('personalInfoTab').click();
            <?php
            endif;
            ?>
        });

    </script>


    <script>
      function getAppointmentId(id) {
        let appoit_id = document.getElementById('appoint_id');
        appoit_id.value = id;
      }


    </script>

    </body>
  </html>

