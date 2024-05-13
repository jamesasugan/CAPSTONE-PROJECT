
<?php
include '../Database/database_conn.php';
session_start();



if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'patient'){
    header("Location: index.php");

}
$user_id = $_SESSION['user_id'];
$sql = "SELECT * from tbl_staff where User_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['Role'] == 'admin'){
        header("Location: staff-index.php");
    }
}
$staff_id = $row['Staff_ID'];

$patient_id = isset($_GET['id']) ? intval($_GET['id']) : null;
$chart_id = isset($_GET['chart_id']) ? intval($_GET['chart_id']) : null;
if (!is_int($patient_id) or !is_int($chart_id)){
    header('Location: staff-patientsRecord.php');
    exit();
}

$sql = "SELECT `tbl_patient`.*, `tbl_appointment`.*, `tbl_patient_chart`.*
        FROM `tbl_patient` 
        INNER JOIN `tbl_appointment` ON `tbl_appointment`.`Patient_ID` = `tbl_patient`.`Patient_ID` 
        INNER JOIN `tbl_patient_chart` ON `tbl_patient_chart`.`Appointment_id` = `tbl_appointment`.`Appointment_ID`
        WHERE `tbl_appointment`.`Patient_ID` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $patient_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();
    $middleInitial = (strlen($row['Middle_Name']) >= 1) ? substr($row['Middle_Name'], 0, 1) : '';


}else{
    header('Location: staff-patientsRecord.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information</title>
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
    <script src="../js/staff-patientsRecord.js" defer></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body>
        <?php include 'staff-navbar.php'; ?>

        <section
            id="fullpatientInformation"
            class="w-full min-h-screen flex justify-center items-center pt-28 pb-10 p-5
            bg-[#f6fafc] dark:bg-[#17222a]"
            >
            <div
                class="w-full max-w-7xl mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]"
            >
                <h2 class="text-3xl font-bold mb-2">Patient's Chart</h2>

              <div class="patientInfo mb-10 mt-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-1 text-lg sm:text-xl">
                  <h2 class="text-lg sm:text-xl font-bold">Status: <span class="text-yellow-600 dark:text-yellow-300"><?php echo $row['patient_Status']?></span></h2>
                  <p><strong>Appointment Type: </strong><?php echo $row['Appointment_type']?> </p>

                  <p><strong>Service: </strong> <?php echo $row['Service_Field']?></p>
                  <p><strong>Service Type: </strong> <?php echo $row['Service_Type']?></p>

                  <p><strong>Name: </strong> <?php echo  $row['First_Name'].' '.$middleInitial.'. '.$row['Last_Name']?></p>
                  <p><strong>Contact Number: </strong> <?php echo $row['Contact_Number']?></p>

                  <p><strong>Sex: </strong> <?php echo $row['Sex']?></p>
                  <p><strong>Email: </strong><?php echo $row['patientEmail']?></p>

                  <p><strong>Vaccinated:</strong> <?php echo $row['Vaccination']?></p>

                  <p><strong>Address:</strong> <?php echo $row['Address']?></p>
                  <p><strong>Date of Birth: </strong><?php echo $row['DateofBirth']?></p>
                </div>
              </div>
              <div class="flex justify-end">
                <button class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none mb-5" onclick="editpatient_info.showModal()">Edit Patient Info</button>
              </div>
              <!-- lalabas lang to sa follow up stage.
                  nilipat ko muna ng pwesto, nilabas ko sa form kase pag nasa form nagkakaerror, gawan mo na lang sariling form siguro to

          -->
              <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                <select id="visitDropdown" onchange="if(this.value !== 'newRecord')
                { getRecords(this.value); getResImg(this.value);} else { document.getElementById('patientRecordForm').reset();
                  document.getElementById('record_id').value = ''; resetImgDisplay();}" name="sort" class="select
                select-bordered text-black dark:text-white w-full sm:w-48  bg-gray-300 dark:bg-gray-600
                text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500
                focus:ring-opacity-50 mb-4 sm:mb-0 sm:mr-4 disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400">
                  <option  selected value='newRecord'>Insert new</option>
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

              <form id="patientRecordForm" action="#" method="POST" enctype='multipart/form-data'>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 mt-5">
                            <div>
                                <label class="block">
                                    Consultation Date:
                                    <input type="date" 
                                        name="consultation-date" 
                                        required 

                                        class="input input-bordered w-full p-2 bg-white dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
                                </label>
                            </div>
                          <input id='record_id' type='hidden' name='record_id' value=''>
                            <div>
                                <label class="block">
                                    Consultant:
                                  <select name="consultant-name" class="select
                select-bordered text-black dark:text-white w-full   bg-gray-300 dark:bg-gray-600
                text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500
                focus:ring-opacity-50 mb-4 sm:mb-0 sm:mr-4 disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400">
                                    <option  selected value='' disabled>Select consultant</option>
                                      <?php
                                      $sql = "SELECT * FROM tbl_staff WHERE role = 'doctor'";
                                      $stmt = $conn->prepare($sql);
                                      $stmt->execute();
                                      $result = $stmt->get_result();

                                      while ($row = $result->fetch_assoc()) {
                                          $middleInitial = substr($row['Middle_Name'], 0, 1);
                                          $selected = ($row['Staff_ID'] == $staff_id) ? 'selected' : '';
                                          echo "<option value='{$row['Staff_ID']}' $selected>{$row['First_Name']} $middleInitial. {$row['Last_Name']}</option>";
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
                                    placeholder="Weight"
                                    class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Heart Rate:
                                    <input type="text" 
                                    name="heart-rate"
                                    required
                                    placeholder="Heart Rate"
                                    class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Temperature (Celsius):
                                    <input type="text" 
                                    name="temperature" 

                                    required 

                                    placeholder="Temperature in Celsius"
                                    class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Blood Pressure:
                                    <input type="text" 
                                    name="blood-pressure"
                                    required 

                                    placeholder="Blood Pressure"
                                    class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
                                </label>
                            </div>             
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4 mb-14">
                            <label class="block">
                                Saturation:
                                <input type="text" name="saturation" required placeholder="Saturation"  class="input input-bordered w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" />
                            </label>

                            <label class="block">Chief Complaint:
                                <textarea id="chiefComplaint" rows="4" name="Chief Complaint"  class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" placeholder="Chief Complaint"></textarea>
                            </label>

                            <label class="block">Physical Examination:
                                <textarea id="physicalExamination" rows="4" name="Physical Examination"  class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" placeholder="Physical Examination"></textarea>
                            </label>

                            <label class="block">Assessment:
                                <textarea id="assessment" rows="4" name="Assessment"  class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" placeholder="Assessment"></textarea>
                            </label>

                            <label class="block">Treatment Plan:
                                <textarea id="treatmentPlan" rows="4" name="Treatment Plan"  class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400" placeholder="Treatment Plan"></textarea>
                            </label>

                            <!-- lalabas to sa initial muna, tas pag nag yes, pwede din lumabas ulit sa follow up check up stage kung need ulit ng follow up -->
                            <div class="flex flex-col items-center p-4">
                                <h1 class="text-lg font-semibold mb-2">Does this patient need a follow-up check-up?</h1>
                                <div class="flex flex-wrap justify-center gap-2">
                                    <div class="flex items-center space-x-2">
                                        <input required onclick='toggleDetails();' id="yesFollowUp" type="radio"  value="yes" name="followUp-radio" class="radio radio-info">
                                        <label for="yesFollowUp" class="text-black dark:text-white">Yes</label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <input required onclick='toggleDetails();' id="noFollowUp" type="radio"  value="no" name="followUp-radio" class="radio radio-info">
                                        <label for="noFollowUp" class="text-black dark:text-white">No</label>
                                    </div>
                                </div>
                                <div id="followUpDetails" class="hidden">
                                    <h2 class="text-md mt-4 font-semibold">Schedule the patient for another check up:</h2>
                                    <label for="followUpDate" class="block text-md font-medium">
                                        Follow Up Date:
                                    </label>
                                    <input
                                      onclick=''
                                        type="date"
                                        id="followUpDate"
                                        name="followUpDate"
                                        required
                                        class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]"
                                    />
                                    <label for="followUpTime" class="block text-md font-medium">
                                        Follow Up Time:
                                        </label>
                                        <input
                                        type="time"
                                        id="followUpTime"
                                        name="followUpTime"
                                        required
                                        min="08:00"
                                        max="17:00"
                                        class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]"
                                        />
                                </div>
                                <div id="completedDetails" class="hidden">
                                    <h2 class="text-md mt-4 font-semibold">This patient will be marked as Completed/Solved</h2>
                                </div>
                            </div>




                        </div>

                        <div class="border border-gray-400 mb-10"></div>

                        <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Results</h2>
                            <!-- Images dito. pag nag upload sa upload file button dito lalabas dapat. kapag kunwari lima inupload na picture dapat lima din tong buong DIV -->
                                <div class="flex flex-wrap gap-2 justify-center items-center w-full mb-3" id='ImageResults'>



                                </div>


                        <div class="chart-actions text-center my-4">                             
                            <input type="file" accept="image/*" name='resultImage[]' multiple class="file-input file-input-bordered file-input-info mb-3 w-full max-w-xs bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" />

                            <div id="editControls" class="space-x-4">
                              <input id="updateBtn" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none " type="submit" value="Submit">
                            </div>
                        </div>
              </form>




            </div>


            <!-- modal content for edit patient information -->
            <dialog id="editpatient_info" class="modal">
                <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                    <h3 class="font-bold text-2xl ">Edit Patient</h3>
                    <form id="EditpatientForm" action="#" method="POST" >
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 mt-5">      
                            <div>
                                <label class="block">
                                    Service:
                                    <div class="flex flex-col w-full">           
                                        <ul class="w-full text-lg font-medium  bg-white dark:bg-gray-600  text-black dark:text-white border border-gray-200 rounded-lg dark:border-gray-600 ">
                                        <li class="border-b border-gray-400 dark:border-slate-300">
                                            <label class="flex items-center pl-3 w-full cursor-pointer">
                                            <input id="horizontal-list-radio-license" 
                                            type="radio" 
                                            value="Consultation" 
                                            name="service" 
                                            class="radio radio-info [color-scheme:light] dark:[color-scheme:dark]" 
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
                                            class="radio radio-info [color-scheme:light] dark:[color-scheme:dark]" 
                                            required>
                                            <span class="py-3 ml-2 text-lg font-medium ">Test/Procedure</span>
                                            </label>
                                        </li>
                                        </ul>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Service Type:
                                    <select
                                        id="service-type"
                                        required
                                        class="select select-bordered w-full bg-white dark:bg-gray-600  text-black dark:text-white text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
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
                            <div>
                                <label class="block">
                                    Name:
                                    <input type="text" 
                                        name="patient-name" 
                                        value="James"
                                        required  
                                        placeholder="Name"
                                        class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white " />
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Contact Number:
                                    <input type="tel"
                                    name="contact-number"  
                                    required 
                                    autocomplete="off"
                                    placeholder="Contact Number" 
                                    pattern="[0-9]{1,11}" 
                                    minlength="11" 
                                    maxlength="11" 
                                    title="Please enter up to 11 numeric characters." 
                                    class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white " />
                                </label>
                            </div>           
                            <div>
                                <label class="block">
                                    Sex:
                                    <select id="sex" required class="select select-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white text-lg" name="sex">
                                        <option value="" disabled selected>Select...</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Email:
                                    <input type="email"
                                    name="email"
                                    required 
                                    autocomplete="off"
                                    placeholder="Email"
                                    class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white "/>
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Vaccinated:
                                    <div class="flex items-center space-x-4 p-2 bg-white dark:bg-gray-600  text-black dark:text-white rounded">
                                        <label class="flex items-center">
                                            <input type="radio" name="vaccinated" value="yes" class="radio radio-primary" required>
                                            <span class="ml-2">Yes</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="vaccinated" value="no" class="radio radio-primary" required>
                                            <span class="ml-2">No</span>
                                        </label>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Address:
                                    <input type="text" 
                                    name="address" 
                                    autocomplete="off"
                                    placeholder="Address" 
                                    required 
                                    class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white " />
                                </label>
                            </div>
                            <div>
                                <label class="block">
                                    Date of Birth:
                                    <input type="date"
                                    id="dob"
                                    name="dob" 
                                    required 
                                    class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white [color-scheme:light] dark:[color-scheme:dark]" />
                                </label>
                            </div>         
                        </div>
                        <div class="flex justify-center">
                            <input type="submit" value="Update" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none">
                        </div> 
                        </form>






                    <div class="modal-action">
                        <form method="dialog">
                                <!-- if there is a button, it will close the modal -->
                            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none">Close</button>
                        </form>
                    </div>
                </div>
            </dialog>
            <!-- modal content for edit patient information end -->

            </section>
        <dialog id='SuccessAlert'  class='modal' onclick='toggleDialog("SuccessAlert")' >
          <div class="flex justify-center" >
            <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
              <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span id='textInfo'>Patient Information Updated!</span>
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


            <script>
                document.addEventListener('DOMContentLoaded', function () {
                var inputDob = document.getElementById('dob');
                if (inputDob) {
                    // Check if the element exists
                    var today = new Date();
                    var maxDate = today.toISOString().split('T')[0]; // format yyyy-mm-dd
                    inputDob.max = maxDate;
                }
                });
            </script>
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
          document.getElementById('patientRecordForm').addEventListener('submit', function(e){
            e.preventDefault();
            let endpoint;
            endpoint = 'createPatientRecord';
            let form_data = new FormData(e.target);
            $.ajax({
              url: 'ajax.php?action=' + endpoint + '&chart_id='+ encodeURIComponent(<?php echo $chart_id?>),
              type: 'POST',
              data: form_data,
              processData: false,
              contentType: false,
              success: function(response) {
                if (parseInt(response) === 1) {
                  toggleDialog('SuccessAlert');
                  window.location.href='staff-patientFullRecord.php?id=<?php echo $_GET['id']?>&chart_id=<?php echo $_GET['chart_id']?>';

                }else {
                  document.getElementById('error').innerHTML = response;
                  toggleDialog('errorAlert');
                }
              }
            });
          });
        </script>
</body>
</html>