<?php
require_once('../class.php');
$id=$_GET['logid'];
$payroll->releaseSalary();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Release Salary</title>
</head>
<body>
    <form method="post">
        <h3>Are you sure you want to release this salary?</h3>
        <button type="submit" name="cancel">Cancel</button>
        <button type="submit" name="release">Release</button>
    </form>
</body>
</html>