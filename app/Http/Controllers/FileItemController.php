<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileItemModel;
use App\ItemStatusModel;
use App\MessageLogModel;
use App\SignerInfoModel;
use App\UsersModel;
use App\ViewerInfoModel;
use Dotenv\Regex\Result;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class FileItemController extends Controller
{



    public function SendFile(Request $request)
    {


        $filePath = $request->file('file_url')->store('public');

        $insert =  Storage::put('public', $request->file('file_url'));

        $url = Storage::url($insert);

        $path = basename($filePath);

        $createFile = FileItemModel::create([

            'title' => $request->title,
            'file_owner' => $request->file_owner,
            'status_id' => $request->status_id,
            'sign_id' => $request->sign_id,
            'sign_sequence_id' => $request->sign_sequence_id,
            'file_url' => asset('/storage/' . $path),

        ]);

        $lastInsertedId = $createFile->id;

        $singers = $request->input('singer');

        // loop through all singer
        foreach ($singers as $singer) {


            $singer['user_id'];
            $singer['sequence'];

            $createFile = SignerInfoModel::create([
                'Item_id' => $lastInsertedId,
                'user_id' =>   $singer['user_id'],
                'sequence' =>  $singer['sequence'],
            ]);
        }




        $viewers = $request->input('viewer');

        // loop through all viwer
        foreach ($viewers as $viewer) {

            $viewer['user_id'];
            $createFile = ViewerInfoModel::create([
                'Item_id' => $lastInsertedId,
                'user_id' =>   $viewer['user_id']

            ]);
        }




        $resposedata = array(

            'title' => $request->title,
            'file_owner' => $request->file_owner,
            'status_id' => $request->status_id,
            'sign_id' => $request->sign_id,
            'sign_sequence_id' => $request->sign_sequence_id,
            'singer' => $singers,
            'viewer' => $viewers,
            'file_url' => asset('/storage/' . $path),
        );




        $response = ["status" => "200", "message" => "success", "data" => $resposedata];
        return response($response, 200, ["Content-Type" => "application/json"]);
    }


    public function inbox_by_status(Request $request)
    {

        $user_id = $request->input('user_id');
        $type = $request->input('type');

        $userCheck = DB::table('users')->where('user_id', '=', $user_id)->get('user_id');

        // $symbol = DB::table("item_status")->get('status_display')->where($user_id, '=', 'user_id');

        $users = UsersModel::where('user_id', $user_id)->get();



        $result = 1;

        $symbol1 = DB::table("file_item")->where('status_id', '=', $result)->count();

        $result2 = 2;
        $symbol2 = DB::table("file_item")->where('status_id', '=', $result2)->count();

        $result3 = 3;
        $symbol3 = DB::table("file_item")->where('status_id', '=', $result3)->count();


        $result4 = 4;
        $symbol4 = DB::table("file_item")->where('status_id', '=', $result4)->count();

        $result5 = 5;
        $symbol5 = DB::table("file_item")->where('status_id', '=', $result5)->count();






        $info = array(
            [
                'status display ' => DB::table('item_status')->where('status_id', '=', $result)->first('status_display'),
                'count' => $symbol1,
            ],
            [
                'status display ' => DB::table('item_status')->where('status_id', '=', $result2)->first('status_display'),
                'count' => $symbol2,
            ],
            [
                'status display ' => DB::table('item_status')->where('status_id', '=', $result3)->first('status_display'),
                'count' => $symbol3,
            ],
            [
                'status display ' => DB::table('item_status')->where('status_id', '=', $result4)->first('status_display'),
                'count' => $symbol4,
            ],
            [
                'status display ' => DB::table('item_status')->where('status_id', '=', $result5)->first('status_display'),
                'count' => $symbol5,
            ]


        );

        if (UsersModel::where('user_id', $request->user_id)->exists()) {
            $response = ["data" => $info];
            return response(json_encode($response), 200, ["Content-Type" => "application/json"]);
        } else {
            $response = ["message" => "user not exist "];
            return response(json_encode($response), 200);
        }
    }




    public function inbox_list(Request $request)
    {


        $user_id = $request->input('user_id');


        $user = DB::table('users')->where('user_id', '=', $user_id);
        $status_id = $request->input('status_id');


        $fileItem = DB::table('file_item')->get();




        $resposedata = array(

            'item id ' => $fileItem[$user_id]->id,
            'message_array' => [
                'item_id' => $fileItem[$user_id]->id,
                'title' => $fileItem[$user_id]->title,
                'completion status' => $fileItem[$user_id]->completed_signer,
                'date_created' => $fileItem[$user_id]->created_date,

            ]

        );

        $response = ["status" => "200", "message" => "success", "data" => [$resposedata]];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }


    public function item_audit_trail(Request $request)
    {


        $user_id = $request->input('user_id');
        $id = $request->input('id');
        $fileItem = DB::table('file_item')->get();

        // $fileItem = FileItemModel::where('id' , '=', $id)->get();

        // $fileMessage = DB::table('message_log')->get();

        $resposedata = array(

            'item id ' => $fileItem[$id]->id,
            'title' => $fileItem[$id]->title,
            'document_owner' => $fileItem[$id]->file_owner,
            'status' => $fileItem[$id]->status_id,
            'completion_status' => $fileItem[$id]->completed_signer,
            'file_url' => $fileItem[$id]->file_url,
            // 'message_array' => [
            //     'message' => $fileMessage[$id]->message,
            //     'date'   => $fileMessage[$id]->created_date,
            // ]

        );

        $response = ["status" => "200", "message" => "success", "data" => $resposedata];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }


    ///// function to Add users to file 
    public function add_viewer(Request $request)
    {

        if (UsersModel::where('user_id', $request->user_id)->exists()) {
            $user_id = $request->input('user_id');
            $item_id = $request->input('item_id');

            // $lastInsertedId = $request->input('item_id');

            $viewers = $request->input('viewer');

            // loop through all viwer
            foreach ($viewers as $viewer) {

                $viewer['user_id'];

                $createFile = ViewerInfoModel::create([
                    'Item_id' => $item_id,
                    'user_id' => $viewer['user_id']

                ]);

                $addMessage = MessageLogModel::create([

                    'Item_id' => $item_id,
                    'user_id' => $viewer['user_id'],
                    'message' => ' Viwer added ',
                ]);
            }


            $response = ["status" => "200", "message" => "success", "data" => $createFile];
            return response($response, 200, ["Content-Type" => "application/json"]);
        } else {
            $response = ["message" => "user not exist "];
            return response(json_encode($response), 200);
        }
    }


    public function reply_message(Request $request)
    {
        $user_id = $request->input('user_id');
        $id = $request->input('id');
        $message = $request->input('message');

        if (UsersModel::where('user_id', $request->user_id)->exists()) {

            if (FileItemModel::where('id', $request->id)->exists()) {

                $file = MessageLogModel::create([

                    'user_id' => $request->user_id,
                    'Item_id' => $request->id,
                    'message' => $request->message,

                ]);

                $response = ["status" => "200", "message" => "success", "data" => $file];

                return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
            } else {
                $response = ["status" => "200", "message" => " file not found"];

                return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
            }
        } else {
            $response = ["status" => "200", "message" => " user Not found"];

            return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
        }
    }


    //    this function preform two action 
    //   first: update the sattus to number 3 which represend the declied
    //   sec: create message in message log by refering to user_id and Item_id
    public function decline_signature(Request $request)
    {

        $user_id = $request->input('user_id');
        $id = $request->input('id');
        $message = $request->input('message');

        if (UsersModel::where('user_id', $request->user_id)->exists()) {

            if (FileItemModel::where('id', '=', $request->id)->exists()) {

                $file = FileItemModel::where('id', '=', $id)->first();

                $file->status_id = 2;

                $file->save();

                $addMessage = MessageLogModel::create([

                    'user_id' => $request->user_id,
                    'Item_id' => $request->id,
                    'message' => $request->message,
                ]);

                $response = ["status" => "200", "message" => "sucess"];
                return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
            } else {
                $response = ["status" => "200", "message" => "file not found"];
                return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
            }
        } else {
            $response = ["status" => "200", "message" => "user not found "];
            return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
        }
    }


    //// delete function delete all the records match with file item_id 

    //// when delted should remove every this including other forgin key and value related 
    // / when delted should store empty file item in message log ????
    public function delete_file(Request $request)
    {

        $user_id = $request->input('user_id');
        $Item_id = $request->input('Item_id');


        // $deleteFile = DB::table('file_item')->where('id', '=', $item_id)->delete();


        $addMessage = MessageLogModel::create([

            'user_id' => $request->user_id,

            'message' => 'file deleted '
        ]);

        $response = ["status" => "200", "message" => "success", "data" => $addMessage];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }


    ///// pki  for now onely will be like this 
    //// public key infrastruture 
    //// send item id will check for user and file belong, automaticly move to next user to sign 
    //// store message log for this process 

    public function pki_sign_file(Request $request)
    {



        $Item_id = $request->input('Item_id');
        $user_id = $request->input('user_id');
        $key = $request->input('my_secret_key');

        $signer = SignerInfoModel::where('Item_id', '=', $Item_id)->first();

        $signer->singed = true;

        $signer->save();

        $signer->user_id =  $signer->user_id + 1;

        $signer->save();

        $addMessage = MessageLogModel::create([

            'user_id' => $request->user_id,

            'message' => ' signed by  ',
        ]);

        $response = ["status" => "200", "message" => "success", 'data' => $signer];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }


    public function e_sign_file(Request $request)
    {
        $Item_id = $request->input('Item_id');
        $user_id = $request->input('user_id');
        $unique_code = $request->input('unique_code');
        $file_url = $request->input('file_url');

        $signer = SignerInfoModel::where('Item_id', '=', $Item_id)->first();

        $signer->singed = true;

        $signer->save();

        $signer->user_id =  $signer->user_id + 1;

        $signer->save();

        MessageLogModel::create([

            'user_id' => $request->user_id,

            'message' => ' e_sign_file by   ',
        ]);

        $response = ["status" => "200", "message" => "success", 'data' => $signer];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }

    public function lock_file(Request $request)
    {
        $user_id = $request->input('user_id');
        $Item_id = $request->input('Item_id');


        // $file = FileItemModel::where('id', '=', $Item_id)->get('lock_status')->first();

        $file = FileItemModel::where('id', '=', $Item_id)->get(['id', 'lock_status'])->first();

        if ($file->lock_status == true) {

            echo 'locked failed ';
        } else {
            echo 'file is not locked';

            $file->lock_status = true;

            $file->lock_code = rand();

            $file->save();
            MessageLogModel::create([

                'user_id' => $request->user_id,
                'Item_id' => $request->Item_id,
                'message' => ' file locked ',
            ]);
        }

        $response = ["status" => "200", "message" => "success", 'data' => $file];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }

    public function login(Request $request)
    {


        // $user_id = $request->input('user_id');
        // $first_name = $request->input('first_name');
        // $last_name = $request->input('last_name');
        // $Firebase_Token = $request->input('Firebase_Token');

        $input = $request->all();

        // if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
        //     $user = Auth::user(); 
        //     $success['token'] =  $user->createToken('AppName')-> accessToken; 
        //      return response()->json(['success' => $success], $this-> successStatus); 
        //    } else{ 
        //     return response()->json(['error'=>'Unauthorised'], 401); 
        //     } 

        $data =  DB::table('users')->get('user_id');

        // $data = UsersModel::where($user_id, '=', 'user_id')->get(['user_id', 'first_name'])->first();
        $response = ["status" => "200", "message" => "success", 'data' => $data];

        return response(json_encode($response), 200, ["Content-Type" => "application/json"]);
    }





    public function show()
    {

        $file =    FileItemModel::all();

        //  $file = FileItemModel::where('total_signer'  );

        return json_encode([$file]);
    }
}
