
<?php
session_start();
require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::STAFF]))
{
  return;
}

$user_query = query_user_info(true);
$specialty = $user_query['speciality'];
$staff_id = $user_query['Staff_ID'];

include '../Database/database_conn.php';
include "ReuseFunction.php";

$chart_id = isset($_GET['chart_id']) ? $_GET['chart_id'] : null;


$sql = "SELECT * FROM `tbl_patient_chart` 
        WHERE Chart_id = ? and Consultant_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $chart_id, $staff_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $middleInitial =
        strlen($row['Middle_Name']) >= 1
            ? substr($row['Middle_Name'], 0, 1)
            : '';
    $Patient_firstname = $row['First_Name'];
    $Patient_lastname = $row['Last_Name'];
    $Patient_middle_name = $row['Middle_Name'];
    $Patient_ContactNumber = $row['Contact_Number'];
    $Patient_Email = $row['patientEmail'];
    $Patient_address = $row['Address'];
    $appointmentType = '';
    $patientDOB =  $row['DateofBirth'];
    $patientVacStat = '';
    $patient_Sex = $row['Sex'];
    $patient_weight = $row['Weight'];
    $patient_MdCondition = $row['Medical_condition'];

    $patient_status = $row['patient_Status'];
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

} else {
    header('Location: staff-patientsRecord.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Form</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/staff.css" />
    <link rel="stylesheet" href="../css/print.css">
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
    <script src="../../node_modules/html2canvas-pro/dist/html2canvas-pro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/main.js" defer></script>
    <script src="../js/staff-patientsRecord.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
      <div class="mainContainer">
      <?php  
    include 'navbar.php';
    ?>
    
        <section id="fullpatientInformation" class="w-full min-h-screen flex justify-center items-center pt-28 pb-10 p-5 bg-[#f6fafc] dark:bg-[#17222a]">
            <div class="w-full max-w-7xl mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1] recordHid">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <div class="order-2 sm:order-1">
                  <h3 class="font-bold text-black dark:text-white text-3xl mb-2 sm:mb-0">
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
                  <div>
                      <strong class="block">Name</strong>
                      <span class="block"><?php echo $Patient_firstname . ' ' . $middleInitial . '. ' . $Patient_lastname; ?></span>
                  </div>
                  <div>
                      <strong class="block">Status</strong>
                      <p class="block font-semibold"><span class="<?php echo $statusClass;?>"><?php echo $patient_status?></span></p>
                  </div>   
                  <div>
                      <strong class="block">Username</strong>
                      <span class="block">franky123</span>
                  </div>
                  <div>
                      <strong class="block">Age</strong>
                      <span class="block"><?php echo (new DateTime($patientDOB))->diff(new DateTime)->y; ?></span>
                  </div>
                  <div>
                      <strong class="block">Sex</strong>
                      <span class="block"><?php echo $patient_Sex; ?></span>
                  </div>
                  <div>
                      <strong class="block">Contact Number</strong>
                      <span class="block"><?php echo $Patient_ContactNumber ?></span>
                  </div>
                  <div>
                      <strong class="block">Email</strong>
                      <span class="block"><?php echo $Patient_Email; ?></span>
                  </div>
                  <div>
                      <strong class="block">Weight</strong>
                      <span class="block"><?php echo $patient_weight; ?></span>
                  </div>
                  <div>
                      <strong class="block">Date of Birth</strong>
                      <span class="block"><?php echo   date("F j, Y", strtotime($patientDOB));?></span>
                  </div>
                  <div>
                      <strong class="block">Medical Condition</strong>
                      <span class="block"><?php echo $patient_MdCondition; ?></span>
                  </div>
                  <div>
                      <strong class="block">Address</strong>
                      <span class="block"><?php echo $Patient_address; ?></span>
                  </div>
                </div>
              </div>
             <!-- <div class="flex justify-end">
                <a class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none mb-5" onclick='toggleDialog("editpatient_info")'>Edit Patient Info</a>
              </div>-->
              
              
              <!-- lalabas lang to sa follow up stage.
                  nilipat ko muna ng pwesto, nilabas ko sa form kase pag nasa form nagkakaerror, gawan mo na lang sariling form siguro to

          -->
            <!-- <div class="flex justify-center">
              <button class="btn btn-info">View Record History</button>
            </div>

            <div class="flex justify-center mt-10">
              <button class="btn btn-info">Add New Record</button>
            </div> -->


            <!-- <div id="printContainer" class="container mx-auto">
                <div class="flex flex-col gap-4 h-[calc(100vh-18rem)] overflow-y-auto">
                    <div class="card bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                        <div class="flex justify-center">
                            <h3 class="text-base sm:text-2xl font-semibold text-gray-900 dark:text-white">Patient Record History</h3>
                        </div>
                        <div class="text-lg">
                            <p><span class="font-medium">Name: </span>Franklin C. Saint</p>
                            <p><span class="font-medium">Consultation Date:</span> July 20, 2024</p>
                            <p><span class="font-medium">Service:</span></p>
                            <p><span class="font-medium">Remarks:</span></p>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- <div class="flex justify-end mb-5">
                <button id="print" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none printformButton flex flex-col items-center px-5 py-1">
                    <i class="fa-solid fa-print"></i>
                    <span>Print</span>
                </button>
            </div>

            <div class="flex justify-end">
              <button id="save" class="btn btn-info">Save</button>
            </div> -->




              <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                <select id="visitDropdown" onchange="if(this.value !== 'newRecord')
                { getRecords(this.value); getResImg(this.value); $('#serviceTypeBTN').html('Edit Service Type')} else { document.getElementById('patientRecordForm').reset(); $('#availedService').html('N/A');
                  document.getElementById('record_id').value = ''; resetImgDisplay(); $('#serviceTypeBTN').html('Select Service Type') }" name="sort" class="select
                select-bordered text-black dark:text-white w-full sm:w-48  bg-gray-300 dark:bg-gray-600
                text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500
                focus:ring-opacity-50 mb-4 sm:mb-0 sm:mr-4 disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400">
                  <option  selected value='newRecord'>Insert new</option>
                    <?php
                    $visitNUmber = 1;
                    $getRecord = 'SELECT * FROM tbl_records where Chart_ID = ?';
                    $recordStmt = $conn->prepare($getRecord);
                    $recordStmt->bind_param('i', $chart_id);
                    $recordStmt->execute();
                    $result = $recordStmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'.$row['Record_ID'].'">Consultation: '.$row['consultationDate'].'</option>';

                        }
                    }
                    ?>
                </select>
              </div>

              <form id="patientRecordForm" enctype='multipart/form-data'>
                <div class="flex justify-center">
                  <a class='btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none mt-6' onclick='toggleDialog("services")' id='serviceTypeBTN'>Select Service</a>
                </div>

                  <p id='availedService' class="text-center mt-5"></p>
               

                <dialog class='modal bg-black bg-opacity-20' id='services'>
                  <div id='ServiceList'  class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 overflow-auto">
                    <h1 class="text-2xl text-center text-black dark:text-white font-bold mb-5">Select Service:</h1>
                    <?php
                    $getServices = "SELECT * from tbl_services where specialty = ?";
                    $getServicesSTMT = $conn->prepare($getServices);
                    $getServicesSTMT->bind_param('s', $specialty);
                    if ($getServicesSTMT->execute()){
                      $result = $getServicesSTMT->get_result();
                      if($result->num_rows > 0){
                        while ($row = $result->fetch_assoc()){
                          echo '
                    <div class="form-control px-2 hover:bg-slate-300 dark:hover:bg-gray-600 transition duration-150">
                      <label class="cursor-pointer label">
                        <span class="label-text text-lg sm:text-xl font-medium text-black dark:text-white">'.$row['Service_Type'].'</span>
                        <input type="checkbox" class="checkbox checkbox-info" name="'.$row['Service_Type'].'" value="'.$row['Service_Type'].'" />
                      </label>
                    </div>';
                        }
                      }else{
                        echo '<div class="form-control px-2 hover:bg-slate-300 dark:hover:bg-gray-600 transition duration-150">
                        <H1>No Available service</H1>
                    </div>';
                      }
                    }

                    ?>



                    <div class="modal-action">

                      <!-- if there is a button, it will close the modal -->
                      <a class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none" onclick='toggleDialog("services")'>Close</a>


                    </div>
                  </div>
                </dialog>
                <input id='serviceSelected' required type='hidden' name='serviceSelected' value=''>
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
                                  <select disabled name="consultant-name" class="select
                select-bordered text-black dark:text-white w-full   bg-gray-300 dark:bg-gray-600
                text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500
                focus:ring-opacity-50 mb-4 sm:mb-0 sm:mr-4 disabled:bg-white dark:disabled:bg-gray-600 disabled:text-black dark:disabled:text-white">
                                    <option  selected value='' disabled>Select consultant</option>
                                      <?php
                                      $sql =
                                          "SELECT * FROM tbl_staff WHERE role = 'doctor'";
                                      $stmt = $conn->prepare($sql);
                                      $stmt->execute();
                                      $result = $stmt->get_result();

                                      while ($row = $result->fetch_assoc()) {
                                          $middleInitial = substr(
                                              $row['Middle_Name'],
                                              0,
                                              1
                                          );
                                          $selected =
                                              $row['Staff_ID'] == $staff_id
                                                  ? 'selected'
                                                  : '';
                                          echo "<option value='{$row['Staff_ID']}' $selected>{$row['First_Name']} $middleInitial. {$row['Last_Name']}</option>";
                                      }
                                      ?>

                                  </select>
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
                            <div class="flex flex-col items-center p-4 followUpsection">
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
                                    <label for="appointment-date" class="block text-md font-medium">
                                        Follow Up Date: <span id='appointmentDateNote' class='text-sm text-info hidden'> (Please check doctor schedule)</span>
                                    </label>
                                  <input
                                    type="date"
                                    id="appointment-date"
                                    name="followUpDate"
                                    required
                                        class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]"
                                    />
                                    <label for="appointment-time" class="block text-md font-medium">
                                        Follow Up Time:
                                        </label>
                                  <select id="appointment-time"  required name="followUpTime" class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]">

                                  </select>

                                </div>
                                <div id="completedDetails" class="hidden">
                                    <h2 class="text-md mt-4 font-semibold">This patient will be marked as no schedule</h2>
                                </div>
                            </div>




                        </div>

                        <div class="border border-gray-400 mb-10"></div>

                        <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Results</h2>
                            <!-- Images dito. pag nag upload sa upload file button dito lalabas dapat. kapag kunwari lima inupload na picture dapat lima din tong buong DIV -->
                                <div class="flex flex-wrap gap-2 justify-center items-center w-full mb-3" id='ImageResults'>                         

                                </div>


                        <div class="chart-actions text-center my-4 ">                             
                            <input type="file" accept="image/*" name='resultImage[]' multiple class="file-input file-input-bordered file-input-info mb-3 w-full max-w-xs bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300 fileUploadsection" />

                            <div id="editControls" class="space-x-4">
                              <input id="updateBtn" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none " type="submit" value="Submit">
                            </div>
                        </div>
              </form>




            </div>


            <!-- modal content for edit patient information -->
            <dialog id="editpatient_info" class="modal bg-opacity-30 bg-black">
                <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                    <h3 class="font-bold text-3xl">Edit Patient</h3>
                    <form id="EditpatientForm" >
                      <input type='hidden' name='patient_chart_id' value='<?php echo $chart_id?>'>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 mt-5">
                                <label class="block text-lg">
                                    First Name:
                                    <input type="text" 
                                        name="patient_first-name"
                                        value="<?php echo $Patient_firstname?>"
                                        required  
                                        placeholder="Name"
                                        class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white " />
                                </label>
                              <label class="block text-lg">
                                Middle Name:
                                <input type="text"
                                       name="patient_middle-name"
                                       value="<?php echo $Patient_middle_name;?>"
                                       required
                                       placeholder="Name"
                                       class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white " />
                              </label>
                              <label class="block text-lg">
                                Last Name:
                                <input type="text"
                                       name="patient_last-name"
                                       value="<?php echo $Patient_lastname?>"
                                       required
                                       placeholder="Name"
                                       class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white " />
                              </label>

                            <div>
                                <label class="block text-lg">
                                    Contact Number:
                                    <input type="tel"
                                    name="patient_contact-number"
                                           value="<?php echo $Patient_ContactNumber?>"
                                    required 
                                    autocomplete="off"
                                    placeholder="Contact Number" 
                                    pattern="^\d{11}$" 
                                    minlength="11" 
                                    maxlength="11" 
                                    title="Please enter up to 11 numeric characters." 
                                    class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white"
                                    oninput="validateNumericInput(this); setCustomValidity('');"
                                    oninvalid="setCustomValidity(this.value.length !== 11 ? 'Please enter exactly 11 digits.' : '');"/>
                                </label>
                            </div>           
                            <div>
                                <label class="block text-lg">
                                    Sex:
                                    <select id="sex"
                                            required
                                            class="select select-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white text-lg" name="patient_sex">
                                        <option value="" disabled selected>Select...</option>
                                      <option value="Male" <?php if ($patient_Sex == 'Male') echo 'selected'; ?> >Male</option>
                                      <option value="Female" <?php if ($patient_Sex == 'Female') echo 'selected'; ?> >Female</option>

                                    </select>
                                </label>
                            </div>
                            <div>
                                <label class="block text-lg">
                                    Email:
                                    <input type="email"
                                    name="patient_email"
                                    required
                                           value='<?php echo $Patient_Email?>'
                                    autocomplete="off"
                                    placeholder="Email"
                                    class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white "/>
                                </label>
                            </div>

                            <div>
                                <label class="block text-lg">
                                    Address:
                                    <input type="text" 
                                    name="patient_address"
                                           value="<?php echo $Patient_address?>"
                                    autocomplete="off"
                                    placeholder="Address" 
                                    required 
                                    class="input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white " />
                                </label>
                            </div>
                            <div>
                                <label class="block text-lg">
                                    Date of Birth:
                                    <input type="date"
                                    id="dob"
                                           value='<?php echo $patientDOB?>'
                                    name="patient_dob"
                                    required 
                                    class="dob-input input input-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white [color-scheme:light] dark:[color-scheme:dark]" />
                                </label>
                            </div>


                          <div>
                            <label class="block text-lg">
                              Patient Status
                              <select id="patient_status"
                                      required
                                      class="select select-bordered w-full p-2 bg-white dark:bg-gray-600  text-black dark:text-white text-lg" name="patient_status">
                                <option value="" disabled selected>Change status</option>
                                <option value="To be Seen" <?php if ($patient_status == 'To be Seen') echo 'selected'; ?> >To be Seen</option>
                                <option value="Follow Up" <?php if ($patient_status == 'Follow Up') echo 'selected'; ?> >Follow Up</option>
                                <option value="Completed" <?php if ($patient_status == 'Completed') echo 'selected'; ?> >Completed</option>
                              </select>
                            </label>
                          </div>


                        </div>
                        <div class="flex justify-center">
                            <input type="submit" value="Update" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none">
                        </div> 
                    </form>

                    <div class="modal-action">
                      <a class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black  border-none" onclick='toggleDialog("editpatient_info")'>Close</a>
                    </div>
                </div>
            </dialog>
            <!-- modal content for edit patient information end -->

            </section>
          </div>

    <!-- print content -->
        <div class="recordContent hidden">
              <a id="save_to_image">
                <div class="invoice-container">
                  <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                      <td colspan="2">
                        <table>
                          <tr>
                            <td class="title">
                              <img
                                src="../images/HCMC-blue.png"
                                style="width: 100%; max-width: 100px"
                              />
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr class="information">
                      <td colspan="2">
                      <table class="table-fixed w-full">
                        <tr>
                          <td class="w-1/2 p-2 align-top">
                            <p><strong>Name:</strong> Franklin C. Saint</p>
                            <p><strong>Sex:</strong> Male</p>
                            <p><strong>Medical Conditions:</strong> N/A</p>
                            <p><strong>Email:</strong> franklinsaint@gmail.com</p>
                            <p><strong>Address:</strong> blk 10 lot 4 via roma street Romanville Tagapo Sta. Rosa Laguna Philippines</p>
                          </td>
                          <td class="w-1/2 p-2 align-top">
                            <p><strong>Age:</strong> 22</p>
                            <p><strong>Weight:</strong> 60kg</p>
                            <p><strong>Contact Number:</strong> 09763218546</p>           
                            <p><strong>Date of Birth:</strong> February 21, 2002</p>
                          </td>
                        </tr>
                      </table>
                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Consultation Date</td>
                      <td class="font-medium py-2">July 21, 2024</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Consultant</td>
                      <td class="font-medium py-2">Dr. John Edward Dionisio</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Heart Rate</td>
                      <td class="font-medium py-2">90</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Temperature</td>
                      <td class="font-medium py-2">36</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Blood Pressure</td>
                      <td class="font-medium py-2">110/70</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Saturation</td>
                      <td class="font-medium py-2">96%</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Chief Complaint</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2">Experiencing high fever, severe headache, and joint pain for the past few days.</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Physical Examination</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2">
                      Patient appears febrile and fatigued.
                      Normal heart sounds, no murmurs, regular rhythm.
                      Clear breath sounds bilaterally, no wheezing or crackles.
                      Soft, mild tenderness in the right upper quadrant, no organomegaly.
                      No rash or petechiae observed.
                      Stable except for elevated temperature.
                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Assessment</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2">
                      Febrile illness with severe headache and myalgia, suspected dengue fever.
                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Treatment Plan</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2">
                      Order dengue NS1 antigen test and dengue IgM and IgG antibody tests to confirm the diagnosis.
                      Recommend complete blood count (CBC) to check for leukopenia and thrombocytopenia, which are common in dengue fever.
                      Advise the patient to maintain adequate hydration by drinking plenty of fluids.
                      Prescribe acetaminophen 500 mg, one tablet every 6 hours as needed for fever and pain.
                      Instruct the patient to avoid NSAIDs such as ibuprofen and aspirin due to the risk of bleeding.
                      </td>
                    </tr>
                  </table>
                </div>
              </a>
            </div>
<!-- print content end -->

            



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
          function isNumeric(value) {
            return !isNaN(value) && (typeof value === 'number' || !isNaN(parseFloat(value)));
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
              url: 'ajax.php?action=getPatientRecord&record_id='+ encodeURIComponent(id) + '&chart_id='+encodeURIComponent(<?php echo $chart_id; ?>),
              method: 'GET',
              dataType: 'json',
              success: function(data) {

                if (data) {

                  $('#availedService').html('<strong class="text-xl">Service: </strong><br><span class="text-lg font-medium">'+data.availedService+'</span>');
                  document.querySelector('#patientRecordForm input[name="serviceSelected"]').value = data.availedService;
                  document.querySelector('#patientRecordForm input[name="consultation-date"]').value = data.consultationDate;
                  document.querySelector('#patientRecordForm input[name="record_id"]').value = data.Record_ID;
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
          document.getElementById('patientRecordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let endpoint = 'createPatientRecord';
            let form_data = new FormData(e.target);

            if (form_data.get('serviceSelected') === '') {
              document.getElementById('error').innerHTML = 'Please select a service type';
              toggleDialog('errorAlert');
              return;
            }if ( !isNumeric(form_data.get('heart-rate')) || !isNumeric(form_data.get('temperature')) ){
              document.getElementById('error').innerHTML = 'Please input correct data type';
              toggleDialog('errorAlert');
              return;

            }

            $.ajax({
              url: 'ajax.php?action=' + endpoint + '&chart_id=' + encodeURIComponent('<?php echo $chart_id; ?>'),
              type: 'POST',
              data: form_data,
              processData: false,
              contentType: false,
              success: function(response) {
                if (parseInt(response) === 1) {
                  toggleDialog('SuccessAlert');
                  window.location.href = 'staff-patientFullRecord.php?chart_id=<?php echo $chart_id; ?>';
                } else {
                  document.getElementById('error').innerHTML = response;
                  toggleDialog('errorAlert');

                }
              }
            });
          });
          document.getElementById('EditpatientForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let endpoint = 'Editpatient';
            let form_data = new FormData(e.target);
            $.ajax({
              url: 'ajax.php?action=' + endpoint,
              type: 'POST',
              data: form_data,
              processData: false,
              contentType: false,
              success: function(response) {
                if (parseInt(response) === 1) {
                  toggleDialog('SuccessAlert');
                  window.location.href = 'staff-patientFullRecord.php?<?php echo'chart_id='.$_GET['chart_id']; ?>';
                } else {
                  document.getElementById('error').innerHTML = response;
                  toggleDialog('errorAlert');

                }
              }
            });
          });

          document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('#services input[type="checkbox"]');
            const hiddenInput = document.getElementById('serviceSelected');

            checkboxes.forEach(checkbox => {
              checkbox.addEventListener('change', () => {
                const selectedServices = Array.from(checkboxes)
                  .filter(checkbox => checkbox.checked)
                  .map(checkbox => checkbox.value)
                  .join(', ');

                hiddenInput.value = selectedServices;
                $('#availedService').html('<strong class="text-xl">Service: </strong><br><span class="text-lg font-medium">'+ selectedServices +'</span>');
              });
            });
          });

          document.getElementById('visitDropdown').addEventListener('change', function() {
            if (this.value !== 'newRecord') {
              getRecords(this.value);
              getResImg(this.value);
              $('#serviceTypeBTN').html('Edit Service Type');
            } else {
              document.getElementById('patientRecordForm').reset();
              $('#availedService').empty();
              document.getElementById('record_id').value = '';
              resetImgDisplay();
              $('#serviceTypeBTN').html('Select Service Type');
              document.querySelector('#patientRecordForm input[name="serviceSelected"]').value = '';
            }
          });

        document.addEventListener('DOMContentLoaded',function(){
          getDoctorAvailability(<?php echo $staff_id?>)
        })
        </script>


        <!-- for print and save only
        <script src="../js/index.js"></script>
        <script src="../js/html2canvaspro.js"></script> 
        -->


        <script src='../js/doctorAppoimtmentAvailability.js' ></script>
</body>
</html>