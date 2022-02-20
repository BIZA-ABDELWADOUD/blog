<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        return $this->CheckForPermission($user, $request);
    }

    public function CheckForPermission($user, $request)
    {
        $Permission = json_decode($user->role->Permission);
        $hasPermission = false;
        foreach ($Permission as $p) {
            if ($p->name == $request->path()) {
                if ($p->read) {
                    $hasPermission = true;
                } else {
                    return view('notallowed');
                }
            }
        }
        if ($hasPermission) {
            return view('welcome');
        } 
            return view('welcome');
        
    }
}
