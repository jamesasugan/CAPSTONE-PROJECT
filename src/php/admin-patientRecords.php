<?php
session_start();
require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::ADMIN]))
{
  return;
}

include '../Database/database_conn.php';
include "ReuseFunction.php";
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="../js/main.js" defer></script>
    <script src="../js/SearchTables.js" defer></script>
  </head>
  <body>
  <?php include 'navbar.php'; ?>
    <div id="patients-recordTab" class="p-10 pt-24 mx-auto w-full min-h-screen bg-[#ebf0f4] dark:bg-[#17222a]">
            <div class="flex flex-col sm:flex-row justify-between items-center bg-gray-200 dark:bg-gray-700 p-5 border-b border-b-black">
                <h3 class="text-2xl sm:text-4xl font-bold text-black dark:text-white mb-4 sm:mb-0 uppercase mr-0 sm:mr-10">
                  Patients
                </h3>
                <div  class="w-full sm:flex sm:items-center justify-end">
                  <select onchange='if (this.value === "none") { resetSearch("TableList"); } else { handleSearch("dropDownSort", "TableList", this.value); }' id='dropDownSort' name="sort" class="select select-bordered w-full sm:w-48 bg-[#0b6c95] font-medium text-white text-base sm:text-lg lg:text-xl mb-4 sm:mb-0 sm:mr-4">
                    <option selected value='none'>Filter</option>
                    <optgroup label="Status">
                      <option>To be Seen</option>
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
      <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden" style="max-height: calc(80vh - 100px);">
        <div class="p-5">
          <div style="overflow-y: auto; max-height: calc(75vh - 100px);">
            <table class="table w-full" id='TableList'>
              <thead class="sticky top-0 bg-neutral-300 dark:bg-gray-500 z-10" style="top: -1px;">
                <tr class="font-bold text-black dark:text-white text-base sm:text-lg">
                  <th class='cursor-pointer'  >Name</th>
                  <th class='cursor-pointer' >Last visit</th>
                  <th class='cursor-pointer'  >Schedule</th>
                  <th class='cursor-pointer'>Consultant</th>
                  <th class='cursor-pointer'  >Status</th>
                  <th>Action</th>
                  <th>Archive</th>
                </tr>
              </thead>
              <tbody class="text-black dark:text-white text-base sm:text-lg">
            <?php
            $sql = "SELECT *
FROM tbl_patient_chart
WHERE patient_Status != 'Archived' AND patient_Status != 'Deleted'
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
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row= $result->fetch_assoc()){
                $middleInitial = (strlen($row['Middle_Name']) >= 1) ? substr($row['Middle_Name'], 0, 1) : '';
                $age = date_diff(date_create($row['DateofBirth']), date_create('today'))->y;
                if ($row['followUp_schedule']!==null){
                    $date = date("F j, Y", strtotime($row['followUp_schedule']));
                    $time = date("g:ia", strtotime($row['followUp_schedule']));
                    $followUpschedule =  $date . ' ' . $time;
                }else{
                    $followUpschedule = "No schedule";
                }
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
                        $statusClass = 'text-warning'; // Default class if none of the above match
                        break;
                }

                echo '<tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
              <td>'.$row['First_Name'].' '.$middleInitial.'. '.$row['Last_Name'].'</td>
          
              <td>'.getLastPatientVisit($row['Chart_id']).'</td>
              <td>'.$followUpschedule.'</td>

              <td> Dr. John Edward Dionisio </td>

              <td class="font-bold '.$statusClass.'">'.$row['patient_Status'].'</td>
              
          
              <!-- sa admin-consultationResults.php dapat to dederetso -->
              <td class="pl-9">
                <a href="consultationResults.php?chart_id='.$row['Chart_id'].'"><i class="fa-regular fa-eye"></i></a>
              </td>
              <td class="pl-10"><button onclick="archive_record.showModal();get_chartID('.$row['Chart_id'].')"><i class="fa-solid fa-box-archive"></i></button></td>
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
            <dialog id="archive_record" class="modal">
                <div class="modal-box bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                    <h3 class="font-bold text-xl text-center">Are you sure you want to Archive this Patient Record?</h3>

                    <!-- <p class="text-black dark:text-white mt-2 mb-1 font-medium">
                      This record will be moved to the <a href="admin-archiveAccounts.php" class="text-blue-500 underline">Archived Patient Records</a></p> -->
                      <a class="btn btn-error mt-5 w-full" data-chart-id="" id='archiveBtn' onclick='archivePatientChart(this.getAttribute("data-chart-id"))'>Archive this Patient Record</a>

                    <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button in form, it will close the modal -->
                            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
                        </form>
                    </div>
                </div>
            </dialog>

   

<!-- <script>
  const printBtn = document.getElementById('print-content');

  printBtn.addEventListener('click', function(){
    print();
  });
</script> -->

    <script>
      function get_chartID(id) {
        let archivebtn = document.getElementById('archiveBtn');
        archivebtn.setAttribute('data-chart-id', id);
      }
      function archivePatientChart(id){
        $.ajax({
          url: 'ajax.php?action=archivePatientChar&chart_id=' + encodeURIComponent(id),
          method: 'GET',
          dataType: 'html',
          success: function(response) {
            if (parseInt(response) === 1) {
              window.location.href='admin-patientRecords.php';
            } else {
              console.log(response)
            }
          }
        });
      }

    </script>

  </body>
</html>
