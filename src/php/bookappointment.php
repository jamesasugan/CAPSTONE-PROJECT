<!-- patient only  -->

<?php
session_start();
require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::PATIENT]))
{
  return;
}

include_once '../Database/database_conn.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book Appointment</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
  </head>
  <body>


    <?php include 'navbar.php'; ?>
    <section
      id="booking"
      class="book-appointment w-full flex justify-center items-center pt-24 pb-10 p-5
      bg-[#f6fafc] dark:bg-[#17222a]"
    >
      <div class="book-form w-full max-w-7xl mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]" id='appointmentForm'>

        <h2 class="text-3xl font-bold mb-2 text-center">Set an Appointment</h2>
        <p class="font-medium text-center">
          Kindly answer the form to set a face-to-face appointment for
          consultation, test, or procedure in our clinic.
        </p>
        <p class="font-medium  text-center">View <a href="doctorschedule.php" target="_blank" class="link text-blue-400 font-bold">Doctor's Schedule</a>  for more information about the schedules.</p>

        <form id='patient_bookAppointment' action="#" method="GET">

          <h3 class="text-xl font-bold mt-5">Select person for appointment</h3>
          <div class="w-full sm:w-2/4">
            <select
              id="AppointPerson"
              name="AppointPerson"
              required
              class="select select-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 text-lg sm:text-xl text-black dark:text-white"
            >
              <option value="" disabled selected>...</option>
                <?php
                $sql =
                    "SELECT * FROM tbl_accountpatientmember  where user_info_ID = ? and status = 'Active'";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $_SESSION['online_Account_owner_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $middleInitial = strlen($row['Middle_Name']) >= 1 ? substr($row['Middle_Name'], 0, 1) : '';
                    echo '<option value="' . $row['Account_Patient_ID_Member'] . '">' . $row['First_Name'] . ' ' . $middleInitial . '. ' . $row['Last_Name'] .'</option>';
                }
                ?>
            </select>
          </div>
          <div class='flex justify-between'>
            <div class='w-1/2 text-start'>
              <h3 class="text-xl font-bold mt-5">Service</h3>
            </div>
          </div>

          <!-- <div class="w-full max-w-md">
            <label for="service-type" class="block text-lg font-medium mb-1">Reason/Purpose</label>
            <textarea   name="reason" placeholder="Type here" required class="textarea-bordered textarea w-full p-2 bg-gray-300 dark:bg-gray-600"></textarea>
          </div> -->
        <fieldset class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">

           <div class="flex flex-col w-full">
             <ul class="w-full text-lg font-medium text-gray-900 bg-gray-300 dark:bg-gray-600 border border-gray-200 rounded-lg dark:border-gray-600 dark:text-white">
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
          <div class="w-full md:w-auto md:col-span-1">
            <select onchange='getDoctorAvailability(this.value)'
              id="doctor"
              name="doctor"
              required
              class="select select-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 text-lg sm:text-xl text-black dark:text-white">

            </select>
          </div>

          <a class="mt-2 btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none cursor-pointer w-full" onclick="serviceModal.showModal()">Choose a Service</a>
          <!-- dito mo lagay kung ano piniling service, hide mo kapag wala pa. yung naka strong yung specialty -->
          <p class="font-medium text-lg mt-1"><strong id='ServiceTitle'>Selected service: </strong> <span id='availedServices'> </span></p>

        <div class="w-full md:w-auto md:col-span-1">
          <label for="appointment-date" class="block text-base sm:text-lg font-medium">
            Appointment Date<span id='appointmentDateNote' class='text-sm text-info hidden'> (Please check doctor schedule)</span>
          </label>
          <input disabled type="date" id="appointment-date" name="appointment-date" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-lg text-black dark:text-white disabled:bg-gray-200 disabled:text-gray-400 dark:disabled:text-gray-400 disabled:border-gray-300" />
        </div>
        <div class="w-full md:w-auto md:col-span-1">
          <label for="appointment-time" class="block text-base sm:text-lg font-medium">
            Available  Time
          </label>
          <select id="appointment-time" name="appointment-time" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark] text-lg text-black dark:text-white">

          </select>
        </div>

        </fieldset>



          <h3 class="text-xl font-bold mb-2 mt-5">Data Privacy Note</h3>
          <p class="mb-4">
          This policy applies to information acquired from patients of Holistic Choice Multispecialty Clinic who have completed the Book Appointment process and other accompanying forms that are required to administer their requests. Furthermore, this notice will inform you how we process and protect your personal information. By visiting this page or reading this notice, you certify that you have read, understood, and agree to the terms below
          </p>
          <p class="mb-4">Information collected and held by HCMC is subject to the Data Privacy Act of 2012, and the clinic respects and supports privacy protection in relation to the information collected. HCMC is committed to complying with the Data Privacy Act (Republic Act No. 10173).</p>
          <label class="flex items-center mb-4 ">
            <input
              type="checkbox"
              required
              class="form-checkbox h-5 w-5 rounded-none checkbox checkbox-success [color-scheme:light] dark:[color-scheme:dark]"
              name="privacy"
              value='checked'
            />
            <span class="ml-2">I understand</span>
          </label>

          <div class="flex justify-center mt-4 mb-2">
            <?php if (
                isset($_SESSION['user_type']) &&
                $_SESSION['user_type'] == 'patient'
            ):

                $sql = 'SELECT * FROM account_user_info where User_ID = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                ?>
            <input type='hidden' name='online_user_id' value='<?php echo $row['user_info_ID']; ?>'>
            <input type='hidden' name='book_status' value='pending'>
            <input type='hidden' name='serviceType' value='' id='ServiceType'>
            <input type='hidden' name='appointment_type' value='Online'>
              <input
                type="submit"
                value="Submit"
                class="bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded w-1/2 cursor-pointer"
              />
            <?php
            else:
                 ?>
              <a href='login.php' class='text-center bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded w-1/2 cursor-pointer'>Submit</a>
            <?php
            endif; ?>

          </div>

        </form>

        <!-- pashow nito pagnasubmit -->
        <dialog id='bookCompletAlert' class='modal'>
          <div  class="flex justify-center " onclick='toggleDialog("bookCompletAlert")'>
              <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Appointment has been booked! Please wait for confirmation message.</span>
              </div>
          </div>
        </dialog>

        <dialog id='bookFailed'  class='modal'  onclick='toggleDialog("bookFailed")'>
          <div  class="flex justify-center pointer-events-none">
            <div role="alert" class="inline-flex items-center bg-error border border-red-400 text-black px-4 py-3 rounded relative">
              <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
              <span id='error'></span>
            </div>
          </div>
        </dialog>

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

      </div>
    </section>

  </body>
  <script>
    let selectedVisitType = '';
    document.querySelectorAll('input[name="VisitType"]').forEach(function(radio) {
      radio.addEventListener('change', function() {
        selectedVisitType = this.value;
        getAppointDoctor(selectedVisitType);
        loadServices();
      });
    });

    document.getElementById('doctor').addEventListener('change', function() {
      loadServices();
    });

    function loadServices() {
      const doctorId = document.getElementById('doctor').value;
      document.getElementById('ServiceType').value = '';
      $('#availedServices').html('');
      if (selectedVisitType && doctorId) {
        getServices(doctorId, selectedVisitType);
      }

    }
    function getAppointDoctor(selectedVisitType){
      $.ajax({
        url: 'ajax.php?action=bookAppointmentDoctor&VisitType=' + encodeURIComponent(selectedVisitType),
        method: 'GET',
        dataType: 'html',
        success: function(data) {
          $('#doctor').html(data);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching data:', error);
        }
      });
    }

    function getServices(staff_Id, visitType){
      $.ajax({
        url: 'ajax.php?action=getDoctorServices&VisitType=' + encodeURIComponent(visitType) + '&staff_id=' + encodeURIComponent(staff_Id),
        method: 'GET',
        dataType: 'html',
        success: function(data) {
          $('#services').html(data);
          attachCheckboxListeners();
        },
        error: function(xhr, status, error) {
          console.error('Error fetching data:', error);
        }
      });
    }

    function attachCheckboxListeners() {
      let services = document.getElementById('services');
      const checkboxes = services.querySelectorAll('input[type="checkbox"]');
      const serviceTypeInput = document.getElementById('ServiceType');

      checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          const selectedSpecialty = this.getAttribute('data-specialty');

          if (this.checked) {
            checkboxes.forEach(cb => {
              if (cb !== this && cb.getAttribute('data-specialty') !== selectedSpecialty) {
                cb.checked = false;
              }
            });
          }

          updateServiceTypeInput();
        });
      });

      function updateServiceTypeInput() {
        let serviceval = Array.from(checkboxes)
          .filter(cb => cb.checked)
          .map(cb => cb.value)
          .join(';');
        serviceTypeInput.value = serviceval;
        $('#availedServices').html(': ' + serviceval);
      }
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
    document.getElementById('patient_bookAppointment').addEventListener('submit', function(e){
      e.preventDefault();
      let form_data = new FormData(e.target);
      if (!form_data.get('serviceType')){
        document.getElementById('error').innerHTML = 'Please select service';
        toggleDialog('bookFailed')
      }
      $.ajax({
        url: 'ajax.php?action=patientBookAppointment',
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        success: function(response) {
          if (parseInt(response) === 1) {
            toggleDialog('bookCompletAlert');
          }else {
            document.getElementById('error').innerHTML = response;
            toggleDialog('bookFailed')
          }
          e.target.reset();
          console.log(response);
        }
      });
    });




  </script>
  <script src='../js/doctorAppoimtmentAvailability.js'></script>
  <script>

    document.addEventListener('DOMContentLoaded', function() {

    });





  </script>


  
</html>
