<?php
include '../Database/database_conn.php';
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'patient') {
    header('Location: index.php');
}


$user_id = $_SESSION['user_id'];

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


$chart_id = isset($_GET['chart_id']) ? $_GET['chart_id'] : '';

$sql = "SELECT * FROM `tbl_patient_chart` 
        WHERE Chart_id = ? and user_info_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $chart_id,$accountOwner_ID);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows == 1){
    $row = $result->fetch_assoc();
    $middleInitial = (strlen($row['Middle_Name']) >= 1) ? substr($row['Middle_Name'], 0, 1) : '';
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
            $statusClass = 'text-warning';
            break;
    }

}else{
    header("Location: patient-profile.php");
    exit(); // Exit the script after redirecting
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record History</title>
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
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script src="../js/main.js" defer></script>
</head>
<body>

    <?php include 'navbar-main.php'; ?>

    <section
      id="fullpatientInformation"
      class="w-full min-h-screen flex justify-center items-center pt-28 pb-10 p-5
            bg-[#f6fafc] dark:bg-[#17222a]"
    >
      <div
        class="w-full max-w-7xl mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1] printableArea"
      >
      <div
        class="flex flex-col sm:flex-row justify-between items-center"
      >
        <div class="order-2 sm:order-1">
          <h3
            class="font-bold text-black dark:text-white text-3xl mb-2 sm:mb-0"
          >
            Patient's Chart
          </h3>
        </div>
        <div class="order-1 sm:order-2 mb-2 sm:mb-0">
          <!-- Toggle between different logos for light/dark mode -->
          <img
            src="../images/HCMC-blue.png"
            class="block h-10 lg:h-16 w-auto dark:hidden"
            alt="logo-light"
          />
          <img
            src="../images/HCMC-white.png"
            class="h-10 lg:h-16 w-auto hidden dark:block"
            alt="logo-dark"
          />
        </div>
      </div>

        <div class="patientInfo mb-10 mt-5">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-1 text-lg sm:text-xl">
            <h2 class="text-lg sm:text-xl font-bold">Status: <span class="<?php echo $statusClass;?>"><?php echo $row['patient_Status']?></span></h2>
            <p><strong>Name: </strong> <?php echo $row['First_Name'] . ' ' . $middleInitial . '. ' . $row['Last_Name']; ?></p>
            <p><strong>Contact Number: </strong> <?php echo $row[ 'Contact_Number']; ?></p>
            <p><strong>Age: </strong> <?php echo (new DateTime($row['DateofBirth']))->diff(new DateTime)->y; ?></p>

            <p><strong>Sex: </strong> <?php echo $row['Sex']; ?></p>
            <p><strong>Email: </strong><?php echo $row['patientEmail']; ?></p>
            <p><strong>Address:</strong> <?php echo $row['Address']; ?></p>
            <p><strong>Date of Birth: </strong><?php echo   date("F j, Y", strtotime($row['DateofBirth']));?></p>
            <p><strong>Service Type: </strong><span id='availedService'>N/A</span> </p>
          </div>
        </div>

        <div class="flex justify-end mb-5">
          <button class="mt-6 btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none printformButton flex flex-col items-center px-5 py-1" onclick="window.print()">
              <i class="fa-solid fa-print"></i>
              <span>Print</span>
          </button>
        </div>
        <!-- lalabas lang to sa follow up stage.
            nilipat ko muna ng pwesto, nilabas ko sa form kase pag nasa form nagkakaerror, gawan mo na lang sariling form siguro to
    -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center">
          <select id="visitDropdown" onchange="if(this.value !== 'newRecord')
                { getRecords(this.value); getResImg(this.value);} else { document.getElementById('patientRecordForm').reset();
                  document.getElementById('record_id').value = ''; resetImgDisplay();}" name="sort" class="select
                select-bordered text-black dark:text-white w-full   bg-gray-300 dark:bg-gray-600
                text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500
                focus:ring-opacity-50 mb-4 sm:mb-0 sm:mr-4 disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400">
            <option  selected value='newRecord'>Select Record</option>
              <?php
              $visitNUmber = 1;
              $getRecord = "SELECT * FROM tbl_records where Chart_ID = ?";
              $recordStmt = $conn->prepare($getRecord);
              $recordStmt->bind_param('i',$chart_id);
              $recordStmt->execute();
              $result = $recordStmt->get_result();
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      echo '<option value="'.$row['Record_ID'].'">Visit '.$visitNUmber++.'</option>';

                  }
              }
              ?>
          </select>
        </div>
        <!-- lalabas lang to sa follow up stage end -->

        <form id="patientRecordForm" action="#" method="POST" enctype='multipart/form-data'>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 mt-5">
            <div>
              <label class="block">
                Consultation Date:
                <input type="date"
                       disabled
                       name="consultation-date"
                       required
                       class="input input-bordered w-full p-2 bg-white dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" />
              </label>
            </div>
            <input id='record_id' type='hidden' name='record_id' value=''>
            <div>
              <label class="block">
                Consultant:
                <select name="consultant-name" class="select
                select-bordered text-black dark:text-white w-full   bg-gray-300 dark:bg-gray-600
                text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500
                focus:ring-opacity-50 mb-4 sm:mb-0 sm:mr-4 disabled:bg-white disabled:text-black dark:disabled:text-white border-none">
                  <option  selected value='' disabled>Select consultant</option>

                    <?php
                    $sql = "SELECT * FROM tbl_staff WHERE role = 'doctor'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $middleInitial = substr($row['Middle_Name'], 0, 1);
                        echo "<option value='{$row['Staff_ID']}' disabled>{$row['First_Name']} $middleInitial. {$row['Last_Name']}</option>";
                    }
                    ?>

                </select>
              </label>
            </div>
            <div>
              <label class="block">
                Weight:
                <input type="text"
                       name="weight"
                       required
                       disabled
                       placeholder="Weight"
                       class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" />
              </label>
            </div>
            <div>
              <label class="block">
                Heart Rate:
                <input type="text" name="heart-rate" required disabled
                       placeholder="Heart Rate"
                       class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" />
              </label>
            </div>
            <div>
              <label class="block">
                Temperature (Celsius):
                <input type="text"
                       name="temperature"
                       required
                       disabled
                       placeholder="Temperature in Celsius"
                       class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" />
              </label>
            </div>
            <div>
              <label class="block">
                Blood Pressure:
                <input type="text"
                       name="blood-pressure"
                       required
                       disabled
                       placeholder="Blood Pressure"
                       class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" />
              </label>
            </div>
          </div>
          <div class="grid grid-cols-1 gap-4 mb-14">
            <label class="block">
              Saturation:
              <input disabled type="text" name="saturation" required placeholder="Saturation"  class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" />
            </label>

            <label class="block">Chief Complaint:
              <textarea disabled id="chiefComplaint" rows="4" name="Chief Complaint"  class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" placeholder="Chief Complaint"></textarea>
            </label>

            <label class="block">Physical Examination:
              <textarea disabled id="physicalExamination" rows="4" name="Physical Examination"  class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" placeholder="Physical Examination"></textarea>
            </label>

            <label class="block">Assessment:
              <textarea disabled id="assessment" rows="4" name="Assessment"  class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" placeholder="Assessment"></textarea>
            </label>

            <label class="block">Treatment Plan:
              <textarea disabled id="treatmentPlan" rows="4" name="Treatment Plan"  class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-black dark:disabled:text-white border-none" placeholder="Treatment Plan"></textarea>
            </label>
            <!-- lalabas to sa initial muna, tas pag nag yes, pwede din lumabas ulit sa follow up check up stage kung need ulit ng follow up -->
          </div>
          <div class="border border-gray-400 mb-10"></div>

          <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Results</h2>
          <!-- Images dito. pag nag upload sa upload file button dito lalabas dapat. kapag kunwari lima inupload na picture dapat lima din tong buong DIV -->
          <div class="flex flex-wrap gap-2 justify-center items-center w-full mb-3" id='ImageResults'>

          </div>
        </form>
      </div>
    </section>
</body>
<script>
  function getResImg(id){
    $.ajax({
      url: 'ajax.php?action=getResImg&record_id=' + encodeURIComponent(id),
      method: 'GET',
      dataType: 'html',
      success: function(data) {
        if (data) {
          $('#ImageResults').html(data);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching data:', error);
      }
    });
  }

  function resetImgDisplay(){
    document.getElementById('ImageResults').innerHTML = ''
  }
  function getRecords(id){
    $.ajax({
      url: 'ajax.php?action=getPatientRecord&record_id='+ encodeURIComponent(id) + '&chart_id='+encodeURIComponent(<?php echo $chart_id?>),
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        if (data) {
          $('#availedService').html(data.availedService);
          document.querySelector('#patientRecordForm input[name="consultation-date"]').value = data.consultationDate;
          document.querySelector('#patientRecordForm input[name="record_id"]').value = data.Record_ID;
          document.querySelector('#patientRecordForm select[name="consultant-name"]').value = data.Consultant_Staff_ID;
          document.querySelector('#patientRecordForm input[name="weight"]').value = data.Weight;
          document.querySelector('#patientRecordForm input[name="blood-pressure"]').value = data.Blood_Pressure;
          document.querySelector('#patientRecordForm input[name="heart-rate"]').value = data.HeartRate;
          document.querySelector('#patientRecordForm input[name="saturation"]').value = data.Saturation;
          document.querySelector('#patientRecordForm input[name="temperature"]').value = data.Temperature;
          document.querySelector('#patientRecordForm textarea[name="Chief Complaint"]').value = data.Chief_complaint;
          document.querySelector('#patientRecordForm textarea[name="Physical Examination"]').value = data.Physical_Examination;
          document.querySelector('#patientRecordForm textarea[name="Assessment"]').value = data.Assessment;
          document.querySelector('#patientRecordForm textarea[name="Treatment Plan"]').value = data.Treatment_Plan;

        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching data:', error);
      }
    });
  }

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const printBtn = document.querySelector('.printform');

      printBtn.addEventListener('click', function() {
        window.print();
      });
    });
  </script>

</html>