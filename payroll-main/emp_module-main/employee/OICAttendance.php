<?php 

require_once('../class.php');
$sessionData = $payroll->getSessionOICData();
$getDateTime = $payroll->getDateTime();

$sessionName = $sessionData['fullname'];
$getTimeNow = $getDateTime['time'];
$getDateNow = $getDateTime['date'];
// $getempId = $sessionData['empId'];

$payroll->submitOICAttendance();
$payroll->TimeOutAttendance();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
</head>
<body>
    <div class="main-container">
        <?php 
            $payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname']);
        ?>

        <div class="attendance">
            <h1>Attendance</h1>
            <form method="post">
                <div>
                    <label for="fullname">Fullname</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo $sessionName ?>" readonly>
                </div>

                <div>
                    <label for="timenow">Time</label>
                    <input type="text" name="timenow" id="timenow" value="<?php echo $getTimeNow ?>" readonly>
                </div>

                <div>
                    <label for="datenow">Date</label>
                    <input type="text" name="datenow" id="datenow" value="<?php echo $getDateNow ?>" readonly>
                </div>
                
                <div>
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" value="<?php echo 'No location right now :)' ?>" readonly>
                </div>
                <?= $payroll->alreadyLogin(); ?>
                
            </form>
        </div>
    </div>
</body>
</html>