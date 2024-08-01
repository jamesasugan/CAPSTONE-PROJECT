<?php
enum AccountType: int
{
    case ADMIN = 0;
    case VISITOR = 1;
    case PATIENT = 2;
    case STAFF = 3; // staff or doctor
}
?>