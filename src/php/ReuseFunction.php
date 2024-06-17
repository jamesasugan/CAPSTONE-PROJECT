<?php
$key = "123sdfqwAS#@!4!@!#$%%^#asdasd";
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
    $staffCondition = $userRole['Role'] == 'doctor' ? ' AND Consultant_id = ?' : '';
    $sql = "SELECT COUNT(*) AS total_count
            FROM tbl_patient_chart WHERE 
            patient_Status != 'Archived' and patient_Status != 'Deleted'" . $staffCondition;
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
    $staffCondition = $userRole['Role'] == 'doctor' ? ' AND Consultant_id = ?' : '';
    $sql = "SELECT COUNT(*) AS total_count
            FROM tbl_patient_chart
            WHERE patient_Status = 'To be Seen'" . $staffCondition;
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
function encrypt($data, $key) {
    $cipher = "aes-256-cbc";
    $ivLength = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivLength);

    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}
function decrypt($data, $key) {
    $cipher = "aes-256-cbc";
    $data = base64_decode($data);
    $ivLength = openssl_cipher_iv_length($cipher);
    $iv = substr($data, 0, $ivLength);
    $encrypted = substr($data, $ivLength);

    return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
}
function getLastPatientVisit($chart_id) {
    include "../Database/database_conn.php";
    $getLastConsultationDateQuery = "SELECT consultationDate 
                                     FROM tbl_records 
                                     WHERE Chart_ID = ? 
                                     ORDER BY consultationDate DESC 
                                     LIMIT 1";
    $stmt = $conn->prepare($getLastConsultationDateQuery);
    $stmt->bind_param("i", $chart_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return date("F j, Y", strtotime($row['consultationDate']));

    } else {
        return "No record";
    }
    $stmt->close();
}
function getPatientChartDoctor($ChartID) {
    include "../Database/database_conn.php";
    $getConsultant = "SELECT tbl_staff.* FROM tbl_patient_chart 
    JOIN tbl_staff on tbl_staff.Staff_ID = tbl_patient_chart.Consultant_id  
         where tbl_patient_chart.Chart_id = ? ";
    $getConsultantSTMT = $conn->prepare($getConsultant);
    $getConsultantSTMT->bind_param("i", $ChartID);
    $getConsultantSTMT->execute();
    $result = $getConsultantSTMT->get_result();
    $getConsultantSTMT->close();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $middleInitial =
            strlen($row['Middle_Name']) >= 1 ? substr($row['Middle_Name'], 0, 1).'.' : '';
        return 'Dr. '.$row['First_Name']. ' '. $middleInitial. ' '. $row['Last_Name'];
    }else {
        return "No record";
    }

}


function UpdateDoctorAvailabiity($selectedDays, $startTime, $endTime, $startSched, $endSched, $staff_id){
    include "../Database/database_conn.php";
    $dates = calculateDates($selectedDays, $startSched, $endSched);
    $staffDateAvailability = array();
    $getDoctorSchedAvailability = "SELECT * FROM tbl_availability where Staff_ID = ?";
    $getDoctorSchedAvailabilitySTMT = $conn->prepare($getDoctorSchedAvailability);
    $getDoctorSchedAvailabilitySTMT->bind_param('i',$staff_id);
    $getDoctorSchedAvailabilitySTMT->execute();
    $result = $getDoctorSchedAvailabilitySTMT->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $staffDateAvailability[] = $row['Date'];
        }
    }

    foreach ($dates as $date) {
        if (in_array($date, $staffDateAvailability)) {
            $sql = "UPDATE tbl_availability SET StartTime = ?, EndTime = ? WHERE Staff_ID = ? AND Date = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $startTime, $endTime, $staff_id, $date);
            $stmt->execute();
        } else {
            $sql = "INSERT INTO tbl_availability (Staff_ID, Date, StartTime, EndTime) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $staff_id, $date, $startTime, $endTime);
            $stmt->execute();
        }
    }
    return 1;

}

function DeleteAllDoctorAvailability($doctor_id){
    include "../Database/database_conn.php";

    $del = "DELETE FROM tbl_availability WHERE Staff_ID = ?";
    $del_stmt = $conn->prepare($del);
    $del_stmt->bind_param('i', $doctor_id);
    $del_stmt->execute();
}
function DeleteSpecificDoctoAvailability($selectd_date, $doctor_id){
    include "../Database/database_conn.php";
    $del = "DELETE FROM tbl_availability WHERE Date = ? AND Staff_ID = ?";
    $del_stmt = $conn->prepare($del);
    $del_stmt->bind_param('si', $selectd_date, $doctor_id);
    $del_stmt->execute();
}
function DeleteRangeDoctorAvailability($range_start_date, $range_end_date, $delDoc_id){
    include "../Database/database_conn.php";

    $del_range = "DELETE FROM tbl_availability WHERE Date BETWEEN ? AND ? AND Staff_ID = ?";
    $del_range_stmt = $conn->prepare($del_range);
    $del_range_stmt->bind_param('ssi', $range_start_date, $range_end_date, $delDoc_id);
    $del_range_stmt->execute();
}