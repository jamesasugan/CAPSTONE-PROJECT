<?php
include '../Database/database_conn.php';
session_start();



if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'patient'){
    header("Location: index.php");

}


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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body>

    <?php include 'admin-navbar.php'; ?>
    
    <section
      id="addwalkInPatient"
      class="w-full min-h-screen flex justify-center items-center pt-28 pb-10 p-5
      bg-[#f6fafc] dark:bg-[#17222a]"
    >
      <div
        class="w-full max-w-7xl mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]"
      >
        <h2 class="text-3xl font-bold mb-10">Add New Patient</h2>

        <form id='walkInPatientForm' action="#" method="GET">
        <fieldset class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
          <legend class="text-xl font-bold mb-2 col-span-full">Service:</legend>
          <div class="flex flex-col w-full">           
            <ul class="w-full text-lg font-medium text-gray-900 bg-gray-300 dark:bg-gray-600 border border-gray-200 rounded-lg dark:border-gray-600 dark:text-white">
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

          <div class="w-full">
            <label for="service-type" class="block text-lg font-medium mb-1">What type of service?</label>
            <select
                id="service-type"
                required
                class="select select-bordered w-full bg-gray-300 dark:bg-gray-600 text-base sm:text-lg lg:text-xl focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
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
        </div>
          <div class="w-full">

            <label
              for="appointDoctor"
              class="block font-medium text-black dark:text-white text-base sm:text-lg"
            >
              Select Doctor's Name:</label
            >
            <select
              id="appointDoctor"
              name="appointDoctor"
              class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white disabled:bg-white disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300"
              required
            >
              <option value="" disabled selected>Select a Doctor</option>
                <?php
                $sql = "SELECT * FROM tbl_staff where role = 'doctor' ";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()){
                    $middleInitial = (strlen($row['Middle_Name']) >= 1) ? substr($row['Middle_Name'], 0, 1) : '';
                    echo '<option value="'.$row['Staff_ID'].'">'.$row['First_Name'].' '.$middleInitial.'. '.$row['Last_Name'].'</option>';
                }
                ?>
            </select>

          </div>



          <div id='doctorList' class="form-group mt-5">

          </div>
        </fieldset>



          <h3 class="text-xl font-bold mt-5 mb-2">Personal Information</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="first-name" class="block text-base sm:text-lg font-medium">First Name</label>
                <input type="text" id="first-name" name="first-name" autocomplete="off" placeholder="First Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
            </div>
            <div>
                <label for="middle-name" class="block text-base sm:text-lg font-medium">Middle Name</label>
                <input type="text" id="middle-name" name="middle-name" placeholder="Middle Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
            </div>

            <div>
                <label for="last-name" class="block text-base sm:text-lg font-medium">Last Name</label>
                <input type="text" id="last-name" name="last-name" placeholder="Last Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
            </div>
            <div>
                <label
                    for="email"
                    class="block font-medium text-black dark:text-white text-base sm:text-lg overflow-hidden whitespace-nowrap text-overflow-ellipsis"
                      >Email Address</label
                  >
                <input id="email" name="email" type="email" autocomplete="email" required placeholder="Email"
                      class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600"/>
            </div>
            <div>
                <label for="contact-number" class="block text-base sm:text-lg font-medium">Contact Number</label>
                <input id="contact-number" name="contact-number" type="tel" required autocomplete="off" placeholder="Contact Number" pattern="[0-9]{1,11}" minlength="11" maxlength="11" title="Please enter up to 11 numeric characters." class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
            </div>

            <div>
                <label for="sex" class="block text-base sm:text-lg font-medium">Sex</label>
                <select id="sex" required class="select select-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 text-lg" name="sex">
                    <option value="" disabled selected>Select...</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div>
                <label for="dob" class="block text-base sm:text-lg font-medium">Date of Birth</label>
                <input type="date" id="dob" name="dob" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]" />
            </div>

            <div>
                <div class="block text-base sm:text-lg font-medium mb-1">Is the Patient vaccinated?</div>
                <div class="flex items-center space-x-4 p-2 bg-gray-300 dark:bg-gray-600 rounded">
                    <label class="flex items-center">
                        <input type="radio" name="vaccinated" value="yes" class="radio radio-primary" required>
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="vaccinated" value="no" class="radio radio-primary" required>
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>
            <div>
                <label for="address" class="block text-base sm:text-lg font-medium">Address</label>
                <input type="text" id="address" name="address" autocomplete="off" placeholder="Address" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
            </div>
            <div class=''>
              <label for="reason" class="block text-base sm:text-lg font-medium">Reason</label>
              <textarea id='reason' name="reason" autocomplete="off" placeholder="Type here..." required class="textarea p-2 textarea-bordered bg-gray-300 dark:bg-gray-600  w-full" ></textarea
            </div>

          </div>


          <div class="flex justify-center mt-10 mb-2 w-full ">
            <input
              type="submit"
              value="Submit"
              class="bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded w-1/2 cursor-pointer"
            />
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
                window.location.href = 'admin-addwalkInPatient.php';
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
</body>
</html>