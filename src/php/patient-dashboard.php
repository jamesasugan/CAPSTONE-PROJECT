<?php
$first_name = '';
$last_name = '';
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'patient'){
    $sql = "SELECT * FROM account_user_info WHERE User_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $first_name = $row['First_Name'];
        $last_name = $row['Last_Name'];
    }
}
?>


<div class="dashboard-page pt-32 sm:pt-60">
  <div class="title mb-0 sm:mb-10 w-full px-4">
    <h1 class="text-3xl sm:text-6xl font-bold text-center break-words mb-5">
      Welcome,
      <span><?php echo isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'patient' ? $first_name.' '. $last_name : '' ?>. </span>
    </h1>
  </div>

  <div
    class="cards-main h-60 flex flex-wrap lg:flex-nowrap justify-center gap-4 p-4 text-[#0e1011] dark:text-[#eef0f1]"
  >
    <div
      class="flex flex-col w-full sm:w-96 shadow-xl bg-[#cadcec] dark:bg-[#0F1E2B] border border-[#35485a] dark:border-[#8c9caa]"
    >
      <div class="flex-grow">
        <div class="card-body">
          <div class="icon flex justify-center">
            <i class="fa-solid fa-calendar-days text-8xl"></i>
          </div>
        </div>
      </div>
      <div class="card-actions justify-center mt-auto">
        <a
          href="patient-profile.php#appointmentHistory"
          class="btn text-base sm:text-lg rounded-none w-full bg-[#78afe2] dark:bg-[#1C3F61] uppercase text-[#0e1011] dark:text-[#eef0f1] hover:bg-[#224362] hover:text-[#eef0f1] dark:hover:bg-[#9dbedd] dark:hover:text-[#0e1011] border-[#35485a] dark:border-[#8c9caa]"
        >
          View Current Appointment
        </a>
      </div>
    </div>
    <div
      class="flex flex-col w-full sm:w-96 shadow-xl bg-[#cadcec] dark:bg-[#0F1E2B] border border-[#35485a] dark:border-[#8c9caa]"
    >
      <div class="flex-grow">
        <div class="card-body">
          <div class="icon flex justify-center">
            <i class="fa-solid fa-plus text-8xl"></i>
          </div>
        </div>
      </div>
      <div class="card-actions justify-center mt-auto">
        <a
          href="bookappointment.php"
          class="btn text-base sm:text-lg rounded-none w-full bg-[#78afe2] dark:bg-[#1C3F61] uppercase text-[#0e1011] dark:text-[#eef0f1] hover:bg-[#224362] hover:text-[#eef0f1] dark:hover:bg-[#9dbedd] dark:hover:text-[#0e1011] border-[#35485a] dark:border-[#8c9caa]"
        >
          Book an Appointment
        </a>
      </div>
    </div>
    <div
      class="flex flex-col w-full sm:w-96 shadow-xl bg-[#cadcec] dark:bg-[#0F1E2B] border border-[#35485a] dark:border-[#8c9caa]"
    >
      <div class="flex-grow">
        <div class="card-body">
          <div class="icon flex justify-center">
            <i class="fa-solid fa-gear text-8xl"></i>
          </div>
        </div>
      </div>
      <div class="card-actions justify-center mt-auto">
        <a
          href="../php/patient-profile.php"
          class="btn text-base sm:text-lg rounded-none w-full bg-[#78afe2] dark:bg-[#1C3F61] uppercase text-[#0e1011] dark:text-[#eef0f1] hover:bg-[#224362] hover:text-[#eef0f1] dark:hover:bg-[#9dbedd] dark:hover:text-[#0e1011] border-[#35485a] dark:border-[#8c9caa]"
        >
          Account Settings
        </a>
      </div>
    </div>
  </div>
</div>
