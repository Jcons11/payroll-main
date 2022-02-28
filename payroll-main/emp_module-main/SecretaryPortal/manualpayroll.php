<?php
require_once('../class.php');
$sessionData = $payroll->getSessionSecretaryData();
$payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname']);
$fullname = $sessionData['fullname'];
$access = $sessionData['access'];
$id = $sessionData['id'];
$payroll->generateSalary($id,$fullname);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Payroll - Secretary</title>
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
               <a href="UserProfile/userprofile_editdetails.html">[ Profile ]</a>  
               <p>Profile Name</p>
               <div class="user-profile">
               </div>   
          </div>

          <div class="manual-payroll_header">
               <h2>Deductions</h2>
          </div>

          <div class="payroll-detail_header">
              Details
          </div>

          <div class="payroll-details">
                <div class="payroll-details__form">
                    <form action="" method="post">
                        <div class="detail">
                            <label for="">Employee ID :</label><br>
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">Location :</label><br>
                            <input type="text">
                            <p>Must not be blank</p>
                        </div>

                        <div class="detail">
                            <label for="">Regular Holiday :</label><br>
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">Special Holiday :</label><br>
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">3th Month Pay :</label><br>
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">Rate Hour :</label><br>   
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">No. of Days work :</label><br>   
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>
                    </form>
                </div>
          </div>

          <div class="payroll-deductions_header">
              Deductions
          </div>

          <div class="payroll-deductions">
            <div class="payroll-deductions__form">
                <div class="detail">
                    <label for="">No. of late :</label><br>
                    <input type="number">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">SSS :</label><br>
                    <input type="number">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">Pag-ibig :</label><br>
                    <input type="text" class="location">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">PhilHealth :</label><br>
                    <input type="number" class="location">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">Cash Bond :</label><br>
                    <input type="number" class="location">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">Vale :</label><br>
                    <input type="number" class="location">
                    <p>Numeric characters only</p>
                </div>
            </div>
          </div>

          <div class="netpay">
            <div class="detail">
                <label for="">NET PAY :</label><br>
                <input type="text">
            </div>

            <button type="submit" name="generate">
                <a href="">Generate</a>
            </button> 
          </div>

          <div class="manual-generated-table">
              <div class="manual-generated-table__header">
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
     </div>
</body>
</html>