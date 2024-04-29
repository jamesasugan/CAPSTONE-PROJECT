<?php

include '../Database/database_conn.php';
session_start();

$action = $_GET['action'];

if ($action == 'signup'){
    extract($_POST);
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $middle_name = filter_input(INPUT_POST, 'middle_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $contact_number = filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_NUMBER_INT);
    $date_of_birth = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
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

    if (isset($first_name) || isset($last_name) || isset($contact_number) || isset($date_of_birth) || isset($sex) || isset($address) || isset($email) || isset($password) || isset($conf_password)) {
        if ($password !== $conf_password) {
            echo 3; //mismatch password
        } else {
            $user_type = isset($_GET['type']) && in_array($_GET['type'], ['Patient', 'Staff', 'Doctor']) ? $_GET['type'] : '';
            if ($user_type === '') {
                echo 4;
                exit();
            }

            $user_type = isset($_GET['type']) && $_GET['type'] == 'patient'? 'Patient' : 'Staff';
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql_accounts = "INSERT INTO tbl_accounts (Email, Password, user_Type) VALUES (?, ?, ?)";
            $stmt_accounts = $conn->prepare($sql_accounts);
            $stmt_accounts->bind_param("ss", $email, $hashed_password, $user_type);
            $stmt_accounts->execute();
            $user_id = $conn->insert_id;
            //  SMTP for email
            $sql_patient = "INSERT INTO account_user_info (User_ID, First_Name, Middle_Name, Last_Name, DateofBirth, Sex, Contact_Number, Address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_patient = $conn->prepare($sql_patient);
            $stmt_patient->bind_param("isssssis", $user_id, $first_name, $middle_name, $last_name, $date_of_birth, $sex, $contact_number, $address);
            $stmt_patient->execute();
            echo 1;
            exit();
        }
    } else {
        echo 2; // may variables null
        exit();
    }
}


if ($action == "login"){
    extract($_POST);
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
    $sql = "SELECT Date, Specialty, tbl_staff.First_Name AS DoctorFirstName, tbl_staff.Last_Name AS DoctorLastName, StartTime, EndTime
        FROM tbl_availability
        INNER JOIN tbl_staff ON tbl_availability.Staff_ID = tbl_staff.Staff_ID
        ORDER BY Date, StartTime";
    $result = $conn->query($sql);
    $schedules = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = $row['Date'];
            $department = $row['Specialty'];
            $doctor = "Dr. " . $row['DoctorLastName'];
            $times = $row['StartTime'] . " to " . $row['EndTime'];

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
    $conn->close();
    $schedules_json = json_encode($schedules);
    header('Content-Type: application/json');
    echo $schedules_json;
}