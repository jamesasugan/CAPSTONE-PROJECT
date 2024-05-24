<?php
include '../Database/database_conn.php';
session_start();



if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'patient'){
    header("Location: index.php");

}
$user_id = $_SESSION['user_id'];
$sql = "SELECT role from tbl_staff where User_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['role'] == 'doctor'){
        header("Location: staff-index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Doctor</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/staff.css" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
    <script src="../js/admin-addnewDoctor.js" defer></script>
</head>
<body>

    <?php include 'admin-navbar.php'; ?>
    
    <section
      id="addDoctor"
      class="w-full min-h-screen flex justify-center items-center pt-28 pb-10 p-5
      bg-[#f6fafc] dark:bg-[#17222a]"
    >
      <div
        class="w-full max-w-7xl mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]"
      >
        <h2 class="text-3xl font-bold mb-2">Add a new Staff Member</h2>

        <form id='staffAccount' action="#" method="GET">
          <h3 class="text-2xl font-bold mt-5 mb-2">Role</h3> 
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <input type='hidden' name='type' value='staff'>
            <div>
                <label for="staffType" class="block text-base sm:text-lg font-medium">User Type</label>
                <select id="staffType" required class="select
                select-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 text-lg" name="role">
                <option value="" disabled selected>Select...</option>
                <option value="admin">Admin</option>
                <option value="doctor">Doctor</option>
                </select>
            </div>          

            <div id="specialtyDiv">
                <label for="specialty" class="block text-base sm:text-lg font-medium">Specialty</label>
                <select id="specialty"
                        required class="select select-bordered w-full p-2 bg-gray-300 dark:bg-gray-600 text-lg"
                        name="specialty">
                <option value="" disabled selected>Select...</option>
                <option value="Internal Medicine">Internal Medicine</option>
                <option value="OB-GYNE">OB-GYNE</option>
                <option value="Family Medicine">Family Medicine</option>
                <option value="Pediatrics">Pediatrics</option>
                <option value="General Medicine">General Medicine</option>
                <option value="Surgery">Surgery</option>
                </select>
            </div>
            </div>


          <h3 class="text-2xl font-bold mt-10 mb-2">Personal Information</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="first-name" class="block text-base sm:text-lg font-medium">First Name</label>
                <input type="text" id="first-name" name="first_name" autocomplete="off" placeholder="First Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
            </div>
            <div>
                <label for="middle-name" class="block text-base sm:text-lg font-medium">Middle Name</label>
                <input type="text" id="middle-name" name="middle_name" placeholder="Middle Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
            </div>

            <div>
                <label for="last-name" class="block text-base sm:text-lg font-medium">Last Name</label>
                <input type="text" id="last-name" name="last_name" placeholder="Last Name" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
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
                <input id="contact-number" name="contact_number" type="tel" required autocomplete="off" placeholder="Contact Number" pattern="[0-9]{1,11}" minlength="11" maxlength="11" title="Please enter up to 11 numeric characters." class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
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
                <label for="address" class="block text-base sm:text-lg font-medium">Address</label>
                <input type="text" id="address" name="address" autocomplete="off" placeholder="Address" required class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600" />
            </div>
        </div>

        <h3 class="text-2xl font-bold mt-5 mb-2">Password</h3> 
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="form-group">
                    <label
                      for="password"
                      class="block font-medium text-black dark:text-white"
                      >Password</label
                    >
                    <div>
                      <input
                        name='password'
                        id="password"
                        type="password"
                        required
                        value="Passwordko1"
                        autocomplete="off"
                        placeholder="Password"
                        class="input input-bordered w-full p-2 bg-gray-300 dark:bg-gray-600"
                      />
                    </div>
                  </div>
           </div>

          <div class="flex justify-center mt-4 mb-2">
            <input
              type="submit"
              value="Submit"
              class="bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold py-2 px-4 rounded w-1/2 cursor-pointer"
            />
          </div>

        </form>

        <!-- pashow nito pagnasubmit -->
        <div id='notif' class="flex justify-center hidden">
            <div role="alert" class="inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Account Created!</span>
            </div>
        </div>

      </div>
    </section>
    <script>

      function toggle_successNotif(){
        let notification = document.getElementById('notif');
        if (notification.classList.contains('hidden')) {
          notification.classList.remove('hidden');
        } else {
          notification.classList.add('hidden');
        }
      }

      document.getElementById('staffAccount').addEventListener('submit', function(e){
        e.preventDefault();

        let form_data = new FormData(e.target)
        $.ajax({
          url: 'ajax.php?action=signup',
          type: 'POST',
          data: form_data,
          processData: false,
          contentType: false,
          success: function(response) {
            if (parseInt(response) === 1) {
              toggle_successNotif();
              e.target.reset();
              setTimeout(function() {
                toggle_successNotif();
              }, 3000);
            }


            console.log(response);

          },
        })
      })

    </script>
</body>
</html>