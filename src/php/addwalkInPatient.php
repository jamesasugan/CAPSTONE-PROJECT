<!-- admin -->

<?php
session_start();
require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::ADMIN]))
{
  return;
}

include '../Database/database_conn.php';
?>

<!DOCTYPE html>
<html lang='en' xmlns='http://www.w3.org/1999/html'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Walk In Patient</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/staff.css" />
    <script
      src="https://kit.fontawesome.com/70df29d299.js"
      crossorigin="anonymous"
    ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" type="image/x-icon" href="../images/logosmall.png">
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="../css/services-swiper.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/main.js" defer></script>
    <script src="../js/admin-addwalkInPatient.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body>
<?php
$user_id = $_SESSION['user_id'];
$sql = 'SELECT role from tbl_staff where User_ID = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['role'] == 'doctor') {
        include 'staff-navbar.php';
    } else {
        include 'admin-navbar.php';
    }
}
?>
    <?php  ?>
    
    <section
      id="addwalkInPatient"
      class="w-full min-h-screen flex justify-center items-center pt-28 pb-10 p-5
      bg-[#f6fafc] dark:bg-[#17222a]"
    >
      <div class="w-full max-w-7xl mx-auto p-10 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1] min-h-[600px]">
        <h2 class="text-3xl sm:text-4xl font-bold mb-10 text-center">Add Walk In Patient</h2>

        <form id='walkInPatientForm'>
          <input id='ServiceType' type='hidden' value='' name='ServiceType'>

       

          <!-- <div class="mx-auto w-1/2 px-4 py-8 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
            <div class="text-lg font-medium mb-4">
              Does this Patient already have an Online Account?
            </div>
            <div class="flex items-center space-x-4 bg-gray-300 dark:bg-gray-600 rounded p-2">
              <label class="flex items-center">
                <input type="radio" name="recordExist" value="Yes" class="radio radio-primary" required>
                <span class="ml-2">Yes</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="recordExist" value="No" class="radio radio-primary" required>
                <span class="ml-2">No</span>
              </label>
            </div>

            <div id="searchPatientRecord" class="hidden mt-4">
              <label for="searchInput1" class="block text-lg font-medium text-gray-800 dark:text-white">Search Patient Record</label>
              <div class="relative">
                <input type="text" id="searchInput1" placeholder="Search..." class="input input-bordered w-full px-3 py-2 bg-white dark:bg-gray-800 text-gray-800 dark:text-white">
                <ul id="optionsList1" class="absolute z-10 hidden w-full py-1 bg-white border border-gray-300 rounded-md shadow-md dark:bg-gray-800 dark:border-gray-700"></ul>
              </div>
            </div>
          </div> -->

<!-- 
            <div id="patientInfo" class="grid grid-cols-1 md:grid-cols-2 gap-1 text-lg sm:text-xl mt-5">
                <p><strong>Name: </strong>Diddy</p>
                <p><strong>Contact Number: </strong>09231512312</p>
                <p><strong>Age: </strong>21</p>
                <p><strong>Sex: </strong> Male</p>
                <p><strong>Weight: </strong> 60</p>
                <p><strong>Medical Condition: </strong> N/A</p>
                <p><strong>Email: </strong>diddy@gmail.com</p>
                <p><strong>Address:</strong> Ohio, USA</p>
                <p><strong>Date of Birth: </strong> December 25, 2000</p>
                <p><strong>Last Visit: </strong> June 25, 2024</p>
                <p><strong>Services Taken: </strong>X-Ray: Skull X-Ray, 
                Upper Extremities. General Medicine. Internal Medicine.</p>
            </div> -->

          <div id="serviceSection" class="grid grid-cols-1 md:grid-cols-2 gap-4"> 
            <h3 class="text-xl font-bold col-span-full mt-5">Service:</h3>
            <div id='doctorList' class="form-group">
              <div class="flex flex-col w-full">           
                <ul class="w-full text-lg font-medium text-gray-900 bg-gray-100 dark:bg-gray-600 border border-gray-200 rounded-lg dark:border-gray-600 dark:text-white">
                  <li class="border-b border-gray-400 dark:border-slate-300">
                    <label class="flex items-center pl-3 w-full cursor-pointer">
                      <input id="horizontal-list-radio-license" 
                      type="radio" 
                      value="Consultation" 
                      name="VisitType"
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
                      name="VisitType"
                      class="radio radio-info [color-scheme:light] dark:[color-scheme:dark]" 
                      required>
                      <span class="py-3 ml-2 text-lg font-medium ">Test/Procedure</span>
                    </label>
                  </li>
                </ul>
              </div>
            </div>


            <div class="w-full">
              <label for="appointDoctor" class="block font-medium text-black dark:text-white text-base sm:text-lg">
                Choose a Doctor:</label>
              <select onchange='getDoctorAvailability(this.value)' id="doctor" name="doctor" class="select select-bordered w-full p-2 bg-gray-100 dark:bg-gray-600 text-lg" required>
              </select>
            </div>
            
            

            <a class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none cursor-pointer w-1/2" onclick="serviceModal.showModal()">Choose a Service</a>
            <!-- dito mo lagay kung ano piniling service, hide mo kapag wala pa. yung naka strong yung specialty -->
            <div></div>

            <!-- gawin mong ul, ganito layout
              Selected Service:
              <ul>Internal Medicine</ul>

              sa baba ng text yung service
            -->
            <p class="font-medium text-lg mt-1 text-black dark:text-white"><strong>Selected Service:</strong> <span id='availedServices'> </span></p>
            
            <div></div>
            

            <div class="w-full md:w-auto md:col-span-1">
              <label for="appointment-date" class="block text-base sm:text-lg font-medium">
                Appointment Date<span id='appointmentDateNote' class='text-base text-error hidden'> (NOT Available, please select another day)</span>
              </label>
              <input disabled type="date" id="appointment-date" name="appointment-date" required class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-lg text-black dark:text-white disabled:bg-gray-200 disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" />
            </div>
            <div class="w-full md:w-auto md:col-span-1">
              <label for="appointment-time" class="block text-base sm:text-lg font-medium">
                Available  Time
              </label>
              <select id="appointment-time" name="appointment-time" required class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-lg text-black dark:text-white">

              </select>
            </div>
          </div>
  




          <div id="personalInfoSection">
            <h3 class="text-xl font-bold mt-5 mb-2">Personal Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                  <label for="first-name" class="block text-base sm:text-lg font-medium">First Name</label>
                  <input type="text" id="first-name" name="first-name" autocomplete="off" placeholder="First Name" required class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600" />
              </div>
              <div>
                  <label for="middle-name" class="block text-base sm:text-lg font-medium">Middle Name</label>
                  <input type="text" id="middle-name" name="middle-name" placeholder="Middle Name" required class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600" />
              </div>

              <div>
                  <label for="last-name" class="block text-base sm:text-lg font-medium">Last Name</label>
                  <input type="text" id="last-name" name="last-name" placeholder="Last Name" required class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600" />
              </div>
              <div>
                  <label
                      for="email"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg overflow-hidden whitespace-nowrap text-overflow-ellipsis"
                        >Email (optional)</label
                    >
                  <input id="email" name="email" type="email" autocomplete="email" placeholder="Email"
                        class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600"/>
              </div>
              <div>
                  <label for="weight" class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis">Weight (optional)</label>
                  <input id="weight" name="weight" type="number" value="" autocomplete="off" placeholder="Weight" class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600" />
              </div>
              <div>
                  <label for="medicalCondition" class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis">Medical Conditions, if any:</label>
                  <input id="medicalCondition" name="medicalCondition" type="text" value="" autocomplete="off" placeholder="Medical Conditions" class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600" />
              </div>
              <div>
                  <label for="contact-number" class="block text-base sm:text-lg font-medium">Contact Number</label>
                  <input id="contact-number" name="contact-number" type="tel" required autocomplete="off" placeholder="Contact Number" pattern="^\d{11}$" minlength="11" maxlength="11" title="Please enter up to 11 numeric characters." class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600" 
                  oninput="validateNumericInput(this); setCustomValidity('');"
                  oninvalid="setCustomValidity(this.value.length !== 11 ? 'Please enter exactly 11 digits.' : '');" />
              </div>

              <div>
                  <label for="sex" class="block text-base sm:text-lg font-medium">Sex</label>
                  <select id="sex" required class="select select-bordered w-full p-2 bg-gray-100 dark:bg-gray-600 text-lg" name="sex">
                      <option value="" disabled selected>Select...</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                  </select>
              </div>
              <div>
                  <label for="dob" class="block text-base sm:text-lg font-medium">Date of Birth</label>
                  <input type="date" id="dob" name="dob" required class="dob-input input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]" />
              </div>

              <div>
                  <label for="address" class="block text-base sm:text-lg font-medium">Address</label>
                  <input type="text" id="address" name="address" autocomplete="off" placeholder="Address" required class="input input-bordered w-full p-2 bg-gray-100 dark:bg-gray-600" />
              </div>
            </div>
          </div>


          <div class="flex justify-center mt-10 mb-2 w-full ">
            <input type="submit" value="Submit" class="bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded w-1/2 cursor-pointer transition duration-150"/>
          </div>

        </form>


        <dialog id='addedNewPatientNotif'  class='modal'>
          <div class="flex justify-center" onclick='toggleDialog("addedNewPatientNotif")'>
              <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Patient Successfully Added!</span>
              </div>
          </div>
        </dialog>

      </div>
    </section>

    <!-- service modal -->
    <dialog id="serviceModal" class="modal">
            <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 text-black dark:text-white overflow-auto p-0">
              <div class="modal-header sticky top-0 bg-gray-200 dark:bg-gray-700 z-10 px-10 pt-10">
                    <div class="flex justify-between">
                      <h3 class="font-bold text-3xl mb-0 text-center">Select a Service</h3>
                        <form method="dialog">
                          <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black border-none mb-2">Close</button>
                        </form>
                    </div>
                    <div class="border border-gray-600 dark:border-slate-300"></div>
              </div>



<!--
              <div class="w-full sm:flex sm:items-center justify-end mb-5 mt-5">
                <div class="flex w-full sm:w-auto">
                  <input
                    id='search'
                    type="text"
                    name="text"
                    class="input input-bordered appearance-none w-full px-3 py-2 rounded-none bg-white dark:bg-gray-600 text-black dark:text-white border border-black border-r-0 dark:border-white"
                    placeholder="Search"
                    onkeyup=''
                  />
                  <button type="submit" class="btn btn-square bg-gray-400 hover:bg-gray-500  rounded-none dark:bg-gray-500 dark:hover:bg-gray-300 border border-black border-l-0 dark:border-white">
                    <i class="fa-solid fa-magnifying-glass text-black dark:text-white"></i>
                  </button>
                </div>
              </div>
-->
              <div class="text-xl font-medium p-10" id='services'>



              </div>
            </div>
            </div>
          </dialog>
  <!-- services modal  end -->

    <script>

      document.getElementById('walkInPatientForm').addEventListener('submit', function(e){
        e.preventDefault();
        let form_data = new FormData(e.target);
        $.ajax({
          url: 'ajax.php?action=AddWalkInPatient',
          type: 'POST',
          data: form_data,
          processData: false,
          contentType: false,
          success: function(response) {
            if (parseInt(response) === 1) {
              toggleDialog('addedNewPatientNotif');
              setTimeout(function() {
                window.location.href = 'addwalkInPatient.php';
              }, 2000);
            }else {
            }
            e.target.reset();
            console.log(response);
          }
        });
      });
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
    </script>
<script src='../js/doctorAppoimtmentAvailability.js'></script>
</body>
</html>