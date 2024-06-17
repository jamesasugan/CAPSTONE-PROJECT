<?php
session_start();
include '../Database/database_conn.php';
if (!isset($_SESSION['user_type']) or $_SESSION['user_type'] !== 'patient') {
    header('Location: index.php');
}
include 'ReuseFunction.php';


$accountOwner_ID = $_SESSION['online_Account_owner_id'];
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
                  <li id="AccountMember" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                    Account Members
                  </li>
                    <li id="appointmentHistoryTab" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                        Appointment History
                    </li>


                  <li id="recordHistoryTab" class="sidebar-item cursor-pointer text-black dark:text-white py-2 px-4 transition-colors duration-200">
                    Record History
                  </li>
                </ul>
          </div>


          <div id="personalInfo" class="flex-1 p-0 sm:p-10">
            <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mb-4">
                Personal Information
              </h3>
              <form id="personal-info" action="#" method="POST" class="space-y-6">

              <!-- for profile image -->
              <div class="flex flex-col items-center">
                  <div class="w-32 h-32 relative">
                      <img src="../images/defaultprofile.jpg" alt="Profile Picture" class="w-full h-full rounded-full object-cover">
                      <!-- yang image na yan yung default profile kapag kakagawa lang ng account -->
                  </div>
                  <label class="block">
                    <input type="file" class="file-input bg-gray-400 text-black dark:text-white dark:bg-gray-600 border-none mt-3 file-input-bordered file-input-sm w-full max-w-xs cursor-pointer disabled:bg-gray-200 disabled:border-none" accept="image/*" disabled/>
                  </label>
              </div>


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
                      pattern="^\d{11}$"
                      minlength="11"
                      maxlength="11"
                      title="Please enter a 11-digit contact number."
                      class="numeric-input input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
                      oninput="validateNumericInput(this); setCustomValidity('');"
                      oninvalid="setCustomValidity(this.value.length !== 11 ? 'Please enter exactly 11 digits.' : '');"
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
                      class="dob-input input input-bordered w-full p-2 text-xs sm:text-lg bg-white dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
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
                      class="block font-medium text-black dark:text-white text-base sm:text-lg overflow-hidden whitespace-nowrap text-overflow-ellipsis">Email Address</label>
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
                  <div class="form-group col-span-1 sm:col-span-1">
                    <label for="weight" class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis">Weight (optional)</label>
                    <input id="weight" name="weight" type="text" value="" autocomplete="off" placeholder="Weight" class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white " />
                  </div>
                  <div class="form-group col-span-1 sm:col-span-1">
                    <label for="medicalCondition" class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis">Medical Conditions, if any:</label>
                    <input id="medicalCondition" name="medicalCondition" type="text" value="" autocomplete="off" placeholder="Medical Conditions" class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white " />
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
          <div id="passwordSection" class="flex-1 p-0 sm:p-10 hidden">
          <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mb-4">
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


          <div id="Memberstab" class="flex-1 p-0 sm:p-10 hidden">
            <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
                <div class="flex flex-col sm:flex-row sm:justify-between mb-3">
                  <h3 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mb-4 sm:mb-0">
                    Account Members
                  </h3>
                    <button class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none" onclick='toggleDialog("addRelative") ;
                  changeInputvalue("actionType","Add");changeInputvalue("accountmemeberID","0") '>Add a Member</button>
                </div>
                
              <div class="overflow-x-auto">
                <table class="table">
                  <!-- head -->
                  <thead>
                  <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                    <th>Name</th>
                    <th>Relationship Type</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $sql = "
    SELECT * FROM tbl_accountpatientmember WHERE user_info_ID = ? and status = 'Active' and RelationshipType != 'Self'";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param('i', $accountOwner_ID);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                          $middleInitial = strlen($row['Middle_Name']) >= 1 ? substr($row['Middle_Name'], 0, 1) : '';
                          echo '
            <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">               
                <td class="w-1/4">' . $row['First_Name'] . ' ' . $middleInitial . '. ' . $row['Last_Name'] . '</td>
                <td>' . $row['RelationshipType'] . '</td>
                <td class="w-1/12 pl-5"> 
                    <button  onclick="toggleDialog(\'addRelative\');getaccountMemberInfo('.$row['Account_Patient_ID_Member'].', '.$row['user_info_ID'].' )"><i class="fa-regular fa-eye"></i></button>
                    <a class="text-error m-2 cursor-pointer" onclick="toggleDialog(\'RemoveAppointmentAccountMember\');getMember_id('.$row['Account_Patient_ID_Member'].')"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>';
                      }
                  }
                  ?>

                  </tbody>
                </table>
              </div>

            </div>
          </div>
          <!-- Appointment Tab -->
          <div id="appointmentHistory" class="flex-1 p-0 sm:p-10 hidden">
            <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mb-4">
                Appointment History
              </h3>

              <div class="container mx-auto">
                <div class="flex flex-col gap-4 h-[calc(100vh-18rem)] overflow-y-auto">
                    <?php
                    $sql = "
                     SELECT `tbl_accountpatientmember`.*, `tbl_appointment`.*
FROM `tbl_accountpatientmember` 
JOIN `tbl_appointment` ON `tbl_appointment`.`Account_Patient_ID_Member` = `tbl_accountpatientmember`.`Account_Patient_ID_Member`
WHERE `tbl_accountpatientmember`.`user_info_ID` = ? 
ORDER BY 
    CASE 
        WHEN `tbl_appointment`.`Status` = 'pending' THEN 0
        WHEN `tbl_appointment`.`Status` = 'rescheduled' THEN 1
        WHEN `tbl_appointment`.`Status` = 'approved' THEN 2
        WHEN `tbl_appointment`.`Status` = 'completed' THEN 3
        ELSE 4
    END, 
    `tbl_appointment`.`Appointment_schedule` ASC;";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $accountOwner_ID);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $middleInitial = strlen($row['Middle_Name']) >= 1 ? substr($row['Middle_Name'], 0, 1).'.' : '';
                            $status_color = '';

                            if ($row['Status'] == 'pending') {
                                $status_color = 'text-yellow-600';
                            } elseif ($row['Status'] == 'completed') {
                                $status_color = 'text-green-500';
                            } elseif ($row['Status'] == 'approved') {
                                $status_color = 'text-blue-500';
                            } elseif ($row['Status'] == 'rescheduled') {
                                $status_color = 'text-yellow-600';
                            } elseif ($row['Status'] == 'cancelled') {
                                $status_color = 'text-red-500';
                            }
                            $appointment_schedule = $row['Appointment_schedule'];
                            $date = isset($appointment_schedule) ? date('F j, Y', strtotime($appointment_schedule)) : 'N/A';$time = isset($appointment_schedule) ? date('g:ia', strtotime($appointment_schedule)) : 'N/A';
                            $time = isset($appointment_schedule)
                                ? date('g:ia', strtotime($appointment_schedule)) . ' - ' . date('g:ia', strtotime($appointment_schedule . ' +30 minutes'))
                                : 'N/A';

                            echo '
                         <div class="card bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                      <h3 class="text-base sm:text-2xl font-semibold text-gray-900 dark:text-white">'.$row['First_Name'].' '.$middleInitial.' '.$row['Last_Name'].'</h3>
                      <p class="text-base sm:text-lg text-black dark:text-white font-bold">Status: <span class="'.$status_color.'">' . ucfirst($row['Status']) . '</span></p>
                    </div>
                      <div class="mt-2  text-sm sm:text-lg text-black dark:text-white">
                        <p><strong>Date:</strong> '.$date.'</p>
                        <p><strong>Time:</strong> '.$time.' </p>
                        <p><strong>Service:</strong> '.$row['ServiceType'].'</p>
                        <p><strong>Remarks:</strong>  '.$row['Remarks'].' </p>
                      </div>
                      <div class="mt-4 flex justify-end">';

                            if ($row['Status'] !== 'completed' and $row['Status'] !== 'cancelled'){
                                if ($row['Status'] == 'rescheduled'){
                                    echo '
                        <!-- <button class="btn btn-error">Cancel Appointment</button> -->
                        <button class="btn btn-success mr-3" onclick="toggleDialog(\'confirmAppointment\');
                         document.getElementById(\'confSchedIdLink\').setAttribute(\'data_id\','.$row['Appointment_ID'].')">Accept</button>
                        <button class="btn btn-error " onclick="toggleDialog(\'viewandCancel\') ;getAppointmentId('.$row['Appointment_ID'].')">Cancel Appointment</button>
                     ';
                                }else{
                                    echo '
                         <button class="btn btn-error" onclick="toggleDialog(\'viewandCancel\') ;getAppointmentId('.$row['Appointment_ID'].')">Cancel Appointment</button> 
                       ';
                                }
                            }
                            echo ' </div>
                  </div>';


                        }

                    }
                    ?>
                </div>
              </div>



             
            </div>
          </div>

          <div id="recordHistory" class="flex-1 p-0 sm:p-10 hidden">
            <div class="bg-gray-200 dark:bg-gray-700 p-5 rounded-lg h-full">
              <h3 class="text-2xl sm:text-3xl font-bold text-black dark:text-white mb-4">
                Record History
              </h3>
              <div class="overflow-x-auto">
                <table class="table">
                  <!-- head -->
                  <thead>
                  <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                    <th>Name</th>
                    <th>Consultant</th>
                    <th>Schedule </th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php


                  $getaccOwnerPatientChart = "
    SELECT *
    FROM tbl_patient_chart
    WHERE user_info_ID = ? 
    AND patient_Status IN ('To be Seen', 'Follow Up', 'Completed')
    ORDER BY followUp_schedule;
";

                  $stmt = $conn->prepare($getaccOwnerPatientChart);
                  $stmt->bind_param('i', $accountOwner_ID);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while ($row = $result->fetch_assoc()) {
                      $middleInitial = strlen($row['Middle_Name']) >= 1 ? substr($row['Middle_Name'], 0, 1) : '';
                      $date = date('F j, Y', strtotime($row['followUp_schedule']));
                      $time = date('g:ia', strtotime($row['followUp_schedule']));
                      $followUpschedule = ($date . ' ' . $time) == 'January 1, 1970 1:00am' ? 'No schedule' : $date . ' ' . $time;

                      $statusClass = '';
                      switch ($row['patient_Status']) {
                          case 'To be Seen':
                              $statusClass = 'text-yellow-600';
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
                      echo '
    <tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
        <td>' . $row['First_Name'] . ' ' . $middleInitial . '. ' . $row['Last_Name'] . '</td>
        <td>' . getPatientChartDoctor($row['Chart_id']) . '</td>
        <td>' . $followUpschedule . '</td>
        <td class="font-bold ' . $statusClass . '">' . $row['patient_Status'] . '</td>
        <!-- Status List
            To be seen = text-yellow-600 dark:text-yellow-300
            Follow Up = text-info
            Completed = text-green-500
            Waiting for Results = text-yellow-600 dark:text-yellow-300
            No Show =  text-red-500
        -->
        <!-- view information -->
        <td class="pl-9">
            <a href="patient-fullRecord.php?chart_id=' . $row['Chart_id'] . '"><i class="fa-regular fa-eye"></i></a>
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
    <dialog id="confirmAppointment"   class="modal bg-black  bg-opacity-40 ">
      <div class="card bg-slate-50 w-[80vw] absolute top-10 sm:w-[30rem] max-h-[35rem]  flex flex-col text-black">
        <div  class=" card-title sticky  w-full grid place-items-center">
          <h3 class="font-bold text-center text-lg  p-5 ">Confirm appointment?</h3>
        </div>
        <div class="p-4 w-full flex justify-evenly">
          <a  id="confSchedIdLink"  class="btn btn-info w-1/4"  onclick="console.log('asdasd');accept_Appointment(this.getAttribute('data_id'))">Yes</a>
          <button class="btn  btn-neutral  w-1/4 " onclick='toggleDialog("confirmAppointment")'>Close</button>
        </div>
      </div>
    </dialog>

      <dialog id="viewandCancel" class="modal bg-black bg-opacity-50">
        <dialog id='errorAlert' class='modal ' onclick='toggleDialog("errorAlert");toggleSecurityEdit(false);toggleEdit(false)' >
          <div class="flex justify-center bg-red-600" >
            <div role="alert" class="inline-flex items-center border  px-4 py-3 rounded relative">
              <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span id='errorAlert'>Something went wrong</span>
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


    <!-- add a relative modal -->
    <dialog id="addRelative"  class="modal bg-opacity-50 bg-black">
      <div class="modal-box w-11/12 max-w-7xl bg-gray-200 dark:bg-gray-700">

        <div class="flex flex-col sm:flex-row justify-between items-center">
          <div class="order-2 sm:order-1">
            <h3 class="font-bold text-black dark:text-white text-2xl sm:text-4xl mb-2 sm:mb-0">Add a Member</h3>
          </div>
          <div class="order-1 sm:order-2 mb-2 sm:mb-0">
            <img src="../images/HCMC-blue.png" class="block h-10 lg:h-16 w-auto dark:hidden" alt="logo-light" />
            <img src="../images/HCMC-white.png" class="h-10 lg:h-16 w-auto hidden dark:block" alt="logo-dark" />
          </div>
        </div>


        <form id="RelativeForm" action="#" method="GET" class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">    
              <div class="form-group">
                    <label for="relation" class="block font-medium text-black dark:text-white text-base sm:text-lg">
                      Relation to this person:
                    </label>
                    <select id="relation" name="relation" class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white" required onchange="handleRelationChange()">
                      <option value="">Select...</option>
                      <option value="Spouse">Spouse</option>
                      <option value="Child">Child</option>
                      <option value="Parent">Parent</option>
                      <option value="Sibling">Sibling</option>
                      <option value="Others">Others</option>
                    </select>
                </div>

                <div class="form-group" id="otherRelationContainer" style="display: none;">
                    <label for="otherRelation" class="block font-medium text-black dark:text-white text-base sm:text-lg">
                      Please specify:
                    </label>
                    <input type="text" id="otherRelation" name="otherRelation" placeholder="Type here..." class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white  whitespace-nowrap overflow-hidden text-ellipsis" />
                </div>
          </div>
              
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">           
                  <div class="form-group">
                    <label
                      for="relativeFname"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg overflow-hidden whitespace-nowrap text-overflow-ellipsis"
                      >First Name</label>
                    <input id="relativeFname" name="relativeFname" type="text" value="" autocomplete="off" required placeholder="First Name"
                      class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white  whitespace-nowrap overflow-hidden text-ellipsis" />
                  </div>
                  <div class="form-group">
                    <label for="relativeMiddlename" class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis ">Middle Name</label>
                    <input id="relativeMiddlename" name="relativeMiddlename" type="text" value="" autocomplete="off" required placeholder="Middle Name" class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white " />
                  </div>
                  <!-- Last Name & Contact Number -->
                  <div class="form-group">
                    <label for="relativeLastname" class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis">Last Name</label>
                    <input id="relativeLastname" name="relativeLastname" type="text" value="" autocomplete="off" required placeholder="Last Name" class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white "
                    />
                  </div>
                  <div class="form-group">
                    <label for="relativeWeight" class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis">Weight (optional)</label>
                    <input id="relativeWeight" name="relativeWeight" type="number" value="" autocomplete="off" placeholder="Weight" class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white " />
                  </div>
                  <!-- Date of Birth, Sex -->
                  <div class="form-group">
                    <label for="relativeDob" class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis">Date of Birth</label>
                    <input id="relativeDob" name="relativeDob" type="date" class="dob-input input input-bordered w-full p-2 text-xs sm:text-lg bg-white dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white " required />
                  </div>
                  <div class="form-group">
                    <label for="relativeSex" class="block font-medium text-black dark:text-white text-base sm:text-lg">Sex</label>
                    <select id="relativeSex" name="sex" class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white " required>
                      <option value="">Select...</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="relativeMedcondition" class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis">Medical Conditions, if any:</label>
                    <input id="relativeMedcondition" name="relativeMedcondition" type="text" value="" autocomplete="off" placeholder="Medical Conditions" class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white " />
                  </div>

                  <div class="form-group">
                    <div class="block text-base sm:text-lg font-medium mb-1 text-black dark:text-white">Does this person live with you?</div>
                    <div class="flex items-center space-x-4 p-2 bg-gray-300 dark:bg-gray-600 rounded">
                      <label class="flex items-center">
                        <input type="radio" name="addressInfo" value="Yes" class="radio radio-primary" required onchange="handleAddressChange()">
                        <span class="ml-2 text-black dark:text-white">Yes</span>
                      </label>
                      <label class="flex items-center">
                        <input type="radio" name="addressInfo" value="No" class="radio radio-primary" required onchange="handleAddressChange()">
                        <span class="ml-2 text-black dark:text-white">No</span>
                      </label>
                    </div>
                  </div>

                  <!-- Address -->
                  <div class="form-group col-span-1 md:col-span-2" id="addressContainer" style="display: none;">
                    <label for="relativeAddress" class="block font-medium text-black dark:text-white text-base sm:text-lg">Address</label>
                    <input id="relativeAddress" name="relativeAddress" type="text" placeholder="Address" class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white" />
                  </div>
                  <input type='hidden' value='' id='accountmemeberID' name='accountmemeberID'>
                  <input type='hidden' id='actionType'  name='actionType' value="Add">
                  <input type='hidden' name='onlineOwnerId' value='<?php echo $accountOwner_ID?>'>
                  
                </div>  
                
                <div class="flex justify-center">
                    <input  type="submit"  value="Submit" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-8">
                  </div>      

              </form>

        <div class="modal-action">
            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none" onclick='toggleDialog("addRelative") '>Close</button>
        </div>
      </div>
      <dialog id='memberErrorUpdate'  class='modal ' onclick='toggleDialog("memberErrorUpdate");' >
        <div class="flex justify-center bg-red-600" >
          <div role="alert" class="inline-flex items-center border  px-4 py-3 rounded relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id='memberErrorUpdatetext'>Something went wrong</span>
          </div>
        </div>
      </dialog>
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

    <dialog id="RemoveAppointmentAccountMember"   class="modal bg-black  bg-opacity-40 ">
      <div class="card bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1] w-[80vw] absolute top-10 sm:w-[30rem] max-h-[35rem]  flex flex-col">
        <div  class=" card-title sticky  w-full grid place-items-center">
          <h3 class="font-bold text-center text-lg  p-5 ">Remove this person from Account Members?</h3>
        </div>
        <div class="p-4 w-full flex justify-evenly">
          <a id="removeAppointmentAccountMemberLink"  class="btn btn-error w-1/4" onclick="removeAppointmentAccountMember(this.getAttribute('data_id'), <?php echo $accountOwner_ID?> )">Yes</a>
          <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black border-none" onclick='toggleDialog("RemoveAppointmentAccountMember")'>Close</button>
        </div>
      </div>
    </dialog>


      <script src='../js/usersInfo.js' ></script>
    <script>
      function getPatientAppointmentInfo(id) {
        $.ajax({
          url: 'ajax.php?action=getPatientApppointmentInfoJSON&data_id=' + encodeURIComponent(id),
          method: 'GET',
          dataType: 'json',
          success: function(data) {
            if (data) {
              const patientData = data[0];
              let formattedDateOfBirth = (new Date(patientData.DateofBirth)).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
              document.querySelector('#Patient_name').textContent = patientData.First_Name + ' ' + patientData.Middle_Name + ' ' + patientData.Last_Name;
              document.querySelector('#Patient_contact_number').textContent = patientData.Contact_Number;
              document.querySelector('#Patient_email').textContent = patientData.patientEmail;
              document.querySelector('#Patient_sex').textContent = patientData.Sex;
              document.querySelector('#Patient_address').textContent = patientData.Address;
              document.querySelector('#Patient_dateOfBirth').textContent = formattedDateOfBirth;
              document.querySelector('#Patient_vacStat').textContent = patientData.Vaccination;
              document.querySelector('#Patient_reasonn').textContent = patientData.reason;
            }
          },
          error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
          }
        });
      }
      function getMember_id(id) {
        document.getElementById('removeAppointmentAccountMemberLink').setAttribute('data_id', id);
      }
      function getaccountMemberInfo(id, AccownerId) {
        $.ajax({
          url: 'ajax.php?action=getAccountMemberDataJSON&data_id=' + encodeURIComponent(id) + '&SessionUserID=' + encodeURIComponent(AccownerId),
          method: 'GET',
          dataType: 'json',
          success: function(data) {
            if (data) {
              document.querySelector('#RelativeForm input[name="relativeFname"]').value = data.First_Name;
              document.querySelector('#RelativeForm  input[name="relativeMiddlename"]').value = data.Middle_Name;
              document.querySelector('#RelativeForm  input[name="relativeLastname"]').value = data.Last_Name;
              document.querySelector('#RelativeForm  input[name="relativeDob"]').value = data.DateofBirth;
              document.querySelector('#RelativeForm  input[name="relativeWeight"]').value = data.weight;
              document.querySelector('#RelativeForm  input[name="accountmemeberID"]').value = data.Account_Patient_ID_Member;
              document.querySelector('#RelativeForm  input[name="relativeMedcondition"]').value = data.Medical_condition;
              document.querySelector('#RelativeForm  input[name="actionType"]').value = 'Edit';

              document.querySelector('#RelativeForm  select[name="sex"]').value = data.Sex;
              let selectElement = document.querySelector('#RelativeForm select[name="relation"]');
              let dataExists = false;

              for (let i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].value === data.RelationshipType) {
                  dataExists = true;
                  break;
                }
              }

              if (dataExists) {
                selectElement.value = data.RelationshipType;
              } else {
                selectElement.value = 'Others'
              }

            } else {
              console.error('No data found for the given patient ID');
            }
          },
          error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
          }
        });
      }
      function removeAppointmentAccountMember(memberID, sessionUserID){
        $.ajax({
          url: 'ajax.php?action=DeleteAccountAppointmentMember&data_id=' + encodeURIComponent(memberID) + '&SessionUserID=' + encodeURIComponent(sessionUserID),
          method: 'GET',
          dataType: 'html',
          success: function(response) {
            if (parseInt(response) === 1) {
              window.location.href = 'patient-profile.php?route=AccountMembers';


            } else {
              console.error('No data found for the given patient ID');
            }
          },
          error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
          }
        });
      }


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
            <?php if (isset($_GET['route']) and $_GET['route'] == 'appointmentHistory'): ?>

            document.getElementById('appointmentHistoryTab').click();
            <?php elseif (isset($_GET['route']) and $_GET['route'] == 'AccountMembers'):?>
             document.getElementById('AccountMember').click();

      <?php else: ?>
          document.getElementById('personalInfoTab').click();
            <?php endif; ?>
        });

    </script>


    <script>
      function getAppointmentId(id) {
        let appoit_id = document.getElementById('appoint_id');
        appoit_id.value = id;
      }
      function accept_Appointment(appointmentID){
        $.ajax({
          url: 'ajax.php?action=AcceptResched&appointment_id=' + encodeURIComponent(appointmentID),
          method: 'GET',
          dataType: 'html',
          success: function(response) {
            if (parseInt(response) === 1) {

              $('#textInfo').html('Appointment Confirmed')
              toggleDialog('profileAlert');
              window.location.href='patient-profile.php?route=appointmentHistory';
            }
            console.log(response);
          }
        });

      }


    </script>

    <!-- script para sa others -->
    <script>
      function handleRelationChange() {
      const relationSelect = document.getElementById('relation');
      const otherRelationContainer = document.getElementById('otherRelationContainer');
      
      if (relationSelect.value === 'Others') {
        otherRelationContainer.style.display = 'block';
      } else {
        otherRelationContainer.style.display = 'none';
      }
    }

    function handleAddressChange() {
      const addressInfo = document.querySelector('input[name="addressInfo"]:checked').value;
      const addressContainer = document.getElementById('addressContainer');
      
      if (addressInfo === 'No') {
        addressContainer.style.display = 'block';
      } else {
        addressContainer.style.display = 'none';
      }
    }
    function changeInputvalue(inputID, value){
        document.getElementById(inputID).value = value
    }
    </script>

    </body>
  </html>

