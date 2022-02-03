<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use App\Models\Import;
use App\Helpers\Utilities;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Repository\ImportRepository;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{   
    
     private $UserRepository;
     public function __construct()
     {
        $this->UserRepository = new UserRepository(new User());
     }

     //All users data
     public function getList(Request $request)
     {
      set_time_limit(4000);
       
        //parameters
        $take = $request->take;
        $skip = $request->skip * $take;
        $name = $request->name;
        $middle = $request->middle;
        //Processing
        $result = Import::where('facebook_url', 'like', '%'.$name.'%');

        $resp = [
            'items' => $result->take(10)->get(),
        ];

        //Response
        return $resp;
     }
    
     
    // //Get user By Id
    // public function getById($id)
    // {
    //     //Processing
    //     $response = $this->UserRepository->getById($id);

    //     //Response
    //     return Utilities::wrap(['message' => $response['message']], $response['code']);
    // } 

     //registeration
     public function register(Request $request)
     {
        
         //validations
        $request->validate([
            'full_name' => 'required|string|max:255|unique:users',
            'username' => 'required|string|unique:users,username',
            'phone' => 'required',
            'password' => 'required|string|min:6',
        ]);

        //Processing
        $response = $this->UserRepository->registerUser($request->all());

        //Response
        return 'Register successfully';
     }

     //login
     public function login(Request $request)
     {
         //validations
        $valiation = $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        //Processing
        $response = $this->UserRepository->authenticate($valiation);

        //Response
        return Utilities::wrap(['message' => $response['message']],200);
     }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Hardik',
                'email' => 'hardik@gmail.com'
            ],
            [
                'id' => 2,
                'name' => 'Vimal',
                'email' => 'vimal@gmail.com'
            ],
            [
                'id' => 3,
                'name' => 'Harshad',
                'email' => 'harshad@gmail.com'
            ]
        ];
          
        return Excel::download(new UsersExport($users), 'users.xlsx');
    }
     
     //logout user
     public function logout()
     {
        //Processing
        $response = $this->UserRepository->logoutUser();

        //Response
        return Utilities::wrap(['message' => $response['message']],$response['code']);
     }

    //  //details user information
    //  public function details()
    //  {
    //     //Processing
    //     $response = $this->UserRepository->me();

    //     //Response
    //     return Utilities::wrap(['message' => $response['message']],$response['code']);
    //  }    
         
    //  //update user
    //  public function updateUser(Request $request, $id)
    //  {
    //      //validations
    //     $data = $request->validate([
    //         'full_name' => 'string',
    //         'username' => 'string',
    //         'phone' => 'string',
    //         'password' => 'string|min:6',
    //         'img' => 'file'
    //     ]);
        
    //    if(array_key_exists("password", $request->all())){
    //     $data['password'] = Hash::make($data['password']);
    //     }
    //     if(array_key_exists("type", $request->all())){//check type
    //         $type = array('marketing', 'support', 'Accounts', 'managment', 'wireless');
    //         if(!in_array($data['type'],$type)){
    //             return Utilities::wrap(['message' => 'The type is invalid'], 400);
    //         }
    //     }
    //     if($request->hasFile('img')){//check file
    //         $fileName = $request->file('img');
    //         $new_name = $fileName->store('uploads');
    //         $data['img'] = $new_name;
    //     }

    //     //Processing
    //     $response = $this->UserRepository->update($id, $data);

    //     //Response
    //     return Utilities::wrap(['message' => $response['message']],$response['code']);
    //  }    
         
    //  //update user
    //  public function updateProfile(Request $request)
    //  {
    //      //validations
    //     $data = $request->validate([
    //         'full_name' => 'string',
    //         'username' => 'string',
    //         'phone' => 'string',
    //         'password' => 'string|min:6',
    //         'img' => 'file'
    //     ]);
        
    //    if(array_key_exists("password", $request->all())){
    //     $data['password'] = Hash::make($data['password']);
    //     }
    //     if(array_key_exists("type", $request->all())){//check type
    //         $type = array('marketing', 'support', 'Accounts', 'managment', 'wireless');
    //         if(!in_array($data['type'],$type)){
    //             return Utilities::wrap(['message' => 'The type is invalid'], 400);
    //         }
    //     }
    //     if($request->hasFile('img')){//check file
    //         $fileName = $request->file('img');
    //         $new_name = $fileName->store('uploads');
    //         $data['img'] = $new_name;
    //     }
    //     $id = auth()->user()->id;

    //      //Processing
    //     $response = $this->UserRepository->update($id, $data);

    //     //Response
    //     return Utilities::wrap(['message' => $response['message']],$response['code']);
    //  }

    // //Delete user with his details
    // public function delete($id)
    // {
    //     //Find user
    //     $model = User::where('id', $id)->where('is_deleted', 0)->first();
    //     if(!$model){
    //     return Utilities::wrap(['message' => 'This deleted user'], 400);
    //     }

    //     //Processing
    //     $response = $this->UserRepository->softDelete($model);

    //     //Response
    //     return Utilities::wrap(['message' => $response['message']], $response['code']);
    // } 
}
