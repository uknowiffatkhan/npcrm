<?php

function format_curr($num)
{
    if (is_numeric($num)) {
        $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $num);
    } else {
        $num = 0;
    }

    return $num;
}


function moneyToWords($value)
{
    $val = abs($value);
    if ($val >= 10000000) {
        $val = format_curr(round($val / 10000000, 2)) . ' Cr';
    } else if ($val >= 100000) {
        $val = format_curr(round($val / 100000, 2)) . ' Lac';
    } else if ($val >= 1000) {
        $val = format_curr(round($val / 1000, 2)) . ' K';
    }
    return $val;
}


function timeago($date)
{
    $timestamp = strtotime($date);

    $strTime = array("Sec", "Min", "Hr", "D", "M", "Y");
    $length = array("60", "60", "24", "30", "12", "10");

    $currentTime = time();
    if ($currentTime >= $timestamp) {
        $diff = time() - $timestamp;
        for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
            $diff = $diff / $length[$i];
        }

        $diff = round($diff);
        return $diff . " " . $strTime[$i] . " ";
    }
}


function getRangeDateString($timestamp)
{
    if ($timestamp) {
        $currentTime = strtotime('today');
        // Reset time to 00:00:00
        $timestamp = strtotime(date('Y-m-d 00:00:00', $timestamp));
        $days = round(($timestamp - $currentTime) / 86400);
        switch ($days) {
            case '0';
                return 'Today';
                break;
            case '-1';
                return 'Yesterday';
                break;
            case '-2';
                return 'Day before yesterday';
                break;
            case '1';
                return 'Tomorrow';
                break;
            case '2';
                return 'Day after tomorrow';
                break;
            default:
                if ($days > 0) {
                    return 'In ' . $days . ' days';
                } else {
                    return ($days * -1) . ' days ago';
                }
                break;
        }
    }
}

function searchJson($obj, $value)
{
    foreach ($obj as $key => $item) {
        if (!is_nan(intval($key)) && is_array($item)) {
            if (in_array($value, $item))
                return $item;
        } else {
            foreach ($item as $child) {
                if (isset($child) && $child == $value) {
                    return $child;
                }
            }
        }
    }
    return null;
}


function datediff($d)
{
    $now = time(); // or your date as well
    $your_date = strtotime($d);
    $datediff = $now - $your_date;

    return round($datediff / (60 * 60 * 24));
}


function sendWhatsapp($phone,$tid,$data)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sender.neralproperty.com/sendwhatsapp.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
    "phone":"'.$phone.'",
    "tid":"'.$tid.'",
    "data":"'.$data.'"
}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    )
    );

    $response = curl_exec($curl);

    curl_close($curl);
    
}

function sendSms($phone, $data, $tmpid)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sender.neralproperty.com/sendsms.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "phone":"'.$phone.'",
            "tid":"'.$tmpid.'",
            "data":"'.$data.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    )
    );

    $response = curl_exec($curl);

    curl_close($curl);
}

?>