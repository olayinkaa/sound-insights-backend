<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);
   
        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors()); 
      
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['verified'] = User::UNVERIFIED_USER;
        $input['verification_token']= User::generateVerificationCode();
        $user = User::create($input);

        // $newUser = User::findOrFail($user->id);


        // if($newUser->status=="admin")
        // {
        //     $success['access_token'] =  $user->createToken('soundinsights',['*'])-> accessToken; 
        //     $success['name'] =  $user->name;
        //     $success['email']= $user->email;
        // }
        // else if($newUser->status==="editor")
        // {
        //     $success['access_token'] =  $user->createToken('soundinsights',[
        //         'create-mp3',
        //         'update-mp3',
        //         'create-aboutus',
        //         'update-aboutus'
        //     ])-> accessToken; 
        //     $success['name'] =  $user->name; 
        //     $success['email']= $user->email;
        // }
        // else
        // {
        //     $success['access_token'] =  $user->createToken('soundinsights')-> accessToken; 
        //     $success['name'] =  $user->name; 
        //     $success['email']= $user->email;
        //     $success['token_type']= "Bearer";

        // }

        return $this->sendResponse($user, "Successful Registration.Email sent to {$user->email} for verification");
    }


    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 

            if($user->verified=="0")
            {
                return $this->errorResponse("Please verified your account to continue",401);
            }

            if($user->status==="admin")
            {
                $success['access_token'] =  $user->createToken('soundinsights',[
                    'create-mp3' => 'Create new mp3 record',
                    'update-mp3' => 'Edit existing mp3 record',
                    'delete-mp3' => 'remove existing mp3 record',
                    'create-aboutus'=>'Create new about us content',
                    'update-aboutus'=>'Edit exsiting about us content',
                    'delete-aboutus'=>'Delete existing about us content'
                ])-> accessToken; 
                $success['name'] =  $user->name;
                $success['email'] =  $user->email;
            }
            else if($user->status==="editor")
            {
                $success['access_token'] =  $user->createToken('soundinsights',[
                'create-mp3',
                'update-mp3',
                'create-aboutus',
                'update-aboutus'
                ])-> accessToken; 
                $success['name'] =  $user->name; 
                $success['email'] =  $user->email; 
            }
            else
            {
                $success['access_token'] =  $user->createToken('soundinsights')-> accessToken; 
                $success['name'] =  $user->name; 
                $success['email'] =  $user->email; 
            }
            $success['token_type']= "Bearer";

            return $this->sendResponse($success, 'User login successfully.');
          
   
        } 
        else
        { 
            return $this->sendError('Unauthorised.', ['error'=>'Invalid email or password']);
        } 
    }



    //
}
