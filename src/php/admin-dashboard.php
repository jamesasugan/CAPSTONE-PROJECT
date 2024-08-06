<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::ADMIN, AccountType::STAFF]))
{
  return;
}

$first_name = '';
$last_name = '';
$user_query = query_user_info(true);
if ($user_query)
{
  $first_name = $user_query['First_Name'];
  $last_name = $user_query['Last_Name'];
}

include 'ReuseFunction.php'
?>


<div class="dashboard-page pt-32 sm:pt-60 min-h-screen">
  <div class="title mb-0 sm:mb-10 w-full px-4">
    <h1 class="text-3xl sm:text-6xl font-bold text-center break-words mb-5">
      Welcome,
      <span> <?php echo $first_name .' '. $last_name?></span>
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
            <span class="font-bold text-6xl sm:text-7xl mt-2 overflow-hidden whitespace-nowrap text-overflow-ellipsis"><?php echo getPendingAppointment()?></span> <!-- pending appointment numbers -->
          </div>
        </div>
      </div>
      <div class="card-actions justify-center mt-auto">
        <a
          href="admin-appointments.php?filter=Pending"
          class="btn text-base sm:text-lg rounded-none w-full bg-[#78afe2] dark:bg-[#1C3F61] uppercase text-[#0e1011] dark:text-[#eef0f1] hover:bg-[#224362] hover:text-[#eef0f1] dark:hover:bg-[#9dbedd] dark:hover:text-[#0e1011] border-[#35485a] dark:border-[#8c9caa] overflow-hidden whitespace-nowrap text-overflow-ellipsis"
        >
          Pending Appointments
        </a>
      </div>
    </div>
    <div
      class="flex flex-col w-full sm:w-96 shadow-xl bg-[#cadcec] dark:bg-[#0F1E2B] border border-[#35485a] dark:border-[#8c9caa]"
    >
      <div class="flex-grow">
        <div class="card-body">
          <div class="icon flex justify-center">
            <span class="font-bold text-6xl sm:text-7xl mt-2 overflow-hidden whitespace-nowrap text-overflow-ellipsis"><?php echo getTotalPatientChart()?></span>  <!-- total record numbers -->
          </div>
        </div>
      </div>
      <div class="card-actions justify-center mt-auto">
        <a
          href="admin-patientRecords.php"
          class="btn text-base sm:text-lg rounded-none w-full bg-[#78afe2] dark:bg-[#1C3F61] uppercase text-[#0e1011] dark:text-[#eef0f1] hover:bg-[#224362] hover:text-[#eef0f1] dark:hover:bg-[#9dbedd] dark:hover:text-[#0e1011] border-[#35485a] dark:border-[#8c9caa] overflow-hidden whitespace-nowrap text-overflow-ellipsis"
        >
          Total Records
        </a>
      </div>
    </div>
    <div
      class="flex flex-col w-full sm:w-96 shadow-xl bg-[#cadcec] dark:bg-[#0F1E2B] border border-[#35485a] dark:border-[#8c9caa]"
    >
      <div class="flex-grow">
        <div class="card-body">
          <div class="icon flex justify-center">
            <i class="fa-solid fa-hospital-user text-6xl sm:text-8xl"></i>
          </div>
        </div>
      </div>
      <div class="card-actions justify-center mt-auto">
        <a
          href="addwalkInPatient.php"
          class="btn text-base sm:text-lg rounded-none w-full bg-[#78afe2] dark:bg-[#1C3F61] uppercase text-[#0e1011] dark:text-[#eef0f1] hover:bg-[#224362] hover:text-[#eef0f1] dark:hover:bg-[#9dbedd] dark:hover:text-[#0e1011] border-[#35485a] dark:border-[#8c9caa] overflow-hidden whitespace-nowrap text-overflow-ellipsis"
        >
          Add new Patient
        </a>
      </div>
    </div>
  </div>
</div>


 