<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\UsersModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class UsersController extends Controller
{
    
    public function show(){

      $users = UsersModel::all();

      return response()->json($users);

    }

    public function UserLogIn(Request $request){
  

        ///// auth must be consider in this chunk !!!! search later 

        // $createUser = UsersModel::([
            
        //      'user_id' => $request->user_id,
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'Firebase_Token' => $request->Firebase_Token,
        // ]);
            
//         $validator = Validator::make($request->all(), 
//               [ 
//               'name' => 'required',
//               'email' => 'required|email',
//               'password' => 'required',  
//               'c_password' => 'required|same:password', 
//              ]);   
//  if ($validator->fails()) {          
//        return response()->json(['error'=>$validator->errors()], 401);       

 $user_id = $request->user_id;
 $first_name = $request->first_name;
 $last_name = $request->last_name;
 $Firebase_Token = $request->Firebase_Token;


$user = DB::table('users')->where('user_id', $user_id)->first();
            
            
            return response()->json([ $user ]);
    }



}
