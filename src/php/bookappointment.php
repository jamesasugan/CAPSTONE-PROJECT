<?php
session_start();
include_once '../Database/database_conn.php';

if (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'staff') {
    $user_id = $_SESSION['user_id'];
    $sql = 'SELECT role from tbl_staff where User_ID = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['role'] == 'doctor') {
            header('Location: staff-index.php');
        } elseif ($row['role'] == 'admin') {
            header('Location: admin-index.php');
        }
    }
}
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


    <?php include 'navbar-main.php'; ?>


    



    <section
      id="booking"
      class="book-appointment w-full flex justify-center items-center pt-24 pb-10 p-5
      bg-[#f6fafc] dark:bg-[#17222a]"
    >
      <div class="book-form w-full max-w-7xl mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]" id='appointmentForm'>
          <?php if (isset($_SESSION['user_type']) and $_SESSION['user_type']  == 'patient'):
              ?>

            <dialog open class='modal bg-black bg-opacity-20' id='chooseBook'>
              <div class="text-center font-bold text-xl mb-10 bg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1] h-36 rounded w-auto p-5">
                <p>Are you booking for yourself?</p>
                <button class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none mr-5 mt-4" onclick='toggleDialog("chooseBook");getAccountUserInfo()'>Yes</button>
                <button class="btn bg-gray-400 text-black dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-300 border-none" onclick='toggleDialog("chooseBook")'>No</button>
              </div>
            </dialog>

          <?php endif;?>
      <!-- labas mo lang to pag naka log in tas hide mo pagtapos magsagot -->


        <h2 class="text-2xl font-bold mb-2">Set an Appointment</h2>
        <p class="mb-4">
          Kindly answer the form to set a face-to-face appointment for
          consultation, test, or procedure in our clinic. <br>View <a href="doctorschedule.php" target="_blank" class="link text-blue-400 font-bold">Doctor's Schedule</a> for more information about the schedules.
        </p>
        <p><span>Note:</span> The selection of Doctor will depend if the selected doctor is available on the set appointment date and time</p>

        <form id='patient_bookAppointment' action="#" method="GET">
          <div class="w-full max-w-md">
            <label for="service-type" class="block text-lg font-medium mb-1">Reason</label>
            <textarea   name="reason" placeholder="Type here" required class="textarea-bordered textarea w-full p-2 bg-gray-300 dark:bg-gray-600"></textarea>
          </div>
        <fieldset class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">

          <!-- <legend class="text-xl font-bold mb-2 col-span-full">Service:</legend>

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
           -->



        <div class="w-full md:w-auto md:col-span-1">
          <label for="appointment-date" class="block text-base sm:text-lg font-medium">
            Appointment Date<span id='appointmentDateNote' class='text-sm text-info hidden'> (Please check doctor schedule)</span>
          </label>
          <input
            type="date"
            id="appointment-date"
            name="appointment-date"
            required
            class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]"
          />
        </div>
        <div class="w-full md:w-auto md:col-span-1">
          <label for="appointment-time" class="block text-base sm:text-lg font-medium">
            Appointment Time
          </label>
          <input
            type="time"
            id="appointment-time"
            name="appointment-time"
            required
            min="08:00"
            max="17:00"
            class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]"
          />
        </div>




          <!-- Dapat kung anong pinili sa service, automatic yun na yung doctor na kung sino man sa service na yon
          <div class="w-full md:w-auto md:col-span-1">
            <label for="doctor" class="block text-base sm:text-lg font-medium">
              Your Doctor will be:
            </label>
            <select
              id="doctor"
              name="doctor"
              required
              class="select select-bordered w-full p-2 text-base sm:text-lg bg-gray-300 dark:bg-gray-600"
            >
              <option value="" disabled selected>...</option>
              <option value="Dr. Smith">Dr. Smith</option>
              <option value="Dr. Johnson">Dr. Johnson</option>
              <option value="Dr. Williams">Dr. Williams</option>
            </select>
          </div> -->

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
                <div class="block text-base sm:text-lg font-medium mb-1">Are you vaccinated?</div>
                <div class="flex items-center space-x-4 p-2 bg-gray-300 dark:bg-gray-600 rounded">
                    <label class="flex items-center">
                        <input type="radio" name="vaccinated" value="Yes" class="radio radio-primary" required>
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="vaccinated" value="No" class="radio radio-primary" required>
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>
            <div>
                <label for="address" class="block text-base sm:text-lg font-medium">Address</label>
                <input type="text" id="address" name="address" autocomplete="off" placeholder="Address" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
            </div>
        </div>

          

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
            <input type='hidden' name='online_user_id' value='<?php echo $row[
                'user_info_ID'
            ]; ?>'>
            <input type='hidden' name='book_status' value='pending'>
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
              <span>Appointment failed please contact support</span>
            </div>
          </div>
        </dialog>
      </div>
    </section>
  </body>
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
    document.getElementById('patient_bookAppointment').addEventListener('submit', function(e){
      e.preventDefault();
      let form_data = new FormData(e.target);
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
            toggleDialog('bookFailed')
          }
          e.target.reset();
          console.log(response);
        }
      });
    });
<?php if (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'patient'):?>
    function getAccountUserInfo(){
      $.ajax({
        url: 'ajax.php?action=getOnlineUserInfo&onlineUser_id=' + encodeURIComponent('<?php echo $_SESSION['user_id']; ?>'),
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          if (data) {
            console.log(data);
            document.querySelector('#patient_bookAppointment input[name="first-name"]').value = data.First_Name;
            document.querySelector('#patient_bookAppointment input[name="middle-name"]').value = data.Middle_Name;
            document.querySelector('#patient_bookAppointment input[name="last-name"]').value = data.Last_Name;
            document.querySelector('#patient_bookAppointment input[name="email"]').value = data.Email;
            document.querySelector('#patient_bookAppointment input[name="contact-number"]').value = data.Contact_Number;
            document.querySelector('#patient_bookAppointment select[name="sex"]').value = data.Sex;
            document.querySelector('#patient_bookAppointment input[name="dob"]').value = data.DateofBirth;
            document.querySelector('#patient_bookAppointment input[name="address"]').value = data.Address;
          }
        },
        error: function(xhr, status, error) {
          console.error('Error fetching data:', error);
        }
      });
    }

    <?php endif;?>





    /*
    function getDoctorSchedule() {
      let schedule;
      $.ajax({
        url: 'ajax.php?action=getDoctorSched',
        method: 'GET',
        dataType: 'json',
        async: false,
        success: function(response) {
          schedule = response;
        },
        error: function(xhr, status, error) {
          console.error('Error fetching schedule:', error);
        }
      });
      return schedule;
    }

    let schedule = getDoctorSchedule();
    let dates = [];
    for (let date in schedule) {
      dates.push(date);
    }
    function setSelectableDates(datesArray) {
      let dateInput = document.getElementById('appointment-date');
      dateInput.setAttribute('type', 'date');
      let dateObjects = datesArray.map(date => new Date(date));
      let minDate = new Date(Math.min.apply(null, dateObjects));
      let maxDate = new Date(Math.max.apply(null, dateObjects));
      dateInput.setAttribute('min', minDate.toISOString().slice(0,10));
      dateInput.setAttribute('max', maxDate.toISOString().slice(0,10));
      dateInput.addEventListener('input', function() {
        let selectedDate = new Date(this.value);
        if (!dateObjects.find(date => date.toISOString().slice(0,10) === selectedDate.toISOString().slice(0,10))) {
          document.getElementById('appointmentDateNote').classList.remove('hidden');
          this.value = ''; // Reset value if not in datesArray
        }else {
          document.getElementById('appointmentDateNote').classList.add('hidden');
        }
      });
    }
    setSelectableDates(dates);
    */

  </script>
</html>
