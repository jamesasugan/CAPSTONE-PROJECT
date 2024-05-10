<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
    header("Location: 404.php");
    exit();
}



include '../Database/database_conn.php';
session_start();

function calculateDates($selectedDays, $onRepeat) {
    $dates = array();
    if ($onRepeat == 'yes') {
        $currentYear = date('Y');
        $currentDayOfYear = date('z') + 1;
        $startDate = date('Y-m-d', strtotime("$currentYear-01-01 +$currentDayOfYear days"));
        $endDate = date('Y-m-d', strtotime("$currentYear-12-31"));
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $dayOfWeek = date('N', strtotime($currentDate));
            if (in_array($dayOfWeek, $selectedDays)) {
                $dates[] = $currentDate;
            }
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }
    } else {
        $currentTimestamp = time();
        $currentDayOfWeek = date('N', $currentTimestamp);
        $startOfWeekTimestamp = strtotime('last Monday', $currentTimestamp);
        for ($i = 0; $i < 7; $i++) {
            $currentDayTimestamp = strtotime("+$i days", $startOfWeekTimestamp);
            $dayOfWeek = date('N', $currentDayTimestamp);
            if (in_array($dayOfWeek, $selectedDays)) {
                $currentDayDate = date('Y-m-d', $currentDayTimestamp);
                $dates[] = $currentDayDate;
            }
        }
    }
    return $dates;
}



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
        // Email already exists
        echo 4;
        exit();
    }

    if (isset($first_name) || isset($last_name) || isset($contact_number) || isset($date_of_birth) || isset($sex) || isset($address) || isset($email) ) {
        $user_type = isset($_POST['type']) && in_array($_POST['type'], ['patient', 'staff']) ? $_POST['type'] : '';
        if ($user_type === '') {
            echo 4;
            exit();
        }



        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_accounts = "INSERT INTO tbl_accounts (Email, Password, userType) VALUES (?, ?, ?)";
        $stmt_accounts = $conn->prepare($sql_accounts);
        $stmt_accounts->bind_param("sss", $email, $hashed_password, $user_type);
        $stmt_accounts->execute();
        $user_id = $conn->insert_id;
        //  send email

        if ($user_type == 'patient'){
            $sql_patient = "INSERT INTO account_user_info (User_ID, First_Name, Middle_Name, Last_Name, DateofBirth, Sex, Contact_Number, Address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_patient = $conn->prepare($sql_patient);
            $stmt_patient->bind_param("isssssis", $user_id, $first_name, $middle_name, $last_name, $date_of_birth, $sex, $contact_number, $address);
            $stmt_patient->execute();

        }else{
            $role = isset($_POST['role']) ? $_POST['role']: '';
            $sql_staff = "INSERT INTO tbl_staff (User_ID, First_Name, 
                       Middle_Name, Last_Name, DateofBirth, Contact_Number,
                       Sex, Address, Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_staff = $conn->prepare($sql_staff);
            $stmt_staff->bind_param("issssisss", $user_id,
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
if ($action == 'DoctorSchedule'){
    $staff_id = isset($_POST['DoctorID']) ? $_POST['DoctorID'] : '' ;
    $monday  = isset($_POST['monday']);
    $tuesday = isset($_POST['tuesday']);
    $wednesday = isset($_POST['wednesday']);
    $thursday = isset($_POST['thursday']);
    $friday = isset($_POST['friday']);
    $saturday = isset($_POST['saturday']);
    $availability_time_In = isset($_POST['availability-timeIn']) ? $_POST['availability-timeIn']: '';
    $availability_time_end = isset($_POST['availability-timeEnd'])? $_POST['availability-timeEnd'] : '';
    $onRepeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';

    $selectedDays = array();
    if ($monday) $selectedDays[] = 1; // Monday
    if ($tuesday) $selectedDays[] = 2; // Tuesday
    if ($wednesday) $selectedDays[] = 3; // Wednesday
    if ($thursday) $selectedDays[] = 4; // Thursday
    if ($friday) $selectedDays[] = 5; // Friday
    if ($saturday) $selectedDays[] = 6; // Saturday


    $dates = calculateDates($selectedDays, $onRepeat);
    $del = "DELETE FROM tbl_availability where Staff_ID = ?";
    $del_stmt = $conn->prepare($del);
    $del_stmt->bind_param('i', $staff_id);
    $del_stmt->execute();
    foreach ($dates as $date) {

        $sql = "INSERT INTO tbl_availability (Staff_ID, Date, StartTime, EndTime) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $staff_id, $date, $availability_time_In, $availability_time_end);
        $stmt->execute();
    }
    echo 1;
}

if ($action == 'deleteSched'){
    $passWord_conf = $_POST['conf_passoword'];
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
                $del = "DELETE FROM tbl_availability where Staff_ID = ?";
                $del_stmt = $conn->prepare($del);
                $del_stmt->bind_param('i', $delDoc_id);
                $del_stmt->execute();
                echo 1;
                exit() ;

            }elseif (isset($_POST['list-radio']) && $_POST['list-radio'] == 'deleteDay'){
                $selectd_date = $_POST['delete-dayDate'];
                $del = "DELETE FROM tbl_availability where Date = ?";
                $del_stmt = $conn->prepare($del);
                $del_stmt->bind_param('s', $selectd_date);
                $del_stmt->execute();
                echo 1;
                exit() ;
            }
            elseif (isset($_POST['list-radio']) && $_POST['list-radio'] == 'customDelete'){
                $range_start_date = $_POST['start-date'];
                $range_end_date = $_POST['end-date'];
                $del_range = "DELETE FROM tbl_availability WHERE Date BETWEEN ? AND ?";
                $del_range_stmt = $conn->prepare($del_range);
                $del_range_stmt->bind_param('ss', $range_start_date, $range_end_date);
                $del_range_stmt->execute();
                echo 1;
                exit() ;
            }else{
                echo 2;
                exit();
            }
        }
        else{
            echo 2;
        }
    }else{
        echo 2;
    }
}
if ($action == 'patientBookAppointment'){
    $firstName = isset($_POST['first-name']) ? $_POST['first-name'] : '';
    $middleName = $_POST['middle-name'];
    $lastName = isset($_POST['last-name']) ? $_POST['last-name'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $sex = isset($_POST['sex']) ? $_POST['sex'] : '';
    $contactNumber = isset($_POST['contact-number']) ? $_POST['contact-number'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $user_id = isset($_POST['online_user_id']) ? $_POST['online_user_id'] : '';
    $patient_email = isset($_POST['email']) ? $_POST['email'] : '';
    $appointment_date = isset($_POST['appointment-date']) ? $_POST['appointment-date'] : '';
    $appointment_time = isset($_POST['appointment-time']) ? $_POST['appointment-time'] : '';
    $service_field = isset($_POST['service']) ? $_POST['service'] : '';
    $service_type = isset($_POST['service-type']) ? $_POST['service-type'] : '';
    $status = isset($_POST['book_status']) ? $_POST['book_status'] : '';
    $appointment_type = isset($_POST['appointment_type']) ? $_POST['appointment_type'] : '';
    $vaccination = isset($_POST['vaccinated']) ? $_POST['vaccinated'] : '';
    $agreement_approval = isset($_POST['privacy']) ? $_POST['privacy'] : '';
    $mysqlDate = date('Y-m-d', strtotime($appointment_date));
    $appointment_schedule = $mysqlDate . ' ' . $appointment_time;


    if ($firstName !== '' &&  $lastName !== '' && $dob !== ''
        && $sex !== '' && $contactNumber !== ''
        && $address !== '' && $user_id !== ''
        && $patient_email !== '' && $appointment_date !== ''
        && $appointment_time !== '' && $service_field !== ''
        && $service_type !== '' && $status !== ''
        && $appointment_type !== '' && $vaccination !== ''
        && $agreement_approval !== '') {
        $sql = 'INSERT INTO tbl_patient 
    (user_info_ID, First_Name, Middle_Name, Last_Name, DateofBirth, Sex, Contact_Number, patientEmail, Address) 
    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssss", $user_id,$firstName, $middleName, $lastName, $dob, $sex, $contactNumber, $patient_email,$address);
        $stmt->execute();
        $patientID = $stmt->insert_id;
        /*
        echo $patientID.' '.$firstName.' '.$middleName.' '.$lastName.' '.$dob.' '.$sex.' '.$contactNumber.' '.$patient_email.' '.$address
            .' '.$appointment_schedule.' '.$service_field.' '.$service_type.' '.$status.' '.$appointment_type.' '.$vaccination.' '.$agreement_approval
        ;
        */

        if($stmt->affected_rows > 0) {
            $patient_appointment = "INSERT INTO tbl_appointment 
                                    (Patient_ID, Appointment_schedule, Service_Field, Service_Type, Status, Appointment_type, Vaccination, AgreementApproval) 
                                    VALUES 
                                    (?, ?, ?, ?, ?, ?, ?, ?)";

            $appointment_stmt = $conn->prepare($patient_appointment);
            $appointment_stmt->bind_param('isssssss', $patientID,
                $appointment_schedule, $service_field, $service_type,
                $status, $appointment_type, $vaccination, $agreement_approval);
            $appointment_stmt->execute();

            if ($appointment_stmt->affected_rows > 0){
                echo 1;
                exit();
            }
        }
    }

    echo "Error occurred while booking appointment.";

    $stmt->close();
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
            $stmt->bind_param('ssssssssi', $acc_Email,$accFirstName,$accMiddleName,$accLastName,$accDOB,$accSex,$accContactNumber
                ,$accContactNumber,$UID);
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