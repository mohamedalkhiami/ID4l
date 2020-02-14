<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendNotification extends Controller
{
    function sendNotification($devicetoken, $mesg, $title, $api_key)
    {

        $registrationIds = $devicetoken;
        #prep the bundle
        $msg = array(

            //////action and logic placed in this place

            "body" => $mesg,
            "title" => $title,
            "sound" => "mySound",

        );
        $fields = array(
            'to' => $registrationIds,
            'notification' => $msg,
            'priority' => 'high',
        );
        $headers = array(
            'Authorization: key=' . $api_key,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        $cur_message = json_decode($result);
        if ($cur_message->success == 1)
            return $result;
        else
            return $result;
    }
}
