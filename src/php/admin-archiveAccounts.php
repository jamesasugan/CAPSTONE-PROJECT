<?php
include '../Database/database_conn.php';
session_start();



if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'patient'){
    header("Location: index.php");

}
$user_id = $_SESSION['user_id'];
$sql = "SELECT role from tbl_staff where User_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['role'] == 'doctor'){
        header("Location: staff-index.php");
    }
} ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Archive Accounts</title>
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

    <div id="patients-recordTab" class="p-10 pt-24 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]">

      <!-- delete all patient records content
        yung name din ng modal dito pre deleteAll_records1,2,3,4 -->
      <div class="flex justify-end mb-5">
            <button class="btn btn-error" onclick="deleteAll_records.showModal()">Delete All Patient Records</button>

            <dialog id="deleteAll_records" class="modal">
                <div class="modal-box bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                    <h3 class="font-bold text-xl">Delete All Patient Records</h3>
                    <form action="#" method="POST">
                        <div class="form-group">  
                            <p class="text-black dark:text-white mt-5 font-medium mb-1">Are you sure you want to permanently Delete all Archived Patient Records?
                                <br><span class="font-bold text-red-400">This action is permanent and cannot be undone.</span>
                            </p>
                            <p class="text-black dark:text-white mt-2 mb-1">Please enter your password to avoid accidental deletion</p>

                                <label for="dlt-password" class="block font-medium text-black dark:text-white">Confirm Password</label>
                                <div class="relative">
                                    <input id="dlt-password" type="password" required autocomplete="off" placeholder="Enter your password" 
                                    class="input input-bordered w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:outline-none sm:text-sm bg-white dark:bg-gray-600 text-black dark:text-white mb-2">
                                </div>
                                <!-- delete button -->
                            <input type="submit" value="Delete All" class="btn btn-error">   
                        </div> 
                    </form>                                      
                      

                    <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button in form, it will close the modal -->
                            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
        <!-- delete all patient records content end -->

            <div class="flex flex-col sm:flex-row  justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black">
                <h3 class="text-2xl sm:text-2xl md:text-4xl font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase mr-0 sm:mr-10">
                  Archived Records
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
              <th>Schedule</th>
              <th>Status</th>
              <th>Action</th>
              <th>Unarchive</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody class="text-black dark:text-white text-base sm:text-lg">

          <?php
            $sql = "SELECT `tbl_patient`.*, `tbl_appointment`.*, `tbl_patient_chart`.*
FROM `tbl_patient` 
INNER JOIN `tbl_appointment` ON `tbl_appointment`.`Patient_ID` = `tbl_patient`.`Patient_ID` 
INNER JOIN `tbl_patient_chart` ON `tbl_patient_chart`.`Appointment_id` = `tbl_appointment`.`Appointment_ID`
where tbl_patient_chart.patient_Status = 'Archived'
ORDER BY 
    CASE WHEN `tbl_patient_chart`.`followUp_schedule` IS NULL THEN 1 ELSE 0 END, 
    `tbl_patient_chart`.`followUp_schedule` ASC;
";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row= $result->fetch_assoc()){
                $middleInitial = (strlen($row['Middle_Name']) >= 1) ? substr($row['Middle_Name'], 0, 1) : '';
                $age = date_diff(date_create($row['DateofBirth']), date_create('today'))->y;
                $date = date("F j, Y", strtotime($row['followUp_schedule']));
                $time = date("g:ia", strtotime($row['followUp_schedule']));
                $followUpschedule = $date . ' ' . $time == 'January 1, 1970 1:00am'  ? 'N/A' : $date . ' ' . $time;
                echo '<tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
              <td>'.$row['First_Name'].' '.$middleInitial.'. '.$row['Last_Name'].'</td>
              <td>'.$age.'</td>
              <td>'.$row['Sex'].'</td>
              <td>'.$row['Appointment_type'].'</td>
       
              <td>'.$followUpschedule.'</td>
              <td class="font-bold text-yellow-600 dark:text-yellow-300">'.$row['patient_Status'].'</td>
              <!-- Status List
                   Completed = text-green-500
                   Waiting for Results = text-yellow-600 dark:text-yellow-300
                   No Show =  text-red-500
            -->

              <!-- view information -->
              <td class="pl-9">
                <a href="admin-patientFullRecord.php?id='.$row['Patient_ID'].'&chart_id='.$row['Chart_id'].'"><i class="fa-regular fa-eye"></i></a>
              </td>
              <td class="pl-10"><button onclick="unArchive('.$row['Chart_id'].')"><i class="fa-solid fa-address-book"></i></button></td>
              <td class="pl-9"><button onclick="delete_record.showModal();get_chartID('.$row['Chart_id'].')"><i class="fa-solid fa-trash text-red-500"></i></button></td>

            </tr>
            <!-- sample row end -->';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <dialog id="delete_record" class="modal">
      <div class="modal-box bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
        <h3 class="font-bold text-xl">Are you sure you want to permanently <span class="text-red-500">Delete</span>  this Patient Record?</h3>
        <button id='deleteBTN' class="btn btn-error mt-5" onclick='delPatientChart(this.getAttribute("data-chart-id"))'>Delete Record</button>

        <div class="modal-action">
          <form method="dialog">
            <!-- if there is a button in form, it will close the modal -->
            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
          </form>
        </div>
      </div>
    </dialog>
    <dialog id='errorAlert'  class='modal' onclick='toggleDialog("errorAlert");' >
      <div class="flex justify-center" >
        <div role="alert" class="inline-flex items-center bg-error border border-black  text-black px-4 py-3 rounded relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span id='error'>Something went wrong</span>
        </div>
      </div>
    </dialog>
<script>
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

  function get_chartID(id) {
    let archivebtn = document.getElementById('deleteBTN');
    archivebtn.setAttribute('data-chart-id', id);
  }
  function unArchive(id){
    $.ajax({
      url: 'ajax.php?action=UnarchivePatientChart&chart_id=' + encodeURIComponent(id),
      method: 'GET',
      dataType: 'html',
      success: function(response) {
        if (parseInt(response) === 1) {
          window.location.href='admin-archiveAccounts.php';
        } else {
          toggleDialog('errorAlert');
        }
      }
    });
  }
  function delPatientChart(id){
    $.ajax({
      url: 'ajax.php?action=DeletePatientChart&chart_id=' + encodeURIComponent(id),
      method: 'GET',
      dataType: 'html',
      success: function(response) {
        if (parseInt(response) === 1) {
          window.location.href='admin-archiveAccounts.php';
        } else {
          toggleDialog('errorAlert');
        }
      }
    });
  }
</script>


<!-- <script>
  const printBtn = document.getElementById('print-content');

  printBtn.addEventListener('click', function(){
    print();
  });
</script> -->
  </body>
</html>
