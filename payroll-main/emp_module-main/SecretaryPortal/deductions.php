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
    <title>Deductions</title>
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
                    <li class="li__records">
                        <a href="../SecretaryPortal/secdashboard.php">Attendance</a>
                    </li>

                    <li class="li__records active">
                        <a href="../SecretaryPortal/" class="active">Employee</a>
                        <ul>
                            <li><a href="../SecretaryPortal/employeelist.php">List of Employees</a></li>
                            <li><a href="../SecretaryPortal/empschedule.php">Schedules</a></li>
                            <li><a href="../SecretaryPortal/deductions.php" class="active">Deductions</a></li>     
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

        <div class="emp-deductions">
               <div class="emp-deductions__header">
                    <h2>Generate Deductions</h2>
               </div>

               <div class="emp-deductions__form">
                    <form action="" method="post">
                         <div class="detail">
                              <label for="">Deductions :</label> <br>
                              <!-- this is a sub of emp id php sql -->
                              <?php $sql ="SELECT empId,firstname,lastname FROM emp_info;";$stmt = $payroll->con()->prepare($sql); $stmt->execute(); $row = $stmt->fetchall(); echo "<select id= select-state name=empid placeholder= Pick a state...>"; foreach($row as $rows){echo "<option value=$rows->empId> $rows->empId $rows->firstname $rows->lastname</option>";}; ?><?php echo "</select>"; ?>
                              <!-- php sql for duty here -->
                         </div>

                         <div class="detail">
                              <label for="">Position :</label> <br>
                              <!-- this is a sub of emp id php sql -->
                              <?php $sql ="SELECT empId,firstname,lastname FROM emp_info;";$stmt = $payroll->con()->prepare($sql); $stmt->execute(); $row = $stmt->fetchall(); echo "<select id= select-state name=empid placeholder= Pick a state...>"; foreach($row as $rows){echo "<option value=$rows->empId> $rows->empId $rows->firstname $rows->lastname</option>";}; ?><?php echo "</select>"; ?>
                              <!-- php sql for position here -->
                         </div>

                         <div class="detail">
                              <label for="">Duty :</label> <br>
                              <!-- this is a sub of emp id php sql -->
                              <?php $sql ="SELECT empId,firstname,lastname FROM emp_info;";$stmt = $payroll->con()->prepare($sql); $stmt->execute(); $row = $stmt->fetchall(); echo "<select id= select-state name=empid placeholder= Pick a state...>"; foreach($row as $rows){echo "<option value=$rows->empId> $rows->empId $rows->firstname $rows->lastname</option>";}; ?><?php echo "</select>"; ?>
                              <!-- php sql for duty here -->
                         </div>

                         <button type="submit">
                              <a href="#">Generate</a>
                         </button>
                    </form>
               </div>
          </div>

          <div class="cashadvance">
               <div class="cashadvance__header">
                    <h2>Cash Advance</h2>
               </div>
               <form action="" method="post">
                    <div class="cashadvance__form">
                         <div class="detail">
                              <label for="">Employee ID :</label>
                              <?php $sql ="SELECT empId,firstname,lastname FROM emp_info;";$stmt = $payroll->con()->prepare($sql); $stmt->execute(); $row = $stmt->fetchall(); echo "<select id= select-state name=empid placeholder= Pick a state...>"; foreach($row as $rows){echo "<option value=$rows->empId> $rows->empId $rows->firstname $rows->lastname</option>";}; ?><?php echo "</select>"; ?>
                         </div>

                         <div class="detail">
                              <label for="">Amount :</label>
                              <input type="number" placeholder="Php">
                         </div>
                    </div>

                    <button type="submit">
                         <a href="#">Generate</a>
                    </button>
               </form>
          </div>

          <div class="manual-generated-salaries">
              <div class="manual-generated-salaries__header">
                  <h1>Generated Salaries</h1>
                  <div class="searchbar">
                      
                    <span class="material-icons">
                        search
                        </span>
                    <input type="text" placeholder="Search">
                  </div>
              </div>
              
              <div class="manual-generated-salaries__content">
                    <table>
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
            
                        <tbody>
                              <?php $payroll->displayGeneratedSalary();?>
                        </tbody>
                    </table>
              </div>
          </div>

          <div class="cash-advance-generated">
              <div class="cash-advance-generated__header">
                  <h1>Cash Advance</h1>
                  <div class="searchbar">
                      
                    <span class="material-icons">
                        search
                        </span>
                    <input type="text" placeholder="Search">
                  </div>
              </div>
              
              <div class="cash-advance-generated__content">
                    <table>
                        <thead>
                            <tr>
                                 <th>Name</th>    
                                 <th>Date</th>    
                                 <th>Amount</th>    
                                 <th>Action</th>    
                            </tr>
                        </thead>
            
                        <tbody>
                              <!-- php here for cash advance table -->
                        </tbody>
                    </table>
              </div>
          </div>
    </div>
</body>


