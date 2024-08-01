<!-- patient -->

<?php
session_start();
require_once 'Utils.php';
$currAccType = get_account_type();
if (!user_has_roles($currAccType, [AccountType::PATIENT, AccountType::VISITOR]))
{
  return;
}

include_once '../Database/database_conn.php';
if ($currAccType == AccountType::PATIENT)
{
  $user_id = $_SESSION['user_id'];
  $getAccOwner_Info = "
  SELECT * FROM account_user_info
  WHERE User_ID = ?;
  ";
  $getAccOwner_InfoSTMT = $conn->prepare($getAccOwner_Info);
  $getAccOwner_InfoSTMT->bind_param('i', $user_id);
  $getAccOwner_InfoSTMT->execute();
  $res = $getAccOwner_InfoSTMT->get_result();
  $row = $res->fetch_assoc();
  $_SESSION['online_Account_owner_id'] = $row['user_info_ID'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HCMC</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/style.css" />
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  </head>
  <body class=" bg-[#ebf0f4] dark:bg-[#17222a] text-[#0e1011] dark:text-[#eef0f1]">
       
  <!-- max-w-screen-xl pinakaimportant -->


    <!-- navigation bar -->
    <?php include 'navbar-main.php'; ?>
    <?php
    if (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'patient'):
    ?>
    <!-- patient welcome page pag may account lang -->
    <?php include 'patient-dashboard.php'; ?>

    <?php endif;?>
    <!-- welcome page pag walang account -->
    <?php include '../html/landpage-swiper.html'; ?>


    <?php include '../html/features.html'; ?>

    <?php include '../html/footer.html'; ?>
    

    

 
  </body>
</html>
