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
    <title>Scan QR</title>
</head>
<body>
    <div class="main-container">
        <?php 
            $payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname']);
        ?>
        <a href="../logout.php">Logout</a>
    </div>
</body>
</html>