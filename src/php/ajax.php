<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    header("Location: 404.php");
    exit();
}





include '../Database/database_conn.php';
session_start();


include "ReuseFunction.php";


$action = $_GET['action'];
extract($_POST);
if ($action == 'signup'){

    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $middle_name = filter_input(INPUT_POST, 'middle_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $contact_number = filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_NUMBER_INT);
    $date_of_birth = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $user_type =  filter_input(INPUT_POST, 'type', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $conf_password = filter_input(INPUT_POST, 'conf_password', FILTER_SANITIZE_STRING);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $check_email_sql = "SELECT Email FROM tbl_accounts WHERE Email = ?";
    $stmt_check_email = $conn->prepare($check_email_sql);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();
    if ($stmt_check_email->num_rows > 0) {

        echo "Email already exist";
        exit();
    }

    if (isset($first_name) || isset($last_name) || isset($contact_number) || isset($date_of_birth) || isset($sex) || isset($address) || isset($email) ) {
        $user_type = isset($_POST['type']) && in_array($_POST['type'], ['patient', 'staff']) ? $_POST['type'] : '';
        if ($user_type === '') {
            echo $user_type;
            echo 'User type missing';
            exit();
        }



        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_accounts = "INSERT INTO tbl_accounts (Email, Password, userType) VALUES (?, ?, ?)";
        $stmt_accounts = $conn->prepare($sql_accounts);
        $stmt_accounts->bind_param("sss", $email, $hashed_password, $user_type);
        $stmt_accounts->execute();
        $user_id = $conn->insert_id;
        // send email

        if ($user_type == 'patient'){
            $sql_patient = "INSERT INTO account_user_info (User_ID, First_Name, Middle_Name, Last_Name, DateofBirth, Sex, Contact_Number, Address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_patient = $conn->prepare($sql_patient);
            $stmt_patient->bind_param("isssssss", $user_id, $first_name, $middle_name, $last_name, $date_of_birth, $sex, $contact_number, $address);
            $stmt_patient->execute();

        }else{
            $role = isset($_POST['role']) ? $_POST['role']: '';
            $sql_staff = "INSERT INTO tbl_staff (User_ID, First_Name, 
                       Middle_Name, Last_Name, DateofBirth, Contact_Number,
                       Sex, Address, Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_staff = $conn->prepare($sql_staff);
            $stmt_staff->bind_param("issssssss", $user_id,
                $first_name, $middle_name, $last_name,
                $date_of_birth,  $contact_number, $sex, $address, $role);
            $stmt_staff->execute();


            if (isset($_POST['specialty'])){
                $staff_id =$conn->insert_id;

                $speciality = $_POST['specialty'];
                $specialityQ = "UPDATE tbl_staff SET speciality = ? WHERE Staff_id = ?";
                $speciality_stmt = $conn->prepare($specialityQ);
                $speciality_stmt->bind_param('si',$speciality,$staff_id );
                $speciality_stmt->execute();
            }

        }
        echo 1;
        exit();

    } else {
        echo 2; // may variables null
        exit();
    }
}


if ($action == "login"){

    $login_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $login_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM tbl_accounts WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($login_password, $row['Password'])) {
            $_SESSION['user_id'] = $row['User_ID'];
            $_SESSION['user_type'] = $row['userType'];
            $_SESSION['userEmail'] = $row['Email'];
            echo 1;
        } else {
            echo 2;//invalid pass
        }
    } else {
        echo 3; // invalid email
    }

}


if ($action == 'getDoctorSched'){
    $doctor_id = isset( $_SESSION['user_id']) ?  $_SESSION['user_id'] : '';
    $user_type = isset( $_SESSION['user_type'])  &&  $_SESSION['user_type'] == 'staff' ?  $_SESSION['user_type'] : '';
    $role = '';
    $staffUID = '';
    if ($doctor_id !== '' && $user_type !== ''){
        $get_user_role_sql = "SELECT * FROM tbl_staff where User_ID = ?";
        $get_rol = $conn->prepare($get_user_role_sql);
        $get_rol->bind_param('i', $doctor_id);
        $get_rol->execute();
        $res = $get_rol->get_result();
        if ($res->num_rows === 1){
            $row = $res->fetch_assoc();
            $role = $row['Role'];
            $staffUID =  $row['Staff_ID'];
        }
    }
    if ($role!== '' && $role == 'doctor'){
        $sql = "SELECT Date, tbl_staff.speciality, tbl_staff.First_Name AS DoctorFirstName, tbl_staff.Last_Name AS DoctorLastName, StartTime, EndTime
        FROM tbl_availability
        INNER JOIN tbl_staff ON tbl_availability.Staff_ID = tbl_staff.Staff_ID where tbl_availability.Staff_ID = $staffUID
        ORDER BY Date, StartTime";
    }else{
        $sql = "SELECT Date, tbl_staff.speciality, tbl_staff.First_Name AS DoctorFirstName, tbl_staff.Last_Name AS DoctorLastName, StartTime, EndTime
        FROM tbl_availability
        INNER JOIN tbl_staff ON tbl_availability.Staff_ID = tbl_staff.Staff_ID
        ORDER BY Date, StartTime";
    }

    $result = $conn->query($sql);
    $schedules = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = $row['Date'];
            if (date("Y-m-d") <= $date){
                $department = $row['speciality'];
                $doctor = "Dr. " . $row['DoctorLastName'];
                $times = date('h:i A', strtotime($row['StartTime'])) . " to " . date('h:i A', strtotime($row['EndTime']));

                $schedule_item = array(
                    'department' => $department,
                    'doctor' => $doctor,
                    'times' => $times
                );

                if (!isset($schedules[$date])) {
                    $schedules[$date] = array();
                }
                $schedules[$date][] = $schedule_item;
            }
        }

    }
    $conn->close();
    $schedules_json = json_encode($schedules);
    header('Content-Type: application/json');
    echo $schedules_json;
}
if ($action == 'DoctorSchedule'){//staff side add sched
    $staff_id = isset($_POST['DoctorID']) ? $_POST['DoctorID'] : '';
    $monday = isset($_POST['monday']) ? 'Monday':'';
    $tuesday = isset($_POST['tuesday']) ? 'Tuesday':'';
    $wednesday = isset($_POST['wednesday']) ? 'Wednesday':'';
    $thursday = isset($_POST['thursday']) ? 'Thursday':'';
    $friday = isset($_POST['friday']) ? 'Friday':'';
    $saturday = isset($_POST['saturday']) ? 'Saturday':'';
    $availability_time_In = $_POST['availability-timeIn'] ?? '';
    $availability_time_end = $_POST['availability-timeEnd'] ?? '';
    $startSched = $_POST['repeatStart'] ?? '';
    $endSched = $_POST['repeatEnd'] ?? '';

    $weekdaysArray = array_filter([$monday, $tuesday, $wednesday, $thursday, $friday, $saturday]);
    $weekdays = implode(',', $weekdaysArray);
    if ($startSched !== '' && $endSched !== '' && isValidDate($startSched) && isValidDate($endSched)) {
        $newSched = "INSERT INTO tbl_schedule (Staff_ID,	weekDays,	startTime,	endTime,	startDate,	endDate)
    values (?,?,?,?,?,?)";
        $newSchedSTMT = $conn->prepare($newSched);
        $newSchedSTMT->bind_param('isssss', $staff_id, $weekdays, $availability_time_In, $availability_time_end, $startSched, $endSched);
        if ($newSchedSTMT->execute()){
            echo 1;
        }else {
            echo $newSchedSTMT->error;
        }
        $newSchedSTMT->close();
        exit();

    }
}

if ($action == 'DoctorSchedRec') {
    $login_user = $_SESSION['user_id'];
    $getstaffID = "SELECT * FROM tbl_staff WHERE User_ID = ?";
    $getstaffIDSTMT = $conn->prepare($getstaffID);
    $getstaffIDSTMT->bind_param("i", $login_user);
    $getstaffIDSTMT->execute();
    $result = $getstaffIDSTMT->get_result();
    if ($result->num_rows === 1) {
        $staff = $result->fetch_assoc();
        $staff_id = $staff['Staff_ID'];
        $staffRole = $staff['Role'];


        if ($staffRole == 'doctor') {
            $getDocReq = "SELECT * FROM tbl_schedule WHERE Staff_ID = ? and status = 'Pending'";
            $getDocReqSTMT = $conn->prepare($getDocReq);
            $getDocReqSTMT->bind_param('i', $staff_id);
            $getDocReqSTMT->execute();
        } elseif ($staffRole == 'admin') {
            $getDocReq = "SELECT  * FROM tbl_schedule JOIN tbl_staff on tbl_staff.Staff_ID = tbl_schedule.Staff_ID  WHERE status = 'Pending'";
            $getDocReqSTMT = $conn->prepare($getDocReq);
            $getDocReqSTMT->execute();
        }else{
            exit();
        }

        $result = $getDocReqSTMT->get_result();
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $formattedStartTime = date("h:i A", strtotime($row['startTime']));
                $formattedEndTime = date("h:i A", strtotime($row['endTime']));
                $formattedStartDate = date("F j, Y", strtotime($row['startDate']));
                $formattedEndDate = date("F j, Y", strtotime($row['endDate']));
                $status_class = '';

                if ($row['status'] == 'Approved') {
                    $status_class = 'text-green-500';
                } elseif ($row['status'] == 'Pending') {
                    $status_class = 'text-yellow-500';
                } else {
                    $status_class = 'text-red-500';
                }
                if ($staffRole == 'admin'){
                    if (!empty($row['Middle_Name'])) {
                        $doctorName = 'Dr. ' . $row['First_Name'] . ' ' . substr($row['Middle_Name'], 0, 1) . '. ' . $row['Last_Name'];
                    } else {
                        $doctorName = 'Dr. ' . $row['First_Name'] . ' ' . $row['Last_Name'];
                    }
                    echo '<tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                        
                          <td class="w-1/4">'.$doctorName.'</td>
                        <td class="w-1/4">' . $row['weekDays'] . '</td>
                        <td class="w-1/4">' . $formattedStartTime . ' to ' . $formattedEndTime . '</td>
                        <td class="w-1/4">' . $formattedStartDate . ' to ' . $formattedEndDate . '</td>
                        <td class="w-1/4">
                          <div class="flex justify-between">
                             <button class="bg-blue-500 p-2 rounded-md mr-5 text-white font-medium" onclick="ApproveSchedReq(' . $row['sched_ID'] . ',  ' . $row['Staff_ID'] . ')">Accept</button>
                             <button class="bg-red-500 p-2 rounded-md text-white font-medium" onclick="declineSchedReq(' . $row['sched_ID'] . ')">Decline</button>

                          </div>
                        </td>
                    </tr>';
                }else if ($staffRole == 'doctor'){
                    echo '<tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                        <td class="w-1/4">' . $row['weekDays'] . '</td>
                        <td class="w-1/4">' . $formattedStartTime . ' to ' . $formattedEndTime . '</td>
                        <td class="w-1/4">' . $formattedStartDate . ' to ' . $formattedEndDate . '</td>
                        <td class="font-bold ' . $status_class . '">' . $row['status'] . '</td>
                    </tr>';
                }
            }
        } else {
            echo ' <h1 class="text-center">No Pending Request</h1>';

        }
    } else {
        exit();
    }
}

if ($action == 'schedReqdecline'){
    $sched_id = $_GET['data_id'];
    $updateSched = "UPDATE tbl_schedule SET status = 'Declined' where sched_ID = ?";
    $updateSchedSTMT = $conn->prepare($updateSched);
    $updateSchedSTMT->bind_param('i', $sched_id);
    if($updateSchedSTMT->execute()){
        echo 1;
    }
}
if ($action == 'approveSchedReq'){
    $sched_id = $_GET['sched_id'];
    $staff_id = $_GET['staff_id'];
    $getDoctorSchedReq = "SELECT * FROM tbl_schedule where sched_ID = ? ";
    $getDoctorSchedReqSTMT = $conn->prepare($getDoctorSchedReq);
    $getDoctorSchedReqSTMT->bind_param('i',$sched_id);
    if ($getDoctorSchedReqSTMT->execute()){
        $result = $getDoctorSchedReqSTMT->get_result();
        if ($result ->num_rows === 1){
            $selectedDays = [];
            $schedule = $result->fetch_assoc();
            $weekDayString = $schedule['weekDays'];
            $startTime = $schedule['startTime'];
            $endTime = $schedule['endTime'];
            $startSched = $schedule['startDate'];
            $endSched = $schedule['endDate'];
            $weekDaysArray = explode(',', $weekDayString);
            foreach ($weekDaysArray as $day) {
                switch ($day) {
                    case 'Monday':
                        $selectedDays[] = 1;
                        break;
                    case 'Tuesday':
                        $selectedDays[] = 2;
                        break;
                    case 'Wednesday':
                        $selectedDays[] = 3;
                        break;
                    case 'Thursday':
                        $selectedDays[] = 4;
                        break;
                    case 'Friday':
                        $selectedDays[] = 5;
                        break;
                    case 'Saturday':
                        $selectedDays[] = 6;
                        break;
                }

            }
            if (isValidDate($startSched) && isValidDate($endSched)){
                if (UpdateDoctorAvailabiity($selectedDays, $startTime, $endTime, $startSched, $endSched, $staff_id) == 1){
                    $updateSched = "UPDATE tbl_schedule SET status = 'Approved' where sched_ID = ?";
                    $updateSchedSTMT = $conn->prepare($updateSched);
                    $updateSchedSTMT->bind_param('i', $sched_id);
                    if($updateSchedSTMT->execute()){
                        echo 1;
                    }
                }
            }
        }
    }
}


if ($action == 'AdminAddDoctorAvailability') {//admin side add sched no need approval, no record on doctor schedule request
    $staff_id = isset($_POST['DoctorID']) ? $_POST['DoctorID'] : '';
    $monday = isset($_POST['monday']) ? 'Monday':'';
    $tuesday = isset($_POST['tuesday']) ? 'Tuesday':'';
    $wednesday = isset($_POST['wednesday']) ? 'Wednesday':'';
    $thursday = isset($_POST['thursday']) ? 'Thursday':'';
    $friday = isset($_POST['friday']) ? 'Friday':'';
    $saturday = isset($_POST['saturday']) ? 'Saturday':'';
    $availability_time_In = $_POST['availability-timeIn'] ?? '';
    $availability_time_end = $_POST['availability-timeEnd'] ?? '';
    $startSched = $_POST['repeatStart'] ?? '';
    $endSched = $_POST['repeatEnd'] ?? '';

    $selectedDays = [];
    if ($monday) $selectedDays[] = 1; // Monday
    if ($tuesday) $selectedDays[] = 2; // Tuesday
    if ($wednesday) $selectedDays[] = 3; // Wednesday
    if ($thursday) $selectedDays[] = 4; // Thursday
    if ($friday) $selectedDays[] = 5; // Friday
    if ($saturday) $selectedDays[] = 6; // Saturday

    if ($startSched !== '' && $endSched !== '' && isValidDate($startSched) && isValidDate($endSched)) {
        echo UpdateDoctorAvailabiity($selectedDays, $availability_time_In, $availability_time_end, $startSched, $endSched, $staff_id);
        exit();
    } else{
        echo 'Some error occurred';
    }
}




if ($action == 'getDoctorAvailabilityDate'){
    $doctor_id = $_GET['doctor_ID'];
    $getDoctorAvailability = "SELECT Date FROM tbl_availability WHERE Staff_ID = ?";
    $getAvailabilitySTMT = $conn->prepare($getDoctorAvailability);
    $getAvailabilitySTMT->bind_param('i', $doctor_id);
    $getAvailabilitySTMT->execute();
    $result = $getAvailabilitySTMT->get_result();
    header('Content-Type: application/json');

    if ($result->num_rows > 0){
        $dates = array();
        while($row = $result->fetch_assoc()){
            $dates[] = $row['Date'];
        }
        echo json_encode($dates);
    } else {
        echo json_encode(['message' => 'No schedule']);
    }
}

if ($action == 'getServices'){


}

if ($action == 'getDoctorAvailabilityTime'){
    $doctor_id = $_GET['doctor_id'];
    $schedDate = $_GET['schedDate'];

    $schedDaySlot = array();
    $getDoctorSchedDate = "SELECT * FROM tbl_availability WHERE Date = ? AND Staff_ID = ?";
    $getDoctorSchedDateSTMT = $conn->prepare($getDoctorSchedDate);
    $getDoctorSchedDateSTMT->bind_param('si', $schedDate, $doctor_id);
    $getDoctorSchedDateSTMT->execute();
    $getDateRes = $getDoctorSchedDateSTMT->get_result();

    if ($getDateRes->num_rows > 0) {
        $row = $getDateRes->fetch_assoc();
        $startTime = strtotime($row['StartTime']);
        $endTime = strtotime($row['EndTime']);

        while ($startTime < $endTime) {
            $endTimeInterval = min($endTime, $startTime + 1800);
            $originalStartTime = date("H:i:s", $startTime);
            $originalEndTime = date("H:i:s", $endTimeInterval);
            $displayStartTime = date("h:i A", $startTime);
            $displayEndTime = date("h:i A", $endTimeInterval);

            $timeSlot = "$displayStartTime - $displayEndTime";

            if ($originalStartTime !== $originalEndTime) {
                $schedDaySlot[$originalStartTime] = $timeSlot;
            }

            $startTime += 1800;
        }
    }
    $getDoctorAppointment = "SELECT Appointment_schedule FROM tbl_appointment WHERE Staff_ID = ? AND Appointment_schedule LIKE ?";
    $getDoctorAppointmentStmt = $conn->prepare($getDoctorAppointment);
    if (!$getDoctorAppointmentStmt) {
        exit("Failed to prepare statement: " . $conn->error);
    }
    $schedDate = '%' . $schedDate . '%';
    $getDoctorAppointmentStmt->bind_param('is', $doctor_id, $schedDate);
    $getDoctorAppointmentStmt->execute();
    $result = $getDoctorAppointmentStmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $appointment_schedule = $row['Appointment_schedule'];
            $time_only = (new DateTime($appointment_schedule))->format('H:i:s');
            if (array_key_exists($time_only, $schedDaySlot)) {
                unset($schedDaySlot[$time_only]);
            }

        }
    }

    $getchartSched = "SELECT * FROM tbl_patient_chart where Consultant_id = ? and followUp_schedule  LIKE ? ";
    $getchartSchedSTMT  = $conn->prepare($getchartSched);
    $getchartSchedSTMT->bind_param('is',$doctor_id, $schedDate);
    $getchartSchedSTMT->execute();
    $chartSchedRes = $getchartSchedSTMT->get_result();
    if ($chartSchedRes->num_rows > 0){
        $followUpSched = $row['followUp_schedule'];
        $followUpSchedtimeOnly = (new DateTime($followUpSched))->format('H:i:s');
        if (array_key_exists($followUpSchedtimeOnly,$schedDaySlot)) {
            unset($schedDaySlot[$followUpSchedtimeOnly]);
        }
    }
    foreach ($schedDaySlot as $time => $timeSlot) {
        echo "<option value='$time'>$timeSlot</option>";
    }
}




if ($action == 'deleteSched'){
    $login_user = $_SESSION['user_id'];

    // Get staff information
    $getstaffID = "SELECT * FROM tbl_staff WHERE User_ID = ?";
    $getstaffIDSTMT = $conn->prepare($getstaffID);
    $getstaffIDSTMT->bind_param("i", $login_user);
    $getstaffIDSTMT->execute();
    $result = $getstaffIDSTMT->get_result();
    if ($result->num_rows === 1) {
        $staff = $result->fetch_assoc();
        $staff_id = $staff['Staff_ID'];
        $staffRole = $staff['Role'];
    } else {
        exit();
    }

    $passWord_conf = $_POST['conf_password'];

    // Verify password
    $sql = "SELECT * FROM tbl_accounts WHERE User_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($passWord_conf, $row['Password'])) {
            $delDoc_id = $_POST['dltDoctorSched'];
            if (isset($_POST['list-radio']) && $_POST['list-radio'] == 'deleteAll') {
                if ($staffRole == 'admin'){
                    DeleteAllDoctorAvailability($delDoc_id);
                } elseif ($staffRole == 'doctor'){
                    $doctorDelSched = "INSERT INTO tbl_delschedactivity (delType, Staff_ID) VALUES ('deleteAll', ?)";
                    $doctorDelSchedSTMT = $conn->prepare($doctorDelSched);
                    $doctorDelSchedSTMT->bind_param('i', $delDoc_id);
                    if (!$doctorDelSchedSTMT->execute()) {
                        echo $doctorDelSchedSTMT->error;
                        exit();
                    }
                }
                echo 1;
                exit();
            } elseif (isset($_POST['list-radio']) && $_POST['list-radio'] == 'deleteDay') {
                $selectd_date = $_POST['delete-dayDate'];
                if ($staffRole == 'admin'){
                    DeleteSpecificDoctoAvailability($selectd_date, $delDoc_id);

                } elseif ($staffRole == 'doctor'){
                    $doctorDelSched = "INSERT INTO tbl_delschedactivity (delType, Staff_ID, startDate, endDate) VALUES ('deleteDay', ?, ?, ?)";
                    $doctorDelSchedSTMT = $conn->prepare($doctorDelSched);
                    $doctorDelSchedSTMT->bind_param('iss', $delDoc_id, $selectd_date, $selectd_date);
                    if (!$doctorDelSchedSTMT->execute()) {
                        echo $doctorDelSchedSTMT->error;
                        exit();
                    }
                }
                echo 1;
                exit();
            } elseif (isset($_POST['list-radio']) && $_POST['list-radio'] == 'customDelete') {
                $range_start_date = $_POST['start-date'];
                $range_end_date = $_POST['end-date'];
                if ($staffRole == 'admin'){
                    DeleteRangeDoctorAvailability($range_start_date,$range_end_date, $delDoc_id );
                } elseif ($staffRole == 'doctor'){
                    $doctorDelSched = "INSERT INTO tbl_delschedactivity (delType, Staff_ID, startDate, endDate) VALUES ('customDelete', ?, ?, ?)";
                    $doctorDelSchedSTMT = $conn->prepare($doctorDelSched);
                    $doctorDelSchedSTMT->bind_param('iss', $delDoc_id, $range_start_date, $range_end_date);
                    if (!$doctorDelSchedSTMT->execute()) {
                        echo $doctorDelSchedSTMT->error;
                        exit();
                    }
                }
                echo 1;
                exit();
            } else {
                echo 2;
                exit();
            }
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}


if ($action == "getPendingDelSched"){
    $login_user = $_SESSION['user_id'];
    $getstaffID = "SELECT * FROM tbl_staff WHERE User_ID = ?";
    $getstaffIDSTMT = $conn->prepare($getstaffID);
    $getstaffIDSTMT->bind_param("i", $login_user);
    $getstaffIDSTMT->execute();
    $result = $getstaffIDSTMT->get_result();
    if ($result->num_rows === 1) {
        $staff = $result->fetch_assoc();
        $staff_id = $staff['Staff_ID'];
        $staffRole = $staff['Role'];
    }else{
        exit();
    }

    if ($staffRole == 'admin'){
        $getPendingDelete = "SELECT * FROM tbl_delschedactivity
    JOIN tbl_staff on tbl_staff.Staff_ID = tbl_delschedactivity.Staff_ID where delStat = 'Pending' ";
        $getPendingDeleteSTMT = $conn->prepare($getPendingDelete);
        $getPendingDeleteSTMT->execute();
    }elseif ($staffRole == 'doctor'){
        $getPendingDelete = "SELECT * FROM tbl_delschedactivity where Staff_ID = ?  order by delStat = 'Pending' desc ";
        $getPendingDeleteSTMT = $conn->prepare($getPendingDelete);
        $getPendingDeleteSTMT->bind_param('i',$staff_id);
        $getPendingDeleteSTMT->execute();
    }
    $result = $getPendingDeleteSTMT->get_result();
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $delType = $row['delType'];
            $deletionType = '';
            $date = '';
            switch ($delType) {
                case 'deleteAll':
                    $deletionType = 'All';
                    $date = "All";
                    break;
                case 'deleteDay':
                    $deletionType = 'Day';
                    $date = (new DateTime($row['startDate']))->format('F j, Y');
                    break;
                case 'customDelete':
                    $deletionType = 'Custom Range';
                    $date = (new DateTime($row['startDate']))->format('F j, Y') . ' to ' . (new DateTime($row['endDate']))->format('F j, Y');
                    break;
                default:
                    $deletionType = 'N/A';
                    break;
            }
            $statusClas = '';
            switch ($row['delStat']){
                case 'Pending':
                    $statusClas = 'text-yellow-500';
                    break;
                case 'Declined':
                    $statusClas = 'text-red-500';
                    break;
                case 'Approved':
                    $statusClas = 'text-green-500';
                    break;
            }



            if ($staffRole == 'admin'){
                if (!empty($row['Middle_Name'])) {
                    $doctorName = 'Dr. ' . $row['First_Name'] . ' ' . substr($row['Middle_Name'], 0, 1) . '. ' . $row['Last_Name'];
                } else {
                    $doctorName = 'Dr. ' . $row['First_Name'] . ' ' . $row['Last_Name'];
                }
            echo '<tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">           
                                  <td class="w-1/4">'.$doctorName.'</td>
                                    <td>'.$deletionType.'
                                    <td class="w-1/4">'.$date.'</td>
                               
                                    <td class="w-1/4">
                                        <div>
                                            <button class="bg-blue-500 p-2 rounded-md mr-5 text-white font-medium" onclick="ApproveDelSchedReq('.$row['delSchedID'].', '.$row['Staff_ID'].')">Accept</button>
                                            <button class="bg-red-500 p-2 rounded-md text-white font-medium" onclick="declineDelSchedReq('.$row['delSchedID'].')">Decline</button>
                                        </div>
                                    </td>
                                </tr>';
            }elseif ($staffRole == 'doctor'){
                echo '<tr class="text-base hover:bg-gray-300 dark:hover:bg-gray-600 font-medium text-black dark:text-white">
                                   <td>'.$deletionType.'
                                    <!--  ito mga values sa Deletion Type
                                          All, Day, Custom Range -->

                            <td class="w-1/4">'.$date.'</td>
                                    <!--  ito mga values sa Date
                                          All(kapag all), 
                                          July 1, 2024(kapag Delete Day)
                                          August 1, 2024 to September 2, 2024(kapag delete custom range)
                                          -->
                                    <td class="font-bold '.$statusClas.'">'.$row['delStat'].'</td>
                                    <!-- Declined = text-red-500 -->
                                </tr>';
            }
        }
    }else {
        echo ' <h1 class="text-center">No Pending Request</h1>';

    }
}

if ($action == 'approveDelSchedReq'){
    $delSched_id = $_GET['del_sched_id'];
    $staff_id = $_GET['staff_id'];
    $getDelReq = "SELECT * from tbl_delschedactivity where delSchedID = ?";
    $getDelReqSTMT = $conn->prepare($getDelReq);
    $getDelReqSTMT->bind_param('i', $delSched_id);
    if (!$getDelReqSTMT->execute()){
        echo $getDelReqSTMT->error;
        exit();
    }
    $result = $getDelReqSTMT->get_result();
    if ($result->num_rows === 1){
        $delSchedrequest = $result->fetch_assoc();
        if ($delSchedrequest['delType'] == 'deleteAll'){
            DeleteAllDoctorAvailability($staff_id);

        }elseif ($delSchedrequest['delType'] == 'deleteDay'){
            DeleteSpecificDoctoAvailability($delSchedrequest['startDate'], $staff_id);

        }elseif ($delSchedrequest['delType'] == 'customDelete'){
            DeleteRangeDoctorAvailability($delSchedrequest['startDate'],$delSchedrequest['endDate'] , $staff_id);
        }
        $declineReq = "UPDATE tbl_delschedactivity SET delStat = 'Approved' where delSchedID = ?";
        $declineReqSTMT = $conn->prepare($declineReq);
        $declineReqSTMT->bind_param('i', $delSched_id);
        if (!$declineReqSTMT->execute()){
            echo $declineReqSTMT->error;
            exit();
        }
        echo 1;
        exit();
    }
}
if ($action == 'declineDel'){
    $delSched_ID = $_GET['data_id'];
    $declineReq = "UPDATE tbl_delschedactivity SET delStat = 'Declined' where delSchedID = ?";
    $declineReqSTMT = $conn->prepare($declineReq);
    $declineReqSTMT->bind_param('i', $delSched_ID);
    if (!$declineReqSTMT->execute()){
        echo $declineReqSTMT->error;
        exit();
    }
    echo 1;
    exit();

}
if ($action == 'getStaffinfo'){
    $staff_id = $_GET['staff_id'];
    $sql = 'SELECT tbl_staff.*, tbl_accounts.*
            FROM tbl_staff
            JOIN tbl_accounts ON tbl_staff.User_ID = tbl_accounts.User_ID
            WHERE tbl_staff.Staff_ID = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $staff_id );
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($row);
    }
    exit();
}
if ($action == 'getPatientInfo'){
    $patient_id = $_GET['online_user_id'];
    $sql = "SELECT account_user_info.*, tbl_accounts.*
            FROM account_user_info
            JOIN tbl_accounts ON account_user_info.User_ID = tbl_accounts.User_ID
            WHERE    
           account_user_info.user_info_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $patient_id );
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($row);
    }
    exit();
}

if ($action == 'patientBookAppointment') {
    $patientAccountMember = isset($_POST['AppointPerson']) ? $_POST['AppointPerson'] : '';
    $appointDoctor  = isset($_POST['doctor']) ? $_POST['doctor'] : '';
    $appointment_date = isset($_POST['appointment-date']) ? $_POST['appointment-date'] : '';
    $appointment_time = isset($_POST['appointment-time']) ? $_POST['appointment-time'] : '';
    $visitType = isset($_POST['VisitType']) ? $_POST['VisitType'] : '';
    $status = isset($_POST['book_status']) ? $_POST['book_status'] : '';
    $appointment_type = isset($_POST['appointment_type']) ? $_POST['appointment_type'] : '';
    $agreement_approval = isset($_POST['privacy']) ? $_POST['privacy'] : '';
    $service_type = isset($_POST['serviceType']) ? $_POST['serviceType'] : '';

    if ($patientAccountMember !== '' && $appointDoctor !== '' && $visitType !== '' &&
        $status !== '' && $appointment_type !== '' &&
        $agreement_approval !== '' && $service_type !== '' && $appointment_date !== '' && $appointment_time !== '') {


        $appointment_schedule = $appointment_date . ' ' . $appointment_time;
        $sqlAppointment = "INSERT INTO tbl_appointment (Staff_ID, Account_Patient_ID_Member, Appointment_schedule, Status, AgreementApproval, ServiceType, Appointment_type, VisitType)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtAppointment = $conn->prepare($sqlAppointment);
        $stmtAppointment->bind_param('iissssss', $appointDoctor, $patientAccountMember, $appointment_schedule, $status, $agreement_approval, $service_type, $appointment_type, $visitType);

        if ($stmtAppointment->execute()) {
            echo 1;
            exit();
        } else {
            echo 'Failed to insert appointment';
        }
    } else {
        echo "Some input field are empty";
    }
}


if ($action == 'getUserInfo'){
    $UID = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    if ($user_type == 'patient'){
        $sql = "SELECT account_user_info.*, tbl_accounts.*
                FROM account_user_info 
                JOIN tbl_accounts ON account_user_info.User_ID = tbl_accounts.User_ID where tbl_accounts.User_ID = ?;
            ";
    }elseif($user_type == 'staff') {
        $sql = "SELECT tbl_accounts.*, tbl_staff.*
FROM tbl_accounts 
    JOIN tbl_staff ON tbl_staff.User_ID = tbl_accounts.User_ID where tbl_accounts.User_ID = ?;
            ";
    }
    $stmt =$conn->prepare($sql);
    $stmt->bind_param('i', $UID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($row);
    }
    exit();
}

if ($action == 'editUserInfo'){
    $UID = $_SESSION['user_id'];
    $types ='';
    if (isset($_POST['editPass']) && ($_POST['editPass'] == 'true')){
        $newPass = isset($_POST['newPass'])
        && isset($_POST['confPass'])
        && $_POST['newPass']
        === $_POST['confPass'] ? $_POST['newPass'] : '';
        if ($newPass !== ''){
            $hashed_password = password_hash($newPass, PASSWORD_DEFAULT);
            $sql = "UPDATE tbl_accounts SET
                Password = ?
                WHERE User_ID = ?";
            $stmt =$conn->prepare($sql);

            $stmt->bind_param('si', $hashed_password,$UID);
            $stmt->execute();
            echo 1;
            exit();
        }else{
            echo 2;
            exit();
        }
    }else{
        $user_type = $_SESSION['user_type'];
        $accFirstName = $_POST['first-name'];
        $accMiddleName = $_POST['middle-name'];
        $accLastName = $_POST['last-name'];
        $accContactNumber = $_POST['contact-number'];
        $accDOB = $_POST['dob'];
        $accSex = $_POST['sex'];
        $accAddress = $_POST['address'];
        $acc_Email = $_POST['email'];
        if ($user_type == 'patient'){
            $sql = "UPDATE account_user_info
                    JOIN tbl_accounts ON account_user_info.User_ID = tbl_accounts.User_ID
                    SET           
                        Email = ?,
                        First_Name = ?,
                        Middle_Name = ?,
                        Last_Name = ?,
                        DateofBirth = ?,
                        Sex = ?,
                        Contact_Number = ?,
                        Address = ?
                    WHERE tbl_accounts.User_ID = ?;
                ";

            $stmt =$conn->prepare($sql);
            $stmt->bind_param('ssssssssi', $acc_Email,$accFirstName,$accMiddleName,$accLastName,$accDOB,$accSex,$accContactNumber,$accAddress,$UID);
            $stmt->execute();
            echo 1;
            exit();

        }elseif($user_type == 'staff') {
            $speciality = '';
            $sql = "SELECT tbl_accounts.*, tbl_staff.*
                    FROM tbl_accounts 
                        JOIN tbl_staff ON tbl_staff.User_ID = tbl_accounts.User_ID where tbl_accounts.User_ID = ?;
                                ";
            $stmt =$conn->prepare($sql);
            $stmt->bind_param('i', $UID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows === 1){
                $row = $result->fetch_assoc();
                if ($row['Role'] == 'doctor'){
                    $speciality = $_POST['specialty'];
                }
            }else{
                exit();
            }
            $sql = "UPDATE tbl_staff
                    JOIN tbl_accounts ON tbl_staff.User_ID = tbl_accounts.User_ID
                    SET           
                        Email = ?,
                        First_Name = ?,
                        Middle_Name = ?,
                        Last_Name = ?,
                        DateofBirth = ?,
                        Sex = ?,
                        Address = ?,
                        speciality = ?,
                        Contact_Number = ?
                    WHERE tbl_accounts.User_ID = ?;
                ";
            $types = 'sssssssssi';
            $stmt =$conn->prepare($sql);
            $stmt->bind_param($types, $acc_Email,$accFirstName,$accMiddleName,
                $accLastName,$accDOB,$accSex,$accAddress,$speciality, $accContactNumber,$UID);
            if ($stmt->execute()){
                echo 1;
                exit();
            }else{
                exit();
            }
        }else{
            echo 2;
            exit();
        }

    }

}

if ($action == 'getAppointmentInfo'){
    $patientAppointment_ID = $_GET['patientAppointment_ID'];
    $sql = "SELECT *
            FROM `tbl_accountpatientmember` 
            JOIN `tbl_appointment` ON `tbl_appointment`.`Account_Patient_ID_Member` = `tbl_accountpatientmember`.`Account_Patient_ID_Member`
            where `tbl_appointment`.`Appointment_ID` = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $patientAppointment_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($row);
    }
        exit();
}

if ($action == 'updateAppointment'){
    $appointment_status = $_POST['list-status'];
    $doctor_id = isset($_POST['appointDoctor']) ? $_POST['appointDoctor'] : '';
    $appointment_id = $_POST['appointment_id'];
    $remark = $_POST['remarks'];
    $service_type = isset($_POST['service-type']) ? $_POST['service-type'] : null;
    if ($appointment_status == 'rescheduled'){
        $set_Date = date('Y-m-d', strtotime($_POST['rescheduled-date']));
        $set_time = $_POST['rescheduled-time'];
        $rescheduledDateTime = $set_Date. ' '. $set_time;
        $sql = 'UPDATE tbl_appointment SET Staff_ID = ?, 
            Status = ?,
        
            Remarks = ?,
            Appointment_schedule = ?               
            WHERE Appointment_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isssi', $doctor_id, $appointment_status, $remark, $rescheduledDateTime, $appointment_id);

    }else if ($appointment_status == 'approved'){
        $sql = 'UPDATE tbl_appointment SET Staff_ID = ?, 
            Status = ?,
            Remarks = ?
            WHERE Appointment_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issi', $doctor_id, $appointment_status,  $remark, $appointment_id);
    }else if ($appointment_status == 'pending'){
        $sql = 'UPDATE tbl_appointment SET Staff_ID = ?, 
            Status = ?,
        
            Remarks = ?
            WHERE Appointment_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issi', $doctor_id, $appointment_status,  $remark, $appointment_id);
    }
    else{
        $rescheduledDateTim = '';
        $sql = 'UPDATE tbl_appointment SET  
            Status = ?,
           
            Remarks = ?,
            Appointment_schedule = NULL
            WHERE Appointment_ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi',  $appointment_status, $remark, $appointment_id);
    }
    if ($stmt->execute()){
        echo 1;
        exit();
    }else{
        echo $stmt->error;
    }
}
if ($action == 'createPatientChart') {
    try {
        $appointment_id = $_GET['appointment_id'];
        $sql = "SELECT `tbl_accountpatientmember`.*, `tbl_appointment`.*
                FROM `tbl_accountpatientmember`
                LEFT JOIN `tbl_appointment` ON `tbl_appointment`.`Account_Patient_ID_Member` = `tbl_accountpatientmember`.`Account_Patient_ID_Member`
                WHERE `tbl_appointment`.`Appointment_ID` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows !== 1) {
            echo 'Something went wrong';
            exit();
        }
        $row = $result->fetch_assoc();

        $chartOnlineUser_Id = isset($row['user_info_ID']) ? $row['user_info_ID'] : NULL;
        $chartConsultant = $row['Staff_ID'];
        $chartFname = $row['First_Name'];
        $chartMname = $row['Middle_Name'];
        $chartLname = $row['Last_Name'];
        $chartDob = $row['DateofBirth'];
        $chartSex = $row['Sex'];
        $chartContactNum = $row['Contact_Number'];
        $chartAddress = $row['Address'];
        $chartEmail = $row['MemberPatientEmail']; // Adding email if it's required
        $patientStatus = 'To be Seen';
        $followUpSchedule = $row['Appointment_schedule'];

        $sql = "INSERT INTO tbl_patient_chart (user_info_ID, Consultant_id, First_Name,
                    Middle_Name, Last_Name, DateofBirth, Sex, Contact_Number, patientEmail, Address, patient_Status, followUp_schedule) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iissssssssss', $chartOnlineUser_Id, $chartConsultant, $chartFname,
            $chartMname, $chartLname, $chartDob, $chartSex, $chartContactNum, $chartEmail, $chartAddress, $patientStatus, $followUpSchedule);
        if ($stmt->execute()) {
            echo 1;
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($action == 'getPatientRecord'){
    $record_id = $_GET['record_id'];
    $sql= "SELECT 
                *
            FROM 
                tbl_records  WHERE Record_ID = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($row);
    }
    exit();
}

if ($action == 'createPatientRecord') {
    try {
        $record_id = 0;
        $consultation_date = $_POST['consultation-date'];
        $weight = $_POST['weight'];
        $heart_rate = $_POST['heart-rate'];
        $temperature = $_POST['temperature'];
        $blood_pressure = $_POST['blood-pressure'];
        $saturation = $_POST['saturation'];
        $chief_comp = $_POST['Chief_Complaint'];
        $physical_exam = $_POST['Physical_Examination'];
        $assesment = $_POST['Assessment'];
        $treatment_plan = $_POST['Treatment_Plan'];
        $followUp = $_POST['followUp-radio'];
        $Chart_ID = $_GET['chart_id'];
        $availed_Service =$_POST['serviceSelected'];
        if (!empty($_POST['record_id'])){
            $record_id = $_POST['record_id'];
            $getRec = "SELECT * FROM tbl_records where Record_ID = ?";
            $stmt = $conn->prepare($getRec);
            $stmt->bind_param('i', $record_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $sql = "UPDATE tbl_records SET 
                    
                       consultationDate = ?,
                       
                       Temperature = ?, 
                       HeartRate = ?,
                       Weight = ?, 
                       Blood_Pressure = ?, 
                       Saturation = ?, 
                       Chief_complaint = ?, 
                       Physical_Examination = ?, 
                       Assessment = ?, 
                       availedService = ?,
                       Treatment_Plan= ?
                       WHERE Record_ID = ?
                       ";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sdddsssssssi', $consultation_date, $temperature,
                    $heart_rate, $weight, $blood_pressure,
                    $saturation, $chief_comp, $physical_exam,
                    $assesment, $availed_Service, $treatment_plan, $record_id);
                if (!$stmt->execute()){
                    if ($stmt->errno == 1265){
                        echo "Data insert mismatch error";
                        exit();
                    }
                }

                if (!empty($_FILES['resultImage']['name'][0])) {
                    $delsql = "DELETE FROM patientimageresult where record_id = ?";
                    $delstmt = $conn->prepare($delsql);
                    $delstmt->bind_param('i', $record_id);
                    $delstmt->execute();
                }
            }else{
                echo 'Something wrong please reload the website1' ;
                exit();
            }
        }else {
            $sql = "INSERT INTO tbl_records (Chart_ID,consultationDate, availedService,Temperature, HeartRate, Weight, Blood_Pressure, Saturation, Chief_complaint, Physical_Examination, Assessment, Treatment_Plan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issdddssssss", $Chart_ID,  $consultation_date, $availed_Service,$temperature, $heart_rate, $weight, $blood_pressure, $saturation, $chief_comp, $physical_exam, $assesment, $treatment_plan);
            if (!$stmt->execute()){
                if ($stmt->errno == 1265){
                    echo "Data insert mismatch error";
                    exit();
                }
            }
            $record_id = $stmt->insert_id;
        }

        if ($followUp === 'no') {
            $update_patient_chart = "UPDATE tbl_patient_chart SET followUp_schedule = null, patient_Status ='Completed' WHERE Chart_id = ?";
            $stmt2 = $conn->prepare($update_patient_chart);
            $stmt2->bind_param('i', $Chart_ID);
            $stmt2->execute();
        } elseif ($followUp === 'yes') {
            $followUpDate = $_POST['followUpDate'];
            $followUpTime = $_POST['followUpTime'];
            $followupSched = $followUpDate . ' ' . $followUpTime;
            $update_patient_chart = "UPDATE tbl_patient_chart SET followUp_schedule = ?, patient_Status ='Follow Up' WHERE Chart_id = ?";
            $stmt = $conn->prepare($update_patient_chart);
            $stmt->bind_param('si', $followupSched, $Chart_ID);
            $stmt->execute();
        }

        if (!empty($_FILES['resultImage']['name'][0])) {
            foreach ($_FILES['resultImage']['tmp_name'] as $key => $tmp_name) {
                $temp_file = $_FILES['resultImage']['tmp_name'][$key];
                $file_type = $_FILES['resultImage']['type'][$key];
                $file_name = uniqid() . '.' . pathinfo($_FILES['resultImage']['name'][$key], PATHINFO_EXTENSION);
                $destination_directory = '../PatientChartRecordResults/';
                $destination_file = $destination_directory . $file_name;
                if (move_uploaded_file($temp_file, $destination_file)){
                    $sql = "INSERT INTO patientimageresult (record_id,	image_file_name)
                                values (?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('is',$record_id, $file_name);
                    $stmt->execute();
                }
            }
            echo 1;
            exit();
        }else{
            echo 1;
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($action == 'getResImg'){
    $record_id = $_GET['record_id'];
    $sql = "SELECT * FROM patientimageresult where record_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $record_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0){
        while ($row = $res->fetch_assoc()){
            echo '<img class="h-auto max-w-full"
                                       src="../PatientChartRecordResults/'.$row['image_file_name'].'"
                                       alt="image description">';
        }
    }
    exit();
}

if ($action == 'archivePatientChar'){
    $chart_id = $_GET['chart_id'];
    $sql = "UPDATE tbl_patient_chart SET followUp_schedule = NULL, 
                             patient_Status = 'Archived' where Chart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $chart_id);
    if ($stmt->execute()){
        echo 1;
    }
}
if ($action == 'DeletePatientChart'){
    $chart_id = $_GET['chart_id'];
    $sql = "UPDATE tbl_patient_chart SET followUp_schedule = NULL, 
                             patient_Status = 'Deleted' where Chart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $chart_id);
    if ($stmt->execute()){
        echo 1;
    }
}
if ($action == 'UnarchivePatientChart'){
    $chart_id = $_GET['chart_id'];
    $sql = "UPDATE tbl_patient_chart SET followUp_schedule = 'No schedule', 
                             patient_Status = '	Unarchived ' where Chart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $chart_id);
    if ($stmt->execute()){
        echo 1;
    }
}

if ($action == 'cancelAppointment'){
    $conf_password = $_POST['conf_pass'];
    $appointment_id = $_POST['appointment_id'];
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM tbl_accounts WHERE User_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    if (password_verify($conf_password, $row['Password'])) {
        $sql = "UPDATE tbl_appointment 
            SET Status = 'cancelled',
                Appointment_schedule = NULL
            WHERE Appointment_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $appointment_id);
        $stmt->execute();
        echo 2;
    } else {
        echo 'Incorrect Password';
    }
}
if ($action == 'AddWalkInPatient') {

    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
    $fname = isset($_POST['first-name']) ? $_POST['first-name'] : '';
    $mname = isset($_POST['middle-name']) ? $_POST['middle-name'] : '';
    $lname = isset($_POST['last-name']) ? $_POST['last-name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $contactNumber = isset($_POST['contact-number']) ? $_POST['contact-number'] : '';
    $sex = isset($_POST['sex']) ? $_POST['sex'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $vaccinated = isset($_POST['vaccinated']) ? $_POST['vaccinated'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $agrement_approval = isset($_POST['agreementApproval']) ? $_POST['agreementApproval'] : '';
    $appoint_doctor = isset($_POST['appointDoctor']) ? $_POST['appointDoctor']: '';
    $status = 'approved';
    $appointment_type = 'Walk In';

    $sqlPatient = 'INSERT INTO tbl_patient 
            (user_info_ID, First_Name, Middle_Name, Last_Name, DateofBirth, Sex, Contact_Number, patientEmail, Address) 
            VALUES (Null, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmtPatient = $conn->prepare($sqlPatient);
    $stmtPatient->bind_param("ssssssss", $fname, $mname, $lname, $dob, $sex, $contactNumber, $email, $address);

    if ($stmtPatient->execute()) {
        $patientID = $stmtPatient->insert_id;
        $sqlAppointment = "INSERT INTO tbl_appointment 
                ( Staff_ID,Patient_ID, Appointment_schedule,  Status, Appointment_type, Vaccination, reason, AgreementApproval) 
                VALUES (?, ?, NOW(), ?, ?, ?, ?, 'checked')";
        $stmtAppointment = $conn->prepare($sqlAppointment);
        $stmtAppointment->bind_param('iissss', $appoint_doctor,$patientID, $status,
            $appointment_type, $vaccinated, $reason);

        if ($stmtAppointment->execute()) {
            $appointment_id = $stmtAppointment->insert_id;
            $newPatientChart = "INSERT INTO tbl_patient_chart (Appointment_id, followUp_schedule, patient_Status) 
                    VALUES (?,Null, 'To be Seen')";
            $newChart_stmt = $conn->prepare($newPatientChart);
            $newChart_stmt->bind_param('i', $appointment_id);
            if ($newChart_stmt->execute()){
                echo 1;
                exit();
            }else{
                echo 'Failed to insert appointment: ' . $newChart_stmt->error;
            }
        } else {
            echo 'Failed to insert appointment: ' . $stmtAppointment->error;
        }
    } else {
        echo 'Failed to insert patient: ' . $stmtPatient->error;
    }
}
if ($action == 'Editpatient'){
    if (isset($_POST['patient_first-name'])
        && isset($_POST['patient_middle-name'])
        && isset($_POST['patient_last-name'])
        && isset($_POST['patient_contact-number'])
        && isset($_POST['patient_sex']) &&
        isset($_POST['patient_email']) &&

        isset($_POST['patient_address']) &&
        isset($_POST['patient_dob']) &&
        isset($_POST['patient_status']) &&
        isset($_POST['patient_chart_id'])) {
        $patientFname = $_POST['patient_first-name'];
        $patientMname = $_POST['patient_middle-name'];
        $patientLname = $_POST['patient_last-name'];
        $patient_contactNum = $_POST['patient_contact-number'];
        $patient_sex = $_POST['patient_sex'];
        $patientEmail = $_POST['patient_email'];
        $patient_address = $_POST['patient_address'];
        $patient_Dob = $_POST['patient_dob'];
        $patient_Chart_status =$_POST['patient_status'];
        $chart_id = $_POST['patient_chart_id'];

        $update_patient_chart_status = "UPDATE tbl_patient_chart SET First_Name = ?, Middle_Name = ?, 
                       Last_Name = ?, DateofBirth = ?, Sex = ?, Contact_Number = ? , 
                       patientEmail = ? , Address = ? , patient_Status = ? WHERE Chart_id = ?";
        $update_patient_chart_stmt = $conn->prepare($update_patient_chart_status);
        $update_patient_chart_stmt->bind_param('sssssssssi', $patientFname, $patientMname,
            $patientLname, $patient_Dob, $patient_sex, $patient_contactNum, $patient_email, $patient_address, $patient_Chart_status, $chart_id);
        if (!$update_patient_chart_stmt->execute()){
            echo $update_patient_chart_stmt->error;
            exit();
        }

        echo 1;
        exit();

    } else {
        echo "Some fields are empty";
        exit();
    }
}

if ($action == 'removeFollowupSched'){
    $chart_id = $_GET['chart_id'];
    $update_patient_chartSched = "UPDATE tbl_patient_chart SET followUp_schedule = Null WHERE Chart_id = ?";
    $stmt = $conn->prepare($update_patient_chartSched);
    $stmt->bind_param('i', $chart_id);
    if (!$stmt->execute()){
        echo 'Error occured please contact developer';
    }
    echo 1;
}

if ($action == 'getOnlineUserInfo'){
    $user_id = $_GET['onlineUser_id'];
    $getOnlineUserInfo = "
        SELECT `tbl_accounts`.*, `account_user_info`.* 
        FROM `tbl_accounts` 
        JOIN `account_user_info` 
        ON `account_user_info`.`User_ID` = `tbl_accounts`.`User_ID` 
        WHERE `account_user_info`.`User_ID` = ?;
    ";
    $getOnlineUserInfoStmt = $conn->prepare($getOnlineUserInfo);
    $getOnlineUserInfoStmt->bind_param('i', $user_id);
    if (!$getOnlineUserInfoStmt->execute()){
        echo $getOnlineUserInfoStmt->error;
        exit();
    }
    $res = $getOnlineUserInfoStmt->get_result();
    if ($res->num_rows === 1){
        $row = $res->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($row);
        exit();
    }
}
if ($action === 'getPatientApppointmentInfoJSON') {
    if (isset($_GET['data_id'])) {
        $patient_id = $_GET['data_id'];
        $sql = "SELECT `tbl_patient`.*, `tbl_appointment`.*
                FROM `tbl_patient` 
                JOIN `tbl_appointment` ON `tbl_appointment`.`Patient_ID` = `tbl_patient`.`Patient_ID`
                WHERE tbl_patient.Patient_ID = ?;";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('i', $patient_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_assoc();
            header('Content-Type: application/json');
            echo json_encode($rows);
        } else {
            echo json_encode(['error' => 'Statement preparation failed']);
        }
    } else {

        echo json_encode(['error' => 'Missing data_id parameter']);
    }
}
if ($action === 'AccountMemberPostReq'){
    $accownerId = isset($_POST['onlineOwnerId']) ? intval($_POST['onlineOwnerId']) : 0;
    $ownerAddress = '';
    $ownerEmail = $_SESSION['userEmail'];
    $ownerContact = '';
    $getAccountInfoAddress = "SELECT * FROM account_user_info WHERE user_info_ID = ?";
    $getAccountInfoAddressSTMT = $conn->prepare($getAccountInfoAddress);
    $getAccountInfoAddressSTMT->bind_param('i', $accownerId);
    $getAccountInfoAddressSTMT->execute();
    $result = $getAccountInfoAddressSTMT->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $ownerAddress = $row['Address'];
        $ownerContact = $row['Contact_Number'];

    }else{
        echo 'Getting Account owner info failed';
        exit();
    }
    $relation = isset($_POST['relation']) && $_POST['relation'] != 'Others'? $_POST['relation'] : (isset($_POST['otherRelation']) ? $_POST['otherRelation'] : '');
    $relativeFname = isset($_POST['relativeFname']) ? $_POST['relativeFname'] : '';
    $relativeMiddlename = isset($_POST['relativeMiddlename']) ? $_POST['relativeMiddlename'] : '';
    $relativeLastname = isset($_POST['relativeLastname']) ? $_POST['relativeLastname'] : '';
    $relativeWeight = isset($_POST['relativeWeight']) ? $_POST['relativeWeight'] : '';
    $relativeDob = isset($_POST['relativeDob']) ? $_POST['relativeDob'] : '';
    $relativeSex = isset($_POST['sex']) ? $_POST['sex'] : '';
    $relativeMedcondition = isset($_POST['relativeMedcondition']) ? $_POST['relativeMedcondition'] : 'N/A';
    $addressInfo = (isset($_POST['addressInfo']) && $_POST['addressInfo'] === 'Yes') ? $ownerAddress : (isset($_POST['relativeAddress']) ? $_POST['relativeAddress'] : '');
    $accountmemeberID = isset($_POST['accountmemeberID']) ? $_POST['accountmemeberID'] : '';
    $actionType = isset($_POST['actionType']) ? $_POST['actionType'] : '';

    if ($relation !== '' && $relativeFname !== '' && $relativeMiddlename !== '' && $relativeLastname !== '' && $relativeWeight !== '' &&
    $relativeDob !== '' && $relativeSex !== '' && $addressInfo !== '' && $accownerId){

        if ($actionType == 'Edit' and $accountmemeberID != 0){
            $updateAccAppointmentMember = "UPDATE tbl_accountpatientmember 
                                   SET First_Name=?, Middle_Name=?, Last_Name=?, DateofBirth=?, 
                                       Sex=?, Contact_Number=?, MemberPatientEmail=?, 
                                       Address=?, Medical_condition=?, RelationshipType=?
                                   WHERE Account_Patient_ID_Member  = ?";
            $updateAccAppointmentMemberSTMT = $conn->prepare($updateAccAppointmentMember);
            $updateAccAppointmentMemberSTMT->bind_param('ssssssssssi', $relativeFname, $relativeMiddlename,
                $relativeLastname, $relativeDob, $relativeSex,
                $ownerContact, $ownerEmail, $addressInfo,
                $relativeMedcondition, $relation, $accountmemeberID);

            if ($updateAccAppointmentMemberSTMT->execute()){
                echo 2;
                exit();
            }else{
                echo $updateAccAppointmentMemberSTMT->error;
            }
        }elseif ($actionType == 'Add'){
            $newAccAppointmentMember = "INSERT INTO tbl_accountpatientmember (user_info_ID,  First_Name	,
                              Middle_Name	,Last_Name	,DateofBirth	,Sex	,Contact_Number
                              	,MemberPatientEmail	,Address	,Medical_condition	,RelationshipType)
    VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $newAccAppointmentMemberSTMT  = $conn->prepare($newAccAppointmentMember);
            $newAccAppointmentMemberSTMT->bind_param('issssssssss', $accownerId, $relativeFname
                ,$relativeMiddlename, $relativeLastname, $relativeDob, $relativeSex, $ownerContact, $ownerEmail,
                $addressInfo, $relativeMedcondition, $relation);
            if ($newAccAppointmentMemberSTMT->execute()){
                echo 2;
                exit();
            }else{
                echo $newAccAppointmentMemberSTMT->error;
            }
        }else{
            echo $actionType;
        }
    } else {
        echo "Some Fields are empty ";

    }
}
if ($action == 'getAccountMemberDataJSON'){
    $accountMemberID = $_GET['data_id'];
    $accOwnerId = $_GET['SessionUserID'];
    $getAccountMemberSql = "SELECT * FROM tbl_accountpatientmember where Account_Patient_ID_Member = ? and user_info_ID = ? and status = 'Active'";
    $getAccountMemberSqlSTMT = $conn->prepare($getAccountMemberSql);
    $getAccountMemberSqlSTMT->bind_param('ii',$accountMemberID, $accOwnerId);

    if ($getAccountMemberSqlSTMT->execute()){
        $result = $getAccountMemberSqlSTMT->get_result();
        if ($result->num_rows === 1){
            $row = $result->fetch_assoc();
            header('Content-Type: application/json');
            echo json_encode($row);
            exit();
        }else{
            echo json_encode(['message' => 'No available Data']);
        }
    }
}
if ($action == 'DeleteAccountAppointmentMember'){
    $accountMemberID = $_GET['data_id'];
    $accOwnerId = $_GET['SessionUserID'];
    $changeMemberStat = "UPDATE tbl_accountpatientmember SET status = 'Removed' where Account_Patient_ID_Member  = ? and  user_info_ID  = ?";
    $changeMemberStatSTMT = $conn->prepare($changeMemberStat);
    $changeMemberStatSTMT->bind_param('ii', $accountMemberID, $accOwnerId);
    if ($changeMemberStatSTMT->execute()){
        echo 1;
        exit();
    }else{
        echo $changeMemberStatSTMT->error;
        exit();
    }

}