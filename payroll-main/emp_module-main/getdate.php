<?php


    $datesched = "9:00:00 AM";
    $datenow = "8:02:00 AM";

    $newdatesched = new dateTime($datesched);
    $newdatenow =  new dateTime($datenow);

    if ($newdatenow < $newdatesched) {
        echo $datesched;
    } else {
        echo $datenow;
    }

    // $scheduleTimeNow = strtotime("3:37:00 PM");
    // $stringTimeIn = ("07:00:00 AM");
    // $scheduleTimeOut = strtotime("6:00:00 PM");

    // // $interval = $scheduleTimeIn->diff($scheduleTimeOut);
    // // $diffInHours = $interval->h;
    // $diffInMinute = abs(($scheduleTimeOut - $scheduleTimeNow)) / 60;

    // // echo "<br>Hour: ".$diffInHours;
    // echo "<br>Minute: ".$diffInMinute."<br>";


    // // DONE
    // $scheduledTimeIn = '7:00:00 AM';
    // $scheduledTimeOut = '6:00:00 PM';
    // $dateNow = '2022/02/01';

    // $getHours = abs(strtotime($scheduledTimeIn) - strtotime($scheduledTimeOut)) / 3600; //Get Hours

    // $ConcatTimeDate = strtotime($scheduledTimeIn." ".$dateNow."+ ".$getHours." HOURS");

    // $TimeOutDate = date("Y/m/d", $ConcatTimeDate);

    // echo $TimeOutDate;

?>
