<?php
session_start();
require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::STAFF]))
{
  return;
}

$user_query = query_user_info(true);
$staff_id = $user_query['Staff_ID'];
include "../Database/database_conn.php";
include 'ReuseFunction.php';
?>

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
    <script src="../js/SearchTables.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </head>
  <body>

    <?php include 'staff-navbar.php'; ?>

    <div id="patients-recordTab" class="p-10 pt-24 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]">
      <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black">
        <h3 class="text-2xl sm:text-4xl font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase mr-0 sm:mr-10">
          Patients
        </h3>
        <div  class="w-full sm:flex sm:items-center justify-end">
          <select onchange='if (this.value === "none") { resetSearch("TableList"); } else { handleSearch("dropDownSort", "TableList", this.value); }' id='dropDownSort' name="sort" class="select select-bordered w-full sm:w-44 bg-[#0b6c95] font-medium text-white text-base sm:text-lg lg:text-xl mb-4 sm:mb-0 sm:mr-4">
            <option selected value='none'>Filter</option>
            <optgroup label="Status">
              <option <?php echo isset($_GET['filter']) && $_GET['filter'] == 'To be Seen' ? 'selected':'';?>>To be Seen</option>
              <option>Follow Up</option>
              <option>Completed</option>
              <option>Unarchive</option>
            </optgroup>
          </select>
          <!-- Search Input and Button -->
          <div class="flex w-full sm:w-auto">
            <input
              type="text"
              name="text"
              id='search'
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
      <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden" style="max-height: calc(85vh - 100px);">
        <div class="p-5">
          <div style="overflow-y: auto; max-height: calc(80vh - 100px);">
            <table class="table w-full" id='TableList'>
              <thead class="sticky top-0 bg-neutral-300 dark:bg-gray-500" style="top: -1px;">
                <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                  <th class='cursor-pointer'  >Name</th>
                  <th class='cursor-pointer' >Last visit</th>
                  <th class='cursor-pointer'  >Schedule</th>
                  <th class='cursor-pointer'  >Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="text-black dark:text-white text-base sm:text-lg">
          <?php
          $sql = "SELECT *
FROM tbl_patient_chart
WHERE patient_Status != 'Archived' AND patient_Status != 'Deleted' and Consultant_id = ?
ORDER BY 
    CASE 
        WHEN `tbl_patient_chart`.`followUp_schedule` IS NULL THEN 1 
        ELSE 0 
    END,
    `tbl_patient_chart`.`followUp_schedule` IS NULL, 
    FIELD(`tbl_patient_chart`.`patient_Status`, 'To be Seen', 'Follow Up', 'Unarchived', 'Completed'),
    `tbl_patient_chart`.`patient_Status` ASC;
";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('i', $staff_id);
          $stmt->execute();
          $result = $stmt->get_result();
          while ($row= $result->fetch_assoc()){
              $middleInitial = (strlen($row['Middle_Name']) >= 1) ? substr($row['Middle_Name'], 0, 1) : '';
              $age = date_diff(date_create($row['DateofBirth']), date_create('today'))->y;
              $date = date("F j, Y", strtotime($row['followUp_schedule']));
              $time = date("g:ia", strtotime($row['followUp_schedule']));
              $followUpschedule = $date . ' ' . $time == 'January 1, 1970 1:00am' ? "No schedule" : $date . ' ' . $time;

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
              echo '<tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
              <td>'.$row['First_Name'].' '.$middleInitial.'. '.$row['Last_Name'].'</td>
         
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

              <!-- sa staff-consultationResults.php dapat to dederetso -->
              <td>
                <a href="staff-patientFullRecord.php?chart_id='. $row['Chart_id'].'"><i class="fa-regular fa-eye"></i></a>';

              if ($row['patient_Status'] == 'Follow Up' and $followUpschedule != 'No schedule'){
                  echo '<div class="tooltip tooltip-bottom ml-5" data-tip="Remove Schedule">
                  <a  data_id="'.$row['Chart_id'].'"  onclick="toggleDialog(\'RemoveSched\');getChart_id(this.getAttribute(\'data_id\'))" class="text-error cursor-pointer "> <i class="fa-solid fa-eraser"></i></a>
                  </div>';
                }
              echo '
              </td>
            </tr>
            <!-- sample row end -->';
          }
          ?>  
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- modal content for archive record -->
    <dialog id="schedRemove" class="modal bg-black bg-opacity-50" onclick='toggleDialog("schedRemove")'>
      <div class="modal-box bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
        <h3 class="font-bold text-center text-warning" id='notiftext'>Follow up schedule has been updated</h3>
      </div>
    </dialog>
    <dialog id="RemoveSched"   class="modal bg-black  bg-opacity-40 ">
      <div class="card bg-slate-50 w-[80vw] absolute top-10 sm:w-[30rem] max-h-[35rem]  flex flex-col text-black">
        <div  class=" card-title sticky  w-full grid place-items-center">
          <h3 class="font-bold text-center text-lg  p-5 ">Remove follow-up schedule?</h3>
        </div>
        <div class="p-4 w-full flex justify-evenly">
          <a id="removeSchedIdLink"  class="btn btn-error w-1/4" onclick="removeFollowUpSched(this.getAttribute('data_id'))">Yes</a>
          <button class="btn  btn-neutral  w-1/4 " onclick='toggleDialog("RemoveSched")'>Close</button>
        </div>
      </div>
    </dialog>



    <!-- <script>
      const printBtn = document.getElementById('print-content');

      printBtn.addEventListener('click', function(){
        print();
      });
    </script> -->



  </body>
  <script>
    function getChart_id(id) {
      document.getElementById('removeSchedIdLink').setAttribute('data_id', id);
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
    function removeFollowUpSched(id){
      $.ajax({
        url: 'ajax.php?action=removeFollowupSched&chart_id=' + encodeURIComponent(id),
        method: 'GET',
        dataType: 'html',
        success: function(response) {
          if (parseInt(response) === 1) {
            toggleDialog('schedRemove')
            window.location.href='staff-patientsRecord.php';
          } else {
            document.getElementById('notiftext').innerHTML = response;
            toggleDialog('schedRemove');
          }
        }
      });
    }
    <?php
    if (isset($_GET['filter']) and $_GET['filter'] == 'To be Seen'):
    ?>
    document.addEventListener('DOMContentLoaded', function(){
      handleSearch("dropDownSort", "TableList", 'To be Seen');
    })
    <?php endif;?>
  </script>
</html>
