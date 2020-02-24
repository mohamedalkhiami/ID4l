<?php

namespace App\Http\Controllers;

use App\FileItemModel;
use App\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PKIsingPdfController extends Controller
{
    public function PKIsign(Request $request)
    {
        //// get the file from file item table after retriving the file URL and get the file from storage then converted
        // this code resposible for private key signature 
        // main technique: using CURL 
        // recieving token and PDF base64 , conect with server, pass value, get new document singed

        $user_id = $request->input('user_id');
        $item_id = $request->input('item_id');
        $token = $request->input('token');

        $user_id = UsersModel::where('user_id', $request->user_id)->exists();

        $item_id = FileItemModel::where('id', $request->item_id)->exists();

        if ($item_id != null and $user_id != 0) {


            $fileToSign = FileItemModel::where('id', '=', $request->item_id)->get('file_url');

            $fileBaseName = basename($fileToSign[0]->file_url);

            $path1 = '/var/www/html/storage/app/public/' . $fileBaseName;

            $path = File::get($path1);


            $base64 = base64_encode($path);


            $curl = curl_init();

            curl_setopt_array($curl, array(

                CURLOPT_PORT => "28445",
                CURLOPT_URL => "https://idm.iris.com.my:28445/resource-server/api/1/0001/pdf/sign",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\t\t\"id\":\"876543210123\", \n\t\t\"document\": \"$base64\"\n\t\n}",
                CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Accept-Encoding: gzip, deflate, br",
                    "Authorization: Bearer $token",
                    "Cache-Control: no-cache",
                    "Connection: keep-alive",
                    "Content-Length: 104270",
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

                ////// replace the file //// done 

                $var = json_decode($response, true);

                $signedDocument = $var['signedDocument'];

                $DecodeSignedDocument = base64_decode($signedDocument);


                if (File::exists($path1)) {

                    var_dump(File::delete($path1));

                    var_dump($open = Storage::disk('public')->put($fileBaseName, $DecodeSignedDocument));
                } else if (!File::exists($path1)) {

                    echo "file not exisit";
                }
            }
        } else {

            $response = ["status" => "200", "message" => "faild check UserID or ItemID"];

            return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
        }
    }
}
