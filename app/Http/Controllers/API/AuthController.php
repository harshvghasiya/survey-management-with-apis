<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\tblusers;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function signin(Request $request)
    {
        $input=$request->validate([
            'username'=>'required|string',
            'password'=>'required|string'
        ]);

        $user=tblusers::where('username', $input['username'])->first();

        if(!$user || !Hash::check($input['password'],$user->password)){
            return $this->sendError('Unauthorised.','Wrong Credentials',401);
        }

        $token=$user->createToken('inclentoken')->plainTextToken;

        $success['token'] =  $token; 
        $success['name'] =  $user;
        return $this->sendResponse($success, 'User signed in');
    }

    public function logout(Request $request){
        
    }
   
}