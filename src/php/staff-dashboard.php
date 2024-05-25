
<?php
$first_name = '';
$last_name = '';
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'staff'){
    $sql = "SELECT * FROM tbl_staff WHERE User_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $first_name = $row['First_Name'];
        $last_name = $row['Last_Name'];
    }
}else{
    header("Location: index.php");
}
include "ReuseFunction.php";
?>


<div class="dashboard-page pt-32 sm:pt-60 ">
  <div class="title mb-0 sm:mb-10 w-full px-4">
    <h1 class="text-3xl sm:text-6xl font-bold text-center break-words mb-5">
      Welcome, Dr.
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
          href="staff-appointments.php?filter=Pending"
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
          href="staff-patientsRecord.php"
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
              <span class="font-bold text-6xl sm:text-7xl mt-2 overflow-hidden whitespace-nowrap text-overflow-ellipsis"><?php echo tobeSeenPatient()?></span>  <!-- total records ng naka "To be Seen" na status -->
          </div>
        </div>
      </div>
      <div class="card-actions justify-center mt-auto">
        <a
          href="staff-patientsRecord.php?filter=To be Seen"
          class="btn text-base sm:text-lg rounded-none w-full bg-[#78afe2] dark:bg-[#1C3F61] uppercase text-[#0e1011] dark:text-[#eef0f1] hover:bg-[#224362] hover:text-[#eef0f1] dark:hover:bg-[#9dbedd] dark:hover:text-[#0e1011] border-[#35485a] dark:border-[#8c9caa] overflow-hidden whitespace-nowrap text-overflow-ellipsis"
        >
          To be Seen Patients
        </a>
      </div>
    </div>
  </div>
</div>