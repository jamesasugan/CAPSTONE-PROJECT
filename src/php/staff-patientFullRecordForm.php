
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
                    <span class="block" id='vrecName'></span>
                  </div>
                  <div>
                    <strong class="block" >Age</strong>
                    <span class="block" id='vrecAge'></span>
                  </div>
                  <div>
                    <strong class="block" >Sex</strong>
                    <span class="block" id='vrecSex'></span>
                  </div>
                  <div>
                    <strong class="block" >Contact Number</strong>
                    <span class="block" id='vrecContactNum'></span>
                  </div>
                  <div>
                    <strong class="block" >Email</strong>
                    <span class="block" id='vrecEmail'></span>
                  </div>
                  <div>
                    <strong class="block">Weight</strong>
                    <span class="block" id='vrecWeight'></span>
                  </div>
                  <div>
                    <strong class="block">Date of Birth</strong>
                    <span class="block" id='vrecDob'></span>
                  </div>
                  <div>
                    <strong class="block">Medical Condition</strong>
                    <span class="block" id='vrecMDcondition'></span>
                  </div>
                  <div>
                    <strong class="block">Address</strong>
                    <span class="block" id='vrecAddress'></span>
                  </div>
                </div>
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

            <!-- modal content for edit patient information end -->

            </section>
          </div>






        <div id='SuccessAlert' onclick='resetNotif(this.id)' >
        </div>

        <div id='errorAlert'  onclick='resetNotif(this.id)' >
        </div>
      <script src='../js/tools.js'></script>
        <script>

          document.addEventListener('DOMContentLoaded', function(){
            $.ajax({
              url: 'ajax.php?action=getPatientChart_info&chart_id=' + encodeURIComponent('<?php echo $_GET["chart_id"]; ?>') + '&consultant_id=' + encodeURIComponent('<?php echo $staff_id; ?>'),
              type: 'GET',
              success: function(response) {
                if (response.successResponse === 1) {


                  let data = response.data;
                  $('#vrecName').html(data.First_Name + ' ' + data.Middle_Name + ' ' + data.Last_Name);
                  let age = Math.floor((new Date() - new Date(data.DateofBirth)) / (365.25 * 24 * 60 * 60 * 1000));
                  $('#vrecAge').html(age);
                  $('#vrecSex').html(data.Sex);
                  $('#vrecContactNum').html(data.Contact_Number);
                  $('#vrecEmail').html(data.patientEmail);
                  $('#vrecWeight').html(data.Weight);
                  $('#vrecDob').html(formatDate(data.DateofBirth));
                  $('#vrecMDcondition').html(data.Medical_condition);
                  $('#vrecAddress').html(data.Address);
                }else if(response.successResponse === 0){
                  window.location.href = 'staff-patientsRecord.php';
                }else {
                  console.error('Error: ' + response.error);
                }
              }
            });
          })

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
                let services = selectedServices.split(",");
                let mappedServices = services.map(x => "<li>" + x.trim() + "</li>");
                $('#availedService').html('<strong class="text-xl">Service: </strong><br><span class="text-lg font-medium">'+ mappedServices +'</span>');
              });
            });
          });


          document.getElementById('patientRecordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let endpoint = 'createPatientRecord';
            let form_data = new FormData(e.target);
            if (form_data.get('serviceSelected') === '') {
              warningNotifcation('errorAlert', 'Please select a service type');
              return;
            }if ( !isNumeric(form_data.get('heart-rate')) || !isNumeric(form_data.get('temperature')) ){

              warningNotifcation('errorAlert', 'Please input correct data type');
              return;

            }

            $.ajax({
              url: 'ajax.php?action=' + endpoint + '&chart_id=' + encodeURIComponent('<?php echo $_GET['chart_id']; ?>'),
              type: 'POST',
              data: form_data,
              processData: false,
              contentType: false,
              success: function(response) {
                if (response.response === 1) {
                  console.log('asdasdsa');
                  successNotifcation('SuccessAlert', response.message);
                  setTimeout(function() {
                    window.location.href = 'patientOverallRecord.php?chart_id=<?=$_GET["chart_id"]?>&record_id='+response.record_id;
                  }, 2000);
                } else {
                  errorNotifcation('errorAlert' , response.message);
                }
              }

            });
          });
        </script>
      <?php if (isset($_GET['record_id'])){?>
        <script src='../js/patientRecordFormStaff.js'></script>
        <script>
          getRecords(<?=$_GET['record_id']?>, <?=$_GET['chart_id']?>)
        </script>
      <?php }?>





</body>
</html>