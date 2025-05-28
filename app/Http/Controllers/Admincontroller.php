<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Log as ModelsLog;

class Admincontroller extends Controller
{
    public function logout(){
        try{
            //remove all session.
                $log = new ModelsLog();
                $log->note = "You have logged out";
                $log->action = "logout";
                $log->status = "successful";
                $log->save();
            session()->flush();
            return redirect()->route('login');
        }
        catch(\Exception $er){
            return response()->json(['message'=>$er->getMessage()]);
        }
    }

    public function return_info(){
        try{
            $user = User::where('id',1)->first();

            if(!$user) {
                return response()->json(['message'=>'Please add admin account in phpmyadmin']);
            }

            return response()->json(['message'=>$user]);
        }
        catch(\Exception $er){
            return response()->json(['message'=>$er->getMessage()]);
        }
    }

    public function update_info(Request $request){

        try{
                $log = new ModelsLog();
                $log->note = "You have updated your account info";
                $log->action = "update account";
                $log->status = "successful";
                $log->save();
            $data = json_decode($request->form);
            $user = User::where('id',1)->first();

            if(!$user){
                return response()->json(['message'=>'Please add admin account in phpmyadmin. The id should be 1.']);
            }

            $user->name = $data->name;
            $user->email = $data->email;
            $user->password = $request->pass_confirm;

            if($user->save()){
                return response()->json(['message'=>'success']);
            }
        }
        catch(\Exception $er){
            return response()->json(['message'=>$er->getMessage()]);
        }
    }
}
