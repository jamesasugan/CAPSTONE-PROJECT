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

    <?php $selectedService = isset($_GET['service'])
        ? $_GET['service']
        : null; ?>

    <section
      id="booking"
      class="book-appointment w-full flex justify-center items-center pt-24 pb-10 p-5
      bg-white dark:bg-[#17222a]"
    >
      <div
        class="book-form w-full max-w-7xl mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]"
      >
        <h2 class="text-2xl font-bold mb-2">Set an Appointment</h2>
        <p class="mb-4">
          Kindly answer the form to set a face-to-face appointment for
          consultation, test, or procedure in our clinic. <br>View <a href="doctorschedule.php" target="_blank" class="link text-blue-400 font-bold">Doctor's Schedule</a> for more information about the schedules.
        </p>
        <p><span>Note:</span> The selection of Doctor will depend if the selected doctor is available on the set appointment date and time</p>

        <form action="#" method="GET">
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
                  class="radio radio-info radio-btn " 
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
                  class="radio radio-info radio-btn" 
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
              <option value="" disabled <?php echo is_null($selectedService) ? 'selected' : ''; ?>>Select service type...</option>
              <?php
              $services = [
                  'OB-Gyne',
                  'Pregnancy Testing',
                  'Dengue Test',
                  'Covid-19 Rapid Testing',
                  'Family Medicine',
                  'Internal Medicine',
                  'Medical Consultation',
                  'Vaccination',
                  'BP Monitoring',
                  'Blood Glucose Determination',
                  'Nebulization',
                  'Complete Blood Count (CBC)',
                  'Fecalysis',
                  'Electrocardiogram (ECG)',
                  'X-RAY',
                  'Pre-Employment Package',
                  'Annual Physical Examination',
                  'FBS',
                  'Lipid Profile',
                  'AST/ALT',
                  'Uric Acid',
                  'Blood Typing',
                  'Electrolytes',
                  'FT4/TSH',
              ];
              foreach ($services as $service) {
                  echo "<option value=\"$service\" " .
                      ($selectedService === $service ? 'selected' : '') .
                      ">$service</option>";
              }
              ?>
          </select>


        </div>

        <div class="w-full md:w-auto md:col-span-1">
          <label for="appointment-date" class="block text-base sm:text-lg font-medium">
            Appointment Date
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




          <!-- Dapat kung anong pinili sa service, automatic yun na yung doctor na kung sino man sa service na yon -->
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
          </div>
        </fieldset>



          <h3 class="text-xl font-bold mt-5 mb-2">Personal Information</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="first-name" class="block text-base sm:text-lg font-medium"
                >First Name</label
              >
              <input
                type="text"
                id="first-name"
                name="first-name"
                autocomplete="off"
                placeholder="First Name"
                required
                class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600"
              />
            </div>
            <div>
              <label for="middle-name" class="block text-base sm:text-lg font-medium"
                >Middle Name</label
              >
              <input
                type="text"
                id="middle-name"
                name="middle-name"
                placeholder="Middle Name"
                required
                class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600"
              />
            </div>
            <div>
              <label for="last-name" class="block text-base sm:text-lg font-medium"
                >Last Name</label
              >
              <input
                type="text"
                id="last-name"
                name="last-name"
                placeholder="Last Name"
                required
                class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600"
              />
            </div>
            <div>
              <label for="contact-number" class="block text-base sm:text-lg font-medium"
                >Contact Number</label
              >
              <input
                id="contact-number"
                name="contact-number"
                type="tel"
                required
                autocomplete="off"
                placeholder="Contact Number"
                pattern="[0-9]{1,11}"
                minlength="11"
                maxlength="11"
                title="Please enter up to 11 numeric characters."
                class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600"
              />
            </div>

            <!-- New fields for Vaccination Status -->
            <div>
            <div class="block text-base sm:text-lg font-medium mb-1">Are you vaccinated?</div>
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
                <label for="vaccine-type" class="block text-base sm:text-lg font-medium">If yes,</label>
                <select
                    id="vaccine-type"
                    name="vaccine-type"
                    class="select select-bordered w-full p-2 text-base sm:text-lg bg-gray-300 dark:bg-gray-600"
                    disabled
                >
                    <option value="" disabled selected>Select vaccine stage...</option>
                    <option value="1st dose">1st Dose</option>
                    <option value="2nd dose">2nd Dose</option>
                    <option value="Booster">Booster</option>
                </select>
            </div>
          </div>

          <div class="mb-4">
            <label for="address" class="block text-base sm:text-lg font-medium"
              >Address</label
            >
            <input
              type="text"
              id="address"
              name="address"
              autocomplete="off"
              placeholder="Address"
              required
              class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600"
            />
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="dob" class="block text-base sm:text-lg font-medium"
                >Date of Birth</label
              >
              <input
                type="date"
                id="dob"
                name="dob"
                required
                class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 [color-scheme:light] dark:[color-scheme:dark]"
              />
            </div>
            <div>
              <label for="sex" class="block text-base sm:text-lg font-medium">Sex</label>
              <select
                id="sex"
                required
                class="select select-bordered w-full p-2 bg-gray-300 dark:bg-gray-600  text-lg"
                name="sex"
              >
                <option value="" disabled selected>Select...</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="email" class="block text-base sm:text-lg font-medium">Email</label>
              <input
                type="email"
                id="email"
                name="email"
                autocomplete="email"
                placeholder="Email"
                required
                class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600"
              />
            </div>
          </div>

          <h3 class="text-xl font-bold mb-2">Data Privacy Note</h3>
          <p class="mb-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
          <label class="flex items-center mb-4 ">
            <input
              type="checkbox"
              required
              class="form-checkbox h-5 w-5 rounded-none checkbox checkbox-success"
              name="privacy"
            />
            <span class="ml-2">I understand</span>
          </label>

          <div class="flex justify-center mt-4 mb-2">
            <input
              type="submit"
              value="Submit"
              class="bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded w-1/2 cursor-pointer"
            />
          </div>

        </form>

        <!-- pashow nito pagnasubmit -->
        <div class="flex justify-center">
            <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Appointment has been booked! Please wait for confirmation message.</span>
            </div>
        </div>

      </div>
    </section>
  </body>
</html>
