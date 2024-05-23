<?php

function calculateDates($selectedDays, $startingDate, $endingDate) {
    $dates = [];

    if ($startingDate === $endingDate) {
        $dates[] = $startingDate;
        return $dates;
    }


    $currentDate = strtotime($startingDate);
    $endDate = strtotime($endingDate);

    while ($currentDate <= $endDate) {
        $dayOfWeek = date('N', $currentDate);
        if (in_array($dayOfWeek, $selectedDays)) {
            $dates[] = date('Y-m-d', $currentDate);
        }
        $currentDate = strtotime('+1 day', $currentDate);
    }

    return $dates;
}

function isValidDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}


function getUserRole() {
    include '../Database/database_conn.php';
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'patient' || !isset($_SESSION['user_id'])) {
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $getDoctor = "SELECT Role, Staff_ID FROM tbl_staff WHERE User_ID = ?";
    $getDoctorStmt = $conn->prepare($getDoctor);
    if (!$getDoctorStmt) {
        die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
    }
    $getDoctorStmt->bind_param('i', $user_id);
    $getDoctorStmt->execute();
    $getDoctorResult = $getDoctorStmt->get_result();
    if ($getDoctorResult->num_rows === 0) {
        return null;
    }
    $row = $getDoctorResult->fetch_assoc();
    $getDoctorStmt->close();
    $conn->close();
    return ['Role' => $row['Role'], 'Staff_ID' => $row['Staff_ID']];
}

function getPendingAppointment() {
    include "../Database/database_conn.php";
    $userRole = getUserRole();
    $staffCondition = $userRole['Role'] == 'doctor' ? ' AND Staff_ID = ?' : '';
    $sql = "SELECT COUNT(*) AS pending_count FROM tbl_appointment WHERE Status = 'pending'" . $staffCondition;
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
    }
    if ($staffCondition) {
        $stmt->bind_param('i', $userRole['Staff_ID']);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $pending_count = 0;
    if ($row = $result->fetch_assoc()) {
        $pending_count = $row['pending_count'];
    }
    $stmt->close();
    $conn->close();
    return $pending_count;
}

function getTotalPatientChart() {
    include '../Database/database_conn.php';
    $userRole = getUserRole();
    $staffCondition = $userRole['Role'] == 'doctor' ? ' AND a.Staff_ID = ?' : '';
    $sql = "SELECT COUNT(*) AS total_count
            FROM tbl_patient_chart pc
            JOIN tbl_appointment 
            a ON pc.Appointment_id = a.Appointment_ID WHERE 
            pc.patient_Status != 'Archived' and pc.patient_Status != 'Deleted'" . $staffCondition;
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
    }
    if ($staffCondition) {
        $stmt->bind_param('i', $userRole['Staff_ID']);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $total_count = 0;
    if ($row = $result->fetch_assoc()) {
        $total_count = $row['total_count'];
    }
    $stmt->close();
    $conn->close();
    return $total_count;
}
function tobeSeenPatient() {
    include '../Database/database_conn.php';
    $userRole = getUserRole();
    $staffCondition = $userRole['Role'] == 'doctor' ? ' AND a.Staff_ID = ?' : '';
    $sql = "SELECT COUNT(*) AS total_count
            FROM tbl_patient_chart pc
            JOIN tbl_appointment a ON pc.Appointment_id = a.Appointment_ID
            WHERE pc.patient_Status = 'To be Seen'" . $staffCondition;
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
    }
    if ($staffCondition) {
        $stmt->bind_param('i', $userRole['Staff_ID']);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $total_count = 0;
    if ($row = $result->fetch_assoc()) {
        $total_count = $row['total_count'];
    }
    $stmt->close();
    $conn->close();
    return $total_count;
}
