<?php
if (isset($_GET['id'])) {

    $scheduleID = $_GET['id'];
    $horaroAPIEndpoint = "https://horaro.org/-/api/v1/schedules/$scheduleID";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $horaroAPIEndpoint);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $marathonData = json_decode(curl_exec($ch), true);

    print(json_encode($marathonData));
}
