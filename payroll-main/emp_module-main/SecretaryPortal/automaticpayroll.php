<?php
require_once('../class.php');
$sessionData = $payroll->getSessionSecretaryData();
$payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname']);
$fullname = $sessionData['fullname'];
$access = $sessionData['access'];
$id = $sessionData['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatic Payroll</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
    <div class="main-container">
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
                    <li class="li__records">
                        <a href="../SecretaryPortal/secdashboard.php">Attendance</a>
                    </li>

                    <li class="li__records">
                        <a href="../SecretaryPortal/employeelist.php">Employee</a>
                        <ul>
                            <li><a href="../SecretaryPortal/employeelist.php">List of Employees</a></li>
                            <li><a href="../SecretaryPortal/empschedule.php">Schedules</a></li>
                            <li><a href="../SecretaryPortal/deductions.php">Deductions</a></li>     
                        </ul>
                    </li>

                    <li class="li__report active">
                        <a href="" class="active">Payroll</a>
                        <ul>
                            <li><a href="../SecretaryPortal/manualpayroll.php">Manual</a></li>
                            <li><a href="#" class="active">Automatic</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="sidebar__logout">
                <div class="li li__logout"><a href="#">LOGOUT</a></div>
            </div>
        </div>

        <div class="user-info">
            <p>Profile Name</p>
            <div class="user-profile">
            </div>
        </div>

        <div class="page-info-head">
            Secretary
        </div>

        <div class="automatic-empid">
                <div class="automatic-empid__form">
                    <form action="" method="post">
                        <div class="detail">
                            <label for="">Employee ID :</label><br>
                            <?php $sql ="SELECT empId,firstname,lastname FROM emp_info;";$stmt = $payroll->con()->prepare($sql); $stmt->execute(); $row = $stmt->fetchall();
                            echo "<select id= empid name=empid placeholder= Pick a state...>"; 
                            foreach($row as $rows)
                            {echo "<option value=$rows->empId> $rows->empId $rows->firstname $rows->lastname</option>";};
                            ?>
                            <?php echo "</select>";?>
                            <div class="detail">
                                <button type="submit" name="generateautomatic">
                                    <a href="">Generate</a>
                                </button>
                            </div>
                        </div>
                    </form>
               </div>
         </div> 

        <div class="auto-generated-salaries">
            <div class="auto-generated-salaries__header">
                <h1>Generated Salaries</h1>
                <div class="searchbar">
                    
                  <span class="material-icons">
                      search
                      </span>
                  <input type="text" placeholder="Search">
                </div>
            </div>
            
            <div class="auto-generated-salaries__content">
                  <table>
                      <thead>
                          <tr>
                              <th>Employee ID</th>
                              <th>Location</th>
                              <th>Starting Date</th>
                              <th>End Date</th>
                              <th>Created</th>
                              <th>Action</th>
                          </tr>
                      </thead>
          
                      <tbody>
                          <!--insert php data for table here inside of php tag-->
                      <?php 
                        $payroll->AutomaticGenerateSalary($fullname,$id);
                        $payroll->displayAutomaticGeneratedSalary();?>
                      </tbody>
                  </table>
            </div>
          </div>
    </div>
</body>
</html>
                