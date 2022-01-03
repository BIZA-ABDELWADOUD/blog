<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
   
    public function index()
    {
         return User::latest()->with('role')->where('role_id','<>', '4')->get();
    }

    public function store(UserRequest $request)
    {
        $user =  User::create([
            'FullName' => $request->FullName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id
        ]);
         $user->load('role');
         return $user;
    }

    public function update(UserRequest $request)
    {
        // array of informations
        $userdata = [
            'FullName' => $request->FullName,
            'email' => $request->email,
            'role_id' => $request->role_id
        ];
        if($request->password) {
            $password = bcrypt($request->password);
            $userdata['password'] = $password;
        }
        // user
        $user = User::where('id',$request->id);
        $isUserUpdated = $user->update($userdata);
         $updatedUser = $user->first();
          $updatedUser->load('role');
         return $updatedUser;
        // end new
    }

    public function destroy(Request $request)
    {
        return User::where('id',$request->id)->delete();

    }

    public function LoginMethod(LoginRequest $request) {
        if(Auth::attempt([
            'email' => $request->email,
            'password' =>$request->password
        ])) {
            $user = Auth::user();
            if($user->role->isAdmin == 0) {
                Auth::logout();
                return response()->json([
                    'msg' => "You don't have permissions to access"
                ],401);
            }
            return response()->json([
                'msg' => "sucess",
                'user' => $user
            ]);
        }
        else {
            return response()->json([
                'msg' => "Incorrect Login details"
            ],401);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
