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


class FileItemController extends Controller
{

    public function SendFile(Request $request)
    {

        $createFile = FileItemModel::create([

            'title' => $request->title,
            'file_owner' => $request->file_owner,
            'status_id' => $request->status_id,
            'sign_id' => $request->sign_id,
            'sign_sequence_id' => $request->sign_sequence_id,
            'file_url' => $request->file_url,

        ]);

        $lastInsertedId = $createFile->id;
        $data = array();
        foreach ($request->total_signer_user_id as $key => $total_signer_user_id) {


            $createFile = SignerInfoModel::create([
                'Item_id' => $lastInsertedId,
                'user_id' => $total_signer_user_id,
                'sequence' => $request->total_signer_sequence[$key]
            ]);



            $data[] = array('user_id' => $total_signer_user_id, 'sequence' => $request->total_signer_sequence[$key]);
        }

        ////// viwer infor to add users

        $lastInsertedId = $createFile->id;
        $data1 = array();

        foreach ($request->viwer_id as $key => $viwer_id) {


            $createFile = ViewerInfoModel::create([
                'Item_id' => $lastInsertedId,

                'user_id' => $request->viwer_id[$key]
            ]);



            $data1[] = array('Item_id' => $lastInsertedId, 'user_id' => $request->viwer_id[$key]);
        }


        $resposedata = array(

            'title' => $request->title,
            'file_owner' => $request->file_owner,
            'status_id' => $request->status_id,
            'sign_id' => $request->sign_id,
            'sign_sequence_id' => $request->sign_sequence_id,
            'singer' => $data,
            'viewer' => $data1,
            'file_url' => $request->file_url,
        );


        $response = ["status" => "200", "message" => "success", "data" => $resposedata];
        return response($response, 200, ["Content-Type" => "application/json"]);
    }

    public function inbox_by_status(Request $request)
    {

        $user_id = $request->input('user_id');
        $type = $request->input('type');


        $symbol = DB::table("item_status")->get('status_display');

        $result = 1;
        $symbol1 = DB::table("file_item")->where('status_id', '=', $result)->count();

        $result2 = 2;
        $symbol2 = DB::table("file_item")->where('status_id', '=', $result2)->count();

        $result3 = 3;
        $symbol3 = DB::table("file_item")->where('status_id', '=', $result3)->count();

        $result4 = 4;
        $symbol4 = DB::table("file_item")->where('status_id', '=', $result4)->count();


        $info = array(
            [
                'status display ' => 'Require Signature',
                'count' => $symbol1,
            ],
            [
                'status display ' => 'Deleted',
                'count' => $symbol2,
            ],
            [
                'status display ' => 'Declined',
                'count' => $symbol3,
            ],
            [
                'status display ' => 'Completed',
                'count' => $symbol4,
            ],


        );
        $response = ["data" => $info];
        return response(json_encode($response), 200, ["Content-Type" => "application/json"]);

        //   $response = ["status" => "200", "message" => "success","data"=>$symbol];
        //   return response(json_encode($response), 200, ["Content-Type" => "application/json"]);

    }


    public function inbox_list(Request $request)
    {


        $user_id = $request->input('user_id');
        $status_id = $request->input('status_id');


        $fileItem = DB::table('file_item')->get();


        // if($user_id){
        // $fileItem[$user_id]->completed_signer = +1 ;
        // $fileItem->save();
        // }
        // // $fileItem = FileItemModel::where('id' , '=', $id)->get();


        $resposedata = array(

            'item id ' => $fileItem[$user_id]->id,
            'message_array' => [
                'item_id' => $fileItem[$user_id]->id,
                'title' => $fileItem[$user_id]->title,
                'completion status' => $fileItem[$user_id]->completed_signer,
                'date_created' => $fileItem[$user_id]->created_date,

            ]

        );

        $response = ["status" => "200", "message" => "success", "data" => $resposedata];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }


    public function item_audit_trail(Request $request)
    {



        $user_id = $request->input('user_id');
        $id = $request->input('id');
        $fileItem = DB::table('file_item')->get();

        // $fileItem = FileItemModel::where('id' , '=', $id)->get();
        $fileMessage = DB::table('message_log')->get();

        $resposedata = array(

            'item id ' => $fileItem[$id]->id,
            'title' => $fileItem[$id]->title,
            'document_owner' => $fileItem[$id]->file_owner,
            'status' => $fileItem[$id]->status_id,
            'completion_status' => $fileItem[$id]->completed_signer,
            // 'file_url' =>$fileItem[$id]->file_url,
            'message_array' => [
                'message' => $fileMessage[$id]->message,
                'date'   => $fileMessage[$id]->created_date,
            ]

        );

        $response = ["status" => "200", "message" => "success", "data" => $resposedata];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }


    ///// function to Add users to file 
    public function add_viewer(Request $request)
    {

        $user_id = $request->input('user_id');
        $item_id = $request->input('item_id');

        $lastInsertedId = $request->input('item_id');

        $data1 = array();

        foreach ($request->viwer_id as $key => $viwer_id) {

            $createFile = SignerInfoModel::create([
                'Item_id' => $lastInsertedId,
                'user_id' => $request->viwer_id[$key]
            ]);
            $data1[] = array('user_id' => $request->viwer_id[$key]);
        }

        $resposedata = array(
            'viewer' => $data1,

        );

        $addMessage = MessageLogModel::create([

            'user_id' => $request->user_id,

            'message' => ' Viwer added ',
        ]);
        $response = ["status" => "200", "message" => "success", "data" => $resposedata];
        return response($response, 200, ["Content-Type" => "application/json"]);
    }


    public function reply_message(Request $request)
    {

        $file = MessageLogModel::create([

            'user_id' => $request->user_id,
            'Item_id' => $request->Item_id,
            'message' => $request->message,

        ]);

        $response = ["status" => "200", "message" => "success", "data" => $file];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }



    //    this function preform two action 
    //   first: update the sattus to number 3 which represend the declied
    //   sec: create message in message log by refering to user_id and Item_id
    public function decline_signature(Request $request)
    {

        $user_id = $request->input('user_id');
        $Item_id = $request->input('Item_id');
        $message = $request->input('message');


        $file = FileItemModel::where('id', '=', $Item_id)->first();

        $file->status_id = 3;

        $file->save();


        $addMessage = MessageLogModel::create([

            'user_id' => $request->user_id,
            'Item_id' => $request->Item_id,
            'message' => $request->message,
        ]);




        $response = ["status" => "200", "message" => "success"];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
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

                'message' => ' file locked ',
            ]);
        }

        $response = ["status" => "200", "message" => "success", 'data' => $file];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }

    public function login(Request $request)
    {


        $user_id = $request->input('user_id');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $Firebase_Token = $request->input('Firebase_Token');

        // if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
        //     $user = Auth::user(); 
        //     $success['token'] =  $user->createToken('AppName')-> accessToken; 
        //      return response()->json(['success' => $success], $this-> successStatus); 
        //    } else{ 
        //     return response()->json(['error'=>'Unauthorised'], 401); 
        //     } 


        $response = ["status" => "200", "message" => "success"];

        return response(json_encode($response), 200, ["Content-Type" => "application/json",]);
    }





    public function show()
    {

        $file =    FileItemModel::all();

        //  $file = FileItemModel::where('total_signer'  );

        return json_encode([$file]);
    }
}
