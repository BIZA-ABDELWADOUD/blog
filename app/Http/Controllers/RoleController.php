<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
   
    public function index()
    {
        return Role::latest()->get();

    }

    public function store(RoleRequest $request)
    {
        return Role::create([
            'roleName' => $request->roleName
        ]);
    }


    public function update(RoleRequest $request)
    {
        return Role::where('id',$request->id)->update([
            'roleName' => $request->roleName
        ]);
    }


    public function destroy(Request $request)
    {
        return Role::where('id',$request->id)->delete();

    }

    public function assignroles(Request $request) {
        $this->validate($request,[
            'Permission' => 'required',
            'id' => 'required'
        ]);
        return Role::where('id',$request->id)->update([
            'Permission' => $request->Permission
        ]);
    }
}
