<?php
session_start();
require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::ADMIN]))
{
  return;
}

include '../Database/database_conn.php';

function getAssignDoctor($staff_id)
{
    include '../Database/database_conn.php';
    if (!isset($staff_id)) {
        return 'N/A';
    }

    $sql =
        'SELECT First_Name, Middle_Name, Last_Name FROM tbl_staff WHERE Staff_ID = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $staff_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $middle_name, $last_name);
    $stmt->fetch();

    if ($middle_name) {
        $middle_name = substr($middle_name, 0, 1) . '.';
    }
    $full_name = $middle_name
        ? "$first_name $middle_name $last_name"
        : "$first_name $last_name";
    $stmt->close();
    $conn->close();

    return $full_name;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Appointments</title>
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
    <script src="../js/admin-appointments.js" defer></script>
    <script src="../js/SearchTables.js" defer></script>
  </head>
  <body>
  <?php include 'admin-navbar.php'; ?>
    <div id="appointmentRecordsTab" class="p-10 pt-24 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]">
      <div class="flex justify-end">
        <a href="addwalkInPatient.php" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded cursor-pointer border-none mb-4">Add Walk In patient</a>
      </div>

      <!-- filter option -->
      <!-- <div class="flex justify-center">
          <div class="w-full sm:w-1/2 bg-gray-200 dark:bg-gray-800 rounded-lg mb-5 p-4 text-black dark:text-white">  
            <h1 class="text-center text-xl font-bold mb-3">Filter Options</h1>
            <div class="flex justify-center">
                <div class="w-full grid gap-2" id="filterVisit">
                    <p class="font-medium text-center sm:text-left">Visit Type:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <label class="flex items-center justify-center bg-white dark:bg-gray-700 text-black dark:text-white px-3 py-2 rounded cursor-pointer">
                            <input type="checkbox" class="hidden" value="Consultation">
                            <span class="text-sm">Consultation</span>
                        </label>
                        <label class="flex items-center justify-center bg-white dark:bg-gray-700 text-black dark:text-white px-3 py-2 rounded cursor-pointer">
                            <input type="checkbox" class="hidden" value="Test/Procedure">
                            <span class="text-sm">Test/Procedure</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-2">
                <div class="w-full grid gap-2" id="filterStatus">
                    <p class="font-medium text-center sm:text-left">Status:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                        <label class="flex items-center justify-center bg-white dark:bg-gray-700 text-black dark:text-white px-3 py-2 rounded cursor-pointer">
                            <input type="checkbox" class="hidden" value="Pending">
                            <span class="text-sm">Pending</span>
                        </label>
                        <label class="flex items-center justify-center bg-white dark:bg-gray-700 text-black dark:text-white px-3 py-2 rounded cursor-pointer">
                            <input type="checkbox" class="hidden" value="Approved">
                            <span class="text-sm">Approved</span>
                        </label>
                        <label class="flex items-center justify-center bg-white dark:bg-gray-700 text-black dark:text-white px-3 py-2 rounded cursor-pointer">
                            <input type="checkbox" class="hidden" value="Rescheduled">
                            <span class="text-sm">Rescheduled</span>
                        </label>
                        <label class="flex items-center justify-center bg-white dark:bg-gray-700 text-black dark:text-white px-3 py-2 rounded cursor-pointer">
                            <input type="checkbox" class="hidden" value="Cancelled">
                            <span class="text-sm">Cancelled</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-2">
              <small id="removeAllButton" class="bg-red-500 text-white px-1 rounded hover:bg-red-600 cursor-pointer">Remove All</small>
            </div>
          </div>
      </div> -->

      <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black">
                <h3 class="text-2xl sm:text-xl md:text-3xl font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase mr-0 sm:mr-10">
                  Appointments
                </h3>
      <div class="w-full sm:flex sm:items-center justify-end">

        <select onchange='if (this.value === "none") { resetSearch("TableList"); } else { handleSearch("dropDownSort", "TableList", this.value); }' id='dropDownSort' name="sort" class="select select-bordered w-full sm:w-48 bg-[#0b6c95] font-medium text-white text-base sm:text-lg lg:text-xl mb-4 sm:mb-0 sm:mr-4">
          <option selected value='none'>Filter</option>
          <optgroup label="Status">
            <option value='Pending' <?php echo isset($_GET['filter']) &&
            $_GET['filter'] == 'Pending'
                ? 'selected'
                : ''; ?>>Pending</option>
            <option value='Approved'>Approved</option>
            <option value='Rescheduled'>Rescheduled</option>
            <option value='Cancelled'>Cancelled</option>
          </optgroup>
        </select>

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
          <div style="overflow-y: auto; max-height: calc(70vh - 100px);">
            <table class="table w-full" id='TableList'>
              <thead class="sticky top-0 bg-neutral-300 dark:bg-gray-500 z-10" style="top: -1px;">
                <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                  <th class='cursor-pointer'>Name</th>
                  <th class='cursor-pointer'>Date</th>
                  <th class='cursor-pointer'>Time</th>
                  <th class='cursor-pointer' >Doctor</th>
                  <th class='cursor-pointer'>Status</th>
                  <th class='cursor-pointer'>Action</th>
                </tr>
              </thead>
              <tbody class="text-black dark:text-white text-base sm:text-lg">
            <!-- sample row -->
            <?php
            $sql = "SELECT `tbl_accountpatientmember`.*, `tbl_appointment`.*
FROM `tbl_accountpatientmember` 
INNER JOIN `tbl_appointment` ON `tbl_appointment`.`Account_Patient_ID_Member` = `tbl_accountpatientmember`.`Account_Patient_ID_Member` 
ORDER BY 
    CASE 
        WHEN `tbl_appointment`.`Status` = 'pending' THEN 0
        WHEN `tbl_appointment`.`Status` = 'rescheduled' THEN 1
        WHEN `tbl_appointment`.`Status` = 'approved' THEN 2
        WHEN `tbl_appointment`.`Status` = 'completed' THEN 3
        ELSE 4
    END, 
    `tbl_appointment`.`Appointment_schedule` ASC;
";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $middleInitial =
                        strlen($row['Middle_Name']) >= 1
                            ? substr($row['Middle_Name'], 0, 1)
                            : '';
                    $appointment_schedule = $row['Appointment_schedule'];
                    $date = isset($appointment_schedule)
                        ? date('F j, Y', strtotime($appointment_schedule))
                        : 'N/A';
                    $time = isset($appointment_schedule)
                        ? date('g:ia', strtotime($appointment_schedule)) . ' - ' . date('g:ia', strtotime($appointment_schedule . ' +30 minutes'))
                        : 'N/A';

                    $status = ucfirst(strtolower($row['Status']));
                    $class = '';
                    switch ($status) {

                        case 'Completed':
                          $class = 'text-green-500';
                          break;
                        case 'Cancelled':
                          $class = 'text-red-500';
                          break;
                        case 'Approved':
                          $class = 'text-blue-500';
                          break;
                        case 'Rescheduled':
                            $class = 'text-warning';
                            break;

                        default:
                            $class = 'text-yellow-600 dark:text-yellow-300';
                            break;
                    }
                    echo '<tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                <td>' .
                        $row['First_Name'] .
                        ' ' .
                        $middleInitial .
                        '. ' .
                        $row['Last_Name'] .
                        '</td>
                <td>' . $date . '</td><!-- alisin mo yung pl-10 pag nagoverlap yung ilalagay mo -->
                <td class=" ">' . $time .'</td> 
                <td>' . getAssignDoctor($row['Staff_ID']) . '</td>
                <td class="font-bold ' .
                        $class .
                        '">' .
                        $status .
                        '</td> 
                <!-- 
                Completed - text-green-500
                Cancelled - text-red-500
                Approved - text-blue-500
                -->
                <td>
                  <!-- yung modal name viewAppointment2,3,4,5 dapat sa mga susunod, bawal parehas kase di maoopen -->
                  <button onclick="viewAppointment.showModal();getAppointmentInfo(this.getAttribute(\'data-id\')); getDoctorAvailability('.$row['Staff_ID'].')" data-id="' . $row['Appointment_ID'] . '">
                    <i class="fa-regular fa-eye"></i>
                  </button>';
                    // Include the tooltip for Approved status here
                    if ($status === 'Completed') {
                        echo '
                                <a class="ml-2 sm:ml-5 hover:cursor-pointer" onclick="toggleDialog(\'addPatient\');setAppointmentId(this.getAttribute(\'data-appointment-id\'))" data-appointment-id="' .
                            $row['Appointment_ID'] .
                            '">
                                  <i class="fa-solid fa-user-plus"></i>
                                </a>';
                    }
                    echo '</td>
            </tr>';
                }
            }
            ?>
            
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  <dialog id="viewAppointment" class="modal">
    <dialog id='profileAlert'  class='modal ' onclick='toggleDialog("profileAlert")' >
      <div class="flex justify-center" >
        <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="stroke-current shrink-0 h-6 w-6 mr-2"
            fill="none"
            viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <span id='textInfo'>Appointment Updated!</span>
        </div>
      </div>
    </dialog>
    <dialog id='errorAlert'  class='modal' onclick='toggleDialog("errorAlert");' >
      <div class="flex justify-center" >
        <div role="alert" class="inline-flex items-center bg-error border border-black  text-black px-4 py-3 rounded relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span id='error'>Somthing went wrong</span>
        </div>
      </div>
    </dialog>
    <div
      id="patient-content"
      class="modal-box h-auto w-11/12 max-w-7xl bg-gray-200 dark:bg-gray-700 p-0">
      
      <div class="sticky top-0 bg-gray-200 dark:bg-gray-700 z-10 px-10 pt-10">
          <div class="flex flex-col sm:flex-row justify-between items-center">
              <div class="order-2 sm:order-1">
                  <h3 class="font-bold text-black dark:text-white text-base sm:text-2xl md:text-3xl mb-2 sm:mb-0">
                      Patient's Appointment Form
                  </h3>
              </div>
              <div class="order-1 sm:order-2 mb-2 sm:mb-0">
                  <img src="../images/HCMC-blue.png" class="block h-10 lg:h-16 w-auto dark:hidden" alt="logo-light" />
                  <img src="../images/HCMC-white.png" class="h-10 lg:h-16 w-auto hidden dark:block" alt="logo-dark" />
              </div>
          </div>
          <div class="modal-action flex justify-end mb-2">
              <form method="dialog">
                  <button id="modalAppointmentbtn" class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">
                      Close
                  </button>
              </form>
          </div>
          <div class="border border-gray-600 dark:border-slate-300"></div>
      </div>


      <!-- staff action -->
      <div class="p-10">
        <h1 class="text-base sm:text-xl font-bold text-black dark:text-white">Appointment Type: <span class="font-bold " id='AppointmentType'></span></h1>  <!-- ayusin mo rin colors dito ah -->

        <h1 class="text-base sm:text-xl font-bold text-black dark:text-white">STATUS: <span class="font-bold " id='appointment_status'></span></h1>  <!-- ayusin mo rin colors dito ah -->

        <h2 class="text-base sm:text-xl font-bold mt-5 text-black dark:text-white">Edit Status of this Appointment</h2>
        <form id='update_appointment' action="#" method="GET">
          <ul class="items-center w-full text-lg font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg sm:flex mb-2">
            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
              <div class="flex items-center ps-3">
                <input id="pending"  type="radio" required name="list-status" class="radio radio-info" value="pending">
                <label for="pending" class="w-full py-3 ms-2">Pending</label>
              </div>
            </li>
            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
              <div class="flex items-center ps-3">
                <input id="approve"  type="radio" required name="list-status" class="radio radio-info" value="approved">
                <label for="approve" class="w-full py-3 ms-2">Approve</label>
              </div>
            </li>

            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
              <div class="flex items-center ps-3">
                <input id="reschedule" type="radio" required name="list-status" class="radio radio-info" value="rescheduled">
                <label for="reschedule" class="w-full py-3 ms-2">Reschedule</label>
              </div>
            </li>
            <li class="w-full dark:border-gray-600">
              <div class="flex items-center ps-3">
                <input id="cancel" type="radio" required name="list-status" class="radio radio-info" value="cancelled">
                <label for="cancel" class="w-full py-3 ms-2">Cancel</label>
              </div>
            </li>
          </ul>

          <div class="flex flex-col sm:flex-row justify-between gap-4" id="reschedule-section" style="display: none;">
            <div class="w-full">
              <label for="rescheduled-date" class="block text-base sm:text-lg font-medium text-black dark:text-white">
                Rescheduled Date<span id='appointmentDateNote' class='text-sm text-info hidden'> (Please check doctor schedule)</span>
              </label>
              <input disabled type="date" id="appointment-date" name="rescheduled-date" class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white text-lg" />
            </div>
            <div class="w-full">
              <label for="appointment-time" class="block text-base sm:text-lg font-medium text-black dark:text-white">
                Rescheduled Time
              </label>
              <select id="appointment-time" name="rescheduled-time" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-lg text-black dark:text-white">

              </select>
            </div>
          </div>
          <div id='doctorList' class="form-group mt-5">
            <label
              for="appointDoctor"
              class="block font-medium text-black dark:text-white text-base sm:text-lg"
            >Select Doctor's Name:</label
            >
            <select
              id="appointDoctor"
              name="appointDoctor"
              class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
              required onchange='getDoctorAvailability(this.value)'>
              <option value="" disabled selected>Select a Doctor</option>
                <?php
                $sql = "SELECT * FROM tbl_staff where role = 'doctor' ";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $middleInitial = strlen($row['Middle_Name']) >= 1 ? substr($row['Middle_Name'], 0, 1) : '';
                    echo '<option value="' . $row['Staff_ID'] . '">' . $row['First_Name'] . ' ' . $middleInitial . '. ' . $row['Last_Name'] . '</option>';
                }
                ?>
            </select>
          </div>
          <!--
          <div id="services-container">
            <div class="service-dropdown">
              <label class="block font-medium text-black dark:text-white text-base sm:text-lg mb-2 mt-2">
                Service Type:
                <select
                  class="select select-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                  name="service-type"
                >
                  <option value="" disabled selected>Select service type...</option>
                  <option value="OB-Gyne">OB-Gyne</option>
                  <option value="Pregnancy Testing">Pregnancy Testing</option>
                  <option value="Dengue Test">Dengue Test</option>
                  <option value="Covid-19 Rapid Testing">Covid-19 Rapid Testing</option>
                  <option value="Family Medicine">Family Medicine</option>
                  <option value="Internal Medicine">Internal Medicine</option>
                  <option value="Medical Consultation">Medical Consultation</option>
                  <option value="Vaccination">Vaccination</option>
                  <option value="BP Monitoring">BP Monitoring</option>
                  <option value="Blood Glucose Determination">Blood Glucose Determination</option>
                  <option value="Nebulization">Nebulization</option>
                  <option value="Complete Blood Count (CBC)">Complete Blood Count (CBC)</option>
                  <option value="Fecalysis">Fecalysis</option>
                  <option value="Electrocardiogram (ECG)">Electrocardiogram (ECG)</option>
                  <option value="X-RAY">X-RAY</option>
                  <option value="Pre-Employment Package">Pre-Employment Package</option>
                  <option value="Annual Physical Examination">Annual Physical Examination</option>
                  <option value="FBS">FBS</option>
                  <option value="Lipid Profile">Lipid Profile</option>
                  <option value="AST/ALT">AST/ALT</option>
                  <option value="Uric Acid">Uric Acid</option>
                  <option value="Blood Typing">Blood Typing</option>
                  <option value="Electrolytes">Electrolytes</option>
                  <option value="Syphilis Screening">Syphilis Screening</option>
                  <option value="Pregnant Screening">Pregnant Screening</option>
                  <option value="FT4/TSH">FT4/TSH</option>
                </select>
              </label>
            </div>
          </div>
          <button id="add-service" class="btn mt-1 mr-2 bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7 mb-2">Add Another Service</button><small class="font-medium text-black dark:text-white">If needed</small>
  -->
          <!-- <div class="mb-3 mt-10">
            <label for="remarks" class="block text-base sm:text-lg font-medium mt-2 text-black dark:text-white">
              Reason:
            </label>
            <input
              type="text"
              id="remarks"
              name="remarks"
              placeholder="Remarks here..."
              required
              class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 text-black dark:text-white"
            />
          </div>
          -->
          <input type='hidden' name='appointment_id' value=''> 


          <!-- reason section -->   
          <input type="hidden" id="remarks" name="remarks" value=''>
          <div class="w-full mb-5 mt-3">
            <label for="reason" class="block font-medium text-black dark:text-white text-base sm:text-lg">
            Select a Reason:
            </label>
            <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <!-- para sa approve. hide mo to kapag iba pinili. vice versa sa ibang choices-->
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="firstApprove" type="radio" value="Your appointment is now listed, comply on the set date and time." name="approveReason" required class="radio radio-info">
                      <label for="firstApprove" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">Your appointment is now listed, comply on the set date and time.</label>
                  </div>
              </li>
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="othersApprove" type="radio" value="" name="approveReason" required class="radio radio-info">
                      <label for="othersApprove" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">Others</label>
                  </div>
              </li>
              <!-- para sa approve end -->

              <!-- para sa reschedule -->
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="firstResched" type="radio" value="The doctor is unavailable due to unforeseen circumstances. Your appointment has been rescheduled. Please confirm in your profile settings if the new time and date works for you." name="reschedReason" required class="radio radio-info">
                      <label for="firstResched" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">The doctor is unavailable due to unforeseen circumstances. Your appointment has been rescheduled. Please confirm in your profile settings if the new time and date works for you.</label>
                  </div>
              </li>
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="secondResched" type="radio" value="Due to weather conditions, your appointment has been rescheduled. Please confirm in your profile settings if the new time and date works for you." name="reschedReason" required class="radio radio-info">
                      <label for="secondResched" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">Due to weather conditions, your appointment has been rescheduled. Please confirm in your profile settings if the new time and date works for you.</label>
                  </div>
              </li>
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="thirdResched" type="radio" value="There will be maintenance in the clinic and your appointment has been rescheduled. Please confirm in your profile settings if the new time and date works for you." name="reschedReason" required class="radio radio-info">
                      <label for="thirdResched" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">There will be maintenance in the clinic and your appointment has been rescheduled. Please confirm in your profile settings if the new time and date works for you.</label>
                  </div>
              </li>
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="fourResched" type="radio" value="Due to a scheduling conflict, your appointment has been rescheduled. Please confirm in your profile settings if the new time and date works for you." name="reschedReason" required class="radio radio-info">
                      <label for="fourResched" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">Due to a scheduling conflict, your appointment has been rescheduled. Please confirm in your profile settings if the new time and date works for you.</label>
                  </div>
              </li>
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="othersResched" type="radio" value="" name="reschedReason" required class="radio radio-info">
                      <label for="othersResched" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">Others</label>
                  </div>
              </li>
              <!-- para sa reschedule end -->

              <!-- para sa cancel -->
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="firstCancel" type="radio" value="Your appointment has been canceled due incomplete or missing patient information." name="cancelReason" required class="radio radio-info">
                      <label for="firstCancel" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">Your appointment has been canceled due incomplete or missing patient information.</label>
                  </div>
              </li>
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="secondCancel" type="radio" value="Your appointment has been canceled due to double booking." name="cancelReason" required class="radio radio-info">
                      <label for="secondCancel" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">Your appointment has been canceled due to double booking.</label>
                  </div>
              </li>
              <li class="border-b border-gray-200 rounded-t-lg dark:border-gray-600 w-full">
                  <div class="flex items-center ps-3">
                      <input id="othersCancel" type="radio" value="" name="cancelReason" required class="radio radio-info">
                      <label for="othersCancel" class="w-full py-3 ms-2 text-base sm:text-lg font-medium text-black dark:text-white">Others</label>
                  </div>
              </li>
              <!-- para sa cancel end -->
          </ul>
              <div id="otherReasoncontainer" class="mt-2">
                <label for="otherReason" class="block font-medium text-black dark:text-white text-base sm:text-lg">
                  Please specify your reason:
                </label>
                <input type="text" id="otherReason" name="otherReason" required placeholder="Type here..." class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white  whitespace-nowrap overflow-hidden text-ellipsis" />
              </div>
        </div>
          <!-- reason end -->

          <p class="text-black dark:text-white"><span class="font-bold text-red-500">NOTE: </span>Once you click the submit button, it cannot be undone. Please confirm all the fields before submitting.</p>
          <input type="submit" value="Submit" class="btn mt-1 bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-7 mb-2">
        </form>




        <div class="mb-10"></div>    
        <!-- appointment form patient info. Nilagyan ko rin "History" sa ID dito katulad sa patient-profile appointment form -->
        <form id='appointmentform' action="#" method="GET">

          <!-- <div>
            <label for="reason" class="block text-base sm:text-lg font-medium text-black dark:text-white">Reason/Purpose:</label>

            <textarea name="reason" placeholder="Type here" disabled required class="textarea-bordered textarea w-full p-2 h-20 bg-gray-300 dark:bg-gray-600 text-black dark:text-white text-base disabled:bg-white disabled:text-black dark:disabled:text-white border-none "></textarea>
          </div> -->

          <div class="text-center mb-10">
            <h3 class="text-2xl font-bold mt-5 mb-2 text-black dark:text-white">Service:</h3>
            <p class="font-medium text-lg w-full text-black dark:text-white" id='selectedService'></p>
          </div>


          <fieldset class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">

            <!--
            <legend class="text-xl font-bold mb-2 col-span-full">Service:</legend>
            <div class="flex flex-col w-full">
              <ul class="w-full text-lg font-medium text-gray-900 bg-gray-300 dark:bg-gray-600 border border-gray-200 rounded-lg dark:border-gray-600 dark:text-white">
                <li class="border-b border-gray-400 dark:border-slate-300">
                  <label class="flex items-center pl-3 w-full cursor-pointer">
                    <input id="horizontal-list-radio-license"
                          type="radio"
                          value="Consultation"
                          name="service"
                          disabled
                          class="radio radio-info [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300"
                          required>
                    <span class="py-3 ml-2 text-lg font-medium ">Consultation</span>
                  </label>
                </li>
                <li>
                  <label class="flex items-center pl-3 w-full cursor-pointer">
                    <input id="horizontal-list-radio-id"
                          type="radio"
                          value="Test/Procedure"
                          name="service"
                          disabled
                          class="radio radio-info [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300"
                          required>
                    <span class="py-3 ml-2 text-lg font-medium ">Test/Procedure</span>
                  </label>
                </li>
              </ul>
            </div>
            -->





            <div class="w-full md:w-auto md:col-span-1">
              <label for="appointment-dateHistory" class="block text-base sm:text-lg font-medium text-black dark:text-white">
                Appointment Date:
              </label>
              <input
                type="date"
                id="appointment-dateHistory"
                name="appointment-dateHistory"
                disabled
                required
                class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300"
              />

            </div>
            <div class="w-full md:w-auto md:col-span-1">
              <label for="appointment-timeHistory" class="block text-base sm:text-lg font-medium text-black dark:text-white">
                Appointment Time:
              </label>
              <input
                type="text"
                id="appointment-timeHistory"
                name="appointment-timeHistory"
                required
                disabled
                min="08:00"
                max="17:00"
                class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300"
              />

            </div>
          </fieldset>
          <h3 class="text-xl font-bold mt-5 mb-2 text-black dark:text-white">Personal Information</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="first-nameHistory" class="block text-base sm:text-lg font-medium text-black dark:text-white">First Name</label>
              <input type="text" id="first-nameHistory" name="first-nameHistory" disabled autocomplete="off"
                    placeholder="First Name" required class="input input-bordered
                      w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-black dark:disabled:text-white border-none" />
            </div>
            <div>
              <label for="middle-nameHistory" class="block text-base sm:text-lg font-medium text-black dark:text-white">Middle Name</label>
              <input type="text" id="middle-nameHistory" name="middle-nameHistory" disabled placeholder="Middle Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300" />
            </div>

            <div>
              <label for="last-nameHistory" class="block text-base sm:text-lg font-medium text-black dark:text-white">Last Name</label>
              <input type="text" id="last-nameHistory" name="last-nameHistory" disabled placeholder="Last Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300" />
            </div>
            <div>
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
                class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300"
              />
            </div>
            <div>
              <label for="contact-numberHistory" class="block text-base sm:text-lg font-medium text-black dark:text-white">Contact Number</label>
              <input id="contact-numberHistory" name="contact-numberHistory" disabled type="tel" required autocomplete="off" placeholder="Contact Number" pattern="[0-9]{1,11}" minlength="11" maxlength="11" title="Please enter up to 11 numeric characters." class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300" />
            </div>

            <div>
              <label for="sexHistory" class="block text-base sm:text-lg font-medium text-black dark:text-white">Sex</label>
              <select id="sexHistory" required class="select select-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 text-lg disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300" name="sexHistory" disabled>
                <option value="" disabled selected>Select...</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div>
              <label for="dobHistory" class="block text-base sm:text-lg font-medium text-black dark:text-white">Date of Birth</label>
              <input type="date" id="dobHistory" name="dobHistory" disabled required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300" />
            </div>

            <div>
              <label for="addressHistory" class="block text-base sm:text-lg font-medium text-black dark:text-white">Address</label>
              <input type="text" id="addressHistory" name="addressHistory" disabled autocomplete="off" placeholder="Address" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 disabled:bg-white disabled:text-black dark:disabled:text-white border-none disabled:border-gray-300" />
            </div>
          </div>
        </form>
      </div>
      <!-- <button id="print-content">Print</button> wag muna -->
    </div>
  </dialog>
  <dialog id="addPatient"   class="modal bg-black  bg-opacity-40 ">
    <div class="card bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1] w-[80vw] absolute top-10 sm:w-[30rem] max-h-[35rem]  flex flex-col">
      <div  class=" card-title sticky  w-full grid place-items-center">
        <h3 class="font-bold text-center text-lg  p-5 ">Create Patient Chart List?</h3>
      </div>
      <p class="text-base text-center font-medium mb-5"><span class="font-bold text-blue-500">NOTE: </span>This patient's information will be added to the patient records.</p>
      <div class="p-4 w-full flex justify-evenly">
        <a id="newChart" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none w-1/4" onclick="create_patientChart(this.getAttribute('data-appointment-id'));">Yes</a>
        <button class="btn bg-gray-400 text-black dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400 border-none w-1/4 " onclick='toggleDialog("addPatient")'>Close</button>
      </div>
    </div>
  </dialog>

 <!-- js for filter options -->
    <!-- <script>
      function setupToggle(containerId) {
        document.querySelectorAll(`#${containerId} label`).forEach(label => {
          label.addEventListener('click', function() {
            const checkbox = this.querySelector('input[type="checkbox"]');
            const isChecked = checkbox.checked;

            document.querySelectorAll(`#${containerId} label`).forEach(lbl => {
              lbl.classList.remove('bg-[#0b6c95]', 'text-white');
              lbl.classList.add('bg-white', 'dark:bg-gray-700', 'text-black');
              lbl.querySelector('input[type="checkbox"]').checked = false;
            });

            if (!isChecked) {
              this.classList.add('bg-[#0b6c95]', 'text-white');
              this.classList.remove('bg-white', 'dark:bg-gray-700', 'text-black');
              checkbox.checked = true;
            }
          });
        });
      }

      function setupStatusToggle(containerId) {
        document.querySelectorAll(`#${containerId} label`).forEach(label => {
          label.addEventListener('click', function() {
            const checkbox = this.querySelector('input[type="checkbox"]');
            const isChecked = checkbox.checked;

            if (isChecked) {
              this.classList.remove('bg-[#0b6c95]', 'text-white');
              this.classList.add('bg-white', 'dark:bg-gray-700', 'text-black');
              checkbox.checked = false;
            } else {
              this.classList.add('bg-[#0b6c95]', 'text-white');
              this.classList.remove('bg-white', 'dark:bg-gray-700', 'text-black');
              checkbox.checked = true;
            }
          });
        });
      }

      function setupRemoveAllButton() {
        document.getElementById('removeAllButton').addEventListener('click', function() {
          document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
            const label = checkbox.closest('label');
            if (label) {
              label.classList.remove('bg-[#0b6c95]', 'text-white');
              label.classList.add('bg-white', 'dark:bg-gray-700', 'text-black');
            }
          });
        });
      }

      setupToggle('filterVisit');
      setupStatusToggle('filterStatus');
      setupRemoveAllButton();
    </script> -->



  <script>
    function setAppointmentId(appointmentId) {
      document.getElementById('newChart').setAttribute('data-appointment-id', appointmentId);
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
    function getAppointmentInfo(patientAppointment_ID){
      $.ajax({
        url: 'ajax.php?action=getAppointmentInfo&patientAppointment_ID=' + patientAppointment_ID,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          if (data) {
            let appointmentSchedule = data.Appointment_schedule;
            let date = '';
            let formattedTime

            if (appointmentSchedule) {
              let parts = appointmentSchedule.split(' ');
              date = parts[0];
              formattedTime = appointmentSchedule ?
                (() => {
                  const startTime = new Date(`2000-01-01T${parts[1]}`);
                  const endTime = new Date(startTime.getTime() + 30 * 60000);

                  const formattedStartTime = startTime.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
                  const formattedEndTime = endTime.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });

                  return `${formattedStartTime} - ${formattedEndTime}`;
                })()
                : 'N/A';



            }
            let status = data.Status.charAt(0).toUpperCase() + data.Status.slice(1).toLowerCase();

            document.querySelector('#appointment_status').textContent = status;
            let statusClass = '';
            switch (status) {
              case 'Pending':
                statusClass = 'text-yellow-600';
                break;
              case 'Approved':
                statusClass = 'text-info';
                break;
              case 'Rescheduled':
                statusClass = 'text-green-500';
                break;
              case 'Cancelled':
                statusClass = 'text-error';
                break;
              default:
                statusClass = '';
                break;
            }
            document.getElementById('appointment_status').className = '';

            document.getElementById('appointment_status').classList.add('font-bold', statusClass)

            document.getElementById('approve').disabled = (status === 'Cancelled');

            let reason;
            if (data.ServiceType !== null) {
              reason = data.ServiceType
            }else {
              reason = '';
            }

            //document.querySelector('#update_appointment select[name="service-type"]').value = service_type;
            $('#selectedService').html(reason);
            $('#AppointmentType').html(data.Appointment_type)
            document.querySelector('#appointmentform input[name="appointment-dateHistory"]').value = date;
            document.querySelector('#appointmentform input[name="appointment-timeHistory"]').value = formattedTime;
            document.querySelector('#appointmentform input[name="first-nameHistory"]').value = data.First_Name;
            document.querySelector('#appointmentform input[name="middle-nameHistory"]').value = data.Middle_Name;
            document.querySelector('#appointmentform input[name="last-nameHistory"]').value = data.Last_Name;
            document.querySelector('#appointmentform input[name="email"]').value = data.MemberPatientEmail;
            document.querySelector('#appointmentform input[name="contact-numberHistory"]').value = data.Contact_Number;
            document.querySelector('#appointmentform input[name="dobHistory"]').value = data.DateofBirth;
            document.querySelector('#appointmentform input[name="addressHistory"]').value = data.Address;
            document.querySelector('#update_appointment input[name="appointment_id"]').value = data.Appointment_ID;
            document.querySelector('#appointmentform select[name="sexHistory"]').value = data.Sex;
            document.querySelector('#update_appointment select[name="appointDoctor"]').value = data.Staff_ID;

          }
        },
        error: function(xhr, status, error) {
          console.error('Error fetching data:', error);
        }
      });
    }
    function create_patientChart(id) {
      $.ajax({
        url: 'ajax.php?action=createPatientChart&appointment_id=' + encodeURIComponent(id),
        type: 'GET',
        success: function(response) {
          if (parseInt(response) === 1) {
              window.location.href='admin-appointments.php';
          } else {
            document.getElementById('error').innerHTML = response;
            toggleDialog('errorAlert');
          }
          console.log(response)
        }

      });
    }

    document.getElementById('update_appointment').addEventListener('submit', function(e){
      e.preventDefault();
      let form_data = new FormData(e.target);
      $.ajax({
        url: 'ajax.php?action=updateAppointment',
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        success: function(response) {
          if (parseInt(response) === 1) {
            window.location.href='admin-appointments.php';

          }else {
            document.getElementById('error').innerHTML= response;
            toggleDialog('errorAlert');

          }
        }
      });
    })



  </script>
  <script src='../js/doctorAppoimtmentAvailability.js'></script>

  <script>
  <?php if (isset($_GET['filter']) and $_GET['filter'] == 'Pending'): ?>
    document.addEventListener('DOMContentLoaded', function(){
      handleSearch("dropDownSort", "TableList", 'Pending');
    })
    <?php endif; ?>
  </script>

  </body>
</html>
