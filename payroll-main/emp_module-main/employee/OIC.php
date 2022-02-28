<?php 

require_once('../class.php');
$sessionData = $payroll->getSessionOICData();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
</head>
<body>

    <div class="main-container">
        <?php 
            $payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname']);
        ?>
        <a href="../logout.php">Logout</a>

        <div class="list">
            <ul>
                <li><a href="">Attendance</a></li>
                <li><a href="">Apply For Leave</a></li>
                <li><a href="">View Remarks and Violation</a></li>
                <li><a href="">Request for Substitution</a></li>
            </ul>

            <ul>
                <li><a href="OICscanQR.php">Scan QR</a></li>
                <li><a href="OICAttendance.php">Attendance</a></li>
            </ul>
        </div>
    </div>


</body>
</html>