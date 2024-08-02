<?php
include_once 'AccountType.php';

function get_account_type()
{
    require '../Database/database_conn.php';
    if (isset($_SESSION['user_type'])){
        if ($_SESSION['user_type'] == 'staff')
        {
            try
            {
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT role from tbl_staff where User_ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
    
                // :(
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row['role'] == 'doctor'){
                      return AccountType::STAFF;
                    }
                    else if ($row['role'] == 'admin'){
                      return AccountType::ADMIN;
                    }
                }
            }
            finally
            {
                $conn->close();
            }
        }
        else // there are only two user_type. staff and patient
        {
            return AccountType::PATIENT;
        }
    }

    return AccountType::VISITOR;
}

function user_has_roles($currAccountType, $permission_arr)
{
    if (in_array($currAccountType, $permission_arr))
        return true;

    header('Location: index.php');
    return false;
}

function query_user_info($is_staff)
{
    require '../Database/database_conn.php';
    if (isset($_SESSION['user_type'])){
        try
        {
            $tbl_name = $is_staff ? "tbl_staff" : "account_user_info";
            $sql = "SELECT * FROM $tbl_name WHERE User_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                return $row;
            }
        }
        finally{
            $conn->close();
        }
    }

    return null;
}

?>