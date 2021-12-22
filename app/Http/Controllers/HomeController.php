<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        return $this->CheckForPermission($user,$request);
         
        
    }

    public function CheckForPermission($user,$request) {
        // return $request->path();
          $Permission = json_decode($user->role->Permission);
          $hasPermission = false;
         if(!$Permission) {
            return view('welcome');
         }
         foreach($Permission as $p) {
            if($p->name==$request->path()) {
                if($p->read) {
                    $hasPermission = true;
                }   
            }
         }
         if($hasPermission) return view('welcome');
          return 'not found'; 

    }
}
