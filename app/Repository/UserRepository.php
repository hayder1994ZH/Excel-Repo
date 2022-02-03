<?php
namespace App\Repository;

use JWTAuth;
use App\Models\User;
use App\Models\Roles;
use App\Models\Import;
use App\Repository\BRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

//                        <----------- Welcome To UserRepository Page ----------->

class UserRepository extends BRepository {

     
    // Repo to Get all employee wireless
    public function getListUsers($skip, $take)
    {
        $result = Import::orderBy("id", "desc");
        $totalCount = Import::get();

        $resp = [
            'items' => $result->skip($skip)->take($take)->get(),
            'totalCount' => $totalCount->get()->count()
        ];

        return $response = array('message' => $resp,'code' => 200);

    }

    //Repo for Login 
    public function authenticate($request)
     {
        $user = User::where('username', $request['username'])->firstOrFail();

        if (!Hash::check($request['password'], $user->password)) {//check password
            return $response = ['message' => 'The password is invalid','code' => 401];
        }
        
        try {
            JWTAuth::factory()->setTTL(60*16*360);
             if (! $token = JWTAuth::fromUser($user)) {
                 return $response = ['message' =>  'invalid_credentials', 'code' => 401];
                }
            } catch (JWTException $e) {
                return $response = ['message' => 'could_not_create_token', 'code' => 400];
        }
        
        return  $response = ['message' => ['token' => $token, 'userData' => $user],'code' => 200];
    }

    //Repo for registration 
    public function registerUser($request)
    {
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request);
        return  $response = ['message' => 'Registration successfully','userData' => $user,'code' => 200];
    }

    //Repo for Logout user
    public function logoutUser()
    {
        auth()->logout();
        return  $response = ['message' => 'Successfully logged out','code' => 200];
    }

    //Repo for user details
    public function me()
    {
       $id = auth()->user()->id;
       $user = User::where('id', $id)->with('roles')->get();
       return  $response = ['message' =>  $user,'code' => 200];
    }
    
}

//                        <----------- Thank You For Read The Code ----------->
