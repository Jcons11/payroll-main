<?php
require_once('../class.php');
$id=$_GET['logid'];
$payroll->deleteautomatedsalary($id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Cash Advance</title>
</head>
<body>
    <form method="post">
        <h3>Are you sure you want to delete this Cash Advance?</h3>
        <button type="submit" name="cancel">Cancel</button>
        <button type="submit" name="deleteauto">Delete</button>
    </form>
</body>
</html>