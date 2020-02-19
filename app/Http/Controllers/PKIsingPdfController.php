<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PKIsingPdfController extends Controller
{
    public function PKIsign(Request $request)
    {

        // this code resposible for private key signature 
        // main technique: using CURL 
        // recieving token and PDF base64 , conect with server, pass value, get new document singed
        $document = $request->input('document');
        $token = $request->input('token');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "28445",
            CURLOPT_URL => "https://idm.iris.com.my:28445/resource-server/api/1/0001/pdf/sign",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\t\"id\":\"876543210123\", \n\t\t\"document\": \"$document\"\n\t\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Accept-Encoding: gzip, deflate, br",
                "Authorization: Bearer $token",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 34270",
                "Content-Type: application/json",
                "Cookie: JSESSIONID=B6F78698554929E0CA5FA83B0E62FA50",
                "Host: idm.iris.com.my:28445",
                "Postman-Token: 692b42f3-0ab3-4749-a281-ce6ca4a69b5f,edf769d0-dadd-40ab-ba29-f281fd6e92f9",
                "User-Agent: PostmanRuntime/7.22.0",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
