<?php
// required to para makapag send ng email
use PHPMailer\PHPMailer\PHPMailer;
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

Class Payroll
{
    private $username = "root";
    private $password = "";

    private $dns = "mysql:host=localhost;dbname=newpayroll";
    protected $pdo;


    public function con()
    {
        $this->pdo = new PDO($this->dns, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $this->pdo;
    }


    // used to set timezone and get date and time
    public function getDateTime()
    {
        date_default_timezone_set('Asia/Manila'); // set default timezone to manila
        $curr_date = date("Y/m/d"); // date
        $curr_time = date("h:i:s A"); // time

        // return date and time in array
        $_SESSION['datetime'] = array('time' => $curr_time, 'date' => $curr_date);
        return $_SESSION['datetime'];
    }



    public function login()
    {
        // set 5 attempts
        session_start();
        if(!isset($_SESSION['attempts'])){
            $_SESSION['attempts'] = 5;
        }

        // create email and password using session
        if(!isset($_SESSION['reservedEmail']) && !isset($_SESSION['reservedPassword'])){
            $_SESSION['reservedEmail'] = "";
            $_SESSION['reservedPassword'] = "";
        }


        // if attempts hits 2
        if($_SESSION['attempts'] == 2){
            echo 'Your credentials has been sent to your email<br/>';
            
            echo 'Reserved Email: '.$_SESSION['reservedEmail'].'<br/>
                  Reserved Password: '.$_SESSION['reservedPassword'];
            
            // send user credentials
            $this->sendEmail($_SESSION['reservedEmail'], $_SESSION['reservedPassword']);
            // echo 'No of attempts: '.$_SESSION['attempts'];
            $_SESSION['attempts'] -= 1; // decrease 1 attempt to current attempts

        } else if($_SESSION['attempts'] == 0){ // if attempts bring down to 0
            
            // select username na gumamit ng 5 attempts
            $reservedEmail = $_SESSION['reservedEmail'];
            $setTimerSql = "SELECT * FROM super_admin WHERE username = ?";
            $stmtTimer = $this->con()->prepare($setTimerSql);
            $stmtTimer->execute([$reservedEmail]);
            $usersTimer = $stmtTimer->fetch();
            $countRowTimer = $stmtTimer->rowCount();

            // kapag may nadetect na ganong username
            if($countRowTimer > 0){
                // get id of that username
                $userId = $usersTimer->id;
                $userAccess = $usersTimer->access;
                $accessSuspended = "suspended";
                

                // update column timer set value to DATENOW - 6HRS
                
                $updateTimerSql = "UPDATE `super_admin` 
                                   SET `timer` = NOW() + INTERVAL 6 HOUR, 
                                       `access` = '$accessSuspended'
                                   WHERE `id` = $userId;
                
                                   SET GLOBAL event_scheduler='ON';
                                   CREATE EVENT one_time_event
                                   ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 6 HOUR
                                   ON COMPLETION NOT PRESERVE
                                   DO
                                      UPDATE `super_admin` 
                                      SET `timer` = NULL, 
                                          `access` = '$userAccess' 
                                      WHERE `id` = $userId;
                                  ";
                $updateTimerStmt = $this->con()->prepare($updateTimerSql);
                $updateTimerStmt->execute();
                $updateCountRow = $updateTimerStmt->rowCount();

                // checking if the column was updated already
                if($updateCountRow > 0){
                    echo 'System has been locked for 6 hrs';
                    session_destroy(); // destroy all the sessions
                } else {
                    echo 'There was something wrong in the codes';
                    session_destroy();
                }
            } else {
                $_SESSION['message'] = 'Username does not exist';
            }

        } else {
            // if user hit login button
            if(isset($_POST['login'])){

                // get input data
                $username = $_POST['username'];
                $password = md5($_POST['password']);
    
                // if username and password are empty
                if(empty($username) && empty($password)){
                    $_SESSION['message'] = 'All input fields are required to login.';
                } else {
                    // check if email is exist using a function
                    $checkEmailArray = $this->checkEmailExist($username); // returns an array(true, cho@gmail.com)
                    $passwordArray = $checkEmailArray[1]; // password ni cho

                    // kapag ang unang array ay nag true
                    if($checkEmailArray[0]){

                        $suspendedAccess = 'suspended';
                        

                        // find account that matches the username and password
                        $sql = "SELECT * FROM super_admin WHERE username = ? AND password = ?";
                        $stmt = $this->con()->prepare($sql);
                        $stmt->execute([$username, $password]);
                        $users = $stmt->fetch();
                        $countRow = $stmt->rowCount();
        
                        // if account exists
                        if($countRow > 0){

                            if($users->access != $suspendedAccess){
                                $fullname = $users->firstname." ".$users->lastname; // create fullname
                                $action = "login"; 
                                    
                                // set timezone and get date and time
                                $datetime = $this->getDateTime(); 
                                $time = $datetime['time'];
                                $date = $datetime['date'];
                
                                // insert mo sa activity log ni admin
                                $actLogSql = "INSERT INTO admin_log(`name`, 
                                                                    `action`,
                                                                    `time`,
                                                                    `date`
                                                                    )
                                            VALUES(?, ?, ?, ?)";
                                $actLogStmt = $this->con()->prepare($actLogSql);
                                $actLogStmt->execute([$fullname, $action, $time, $date]);
                
                                // create user details using session
                                session_start();
                                $_SESSION['adminDetails'] = array('fullname' => $fullname,
                                                                  'access' => $users->access,
                                                                  'id' => $users->id
                                                                  );
                                header('Location: dashboard.php'); // redirect to dashboard.php
                                return $_SESSION['adminDetails']; // after calling the function, return session
                            } else {
                                $dateExpiredArray = $this->formatDateLocked($users->timer);
                                $dateExpired = implode(" ", $dateExpiredArray);
                                
                                echo 'Your account has been locked until</br>'.
                                     'Date: '.$dateExpired;
                            } 
                        } else {

                            $sqlCheckAccess = "SELECT * FROM super_admin WHERE username = ?";
                            $stmtCheckAccess = $this->con()->prepare($sqlCheckAccess);
                            $stmtCheckAccess->execute([$username]);
                            $usersCheckAccess = $stmtCheckAccess->fetch();
                            $countCheckAccess = $stmtCheckAccess->rowCount();

                            if($countCheckAccess > 0){
                                if($usersCheckAccess->access == $suspendedAccess){
                                    
                                    $dateExpiredArray2 = $this->formatDateLocked($usersCheckAccess->timer);
                                    $dateExpired2 = implode(" ", $dateExpiredArray2);
                                    
                                    echo 'Your account has been locked until</br>'.
                                        'Date: '.$dateExpired2;
                                } else {
                                    $_SESSION['message'] = "Username and password are not matched <br/>";
                                    // echo 'No of attempts: '.$_SESSION['attempts'];
                                    $_SESSION['attempts'] -= 1; // decrease 1 attempt to current attempts
                                    $_SESSION['reservedEmail'] = $username; // blank to kanina, nagkaron na ng laman
                                    $_SESSION['reservedPassword'] = $passwordArray; // blank to kanina, nagkaron na ng laman
                                }
                            }
                        }
                    } else {
                        // echo 'Your email is not exist in our system';
                        
                        // check if email is exist using a function
                            $checkEmailArray = $this->checkEmailExistEmployee($username); // returns an array(true, cho@gmail.com)
                            $passwordArray = $checkEmailArray[1]; // password ni cho

                            // kapag ang unang array ay nag true
                            if($checkEmailArray[0]) {

                                $suspendedAccess = 'suspended';
                                $position = 'Officer in Chief';
                                

                                // find account that matches the username and password
                                $sql = "SELECT * FROM emp_info WHERE email = ? AND password = ? AND position = ?";
                                $stmt = $this->con()->prepare($sql);
                                $stmt->execute([$username, $password, $position]);
                                $users = $stmt->fetch();
                                $countRow = $stmt->rowCount();
                
                                // if account exists
                                if($countRow > 0){

                                    if($users->access != $suspendedAccess){
                                        $fullname = $users->firstname ." ". $users->lastname; // create fullname
                                        // $action = "login"; 
                                            
                                        // // set timezone and get date and time
                                        // $datetime = $this->getDateTime(); 
                                        // $time = $datetime['time'];
                                        // $date = $datetime['date'];
                        
                                        // // insert mo sa activity log ni admin
                                        // $actLogSql = "INSERT INTO admin_log(`name`, 
                                        //                                     `action`,
                                        //                                     `time`,
                                        //                                     `date`
                                        //                                     )
                                        //             VALUES(?, ?, ?, ?)";
                                        // $actLogStmt = $this->con()->prepare($actLogSql);
                                        // $actLogStmt->execute([$fullname, $action, $time, $date]);
                        
                                        // // create user details using session
                                        session_start();
                                        $_SESSION['OICDetails'] = array('fullname' => $fullname,
                                                                          'access' => $users->access,
                                                                          'position' => $users->position,
                                                                          'id' => $users->id,
                                                                          'empId' => $users->empId,
                                                                          'scheduleTimeIn' => $users->scheduleTimeIn,
                                                                          'scheduleTimeOut' => $users->scheduleTimeOut,
                                                                          'datetimeIn' => $users->datetimeIn
                                                                          );
                                        header('Location: employee/OIC.php'); // redirect to dashboard.php
                                        return $_SESSION['OICDetails']; // after calling the function, return session
                                    } else {
                                        $dateExpiredArray = $this->formatDateLocked($users->timer);
                                        $dateExpired = implode(" ", $dateExpiredArray);
                                        
                                        echo 'Your account has been locked until</br>'.
                                            'Date: '.$dateExpired;
                                    } 
                                } else {

                                    $sqlCheckAccess = "SELECT * FROM emp_info WHERE email = ?";
                                    $stmtCheckAccess = $this->con()->prepare($sqlCheckAccess);
                                    $stmtCheckAccess->execute([$username]);
                                    $usersCheckAccess = $stmtCheckAccess->fetch();
                                    $countCheckAccess = $stmtCheckAccess->rowCount();

                                    if($countCheckAccess > 0){
                                        if($usersCheckAccess->access == $suspendedAccess){
                                            
                                            $dateExpiredArray2 = $this->formatDateLocked($usersCheckAccess->timer);
                                            $dateExpired2 = implode(" ", $dateExpiredArray2);
                                            
                                            echo 'Your account has been locked until</br>'.
                                                'Date: '.$dateExpired2;
                                        } else {
                                            $_SESSION['message'] = "Username and password are not matched <br/>";
                                            // echo 'No of attempts: '.$_SESSION['attempts'];
                                            $_SESSION['attempts'] -= 1; // decrease 1 attempt to current attempts
                                            $_SESSION['reservedEmail'] = $username; // blank to kanina, nagkaron na ng laman
                                            $_SESSION['reservedPassword'] = $passwordArray; // blank to kanina, nagkaron na ng laman
                                        }
                                    }
                                }
                    } else {
                        // echo 'Your email is not exist in our system';
                        
                        // check if email is exist using a function
                        $checkEmailArray = $this->checkEmailExistSecretary($username); // returns an array(true, cho@gmail.com)
                        $passwordArray = $checkEmailArray[1]; // password ni cho

                        // kapag ang unang array ay nag true
                        if($checkEmailArray[0]) {

                            $suspendedAccess = 'suspended';
                            

                            // find account that matches the username and password
                            $sql = "SELECT * FROM secretary WHERE email = ? AND password = ?";
                            $stmt = $this->con()->prepare($sql);
                            $stmt->execute([$username, $password]);
                            $users = $stmt->fetch();
                            $countRow = $stmt->rowCount();
            
                            // if account exists
                            if($countRow > 0){

                                if($users->access != $suspendedAccess){
                                    $id = $users->id;
                                    $fullname = $users->firstname ." ". $users->lastname; // create fullname
                                    $action = "login"; 
                                        
                                    // set timezone and get date and time
                                    $datetime = $this->getDateTime(); 
                                    $time = $datetime['time'];
                                    $date = $datetime['date'];
                    
                                    // insert mo sa activity log ni admin
                                    $actLogSql = "INSERT INTO secretary_log(`sec_id`,`name`, 
                                                                        `action`,
                                                                        `time`,
                                                                        `date`
                                                                        )
                                                VALUES(?, ?, ?, ?, ?)";
                                    $actLogStmt = $this->con()->prepare($actLogSql);
                                    $actLogStmt->execute([$id,$fullname, $action, $time, $date]);
                    
                                    // // create user details using session
                                    session_start();
                                    $_SESSION['SecretaryDetails'] = array('fullname' => $fullname,
                                                                        'access' => $users->access,
                                                                        'position' => $users->position,
                                                                        'id' => $users->id,
                                                                        'empId' => $users->empId,
                                                                        'scheduleTimeIn' => $users->scheduleTimeIn,
                                                                        'scheduleTimeOut' => $users->scheduleTimeOut,
                                                                        'datetimeIn' => $users->datetimeIn
                                                                        );
                                    header('Location: SecretaryPortal/secdashboard.php'); // redirect to dashboard.php
                                    return $_SESSION['SecretaryDetails']; // after calling the function, return session
                                } else {
                                    $dateExpiredArray = $this->formatDateLocked($users->timer);
                                    $dateExpired = implode(" ", $dateExpiredArray);
                                    
                                    echo 'Your account has been locked until</br>'.
                                        'Date: '.$dateExpired;
                                } 
                            } else {

                                $sqlCheckAccess = "SELECT * FROM secretary WHERE email = ?";
                                $stmtCheckAccess = $this->con()->prepare($sqlCheckAccess);
                                $stmtCheckAccess->execute([$username]);
                                $usersCheckAccess = $stmtCheckAccess->fetch();
                                $countCheckAccess = $stmtCheckAccess->rowCount();

                                if($countCheckAccess > 0){
                                    if($usersCheckAccess->access == $suspendedAccess){
                                        
                                        $dateExpiredArray2 = $this->formatDateLocked($usersCheckAccess->timer);
                                        $dateExpired2 = implode(" ", $dateExpiredArray2);
                                        
                                        echo 'Your account has been locked until</br>'.
                                            'Date: '.$dateExpired2;
                                    } else {
                                        $_SESSION['message'] = "Username and password are not matched <br/>";
                                        // echo 'No of attempts: '.$_SESSION['attempts'];
                                        $_SESSION['attempts'] -= 1; // decrease 1 attempt to current attempts
                                        $_SESSION['reservedEmail'] = $username; // blank to kanina, nagkaron na ng laman
                                        $_SESSION['reservedPassword'] = $passwordArray; // blank to kanina, nagkaron na ng laman
                                    }
                                }
                            }
                        } else {
                            $_SESSION['message'] = 'Your email does not exist in our system';
                        }
                    }
                }
            }
        }
        }
    }


    
    public function formatDateLocked($date)
    {
        $dateArray = explode(" ", $date);

        $dateExpired = date("F j Y", strtotime($dateArray[0])); // date
        $timeExpired = date("h:i:s A", strtotime($dateArray[1])); // time
        return array($dateExpired, $timeExpired);
    }
    

    public function checkAccountTimer($id)
    {
        $sql = "SELECT * FROM super_admin WHERE id = ?";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$id]);
        $users = $stmt->fetch();
        $countRow = $stmt->rowCount();

        if($countRow > 0){
            if($users->timer != NULL){
                return true;
            } else {
                return false;
            }
        }

    }


    public function checkEmailExist($email)
    {
        // find email exist in the database
        $sql = "SELECT * FROM super_admin WHERE username = ?";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$email]);
        $users = $stmt->fetch();
        $countRow = $stmt->rowCount();

        // kapag may nadetect
        if($countRow > 0){
            return array(true, $users->password); // yung kaakibat na password, return mo
        } else {
            return array(false, ''); // pag walang nakita, return false and null
        }
    }

    
    public function checkEmailExistEmployee($email)
    {
        // find email exist in the database
        $sql = "SELECT * FROM emp_info WHERE email = ?";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$email]);
        $users = $stmt->fetch();
        $countRow = $stmt->rowCount();

        // kapag may nadetect
        if($countRow > 0){
            return array(true, $users->password); // yung kaakibat na password, return mo
        } else {
            return array(false, ''); // pag walang nakita, return false and null
        }
    }

    public function checkEmailExistSecretary($email)
    {
        // find email exist in the database
        $sql = "SELECT * FROM secretary WHERE email = ?";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$email]);
        $users = $stmt->fetch();
        $countRow = $stmt->rowCount();

        // kapag may nadetect
        if($countRow > 0){
            return array(true, $users->password); // yung kaakibat na password, return mo
        } else {
            return array(false, ''); // pag walang nakita, return false and null
        }
    }

    public function sendEmail($email, $password)
    {
        
        $name = 'JTDV Incorporation';
        $subject = 'subject kunwari';
        $body = "Credentials
                 Your username: $email <br/>
                 Your password: $password
                ";

        if(!empty($email)){

            $mail = new PHPMailer();

            // smtp settings
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "DammiDoe123@gmail.com";  // gmail address
            $mail->Password = "DammiDoe123123";         // gmail password
            $mail->Port = 465;
            $mail->SMTPSecure = "ssl";

            // email settings
            $mail->isHTML(true);
            $mail->setFrom($email, $name);              // Katabi ng user image
            $mail->addAddress($email);                  // gmail address ng pagsesendan
            $mail->Subject = ("$email ($subject)");     // headline
            $mail->Body = $body;                        // textarea

            if($mail->send()){
                $status = "success";
                $response = "Email is sent!";
                echo '<br/>'.$status."<br/>".$response;
            } else {
                $status = "failed";
                $response = "Something is wrong: <br/>". $mail->ErrorInfo;
                echo '<br/>'.$status."<br/>".$response;
            }
        } 
    }

    public function logout()
    {
        $this->pdo = null;
        session_start();
        unset($_SESSION['adminDetails']);
        session_destroy();
        header('Location: login.php');
    }

    // get login session
    public function getSessionData()
    {
        session_start();
        if($_SESSION['adminDetails']){
            return $_SESSION['adminDetails'];
        }

    }

    // get login session: Employee: OIC
    public function getSessionOICData()
    {
        session_start();
        if($_SESSION['OICDetails']){
            return $_SESSION['OICDetails'];
        }
    }

        // get login session: Secretary
    public function getSessionSecretaryData()
    {
        session_start();
        if($_SESSION['SecretaryDetails']){
            return $_SESSION['SecretaryDetails'];
        }
    }

    public function verifyUserAccess($access, $fullname)
    {
        $message = 'You are not allowed to enter the system';

        if($access == 'user'){
            header("Location: login.php?message=$message");
        } else if($access == 'super administrator'){
            echo 'Welcome '.$fullname;
        } else if ($access == 'secretary') {
            echo ''.$fullname.' ('.$access.')';
        } else if ($access == 'Employee') {
            $position = $_SESSION['OICDetails']['position'];
            $scheduleTimeIn = $_SESSION['OICDetails']['scheduleTimeIn'];
            $scheduleTimeOut = $_SESSION['OICDetails']['scheduleTimeOut'];

            echo 'Welcome '.$fullname.' ('.$access.': '.$position.') (';
            echo $scheduleTimeIn. " - " .$scheduleTimeOut.") ";
        }
        else {
            header("Location: login.php?message=$message");
        }
    }

    // for secretary functionality in admin
    public function addSecretary($id, $fullnameAdmin)
    {
        if(isset($_POST['addsecretary'])){
            $fullname = $_POST['fullname'];
            $cpnumber = $_POST['cpnumber'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $address = $_POST['address'];
            $access = "secretary";
            // generated password
            $password = $this->generatedPassword($fullname);
            $isDeleted = FALSE;

            $timer = NULL;

            if(empty($fullname) &&
               empty($email) &&
               empty($gender) &&
               empty($address) &&
               empty($password) &&
               empty($isDeleted)
            ){
                echo 'All input fields are required!';
            } else {

                // check email if existing
                
                if($this->checkSecEmailExist($email)){
                    echo 'Email is already exist!';
                } else {

                    // set timezone and get date and time
                    $datetime = $this->getDateTime(); 
                    $time = $datetime['time'];
                    $date = $datetime['date'];

                    $sql = "INSERT INTO secretary(fullname, 
                                                  gender, 
                                                  cpnumber, 
                                                  address, 
                                                  email, 
                                                  password,
                                                  timer, 
                                                  admin_id,
                                                  access,
                                                  isDeleted
                                                  )
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->con()->prepare($sql);
                    $stmt->execute([$fullname, $gender, $cpnumber, $address, $email, $password[0], $timer, $id, $access, $isDeleted]);
                    $users = $stmt->fetch();
                    $countRow = $stmt->rowCount();
                    

                    if($countRow > 0){
                        echo 'A new date was added';


                        $this->sendEmail($email, $password[1]);

                        $action = "Add Secretary";

                        $sqlAdminLog = "INSERT INTO admin_log(name, action, time, date)
                                        VALUES(?, ?, ?, ?)";
                        $stmtAdminLog = $this->con()->prepare($sqlAdminLog);
                        $stmtAdminLog->execute([$fullnameAdmin, $action, $time, $date]);
                        $countRowAdminLog = $stmtAdminLog->rowCount();

                        if($countRowAdminLog > 0){
                            echo 'pumasok na sa act log';
                        } else {
                            echo 'di pumasok sa act log';
                        }

                    } else {
                        echo 'Error in adding secretary!';
                    }
                }
            }
        }
    }

    public function generatedPassword($fullname)
    {
        $keyword = "%15@!#Fa4%#@kE";
        $generatedPassword = md5($fullname.$keyword);
        return array($generatedPassword, $fullname.$keyword);
    }

    // for secretary table only
    public function checkSecEmailExist($email)
    {
        // find email exist in the database
        $sql = "SELECT * FROM secretary WHERE email = ?";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$email]);
        $users = $stmt->fetch();
        $countRow = $stmt->rowCount();

        // kapag may nadetect
        if($countRow > 0){
            return true; 
        } else {
            return false; 
        }
    }


    // show only 2 record of secretary
    public function show2Secretary()
    {
        $sql = "SELECT fullname, access FROM secretary LIMIT 2";
        $stmt = $this->con()->query($sql);
        while($row = $stmt->fetch()){
            echo "<h1>$row->fullname</h1><br/>
                  <h4>$row->access</h4><br/>";
        }
    }

    public function showAllSecretary()
    {
        $sql = "SELECT * FROM secretary";
        $stmt = $this->con()->query($sql);

        while($row = $stmt->fetch()){
            echo "<tr>
                    <td>$row->fullname</td>
                    <td>$row->gender</td>
                    <td>$row->email</td>
                    <td>
                        <a href='showAll.php?secId=$row->id'>view</a>
                    </td>
                  </tr>";
        }
    }

    public function showSpecificSec()
    {
        if(isset($_GET['secId'])){
            $id = $_GET['secId'];

            $sql = "SELECT * FROM secretary WHERE id = ?";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            $countRow = $stmt->rowCount();

            if($countRow > 0){
                $fullname = $user->fullname;
                $gender = $user->gender;
                $email = $user->email;
                $cpnumber = $user->cpnumber;
                $address = $user->address;

                echo "<script>
                         let viewModal = document.querySelector('.view-modal');
                         viewModal.setAttribute('id', 'show-modal');

                         let fullname = document.querySelector('#fullname').value = '$fullname';
                         let gender = document.querySelector('#gender').value = '$gender';
                         let email = document.querySelector('#email').value = '$email';
                         let cpnumber = document.querySelector('#cpnumber').value = '$cpnumber';
                         let address = document.querySelector('#address').value = '$address';
                      </script>";
            }
        }
    }

    public function submitOICAttendance() {
        if(isset($_POST['timeIn'])) {
            $getSessionEmpId = $_SESSION['OICDetails']['empId'];
            $getScheduleTimeIn = $_SESSION['OICDetails']['scheduleTimeIn'];
            $getScheduleTimeOut = $_SESSION['OICDetails']['scheduleTimeOut'];
            $getdateIn = $_SESSION['OICDetails']['datetimeIn'];

            $timenow = $_POST['timenow'];
            $newSchedTimeIn = new dateTime($getScheduleTimeIn);
            $newSchedTimeOut = new dateTime($getScheduleTimeOut);
            $newTimeNow = new dateTime($timenow);
            $newSchedTimeIn->sub(new DateInterval('PT1H'));
    
            if ($newSchedTimeIn >= $newSchedTimeOut) {

                if ($newTimeNow >= $newSchedTimeOut && $newTimeNow >= $newSchedTimeIn) {
                    $this->TimeInValidate();
                } else if ($newTimeNow <= $newSchedTimeOut && $newTimeNow <= $newSchedTimeIn) {
                    $this->TimeInValidate();
                } else {
                    echo 'You can only time in before 1 hour of your time in schedule';
                }

            } else if ($newSchedTimeIn <= $newSchedTimeOut) {
                if ($newTimeNow >= $newSchedTimeIn && $newTimeNow <= $newSchedTimeOut) {
                    $this->TimeInValidate();
                } else {
                    echo 'You can only time in before 1 hour of your time in schedule';
                }
            }
        }
    }

    public function TimeOutUpdate() {

        $sqlTimeOutUpdate = "SET GLOBAL event_scheduler='ON';";
        $stmtTimeOutUpdate = $this->con()->prepare($sqlTimeOutUpdate);
        $stmtTimeOutUpdate->execute();

        $verify = $stmtTimeOutUpdate->fetch();

        echo 'On progress. Please look at TimeOutUpdate()';

    }

    public function TimeOutAttendance() {
        if(isset($_POST['timeOut'])) {
            $empId = $_SESSION['OICDetails']['empId'];
            $scheduleTimeOut = $_SESSION['OICDetails']['scheduleTimeOut'];
            $timenow = $_POST['timenow'];
            $login_session = 'true';

            $NewTimeNow = new dateTime($timenow);
            $NewSchedTimeOutNoInterval = new dateTime($scheduleTimeOut);
            $NewSchedTimeOut = new dateTime($scheduleTimeOut);
            $NewSchedTimeOut->sub(new DateInterval('PT15M'));

            $sql = "SELECT * FROM emp_attendance WHERE empId = ? AND login_session = ?";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$empId, $login_session]);

            $users = $stmt->fetch();
            $countRow = $stmt->rowCount();

            if ($countRow > 0) {
                if ($NewTimeNow <= $NewSchedTimeOut) {
                    if ($NewTimeNow >= $NewSchedTimeOut && $NewTimeNow <= $NewSchedTimeOutNoInterval) {
                        $this->TimeOutUpdate();
                    } else {
                        echo 'You can only time-out 15 mins before of your time out schedule.';
                    }
                } else if ($NewTimeNow >= $NewSchedTimeOut) {
                    if ($NewTimeNow >= $NewSchedTimeOut && $NewTimeNow <= $NewSchedTimeOutNoInterval) {
                        $this->TimeOutUpdate();
                    } else if ($NewTimeNow <= $NewSchedTimeOut && $NewTimeNow <= $NewSchedTimeOutNoInterval) {
                        $this->TimeOutUpdate();
                    } else {
                        $this->TimeOutUpdate();
                    }
                }
            } else {
                echo 'User not found.';
            }
        }
    }

    public function TimeInValidate() {
            $getSessionEmpId = $_SESSION['OICDetails']['empId'];
            $getScheduleTimeIn = $_SESSION['OICDetails']['scheduleTimeIn'];
            $getScheduleTimeOut = $_SESSION['OICDetails']['scheduleTimeOut'];
            $getdateIn = $_SESSION['OICDetails']['datetimeIn'];
            $getid = $_SESSION['OICDetails']['id'];

            $empId = $getSessionEmpId;
            $timenow = $_POST['timenow'];
            $datenow = $_POST['datenow'];
            $location = $_POST['location'];
            $login_session = 'true';

            $newScheduleTimeIn = new dateTime($getScheduleTimeIn);
            $newScheduleTimeOut = new dateTime($getScheduleTimeOut);
            $newTimeNow = new dateTime($timenow);

                if($newTimeNow < $newScheduleTimeIn) {
                    $TimeInsert = $getScheduleTimeIn;
                } else {
                    $TimeInsert = $timenow;
                }


                if ($newScheduleTimeIn <= $newTimeNow) {
                    $status = 'Late';
                } else {
                    $status = 'Good';
                }
    
                $sqlgetLoginSession = "SELECT login_session FROM emp_attendance WHERE login_session = ? AND empId = ?";
                $stmtLoginSession = $this->con()->prepare($sqlgetLoginSession);
                $stmtLoginSession->execute([$login_session, $empId]);
    
                $verify = $stmtLoginSession->fetch();
    
                if ($row = $verify) {
                    echo 'You can only login once.';
                } else {    
                    $getHours = abs(strtotime($getScheduleTimeIn) - strtotime($getScheduleTimeOut)) / 3600;
                    $ConcatTimeDate = strtotime($getScheduleTimeIn." ".$getdateIn."+ ".$getHours." HOURS");
                    $ConvertToDate = date("Y/m/d", $ConcatTimeDate);
                    $ConvertToDateEventName = date("Y_m_d", $ConcatTimeDate);
                    $ConvertToSched = date("Y-m-d H:i:s", $ConcatTimeDate);

                    $customEventname = "time_in_ID_$getid".'_DATE_'."$ConvertToDateEventName";

                    $sql = "INSERT INTO emp_attendance(empId, timeIn, datetimeIn, datetimeOut, location, login_session, status) VALUES(?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->con()->prepare($sql);
                    $stmt->execute([$empId, $TimeInsert, $datenow, $ConvertToDate, $location, $login_session, $status]);
        
                    $users = $stmt->fetch();
                    $countRow = $stmt->rowCount();

                    if($countRow > 0) {
                        $sqlInsertEvent = "SET GLOBAL event_scheduler='ON';
                                            CREATE EVENT $customEventname
                                            ON SCHEDULE AT '$ConvertToSched'
                                            ON COMPLETION NOT PRESERVE
                                            DO
                                               UPDATE `emp_attendance`
                                               SET `login_session` = 'false',
                                               `timeOut` = '$getScheduleTimeOut',
                                               `datetimeOut` = '$ConvertToDate'
                                               WHERE `empid` = '$empId';
                                            ";
                        $InsertEventStmt = $this->con()->prepare($sqlInsertEvent);
                        $InsertEventStmt->execute();
                        $CountRow = $InsertEventStmt->rowCount();
        
                        if ($countRow > 0) {
                            echo 'Time-in Successfully';
                        } else {
                            echo 'Wala';
                        }
        
                    } else {
                        echo 'Time in error';
                    }
                }
    }

    public function alreadyLogin() {

        $getSessionEmpId = $_SESSION['OICDetails']['empId'];
        $empId = $getSessionEmpId;
        $login_session = 'true';


        $sqlgetLoginSession = "SELECT login_session FROM emp_attendance WHERE login_session = ? AND empId = ?";
        $stmtLoginSession = $this->con()->prepare($sqlgetLoginSession);
        $stmtLoginSession->execute([$login_session, $empId]);

        $verify = $stmtLoginSession->fetch();

        if ($row = $verify) {
            echo '<button type="submit" name="timeOut">Time-Out</button>';
        } else {
            echo '<button type="submit" name="timeIn" id="time-in-button">Time-in</button>';
        }

    }

    // ========================================= RED'S PROPERTY ==============================================

    public function displayAttendance()
    {
        $sql ="SELECT emp_info.empId, emp_info.firstname, emp_info.lastname,emp_attendance.company, emp_attendance.timeIn, emp_attendance.datetimeIn,
                        emp_attendance.timeOut, emp_attendance.datetimeOut,
                        emp_attendance.status, emp_attendance.id
        FROM emp_info
        INNER JOIN emp_attendance ON emp_info.empId = emp_attendance.empId WHERE emp_attendance.salary_status != 'paid'
        ORDER BY emp_attendance.id DESC;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            while($row = $stmt->fetch()){
            echo "<tr>
            <td>&nbsp;$row->empId&nbsp;</td>
            <td>&nbsp;$row->firstname&nbsp;</td>
            <td>&nbsp;$row->lastname&nbsp;</td>
            <td>&nbsp;$row->company&nbsp;</td>
            <td>&nbsp;$row->timeIn&nbsp;</td>
            <td>&nbsp;$row->datetimeIn&nbsp;</td>
            <td>&nbsp;$row->timeOut&nbsp;</td>
            <td>&nbsp;$row->datetimeOut&nbsp;</td>
            <td>&nbsp;$row->status&nbsp;</td>
            </tr>";   
            }
    }
    public function displayGeneratedSalary()
    {
        $sql ="SELECT log, generated_salary.emp_id, emp_info.firstname, emp_info.lastname, generated_salary.location, generated_salary.date
        FROM generated_salary INNER JOIN emp_info WHERE generated_salary.emp_id = emp_info.empId ORDER BY date ASC;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->emp_id</td>
            <td>$row->firstname $row->lastname</td>
            <td>$row->location</td>
            <td>$row->date</td>
            <td class ='td-action'>
                <div class = 'ic ic__add'>
                    <a href='viewsalary.php?logid=$row->log' class ='td-view'>
                        <span class='material-icons'>visibility</span>
                    </a>
                </div>

                <div class = 'ic ic__edit'>
                    <a href='viewsalary.php?logid=$row->log' class ='td-edit'>
                    <span class='material-icons'>edit</span>
                    </a>
                </div>

                <div class = 'ic ic__delete'>
                    <a href='viewsalary.php?logid=$row->log' class ='td-delete'>
                        <span class='material-icons'>delete</span>
                    </a>
                </div>
            </td>
            </tr>";
            $this->deleteSalary($row->log);
            }
    }
    public function deleteSalary($logid)
    {
        if(isset($_POST['delete'])){
        $sessionData = $this->getSessionSecretaryData();
        $fullname = $sessionData['fullname'];
        $secid = $sessionData['id'];
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
        $empid=$logid;
        $sql= "DELETE FROM generated_salary WHERE log = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$empid]);
        $countrow = $stmt->rowCount();
        if($countrow > 0) {
            $action = "Delete Salary";
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$secid,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                    header('location:manualpayroll.php');
                } else {
                    echo 'di pumasok sa act log';
                    header('location:manualpayroll.php');
                }
            } else {
                echo 'Error in deleting salary!';
            }
        }
        else if(isset($_POST['cancel'])){
            header('location: manualpayroll.php');
        }else{
        }

    }
    public function search()
    {
        if(isset($_POST['bsearch']))
            $search = strtolower($_POST['search']);
    
            if(!empty($search)){
                $sql ="SELECT emp_info.empId, emp_info.firstname, emp_info.lastname, 
                emp_attendance.company, emp_attendance.timeIn, emp_attendance.datetimeIn, 
                emp_attendance.timeOut, emp_attendance.datetimeOut,
                emp_attendance.status
    FROM emp_info
    INNER JOIN emp_attendance ON emp_info.empId = emp_attendance.empId WHERE emp_attendance.salary_status != 'paid';";
    $found=false;
                $stmt = $this->con()->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll();
                $countRow = $stmt->rowCount();
                foreach($users as $user){
                $lfirstname = strtolower($user->firstname);
                $llastname = strtolower($user->lastname);
                $lcompany = strtolower($user->company);
                $lstatus = strtolower($user->status);
                $timeIn = strtolower($user->timeIn);
                $timeOut = strtolower($user->timeOut);
                if(preg_match("/{$search}/i", $lfirstname) || preg_match("/{$search}/i", $llastname) || preg_match("/{$search}/i", $lcompany) || preg_match("/{$search}/i", $lstatus) || preg_match("/{$search}/i", $timeIn) || preg_match("/{$search}/i", $user->datetimeIn) || preg_match("/{$search}/i", $timeOut) ||preg_match("/{$search}/i", $user->datetimeOut)){
                    echo "<tr>
                    <td>&nbsp;$user->empId&nbsp;</td>
                    <td>&nbsp;$user->firstname&nbsp;</td>
                    <td>&nbsp;$user->lastname&nbsp;</td>
                    <td>&nbsp;$user->company&nbsp;</td>
                    <td>&nbsp;$user->timeIn&nbsp;</td>
                    <td>&nbsp;$user->datetimeIn&nbsp;</td>
                    <td>&nbsp;$user->timeOut&nbsp;</td>
                    <td>&nbsp;$user->datetimeOut&nbsp;</td>
                    <td>&nbsp;$user->status&nbsp;</td>
                    <tr/>";
                    $found=true;
                }
                }
                if($found!==true){
                    echo"No Record Found!";
                    $this->displayAttendance();
                }
                }else{
                echo "Please Input Fields!";
                $this->displayAttendance();
                }
    }
    public function generateSalary($id,$fullname)
    {
        if(isset($_POST['generate']))
        {
            if( isset($_POST['empid']) &&
            isset($_POST['rate']) &&
            isset($_POST['hrsduty']) &&
            isset($_POST['location']) &&
            isset($_POST['noofdayswork']) &&
            isset($_POST['regholiday']) &&
            isset($_POST['daylate']) &&
            isset($_POST['hrslate']) &&
            isset($_POST['sss']) &&
            isset($_POST['pagibig']) &&
            isset($_POST['philhealth']) &&
            isset($_POST['cashbond']) &&
            isset($_POST['specialholiday']) &&
            isset($_POST['thirteenmonth']) &&
            isset($_POST['cvale']))
            {
                if( empty($_POST['rate']) &&
                    empty($_POST['rate'])
                ) {
                    echo "All inputs are required";
                }else{
                $empid=$_POST['empid'];
                $rate=(int)$_POST['rate'];
                $hrsduty=(int)$_POST['hrsduty'];
                $location = $_POST['location'];
                $noofdayswork = (int)$_POST['noofdayswork'];
                $regholiday = $_POST['regholiday'];
                $daylate=$_POST['daylate'];
                $hrslate=$_POST['hrslate'];
                $sss=$_POST['sss'];
                $pagibig=$_POST['pagibig'];
                $philhealth=$_POST['philhealth'];
                $cashbond=$_POST['cashbond'];
                $specialholiday=$_POST['specialholiday'];
                $thirteenmonth=$_POST['thirteenmonth'];
                $netpay="";
                $vale=$_POST['cvale'];
                $totaldaysalary = $hrsduty * $rate ; // sahod sa isang araw depende sa duty at rate
 
                $regholidayhoursalary = $regholiday * $rate;
                $totalregholidaysalary = $regholidayhoursalary;                        // sahod pag regular holiday

                $totalspecialholidayhoursalary = $specialholiday * $rate;
                $totalspecialholidayhoursalarypercent = $totalspecialholidayhoursalary * 0.03;
                $totalspecialholidaysalary = $totalspecialholidayhoursalarypercent + $totalspecialholidayhoursalary;
                
                $totalhrs = $hrsduty * $noofdayswork; // oras ng trabaho
                $totalsalaryfortotalhours = $totalhrs * $rate;  // sahod sa oras nang tinrabaho

                $totalholidaysalary = (float)$totalregholidaysalary + (float)$totalspecialholidaysalary;
                $totg = (float)$totalholidaysalary + (float)$thirteenmonth;
                $totalgross = (float)$totalsalaryfortotalhours + (float)$totg;

                $totalsalaryforlate = (float)$hrslate * $rate;
                $totaldeduction = (float)$vale + (float)$cashbond + (float)$sss + (float)$pagibig + (float)$philhealth + (float)$totalsalaryforlate;

                $netpay = $totalgross - $totaldeduction;
            // set timezone and get date and time
            $datetime = $this->getDateTime();
            $time = $datetime['time'];
            $date = $datetime['date']; 
            $sql = "INSERT INTO generated_salary (emp_id,
                                            location,
                                            rate_hour,
                                            date,
                                            hours_duty,
                                            regular_holiday,
                                            special_holiday,
                                            day_late,
                                            hrs_late,
                                            no_of_work,
                                            sss,
                                            pagibig,
                                            philhealth,
                                            cashbond,
                                            vale,
                                            thirteenmonth,
                                            total_hours,
                                            regular_pay,
                                            regular_holiday_pay,
                                            special_holiday_pay,
                                            total_deduction,
                                            total_gross,
                                            total_netpay,
                                            dateandtime_created
                                            )
                    VALUES(?, ?, ?, ?,?, ?,?, ?,?, ?, ?,?,?,?,?,?,?,?,? ,?, ?, ?, ?,?);";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$empid, $location, $rate, $date, $hrsduty,$regholiday, $specialholiday, $daylate, $hrslate,  $noofdayswork, $sss,$pagibig,$philhealth, $cashbond, $vale, $thirteenmonth,$totalhrs, $totalsalaryfortotalhours, $totalregholidaysalary, $totalspecialholidaysalary, $totaldeduction,$totalgross,$netpay, $time]);
            $users = $stmt->fetch();
            $countRow = $stmt->rowCount();

            if($countRow > 0){
                echo 'Added';

                $action = "Add Salary";

                $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
                $stmtSecLog = $this->con()->prepare($sqlSecLog);
                $stmtSecLog->execute([$id,$fullname, $action, $time, $date]);
                $countRowSecLog = $stmtSecLog->rowCount();

                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                } else {
                    echo 'di pumasok sa act log';
                }

            } else {
                echo 'Error in adding salary!';
            }
        }
            } else {
            echo "All inputs are required!";
            
        }

    }
    }
    public function showSpecificSalary()
    {
        if(isset($_GET['empid'])){
            $id = $_GET['empid'];
            $sql = "SELECT * FROM generated_salary WHERE emp_id = ?";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            $countRow = $stmt->rowCount();

            if($countRow > 0){
                $empid = $user->emp_id;
                $location = $user->location;
                $date = $user->date;
                $late = $user->day_late; 
                $absent = $user->day_absent;
                $noofdayswork = $user->no_of_work; 
                $sss= $user->sss;
                $cashbond = $user->cashbond;
                $vale = $user->vale;
                $thirteenmonth = $user->thirteenmonth;
                $gross = $user->total_gross;
                $netpay = $user->total_netpay;
                $time = $user->dateandtime_created;
                echo"location ".$location;
            }
        }
    }

    public function updateSalary($id,$fullname){
        if(isset($_POST['edit']))
        {
            // if( isset($_POST['empid']) &&
            // !isset($_POST['rate']) &&
            // isset($_POST['hrsduty']) &&
            // isset($_POST['location']) &&
            // isset($_POST['noofdayswork']) &&
            // isset($_POST['regholiday']) &&
            // isset($_POST['daylate']) &&
            // isset($_POST['minlate']) &&
            // isset($_POST['dayabsent']) &&
            // isset($_POST['sss']) &&
            // isset($_POST['cashbond']) &&
            // isset($_POST['specialholiday']) &&
            // isset($_POST['thirteenmonth']) &&
            // isset($_POST['cvale']))
            // {
                $empid=$_POST['empid'];
                $rate=(int)$_POST['rate'];
                $hrsduty=(int)$_POST['hrsduty'];
                $location = $_POST['location'];
                $noofdayswork = (int)$_POST['noofdayswork'];
                $regholiday = $_POST['regholiday'];
                $daylate=$_POST['daylate'];
                $minlate=$_POST['hrslate'];
                // $dayabsent=$_POST['dayabsent'];
                $sss=$_POST['sss'];
                $cashbond=$_POST['cashbond'];
                $specialholiday=$_POST['specialholiday'];
                $thirteenmonth=$_POST['thirteenmonth'];
                $netpay="";
                $vale=$_POST['cvale'];
                $logid=$_GET['logid'];
                $totaldaysalary = $hrsduty * $rate ; // sahod sa isang araw depende sa duty at rate

                $totalregholidayhour = $hrsduty * $regholiday; 
                $totalregholidayhoursalary = $totalregholidayhour * $rate;
                $totalregholidaysalary = $totalregholidayhoursalary;                        // sahod pag regular holiday

                $specialholidayhour = $hrsduty * $specialholiday;
                $totalspecialholidayhoursalary = $specialholidayhour * $rate;
                $totalspecialholidayhoursalarypercent = $totalspecialholidayhoursalary * 0.03;
                $totalspecialholidaysalary = $totalspecialholidayhoursalarypercent;
                
                $totalhrs = $hrsduty * $noofdayswork; // oras ng trabaho
                $totalsalaryfortotalhours = $totalhrs * $rate;  // sahod sa oras nang tinrabaho

                $totalholidaysalary = $totalregholidaysalary + $totalspecialholidaysalary;
                $totg = $totalholidaysalary + $thirteenmonth;
                $totalgross = $totalsalaryfortotalhours + $totg;

                // $totalhourfordayabsent = $dayabsent * $hrsduty; // total hours ng absent
                // $totaldaysalaryfordayabsent = $totalhourfordayabsent * $rate; //sahod absent

                $totalsalaryforlate = $minlate * 59.523;
                $totaldeduction = $vale + $cashbond + $sss  + $totalsalaryforlate;

                $netpay = $totalgross - $totaldeduction;
                        // else if (!empty($empid) &&
                        // !empty($location)&&
                        // !empty($noofdayswork) &&
                        // !empty($cashbond) &&
                        // !empty($hrsduty) &&
                        // !empty($sss) &&
                        // !empty($rate) &&
                        // !empty($vale) &&
                        // !empty($daylate) &&
                        // !empty($hrslate) &&
                        // !empty($dayabsent) &&
                        // !empty($hrsabsent) &&
                        // !empty($thirteenmonth)
                        // ){
                        // set timezone and get date and time
                        $datetime = $this->getDateTime();
                        $time = $datetime['time'];
                        $date = $datetime['date']; 
                    $sql = "UPDATE generated_salary SET emp_id = ?,
                    location = ?,
                    rate_hour = ?,
                    date = ?,
                    hours_duty = ?,
                    regular_holiday = ?,
                    special_holiday = ?,
                    day_late = ?,
                    hrs_late = ?,
                    -- day_absent = ?,
                    -- hours_absent = ?,
                    no_of_work = ?,
                    sss = ?,
                    cashbond = ?,
                    vale = ?,
                    thirteenmonth = ?,
                    total_hours = ?,
                    regular_pay = ?,
                    regular_holiday_pay = ?,
                    special_holiday_pay = ?,
                    total_deduction = ?,
                    total_gross = ?,
                    total_netpay = ?,
                    dateandtime_created = ?
                    WHERE log = $logid;";
                    $stmt = $this->con()->prepare($sql);
                    $stmt->execute([$empid, $location, $rate, $date,$hrsduty,$regholiday,$specialholiday,$daylate, $minlate, $noofdayswork, $sss, $cashbond, $vale, $thirteenmonth ,$totalhrs ,$totalsalaryfortotalhours,$totalregholidaysalary,$totalspecialholidaysalary,$totaldeduction,$totalgross,$netpay ,$time]);
                    $users = $stmt->fetch();
                    $countRow = $stmt->rowCount();

                        if($countRow > 0){
                            echo 'Updated';

                            $action = "Edit Salary";

                            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                            VALUES(?, ?, ?, ?, ?)";
                            $stmtSecLog = $this->con()->prepare($sqlSecLog);
                            $stmtSecLog->execute([$id,$fullname, $action, $time, $date]);
                            $countRowSecLog = $stmtSecLog->rowCount();

                            if($countRowSecLog > 0){
                                echo 'pumasok na sa act log';
                                header('location: manualpayroll.php');
                            } else {
                                echo 'di pumasok sa act log';
                            }

                        } else {
                            echo 'Error in updating salary!';
                        }
            // } else {
            // echo "All inputs are required!";
            // }
        }
    }
public function employeeList(){
    $sql ="SELECT * FROM emp_info";
    $stmt = $this->con()->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchall();
                    foreach($users as $user){
                        echo "<tr>
                                <td>&nbsp;$user->empId&nbsp;</td>
                                <td>&nbsp;$user->firstname&nbsp;</td>
                                <td>&nbsp;$user->lastname&nbsp;</td>
                                <td>&nbsp;$user->address&nbsp;</td>
                                <td>&nbsp;$user->cpnumber&nbsp;</td>
                                <td>&nbsp;$user->position&nbsp;</td>
                                <td>&nbsp;$user->status&nbsp;</td>
                                <td class ='td-action'>
                                    <div class = 'ic ic__add'>
                                        <a href='viewemployee.php?empId=$user->empId' class='td-view'>
                                            <span class='material-icons'>visibility</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>";
                    }
}
public function searchEmployee(){
        if(isset($_POST['empsearch'])){
            $search = strtolower($_POST['employeesearch']);
    
            if(!empty($search)){
                $sql ="SELECT empId, firstname, lastname, address, cpnumber, position, status
    FROM emp_info;";
    $found=false;
                $stmt = $this->con()->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll();
                $countRow = $stmt->rowCount();
                foreach($users as $user){
                $lfirstname = strtolower($user->firstname);
                $llastname = strtolower($user->lastname);
                $laddress = strtolower($user->address);
                $lstatus = strtolower($user->status);
                $lposition = strtolower($user->position);
                if(preg_match("/{$search}/i", $lfirstname) || preg_match("/{$search}/i", $llastname) || preg_match("/{$search}/i", $laddress) || preg_match("/{$search}/i", $lstatus) || preg_match("/{$search}/i", $lposition)){
                    echo "<tr>
                    <td>&nbsp;$user->empId&nbsp;</td>
                    <td>&nbsp;$user->firstname&nbsp;</td>
                    <td>&nbsp;$user->lastname&nbsp;</td>
                    <td>&nbsp;$user->address&nbsp;</td>
                    <td>&nbsp;$user->cpnumber&nbsp;</td>
                    <td>&nbsp;$user->position&nbsp;</td>
                    <td>&nbsp;$user->status&nbsp;</td>
                    <td>&nbsp;<a href='viewemployee.php?empId=$user->empId'>View </a>&nbsp;</td>
                    <tr/>";
                    $found=true;
                }
                }
                if($found!==true){
                    echo"No Record Found!";
                    $this->employeeList();
                }
                }else{
                echo "Please Input Fields!";
                $this->employeeList();
                }
    }
}
public function automaticGenerateSalary($fullname,$id){
    if(isset($_POST['generateautomatic'])){
        $regholiday = 0;
        $specholiday = 0;
        $empid = $_POST['empid'];
        $sql="SELECT emp_attendance.timeIn, emp_attendance.timeOut, emp_info.rate
        FROM emp_attendance INNER JOIN emp_info ON emp_attendance.empId = emp_info.empId WHERE emp_attendance.empId = ? AND emp_attendance.salary_status != 'paid';";
                $stmt = $this->con()->prepare($sql);
                $stmt->execute([$empid]);
                $users = $stmt->fetchAll();
                $countRow = $stmt->rowCount();
                if($countRow >= 3){
                $tothrs = 0;
                foreach ($users as $user){
                    $rate = $user->rate;
                    $timein= date('H:i:s',strtotime($user->timeIn));
                    $timeout= date('H:i:s',strtotime($user->timeOut));
                    $tothrs += abs(strtotime($timein) - strtotime($timeout)) /3600 ;
                    
                }
                $sql0="SELECT emp_attendance.timeIn, emp_attendance.timeOut, emp_info.rate, emp_attendance.datetimeIn, emp_attendance.datetimeOut, emp_info.position
                FROM emp_attendance INNER JOIN emp_info ON emp_attendance.empId = emp_info.empId WHERE emp_attendance.empId = ?;";
                $stmt0 = $this->con()->prepare($sql0);
                $stmt0->execute([$empid]);
                $users0 = $stmt0->fetch();
                $countRow0 = $stmt0->rowCount();
                $hoursduty = 12;                                   //modify pag ayos na sched table
                if($countRow0 >= 1){
                $getin=$countRow0;
                while($countRow0 >= $getin){
                $start = $users0->datetimeIn;
                $getin++;
                }
                $end = $start;
                $users01 = $stmt0->fetchall();                        //get start date and end date
                foreach($users01 as $user0){
                $end = $user0->datetimeOut;
                }
                $sql1="SELECT * FROM cashadvance WHERE empId = ?;";
                $stmt1 = $this->con()->prepare($sql1);
                $stmt1->execute([$empid]);
                $users1 = $stmt1->fetch();
                $countRow1 = $stmt1->rowCount();
                if($countRow1 > 0){
                    $vale = $users1->amount;
                }else{
                    $vale = 0;
                }
                $position = $users0->position; //get the position of selected employee
                if(strtolower($position)=="security officer" || $hoursduty == 12)                          
                {
                    $rate = 59.523;
                    $philhealth = 0;                                    //modify pag may schedule table na
                                                                        //kapag guard tapos 12 hrs duty
                $sql2="SELECT * FROM deductions WHERE position = 'security officer' AND duty = 12;";
                $stmt2 = $this->con()->prepare($sql2);
                $stmt2->execute();
                $users2 = $stmt2->fetchall();
                $countRow2 = $stmt2->rowCount();
                if($countRow2 > 0){
                    foreach($users2 as $user2){
                        if(strtolower($user2->deduction)=="sss"){
                            $sss = $user2->amount;
                        }else if(strtolower($user2->deduction)=="pagibig"){
                            $pagibig = $user2->amount;
                        }else if(strtolower($user2->deduction)=="philhealth"){
                            $philhealth = $user2->amount;
                        }else{
                            $sss = 0;
                            $pagibig = 0;
                            $philhealth = 0;
                        }
                        }
                }else {
                    $sss = 0;
                    $pagibig = 0;
                    $philhealth = 0;
                    echo "No deductions set";
                }


            }else if(strtolower($position)=="security officer" || $hoursduty == 8){                                                     //kapag guard tapos 8 hrs duty
                $sql2="SELECT * FROM deductions WHERE position = 'security officer' AND duty = 8;";
                $stmt2 = $this->con()->prepare($sql2);
                $stmt2->execute();
                $users2 = $stmt2->fetchall();
                $countRow2 = $stmt2->rowCount();
                if($countRow2 > 0){
                    foreach($users2 as $user2){
                        if(strtolower($user2->deduction)=="sss"){
                            $sss = $user2->amount;
                        }else if(strtolower($user2->deduction)=="pagibig"){
                            $pagibig = $user2->amount;
                        }else if(strtolower($user2->deduction)=="philhealth"){
                            $philhealth = $user2->amount;
                        }else{
                            $sss = 0;
                            $pagibig = 0;
                            $philhealth = 0;
                                }
                                                }           
                                    }else {
                    $sss = 0;
                    $pagibig = 0;
                    $philhealth = 0;
                    echo "No deductions set";
                                        }

                } else if (strtolower($position)=="oic" || $hoursduty == 12){
                    $rate= 67.125;
                                                        //modify pag may schedule table na
                $sql2="SELECT * FROM deductions WHERE position = 'oic' AND duty = 12;";
                $stmt2 = $this->con()->prepare($sql2);
                $stmt2->execute();
                $users2 = $stmt2->fetchall();
                $countRow2 = $stmt2->rowCount();
                if($countRow2 > 0){
                    foreach($users2 as $user2){
                        if(strtolower($user2->deduction)=="sss"){
                            $sss = $user2->amount;
                        }else if(strtolower($user2->deduction)=="pagibig"){
                            $pagibig = $user2->amount;
                        }else if(strtolower($user2->deduction)=="philhealth"){
                            $philhealth = $user2->amount;
                        }else{
                            $sss = 0;
                            $pagibig = 0;
                            $philhealth = 0;
                        }
                        }
                }else {
                    $sss = 0;
                    $pagibig = 0;
                    $philhealth = 0;
                    echo "No deductions set";
                }
                    
            
            }else if(strtolower($position)=="oic" || $hoursduty == 8){
                $sql2="SELECT * FROM deductions WHERE position = 'oic' AND duty = 8;";
                $stmt2 = $this->con()->prepare($sql2);
                $stmt2->execute();
                $users2 = $stmt2->fetchall();
                $countRow2 = $stmt2->rowCount();
                if($countRow2 > 0){
                    foreach($users2 as $user2){
                        if(strtolower($user2->deduction)=="sss"){
                            $sss = $user2->amount;
                        }else if(strtolower($user2->deduction)=="pagibig"){
                            $pagibig = $user2->amount;
                        }else if(strtolower($user2->deduction)=="philhealth"){
                            $philhealth = $user2->amount;
                        }else{
                            $sss = 0;
                            $pagibig = 0;
                            $philhealth = 0;
                        }
                        }
                }else {
                    $sss = 0;
                    $pagibig = 0;
                    $philhealth = 0;
                    echo "No deductions set";
                }
                }else{
                    echo "error in position";
                }
                $sqlhol="SELECT * FROM emp_attendance INNER JOIN holidays ON emp_attendance.datetimeIn = holidays.date_holiday WHERE emp_attendance.empId = ?;";
                $stmthol = $this->con()->prepare($sqlhol);
                $stmthol->execute([$empid]);
                $usershol = $stmthol->fetchall();
                $countRowhol = $stmthol->rowCount();
                if($countRowhol > 0){
                    foreach($usershol as $userhol){
                        if(strtolower($userhol->type)=="regular holiday"){
                            $regholiday = $regholiday + 1;
                        }elseif(strtolower($userhol->type)=="special holiday"){
                            $specholiday = $specholiday + 1;
                        }else{

                        }
                    }
                }
                    $standardpay = $tothrs * $rate;
                    $regholiday = $regholiday * $hoursduty;
                    $regholidaypay = ($regholiday * $rate);
                    $specholiday = $specholiday * $hoursduty;
                    $specrate = $specholiday * $rate;
                    $specpercent = $specrate * 0.30;
                    $specholidaypay = $specpercent;
                    $thirteenmonth = 0;
                    $cashbond = 50;
                    $total_hours_late = 0;                                      //sa attendance ni vonne to
                    $totalgross = ($standardpay + $regholidaypay + $specholidaypay + $thirteenmonth);
                    $totaldeduction = ($sss + $pagibig + $philhealth + $cashbond + $vale);
                    $totalnetpay = $totalgross - $totaldeduction;
                    if($totalnetpay < 0){
                    $forrelease = "**Not for Release!";
                    }else{
                        $forrelease="For Release";
                    }
                    date_default_timezone_set('Asia/Manila');
                    $date = date('F j, Y h:i:s A');
                if($countRow > 0 ){
                    $sql1="INSERT INTO `automatic_generated_salary`(`emp_id`, `total_hours`,`standard_pay`, `regular_holiday`, 
                    `regular_holiday_pay`, `special_holiday`, `special_holiday_pay`, `thirteenmonth`, `sss`,`pagibig`,`philhealth`, `cashbond`, 
                    `vale`, `total_hours_late`, `total_gross`, `total_deduction`, `total_netpay` ,`start`,`end`,`for_release`,`date_created`) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                    $stmt1 = $this->con()->prepare($sql1);
                    $stmt1->execute([$empid,$tothrs,$standardpay,$regholiday,$regholidaypay,$specholiday,$specholidaypay,$thirteenmonth,$sss,$pagibig,$philhealth,$cashbond,$vale,$total_hours_late,$totalgross,$totaldeduction,$totalnetpay,$start,$end,$forrelease,$date]);
                    $CountRow01 = $stmt1 ->rowCount();
                    if($CountRow01>0){
                        $action = "Add Automated Salary";
                        $secdatetime = $this->getDateTime();
                        $sectime = $secdatetime['time'];
                        $secdate = $secdatetime['date'];
                        $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                    VALUES(?, ?, ?, ?, ?)";
                        $stmtSecLog = $this->con()->prepare($sqlSecLog);
                        $stmtSecLog->execute([$id,$fullname, $action, $sectime, $secdate]);
                        $countRowSecLog = $stmtSecLog->rowCount();
                        if($countRowSecLog > 0){
                            echo 'pumasok na sa act log';
                        } else {
                            echo 'di pumasok sa act log';
                        }
                                        }
                }
            }else {
                echo "The selected employee is less than or equal to 5 attendance only, can't generate salary";
            }
        }
}
}
public function displayAutomaticGeneratedSalary(){
        $sql ="SELECT log, automatic_generated_salary.emp_id, automatic_generated_salary.start, automatic_generated_salary.end, emp_info.firstname, emp_info.lastname, automatic_generated_salary.date_created
        FROM automatic_generated_salary INNER JOIN emp_info WHERE automatic_generated_salary.emp_id = emp_info.empId AND for_release !='released'  ORDER BY date_created DESC;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->emp_id</td>
            <td>$row->firstname $row->lastname</td>
            <td>$row->start</td>
            <td>$row->end</td>
            <td>$row->date_created</td>
            <td><a href='viewautomatedsalary.php?logid=$row->log'>View </a><a href='releaseautomatedsalary.php?logid=$row->log'>Release </a><a href='deleteautomatedsalary.php?logid=$row->log'>Delete </a></td>
            </tr>";
            // $this->deleteSalary($row->log);
            }
}
public function releaseSalary(){
        if(isset($_POST['release'])){
            $logid = $_GET['logid'];
            $sql = "SELECT * FROM automatic_generated_salary WHERE log = ?;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$logid]);
            $user=$stmt->fetch();
            if(strtolower($user->for_release)=='**not for release!'){
                echo "di pwede irelease";
                header('location: automaticpayroll.php');
            }else{
            $sql1="UPDATE automatic_generated_salary SET for_release = 'released' WHERE log = $logid;";
            $stmt1 = $this->con()->prepare($sql1);
            $stmt1->execute();
            $CountRow01 = $stmt1 ->rowCount();
            if($CountRow01>0){
            $status='unpaid';
            $sql2="UPDATE emp_attendance SET salary_status = 'paid' WHERE empId = ? AND salary_status = ?;";
            $stmt2 = $this->con()->prepare($sql2);
            $stmt2->execute([$user->emp_id,$status]);
            $CountRow02 = $stmt2 ->rowCount();
            if($CountRow02>0){
                echo "pasok sa act log";
                header('automaticpayroll.php');
            }
            }
            }


        }//isset
        else if(isset($_POST['cancel'])){
            header('location: automaticpayroll.php');
        }
}
public function deleteautomatedsalary($logid){
    if(isset($_POST['deleteauto'])){
        $sql = "DELETE FROM automatic_generated_salary WHERE log = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$logid]);
        $countrow = $stmt->rowCount();
        if($countrow > 0) {
        $action = "Delete Automated Salary";
        $sessionData = $this->getSessionSecretaryData();
        $fullname = $sessionData['fullname'];
        $secid = $sessionData['id'];
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$secid,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                    header('location:automaticpayroll.php');
                } else {
                    echo 'di pumasok sa act log';
                    header('location:automaticpayroll.php');
                }
            } else {
                echo 'Error in deleting !';
            }
        }
        else if(isset($_POST['cancel'])){
            header('location: automaticpayroll.php');
        }else{
        }
}





public function adddeduction($fullname,$id){
            if(isset($_POST['generatededuction'])){
                $deduction = $_POST['deduction'];
                $position = $_POST['position'];
                $duty = $_POST['duty'];
                if(strtolower($deduction)=="sss"){
                    if(strtolower($position) == "security officer"){
                        $rate = 59.523;
                        $tothrs = $duty * 28;
                        $monthlysalary = $tothrs * $rate;
                        $amount = $monthlysalary * 0.0450 /2;    
                    }else{
                        $rate = 67.125;
                        $tothrs = $duty * 28;
                        $monthlysalary = $tothrs * $rate;
                        $amount = $monthlysalary * 0.0450 /2;
                    }
                }else if(strtolower($deduction)=="pagibig"){
                    if(strtolower($position) == "security officer"){
                        $rate = 59.523;
                        $tothrs = $duty * 28;
                        $monthlysalary = $tothrs * $rate;
                        $amount = $monthlysalary * 0.02 /2;    
                    }else{
                        $rate = 67.125;
                        $tothrs = $duty * 28;
                        $monthlysalary = $tothrs * $rate;
                        $amount = $monthlysalary * 0.02 /2;
                    }
                }else if(strtolower($deduction)=="philhealth"){
                    if(strtolower($position) == "security officer"){
                        $rate = 59.523;
                        $tothrs = $duty * 28;
                        $monthlysalary = $tothrs * $rate;
                        $amount = $monthlysalary * 0.035 / 2;    
                    }else{
                        $rate = 67.125;
                        $tothrs = $duty * 28;
                        $monthlysalary = $tothrs * $rate;
                        $amount = $monthlysalary * 0.035 / 2;
                    }
                }
                else{
                    echo "Error";
                }
                $cutoff = "Bi-weekly";
                $sql="INSERT INTO  deductions (`deduction`, `position`,`cutoff`, `duty`, `amount`) VALUES (?,?,?,?,?);";
                $stmt = $this->con()->prepare($sql);
                $stmt->execute([$deduction,$position,$cutoff,$duty, number_format($amount)]);
                $countrow = $stmt->rowCount();
                if($countrow > 0) {
                $action = "Add Deduction";
                $datetime = $this->getDateTime();
                $time = $datetime['time'];
                $date = $datetime['date'];
                $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                    VALUES(?, ?, ?, ?, ?)";
                $stmtSecLog = $this->con()->prepare($sqlSecLog);
                $stmtSecLog->execute([$id,$fullname, $action, $time, $date]);
                $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                } else {
                    echo 'di pumasok sa act log';
                    header('location:deductions.php');
                }
            }
            }//isset
}
public function deletededuction($logid){
    if(isset($_POST['deletededuction'])){
        $sql = "DELETE FROM deductions WHERE id = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$logid]);
        $countrow = $stmt->rowCount();
        if($countrow > 0) {
        $action = "Delete Deduction";
        $sessionData = $this->getSessionSecretaryData();
        $fullname = $sessionData['fullname'];
        $secid = $sessionData['id'];
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$secid,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                    header('location:deductions.php');
                } else {
                    echo 'di pumasok sa act log';
                    header('location:deductions.php');
                }
            } else {
                echo 'Error in deleting salary!';
            }
        }
        else if(isset($_POST['cancel'])){
            header('location: deductions.php');
        }else{

        }

}
public function displaydeduction(){
    $sql="SELECT id,deduction,position,cutoff,duty,amount FROM deductions;";
    $stmt = $this->con()->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch()){
        echo "<tr>
        <td>$row->deduction</td>
        <td>$row->position</td>
        <td>$row->cutoff</td>
        <td>$row->duty</td>
        <td>$row->amount</td>
        <td><a href='deletededuction.php?logid=$row->id'>Delete </a></td>
        </tr>";
        $this->deletededuction($row->id);
        }
}
public function cashadvance($fullname,$id){
    if(isset($_POST['add'])){
        if(!empty($_POST['amount'])){
        $empid = $_POST['empid'];
        $amount = $_POST['amount'];
        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y');
        if($amount <= 3000){
            $sql="INSERT INTO cashadvance (`empId`,`date`,`amount`) VALUES (?,?,?);";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$empid,$date,$amount]);
            $countrow = $stmt->rowCount();
        if($countrow > 0) {
        $action = "Add Cash Advance";
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$id,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                } else {
                    echo 'di pumasok sa act log';
                    header('location:deductions.php');
                }
            }
        }else {
            echo "Maximum Cash Advance: 3,000 only";
        }
    }//empty
    }//isset
}
public function deletecashadv($logid){
    if(isset($_POST['deletecashadv'])){
        $sql = "DELETE FROM cashadvance WHERE id = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$logid]);
        $countrow = $stmt->rowCount();
        if($countrow > 0) {
        $action = "Delete Cash Advance";
        $sessionData = $this->getSessionSecretaryData();
        $fullname = $sessionData['fullname'];
        $secid = $sessionData['id'];
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$secid,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                    header('location:deductions.php');
                } else {
                    echo 'di pumasok sa act log';
                    header('location:deductions.php');
                }
            } else {
                echo 'Error in deleting cash advance!';
            }
        }
        else if(isset($_POST['cancel'])){
            header('location: deductions.php');
        }else{
        }
}
public function displaycashadvance(){
    $sql="SELECT cashadvance.id, cashadvance.date, cashadvance.amount, emp_info.firstname, emp_info.lastname FROM cashadvance INNER JOIN emp_info ON cashadvance.empId = emp_info.empId;";
    $stmt = $this->con()->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch()){
        echo "<tr>
        <td>$row->firstname $row->lastname</td>
        <td>$row->date</td>
        <td>$row->amount</td>
        <td><a href='deletecashadv.php?logid=$row->id'>Delete </a></td>
        </tr>";
        $this->deletecashadv($row->id);
        }
}

} // End of class



$payroll = new Payroll;

?>

