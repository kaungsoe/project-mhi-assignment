<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('KS')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return response()->json($success);
        } 
        else {
            return response()->json(["status"=>"Failed Successfully"]);
        }
        
    }
    public function register(Request $request){
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('KS')->plainTextToken;
        $success['name'] =  $user->name;
        $success['address']= $user->address;
        $success['email']= $user->email;
        $success['phone']=  $user->phone;
        $success['role'] = $user->role;
   
        return response()->json($success);
    }
    public function updateUserInfo(Request $request){
        $user=Auth::user();
        $user->address=$request->address;
        $user->save();
        return response()->json($user);
    }   

}
