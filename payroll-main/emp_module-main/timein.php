<?php

    // $getScheduleTimeIn = "8:00:00 AM"; //Dito lang mags-start mag time-in
    // $getScheduleTimeOut = "5:00:00 PM"; //After nito bawal na mag time-in
    // $timenow = "7:00:00 AM"; //Oras mo today

    // $newSchedTimeIn = new dateTime($getScheduleTimeIn);
    // $newSchedTimeOut = new dateTime($getScheduleTimeOut);
    // $newTimeNow = new dateTime($timenow);
    // $newSchedTimeIn->sub(new DateInterval('PT1H'));

    $timenow = "4:39:32 PM";
    $getScheduleTimeOut = "5:00:00 AM";
    $UnixTimeNow = strtotime($timenow);
    $UnixScheduleTimeOut = strtotime($getScheduleTimeOut);

    $count_in_min = abs(($UnixTimeNow - $UnixScheduleTimeOut) / 60);
    $int_min = intval($count_in_min);
    $NewUnixTimeNow = strtotime($timenow."+ ".$int_min." minute");

    // var_dump($int_min);    

    // echo $int_min;
    echo date('h:i:s A', $NewUnixTimeNow);


    // echo 'Execute at: ' 

    // $StrTimeIn = $newSchedTimeIn->format('H');
    // $StrTimeOut = $newSchedTimeOut->format('H');
    // $StrTimeNow = $newTimeNow->format('H');

    // echo 'Start: '.$StrTimeIn.'<br>';
    // echo 'End: '.$StrTimeOut.'<br>';
    // echo 'Value: '.$StrTimeNow.'<br>';

    // if(isset($_POST['timein'])) {
        

    //     if ($newSchedTimeIn > $newSchedTimeOut) {

    //         if ($newTimeNow >= $newSchedTimeOut && $newTimeNow >= $newSchedTimeIn) {
    //             echo 'Time-in Successfully (1)';
    //         } else if ($newTimeNow <= $newSchedTimeOut && $newTimeNow <= $newSchedTimeIn) {
    //             echo 'Time in Successfully';
    //         } else {
    //             echo 'Fuck off (1)';
    //         }

    //     } else if ($newSchedTimeIn < $newSchedTimeOut) {
    //         if ($newTimeNow >= $newSchedTimeIn && $newTimeNow <= $newSchedTimeOut) {
    //             echo 'Time-in Successfully (2)';
    //         } else {
    //             echo 'You can only time in before 1 hour of your time in schedule (2)';
    //         }
    //     }

    // }
    

    // if ($getScheduleTimeIn = "12:00:00 AM") {
    //     $TimeInPermission = new dateTime($getScheduleTimeIn);
    //     $TimeInPermission->add(new DateInterval('PT23H')); //Add 1 HR
    // } else {
    //     $TimeInPermission = new dateTime($getScheduleTimeIn);
    //     $TimeInPermission->sub(new DateInterval('PT1H')); //Subtracts 1 HR
    // }

    // $TimeNowFormat = new dateTime($timenow);
    // $TimeOutPermission = new dateTime($getScheduleTimeOut);

    // $resultTimeInFormat = $TimeInPermission->format('H');
    // $resultTimeOutFormat = $TimeOutPermission->format('H');
    // $resultTimeNowFormat = $TimeNowFormat->format('H');
    // // var_dump($TimeInPermission);

    // if ($TimeNowFormat >= $TimeInPermission && $TimeNowFormat >= $TimeOutPermission) {
    //     echo 'Time-in Successfully<br>';
    //     echo 'Time In: '.$resultTimeInFormat.'<br>';
    //     echo 'Time Out: '.$resultTimeOutFormat.'<br>';
    //     echo 'Time Now: '.$resultTimeNowFormat."<br>";


    // } else {
    //     echo 'You con only time-in 1 hour before of your Time Schedule.<br>';
    //     echo 'Time In: '.$resultTimeInFormat.'<br>';
    //     echo 'Time Out: '.$resultTimeOutFormat.'<br>';
    //     echo 'Time Now: '.$resultTimeNowFormat."<br>";
    // }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <!-- <input type="text" name="timenow" id="timenow" value="<?php echo $timenow ?>"> -->
       <button type="submit" name="timein">Time-In</button>
    </form>
</body>
</html>