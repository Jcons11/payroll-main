<?php
require_once('../class.php');
$sessionData = $payroll->getSessionSecretaryData();
$payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname']);
$fullname = $sessionData['fullname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
    <div class="main-container">
        <!--SIDENAV START-->
        <div class="sidebar">
            <div class="sidebar__logo">
                <div class="logo"></div>
                <h3>JDTV</h3>
            </div>
            <nav>
                <ul>
                    <li class="li__records">
                        <a href="#" class="">DASHBOARD</a>
                    </li>
                    <li class="li__activities">
                        <a href="../SecretaryPortal/secdashboard.php">Attendance</a>
                    </li>

                    <li class="li__user active">
                        <a href="../SecretaryPortal/" class="active">Employee</a>
                        <ul>
                            <li><a href="../SecretaryPortal/employeelist.php" class="active">List of Employees</a></li>
                            <li><a href="../SecretaryPortal/empschedule.php">Schedules</a></li>
                            <li><a href="../SecretaryPortal/deductions.php">Deductions</a></li>     
                        </ul>
                    </li>

                    <li class="li__report" class ="active">
                        <a href="">Payroll</a>
                        <ul>
                            <li><a href="../SecretaryPortal/manualpayroll.php">Manual</a></li>
                            <li><a href="../SecretaryPortal/automaticpayroll.php">Automatic</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="sidebar__logout">
                <div class="li li__logout"><a href="#">LOGOUT</a></div>
            </div>
        </div>

        <div class="page-info-head">
            Secretary
        </div>

        <div class="user-info">
            <p>Profile Name</p>
            <div class="user-profile">
            </div>
        </div>

        <div class="attendance_monitoring">
            <div class="attendance_monitoring__header">
                <h1>List of Employees</h1>
                <button class="btn_primary">
                    <span class="material-icons"> description</span>
                    <a href="#">Print</a>
                </button>
                <div class="attendance_monitoring__header__svg">
                    <object data="SVG_modified/search.svg" type=""></object>
                </div>
                <input type="search" placeholder="Search">
            </div>

            <div class="card">
                <div class="card__content">
                    <table>
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                                if(isset($_POST['print'])){

                                } 
                                else if(isset($_POST['empsearch'])){
                                    $payroll->searchEmployee();
                                }
                                else {
                                    $payroll->employeeList(); 
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>