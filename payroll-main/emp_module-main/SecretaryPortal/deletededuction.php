<?php
require_once('../class.php');
$id=$_GET['logid'];
$payroll->deletededuction($id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Deduction</title>
</head>
<body>
    <form method="post">
        <h3>Are you sure you want to delete this deduction?</h3>
        <button type="submit" name="cancel">Cancel</button>
        <button type="submit" name="deletededuction">Delete</button>
    </form>
</body>
</html>