<?php
require_once('../class.php');
$sessionData = $payroll->getSessionSecretaryData();
$payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname']);
$fullname = $sessionData['fullname'];
$access = $sessionData['access'];
$id = $sessionData['id'];
$log=$_GET['logid'];
$payroll->updateSalary($id,$fullname);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .view-modal {
    height: 100vh;
    width: 100vw;
    background-color: #00000045;
    position: absolute;
    top: 0; left: 0;
    display: none;
}
.sidebar{
        float: left;
        width: 20%;
    }
.deductions{
        position:absolute;
        right:600px;
        top: 110px;
    }
.manual_payroll_update{
    float: left;
    width: 40%;
    padding: 0 20px;
    overflow: hidden;
    }
.manual_payroll_update.earnings{
        left:20px;
    }
.manual_payroll {
        width: 80%;
        padding: 0;
    }

#show-modal {
    display: block !important;
}</style>
</head>
<body>
<a href="manualpayroll.php">BACK</a>
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
                    <li class="li__records active">
                        <a href="secdashboard.php" class="active">ATTENDANCE</a>
                    </li>
                    <li class="li__records active">
                        <a href="employeelist.php" class="active">EMPLOYEES</a>
                        <ul>
                            <li><a href="employeelist.php">List of Employees</a></li>
                            <li><a href="empschedule.php">Schedules</a></li>
                            <li><a href="deductions.php">Deductions</a></li>
                            <li><a href="violations.php">Violations</a></li>
                        </ul>
                    </li>
                    <li class="li__report" class ="active">
                        <a href="">Payroll</a>
                        <ul>
                            <li><a href="manualpayroll.php">Manual</a></li>
                            <li><a href="automaticpayroll.php">Automatic</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="sidebar__logout">
                <div class="li li__logout"><a href="../logout.php">LOGOUT</a></div>
            </div>
            </div>
            <div class="user-info">
            <div class="user-profile"></div>
        </div>
<div class="manual_payroll_update">
                <h1>Edit</h1>
                    <form method="post">
                    <label for="empid">Employee ID</label><br/>
                    <?php $sql ="SELECT * FROM emp_info INNER JOIN generated_salary ON emp_info.empId = generated_salary.emp_id WHERE generated_salary.log = ?;";$stmt = $payroll->con()->prepare($sql); $stmt->execute([$log]); $rows = $stmt->fetch(); echo "<select id= select-state name=empid placeholder= Pick a state...><option value=$rows->empId> $rows->empId $rows->firstname $rows->lastname</option></select>";?><br/>
                    <label for="location">Location</label><br/>
                    <input type="text" name="location" id="location" value="<?php echo $rows->location;?>"><br/>
                    <label for="regholiday">Regular Holiday-Hour/s</label><br/>
                    <input type="number" name="regholiday" id="regholiday" value="<?php echo $rows->regular_holiday;?>"><br/>
                    <label for="specialholiday">Special Holiday-Hour/s</label><br/>
                    <input type="number" name="specialholiday" id="specialholiday" value="<?php echo $rows->special_holiday;?>"><br/>
                    <label for="thirteenmonth">13month</label><br/>
                    <input type="number" name="thirteenmonth" id="thirteenmonth" value="<?php echo $rows->thirteenmonth;?>"><br/>
                    <label for="rate">Rate/Hour</label><br/>
                    <input type="number" name="rate" id="rate" step="any" value="<?php echo $rows->rate_hour;?>"></br>
                    <label for="noofdayswork"># of days work</label>&emsp;<label for="hrsduty">Duty</label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br/>
                    <input type="number" name="noofdayswork" id="noofdayswork" style="width: 7em" value="<?php echo $rows->no_of_work;?>">&emsp;<select name="hrsduty" id="hrsduty" style="width: 7em">
                    <option value="8">8 hours</option><option value="12">12 hours</option></select><br/><br/><br/>
                    <button type="submit" name="edit">Update</button>
                </div>
                <div class = "deductions">
                    Deductions<br/>
                    <label for="daylate">No. of late</label>&emsp;&emsp;<label for="hrslate">total hour/s</label><br/>
                    <input type="number" name="daylate" id="daylate" style="width: 5em" value="<?php echo $rows->day_late;?>">&emsp;&emsp;<input type="number" name="hrslate" id="hrslate" style="width: 5em" value="<?php echo $rows->hrs_late;?>"><br/>
                    <label for="sss">SSS</label><br/>
                    <input type="number" name="sss" id="sss" value="<?php echo $rows->sss;?>"><br/>
                    <label for="cashbond">Cash Bond</label><br/>
                    <input type="number" name="cashbond" id="cashbond" value="<?php echo $rows->cashbond;?>"><br/>
                    <label for="cvale">Vale</label></br>
                    <input type="number" name="cvale" id="cvale" value="<?php echo $rows->vale;?>"><br/>
                </div>
                    </form>
        </div>
        </div>
</body>
</html>